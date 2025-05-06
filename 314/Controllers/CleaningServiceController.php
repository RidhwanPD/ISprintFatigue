<?php
require_once __DIR__ . '/../Entities/CleaningService.php';

class CleaningServiceController {
    private $service;

    public function __construct() {
        $this->service = new CleaningService();
    }

	public function createService($cleanerId, $title, $description, $categoryId, $price) {
		return $this->service->createService($cleanerId, $title, $description, $categoryId, $price);
	}
	
	public function getServicesByCleaner($cleanerId) {
		return $this->service->getServicesByCleaner($cleanerId);
	}
	
	public function searchServicesByTitle($cleanerId, $keyword) {
		return $this->service->searchServicesByTitle($cleanerId, $keyword);
	}
	
	public function getServiceById($jobId) {
		return $this->service->getServiceById($jobId);
	}

	public function updateService($jobId, $title, $description, $categoryId, $price) {
		return $this->service->updateService($jobId, $title, $description, $categoryId, $price);
	}

	public function suspendService($jobId) {
		return $this->service->suspendService($jobId);
	}
	
	public function unsuspendService($jobId) {
		return $this->service->unsuspendService($jobId);
	}
	
	public function incrementViewCount($serviceId) {
		return $this->service->incrementViewCount($serviceId);
	}
	
	public function incrementShortlistCount($jobId) {
		return $this->service->incrementShortlistCount($jobId);
	}

}
