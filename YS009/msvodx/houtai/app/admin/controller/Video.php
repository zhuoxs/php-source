<?php

namespace app\admin\controller;

use think\Db;
use think\Request;

class Video extends Admin
{



    /**
     * 视频审核列表
     */
    public function videocheck(Request $request){
        $videodb=$this->myDb->name('video');
        $class=$this->myDb->name('class');
        $select=$request->get('select/d',1);
        $key=$request->get('key/s','');
        $cla=$request->get('class/d',0);
        $where=" 1=1";
        $where.=" and type=0 and is_check != 1 ";
        if($key!='0' && !empty($key) && $key!=''){
            switch ($select){
                case 1:
                    $where.=" and id='{$key}'";
                    break;
                case 2:
                    $where.=" and title like '%{$key}%' ";
                    break;
                case 3:
                    $where.=" and key_word like  '%{$key}%'";
                    break;
                default :
                    $where.=" and 1=1";
                    break;
            }
        }
        if($cla!=0){
            $classid=$class->where(['pid'=>$cla])->field('id')->select();
            $id=null;
            foreach ($classid as $k=>$v){
                $id.=$v['id'].',';
            }
            $id=$id.$cla;
            $where.=" and (class={$cla} || class in({$id})) ";
        }
        $data_list=$videodb->where($where)->order("id",'desc')->paginate();
        $list=$data_list->toArray();
        $pages = $data_list->render();

        foreach ($list['data'] as $k=>$v){
            $list['data'][$k]['class']=$this->GetClassname_ByClass($v['class'],1);
            if( $list['data'][$k]['user_id']==0){
                $list['data'][$k]['user_id']='admin';
            }
        }
        $classlist=$class->where(['type'=>1,'pid'=>0])->select();
        foreach ($classlist as $k=>$v){
            $classlist[$k]['childs']=$class->where(['pid'=>$v['id']])->select();
        }
        $this->assign('cla',$cla);
        $this->assign('keys',$key);
        $this->assign('select',$select);
        $this->assign('classlist',$classlist);
        $this->assign('pages', $pages);
        $this->assign('data_list',$list['data']);
        return $this->fetch();
    }

    /**
     *  whs 20171113
     *  视频集选择
     */

    function video_gather_lists(Request $request){
        $videodb=$this->myDb->name('video');
        $class=$this->myDb->name('class');
        $pid=$request->param("pid");
        $where=" pid!={$pid} and type=0  and is_check = 1 ";
        $name=null;$cla=null;
        if(!empty($request->get('isget'))){
            $name=$request->get("name");
            if(!empty($name)){
                $where.=" and  title like '%{$name}%' ";
            }
            $cla=$request->get("class");
            if(!empty($cla) && $cla!='0'){
                $classid=$class->where(['pid'=>$cla])->field('id')->select();
                $id=null;
                foreach ($classid as $k=>$v){
                    $id.=$v['id'].',';
                }
                $id=$id.$cla;
                $where.=" and (class={$cla} || class in({$id})) ";
            }
        }
        $data_list=$videodb->where($where)->order("id",'desc')->select();
        if($request->isAjax()){
            $ids=$request->post('ids/a');
            if(empty($ids)){
                $this->error('请选择你要分集的视频');
            }
            $id=implode(",",$ids);
            $relust=$videodb->where("id in ({$id})")->setField("pid",$pid);
            //组装视频集数信息
            $dataid=$videodb->where('pid',$pid)->field('id')->select();
            $insertids=null;
            foreach ($dataid as $v)
            {
                $insertids.=$v['id'].',';
            }
            $insertids=rtrim($insertids,',');
            $videodb->where(['id'=>$pid])->setField("diversity_data",$insertids);
            if($relust){
                return $this->success("更新成功");
            }
        }
        foreach ($data_list as $k=>$v){
            $data_list[$k]['class']=$this->GetClassname_ByClass($v['class'],1);
            if( $data_list[$k]['user_id']==0){
                $data_list[$k]['user_id']='admin';
            }
        }
        $classlist=$class->where(['type'=>1,'pid'=>0])->select();
        foreach ($classlist as $k=>$v){
            $classlist[$k]['childs']=$class->where(['pid'=>$v['id']])->select();
        }
        $this->assign('name',$name);
        $this->assign('cla',$cla);
        $this->assign('classlist',$classlist);
        $this->assign('data_list',$data_list);
        $this->view->engine->layout(false);
        return $this->fetch();
    }
    /**
     * whs 20171113
     *视频集编辑
     */
    function gather_edit(Request $request){
        $id=$request->param('id');
        $videodb=$this->myDb->name('video');
        if(empty($id)){
            return $this->error('出错了,请联系管理员解决！');
        }
        if($request->isPost()){
            $videoinfo=$request->post('video/a');
            $tag=$request->post('tag/a',[0]);
            $videoinfo['tag']=implode(',',$tag) ;
            $videoinfo['update_time']= time();
            $videoinfo['is_check']= 1;
            //验证视频信息
            $rule =[
                'title|视频标题'=>'require',
                'thumbnail|视频缩略图'=>'require',
                'class|视频分类'=>'require'
            ];
            $message=[
                'title.require'=>"标题不能为空",
                'thumbnail.require'=>'缩略图不能为空',
                'class.require'=>'请选择视频分类'
            ];
            $result=$this->validate($videoinfo,$rule,$message);
            if($result !== true) {
                return $this->error($result);
            }
            $insert=$videodb->where(['id'=>$id])->update($videoinfo);
            if($insert){
                return $this->success('修改成功',url('admin/video/edit',['id'=>$id]));
            }
        }
        $videoinfo=$videodb->where(['id'=>$id])->find();
        $videoinfo['tag']=explode(',',$videoinfo['tag']);
        //添加视频分类
        $tag=$this->myDb->name('tag');
        $class=$this->myDb->name('class');
        $classlist=$class->where(['type'=>1,'pid'=>0])->select();
        foreach ($classlist as $k=>$v){
            $classlist[$k]['childs']=$class->where(['pid'=>$v['id']])->select();
        }

        //视频标签
        $tag_result=$tag->where(['type'=>1,'status'=>1])->select();
        $this->assign('classlist',$classlist);
        $this->assign('tag_result',$tag_result);
        $this->assign('videoinfo',$videoinfo);
        return $this->fetch();
    }
    /**
     * 后台视频集上传
     * @author frs whs tcl dreamer ?2016
     * @return mixed
     */
    function gather_upload(Request $request){
        if ($this->request->isPost()) {
            $videodb=$this->myDb->name('video');
            //视频资料
            $videoinfo=$request->post('video/a');
            $tag=$request->post('tag/a',[0]);
            $videoinfo['tag']=implode(',',$tag) ;
            $videoinfo['add_time']= time();
            $videoinfo['update_time']= time();
            $videoinfo['type']=1;
            $videoinfo['is_check']=1;
            //验证视频信息
            $rule =[
                'title|视频集标题'=>'require',
                'thumbnail|视频缩略图'=>'require',
                'class|视频分类'=>'require'
            ];
            $message=[
                'title.require'=>"标题不能为空",
                'thumbnail.require'=>'缩略图不能为空',
                'class.require'=>'请选择视频分类'
            ];
            $result=$this->validate($videoinfo,$rule,$message);
            if($result !== true) {
                return $this->error($result);
            }
            $insert=$videodb->insert($videoinfo);
            if($insert){
                return $this->success('添加成功',url("video_gather"));
            }
            return $this->error('哎呀，出错了！',url());
        }
        //添加视频分类
        $tag=$this->myDb->name('tag');
        $class=$this->myDb->name('class');
        $classlist=$class->where(['type'=>1,'pid'=>0])->select();
        foreach ($classlist as $k=>$v){
            $classlist[$k]['childs']=$class->where(['pid'=>$v['id']])->select();
        }
        //视频标签
        $tag_result=$tag->where(['type'=>1,'status'=>1])->select();
        $this->assign('classlist',$classlist);
        $this->assign('tag_result',$tag_result);
        return $this->fetch();
    }

    /**
     * 视频集列表
     * @param Request $request
     * @return mixed
     */
    function video_gather(Request $request){
        $class=$this->myDb->name('class');
        $select=$request->get('select/d',1);
        $key=$request->get('key/s','');
        $cla=$request->get('class/d',0);
        $videodb=$this->myDb->name('video');
        $where=" 1=1 and type=1 ";
        if($key!='0' && !empty($key) && $key!=''){
            switch ($select){
                case 1:
                    $where.=" and id='{$key}'";
                    break;
                case 2:
                    $where.=" and title like '%{$key}%' ";
                    break;
                case 3:
                    $where.=" and key_word like  '%{$key}%'";
                    break;
                default :
                    $where.=" and 1=1";
                    break;
            }
        }
        if($cla!=0){
            $classid=$class->where(['pid'=>$cla])->field('id')->select();
            $id=null;
            foreach ($classid as $k=>$v){
                $id.=$v['id'].',';
            }
            $id=$id.$cla;
            $where.=" and (class={$cla} || class in({$id})) ";
        }

        $data_list=$videodb->where($where)->order('id desc')->paginate();
        $list=$data_list->toArray();
        $pages = $data_list->render();
        $classlist=$class->where(['type'=>1,'pid'=>0])->select();
        foreach ($classlist as $k=>$v){
            $classlist[$k]['childs']=$class->where(['pid'=>$v['id']])->select();
        }
        foreach ($list['data'] as $k=>$v){
            $list['data'][$k]['class']=$this->GetClassname_ByClass($v['class'],1);
            if( $list['data'][$k]['user_id']==0){
                $list['data'][$k]['user_id']='admin';
            }
        }

        $this->assign('cla',$cla);
        $this->assign('keys',$key);
        $this->assign('select',$select);
        $this->assign('classlist',$classlist);
        $this->assign('pages', $pages);
        $this->assign('data_list',$list['data']);
        return $this->fetch();
    }

    /**
     * 视频批量修改
     * chixuegao 20171127
     */
    function batch_edit(Request $request){
        $class=$this->myDb->name('class');
        $ids=$request->get('ids','0');
        if($request->isAjax()){
            $idse=$request->post('idse/a');
            $con=$request->post('con');
            $video=$this->myDb->name('video');
            if($con=='id'){
                $id=$request->post('id/s','0');
                foreach ($idse as $k=>$v){
                    if($v=='click'){
                        $click=$request->post('click/d',0);
                        $video->where("id in ({$id})")->update(['click'=>$click]);
                    }elseif ($v=='good'){
                        $good=$request->post('good/d',0);
                        $video->where("id in ({$id})")->update(['good'=>$good]);
                    }elseif ($v=='gold'){
                        $gold=$request->post('gold/d',0);
                        $video->where("id in ({$id})")->update(['gold'=>$gold]);
                    }elseif ($v=='class'){
                        $class=$request->post('class/s',0);
                        $video->where("id in ({$id})")->update(['class'=>$class]);
                    }elseif ($v=='reco'){
                        $reco=$request->post('reco/d',0);
                        $video->where("id in ({$id})")->update(['reco'=>$reco]);
                    }elseif ($v=='reco'){
                        $status=$request->post('status/d',0);
                        $video->where("id in ({$id})")->update(['status'=>$status]);
                    }
                }
            }elseif ($con=='clas'){
                $clas=$request->post('clas/s','0');
                foreach ($idse as $k=>$v){
                    if($v=='click'){
                        $click=$request->post('click/d',0);
                        $video->where("class = {$clas}")->update(['click'=>$click]);
                    }elseif ($v=='good'){
                        $good=$request->post('good/d',0);
                        $video->where("class = {$clas}")->update(['good'=>$good]);
                    }elseif ($v=='gold'){
                        $gold=$request->post('gold/d',0);
                        $video->where("class = {$clas}")->update(['gold'=>$gold]);
                    }elseif ($v=='class'){
                        $class=$request->post('class/s',0);
                        $video->where("class = {$clas}")->update(['class'=>$class]);
                    }elseif ($v=='reco'){
                        $reco=$request->post('reco/d',0);
                        $video->where("class = {$clas}")->update(['reco'=>$reco]);
                    }elseif ($v=='reco'){
                        $status=$request->post('status/d',0);
                        $video->where("class = {$clas}")->update(['status'=>$status]);
                    }
                }
            }
            return $this->success('修改成功！');

        }
        $classlist=$class->where(['type'=>1,'pid'=>0])->select();
        foreach ($classlist as $k=>$v){
            $classlist[$k]['childs']=$class->where(['pid'=>$v['id']])->select();
        }
        $this->assign('ids',$ids);
        $this->assign('classlist',$classlist);
        $this->view->engine->layout(false);
        return $this->fetch();
    }
    /**
     * 后台视频上传
     * @author frs whs tcl dreamer ?2016
     * @return mixed
     */
    function upload(Request $request){
        if ($this->request->isPost()) {
            $videodb=$this->myDb->name('video');
            //视频资料
            $videoinfo=$request->post('video/a');
            $tag=$request->post('tag/a',[0]);
            $videoinfo['tag']=implode(',',$tag) ;
            $videoinfo['add_time']= time();
            $videoinfo['update_time']= time();
            $videoinfo['is_check']= 1;
            //验证视频信息
            $rule =[
                'title|视频标题'=>'require',
                'url|视频地址'=>'require',
                #'download_url|下载地址'=>'require',
                'thumbnail|视频缩略图'=>'require',
                'class|视频分类'=>'require'
            ];
            $message=[
                'title.require'=>"标题不能为空",
                'url.require'=>'视频地址不能为空',
                #'download_url.require'=>'下载地址不能为空',
                'thumbnail.require'=>'缩略图不能为空',
                'class.require'=>'请选择视频分类',

            ];
            $result=$this->validate($videoinfo,$rule,$message);
            if($result !== true) {
                return $this->error($result);
            }
            $insert=$videodb->insert($videoinfo);
            if($insert){
                return $this->success('添加成功',url('lists'));
            }
            return $this->error('哎呀，出错了！',url());
        }
        //添加视频分类
        $tag=$this->myDb->name('tag');
        $class=$this->myDb->name('class');
        $classlist=$class->where(['type'=>1,'pid'=>0])->select();
        foreach ($classlist as $k=>$v){
            $classlist[$k]['childs']=$class->where(['pid'=>$v['id']])->select();
        }

        //视频标签
        $tag_result=$tag->where(['type'=>1,'status'=>1])->select();
        $this->assign('classlist',$classlist);
        $this->assign('tag_result',$tag_result);
      return $this->fetch();
    }
     /**
     * whs 20171113
      *视频编辑
     */
    function edit(Request $request){
        $id=$request->param('id');
        $videodb=$this->myDb->name('video');
        if(empty($id)){
           return $this->error('出错了,请联系管理员解决！');
        }
        if($request->isPost()){
            $videoinfo=$request->post('video/a');
            $tag=$request->post('tag/a',[0]);
            $videoinfo['tag']=implode(',',$tag) ;
            $videoinfo['update_time']= time();
            //验证视频信息
            $rule =[
                'title|视频标题'=>'require',
                'url|视频地址'=>'require',
                #'download_url|下载地址'=>'require',
                'thumbnail|视频缩略图'=>'require',
                'class|视频分类'=>'require'
            ];
            $message=[
                'title.require'=>"标题不能为空",
                'url.require'=>'视频地址不能为空',
                #'download_url.require'=>'下载地址不能为空',
                'thumbnail.require'=>'缩略图不能为空',
                'class.require'=>'请选择视频分类'
            ];
            $result=$this->validate($videoinfo,$rule,$message);
            if($result !== true) {
                return $this->error($result);
            }
            $insert=$videodb->where(['id'=>$id])->update($videoinfo);
            if($insert){
                return $this->success('修改成功',url('lists'));
            }
        }
        $videoinfo=$videodb->where(['id'=>$id])->find();
        $videoinfo['tag']=explode(',',$videoinfo['tag']);
        //添加视频分类
        $tag=$this->myDb->name('tag');
        $class=$this->myDb->name('class');
        $classlist=$class->where(['type'=>1,'pid'=>0])->select();
        foreach ($classlist as $k=>$v){
            $classlist[$k]['childs']=$class->where(['pid'=>$v['id']])->select();
        }

        //视频标签
        $tag_result=$tag->where(['type'=>1,'status'=>1])->select();
        $this->assign('classlist',$classlist);
        $this->assign('tag_result',$tag_result);
        $this->assign('videoinfo',$videoinfo);
        return $this->fetch();
    }

    /**
     *  whs 20171113
     *  视频列表
     */

    function lists(Request $request){
        $videodb=$this->myDb->name('video');
        $class=$this->myDb->name('class');
         $select=$request->get('select/d',1);
         $key=$request->get('key/s','');
         $cla=$request->get('class/d',0);
         $pid=$request->param("pid");
         $where=" 1=1 and video.is_check=1 ";
         if(!empty($pid)){
             $where.=" and video.pid={$pid} ";
             $this->assign('pid',$pid);
             $ptl='gather_lists';
         }else{
             $where.=" and video.type=0 ";
             $ptl='lists';
         }
         if($key!='0' && !empty($key) && $key!=''){
             switch ($select){
                 case 1:
                     $where.=" and video.id='{$key}'";
                     break;
                 case 2:
                     $where.=" and video.title like '%{$key}%' ";
                     break;
                 case 3:
                     $where.=" and video.key_word like  '%{$key}%'";
                     break;
                 default :
                     $where.=" and 1=1";
                     break;
             }
         }
        if($cla!=0){
             $classid=$class->where(['pid'=>$cla])->field('id')->select();
             $id=null;
             foreach ($classid as $k=>$v){
                 $id.=$v['id'].',';
             }
            $id=$id.$cla;
             $where.=" and (class={$cla} || class in({$id})) ";
        }
        //echo $where;die;
        //$data_list=$videodb->where($where)->order("id",'desc')->paginate(null,false,['query'=>$request->get()]);
        $data_list=$this->myDb->view('video','id,title,info,key_word,update_time,click,good,thumbnail,user_id,status,is_check,sort,type,gold')
            ->view('class','name as class','video.class=class.id and class.type=1')
            ->where($where)->order("id",'desc')->cache(120)->paginate(null,false,['query'=>$request->get()]);

        $list=$data_list->toArray();
        $pages = $data_list->render();

        foreach ($list['data'] as $k=>$v){
          //  $list['data'][$k]['class']=$this->GetClassname_ByClass($v['class'],1);
            if( $list['data'][$k]['user_id']==0){
                $list['data'][$k]['user_id']='admin';
            }
        }
        $classlist=$class->where(['type'=>1,'pid'=>0])->select();
        foreach ($classlist as $k=>$v){
            $classlist[$k]['childs']=$class->where(['pid'=>$v['id']])->select();
        }
        $this->assign('cla',$cla);
        $this->assign('keys',$key);
        $this->assign('select',$select);
        $this->assign('classlist',$classlist);
        $this->assign('pages', $pages);
        $this->assign('data_list',$list['data']);
        return $this->fetch($ptl);
    }


    /**
     * whs 20171113
     * @ id 类id ,$type类型
     * 通过视频类id获取视频类型
     */
    function GetClassname_ByClass($id,$type){
        $class=$this->myDb->name('class');
        $classname=$class->where(['id'=>$id,'type'=>$type])->field('name')->find();
        if($classname){
            return $classname['name'];
        }else{
            return '未定义分类';
        }
    }
    /**
     * whs 20171113
     * @ id 类id ,$type类型
     * 通过视频类id获取视频类型
     */
    function randclick(Request $request){

        $callback = input('param.callback/s');
        if (!$callback) {
            echo '<br><br>callback为必传参数！';
            exit;
        }
        if($this->request->isPost()){
            $class=$request->post('class/d',0);
            $type=$request->post('type/d',2);
            $num=$request->post('num/d',0);
            $min_num=$request->post('min_num/d',0);
            $max_num=$request->post('max_num/d',100);

            $where=" 1=1";
          switch (intval($class)){
              case 0:
                $where.=" and 1=1";
                break;
              default :
                  $where.=" and class=".intval($class);
          }
            $video=$this->myDb->name('video');
           $videoinfo=$video->where($where)->field("id,click")->select();
           if($type==1){
               if(intval($min_num)==0){$min_num=0;};if(intval($max_num)==0){$max_num=100;};
               foreach ($videoinfo as $k=>$v){
                   $hits=mt_rand($min_num,$max_num);
                   $video->where("id={$v['id']}")->setInc('click',intval($hits));
               }
           }else{
               if(intval($num)==0){$num=0;};
               $video->where($where)->setInc('click',intval($num));
           }
            return $this->success('修改成功');
        }
        $class=$this->myDb->name('class');
        $classlist=$class->where(['type'=>1,'pid'=>0])->select();
        foreach ($classlist as $k=>$v){
            $classlist[$k]['childs']=$class->where(['pid'=>$v['id']])->select();
        }
        $this->assign('classlist',$classlist);
        $this->assign('callback', $callback);
        $this->view->engine->layout(false);
        return $this->fetch();
    }

    /* 视频预览 2018/01/16 $dreamer */
    function play(Request $request){
        $videoId=$request->param('id/d',0);
        if($videoId<=0) exit('<h2>视频ID不正确</h2>');

        $videoInfo=$this->myDb->name('video')->where("id={$videoId}")->find();
        if(!$videoInfo)  exit('<h2>视频信息不存在</h2>');

        $yzmPlayKey=$this->myDb->name('admin_config')->where("name='yzm_play_secretkey'")->find();
        $yzmPlayKey=(isset($yzmPlayKey['value']))?$yzmPlayKey['value']:'';
        $yzmPlayKey=create_yzm_play_sign($yzmPlayKey);
        $videoInfo['url'].="?sign={$yzmPlayKey}";

        $this->assign('videoInfo',$videoInfo);

        $this->view->engine->layout(false);
        return $this->fetch();

    }

    /**
     * 删除视频标签(为了兼容权限控制)
     * $dreamer 1/25
     */
    public function deleteTag(){
        return  $this->khdel();
    }

    /**
     * 删除分类(为了兼容权限控制)
     * $dreamer 1/25
     */
    public function deleteClass(){
        return  $this->khdel('1');die;
    }
}