<?php

namespace Modules\Admin\Repositories;

use Illuminate\Http\Request;
use Modules\Mon\Entities\Patient;
use Modules\Mon\Entities\PatientExamination;
use Modules\Mon\Repositories\BaseRepository;

interface PatientExaminationRepository extends BaseRepository
{
    public function startExamination(PatientExamination $model,Request $request);
    public function finishExamination(PatientExamination $model,Request $request);
}
