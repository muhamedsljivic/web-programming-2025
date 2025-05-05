<?php
require_once './services/BaseService.php';
require_once './dao/OrderDetailsDao.php';

class OrderDetailsService extends BaseService {
    public function __construct() {
        parent::__construct(new OrderDetailsDao());
    }

    public function get_all_order_details() {
        return $this->dao->getAllOrderDetails();
    }

    public function get_order_details_by_order_id($order_id) {
        return $this->dao->getOrderDetailsByOrderId($order_id);
    }

    public function get_order_details_by_product_id($order_id, $product_id) {
        return $this->dao->getOrderDetailsByProductId($order_id, $product_id);
    }

    public function add_order_detail($order_id, $product_id, $quantity, $price, $subtotal) {
        return $this->dao->addOrderDetail($order_id, $product_id, $quantity, $price, $subtotal);
    }

    public function update_order_detail($order_id, $product_id, $quantity, $price, $subtotal) {
        return $this->dao->updateOrderDetail($order_id, $product_id, $quantity, $price, $subtotal);
    }

    public function delete_order_detail($order_id, $product_id) {
        return $this->dao->deleteOrderDetail($order_id, $product_id);
    }
}
?>
