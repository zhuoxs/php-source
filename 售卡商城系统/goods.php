<?php
require './Mao/common.php';
$id= isset($_GET['id']) ? $_GET['id'] : 0;
$cha_1 = $DB->get_row("select * from mao_shop where M_id='{$mao['id']}' and id='{$id}' limit 1");
if($cha_1['type'] == 1){
    $bt = "中国电信";
}elseif ($cha_1['type'] == 2){
    $bt = "中国移动";
}elseif ($cha_1['type'] == 3){
    $bt = "中国联通";
}
if(!$cha_1){
    sysmsg("商品不存在！");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <title><?php echo $mao['title']?></title>
    <link rel="stylesheet" type="text/css" href="/Mao_Public/css/Mao.min.css">
    <link rel="stylesheet" type="text/css" href="/Mao_Public/css/style.css">
    <link rel="stylesheet" type="text/css" href="/Mao_Public/css/Mao.diy.css">
    <link rel="stylesheet" type="text/css" href="/Mao_Public/css/iconfont.css">
    <script src="/Mao_Public/js/jquery-2.1.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/Mao_Public/css/layer.css">
    <script src="/Mao_Public/js/layer.js"></script>
    <script src="/Mao_Public/js/Mao.js"></script>
</head>
<body>
<div class="fui-page-group">
    <div class="fui-page fui-page-current page-goods-detail">
        <div class="fui-header jb">
            <div class="fui-header-left">
                <a onclick="goBack()" class="back" style="color: #f7f7f7;"></a>
            </div>
            <div class="title">商品详情</div>
            <div class="fui-header-right">
                <a onclick="fz('fenxiang')" class="icon btn-like icon-like" style="color: #f7f7f7;"></a>
            </div>
        </div>
        <div class="fui-content basic-block pulldown ">
            <div class="fui-swipe goods-swipe">
                <div class="fui-swipe-wrapper">
                    <div class="fui-swipe-item"><img src="<?php echo $cha_1['img']?>"></div>
                </div>
                <?php
                if($cha_1['kucun'] <= 0 || $cha_1['zt'] != 0){
                    echo '<div class="salez"><img src="/Mao_Public/img/kcbz.png"></div>';
                }
                ?>
            </div>
            <div class="fui-cell-group fui-detail-group" style="margin-top: 0px; margin-bottom: 0px; background: #ffffff;">
                <div class="fui-cell">
                    <div class="fui-cell-text name" style="color: #333333;font-size: 0.9rem;">【<?php echo $bt?>】<?php echo $cha_1['name']?></div>
                </div>
                <div class="fui-cell goods-subtitle">
                    <span class="text-danger" style="color: #ef4f4f;">
                        <?php
                        if($cha_1['youhui_zhang'] > 0){
                            echo '单次购买满'.$cha_1['youhui_zhang'].'件,每件'.$cha_1['youhui_price'].'元';
                        }
                        ?>
                    </span>
                </div>
                <div class="fui-cell">
                    <div class="fui-cell-text price">
                        <span class="text-danger" style="vertical-align: middle; color: #ef4f4f; ">
                            ￥<?php echo $cha_1['price']?>
                            <span class="original">￥0.00</span>
                        </span>
                    </div>
                </div>
                <div class="fui-cell">
                    <div class="fui-cell-text flex">
                        <span style="color: #585757;font-size: 12px;margin-top: 5px;">库存:  <?php echo $cha_1['kucun']?></span>
                        <span style="color: #585757;font-size: 12px;margin-top: 5px;">销量:  <?php echo $cha_1['xiaoliang']?></span>
                    </div>
                </div>
                <div style="border-top: 5px solid #fafafa; margin-top: 5px;padding-top: 15px;" class="fui-cell">
                    <div class="fui-cell-text flex">

                        <ul style="width: 100%;">
                            <li style="float: left;width: 25%;list-style: none;">
                                <img src="/Mao_Public/img/duigou.png" width="12" height="12">&nbsp;正品保证
                            </li>
                            <li style="float: left;width: 25%;list-style: none;">
                                <img src="/Mao_Public/img/duigou.png" width="12" height="12">&nbsp;官方货源
                            </li>
                            <li style="float: left;width: 25%;list-style: none;">
                                <img src="/Mao_Public/img/duigou.png" width="12" height="12">&nbsp;信誉保证
                            </li>
                            <li style="float: right;width: 25%;list-style: none;">
                                <img src="/Mao_Public/img/duigou.png" width="12" height="12">&nbsp;全网最低价
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="fui-cell-group">
                <div class="fui-cell">
                    <div class="fui-cell-info" style="border-left: 5px solid #00beda;padding-left: 5px;">商品详情</div>
                </div>
                <hr>
                <div class="content-block content-images" style="margin: 0.4rem 0.4rem;">
                    <?php
                    if($cha_1['xq']  == "" || $cha_1['xq'] == null){
                        echo '<p>该商品未设置详情内容~</p>';
                    }else{
                        echo $cha_1['xq'];
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="fui-navbar bottom-buttons" style="background: #ffffff;">
        <a class="nav-item favorite-item " href="/index.php">
            <span class="icon icon-home"></span>
            <span class="label" style="color: #999999">首页</span>
        </a>
        <a class="nav-item external" href="/list.php">
            <span class="icon icon-shop" style="color: #999999"></span>
            <span class="label" style="color: #999999">分类</span>
        </a>
        <a class="nav-item external" href="/user/index.php">
            <span class="icon icon-cart" style="color: #999999"></span>
            <span class="label" style="color: #999999">订单</span>
        </a>
        <?php
        if($cha_1['kucun'] <= 0){
            echo '<a class="nav-item btn buybtn" style="background: #D1D1D1;">库存不足</a>';
        }elseif($cha_1['zt'] != 0){
            echo '<a class="nav-item btn buybtn" style="background: #D1D1D1;">已下架</a>';
        }else{
            echo '<a class="nav-item btn buybtn jb" data-type="2" onclick="aClick()">立刻购买</a>';
        }
        ?>
    </div>
    <div style="display: none;" id="ceshi">
        <div class="fui-modal picker-modal in">
            <div class="option-picker ">
                <div class="option-picker-inner">
                    <div class="option-picker-cell goodinfo">
                        <div class="closebtn2" onclick="closebtn();"><i class="icon icon-guanbi1"></i></div>
                        <div class="img" style="z-index: 9999;"><img class="thumb" src="<?php echo $cha_1['img']?>"></div>
                        <div class="info info-name">
                            【<?php echo $bt?>】<?php echo $cha_1['name']?>
                        </div>
                        <div class="info info-price text-danger">
                            <span>
                                ￥<span class="price"><?php echo $cha_1['price']?></span>
                            </span>
                        </div>
                    </div>
                    <div class="option-picker-options">
                        <div class="fui-cell-group diyform-container">
                            <div class="fui-cell must" data-must="1" data-type="0" data-name="" data-name2="" data-isdefault="0" data-itemid="field_data0" data-key="">
                                <div class="fui-cell-label" style="padding-right: 15px;">
                                    联系手机
                                </div>
                                <div class="fui-cell-info">
                                    <input type="text" class="fui-input" id="lianxi2" name="lianxi2" placeholder="(收件人手机号)查询订单需要,请勿胡乱填写">
                                </div>
                            </div>
                        </div>
                        <?php
                        if($cha_1['slxd_zt'] == 0){
                            ?>
                            <div class="fui-cell-group" style="margin-top:0">
                                <div class="fui-cell">
                                    <div class="fui-cell-label">数量</div>
                                    <div class="fui-cell-info"></div>
                                    <div class="fui-cell-mask noremark">
                                        <div class="fui-number" style="width: 7rem;">
                                            <div class="minus" id="minus" onclick="minus();">-</div>
                                            <input class="num2" type="tel" name="buynum" value="1" id="num" onkeyup="if(isNaN(value))execCommand(&#39;undo&#39;)">
                                            <div class="plus" id="add" onclick="add();">+</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }else{
                            ?>
                            <div class="fui-cell-group" style="margin-top:0">
                                <div class="fui-cell">
                                    <div class="fui-cell-label">数量</div>
                                    <div class="fui-cell-info"></div>
                                    <div class="fui-cell-mask noremark">
                                        <div class="fui-number" style="width: 7rem;">
                                            <div class="minus disabled">-</div>
                                            <input class="num2" type="tel" name="buynum" value="1" id="num" onkeyup="if(isNaN(value))execCommand(&#39;undo&#39;)" disabled="disabled">
                                            <div class="plus disabled">+</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="fui-navbar  " style="display: block;">
                        <a href="javascript:;" class="nav-item btn jb" style="" onclick="create();">确定</a>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            function create(){
                var loading = layer.open({
                    type: 2
                    ,content: '加载中'
                    ,shade: 'background-color: rgba(0,0,0,.2)'
                    ,shadeClose:false
                });
                $.ajax({
                    url: '../api/api.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        mod: "create",
                        id: "<?php echo $cha_1['id']?>",
                        num: $('.num').val(),
                        shouji: $("#lianxi").val()
                    },
                    success: function (a) {
                        layer.close(loading);
                        if (a.code == 0) {
                            window.location.href="/repair.php";
                        } else {
                            layer.open({
                                content: a.msg
                                ,skin: 'msg'
                                ,time: 2
                            });
                        }
                    },
                    error: function() {
                        layer.close(loading);
                        layer.open({
                            content: '~连接服务器失败！'
                            ,skin: 'msg'
                            ,time: 2
                        });
                    }
                });
            }
        </script>
    </div>
</div>
<span id='fenxiang' style="display:none">【<?php echo $bt?>】<?php echo $cha_1['name']?>  http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?></span>
<?php
if($mao['ym_id'] != "" || $mao['ym_id'] != null){
    ?>
    <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? "https://" : "http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_<?php echo $mao['ym_id']?>'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s23.cnzz.com/z_stat.php%3Fid%3D<?php echo $mao['ym_id']?>' type='text/javascript'%3E%3C/script%3E"));</script>
    <?php
}
?>
<script type="text/javascript">
    function aClick() {
        var html = $('#ceshi').html();
        html=html.replace(/lianxi2/g, "lianxi");
        html=html.replace(/num2/g, "num");
        html=html.replace(/closebtn2/g, "closebtn");
        layer.open({
            type: 1,
            content: html,
            anim: 'up',
            style: 'position:fixed; bottom:0; left:0; width: 100%; height: 200px; padding:10px 0; border:none;'
        });
    }
    function closebtn(){
        layer.closeAll();
    }
    function add(){
        $('.num').val(parseInt($('.num').val())+1);
    }
    function minus() {
        if ($('.num').val() > 1) {
            $('.num').val(parseInt($('.num').val()) - 1);
        }
    }
</script>
</body>
</html>
