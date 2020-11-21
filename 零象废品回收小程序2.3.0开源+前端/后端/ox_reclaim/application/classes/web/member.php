<?php
if (!(defined('IN_IA')))
{
	exit('Access Denied');
}

class Web_Member extends Web_Base
{
    /**
     * 会员列表
     */
    public function memberList(){
        global $_W,$_GPC;

        $where = '';
        $keyword = $_GPC['keyword'];
        if(!empty($keyword)){
            $where .= "and ( nickname like '%".$keyword."%' or phone='".$keyword."' )";
        }

        $pindex = max(1, intval($_GPC['page']));
        $psize = 20;
        $list=pdo_fetchall("select * from ".tablename('ox_reclaim_member')."  where `uniacid`= {$_W['uniacid']} and black=0 and jiedan=0 {$where}  order by money asc,id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
        $total = pdo_fetchcolumn("select count(*) from ".tablename('ox_reclaim_member')."  where `uniacid`= {$_W['uniacid']}  and black=0  and jiedan=0 {$where}  ");


        $pager = pagination2($total, $pindex, $psize);
        $i=($pindex - 1) * $psize+1;

        include $this->template();
    }
    /*
     * 会员加入黑名单
     */
    public function member_black(){
        global $_W,$_GPC;
        $id = $_GPC['id'];
        if($_W['ispost'])
        {
            //删除
            $where_data['id'] = $id;
            $where_data['uniacid'] = $_W['uniacid'];
            $res = pdo_update('ox_reclaim_member',array('black'=>time()),$where_data);
            if($res)
            {
                $this->success('拉黑成功','member/memberList');
            }else{
                $this->error('拉黑失败','member/memberList');
            }
        }
        $this->error('数据错误','member/memberList');
    }
    /*
     * 会员加入接单员
     */
    public function member_jiedan(){
        global $_W,$_GPC;
        $id = $_GPC['id'];
        if($_W['ispost'])
        {

            //删除
            $where_data['id'] = $id;
            $where_data['uniacid'] = $_W['uniacid'];
            $user = pdo_get('ox_reclaim_member',$where_data);
            if(empty($user['jiedan'])){
                $data = array('jiedan'=>1);
            }else{
                $data = array('jiedan'=>0);
            }
            $res = pdo_update('ox_reclaim_member',$data,$where_data);
            if($res)
            {
                $this->success('修改成功','',2);
            }else{
                $this->error('修改失败','',2);
            }
        }
        $this->error('数据错误','member/memberList');
    }

    /*
     * 会员增加余额
     */
    public function money_add(){
        global $_W,$_GPC;
        $money_num = $_GPC['money_num'];
        $user_id= $_GPC['user_id'];
        if($_W['ispost'])
        {
            if(!is_numeric($money_num)){
                $this->result(0,'请输入数字'.$money_num);
            }
            //获取会员信息
            $user_info = pdo_get('ox_reclaim_member',array('id'=>$user_id,'uniacid'=>$_W['uniacid']));

            $ceshi = new Basis();
            $parame = array(
                'from_uid'=>$user_info['uid'],  //来源用户-可不填写
                'type'=>4, //类型 0接单 1完工 2提现 3提现驳回
                'from_id'=>$user_id,   //来源id 订单id或提现表id(非小程序form_id)
                'from_table'=>'ox_reclaim_member', //来源表名，不带ims_
                'desc'=>'管理员调整资金',
                //'integral'=>floor($money_num)
            );
            $result = $ceshi->money_change($money_num,$user_info['uid'],$parame);

            if($result['code']){
                $this->result(1,'充值成功');
            }else{
                $this->result(0,'充值失败');
            }

        }
        $this->result(0,'充值失败');
    }
    /**
     * 黑名单列表
     */
    public function blackList(){
        global $_W,$_GPC;

        $where = '';
        $keyword = $_GPC['keyword'];
        if(!empty($_GPC['keyword']))
        {
            $where .= "and ( nickname like '%".$keyword."%' or phone='".$keyword."' )";
        }

        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $list=pdo_fetchall("select * from ".tablename('ox_reclaim_member')."  where `uniacid`= {$_W['uniacid']} and `black`>0 ".$where." order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
        $total = pdo_fetchcolumn("select count(*) from ".tablename('ox_reclaim_member')."  where `uniacid`= {$_W['uniacid']} and `black`>0 ".$where);

        $pager = pagination2($total, $pindex, $psize);
        $i=($pindex - 1) * $psize+1;
        include $this->template();
    }
    /*
     *黑名单恢复
     */
    public function black_member(){
        global $_W,$_GPC;
        $id = $_GPC['id'];
        if($_W['ispost'])
        {
            //删除
            $where_data['id'] = $id;
            $where_data['uniacid'] = $_W['uniacid'];
            $res = pdo_update('ox_reclaim_member',array('black'=>0),$where_data);
            if($res)
            {
                $this->success('恢复成功','member/blackList');
            }else{
                $this->error('恢复失败','member/blackList');
            }
        }
        $this->error('数据错误','member/blackList');
    }
    /**
     * 资金记录
     */
    public function money_log(){
        global $_W,$_GPC;
        $user_info = pdo_get('ox_reclaim_member',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $order = ' order by create_time desc';
        $list=pdo_fetchall("select * from ".tablename('ox_reclaim_money_log')." where `uniacid`= {$_W['uniacid']} and uid='".$user_info['uid']."' ".$order." LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
        $total = pdo_fetchcolumn("select count(*) from ".tablename('ox_reclaim_money_log')." where `uniacid`= {$_W['uniacid']} and uid='".$user_info['uid'] ."'");

        $pager = pagination2($total, $pindex, $psize);
        $i=($pindex - 1) * $psize+1;
        include $this->template();
    }
    /**
     * 接单员列表
     */
    public function adminList(){
        global $_W,$_GPC;

        $where = '';
        $keyword = $_GPC['keyword'];
        if(!empty($keyword)){
            $where .= "and ( nickname like '%".$keyword."%' or phone='".$keyword."' )";
        }

        $pindex = max(1, intval($_GPC['page']));
        $psize = 20;
        $list=pdo_fetchall("select * from ".tablename('ox_reclaim_member')."  where `uniacid`= {$_W['uniacid']} and black=0 and jiedan=1 {$where}  order by money asc,id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
        $total = pdo_fetchcolumn("select count(*) from ".tablename('ox_reclaim_member')."  where `uniacid`= {$_W['uniacid']}  and black=0 and jiedan=1  {$where}  ");


        $pager = pagination2($total, $pindex, $psize);
        $i=($pindex - 1) * $psize+1;

        include $this->template();
    }



}

?>