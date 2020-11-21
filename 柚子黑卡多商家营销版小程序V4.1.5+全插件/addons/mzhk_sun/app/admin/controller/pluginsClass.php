<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | Copyright (c) 柚子黑卡  All rights reserved.
// +----------------------------------------------------------------------
// | Author: 淡蓝海寓
// +----------------------------------------------------------------------

namespace app\admin\controller;


class pluginsClass extends BaseClass {
    private $urlarray = array("ctrl"=>"plugin");

    public function __construct(){ 
        parent::__construct();
        global $_W, $_GPC;
        $GLOBALS['frames'] = $this->getMainMenu();
    }


    /*插件应用列表*/
    public function plugin(){
        global $_W, $_GPC;

		//判断分销插件是否安装
		if(pdo_tableexists("mzhk_sun_distribution_set")){
			$distribution = 1;
		}

		//判断吃探插件是否安装
		if(pdo_tableexists("mzhk_sun_eatvisit_set")){
			$eatvisit = 1;
		}

		//判断积分插件是否安装
		if(pdo_tableexists("mzhk_sun_plugin_scoretask_system")){
			$scoretask = 1;
		}

		//判断服务商插件是否安装
		if(pdo_fieldexists('mzhk_sun_system',  'server_wxkey')){
			$service = 1;
		}

		//判断裂变券插件是否安装
		if(pdo_tableexists("mzhk_sun_distribution_fission_set")){
			$fission = 1;
		}

		//判断红包插件是否安装
		if(pdo_tableexists("mzhk_sun_redpacket_set")){
			$redpacket = 1;
		}

		//判断次卡插件是否安装
		if(pdo_tableexists("mzhk_sun_subcard_set")){
			$subcard = 1;
		}
		//判断权益插件是否安装
		if(pdo_tableexists("mzhk_sun_member_set")){
			$member = 1;
		}
		//判断套餐包插件是否安装
		if(pdo_tableexists("mzhk_sun_package_set")){
			$package = 1;
		}
		//判断抽奖插件是否安装
        if(pdo_tableexists("mzhk_sun_plugin_lottery_system")){

            $lottery = 1;
        }
		//判断公众号插件是否安装
        if(pdo_tableexists("mzhk_sun_wechat_set")){

            $wechat = 1;
        }
		//判断云店插件是否安装
        if(pdo_tableexists("mzhk_sun_cloud_set")){

            $cloud = 1;
        }
        include $this->template('web/plugin/pluginlist');
    }

	/*分销跳转*/
	public function todistribution(){
        global $_W, $_GPC;

		//判断分销插件是否安装
		if(pdo_tableexists("mzhk_sun_distribution_set")){
			$url = url('site/entry/distribution_set', array('m' => 'mzhk_sun_plugin_distribution'));
			$url = substr($url,2);
			$newurl = $_W['siteroot']."web/".$url;
			@header("location:".$newurl."");
		}else{
			message('请先安装黑卡分销插件','','error');
		}
    }

	/*吃探跳转*/
	public function toeatvisit(){
        global $_W, $_GPC;

		//判断吃探插件是否安装
		if(pdo_tableexists("mzhk_sun_eatvisit_set")){
			$url = url('site/entry/setting', array('m' => 'mzhk_sun_plugin_eatvisit'));
			$url = substr($url,2);
			$newurl = $_W['siteroot']."web/".$url;
			@header("location:".$newurl."");
		}else{
			message('请先安装黑卡吃探插件','','error');
		}
    }

	/*积分跳转*/
	public function toscoretask(){
        global $_W, $_GPC;

		//判断积分插件是否安装
		if(pdo_tableexists("mzhk_sun_plugin_scoretask_system")){
			$url = url('site/entry/index', array('m' => 'mzhk_sun_plugin_scoretask'));
			$url = substr($url,2);
			$newurl = $_W['siteroot']."web/".$url;
			@header("location:".$newurl."");
		}else{
			message('请先安装黑卡积分任务宝','','error');
		}
    }

	/*服务商跳转*/
	public function toservice(){
        global $_W, $_GPC;

		//判断服务商插件是否安装
		if(pdo_fieldexists('mzhk_sun_system',  'server_wxkey')){
			$url = url('site/entry/serverset', array('m' => 'mzhk_sun_plugin_service'));
			$url = substr($url,2);
			$newurl = $_W['siteroot']."web/".$url;
			@header("location:".$newurl."");
		}else{
			message('请先安装黑卡服务商','','error');
		}
    }

	/*裂变券跳转*/
	public function tofission(){
        global $_W, $_GPC;

		//判断裂变券插件是否安装
		if(pdo_tableexists("mzhk_sun_distribution_fission_set")){
			$url = url('site/entry/fission_set', array('m' => 'mzhk_sun_plugin_fission'));
			$url = substr($url,2);
			$newurl = $_W['siteroot']."web/".$url;
			@header("location:".$newurl."");
		}else{
			message('请先安装黑卡裂变券插件','','error');
		}
    }

	/*红包跳转*/
	public function toredpacket(){
        global $_W, $_GPC;

		//判断红包插件是否安装
		if(pdo_tableexists("mzhk_sun_redpacket_set")){
			$url = url('site/entry/redpacket_set', array('m' => 'mzhk_sun_plugin_redpacket'));
			$url = substr($url,2);
			$newurl = $_W['siteroot']."web/".$url;
			@header("location:".$newurl."");
		}else{
			message('请先安装黑卡红包插件','','error');
		}
    }

	/*次卡跳转*/
	public function tosubcard(){
        global $_W, $_GPC;

		//判断红包插件是否安装
		if(pdo_tableexists("mzhk_sun_subcard_set")){
			$url = url('site/entry/SubcardSet', array('m' => 'mzhk_sun_plugin_subcard'));
			$url = substr($url,2);
			$newurl = $_W['siteroot']."web/".$url;
			@header("location:".$newurl."");
		}else{
			message('请先安装黑卡次卡插件','','error');
		}
    }
    /*权益跳转*/
	public function tomember(){
        global $_W, $_GPC;

		//判断红包插件是否安装
		if(pdo_tableexists("mzhk_sun_member_set")){
			$url = url('site/entry/setting', array('m' => 'mzhk_sun_plugin_member'));
			$url = substr($url,2);
			$newurl = $_W['siteroot']."web/".$url;
			@header("location:".$newurl."");
		}else{
			message('请先安装黑卡权益插件','','error');
		}
    }
    /*套餐包跳转*/
	public function topackage(){
        global $_W, $_GPC;

		//判断红包插件是否安装
		if(pdo_tableexists("mzhk_sun_package_set")){
			$url = url('site/entry/setting', array('m' => 'mzhk_sun_plugin_package'));
			$url = substr($url,2);
			$newurl = $_W['siteroot']."web/".$url;
			@header("location:".$newurl."");
		}else{
			message('请先安装黑卡套餐包插件','','error');
		}
    }
    /*抽奖跳转*/
	public function tolottery(){
        global $_W, $_GPC;

		//判断红包插件是否安装
		if(pdo_tableexists("mzhk_sun_plugin_lottery_system")){
			$url = url('site/entry/index', array('m' => 'mzhk_sun_plugin_lottery'));
			$url = substr($url,2);
			$newurl = $_W['siteroot']."web/".$url;
			@header("location:".$newurl."");
		}else{
			message('请先安装黑卡大抽奖插件','','error');
		}
    }
	/*公众号跳转*/
	public function towechatlink(){
        global $_W, $_GPC;

		//判断红包插件是否安装
		if(pdo_tableexists("mzhk_sun_wechat_set")){
			$url = url('site/entry/serverset', array('m' => 'mzhk_sun_plugin_wechatlink'));
			$url = substr($url,2);
			$newurl = $_W['siteroot']."web/".$url;
			@header("location:".$newurl."");
		}else{
			message('请先安装黑卡公众号插件','','error');
		}
    }
	/*云店跳转*/
	public function tocloudlink(){
        global $_W, $_GPC;

		//判断红包插件是否安装
		if(pdo_tableexists("mzhk_sun_cloud_set")){
			$url = url('site/entry/cloud_set', array('m' => 'mzhk_sun_plugin_cloud'));
			$url = substr($url,2);
			$newurl = $_W['siteroot']."web/".$url;
			@header("location:".$newurl."");
		}else{
			message('请先安装黑卡云店插件','','error');
		}
    }

	

}