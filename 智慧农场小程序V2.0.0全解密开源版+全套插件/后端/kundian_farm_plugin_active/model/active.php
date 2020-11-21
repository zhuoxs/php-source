<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2018/10/10
 * Time: 9:54
 */
defined('IN_IA') or exit('Access Denied');

class Active_KundianFarmPluginActive{
    protected $uniacid='';
    public $active='cqkundian_farm_plugin_active';
    public $active_order='cqkundian_farm_plugin_active_order';
    public function __construct($uniacid=''){
        global $_W;
        if($uniacid){
            $this->uniacid=$uniacid;
        }else{
            $this->uniacid=$_W['uniacid'];
        }

    }

    public function getQrCode($order_id){
        $account_api=WeAccount::create();
        $access_token=$account_api->getAccessToken();
        $params = array(
            'path' => "kundian_active/pages/check/index?order_id=".$order_id,
        );

        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/wxa/getwxacode?access_token={$access_token}");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        $response = curl_exec($ch);
        $filename = md5(uniqid()).'.png';
        $tmp_file =IA_ROOT."/addons/kundian_farm/resource/img/temp/{$filename}";
        file_put_contents($tmp_file, ob_get_contents());
        $check_result = json_decode(ob_get_contents(), true);
        curl_close($ch);
        ob_end_clean();
        if ($check_result['errcode']) {
            return false;
        }

        $filepath="kundian_farm/resource/img/temp/";
        $file['savepath'] =$filepath;
        $file['savename'] = $filename;
        $file['tmp_name'] = $tmp_file;
        $file['type'] = 'image/png';
        $file['size'] = filesize($tmp_file);
        $img_url = $this->uploadLocalFile($filepath.$filename);
        if($img_url) {
            @unlink($tmp_file);
            if ($img_url) {
                return $img_url;
            } else {
                return false;
            }
        }else{
            global $_W;
            $local_img=$_W['siteroot']."/addons/kundian_farm/resource/img/temp/{$filename}";
            return $local_img;
        }
    }

    public function uploadLocalFile($filename,$auto_delete_local='true'){
        global $_W;
        error_reporting(0);
        load()->library('qiniu');
        $auth = new Qiniu\Auth($_W['setting']['remote']['qiniu']['accesskey'], $_W['setting']['remote']['qiniu']['secretkey']);
        $config = new Qiniu\Config();
        $uploadmgr = new Qiniu\Storage\UploadManager($config);
        $putpolicy = Qiniu\base64_urlSafeEncode(json_encode(array(
            'scope' => $_W['setting']['remote']['qiniu']['bucket'] . ':' . $filename,
        )));
        $uploadtoken = $auth->uploadToken($_W['setting']['remote']['qiniu']['bucket'], $filename, 3600, $putpolicy);
        list($ret, $err) = $uploadmgr->putFile($uploadtoken, $filename, IA_ROOT . '/addons/' .$filename);
        if ($auto_delete_local) {
        }
        $url=tomedia($filename);
        if ($err !== null) {
            //return error(1, '远程附件上传失败，请检查配置并重新上传');
            return false;
        } else {
            return $url;
        }
    }

    public function addActive($get){
        $formData=$get;
        $update=[
            'title'=>$formData['title'],
            'cover'=>tomedia($formData['cover']),
            'begin_time'=>strtotime($formData['time[start']),
            'end_time'=>strtotime($formData['time[end']),
            'start_time'=>strtotime($formData['start']),
            'address'=>$formData['address'],
            'phone'=>$formData['phone'],
            'rank'=>$formData['rank'],
            'status'=>$formData['status'],
            'detail'=>$formData['detail'],
            'uniacid'=>$this->uniacid,
            'longitude'=>$formData['addr[lng'],
            'latitude'=>$formData['addr[lat'],
            'is_check'=>$formData['is_check'],
            'times_enroll'=>$formData['times_enroll'],
            'count'=>$formData['count'],
        ];

        $m=0;
        $add_info=[];
        while ($formData["add_info[$m"]){
            $add_info[]=$formData["add_info[$m"];
            $m++;
        }

        $update['add_info']=serialize($add_info);
        if($get['id']){
            $active_id=$get['id'];
            pdo_update($this->active,$update,['id'=>$get['id'],'uniacid'=>$this->uniacid]);
        }else{
            pdo_insert($this->active,$update);
            $active_id=pdo_insertid();
        }
        $x=0;
        while($formData["spec_name[$x"]) {
            $goods_slide[]=tomedia($formData["spec_name[$x"]);
            $specUpdate=[
                'spec_name'=>$formData["spec_name[$x"],
                'price'=>$formData["spec_price[$x"],
                'spec_desc'=>$formData["spec_desc[$x"],
                'active_id'=>$active_id,
                'uniacid'=>$this->uniacid,
            ];
            if(empty($get['id'])){
                pdo_insert('cqkundian_farm_plugin_active_spec',$specUpdate);
            }else{
                $spec_id=$formData["spec_id[$x"];
                $con=['id'=>$spec_id,'active_id'=>$active_id];
                $is_exist=pdo_get('cqkundian_farm_plugin_active_spec',$con);
                if(empty($is_exist)){
                    pdo_insert('cqkundian_farm_plugin_active_spec',$specUpdate);
                }else{
                    pdo_update('cqkundian_farm_plugin_active_spec',$specUpdate,['id'=>$spec_id]);
                }
            }
            $x++;
        }
        return $active_id;
    }

    public function getActiveOrder($cond,$page='',$size=''){
        if(empty($cond['uniacid'])) $cond['uniacid']=$this->uniacid;

        $query=load()->object("query");
        if(!empty($page) && !empty($size)) {
            $list = $query->from($this->active_order, 'a')
                ->leftjoin($this->active, 'b')->on('a.active_id', 'b.id')
                ->leftjoin('cqkundian_farm_plugin_active_spec', 'c')->on('c.id', 'a.spec_id')
                ->leftjoin('cqkundian_farm_user', 'd')->on('a.uid', 'd.uid')
                ->select('a.*', 'b.start_time', 'b.cover', 'b.title', 'c.spec_name', 'c.price','d.nickname')
                ->where($cond)->page($page, $size)->getall();
        }else{
            $list = $query->from($this->active_order, 'a')
                ->leftjoin($this->active, 'b')->on('a.active_id', 'b.id')
                ->leftjoin('cqkundian_farm_plugin_active_spec', 'c')->on('c.id', 'a.spec_id')
                ->leftjoin('cqkundian_farm_user', 'd')->on('a.uid', 'd.uid')
                ->select('a.*', 'b.start_time', 'b.cover', 'b.title', 'c.spec_name', 'c.price','d.nickname')
                ->where($cond)->getall();
        }

        for ($i=0;$i<count($list);$i++){
            $list[$i]['create_time']=date('Y-m-d H:i:s',$list[$i]['create_time']);
            $list[$i]=$this->neatenOrder($list[$i]);
        }

        return $list;
    }

    function getWeek($day){
        switch ($day){
            case 1:
                return "周一";
                break;
            case 2:
                return '周二';
                break;
            case 3:
                return '周三';
                break;
            case 4:
                return '周四';
                break;
            case 5:
                return '周五';
                break;
            case 6:
                return '周六';
                break;
            case 0:
                return '周日';
                break;
        }
    }

    /**
     * 订单状态整理
     * @param $orderData    //订单类型
     * @return mixed
     */
    function neatenOrder($orderData){
        if($orderData['apply_delete']==0){
            if($orderData['is_pay']==0){
                $orderData['status']=0;
                $orderData['status_txt']='未支付';
            }else{
                if($orderData['is_check']==0){
                    $orderData['status']=1;
                    $orderData['status_txt']='已支付，待审核';
                }elseif ($orderData['is_check']==1){
                    $orderData['status']=2;
                    $orderData['status_txt']='审核通过，待参加';
                }elseif ($orderData['is_check']==2){
                    $orderData['status']=3;
                    $orderData['status_txt']='审核未通过';
                }elseif ($orderData['is_check']==3){
                    $orderData['status']=4;
                    $orderData['status_txt']='已参加';
                }
            }
        }else{
            $orderData['status']=5;
            $orderData['status_txt']='订单已取消';
        }

        return $orderData;
    }
}