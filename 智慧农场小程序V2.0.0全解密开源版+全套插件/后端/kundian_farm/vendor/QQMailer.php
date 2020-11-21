<?php
require_once IA_ROOT.'/framework/library/phpmailer/class.phpmailer.php';
require_once IA_ROOT.'/framework/library/phpmailer/class.smtp.php';
require_once ROOT_PATH.'/model/common.php';
class QQMailer
{
    public static $HOST = 'smtp.qq.com'; // QQ 邮箱的服务器地址
    public static $PORT = 465; // smtp 服务器的远程服务器端口号
    public static $SMTP = 'ssl'; // 使用 ssl 加密方式登录
    public static $CHARSET = 'UTF-8'; // 设置发送的邮件的编码

    private static $USERNAME = ''; // 授权登录的账号
    private static $PASSWORD = ''; // 授权登录的密码
    private static $NICKNAME = ''; // 发件人的昵称
    protected $mailSet=[];        //配置信息

    /**
     * QQMailer constructor.
     * @param bool $debug [调试模式]
     */
    public function __construct($debug = false,$uniacid)
    {
        $commonModel=new Common_KundianFarmModel('cqkundian_farm_set');
        $filed=['is_open_QQMail_notice','sender_mailbox','qq_auth_code','sender_platform_name','addressee_mailbox'];
        $mailSet=$commonModel->getSetData($filed,$uniacid);
        self::$NICKNAME=$mailSet['sender_platform_name'];
        self::$USERNAME=$mailSet['sender_mailbox'];
        self::$PASSWORD=$mailSet['qq_auth_code'];
        $this->mailSet=$mailSet;
        $this->mailer=new PHPMailer();
        $this->mailer->SMTPDebug = $debug ? 1 : 0;
        $this->mailer->isSMTP(); // 使用 SMTP 方式发送邮件
    }

    /**
     * @return PHPMailer
     */
    public function getMailer()
    {
        return $this->mailer;
    }

    private function loadConfig()
    {
        /* Server Settings  */
        $this->mailer->SMTPAuth = true; // 开启 SMTP 认证
        $this->mailer->Host = self::$HOST; // SMTP 服务器地址
        $this->mailer->Port = self::$PORT; // 远程服务器端口号
        $this->mailer->SMTPSecure = self::$SMTP; // 登录认证方式
        /* Account Settings */
        $this->mailer->Username = self::$USERNAME; // SMTP 登录账号
        $this->mailer->Password = self::$PASSWORD; // SMTP 登录密码
        $this->mailer->From = self::$USERNAME; // 发件人邮箱地址
        $this->mailer->FromName = self::$NICKNAME; // 发件人昵称（任意内容）
        /* Content Setting  */
        $this->mailer->isHTML(true); // 邮件正文是否为 HTML
        $this->mailer->CharSet = self::$CHARSET; // 发送的邮件的编码
    }

    /**
     * Add attachment
     * @param $path [附件路径]
     */
    public function addFile($path)
    {
        $this->mailer->addAttachment($path);
    }


    /**
     * Send Email
     * @param $email [收件人]
     * @param $title [主题]
     * @param $content [正文]
     * @return bool [发送状态]
     */
    public function send($email, $title, $content)
    {
        $this->loadConfig();
        if(is_array($email)){
            for ($i=0;$i<count($email);$i++) {
                $this->mailer->addAddress($email[$i]); // 收件人邮箱
            }
        }else{
            $this->mailer->addAddress($email); // 收件人邮箱
        }

        $this->mailer->Subject = $title; // 邮件主题
        $this->mailer->Body = $content; // 邮件信息
        return (bool)$this->mailer->send(); // 发送邮件
    }

    /**
     * 发送邮件
     * @param $orderData        订单信息
     * @param $order_type       订单类型 1新订单通知 2 取消订单通知
     * @return bool
     */
    public function sendMail($orderData,$order_type){
        $mailSet=$this->mailSet;
        error_reporting(0);
        // 邮件标题
        if($order_type==1){
            $title = '您有新的订单，请及时处理';
        }else if($order_type==2){
            $title = '订单取消通知';
        }else{
            $title='您有新的任务待处理';
        }
        $content="<p align='center'>订单编号：".$orderData['order_number']."<br/>订单金额：".$orderData['total_price']."元<br/>说明：".$orderData['body']."<br/>请尽快处理!进去小程序查看详情<br/></p>";
        // 发送QQ邮件
        $addressee=explode(',',$mailSet['addressee_mailbox']);
        $res=$this->send($addressee, $title, $content);
        return $res;
    }
}