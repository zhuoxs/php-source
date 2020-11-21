<?php
if (!(defined('IN_IA')))
{
	exit('Access Denied');
}

class Web_Baseset extends Web_Base
{
    /**
     * 小程序设置
     */
    public function index()
    {
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        load()->func('tpl');
        $result=pdo_fetch("SELECT * FROM ".tablename('ox_reclaim_info')." where `uniacid`={$_W['uniacid']} limit 1");
        if($_W['ispost']){
            $data=$_GPC['data'];
            if(!empty($result)){
                $res=pdo_update('ox_reclaim_info',$data,array('uniacid'=>$uniacid));
            }else{
                $data['uniacid'] = $_W['uniacid'];
                $res=pdo_insert('ox_reclaim_info',$data);
            }
            if(!empty($res)){
                $this->success('修改成功','baseset/index');
            }else{
                $this->success('修改失败','baseset/index');
            }
        }
        include $this->template();
    }


    /*
    * 关于我们列表
    */
    public function about(){
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];

        $list=pdo_fetchall("select * from ".tablename('ox_reclaim_view')." where `uniacid`='$uniacid'   order by sort desc ");

        include $this->template();

    }
    /*
     * 关于我们添加
     */
    public function about_add(){
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        $id = $_GPC['id'];

        if(empty($id))
        {
            $data =[];
            if($_W['ispost'])
            {
                //添加
                $data=$_GPC['data'];
                $data['uniacid'] =$_W['uniacid'];
                $data['create_time'] = time();

                $res = pdo_insert('ox_reclaim_view',$data);
                if($res)
                {
                    $this->success('添加成功','baseset.about');
                }else{
                    $this->error('添加失败','baseset.about');
                }

            }
        }else{
            $type_info=pdo_get('ox_reclaim_view',array('id'=>$id,'uniacid'=>$_W['uniacid']));
            if($_W['ispost'])
            {
                //修改
                $data=$_GPC['data'];

                $where_data['id'] = $id;
                $where_data['uniacid'] = $_W['uniacid'];
                $res = pdo_update('ox_reclaim_view',$data,$where_data);
                if($res)
                {
                    $this->success('修改成功','baseset.about');
                }else{
                    $this->error('修改失败','baseset.about');
                }
            }
        }
        include $this->template();
    }
    /*
    * 删除关于我们
     */
    public function about_del()
    {
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        if($_GPC['id']){
            $id=$_GPC['id'];
            $res=pdo_delete('ox_reclaim_view',array('id'=>$id,'uniacid'=>$uniacid));
            if($res)
            {
                $this->success('删除成功','baseset.about');
            }else{
                $this->error('删除失败','baseset.about');
            }
        }

    }
    /*
     * 反馈列表
     */
    public function suggest(){
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        $pindex = max(1, intval($_GPC['page']));
        $psize = 8;
        $list=pdo_fetchall("select * from ".tablename('ox_reclaim_suggest')." where `uniacid`='$uniacid'   order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
        $total = pdo_fetchcolumn("select count(*) from ".tablename('ox_reclaim_suggest')." where `uniacid`='$uniacid'  ");

        $pager = pagination2($total, $pindex, $psize);
        $i = ($pindex - 1) * $psize+1;
        include $this->template();

    }
    /*
   * 删除反馈
    */
    public function suggest_del()
    {
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        if($_GPC['id']){
            $id=$_GPC['id'];
            $res=pdo_delete('ox_reclaim_suggest',array('id'=>$id,'uniacid'=>$uniacid));
            if($res)
            {
                $this->success('删除成功','baseset.suggest');
            }else{
                $this->error('删除失败','baseset.suggest');
            }
        }

    }
    // 服务区域审核
    public function apply(){
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        $pindex = max(1, intval($_GPC['page']));
        $psize = 20;
        $list=pdo_fetchall("select * from ".tablename('ox_reclaim_city')." where `uniacid`='$uniacid'   order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
        $total = pdo_fetchcolumn("select count(*) from ".tablename('ox_reclaim_city')." where `uniacid`='$uniacid'  ");

        $pager = pagination2($total, $pindex, $psize);
        $i = ($pindex - 1) * $psize+1;
        include $this->template();
    }

    // 开通区域
    public function editApply(){
        global $_W,$_GPC;
        $detail = pdo_get('ox_reclaim_city',['id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']]);
        $status = $detail['status'] == 1 ? 0 : 1;
        pdo_update('ox_reclaim_city',['status' => $status],['id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']] );
        $this->success('修改成功','baseset.apply');
    }


}

?>