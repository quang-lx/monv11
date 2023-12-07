<?php

namespace Modules\Admin\Repositories;

use Illuminate\Http\Request;
use Modules\Mon\Entities\Patient;
use Modules\Mon\Repositories\BaseRepository;

interface PatientRepository extends BaseRepository
{
    public function getCurrentExaminationService(Patient $patient, Request $request, $relations = null);
    public function changeStatus($request);
    public function reExamination($patient, $data);
    public function addService(Patient $patient, Request $request);
    public function deleteService(Patient $patient, Request $request);
    public function cancelService(Patient $patient, Request $request);
}
