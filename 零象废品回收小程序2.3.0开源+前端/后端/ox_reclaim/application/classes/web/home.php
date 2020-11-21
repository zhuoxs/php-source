<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/20
 * Time: 15:12
 */
class Web_Home extends Web_Base
{
    /*
       * 轮播列表
       */
    public function lunbo(){
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        $list=pdo_fetchall("select * from ".tablename('ox_reclaim_banner')." where `uniacid`='$uniacid'   order by sort desc ");
        include $this->template();

    }
    /*
     * 轮播列表
     */
    public function lunbo_add(){
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

                $res = pdo_insert('ox_reclaim_banner',$data);
                if($res)
                {
                    $this->success('添加成功','home.lunbo');
                }else{
                    $this->error('添加失败','home.lunbo');
                }
            }
        }else{
            $type_info=pdo_get('ox_reclaim_banner',array('id'=>$id,'uniacid'=>$_W['uniacid']));
            if($_W['ispost'])
            {
                //修改
                $data=$_GPC['data'];

                $where_data['id'] = $id;
                $where_data['uniacid'] = $_W['uniacid'];
                $res = pdo_update('ox_reclaim_banner',$data,$where_data);
                if($res)
                {
                    $this->success('修改成功','home.lunbo');
                }else{
                    $this->error('修改失败','home.lunbo');
                }
            }
        }
        include $this->template();
    }
    /*
    * 删除轮播
     */
    public function lunbo_del()
    {
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        if($_GPC['id']){
            $id=$_GPC['id'];
            $res=pdo_delete('ox_reclaim_banner',array('id'=>$id,'uniacid'=>$uniacid));
            if($res)
            {
                $this->success('删除成功','home.lunbo');
            }else{
                $this->error('删除失败','home.lunbo');
            }
        }

    }
    /*
     * 类型列表
     */
    public function type(){
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];

        $list=pdo_fetchall("select * from ".tablename('ox_reclaim_type')." where `uniacid`='$uniacid'   order by sort desc ");

        include $this->template();

    }
    /*
     * 类型添加
     */
    public function type_add(){
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

                $res = pdo_insert('ox_reclaim_type',$data);
                if($res)
                {
                    $this->success('添加成功','home.type');
                }else{
                    $this->error('添加失败','home.type');
                }

            }
        }else{
            $type_info=pdo_get('ox_reclaim_type',array('id'=>$id,'uniacid'=>$_W['uniacid']));
            if($_W['ispost'])
            {
                //修改
                $data=$_GPC['data'];

                $where_data['id'] = $id;
                $where_data['uniacid'] = $_W['uniacid'];
                $res = pdo_update('ox_reclaim_type',$data,$where_data);
                if($res)
                {
                    $this->success('修改成功','home.type');
                }else{
                    $this->error('修改失败','home.type');
                }
            }
        }
        include $this->template();
    }
    /*
    * 删除类型
     */
    public function type_del()
    {
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        if($_GPC['id']){
            $id=$_GPC['id'];
            $res=pdo_delete('ox_reclaim_type',array('id'=>$id,'uniacid'=>$uniacid));
            if($res)
            {
                $this->success('删除成功','home.type');
            }else{
                $this->error('删除失败','home.type');
            }
        }

    }

    /*
    * 类型列表
    */
    public function rule(){
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];

        $list=pdo_fetchall("select * from ".tablename('ox_reclaim_rule')." where `uniacid`='$uniacid'   order by sort desc ");

        include $this->template();

    }
    /*
     * 类型添加
     */
    public function rule_add(){
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

                $res = pdo_insert('ox_reclaim_rule',$data);
                if($res)
                {
                    $this->success('添加成功','home.rule');
                }else{
                    $this->error('添加失败','home.rule');
                }

            }
        }else{
            $type_info=pdo_get('ox_reclaim_rule',array('id'=>$id,'uniacid'=>$_W['uniacid']));
            if($_W['ispost'])
            {
                //修改
                $data=$_GPC['data'];

                $where_data['id'] = $id;
                $where_data['uniacid'] = $_W['uniacid'];
                $res = pdo_update('ox_reclaim_rule',$data,$where_data);
                if($res)
                {
                    $this->success('修改成功','home.rule');
                }else{
                    $this->error('修改失败','home.rule');
                }
            }
        }
        include $this->template();
    }
    /*
    * 删除类型
     */
    public function rule_del()
    {
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        if($_GPC['id']){
            $id=$_GPC['id'];
            $res=pdo_delete('ox_reclaim_rule',array('id'=>$id,'uniacid'=>$uniacid));
            if($res)
            {
                $this->success('删除成功','home.rule');
            }else{
                $this->error('删除失败','home.rule');
            }
        }

    }

    /*
    * 跳转列表
    */
    public function pagesList(){
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        $list=pdo_fetchall("select * from ".tablename('ox_reclaim_pages')." where `uniacid`='$uniacid'   order by sort desc ");
        include $this->template();

    }
    /*
     * 跳转列表
     */
    public function pages_add(){
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

                $res = pdo_insert('ox_reclaim_pages',$data);
                if($res)
                {
                    $this->success('添加成功','home.pagesList');
                }else{
                    $this->error('添加失败','home.pagesList');
                }
            }
        }else{
            $type_info=pdo_get('ox_reclaim_pages',array('id'=>$id,'uniacid'=>$_W['uniacid']));
            if($_W['ispost'])
            {
                //修改
                $data=$_GPC['data'];

                $where_data['id'] = $id;
                $where_data['uniacid'] = $_W['uniacid'];
                $res = pdo_update('ox_reclaim_pages',$data,$where_data);
                if($res)
                {
                    $this->success('修改成功','home.pagesList');
                }else{
                    $this->error('修改失败','home.pagesList');
                }
            }
        }
        include $this->template();
    }
    /*
    * 跳转轮播
     */
    public function pages_del()
    {
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        if($_GPC['id']){
            $id=$_GPC['id'];
            $res=pdo_delete('ox_reclaim_pages',array('id'=>$id,'uniacid'=>$uniacid));
            if($res)
            {
                $this->success('删除成功','home.pagesList');
            }else{
                $this->error('删除失败','home.pagesList');
            }
        }

    }
    /**
     * 价格说明
     */
    public function priceList(){
        global $_W,$_GPC;

        $pageSize = 20;
        $pindex = max(1, intval($_GPC['page']));
        $sql = " SELECT ortp.*,ort.name FROM ".tablename('ox_reclaim_type_price')." ortp 
        LEFT JOIN ".tablename('ox_reclaim_type')." ort ON ortp.`type_id`=ort.`id` 
        WHERE ortp.`uniacid`={$_W['uniacid']}
         order by ortp.sort desc,ortp.type_id 
         LIMIT " . ($pindex - 1) * $pageSize . ",{$pageSize}";
        $total = pdo_fetchcolumn("select count(*) from ".tablename('ox_reclaim_type_price')." ortp 
        LEFT JOIN ".tablename('ox_reclaim_type')." ort ON ortp.`type_id`=ort.`id` 
        WHERE ortp.`uniacid`={$_W['uniacid']}");
        $pager = pagination2($total, $pindex, $pageSize);
        $list=pdo_fetchall($sql);
        include $this->template();
    }

    /**
     * 增加价格说明
     */
    public function price_add(){
        global $_W,$_GPC;
        $detail = pdo_get('ox_reclaim_type_price',['uniacid' => $_W['uniacid'],'id'=>$_GPC['id']]);
        $typeList = pdo_getall('ox_reclaim_type',['uniacid' => $_W['uniacid']],['id','name']);
        if($_W['ispost']){
            if($_GPC['id']){
                pdo_update('ox_reclaim_type_price',$_GPC['data'],['uniacid' => $_W['uniacid'],'id'=>$_GPC['id']]);
            }else{
                $_GPC['data']['uniacid'] = $_W['uniacid'];
                pdo_insert('ox_reclaim_type_price',$_GPC['data']);
            }
            $this->success('保存成功','home.priceList');
        }
        include $this->template();
    }

    /*
    * 价格删除
     */
    public function price_del()
    {
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        if($_GPC['id']){
            $id=$_GPC['id'];
            $res=pdo_delete('ox_reclaim_type_price',array('id'=>$id,'uniacid'=>$uniacid));
            if($res)
            {
                $this->success('删除成功','home.priceList');
            }else{
                $this->error('删除失败','home.priceList');
            }
        }

    }

}