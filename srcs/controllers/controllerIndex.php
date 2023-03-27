<?php

class Index {
    private $_user;
    private $_view;

    public function __construct($url) {
        $this->index();
    }

    private function index() {
        require_once('views/index.php');
    }
}