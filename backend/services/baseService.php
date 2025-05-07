<?php

class BaseService {
    protected $dao;

    public function __construct($dao)
    {
        $this->dao = $dao;
    }

    public function get_all()
    {
        return $this->dao->getAll();
    }

    public function get_by_id($id)
    {
        return $this->dao->getById($id);
    }

    public function add($entity)
    {
        return $this->dao->insert($entity);
    }

    public function update($entity, $id, $id_column = "id")
    {
        // Your DAO only supports updating by "id"
        if ($id_column !== "id") {
            throw new Exception("Custom ID columns not supported in BaseDao update");
        }
        return $this->dao->update($id, $entity);
    }

    public function delete($id)
    {
        return $this->dao->delete($id);
    }
}
?>
