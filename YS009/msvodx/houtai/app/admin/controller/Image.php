<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/21
 * Time: 14:19
 */

namespace app\admin\controller;


use think\Request;

class Image extends  Admin
{

    /**
     * 图册审核
     */
    public function imgcheck(Request $request){
        $atlasdb=$this->myDb->name('atlas');
        $class=$this->myDb->name('class');
        $select=$request->get('select/d',1);
        $key=$request->get('key/s','');
        $cla=$request->get('class/d',0);
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
                    $where.=" and key_word like '%{$key}%'";
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

        $data_list=$atlasdb->where($where)->order("id",'desc')->paginate();
        $list=$data_list->toArray();
        $pages = $data_list->render();
        foreach ($list['data'] as $k=>$v){
            $list['data'][$k]['class']=$this->GetClassname_ByClass($v['class'],2);
            if( $list['data'][$k]['user_id']==0){
                $list['data'][$k]['user_id']='admin';
            }
        }
        $classlist=$class->where(['type'=>2,'pid'=>0])->select();
        foreach ($classlist as $k=>$v){
            $classlist[$k]['childs']=$class->where(['pid'=>$v['id']])->select();
        }
        $this->assign('cla',$cla);
        $this->assign('keys',$key);
        $this->assign('select',$select);
        $this->assign('pages', $pages);
        $this->assign('data_list',$list['data']);
        $this->assign('classlist',$classlist);
        return $this->fetch();
    }

    /**
     * 图片批量修改
     * chixuegao 20171127
     */
    function batch_edit(Request $request){

        $class=$this->myDb->name('class');
        $ids=$request->get('ids','0');
        if($request->isAjax()){
            $idse=$request->post('idse/a');
            $con=$request->post('con');
            $atlas=$this->myDb->name('atlas');
            if($con=='id'){
                $id=$request->post('id/s','0');
                foreach ($idse as $k=>$v){
                    if($v=='click'){
                        $click=$request->post('click/d',0);
                        $atlas->where("id in ({$id})")->update(['click'=>$click]);
                    }elseif ($v=='good'){
                        $good=$request->post('good/d',0);
                        $atlas->where("id in ({$id})")->update(['good'=>$good]);
                    }elseif ($v=='gold'){
                        $gold=$request->post('gold/d',0);
                        $atlas->where("id in ({$id})")->update(['gold'=>$gold]);
                    }elseif ($v=='class'){
                        $class=$request->post('class/s',0);
                        $atlas->where("id in ({$id})")->update(['class'=>$class]);
                    }elseif ($v=='status'){
                        $status=$request->post('status/d',0);
                        $atlas->where("id in ({$id})")->update(['status'=>$status]);
                    }
                }
            }elseif ($con=='clas'){
                $clas=$request->post('clas/s','0');
                foreach ($idse as $k=>$v){
                    if($v=='click'){
                        $click=$request->post('click/d',0);
                        $atlas->where("class = {$clas}")->update(['click'=>$click]);
                    }elseif ($v=='good'){
                        $good=$request->post('good/d',0);
                        $atlas->where("class = {$clas}")->update(['good'=>$good]);
                    }elseif ($v=='gold'){
                        $gold=$request->post('gold/d',0);
                        $atlas->where("class = {$clas}")->update(['gold'=>$gold]);
                    }elseif ($v=='class'){
                        $class=$request->post('class/s',0);
                        $atlas->where("class = {$clas}")->update(['class'=>$class]);
                    }elseif ($v=='status'){
                        $status=$request->post('status/d',0);
                        $atlas->where("class = {$clas}")->update(['status'=>$status]);
                    }
                }
            }
            return $this->success('修改成功！');
            //  var_dump($_POST);
        }
        $classlist=$class->where(['type'=>2,'pid'=>0])->select();
        foreach ($classlist as $k=>$v){
            $classlist[$k]['childs']=$class->where(['pid'=>$v['id']])->select();
        }
        $this->assign('ids',$ids);
        $this->assign('classlist',$classlist);
        $this->view->engine->layout(false);
        return $this->fetch();
    }

    public function imageedit(){
        $this->view->engine->layout(false);
        return $this->fetch();
    }

    public function imagelists(Request $request){
        $atlas_id=$request->param('id/d',0);
        $imagedb=$this->myDb->name('image');
        $atlasdb=$this->myDb->name('atlas');

        $atlas=$atlasdb->where(['id'=>$atlas_id])->find();
        $data_list=$imagedb->where(['atlas_id'=>$atlas_id])->paginate();
        $list=$data_list->toArray();
        $pages = $data_list->render();
        $this->assign('id',$atlas_id);
        $this->assign('pages',$pages);
        $this->assign('atlas',$atlas);
        $this->assign('data_list',$list['data']);
       return $this->fetch();
    }

    public function addimages(Request $request){
        $id=$request->param('id/d');
        $atlasdb=$this->myDb->name('atlas');
        $callback = input('param.callback/s');
        if (!$callback) {
            echo '<br><br>callback为必传参数！';
            exit;
        }
        $check=$atlasdb->where(['id'=>$id])->find();
        if(!$check){
            echo '<br><br>你添加的图集不存在！';
            exit;
        }
        if($request->isAjax()){
            $img['atlas_id']=$request->post('atlas_id');
            $imgurl=$request->post('url/a');
            $img['title']='';
            $img['add_time']=time();
            //验证视频信息
            $rule =[
                'atlas_id|图集id'=>'require',
            ];
            $message=[
                'atlas_id.require'=>"图集id不能为空",
            ];
            $result=$this->validate($img,$rule,$message);
            if($result !== true) {
                return $this->error($result);
            }
            if(empty($imgurl)){
                return $this->error('请上传图片后提交！');
            }
            $imagedb=$this->myDb->name('image');
            foreach ($imgurl as $v){
                 $img['url']=$v;
                 $insert=$imagedb->insert($img);
                unset($img['url']);
            }

            if($insert){
                return $this->success('添加成功');
            }
        }
        $this->assign('id',$id);
        $this->assign('callback', $callback);
        $this->view->engine->layout(false);
        return $this->fetch();
    }

    /***
     * 获取图集列表
     * whs
     */
    public function lists(Request $request){
        $atlasdb=$this->myDb->name('atlas');
        $class=$this->myDb->name('class');
        $select=$request->get('select/d',1);
        $key=$request->get('key/s','');
        $cla=$request->get('class/d',0);
        $where=" 1=1 and is_check=1 ";
        if($key!='0' && !empty($key) && $key!=''){
            switch ($select){
                case 1:
                    $where.=" and id='{$key}'";
                    break;
                case 2:
                    $where.=" and title like '%{$key}%' ";
                    break;
                case 3:
                    $where.=" and key_word like '%{$key}%'";
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

        $data_list=$atlasdb->where($where)->order('update_time desc')->paginate(null,false,['query'=>$request->get()]);
        $list=$data_list->toArray();
        $pages = $data_list->render();
        foreach ($list['data'] as $k=>$v){
            $list['data'][$k]['class']=$this->GetClassname_ByClass($v['class'],2);
            if( $list['data'][$k]['user_id']==0){
                $list['data'][$k]['user_id']='admin';
            }
        }

        $classlist=$class->where(['type'=>2,'pid'=>0])->select();
        foreach ($classlist as $k=>$v){
            $classlist[$k]['childs']=$class->where(['pid'=>$v['id']])->select();
        }
        $this->assign('cla',$cla);
        $this->assign('keys',$key);
        $this->assign('select',$select);
        $this->assign('pages', $pages);
        $this->assign('data_list',$list['data']);
        $this->assign('classlist',$classlist);
        return $this->fetch();
    }

    /**
     * 添加图集
     * whs
     */
    public function add(Request $request){
        if ($this->request->isPost()) {
            $imagedb=$this->myDb->name('atlas');
            //视频资料
            $imageinfo=$request->post('image/a');
            $tag=$request->post('tag/a',[0]);
            $imageinfo['tag']=implode(',',$tag) ;
            $imageinfo['add_time']= time();
            $imageinfo['update_time']= time();
            $imageinfo['is_check']=1;
            //验证视频信息
            $rule =[
                'title|图集标题'=>'require',
                'cover|图集封面'=>'require',
                'class|图集分类'=>'require'
            ];
            $message=[
                'title.require'=>"标题不能为空",
                'cover.require'=>'缩略图不能为空',
                'class.require'=>'请选择视频分类',
            ];
            $result=$this->validate($imageinfo,$rule,$message);
            if($result !== true) {
                return $this->error($result);
            }
            $insert=$imagedb->insert($imageinfo);
            if($insert){
                return $this->success('添加成功',url('image/lists'));
            }
            return $this->error('哎呀，出错了！',url());
        }
        //添加图集分类
        $tag=$this->myDb->name('tag');
        $class=$this->myDb->name('class');
        $classlist=$class->where(['type'=>2,'pid'=>0])->select();
        foreach ($classlist as $k=>$v){
            $classlist[$k]['childs']=$class->where(['pid'=>$v['id']])->select();
        }
        //图集标签
        $tag_result=$tag->where(['type'=>2,'status'=>1])->select();
        $this->assign('classlist',$classlist);
        $this->assign('tag_result',$tag_result);
        return $this->fetch();
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
            $image=$this->myDb->name('atlas');
            $videoinfo=$image->where($where)->field("id,click")->select();
            if($type==1){
                if(intval($min_num)==0){$min_num=0;};if(intval($max_num)==0){$max_num=100;};
                foreach ($videoinfo as $k=>$v){
                    $hits=mt_rand($min_num,$max_num);
                    $image->where("id={$v['id']}")->setInc('click',intval($hits));
                }
            }else{
                if(intval($num)==0){$num=0;};
                $image->where($where)->setInc('click',intval($num));
            }
            return $this->success('修改成功');
        }
        $class=$this->myDb->name('class');
        $classlist=$class->where(['type'=>2,'pid'=>0])->select();
        foreach ($classlist as $k=>$v){
            $classlist[$k]['childs']=$class->where(['pid'=>$v['id']])->select();
        }
        $this->assign('classlist',$classlist);
        $this->assign('callback', $callback);
        $this->view->engine->layout(false);
        return $this->fetch();
    }
    public function edit(Request $request){
        $id=$request->param('id');
        $imagedb=$this->myDb->name('atlas');
        if(empty($id)){
            return $this->error('出错了,请联系管理员解决！');
        }
        if($request->isPost()){
            $atlasinfo=$request->post('image/a');
            $tag=$request->post('tag/a',[0]);
            $atlasinfo['tag']=implode(',',$tag) ;
            $atlasinfo['update_time']= time();
            //验证视频信息
            $rule =[
                'title|图集标题'=>'require',
                'cover|图集缩略图'=>'require',
                'class|视频分类'=>'require'
            ];
            $message=[
                'title.require'=>"标题不能为空",
                'cover.require'=>'缩略图不能为空',
                'class.require'=>'请选择图集分类'
            ];
            $result=$this->validate($atlasinfo,$rule,$message);
            if($result !== true) {
                return $this->error($result);
            }
            $insert=$imagedb->where(['id'=>$id])->update($atlasinfo);
            if($insert){
                return $this->success('修改成功',url('lists'));
            }
        }
        $imageinfo=$imagedb->where(['id'=>$id])->find();
        $imageinfo['tag']=explode(',',$imageinfo['tag']);
        //添加视频分类
        $tag=$this->myDb->name('tag');
        $class=$this->myDb->name('class');
        $classlist=$class->where(['type'=>2,'pid'=>0])->select();
        foreach ($classlist as $k=>$v){
            $classlist[$k]['childs']=$class->where(['pid'=>$v['id']])->select();
        }

        //视频标签
        $tag_result=$tag->where(['type'=>2,'status'=>1])->select();
        $this->assign('classlist',$classlist);
        $this->assign('tag_result',$tag_result);
        $this->assign('imageinfo',$imageinfo);

        return $this->fetch();

    }

    /**
     * 删除图片标签(为了兼容权限控制)
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
        return  $this->khdel('2');
    }

    /**
 * 修改图片状态(为了兼容权限控制)
 * $feng 1/29
 */
    public function image_status(){
        return  $this->status();
    }

    /**
     * 删除图片(为了兼容权限控制)
     * $feng 1/29
     */
    public function image_del(){
        return  $this->del();
    }

    /**
     * 修改图片排序(为了兼容权限控制)
     * $feng 1/29
     */
    public function image_sort(){
        return  $this->sort();
    }
}