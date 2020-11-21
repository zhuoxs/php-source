<?php
namespace app\admin\controller;

use app\api\controller\Cwx;
use app\base\controller\Admin;
use app\model\Config;
use app\model\Goods;
use app\model\Goodsattr;
use app\model\Goodsattrgroup;
use app\model\Goodsattrsetting;
use app\model\Store;
use app\model\System;
use think\Loader;

class Cgoods extends Admin
{

    public function get_list(){
        $model = $this->model;

        //条件
        $query = function ($query){
            if($_SESSION['admin']['store_id']>0){
                $query->where('store_id',$_SESSION['admin']['store_id']);
            }else{
                $store_id = input('request.store_id',-1);
                if($store_id!= -1){
                    $query->where('store_id',$store_id);
                }
            }
            //关键字搜索
            $key = input('get.key');
            if ($key){
                $query->where('name','like',"%$key%");
            }
            $cat_id = input('get.cat_id');
            if ($cat_id&&$cat_id>0){
                $query->where('cat_id',"$cat_id");
            }
            $cat_id = input('get.cat_id');
            if ($cat_id){
                $query->where('cat_id',"$cat_id");
            }
            $state = input('get.state');
            if ($state){
                if($state == -1){
                    //销售中
                    $query->where('state',1);
                    $query->where('end_time','>=',time());
                    $query->where('begin_time','<=',time());
                }else if($state == -2){
                    //已经下架
                    $query->where("state = 0 OR end_time < ".time());
                }else if($state == -3){
                    //已经过期
                    $query->where('end_time','<',time());
                }else if($state == -4){
                    //未开始
                    $query->where('begin_time','>',time());
                }
            }

            $show_hide_goods = input('get.show_hide_goods');
            if ($show_hide_goods){
                $query->where('is_show',0);
            }else{
                $query->where('is_show',1);
            }
        };
        //排序、分页
        $model->fill_order_limit();

        $list = $model->with(['category','store'])->where($query)->select();
        $sys=new System();
        $zhy_auth=$sys->getZnyAuth();
        foreach ($list as $key=>$value){
            $list[$key]['zny_auth']=$zhy_auth;
        }
        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list
        ];
    }
    public function see(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $id = input('get.id');

        //        获取规格设置
        $attrsetting_model = new Goodsattrsetting();
        $attrsetting_list = $attrsetting_model->where('goods_id',$id)->select();

//        获取规格分组信息
        $attrgroup_model = new Goodsattrgroup();
        $attrgroup_list = $attrgroup_model->with('attrs')->where('goods_id',$id)->select();
        foreach ($attrgroup_list as &$item) {
            $attrs = [];
            foreach ($item['attrs'] as $attr) {
//                处理规格设置
                foreach ($attrsetting_list as &$attrsetting) {
                    if(strpos($attrsetting['key'],",{$attr['name']},") !== false){
                        $attrsetting[$item['name']] = $attr['name'];
                    }
                }

                $attrs[] = $attr['name'];
            }
        }
        $this->view->attrgroup_list = $attrgroup_list;


        $this->view->attrsetting_list = $attrsetting_list;

        $info = $this->model->get($id,['category']);
        $info['pics'] = json_decode($info['pics']);
        $info['videosrc']=tomedia( $info['video']);
        $info['img_details'] = json_decode($info['img_details']);
        $this->view->info = $info;
        return view();
    }

    //    新增页
    public function add(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;

        $this->view->setting = System::get_curr();

        $this->view->attrgroup_list = [];
        $this->view->attrsetting_list = [];

        $info = $this->model;
        $info['details'] = '';
        $info['use_attr'] = 0;
        $info['leader_draw_type'] = isset($info['leader_draw_type']) && $info['leader_draw_type']?$info['leader_draw_type']:0;
        $this->view->info = $info;
        $this->view->is_edit = 0;

        //        获取团长抽成
        $rate = 0;
        $money = 0;

        $store = Store::get($_SESSION['admin']['store_id']);
        if ($store && $store->leader_draw_type == 1){
            $rate = $store->leader_draw_rate;
        }elseif ($store && $store->leader_draw_type == 2){
            $money = $store->leader_draw_money;
        }else{
            $type = Config::get_value('leader_draw_type',1);
            if ($type == 1) {
                $rate = Config::get_value('leader_draw_rate',0);
            }else{
                $money = Config::get_value('leader_draw_money',0);
            }
        }

        $this->view->leader_rate = $rate;
        $this->view->leader_money= $money;
        return view('edit');
    }
    //    编辑页
    public function edit(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $id = input('get.id');

        //        获取规格设置
        $attrsetting_model = new Goodsattrsetting();
        $attrsetting_list = $attrsetting_model->where('goods_id',$id)->select();

//        获取规格分组信息
        $attrgroup_model = new Goodsattrgroup();
        $attrgroup_list = $attrgroup_model->with('attrs')->where('goods_id',$id)->select();
        foreach ($attrgroup_list as &$item) {
            $attrs = [];
            foreach ($item['attrs'] as $attr) {
//                处理规格设置
                foreach ($attrsetting_list as &$attrsetting) {
                    if(strpos($attrsetting['key'],",{$attr['name']},") !== false){
                        $attrsetting[$item['name']] = $attr['name'];
                    }
                }

                $attrs[] = $attr['name'];
            }
        }
        $this->view->attrgroup_list = $attrgroup_list;


        $this->view->attrsetting_list = $attrsetting_list;

        $info = $this->model->get($id);
        $info['pics'] = json_decode($info['pics']);
        $info['videosrc']=tomedia( $info['video']);
        $info['img_details'] = json_decode($info['img_details']);
        $info['leader_draw_type'] = $info['leader_draw_type']?:0;
        $this->view->info = $info;
        $this->view->is_edit = 1;
//        获取团长抽成
        $rate = 0;
        $money = 0;

        $store = Store::get($_SESSION['admin']['store_id']);
        if ($store && $store->leader_draw_type == 1){
            $rate = $store->leader_draw_rate;
        }elseif ($store && $store->leader_draw_type == 2){
            $money = $store->leader_draw_money;
        }else{
            $type = Config::get_value('leader_draw_type',1);
            if ($type == 1) {
                $rate = Config::get_value('leader_draw_rate',0);
            }else{
                $money = Config::get_value('leader_draw_money',0);
            }
        }

        $this->view->leader_rate = $rate;
        $this->view->leader_money= $money;

        return view('edit');
    }
    //    复制编辑页
    public function copy(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $id = input('get.id');

        //        获取规格设置
        $attrsetting_model = new Goodsattrsetting();
        $attrsetting_list = $attrsetting_model->where('goods_id',$id)->select();

//        获取规格分组信息
        $attrgroup_model = new Goodsattrgroup();
        $attrgroup_list = $attrgroup_model->with('attrs')->where('goods_id',$id)->select();
        foreach ($attrgroup_list as &$item) {
            $attrs = [];
            foreach ($item['attrs'] as $attr) {
//                处理规格设置
                foreach ($attrsetting_list as &$attrsetting) {
                    if(strpos($attrsetting['key'],",{$attr['name']},") !== false){
                        $attrsetting[$item['name']] = $attr['name'];
                    }
                }

                $attrs[] = $attr['name'];
            }
        }
        $this->view->attrgroup_list = $attrgroup_list;


        $this->view->attrsetting_list = $attrsetting_list;


        $info = $this->model->get($id,['category','platform_category']);
        $info['pics'] = json_decode($info['pics']);
        unset($info->id);
        $this->view->info = $info;
        return view('edit');
    }
    //    数据保存（新增、编辑）
    public function save(){
        $info = $this->model;

        $id = input('post.id');
        if ($id) {
            $info = $info->get($id, 'category');
        }

        $data = input('post.');
//        补充商户id信息
        if (!$data['store_id']){
            $data['store_id'] = $_SESSION['admin']['store_id'];
        }

        $data['check_state'] = 2;
//        判断是否需要重新审核
        if ($data['store_id']&&$_SESSION['admin']['store_id']>0){
            if($id){
                $config = Config::get_value('goods_update_check',0);
            }else{
                $config = Config::get_value('goods_insert_check',0);
            }
            if ($config){
                $data['check_state'] = 1;
                $data['fail_reason'] = '';
            }
        }

        $data['pics'] = json_encode($data['pics']);
        $data['img_details'] = json_encode($data['img_details']);
        $data['videosrc']=tomedia( $data['video']);
        $ret = $info->allowField(true)->save($data);

        if($ret){
            if($info->use_attr){
//            修改分组信息的 goods_id
                $attrs_data = $data['attrs_data'];
                $attrs_data = json_decode($attrs_data);

                $attrgroup_model = new Goodsattrgroup();
                $group_list = [];
                foreach ($attrs_data as $key => $attr_group) {
                    if (!$attr_group){
                        continue;
                    }
                    $group_data = [];
                    $group_data['id'] = $key;
                    $group_data['goods_id'] = $info->id;
                    $group_list[] = $group_data;
                }
                $attrgroup_model->saveAll($group_list);

//              保存规格设置
                $attrsettings = $data['attr'];
                $attrsettings = json_decode($attrsettings);

                $attrsetting_model = new Goodsattrsetting();
                $attrsetting_model->where('goods_id',$info->id)->delete();

                $num = 0;
                foreach ($attrsettings as $attrsetting) {
                    $attrsetting = (array)$attrsetting;
                    $num += $attrsetting['stock'];
                    $attrsetting_model = new Goodsattrsetting();
                    $attrsetting = (array)$attrsetting;
                    $attrsetting['goods_id'] = $info->id;

//                name
                    $names = [];
                    foreach ($attrs_data as $key => $attr_group) {
                        if (!$attr_group){
                            continue;
                        }
                        $attr_group = (array)$attr_group;
                        $names[] = $attrsetting[$attr_group['name']];
                    }
                    $attrsetting['key'] = ','.implode(',',$names).',';
                    $attrsetting['attr_ids'] = $attrsetting['ids']? ','.implode(',',$attrsetting['ids']).',':$attrsetting['attr_ids'];

                    $attrsetting_model->allowField(true)->save($attrsetting);
                }
                $info->stock = $num;
                $info->save();
            }

            return array(
                'code'=>0,
                'data'=>$info->id,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'保存失败',
            );
        }
    }
    //    审核商品列表页
    public function index2()
    {
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view();
    }
    public function get_list2(){
        $model = $this->model;

        //条件
        $query = function ($query){
            $query->where('store_id',['<>',0]);
//            $query->where('check_state',1);
            //关键字搜索
            $key = input('get.key');
            if ($key){
                $query->where('name','like',"%$key%");
            }
        };

        //排序、分页
        $model->fill_order_limit();

        $list = $model->with(['store','category'])->where($query)->order('check_state')->select();

        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }

    public function batchBeginTime(){
        $query = function ($query){
            $ids = input("post.ids");
            if($ids){
                $query->where('id',['in',$ids]);
            }
            //$query->where('store_id',$_SESSION['admin']['store_id']);
            //关键字搜索
            $key = input('post.key');
            if ($key){
                $query->where('name','like',"%$key%");
            }
            $cat_id = input('post.cat_id');
            if ($cat_id&&$cat_id>0){
                $query->where('cat_id',"$cat_id");
            }
            $state = input('post.state');
            if ($state){
                if($state == -1){
                    //销售中
                    $query->where('state',1);
                    $query->where('end_time','>=',time());
                    $query->where('begin_time','<=',time());
                }else if($state == -2){
                    //已经下架
                    $query->where("state = 0 OR end_time < ".time());
                }else if($state == -3){
                    //已经过期
                    $query->where('end_time','<',time());
                }else if($state == -4){
                    //未开始
                    $query->where('begin_time','>',time());
                }
            }
        };
        $list = Goods::where($query)
            ->select();

        $date = input('request.date');

        $ret = 0;
        foreach ($list as $item) {
            $item->begin_time = $date;
            $reti = $item->save();
            if ($reti) $ret ++;
        }

        if ($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                '修改失败',
            );
        }
    }
    public function batchEndTime(){
        $query = function ($query){
            $ids = input("post.ids");
            if($ids){
                $query->where('id',['in',$ids]);
            }
//            $query->where('store_id',$_SESSION['admin']['store_id']);
            //关键字搜索
            $key = input('post.key');
            if ($key){
                $query->where('name','like',"%$key%");
            }
            $cat_id = input('post.cat_id');
            if ($cat_id&&$cat_id>0){
                $query->where('cat_id',"$cat_id");
            }
            $state = input('post.state');
            if ($state){
                if($state == -1){
                    //销售中
                    $query->where('state',1);
                    $query->where('end_time','>=',time());
                    $query->where('begin_time','<=',time());
                }else if($state == -2){
                    //已经下架
                    $query->where("state = 0 OR end_time < ".time());
                }else if($state == -3){
                    //已经过期
                    $query->where('end_time','<',time());
                }else if($state == -4){
                    //未开始
                    $query->where('begin_time','>',time());
                }
            }
        };
        $list = Goods::where($query)
            ->select();

        $date = input('request.date');

        $ret = 0;
        foreach ($list as $item) {
            $item->end_time = $date;
            $reti = $item->save();
            if ($reti) $ret ++;
        }

        if ($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                '修改失败',
            );
        }
    }
    public function batchSendTime(){
        $query = function ($query){
            $ids = input("post.ids");
            if($ids){
                $query->where('id',['in',$ids]);
            }
//            $query->where('store_id',$_SESSION['admin']['store_id']);
            //关键字搜索
            $key = input('post.key');
            if ($key){
                $query->where('name','like',"%$key%");
            }
            $cat_id = input('post.cat_id');
            if ($cat_id&&$cat_id>0){
                $query->where('cat_id',"$cat_id");
            }
            $state = input('post.state');
            if ($state){
                if($state == -1){
                    //销售中
                    $query->where('state',1);
                    $query->where('end_time','>=',time());
                    $query->where('begin_time','<=',time());
                }else if($state == -2){
                    //已经下架
                    $query->where("state = 0 OR end_time < ".time());
                }else if($state == -3){
                    //已经过期
                    $query->where('end_time','<',time());
                }else if($state == -4){
                    //未开始
                    $query->where('begin_time','>',time());
                }
            }
        };
        $list = Goods::where($query)
            ->select();

        $date = input('request.date');

        $ret = 0;
        foreach ($list as $item) {
            $item->send_time = $date;
            $reti = $item->save();
            if ($reti) $ret ++;
        }

        if ($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                '修改失败',
            );
        }
    }

    public function batchReceiveTime(){
        $query = function ($query){
            $ids = input("post.ids");
            if($ids){
                $query->where('id',['in',$ids]);
            }
//            $query->where('store_id',$_SESSION['admin']['store_id']);
            //关键字搜索
            $key = input('post.key');
            if ($key){
                $query->where('name','like',"%$key%");
            }
            $cat_id = input('post.cat_id');
            if ($cat_id&&$cat_id>0){
                $query->where('cat_id',"$cat_id");
            }
            $state = input('post.state');
            if ($state){
                if($state == -1){
                    //销售中
                    $query->where('state',1);
                    $query->where('end_time','>=',time());
                    $query->where('begin_time','<=',time());
                }else if($state == -2){
                    //已经下架
                    $query->where("state = 0 OR end_time < ".time());
                }else if($state == -3){
                    //已经过期
                    $query->where('end_time','<',time());
                }else if($state == -4){
                    //未开始
                    $query->where('begin_time','>',time());
                }
            }
        };
        $list = Goods::where($query)
            ->select();

        $date = input('request.date');

        $ret = 0;
        foreach ($list as $item) {
            $item->receive_time = $date;
            $reti = $item->save();
            if ($reti) $ret ++;
        }

        if ($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                '修改失败',
            );
        }
    }
    //强制上架
    //    启用
    public function mandatory(){
        $ids = input("post.ids");
        $state = input("post.value");
        $ret = $this->model->where('id','in',$ids)->update(['mandatory'=>$state]);
        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>"失败"
            );
        }
    }
//    后台显示
    public function batchadminshow(){
        $ids = input("post.ids");
        $ret = $this->model->where('id','in',$ids)->update(['is_show'=>1]);
        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'显示失败',
            );
        }
    }
//    后台隐藏
    public function batchadminhide(){
        $ids = input("post.ids");
        $ret = $this->model->where('id','in',$ids)->update(['is_show'=>0]);
        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'隐藏失败',
            );
        }
    }

    /**
     * 挚能云商品列表
    */
    public function znygoods()
    {
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view();
    }
    /**
     * 下载商品
    */
    public function downloadGoods(){
        global $_W,$_GPC;
        $goods_id=input('post.goods_id');
        $set=System::get_curr();
        if($set['zny_apid']&&$set['zny_apikey']){
            $url='https://api.znymall.cn/index.php?s=/api/Openapi/apiGetGoodsInfo';
            $new =new Cwx();
            $data['apid']=$set['zny_apid'];
            $data['apikey']=$set['zny_apikey'];
            $data['goods_id']=$goods_id;
            $res=$new ->https_request($url,$data);
            $return_data=json_decode($res,true);
            if($return_data['code']>0){
                return array('code'=>$return_data['code'], 'msg'=>$return_data['msg'],);
            }else{
                $data=$return_data['data'];
                $imglist=$data['img_list'];
                $newarr=array();
                $pic_sise=input('post.size',0);
                foreach ($imglist as $key=>$val){
                    if($pic_sise==0){
                        if($val['domain']=='http://qiniu.znymall.cn'){
                            $imgurl=$val['pic_cover'];
                        }else{
                            $imgurl=$return_data['other']['imgroot'].'/'.$val['pic_cover'];
                        }
                    }elseif($pic_sise==1){
                        if($val['domain']=='http://qiniu.znymall.cn'){
                            $imgurl=$val['pic_cover_big'];
                        }else{
                            $imgurl=$return_data['other']['imgroot'].'/'.$val['pic_cover_big'];
                        }
                    }elseif($pic_sise==2){
                        if($val['domain']=='http://qiniu.znymall.cn'){
                            $imgurl=$val['pic_cover_mid'];
                        }else{
                            $imgurl=$return_data['other']['imgroot'].'/'.$val['pic_cover_mid'];
                        }
                    }elseif($pic_sise==3){
                        if($val['domain']=='http://qiniu.znymall.cn'){
                            $imgurl=$val['pic_cover_small'];
                        }else{
                            $imgurl=$return_data['other']['imgroot'].'/'.$val['pic_cover_small'];
                        }
                    }elseif($pic_sise==4){
                        if($val['domain']=='http://qiniu.znymall.cn'){
                            $imgurl=$val['pic_cover_micro'];
                        }else{
                            $imgurl=$return_data['other']['imgroot'].'/'.$val['pic_cover_micro'];
                        }
                    }
                    $pic=$this->downloadImage($imgurl);
                    array_push($newarr,$pic);
                }
                $return_data['data']['description']=$this->changeContentPic($return_data['data']['description']);
                $return_data['data']['img_arr']=$newarr;
                return array('code'=>0, 'msg'=>'success','data'=>$return_data,'other'=>$_W['attachurl']);
            }
        }else{
            return array('code'=>1, 'msg'=>'请先配置参数',);
        }
    }
    /**
     * 上传商品
    */
    public function uploadZny(){
        global $_W;
        $id=input('post.id');
        $goodsinfo=Goods::get($id);
        if ($goodsinfo['zny_goods_id']>0||($goodsinfo['zny_goods_id']==null&&$goodsinfo['is_upload_zny']==0)){
            $data['goods_name']=$goodsinfo['name'];
//        $data['market_price']=$goodsinfo['name'];//市场价
            $data['price']=$goodsinfo['original_price'];//原价
            $data['promotion_price']=$goodsinfo['price'];//商品促销价格
            $data['cost_price']=$goodsinfo['cost_price'];//成本价
            $data['sort']=$goodsinfo['index'];//排序
            $data['stock']=$goodsinfo['stock'];
            $data['max_buy']=$goodsinfo['limit'];
            $data['sales']=$goodsinfo['sales_num'];
            $data['introduction']=$goodsinfo['service'];//商品简介
            $data['description']=$goodsinfo['details'];//商品详情
            $data['picture']=$_W['attachurl'].$goodsinfo['pic'];
            $data['pics']=$goodsinfo['pics'];
            $data['imgroot']=$_W['attachurl'];
            $data['goods_id']=$goodsinfo['zny_goods_id'];
            $system=System::get_curr();
            if($system['zny_apid']&&$system['zny_apikey']){
                $data['apid']=$system['zny_apid'];
                $data['apikey']=$system['zny_apikey'];
            }else{
                return_json('请先配置api接口参数',1);
            }
            $new =new Cwx();
            $url='https://api.znymall.cn/index.php?s=/api/Openapi/apiUploadGoods';
//            var_dump($data);exit;
            $res=$new ->https_request($url,$data);
            $return_data=json_decode($res,true);

            if($return_data['code']>0){
                return array('code'=>$return_data['code'], 'msg'=>$return_data['msg'],);
            }else{
                Goods::update(['is_upload_zny'=>1,'zny_goods_id'=>$return_data['data']['goods_id']],['id'=>$id]);
                return array('code'=>0, 'msg'=>'success','data'=>json_decode($res,true),);
            }
        }else{
            return array('code'=>-1, 'msg'=>'请勿重复上传',);
        }

    }
    public function test1(){
        $set=System::get_curr();
        if($set['zny_apid']&&$set['zny_apikey']){
            $url='https://api.znymall.cn/index.php?s=/api/Openapi/apiGetGoodsInfo';
            $new =new Cwx();
            $data['apid']=$set['zny_apid'];
            $data['apikey']=$set['zny_apikey'];
            $data['goods_id']=132;
            $res=$new ->https_request($url,$data);
            $return_data=json_decode($res,true);
            $content=$return_data['data']['description'];
            $a= $this->changeContentPic($content);
            var_dump($a);exit;
        }

    }
    /**
     * 富文本图片转存
    */

    function changeContentPic($content)
    {
        global $_W;
        $pregRule = "/<[img|IMG].*?src=[\'|\"](.*?(?:[\.jpg|\.jpeg|\.png|\.gif|\.bmp]))[\'|\"].*?[\/]?>/";
        preg_match_all($pregRule,$content,$array,PREG_PATTERN_ORDER);
        $replaceArr = array();
        foreach($array[1] as $value) {
            array_push($replaceArr, $_W['attachurl'].$this->downloadImage($value));
        }
        $replaceStr = str_replace($array[1], $replaceArr, $content);
        return $replaceStr;


    }

    function downloadImage($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_NOBODY, 0); // 只取body头
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $package = curl_exec($ch);
        $httpinfo = curl_getinfo($ch);
        curl_close($ch);
        $imageAll = array_merge(array(
              'imgBody' => $package
        ), $httpinfo);
        $path=IA_ROOT."/attachment/";
        file_put_contents($path,$package);
        //        文件名
        $filename = time().rand(10000,99999).'.png';
        file_put_contents($path. $filename, $package);
        //远程附件存储
        @require_once (IA_ROOT."/framework/function/file.func.php");
        @$filename=$filename;
        @file_remote_upload($filename);
        return $filename;
    }
    public function test(){
        echo date("Y-m-d H:i:s" ,1559232000);
    }
}
