<?php

abstract class AbstractController {
    
    protected $view;
    
    public function __construct($view) {
        $this->view = $view;
    }
    
    public function action404() {
        header('HTTP/1.1 404 Not Found');
        header('Status: 404 Not Found');
    }
    
    public function redirect($link) {
        header("Location: $link");
        exit;
    }
    
    abstract protected function render($str);
}

?>