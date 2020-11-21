<?php
// +----------------------------------------------------------------------
// | 微擎模块
// +----------------------------------------------------------------------
// | Copyright (c) 柚子黑卡  All rights reserved.
// +----------------------------------------------------------------------
// | Author: 淡蓝海寓
// +----------------------------------------------------------------------

namespace app\admin\controller;


class FinanceClass extends BaseClass {
    private $urlarray = array("ctrl"=>"Finance");

    public function __construct(){
        parent::__construct();
        global $_W, $_GPC;
        $GLOBALS['frames'] = $this->getMainMenu();
    }

    /*提现设置*/
    public function withdrawset(){
        global $_W, $_GPC;
        $urlarray = $this->urlarray;
        $item=pdo_get('ymmf_sun_withdrawset',array('uniacid'=>$_W['uniacid']));
        $wd_type = $item["wd_type"]?explode(",",$item["wd_type"]):array();
        if(checksubmit('submit')){
            $data['is_open']=$_GPC['is_open'];
            $data['wd_type']=$_GPC['wd_type']?implode(",",$_GPC['wd_type']):1;
            $data['wd_content']=html_entity_decode($_GPC['wd_content']);
            $data['min_money']=$_GPC['min_money'];
            $data['avoidmoney']=$_GPC['avoidmoney'];
            $data['wd_wxrates']=$_GPC['wd_wxrates'];
            $data['wd_alipayrates']=$_GPC['wd_alipayrates'];
            $data['wd_bankrates']=$_GPC['wd_bankrates'];
            $data['cms_rates']=$_GPC['cms_rates'];

            if($_GPC['id']==''){
                $data['uniacid']=$_W['uniacid'];
                $res=pdo_insert('ymmf_sun_withdrawset',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('withdrawset',$urlarray),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('ymmf_sun_withdrawset', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('withdrawset',$urlarray),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }

        include $this->template('web/finance/withdrawset');

    }

    /*提现列表*/
    public function withdraw(){
        global $_W, $_GPC;
        $urlarray = $this->urlarray;
        //提现方式
        $widthdraw = array("","微信","支付宝","银行卡");

        $where=" WHERE uniacid=:uniacid ";
        $keyword = $_GPC['keyword'];
        if($_GPC['keyword']){
            $op=$_GPC['keyword'];
            $where.=" and branchname LIKE '%{$op}%'";
        }

        $data[':uniacid']=$_W['uniacid'];
        if($_GPC["type"]=='s'){
            $status = intval($_GPC['status']);
            if($status!=999){
                $where .= " and status=:status ";
                $data[':status']=$status;
            }
        }else{
            $status = 999;
        }
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=10;
        $sql="select * from " . tablename("ymmf_sun_withdraw") ." ".$where." order by id desc ";
        $total=pdo_fetchcolumn("select count(*) as wname from " . tablename("ymmf_sun_withdraw") . " " .$where." ",$data);
        $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
        $list = pdo_fetchall($select_sql,$data);
        $pager = pagination($total, $pageindex, $pagesize);

        if($_GPC['op']=='delete'){

            die('error');
            $res=pdo_delete('ymmf_sun_withdraw',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));

            if($res){
                message('删除成功！', $this->createWebUrl('withdraw',$urlarray), 'success');
            }else{
                message('删除失败！','','error');
            }
        }else if($_GPC['op']=='pass'){
            // 通过要判断是否是微信支付
            $id = intval($_GPC['id']);
            $uniacid = $_W['uniacid'];
            $withdraw = pdo_get('ymmf_sun_withdraw',array('uniacid'=>$uniacid,'id'=>$id));

            if($withdraw["wd_type"]==1){//微信直接打款
                include IA_ROOT . '/addons/ymmf_sun/wxfirmpay.php';
                $appData = pdo_get('ymmf_sun_system', array('uniacid' => $uniacid));
                $mch_appid = $appData['appid'];
                $mchid = $appData['mchid'];
                $key = $appData['wxkey'];
                $openid = $withdraw["openid"];
                $partner_trade_no = $mchid.time().rand(100000,999999);
                $re_user_name = $withdraw["wd_name"];
                $desc = "提现自动打款";
                $amount = $withdraw["realmoney"]*100;
                $apiclient_cert = IA_ROOT . "/addons/ymmf_sun/cert/".$appData['apiclient_cert'];
                $apiclient_key = IA_ROOT . "/addons/ymmf_sun/cert/".$appData['apiclient_key'];
                $weixinfirmpay = new WeixinfirmPay($mch_appid, $mchid, $key, $openid,$partner_trade_no,$re_user_name,$desc,$amount,$apiclient_cert,$apiclient_key);
                $return = $weixinfirmpay->pay();
                if($return['result_code']=='SUCCESS'){

                    //打款成功直接扣除商家的钱
                    $res_b = pdo_update('ymmf_sun_branch',array('frozenamount -='=>$withdraw["money"],'amount -='=>$withdraw["money"]),array('uniacid'=>$_W['uniacid'],'id'=>$withdraw["bid"]));

                    //更新提现状态
                    pdo_update('ymmf_sun_withdraw', array("status"=>1), array('id' => $id));
                    //插入商家资金明细
                    $data = array();
                    $data["bid"] = $withdraw["bid"];
                    $data["branchname"] = $withdraw['branchname'];
                    $data["mcd_type"] = 2;
                    $data["mcd_memo"] = "商家提现-提现总金额:".$withdraw["money"]."元；支付佣金:".$withdraw["paycommission"]."元；支付手续费:".$withdraw["ratesmoney"]."元；实际提现金额:".$withdraw["realmoney"]."元";//备注
                    $data["addtime"] = time();
                    $data["money"] = $withdraw["money"];
                    $data["paycommission"] = $withdraw["paycommission"];
                    $data["ratesmoney"] = $withdraw["ratesmoney"];
                    $data["wd_id"] = $id;
                    $data["uniacid"] = $uniacid;
                    $data["status"] = 1;
                    $res = pdo_insert('ymmf_sun_mercapdetails', $data);
                }else{
                    message('付款失败，'.$return['return_msg'].'！','','error');
                }
            }else{//非微信，更新状态
                //打款成功直接扣除商家的钱
                $res_b = pdo_update('ymmf_sun_branch',array('frozenamount -='=>$withdraw["money"],'amount -='=>$withdraw["money"]),array('uniacid'=>$_W['uniacid'],'id'=>$withdraw["bid"]));

                //更新提现状态
                pdo_update('ymmf_sun_withdraw', array("status"=>1), array('id' => $id));
                //插入商家资金明细
                $data = array();
                $data["bid"] = $withdraw["bid"];
                $data["branchname"] = $withdraw['branchname'];
                $data["mcd_type"] = 2;
                $data["mcd_memo"] = "商家提现-提现总金额:".$withdraw["money"]."元；支付佣金:".$withdraw["paycommission"]."元；支付手续费:".$withdraw["ratesmoney"]."元；实际提现金额:".$withdraw["realmoney"]."元";//备注
                $data["addtime"] = time();
                $data["money"] = $withdraw["money"];
                $data["paycommission"] = $withdraw["paycommission"];
                $data["ratesmoney"] = $withdraw["ratesmoney"];
                $data["wd_id"] = $id;
                $data["uniacid"] = $uniacid;
                $data["status"] = 1;
                $res = pdo_insert('ymmf_sun_mercapdetails', $data);
            }

            if($res){
                message('成功！', $this->createWebUrl('withdraw',$urlarray), 'success');
            }else{
                message('失败！','','error');
            }
        }elseif($_GPC['op']=='refuse'){
            $id = intval($_GPC['id']);
            $uniacid = $_W['uniacid'];
            $withdraw = pdo_get('ymmf_sun_withdraw',array('uniacid'=>$uniacid,'id'=>$id));
            //拒绝之后要扣除冻结资金
            $res_b = pdo_update('ymmf_sun_branch',array('frozenamount -='=>$withdraw["money"]),array('uniacid'=>$uniacid,'id'=>$withdraw["bid"]));

            $res=pdo_update('ymmf_sun_withdraw',array('status'=>2),array('id'=>$id,'uniacid'=>$uniacid));
            if($res){
                message('拒绝成功！', $this->createWebUrl('withdraw',$urlarray), 'success');
            }else{
                message('拒绝失败！','','error');
            }
        }

        include $this->template('web/finance/withdraw');

    }

    /*商家流水记录*/
    public function mercapdetails(){
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];

        $where=" WHERE uniacid=:uniacid ";
        $keyword = $_GPC['keyword'];
        if($_GPC['keyword']){
            $op=$_GPC['keyword'];
            $where.=" and branchname LIKE  '%$op%'";
        }

        if(!empty($_GPC['time_start_end'])){
            $time_start_end = $_GPC["time_start_end"];
            if($time_start_end){
                $time_start_end_arr = explode(" - ",$time_start_end);
                if($time_start_end_arr){
                    $starttime = strtotime($time_start_end_arr[0]);
                    $endtime = strtotime($time_start_end_arr[1]);
                    $where.=" and addtime >= {$starttime} and addtime <= {$endtime} ";
                }
            }
        }

        $type=isset($_GPC['type'])?$_GPC['type']:'all';

        if($_GPC["type"]=='s'){
            $status = intval($_GPC['status']);
            if($status!=999){
                $where .= " and mcd_type=:status ";
                $data[':status']=$status;
            }
        }else{
            $status = 999;
        }

        $data[':uniacid']=$_W['uniacid'];

        //提现方式
        $widthdraw = array("","订单收入","提现","线下付款","优惠券收入","线下支付-余额支付","商家返利","联盟红包返利");

        $pageindex = max(1, intval($_GPC['page']));
        $pagesize=10;
        $sql="select * from " . tablename("ymmf_sun_mercapdetails") ." ".$where." order by id desc ";

        //导出
        if($_GPC['op']=='exportorder'){
            $select_sql =$sql." ";
            $orderlist=pdo_fetchall($select_sql,$data);
            $export_title_str = "id,月份,商家名称,类型,金额(元),佣金(元),状态,完成时间,备注信息";
            $export_title = explode(',',$export_title_str);
            $export_list = array();
            $widthdraw = array("","订单收入","提现");
            $status = array("","成功","不成功");
            $i=1;
            foreach ($orderlist as $k => $v){
                $export_list[$k]["k"] = $v["id"];
                $export_list[$k]["month"] = $v["addtime"]?date("Y/m",$v["addtime"])."\t":" ";
                $export_list[$k]["branchname"] = $v["branchname"];
                $export_list[$k]["widthdraw"] = $widthdraw[$v["mcd_type"]];
                $export_list[$k]["money"] = $v["money"];
                $export_list[$k]["paycommission"] = $v["paycommission"];
                $export_list[$k]["status"] = $status[$v["status"]];
                $export_list[$k]["addtime"] = $v["addtime"]?date("Y-m-d H:i:s",$v["addtime"])."\t":" ";
                $export_list[$k]["mcd_memo"] = $v["mcd_memo"]."\t";
                $i++;
            }
            $exporttitle = "商家资金明细";

            exportToExcel($exporttitle.'_'.date("YmdHis").'.csv',$export_title,$export_list);
            exit;
        }else if($_GPC['op']=='delete'){

            $res=pdo_delete('ymmf_sun_mercapdetails',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));

            if($res){
                message('删除成功！', $this->createWebUrl('mercapdetails'), 'success');
            }else{
                message('删除失败！','','error');
            }
        }else if($_GPC['op']=='paytomch'){//后台支付按钮，目前没用
            $id = intval($_GPC['id']);

        }

        $total=pdo_fetchcolumn("select count(*) as wname from " . tablename("ymmf_sun_mercapdetails") . " " .$where." ",$data);

        $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
        $list=pdo_fetchall($select_sql,$data);
        $pager = pagination($total, $pageindex, $pagesize);

        include $this->template('web/finance/mercapdetails');

    }

}