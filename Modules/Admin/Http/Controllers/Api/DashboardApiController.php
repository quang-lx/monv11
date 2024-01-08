<?php

namespace Modules\Admin\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Repositories\DashboardRepository;
use Modules\Admin\Transformers\ExaminationServiceFullTransformer;
use Modules\Admin\Transformers\ExaminationServiceListTransformer;
use Modules\Admin\Transformers\ExaminationServiceTransformer;
use Modules\Mon\Entities\ExaminationService;
use Modules\Admin\Http\Requests\ExaminationService\CreateExaminationServiceRequest;
use Modules\Admin\Http\Requests\ExaminationService\UpdateExaminationServiceRequest;
use Modules\Admin\Repositories\ExaminationServiceRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;

class DashboardApiController extends ApiController
{

    public $dashboard_repo;
    public function __construct(Authentication $auth, DashboardRepository $dashboard_repo)
    {
        parent::__construct($auth);

        $this->dashboard_repo = $dashboard_repo;
    }

    public function summaryKCB(Request $request) {
        return  $this->dashboard_repo->summaryKCB($request);
    }
    public function summaryPatient(Request $request) {
        return  $this->dashboard_repo->summaryPatient($request);
    }
}
