<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/8 0008
 * Time: 17:49
 */
$sql = <<<EOF
DROP TABLE IF EXISTS `ims_cqkundian_farm_plugin_active`;
DROP TABLE IF EXISTS `ims_cqkundian_farm_plugin_active_order`;
DROP TABLE IF EXISTS `ims_cqkundian_farm_plugin_active_set`;
DROP TABLE IF EXISTS `ims_cqkundian_farm_plugin_active_spec`;

EOF;
pdo_run($sql);

