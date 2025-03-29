<?php
require_once './BaseDao.php';

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
}
?>
