<?php
namespace models;

class Model {
    protected $db;
    
    public function __construct() {
        $config = require BASE_PATH . '/config/database.php';
        
        try {
            $this->db = new \PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}",
                $config['username'],
                $config['password'],
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    \PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (\PDOException $e) {
            die("Połączenie nie powiodło się: " . $e->getMessage());
        }
    }
    
    protected function query($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
    
    protected function findAll($sql, $params = []) {
        return $this->query($sql, $params)->fetchAll();
    }
    
    protected function findOne($sql, $params = []) {
        return $this->query($sql, $params)->fetch();
    }
} 