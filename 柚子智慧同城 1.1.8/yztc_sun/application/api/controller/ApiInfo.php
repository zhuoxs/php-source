<?php
namespace app\api\controller;
use app\model\Infocomment;
use app\model\Infosettings;
use app\model\Infocategory;
use app\model\Infotop;
use app\model\Infotoprecord;
use app\model\Info;
use app\model\Infobrowselike;
use app\model\City;
use app\model\User;
use app\model\System;
use think\Db;
use think\Loader;

class ApiInfo extends Api
{
    //删除评论
    public function delInfocomment(){
        $id=input('request.id');
        (new Infocomment())->allowField(true)->save(['is_del'=>1],['id'=>$id]);
        success_json('删除成功');
    }
    //获取我收藏的帖子
    public function getMyInfobrowselike(){
        $infobrowselikeModel=new Infobrowselike();
        $infobrowselikeModel->fill_order_limit_length();//分页，排序
        $query = function ($query){
            $query->where('type',2);
            $query->where('collect_status',1);
            $user_id=input('request.user_id');
            if($user_id){
                $query->where('user_id',$user_id);
            }
        };
        $data=$infobrowselikeModel->where($query)->order('collect_time desc,id desc')->select();
        $data=objecttoarray($data);
        foreach ($data as $key=>&$val){
            $val['user']=User::get($val['user_id']);
            $val['info']=Info::get($val['info_id']);
          /*  if($val['info']['check_status']!=2||$val['info']['is_del']==1){
                unset($data[$key]);
                continue;
            }*/
            $val['pics']=json_decode($val['info']['pic']);
            $val['cat_name']=Infocategory::get($val['info']['cat_id'])['name'];
            $val['topcat_name']=Infocategory::get($val['info']['topcat_id'])['name'];
            $val['browse_num']=$infobrowselikeModel->getBrowseNum($val['info']['id']);
            $val['like_num']=$infobrowselikeModel->getLikeNum($val['info']['id']);
            $val['is_like']=$infobrowselikeModel->getIsLike($val['info']['user_id'],$val['info']['id']);
            if($val['info']['topping_time']>time()){
                $val['info']['top_status']=1;
            }else{
                $val['info']['top_status']=0;
            }
        }
        success_withimg_json($data);
    }
    //判断帖子类别id有没有二级分类
    public function isSecondInfocategory(){
        $id=input('request.id');
        $is_check=(new Infocategory())->isSecondInfocategory($id);
        if($is_check){
            success_json('有帖子下级分类');
        }else{
            error_json('没有帖子下级分类');
        }
    }
    //删除帖子
    public function delInfo(){
        $user_id=input('request.user_id');
        $info_id=input('request.info_id');
        (new Info())->allowField(true)->save(['is_del'=>1],['user_id'=>$user_id,'id'=>$info_id]);
        (new Infocomment())->allowField(true)->save(['is_del'=>1],['info_id'=>$info_id]);
        success_json('删除成功');
    }
    //获取评论列表
    public function getInfoCommentList(){
        $infocommentModel=new Infocomment();
        $infocommentModel->fill_order_limit_length();//分页，排序
        $query = function ($query){
            $query->where('comment_type',1);
            $info_id=input('request.info_id');
            $query->where('info_id',$info_id);
            $query->where('is_del',0);
            $query->where('check_status',2);
        };
        $data=$infocommentModel->where($query)->select();
        $data=objecttoarray($data);
        foreach ($data as &$val){
            $val['user']=User::get($val['user_id']);
            $val['list']=$infocommentModel->where(['top_comment_id'=>$val['id'],'comment_type'=>2,'check_status'=>2])->select();
            foreach ($val['list'] as &$item){
                $item['user']=User::get($item['user_id']);
                $item['to_user']=User::get($item['to_user_id']);
            }
        }
        success_withimg_json($data);

    }
    //发表评论和回复
    public function setInfoComment(){
        $user_id=input('request.user_id');
        $comment_type=input('request.comment_type')?input('request.comment_type'):1;
        $info_id=input('request.info_id');
        $content=input('request.content');
        $comment_id=input('request.comment_id')?input('request.comment_id'):0;
        $infosettings=Infosettings::get_curr();
        $infocommentModel=new Infocomment();
        $check_status=1;
        if(intval($infosettings['comment_check'])==0){
            $check_status=2;
        }
        if($comment_type==1){
            $data=[
                'user_id'=>$user_id,
                'info_id'=>$info_id,
                'content'=>$content,
                'comment_type'=>$comment_type,
                'check_status'=>$check_status,
            ];
        }else if($comment_type==2){
            $infocomment=$infocommentModel->find($comment_id);
            if($infocomment['comment_type']==1){
                $top_comment_id=$infocomment['id'];
            }else{
                $top_comment_id=$infocomment['top_comment_id'];
            }
            $data=[
                'user_id'=>$user_id,
                'to_user_id'=>$infocomment['user_id'],
                'info_id'=>$infocomment['info_id'],
                'top_comment_id'=>$top_comment_id,
                'comment_id'=>$comment_id,
                'content'=>$content,
                'comment_type'=>$comment_type,
                'check_status'=>$check_status,
            ];
        }
        $infocommentModel->allowField(true)->save($data);
        success_json('发布成功');
    }
    //获取我的帖子
    public function getMyInfo(){
        $infoModel=new Info();
        $infoModel->fill_order_limit_length();
        $query = function ($query) {
            $user_id=input('request.user_id');
            if($user_id>0){
                $query->where('user_id',$user_id);
            }
            $query->where('is_del',0);
            $type = input('request.type');
            if ($type) {
                $query->where('check_status',$type);
            }
            $user_id=input('request.user_id');
        };
        $data=$infoModel->where($query)->with('user')->order('id desc')->select();
        $data=objecttoarray($data);
        $infobrowselikeModel=new Infobrowselike();
        foreach ($data as &$val){
            $val['pics']=json_decode($val['pic']);
            $val['cat_name']=Infocategory::get($val['cat_id'])['name'];
            $val['topcat_name']=Infocategory::get($val['topcat_id'])['name'];
            $val['browse_num']=$infobrowselikeModel->getBrowseNum($val['id']);
            $val['like_num']=$infobrowselikeModel->getLikeNum($val['id']);
            $val['is_like']=$infobrowselikeModel->getIsLike($val['user_id'],$val['id']);
            if($val['topping_time']>time()){
                $val['top_status']=1;
            }else{
                $val['top_status']=0;
            }
        }
        success_withimg_json($data);
    }
    //帖子点赞取消点赞
    public function setLike(){
        $user_id=input('request.user_id');
        $id=input('request.id');
        (new Infobrowselike())->setLike($user_id,$id);
        success_json('成功');
    }
    //获取帖子详情信息
    public function getInfoDetail(){
        $id=input('request.id');
        $user_id=input('request.user_id');
        $data=Info::get(['id'=>$id,'is_del'=>0]);
        $infoModel=new Info();
        if($data){
            $infobrowselikeModel=new Infobrowselike();
            //增加浏览记录
            $infobrowselikeModel->setBrowse($user_id,$id);
            $data['user']=User::get($data['user_id']);
            $data['pics']=json_decode($data['pic']);
            $data['cat_name']=Infocategory::get($data['cat_id'])['name'];
            $data['topcat_name']=Infocategory::get($data['topcat_id'])['name'];
            $data['browse_num']=$infobrowselikeModel->getBrowseNum($id);
            $data['like_num']=$infobrowselikeModel->getLikeNum($id);
            $data['is_like']=$infobrowselikeModel->getIsLike($user_id,$id);
            $data['content']=$infoModel->replace_word_filtering($data['content']);
            if($data['topping_time']>time()){
                $data['top_status']=1;
            }else{
                $data['top_status']=0;
            }
        }
        success_withimg_json($data);
    }
    //置顶过期变成排序变成0
    private function sort_zero(){
        $infoModel=new Info();
        $infoModel->where(['topping_time'=>['gt',0],'sort_id'=>['gt',0]])->field('id');
        $data=$infoModel->where(['topping_time'=>['lt',time()]])->select();
        $data=objecttoarray($data);
        if($data){
            foreach ($data as $val){
                (new Info())->allowField(true)->save(['sort_id'=>0],['id'=>$val['id']]);
            }
        }


    }
    //获取帖子列表信息
    public function getInfoList(){
        $this->sort_zero();
        $infoModel=new Info();
        $infoModel->fill_order_limit_length();
        $user_id=input('request.user_id');
        $query = function ($query){
            $infosettings=Infosettings::get_curr();
            $query->where('is_show',1);
            $query->where('check_status',2);
            $query->where('is_del',0);
            $topcat_id=input('request.topcat_id');
            if($topcat_id){
                $query->where('topcat_id',$topcat_id);
            }
            $cat_id=input('request.cat_id');
            if($cat_id){
                $query->where('cat_id',$cat_id);
            }
            $area_adcode=input('request.area_adcode');
            if($infosettings['national_status']==0){
                if($area_adcode){
                    if($infosettings['post_address']==1){
                        $query->where('adcode',$area_adcode);
                    }else{
                        $query->where('area_adcode',$area_adcode);
                    }
                }
            }
            $key=input('request.key');
            if($key){
                $query->where('content','like',"%$key%");
            }
        };
        $field=" * ";
        $order=' topping_time>'.time().' desc,sort_id desc,id desc';
        $sort=input('request.sort');
        if($sort==1){
            //$order='popularity_num desc,id desc';
        }else if($sort==2){
            $order='check_time desc,id desc';
        }else if($sort==3){
            $lat=input('request.lat');
            $lng=input('request.lng');
            $field="*,convert(acos(cos($lat*pi()/180 )*cos(lat*pi()/180)*cos($lng*pi()/180 -lng*pi()/180)+sin($lat*pi()/180 )*sin(lat*pi()/180))*6370996.81,decimal) as distance ";
            $order=" distance asc,id desc";
        }
        $data=$infoModel->where($query)->with('user')->field($field)->orderRaw($order)->select();
        $data=objecttoarray($data);
        $infobrowselikeModel=new Infobrowselike();
        foreach ($data as &$val){
            $val['pics']=json_decode($val['pic']);
            $val['cat_name']=Infocategory::get($val['cat_id'])['name'];
            $val['topcat_name']=Infocategory::get($val['topcat_id'])['name'];
            $val['browse_num']=$infobrowselikeModel->getBrowseNum($val['id']);
            $val['like_num']=$infobrowselikeModel->getLikeNum($val['id']);
            $val['is_like']=$infobrowselikeModel->getIsLike($user_id,$val['id']);
            $val['content']=$infoModel->replace_word_filtering($val['content']);
            if($val['topping_time']>time()){
                $val['top_status']=1;
            }else{
                $val['top_status']=0;
            }
        }
        success_withimg_json($data);
    }
    //获取帖子相关配置信息
   public function getInfosettings(){
        $data=Infosettings::get_curr();
        if($data){
            $data['map_key']=System::get_curr()['map_key'];
        }
        success_withimg_json($data);
   }
   //获取帖子栏目信息
    public function getInfocategory(){
       $parent_id=input('request.parent_id');
       $data=(new Infocategory())->where(['parent_id'=>$parent_id,'state'=>1,'is_del'=>0])->order('index asc')->select();
       success_withimg_json($data);
    }
    //获取置顶费用信息
    public function getInfotop(){
        $data=(new Infotop())->where(['state'=>1])->order('sort desc,id asc')->select();
        success_withimg_json($data);
    }
    //地址转换
    public function addressTo(){
        $address=input('request.address');
        $city=getCity($address);
        var_dump($city);
        $city=$this->getCity($city);
        var_dump($city);
        $adcode_address=input('request.adcode_address');
        if(!$city){
            $city=getCity($adcode_address);
            $city=$this->getCity($city);
            var_dump($city);
        }
    }
    //发布帖子
    public function setInfo(){
        $user_id=input('request.user_id');
        $cat_id=input('request.cat_id');
        $content=input('request.content');
        $pic=input('request.pic');
        $name=input('request.name');
        $phone=input('request.phone');
        $address=input('request.address');
        $area=input('request.area_adcode');
        $adcode_address=input('request.adcode_address');
        if($pic){
            $pic=explode(',',$pic);
            $pic=json_encode($pic);
        }
        (new Info())->check_version();
        $top_id=input('request.top_id')?input('request.top_id'):0;
        $lng=input('request.lng');
        $lat=input('request.lat');
        $top_status=0;
        $topcat_id=Infocategory::get($cat_id)['parent_id'];
        $money=0;
        $day_num=0;
        if($top_id>0){
            $top_status=1;
            $infotop=(new Infotop())->isExistInfotop($top_id);
            if(!$infotop){
                error_json('置顶收费不存在,请重新选择置顶信息');
            }
            $money=$infotop['money'];
            $day_num=$infotop['day_num'];
        }
        $city=getCity($address);
        $city=$this->getCity($city);
        if(!$city){
            $city=getCity($adcode_address);
            $city=$this->getCity($city);
            if(!$city) {
                error_json('位置信息有误');
            }
        }
        $citycode=$city['citycode'];
        $adcode=$city['adcode'];
        $infosettings=Infosettings::get_curr();
        if(!$infosettings){
            error_json('请先设置后台发布基础信息');
        }
        $ispost=(new Info())->isUserPost($user_id);
        if(!$ispost){
            error_json('超过当天发帖最多次数,请明天在发帖');
        }
        if($infosettings['is_check']==1){
            $need_status=1;
            $check_status=1;
        }else{
            $need_status=0;
            $check_status=2;
        }
        $infosettings=Infosettings::get_curr();
        $posting_fee=0;
        $is_show=1;
        if($infosettings['posting_fee_switch']==1){
            $posting_fee=$infosettings['posting_fee'];
            $is_show=0;
            $money+=$posting_fee;
        }
        //增加帖子记录
        $info=[
            'user_id'=>$user_id,
            'topcat_id'=>$topcat_id,
            'cat_id'=>$cat_id,
            'content'=>$content,
            'pic'=>$pic,
            'name'=>$name,
            'phone'=>$phone,
            'address'=>$address,
            'area_adcode'=>$area,
            'lng'=>$lng,
            'lat'=>$lat,
            'need_status'=>$need_status,
            'check_status'=>$check_status,
            'citycode'=>$citycode,
            'adcode'=>$adcode,
            'top_status'=>$top_status,
            'top_id'=>$top_id,
            'posting_fee'=>$posting_fee,
            'is_show'=>$is_show,
        ];
        $infoModel=new Info();
        $infoModel->allowField(true)->save($info);
        $info_id=$infoModel['id'];
        if($top_id>0||$money>0){
            //增加帖子置顶记录订单
            $toprecord=[
                'info_id'=>$info_id,
                'user_id'=>$user_id,
                'openid'=>User::get($user_id)['openid'],
                'top_id'=>$top_id,
                'day_num'=>$day_num,
                'order_amount'=>$money,
                'order_no'=>date("YmdHis") .rand(11111, 99999),
                'pay_status'=>0,
                'order_status'=>0,
                'need_status'=>$need_status,
                'check_status'=>$check_status,
            ];
            $infotoprecordModel=new Infotoprecord();
            $infotoprecordModel->allowField(true)->save($toprecord);
            $infotoprecord_id=$infotoprecordModel['id'];
            //保存帖子订单id
            $infoModel->allowField(true)->save(['record_id'=>$infotoprecord_id],['id'=>$info_id]);
            if($toprecord['order_amount']>0){
                $param=array(
                    'type'=>'TopOrder',
                    'order_id'=>$infotoprecord_id,
                );
                $this->getPayParam($param);
            }else{
                //0元支付处理
                (new Infotoprecord())->zeroPay($infotoprecord_id);
            }
        }
        success_json('发布成功');
    }
    //获取微信支付参数
    public function getPayParam($param){
        if($param['type']=='TopOrder'){
            $orderModel=new Infotoprecord();
            $order=$orderModel::get($param['order_id']);
            if(!$order){
                error_json('订单错误');
            }
            if($order['pay_status']==1||$order['order_status']>0){
                error_json('该订单已支付或者已取消');
            }
            $order['attach']=json_encode(array(
                'type'=>'TopOrder',
                'uniacid'=>$order['uniacid'],
            ));
            $data=$this->setPayParam($order);
            $data['order_id']=$param['order_id'];
            success_json($data);
        }
    }

    //设置微信支付参数
    private function setPayParam($order){
        global $_W;
        Loader::import('wxpay.wxpay');
        $system=System::get_curr();
        $appid = $system['appid'];
        $openid = $order['openid'];//openid
        $mch_id = $system['mchid'];//商户号
        $key = $system['wxkey'];   //密钥
        $out_trade_no = $order['order_no'];//订单号
        $total_fee = sprintf("%.0f",$order['order_amount']*100);//价格
        $body=$order['order_no'];
        $attach=$order['attach'];
        $siteroot=str_replace("https","http",$_W['siteroot']);
        $notify_url=$siteroot.'/addons/yztc_sun/public/notify.php';
        if($openid=='o3W0Y4_2rFmIi00R71ClYr1UpCyU'){
           // $total_fee=1;
        }
        if($total_fee<=0){
            error_json('金额有误');
        }
        $weixinpay = new \WeixinPay($appid, $openid, $mch_id, $key, $out_trade_no, $body, $total_fee,$attach,$notify_url);
        $return = $weixinpay->pay();
        return $return;
    }

    //获取省市编码信息
    public function getCity($data){
        $city=City::get(['name'=>$data['city'],'level'=>'city']);
       if(!$city){
           return false;
       }
        $are=str_replace("区","",$data['area']);
        $are=str_replace("县","",$are);
        $data=City::get(['citycode'=>$city['citycode'],'name'=>['like',"%$are%"],'level'=>'district']);
       if(!$data){
           return false;
       }
        return $data;
    }


}
