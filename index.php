<?php
session_start();

// Define base path constants
define('BASE_PATH', __DIR__);
define('BASE_URL', 'http://localhost/restauracja/');

// Autoloader
spl_autoload_register(function ($class) {
    $file = BASE_PATH . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

// Router
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Convert controller name to proper format (e.g., home -> HomeController)
$controllerClass = ucfirst($controller) . 'Controller';
$controllerFile = BASE_PATH . '/controllers/' . $controllerClass . '.php';

try {
    if (file_exists($controllerFile)) {
        $controllerClass = "controllers\\{$controllerClass}";
        $controllerInstance = new $controllerClass();
        
        if (method_exists($controllerInstance, $action)) {
            $controllerInstance->$action();
        } else {
            throw new Exception("Action not found");
        }
    } else {
        throw new Exception("Controller not found");
    }
} catch (Exception $e) {
    // Handle errors
    echo "Error: " . $e->getMessage();
} 