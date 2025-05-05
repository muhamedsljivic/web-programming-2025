<?php
require_once './services/BaseService.php';
require_once './dao/ProductsDao.php';

class ProductsService extends BaseService {
    public function __construct() {
        parent::__construct(new ProductsDao());
    }

    public function get_all_products() {
        return $this->dao->getAllProducts();
    }

    public function get_product_by_id($id) {
        return $this->dao->getProductById($id);
    }

    public function create_product($data) {
        return $this->dao->createProduct($data);
    }

    public function update_product($id, $data) {
        return $this->dao->updateProduct($id, $data);
    }

    public function delete_product($id) {
        return $this->dao->deleteProduct($id);
    }

    public function get_products_by_category($category_id) {
        return $this->dao->getProductsByCategory($category_id);
    }
}
?>
