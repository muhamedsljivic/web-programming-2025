<?php
require_once './services/BaseService.php';
require_once './dao/UsersDao.php';

class UsersService extends BaseService {
    public function __construct() {
        parent::__construct(new UsersDao());
    }

    public function get_all_users() {
        return $this->dao->getAllUsers();
    }

    public function get_user_by_email($email) {
        return $this->dao->getByEmail($email);
    }
    public function create_user($name, $email, $password, $phone, $address, $city, $country, $postal_code, $role, $created_at) {
        // Prepare the data array
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'phone' => $phone,
            'address' => $address,
            'city' => $city,
            'country' => $country,
            'postal_code' => $postal_code,
            'role' => $role,
            'created_at' => $created_at
        ];
    
        // Call the DAO's createUser method with the data
        return $this->dao->createUser($data);
    }
    

    
    public function update_user($id, $data) {
        // First, get the existing user data
        $user = $this->dao->getById($id);  // Assuming `getById()` method is implemented in the DAO.
    
        if ($user) {
            // If user exists, update the fields
            $updated_data = [
                'name' => isset($data['name']) ? $data['name'] : $user['name'],
                'email' => isset($data['email']) ? $data['email'] : $user['email'],
                'password' => isset($data['password']) ? $data['password'] : $user['password'],
                'phone' => isset($data['phone']) ? $data['phone'] : $user['phone'],
                'address' => isset($data['address']) ? $data['address'] : $user['address'],
                'city' => isset($data['city']) ? $data['city'] : $user['city'],
                'country' => isset($data['country']) ? $data['country'] : $user['country'],
                'postal_code' => isset($data['postal_code']) ? $data['postal_code'] : $user['postal_code'],
                'role' => isset($data['role']) ? $data['role'] : $user['role']
            ];
    
            // Now call the DAO method to update the user in the database
            $this->dao->updateUser($id, $updated_data);
            
            return ['success' => 'User updated successfully'];
        } else {
            // If user is not found
            return ['error' => 'User not found'];
        }
    }
    
    public function get_user_by_id($id) {
        return $this->dao->getById($id);
    }

    public function delete_user($id) {
        return $this->dao->deleteUser($id);
    }
}
?>
