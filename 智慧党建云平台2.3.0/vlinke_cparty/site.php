<?php
/**
 * 智慧党建云平台
 *
 * @author xiechunbing 732680577
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');



!defined('VLINKE_CPARTY_PATH') && define('VLINKE_CPARTY_PATH',IA_ROOT.'/addons/vlinke_cparty/');


@require_once('excel/reader.php');

require_once IA_ROOT . '/addons/vlinke_cparty/inc/functions.php';


class Vlinke_cpartyModuleSite extends WeModuleSite {

    public $table_param       = "vlinke_cparty_param";
    public $table_branch      = "vlinke_cparty_branch";
    public $table_user        = "vlinke_cparty_user";    
    public $table_leader      = "vlinke_cparty_leader";
    public $table_integral    = "vlinke_cparty_integral";
    
    public $table_slide       = "vlinke_cparty_slide";
    public $table_notice      = "vlinke_cparty_notice";
    
    public $table_artcate     = "vlinke_cparty_artcate";
    public $table_article     = "vlinke_cparty_article";
    public $table_artmessage  = "vlinke_cparty_artmessage";
    
    
    public $table_educate     = "vlinke_cparty_educate";
    public $table_edulesson   = "vlinke_cparty_edulesson";
    public $table_educhapter  = "vlinke_cparty_educhapter";
    public $table_edustudy    = "vlinke_cparty_edustudy";
    public $table_edulog      = "vlinke_cparty_edulog";
    public $table_edumessage  = "vlinke_cparty_edumessage";
    
    public $table_supmailbox  = "vlinke_cparty_supmailbox";
    public $table_supproposal = "vlinke_cparty_supproposal";
    public $table_supreadily  = "vlinke_cparty_supreadily";
    public $table_supreport   = "vlinke_cparty_supreport";
    
    public $table_expcate     = "vlinke_cparty_expcate";
    public $table_expense     = "vlinke_cparty_expense";
    
    public $table_sercate     = "vlinke_cparty_sercate";
    public $table_seritem     = "vlinke_cparty_seritem";
    public $table_serlog      = "vlinke_cparty_serlog";
    public $table_sermessage  = "vlinke_cparty_sermessage";
    
    public $table_activity    = "vlinke_cparty_activity";
    public $table_actenroll   = "vlinke_cparty_actenroll";
    public $table_actmessage  = "vlinke_cparty_actmessage";
    
    public $table_exacate     = "vlinke_cparty_exacate";
    public $table_exabank     = "vlinke_cparty_exabank";
    public $table_exadevery   = "vlinke_cparty_exadevery";
    public $table_exaday      = "vlinke_cparty_exaday";
    public $table_exapevery   = "vlinke_cparty_exapevery";
    public $table_exapaper    = "vlinke_cparty_exapaper";
    public $table_exaanswer   = "vlinke_cparty_exaanswer";
    public $table_exaitem     = "vlinke_cparty_exaitem";
    
    public $table_bbscate     = "vlinke_cparty_bbscate";
    public $table_bbstopic    = "vlinke_cparty_bbstopic";
    public $table_bbszan      = "vlinke_cparty_bbszan";
    public $table_bbsreply    = "vlinke_cparty_bbsreply";
    public $table_bbscollect  = "vlinke_cparty_bbscollect";
	
	public $table_msgtemplate = 'vlinke_cparty_msgtemplate';
	public $table_msgmessage  = 'vlinke_cparty_msgmessage';
	public $table_msglog      = 'vlinke_cparty_msglog';



    public function getParam(){
        global $_W;
        // 判断微信端登录
        $useragent = addslashes($_SERVER['HTTP_USER_AGENT']);
        if (strpos($useragent, 'MicroMessenger') === false && strpos($useragent, 'Windows Phone') === false) {
            message('非法访问，请通过微信打开！');
            die();
        }
        // 返回配置项
        $param = pdo_get($this->table_param,array('uniacid'=>$_W['uniacid']));
        if (empty($param)) {
            message('请先配置活动！');
            die();
        }
        $param['footnav'] = iunserializer($param['footnav']);
        foreach ($param['footnav'] as $k => $v) {
            $param['footnav'][$k]['dos'] = explode(",", $v['dos']);
        }
        return $param;
    }


    public function getUser($isopen=0){
        global $_W;
        $fan = mc_oauth_userinfo();
        $user = pdo_get($this->table_user, array('openid'=>$fan['openid'],'uniacid'=>$_W['uniacid'],'recycle'=>0));
        
        if ($isopen==0) {
            if (empty($user)) {
                $url = $this->createMobileUrl("login");
                Header("Location:".$url); 
            }
            if ($user['status']==1) {
                message("您的信息审核中，请耐心等待！", "", "error");
            }elseif ($user['status']==3) {
                message("您的账号已被禁用，如有疑问，请联系管理员！", "", "error");
            }
        }
        return $user;
    }

    // 获取指定ID的组织
    public function getBranch($branchid=0){
        global $_W;
        $branch = pdo_get($this->table_branch, array('id'=>$branchid,'uniacid'=>$_W['uniacid']));
        if (empty($branch)) {
            message("组织信息不存在！", referer(), "error");
        }
        return $branch;
    }

    // 积分记录
    public function setIntegral($dataarr, $isrank=1){
        global $_W;
        $dataarr['uniacid']    = $_W['uniacid'];
        $dataarr['isrank']     = $isrank;
        $dataarr['iyear']      = date("Y");
        $dataarr['iseason']    = date("Y").ceil(date("m")/3);
        $dataarr['imonth']     = date("Ym");
        $dataarr['createtime'] = time();
        pdo_insert($this->table_integral, $dataarr);
        $insertid = pdo_insertid();
        pdo_update($this->table_user, array('integral +='=>$dataarr['integral']), array('id'=>$dataarr['userid']));
        unset($_SESSION['cpartyuser']);
        return $insertid;
    }

    // 上传图片
    public function doMobileUploadimage() {
        global $_W, $_GPC;
        load()->func('file');
        $img = file_upload($_FILES['upfile'], 'image', '');
        exit(json_encode($img));
    }


    // 支付验证
    public function payResult($params) {
        global $_W;
        if ($params['result'] == 'success' && $params['from'] == 'notify') {
            $paynumber = $params['tid'];
            $expense = pdo_get($this->table_expense, array('paynumber'=>$paynumber));
            $expenseid = $expense['id'];
            pdo_update($this->table_expense, array('status'=>2,'paytime'=>time()), array('id'=>$expenseid));
        }
        if ($params['from'] == 'return') {
            if ($params['result'] == 'success') {
                message('支付成功！', $this->createMobileUrl('explog'), 'success');
            } else {
                message('支付失败！', $this->createMobileUrl('explog'), 'error');
            }
        }
    }




    public function doWebAdmin() {
        global $_W,$_GPC;
        session_start();
        $action = trim($_GPC['r']);
        $action = empty($action)?"home":$action;
        $op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

        // 判断登录状态
        if ($action=="login") {
            if( !empty($_SESSION['cparty']['uniacid']) && $_W['uniacid']==$_SESSION['cparty']['uniacid'] && !empty($_SESSION['cparty']['luser']) ){
                header("location:".$this->createWebUrl("admin",array('r'=>"home",'uniacid'=>$_W['uniacid'])));
            }
        }else{
            if( empty($_SESSION['cparty']['uniacid']) || $_W['uniacid']!=$_SESSION['cparty']['uniacid'] || empty($_SESSION['cparty']['luser']) ){
                header("location:".$this->createWebUrl("admin",array('r'=>"login",'uniacid'=>$_W['uniacid'])));
            }
        }

        $luser        = $_SESSION['cparty']['luser'];
        
        $lbranchall   = $_SESSION['cparty']['lbranchall'];
        $lbranchallid = $_SESSION['cparty']['lbranchallid'];
        
        $lbranch      = $_SESSION['cparty']['lbranch'];
        
        $lbrancharr   = $_SESSION['cparty']['lbrancharr'];
        $lbrancharrid = $_SESSION['cparty']['lbrancharrid'];

        // var_dump($lbrancharr);

        require_once VLINKE_CPARTY_PATH . 'inc/admin/'.$action.'.inc.php';
        exit();
    }





}