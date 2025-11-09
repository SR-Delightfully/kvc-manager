<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class ScheduleModel extends BaseModel
{
    public function __construct(PDOService $pDOService) {
        parent:: __construct($pDOService);
    }
}
