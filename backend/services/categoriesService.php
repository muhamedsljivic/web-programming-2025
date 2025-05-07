<?php
require_once './services/BaseService.php';
require_once './dao/CategoriesDao.php';

class CategoriesService extends BaseService {
    public function __construct() {
        parent::__construct(new CategoriesDao());
    }

    public function get_all_categories() {
        return $this->dao->getAllCategories();
    }

    public function get_category_by_id($id) {
        $this->validate_category_id($id);
        return $this->dao->getCategoryById($id);
    }
    public function create_category($data) {
        // Check if category name already exists
        $existingCategory = $this->dao->getCategoryByName($data['name']);
        if ($existingCategory) {
            throw new Exception('Category with this name already exists');
        }
    
        // Proceed to create the category
        return $this->dao->createCategory($data);
    }
    

    public function update_category($id, $data) {
        // Validate category ID and data
        $this->validate_category_id($id);
        $this->validate_category_data($data);

        // Ensure category exists
        $existingCategory = $this->dao->getCategoryById($id);
        if (!$existingCategory) {
            throw new Exception("Category not found");
        }

        return $this->dao->updateCategory($id, $data);
    }

    public function delete_category($id) {
        // Validate category ID
        $this->validate_category_id($id);

        // Ensure category exists before deletion
        $existingCategory = $this->dao->getCategoryById($id);
        if (!$existingCategory) {
            throw new Exception("Category not found");
        }

        return $this->dao->deleteCategory($id);
    }

    // Validation methods
    private function validate_category_id($id) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid category ID");
        }
    }

    private function validate_category_data($data) {
        if (empty($data['name'])) {
            throw new Exception("Category name cannot be empty");
        }

        if (strlen($data['name']) > 255) {
            throw new Exception("Category name is too long (max 255 characters)");
        }
    }
}
?>
