<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/Location.php';

class LocationController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getLocationUrlById($lid) {
        $locationModel = new Location($this->db);
        return $locationModel->getLocationUrlById($lid);
    }
}
?>
