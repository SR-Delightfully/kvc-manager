<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class ColourModel extends BaseModel
{
    public function __construct(PDOService $pDOService) {
        parent:: __construct($pDOService);
    }

    public function getColourById($id){
        $stmt = "SELECT * FROM colour where colour_id = :id";
        $params = [':id'=>$id];
        $colour = $this->selectOne($stmt,$params);
        return $colour;
    }

    public function getAllColours(): ?array {
        $stmt = "SELECT * FROM colour";
        $colours = $this->selectAll($stmt);
        return $colours;
    }

    public function createColour(array $data): void {
        $stmt = "INSERT INTO colour(product_category, product_code, product_name) VALUES
        (:pCat, :pCode, :pName)";
        $params = [':pCat'=>$data['product_category'],':pCode'=>$data['product_code'],':pName'=>$data['product_name']];
        $this->execute($stmt, $params);
    }

    public function deleteColour($colourId){
        $stmt = "DELETE FROM colour WHERE colour_id = :id";
        $params = ['id'=>$colourId];
        $this->execute($stmt,$params);
    }

    public function updateColour($id, $data) {
        $stmt = "UPDATE colour SET
                    colour_code = :code,
                    colour_name = :name
                    WHERE colour_id = :id";

        $params = [':code'=>$data['colour_code'],':name'=>$data['colour_name'],':id'=>$id];
        $this->execute($stmt,$params);
    }
}
