<?php

if (!defined("IN_IA")) {
    exit("Access Denied");
}
class PluginPfMobilePage extends Page
{
    public $model = NULL;
    public $set = NULL;
    public function __construct()
    {
        m("shop")->checkClose();
        $this->model = m("plugin")->loadModel($GLOBALS["_W"]["plugin"]);
        $this->set = $this->model->getSet();
    }
    public function getSet()
    {
        return $this->set;
    }
}

?>