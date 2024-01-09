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
        $query = Patient::query()->whereBetween('created_at', [$from_date, $to_date]);

        $mane = (clone $query)->where('sex', Patient::MALE)->count();
        $female = (clone $query)->where('sex', Patient::FEMALE)->count();
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
        $query = Patient::query()->whereBetween('created_at', [$from_date, $to_date]);

        $total_0_to_6_age = (clone $query)->whereBetween('birthday', [Carbon::now()->subYears(6), Carbon::now()->subYears(0)])->count();
        $total_7_to_12_age = (clone $query)->whereBetween('birthday', [Carbon::now()->subYears(12), Carbon::now()->subYears(7)])->count();
        $total_13_to_18_age = (clone $query)->whereBetween('birthday', [Carbon::now()->subYears(18), Carbon::now()->subYears(13)])->count();
        $total_19_to_40_age = (clone $query)->whereBetween('birthday', [Carbon::now()->subYears(40), Carbon::now()->subYears(19)])->count();
        $total_41_to_60_age = (clone $query)->whereBetween('birthday', [Carbon::now()->subYears(60), Carbon::now()->subYears(41)])->count();
        $total_greater_than_60_age = (clone $query)->where('birthday', '<=', Carbon::now()->subYears(60))->count();

        return [
            'labels' => ['0-6', '7-12', '13-18', '19-40', '41-60', 'Trên 60'],
            'datasets' => [
                [
                    'backgroundColor' => ['#E17126', '#617882', '#119DB5', '#015E99', '#1790C9', '#FFC000'],
                    'data' => [$total_0_to_6_age, $total_7_to_12_age, $total_13_to_18_age, $total_19_to_40_age, $total_41_to_60_age, $total_greater_than_60_age],
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
        $labels = [];
        $data = [];
        $backgroundColor = [];

        $examination_service = $query->groupBy('service_id')->select('service_id', DB::raw('count(*) as total'))->get();
        foreach ($examination_service as $key => $service) {
            $labels[] = TestingService::find($service['service_id'])->code;
            $data[] = $service['total'];
            $backgroundColor[] = $this->rand_color();
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
        $labels = [];
        $data = [];
        $backgroundColor = [];

        $examination_service = $query->groupBy('service_id')->select('service_id', DB::raw('count(*) as total'))->get();
        foreach ($examination_service as $key => $service) {
            $labels[] = TestingService::find($service['service_id'])->serviceType->code;
            $data[] = $service['total'];
            $backgroundColor[] = $this->rand_color();
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

    public function rand_color() {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }


}
