<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/BodyStyle.php';

class BodyStyleController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getBodyStyleById($bsid) {
        $bodyStyle = new BodyStyle($this->db);
        return $bodyStyle->getBodyStyleById($bsid);
    }
}