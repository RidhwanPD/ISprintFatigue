<?php
require_once __DIR__ . '/../Utilities/DB.php';

class UserProfile {
    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }

    public function createProfile($userId, $phone, $address, $preferredCleaningTime, $cleaningFrequency, $languagePreference, $status = 'active') {
        $sql = "INSERT INTO user_profiles (
                    user_id, phone, address, preferred_cleaning_time, cleaning_frequency, language_preference, status
                ) VALUES (
                    '$userId', '$phone', '$address', '$preferredCleaningTime', '$cleaningFrequency', '$languagePreference', '$status'
                )";
        return mysqli_query($this->conn, $sql);
    }

    public function hasProfile($userId) {
        $sql = "SELECT * FROM user_profiles 
				WHERE user_id = '$userId'";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_num_rows($result) > 0;
    }

    public function getProfileByUserId($userId) {
        $sql = "SELECT * FROM user_profiles 
				WHERE user_id = '$userId'";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function getAllProfiles() {
        $sql = "SELECT * FROM user_profiles";
        $result = mysqli_query($this->conn, $sql);

        $profiles = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $profiles[] = $row;
        }
        return $profiles;
    }

    public function updateProfile($userId, $phone, $address, $preferredCleaningTime, $cleaningFrequency, $languagePreference, $status) {
        $sql = "UPDATE user_profiles 
                SET phone = '$phone', 
                    address = '$address', 
                    preferred_cleaning_time = '$preferredCleaningTime', 
                    cleaning_frequency = '$cleaningFrequency', 
                    language_preference = '$languagePreference', 
                    status = '$status' 
                WHERE user_id = '$userId'";
        return mysqli_query($this->conn, $sql);
    }

    public function suspendProfile($userId) {
        $sql = "UPDATE user_profiles 
				SET status = 'suspended' WHERE user_id = '$userId'";
        return mysqli_query($this->conn, $sql);
    }

    public function unsuspendProfile($userId) {
        $sql = "UPDATE user_profiles 
				SET status = 'active' WHERE user_id = '$userId'";
        return mysqli_query($this->conn, $sql);
    }

    public function exists($userId) {
        $sql = "SELECT * FROM user_profiles 
				WHERE user_id = '$userId'";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_num_rows($result) > 0;
    }
}
