<?php

namespace Modules\Admin\Repositories;

use Illuminate\Http\Request;
use Modules\Mon\Repositories\BaseRepository;

interface PatientRepository extends BaseRepository
{
    public function getPatientHasService(Request $request, $relations = null);
    public function changeStatus($request);
    public function reExamination($patient, $data);
}
