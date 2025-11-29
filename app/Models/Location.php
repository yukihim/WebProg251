<?php
require_once __DIR__ . '/../../config/Database.php';

class Location {
    private $conn;
    private $table_name = "Location";

    public $lid;
    public $location_name;
    public $address;
    public $Maps_url;

    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function getLocationUrlById($lid) {
        $query = "SELECT location_name, Maps_url 
                FROM {$this->table_name}
                WHERE lid = :lid
                LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':lid', $lid);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
