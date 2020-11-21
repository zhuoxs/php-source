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

use app\common\util\Dir;
use think\Db;
use think\Request;

/**
 * 后台默认首页控制器
 * @package app\admin\controller
 */

class Index extends Admin
{



    /**
     * 首页
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    public function index()
    {
        $data=array();
        //获取系统信息
        $data['videocount']=$this->myDb->name('video')->count();//视频数量总数
        $data['videoshenhe']=$this->myDb->name('video')->where(['is_check'=>0])->count();//待审核视频数
        //获取小说总数
        $data['novelcount']=$this->myDb->name('novel')->count();
        $data['novelshenhe']=$this->myDb->name('novel')->where(['is_check'=>0])->count();
      
        //获取图片总数
        $data['atlascount']=$this->myDb->name('atlas')->count();
        $data['atlasshenhe']=$this->myDb->name('atlas')->where(['is_check'=>0])->count();
		
		      //评论总数
        $data['commentcount']=$this->myDb->name('comment')->count();
        $data['commentshenhe']=$this->myDb->name('comment')->where(['status'=>0])->count();
		
		 //获取系统信息
        $data['membercount']=$this->myDb->name('member')->count();//会员数量总数
        $data['membershenhe']=$this->myDb->name('member')->where(['status'=>0])->count();
		//支付信息
        $data['ordercount']=$this->myDb->name('order')->count();//会员数量总数
        $data['ordershenhe']=$this->myDb->name('order')->where(['status'=>0])->count();
		$data['ordershenhey']=$this->myDb->name('order')->where(['status'=>1])->count();//已经支付记录
        $this->assign('data',$data);
        if (cookie('hisi_iframe')) {
            $this->view->engine->layout(false);
            return $this->fetch('iframe');
        } else {
            return $this->fetch();
        }
    }

    /**
     * 系统标签管理
     * @author whs
     * @return mixed
     */
    public function taglist(Request $request){

        $type=$request->param('t','list');
        $tag=$this->myDb->name('tag');
        $types=$request->param('type',1);
        $this->assign('type',$types);
        switch ($type){
            case 'list':
                $where= ' 1=1 ';
                if(!empty($types)){
                    $where.=" and type =".$types;
                }
                $keys=$request->get('keys');
                if(!empty($keys)){
                    $where.=" and name like '%".$keys."%'";
                }
                $data_list=$tag->where($where)->paginate();
                $pages = $data_list->render();


                $this->assign('keys',$keys);
                $this->assign('pages', $pages);
                $this->assign('data_list',$data_list);
                return $this->fetch();
                break;
            case 'add':
                if($request->isPost()){
                    $tag->insert($request->post());
                  return  $this->success('添加成功',url('index/taglist',['t'=>'list','type'=>$types]));
                  break;
                }else{
                    return $this->fetch('tagform');
                    break;
                }
            case 'edit':
                $id=$request->param('id');
                if($request->isPost()) {
                    $tag->where(['id'=>$id])->update($request->post());
                    $this->success('修改成功',url('index/taglist',['t'=>'list','type'=>$types]));
                }else{
                    if(empty($id)){
                        return $this->error('非法请求，ID为空！');
                        break;
                    }
                    $tageinfo=$tag->where(['id'=>$id])->find();
                    $this->assign('tag',$tageinfo);
                    return $this->fetch('tagedit');
                    break;
                }
            default :
                echo '出错了，要交钱的哦';
                break;
        }

    }

    /**
     * 分类管理 whs
     * 20171114
     */
    public function classlist(Request $request){
        $type=$request->param('type');
        $class=$this->myDb->name("class");
        if(empty($type)){
            $this->error("非法请求,请检查地址后再试");
        }
        $classlist=$class->where(['type'=>$type,'pid'=>0])->select();
        foreach ($classlist as $k=>$v){
            $classlist[$k]['childs']=$class->where(['pid'=>$v['id']])->select();
        }


        $this->assign("type",$type);
        $this->assign('classlist',$classlist);
        return $this->fetch();
    }

    /**
     * 分类编辑
     */
    public function classadd(Request $request){
        $type=$request->param('type');
        $id=$request->param('id');
        $class=$this->myDb->name("class");
        //$group =$this->myDb->name("member_group");
        if($request->isPost()){
            $upload_group=$request->post('upload_group/a',[0]);
            $read_group=$request->post('read_group/a',[0]);
            $data['name']=$request->post('name');
            $data['read_group']=implode(',',$read_group) ;
            $data['upload_group']=implode(',',$upload_group);
            $data['pid']=$request->post('id/d',0);
            $data['last_time'] =time();
            $data['status']=$request->post('status/d',1);
            $data['type']=$type;
            $result=$class->insert($data);
            if($result){
                return $this->success('修改成功');
            }else{
                return $this->error('修改失败');
            }
        }
        if(empty($type)){
            $this->error("非法请求,请检查地址后再试");
        }
        $fclass=$class->where(['pid'=>0,'type'=>$type])->select();
        if(!empty($id)){
            $classinfo=$class->where(['id'=>$id,'type'=>$type])->find();
        }else{
            $classinfo['id']=0;
        }
        //获取会员组
        //$membergroup=$group->where(['status'=>1])->order('sort','desc')->select();
        //$this->assign("membergroup",$membergroup);
        $this->assign("type",$type);
        $this->assign("classinfo",$classinfo);
        $this->assign('fclass',$fclass);
        return $this->fetch();
    }

    /*
     * 分类编辑 whs
     */
    public function classedit(Request $request){
        $type=$request->param('type');
        $id=$request->param('id');
        $class=$this->myDb->name("class");
        //$group =$this->myDb->name("member_group");
        if($request->isPost()){
          $upload_group=$request->post('upload_group/a',[0]);
          $read_group=$request->post('read_group/a',[0]);
            $data['name']=$request->post('name');
            $data['read_group']=implode(',',$read_group) ;
            $data['upload_group']=implode(',',$upload_group);
            $id=$request->post('id');
            $data['pid']=$request->post('pid');
            $data['last_time'] =time();
            $data['status']=$request->post('status/d',1);
            $result=$class->where(['id'=>$id])->update($data);
            if($result){
                return $this->success('修改成功');
            }else{
                return $this->error('修改失败');
            }
        }
        if(empty($type) || empty($id)){
            $this->error("非法请求,请检查地址后再试");
        }
        //获取会员组
        //$membergroup=$group->where(['status'=>1])->order('sort','desc')->select();
        $fclass=$class->where(['pid'=>0,'type'=>$type])->select();
        $classinfo=$class->where(['id'=>$id,'type'=>$type])->find();
        $classinfo['read_group']=explode(',', $classinfo['read_group']);
        $classinfo['upload_group']=explode(',', $classinfo['upload_group']);
        //$this->assign("membergroup",$membergroup);
        $this->assign("type",$type);
        $this->assign('fclass',$fclass);
        $this->assign("classinfo",$classinfo);
        return $this->fetch();
     }


    /**
     * 欢迎首页
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    public function welcome()
    {
        $data=array();
        //获取系统信息
        $data['videocount']=$this->myDb->name('video')->count();//视频数量总数
        $data['videoshenhe']=$this->myDb->name('video')->where(['is_check'=>0])->count();//待审核视频数
        //获取小说总数
        $data['novelcount']=$this->myDb->name('novel')->count();
        $data['novelshenhe']=$this->myDb->name('novel')->where(['is_check'=>0])->count();
        //获取图片总数
        $data['atlascount']=$this->myDb->name('atlas')->count();
        $data['atlasshenhe']=$this->myDb->name('atlas')->where(['is_check'=>0])->count();
        //获取会员信息
        $data['membercount']=$this->myDb->name('member')->count();//会员量总数
	    $data['membershenhe']=$this->myDb->name('member')->where(['status'=>0])->count();//异常用户
		//获取支付信息
        $data['ordershenhey']=$this->myDb->name('order')->where(['status'=>1])->count();//已经支付记录
        $data['ordershenhe']=$this->myDb->name('order')->where(['status'=>0])->count();//未支付记录
		//获取评论信息
        $data['commentcount']=$this->myDb->name('comment')->count();//评论总数
	    $data['commentshenhe']=$this->myDb->name('comment')->where(['status'=>0])->count();//待审核评论数
	
        ///////
        //1会员增长
        $memberMonthListMonth = array();
        $memberMonthListCount = array();

        $userarr = $this->myDb->query("SELECT FROM_UNIXTIME(add_time,'%Y%m') months,COUNT(1) count FROM `ms_member` GROUP BY months");
        foreach ($userarr as $row) {
            //$row = array_map('addslashes', $row);			
            //implode("', '", $row)
            array_push($memberMonthListMonth,$row['months']);
            array_push($memberMonthListCount,$row['count']); 
        }
        $data['memberMonthList']['month'] =implode(",", $memberMonthListMonth);
        $data['memberMonthList']['count'] =implode(",", $memberMonthListCount);
		
            //print_r($data['memberMonthList']['count']);
        
         //2视频消费增长
        $viewVideoMonthListMonth = array();
        $viewVideoMonthListCount = array();

        $userarr = $this->myDb->query("SELECT FROM_UNIXTIME(add_time,'%Y%m') months,sum(gold) count FROM `ms_video` GROUP BY months");
        foreach ($userarr as $row) {
            //$row = array_map('addslashes', $row);			
            //implode("', '", $row)
            array_push($viewVideoMonthListMonth,$row['months']);
            array_push($viewVideoMonthListCount,$row['count']); 
        }
        $data['viewVideoMonthList']['month'] =implode(",", $viewVideoMonthListMonth);
        $data['viewVideoMonthList']['count'] =implode(",", $viewVideoMonthListCount);
         
         //3图册消费增长
        $viewAtlasMonthListMonth = array();
        $viewAtlasMonthListCount = array();

        $userarr = $this->myDb->query("SELECT FROM_UNIXTIME(add_time,'%Y%m') months,sum(gold) count FROM `ms_atlas` GROUP BY months");
        foreach ($userarr as $row) {
            //$row = array_map('addslashes', $row);			
            //implode("', '", $row)
            array_push($viewAtlasMonthListMonth,$row['months']);
            array_push($viewAtlasMonthListCount,$row['count']); 
        }
        $data['viewAtlasMonthList']['month'] =implode(",", $viewAtlasMonthListMonth);
        $data['viewAtlasMonthList']['count'] =implode(",", $viewAtlasMonthListCount);
         
         //4资讯消费增长
        $viewNovelMonthListMonth = array();
        $viewNovelMonthListCount = array();

        $userarr = $this->myDb->query("SELECT FROM_UNIXTIME(add_time,'%Y%m') months,sum(gold) count FROM `ms_novel` GROUP BY months");
        foreach ($userarr as $row) {
            //$row = array_map('addslashes', $row);			
            //implode("', '", $row)
            array_push($viewNovelMonthListMonth,$row['months']);
            array_push($viewNovelMonthListCount,$row['count']); 
        }
        $data['viewNovelMonthList']['month'] =implode(",", $viewNovelMonthListMonth);
        $data['viewNovelMonthList']['count'] =implode(",", $viewNovelMonthListCount);
         
        ///////
		
        $this->assign('data',$data);

        return $this->fetch('index');
    }

    /**
     * 清理缓存
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    public function clear()
    {
        if (Dir::delDir(RUNTIME_PATH) === false) {
            return $this->error('缓存清理失败！');
        }
        return $this->success('缓存清理成功！');
    }




}
