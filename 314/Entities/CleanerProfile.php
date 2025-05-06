<?php
require_once __DIR__ . '/../Utilities/DB.php';

class CleanerProfile {
    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }

    public function createCleanerProfile($userId, $phone, $address, $experience, $preferredCleaningTime, $cleaningFrequency, $languagePreference, $expertise, $rating) {
        $check = mysqli_query($this->conn, "SELECT * FROM cleaner_profiles WHERE user_id = '$userId'");
        if (mysqli_num_rows($check) > 0) {
            return 'exists';
        }

        $sql = "INSERT INTO cleaner_profiles (
                    user_id, phone, address, experience, 
                    preferred_cleaning_time, cleaning_frequency, 
                    language_preference, expertise, rating, 
                    status
                ) VALUES (
                    '$userId', '$phone', '$address', '$experience',
                    '$preferredCleaningTime', '$cleaningFrequency',
                    '$languagePreference', '$expertise',$rating, 
                    'active'
                )";

        return mysqli_query($this->conn, $sql) ? 'success' : 'error';
    }

    public function getCleanerProfileByUserId($userId) {
        $sql = "SELECT cp.*, sc.name AS category_name 
                FROM cleaner_profiles cp 
                LEFT JOIN service_categories sc 
                ON cp.expertise = sc.category_id
                WHERE cp.user_id = '$userId'";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }
	
	public function updateCleanerProfile($userId, $phone, $address, $experience, $preferredCleaningTime, $cleaningFrequency, $languagePreference, $expertise, $rating) {
		$sql = "UPDATE cleaner_profiles 
				SET phone = '$phone', 
                address = '$address', 
                experience = '$experience', 
                preferred_cleaning_time = '$preferredCleaningTime',
                cleaning_frequency = '$cleaningFrequency',
                language_preference = '$languagePreference',
                expertise = '$expertise',
				rating = $rating
				WHERE user_id = '$userId'";
		return mysqli_query($this->conn, $sql);
	}


    public function hasCleanerProfile($userId) {
        $sql = "SELECT * FROM cleaner_profiles WHERE user_id = '$userId'";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_num_rows($result) > 0;
    }

    public function suspendCleanerProfile($userId) {
        $sql = "UPDATE cleaner_profiles SET status = 'suspended' WHERE user_id = '$userId'";
        return mysqli_query($this->conn, $sql);
    }

    public function unsuspendCleanerProfile($userId) {
        $sql = "UPDATE cleaner_profiles SET status = 'active' WHERE user_id = '$userId'";
        return mysqli_query($this->conn, $sql);
    }

    public function exists($userId) {
        $sql = "SELECT * FROM cleaner_profiles WHERE user_id = '$userId'";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_num_rows($result) > 0;
    }
	
	public function getAllActiveCleaners() {
		$sql = "SELECT cp.*, u.name, u.email, sc.name AS category_name
				FROM cleaner_profiles cp
				JOIN users u ON cp.user_id = u.id
				LEFT JOIN service_categories sc ON cp.expertise = sc.category_id
				WHERE cp.status = 'active' AND u.status = 'active'";
    
		$result = mysqli_query($this->conn, $sql);

		$cleaners = [];
			while ($row = mysqli_fetch_assoc($result)) {
			$cleaners[] = $row;
		}

		return $cleaners;
	}

	public function searchCleanersByCategoryOrRating($keyword) {
    $sql = "SELECT cp.*, u.name, sc.name AS category_name
            FROM cleaner_profiles cp
            JOIN users u ON cp.user_id = u.id
            LEFT JOIN service_categories sc ON cp.expertise = sc.category_id
            WHERE cp.status = 'active'
            AND (
                sc.name LIKE '%$keyword%' 
				OR cp.address LIKE '%$keyword%'
                OR cp.rating LIKE '%$keyword%'
            )";

    $result = mysqli_query($this->conn, $sql);
    $cleaners = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $cleaners[] = $row;
    }
    return $cleaners;
}

	
}
?>
