<?php
/**
 * 智慧党建云平台
 *
 * @author xiechunbing 732680577
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

!defined('VLINKE_CPARTY_PATH') && define('VLINKE_CPARTY_PATH',IA_ROOT.'/addons/vlinke_cparty/');

require_once IA_ROOT . '/addons/vlinke_cparty/inc/functions.php';

class Vlinke_cpartyModuleWxapp extends WeModuleWxapp {



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


    // public function __construct() {
    //     global $_W;
    //     global $_GPC;
    //     if (empty($_W['openid'])) {
    //         $this->result(41009, '请先登录');
    //     }
    // }

    // 附件地址
    public function doPageAttachurl(){
        global $_W;
        $this->result(0, '', $_W['attachurl']);
    }


    // 上传图片
    public function doPageUploadimage() {
        global $_W, $_GPC;
        load()->func('file');
        $img = file_upload($_FILES['upfile'], 'image', '');
        $this->result(0, '', $img);
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
        return $insertid;
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
                $this->result(0, "支付成功！");
            } else {
                $this->result(1, "支付失败！");
            }
        }
    }


  


}