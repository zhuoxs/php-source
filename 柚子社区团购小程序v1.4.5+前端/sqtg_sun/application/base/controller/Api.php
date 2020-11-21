<?php
namespace app\base\controller;

use think\Controller;
use think\Db;
use think\Loader;

class Api extends Controller
{
//    public function __construct()
//    {
//        parent::__construct();
//        Db::query('set sql_mode="ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION";');
//    }

    public function ajaxSuccess($ret){
        echo json_encode(array(
            'code'=>0,
            'data'=>$ret,
        ));
        exit();
    }
    public function ajaxError($msg,$code= 1){
        echo json_encode(array(
            'code'=>$code,
            'msg'=>$msg,
        ));
        exit();
    }
    //多个商品运费
    public function getExpressPriceMore($goodsList,$address,$sincetype=1){
        if($sincetype==2){
            return 0;
        }
        $newGoodsList = [];
        foreach($goodsList as $row){
            if($row['postagerules_id']>0){
                if(isset($newGoodsList[$row['postagerules_id']])){
                    $newGoodsList[$row['postagerules_id']]['num'] += $row['num'];
                    $newGoodsList[$row['postagerules_id']]['weight'] += $row['weight'];
                }else{
                    $newGoodsList[$row['postagerules_id']] = $row;
                }
            }
        }
        $matching = null;
        foreach($newGoodsList as $key => $goods) {
            $postagerules=Db::name('postagerules')->find($goods['postagerules_id']);
            $list = json_decode($postagerules['detail'],1);
            foreach ($list as $i => $item) {
                if(strpos($item['detail'],$address['province'])!==false||strpos($item['detail'],$address['city'])!==false){
                    $matching = $list[$i];
                    break;
                }
            }
            $newGoodsList[$key]['type']       = $postagerules['type'];
            $newGoodsList[$key]['matching']   = $matching;
        }
        $maxFristPrice = 0;
        $maxFristPriceIndex = null;
        foreach($newGoodsList as $k => $m){
            if ($m['matching']['first_price'] >= $maxFristPrice){
                $maxFristPrice = $m['matching']['first_price'];
                $maxFristPriceIndex = $k;
            }
        }
        $price = 0;
        foreach ($newGoodsList as $key => $value) {
            if($key == $maxFristPriceIndex) {
                if ($value['type'] == '1') {
                    // 按件计费
                    $value['num'] -= $value['matching']['first_count'];
                    $price += $value['matching']['first_price'];
                    if ($value['matching']['next_count']) {
                        $leave = ceil($value['num'] / $value['matching']['next_count']) > 0 ? ceil($value['num'] / $value['matching']['next_count']) : 0;
                    } else {
                        $leave = 0;
                    }
                    $price += $leave * $value['matching']['next_price'];
                }else{
                    // 按重计费
                    $totalWeight = $value['weight'];
                    $totalWeight -= $value['matching']['first_count'];
                    $price += $value['matching']['first_price'];
                    if ($value['matching']->second) {
                        $leave = ceil($totalWeight / $value['matching']['next_count']) > 0 ? ceil($totalWeight / $value['matching']['next_count']) : 0;
                    } else {
                        $leave = 0;
                    }
                    $price += $leave * $value['matching']['next_price'];
                }
            }else{
                if ($value['type'] == '1') {
                    // 按件计费
                    if ($value['matching']['next_count']) {
                        $leave = ceil($value['num'] / $value['matching']['next_count']) > 0 ? ceil($value['num'] / $value['matching']['next_count']) : 0;
                    } else {
                        $leave = 0;
                    }
                    $price += $leave * $value['matching']['next_price'];
                }else{
                    // 按重计费
                    $totalWeight = $value['weight'];
                    if ($value['matching']['next_count']) {
                        $leave = ceil($totalWeight / $value['matching']['next_count']) > 0 ? ceil($totalWeight / $value['matching']['next_count']) : 0;
                    } else {
                        $leave = 0;
                    }
                    $price += $leave * $value['matching']['next_price'];
                }
            }
        }
        return $price;
    }
    //单个商品运费
    public function getExpressPrice($gid,$num,$address,$attr_ids='',$sincetype=1){
          if($sincetype==2){
              return 0;
          }
          $goods=Db::name('goods')->find($gid);
          if(!$goods){
              return 0;
          }
          if(!$goods['postagerules_id']){
              return 0;
          }
          if(empty($address['province'])||empty($address['city'])){
              return 0;
          }
          $postagerules=Db::name('postagerules')->find($goods['postagerules_id']);
          if($postagerules['state']==0||!$postagerules){
              return 0;
          }

          $detail=json_decode($postagerules['detail'],1);
          $postagerules_detail=null;
          foreach($detail as $val){
              if(strpos($val['detail'],$address['province'])!==false){
                  $postagerules_detail=$val;
                  break;
              }
              if(strpos($val['detail'],$address['city'])!==false){
                  $postagerules_detail=$val;
                  break;
              }
          }
          if(!$postagerules_detail){
              return 0;
          }
          $price=0;
          if($postagerules['type']==1){
              //按件
              $num -= $postagerules_detail['first_count'];
              $price += $postagerules_detail['first_price'];
              $leave = ceil($num / $postagerules_detail['next_count'])>0?ceil($num / $postagerules_detail['next_count']):0;
              $price += $leave * $postagerules_detail['next_price'];
          }else if($postagerules['type']==2){
              //按重
              //计算总重量
              $weight=$this->getWeight($gid,$attr_ids);
              $totalWeight=$num*$weight;
              $totalWeight -= $postagerules_detail['first_count'];
              $price +=  $postagerules_detail['first_price'];
              $leave = ceil($totalWeight / $postagerules_detail['next_count'])>0?ceil($totalWeight / $postagerules_detail['next_count']):0;
              $price += $leave * $postagerules_detail['next_price'];
          }
          return $price;
    }
    public function getWeight($gid,$attr_ids){
        $goods=Db::name('goods')->find($gid);
        if($goods['use_attr']==0){
            return $goods['weight']?$goods['weight']:0;
        }else if($goods['use_attr']==1){
            $goodsattrsetting=Db::name('goodsattrsetting')->where(array('goods_id'=>$gid,'attr_ids'=>$attr_ids))->find();
            if(!$goodsattrsetting){
                return 0;
            }
            return $goodsattrsetting['weight']?$goodsattrsetting['weight']:0;
        }
    }
    //打印
    public function setPrint($param){
        Loader::import('httpclient.HttpClient');
        define('USER', $param['user']);	//*必填*：飞鹅云后台注册账号
        define('UKEY', $param['key']);	//*必填*: 飞鹅云注册账号后生成的UKEY
        define('SN', $param['sn']);	    //*必填*：打印机编号，必须要在管理后台里添加打印机或调用API接口添加之后，才能调用API
        //以下参数不需要修改
        define('IP','api.feieyun.cn');		//接口IP或域名
        define('PORT',80);					//接口IP端口
        define('PATH','/Api/Open/');		//接口路径
        define('STIME', time());			    //公共参数，请求时间
        define('SIG', sha1(USER.UKEY.STIME));   //公共参数，请求公钥
        $content = array(
            'user'=>USER,
            'stime'=>STIME,
            'sig'=>SIG,
            'apiname'=>'Open_printMsg',
            'sn'=>SN,
            'content'=>$param['content'],
            'times'=>$param['times']//打印次数
        );
        $client = new \HttpClient(IP,PORT);
        if(!$client->post(PATH,$content)){
            return 'error';
        }
        else{
            //服务器返回的JSON字符串，建议要当做日志记录起来
            return $client->getContent();
        }
    }

    /**
     * 上传视频
     */
    public function uploadVideo(){
        global $_W, $_GPC;
        //检测是否存在文件
        if (!is_uploaded_file($_FILES["file"]['tmp_name'])) {
            //图片不存在
            return_json('文件不存在',1);
        }else{
            $file = $_FILES["file"];

//            require_once IA_ROOT."/framework/class/uploadedfile.class.php";
            Loader::import('upload.uploadfile');
            $upload = new \UploadFile();
//            var_dump($upload);exit;
            //设置上传文件大小,目前相当于无限制,微信会自动压缩图片
            $upload->maxSize = 30292200;
            $upload->allowExts = explode(',', 'png,gif,jpeg,pjpeg,bmp,x-png,jpg,mp4');
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
}
