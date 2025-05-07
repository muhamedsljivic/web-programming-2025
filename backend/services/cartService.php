<?php
require_once './services/BaseService.php';
require_once './dao/CartDao.php';
require_once './dao/productsDao.php'; 

class CartService extends BaseService {
    private $productDao;

    public function __construct() {
        parent::__construct(new CartDao());
        $this->productDao = new ProductsDao(); 
    }

    public function get_all_cart_items() {
        return $this->dao->getAllCartItems();
    }

    public function get_cart_by_user_id($user_id) {
        $this->validate_user_id($user_id);
        return $this->dao->getCartByUserId($user_id);
    }

    public function add_to_cart($user_id, $product_id, $quantity = 1) {
        // Validate input
        $this->validate_user_id($user_id);
        $this->validate_product_exists($product_id);
        $this->validate_quantity($quantity);

        // Check if the product is already in the cart and update if necessary
        if ($this->is_product_in_cart($user_id, $product_id)) {
            return $this->update_cart_quantity($user_id, $product_id, $quantity);
        }

        return $this->dao->addToCart($user_id, $product_id, $quantity);
    }

    public function is_product_in_cart($user_id, $product_id) {
        $this->validate_user_id($user_id);
        $this->validate_product_exists($product_id);
        return $this->dao->isProductInCart($user_id, $product_id);
    }

    public function update_cart_quantity($user_id, $product_id, $quantity) {
        // Validate input
        $this->validate_user_id($user_id);
        $this->validate_product_exists($product_id);
        $this->validate_quantity($quantity);

        return $this->dao->updateCartQuantity($user_id, $product_id, $quantity);
    }

    public function set_cart_quantity($user_id, $product_id, $quantity) {
        // Validate input
        $this->validate_user_id($user_id);
        $this->validate_product_exists($product_id);
        $this->validate_quantity($quantity);

        return $this->dao->setCartQuantity($user_id, $product_id, $quantity);
    }

    public function remove_from_cart($user_id, $product_id) {
        // Validate input
        $this->validate_user_id($user_id);
        $this->validate_product_exists($product_id);

        return $this->dao->removeFromCart($user_id, $product_id);
    }

    public function clear_cart($user_id) {
        $this->validate_user_id($user_id);
        return $this->dao->clearCart($user_id);
    }

    // Validation methods
    private function validate_user_id($user_id) {
        if (!is_numeric($user_id) || $user_id <= 0) {
            throw new Exception("Invalid user ID");
        }
    }

    private function validate_product_exists($product_id) {
        if (!$this->productDao->getById($product_id)) {
            throw new Exception("Product does not exist");
        }
    }

    private function validate_quantity($quantity) {
        if (!is_numeric($quantity) || $quantity <= 0) {
            throw new Exception("Quantity must be a positive integer");
        }
    }
}
?>
