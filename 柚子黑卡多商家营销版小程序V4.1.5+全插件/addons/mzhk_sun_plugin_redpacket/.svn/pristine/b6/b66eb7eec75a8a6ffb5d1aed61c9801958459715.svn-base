<?php
defined('IN_IA') or exit ('Access Denied');

// error_reporting(0);
class auth{
    private $ip_a;
    private $cb9b = '12';
    private $check = '1972K+vbipdZEZacO7ghmwkmCp+lwv1dOIi8QNbaz2D90IAAQMJA6x66RDyjttTR/zbL+CgC6/DUbY3N';

    public function __construct(){
        $this->ip_a = gethostbynamel($_SERVER['HTTP_HOST']);
    }

    public function getdata(){
        global $_W;
        $message_a = $this->message_a;
        $ip_arr = $this->ip_a;
        $cb9b = $this->cb9b;
        $check = $this->check;
        $domain_a=$_SERVER['HTTP_HOST'];
        $contents_a_e = pdo_get("mzhk_sun_acode",array("id"=>3));
        $u = $this->createWebUrl('setting',array("settype"=>3));
        if($contents_a_e){
            $contents_a = encryptcode($contents_a_e["code"], 'D','',0);
        }
        if(!empty($contents_a)){
            $con_a = unserialize($contents_a);
            $time_a = time();
			if(isset($con_a["issa"]) && $con_a["issa"]==1){
				return true;
			}
            if($con_a["time"]<($time_a-3600*24*5)){
                $getdocode_a = getdocode($cb9b,$check);
            }
            if($con_a["domain"]!=$domain_a || $con_a["pid"]!=$cb9b){
                header("Location:".$u);
                exit;
            }
        }else{
            $getdocode_a = getdocode($cb9b,$check);
            if($getdocode_a!==0){
                header("Location:".$u);
                exit;
            }
        }
        return true;
    }
}