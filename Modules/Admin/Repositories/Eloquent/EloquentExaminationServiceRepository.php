<?php

namespace Modules\Admin\Repositories\Eloquent;

use Illuminate\Http\Request;
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

    public function serverPagingFor(Request $request, $relations = null)
    {
        $query = $this->newQueryBuilder();
        if ($relations) {
            $query = $query->with($relations);
        }
        if ($request->get('search') !== null) {
            $keyword = $request->get('search');
            $query->where(function ($query) use ($keyword) {
                $query->whereHas('patient', function ($query) use ($keyword){
                    $query->where(function ($q) use ($keyword) {
                        $q->orWhere('name', 'ilike', "%{$keyword}%")
                            ->orWhere('phone', 'ilike', "%{$keyword}%")
                            ->orWhere('address', 'ilike', "%{$keyword}%")
                            ->orWhere('papers', 'ilike', "%{$keyword}%")
                            ->orWhere('job', 'ilike', "%{$keyword}%");
                    });
                });
                $query->orWhereHas('testingService', function ($query) use ($keyword){
                    $query->where(function ($q) use ($keyword) {
                        $q->orWhere('code', 'ilike', "%{$keyword}%");
                        $q->orWhere('code_lis', 'ilike', "%{$keyword}%");
                        $q->orWhere('name', 'ilike', "%{$keyword}%");
                        $q->orWhere('type', 'ilike', "%{$keyword}%");
                    });
                });
            });

        }


        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';

            $query->orderBy($request->get('order_by'), $order);
        } else {
            $query->orderBy('updated_at', 'desc');
        }
        return $query->paginate($request->get('per_page', 10));
    }
}
