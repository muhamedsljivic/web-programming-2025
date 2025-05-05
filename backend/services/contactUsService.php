<?php
require_once './services/BaseService.php';
require_once './dao/ContactUsDao.php';

class ContactUsService extends BaseService {
    public function __construct() {
        parent::__construct(new ContactUsDao());
    }

    // Get all messages
    public function get_all_messages() {
        return $this->dao->getAllMessages();
    }

    // Get message by ID
    public function get_message_by_id($id) {
        $this->validate_message_id($id); // Validate ID
        return $this->dao->getMessageById($id);
    }

    // Get messages by user ID
    public function get_messages_by_user_id($user_id) {
        $this->validate_user_id($user_id); // Validate user ID
        return $this->dao->getMessagesByUserId($user_id);
    }

    // Submit a new message
    public function submit_message($user_id, $name, $email, $message) {
        // Validate inputs
        $this->validate_user_id($user_id);
        $this->validate_message_data($name, $email, $message);
        
        return $this->dao->submitMessage($user_id, $name, $email, $message);
    }

    // Delete message
    public function delete_message($id) {
        $this->validate_message_id($id); // Validate ID
        return $this->dao->deleteMessage($id);
    }

    // Validation methods
    private function validate_message_id($id) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid message ID");
        }
    }

    private function validate_user_id($user_id) {
        if (!is_numeric($user_id) || $user_id <= 0) {
            throw new Exception("Invalid user ID");
        }
    }

    private function validate_message_data($name, $email, $message) {
        if (empty($name) || strlen($name) > 255) {
            throw new Exception("Invalid name. Name cannot be empty or longer than 255 characters.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format.");
        }

        if (empty($message) || strlen($message) > 1000) {
            throw new Exception("Message cannot be empty or longer than 1000 characters.");
        }
    }
}
?>
