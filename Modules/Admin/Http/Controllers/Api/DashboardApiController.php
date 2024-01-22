<?php

namespace Modules\Admin\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Admin\Repositories\DashboardRepository;
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

    public function summarySex(Request $request) {
        return  $this->dashboard_repo->summarySex($request);
    }

    public function summaryAge(Request $request) {
        return  $this->dashboard_repo->summaryAge($request);
    }

    public function summaryService(Request $request) {
        return  $this->dashboard_repo->summaryService($request);
    }

    public function summaryServiceType(Request $request) {
        return  $this->dashboard_repo->summaryServiceType($request);
    }

    public function barChartService(Request $request) {
        return  $this->dashboard_repo->barChartService($request);
    }

    public function barChartDisease(Request $request) {
        return  $this->dashboard_repo->barChartDisease($request);
    }

    public function lineChartNumberExamination(Request $request) {
        return  $this->dashboard_repo->lineChartNumberExamination($request);
    }
}
