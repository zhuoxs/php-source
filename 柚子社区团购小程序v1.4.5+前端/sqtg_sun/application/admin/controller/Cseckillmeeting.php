<?php
namespace app\admin\controller;

use app\base\controller\Admin;
use app\model\Goodsattrsetting;
use app\model\Seckillgoods;
use app\model\Seckillgoodsattrsetting;
use app\model\Seckillmeeting;
use app\model\Seckilltopic;

class Cseckillmeeting extends Admin
{

//    获取列表页数据
    public function get_list(){
        $model = $this->model;

        //条件
        $query = function ($query){
            //关键字搜索
            $key = input('get.key');
            if ($key){
                $query->where('name','like',"%$key%");
            }
            $seckilltopic_id = input('get.seckilltopic_id');
            if ($seckilltopic_id){
                $query->where('seckilltopic_id',$seckilltopic_id);
            }
        };

        //排序、分页
        $model->fill_order_limit();

        $list = $model->where($query)->select();

        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }

    public function select2(){
        $seckilltopic_model = new Seckilltopic();
        $list = $seckilltopic_model
            ->where('state',1)
            ->field("id as value,name as label")
            ->select();

        $seckillmeeting_model = new Seckillmeeting();
        foreach ($list as &$item) {
            $item['children'] = $seckillmeeting_model
                ->field("id as value,name as label")
                ->where('seckilltopic_id',$item['value'])
                ->where('state',1)
                ->select();
        }
        return $list;
    }
    //    数据保存（新增、编辑）
    public function save(){
        $info = $this->model;

        $id = input('post.id');
        if ($id){
            $info = $info->get($id);
        }
        $data = input('post.');
        $data['hours'] = implode(',',array_keys($data['hours']));
        $ret = $info->allowField(true)->save($data);

        if($ret){
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
    //    编辑页
    public function edit(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $id = input('get.id');
        $info = $this->model->get($id,'seckilltopic');
        $info['hours'] = $info['hours']?explode(',',$info['hours']):[];
        $this->view->info = $info;

        return view('edit');
    }
    //    编辑页
    public function goodsedit(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $id = input('get.id');
        $info = $this->model->get($id,'seckilltopic');
        $info['hours'] = $info['hours']?explode(',',$info['hours']):[];
        $this->view->info = $info;

        $seckillgoods = new Seckillgoods();
        $list = $seckillgoods
            ->with(['attrgroups','attrsetting'])
            ->where('seckillmeeting_id',$id)
            ->where('store_id',$_SESSION['admin']['store_id'])
            ->select();

        $new_list = [];
        foreach ($list as $item) {
            if (!$new_list[$item['hour']]){
                $new_list[$item['hour']] = [];
            }
            $new_list[$item['hour']][$item['goods_id']] = $item;
        }

        $this->view->goodses = $new_list;


        return view('edit4store');
    }
    public function copy(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $id = input('get.id');
        $info = $this->model->get($id);
        $info['hours'] = $info['hours']?explode(',',$info['hours']):[];
        $this->view->info = $info;
        return view('edit');
    }
    public function hourselect(){
        $id = input('request.id');
        $meeting = Seckillmeeting::get($id);
        $list = $meeting['hours']?explode(',',$meeting['hours']):[];
        $new_list = [];
        foreach ($list as &$item) {
            $new_list[] = [
                'id'=>$item,
                'text'=>$item,
            ];
        }
        return $new_list;
    }

    public function goodssave(){
        $data = input('request.');
        $list = $data['data'];
        $meeting_id = $data['id'];

        foreach ($list as $hour => $goodses) {
            foreach ($goodses as $goods) {

//                删除多规格设置
                $setting_model = new Seckillgoodsattrsetting();
                $list = $setting_model->where('seckillgoods_id',$goods['id'])->select();
                if ($list && count($list)){
                    $setting_model->where('seckillgoods_id',$goods['id'])->delete();
                }


                if($goods['edit_state'] == -1){//删除标志
                    Seckillgoods::destroy($goods['id']);
                }else{
                    if ($goods['id']){
                        $seckillgoods = Seckillgoods::get($goods['id']);
                    }else{
                        $seckillgoods = new Seckillgoods();
                    }
                    $goods['seckillmeeting_id'] = $meeting_id;
                    $goods['hour'] = $hour;
                    $seckillgoods->allowField(true)->save($goods);

//                    多规格设置
                    if ($goods['use_attr'] && $goods['attrsetting']){
                        foreach ($goods['attrsetting'] as $setting) {
                            $setting['seckillgoods_id'] = $seckillgoods->id;
                            $setting['goods_id'] = $goods['goods_id'];

                            $setting['attr_ids'] = $setting['attr_ids']?:','.implode(',',$setting['ids']).',';

                            $goodssetting = Goodsattrsetting::get(['goods_id'=>$setting['goods_id'],'attr_ids'=>$setting['attr_ids']]);
                            unset($goodssetting['id']);
                            unset($goodssetting['create_time']);
                            unset($goodssetting['update_time']);

                            $setting = array_merge(json_decode(json_encode($goodssetting),true),json_decode(json_encode($setting),true));

                            $setting_model = new Seckillgoodsattrsetting();
                            $setting_model->allowField(true)->save($setting);
                        }
                    }
                }
            }
        }

        return array(
            'code'=>0,
        );
    }
}
