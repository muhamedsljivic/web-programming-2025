<?php
require_once './BaseDao.php';

class ContactUsDao extends BaseDao {
    public function __construct() {
        parent::__construct('contact_us'); 
    }

    // Get all contact messages
    public function getAllMessages() {
        return $this->getAll();
    }

    // Get a single contact message by ID
    public function getMessageById($id) {
        return $this->getById($id);
    }

    // Get all messages from a specific user
    public function getMessagesByUserId($user_id) {
        $stmt = $this->connection->prepare("SELECT * FROM contact_us WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Submit a new contact message
    public function submitMessage($user_id, $name, $email, $message) {
        $data = [
            'user_id' => $user_id,
            'name' => $name,
            'email' => $email,
            'message' => $message
        ];
        return $this->insert($data);
    }

    // Delete a contact message
    public function deleteMessage($id) {
        return $this->delete($id);
    }
}
?>
