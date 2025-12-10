<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;
use DateTime;
use Exception;

class PalletModel extends BaseModel
{
    public function __construct(PDOService $pDOService)
    {
        parent::__construct($pDOService);
    }

    public function getPalletCompleteById($id)
    {
        $stmt = "SELECT pallet.*, palletize_session.* FROM pallet LEFT JOIN palletize_session ON pallet.pallet_id =  palletize_session.pallet_id WHERE pallet.pallet_id = :id";
        $params = [':id' => $id];
        $pallet = $this->selectOne($stmt, $params);
        return $pallet;
    }

    public function getAllPalletsComplete(): ?array
    {
        $stmt = "SELECT pallet.*, palletize_session.* FROM pallet LEFT JOIN palletize_session ON pallet.pallet_id =  palletize_session.pallet_id";
        $pallets = $this->selectAll($stmt);
        return $pallets;
    }

    public function getAllPalletsClean() {
        $stmt = "SELECT p.pallet_id, v.variant_description AS variant_description, t.batch_number AS tote_id, s.station_name AS station_id, l.start_time, l.end_time, l.units, l.break_time, l.mess, l.notes FROM pallet p LEFT JOIN tote t ON p.tote_id = t.tote_id LEFT JOIN product_variant v ON v.variant_id = t.variant_id LEFT JOIN station s ON s.station_id = p.station_id LEFT JOIN palletize_session l ON l.pallet_id = p.pallet_id";
        $pallets = $this->selectAll($stmt);
        return $pallets;
    }

    public function getAllPalletsSimple(): ?array
    {
        $stmt = "SELECT * FROM pallet";
        $pallets = $this->selectAll($stmt);
        return $pallets;
    }

    public function getAll(): array
    {
        return $this->getAllPalletsComplete() ?? [];
    }

    public function getByUser(int $userId): array
    {
        $stmt = "SELECT pallet.*, palletize_session.*
                FROM pallet
                LEFT JOIN palletize_session ON pallet.pallet_id = palletize_session.pallet_id
                WHERE pallet.user_id = :user_id";
        return $this->selectAll($stmt, [':user_id' => $userId]) ?? [];
    }

    public function find(int $id): ?array
    {
        return $this->getPalletCompleteById($id) ?? null;
    }

    public function create(array $data): void
    {
        $stmt = "INSERT INTO pallet (user_id, name, created_at) VALUES (:user_id, :name, NOW())";
        $params = [
            ':user_id' => $data['user_id'],
            ':name' => $data['name'] ?? '',
        ];
        $this->execute($stmt, $params);
    }

    public function update(int $id, array $data): void
    {
        $stmt = "UPDATE pallet SET name = :name WHERE pallet_id = :id";
        $params = [
            ':id' => $id,
            ':name' => $data['name'] ?? '',
        ];
        $this->execute($stmt, $params);
    }

    public function updatePalletize(int $id, array $data): void
    {
        $stmt = "UPDATE palletize_session SET start_time = :start_time,
                                end_time = :end_time,
                                units = :units,
                                break_time = :break_time,
                                mess = :mess,
                                notes = :notes WHERE pallet_id = :id";
        $params = [
            ':id' => $id,
            ':start_time' => $data['start_time'],
            ':end_time' =>$data['end_time'],
            ':units' => $data['units'],
            ':break_time' => $data['break_time'],
            ':mess' => $data['mess'],
            ':notes' => $data['notes']
        ];
        $this->execute($stmt, $params);
    }

    public function delete(int $id): void
    {
        $stmt = "DELETE FROM pallet WHERE pallet_id = :id";
        $this->execute($stmt, [':id' => $id]);
    }

    public function getAllTotes(): ?array
    {
        $stmt = "SELECT * FROM tote";
        $tote = $this->selectAll($stmt);
        return $tote;
    }
}
