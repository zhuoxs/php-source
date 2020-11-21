<?php
/**
 * 小说控制器类
 */

namespace app\controller;

use think\Db;
use think\Request;
use think\Controller;

class Novel extends BaseController
{
    protected function _initialize()
    {
        $this->assign('page_title', '小说');
        $this->assign('curFooterNavIndex',2);   //底部导航选中的序号
    }

    //兼容index直入列表页
    public function index(Request $request){
        return  $this->lists($request);
    }
    //列表页
    public function lists(Request $request)
    {
        $tag_id = empty($request->param('tag_id')) ? 0 : $request->get('tag_id');
        $sub_cid = empty($request->param('sub_cid')) ? 0 : $request->param('sub_cid');
        $cid=$request->get('cid');
        if(!isset($cid)){
            $cid = empty($request->param('cid')) ? 0 : $request->param('cid');
            if(!empty($cid)){
                $menu = db::name('class')->where(array('id'=>$cid))->find();
                if(!empty($menu['pid'])){
                    $sub_cid = $cid;
                    $cid = $menu['pid'];
                }
            }
        }
        $class_list =  Db::name('class')->where(array('status'=>1,'type'=>3,'pid'=>0))->field('id,name')->select();
        $tag_list = Db::name('tag')->where(array('status'=>1,'type'=>3))->select();
        $tags_list = Db::name('tag')->where(array('status'=>1,'type'=>3))->column('id,name');
        $where = "status = 1 and is_check=1 ";
        $params = array(
            'type' => 'novel'
        );
        if(!empty($cid)){
            $params['cid'] = $cid;
            $class_sublist = Db::name('class')->where(array('status'=>1,'type'=>3,'pid'=>$cid))->field('id,name')->select();
            $this->assign('sub_cid', $sub_cid);
            $this->assign('class_sublist', $class_sublist);
            if(empty($sub_cid)){
                if(empty($class_sublist)){
                    $where .= " and class = $cid";
                }else{
                    $param = array(
                        'db' => 'class',
                        'where' => array('status'=>1,'type'=>3,'pid'=>$cid),
                        'field' => 'id',
                        'type' => 'array',
                    );
                    $sub_array =  get_field_values($param);
                    $where .= " and (class = $cid or class in (".implode(',',$sub_array)."))";
                }
            }else{
                $params['cid'] = $sub_cid;
                $where .= " and class = $sub_cid";
            }
        }
        if(!empty($tag_id)){
//            $where .= " and tag = $tag_id";
            $where .= " and FIND_IN_SET( $tag_id, tag)";
        }
        $orderCode = $request->get('orderCode');
        if(!isset($orderCode)) $orderCode = empty($request->param('orderCode')) ? 'lastTime' : $request->param('orderCode');
        switch ($orderCode){
            case 'lastTime':
                $order="update_time desc";
                break;
            case 'lastTimeASC':
                $order="update_time asc";
                break;
            case 'hot':
                $order="click desc";
                break;
            case 'hotASC':
                $order="click asc";
                break;
            case 'reco':
                $order="reco desc";
                break;
            case 'recoASC':
                $order="reco asc";
                break;
            default:
                $order="update_time desc";
                break;
        }
        $order = empty($order) ? 'id desc' : $order;

        $tag = [];
        $list =  Db::name('novel')->where($where)->field('id,title,click,good,gold,thumbnail,tag,short_info,update_time')->order($order)->paginate(10,false,array('query'=>$request->get()));
        foreach ($list as $k => $v){
            $tag[$v['id']] = explode(",",$v['tag']);
        }
        //获取推荐数据
        $recom_list =get_recom_data($params);
        $pages = $list->render();
        $this->assign('pages', $pages);
        $this->assign('list', $list);
        $this->assign('recom_list', $recom_list);
        $this->assign('tag', $tag);
        $this->assign('cid', $cid);
        $this->assign('tag_id', $tag_id);
        $this->assign('class_list', $class_list);
        $this->assign('orderCode', $orderCode);
        $this->assign('tag_list', $tag_list);
        $this->assign('tags_list', $tags_list);
        $this->assign('page_title', '小说列表');
        $this->assign('navTopTitle', '小说列表');
        return view();
    }

    //查看页
    public function show(Request $request){
        $id =  empty($request->param('id')) ? 0 : $request->param('id');
        $where = "status = 1 and id = $id";
        //$info = Db::name('novel')->where($where)->field('title,click,good,thumbnail,tag,content,user_id,update_time')->find();

        $collect_info='收藏';
        if (isCollected('novel',$id)){ $collect_info='已收藏';}

        $this->assign('collect_info',$collect_info);

        $info = Db::view('novel','id,title,click,good,thumbnail,tag,content,update_time,class,user_id,gold,is_check')
             ->view('member','username','novel.user_id=member.id','LEFT')
             ->where( "novel.status = 1 and novel.id = $id")
             ->find();

        if(!$info) return $this->error('资源不存在或已下架！');
        if($info['is_check'] !=1 ){
            return $this->error('资源未通过审核！');
        }

        //上一篇
        $previous_info=Db::name("novel")->where("id>{$id} and status = 1 and is_check =1 ")->order('id asc')->find();
        //下一篇
        $next_info=Db::name("novel")->where("id<{$id} and status = 1 and is_check =1 ")->order("id desc")->find();
        //判断扣费

        $showmsg=insert_watch_logshowmsg('novel',$id,$info['user_id'],$info['gold']);

        if($showmsg!='0'){
            $info['content']='';
            $permit=0;
        }else{
            $permit=1;
        }
        $novel=model('novel')->get($id);
        $novel->click++;
        $novel->save();
        if(empty($info['tag'])){
            $info['tag']=0;
        }
        $where = "id in (".$info['tag'].")";
        $tag_list =  Db::name('tag')->where($where)->select();
        //获取推荐数据
        $params = array(
            'type' => 'novel',
            'cid' => $info['class'],
        );
        $recom_list =get_recom_data($params);
        $this->assign('recom_list', $recom_list);
        $this->assign('tag_list', $tag_list);
        $this->assign('info', $info);

        $this->assign('previous_info',$previous_info);
        $this->assign('next_info',$next_info);
        $this->assign('permit',$permit);
        //当前用户是否点赞过
        $this->assign('isGooded',isGooded('novel',$id));
        $this->assign('isCollected',isCollected('novel',$id));
        $this->assign('page_title', $info['title']);
        $this->assign('navTopTitle', '小说详情');
        return view();
    }
    //搜索页
    public function search(Request $request){
        return  $this->lists($request);
    }

}