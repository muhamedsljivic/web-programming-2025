<?php
require_once './BaseDao.php';

class OrdersDao extends BaseDao {
    public function __construct() {
        parent::__construct('orders'); 
    }

    // Get all orders
    public function getAllOrders() {
        return $this->getAll();
    }

    // Get a single order by ID
    public function getOrderById($id) {
        return $this->getById($id);
    }

    // Get orders for a specific user
    public function getOrdersByUserId($user_id) {
        $stmt = $this->connection->prepare("SELECT * FROM orders WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Create a new order
    public function createOrder($user_id, $total_price, $status = 'pending') {
        $data = [
            'user_id' => $user_id,
            'total_price' => $total_price,
            'status' => $status
        ];
        return $this->insert($data);
    }

    // Update order status
    public function updateOrderStatus($order_id, $status) {
        $data = [
            'status' => $status
        ];
        return $this->update($order_id, $data);
    }

    // Delete an order
    public function deleteOrder($order_id) {
        return $this->delete($order_id);
    }
}
?>
