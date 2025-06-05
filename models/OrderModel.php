<?php
namespace models;

class OrderModel extends Model {
    public function getOrders($status = null) {
        $sql = "SELECT o.*, t.number as table_number,
                COUNT(oi.id) as items_count,
                GROUP_CONCAT(CONCAT(mi.name, ' (', oi.quantity, ')') SEPARATOR ', ') as items_list
                FROM orders o
                LEFT JOIN tables t ON o.table_id = t.id
                LEFT JOIN order_items oi ON o.id = oi.order_id
                LEFT JOIN menu_items mi ON oi.menu_item_id = mi.id";
        
        $params = [];
        if ($status) {
            $sql .= " WHERE o.status = ?";
            $params[] = $status;
        }
        
        $sql .= " GROUP BY o.id ORDER BY o.created_at DESC";
        return $this->findAll($sql, $params);
    }
    
    public function getOrder($id) {
        return $this->findOne(
            "SELECT o.*, t.number as table_number, t.capacity as table_capacity
             FROM orders o
             LEFT JOIN tables t ON o.table_id = t.id
             WHERE o.id = ?",
            [$id]
        );
    }
    
    public function getOrderItems($orderId) {
        return $this->findAll(
            "SELECT oi.*, mi.name, mi.description, c.name as category_name
             FROM order_items oi
             JOIN menu_items mi ON oi.menu_item_id = mi.id
             LEFT JOIN categories c ON mi.category_id = c.id
             WHERE oi.order_id = ?
             ORDER BY c.name, mi.name",
            [$orderId]
        );
    }
    
    public function createOrder($tableId) {
        $this->query(
            "INSERT INTO orders (table_id, status) VALUES (?, 'new')",
            [$tableId]
        );
        return $this->db->lastInsertId();
    }
    
    public function addOrderItem($orderId, $menuItemId, $quantity) {
        // Get menu item price
        $menuItem = $this->findOne(
            "SELECT price FROM menu_items WHERE id = ?",
            [$menuItemId]
        );
        
        if (!$menuItem) {
            throw new \Exception('Nie znaleziono pozycji menu.');
        }
        
        // Add order item
        $this->query(
            "INSERT INTO order_items (order_id, menu_item_id, quantity, price) 
             VALUES (?, ?, ?, ?)",
            [$orderId, $menuItemId, $quantity, $menuItem['price']]
        );
        
        // Update order total
        $this->updateOrderTotal($orderId);
    }
    
    public function removeOrderItem($orderId, $itemId) {
        $this->query(
            "DELETE FROM order_items WHERE order_id = ? AND id = ?",
            [$orderId, $itemId]
        );
        
        $this->updateOrderTotal($orderId);
    }
    
    public function updateOrderStatus($id, $status) {
        if (!in_array($status, ['new', 'in_progress', 'ready', 'completed', 'cancelled'])) {
            throw new \Exception('Nieprawidłowy status zamówienia.');
        }
        
        $this->query(
            "UPDATE orders SET status = ? WHERE id = ?",
            [$status, $id]
        );
        
        // If order is completed or cancelled, free the table
        if (in_array($status, ['completed', 'cancelled'])) {
            $order = $this->getOrder($id);
            if ($order && $order['table_id']) {
                $tableModel = new TableModel();
                $tableModel->freeTable($order['table_id']);
            }
        }
    }
    
    private function updateOrderTotal($orderId) {
        $this->query(
            "UPDATE orders o 
             SET total_amount = (
                 SELECT COALESCE(SUM(quantity * price), 0)
                 FROM order_items
                 WHERE order_id = ?
             )
             WHERE o.id = ?",
            [$orderId, $orderId]
        );
    }
    
    public function getOrderStats($startDate = null, $endDate = null) {
        $sql = "SELECT 
                COUNT(*) as total_orders,
                COUNT(CASE WHEN status = 'completed' THEN 1 END) as completed_orders,
                COUNT(CASE WHEN status = 'cancelled' THEN 1 END) as cancelled_orders,
                COALESCE(SUM(CASE WHEN status = 'completed' THEN total_amount ELSE 0 END), 0) as total_revenue
                FROM orders
                WHERE 1=1";
        
        $params = [];
        if ($startDate) {
            $sql .= " AND DATE(created_at) >= ?";
            $params[] = $startDate;
        }
        if ($endDate) {
            $sql .= " AND DATE(created_at) <= ?";
            $params[] = $endDate;
        }
        
        return $this->findOne($sql, $params);
    }
    
    public function getPopularItems($limit = 5) {
        $sql = "SELECT mi.name, c.name as category_name,
                    COUNT(oi.id) as order_count,
                    SUM(oi.quantity) as total_quantity
                 FROM order_items oi
                 JOIN menu_items mi ON oi.menu_item_id = mi.id
                 LEFT JOIN categories c ON mi.category_id = c.id
                 JOIN orders o ON oi.order_id = o.id
                 WHERE o.status = 'completed'
                 GROUP BY mi.id
                 ORDER BY total_quantity DESC
                 LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
} 