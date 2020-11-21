<?php
defined('IN_IA') or exit('Access Denied');

class Menus_sys extends Menus {

    public static function __callStatic($method, $arg) {
        global $_W, $_GPC;
        $config = App::ext_plugin_config($_W['plugin']);
        if (empty($config['menus']) || $config['setting']['system'] != 'true') {
            wl_message('您访问的应用不存在，请重试！');
        }
        return $config['menus'];
    }

    /**
     * static function 顶部列表
     *
     * @access static
     * @name topmenus
     * @param
     * @return array
     */
    static function topmenus() {
        global $_W;
        $frames = array();
        $appact = Util::traversingFiles(PATH_PLUGIN);
        $appact[] = 'app';

        $frames['dashboard']['title'] = '<i class="fa fa-desktop"></i>&nbsp;&nbsp; 首页';
        $frames['dashboard']['url'] = web_url('dashboard/dashboard');
        $frames['dashboard']['active'] = 'dashboard';

        $frames['member']['title'] = '<i class="fa fa-user"></i>&nbsp;&nbsp; 客户';
        $frames['member']['url'] = web_url('member/wlMember/index');
        $frames['member']['active'] = 'member';

		$frames['store']['title'] = '<i class="fa fa-users"></i>&nbsp;&nbsp; 商户';
		$frames['store']['url'] = web_url('store/merchant/index',array('enabled'=>''));
		$frames['store']['active'] = 'store';

        $frames['order']['title'] = '<i class="fa fa-list"></i>&nbsp;&nbsp; 订单';
        $frames['order']['url'] = web_url('order/wlOrder/orderlist');
        $frames['order']['active'] = 'order';

        if (p('area')) {
            $frames['area']['title'] = '<i class="fa fa-map"></i>&nbsp;&nbsp; 代理';
            $frames['area']['url'] = web_url('area/areaagent/agentIndex');
            $frames['area']['active'] = 'area';
        }

        $frames['finance']['title'] = '<i class="fa fa-money"></i>&nbsp;&nbsp; 财务';
        $frames['finance']['url'] = web_url('finace/newCash/cashrecord');
        $frames['finance']['active'] = 'finace';

        $frames['data']['title'] = '<i class="fa fa-bar-chart"></i>&nbsp;&nbsp; 数据';
        $frames['data']['url'] = web_url('datacenter/datacenter/stat_operate');
        $frames['data']['active'] = 'datacenter';

        $frames['app']['title'] = '<i class="fa fa-cubes"></i>&nbsp;&nbsp; 应用';
        $frames['app']['url'] = web_url('app/plugins');
        $frames['app']['active'] = array_merge(array_diff($appact, array('area')));

        $frames['setting']['title'] = '<i class="fa fa-gear"></i>&nbsp;&nbsp; 设置';
        $frames['setting']['url'] = web_url('setting/shopset/base');
        $frames['setting']['active'] = 'setting';

        if ($_W['isfounder']) {
            $frames['cloud']['title'] = '<i class="fa fa-cloud"></i>&nbsp;&nbsp; 云服务';
            $frames['cloud']['url'] = web_url('cloud/plugin/index');
            $frames['cloud']['active'] = 'cloud';
        }
        return $frames;
    }

    static function getdashboardFrames() {
        global $_W;
        $frames = array();
        $frames['member']['title'] = '<i class="fa fa-dashboard"></i>&nbsp;&nbsp; 概况';
        $frames['member']['items'] = array();

        $frames['member']['items']['setting']['url'] = web_url('dashboard/dashboard/index');
        $frames['member']['items']['setting']['title'] = '运营概况';
        $frames['member']['items']['setting']['actions'] = array('ac', 'dashboard');
        $frames['member']['items']['setting']['active'] = '';

        $frames['page']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 主页管理';
        $frames['page']['items'] = array();
        $frames['page']['items']['notice']['url'] = web_url('dashboard/notice/index');
        $frames['page']['items']['notice']['title'] = '公告';
        $frames['page']['items']['notice']['actions'] = array('ac', 'notice');
        $frames['page']['items']['notice']['active'] = '';

        $frames['page']['items']['adv']['url'] = web_url('dashboard/adv/index');
        $frames['page']['items']['adv']['title'] = '幻灯片';
        $frames['page']['items']['adv']['actions'] = array('ac', 'adv');
        $frames['page']['items']['adv']['active'] = '';

        $frames['page']['items']['nav']['url'] = web_url('dashboard/nav/index');
        $frames['page']['items']['nav']['title'] = '导航栏';
        $frames['page']['items']['nav']['actions'] = array('ac', 'nav');
        $frames['page']['items']['nav']['active'] = '';

        $frames['page']['items']['banner']['url'] = web_url('dashboard/banner/index');
        $frames['page']['items']['banner']['title'] = '广告栏';
        $frames['page']['items']['banner']['actions'] = array('ac', 'banner');
        $frames['page']['items']['banner']['active'] = '';

        $frames['page']['items']['cube']['url'] = web_url('dashboard/cube/index');
        $frames['page']['items']['cube']['title'] = '商品魔方';
        $frames['page']['items']['cube']['actions'] = array('ac', 'cube');
        $frames['page']['items']['cube']['active'] = '';

//		$frames['page']['items']['sort']['url'] = web_url('dashboard/sort/index');
//		$frames['page']['items']['sort']['title'] = '主页排版';
//		$frames['page']['items']['sort']['actions'] = array();
//		$frames['page']['items']['sort']['active'] = '';

        $frames['page']['items']['plugin']['url'] = web_url('dashboard/plugin/index');
        $frames['page']['items']['plugin']['title'] = '选项卡管理';
        $frames['page']['items']['plugin']['actions'] = array('ac', 'plugin');
        $frames['page']['items']['plugin']['active'] = '';

        $frames['page']['items']['foot']['url'] = web_url('dashboard/foot/index');
        $frames['page']['items']['foot']['title'] = '底部菜单';
        $frames['page']['items']['foot']['actions'] = array('ac', 'foot');
        $frames['page']['items']['foot']['active'] = '';

        return $frames;
    }

    /**
     * static function 客户左侧列表
     *
     * @access static
     * @name getmemberFrames
     * @param
     * @return array
     */
    static function getmemberFrames() {
        global $_W;
        $frames = array();
        $frames['user']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 客户';
        $frames['user']['items'] = array();

        $frames['user']['items']['register']['url'] = web_url('member/wlMember/index');
        $frames['user']['items']['register']['title'] = '客户概况';
        $frames['user']['items']['register']['actions'] = array('ac', 'wlMember', 'do', 'index');
        $frames['user']['items']['register']['active'] = '';

        $frames['user']['items']['notice']['url'] = web_url('member/wlMember/memberIndex');
        $frames['user']['items']['notice']['title'] = '客户列表';
        $frames['user']['items']['notice']['actions'] = array('ac', 'wlMember', 'do', array('memberIndex', 'memberDetail'));
        $frames['user']['items']['notice']['active'] = '';

        if (p('userlabel')) {
            $frames['userlabel']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 标签';
            $frames['userlabel']['items'] = array();

            $frames['userlabel']['items']['labellist']['url'] = web_url('userlabel/labeladmin/labellist');
            $frames['userlabel']['items']['labellist']['title'] = '客户标签';
            $frames['userlabel']['items']['labellist']['actions'] = array();
            $frames['userlabel']['items']['labellist']['active'] = '';

            $frames['userlabel']['items']['labelrecord']['url'] = web_url('userlabel/statistics/labelrecord');
            $frames['userlabel']['items']['labelrecord']['title'] = '标签记录';
            $frames['userlabel']['items']['labelrecord']['actions'] = array();
            $frames['userlabel']['items']['labelrecord']['active'] = '';
        }

        $frames['current']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 财务';
        $frames['current']['items'] = array();

        $frames['current']['items']['recharge']['url'] = web_url('member/wlMember/recharge');
        $frames['current']['items']['recharge']['title'] = '充值明细';
        $frames['current']['items']['recharge']['actions'] = array('ac', 'wlMember', 'do', 'recharge');
        $frames['current']['items']['recharge']['active'] = '';

        $frames['current']['items']['integral']['url'] = web_url('member/wlMember/integral');
        $frames['current']['items']['integral']['title'] = '积分明细';
        $frames['current']['items']['integral']['actions'] = array('ac', 'wlMember', 'do', 'integral');
        $frames['current']['items']['integral']['active'] = '';

        $frames['current']['items']['balance']['url'] = web_url('member/wlMember/balance');
        $frames['current']['items']['balance']['title'] = '余额明细';
        $frames['current']['items']['balance']['actions'] = array('ac', 'wlMember', 'do', 'balance');
        $frames['current']['items']['balance']['active'] = '';

        return $frames;
    }

    static function getstoreFrames() {
        global $_W, $_GPC;
        $frames = array();

        $frames['user']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 商户管理';
        $frames['user']['items'] = array();
        $frames['user']['items']['index']['url'] = web_url('store/merchant/index', array('enabled' => ''));
        $frames['user']['items']['index']['title'] = '商户列表';
        $frames['user']['items']['index']['actions'] = array('ac', 'merchant', 'do', 'index');
        $frames['user']['items']['index']['active'] = '';

        $frames['user']['items']['edit']['url'] = web_url('store/merchant/edit');
        $frames['user']['items']['edit']['title'] = !empty($_GPC['id']) ? '编辑商户' : '添加商户';
        $frames['user']['items']['edit']['actions'] = array('ac', 'merchant', 'do', 'edit');
        $frames['user']['items']['edit']['active'] = '';

        $frames['register']['title'] = '<i class="fa fa-globe"></i>&nbsp;&nbsp; 入驻管理';
        $frames['register']['items'] = array();
        $frames['register']['items']['register']['url'] = web_url('store/register/index');
        $frames['register']['items']['register']['title'] = '入驻申请';
        $frames['register']['items']['register']['actions'] = array('ac', 'register', 'do', 'index');
        $frames['register']['items']['register']['active'] = '';

//		$frames['register']['items']['setting']['url'] = web_url('store/register/set');
//		$frames['register']['items']['setting']['title'] = '入驻设置';
//		$frames['register']['items']['setting']['actions'] = array('ac','register','do','set');
//		$frames['register']['items']['setting']['active'] = '';

        $frames['group']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 商户类别';
        $frames['group']['items'] = array();
        $frames['group']['items']['group']['url'] = web_url('store/group/index');
        $frames['group']['items']['group']['title'] = '商户分组';
        $frames['group']['items']['group']['actions'] = array('ac', 'group');
        $frames['group']['items']['group']['active'] = '';

        $frames['group']['items']['category']['url'] = web_url('store/category/index');
        $frames['group']['items']['category']['title'] = '商户分类';
        $frames['group']['items']['category']['actions'] = array('ac', 'category');
        $frames['group']['items']['category']['active'] = '';

        $frames['comment']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 评论与动态';
        $frames['comment']['items'] = array();
        $frames['comment']['items']['comment']['url'] = web_url('store/comment/index');
        $frames['comment']['items']['comment']['title'] = '全部评论';
        $frames['comment']['items']['comment']['actions'] = array('ac', 'comment', 'do', 'index');
        $frames['comment']['items']['comment']['active'] = '';

        $frames['comment']['items']['dynamic']['url'] = web_url('store/comment/dynamic');
        $frames['comment']['items']['dynamic']['title'] = '商户动态';
        $frames['comment']['items']['dynamic']['actions'] = array('ac', 'comment', 'do', 'dynamic');
        $frames['comment']['items']['dynamic']['active'] = '';

        $frames['setting']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 商户设置';
        $frames['setting']['items'] = array();
        $frames['setting']['items']['setting']['url'] = web_url('store/comment/storeSet');
        $frames['setting']['items']['setting']['title'] = '基本设置';
        $frames['setting']['items']['setting']['actions'] = array('ac', 'comment', 'do', 'index');
        $frames['setting']['items']['setting']['active'] = '';

        return $frames;
    }

    /**
     * static function 订单左侧列表
     *
     * @access static
     * @name getorderFrames
     * @param
     * @return array
     */
    static function getorderFrames() {
        global $_W;
        $frames = array();
        $frames['order']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 订单';
        $frames['order']['items'] = array();

        $frames['order']['items']['orderlist']['url'] = web_url('order/wlOrder/orderlist');
        $frames['order']['items']['orderlist']['title'] = '商品订单';
        $frames['order']['items']['orderlist']['actions'] = array('ac', 'wlOrder', 'do', array('orderlist', 'orderdetail'));
        $frames['order']['items']['orderlist']['active'] = '';

        $frames['order']['items']['payonlinelist']['url'] = web_url('order/wlOrder/payonlinelist');
        $frames['order']['items']['payonlinelist']['title'] = '在线买单';
        $frames['order']['items']['payonlinelist']['actions'] = array('ac', 'wlOrder', 'do', 'payonlinelist');
        $frames['order']['items']['payonlinelist']['active'] = '';

        $frames['order']['items']['orderset']['url'] = web_url('order/wlOrder/orderset');
        $frames['order']['items']['orderset']['title'] = '订单设置';
        $frames['order']['items']['orderset']['actions'] = array('ac', 'wlOrder', 'do', 'orderset');
        $frames['order']['items']['orderset']['active'] = '';

        $frames['freight']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 运费';
        $frames['freight']['items'] = array();

        $frames['freight']['items']['freightlist']['url'] = web_url('order/wlOrder/freightlist');
        $frames['freight']['items']['freightlist']['title'] = '运费模板';
        $frames['freight']['items']['freightlist']['actions'] = array('ac', 'wlOrder', 'do', 'freightlist');
        $frames['freight']['items']['freightlist']['active'] = '';


        return $frames;
    }

    /**
     * static function 区域左侧列表
     *
     * @access static
     * @name getareaFrames
     * @param
     * @return array
     */
//	static function getareaFrames(){
//		global $_W;
//		$frames = array();
//		
//		$frames['user']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 代理列表';
//		$frames['user']['items'] = array();
//		$frames['user']['items']['notice']['url'] = web_url('area/areaagent/agentIndex');
//		$frames['user']['items']['notice']['title'] = '代理列表';
//		$frames['user']['items']['notice']['actions'] = array('ac','areaagent','do',array('agentIndex','agentEdit'));
//		$frames['user']['items']['notice']['active'] = '';
//		
//		$frames['user']['items']['adv']['url'] = web_url('area/areaagent/groupIndex');
//		$frames['user']['items']['adv']['title'] = '代理分组';
//		$frames['user']['items']['adv']['actions'] = array('ac','areaagent','do',array('groupIndex','groupEdit'));
//		$frames['user']['items']['adv']['active'] = '';
//		
//		$frames['selfarea']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 地区管理';
//		$frames['selfarea']['items'] = array();
//		$frames['selfarea']['items']['notice']['url'] = web_url('area/hotarea/index');
//		$frames['selfarea']['items']['notice']['title'] = '地区列表';
//		$frames['selfarea']['items']['notice']['actions'] = array('ac','hotarea','do','index');
//		$frames['selfarea']['items']['notice']['active'] = '';
//		
//		$frames['selfarea']['items']['group']['url'] = web_url('area/hotarea/group');
//		$frames['selfarea']['items']['group']['title'] = '地区分组';
//		$frames['selfarea']['items']['group']['actions'] = array('ac','hotarea','do',array('group','groupedit'));
//		$frames['selfarea']['items']['group']['active'] = '';
//		
//		$frames['selfarea']['items']['custom']['url'] = web_url('area/custom/index');
//		$frames['selfarea']['items']['custom']['title'] = '自定义地区';
//		$frames['selfarea']['items']['custom']['actions'] = array('ac','custom');
//		$frames['selfarea']['items']['custom']['active'] = '';
//		
//		$frames['agentcover']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 入口设置';
//		$frames['agentcover']['items'] = array();
//		$frames['agentcover']['items']['notice']['url'] = web_url('area/areaagent/agentCover');
//		$frames['agentcover']['items']['notice']['title'] = '代理入口';
//		$frames['agentcover']['items']['notice']['actions'] = array('ac','areaagent','do','agentCover');
//		$frames['agentcover']['items']['notice']['active'] = '';
//		
//		return $frames;
//	}

    /**
     * 设置左侧列表
     *
     * @access public
     * @name 方法名称
     * @param mixed  参数一的说明
     * @return array
     */
    static function getfinaceFrames() {
        global $_W, $_GPC;
        $frames = array();
        $frames['cashSurvey']['title'] = '<i class="fa fa-database"></i>&nbsp;&nbsp; 财务概况';
        $frames['cashSurvey']['items'] = array();

//		$frames['cashSurvey']['items']['datemana']['url'] = web_url('finace/wlCash/cashSurvey');
//		$frames['cashSurvey']['items']['datemana']['title'] = '财务概况';
//		$frames['cashSurvey']['items']['datemana']['actions'] = array();
//		$frames['cashSurvey']['items']['datemana']['active'] = '';

        $frames['cashSurvey']['items']['cashrecord']['url'] = web_url('finace/newCash/cashrecord');
        $frames['cashSurvey']['items']['cashrecord']['title'] = '账单明细';
        $frames['cashSurvey']['items']['cashrecord']['actions'] = array();
        $frames['cashSurvey']['items']['cashrecord']['active'] = '';

        $frames['cashSurvey']['items']['refundrecord']['url'] = web_url('finace/newCash/refundrecord');
        $frames['cashSurvey']['items']['refundrecord']['title'] = '退款记录';
        $frames['cashSurvey']['items']['refundrecord']['actions'] = array();
        $frames['cashSurvey']['items']['refundrecord']['active'] = '';

        $frames['current']['title'] = '<i class="fa fa-globe"></i>&nbsp;&nbsp; 账户';
        $frames['current']['items'] = array();

        $frames['current']['items']['currentstore']['url'] = web_url('finace/newCash/currentlist', array('type' => 'store'));
        $frames['current']['items']['currentstore']['title'] = '商家账户';
        $frames['current']['items']['currentstore']['actions'] = array('type', 'store');
        $frames['current']['items']['currentstore']['active'] = '';

        $frames['current']['items']['currentmy']['url'] = web_url('finace/newCash/currentlist', array('type' => 'agent'));
        $frames['current']['items']['currentmy']['title'] = '代理账户';
        $frames['current']['items']['currentmy']['actions'] = array('type', 'agent');
        $frames['current']['items']['currentmy']['active'] = '';

        $frames['cashApply']['title'] = '<i class="fa fa-globe"></i>&nbsp;&nbsp; 提现';
        $frames['cashApply']['items'] = array();

        $frames['cashApply']['items']['display1']['url'] = web_url('finace/wlCash/cashApply');
        $frames['cashApply']['items']['display1']['title'] = '提现申请';
        $frames['cashApply']['items']['display1']['actions'] = array();
        $frames['cashApply']['items']['display1']['active'] = '';

        $frames['cashApply']['items']['cashset']['url'] = web_url('finace/wlCash/cashset');
        $frames['cashApply']['items']['cashset']['title'] = '结算设置';
        $frames['cashApply']['items']['cashset']['actions'] = array();
        $frames['cashApply']['items']['cashset']['active'] = '';

        return $frames;
    }

    static function getdatacenterFrames() {
        global $_W;
        $frames = array();

        $frames['datacenter']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 统计分析';
        $frames['datacenter']['items'] = array();

        $frames['datacenter']['items']['stat_operate']['url'] = web_url('datacenter/datacenter/stat_operate');
        $frames['datacenter']['items']['stat_operate']['title'] = '运营分析';
        $frames['datacenter']['items']['stat_operate']['actions'] = array();
        $frames['datacenter']['items']['stat_operate']['active'] = '';

        $frames['datacenter']['items']['stat_store']['url'] = web_url('datacenter/datacenter/stat_store');
        $frames['datacenter']['items']['stat_store']['title'] = '店铺统计';
        $frames['datacenter']['items']['stat_store']['actions'] = array();
        $frames['datacenter']['items']['stat_store']['active'] = '';

        if (file_exists(PATH_MODULE . 'TnSrtWDJ.log')) {
            $frames['datacenter']['items']['stat_store_card']['url'] = web_url('datacenter/datacenter/stat_store_card');
            $frames['datacenter']['items']['stat_store_card']['title'] = '商户会员';
            $frames['datacenter']['items']['stat_store_card']['actions'] = array();
            $frames['datacenter']['items']['stat_store_card']['active'] = '';
        }

//		$frames['datacenter']['items']['stat_agent']['url'] = web_url('datacenter/datacenter/stat_agent');
//		$frames['datacenter']['items']['stat_agent']['title'] = '代理统计';
//		$frames['datacenter']['items']['stat_agent']['actions'] = array();
//		$frames['datacenter']['items']['stat_agent']['active'] = '';

        if (p('distribution')) {
            $frames['distri']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 分销分析';
            $frames['distri']['items'] = array();

            $frames['distri']['items']['stat_distri']['url'] = web_url('datacenter/datacenter/stat_distri');
            $frames['distri']['items']['stat_distri']['title'] = '分销统计';
            $frames['distri']['items']['stat_distri']['actions'] = array();
            $frames['distri']['items']['stat_distri']['active'] = '';
        }

        return $frames;
    }

    /**
     * static function 设置左侧列表
     *
     * @access static
     * @name getsettingFrames
     * @param
     * @return array
     */
    static function getsettingFrames() {
        global $_W, $_GPC;
        if ($_GPC['ac'] == 'shopset' || $_GPC['ac'] == 'payset' || $_GPC['ac'] == 'coverset' || $_GPC['do'] == 'notice') {
            $frames = array();
            $frames['setting']['title'] = '<i class="fa fa-globe"></i>&nbsp;&nbsp; 设置';
            $frames['setting']['items'] = array();
            $frames['setting']['items']['base']['url'] = web_url('setting/shopset/base');
            $frames['setting']['items']['base']['title'] = '基础设置';
            $frames['setting']['items']['base']['actions'] = array('ac', 'shopset', 'do', 'base');
            $frames['setting']['items']['base']['active'] = '';

            $frames['setting']['items']['share']['url'] = web_url('setting/shopset/share');
            $frames['setting']['items']['share']['title'] = '分享关注';
            $frames['setting']['items']['share']['actions'] = array('ac', 'shopset', 'do', 'share');
            $frames['setting']['items']['share']['active'] = '';

            $frames['setting']['items']['templat']['url'] = web_url('setting/shopset/templat');
            $frames['setting']['items']['templat']['title'] = '模板设置';
            $frames['setting']['items']['templat']['actions'] = array('ac', 'shopset', 'do', 'templat');
            $frames['setting']['items']['templat']['active'] = '';

            $frames['setting']['items']['api']['url'] = web_url('setting/shopset/api');
            $frames['setting']['items']['api']['title'] = '接口设置';
            $frames['setting']['items']['api']['actions'] = array('ac', 'shopset', 'do', 'api');
            $frames['setting']['items']['api']['active'] = '';

            //		$frames['setting']['items']['wap']['url'] = web_url('setting/shopset/wap');
            //		$frames['setting']['items']['wap']['title'] = '全网通设置';
            //		$frames['setting']['items']['wap']['actions'] = array('ac','shopset','do','wap');
            //		$frames['setting']['items']['wap']['active'] = '';

            $frames['payset']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 交易';
            $frames['payset']['items'] = array();
            $frames['payset']['items']['recharge']['url'] = web_url('setting/shopset/recharge');
            $frames['payset']['items']['recharge']['title'] = '充值设置';
            $frames['payset']['items']['recharge']['actions'] = array('ac', 'shopset', 'do', 'recharge');
            $frames['payset']['items']['recharge']['active'] = '';

            $frames['payset']['items']['creditset']['url'] = web_url('setting/shopset/creditset');
            $frames['payset']['items']['creditset']['title'] = '积分设置';
            $frames['payset']['items']['creditset']['actions'] = array('ac', 'shopset', 'do', 'creditset');
            $frames['payset']['items']['creditset']['active'] = '';

            $frames['payset']['items']['trade']['url'] = web_url('setting/payset/trade');
            $frames['payset']['items']['trade']['title'] = '文字设置';
            $frames['payset']['items']['trade']['actions'] = array('ac', 'payset', 'do', 'trade');
            $frames['payset']['items']['trade']['active'] = '';

            $frames['payset']['items']['register']['url'] = web_url('setting/register/baseset');
            $frames['payset']['items']['register']['title'] = '入驻设置';
            $frames['payset']['items']['register']['actions'] = array('ac', 'register', 'do', 'baseset');
            $frames['payset']['items']['register']['active'] = '';

            $frames['payset']['items']['customer']['url'] = web_url('setting/shopset/customer');
            $frames['payset']['items']['customer']['title'] = '客服设置';
            $frames['payset']['items']['customer']['actions'] = array('ac', 'shopset', 'do', 'customer');
            $frames['payset']['items']['customer']['active'] = '';


//			$frames['payset']['items']['payset']['url'] = web_url('setting/payset/index');
//			$frames['payset']['items']['payset']['title'] = '支付方式';
//			$frames['payset']['items']['payset']['actions'] = array('ac','payset','do','index');
//			$frames['payset']['items']['payset']['active'] = '';

            $frames['notice']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 消息';
            $frames['notice']['items'] = array();

            $frames['notice']['items']['message']['url'] = web_url('setting/noticeset/smslist');
            $frames['notice']['items']['message']['title'] = '短信消息';
            $frames['notice']['items']['message']['actions'] = array('ac', 'noticeset', 'do', 'smslist');
            $frames['notice']['items']['message']['active'] = '';

            $frames['notice']['items']['notice']['url'] = web_url('setting/noticeset/notice');
            $frames['notice']['items']['notice']['title'] = '模板消息';
            $frames['notice']['items']['notice']['actions'] = array('ac', 'noticeset', 'do', 'notice');
            $frames['notice']['items']['notice']['active'] = '';

            $frames['cover']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 入口';
            $frames['cover']['items'] = array();
            $frames['cover']['items']['index']['url'] = web_url('setting/coverset/index');
            $frames['cover']['items']['index']['title'] = '首页入口';
            $frames['cover']['items']['index']['actions'] = array('ac', 'coverset', 'do', 'index');
            $frames['cover']['items']['index']['active'] = '';

            $frames['cover']['items']['member']['url'] = web_url('setting/coverset/member');
            $frames['cover']['items']['member']['title'] = '会员中心';
            $frames['cover']['items']['member']['actions'] = array('ac', 'coverset', 'do', 'member');
            $frames['cover']['items']['member']['active'] = '';

            $frames['cover']['items']['store']['url'] = web_url('setting/coverset/store');
            $frames['cover']['items']['store']['title'] = '商户列表';
            $frames['cover']['items']['store']['actions'] = array('ac', 'coverset', 'do', 'store');
            $frames['cover']['items']['store']['active'] = '';
        }

        if ($_GPC['ac'] == 'noticeset' && $_GPC['do'] != 'notice') {
            $frames['sms']['title'] = '<i class="fa fa-cloud"></i>&nbsp;&nbsp; 自定义短信';
            $frames['sms']['items'] = array();

            $frames['sms']['items']['note_display']['url'] = web_url('setting/noticeset/smslist');
            $frames['sms']['items']['note_display']['title'] = '短信模板';
            $frames['sms']['items']['note_display']['actions'] = array('ac', 'noticeset', 'do', 'smslist');
            $frames['sms']['items']['note_display']['active'] = '';

            $frames['sms']['items']['note_add']['url'] = web_url('setting/noticeset/smsadd');
            $frames['sms']['items']['note_add']['title'] = '添加模板';
            $frames['sms']['items']['note_add']['actions'] = array('ac', 'noticeset', 'do', 'smsadd');
            $frames['sms']['items']['note_add']['active'] = '';

            $frames['note_setting_title']['title'] = '<i class="fa fa-cloud"></i>&nbsp;&nbsp; 短信设置';
            $frames['note_setting_title']['items'] = array();

            $frames['note_setting_title']['items']['note_setting']['url'] = web_url('setting/noticeset/smsset');
            $frames['note_setting_title']['items']['note_setting']['title'] = '短信设置';
            $frames['note_setting_title']['items']['note_setting']['actions'] = array('ac', 'noticeset', 'do', 'smsset');
            $frames['note_setting_title']['items']['note_setting']['active'] = '';

            $frames['note_setting_title']['items']['note_param']['url'] = web_url('setting/noticeset/smsparams');
            $frames['note_setting_title']['items']['note_param']['title'] = '参数设置';
            $frames['note_setting_title']['items']['note_param']['actions'] = array('ac', 'noticeset', 'do', 'smsparams');
            $frames['note_setting_title']['items']['note_param']['active'] = '';
        }

        if ($_GPC['ac'] == 'register') {
            $frames['registerset']['title'] = '<i class="fa fa-cloud"></i>&nbsp;&nbsp; 入驻设置';
            $frames['registerset']['items'] = array();

            $frames['registerset']['items']['baseset']['url'] = web_url('setting/register/baseset');
            $frames['registerset']['items']['baseset']['title'] = '基础设置';
            $frames['registerset']['items']['baseset']['actions'] = array('ac', 'register', 'do', 'baseset');
            $frames['registerset']['items']['baseset']['active'] = '';

            $frames['registerset']['items']['chargelist']['url'] = web_url('setting/register/chargelist');
            $frames['registerset']['items']['chargelist']['title'] = '收费设置';
            $frames['registerset']['items']['chargelist']['actions'] = array('ac', 'register', 'do', 'chargelist');
            $frames['registerset']['items']['chargelist']['active'] = '';

        }
        return $frames;
    }

    static function getappFrames() {
        global $_W;
        $frames = array();

        $frames['app']['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; 应用';
        $frames['app']['items'] = array();
        $frames['app']['items']['plugins']['url'] = web_url('app/plugins/index');
        $frames['app']['items']['plugins']['title'] = '应用列表';
        $frames['app']['items']['plugins']['actions'] = array('ac', 'plugins');
        $frames['app']['items']['plugins']['active'] = '';

        $pluginsset = App::get_apps($_W['uniacid']);
        $category = App::getCategory();
        foreach ($category as $key => $value) {
            $frames[$key]['title'] = '<i class="fa fa-inbox"></i>&nbsp;&nbsp; ' . $value['name'];
            $frames[$key]['items'] = array();
            foreach ($pluginsset as $pk => $plug) {
                if ($plug['category'] == $key) {
                    $frames[$key]['items'][$plug['ident']]['url'] = $plug['cover'];
                    $frames[$key]['items'][$plug['ident']]['title'] = $plug['name'];
                    $frames[$key]['items'][$plug['ident']]['actions'] = array('ac', $plug['ident']);
                    $frames[$key]['items'][$plug['ident']]['active'] = '';
                }
            }
        }

        return $frames;
    }

    static function getcloudFrames() {
        global $_W, $_GPC;
        $frames = array();


        $frames['plugin']['title'] = '<i class="fa fa-database"></i>&nbsp;&nbsp; 应用管理';
        $frames['plugin']['items'] = array();

        $frames['plugin']['items']['index']['url'] = web_url('cloud/plugin/index');
        $frames['plugin']['items']['index']['title'] = '应用信息';
        $frames['plugin']['items']['index']['actions'] = array();
        $frames['plugin']['items']['index']['active'] = '';

        $frames['plugin']['items']['perm']['url'] = web_url('cloud/plugin/account_list');
        $frames['plugin']['items']['perm']['title'] = '公众号权限';
        $frames['plugin']['items']['perm']['actions'] = array('do', array('account_list', 'account_post'));
        $frames['plugin']['items']['perm']['active'] = '';

        $frames['database']['title'] = '<i class="fa fa-database"></i>&nbsp;&nbsp; 数据管理';
        $frames['database']['items'] = array();

        $frames['database']['items']['datemana']['url'] = web_url('cloud/database/datemana');
        $frames['database']['items']['datemana']['title'] = '数据管理';
        $frames['database']['items']['datemana']['actions'] = array();
        $frames['database']['items']['datemana']['active'] = '';

        $frames['database']['items']['run']['url'] = web_url('cloud/database/run');
        $frames['database']['items']['run']['title'] = '运行SQL';
        $frames['database']['items']['run']['actions'] = array();
        $frames['database']['items']['run']['active'] = '';

        $frames['sysset']['title'] = '<i class="fa fa-database"></i>&nbsp;&nbsp; 系统设置';
        $frames['sysset']['items'] = array();

        $frames['sysset']['items']['base']['url'] = web_url('cloud/wlsysset/base');
        $frames['sysset']['items']['base']['title'] = '系统信息';
        $frames['sysset']['items']['base']['actions'] = array();
        $frames['sysset']['items']['base']['active'] = '';

        $frames['sysset']['items']['datemana']['url'] = web_url('cloud/wlsysset/taskcover');
        $frames['sysset']['items']['datemana']['title'] = '计划任务';
        $frames['sysset']['items']['datemana']['actions'] = array();
        $frames['sysset']['items']['datemana']['active'] = '';

        return $frames;
    }
}
