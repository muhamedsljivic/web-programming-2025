<?php
require_once __DIR__ . '/BaseDao.php';

class WishlistDao extends BaseDao {
    public function __construct() {
        parent::__construct('wishlist');
    }

    // Get all wishlist items
    public function getAllWishlistItems() {
        return $this->getAll();
    }

    // Get wishlist items for a specific user
    public function getWishlistByUserId($user_id) {
        $stmt = $this->connection->prepare("SELECT * FROM wishlist WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Add a product to the wishlist
    public function addToWishlist($user_id, $product_id) {
        $data = [
            'user_id' => $user_id,
            'product_id' => $product_id
        ];
        return $this->insert($data);
    }

    // Remove a product from the wishlist
    public function removeFromWishlist($user_id, $product_id) {
        $stmt = $this->connection->prepare("DELETE FROM wishlist WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_id', $product_id);
        return $stmt->execute();
    }

    // Check if a product is already in the wishlist
    public function isProductInWishlist($user_id, $product_id) {
        $stmt = $this->connection->prepare("SELECT * FROM wishlist WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        return $stmt->fetch() !== false;
    }
}
?>
