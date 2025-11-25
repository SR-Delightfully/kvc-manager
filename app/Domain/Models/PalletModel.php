<?php

namespace App\Domain\Models;

use App\Helpers\Core\PDOService;

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

    public function delete(int $id): void
    {
        $stmt = "DELETE FROM pallet WHERE pallet_id = :id";
        $this->execute($stmt, [':id' => $id]);
    }
}
