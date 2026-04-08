<?php
require_once 'BaseController.php';

class HomeController extends BaseController {
    public function index() {
        $data = [
            'title' => 'Sistema de Notas - Inicio'
        ];
        $this->view('home/index', $data);
    }
}
?>