<?php
require_once __DIR__ . '/../../config/Database.php';

class Brand {
    private $conn;
    private $table_name = "Brand";

    public $bid;
    public $brand_name;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * 
                FROM {$this->table_name}
                ORDER BY bid ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBrandNameById($bid) {
        $query = "SELECT brand_name 
                FROM {$this->table_name}
                WHERE bid = :bid
                LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':bid', $bid);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
