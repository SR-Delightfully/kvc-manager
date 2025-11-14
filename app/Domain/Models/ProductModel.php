<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class ProductModel extends BaseModel
{
    public function __construct(PDOService $pDOService) {
        parent:: __construct($pDOService);
    }

    public function getProductById($id): ?array {
        $stmt = "SELECT * FROM product WHERE product_id = :id";
        $params = [':id'=>$id];
        $product = $this->selectOne($stmt,$params);
        return $product;
    }
    public function getAllProducts(): ?array {
        $stmt = "SELECT * FROM product";
        $products = $this->selectAll($stmt);
        return $products;
    }

    public function getAllProductTypes() {
        $stmt = "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'product' AND COLUMN_NAME = 'product_category'";
        $productTypes = $this->selectAll($stmt);
        //productTypes is an array holding 1 string "enum('sci', '100-base')" in a literal string
        //convert that string to array
        $enumString = $productTypes['COLUMN_TYPE'];
        $enumString = str_replace(["enum(", ")", "'"], "", $enumString);

        return explode(",", $enumString);
    }

    public function createProduct(array $data): void {
        $stmt = "INSERT INTO product(product_category, product_code, product_name) VALUES
        (:pCat, :pCode, :pName)";
        $params = [':pCat'=>$data['product_category'],':pCode'=>$data['product_code'],':pName'=>$data['product_name']];
        $this->execute($stmt, $params);
    }

    public function deleteProduct(int $productId){
        $stmt = "DELETE FROM product WHERE product_id = :id";
        $params = ['id'=>$productId];
        $this->execute($stmt,$params);
    }

    public function updateProduct($id, $data) {
        $stmt = "UPDATE product SET
                    product_category = :cat,
                    product_code = :code,
                    product_name = :name
                    WHERE product_id = :id";

        $params = [':cat'=>$data['product_category'],':code'=>$data['product_code'],':name'=>$data['product_name'],':id'=>$id];
        $this->execute($stmt,$params);
    }

    public function createProductType($data) {
        $stmt = "ALTER TABLE product MODIFY COLUMN product_category ENUM";
    }
}
