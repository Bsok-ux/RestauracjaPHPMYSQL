<?php
namespace controllers;

class OrdersController extends Controller {
    private $orderModel;
    private $menuModel;
    private $tableModel;
    
    public function __construct() {
        $this->orderModel = new \models\OrderModel();
        $this->menuModel = new \models\MenuModel();
        $this->tableModel = new \models\TableModel();
    }
    
    public function index() {
        $status = $_GET['status'] ?? null;
        $orders = $this->orderModel->getOrders($status);
        $stats = $this->orderModel->getOrderStats();
        $popularItems = $this->orderModel->getPopularItems();
        
        $this->render('orders/index', [
            'orders' => $orders,
            'stats' => $stats,
            'popularItems' => $popularItems,
            'currentStatus' => $status
        ]);
    }
    
    public function create() {
        $tableId = $_GET['table_id'] ?? null;
        
        if (!$tableId || !$this->tableModel->isTableAvailable($tableId)) {
            $_SESSION['error'] = 'Stolik jest niedostępny do utworzenia zamówienia.';
            $this->redirect('?controller=tables');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $orderId = $this->orderModel->createOrder($tableId);
                $this->tableModel->reserveTable($tableId, 'occupied');
                
                if (isset($_POST['items']) && is_array($_POST['items'])) {
                    foreach ($_POST['items'] as $itemId => $quantity) {
                        if ($quantity > 0) {
                            $this->orderModel->addOrderItem($orderId, $itemId, $quantity);
                        }
                    }
                }
                
                $_SESSION['success'] = 'Zamówienie zostało pomyślnie utworzone.';
                $this->redirect("?controller=orders&action=view&id={$orderId}");
            } catch (\Exception $e) {
                $_SESSION['error'] = 'Błąd podczas tworzenia zamówienia: ' . $e->getMessage();
                $this->redirect('?controller=tables');
            }
        }
        
        $table = $this->tableModel->getTable($tableId);
        $menuItems = $this->menuModel->getMenuItems();
        $categories = $this->menuModel->getCategories();
        
        $this->render('orders/form', [
            'table' => $table,
            'menuItems' => $menuItems,
            'categories' => $categories
        ]);
    }
    
    public function view() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->redirect('?controller=orders');
        }
        
        $order = $this->orderModel->getOrder($id);
        if (!$order) {
            $_SESSION['error'] = 'Nie znaleziono zamówienia.';
            $this->redirect('?controller=orders');
        }
        
        $items = $this->orderModel->getOrderItems($id);
        
        $this->render('orders/view', [
            'order' => $order,
            'items' => $items
        ]);
    }
    
    public function addItem() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderId = $_POST['order_id'] ?? null;
            $menuItemId = $_POST['menu_item_id'] ?? null;
            $quantity = $_POST['quantity'] ?? 1;
            
            try {
                $this->orderModel->addOrderItem($orderId, $menuItemId, $quantity);
                $_SESSION['success'] = 'Pozycja została dodana do zamówienia.';
            } catch (\Exception $e) {
                $_SESSION['error'] = 'Błąd podczas dodawania pozycji: ' . $e->getMessage();
            }
            
            $this->redirect("?controller=orders&action=view&id={$orderId}");
        }
    }
    
    public function removeItem() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderId = $_POST['order_id'] ?? null;
            $itemId = $_POST['item_id'] ?? null;
            
            try {
                $this->orderModel->removeOrderItem($orderId, $itemId);
                $_SESSION['success'] = 'Pozycja została usunięta z zamówienia.';
            } catch (\Exception $e) {
                $_SESSION['error'] = 'Błąd podczas usuwania pozycji: ' . $e->getMessage();
            }
            
            $this->redirect("?controller=orders&action=view&id={$orderId}");
        }
    }
    
    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderId = $_POST['order_id'] ?? null;
            $status = $_POST['status'] ?? null;
            
            try {
                $this->orderModel->updateOrderStatus($orderId, $status);
                $_SESSION['success'] = 'Status zamówienia został zaktualizowany.';
            } catch (\Exception $e) {
                $_SESSION['error'] = 'Błąd podczas aktualizacji statusu: ' . $e->getMessage();
            }
            
            $this->redirect("?controller=orders&action=view&id={$orderId}");
        }
    }
} 