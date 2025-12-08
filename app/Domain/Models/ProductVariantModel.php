<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class ProductVariantModel extends BaseModel
{
    public function __construct(PDOService $pDOService) {
        parent:: __construct($pDOService);
    }

public function getVariantById($id): ?array {
        $stmt = "SELECT * FROM product_variant WHERE variant_id = :id";
        $params = [':id'=>$id];
        $variant = $this->selectOne($stmt,$params);
        return $variant;
    }
    public function getAllVariants(): ?array {
        $stmt = "SELECT * FROM product_variant";
        $variants = $this->selectAll($stmt);
        return $variants;
    }

    public function createVariant(array $data): void {
        $stmt = "INSERT INTO product_variant(product_id, colour_id, unit_size, variant_description) VALUES
        (:pId, :cId, :uSize, :vDesc)";
        $params = [':pId'=>$data['product_id'],':cId'=>$data['colour_id'],':uSize'=>$data['unit_size'], ':vDesc'=>$data['variant_description']];
        $this->execute($stmt, $params);
    }

    public function deleteVariant($id){
        $stmt = "DELETE FROM product_variant WHERE variant_id = :id";
        $params = ['id'=>$id];
        $this->execute($stmt,$params);
    }

    public function updateVariant($id, $data) {
        $stmt = "UPDATE product_variant SET
                    product_id = :pId,
                    colour_id = :cId,
                    unit_size = :uSize,
                    variant_description = :vDesc
                    WHERE variant_id = :id";

        $params = [':pId'=>$data['product_id'],':cId'=>$data['colour_id'],':uSize'=>$data['unit_size'],':vDesc'=>$data['variant_description'], ':id' => $id];
        $this->execute($stmt,$params);
    }

    public function search($searchTerm) {
        $stmt = "SELECT * FROM product_variant WHERE variant_description LIKE ?";
        $params = [];
        $like = '%' . $searchTerm . '%';
        $params[] = $like;
        $results = $this->selectAll($stmt, $params);
        return $results;
    }

    public function getAllVariantsClean() {
        $stmt = "SELECT v.variant_id, p.product_name AS product_id, c.colour_code AS colour_id, v.unit_size, v.variant_description FROM product_variant v LEFT JOIN product p ON p.product_id = v.product_id LEFT JOIN colour c ON c.colour_id = v.colour_id";
        $variants = $this->selectAll($stmt);
        return $variants;
    }

    public function getVariantCleanById($id) {
        $stmt = "SELECT v.variant_id, p.product_name AS product_name, p.product_id AS product_id, c.colour_id AS colour_id, c.colour_code AS colour_code, v.unit_size, v.variant_description FROM product_variant v LEFT JOIN product p ON p.product_id = v.product_id LEFT JOIN colour c ON c.colour_id = v.colour_id WHERE variant_id = :id";
        $params = [':id' => $id];
        $variants = $this->selectOne($stmt, $params);
        return $variants;
    }
}
