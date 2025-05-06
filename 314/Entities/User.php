<?php
require_once __DIR__ . '/../Utilities/DB.php';

class User {
    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }

    public function getByEmail($email) {
        $sql = "SELECT * FROM users 
				WHERE email = '$email'";
        $result = mysqli_query($this->conn, $sql);

        if ($row = mysqli_fetch_assoc($result)) {
            return $row;
        }

        return null;
    }

	public function createUser($name, $email, $password, $role) {
		$check = mysqli_query($this->conn, "SELECT * FROM users 
											WHERE email = '$email'");
		if (mysqli_num_rows($check) > 0) {
			return 'exists';
		}

		$sql = "INSERT INTO users (name, email, password, role, status)
            VALUES ('$name', '$email', '$password', '$role', 'active')";
    
		if (mysqli_query($this->conn, $sql)) {
			return 'success';
		} else 
		{
        return 'error';
		}
	}

    public function getAllUsers() {
        $sql = "SELECT * FROM users 
				ORDER BY id ASC";
        $result = mysqli_query($this->conn, $sql);

        $users = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
        return $users;
    }

	public function searchUsers($keyword) {
		$sql = "SELECT * FROM users 
				WHERE name LIKE '%$keyword%' 
				OR email LIKE '%$keyword%' 
				OR role LIKE '%$keyword%' 
				ORDER BY id ASC";
		$result = mysqli_query($this->conn, $sql);

		$users = [];
		while ($row = mysqli_fetch_assoc($result)) {
			$users[] = $row;
		}
		return $users;
	}

    public function getUserById($id) {
        $sql = "SELECT * FROM users 
				WHERE id = '$id'";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function updateUser($id, $name, $email, $role) {
        $sql = "UPDATE users 
                SET name = '$name', email = '$email', role = '$role' 
                WHERE id = '$id'";
        return mysqli_query($this->conn, $sql);
    }
	
	public function suspendUser($id) {
		$sql = "UPDATE users 
				SET status = 'suspended' WHERE id = '$id'";
		return mysqli_query($this->conn, $sql);
	}
	
	public function unsuspendUser($id) {
		$sql = "UPDATE users 
				SET status = 'active' WHERE id = '$id'";
		return mysqli_query($this->conn, $sql);
	}
}
