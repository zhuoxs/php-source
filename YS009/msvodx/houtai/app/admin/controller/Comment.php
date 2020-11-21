<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/8
 * Time: 11:16
 */


namespace app\admin\controller;


use think\Db;
use think\Request;

class Comment extends Admin
{
    public $tab_data = [];
    /**
     * 初始化方法
     */
    protected function _initialize()
    {
        parent::_initialize();

        $tab_data['menu'] = [
            [
                'title' => '视频评论',
                'url' => url('admin/comment/index',['types'=>'video'],false),
            ],
            [
                'title' => '图片评论',
                'url' => url('admin/comment/index',['types'=>'image'],false),
            ],
            [
                'title' => '资讯评论',
                'url' => url('admin/comment/index',['types'=>'novel'],false),
            ],
        ];
        $this->assign('tab_type', 1);
        $this->tab_data = $tab_data;
    }

    /**
     *  frs
     *  评论列表
     */
    public function index(Request $request){
        $type = $request->route('types/s','video');
        $this->tab_data['current'] = url('admin/comment/index',['types'=>$type]);
        $this->assign('tab_data', $this->tab_data);
        $resources_type_value = array(
            'video' => 1,
            'image' => 2,
            'novel' => 3,
        );
        $where = 'resources_type ='.$resources_type_value[$type];
        $order = 'last_time desc';
        $list = $this->myDb->view('Comment')
            ->view('member','username','ms_comment.send_user=member.id','LEFT')
            ->view($type,'title','ms_comment.resources_id='.$type.'.id','LEFT')
            ->order($order)
            ->where($where)
            ->paginate(20);
        $pages = $list->render();
        $this->assign('pages', $pages);
        $this->assign('list', $list);
        return $this->fetch();
    }

}