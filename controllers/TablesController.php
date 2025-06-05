<?php
namespace controllers;

class TablesController extends Controller {
    private $tableModel;
    
    public function __construct() {
        $this->tableModel = new \models\TableModel();
    }
    
    public function index() {
        $tables = $this->tableModel->getTables();
        $this->render('tables/index', ['tables' => $tables]);
    }
    
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'number' => $_POST['number'],
                'capacity' => $_POST['capacity'],
                'status' => 'free'
            ];
            
            try {
                $this->tableModel->addTable($data);
                $_SESSION['success'] = 'Stolik został pomyślnie dodany.';
            } catch (\Exception $e) {
                $_SESSION['error'] = 'Błąd podczas dodawania stolika: ' . $e->getMessage();
            }
            
            $this->redirect('?controller=tables');
        }
        
        $this->render('tables/form');
    }
    
    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->redirect('?controller=tables');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'number' => $_POST['number'],
                'capacity' => $_POST['capacity'],
                'status' => $_POST['status']
            ];
            
            try {
                $this->tableModel->updateTable($id, $data);
                $_SESSION['success'] = 'Informacje o stoliku zostały zaktualizowane.';
            } catch (\Exception $e) {
                $_SESSION['error'] = 'Błąd podczas aktualizacji informacji: ' . $e->getMessage();
            }
            
            $this->redirect('?controller=tables');
        }
        
        $table = $this->tableModel->getTable($id);
        if (!$table) {
            $_SESSION['error'] = 'Nie znaleziono stolika.';
            $this->redirect('?controller=tables');
        }
        
        $this->render('tables/form', ['table' => $table]);
    }
    
    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $status = $_POST['status'] ?? null;
            
            if ($id && $status) {
                try {
                    if ($status === 'free') {
                        $this->tableModel->freeTable($id);
                    } else {
                        $this->tableModel->reserveTable($id, $status);
                    }
                    $_SESSION['success'] = 'Status stolika został zaktualizowany.';
                } catch (\Exception $e) {
                    $_SESSION['error'] = 'Błąd podczas aktualizacji statusu: ' . $e->getMessage();
                }
            }
        }
        
        $this->redirect('?controller=tables');
    }
    
    public function view() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->redirect('?controller=tables');
        }
        
        $table = $this->tableModel->getTableWithCurrentOrder($id);
        if (!$table) {
            $_SESSION['error'] = 'Nie znaleziono stolika.';
            $this->redirect('?controller=tables');
        }
        
        $this->render('tables/view', ['table' => $table]);
    }
} 