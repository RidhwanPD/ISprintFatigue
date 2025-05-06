<?php
require_once __DIR__ . '/../Entities/User.php';

class LoginController {
    private $user;

    public function __construct() 
	{
        $this->user = new User();
    }

    public function loginUser($email, $password) 
	{
        $user = $this->user->getByEmail($email);

        if ($user && $password === $user['password']) 
		{
            return $user;
        }

        return false;
    }
}
