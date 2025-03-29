<?php
require_once './BaseDao.php';

class OrderDetailsDao extends BaseDao {
    public function __construct() {
        parent::__construct('order_details'); 
    }

    // Get all order details
    public function getAllOrderDetails() {
        return $this->getAll();
    }

    // Get order details by order ID
    public function getOrderDetailsByOrderId($order_id) {
        $stmt = $this->connection->prepare("SELECT * FROM order_details WHERE order_id = :order_id");
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Get order details for a specific product in an order
    public function getOrderDetailsByProductId($order_id, $product_id) {
        $stmt = $this->connection->prepare("SELECT * FROM order_details WHERE order_id = :order_id AND product_id = :product_id");
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Add new order detail
    public function addOrderDetail($order_id, $product_id, $quantity, $price, $subtotal) {
        $data = [
            'order_id' => $order_id,
            'product_id' => $product_id,
            'quantity' => $quantity,
            'price' => $price,
            'subtotal' => $subtotal
        ];
        return $this->insert($data);
    }

    // Update order detail quantity and price
    public function updateOrderDetail($order_id, $product_id, $quantity, $price, $subtotal) {
        $data = [
            'quantity' => $quantity,
            'price' => $price,
            'subtotal' => $subtotal
        ];
        return $this->update($order_id, $data);
    }

    // Delete order detail by order ID and product ID
    public function deleteOrderDetail($order_id, $product_id) {
        $stmt = $this->connection->prepare("DELETE FROM order_details WHERE order_id = :order_id AND product_id = :product_id");
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':product_id', $product_id);
        return $stmt->execute();
    }
}
?>
