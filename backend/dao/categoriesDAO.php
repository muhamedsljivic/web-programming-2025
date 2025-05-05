<?php
require_once __DIR__ . '/BaseDao.php';

class CategoriesDao extends BaseDao {
    public function __construct() {
        parent::__construct('categories'); // Set table to 'categories'
    }

    // Get all categories
    public function getAllCategories() {
        return $this->getAll();
    }

    // Get category by ID
    public function getCategoryById($id) {
        return $this->getById($id);
    }

    // Create a new category
    public function createCategory($data) {
        return $this->insert($data);
    }

    // Update category
    public function updateCategory($id, $data) {
        return $this->update($id, $data);
    }

    // Delete category
    public function deleteCategory($id) {
        return $this->delete($id);
    }

    // Get category by name (new method)
    public function getCategoryByName($name) {
            $sql = "SELECT * FROM " . $this->table . " WHERE name = :name LIMIT 1";
            $stmt = $this->connection->prepare($sql);  // Use $this->connection instead of $this->db
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); // Return a single category or null if not found
    }
}
?>
