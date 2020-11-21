<?php
 namespace app\boguan\controller\platform; use app\boguan\controller\Platform; class Market extends Platform { public function index() { return $this->fetch(); } }