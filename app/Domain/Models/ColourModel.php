<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class ColourModel extends BaseModel
{
    public function __construct(PDOService $pDOService) {
        parent:: __construct($pDOService);
    }

    public function getAllColours(): ?array {
        return null;
    }

    public function createColour(array $data): void {

    }

    public function deleteColour(int $colourId){

    }
}
