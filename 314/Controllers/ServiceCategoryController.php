<?php
require_once __DIR__ . '/../Entities/ServiceCategory.php';

class ServiceCategoryController {
    private $category;

    public function __construct() {
        $this->category = new ServiceCategory();
    }

    public function createCategory($name, $description) {
        if ($this->category->existsByName($name)) {
            return 'exists';
        }
        return $this->category->createCategory($name, $description) ? 'success' : 'error';
    }

    public function getAllCategories() {
        return $this->category->getAllCategories();
    }
	
	public function searchCategories($keyword) {
		return $this->category->searchCategories($keyword);
	}

	public function getCategoryById($id) {
		return $this->category->getCategoryById($id);
	}

	public function updateCategory($categoryId, $name, $description) {
		return $this->category->updateCategory($categoryId, $name, $description);
	}
	
	public function suspendCategory($categoryId) {
		return $this->category->suspendCategory($categoryId);
	}
	
	public function unsuspendCategory($categoryId) {
		return $this->category->unsuspendCategory($categoryId);
	}

}
