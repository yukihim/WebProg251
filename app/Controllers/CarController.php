<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/Car.php';

class CarController {
    private $db;
    private $carModel;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->carModel = new Car($this->db);
    }

    public function listCarsPaginated($limit, $offset) {
        return $this->carModel->getAllPaginated($limit, $offset);
    }

    public function countCars() {
        return $this->carModel->countAllPaginated();
    }

    public function searchCarsPaginated($keyword, $limit, $offset) {
        return $this->carModel->searchPaginated($keyword, $limit, $offset);
    }

    public function countSearchCars($keyword) {
        return $this->carModel->countSearch($keyword);
    }

    public function showByBrandPaginated($brand_id, $limit, $offset) {
        return $this->carModel->getByBrandPaginated($brand_id, $limit, $offset);
    }

    public function countCarsByBrand($brand_id) {
        return $this->carModel->countByBrand($brand_id);
    }

    public function showCar($cid) {
        return $this->carModel->getCarById($cid);
    }

    // New: Get inventory for a car (all locations and amounts)
    public function getCarInventory($cid) {
        return $this->carModel->getInventory($cid);
    }
}
?>