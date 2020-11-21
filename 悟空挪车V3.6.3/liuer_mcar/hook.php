<?php
/**
 * hook.php
 * @authors
 */
require_once 'common/Table.php';
require_once 'common/function.php';

class Liuer_mcarModuleHook extends WeModuleHook{

    public function hookWebCodelog(){


    }

    public function hookWebAgent(){
        $settings = get_module_info();
        $agent_setting = isset($settings['agent_setting']) ? $settings['agent_setting'] : 0;
        return $agent_setting;
    }

    public function hookWebCategory(){
        $settings = get_module_info();
        $agent_setting = isset($settings['agent_category']) ? $settings['agent_category'] : 0;
        return $agent_setting;
    }

    //获取代理商信息
    public function hookWebAgentById($id){
        global $_W;
        $agentInfo = pdo_get(Table::AGENT,['id'=>$id]);
        return $agentInfo;
    }

}