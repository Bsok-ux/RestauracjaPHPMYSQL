<?php
namespace controllers;

class Controller {
    protected function render($view, $data = []) {
        extract($data);
        
        $viewFile = BASE_PATH . '/views/' . $view . '.php';
        
        if (file_exists($viewFile)) {
            ob_start();
            include BASE_PATH . '/views/layouts/header.php';
            include $viewFile;
            include BASE_PATH . '/views/layouts/footer.php';
            echo ob_get_clean();
        } else {
            throw new \Exception("Nie znaleziono pliku widoku: " . $view);
        }
    }

    protected function redirect($url) {
        header('Location: ' . BASE_URL . $url);
        exit();
    }
} 