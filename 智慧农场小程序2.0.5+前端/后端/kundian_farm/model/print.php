<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2019/5/10 0010
 * Time: 上午 9:50
 */
defined('IN_IA') or exit('Access Denied');
require_once ROOT_PATH.'model/common.php';
class Print_KundianFarmModel{
    public $print='cqkundian_farm_print';
    protected $uniacid='';
    static $c='';
    public function __construct($uniacid=''){
        global $_W;
        $this->uniacid=$_W['uniacid'];
        if($uniacid){
            $this->uniacid=$uniacid;
        }
        self::$c=new Common_KundianFarmModel();
    }

    public function farmAddPrint($d){
        $update=[
            'p_sn'=>$d['p_sn'],
            'p_key'=>$d['p_key'],
            'name'=>$d['name'],
            'number'=>$d['number'],
            'rank'=>$d['rank'],
            'uniacid'=>$this->uniacid,
        ];
        require_once ROOT_PATH.'vendor/print/HttpClient.class.php';
        $snList = $update['p_sn']."#".$update['p_key']."#".$update['name']."#".$update['number'];
        $pSet=self::$c->getSetData(['print_user','print_ukey'],$this->uniacid);
        define('IP','api.feieyun.cn');			//接口IP或域名
        define('PORT',80);						//接口IP端口
        define('PATH','/Api/Open/');		//接口路径
        define('STIME', time());			    //公共参数，请求时间
        define('SIG', sha1($pSet['print_user'].$pSet['print_ukey'].STIME));   //公共参数，请求公钥
        if(empty($d['id'])){
            $r=pdo_insert($this->print,$update);
            if($r){
                $res=$this->addprinter($snList,$pSet['print_user'],'Open_printerAddlist');
                $res1=json_decode($res);
                if($res1->msg=='ok'){
                    return true;
                }
                return false;
            }
            return false;
        }
        return true;
    }

    public function FarmDelPrint($id){
        require_once ROOT_PATH.'vendor/print/HttpClient.class.php';
        $pSet=self::$c->getSetData(['print_user','print_ukey'],$this->uniacid);
        define('IP','api.feieyun.cn');			//接口IP或域名
        define('PORT',80);						//接口IP端口
        define('PATH','/Api/Open/');		//接口路径
        define('STIME', time());			    //公共参数，请求时间
        define('SIG', sha1($pSet['print_user'].$pSet['print_ukey'].STIME));   //公共参数，请求公钥
        $data=pdo_get($this->print,['id'=>$id,'uniacid'=>$this->uniacid]);
        $res=pdo_delete($this->print,['id'=>$id,'uniacid'=>$this->uniacid]);
        if($res){
            $res=$this->deletePrinter($pSet['print_user'],$data['p_sn']);
            $res1=json_decode($res);
            if($res1->msg=='ok'){
                return true;
            }
            return false;
        }
        return false;
    }

    /** 测试打印机 */
    public function printTest($sn,$title,$content){
        $pSet=self::$c->getSetData(['print_user','print_ukey'],$this->uniacid);
        require_once ROOT_PATH.'vendor/print/HttpClient.class.php';
        define('USER', $pSet['print_user']);    //*必填*：飞鹅云后台注册账号
        define('UKEY', $pSet['print_ukey']);    //*必填*: 飞鹅云注册账号后生成的UKEY
        define('SN', $sn);        //*必填*：打印机编号，必须要在管理后台里添加打印机或调用API接口添加之后，才能调用API
        //以下参数不需要修改
        define('IP', 'api.feieyun.cn');            //接口IP或域名
        define('PORT', 80);                        //接口IP端口
        define('PATH', '/Api/Open/');        //接口路径
        define('STIME', time());                //公共参数，请求时间
        define('SIG', sha1(USER . UKEY . STIME));   //公共参数，请求公钥

        $orderInfo = '<CB>'.$title.'</CB><BR>';
        $orderInfo .= $content.'<BR>';
        //echo $orderInfo;
        //打开注释可测试
        return $this->wp_print(SN, $orderInfo, 1);
    }

    /** 打印订单信息 */
    public function printOrder($oData,$sn,$time){
        global $_W;
        $pSet=self::$c->getSetData(['print_user','print_ukey'],$this->uniacid);
        require_once ROOT_PATH.'vendor/print/HttpClient.class.php';
        define('USER', $pSet['print_user']);    //*必填*：飞鹅云后台注册账号
        define('UKEY', $pSet['print_ukey']);    //*必填*: 飞鹅云注册账号后生成的UKEY
        define('SN', $sn);        //*必填*：打印机编号，必须要在管理后台里添加打印机或调用API接口添加之后，才能调用API
        //以下参数不需要修改
        define('IP', 'api.feieyun.cn');            //接口IP或域名
        define('PORT', 80);                        //接口IP端口
        define('PATH', '/Api/Open/');        //接口路径
        define('STIME', time());                //公共参数，请求时间
        define('SIG', sha1(USER . UKEY . STIME));   //公共参数，请求公钥

        $orderInfo='<CB>'.$_W['account']['name'].'</CB><BR>';

        foreach ($oData['orderDetail'] as $k => $v){
            $orderInfo.='商品名称：'.$v['goods_name'].'<BR>';
            if($oData['is_integral']){
                if($v['skuName']){
                    $orderInfo.='规格：'.$v['skuName'].'<BR>';
                }
                $orderInfo.='单价：'.$v['price'].'积分<BR>';
                $orderInfo.='数量：'.$v['count'].'<BR>';
                $orderInfo.='运费：'.$v['send_price'].'元<BR>';
            }else{
                if($oData['order_type']==3){
                    $orderInfo.='认养编号：'.$v['add_info']['adopt_number'].'<BR>';
                    $orderInfo.='已认养天数：'.ceil((time()-$v['add_info']['create_time'])/86400).'天<BR>';
                    $orderInfo.='认养时间：'.date('Y-m-d H:i',$v['add_info']['create_time']).'<BR>';
                }elseif ($oData['order_type']==4){
                    $orderInfo.='土地编号：'.$v['land_num'].'<BR>';
                    if($v['seedBag']['weight']){
                        $orderInfo.='土地编号：'.$v['seedBag']['weight'].'kg<BR>';
                    }
                }else{
                    if($v['skuName']){
                        $orderInfo.='规格：'.$v['skuName'].'<BR>';
                    }
                    $orderInfo.='单价：'.$v['price'].'元<BR>';
                    $orderInfo.='数量：'.$v['count'].'<BR>';
                    $orderInfo.='小计：'.$v['count']*$v['price'].'元<BR>';
                }
            }

            $orderInfo.='--------------------------------<BR>';

        }

        $orderInfo.='订单编号：'.$oData['order_number'].'<BR>';
        $orderInfo.='下单时间：'.$oData['create_time'].'<BR>';
        $orderInfo.='总计：'.$oData['total_price'].'元<BR>';
        if($oData['remark'] && $oData['remark']!='undefined'){
            $orderInfo.='备注：'.$oData['remark'].'<BR>';
        }
        $orderInfo.='出票时间：'.date("Y-m-d H:i:s",time()).'<BR>';
        $orderInfo.='收货人：'.$oData['name'].'<BR>';
        $orderInfo.='联系电话：'.$oData['phone'].'<BR>';
        $orderInfo.='收货地址：'.$oData['address'].'<BR>';
        return $this->wp_print(SN, $orderInfo, $time);
    }

    public function wp_print($printer_sn,$orderInfo,$times){
        $content = array(
            'user'=>USER,
            'stime'=>STIME,
            'sig'=>SIG,
            'apiname'=>'Open_printMsg',

            'sn'=>$printer_sn,
            'content'=>$orderInfo,
            'times'=>$times//打印次数
        );

        $client = new HttpClient(IP,PORT);
        if(!$client->post(PATH,$content)){
            return false;
        }
        else{
            //服务器返回的JSON字符串，建议要当做日志记录起来
            return $client->getContent();
        }

    }

    /**
     * 添加打印机
     * @param $snlist  打印机添加信息
     * @param $user    打印机用户
     * @param $apiname 接口名称
     * @return string  返回类型
     */
    public function addprinter($snlist,$user,$apiname){
        $content = [
            'user'=>$user,
            'stime'=>STIME,
            'sig'=>SIG,
            'apiname'=>$apiname,
            'printerContent'=>$snlist
        ];
        $client = new HttpClient(IP,PORT);
        if(!$client->post(PATH,$content)){
            echo 'error';
        }else{
            return $client->getContent();
        }
    }

    public function deletePrinter($user,$snlist){
        $content = array(
            'user'=>$user,
            'stime'=>STIME,
            'sig'=>SIG,
            'apiname'=>'Open_printerDelList',
            'snlist'=>$snlist
        );
        $client = new HttpClient(IP,PORT);
        if(!$client->post(PATH,$content)){
            echo 'error';
        }else{
            return $client->getContent();
        }
    }



}