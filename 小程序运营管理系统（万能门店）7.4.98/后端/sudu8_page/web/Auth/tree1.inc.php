<?php
$act = isset(self::$_GPC["act"])?self::$_GPC["act"]:"display";

return include self::template("web/Auth/tree1");