<?php
require_once './services/BaseService.php';
require_once './dao/WishlistDao.php';

class WishlistService extends BaseService {
    public function __construct() {
        parent::__construct(new WishlistDao());
    }

    public function get_all_wishlist_items() {
        return $this->dao->getAllWishlistItems();
    }

    public function get_wishlist_by_user_id($user_id) {
        return $this->dao->getWishlistByUserId($user_id);
    }
    public function add_to_wishlist($user_id, $data) {
        // Here, you directly use product_id since it's an integer
        $product_id = $data['product_id'];  // Directly access the product_id as an integer
    
        // Now, call the method with the correct parameters
        return $this->dao->addToWishlist($user_id, $product_id);
    }
    

    public function remove_from_wishlist($user_id, $product_id) {
        return $this->dao->removeFromWishlist($user_id, $product_id);
    }

    public function is_product_in_wishlist($user_id, $product_id) {
        return $this->dao->isProductInWishlist($user_id, $product_id);
    }
}
?>
