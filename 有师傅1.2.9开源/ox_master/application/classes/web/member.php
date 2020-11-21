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

        $time = time();
        $user_ids = pdo_fetchall("select uid from " .tablename('ox_master_black'). " where uniacid='{$_W['uniacid']}' and (black_time>'{$time}' or black_time=0)");
        if (!empty($user_ids))
        {
            $query = " and uid not in (";
            foreach ($user_ids as $k=>$v){
                $query.= " ".$v['uid'].",";
            }
            $query =rtrim($query, ",");
            $query.=")";
        }else{
            $query = '';
        }

        if($_GPC['key']){
            $query .= " and nickname like '%{$_GPC['key']}%'  ";
        }
        if($_GPC['date']){
            $begin = $_GPC['date'][0] / 1000;
            $end = $_GPC['date'][1] / 1000;
            $query .= " and updatetime >{$begin} and updatetime < {$end} ";
        }
        $list=pdo_fetchall("select * from ".tablename('mc_mapping_fans')."  where `uniacid`= {$_W['uniacid']} {$query} order by fanid desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
        $total = pdo_fetchcolumn("select count(*) from ".tablename('mc_mapping_fans')."  where `uniacid`= {$_W['uniacid']} {$query}  ");
        $result = [
            'list' => $list,
            'total' => intval($total),
            'params' => $query
        ];
        return $this->result('0','sufcc',$result);
    }

    /*
     * 会员拉黑操作
     */
    public function addBlack(){
        global $_W,$_GPC;
        $data = [
            'create_time'=>time(),
            'uniacid'=>$_W['uniacid']
        ];
        if(!empty($_GPC['tian'])){
            $data['black_time'] = time()+($_GPC['tian']*86400);
        }else{
            $data['black_time'] = 0;
        }
        if(empty($_GPC['reject'])){
            $data['reject'] = '无';
        }else{
            $data['reject'] = $_GPC['reject'];
        }
        if(empty($_GPC['uid'])){
            return $this->result('-1','用户信息获取失败',$_GPC);
        }
        $data['uid'] = $_GPC['uid'];
        $res = pdo_insert('ox_master_black',$data);
        if($res){
            return $this->result('0','添加黑名单成功',$_GPC);
        }else{
            return $this->result('-1','添加黑名单失败',$_GPC);
        }
    }

    /*
     * 黑名单会员列表
     */
    public function BlackList(){
        global $_W,$_GPC;
        $pindex = $_GPC['page'] ?: 1;
        $psize = $_GPC['limit'] ?: 20;

        $user_ids = pdo_fetchall("select uid from " .tablename('ox_master_black'). " where uniacid='{$_W['uniacid']}' and (black_time>'{$time}' or black_time=0)");
        if (!empty($user_ids))
        {
            $query = " and uid in (";
            foreach ($user_ids as $k=>$v){
                $query.= " ".$v['uid'].",";
            }
            $query =rtrim($query, ",");
            $query.=")";
        }else{
            $query = 'and 1=0';
        }

        if($_GPC['key']){
            $query .= " and nickname like '%{$_GPC['key']}%'  ";
        }
        if($_GPC['date']){
            $begin = $_GPC['date'][0] / 1000;
            $end = $_GPC['date'][1] / 1000;
            $query .= " and updatetime >{$begin} and updatetime < {$end} ";
        }
        $list=pdo_fetchall("select * from ".tablename('mc_mapping_fans')."  where `uniacid`= {$_W['uniacid']} {$query} order by fanid desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
        $total = pdo_fetchcolumn("select count(*) from ".tablename('mc_mapping_fans')."  where `uniacid`= {$_W['uniacid']} {$query}  ");
        foreach ($list as &$value){
            $user_black = pdo_get('ox_master_black',array('uniacid'=>$_W['uniacid'],'uid'=>$value['uid']));
            if($user_black['black_time']=='0'){
                $value['black_time'] = '永久';
            }else{
                $value['black_time'] = date('Y-m-d H:i:s',$user_black['black_time']);
            }
        }
        $result = [
            'list' => $list,
            'total' => intval($total),
            'params' => $query
        ];
        return $this->result('0','sufcc',$result);
    }

    /*
     * 会员取消拉黑操作
     */
    public function delBlack(){
        global $_W,$_GPC;
        if(empty($_GPC['uid'])){
            return $this->result('-1','用户信息无效',$result);
        }
        pdo_delete('ox_master_black',array('uniacid'=>$_W['uniacid'],'uid'=>$_GPC['uid']));
        return $this->result('0','恢复成功',$result);
    }
}

?>