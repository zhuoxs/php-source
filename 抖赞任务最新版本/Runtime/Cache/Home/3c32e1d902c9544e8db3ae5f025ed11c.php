<?php if (!defined('THINK_PATH')) exit(); $title = "推广赚钱";?>
<!DOCTYPE html>
<html>
<head>
    <?php
 $version = time(); ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <title><?php echo ($title); ?></title>
    <link rel="stylesheet" href="/tpl/Public/css/share.css?<?php echo ($version); ?>">
    <link rel="stylesheet" href="/tpl/Public/css/font.css?<?php echo ($version); ?>" />
    <!--JQ-->
    <script type="text/javascript" src="/tpl/Public/js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="/tpl/Public/js/jquery-form.js"></script>
    <script type="text/javascript" src="/tpl/Public/js/layer_mobile2/layer.js?<?php echo ($version); ?>"></script>
    <script type="text/javascript" src="/tpl/Public/js/swiper.3.1.7.min.js"></script>

    <script src="/tpl/Public/js/jquery.simplesidebar.js"></script>
    <script src="/tpl/Public/js/jquery.SuperSlide.2.1.1.js"></script>
    <script src="/tpl/Public/js/TouchSlide.1.0.js"></script>

    <script type="text/javascript" src="/tpl/Public/js/func.js?<?php echo ($version); ?>"></script>
    <script>
        var SITE_URL  = 'https:' == document.location.protocol ?'https://' : 'http://' + "<?php echo $_SERVER['HTTP_HOST'];?>";
    </script>
</head>
<style>
    html{
        height: 100%;
    }
    body{
        height: 100%;
    }
    button{position: absolute;width: 100px;height: 30px;background: none;border: 1px #fff solid;border-radius: 5px; left: 50%; top: 510px; margin-left: -50px;color: #fff;}
</style>
<body style="background: #20255c">
<img src="" id="qrcodeimg" class="ewmimg" width="100%" />
<?php if($member_client_info['platform'] == 'app'): ?><button onclick="save_img()" type="button">保存到相册</button><?php endif; ?>
</body>
</html>

<script>
    function create_qrcode()
    {
        var url = "<?php echo U('Qrcode/qrcode');?>";
        layer.open({
            type: 2,
            content: '正在生成二维码..'
        });
        $.post(url,{post_id:0},function(data){
            if( data.status == 1 ) {
                $('#qrcodeimg').attr('src',data.url);
            }
            layer.closeAll();
        },'json')
    }
    create_qrcode();

    function save_img(){
        var img = $('#qrcodeimg').attr('src');
        //保存图片到相册
        lbuilder.Native.saveImage(img, function(message){
            sp_alert('二维码已经保存到相册');
        }, function(err){
            sp_alert("save fail"+err);
        });
    }
</script>

<?php if($is_wechat == 1): ?><script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script>
        /*
         * 注意：
         * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
         * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
         * 3. 完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
         *
         * 如有问题请通过以下渠道反馈：
         * 邮箱地址：weixin-open@qq.com
         * 邮件主题：【微信JS-SDK反馈】具体问题
         * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
         */
        wx.config({
            appId: '<?php echo $signPackage["appId"];?>',
            timestamp: <?php echo $signPackage["timestamp"];?>,
        nonceStr: '<?php echo $signPackage["nonceStr"];?>',
                signature: '<?php echo $signPackage["signature"];?>',
                jsApiList: [
            'checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo',
            'hideMenuItems',
            'showMenuItems',
            'hideAllNonBaseMenuItem',
            'showAllNonBaseMenuItem',
            'translateVoice',
            'startRecord',
            'stopRecord',
            'onRecordEnd',
            'playVoice',
            'pauseVoice',
            'stopVoice',
            'uploadVoice',
            'downloadVoice',
            'chooseImage',
            'previewImage',
            'uploadImage',
            'downloadImage',
            'getNetworkType',
            'openLocation',
            'getLocation',
            'hideOptionMenu',
            'showOptionMenu',
            'closeWindow',
            'scanQRCode',
            'chooseWXPay',
            'openProductSpecificView',
            'addCard',
            'chooseCard',
            'openCard'
        ]
        });
        /*wx.ready(function () {
         // 在这里调用 API
         });*/
    </script>

    <!--微信分享-->
    <script>
        wx.ready(function () {
            var shareData = {
                title: '<?php echo ($share_title); ?>',
                desc: '<?php echo ($share_desc); ?>',
                link: '<?php echo ($share_link); ?>',
                imgUrl: '<?php echo ($share_logo); ?>',
                trigger: function (res) {

                },
                success: function (res) {
                    //sp_alert('已分享')
                },
                cancel: function (res) {
                    //alert('已取消分享');
                },
                fail: function (res) {
                    alert(JSON.stringify(res));
                }
            };
            wx.onMenuShareTimeline(shareData); //分享到朋友圈
            wx.onMenuShareAppMessage(shareData); //分享给朋友
            wx.onMenuShareQQ(shareData); //分享到QQ
            wx.onMenuShareWeibo(shareData); //分享到微博
        });
        wx.error(function (res) {
            alert(res.errMsg);
            console.log(res.errMsg);
        });
    </script>
    <!--END 微信分享--><?php endif; ?>