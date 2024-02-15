<?php
include __DIR__ . '/../services/userservice.php';

class LoginController
{
    private $userService;

    function __construct()
    {
        $this->userService = new UserService();
    }

    public function index()
    {
        //$model = $this->userService->getAll();

        require __DIR__ . '/../views/login/index.php';
    }

    public function logout()
    {
        session_start();
        session_destroy();
        //header("Location: /login");
    }

    public function login()
    {



        echo 'Login controller method called';

        $username = $_POST['username'];
        $password = $_POST['password'];

        $errors = $this->userService->validateLogin($username, $password);

        if (!empty($errors)) {
            // Return the errors to the view
            return $errors;
        }

        $user = $this->userService->login($username, $password);

        // Start a session and redirect the user to the dashboard
        session_start();
        $_SESSION['user'] = $user;
        header('Location: /home');
        require __DIR__ . '/../views/login/index.php';
        /*
        $username = $_POST['username'];
        $password = $_POST['password'];

        // check if email and password match with any record in the user table

        $user = $this->userService->validateLogin($username, $password);
        if ($user) {
            session_start();
            $_SESSION['logged_in'] = true;
            header('Location: /home');
        } else {
            // return error message
            echo "Invalid username or password";
        }
        */
    }

    public function register()
    {
        $user = new User($_POST);

        $errors = $this->userService->validate($user);

        if (!empty($errors)) {
            // Return the errors to the view
            return $errors;
        }

        $this->userService->register($user);

        // Redirect the user to the login page
        header('Location: /login');
    }
}
