<?php
namespace models;

class TableModel extends Model {
    public function getTables() {
        return $this->findAll("SELECT * FROM tables ORDER BY number");
    }
    
    public function getTable($id) {
        return $this->findOne("SELECT * FROM tables WHERE id = ?", [$id]);
    }
    
    public function addTable($data) {
        $sql = "INSERT INTO tables (number, capacity, status) VALUES (?, ?, ?)";
        return $this->query($sql, [
            $data['number'],
            $data['capacity'],
            $data['status'] ?? 'free'
        ]);
    }
    
    public function updateTable($id, $data) {
        $sql = "UPDATE tables SET number = ?, capacity = ?, status = ? WHERE id = ?";
        return $this->query($sql, [
            $data['number'],
            $data['capacity'],
            $data['status'],
            $id
        ]);
    }
    
    public function updateStatus($id, $status) {
        $sql = "UPDATE tables SET status = ? WHERE id = ?";
        return $this->query($sql, [$status, $id]);
    }
    
    public function getAvailableTables() {
        return $this->findAll("SELECT * FROM tables WHERE status = 'free' ORDER BY number");
    }
    
    public function getTableWithCurrentOrder($tableId) {
        return $this->findOne(
            "SELECT t.*, o.id as order_id, o.status as order_status, o.total_amount
             FROM tables t
             LEFT JOIN orders o ON t.id = o.table_id AND o.status NOT IN ('completed', 'cancelled')
             WHERE t.id = ?",
            [$tableId]
        );
    }
    
    public function reserveTable($id, $status = 'reserved') {
        if (!in_array($status, ['reserved', 'occupied'])) {
            throw new \Exception('Nieprawidłowy status stolika.');
        }
        return $this->updateStatus($id, $status);
    }
    
    public function freeTable($id) {
        return $this->updateStatus($id, 'free');
    }
    
    public function isTableAvailable($id) {
        $table = $this->getTable($id);
        return $table && $table['status'] === 'free';
    }
} 