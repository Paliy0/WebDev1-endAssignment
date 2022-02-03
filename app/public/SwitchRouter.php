<?php
class SwitchRouter {
    public function route($uri) {
        switch ($uri) {
            case '':
                require __DIR__ . '/controller/homeController.php';
                $controller = new homeController();
                $controller->index();
                break;

            case 'about':
                require __DIR__ . '/controller/homeController.php';
                $controller = new homeController();
                $controller->about();
                break;
            
            default:
                echo"Not found";
                http_response_code(404);
                break;
        }
    }
}