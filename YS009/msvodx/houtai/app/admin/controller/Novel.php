<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/20
 * Time: 10:29
 */

namespace app\admin\controller;

use think\Request;

class Novel extends Admin
{


    /**
     * 资讯审核
     */
    function novelcheck(Request $request){
        $select=$request->get('select/d',1);
        $key=$request->get('key/s','');
        $cla=$request->get('class/d',0);
        $class=$this->myDb->name('class');
        $noveldb=$this->myDb->name('novel');
        $where=" 1=1 and is_check != 1";
        if($key!='0' && !empty($key) && $key!=''){
            switch ($select){
                case 1:
                    $where.=" and id='{$key}'";
                    break;
                case 2:
                    $where.=" and title like '%{$key}%' ";
                    break;
                case 3:
                    $where.="and key_word like  '%{$key}%'";
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
        $data_list=$noveldb->where($where)->order("id",'desc')->paginate();
        $list=$data_list->toArray();
        $pages = $data_list->render();
        foreach ($list['data'] as $k=>$v){
            $list['data'][$k]['class']=$this->GetClassname_ByClass($v['class'],3);
            if( $list['data'][$k]['user_id']==0){
                $list['data'][$k]['user_id']='admin';
            }
        }
        //type为3是资讯类型
        $classlist=$class->where(['type'=>3,'pid'=>0])->select();
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
     * 资讯批量修改
     * chixuegao 20171127
     */
    function batch_edit(Request $request){

        $class=$this->myDb->name('class');
        $ids=$request->get('ids','0');
        if($request->isAjax()){
            $idse=$request->post('idse/a');
            $con=$request->post('con');
            $novel=$this->myDb->name('novel');
            if($con=='id'){
                $id=$request->post('id/s','0');
                foreach ($idse as $k=>$v){
                    if($v=='click'){
                        $click=$request->post('click/d',0);
                        $novel->where("id in ({$id})")->update(['click'=>$click]);
                    }elseif ($v=='good'){
                        $good=$request->post('good/d',0);
                        $novel->where("id in ({$id})")->update(['good'=>$good]);
                    }elseif ($v=='gold'){
                        $gold=$request->post('gold/d',0);
                        $novel->where("id in ({$id})")->update(['gold'=>$gold]);
                    }elseif ($v=='class'){
                        $class=$request->post('class/s',0);
                        $novel->where("id in ({$id})")->update(['class'=>$class]);
                    }elseif ($v=='status'){
                        $status=$request->post('status/d',0);
                        $novel->where("id in ({$id})")->update(['status'=>$status]);
                    }
                }
            }elseif ($con=='clas'){
                $clas=$request->post('clas/s','0');
                foreach ($idse as $k=>$v){
                    if($v=='click'){
                        $click=$request->post('click/d',0);
                        $novel->where("class = {$clas}")->update(['click'=>$click]);
                    }elseif ($v=='good'){
                        $good=$request->post('good/d',0);
                        $novel->where("class = {$clas}")->update(['good'=>$good]);
                    }elseif ($v=='gold'){
                        $gold=$request->post('gold/d',0);
                        $novel->where("class = {$clas}")->update(['gold'=>$gold]);
                    }elseif ($v=='class'){
                        $class=$request->post('class/s',0);
                        $novel->where("class = {$clas}")->update(['class'=>$class]);
                    }elseif ($v=='status'){
                        $status=$request->post('status/d',0);
                        $novel->where("class = {$clas}")->update(['status'=>$status]);
                    }
                }
            }
            return $this->success('修改成功！');
            //  var_dump($_POST);
        }
        $classlist=$class->where(['type'=>3,'pid'=>0])->select();
        foreach ($classlist as $k=>$v){
            $classlist[$k]['childs']=$class->where(['pid'=>$v['id']])->select();
        }
        $this->assign('ids',$ids);
        $this->assign('classlist',$classlist);
        $this->view->engine->layout(false);
        return $this->fetch();
    }

    /**
     * @param Request $request
     * @return mixed|void
     * chixuegao 资讯添加
     */
    public function add(Request $request){
        if($request->isPost()){
            $noveldb=$this->myDb->name('novel');
            //视频资料
            $novelinfo=$request->post('novel/a');
            $tag=$request->post('tag/a',[0]);
            $novelinfo['tag']=implode(',',$tag) ;
            $novelinfo['add_time']= time();
            $novelinfo['update_time']= time();
            $novelinfo['is_check']=1;
            //验证视频信息
            $rule =[
                'title|资讯标题'=>'require',
                'content|资讯内容'=>'require',
                'class|资讯分类'=>'require',
                'thumbnail|资讯缩略图'=>'require'
            ];
            $message=[
                'title.require'=>"标题不能为空",
                'content.require'=>'资讯内容不能为空',
                'thumbnail.require'=>'缩略图不能为空',
                'class.require'=>'请选择资讯分类'
            ];
            $result=$this->validate($novelinfo,$rule,$message);
            if($result !== true) {
                return $this->error($result);
            }
            $insert=$noveldb->insert($novelinfo);
            if($insert){
                return $this->success('添加成功',url('lists'));
            }
            return $this->error('哎呀，出错了！',url());
        }
        $tag=$this->myDb->name('tag');
        $class=$this->myDb->name('class');
        $classlist=$class->where(['type'=>3,'pid'=>0])->select();
        foreach ($classlist as $k=>$v){
            $classlist[$k]['childs']=$class->where(['pid'=>$v['id']])->select();
        }
        $tag_result=$tag->where(['type'=>3,'status'=>1])->select();
        $this->assign('classlist',$classlist);
        $this->assign('tag_result',$tag_result);
        return $this->fetch();
    }

    /**
     * chixuegao
     * 获取资讯列表
     */
    public function lists(Request $request){
        $select=$request->get('select/d',1);
        $key=$request->get('key/s','');
        $cla=$request->get('class/d',0);
        $class=$this->myDb->name('class');
        $noveldb=$this->myDb->name('novel');
        $where=" 1=1 and is_check=1";
        if($key!='0' && !empty($key) && $key!=''){
            switch ($select){
                case 1:
                    $where.=" and id='{$key}'";
                    break;
                case 2:
                    $where.=" and title like '%{$key}%' ";
                    break;
                case 3:
                    $where.="and key_word like  '%{$key}%'";
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
        $data_list=$noveldb->where($where)->order('update_time desc')->paginate(null,false,['query'=>$request->get()]);
        $list=$data_list->toArray();
        $pages = $data_list->render();
        foreach ($list['data'] as $k=>$v){
            $list['data'][$k]['class']=$this->GetClassname_ByClass($v['class'],3);
            if( $list['data'][$k]['user_id']==0){
                $list['data'][$k]['user_id']='admin';
            }
        }
        //type为3是资讯类型
        $classlist=$class->where(['type'=>3,'pid'=>0])->select();
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
    /***
     * 资讯修改
     * chixuegao 20171120
     */
    public function edit(Request $request){
        $noveldb=$this->myDb->name('novel');
        $tag=$this->myDb->name('tag');
        $class=$this->myDb->name('class');
        $id=$request->param('id');
        if(empty($id)){
            return $this->error('出错了,请联系管理员解决！');
        }
        if($request->isPost()){

            $novelinfo=$request->post('novel/a');
            $tag=$request->post('tag/a',[0]);
            $novelinfo['tag']=implode(',',$tag) ;
            $novelinfo['update_time']= time();
            //验证资讯信息
            $rule =[
                'title|资讯标题'=>'require',
                'content|资讯内容'=>'require',
                'class|资讯分类'=>'require',
                'thumbnail|资讯缩略图'=>'require'
            ];
            $message=[
                'title.require'=>"标题不能为空",
                'content.require'=>'资讯内容不能为空',
                'thumbnail.require'=>'缩略图不能为空',
                'class.require'=>'请选择资讯分类'
            ];
            $result=$this->validate($novelinfo,$rule,$message);
            if($result !== true) {
                return $this->error($result);
            }
            $insert=$noveldb->where(['id'=>$id])->update($novelinfo);
            if($insert){
                return $this->success('修改成功',url('lists'));
            }
            return $this->error('出错啦，请联系管理员解决');
        }
        $classlist=$class->where(['type'=>3,'pid'=>0])->select();
        foreach ($classlist as $k=>$v){
            $classlist[$k]['childs']=$class->where(['pid'=>$v['id']])->select();
        }
        $tag_result=$tag->where(['type'=>3,'status'=>1])->select();
        $novelinfo=$noveldb->where(['id'=>$id])->find();
        $novelinfo['tag']=explode(',',$novelinfo['tag']);
        $this->assign('novelinfo',$novelinfo);
        $this->assign('classlist',$classlist);
        $this->assign('tag_result',$tag_result);
        return $this->fetch();
    }
    /**
     * whs 20171113
     * @ id 类id ,$type类型
     * 通过视频类id获取资讯类型
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
     * 通过资讯类id资讯类型 批量增加点击量
     */
    function randclick(Request $request){
        $q = input('param.q/s');
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
            $novel=$this->myDb->name('novel');
            $novelinfo=$novel->where($where)->field("id,click")->select();
            if($type==1){
                if(intval($min_num)==0){$min_num=0;};if(intval($max_num)==0){$max_num=100;};
                foreach ($novelinfo as $k=>$v){
                    $hits=mt_rand($min_num,$max_num);
                    $novel->where("id={$v['id']}")->setInc('click',intval($hits));
                }
            }else{
                if(intval($num)==0){$num=0;};
                $novel->where($where)->setInc('click',intval($num));
            }
            return $this->success('修改成功');
        }
        $class=$this->myDb->name('class');
        $classlist=$class->where(['type'=>3,'pid'=>0])->select();
        foreach ($classlist as $k=>$v){
            $classlist[$k]['childs']=$class->where(['pid'=>$v['id']])->select();
        }
        $this->assign('classlist',$classlist);
        $this->assign('callback', $callback);
        $this->view->engine->layout(false);
        return $this->fetch();
    }

    /**
     * 删除资讯标签(为了兼容权限控制)
     * $dreamer 1/25
     */
    public function deleteTag(){
        return  $this->khdel();
    }

    /**
     * 删除资讯分类(为了兼容权限控制)
     * $dreamer 1/25
     */
    public function deleteClass(){
        return  $this->khdel('3');
    }


}