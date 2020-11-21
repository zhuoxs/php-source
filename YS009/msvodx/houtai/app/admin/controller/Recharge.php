<?php
// +----------------------------------------------------------------------
// | msvodx[TP5内核]
// +----------------------------------------------------------------------
// | Copyright © 2019-QQ97250974
// +----------------------------------------------------------------------
// | 专业二开仿站定制修改,做最专业的视频点播系统
// +----------------------------------------------------------------------
// | Author: cherish ©2018
// +----------------------------------------------------------------------
namespace app\admin\controller;
use think\Request;

/**
 * 充值管理控制器
 * @package app\admin\controller
 */
class Recharge extends Admin
{

    /**
     * 充值记录
     * @author frs
     * @return mixed
     */
    public function index()
    {
        $data_list=$this->myDb->view('order','*')
            ->view('member','username,nickname,headimgurl,tel,email','order.user_id=member.id')
            ->order('add_time desc')
            ->paginate(15);
        #dump($data_list->items());
        $items=[];
        foreach ($data_list as $item){
            if($item['buy_type']===2){
                $item['buy_vip_info']=\json_decode($item['buy_vip_info'],true);
            }
            $items[]=$item;
        }

        $pages = $data_list->render();
        $this->assign('data_list', $items);
        $this->assign('pages', $pages);
        return $this->fetch();
    }

    /***
     * 用户消费记录
     */
    public function consume(Request $request){
        $type=$request->param('type/d',1);
        if(empty($type))  return $this->error('参数不正确，请稍后再试');
        switch ($type){
            case 1:
                $table='video';
                $title='视频';
                break;
            case 2:
                $table='atlas';
                $title='图册';
                break;
            case 3:
                $table='novel';
                $title='资讯';
           /*     $consume_table = $this->myDb->name('novel_watch_log');
             */
           break;
        }
        $data_list=$this->myDb->view("{$table}_watch_log",'id,user_ip,gold,user_id,view_time')
            ->view("{$table}",'title,class',"{$table}_watch_log.{$table}_id={$table}.id")
            ->view('class','type,name',"{$table}.class=class.id")
            ->view('member','username,headimgurl,nickname,tel,email',"{$table}_watch_log.user_id=member.id")
            ->where("{$table}_watch_log.gold!=0")
            ->order('view_time','desc')
            ->paginate(20);
        $pages=$data_list->render();
        $this->assign('pages',$pages);
        $this->assign('title',$title);
        $this->assign('data_list',$data_list);
        return $this->fetch();
    }
    /**
     * 充值套餐
     * @author frs
     * @return mixed
     */
    public function package()
    {
        $data_list = $this->myDb->name('recharge_package')->order('sort desc,id asc')->field('name,id,sort,days,price,status,permanent,info')->select();
        $this->assign('data_list', $data_list);
        return $this->fetch();
    }
	    /**
     * 金币套餐
     * @author frs
     * @return mixed
     */
    public function goldpackage()
    {
        $data_list = $this->myDb->name('gold_package')->order('id asc')->field('name,id,price,gold')->select();
        $this->assign('data_list', $data_list);
        return $this->fetch();
    }
	    /**
     * 添加金币
     * @author frs
     * @return mixed
     */
    public function addgoldpackage()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $result = $this->validate($data, 'RechargePackage');
            if($result !== true) {
                return $this->error($result);
            }
            $this->myDb->name('gold_package')->insert($data);
            return $this->success('添加成功',url('recharge/goldpackage'));
        }else{
            return $this->fetch();
        }
    }
	    /**
     * 编辑金币
     * @author frs
     * @return mixed
     */
    public function editgoldpackage()
    {
        $id=$this->request->param('id');
        $where['id'] = $id;
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $result = $this->validate($data, 'RechargePackage');
            if($result !== true) {
                return $this->error($result);
            }
            $this->myDb->name('gold_package')->where($where)->update($data);
            return $this->success('编辑成功');
        }else{
            $info =  $this->myDb->name('gold_package')->where($where)->field('id,name,price,gold')->find();
            $this->assign('info', $info);
            return $this->fetch();
        }
    }

    /**
     * 添加套餐
     * @author frs
     * @return mixed
     */
    public function addPackage()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $data['permanent'] = !empty($data['permanent'] ) ? 1 : 0;
            $result = $this->validate($data, 'RechargePackage');
            if($result !== true) {
                return $this->error($result);
            }
            $this->myDb->name('recharge_package')->insert($data);
            return $this->success('添加成功',url('recharge/package'));
        }else{
            return $this->fetch();
        }
    }

    /**
     * 编辑套餐
     * @author frs
     * @return mixed
     */
    public function editPackage()
    {
        $id=$this->request->param('id');
        $where['id'] = $id;
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $data['permanent'] = !empty($data['permanent'] ) ? 1 : 0;
            $result = $this->validate($data, 'RechargePackage');
            if($result !== true) {
                return $this->error($result);
            }
            $this->myDb->name('recharge_package')->where($where)->update($data);
            return $this->success('编辑成功');
        }else{
            $info =  $this->myDb->name('recharge_package')->where($where)->field('id,name,sort,price,days,permanent,status,info')->find();
            $this->assign('info', $info);
            return $this->fetch();
        }
    }
}

