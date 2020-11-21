<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/8 0008
 * Time: 17:49
 */
$sql = <<<EOF
DROP TABLE IF EXISTS `ims_cqkundian_farm_plugin_play_friend`;
DROP TABLE IF EXISTS `ims_cqkundian_farm_plugin_play_land_opeartion`;
DROP TABLE IF EXISTS `ims_cqkundian_farm_plugin_play_set`;
DROP TABLE IF EXISTS `ims_cqkundian_farm_plugin_play_visit`;
DROP TABLE IF EXISTS `ims_cqkundian_farm_plugin_play_shed_upgrade`;
EOF;
pdo_run($sql);

