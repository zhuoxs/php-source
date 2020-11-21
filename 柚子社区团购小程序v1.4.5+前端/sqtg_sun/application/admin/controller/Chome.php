<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/9
 * Time: 15:24
 */
namespace app\admin\controller;

use app\base\controller\Admin;
use app\model\Coupon;
use app\model\Homepage;
use app\model\Customize;
use app\model\Homepagetem;
use app\model\Shop;
use app\model\System;
use app\model\Topic;
use think\Db;

class Chome extends Admin{
    public function homepage(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $home=new Homepage();
        $info=$home->mfind(['uniacid'=>$_W['uniacid']]);
        $this->view->info=$info;
        return view('homepage');
    }
    public function getHomepage(){
        global $_W,$_GPC;
        $home=new Homepage();
        $id=input('post.id',0);
        if($id>0){
            $whereh['id']=$id;
        }else{
            $whereh=['uniacid'=>$_W['uniacid'],'is_default'=>1];
        }
        $info=$home->mfind($whereh);
        //底部导航
        $cus=new Customize();
        $where['type']=3;
        $where['state']=1;
        $order['sort']='asc';

        //        判断多商户是否开启
        $config = \app\model\Config::get(['key'=>'mstore_switch']);
        if (!$config['value']){
            $where['url']=['<>','/sqtg_sun/pages/zkx/pages/merchants/merchants/merchant'];
        }
        $navlist=$cus->where($where)->order($order)->select();
        $other['footnav']=$navlist;
        $other['img_root'] = $_W['attachurl'];
        //基础配置
        $sys=new System();
        $other['system']=$sys->mfind(['uniacid'=>$_W['uniacid']]);
        return_json('success',0,$info,$other);
    }
    public function pageselect(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $this->view->linkurl=$this->getWxAppUrl();

        $this_id = input('param.select_id');
        $this_type=input('param.this_type');
        $this->assign('this_id', $this_id);
        $this->assign('this_type', $this_type);


        return view('pageselect');
    }
    //地图
    public function pagemap(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view('pagemap');
    }
    //富文本
    public function richtxt(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $val = input('param.val');
        $this->assign('val', $val);
        return view('richtxt');
    }
    //获取小程序内部链接
    public function getWxAppUrl(){
        $pluginkey=Db::name('pluginkey')->field('name,value')->select();
        $url=getWxAppUrl();
        if($pluginkey){
            foreach ($pluginkey as $val){
                if(!empty($val['value'])) {
                    $url[] = $val;
                }
            }
        }
        return $url;
    }
    //商品选择
    public function shopselect(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;

        $this_id = input('param.select_id');
        $this_type=input('param.this_type');
        $jump_type=input('param.jump_type', 0);
        $this->assign('this_id', $this_id);
        $this->assign('this_type', $this_type);
        $this->assign('jump_type', $jump_type);

        return view('shopselect');
    }
    public function get_goods_list(){
        global $_W;
        $model =new \app\model\Goods();
        //排序、分页
        $model->fill_order_limit();
        $where['uniacid']=$_W['uniacid'];
        $key=input('get.key');
        if($key){
            $where['name']=['like',"%$key%"];
        }
        $where['check_state']=1;
        $where['state']=1;
        $list = $model->where($where)->select();
        foreach ($list as $key =>$value){
            $list[$key]['pic']=$_W['attachurl'].$value['pic'];
        }
        return [
            'code'=>0,
            'count'=>$model->where($where)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    //TODO::保存模板
    public function save_tem(){
        global $_W;
        $val=json_decode($_POST['index_list'],true);
        $index_val=json_encode($val);
        $model=new Homepage();
        $info=$model->mfind(['uniacid'=>$_W['uniacid']]);
        if($info){
            $pic=$this->base64_image_content($_POST['pic']);
            $ret=$model->save(['index_value'=>$index_val,'pic'=>$pic,'name'=>$_POST['name'],'system_value'=>$_POST['sys_set'],'footnav_value'=>$_POST['sendnav']],['id'=>$_POST['id'],]);
            $id=$_POST['id'];
            $nowinfo=$model->mfind(['id'=>$id]);
            if($nowinfo['is_default']==1){
                $this->updateSet($id);
            }
        }else{
            $ret=Db::name('homepage')->insertGetId(['index_value'=>$index_val,'uniacid'=>$_W['uniacid'],'create_time'=>time(),'name'=>$_POST['name'],'system_value'=>$_POST['sys_set'],'footnav_value'=>$_POST['sendnav']]);
//            $ret=$model->allowField(true)->save(['index_value'=>$index_val]);
            $id=$ret;
        }

        if($ret){
            return array(
                'code'=>0,
                'msg'=>'保存成功',
                'data'=>$id,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'保存失败',
            );
        }
    }

    //TODO::添加到我的模板
    public function add_mytem(){
        global $_W;

        $tem=new Homepage();
        $pic=input('post.pic');
        $data['pic']=$this->base64_image_content($pic);
        $data['name']=input('post.name');
        $data['index_value']=input('post.index_value');
        $data['system_value']=input('post.sys_set');
        $data['footnav_value']=input('post.sendnav');
        $data['create_time']=time();
        $ret=$tem->allowField(true)->save($data);

        if($ret){
            return array(
                'code'=>0,
                'msg'=>'添加成功',
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'添加失败',
            );
        }
    }
    //TODO:;base64转图片
    function base64_image_content($base64_image_content){
        //匹配出图片的格式
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
            $type = $result[2];
//            $new_file = $path."/".date('Ymd',time())."/";
            $path=IA_ROOT."/attachment/";
            $filepath = $path."/homgpageimg/";
            if(!file_exists($filepath)){
                //检查是否有该文件夹，如果没有就创建，并给予最高权限
                mkdir($filepath, 0700);
            }
            $name=time().".{$type}";
            $new_file = $filepath.$name;
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){
                $lastname='homgpageimg/'.$name;

                return $lastname;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    //TODO::我的模板
    public function mytemplate(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        //排序、分页
        $model=new Homepage();
        $where['uniacid']=$_W['uniacid'];
        $order['create_time']='asc';
        $list = $model->where($where)->order($order)->select();
        $list=json_decode(json_encode($list),true);
        foreach ($list as $key =>$value){
            $list[$key]['img']=$_W['attachurl'].$value['pic'];
            $list[$key]['create_time']=date('Y-m-d H:i:s',$value['create_time']);
        }
//        var_dump($list);exit;
        $this->view->list=$list;

        return view('mytemplate');
    }
    //TODO::选用模板
    public function checkTem(){
        global $_W,$_GPC;
        $id=input('post.id');
        Homepage::update(['is_default'=>0],['uniacid'=>$_W['uniacid']]);
        $res=Homepage::update(['is_default'=>1],['id'=>$id]);
        if($res){
            $this->updateSet($id);
            return array(
                'code'=>0,
                'msg'=>'选用成功',
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'选用失败',
            );
        }
    }
    public function nocheckTem(){
        global $_W,$_GPC;
        $id=input('post.id');
        $res=Homepage::update(['is_default'=>0],['id'=>$id]);
        if($res){
            $this->updateSet($id);
            return array(
                'code'=>0,
                'msg'=>'取消选用成功',
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'取消选用失败',
            );
        }
    }
    //TODO::修改基础设置、底部导航
    public function updateSet($id){
        global $_W;
        $home=new Homepage();
        $info=$home->mfind(['id'=>$id]);
        $system_val=json_decode($info['system_value'],true);
        //基础设置
        $sysdata['index_title']=$system_val['index_title'];
        $sysdata['fontcolor']=$system_val['fontcolor'];
        $sysdata['top_color']=$system_val['top_color'];
        $sysdata['bottom_color']=$system_val['bottom_color'];
        $sysdata['bottom_fontcolor_a']=$system_val['bottom_fontcolor_a'];
        $sysdata['bottom_fontcolor_b']=$system_val['bottom_fontcolor_b'];
        $sys=new System();
        $sys->allowField(true)->save($sysdata,array('uniacid'=>$_W['uniacid']));
        //底部导航
        $cus=new Customize();
        $sendnav=json_decode($info['footnav_value'],true);
        $cus->where(['type'=>3,'uniacid'=>$_W['uniacid']])->delete();
        foreach ($sendnav as $key=>$value){
            $sendnav[$key]['uniacid']=$_W['uniacid'];
            $sendnav[$key]['create_time']=time();
        }
        Db::name('customize')->insertAll($sendnav);
    }
    //TODO::删除模板
    public function delTem(){
        global $_W,$_GPC;
        $id=input('post.id');
        $home=new Homepage();
        $res=$home->where(['id'=>$id])->delete();
        if($res){
            return array(
                'code'=>0,
                'msg'=>'删除成功',
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'删除失败',
            );
        }
    }

    //TODO;:门店选择
    public function storeselect(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;

        $this_id = input('param.select_id');
        $this_type=input('param.this_type');
        $jump_type=input('param.jump_type', 0);
        $this->assign('this_id', $this_id);
        $this->assign('this_type', $this_type);
        $this->assign('jump_type', $jump_type);


        return view('storeselect');
    }
    public function get_store_list(){
        global $_W;
        $model =new Shop();
        //排序、分页
        $model->fill_order_limit();
        $where['uniacid']=$_W['uniacid'];
        $key=input('get.key');
        if($key){
            $where['name']=['like',"%$key%"];
        }
        $where['is_del']=0;
        $list = $model->where($where)->select();
        foreach ($list as $key =>$value){
            $list[$key]['pic']=$_W['attachurl'].$value['pic'];
        }
        return [
            'code'=>0,
            'count'=>$model->where($where)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    //TODO;:优惠券选择
    public function couponselect(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;

        $this_id = input('param.select_id');
        $this_type=input('param.this_type');
        $jump_type=input('param.jump_type', 0);
        $this->assign('this_id', $this_id);
        $this->assign('this_type', $this_type);
        $this->assign('jump_type', $jump_type);

        return view('couponselect');
    }
    public function get_coupon_list(){
        global $_W;
        $model =new Coupon();
        //排序、分页
        $model->fill_order_limit();
        $where['uniacid']=$_W['uniacid'];
        $key=input('get.key');
        if($key){
            $where['name']=['like',"%$key%"];
        }
        $where['state']=1;
        $list = $model->where($where)->select();

        return [
            'code'=>0,
            'count'=>$model->where($where)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    //TODO;:话题选择
    public function topicselect(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;

        $this_id = input('param.select_id');
        $this_type=input('param.this_type');
        $jump_type=input('param.jump_type', 0);
        $this->assign('this_id', $this_id);
        $this->assign('this_type', $this_type);
        $this->assign('jump_type', $jump_type);

        return view('topicselect');
    }
    public function get_topic_list(){
        global $_W;
        $model =new Topic();
        //排序、分页
        $model->fill_order_limit();
        $where['uniacid']=$_W['uniacid'];
        $key=input('get.key');
        if($key){
            $where['title']=['like',"%$key%"];
        }
        $list = $model->where($where)->select();
        foreach ($list as $key =>$value){
            $list[$key]['pic']=$_W['attachurl'].$value['pic'];
        }
        return [
            'code'=>0,
            'count'=>$model->where($where)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    //TODO;:话题选择
    public function videoselect(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;

        $this_id = input('param.select_id');
        $this_type=input('param.this_type');
        $jump_type=input('param.jump_type', 0);
        $this->assign('this_id', $this_id);
        $this->assign('this_type', $this_type);
        $this->assign('jump_type', $jump_type);

        return view('videoselect');
    }
    public function get_video_list(){
        global $_W;
        $model =new \app\model\Video();
        //排序、分页
        $model->fill_order_limit();
        $where['uniacid']=$_W['uniacid'];
        $key=input('get.key');
        if($key){
            $where['title']=['like',"%$key%"];
        }
        $where['state']=1;
        $list = $model->where($where)->select();
        foreach ($list as $key =>$value){
            $list[$key]['pic']=$_W['attachurl'].$value['img'];
        }
        return [
            'code'=>0,
            'count'=>$model->where($where)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
}
