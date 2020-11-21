<?php  
//header('Access-Control-Allow-Origin: *');
    header('Content-Type: text/html; charset=utf8');

    //连接数据库
    $link = mysql_connect("localhost","root","33hao@!123");
    mysql_query("set names 'utf8'");
    if(!$link){
        echo json_encode(array('code'=>0,'msg'=>'数据库连接失败')) ;
        exit(-1);
    }else{
        //echo json_encode(array('code'=>1,'msg'=>'数据库连接成功')) ;
    }
    //选择一个数据库作为默认数据库
    mysql_select_db('xiaochengxu');
    $sql = "select * from ims_hyb_yl_email";
    $result=mysql_query($sql,$link);
    $rs=mysql_fetch_array($result);
    var_dump($rs);

// require '../functions.php';
	$smtpemailto = $_POST['email'];//发送给谁
	$mailtitle = '预约提醒通知';//$_POST['title'];//邮件主题
	$mailcontent = "您的验证码是: <span color='red'></span>。请输入后再修改密码。";//

	//引入PHPMailer的核心文件 使用require_once包含避免出现PHPMailer类重复定义的警告
    require_once ("api/phpmailer/class.phpmailer.php"); 
    require_once ("api/phpmailer/class.smtp.php");
    //实例化PHPMailer核心类
    $mail = new PHPMailer();

    //是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
    //$mail->SMTPDebug = 2;

    //使用smtp鉴权方式发送邮件
    $mail->isSMTP();

    //smtp需要鉴权 这个必须是true
    $mail->SMTPAuth=true;

    //链接qq域名邮箱的服务器地址
    $mail->Host = "{$rs['mailhost']}";

    //设置使用ssl加密方式登录鉴权
    $mail->SMTPSecure = 'ssl';

    //设置ssl连接smtp服务器的远程服务器端口号，以前的默认是25，但是现在新的好像已经不可用了 可选465或587
    $mail->Port = 465;

    //设置smtp的helo消息头 这个可有可无 内容任意
    // $mail->Helo = 'Hello smtp.qq.com Server';

    //设置发件人的主机域 可有可无 默认为localhost 内容任意，建议使用你的域名
    $mail->Hostname = 'http://www.szdqc.cn';

    //设置发送的邮件的编码 可选GB2312 我喜欢utf-8 据说utf8在某些客户端收信下会乱码
    $mail->CharSet = 'UTF-8';

    //设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
    $mail->FromName = '中科养生';

    //smtp登录的账号 这里填入字符串格式的qq号即可
    $mail->Username = '2065168587@qq.com';

    //smtp登录的密码 使用生成的授权码（就刚才叫你保存的最新的授权码）
    $mail->Password = $redis->get('email:send_email_password');
    //SMTP服务器的验证密码 'jvpfoeokxomufgji';//'drtzejqwbdomegbc';//jvpfoeokxomufgji

    //设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
    $mail->From = $redis->get('email:send_email');//SMTP服务器的用户邮箱

    //邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
    $mail->isHTML(true); 

    //设置收件人邮箱地址 该方法有两个参数 第一个参数为收件人邮箱地址 第二参数为给该地址设置的昵称 不同的邮箱系统会自动进行处理变动 这里第二个参数的意义不大
    $mail->addAddress($smtpemailto,'中科修改密码通知');

    //添加多个收件人 则多次调用方法即可
    // $mail->addAddress('xxx@163.com','lsgo在线通知');

    //添加该邮件的主题
    $mail->Subject = $mailtitle;

    //添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
    $mail->Body = $mailcontent;

    //为该邮件添加附件 该方法也有两个参数 第一个参数为附件存放的目录（相对目录、或绝对目录均可） 第二参数为在邮件附件中该附件的名称
    // $mail->addAttachment('./d.jpg','mm.jpg');
    //同样该方法可以多次调用 上传多个附件
    // $mail->addAttachment('./Jlib-1.1.0.js','Jlib.js');

    $flag = $mail->send();
	if($flag){
		$post->error = 0;
		$post->msg = "邮件发送成功！";
		echo json_encode($post);
	}else{
	    $post->error = 1;
		$post->msg = "邮件发送失败！请检查邮箱填写是否有误。";
		echo json_encode($post);
	}
?>