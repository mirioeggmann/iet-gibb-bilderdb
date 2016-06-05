<?php
class ErrorController
{
    public function index() {
        $view = new View('errors/404');
        $view->display();
    }
}