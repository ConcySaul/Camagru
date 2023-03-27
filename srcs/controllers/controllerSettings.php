<?php

class Settings {
    private $_user;
    private $_view;

    public function __construct($url) {
        $this->settings();
    }

    private function settings() {
        require_once('views/settings.php');
    }
}