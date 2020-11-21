<?php

defined('IN_IA') or exit('Access Denied');

class Question_anModule extends WeModule {

    public function welcomeDisplay() {
        header('location: ' . $this->createWebUrl('index'));
        exit;
    }

}
