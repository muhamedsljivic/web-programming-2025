<?php
require_once './services/BaseService.php';
require_once './dao/OrdersDao.php';

class OrdersService extends BaseService {
    public function __construct() {
        parent::__construct(new OrdersDao());
    }

    public function get_all_orders() {
        return $this->dao->getAllOrders();
    }

    public function get_order_by_id($id) {
        return $this->dao->getOrderById($id);
    }

    public function get_orders_by_user_id($user_id) {
        return $this->dao->getOrdersByUserId($user_id);
    }

    public function create_order($data) {
        // Extract the values from the array
        $user_id = $data['user_id'];
        $total_price = $data['total_price'];
        $status = isset($data['status']) ? $data['status'] : 'pending';
        
        // Call the DAO method
        return $this->dao->createOrder($user_id, $total_price, $status);
    }


    public function update_order_status($order_id, $status) {
        return $this->dao->updateOrderStatus($order_id, $status);
    }

    public function delete_order($order_id) {
        return $this->dao->deleteOrder($order_id);
    }
}
?>
