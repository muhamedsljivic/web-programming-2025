<?php
require_once __DIR__ . '/BaseDao.php';

class CartDao extends BaseDao {
    public function __construct() {
        parent::__construct('cart'); 
    }

    // Get all cart items
    public function getAllCartItems() {
        return $this->getAll();
    }

    // Get cart items for a specific user
    public function getCartByUserId($user_id) {
        $stmt = $this->connection->prepare("SELECT * FROM cart WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Add a product to the cart or update quantity if already exists
    public function addToCart($user_id, $product_id, $quantity = 1) {
        // Check if the product exists in the products table
        $stmt = $this->connection->prepare("SELECT * FROM products WHERE id = :product_id");
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        $product = $stmt->fetch();
    
        if (!$product) {
            // Product doesn't exist
            throw new Exception("Product with ID $product_id not found.");
        }
    
        if ($this->isProductInCart($user_id, $product_id)) {
            return $this->updateCartQuantity($user_id, $product_id, $quantity);
        } else {
            $data = [
                'user_id' => $user_id,
                'product_id' => $product_id,
                'quantity' => $quantity
            ];
            return $this->insert($data);
        }
    }
    
    

    // Check if a product is already in the cart
    public function isProductInCart($user_id, $product_id) {
        $stmt = $this->connection->prepare("SELECT * FROM cart WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        return $stmt->fetch() !== false;
    }

    // Update quantity of a product in the cart
    public function updateCartQuantity($user_id, $product_id, $quantity) {
        $stmt = $this->connection->prepare("UPDATE cart SET quantity = quantity + :quantity WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_id', $product_id);
        return $stmt->execute();
    }

    // Set a specific quantity for a product in the cart
    public function setCartQuantity($user_id, $product_id, $quantity) {
        $stmt = $this->connection->prepare("UPDATE cart SET quantity = :quantity WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_id', $product_id);
        return $stmt->execute();
    }

    // Remove a product from the cart
    public function removeFromCart($user_id, $product_id) {
        $stmt = $this->connection->prepare("DELETE FROM cart WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_id', $product_id);
        return $stmt->execute();
    }

    // Clear the entire cart for a user
    public function clearCart($user_id) {
        $stmt = $this->connection->prepare("DELETE FROM cart WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        return $stmt->execute();
    }
}
?>
