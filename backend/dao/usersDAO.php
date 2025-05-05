<?php
require_once __DIR__ . '/BaseDao.php';

class UsersDao extends BaseDao {
    public function __construct() {
        parent::__construct('users');
    }

     // Get all users
     public function getAllUsers() {
        return $this->getAll();
    }

    // Get user by email
    public function getByEmail($email) {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Create a new user
    public function createUser($data) {
        return $this->insert($data);
    }
    public function updateUser($id, $data) {
        $sql = "UPDATE users SET name = :name, email = :email, password = :password, phone = :phone, address = :address, city = :city, country = :country, postal_code = :postal_code, role = :role WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':city', $data['city']);
        $stmt->bindParam(':country', $data['country']);
        $stmt->bindParam(':postal_code', $data['postal_code']);
        $stmt->bindParam(':role', $data['role']);
        return $stmt->execute();
    }
    
    
    public function getById($id) {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Delete user
    public function deleteUser($id) {
        return $this->delete($id);
    }
}
?>
