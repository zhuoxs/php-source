<?php
/**
 * 视频控制器类
 */

namespace app\controller;

use think\Db;
use think\Request;
use think\Controller;

class Search extends BaseController{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->assign('curFooterNavIndex',2);   //底部导航选中的序号
    }

    public function index(Request $request){
        $type = $request->param('type/s','video');
        $key_word = htmlspecialchars(trim($request->param('key_word/s','')),ENT_QUOTES);
        $page_num = ($type == 'novel') ? 10 : 20 ;
        $allowType = ['atlas', 'novel', 'video'];
        $tpl = array(
            'video' => 'video/search',
            'atlas' => 'images/search',
            'novel' => 'novel/search',
        );
        $field = array(
            'video' => 'id,thumbnail,play_time,title,update_time,gold,click',
            'atlas' => 'id,cover,title,update_time,gold,click,good',
            'novel' =>  'id,thumbnail,tag,title,update_time,gold,click,short_info',
        );
        $orderCode = empty($request->param('orderCode')) ? 'lastTime' : $request->param('orderCode');
        switch ($orderCode){
            case 'lastTime':
                $order="update_time desc";
                break;
            case 'hot':
                $order="click desc";
                break;
            case 'reco':
                $order="reco desc";
                break;
        }
        if (!in_array($type, $allowType))  $this->error('没有该资源类型！');
        if ($type == 'video') {
            #$where = "status = 1 and is_check=1 and pid = 0 and title like '%$key_word%'";  //为了避免视频被加入视频集后无法搜索到的Bug $dreamer 2018/02/02
            $where = "status = 1 and is_check=1 and title like '%$key_word%'";
        } else {
            $where = "status = 1 and is_check=1 and title like '%$key_word%'";
        }

        $order = empty($order) ? 'id desc' : $order;
        $count =  Db::name($type)->where($where)->count();
        $list = db::name($type)->where($where)->order($order)->field($field[$type])->paginate($page_num,false,array('query'=>$request->get()));

        //echo db::name($type)->getLastSql();

        $pages = $list->render();
        if($type == 'novel' ){
            $tag = array();
            $params = array(
                'type' =>  $type,
            );
            $recom_list = get_recom_data($params);
            foreach ($list as $k => $v){
                $tag[$v['id']] = explode(",",$v['tag']);
            }
            $this->assign('tag', $tag);
            $tags_list = Db::name('tag')->where(array('status'=>1,'type'=>3))->column('id,name');
            $this->assign('recom_list', $recom_list);
            $this->assign('tags_list', $tags_list);
        }
        $this->assign('count', $count);
        $this->assign('pages', $pages);
        $this->assign('type', $type);
        $this->assign('orderCode', $orderCode);
        $this->assign('key_word', $key_word);
        $this->assign('list', $list);
        $this->assign('page_title', $key_word.'_搜索结果');
        $this->assign('navTopTitle', '搜索结果');
        $lower = strtolower($key_word);
        $upper = strtoupper($key_word);
        return view($tpl[$type]);
    }
}