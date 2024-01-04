<?php

namespace Modules\Admin\Repositories;

use Illuminate\Http\Request;
use Modules\Mon\Entities\PatientExamination;

class DashboardRepository
{
    public function summaryKCB(Request $request) {
        list($from_date, $to_date) = $request->get('date_search');
        $query = PatientExamination::query()->whereBetween('created_at', [$from_date, $to_date]);
        $total = $query->count();
        $not_done = (clone $query)->where('status', '<>', PatientExamination::STATUS_DONE)->count();
        $not_done_percent = $total> 0 ? round(($not_done/$total * 100)): 0;
        $new_kcb =  (clone $query)->where('type',   PatientExamination::TYPE_NEW)->count();
        $new_percent = $total> 0 ? round(($new_kcb/$total * 100)): 0;

        $again_kcb = $total - $new_kcb;
        $again_percent = 100 - $again_kcb;

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

}
