<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/8 0008
 * Time: 17:49
 */
$sql = <<<EOF
DROP TABLE IF EXISTS `ims_cqkundian_farm_plugin_funding_order`;
DROP TABLE IF EXISTS `ims_cqkundian_farm_plugin_funding_progress`;
DROP TABLE IF EXISTS `ims_cqkundian_farm_plugin_funding_project`;
DROP TABLE IF EXISTS `ims_cqkundian_farm_plugin_funding_project_spec`;
DROP TABLE IF EXISTS `ims_cqkundian_farm_plugin_funding_set`;

EOF;
pdo_run($sql);

