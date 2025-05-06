<?php
require_once __DIR__ . '/../Entities/CleanerProfile.php';

class CleanerProfileController {
    private $cleanerProfile;

    public function __construct() {
        $this->cleanerProfile = new CleanerProfile();
    }

    public function createCleanerProfile($userId, $phone, $address, $experience, $preferredCleaningTime, 
					$cleaningFrequency, $languagePreference, $expertise, $rating) {
        return $this->cleanerProfile->createCleanerProfile(
            $userId, 
            $phone, 
            $address, 
            $experience, 
            $preferredCleaningTime, 
            $cleaningFrequency, 
            $languagePreference, 
            $expertise,
			$rating
        );
    }

    public function getCleanerProfileByUserId($userId) {
        return $this->cleanerProfile->getCleanerProfileByUserId($userId);
    }

    public function hasCleanerProfile($userId) {
        return $this->cleanerProfile->hasCleanerProfile($userId);
    }
	
    public function suspendCleanerProfile($userId) {
        return $this->cleanerProfile->suspendCleanerProfile($userId);
    }

    public function unsuspendCleanerProfile($userId) {
        return $this->cleanerProfile->unsuspendCleanerProfile($userId);
    }
	
	public function updateCleanerProfile($userId, $phone, $address, $experience, 
					$preferredCleaningTime, $cleaningFrequency, $languagePreference, $expertise, $rating) {
		return $this->cleanerProfile->updateCleanerProfile($userId, $phone, $address, $experience, $preferredCleaningTime, 
				$cleaningFrequency, $languagePreference, $expertise, $rating);
	}
	public function getAllActiveCleaners() {
		return $this->cleanerProfile->getAllActiveCleaners();
	}
	
	public function searchCleanersByCategoryOrRating($keyword) {
		return $this->cleanerProfile->searchCleanersByCategoryOrRating($keyword);
	}
	

}
