<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:89:"/www/wwwroot/app.jishuizhibei.com/addons/yztc_sun/application/admin/view/cstore/edit.html";i:1555123169;s:89:"/www/wwwroot/app.jishuizhibei.com/addons/yztc_sun/application/admin/view/common/edit.html";i:1553823405;s:104:"/www/wwwroot/app.jishuizhibei.com/addons/yztc_sun/application/admin/view/common/locationchoosestore.html";i:1553823400;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>layui</title>
    <link rel="stylesheet" href="/addons/yztc_sun/public/static/bower_components/layui/src/css/layui.css">
    <script src="/addons/yztc_sun/public/static/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/addons/yztc_sun/public/static/bower_components/layui/src/layui.js"></script>

    <link href="/addons/yztc_sun/public/static/bower_components/select2/dist/css/select2.css" rel="stylesheet" />
    <script src="/addons/yztc_sun/public/static/custom/pinyin.js"></script>

    <link href="/web/resource//css/bootstrap.min.css" rel="stylesheet">
    <!--<link href="/web/resource//css/font-awesome.min.css" rel="stylesheet">-->
    <link href="/web/resource//css/common.css" rel="stylesheet">
    <script>

        window.sysinfo = {
            'siteroot': '<?php echo isset($_W['siteroot'])?$_W['siteroot']:''; ?>',
            'siteurl': '<?php echo isset($_W['siteurl'])?$_W['siteurl']:''; ?>',
            'attachurl': '<?php echo isset($_W['attachurl'])?$_W['attachurl']:''; ?>',
            'attachurl_local': '<?php echo isset($_W['attachurl_local'])?$_W['attachurl_local']:''; ?>',
            'attachurl_remote': '<?php echo isset($_W['attachurl_remote'])?$_W['attachurl_remote']:''; ?>',
            'cookie' : {'pre': '<?php echo isset($_W['config']['cookie']['pre'])?$_W['config']['cookie']['pre']:''; ?>'},
            'account' : <?php  echo json_encode($_W['account']) ?>
        };
    </script>
    <script src="/web/resource//js/app/util.js"></script>
    <script src="/web/resource//js/app/common.min.js"></script>
    <script>var require = { urlArgs: 'v=20161011' };</script>
    <script src="/web/resource//js/require.js"></script>
    <script src="/web/resource//js/app/config.js"></script>
    <script>
        requireConfig.baseUrl = "/web/resource/js/app";
        requireConfig.paths.select2 = "/addons/yztc_sun/public/static/bower_components/select2/dist/js/select2";
        require.config(requireConfig);

        require(['select2','bootstrap'], function () {
            $.fn.select2.defaults.set("matcher",function(params, data) {
                if ($.trim(params.term) === '') {
                    return data;
                }
                if (data.keywords && data.keywords.indexOf(params.term) > -1 || data.text.indexOf(params.term) > -1) {
                    return data;
                }
                return null;
            });
        });
    </script>
    <style>
        body{
            min-width: 0px !important;
        }
        .select2{
            width: 100%;
        }
        .select2 .select2-selection{
            height: 38px;
            border-radius: 2px;
            /*border-color: rgb(230,230,230);*/
        }
        .select2 .select2-selection__rendered{
            line-height: 38px!important;
        }
        .select2 .select2-selection__arrow{
            height: 36px!important;
        }

        .layui-form-item .layui-form-label{
            width: 180px;
        }
        .layui-form-item .layui-input-block{
            margin-left: 210px;
        }
        .layui-form-item .layui-input-inline{
            margin-left: 30px;
        }
    </style>
</head>
<body>
<div class="layui-layout layui-layout-admin">
    <div style="padding: 15px;">
        <form class="layui-form" method="post" action="<?php echo adminurl('save'); ?>">
            <input type="hidden" name="id" value="<?php echo isset($info['id'])?$info['id']:''; ?>">
            

<div class="layui-form-item">
    <label class="layui-form-label">所属商圈</label>
    <div class="layui-input-block">
        <select name="district_id" id="district_id" class="select2" lay-verify="required" lay-ignore></select>
    </div>
</div>



<div class="layui-form-item">
    <label class="layui-form-label">所属分类</label>
    <div class="layui-input-block">
        <select name="cat_id" id="cat_id" class="select2" lay-verify="required" lay-ignore></select>
    </div>
</div>

<?php if(!$info['id']): ?>
<div class="layui-form-item">
    <label class="layui-form-label">所属用户</label>
    <div class="layui-input-block">
        <select name="user_id" id="user_id" class="select2" lay-verify="required" lay-ignore></select>
    </div>
</div>
<input type="hidden" name="check_status" value="2">
<?php endif; ?>


<div class="layui-form-item">
    <label class="layui-form-label">商户名称</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" name="name" lay-verify="required" placeholder="请输入门店名称" class="layui-input" value="<?php echo isset($info['name'])?$info['name']:''; ?>">
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">联系人</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" name="contact" placeholder="请输入联系人" class="layui-input" value="<?php echo isset($info['contact'])?$info['contact']:''; ?>">
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">联系电话</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" name="tel" placeholder="请输入联系电话" class="layui-input" value="<?php echo isset($info['tel'])?$info['tel']:''; ?>">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">商家手机</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" name="phone" placeholder="请输入商家手机" class="layui-input" value="<?php echo isset($info['phone'])?$info['phone']:''; ?>">
    </div>
</div>
<!--<div class="layui-form-item">-->
    <!--<label class="layui-form-label">微信号</label>-->
    <!--<div class="layui-input-block">-->
        <!--<input autocomplete="off" type="text" name="wechat_number" placeholder="请输入微信号" class="layui-input" value="<?php echo isset($info['wechat_number'])?$info['wechat_number']:''; ?>">-->
    <!--</div>-->
<!--</div>-->

<div class="layui-form-item">
    <label class="layui-form-label">平台抽成比率</label>
    <div class="layui-input-inline">
        <input autocomplete="off" type="number" name="ptcc_rate" lay-verify="required" placeholder="平台抽成比率" class="layui-input" value="<?php echo isset($info['ptcc_rate'])?$info['ptcc_rate']:''; ?>">%
    </div>
</div>
<!--
<div class="layui-form-item">
    <label class="layui-form-label">地址</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" name="address" placeholder="请输入地址" class="layui-input" value="<?php echo isset($info['address'])?$info['address']:''; ?>">
    </div>
</div>-->
<?php if($distributionset['store_setting'] == 1 and $distributionset['level'] > 0): ?>
<div class="layui-form-item">
    <label class="layui-form-label">是否开启分销</label>
    <div class="layui-input-block">
        <input type="radio" name="distribution_open" value="1" title="开启" <?php echo $info['distribution_open']==1?"checked":""; ?>>
        <input type="radio" name="distribution_open" value="0" title="关闭" <?php echo $info['distribution_open']==0?"checked":""; ?>>
    </div>
</div>

<div class="layui-form-item commissiontype">
    <label class="layui-form-label">分销佣金类型</label>
    <div class="layui-input-block">
        <input type="radio" name="commissiontype" value="1" title="百分比" <?php echo $info['commissiontype']==1||!$info['commissiontype']?"checked":""; ?>>
        <input type="radio" name="commissiontype" value="2" title="固定金额" <?php echo $info['commissiontype']==2?"checked":""; ?>>
    </div>
</div>

<div class="layui-form-item commission">
    <div class="layui-inline">
        <label class="layui-form-label">一级佣金</label>
        <div class="layui-input-block">
            <input autocomplete="off" type="text" name="first_money" placeholder="" class="layui-input" value="<?php echo isset($info['first_money'])?$info['first_money']:''; ?>">
            <label class="commissiontype_1">%</label><label class="commissiontype_2">元</label>
        </div>
    </div>
    <?php if($distributionset['level'] > 1): ?>
    <div class="layui-inline">
        <label class="layui-form-label">二级佣金</label>
        <div class="layui-input-block">
            <input autocomplete="off" type="text" name="second_money" placeholder="" class="layui-input" value="<?php echo isset($info['second_money'])?$info['second_money']:''; ?>">
            <label class="commissiontype_1">%</label><label class="commissiontype_2">元</label>
        </div>
    </div>
    <?php endif; if($distributionset['level'] > 2): ?>
    <div class="layui-inline">
        <label class="layui-form-label">三级佣金</label>
        <div class="layui-input-block">
            <input autocomplete="off" type="text" name="third_money" placeholder="" class="layui-input" value="<?php echo isset($info['third_money'])?$info['third_money']:''; ?>">
            <label class="commissiontype_1">%</label><label class="commissiontype_2">元</label>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>



<div class="layui-form-item">
    <label class="layui-form-label">logo</label>
    <div class="layui-input-block">
        <?php echo tpl_form_field_image('logo', isset($info['logo'])?$info['logo']:'','/web/resource/images/nopic.jpg'); ?>
        <div class="layui-form-mid layui-word-aux">建议尺寸：220*220</div>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">首页菜单图标</label>
    <div class="layui-input-block">
        <?php echo tpl_form_field_image('icon', isset($info['icon'])?$info['icon']:'','/web/resource/images/nopic.jpg'); ?>
        <div class="layui-form-mid layui-word-aux">建议尺寸：40*40</div>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">banner轮播图</label>
    <div class="layui-input-block">
        <?php echo tpl_form_field_multi_image('banner', isset($info['banner'])?$info['banner']:''); ?>
        <div class="layui-form-mid layui-word-aux">建议尺寸：750*400</div>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">海报图</label>
    <div class="layui-input-block">
        <?php echo tpl_form_field_image('posterpic', isset($info['posterpic'])?$info['posterpic']:'','/web/resource/images/nopic.jpg'); ?>
        <div class="layui-form-mid layui-word-aux">建议尺寸：750*1330，不上传则自动生成显示默认海报</div>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">详情二维码</label>
    <div class="layui-input-block">
        <?php echo tpl_form_field_image('detail_qrcode',$info['detail_qrcode']); ?>
        <div class="layui-form-mid layui-word-aux">建议尺寸：500*500，</div>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">营业时间</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" name="business_range" id="business_range" placeholder=" - " class="layui-input" value="<?php echo isset($info['business_range'])?$info['business_range']:''; ?>">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">星级</label>
    <div class="layui-input-block">
        <select name="star" id="star" class="select2" lay-verify="required" lay-ignore></select>
    </div>
</div>

<div class="layui-form-item ytx253">
    <label class="layui-form-label">服务设施</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" name="service"  placeholder="" class="layui-input" value="<?php echo isset($info['service'])?$info['service']:''; ?>">
        <div class="layui-form-mid layui-word-aux"> *多个服务设施用 用逗号,隔开 例 刷卡支付,停车</div>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">人均消费</label>
    <div class="layui-input-block">
        <input autocomplete="off" type="text" name="per_consumption" lay-verify="required" placeholder="请输入人均消费(单位元)" class="layui-input" value="<?php echo isset($info['per_consumption'])?$info['per_consumption']:''; ?>">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">过期时间</label>
    <div class="layui-input-block">
        <input type="text" class="layui-input" id="end_time" lay-verify="required" readonly="readonly" name="end_time" placeholder="yyyy-MM-dd HH:mm:ss" value="<?php echo $info['end_time']; ?>">
    </div>
</div>
<!--
<div class="layui-form-item">
    <label class="layui-form-label">商家介绍</label>
    <div class="layui-input-block">
        <textarea name="detail" placeholder="请输入介绍" class="layui-textarea"><?php echo isset($info['detail'])?$info['detail']:''; ?></textarea>
    </div>
</div>-->

<div class="layui-form-item">
    <label class="layui-form-label">商家推荐</label>
    <div class="layui-input-block">
        <input type="radio" name="is_recommend" value="1" title="推荐" <?php echo $info['is_recommend']==1?"checked":""; ?>>
        <input type="radio" name="is_recommend" value="0" title="取消" <?php echo $info['is_recommend']==0?"checked":""; ?>>
    </div>
</div>


<div class="layui-form-item">
    <label class="layui-form-label">品质商家</label>
    <div class="layui-input-block">
        <input type="radio" name="quality_status" value="1" title="是" <?php echo $info['quality_status']==1?"checked":""; ?>>
        <input type="radio" name="quality_status" value="0" title="否" <?php echo $info['quality_status']==0?"checked":""; ?>>
    </div>
</div>




<style type="text/css">
    .ismap .maps {
        height: 380px;
        width: 550px;
        overflow: hidden;
        border: 1px solid #E4E4E4;
    }
</style>
<div class="layui-form-item">
    <label class="layui-form-label">详细地址</label>
    <div class="layui-input-block">
        <div class="input-group">
                <span class="input-group-btn">
                    <a href="javascript:;" class="layui-btn layui-btn-sm layui-btn-normal" id="selectshop" onClick="codeAddress();">定位</a>
                </span>
            <input type="text" name="address" value="<?php echo $info['address']; ?>" placeholder="输入详细地址，如：杏林湾营运中心9号楼" autocomplete="off" id="address" class="form-control">
        </div>
        <div class="layui-form-mid layui-word-aux">输入完整地址后，点击定位获得商户的经纬度（如定位不准，可手动拖动定位）</div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <div class="layui-input-inline">
                    <input class="hrefto jing layui-input" readonly="readonly"  type="text" name="lng" value="<?php echo $info['lng']; ?>"/>
                </div>
            </div>
            <div class="layui-inline">
                <div class="layui-input-inline">
                    <input class="hrefto wei layui-input" readonly="readonly" type="text" name="lat" value="<?php echo $info['lat']; ?>"/>
                </div>
            </div>
        </div>

        <div class="ismap">
            <div class="maps" id="dituContent"></div>
        </div>
    </div>
</div>
<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&amp;libraries=place&key=<?php echo $info['map_key']; ?>"></script>
<script src="https://3gimg.qq.com/c/=/lightmap/api_v2/2/4/91/main.js,lightmap/api_v2/2/4/91/mods/place.js" type="text/javascript"></script>
<script>
    var namestr = "<?php echo $info['address']; ?>"
    var lng = "<?php echo $info['lng']; ?>";
    var lat = "<?php echo $info['lat']; ?>";
    $(function () {
        if (namestr != null && namestr != '') {
            var center = new qq.maps.LatLng(lat, lng);

            var map = new qq.maps.Map(document.getElementById('dituContent'), {
                center: center,
                zoom: 13
            });
            var marker = new qq.maps.Marker({
                position: center,
                draggable: true,
                map: map
            });

            geocoder = new qq.maps.Geocoder({
                complete: function (result) {
                    // $('input[name=address]').val(result.detail.address);
                    map.setCenter(result.detail.location);
                    marker.setPosition(result.detail.location);
                    var weizhi1 = marker.getPosition();
                    $('input.wei').val(weizhi1.lat);
                    $('input.jing').val(weizhi1.lng);
                }

            });
            var ap = new qq.maps.place.Autocomplete(document.getElementById('address'));
            //调用Poi检索类。用于进行本地检索、周边检索等服务。
            var searchService = new qq.maps.SearchService({
                map: map
            });
            //添加监听事件
            qq.maps.event.addListener(ap, "confirm", function (res) {

                geocoder.getLocation(res.value);
                //若服务请求失败，则运行以下函数
                geocoder.setError(function () {
                    alert("出错了，请输入正确的地址！！！");
                });
            });

            qq.maps.event.addListener(marker, 'dragend', function (event) {
                var latLng = event.latLng,
                    lat = latLng.getLat(),
                    lng = latLng.getLng();

                // var coord = new qq.maps.LatLng(lat,lng);
                // geocoder.getAddress(coord);
                $('input.wei').val(lat);
                $('input.jing').val(lng);
            });
        } else {
            //				console.log(5);
            //				$(".ismap").show();
            //				    var center = new qq.maps.LatLng(39.916527,116.397128);
            //				    map = new qq.maps.Map(document.getElementById('dituContent'),{
            //				        center: center,
            //				        zoom: 13
            //				    });
            //				    //获取城市列表接口设置中心点
            //				    citylocation = new qq.maps.CityService({
            //				        complete : function(result){
            //				            map.setCenter(result.detail.latLng);
            //				             if (marker != null) {
            //				                marker.setMap(null);
            //				            }
            //				            //设置marker标记
            //				            marker = new qq.maps.Marker({
            //				                map: map,
            //				                position: results.detail.latLng
            //				            });
            //				        }
            //				    });
            ////				    var marker = new qq.maps.Marker({
            ////				        position: center,
            ////				        map: map
            ////				    });
            //				    //调用searchLocalCity();方法    根据用户IP查询城市信息。
            //				    citylocation.searchLocalCity();
        }

    })
    //清除地图上的marker
    //		function clearOverlays(overlays) {
    //			var overlay;
    //			while(overlay = overlays.pop()) {
    //				overlay.setMap(null);
    //			}
    //		}
    function codeAddress() {
        var address = document.getElementById("address").value;
        var namestr = "<?php echo $info['address']; ?>"
        // alert(address);
        //通过getLocation();方法获取位置信息值
        if (namestr != null && namestr != '') {
            geocoder.getLocation(address);

        } else {
            var center = new qq.maps.LatLng(39.916527, 116.397128);
            var map = new qq.maps.Map(document.getElementById('dituContent'), {
                center: center,
                zoom: 13
            });

            function replaceLikeVal(comp) {
                if (comp.value.indexOf("'") != -1 || comp.value.indexOf("\"") != -1) {
                    //comp.value = comp.value.substring(0, comp.value.length-1);
                    comp.value = comp.value.replace(/\'/g, "").replace(/\"/g, "");
                }
            };
            var searchService, markers = [];
            //设置Poi检索服务，用于本地检索、周边检索
            searchService = new qq.maps.SearchService({
                //检索成功的回调函数
                complete: function (results) {

                    //设置回调函数参数
                    var pois = results.detail.pois;

                    if (!pois) {
                        //						alert('请输入详细的地址(xxx市xxx县xxx镇xxx)');
                        alert("请输入详细的地址");
                    }
                    var infoWin = new qq.maps.InfoWindow({
                        map: map
                    });
                    var latlngBounds = new qq.maps.LatLngBounds();
                    for (var i = 0, l = pois.length; i < l; i++) {
                        var poi = pois[i];
                        //扩展边界范围，用来包含搜索到的Poi点
                        latlngBounds.extend(poi.latLng);

                        (function (n) {
                            var marker = new qq.maps.Marker({
                                position: center,
                                draggable: true,
                                map: map
                            });

                            marker.setPosition(pois[n].latLng);

                            marker.setTitle(i + 1);
                            markers.push(marker);
                            $('.wei').val(pois[n].latLng.lat);
                            $('.jing').val(pois[n].latLng.lng);
                            qq.maps.event.addListener(marker, 'dragend', function (event) {
                                console.log(event);
                                var latLng = event.latLng,
                                    lat = latLng.getLat(),
                                    lng = latLng.getLng();

                                // var coord = new qq.maps.LatLng(lat,lng);
                                // geocoder.getAddress(coord);
                                $('.jing').val(lng);
                                $('.wei').val(lat);
                            });
                        })(i);
                    }
                    //调整地图视野
                    map.fitBounds(latlngBounds);
                },
                //若服务请求失败，则运行以下函数
                error: function () {
                    alert('请输入有效地址')
                }
            });
            $(".map").show();
            var keyword = document.getElementById("address").value;
            console.log(keyword);
            var region = '';
            var pageIndex = 0;
            var pageCapacity = 1;
            //			clearOverlays(markers);
            //根据输入的城市设置搜索范围
            searchService.setLocation(region);
            //设置搜索页码
            searchService.setPageIndex(pageIndex);
            //设置每页的结果数
            searchService.setPageCapacity(pageCapacity);
            //根据输入的关键字在搜索范围内检索
            searchService.search(keyword);
            //根据输入的关键字在圆形范围内检索
            //var region = new qq.maps.LatLng(39.916527,116.397128);
            //searchService.searchNearBy(keyword, region , 2000);
            //根据输入的关键字在矩形范围内检索
            //region = new qq.maps.LatLngBounds(new qq.maps.LatLng(39.936273,116.440043),new qq.maps.LatLng(39.896775,116.354212));
            //searchService.searchInBounds(keyword, region);

        }
    }

    //		function replaceLikeVal(comp) {
    //			if(comp.value.indexOf("'") != -1 || comp.value.indexOf("\"") != -1) {
    //				//comp.value = comp.value.substring(0, comp.value.length-1);
    //				comp.value = comp.value.replace(/\'/g, "").replace(/\"/g, "");
    //			}
    //		};
    //		var searchService, markers = [];
    //		var init = function() {
    //			var center = new qq.maps.LatLng(39.916527, 116.397128);
    //			var map = new qq.maps.Map(document.getElementById('dituContent'), {
    //				center: center,
    //				zoom: 13
    //			});
    //
    //			//设置Poi检索服务，用于本地检索、周边检索
    //			searchService = new qq.maps.SearchService({
    //				//检索成功的回调函数
    //				complete: function(results) {
    //
    //					//设置回调函数参数
    //					var pois = results.detail.pois;
    //
    //					if(!pois) {
    ////						alert('请输入详细的地址(xxx市xxx县xxx镇xxx)');
    //						layer.msg("请输入详细的地址(xxx市xxx县xxx镇xxx)", {
    //							icon: 2,
    //							time: 1000
    //						});
    //						return false;
    //					}
    //					var infoWin = new qq.maps.InfoWindow({
    //						map: map
    //					});
    //					var latlngBounds = new qq.maps.LatLngBounds();
    //					for(var i = 0, l = pois.length; i < l; i++) {
    //						var poi = pois[i];
    //						//扩展边界范围，用来包含搜索到的Poi点
    //						latlngBounds.extend(poi.latLng);
    //
    //						(function(n) {
    //							var marker = new qq.maps.Marker({
    //								position: center,
    //								draggable: true,
    //								map: map
    //							});
    //
    //							marker.setPosition(pois[n].latLng);
    //
    //							marker.setTitle(i + 1);
    //							markers.push(marker);
    //							$('.wei').val(pois[n].latLng.lat);
    //							$('.jing').val(pois[n].latLng.lng);
    //
    //							// qq.maps.event.addListener(marker, 'click', function() {
    //							//     infoWin.open();
    //							//     infoWin.setContent('<div style="width:280px;height:100px;">' + 'POI的ID为：' +
    //							//         pois[n].id + '，POI的名称为：' + pois[n].name + '，POI的地址为：' + pois[n].address + '，POI的类型为：' + pois[n].type + '</div>');
    //							//     infoWin.setPosition(pois[n].latLng);
    //							// });
    //							qq.maps.event.addListener(marker, 'dragend', function(event) {
    //								var latLng = event.latLng,
    //									lat = latLng.getLat(),
    //									lng = latLng.getLng();
    //
    //								// var coord = new qq.maps.LatLng(lat,lng);
    //								// geocoder.getAddress(coord);
    //								$('.jing').val(lng);
    //								$('.wei').val(lat);
    //							});
    //						})(i);
    //					}
    //					//调整地图视野
    //					map.fitBounds(latlngBounds);
    //				},
    //				//若服务请求失败，则运行以下函数
    //				error: function() {
    ////					alert("出错了。");
    //				layer.msg("您还没填地址呢", {
    //					icon: 2,
    //					time: 1000
    //				});
    //				}
    //			});
    //
    //		}
    //
    //		//清除地图上的marker
    //		function clearOverlays(overlays) {
    //			var overlay;
    //			while(overlay = overlays.pop()) {
    //				overlay.setMap(null);
    //			}
    //		}
    //		//设置搜索的范围和关键字等属性
    //		function searchKeyword() {
    //			$(".map").show();
    //			var keyword = document.getElementById("address").value;
    //			console.log(keyword);
    //			var region = '';
    //			var pageIndex = 0;
    //			var pageCapacity = 1;
    //			clearOverlays(markers);
    //			//根据输入的城市设置搜索范围
    //			searchService.setLocation(region);
    //			//设置搜索页码
    //			searchService.setPageIndex(pageIndex);
    //			//设置每页的结果数
    //			searchService.setPageCapacity(pageCapacity);
    //			//根据输入的关键字在搜索范围内检索
    //			searchService.search(keyword);
    //			//根据输入的关键字在圆形范围内检索
    //			//var region = new qq.maps.LatLng(39.916527,116.397128);
    //			//searchService.searchNearBy(keyword, region , 2000);
    //			//根据输入的关键字在矩形范围内检索
    //			//region = new qq.maps.LatLngBounds(new qq.maps.LatLng(39.936273,116.440043),new qq.maps.LatLng(39.896775,116.354212));
    //			//searchService.searchInBounds(keyword, region);
    //
    //		}
    $('#address').on('keypress', function (e) {
        if (e.keyCode == 13){
            //执行重载
            codeAddress();
            return false;
        }
    })
</script>

<div class="layui-form-item">
    <label class="layui-form-label">商店介绍</label>
    <div class="layui-input-block">
        <?php echo tpl_ueditor('details', $info['details']); ?>
    </div>
</div>


<script>
    layui.use('laydate',function () {
        var laydate = layui.laydate;
        laydate.render({
            elem: '#end_time'
            ,type: 'datetime'
            ,format: 'yyyy-MM-dd HH:mm:ss'
        });
    })
    require(['select2'], function () {
        $('.select2').select2();

        //广告类型
        var ret = [
            {id:1,text:'首页轮播图'},
            {id:2,text:'首页中部广告'},
        ];
        ret.unshift({id: '', text: '请选择类型'});
        ret.map(function (obj) {
            obj.keywords += obj.text.toPinYin() + obj.text.toPinYin(true);
            if(obj.id == "<?php echo isset($info['type'])?$info['type']:''; ?>"){
                obj.selected = true;
            }
            return obj;
        });
        $('#type').select2({
            data: ret,
        })

        var star=[
            {id:1,text:'一星'},
            {id:2,text:'二星'},
            {id:3,text:'三星'},
            {id:4,text:'四星'},
            {id:5,text:'五星'},
        ]
        star.map(function (obj) {
            obj.keywords += obj.text.toPinYin() + obj.text.toPinYin(true);
            if(obj.id == "<?php echo isset($info['star'])?$info['star']:''; ?>"){
                obj.selected = true;
            }
            return obj;
        });
        $('#star').select2({
            data: star,
        })

        //商圈
        $.get("<?php echo adminurl('selectrules','Cstoredistrict'); ?>", function (ret) {
            if (typeof ret == "string") {
                ret = JSON.parse(ret);
            }
            ret.unshift({id: '', text: '请选择商圈'});
            ret.map(function (obj) {
                obj.keywords += obj.text.toPinYin() + obj.text.toPinYin(true);
                if (obj.id == "<?php echo isset($info['district_id'])?$info['district_id']:''; ?>") {
                    obj.selected = true;
                }
                return obj;
            });
            $('#district_id').select2({
                data: ret,
            })
        })
        //分类
        $.get("<?php echo adminurl('selectrules','Cstorecategory'); ?>", function (ret) {
            if (typeof ret == "string") {
                ret = JSON.parse(ret);
            }
            ret.unshift({id: '', text: '请选择分类'});
            ret.map(function (obj) {
                obj.keywords += obj.text.toPinYin() + obj.text.toPinYin(true);
                if (obj.id == "<?php echo isset($info['cat_id'])?$info['cat_id']:''; ?>") {
                    obj.selected = true;
                }
                return obj;
            });
            $('#cat_id').select2({
                data: ret,
            })
        })
        //用户
        $.get("<?php echo adminurl('selectrules','Cuser'); ?>", function (ret) {
            if (typeof ret == "string") {
                ret = JSON.parse(ret);
            }
            ret.unshift({id: '', text: '请选择用户'});
            ret.map(function (obj) {
                obj.keywords += obj.text.toPinYin() + obj.text.toPinYin(true);
                if (obj.id == "<?php echo isset($info['user_id'])?$info['user_id']:''; ?>") {
                    obj.selected = true;
                }
                return obj;
            });
            $('#user_id').select2({
                data: ret,
            })
        })


        layui.use('laydate',function () {
            var laydate = layui.laydate;
            laydate.render({
                elem: '#business_range'
                ,type: 'time'
                ,range: true
            });
        })

        setcommissiontypeshow();
        setdistribution_openshow();
        function setcommissiontypeshow(){
            var  commissiontype= $('[name=commissiontype]:checked').val();
            if(commissiontype==1){
                $('.commissiontype_1').show();
                $('.commissiontype_2').hide();
            }else if(commissiontype==2){
                $('.commissiontype_1').hide();
                $('.commissiontype_2').show();
            }else{
                $('.commissiontype_1').hide();
                $('.commissiontype_2').hide();
            }
        }
        function setdistribution_openshow(){
            var distribution_open= $('[name=distribution_open]:checked').val();
            if(distribution_open==0){
                $('.commissiontype').hide();
                $('.commission').hide();
            }else if(distribution_open==1){
                $('.commissiontype').show();
                $('.commission').show();
            }
        }
        layui.use(['table','form'],function () {
            var table = layui.table;
            var form = layui.form;
            form.on('radio', function (data) {
                if ($(data.elem).is('[name=commissiontype]')) {
                    setcommissiontypeshow();
                }
                if ($(data.elem).is('[name=distribution_open]')) {
                    setdistribution_openshow();
                }
            });
        })

    })
</script>

            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit="">立即提交</button>
                    <button class="layui-btn layui-btn-primary" id="btnCancel">取消</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    //JavaScript代码区域
    layui.use(['element','form'], function(){
        var element = layui.element;
        var form = layui.form;

        
        // 新增界面、保存、取消事件
        form.on('submit', function(data){
            if(!$(data.elem).is('button')){
                return false;
            }
            var data = data.field;
            console.log(data);
            var url = "<?php echo adminurl('save'); ?>";
            $.post(url,data,function(res){
                if (typeof res == 'string'){
                    res = $.parseJSON(res);
                }
                if (res.code == 0) {
                    var index=parent.layer.getFrameIndex(window.name);
                    parent.layer.close(index);
                    parent.layer.msg('保存成功',{icon: 6,anim: 6});
                    parent.layui.table.reload('laytable',{});
                }else{
                    layer.msg(res.msg,{icon: 5,anim: 6});
                }
            });
            return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });
        
        $('#btnCancel').click(function(e){
            var index=parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
        })
    })
</script>
</body>
</html>