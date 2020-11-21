<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/23
 * Time: 16:41
 */
namespace app\api\controller;
use app\base\controller\Api;
use app\model\Suggest;

class Csuggest extends Api{
/**
 * 发表留言
*/
public function addSuggest(){
    $user_id=input('post.user_id');
    $content=input('post.content');
    $tel=input('post.tel');
    $name=input('post.name');
    if($user_id&&$content&&$tel&&$name){
        $data['user_id']=$user_id;
        $data['content']=$content;
        $data['tel']=$tel;
        $data['username']=$name;
        $sug=new Suggest();
        $res=$sug->allowField(true)->save($data);
        if($res){
            return_json('留言成功');
        }else{
            return_json('请稍后重试',-1);
        }
    }else{
        return_json('数据不能为空',-1);
    }
}
/**
 * 我的留言
*/
public function mySuggest(){
    global $_W;
    $user_id=input('post.user_id');
    if($user_id>0){
        $where['user_id']=$user_id;
        $where['uniacid']=$_W['uniacid'];
        $sug=new Suggest();
        $page=input('post.page',1);
        $length=input('post.length',10);
        $list=$sug->mlist($where,array('create_time'=>'desc'),$page,$length);
        return_json('success',0,$list);
    }else{
        return_json('user_id不能为空',-1);
    }
}

}