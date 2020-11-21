define(['core', 'tpl'], function (core, tpl) {
    var modal = {page: 1, keyword: '',cateid: 0};
    modal.init = function (params) {
        modal.keyword = params.keyword ? params.keyword : '' ;
        modal.cateid = params.cateid ? params.cateid : 0 ;
        modal.page = 1;
        modal.lat = '';
        modal.lng = '';
        modal.range = 2000;
        modal.sorttype = 0;

        if (modal.cateid > 0) {
            $('.sortmenu_cate ul li').each(function(){
                if ($(this).attr('cateid') == modal.cateid) {
                    $('#sortmenu_cate_text').html($(this).attr('text'));
                }
            });
        }


        $(".sortMenu > li").off("click").on("click",function(){
            var menuclass = $(this).attr("data-class");
            if($("."+menuclass+"").css("display")=="none"){
                $(".sortMenu > div").hide();
                $("."+menuclass+"").show();
                $(".sort-mask").show();
            }else{
                $("."+menuclass+"").hide();
                $(".sort-mask").hide();
            }

        });

        $(".sort-mask").off("click").on("click",function(){
            $(this).hide();
            $(".sortMenu > div").hide();
        });

        $('.sortmenu_rule ul li').click(function () {
            modal.range = $(this).attr('range');
            var text = $(this).attr('text');
            $('#sortmenu_rule_text').html(text);
            $('.sortmenu_rule').hide();
            modal.page = 1;
            $(".container").empty();
            $(".sort-mask").hide();
            $(".sortMenu > div").hide();
            modal.getList()
        });

        $('.sortmenu_cate ul li').click(function () {
            modal.cateid = $(this).attr('cateid');
            var text = $(this).attr('text');
            $('#sortmenu_cate_text').html(text);
            $('.sortmenu_cate').hide();
            modal.page = 1;
            $(".container").empty();
            $(".sort-mask").hide();
            $(".sortMenu > div").hide();
            modal.getList()
        });

        $('.sortmenu_sort ul li').click(function () {
            modal.sorttype = $(this).attr('sorttype');
            var text = $(this).attr('text');
            $('#sortmenu_sort_text').html(text);
            $('.sortmenu_sort').hide();
            modal.page = 1;
            $(".container").empty();
            $(".sort-mask").hide();
            $(".sortMenu > div").hide();
            modal.getList()
        });


        $('.fui-content').infinite({
            onLoading: function () {
                modal.getList()
            }
        });
        if (modal.page == 1) {
            modal.getList()
        }
    };
    modal.getList = function () {
        var lat=modal.getCookie("lat");
        var lng=modal.getCookie("lng");
        if(false && lat!="" && lng!=""){
            modal.lat = lat;
            modal.lng = lng;
            modal.getMerch();
        }else{
            /*高德地图定位*/
            var map = new AMap.Map('amap-container');
            window.modal = modal;
            map.plugin('AMap.Geolocation', function() {
                var geolocation = new AMap.Geolocation({
                    enableHighAccuracy: true,//是否使用高精度定位，默认:true
                    timeout: 5000,          //超过10秒后停止定位，默认：5s
                    maximumAge: 0,        //定位结果缓存0毫秒，默认：0(10min)
                });
                map.addControl(geolocation);
                geolocation.getCurrentPosition(function(status,result){
                    if(status=='complete'){
                        modal.setCookie('lat',result.position.lat,0.1);
                        modal.setCookie('lng',result.position.lng,0.1);
                        modal.lat = result.position.lat;
                        modal.lng = result.position.lng;
                        modal.getMerch()
                    }else{
                        /*FoxUI.toast.show("位置获取失败!"+result.message);
                        return*/
                        /*百度地图定位*/
                        var geoLocation = new BMap.Geolocation();
                        window.modal = modal;
                        geoLocation.getCurrentPosition(function (result) {
                            if (this.getStatus() == BMAP_STATUS_SUCCESS) {
                                modal.setCookie('lat',result.point.lat,0.1);
                                modal.setCookie('lng',result.point.lng,0.1);
                                modal.lat = result.point.lat;
                                modal.lng = result.point.lng;
                                modal.getMerch()
                            } else {
                                FoxUI.toast.show("位置获取失败!");
                                return
                            }
                        }, {enableHighAccuracy: true});
                    }
                });
            });
        }
    };
    modal.getMerch = function (){
        core.json('merch/list/ajaxmerchuser', {page: modal.page, keyword: modal.keyword, cateid: modal.cateid, lat: modal.lat, lng: modal.lng, range: modal.range, sorttype: modal.sorttype}, function (ret) {
            var result = ret.result;
            if (result.total <= 0) {
                $('.content-empty').show();
                $('.fui-content').infinite('stop')
            } else {
                $('.content-empty').hide();
                $('.container').show();
                $('.fui-content').infinite('init');
                if (result.list.length <= 0 || result.list.length < result.pagesize) {
                    $('.fui-content').infinite('stop')
                }
            }
            modal.page++;
            core.tpl('.container', 'tpl_merch_list_user', result, modal.page > 2);
        }, true, true)
    };
    modal.getCookie = function (cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1);
            if (c.indexOf(name) != -1) {
                return c.substring(name.length, c.length)
            }
        }
        return "";
    };
    modal.setCookie = function(name,value,expireHours){
        var cookieString=name+"="+escape(value);
        if(expireHours>0){
            var date = new Date();
            date.setTime(date.getTime()+(expireHours*3600*1000));
            cookieString=cookieString+"; expires="+date.toGMTString();
        }
        document.cookie=cookieString;
    };
    modal.delCookie = function (name) {
        var date = new Date();
        date.setTime(date.getTime()-10000);
        document.cookie=name+"=v; expires="+date.toGMTString();
    };
    return modal
});