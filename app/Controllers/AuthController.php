<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function register($data) {
        $user = new User($this->db);
        $user->email = $data['email'];
        $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->created_at = $data['created_at'] ?? date('Y-m-d H:i:s');

        echo "[AuthController] Registering user:\n";
        print_r($data);

        echo "[AuthController] User fetched:\n";
        print_r($user);

        return $user->create();
    }

    public function login($email, $password) {
        $user = new User($this->db);
        $result = $user->login($email);
        if ($result && password_verify($password, $result['password'])) {
            return $result;
        }
        return false;
    }

    public function getUserById($uid) {
        $user = new User($this->db);
        return $user->getById($uid);
    }

    public function getUserByEmail($email) {
        $user = new User($this->db);
        return $user->getByEmail($email);
    }

    public function resetPassword($uid, $newPassword) {
        $user = new User($this->db);
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        return $user->resetPassword($uid, $hashedPassword);
    }
}
?>
