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
        $pindex = $_GPC['page'] ?: 1;
        $psize = $_GPC['limit'] ?: 20;

        $query = '';
        if($_GPC['key']){
            $query .= " and nickname like '%{$_GPC['key']}%'  ";
        }
        if($_GPC['date']){
            $begin = $_GPC['date'][0] / 1000;
            $end = $_GPC['date'][1] / 1000;
            $query .= " and create_time >{$begin} and create_time < {$end} ";
        }
        $list=pdo_fetchall("select * from ".tablename('ox_reathouse_member')."  where `uniacid`= {$_W['uniacid']} {$query} order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
        $total = pdo_fetchcolumn("select count(*) from ".tablename('ox_reathouse_member')."  where `uniacid`= {$_W['uniacid']} {$query}  ");
        $result = [
            'list' => $list,
            'total' => intval($total),
            'params' => $query
        ];
        return $this->result('0','sufcc',$result);
    }

    /*
     * 修改会员可发布状态
     */
    public function up_publish(){
        global $_W,$_GPC;
        $where = [
            'uid'=>$_GPC['uid'],
            'uniacid'=>$_W['uniacid']
        ];
        $res = pdo_update('ox_reathouse_member',array('is_publish'=>$_GPC['is_publish']),$where);
        if($res){
            return $this->result('0','操作成功',$_GPC);
        }else{
            return $this->result('-1','操作失败',$_GPC);
        }
    }

}

?>