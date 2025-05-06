<?php
require_once __DIR__ . '/../Utilities/DB.php';

class CleaningService {
    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }

    public function createService($cleanerId, $title, $description, $categoryId, $price) {
		$sql = "INSERT INTO cleaning_services (cleaner_id, title, description, category_id, price, status, views, shortlisted)
				VALUES ('$cleanerId', '$title', '$description', '$categoryId', '$price','offered', 0, 0)";
		return mysqli_query($this->conn, $sql);
	}

	
	public function getServicesByCleaner($cleanerId) {
		$sql = "SELECT cs.*, sc.name AS category_name 
				FROM cleaning_services cs
				LEFT JOIN service_categories sc ON cs.category_id = sc.category_id
				WHERE cs.cleaner_id = '$cleanerId'";
		$result = mysqli_query($this->conn, $sql);

		$services = [];
		while ($row = mysqli_fetch_assoc($result)) {
			$services[] = $row;
		}
		return $services;
	}

	
	public function searchServicesByTitle($cleanerId, $keyword) {
		$sql = "SELECT cs.*, sc.name AS category_name 
				FROM cleaning_services cs
				LEFT JOIN service_categories sc ON cs.category_id = sc.category_id
				WHERE cs.cleaner_id = '$cleanerId'
				AND (
                cs.title LIKE '%$keyword%' 
                OR cs.description LIKE '%$keyword%'
                OR sc.name LIKE '%$keyword%'   
				)
				ORDER BY cs.job_id ASC";

		$result = mysqli_query($this->conn, $sql);

		if ($result && mysqli_num_rows($result) > 0) {
			$services = [];
			while ($row = mysqli_fetch_assoc($result)) {
				$services[] = $row;
        }
			return $services;
		}
	}

	public function getServiceById($jobId) {
		$sql = "SELECT * FROM cleaning_services 
				WHERE job_id = '$jobId'";
		$result = mysqli_query($this->conn, $sql);
		return mysqli_fetch_assoc($result);
	}

	public function updateService($jobId, $title, $description, $categoryId, $price) {
		$sql = "UPDATE cleaning_services 
				SET title = '$title', description = '$description', category_id = '$categoryId', price = '$price'
				WHERE job_id = '$jobId'";
		return mysqli_query($this->conn, $sql);
	}


	public function suspendService($jobId) {
		$sql = "UPDATE cleaning_services 
				SET status = 'suspended' WHERE job_id = '$jobId'";
		return mysqli_query($this->conn, $sql);
	}
	
	public function unsuspendService($jobId) {
		$sql = "UPDATE cleaning_services 
				SET status = 'offered' WHERE job_id = '$jobId'";
		return mysqli_query($this->conn, $sql);
	}
	
	public function incrementViewCount($serviceId) {
		$sql = "UPDATE cleaning_services SET views = views + 1 WHERE job_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $serviceId);
		return $stmt->execute();
	}
	
	public function incrementShortlistCount($jobId) {
		$sql = "UPDATE cleaning_services 
				SET shortlisted = shortlisted + 1 
				WHERE job_id = '$jobId'";
		return mysqli_query($this->conn, $sql);
	}
	
}
