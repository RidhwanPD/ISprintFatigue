<?php
require_once __DIR__ . '/../Entities/User.php';

class UserController {
    private $user;

    public function __construct() {
        $this->user = new User();
    }

    public function createUser($name, $email, $password, $role) {
        return $this->user->createUser($name, $email, $password, $role);
    }
	
	public function getAllUsers() {
		return $this->user->getAllUsers();
	}
	
	public function searchUsers($keyword) {
		return $this->user->searchUsers($keyword);
	}
	
	public function getUserById($Id) {
		return $this->user->getUserById($Id);
	}
	
	public function updateUser($id, $name, $email, $role) {
		return $this->user->updateUser($id, $name, $email, $role);
	}
	
	public function suspendUser($id) {
		$this->user->suspendUser($id);
		require_once __DIR__ . '/../Entities/UserProfile.php';
		$profile = new UserProfile();
		$profile->suspendProfile($id);

		return true;
	}

	
	public function unsuspendUser($id) {
		$userResult = $this->user->unsuspendUser($id);
		require_once __DIR__ . '/../Entities/UserProfile.php';
		$profile = new UserProfile();
		$profileResult = $profile->unsuspendProfile($id);

		return $userResult && $profileResult;
	}
	
	public function hasProfile($userId) {
		require_once __DIR__ . '/../Entities/UserProfile.php';
		$profile = new UserProfile();
		return $profile->exists($userId);
	}
	
	public function hasCleanerProfile($userId) {
		require_once __DIR__ . '/../Entities/CleanerProfile.php';
		$cleanerProfile = new CleanerProfile();
		return $cleanerProfile->exists($userId);
	}

}
