<?php
require_once __DIR__ . '/../../config/Database.php';

class Car {
    private $conn;
    private $table_name = "Car";

    public $cid;
    public $model_name;
    public $description;
    public $price;
    public $year;
    public $image_url;

    // foreign keys
    public $brand_id;
    public $style_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllPaginated($limit, $offset) {
        $query = "SELECT j.*, b.brand_name, bs.style_name
                FROM {$this->table_name} j
                JOIN Brand b ON j.brand_id = b.bid
                JOIN BodyStyle bs ON j.style_id = bs.bsid
                ORDER BY j.year DESC
                LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAllPaginated() {
        $query = "SELECT COUNT(*) FROM {$this->table_name}";
        return $this->conn->query($query)->fetchColumn();
    }

    public function searchPaginated($keyword, $limit, $offset) {
        $query = "SELECT j.*, b.brand_name, bs.style_name
                FROM {$this->table_name} j
                JOIN Brand b ON j.brand_id = b.bid
                JOIN BodyStyle bs ON j.style_id = bs.bsid
                WHERE j.model_name LIKE :keyword OR bs.style_name LIKE :keyword OR b.brand_name LIKE :keyword
                ORDER BY j.year DESC
                LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($query);
        $kw = "%" . $keyword . "%";
        $stmt->bindParam(":keyword", $kw);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countSearch($keyword) {
        $query = "SELECT COUNT(*) FROM {$this->table_name} j
                JOIN Brand b ON j.brand_id = b.bid
                JOIN BodyStyle bs ON j.style_id = bs.bsid
                WHERE j.model_name LIKE :keyword";
        $stmt = $this->conn->prepare($query);
        $kw = "%" . $keyword . "%";
        $stmt->bindParam(":keyword", $kw);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getByBrandPaginated($brand_id, $limit, $offset) {
        $query = "SELECT j.*, b.brand_name, bs.style_name
                FROM {$this->table_name} j
                JOIN Brand b ON j.brand_id = b.bid
                JOIN BodyStyle bs ON j.style_id = bs.bsid
                WHERE j.brand_id = :brand_id
                ORDER BY j.year DESC
                LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":brand_id", $brand_id);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countByBrand($brand_id) {
        $query = "SELECT COUNT(*) FROM {$this->table_name} WHERE brand_id = :brand_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":brand_id", $brand_id);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function search($keyword) {
        $query = "SELECT j.*, b.brand_name, bs.style_name
                FROM {$this->table_name} j
                JOIN Brand b ON j.brand_id = b.bid
                JOIN BodyStyle bs ON j.style_id = bs.bsid
                WHERE (j.model_name LIKE :keyword OR b.brand_name LIKE :keyword OR bs.style_name LIKE :keyword)
                ORDER BY j.year DESC";
        $stmt = $this->conn->prepare($query);
        $kw = "%" . $keyword . "%";
        $stmt->bindParam(":keyword", $kw);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByBrand($brand_id) {
        $query = "SELECT j.*, b.brand_name, bs.style_name
                FROM {$this->table_name} j
                JOIN Brand b ON j.brand_id = b.bid
                JOIN BodyStyle bs ON j.style_id = bs.bsid
                WHERE j.brand_id = :brand_id
                ORDER BY j.year DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":brand_id", $brand_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCarById($cid) {
        $query = "SELECT j.*, b.brand_name, bs.style_name
                FROM {$this->table_name} j
                JOIN Brand b ON j.brand_id = b.bid
                JOIN BodyStyle bs ON j.style_id = bs.bsid
                WHERE j.cid = :cid
                LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":cid", $cid);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // New: Get inventory for a car (all locations and amounts)
    public function getInventory($cid) {
        $query = "SELECT i.amount, l.location_name, l.address, l.Maps_url
                  FROM Inventory i
                  JOIN Location l ON i.location_id = l.lid
                  WHERE i.car_id = :cid";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":cid", $cid);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>