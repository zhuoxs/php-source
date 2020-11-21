<?php
error_reporting(0);
require '../Mao/common.php';
header('Content-Type: text/html;charset=utf-8');
if( $_SERVER['HTTP_REFERER'] == "" ){
    sysmsg("非法请求,已记录IP地址！");
}
$mod = isset($_GET['mod']) ? $_GET['mod'] :0;
if($mod){
    if($mod == "list"){
        $lx = isset($_GET['lx']) ? $_GET['lx'] :0;
        $type = isset($_GET['type']) ? $_GET['type'] :0;
        $search = isset($_GET['search']) ? $_GET['search'] :0;

        if($lx == 1){
            if($type == 0 || $type == "" || $type == null){
                $sql = "M_id='{$mao['id']}' and zt='0'";
            }elseif($type == 1){
                $sql = "M_id='{$mao['id']}' and (type='1' && zt='0')";//电信
            }elseif($type == 2){
                $sql = "M_id='{$mao['id']}' and (type='2' && zt='0')";//移动
            }elseif($type == 3){
                $sql = "M_id='{$mao['id']}' and (type='3' && zt='0')";//联通
            }elseif($type == 4){
                $sql = "M_id='{$mao['id']}' and (tj='0' && zt='0')";//推荐
            }
        }elseif($lx == 2){
            $sql = "M_id='{$mao['id']}' and name LIKE '%{$search}%'";
        }



        //$sql = "M_id='{$mao['id']}' and name LIKE '%{$search}%'";
        //echo $sql;
        $numrows = $DB->count("SELECT count(*) from mao_shop WHERE {$sql} ");
        if($numrows <= 0){
            exit('<div class="content-empty"><img src="/Mao_Public/img/nolist.png" style="width: 6rem;margin-bottom: .5rem;"><br><p style="color: #999;font-size: .75rem">没有查询到商品！</p><br><a href="/index.php" class="btn btn-sm btn-danger-o external" style="border-radius: 100px;height: 1.9rem;line-height:1.9rem;width:  7rem;font-size: .75rem">去首页逛逛吧</a></div>');
        }else{
            $pagesize = 5;
            $pages = intval($numrows / $pagesize);
            if ($numrows % $pagesize) {
                $pages++;
            }
            if (isset($_GET['page'])) {
                $page = intval($_GET['page']);
            } else {
                $page = 1;
            }
            $offset = $pagesize * ($page - 1);
            $rs = $DB->query("SELECT * FROM mao_shop WHERE {$sql} order by id desc limit $offset,$pagesize");
            while ($res = $DB->fetch($rs)) {
                if($res['type'] == 1){
                    $bt = "中国电信";
                }elseif ($res['type'] == 2){
                    $bt = "中国移动";
                }elseif ($res['type'] == 3){
                    $bt = "中国联通";
                }
                ?>
                <a class="fui-goods-item" style="position: relative;width:100%" href="/goods.php?id=<?php echo $res['id']?>">
                    <div class="imagezdy <?php if($res['tj']==0){echo'triangle';}?>" data-text="推荐" data-lazyloaded="true" style="background-image: url('<?php echo $res['img']?>');"></div>
                    <div class="detail">
                        <div class="nametj" style="color: #262626;">
                            【<?php echo $bt?>】 <?php echo $res['name']?>
                        </div>
                        <div class="price">
                            <span class="text" style="color: #ed2822;">
                                <p class="minprice">¥ <?php echo $res['price']?></p>
                            </span>
                            <?php
                            if($res['yf_price'] == "0.00"){
                                echo '<span class="buy buybtn-3" style="background-color: #01a1ff;margin-right: 5px;">邮</span>';
                            }
                            ?>
                            <span class="buy buybtn-3" style="background-color: #fe5455;"><i class="icon icon-cartfill"></i></span>
                        </div>
                    </div>
                </a>
                <?php
            }
            $first=1;
            $prev=$page-1;
            $next=$page+1;
            $last=$pages;
            if($numrows > 5){
                if($page<$pages){
                    ?>
                    <script>
                        $('#page').html('<div class="content-fy"><a onclick="page(\'<?php echo $lx?>\',\'<?php echo $type?>\',\'<?php echo $next.$link?>\',\'<?php echo $search?>\')" class="btn btn-sm btn-danger-o external" style="border-radius: 100px;height: 1rem;line-height:1rem;font-size: .75rem">加载更多</a></div>');
                    </script>
                    <?php
                }else{
                    ?>
                    <script>
                        $('#page').html('<div class="content-fy"><a onclick="layer.msg(\'没有更多了\');" class="btn btn-sm btn-danger-o external" style="border-radius: 100px;height: 1rem;line-height:1rem;font-size: .75rem">加载更多</a></div>');
                    </script>
                    <?php
                }
            }else{
                ?>
                <script>
                    $('#page').html('');
                </script>
                <?php
            }
            ?>
            <script>
                $('#ts').text('共：<?php echo $numrows?>件商品');
            </script>
            <?php
        }
    }
    elseif($mod == "dd_list"){
        $lx = isset($_GET['lx']) ? $_GET['lx'] :1;
        $type = isset($_GET['type']) ? $_GET['type'] :1;
        $search = isset($_GET['search']) ? $_GET['search'] :0;

        if($lx == 1){
            if($type == 1 || $type == "" || $type == null){
                $sql = "M_id='{$mao['id']}' and (sjh='{$_SESSION['user']}' && zt!='1')";//全部订单
            }elseif($type == 2){
                $sql = "M_id='{$mao['id']}' and (sjh='{$_SESSION['user']}' && zt='0')";//已支付等待处理
            }elseif($type == 3){
                $sql = "M_id='{$mao['id']}' and (sjh='{$_SESSION['user']}' && zt='2')";//处理完成
            }elseif($type == 4){
                $sql = "M_id='{$mao['id']}' and (sjh='{$_SESSION['user']}' && zt='3')";//处理失败
            }
        }elseif($lx == 2){
            $sql = "M_id='{$mao['id']}' and (sjh='{$_SESSION['user']}' && ddh='{$search}' && zt!='1')";
        }
        $numrows = $DB->count("SELECT count(*) from mao_dindan WHERE {$sql} ");
        if($numrows <= 0){
            exit('<div class="content-empty"><img src="/Mao_Public/img/nolist.png" style="width: 6rem;margin-bottom: .5rem;"><br><p style="color: #999;font-size: .75rem">您还未购买过商品！</p><br><a href="/index.php" class="btn btn-sm btn-danger-o external" style="border-radius: 100px;height: 1.9rem;line-height:1.9rem;width:  7rem;font-size: .75rem">去首页逛逛吧</a></div>');
        }else{
            $pagesize = 5;
            $pages = intval($numrows / $pagesize);
            if ($numrows % $pagesize) {
                $pages++;
            }
            if (isset($_GET['page'])) {
                $page = intval($_GET['page']);
            } else {
                $page = 1;
            }
            $offset = $pagesize * ($page - 1);
            $rs = $DB->query("SELECT * FROM mao_dindan WHERE {$sql} order by id desc limit $offset,$pagesize");
            while ($res = $DB->fetch($rs)) {
                $cha_1 = $DB->get_row("select * from mao_shop where M_id='{$mao['id']}' and id='{$res['M_sp']}' limit 1");
                if($res['zt'] == 0){
                    $zt = '<span class="status" style="color: #ff5555;">未发货</span>';
                }elseif($res['zt'] == 1){
                    $zt = '<span class="status" style="color: #ff5555;">未付款</span>';
                }elseif($res['zt'] == 2){
                    $zt = '<span class="status" style="color: #5fb878;">已发货</span>';
                }elseif($res['zt'] == 3){
                    $zt = '<span class="status" style="color: #ff5555;">异常</span>';
                }else{
                    $zt = '<span class="status" style="color: #ff5555;">未知状态</span>';
                }
                ?>
                <div class="fui-content-inner">
                    <div class="container">
                        <div>
                            <div class="fui-list-group order-item">
                                <a data-nocache="true">
                                    <div class="fui-list-group-title lineblock2 ">
                                        订单号: <?php echo $res['ddh']?>
                                        <?php echo $zt?>
                                    </div>
                                    <div class="fui-list goods-list">
                                        <div class="fui-list-media" style="">
                                            <img src="<?php echo $cha_1['img']?>">
                                        </div>
                                        <div class="fui-list-inner">
                                            <div class="text goodstitle towline">
                                                <?php echo $res['name']?>
                                            </div>
                                            <div class="subtitle" style="color:#999;">
                                                <?php echo $res['time']?>
                                            </div>
                                        </div>
                                        <div class="fui-list-angle">
                                            <span style="color: #999">x <?php echo $res['sl']?></span></span>
                                        </div>
                                    </div>
                                    <div class="fui-list-group-title1">
                                        <span class="status noremark">
                                            实付:  &nbsp;&nbsp;&nbsp;<span class="text-danger" style="font-size: 1.2rem;">¥  <?php echo $res['price']?></span>
                                        </span>
                                    </div>
                                </a>
                                <div class="fui-list-group-title lineblock opblock">
                                    <?php
                                    if($res['zt'] == 2){
                                        ?>
                                        <span class="status noremark"><a href="/user/add_gd.php?ddh=<?php echo $res['ddh']?>" class="btn btn-sm btn-danger-o externald">提交工单</a></span>
                                        <span class="status noremark"><a href="/user/imgorderhistory.php?ddh=<?php echo $res['ddh']?>" class="btn btn-sm btn-danger-o externald">查看物流</a></span>
                                        <?php
                                    }elseif($res['zt'] == 3){
                                        ?>
                                        <span class="status noremark"><a href="/user/add_gd.php?ddh=<?php echo $res['ddh']?>" class="btn btn-sm btn-danger-o externald">提交工单</a></span>
                                        <span class="status noremark"><a onclick="xq('<?php echo $res['id']?>')" class="btn btn-sm btn-danger-o externald">查看详情</a></span>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            $first=1;
            $prev=$page-1;
            $next=$page+1;
            $last=$pages;
            if($numrows > 5){
                if($page<$pages){
                    ?>
                    <script>
                        $('#page').html('<div class="content-fy"><a onclick="page(\'<?php echo $lx?>\',\'<?php echo $type?>\',\'<?php echo $next.$link?>\',\'<?php echo $search?>\')" class="btn btn-sm btn-danger-o external" style="border-radius: 100px;height: 1rem;line-height:1rem;font-size: .75rem">加载更多</a></div>');
                    </script>
                    <?php
                }else{
                    ?>
                    <script>
                        $('#page').html('<div class="content-fy"><a onclick="layer.msg(\'没有更多了\');" class="btn btn-sm btn-danger-o external" style="border-radius: 100px;height: 1rem;line-height:1rem;font-size: .75rem">加载更多</a></div>');
                    </script>
                    <?php
                }
            }else{
                ?>
                <script>
                    $('#page').html('');
                </script>
                <?php
            }
        }
        ?>
        <script>
            function xq(id) {
                var loading = layer.load();
                $.ajax({
                    url: '../api/api.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        mod: "xq",
                        id: id
                    },
                    success: function (a) {
                        layer.close(loading);
                        if (a.code == 0) {
                            var width = screen.width >= 650 ? "650px" : "92%";
                            layer.open({
                                title: '异常详情',
                                type: 1,
                                offset: 't',
                                area: [width, '500px'],
                                fixed: false,
                                maxmin: true,
                                content: '<div class="content-block content-images" style="margin: 0.4rem 0.4rem;">'+a.msg+'</div>'
                            });
                        } else {
                            layer.msg(a.msg);
                        }
                    },
                    error: function() {
                        layer.close(loading);
                        layer.msg('~连接服务器失败！', {icon: 5});
                    }
                });
            }
        </script>
        <?php
    }
    elseif($mod == "gd_list"){
        $sql = "M_id='{$mao['id']}' and users='{$_SESSION['user']}'";
        $numrows = $DB->count("SELECT count(*) from mao_gd WHERE {$sql} ");
        if($numrows <= 0){
            exit('<div class="content-empty"><img src="/Mao_Public/img/nolist.png" style="width: 6rem;margin-bottom: .5rem;"><br><p style="color: #999;font-size: .75rem">您未提交过工单！</p></div>');
        }else{
            $pagesize = 8;
            $pages = intval($numrows / $pagesize);
            if ($numrows % $pagesize) {
                $pages++;
            }
            if (isset($_GET['page'])) {
                $page = intval($_GET['page']);
            } else {
                $page = 1;
            }
            $offset = $pagesize * ($page - 1);
            $rs = $DB->query("SELECT * FROM mao_gd WHERE {$sql} order by id desc limit $offset,$pagesize");
            while ($res = $DB->fetch($rs)) {
                if($res['zt'] == 0){
                    $zt = '<span style="color: #5fb878;">已处理</span>';
                }elseif($res['zt'] == 1){
                    $zt = '<span style="color: #ff5555;">未处理</span>';
                }else{
                    $zt = '<span style="color: #ff5555;">未知</span>';
                }
                if($res['type'] == 1){
                    $type = '不能上网';
                }elseif($res['zt'] == 2){
                    $type = '其他问题';
                }else{
                    $type = '其他问题';
                }
                ?>
                <a <?php if($res['zt'] == 0){echo'onclick="gd('.$res['id'].')"';}?>>
                    <div class="fui-list goods-item">
                        <div class="fui-list-inner">
                            <div class="title">
                                [<?php echo $type?>] <?php echo $res['ddh']?>
                            </div>
                            <div class="text">
                                <?php echo $res['time']?>
                            </div>
                        </div>
                        <div class="fui-list-angle">
                            <span class=" text-success"><?php echo $zt?></span>
                        </div>
                    </div>
                </a>
                <?php
            }
            $first=1;
            $prev=$page-1;
            $next=$page+1;
            $last=$pages;
            if($numrows > 8){
                if($page<$pages){
                    ?>
                    <script>
                        $('#page').html('<div class="content-fy"><a onclick="page(\'<?php echo $next.$link?>\')" class="btn btn-sm btn-danger-o external" style="border-radius: 100px;height: 1rem;line-height:1rem;font-size: .75rem">加载更多</a></div>');
                    </script>
                    <?php
                }else{
                    ?>
                    <script>
                        $('#page').html('<div class="content-fy"><a onclick="layer.msg(\'没有更多了\');" class="btn btn-sm btn-danger-o external" style="border-radius: 100px;height: 1rem;line-height:1rem;font-size: .75rem">加载更多</a></div>');
                    </script>
                    <?php
                }
            }else{
                ?>
                <script>
                    $('#page').html('');
                </script>
                <?php
            }
        }
        ?>
        <script>
            function gd(id) {
                var loading = layer.load();
                $.ajax({
                    url: '../api/api.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        mod: "gd",
                        id: id
                    },
                    success: function (a) {
                        layer.close(loading);
                        if (a.code == 0) {
                            var width = screen.width >= 650 ? "650px" : "92%";
                            layer.open({
                                title: '处理结果',
                                type: 1,
                                offset: 't',
                                area: [width, '500px'],
                                fixed: false,
                                maxmin: true,
                                content: '<div class="content-block content-images" style="margin: 0.4rem 0.4rem;">'+a.msg+'</div>'
                            });
                        } else {
                            layer.msg(a.msg);
                        }
                    },
                    error: function() {
                        layer.close(loading);
                        layer.msg('~连接服务器失败！', {icon: 5});
                    }
                });
            }
        </script>
        <?php
    }
    else{
        sysmsg("非法请求,已记录IP地址！");
    }
}else{
    sysmsg("非法请求,已记录IP地址！");
}
?>