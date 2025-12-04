<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

class ToteModel extends BaseModel
{
    public function __construct(PDOService $pDOService) {
        parent:: __construct($pDOService);
    }
    public function getToteById($id): ?array {
        $stmt = "SELECT * FROM tote WHERE tote_id = :id";
        $params = [':id'=>$id];
        $tote = $this->selectOne($stmt,$params);
        return $tote;
    }
    public function getAllTotes(): ?array {
        $stmt = "SELECT * FROM tote";
        $totes = $this->selectAll($stmt);
        return $totes;
    }

    public function createTote(array $data): void {
        $stmt = "INSERT INTO tote(variant_id, batch_number) VALUES
        (:variant_id, :batch_number)";
        $params = [':variant_id'=>$data['variant_id'], ':batch_number'=>$data['batch_number']];
        $this->execute($stmt, $params);
    }

    public function deleteTote(int $id){
        $stmt = "DELETE FROM tote WHERE tote_id = :id";
        $params = ['id'=>$id];
        $this->execute($stmt,$params);
    }

    public function updateTote($id, $data) {
        $stmt = "UPDATE tote SET
                    variant_id = :variant_id,
                    batch_number = :batch_number
                    WHERE tote_id = :tote_id";

        $params = [':variant_id'=>$data['variant_id'], ':batch_number' =>$data['batch_number'], ':tote_id' => $id];
        $this->execute($stmt,$params);
    }
}
