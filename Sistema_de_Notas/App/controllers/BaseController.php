<?php
class BaseController {
    protected function view($viewName, $data = []) {
        extract($data);
        require_once "app/views/layouts/header.php";
        require_once "app/views/$viewName.php";
        require_once "app/views/layouts/footer.php";
    }
    
    protected function redirect($url) {
        header("Location: $url");
        exit();
    }
}
?>