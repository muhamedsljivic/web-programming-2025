<?php
require_once './BaseDao.php';

class ProductsDao extends BaseDao {
    public function __construct() {
        parent::__construct('products'); 
    }

    // Get all products
    public function getAllProducts() {
        return $this->getAll();
    }

    // Get product by ID
    public function getProductById($id) {
        return $this->getById($id);
    }

    // Create a new product
    public function createProduct($data) {
        return $this->insert($data);
    }

    // Update a product
    public function updateProduct($id, $data) {
        return $this->update($id, $data);
    }

    // Delete a product
    public function deleteProduct($id) {
        return $this->delete($id);
    }

    // Get products by category ID
    public function getProductsByCategory($category_id) {
        $stmt = $this->connection->prepare("SELECT * FROM products WHERE category_id = :category_id");
        $stmt->bindParam(':category_id', $category_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>
