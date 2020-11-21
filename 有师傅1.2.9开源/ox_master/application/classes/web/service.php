<?php
if (!(defined('IN_IA')))
{
    exit('Access Denied');
}

class Web_Service extends Web_Base
{

    public function type()
    {
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        $pindex = $_GPC['page'] ?: 1;
        $psize = $_GPC['limit'] ?: 20;
        $list=pdo_fetchall("select * from ".tablename('ox_master_type')." where `uniacid`='$uniacid' and class_level='1'  order by sort desc,parent_id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
        $total = pdo_fetchcolumn("select count(*) from ".tablename('ox_master_type')." where `uniacid`='$uniacid' and class_level='1'  ");

        $last_class_data = pdo_fetchall("select * from ".tablename('ox_master_type')."where `uniacid`='{$uniacid}' and class_level='0'");

        $temp_data = array();
        foreach ($last_class_data as $tk=>$tv)
        {
            $temp_data[$tv['id']]=$tv['name'];

        }
        $temp_data[0] = "头部导航";
        foreach ($list as $k => $v){
            $list[$k]['path'] = tomedia($v['img']);
            $list[$k]['last_class_name'] = $temp_data[$v['parent_id']];
        }
        $result = [
            'list' => $list,
            'total' => intval($total)
        ];
        return $this->result('0','sufcc',$result);
    }
    public function typef()
    {
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        $pindex = $_GPC['page'] ?: 1;
        $psize = $_GPC['limit'] ?: 20;
        $list=pdo_fetchall("select * from ".tablename('ox_master_type')." where `uniacid`='$uniacid' and class_level='0'  order by sort desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
        $total = pdo_fetchcolumn("select count(*) from ".tablename('ox_master_type')." where `uniacid`='$uniacid' and class_level='0'  ");

//        $last_class_data = pdo_fetchall("select * from ".tablename('ox_master_type')."where `uniacid`='{$uniacid}' and class_level='0'");
//
//        $temp_data = array();
//        foreach ($last_class_data as $tk=>$tv)
//        {
//            $temp_data[$tv['id']]=$tv['name'];
//
//        }
        foreach ($list as $k => $v){
            $list[$k]['path'] = tomedia($v['img']);
//            $list[$k]['last_class_name'] = $temp_data[$v['parent_id']];
        }
        $result = [
            'list' => $list,
            'total' => intval($total)
        ];
        return $this->result('0','sufcc',$result);
    }



    public function type_add()
    {
        global $_W,$_GPC;
        $class_level=0;
        if ($_GPC['parentids'] || $_GPC['parentids'] === '0')
        {
            $class_level=1;
        }
        $data=[
            'name' => $_GPC['name'],
            'sort' => $_GPC['sort'],
            'uniacid' => $_W['uniacid'],
            'create_time' => $_SERVER['REQUEST_TIME'],
            'img' => $_GPC['img'],
            'show_num'=>$_GPC['show_num'],
            'title'=>$_GPC['title'],
            'parent_id'=>$_GPC['parentids'],
            'class_level'=>$class_level
        ];
        $res=pdo_insert('ox_master_type',$data);
        return $this->result('0','sufcc',$_GPC);
    }
    /*
    * 修改分类
     */
    public function type_edit()
    {
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        $id=$_GPC['id'];
        $is_num = is_numeric($_GPC['last_class_name']);
        $data=[
            'name' => $_GPC['name'],
            'sort' => $_GPC['sort'],
            //'uniacid' => $_W['uniacid'],
            //'create_time' => $_SERVER['REQUEST_TIME'],
            'img' => $_GPC['img'],
//            'parent_id' => $_GPC['last_class_name'],
            'show_num'=>$_GPC['show_num'],
            'title'=>$_GPC['title'],
        ];
        $rows['name']="";
        if ($is_num)
        {
            $data['parent_id']=$_GPC['last_class_name'];
            $data['class_level']=1;
            $parent_id = $data['parent_id'];
            $rows=pdo_fetch("select * from ".tablename('ox_master_type')." where `uniacid`='{$uniacid}' and id='{$parent_id}' ");

            if(!$rows){
                $rows['name']="头部导航";
            }

        }
        $res=pdo_update('ox_master_type',$data,array('id'=>$id));
        return $this->result('0',$rows['name'],$res);
    }


    /*
    * 删除分类
     */
    public function type_del()
    {
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        if($_GPC['id']){
            $id=$_GPC['id'];
            $rows = pdo_fetch("select * from ".tablename('ox_master_type')." where `uniacid`='{$uniacid}' and id='{$id}' ");
            if (empty($rows)) {
                return $this->result('23','分类不存在',$_GPC);
            }
            $parent_rows = pdo_fetch("select * from ".tablename('ox_master_type')." where `uniacid`='{$uniacid}' and parent_id='{$id}' ");
            if ($parent_rows)
            {
                return $this->result('23','请先删除此分类下相关服务',$_GPC);
            }
            $data=pdo_delete('ox_master_type',array('id'=>$id,'uniacid'=>$uniacid));
            if ($data) {
                return $this->result('0','删除成功',$_GPC);
            }else
            {
                return $this->result('23','删除失败',$_GPC);
            }
        }
    }
    /*
   * 删除分类
   */
    public function type_delall()
    {
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        if($_GPC['ids']){
            $ids=explode(',',$_GPC['ids']);
            $data=pdo_delete('ox_master_type',array('id'=>$ids,'uniacid'=>$uniacid));
            if ($data) {
                return $this->result('0','删除成功',$_GPC);
            }else
            {
                return $this->result('23','删除失败',$_GPC);
            }
        }
    }

    public function getNextClassList()
    {
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        $list=pdo_fetchall("select * from ".tablename('ox_master_type')." where `uniacid`='{$uniacid}' and class_level='0'");
        $list[] = ['id' => 0,'name' => '头部导航'];
        return $this->result('0','sufcc',$list);
    }

    public  function getTopClass()
    {
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        $list=pdo_fetchall("select * from ".tablename('ox_master_type')." where `uniacid`='{$uniacid}' and class_level='0'");
        $list[] = ['id' => 0,'name' => '头部导航'];
        return $this->result('0','sufcc',$list);
    }
    public function test(){
            $result = Message::Instance()->uniformSend([]);
            echo '<pre>';
            var_dump($result);
    }


}

?>