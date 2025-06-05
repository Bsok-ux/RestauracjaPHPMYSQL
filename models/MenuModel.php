<?php
namespace models;

class MenuModel extends Model {
    public function getCategories() {
        return $this->findAll("SELECT * FROM categories ORDER BY name");
    }
    
    public function getCategory($id) {
        return $this->findOne("SELECT * FROM categories WHERE id = ?", [$id]);
    }
    
    public function addCategory($name, $description) {
        $sql = "INSERT INTO categories (name, description) VALUES (?, ?)";
        return $this->query($sql, [$name, $description]);
    }
    
    public function getMenuItems($categoryId = null) {
        $sql = "SELECT m.*, c.name as category_name 
                FROM menu_items m 
                LEFT JOIN categories c ON m.category_id = c.id";
        $params = [];
        
        if ($categoryId) {
            $sql .= " WHERE m.category_id = ?";
            $params[] = $categoryId;
        }
        
        $sql .= " ORDER BY c.name, m.name";
        return $this->findAll($sql, $params);
    }
    
    public function getMenuItem($id) {
        return $this->findOne(
            "SELECT m.*, c.name as category_name 
             FROM menu_items m 
             LEFT JOIN categories c ON m.category_id = c.id 
             WHERE m.id = ?", 
            [$id]
        );
    }
    
    public function addMenuItem($data) {
        $sql = "INSERT INTO menu_items (category_id, name, description, price, is_available) 
                VALUES (?, ?, ?, ?, ?)";
        return $this->query($sql, [
            $data['category_id'],
            $data['name'],
            $data['description'],
            $data['price'],
            $data['is_available'] ?? 1
        ]);
    }
    
    public function updateMenuItem($id, $data) {
        $sql = "UPDATE menu_items 
                SET category_id = ?, name = ?, description = ?, 
                    price = ?, is_available = ? 
                WHERE id = ?";
        return $this->query($sql, [
            $data['category_id'],
            $data['name'],
            $data['description'],
            $data['price'],
            $data['is_available'] ?? 1,
            $id
        ]);
    }
    
    public function toggleAvailability($id) {
        $sql = "UPDATE menu_items 
                SET is_available = NOT is_available 
                WHERE id = ?";
        return $this->query($sql, [$id]);
    }
} 