<?php
require_once __DIR__ . '/../Entities/Favorite.php';

class FavoriteController {
    private $favorite;

    public function __construct() {
        $this->favorite = new Favorite();
    }

    public function addFavorite($homeownerId, $cleanerId) {
        if ($this->favorite->isFavorited($homeownerId, $cleanerId)) {
            return 'exists';
        }

        return $this->favorite->addFavorite($homeownerId, $cleanerId) ? 'success' : 'error';
    }

    public function removeFavorite($homeownerId, $cleanerId) {
        return $this->favorite->removeFavorite($homeownerId, $cleanerId) ? 'removed' : 'error';
    }

    public function isFavorited($homeownerId, $cleanerId) {
        return $this->favorite->isFavorited($homeownerId, $cleanerId);
    }

    public function getFavoritesByHomeowner($homeownerId) {
        return $this->favorite->getFavoritesByHomeowner($homeownerId);
    }
	
	public function searchFavoritesByHomeowner($homeownerId, $keyword) {
		return $this->favorite->searchFavoritesByHomeowner($homeownerId, $keyword);
	}

}
?>
