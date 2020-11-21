<?php
$act = isset(self::$_GPC["act"])?self::$_GPC["act"]:"display";
$plugin = self::$_GPC['plugin'];
return include self::template("web/Appcenter/".$plugin."/".self::$_GPC['op']."/".$act);