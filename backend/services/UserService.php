<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/UserDao.php';

class UserService extends BaseService {
    public function __construct() {
        $dao = new UserDao();
        parent::__construct($dao);
    }

    public function createUser($data) {
        if (empty($data['username'])) {
            throw new Exception('Username is required.');
        }
        if (empty($data['email'])) {
            throw new Exception('Email is required.');
        }
        if (empty($data['password'])) {
            throw new Exception('Password is required.');
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format.');
        }

        $existingUser = $this->dao->getByUsername($data['username']);
        if ($existingUser) {
            throw new Exception('Username already exists.');
        }

        $existingEmail = $this->dao->getByEmail($data['email']);
        if ($existingEmail) {
            throw new Exception('Email already registered.');
        }

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        if (!isset($data['is_admin'])) {
            $data['is_admin'] = false;
        }

        return $this->create($data);
    }

    public function updateUser($id, $data) {
        if (isset($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format.');
        }

        if (isset($data['username'])) {
            $existingUser = $this->dao->getByUsername($data['username']);
            if ($existingUser && $existingUser['id'] != $id) {
                throw new Exception('Username already exists.');
            }
        }

        if (isset($data['email'])) {
            $existingEmail = $this->dao->getByEmail($data['email']);
            if ($existingEmail && $existingEmail['id'] != $id) {
                throw new Exception('Email already registered.');
            }
        }

        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        return $this->update($id, $data);
    }

    public function getByUsername($username) {
        return $this->dao->getByUsername($username);
    }

    public function getByEmail($email) {
        return $this->dao->getByEmail($email);
    }

    public function verifyPassword($username, $password) {
        $user = $this->dao->getByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}
?>