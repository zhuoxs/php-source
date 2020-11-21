<?php



    load()->func('tpl');

        global $_GPC, $_W;

        $opt = $_GPC['opt'];

        $ops = array('display','post', 'delete','qrcode','searchs','do_qrcode');

        $opt = in_array($opt, $ops) ? $opt : 'display';

        $uniacid = $_W['uniacid'];



       

        //文章列表

        if ($opt == 'display'){

            $_W['page']['title'] = '员工管理';

            $where = "";

            $skey = $_GPC['skey'];

            if(!empty($skey)){

                $where = " and realname like '%%".$skey."%%'";

            }


            $total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_staff')." WHERE uniacid = :uniacid ".$where, array(':uniacid' => $uniacid));

            if($_GPC['first'] == '1'){

                $pageindex = 1;

            }else{

                $pageindex = max(1, intval($_GPC['page']));

            }

            $pagesize = 10;  

            $start = ($pageindex-1) * $pagesize;

            $pager = pagination($total, $pageindex, $pagesize);



             // 获取文章分类

            $staffs = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_staff')." WHERE uniacid = :uniacid ".$where." ORDER BY num DESC limit $start, $pagesize", array(':uniacid' => $uniacid));
            foreach ($staffs as $key => &$value) {
                $value['score'] = intval($value['score']);
            }



        }

        

        //员工添加/编辑

        if($opt == 'post'){

            $id = intval($_GPC['id']);

            $stores = pdo_fetchall("SELECT id,title FROM ".tablename('sudu8_page_store')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));

            $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_staff')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));

            $item['expand'] = unserialize($item['expand']);
            $item['score'] = intval($item['score']);

            if (checksubmit('submit')) {
                $duogg = $_GPC['duogg'];

                $duoggarr = explode(',',substr($duogg, 0,strlen($duogg)-1));

                $kkk = serialize($duoggarr);

                if (empty($_GPC['num'])) {

                    $num = 1;

                }else{
                    $num = $_GPC['num'];
                }

                if (empty($_GPC['realname'])) {

                    message('请输入员工真实姓名！');

                }
                $age = $_GPC['age'];

                $mobile = $_GPC['mobile'];

                if (empty($mobile)) {

                    message('请输入员工手机号码！');

                }else{

                    if (!preg_match("/^1[3456789]{1}\d{9}$/",$mobile)) {

                        message('手机号格式错误！');

                    }

                }



                $score = intval($_GPC['score']);

                if(!$score){

                    $score = 0;

                }

                if(!is_numeric($score)){

                    message('评分为数值,请输入数字');

                }else{

                    

                    if($score < 0 || $score > 5){

                        message('评分数值为0-5分,请输入正确的数字');

                    }

                }



                $len = strlen($score);

                if($len>3){

                    $score = substr($score,0,3);

                }


                if($_GPC['visit'] > 0){
                    $visit = $_GPC['visit'];
                }

                if($_GPC['zan'] > 0){
                    $zan = $_GPC['zan'];
                }

                if($_GPC['forward'] > 0){
                    $forward = $_GPC['forward'];
                }

                if($_GPC['price'] > 0){
                    $price = $_GPC['price'];
                }


                $proid = $_GPC['province'];

                $cityid = $_GPC['city'];

                $areaid = $_GPC['area'];


                $province =  $_GPC['pro'] ? $_GPC['pro'] : $item['province'];

                $city = $_GPC['cit'] ? $_GPC['cit'] : $item['city'];

                $area = $_GPC['are'] ? $_GPC['are'] : $item['area'];



                //富文本内容处理

                $descp = $_GPC['text'];

                // $descp = htmlspecialchars_decode($descp);//把一些预定义的 HTML 实体转换为字符

                // $descp = strip_tags($descp);//函数剥去字符串中的 HTML、XML 以及 PHP 的标签,获取纯文本内容





                $data = array(

                    'uniacid' => $uniacid,

                    'realname' => $_GPC['realname'],

                    'age' => $_GPC['age'],

                    'mobile' => $mobile,

                    'wxnumber' => $_GPC['wxnumber'],

                    'email' => $_GPC['email'],

                    'company' => $_GPC['company'],

                    'province' => $province,

                    'city' => $city,

                    'area' => $area,

                    'address' => $_GPC['address'],

                    'title' => $_GPC['title'],

                    'job' => $_GPC['job'],

                    'pic' => $_GPC['thumb'],

                    'contract' => $_GPC['contract'],

                    'auth' => $_GPC['auth'],

                    'score' => $score,

                    'visit' => $visit,

                    'zan' => $zan,

                    'forward' => $forward,

                    'price' => $price,

                    'descp' => $descp,

                    'expand' => $kkk,

                    'proid' => $proid,

                    'cityid' => $cityid,

                    'areaid' => $areaid,

                    'voice' => $_GPC['voice'],

                    'autovoice' => $_GPC['autovoice'],

                    'num' => $_GPC['num'],

                    'store' => $_GPC['storeid'],
                    
                    'hxmm' => $_GPC['hxmm'],
                );






                if (empty($id)) {

                    pdo_insert('sudu8_page_staff', $data);

                } else {

                    pdo_update('sudu8_page_staff', $data, array('id' => $id ,'uniacid' => $uniacid));

                }

                message('员工 添加/修改 成功!', $this->createWebUrl('Commentset', array('op'=>'staff','opt'=>'display','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');

            }



        }





         //员工删除

        if($opt == 'delete'){

            $id = intval($_GPC['id']);

            $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_staff')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));

            if (empty($row)) {

                message('员工不存在或是已经被删除！');

            }

            pdo_delete('sudu8_page_staff', array('id' => $id ,'uniacid' => $uniacid));

             message('员工 删除 成功!', $this->createWebUrl('Commentset', array('op'=>'staff','opt'=>'display','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');

        }



        //生成二维码页面

        if($opt == 'qrcode'){

            $id = intval($_GPC['id']);

            $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_staff')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));

        }



        //生成二维码页面

        if($opt == 'do_qrcode'){

            $id = intval($_GPC['id']);

            $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_staff')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));

            // if($item['bqrcode'] == null){

                $app = pdo_fetch("SELECT * FROM ".tablename('account_wxapp')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
                $appid = $app['key'];
                $appsecret = $app['secret'];
                $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
                $weixin = file_get_contents($url);
                $jsondecode = json_decode($weixin); //对JSON格式的字符串进行编码
                $array = get_object_vars($jsondecode);//转换成数组
                $access_token = $array['access_token'];//输出openid

                $id = $_GPC['id'];

                $ewmurl = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=" . $access_token;
                $sjc = time().rand(1000,9999);
                $pagepath = 'sudu8_page/staff_card/staff_card';
                $data = [
                            'page' => $pagepath,
                            'width' => '500',
                            'scene' => $id
                        ];
                $data=json_encode($data);
                //$result = $this->_requestPost($ewmurl,$data); 
                //_requestPost($url, $data, $ssl=true) {  
                $curl = curl_init();  
                //设置curl选项  
                curl_setopt($curl, CURLOPT_URL, $ewmurl);//URL  
                $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0 FirePHP/0.7.4';  
                curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);//user_agent，请求代理信息  
                curl_setopt($curl, CURLOPT_AUTOREFERER, true);//referer头，请求来源  
                curl_setopt($curl, CURLOPT_TIMEOUT, 30);//设置超时时间  
                //SSL相关  
                if (true) {  
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//禁用后cURL将终止从服务端进行验证  
                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//检查服务器SSL证书中是否存在一个公用名(common name)。  
                }  
                // 处理post相关选项  
                curl_setopt($curl, CURLOPT_POST, true);// 是否为POST请求  
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);// 处理请求数据  
                // 处理响应结果  
                curl_setopt($curl, CURLOPT_HEADER, false);//是否处理响应头  
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);//curl_exec()是否返回响应结果  
      
                // 发出请求  
                $response = curl_exec($curl);
                
                if (false === $response) {  
                    echo '<br>', curl_error($curl), '<br>';  
                    return false;  
                }  
                curl_close($curl);  

                // var_dump($response);die;
                // var_dump($result);
                // die();
                $newpath = ROOT_PATH."ewmimg";
                if(!file_exists($newpath)){
                    mkdir($newpath);
                }

                file_put_contents(ROOT_PATH."ewmimg/".$sjc.".jpg", $response); 
                $path = MODULE_URL."ewmimg/".$sjc.".jpg";
                
                $tdata = array(
                    "bqrcode" => $path
                );
                
                pdo_update("sudu8_page_staff",$tdata,array("id"=>$id));
                message('二维码生成成功!', $this->createWebUrl('Commentset', array('op'=>'staff','opt'=>'qrcode','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'], 'id'=>$_GPC['id'])), 'success');
            // }else{
                // message('二维码已存在,不用再生成!', $this->createWebUrl('Commentset', array('op'=>'staff','opt'=>'qrcode','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'], 'id'=>$_GPC['id'])), 'success');
            // }

        }













return include self::template('web/Commentset/staff');



