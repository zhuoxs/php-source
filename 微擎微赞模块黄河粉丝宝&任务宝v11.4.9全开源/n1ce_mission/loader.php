<?php

if (!function_exists("yload")) {

  function yload() {
    static $loader;
    if(empty($loader)) {
      $loader = new YLoader();
    }
    return $loader;
  }

  class YLoader {
    private $cache = array();

    public function routing($mn, $name) {
      global $_W;
      if (isset($this->cache['routing'][$name])) {
        return true;
      }
      $file = IA_ROOT . '/addons/' . $mn . '/' . $name . '.routing.inc.php';
      if (file_exists($file)) {
        include $file;
        $this->cache['routing'][$name] = true;
        return true;
      } else {
        trigger_error('Invalid Routing File ' . $name . '.routing.inc.php. File Path:' . $file, E_USER_ERROR);
        return false;
      }
    }

    public function func($mn, $name) {
      global $_W;
      if (isset($this->cache['func'][$name])) {
        return true;
      }
      $file = IA_ROOT . '/addons/'. $mn . '/' . $name . '.func.inc.php';
      if (file_exists($file)) {
        include $file;
        $this->cache['func'][$name] = true;
        return true;
      } else {
        trigger_error('Invalid Function File ' . $name . '.func.inc.php. File Path:' . $file, E_USER_ERROR);
        return false;
      }
    }

    public function classs($mn, $name, $silence = false) {
      global $_W;
      if (isset($this->cache['class'][$name])) {
        return true;
      }
      $file = IA_ROOT . '/addons/' .$mn.'/'. $name . '.class.inc.php';
      if (file_exists($file)) {
        include $file;
        $this->cache['class'][$name] = true;
        return true;
      } else if ($silence == false) {
        debug_print_backtrace();
        trigger_error('Invalid Class ' . $name . '.class.inc.php. File Path:' . $file, E_USER_ERROR);
        return false;
      } else {
        return false;
      }
    }
  }
}

