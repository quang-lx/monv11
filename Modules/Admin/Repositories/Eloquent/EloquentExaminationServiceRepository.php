<?php

namespace Modules\Admin\Repositories\Eloquent;

use Carbon\Carbon;
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
                $query->whereHas('patient', function ($query) use ($keyword) {
                    $query->where(function ($q) use ($keyword) {
                        $q->orWhere('name', 'ilike', "%{$keyword}%")
                            ->orWhere('phone', 'ilike', "%{$keyword}%")
                            ->orWhere('address', 'ilike', "%{$keyword}%")
                            ->orWhere('papers', 'ilike', "%{$keyword}%")
                            ->orWhere('job', 'ilike', "%{$keyword}%")
                            ->orWhere('id', 'ilike', "%{$keyword}%");
                    });
                });
                $query->orWhereHas('testingService', function ($query) use ($keyword) {
                    $query->where(function ($q) use ($keyword) {
                        $q->orWhere('code', 'ilike', "%{$keyword}%");

                    });
                });
                $query->orWhereHas('examination', function ($query) use ($keyword) {
                    $query->where(function ($q) use ($keyword) {
                        $q->orWhere('id', 'ilike', "%{$keyword}%");

                    });
                });
            });

        }
        if ($request->get('sex') !== null) {
            $sex = $request->get('sex');
            $query->whereHas('patient', function ($query) use ($sex) {
                $query->where('sex', $sex);

            });
        }
        if ($request->get('status') !== null) {
            $status = $request->get('status');
            $query->where('status', $status);
        }
        if ($request->get('from_source') !== null) {
            $from_source = $request->get('from_source');
            $query->where('from_source', $from_source);
        }
        if ($request->get('created_by') !== null) {
            $created_by = $request->get('created_by');
            $query->where('created_by', $created_by);
        }
        if ($request->get('result_by') !== null) {
            $result_by = $request->get('result_by');
            $query->where('result_by', $result_by);
        }
        if ($request->get('service_type') !== null) {
            $service_type = $request->get('service_type');
            $query->whereHas('testingService', function ($query) use ($service_type) {
                $query->where('type', $service_type);
            });
        }

        if ($request->get('service_id') !== null) {
            $service_id = $request->get('service_id');
            $query->whereIn('service_id', $service_id);
        }


        $created_at = $request->get('created_at');

        if ($created_at !== null && count($created_at) > 0) {
            $created_at_start_date = Carbon::parse($created_at[0])->startOfDay();
            $created_at_end_date = Carbon::parse($created_at[1])->endOfDay();
            $query->whereBetween('created_at', [$created_at_start_date, $created_at_end_date]);
        }


        $result_at = $request->get('result_at');

        if ($result_at !== null && count($result_at) > 0) {
            $result_at_start_date = Carbon::parse($result_at[0])->startOfDay();
            $result_at_end_date = Carbon::parse($result_at[1])->endOfDay();
            $query->whereBetween('result_at', [$result_at_start_date, $result_at_end_date]);
        }

        $birthday = $request->get('birthday');


        if ($birthday !== null && count($birthday) > 0) {
            $birthday_start_date = Carbon::parse($birthday[0])->startOfDay();
            $birthday_end_date = Carbon::parse($birthday[1])->endOfDay();
            $query->whereHas('patient', function ($query) use ($birthday_start_date, $birthday_end_date) {
                $query->whereBetween('birthday', [$birthday_start_date, $birthday_end_date]);

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
