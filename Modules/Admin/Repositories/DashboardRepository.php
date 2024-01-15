<?php

namespace Modules\Admin\Repositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Mon\Entities\ExaminationService;
use Modules\Mon\Entities\Patient;
use Modules\Mon\Entities\PatientExamination;
use Illuminate\Support\Facades\Log;
use Modules\Mon\Entities\TestingService;

class DashboardRepository
{
    public function summaryKCB(Request $request)
    {
        list($from_date, $to_date) = $request->get('date_search');
        $from_date = Carbon::createFromFormat('d/m/Y', $from_date);
        $to_date = Carbon::createFromFormat('d/m/Y', $to_date);
        $query = PatientExamination::query()->whereBetween('created_at', [$from_date, $to_date]);
        $total = $query->count();
        $not_done = (clone $query)->where('status', '<>', PatientExamination::STATUS_DONE)->count();
        $not_done_percent = $total > 0 ? round(($not_done / $total * 100)) : 0;
        $new_kcb = (clone $query)->where('type', PatientExamination::TYPE_NEW)->count();
        $new_percent = $total > 0 ? round(($new_kcb / $total * 100)) : 0;

        $again_kcb = $total - $new_kcb;
        $again_percent = 100 - $new_percent;

        return [
            'total' => $total,
            'not_done' => $not_done,
            'not_done_percent' => $not_done_percent,
            'new_kcb' => $new_kcb,
            'new_percent' => $new_percent,
            'again_kcb' => $again_kcb,
            'again_percent' => $again_percent,
        ];

    }

    public function summaryPatient(Request $request)
    {
        list($from_date, $to_date) = $request->get('date_search');
        $from_date = Carbon::createFromFormat('d/m/Y', $from_date);
        $to_date = Carbon::createFromFormat('d/m/Y', $to_date);
        $query = PatientExamination::query()->whereBetween('created_at', [$from_date, $to_date]);
        $total = (clone $query)->selectRaw('distinct patient_id')->count();
        $total_children = (clone $query)->whereHas('patient', function ($query) {
            $query->where('birthday', '>=', Carbon::now()->subYears(16));
        })->selectRaw('distinct patient_id')->count();
        $children_percent = $total > 0 ? round(($total_children / $total * 100)) : 0;
        $male_count = (clone $query)->whereHas('patient', function ($query) {
            $query->where('sex', '=', Patient::MALE);
        })->selectRaw('distinct patient_id')->count();
        $male_percent = $total > 0 ? round(($male_count / $total * 100)) : 0;

        $female_count = $total - $male_count;
        $female_percent = 100 - $male_percent;

        $total_old = (clone $query)->whereHas('patient', function ($query) {
            $query->where('birthday', '<=', Carbon::now()->subYears(60));
        })->selectRaw('distinct patient_id')->count();
        $old_percent = $total > 0 ? round(($total_old / $total * 100)) : 0;

        return [
            'total' => $total,
            'children' => $total_children,
            'children_percent' => $children_percent,
            'male' => $male_count,
            'male_percent' => $male_percent,
            'female' => $female_count,
            'female_percent' => $female_percent,
            'old' => $total_old,
            'old_percent' => $old_percent,
        ];

    }

    public function summarySex(Request $request)
    {
        list($from_date, $to_date) = $request->get('date_search');
        $from_date = Carbon::createFromFormat('d/m/Y', $from_date);
        $to_date = Carbon::createFromFormat('d/m/Y', $to_date);
        $query = PatientExamination::query()->whereBetween('created_at', [$from_date, $to_date]);

        $mane = (clone $query)->whereHas('patient', function ($query) {
            $query->where('sex', Patient::MALE);
        })->count();

        $female = (clone $query)->whereHas('patient', function ($query) {
            $query->where('sex', Patient::FEMALE);
        })->count();
        if (array_sum([$female, $mane]) == 0) {
            return null;
        }
        return [
            'labels' => ['Nữ', 'Nam'],
            'datasets' => [
                [
                    'backgroundColor' => ['#1790C9', '#119DB5'],
                    'data' => [$female, $mane],
                    'borderJoinStyle' => 'round',
                    'weight' => 250
                ]
            ]
        ];
    }

    public function summaryAge(Request $request)
    {
        list($from_date, $to_date) = $request->get('date_search');
        $from_date = Carbon::createFromFormat('d/m/Y', $from_date);
        $to_date = Carbon::createFromFormat('d/m/Y', $to_date);
        $query = PatientExamination::query()->whereBetween('created_at', [$from_date, $to_date]);

        $total_0_to_6_age = (clone $query)->whereHas('patient', function ($query) {
            $query->whereBetween('birthday', [Carbon::now()->subYears(6), Carbon::now()->subYears(0)]);
        })->selectRaw('distinct patient_id')->count();

        $total_7_to_12_age = (clone $query)->whereHas('patient', function ($query) {
            $query->whereBetween('birthday', [Carbon::now()->subYears(12), Carbon::now()->subYears(7)]);
        })->selectRaw('distinct patient_id')->count();

        $total_13_to_18_age = (clone $query)->whereHas('patient', function ($query) {
            $query->whereBetween('birthday', [Carbon::now()->subYears(18), Carbon::now()->subYears(13)]);
        })->selectRaw('distinct patient_id')->count();

        $total_19_to_40_age = (clone $query)->whereHas('patient', function ($query) {
            $query->whereBetween('birthday', [Carbon::now()->subYears(40), Carbon::now()->subYears(19)]);
        })->selectRaw('distinct patient_id')->count();

        $total_41_to_60_age = (clone $query)->whereHas('patient', function ($query) {
            $query->whereBetween('birthday', [Carbon::now()->subYears(60), Carbon::now()->subYears(41)]);
        })->selectRaw('distinct patient_id')->count();

        $total_greater_than_60_age = (clone $query)->whereHas('patient', function ($query) {
            $query->where('birthday', '<=', Carbon::now()->subYears(60));
        })->selectRaw('distinct patient_id')->count();

        $data = [$total_0_to_6_age, $total_7_to_12_age, $total_13_to_18_age, $total_19_to_40_age, $total_41_to_60_age, $total_greater_than_60_age];
        if (array_sum($data) == 0) {
            return null;
        }

        return [
            'labels' => ['0-6', '7-12', '13-18', '19-40', '41-60', 'Trên 60'],
            'datasets' => [
                [
                    'backgroundColor' => ['#E17126', '#617882', '#119DB5', '#015E99', '#1790C9', '#FFC000'],
                    'data' => $data,
                    'borderJoinStyle' => 'round',
                    'weight' => 250
                ]
            ]
        ];
    }

    public function summaryService(Request $request)
    {
        list($from_date, $to_date) = $request->get('date_search');
        $from_date = Carbon::createFromFormat('d/m/Y', $from_date);
        $to_date = Carbon::createFromFormat('d/m/Y', $to_date);
        $query = ExaminationService::query()->whereBetween('created_at', [$from_date, $to_date]);
        $query_remaining = ExaminationService::query()->whereBetween('created_at', [$from_date, $to_date]);
        $labels = [];
        $data = [];
        $backgroundColor = [];
        $service_id_top_3 = [];

        $examination_service = $query->groupBy('service_id')->select('service_id', DB::raw('count(*) as total'))->orderBy(DB::raw('count(*)'))->limit(3)->get();
        foreach ($examination_service as $key => $service) {
            $labels[] = TestingService::find($service['service_id'])->code;
            $data[] = $service['total'];
            $backgroundColor[] = $this->rand_color();
            $service_id_top_3[] = $service['service_id'];
        }

        $examination_service_remaining = $query_remaining->whereNotIn('id', $service_id_top_3)->select(DB::raw('count(*) as total'))->first();
        $labels[] = 'Còn lại';
        $data[] = $examination_service_remaining['total'];
        $backgroundColor[] = $this->rand_color();

        if (array_sum($data) == 0) {
            return null;
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'backgroundColor' => $backgroundColor,
                    'data' => $data,
                    'borderJoinStyle' => 'round',
                    'weight' => 250
                ]
            ]
        ];

    }

    public function summaryServiceType(Request $request)
    {
        list($from_date, $to_date) = $request->get('date_search');
        $from_date = Carbon::createFromFormat('d/m/Y', $from_date);
        $to_date = Carbon::createFromFormat('d/m/Y', $to_date);
        $query = ExaminationService::query()->whereBetween('created_at', [$from_date, $to_date]);
        $query_remaining = ExaminationService::query()->whereBetween('created_at', [$from_date, $to_date]);
        $labels = [];
        $data = [];
        $backgroundColor = [];
        $service_id_top_3 = [];

        $examination_service = $query->groupBy('service_id')->select('service_id', DB::raw('count(*) as total'))->orderBy(DB::raw('count(*)'))->limit(8)->get();
        foreach ($examination_service as $key => $service) {
            $labels[] = TestingService::find($service['service_id'])->serviceType->code;
            $data[] = $service['total'];
            $backgroundColor[] = $this->rand_color();
            $service_id_top_3[] = $service['service_id'];
        }

        $examination_service_remaining = $query_remaining->whereNotIn('id', $service_id_top_3)->select(DB::raw('count(*) as total'))->first();
        $labels[] = 'Còn lại';
        $data[] = $examination_service_remaining['total'];
        $backgroundColor[] = $this->rand_color();

        if (array_sum($data) == 0) {
            return null;
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'backgroundColor' => $backgroundColor,
                    'data' => $data,
                    'borderJoinStyle' => 'round',
                    'weight' => 250
                ]
            ]
        ];

    }

    public function barChartService(Request $request)
    {
        list($from_date, $to_date) = $request->get('date_search');
        $from_date = Carbon::createFromFormat('d/m/Y', $from_date);
        $to_date = Carbon::createFromFormat('d/m/Y', $to_date);
        $query = ExaminationService::query()->whereBetween('created_at', [$from_date, $to_date]);
        $labels = [];
        $data = [];

        $examination_service = $query->groupBy('service_id')->select('service_id', DB::raw('count(*) as total'))->orderBy(DB::raw('count(*)'))->limit(10)->get();
        foreach ($examination_service as $key => $service) {
            $labels[] = TestingService::find($service['service_id'])->code;
            $data[] = $service['total'];
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];

    }

    public function rand_color()
    {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }

    public function lineChartNumberExamination(Request $request)
    {
        list($from_date, $to_date) = $request->get('date_search');
        $from_date = Carbon::createFromFormat('d/m/Y', $from_date);
        $to_date = Carbon::createFromFormat('d/m/Y', $to_date);
        $date_range = [];
        $data_label = [];
        $currentDate = Carbon::parse($from_date);
        $datasets = [];

        while ($currentDate->lte(Carbon::parse($to_date))) {
            $date_range[] = $currentDate->format('d/m/Y');
            $data_label[] = $currentDate->format('d/m');
            $currentDate->addDay();
        }


        $query = $this->queryGePatientExaminationRangeTime($from_date, $to_date);

        $children = (clone $query)->whereHas('patient', function ($query) {
            $query->where('birthday', '>=', Carbon::now()->subYears(16));
        })->groupBy(DB::raw('DATE(created_at)'), 'patient_id')->get();
        $datasets[] = $this->mapDataRangeTime($date_range, $children, '#0381FE', 'Trẻ em');

        $male = (clone $query)->whereHas('patient', function ($query) {
            $query->where('sex', '=', Patient::MALE);
        })->groupBy(DB::raw('DATE(created_at)'), 'patient_id')->get();
        $datasets[] = $this->mapDataRangeTime($date_range, $male, '#FB8532', 'Phụ nữ');

        $old = (clone $query)->whereHas('patient', function ($query) {
            $query->where('birthday', '<=', Carbon::now()->subYears(60));
        })->groupBy(DB::raw('DATE(created_at)'), 'patient_id')->get();
        $datasets[] = $this->mapDataRangeTime($date_range, $old, '#52C41A', 'Người cao tuổi');

        $female = (clone $query)->whereHas('patient', function ($query) {
            $query->where('sex', '=', Patient::FEMALE);
        })->groupBy(DB::raw('DATE(created_at)'), 'patient_id')->get();
        $datasets[] = $this->mapDataRangeTime($date_range, $female, '#E8E8E8', 'Đàn ông');


        return [
            'labels' => $data_label,
            'datasets' => $datasets
        ];


    }


    public static function queryGePatientExaminationRangeTime($from_date, $to_date)
    {
        $query = PatientExamination::select(DB::raw('DATE(created_at) as created_at'), DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$from_date, $to_date]);
        return $query;
    }

    public function mapDataRangeTime($date_range, $list_data, $color, $label)
    {
        $result = [];
        foreach ($date_range as $date) {
            $result[$date] = 0; // Khởi tạo số đơn hàng bằng 0 cho mỗi ngày
        }

        foreach ($list_data as $data) {
            $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('d/m/Y');
            $result[$created_at] = $data->total;
        }

        return
            [
                'label' => $label,
                'borderColor' => $color,
                'backgroundColor' => $color,
                'data' => array_values($result),
                'fill' => false,
                'datalabels' => [
                    'display' => false,
                ],
                'pointHoverRadius' => 6
            ];
    }


}
