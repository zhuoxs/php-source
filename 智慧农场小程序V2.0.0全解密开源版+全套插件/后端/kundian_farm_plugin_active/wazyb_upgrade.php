<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/19 0019
 * Time: 12:32
 */

$sql = <<<EOF
ALTER TABLE `ims_cqkundian_farm_plugin_active` ADD `add_info` text NOT NULL COMMENT '报名信息';
ALTER TABLE `ims_cqkundian_farm_plugin_active` ADD `times_enroll` TINYINT(1) NOT NULL COMMENT '是否允许多次报名 1 是 0 否';
EOF;
pdo_run($sql);

if(!pdo_fieldexists('cqkundian_farm_plugin_active', 'add_info')) {
    pdo_query("ALTER TABLE ".tablename('cqkundian_farm_plugin_active')." ADD `add_info` text NOT NULL DEFAULT '';");
}
if(!pdo_fieldexists('cqkundian_farm_plugin_active', 'times_enroll')) {
    pdo_query("ALTER TABLE ".tablename('cqkundian_farm_plugin_active')." ADD `times_enroll` TINYINT(1) NOT NULL DEFAULT '0';");
}

