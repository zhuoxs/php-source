<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/19 0019
 * Time: 12:32
 */

$sql = <<<EOF

EOF;
pdo_run($sql);
if(!pdo_fieldexists('cqkundian_farm_plugin_funding_project', 'fund_fictitious_money')) {
    pdo_query("ALTER TABLE ".tablename('cqkundian_farm_plugin_funding_project')." ADD `fund_fictitious_money` float NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('cqkundian_farm_plugin_funding_project', 'fictitious_person')) {
    pdo_query("ALTER TABLE ".tablename('cqkundian_farm_plugin_funding_project')." ADD `fictitious_person` int(11) NOT NULL DEFAULT '0';");
}
