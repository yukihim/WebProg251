<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/Brand.php';

class BrandController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getAllBrands() {
        $brandModel = new Brand($this->db);
        return $brandModel->getAll();
    }

    public function getBrandNameById($bid) {
        $brandModel = new Brand($this->db);
        return $brandModel->getBrandNameById($bid);
    }
}
?>
