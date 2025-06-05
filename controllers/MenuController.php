<?php
namespace controllers;

class MenuController extends Controller {
    private $menuModel;
    
    public function __construct() {
        $this->menuModel = new \models\MenuModel();
    }
    
    public function index() {
        $categoryId = $_GET['category_id'] ?? null;
        $items = $this->menuModel->getMenuItems($categoryId);
        $categories = $this->menuModel->getCategories();
        
        $this->render('menu/index', [
            'items' => $items,
            'categories' => $categories,
            'selectedCategory' => $categoryId
        ]);
    }
    
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'category_id' => $_POST['category_id'],
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'is_available' => isset($_POST['is_available']) ? 1 : 0
            ];
            
            $this->menuModel->addMenuItem($data);
            $this->redirect('?controller=menu');
        }
        
        $categories = $this->menuModel->getCategories();
        $this->render('menu/form', ['categories' => $categories]);
    }
    
    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->redirect('?controller=menu');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'category_id' => $_POST['category_id'],
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'is_available' => isset($_POST['is_available']) ? 1 : 0
            ];
            
            $this->menuModel->updateMenuItem($id, $data);
            $this->redirect('?controller=menu');
        }
        
        $item = $this->menuModel->getMenuItem($id);
        $categories = $this->menuModel->getCategories();
        $this->render('menu/form', [
            'item' => $item,
            'categories' => $categories
        ]);
    }
    
    public function toggleAvailability() {
        $id = $_POST['id'] ?? null;
        if ($id) {
            $this->menuModel->toggleAvailability($id);
        }
        $this->redirect('?controller=menu');
    }
} 