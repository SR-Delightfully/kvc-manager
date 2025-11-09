<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class ProductModel extends BaseModel
{
    public function __construct(PDOService $pDOService) {
        parent:: __construct($pDOService);
    }

    public function getAllProducts(): ?array {
        $stmt = "SELECT * FROM products";
        $products = $this->selectAll($stmt);
        return $products;
    }

    public function createProduct(array $data): void {
        $stmt = "INSERT INTO product(product_category, product_code, product_name) VALUES
        (:pCat, :pCode, :pName)";
        $params = [':pCat'=>$data['product_category'],':pCode'=>$data['product_code'],':pName'=>$data['product_name']];
        $this->execute($stmt, $params);
    }

    public function deleteProduct(int $productId){
        
    }

}
