<?php
class Router {
    public function route() {
        $controller = $_GET['controller'] ?? 'home';
        $action = $_GET['action'] ?? 'index';
        
        $controllerFile = "app/controllers/" . ucfirst($controller) . "Controller.php";
        
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controllerClass = ucfirst($controller) . "Controller";
            $controllerInstance = new $controllerClass();
            
            if (method_exists($controllerInstance, $action)) {
                $controllerInstance->$action();
            } else {
                $this->error404();
            }
        } else {
            $this->error404();
        }
    }
    
    private function error404() {
        header("HTTP/1.0 404 Not Found");
        echo "Página no encontrada";
    }
}
?>