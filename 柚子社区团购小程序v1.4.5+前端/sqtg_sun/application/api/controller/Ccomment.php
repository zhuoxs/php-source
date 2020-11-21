<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/17
 * Time: 16:22
 */
namespace app\api\controller;
use app\base\controller\Api;
use app\model\Comment;
use app\model\Order;
use app\model\Orderdetail;
use app\model\User;
use think\Loader;

class Ccomment extends Api{
    //TODO::上传图片
    public function uploadPic(){
        global $_W, $_GPC;
        //检测是否存在文件
        if (!is_uploaded_file($_FILES["file"]['tmp_name'])) {
            //图片不存在
            return_json('图片不存在',1);
        }else{
            $file = $_FILES["file"];

//            require_once IA_ROOT."/framework/class/uploadedfile.class.php";
            Loader::import('upload.uploadfile');
            $upload = new \UploadFile();
//            var_dump($upload);exit;
            //设置上传文件大小,目前相当于无限制,微信会自动压缩图片
            $upload->maxSize = 30292200;
            $upload->allowExts = explode(',', 'png,gif,jpeg,pjpeg,bmp,x-png,jpg');
            $upload->savePath = IA_ROOT."/attachment/";
            $upload->saveRule = uniqid();
            $uploadList = $upload->uploadOne($file);
//            var_dump($uploadList);exit;
            if (!$uploadList) {
                //捕获上传异常
                return_json($upload->getErrorMsg(),1);
            }
            $newimg = $uploadList['0']['savename'];
            //远程附件存储
            @require_once (IA_ROOT."/framework/function/file.func.php");
            @$filename=$newimg;
            @file_remote_upload($filename);
            $imgroot['img_root'] = $_W['attachurl'];
            return_json('success',0,$newimg,$imgroot);
        }
    }

    /**
     * 评价
    */
    public function comment(){
        $data['order_id']=input('post.order_id');
        $order=new Order();
        $orderinfo=$order->mfind(['id'=>$data['order_id']]);
        if($orderinfo['order_status']==3){
            $data['order_detail_id']=input('post.order_detail_id');
            $detail=new Orderdetail();
            $detailinfo=$detail->mfind(['id'=>$data['order_detail_id']]);
            if($detailinfo['is_pingjia']==0){
                $data['goods_id']=$detailinfo['gid'];
                $data['user_id']=input('post.user_id');
                $data['stars']=input('post.stars');
                $data['content']=input('post.content');
                $data['type']=input('post.type',1);
                $img=input('post.imgs');
                if($img){
                    $imgs=explode(',',$img);
                    $data['imgs']=  json_encode($imgs);
                }
                $com=new Comment();
                $res=$com->allowField(true)->save($data);
                if($res){
                    $detail->allowField(true)->save(['is_pingjia'=>1],['id' => $data['order_detail_id']]);
                    return_json('评价成功',0);
                }else{
                    return_json('评价失败',1);
                }
            }else{
                return_json('该订单已评价',1);
            }
        }else{
            return_json('订单还未完成无法评价',1);
        }
    }
    /**
     * 评论列表
    */
    public function commentList(){
        global $_W;
        $goods_id=input('post.goods_id');
        if($goods_id){
            $where['goods_id']=$goods_id;
            $order['create_time']='desc';
            $page = input('post.page', 1);
            $length = input('post.length', 10);
            $comment=new Comment();
            $list=$comment->mlist($where,$order,$page,$length);
            foreach ($list as $key =>$value){
                $user=new User();
                $list[$key]['userinfo']=$user->mfind(['id'=>$value['user_id']],'img,name');
                if($value['imgs']){
                    $list[$key]['imgs']=json_decode($value['imgs']);
                }
            }
            $imgroot['img_root'] = $_W['attachurl'];
            return_json('success',0,$list,$imgroot);
        }else{
            return_json('商品id不能为空',1);
        }
    }
    /**
     * 通用评论列表
     */
    public function baseCommentList(){
        global $_W;
        $goods_id=input('post.goods_id');
        if($goods_id){
            $where['goods_id']=$goods_id;
            $order['create_time']='desc';
            $type = input('post.type', 1);
            $where['type']=$type;
            $page = input('post.page', 1);
            $length = input('post.length', 10);
            $comment=new Comment();
//            $list=$comment->mlist($where,$order,$page,$length);
            $list=$comment->where($where)->with('userinfo')->order($order)->page($page,$length)->select();
            foreach ($list as $key =>$value){
                if($value['imgs']){
                    $list[$key]['imgs']=json_decode($value['imgs']);
                }
            }
            $imgroot['img_root'] = $_W['attachurl'];
            return_json('success',0,$list,$imgroot);
        }else{
            return_json('商品id不能为空',1);
        }
    }
}