<?php 
	function foodAutoLoad($classname){
		$file = IA_ROOT.'/addons/zofui_posterhelp/class/'.$classname.'.class.php';
		if(file_exists($file)){
			require_once ($file);
		}
	}
	spl_autoload_register('foodAutoLoad');

	class Data {

		static function webMenu(){
			global $_W,$_GPC;

			if( function_exists( 'buildframes' ) ){
				$myframes = buildframes('account');
				$seturl = $myframes['section']['platform_module_common']['menu']['platform_module_settings']['url'];
			}
			if( empty( $seturl ) ) $seturl = $_W['siteroot'].'web/index.php?c=profile&a=module&do=setting&op=set&m=zofui_posterhelp';
			
		  	return array(
		  		'setting' => array(
		  			'name' => '参数设置',
		  			'icon' => 'https://res.wx.qq.com/mpres/htmledition/images/icon/menu/icon_menu_setup.png',
		  			'list'=>array(
		  				array('op'=>'set','name'=>'参数设置','url'=>$seturl),
		  			),
		  			'toplist' => array('set')
		  			//'url' => $seturl,
		  		),
		  		'data' => array(
		  			'name' => '数据信息',
		  			'icon' => 'https://res.wx.qq.com/mpres/htmledition/images/icon/menu/icon_menu_statistics.png',
		  			'list'=>array(
		  				array('op'=>'helplog','name'=>'赠送记录','url'=>Util::webUrl('data',array('op'=>'helplog','actid'=>$_GPC['actid']))),
		  				array('op'=>'getlog','name'=>'兑奖记录','url'=>Util::webUrl('data',array('op'=>'getlog','actid'=>$_GPC['actid']))),
		  				array('op'=>'waitpay','name'=>'待发红包','url'=>Util::webUrl('data',array('op'=>'waitpay','actid'=>$_GPC['actid']))),
		  				array('op'=>'user','name'=>'会员列表','url'=>Util::webUrl('data',array('op'=>'user','actid'=>$_GPC['actid']))),
		  				array('op'=>'tel','name'=>'姓名电话','url'=>Util::webUrl('data',array('op'=>'tel','actid'=>$_GPC['actid']))),
		  			),
		  			'toplist' => array('helplog','getlog','user','tel','waitpay'),
		  			'ishide' => 1,
		  		),
		  		'custom' => array(
		  			'name' => '设置活动',
		  			'icon' => 'https://res.wx.qq.com/mpres/htmledition/images/icon/menu/icon_menu_statistics.png',
		  			'ishide' => 1,
		  		),
		  		'key' => array(
		  			'name' => '活动入口和关键词',
		  			'icon' => 'https://res.wx.qq.com/mpres/htmledition/images/icon/menu/icon_menu_statistics.png',
		  			'ishide' => 1,
		  		),		  		
		  		'act' => array(
		  			'name'=>'活动管理',
		  			'icon' => 'https://res.wx.qq.com/mpres/htmledition/images/icon/menu/icon_menu_management.png',
		  			'list'=>array(
		  				array('op'=>'create','name'=>'添加活动','url'=>Util::webUrl('act',array('op'=>'create'))),
		  				array('op'=>'list','name'=>'活动列表','url'=>Util::webUrl('act',array('op'=>'list')))
		  			),
		  			'toplist' => array('create','list')
		  		),

		  		'explain' => array(
		  			'name'=>'模块使用说明',
		  			'icon' => 'https://res.wx.qq.com/mpres/htmledition/images/icon/menu/icon_menu_ad.png',
		  			'url' => Util::webUrl('explain')
		  		),
		  	);
		}
		

	}


	class topbal
	{
		

		static function helplogList(){
			global $_W,$_GPC;

			return array(
				'search' => array(
					array(
						'do' => 'data',
						'op' => 'helplog',
						'placeholder' => '输入被赠送者昵称',
					)
				)
			);
		}
		static function getlogList(){
			global $_W,$_GPC;

			return array(
				'status' => array(
					array('value'=>'','name'=>'兑奖状态','url'=>WebCommon::logUrl('status','')),
					array('value'=>2,'name'=>'已领奖','url'=>WebCommon::logUrl('status','2')),
					array('value'=>1,'name'=>'待领奖','url'=>WebCommon::logUrl('status','1'))
				),
				'search' => array(
					array(
						'do' => 'data',
						'op' => 'getlog',
						'search' => 'nick',
						'placeholder' => '输入兑奖者昵称',
					),
					array(
						'do' => 'data',
						'op' => 'getlog',
						'search' => 'code',
						'placeholder' => '输入兑奖编码',
					),					
				),
			);
		}


		static function userList(){
			global $_W;

			return array(
				'status' => array(
					array('value'=>'','name'=>'会员状态','url'=>WebCommon::logUrl('status','')),
					array('value'=>1,'name'=>'黑名单','url'=>WebCommon::logUrl('status','2')),
					array('value'=>2,'name'=>'正常','url'=>WebCommon::logUrl('status','1'))
				),
				'order' => array(
					array('value'=>'','name'=>'最新排序','url'=>WebCommon::logUrl('order','')),
					array('value'=>1,'name'=>'积分排序','url'=>WebCommon::logUrl('order','1')),
				),

				'search' => array(
					array(
						'do' => 'data',
						'op' => 'user',
						'placeholder' => '输入会员昵称',
					)
				)
			);
		}




	}
