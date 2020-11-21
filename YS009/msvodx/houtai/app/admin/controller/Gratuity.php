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

/**
 * 打赏管理控制器
 * @package app\admin\controller
 */
class Gratuity extends Admin
{

    /**
     * 打赏记录
     * @author frs
     * @return mixed
     */
    public function index()
    {
        $data_list = $this->myDb->name('gratuity_record')->alias('a')->join('ms_member m','a.user_id = m.id')->field('a.id,gratuity_time,gift_info,content_type,content_id,headimgurl,nickname,tel,email')->paginate(20);
        $pages = $data_list->render();
//        var_dump($data_list);
        $video_list = array();
        $images_list = array();
        $novel_list = array();
        foreach ($data_list as $k=>$v){
            if($v['content_type'] == 1){
                $video_list[] = $v['content_id'];
            }else if($v['content_type'] == 2){
                $images_list[] = $v['content_id'];
            }else if($v['content_type'] == 3){
                $novel_list[] = $v['content_id'];
            }
        }
        $video_list = !empty($video_list) ? $this->myDb->name('video')->where('id','in',$video_list)->column('id,title') :  '';
        $images_list = !empty($images_list) ? $this->myDb->name('atlas')->where('id','in',$images_list)->column('id,title') :  '';
        //$images_list = !empty($images_list) ?  $this->myDb->name('image')->alias('a')->join('ms_atlas m','a.atlas_id = m.id')->where('a.id','in',$images_list)->column('a.id,m.title') : '';
        $novel_list = !empty($novel_list) ? $this->myDb->name('novel')->where('id','in',$novel_list)->column('id,title') : '';
        $this->assign('data_list', $data_list);
        $this->assign('pages', $pages);
        $this->assign('video_list', $video_list);
        $this->assign('images_list', $images_list);
        $this->assign('novel_list', $novel_list);
        return $this->fetch();
    }

    /**
     * 礼物记录
     * @author frs
     * @return mixed
     */
    public function gift()
    {
        $data_list = $this->myDb->name('gift')->field('id,name,sort,info,images,price,status')->paginate(20);
        $pages = $data_list->render();
        $this->assign('data_list', $data_list);
        $this->assign('pages', $pages);
        return $this->fetch();
    }

    /**
     * 添加礼物
     * @author frs
     * @return mixed
     */
    public function addGift()
    {
        if($this->request->isPost()){
            $data = $this->request->post();
            $result = $this->validate($data, 'Gift');
            if($result !== true) {
                return $this->error($result);
            }
             $this->myDb->name('gift')->insert($data);
            return $this->success('添加成功',url('gratuity/gift'));
        }else{
            return $this->fetch();
        }

    }

    /**
     * 编辑礼物
     * @author frs
     * @return mixed
     */
    public function editGift()
    {
        $id=$this->request->param('id');
        $where['id'] = $id;
        if($this->request->isPost()){
            $data = $this->request->post();
            $result = $this->validate($data, 'Gift');
            if($result !== true) {
                return $this->error($result);
            }
            $this->myDb->name('gift')->where($where)->update($data);
            return $this->success('编辑成功',url('gratuity/gift'));
        }else{
            $info = $this->myDb->name('gift')->where($where)->field('id,name,sort,info,images,price,status')->find();
            $this->assign('info', $info);
            return $this->fetch();
        }
    }

}
