<?php
require __DIR__ . '/../services/userservice.php';

class UserController
{
    private $userService;

    function __construct()
    {
        $this->userService = new UserService();
    }

    public function index()
    {
        $model = $this->userService->getAll();

        require __DIR__ . '/../views/user/index.php';
    }
    public function create()
    {
        //$model = $this->userService->getAll();

        require __DIR__ . '/../views/user/create.php';
    }
    public function edit()
    {
        //$model = $this->userService->getAll();

        require __DIR__ . '/../views/user/edit.php';
    }
    public function profile()
    {
        //$model = $this->userService->getAll();

        require __DIR__ . '/../views/user/profile.php';
    }
}
