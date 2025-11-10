<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class ProductVariantModel extends BaseModel
{
    public function __construct(PDOService $pDOService) {
        parent:: __construct($pDOService);
    }

    public function getAllVariants(): ?array {
        return null;
    }

    public function createVariant(array $data): void {

    }

    public function deleteVariant(int $variantId){

    }
}
