<?php
 namespace app\boguan\controller\platform; use think\Controller; class Common extends Controller { public function notAuth() { return $this->fetch(); } }