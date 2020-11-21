<?php
defined('IN_IA') or exit ('Access Denied');
//error_reporting(0);
class AuthClass{
    private $message_a = "您的站点未授权，授权请联系服务商";
    private $fname_a = "/addons/mzhk_sun/inc/web/";
    private $ip_a;
    private $cb9b = '12';
    private $check = '1972K+vbipdZEZacO7ghmwkmCp+lwv1dOIi8QNbaz2D90IAAQMJA6x66RDyjttTR/zbL+CgC6/DUbY3N';

    public function __construct(){
        $this->ip_a = gethostbynamel($_SERVER['HTTP_HOST']);
    }

    public function getcodeidea(){
        $message_a = $this->message_a;
        $fname_a = $this->fname_a;
        $ip_arr = $this->ip_a;
        //$ip_a = $ip_arr[0];
        $cb9b = $this->cb9b;
        $check = $this->check;
        $domain_a=$_SERVER['HTTP_HOST'];
		$contents_a_e = pdo_get("mzhk_sun_acode",array("id"=>1));
        if($contents_a_e){
            $contents_a = encryptcode($contents_a_e["code"], 'D','',0);
        }
        //$contents_a_e = file_get_contents(IA_ROOT.$fname_a."sqcode.php");
        //$contents_a = encryptcode($contents_a_e, 'D','',0);
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
				$isnoauth = true;
                if($con_a["domain_str"]){
                    $domain_str = explode(",",$con_a["domain_str"]);
                    if(in_array($domain_a, $domain_str)){
                        $isnoauth = false;
                    }
                }
                if($isnoauth){
                    echo '<font color=red>'.$message_a.'</font>';
                    exit;
                }
            }
            // if(in_array($con_a["ip"], $ip_arr)){
            //     if(in_array($con_a["loca_ip"], $ip_arr)){
            //         echo '<font color=red>'.$message_a.'</font>';
            //         exit;
            //     }
            // }
        }else{
            $getdocode_a = getdocode($cb9b,$check);
            if($getdocode_a!==0){
                echo '<font color=red>'.$message_a.'</font>';
                exit;
            }
        }
        return true;
    }
}