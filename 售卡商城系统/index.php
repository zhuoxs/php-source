<?php
require './Mao/common.php';
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
    <script src="/Mao_Public/layer/layer.js"></script>
    <script src="/Mao_Public/js/Mao.js"></script>
</head>
<body>
<div class="fui-page-group">
    <div class="fui-page  fui-page-current " style="top: 0; background-color: #fafafa;">
        <div class="fui-header jb">
            <div class="fui-header-left"></div>
            <div class="title"><?php echo $mao['title']?></div>
            <div class="fui-header-right"></div>
        </div>
        <div class="fui-content navbar" style="background-color: #f3f3f3; padding-bottom: 0;">
            <div class="fui-notice" style="background: #ffffff; border-color: ; margin-bottom: 0px;" data-speed="4">
                <div class="icon">
                    <i class="icon icon-notification1" style="font-size: 0.7rem; color: #fd5454;"></i>
                </div>
                <div class="text" style="color: #666666;">
                    <ul>
                        <li>
                            <a href="javascript:;" style="color: #666666;" data-nocache="true">
                                <marquee behavior="scroll" scrolldelay="100" scrollamount="5">
                                    <?php echo $mao['gd_gg']?>
                                </marquee>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="fui-cell-group">
                <div class="fui-cell">
                    <div class="fui-cell-info" style="border-left: 5px solid #00beda;padding-left: 5px;">商品分类</div>
                </div>
                <hr>
                <div class="fui-icon-group noborder col-4 circle" style="background: #ffffff">
                    <a class="fui-icon-col external" href="list.php?mod=1">
                        <div class="icon"><img style="border-radius: 0" src="/Mao_Public/img/dx.png"></div>
                        <div class="text" style="color: #666666;">中国电信</div>
                    </a>
                    <a class="fui-icon-col external" href="list.php?mod=2">
                        <div class="icon"><img style="border-radius: 0" src="/Mao_Public/img/yd.png"></div>
                        <div class="text" style="color: #666666;">中国移动</div>
                    </a>
                    <a class="fui-icon-col external" href="list.php?mod=3">
                        <div class="icon"><img style="border-radius: 0" src="/Mao_Public/img/lt.png"></div>
                        <div class="text" style="color: #666666;">中国联通</div>
                    </a>
                    <a class="fui-icon-col external" href="list.php?mod=4">
                        <div class="icon"><img style="border-radius: 0" src="/Mao_Public/img/tj.png"></div>
                        <div class="text" style="color: #666666;">站长推荐</div>
                    </a>
                </div>
            </div>
            <?php
            $tj_Number = $DB->count("SELECT count(*) from mao_shop WHERE M_id='{$mao['id']}' and tj='0'");
            if($tj_Number > 0){
                ?>
                <div class="fui-cell-group">
                    <div class="fui-cell">
                        <div class="fui-cell-info" style="border-left: 5px solid #00beda;padding-left: 5px;">
                            站长推荐 <i class="icon icon-hot" style="color: #fd5454;"></i>
                            <a style="float:right" href="list.php?mod=4">更多</a>
                        </div>
                    </div>
                    <hr>
                    <div class="fui-goods-group block three" style="background: ;">
                        <?php
                        $rs = $DB->query("SELECT * FROM mao_shop WHERE M_id='{$mao['id']}' and (tj='0' && zt='0') order by id desc limit 2");
                        while($rows = $DB->fetch($rs)){
                            if($rows['type'] == 1){
                                $type = "中国电信";
                            }elseif ($rows['type'] == 2){
                                $type = "中国移动";
                            }elseif ($rows['type'] == 3){
                                $type = "中国联通";
                            }
                            ?>
                            <a class="fui-goods-item" style="position: relative;width:100%" href="/goods.php?id=<?php echo $rows['id']?>">
                                <div class="imagezdy triangle" data-text="推荐" data-lazyloaded="true" style="background-image: url('<?php echo $rows['img']?>');"></div>
                                <div class="detail">
                                    <div class="nametj" style="color: #262626;">
                                        【<?php echo $type?>】 <?php echo $rows['name']?>
                                    </div>
                                    <div class="price">
                                        <span class="text" style="color: #ed2822;">
                                            <p class="minprice">¥ <?php echo $rows['price']?></p>
                                        </span>
                                        <?php
                                        if($rows['yf_price'] == "0.00"){
                                            echo '<span class="buy buybtn-3" style="background-color: #01a1ff;margin-right: 5px;">邮</span>';
                                        }
                                        ?>
                                        <span class="buy buybtn-3" style="background-color: #fe5455;"><i class="icon icon-cartfill"></i></span>
                                    </div>
                                </div>
                            </a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
            ?>
            <div class="fui-cell-group">
                <div class="fui-cell">
                    <div class="fui-cell-info" style="border-left: 5px solid #00beda;padding-left: 5px;">
                        最新商品
                        <a style="float:right" href="list.php">更多</a>
                    </div>
                </div>
                <hr>
                <div class="fui-goods-group block three" style="background: ;">
                    <?php
                    $rs = $DB->query("SELECT * FROM mao_shop WHERE M_id='{$mao['id']}' and zt='0' order by id desc limit 6");
                    while($rows = $DB->fetch($rs)){
                        if($rows['type'] == 1){
                            $type = "中国电信";
                        }elseif ($rows['type'] == 2){
                            $type = "中国移动";
                        }elseif ($rows['type'] == 3){
                            $type = "中国联通";
                        }
                        ?>
                        <a class="fui-goods-item" style="position: relative;" href="/goods.php?id=<?php echo $rows['id']?>">
                            <div class="image <?php if($rows['tj']==0){echo'triangle';}?>" data-text="推荐" style="background-image: url('<?php echo $rows['img']?>');"></div>
                            <div class="detail">
                                <div class="name" style="color: #262626;">
                                    【<?php echo $type?>】 <?php echo $rows['name']?>
                                </div>
                                <div class="price">
									<span class="text" style="color: #ed2822;">
	                                    <p class="minprice">¥ <?php echo $rows['price']?></p>
	                                </span>
                                    <?php
                                    if($rows['yf_price'] == "0.00"){
                                        echo '<span class="buy buybtn-3" style="background-color: #01a1ff;margin-right: 5px;">邮</span>';
                                    }
                                    ?>
                                    <span class="buy buybtn-3" style="background-color: #fe5455;"><i class="icon icon-cartfill"></i></span>
                                </div>
                            </div>
                        </a>
                        <?php
                    }
                    ?>
                </div>
            </div>


        </div>
    </div>
    <div class="fui-navbar">
        <a href="index.php" class="external nav-item active">
            <span class="icon icon-home"></span>
            <span class="label">首页</span>
        </a>
        <a href="list.php" class="external nav-item ">
            <span class="icon icon-list"></span>
            <span class="label">全部商品</span>
        </a>
        <a onclick="kefu()" class="external nav-item ">
            <span class="icon icon-person2"></span>
            <span class="label">联系客服</span>
        </a>
        <a href="/user/index.php" class="external nav-item ">
            <span class="icon icon-daifukuan1"></span>
            <span class="label">订单查询</span>
        </a>
    </div>
</div>
<?php
if($mao['ym_id'] != "" || $mao['ym_id'] != null){
    ?>
    <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? "https://" : "http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_<?php echo $mao['ym_id']?>'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s23.cnzz.com/z_stat.php%3Fid%3D<?php echo $mao['ym_id']?>' type='text/javascript'%3E%3C/script%3E"));</script>
    <?php
}
?>
</body>
</html>