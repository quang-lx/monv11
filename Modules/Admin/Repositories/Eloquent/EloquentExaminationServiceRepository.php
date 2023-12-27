<?php

namespace Modules\Admin\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Modules\Admin\Repositories\ExaminationServiceRepository;
use Modules\Mon\Entities\ExaminationService;
use Modules\Mon\Repositories\Eloquent\BaseRepository;

class EloquentExaminationServiceRepository extends BaseRepository implements ExaminationServiceRepository
{
    public function cancel(ExaminationService $examinationservice)
    {
        if ($examinationservice->status != ExaminationService::STATUS_PROCESSING) {
            throw new \Exception('Trạng thái không hợp lệ');
        }
        $examinationservice->status = ExaminationService::STATUS_CANCEL;
        $examinationservice->save();
        return $examinationservice;
    }

    /**
     * @param $model ExaminationService
     */
    public function destroy($model)
    {
        try {
            DB::beginTransaction();
            $model->listIndex()->delete();
            $model->delete();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

    }

}
