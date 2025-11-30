<?php
require_once __DIR__ . '/../../config/database.php';

class BodyStyle {
    private $conn;
    private $table_name = "BodyStyle";

    public $bsid;
    public $body_style;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getBodyStyleById($bsid) {
        $query = "SELECT style_name 
                FROM {$this->table_name}
                WHERE bsid = :bsid
                LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':bsid', $bsid);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
