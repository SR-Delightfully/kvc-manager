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

    public function createProduct(array $data): void {
        $stmt = "INSERT INTO product(product_type_id, product_code, product_name) VALUES
        (:pType, :pCode, :pName)";
        $params = [':pType'=>$data['product_type_id'],':pCode'=>$data['product_code'],':pName'=>$data['product_name']];
        $this->execute($stmt, $params);
    }

    public function deleteProduct($productId){
        $stmt = "DELETE FROM product WHERE product_id = :id";
        $params = [':id'=>$productId];
        $this->execute($stmt,$params);
    }

    public function updateProduct($id, $data) {
        $stmt = "UPDATE product SET
                    product_type_id = :type,
                    product_code = :code,
                    product_name = :name
                    WHERE product_id = :id";

        $params = [':type'=>$data['product_type_id'],':code'=>$data['product_code'],':name'=>$data['product_name'],':id'=>$id];
        $this->execute($stmt,$params);
    }

    //* FOR_PRODUCT_TYPES

    public function getProductTypeById($id): ?array {
        $stmt = "SELECT * FROM product_type WHERE product_type_id = :id";
        $params = [':id'=>$id];
        $productTypes = $this->selectOne($stmt, $params);
        return $productTypes;
    }

    public function getAllProductTypes(): ?array {
        $stmt = "SELECT * FROM product_type";
        $productTypes = $this->selectAll($stmt);
        return $productTypes;
    }

    public function createProductType($data) {
        $stmt = "INSERT INTO product_type (product_type_name) VALUES
        (:pName)";
        $params = [':pName'=>$data['product_type_name']];
        $this->execute($stmt,$params);
    }

    public function deleteProductType($productId){
        $stmt = "DELETE FROM product_type WHERE product_type_id = :id";
        $params = ['id'=>$productId];
        $this->execute($stmt,$params);
    }

    public function updateProductType($id, $data) {
        $stmt = "UPDATE product_type SET
                    product_type_name = :name
                    WHERE product_type_id = :id";

        $params = [':name'=>$data['product_type_name'],':id'=>$id];
        $this->execute($stmt,$params);
    }
}
