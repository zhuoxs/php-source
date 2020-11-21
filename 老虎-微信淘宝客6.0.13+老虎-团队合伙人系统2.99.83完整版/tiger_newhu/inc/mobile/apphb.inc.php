<?php
global $_GPC,$_W;
$cfg = $this->module['config'];
$weid=$_W['uniacid'];
		
        $uid=$_GPC['uid'];//会员ID
        $h=$_GPC['hbid'];//海报ID
				//file_put_contents(IA_ROOT."/addons/tiger_tkxcx/inc/wxapp/yq_log.txt","uid".$uid."----".$weid."----",FILE_APPEND);
				
				$share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$weid}' and id='{$uid}'");
				//file_put_contents(IA_ROOT."/addons/tiger_tkxcx/log.txt","\n".json_encode($share),FILE_APPEND);	
				//echo "<pre>";
				//print_r($share);
				//exit;
				
				if(empty($share['yaoqingma'])){
					$yaoqingma="tk".$share['id'];
					$b=pdo_update("tiger_newhu_share",array('yaoqingma'=>$yaoqingma), array ('id' =>$share['id'],'weid'=>$weid));
				}
        
        //海报背景
        $hbbj = pdo_fetch("select * from ".tablename("tiger_app_hb")." where weid='{$weid}' and id='{$h}'");
				//print_r($hbbj);

        $url1=$cfg['tknewurl']."app/index.php?i=".$weid."&c=entry&do=apphbfx&m=tiger_newhu&yq=".$share['yaoqingma']."&hid=".$share['id'];
		
		$url=urlencode($url1);

        $ewmp="http://bshare.optimix.asia/barCode?site=weixin&url=".$url;
        
        $ewm=appgetimg($ewmp,'',$_W);
        $hbimg=picjialidun($ewm,tomedia($hbbj['pic']),$cfg['tknewurl'],$share);
        //小图
         $pathxt=IA_ROOT."/attachment/images";
         $des_w = 80;
				 $des_h = 120;
				$filename = $hbimg;
				$name = deal($des_w,$des_h,$filename,$pathxt);
				//echo $name."---";
				//echo $cfg['tknewurl']."---".IA_ROOT;

				
				$name=str_replace(IA_ROOT."/",$cfg['tknewurl'],$name);
        //小图结束
				
				
        
        $data=array(
        	'url'=>$hbimg,
        	'surl'=>$name,
        	'fxurl'=>"",
        	'fxtitle'=>$cfg['appname'],
        	'fxcontent'=>$cfg['apptxt'],
        );
 
      exit(json_encode(array('errno'=>0,'data'=>array('data'=>$data))));   
     // $this->result(0, 'OK', array('data' =>$data));
        
        
    function appgetimg($url,$path='',$_W){//二维码保存到指定分日期保存目录
	            empty($path)&&($path = IA_ROOT."/addons/tiger_newhu/goodsimg/".date("Ymd"));
	            !file_exists($path)&&mkdir ($path, 0777, true );
	            if($url == "")return false;
	            $sctime=date("YmdHis").sjrd44(6);
	            $filename = $path.'/'.$sctime.".png";
	            ob_start();
	            readfile($url);
	            $img = ob_get_contents();
	            ob_end_clean();
	            $fp = fopen($filename, "a");
	            fwrite($fp, $img);
	            fclose($fp);
	            //return $filename.'-----'."/addons/tiger_newhu/goodsimg/".$sctime.".jpg";//返回文件名
	            return $_W['siteroot']."addons/tiger_newhu/goodsimg/".date("Ymd").'/'.$sctime.".png";//返回文件名
	    }
	    
	    function sjrd44($length = 4){ 
            $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
            $str = ''; 
            for ($i = 0; $i<$length;$i++ ) 
            {  
                $str .= $chars[mt_rand(0, strlen($chars)-1)]; 
            } 
            return $str; 
        } 
        
        /**
	   $UID 会员ID
	   **/
	  	function picjialidun($ewm,$pic,$httpsurl,$share){//生成产品海报图片
	  		
	  		$path = IA_ROOT."/addons/tiger_tkxcx/ewm/".date("Ymd");
	  		
            !file_exists($path)&&mkdir ($path, 0777, true );           
            $sctime=date("YmdHis").sjrd44(6);
            $filename = $path.'/'.$sctime.".jpg";
            $picurl=$httpsurl."addons/tiger_tkxcx/ewm/".date("Ymd")."/".$sctime.".jpg";
            
	        if(empty($pic)){
	        	$background_pic_path=IA_ROOT.'/addons/tiger_app/hb/6401.jpg';
	        }else{
	        	$background_pic_path=$pic;//IA_ROOT.'/attachment/'.$pic;
	        }
	        
	        
	        //return $background_pic_path;
	
	        
	        $im  = imagecreatefromjpeg($background_pic_path);
	        $font=IA_ROOT.'/addons/tiger_tkxcx/font/msyh.ttf';
	        $color= imagecolorallocate($im, 52,52,52);
					//file_put_contents(IA_ROOT."/addons/tiger_tkxcx/inc/wxapp/yq_log.txt",$share['yaoqingma'],FILE_APPEND);
//	        imagettftext($im, 26, 0, 206,930, $color, $font,$share['yaoqingma']);//邀请码暂时不要了
	        
	        list($width,$height) = getimagesize($ewm);        
	        $newwidth = 195;
	        $newheight = 195;
	        $thumb = imagecreatetruecolor($newwidth,$newheight);
	        $source = imagecreatefrompng($ewm);
	        $aa=imagecopyresampled($im, $source, 273,968, 0, 0, $newwidth, $newheight, $width, $height);//二维码位置
	
	
	        imagejpeg($im,$filename);//保存图片
	        imagedestroy($im);	        
	        return $picurl;
		}
		
		// * @todo  把一张图片按照用户定义的高宽进行缩放，并把处理后的图片重命名，放在指定文件夹
// * @param string $width:用户定义的需要处理成的目标宽度
// * @param string $height:用户定义的需要处理的目标高度
// * @param string $filename: 图片的名字
// * @param string $path:可选参数，保存的新图片的路径，若不传值，则默认当前目录
// * @return string $newname: 返回的是处理后的图片的新名字
// */
	function deal($width,$height,$filename,$path=''){
		     /* getimagesize 获取图像的数据，返回值是一个数组，
		      * arr[0]代表图片的宽度 ，arr[1]代表图片的高度，arr[2]代表图像类型，返回的是数字
		      * arr[3] 代表包含图片高宽的字符串，如width='200' height='100',可直接用在html标签里面
		      * arr[bits]代表图像的每种颜色的位数，用二进制表示
		      * arr[mime]图像的mime信息，如image/png
		      * arr[channels]:图像的通道值
		      * */
		     $arr = getimagesize($filename);
		
		     //判断传入的图片的格式，创建、生成相应的图片格式
		     switch ($arr['mime']){//mime获取图像的mime值，用于判断创建图片的格式和生成图片的格式
		         case "image/png":
		             $srcType = 'imagecreatefrompng';
		             $outType = 'imagepng';
		             break;
		         case "image/gif":
		             $srcType = 'imagecreatefromgif';
		             $outType = 'imagegif';
		             break;
		         case "image/jpg":
		         case "image/jpeg":
		             $srcType = 'imagecreatefromjpeg';
		             $outType = 'imagejpeg';
		             break;
		     }
		
		    $src_img = $srcType($filename);
		    $src_w = $arr[0];  //获取传入图片的真实宽度
		    $src_h = $arr[1];  //获取传入图片的真实高度
		    $des_w = $width;   //用户定义的传入的宽度，即目标宽度
		    $des_h = $height;  //用户定义的传入的高度，即目标高度
		    $scale_w = $src_w/$des_w;   //获取真实宽度与目标宽度的比例
		    $scale_h = $src_h/$des_h;   //获取真实高度与目标高度的比例
		
		    if($src_w <= $des_w && $src_h <= $des_h){
		        $true_w = $src_w;
		        $true_h = $src_h;
		        $des_img = imagecreatetruecolor($true_w, $true_h);
		
		        //若scale_w > scale_h ,即原图片的宽大于高，横向图片,依据宽为基准
		    }elseif ($scale_w >= $scale_h){
		        $true_w = $src_w/$scale_w;
		        $true_h = $src_h/$scale_w;
		        $des_img = imagecreatetruecolor($true_w,$true_h);
		
		        //否则就是原图片的高大于宽，竖向图片,则依据高为基准来缩放
		    }else{
		        $true_w = $src_w/$scale_h;
		        $true_h = $src_h/$scale_h;
		        $des_img = imagecreatetruecolor($true_w,$true_h);
		    }
		
		    imagecopyresized($des_img, $src_img, 0, 0, 0, 0, $true_w, $true_h, $src_w, $src_h);
		
		    //下面是重命名操作后的图片
		    $temp = explode('/', $filename);  //把路径、文件名拆分成数组，方便操作，例如：img/new/a.png，被拆分成temp['img','new','a.png'];
		    $temp = array_pop($temp);  //通过pop删除操作，返回最后一个参数值，此参数值为图片名字，如a.png
		    $ext = substr($temp, strrpos($temp, '.'));//获取图片的后缀名，通过字符串截取，从最后一个.出现的位置截取到末尾，如.png
		    $name = substr($temp, 0,strrpos($temp, '.'));//获取图片的名字，通过字符串截取，截取最后一个.出现的位置之前的全部字符，如a
		    $truePath = !empty($path) ? $path."/" : ''; //将路径名保存在变量truePath里面
		
		    //如果路径存在，且不为路径名，如c.txt，则创建一个名为c.txt的路径（文件夹）；如果路径存在，且为路径名，则执行下一句；如果未传入路径名，则执行下一句
		    if(!empty($truePath) && !is_dir($truePath)){
		        mkdir($truePath,0777,true);
		    }
		
		    //给图片新命名，以路径名+原名字+自定义字符+后缀来命名。图片会存放在相应路径下
		    $newname = $truePath.$name."_150_".time().$ext;
		    $outType($des_img,$newname);
		
		    //$outType($des_img);
		
		    return $newname;  
		 }
	
		
?>