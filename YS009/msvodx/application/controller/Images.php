<?php
/**
 * 图片控制器类
 */

namespace app\controller;
use think\Db;
use think\Request;
use think\Controller;


class Images extends BaseController {
    protected function _initialize()
    {
        $this->assign('page_title', '图片');
        $this->assign('navTopTitle', '图片');
        $this->assign('curFooterNavIndex',2);   //底部导航选中的序号
    }
    //兼容index直入列表页
    public function index(Request $request){
        return  $this->lists($request);
    }

    //图片列表页
    public function lists(Request $request)
    {
        $class_sublist = array();
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
        $tag_id = empty($request->param('tag_id')) ? 0 : $request->get('tag_id');
        $class_list =  Db::name('class')->where(array('status'=>1,'type'=>2,'pid'=>0))->field('id,name')->select();
        $tag_list = Db::name('tag')->where(array('status'=>1,'type'=>2))->select();
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
        $where="status = 1 and is_check=1 ";
        if(!empty($cid)){
            $class_sublist = Db::name('class')->where(array('status'=>1,'type'=>2,'pid'=>$cid))->field('id,name')->select();
            $this->assign('sub_cid', $sub_cid);

            if(empty($sub_cid)){
                if(empty($class_sublist)){
                    $where .= " and class = $cid";
                }else{
                    $param = array(
                        'db' => 'class',
                        'where' => array('status'=>1,'type'=>2,'pid'=>$cid),
                        'field' => 'id',
                    );
                    $sub_array =  get_field_values($param);
                    $where .= " and (class = $cid or class in (".implode(',',$sub_array)."))";
                }
            }else{
                $where .= " and class = $sub_cid";
            }

        }
        if(!empty($tag_id)){
            $where .= " and FIND_IN_SET( $tag_id, tag)";
        }
        $tag = "";
        $count =  Db::name('atlas')->where($where)->count();
        $list =  Db::name('atlas')->where($where)->field('id,title,cover,click,gold,good,update_time')->order($order)->paginate(20,false,array('query'=>$request->get()));
        $pages = $list->render();
        $this->assign('pages', $pages);
        $this->assign('orderCode', $orderCode);
        $this->assign('list', $list);
        $this->assign('count', $count);
        $this->assign('tag', $tag);
        $this->assign('cid', $cid);
        $this->assign('tag_id', $tag_id);
        $this->assign('class_list', $class_list);
        $this->assign('class_sublist', $class_sublist);
        $this->assign('tag_list', $tag_list);
        $this->assign('page_title', '图片列表');
        $this->assign('navTopTitle', '图片列表');
        return view();
    }


    //图片查看
    public function show(Request $request){
        $atlas_id = empty($request->param('id')) ? 0 : $request->param('id');
        $order = empty($order) ? 'sort asc' : $order;
        $where="status = 1 and atlas_id = $atlas_id";
        $list =  Db::name('image')->where($where)->field('id,url')->order($order)->paginate(20);
        $num =  Db::name('image')->where($where)->count();
        if(empty($num)){
            $this->error('该图册暂时还没有图片！');
        }

        $pages = $list->render();
        $atlasInfo=Db::view('atlas')
            ->view('member',['id'=>'member_id','username','headimgurl'],'atlas.user_id=member.id','LEFT')
            ->where(['atlas.id'=>$atlas_id])
            ->find();
        $atlasInfo['tag'] =   explode(",",$atlasInfo['tag']);
        if(!$atlasInfo) return $this->error('资源不存在或已被删除');
        if($atlasInfo['status'] !=1 ){
            return $this->error('资源已被下架！');
        }
        if($atlasInfo['is_check'] !=1 ){
            return $this->error('资源未通过审核！');
        }

        if($atlasInfo){
            $atlasTags=Db::name('tag')->where(['type'=>2])->order('sort asc')->select();
            $this->assign('atlasTags',$atlasTags);
        }
        $user_id = session('member_id');
       //判断扣费
        $showmsg=insert_watch_logshowmsg('atlas',$atlas_id,$atlasInfo['user_id'],$atlasInfo['gold']);
        if($showmsg!='0'){
            $info['content']='';
            $permit=0;
        }else{
            $permit=1;
        }
        //获取个人相册
        $atlas_list=null;
        if (intval($user_id) > 0) {
            $atlas_list=Db::name('user_atlas')->where(['user_id'=>$user_id])->select();
        }
        $atlas=model('atlas')->get($atlas_id);
        $atlas->click++;
        $atlas->save();
        $this->assign('atlas_list',$atlas_list);
        $this->assign('atlasInfo',$atlasInfo);
        $this->assign('pages', $pages);
        $this->assign('list', $list);
        $this->assign('isGooded',isGooded('atlas',$atlas_id));
        $this->assign('page_title', $atlasInfo['title']);
        $this->assign('navTopTitle', '图集详情');
        $this->assign('permit',$permit);
        return view();
        /*if($permit==0){
            return view('showtips');
        }else{
            return view();
        }*/

    }
     //图片搜索页
     public function search(Request $request){


        return $this->fetch();
     }

}