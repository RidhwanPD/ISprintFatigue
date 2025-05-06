<?php
require_once __DIR__ . '/../Utilities/DB.php';

class ServiceCategory {
    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }

    public function createCategory($name, $description, $status = 'active') {
        $sql = "INSERT INTO service_categories (name, description, status)
                VALUES ('$name', '$description', '$status')";
        return mysqli_query($this->conn, $sql);
    }

    public function getAllCategories() {
        $sql = "SELECT * FROM service_categories";
        $result = mysqli_query($this->conn, $sql);

        $categories = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row;
        }
        return $categories;
    }
	
	public function searchCategories($keyword) {
		$keyword = "%$keyword%";
		$stmt = $this->conn->prepare("SELECT * FROM service_categories WHERE name LIKE ? OR description LIKE ?");
		$stmt->bind_param("ss", $keyword, $keyword);
		$stmt->execute();
		return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	}


    public function existsByName($name) {
        $sql = "SELECT * FROM service_categories WHERE name = '$name'";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_num_rows($result) > 0;
    }
	
	public function getCategoryById($categoryId) {
        $sql = "SELECT * FROM service_categories WHERE category_id = '$categoryId'";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }
	
	public function updateCategory($categoryId, $name, $description) {
		$stmt = $this->conn->prepare("UPDATE service_categories SET name = ?, description = ? WHERE category_id = ?");
		$stmt->bind_param("ssi", $name, $description, $categoryId);
		return $stmt->execute();
	}
	
	public function suspendCategory($categoryId) {
		$stmt = $this->conn->prepare("UPDATE service_categories SET status = 'suspended' WHERE category_id = ?");
		$stmt->bind_param("i", $categoryId);
		return $stmt->execute();
	}
	
	public function unsuspendCategory($categoryId) {
		$stmt = $this->conn->prepare("UPDATE service_categories SET status = 'active' WHERE category_id = ?");
		$stmt->bind_param("i", $categoryId);
		return $stmt->execute();
	}

}
