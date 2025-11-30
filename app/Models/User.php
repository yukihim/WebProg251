<?php
require_once __DIR__ . '/../../config/database.php';

class User {
    private $conn;
    private $table_name = "User";

    public $uid;
    public $email;
    public $password;
    public $first_name;
    public $last_name;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO {$this->table_name} (first_name, last_name, email, password, created_at)
                VALUES (:first_name, :last_name, :email, :password, :created_at)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":created_at", $this->created_at);
        return $stmt->execute();
    }

    public function login($email) {
        // Return user by email
        $query = "SELECT *
                FROM {$this->table_name}
                WHERE email = :email
                LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getById($uid) {
        $query = "SELECT * 
                FROM {$this->table_name}
                WHERE uid = :uid";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":uid", $uid);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByEmail($email) {
        $query = "SELECT *
                FROM {$this->table_name}
                WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function resetPassword($uid, $newPassword) {
        $query = "UPDATE {$this->table_name}
                SET password = :password
                WHERE uid = :uid";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":password", $newPassword);
        $stmt->bindParam(":uid", $uid);
        return $stmt->execute();
    }
}
?>
