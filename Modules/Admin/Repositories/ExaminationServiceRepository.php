<?php

namespace Modules\Admin\Repositories;

use Modules\Mon\Entities\ExaminationService;
use Modules\Mon\Repositories\BaseRepository;

interface ExaminationServiceRepository extends BaseRepository
{
    public function cancel(ExaminationService $examinationservice);
}
