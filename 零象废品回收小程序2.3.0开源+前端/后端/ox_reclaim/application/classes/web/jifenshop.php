<?php

class Web_Jifenshop extends Web_Base
{
    /**
     * 积分商城设置
     */
    public function index()
    {
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        load()->func('tpl');
        $result=pdo_fetch("SELECT * FROM ".tablename('ox_reclaim_shop_info')." where `uniacid`={$_W['uniacid']} limit 1");
        if($_W['ispost']){
            $data=$_GPC['data'];
            if(!empty($result)){
                $res=pdo_update('ox_reclaim_shop_info',$data,array('uniacid'=>$uniacid));
            }else{
                $data['uniacid'] = $_W['uniacid'];
                $res=pdo_insert('ox_reclaim_shop_info',$data);
            }
            if(!empty($res)){
                $this->success('修改成功','jifenshop/index');
            }else{
                $this->success('修改失败','jifenshop/index');
            }
        }
        include $this->template();
    }
    /**
     * 商品列表
     */
    public function goodslist(){
        global $_W,$_GPC;

        $where = ' and del_time=0 ';
        $keyword = $_GPC['keyword'];
        if(!empty($keyword))
        {
            $where .= "and title like '%".$keyword."%' ";
        }

        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $list=pdo_fetchall("select * from ".tablename('ox_reclaim_goods')."   where `uniacid`= {$_W['uniacid']}  ".$where." order by create_time desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
        $total = pdo_fetchcolumn("select count(*) from ".tablename('ox_reclaim_goods')." where `uniacid`= {$_W['uniacid']} ".$where);

        $pager = pagination2($total, $pindex, $psize);
        $i=($pindex - 1) * $psize+1;
        include $this->template();
    }
    /**
     * 商品添加
     */
    public function goodsadd(){
        global $_W,$_GPC;
        $id = $_GPC['id'];
        if(empty($id))
        {
            $info = array();
            if($_W['ispost'])
            {
                //添加
                $data = $_GPC['data'];
                $data['create_time'] = time();
                $data['uniacid'] = $_W['uniacid'];
                $data['img'] = $_GPC['dataimg'][0];

                $res = pdo_insert('ox_reclaim_goods',$data);
                $order_id = pdo_insertid();
                if($res)
                {
                    $img_arr = [
                        'uniacid'=>$_W['uniacid'],
                        'order_id'=>$order_id,
                        'type'=>2,
                        'create_time'=>time(),
                    ];
                    if(!empty($_GPC['dataimg'])){
                        foreach ($_GPC['dataimg'] as $k=>$v){
                            $img_arr['img'] = $v;
                            pdo_insert('ox_reclaim_image',$img_arr);
                        }
                    }

                    $this->success('添加成功','jifenshop/goodslist');
                }else{
                    $this->error('添加失败','jifenshop/goodslist');
                }

            }
        }else{
            $info = pdo_get('ox_reclaim_goods',array('id'=>$id));
            $imgs = pdo_getall('ox_reclaim_image',array('uniacid'=>$_W['uniacid'], 'order_id'=>$id,'type'=>2));
            $imgs_path = [];
            foreach ($imgs as $k =>$v){
                $imgs_path[] = $v['img'];
            }
            if($_W['ispost'])
            {
                pdo_delete('ox_reclaim_image',['uniacid'=>$_W['uniacid'], 'order_id'=>$id,'type'=>2]);
                $img_arr = [
                    'uniacid'=>$_W['uniacid'],
                    'order_id'=>$id,
                    'type'=>2,
                    'create_time'=>time(),
                ];
                if(!empty($_GPC['dataimg'])) {
                    foreach ($_GPC['dataimg'] as $k => $v) {
                        $img_arr['img'] = $v;
                        pdo_insert('ox_reclaim_image', $img_arr);
                    }
                }
                //修改
                $data = $_GPC['data'];
                $data['img'] = $_GPC['dataimg'][0];

                $where_data['id'] = $id;
                $where_data['uniacid'] = $_W['uniacid'];

                $res = pdo_update('ox_reclaim_goods',$data,$where_data);
                if($res)
                {
                    $this->success('修改成功','jifenshop/goodslist');
                }
                else{
                    $this->error('修改失败','jifenshop/goodslist');
                }
            }
        }
        include $this->template();
    }
    /**
     * 商品删除
     */
    public function goods_del(){
        global $_W,$_GPC;
        $id = $_GPC['id'];
        if($_W['ispost'])
        {
            //删除
            $where_data['id'] = $id;
            $where_data['uniacid'] = $_W['uniacid'];

            $res = pdo_update('ox_reclaim_goods',array('del_time'=>time()),$where_data);
            if($res)
            {
                $this->success('删除成功','jifenshop/goodslist');
            }else{
                $this->error('删除失败','jifenshop/goodslist');
            }
        }
        $this->error('删除失败','jifenshop/goodslist');
    }

    /**
     * 商品上下架
     */
    public function updown(){
        global $_W,$_GPC;
        $id = $_GPC['id'];
        if($_W['ispost'])
        {
            if($_GPC['state']==1){
                $data['state'] = 2;
            }else{
                $data['state'] = 1;
            }
            $where_data['id'] = $id;
            $where_data['uniacid'] = $_W['uniacid'];

            $res = pdo_update('ox_reclaim_goods',$data,$where_data);
            if($res)
            {
                $this->success('发货成功','jifenshop/goodslist');
            }else{
                $this->error('发货失败','jifenshop/goodslist');
            }
        }
        $this->error('发货失败','jifenshop/goodslist');
    }
    /**
     * 兑换商品订单
     */
    public function order(){
        global $_GPC, $_W;
        $status = [ '已兑换', '已发货', '已完成'];
        $query = "";
        if($_GPC['keyword']){
            $query = " AND (name like '%{$_GPC['keyword']}%' or  phone like '%{$_GPC['keyword']}%' or o_sn like '%{$_GPC['keyword']}%')";
        }
        $pageSize = 20;
        $_GPC['page'] = $_GPC['page'] ?: 1;
        $pageCur = ($_GPC['page']-1) * $pageSize;
        $sql = "SELECT *  FROM ".tablename('ox_reclaim_shop_order')." WHERE uniacid = {$_W['uniacid']} {$query} ORDER BY id DESC LIMIT {$pageCur},{$pageSize}";
        $list = pdo_fetchall($sql);
        foreach ($list as $k => $v){
            $member = pdo_get('ox_reclaim_member',array('uid'=>$v['uid']));
            $list[$k]['nickname'] = $member['nickname'] ;
        }
        $total = pdo_fetchcolumn("select count(*) from ".tablename('ox_reclaim_shop_order')."  where `uniacid`= {$_W['uniacid']}  {$query}  ");
        $pager = pagination2($total, $pageCur, $pageSize);
        include $this->template();
    }
    /*
     * 发货按钮
     */
    public function order_fahuo(){
        global $_W,$_GPC;
        $id = $_GPC['id'];
        if($_W['ispost'])
        {
            $data['status'] = 2;
            $data['fahuo_time'] = time();
            $where_data['id'] = $id;
            $where_data['uniacid'] = $_W['uniacid'];

            $res = pdo_update('ox_reclaim_shop_order',$data,$where_data);
            if($res)
            {
                $this->success('发货成功','',2);
            }else{
                $this->error('发货失败','',2);
            }
        }
        $this->error('发货失败','',2);
    }
}