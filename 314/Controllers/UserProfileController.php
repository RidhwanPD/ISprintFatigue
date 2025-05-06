<?php
require_once __DIR__ . '/../Entities/UserProfile.php';

class UserProfileController {
    private $profile;

    public function __construct() {
        $this->profile = new UserProfile();
    }

    public function createProfile($userId, $phone, $address, $preferredCleaningTime, $cleaningFrequency, $languagePreference) {
        return $this->profile->createProfile($userId, $phone, $address, $preferredCleaningTime, $cleaningFrequency, $languagePreference);
    }

    public function hasProfile($userId) {
        return $this->profile->hasProfile($userId);
    }

    public function getProfileByUserId($userId) {
        return $this->profile->getProfileByUserId($userId);
    }

    public function getAllProfiles() {
        return $this->profile->getAllProfiles();
    }

    public function updateProfile($userId, $phone, $address, $preferredCleaningTime, $cleaningFrequency, $languagePreference, $status = 'active') {
		return $this->profile->updateProfile($userId, $phone, $address, $preferredCleaningTime, $cleaningFrequency, $languagePreference, $status);
	}


    public function suspendProfile($userId) {
        return $this->profile->suspendProfile($userId);
    }

    public function unsuspendProfile($userId) {
        return $this->profile->unsuspendProfile($userId);
    }
}
