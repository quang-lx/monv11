<?php

namespace Modules\Admin\Repositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Mon\Entities\Patient;
use Modules\Mon\Entities\PatientExamination;

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
        $mane = Patient::where('sex', Patient::MALE)->count();
        $female = Patient::where('sex', Patient::FEMALE)->count();
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
}
