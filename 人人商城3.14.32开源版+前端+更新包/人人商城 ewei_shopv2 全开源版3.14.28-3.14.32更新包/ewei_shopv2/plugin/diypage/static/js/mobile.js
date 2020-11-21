define(['core', 'tpl'], function (core, tpl) {
    var modal = {location: {lat: '0', lng: '0'},tabbar_index:0};
    modal.init = function (params) {
        modal.initNotice();
        modal.initSwiper();
        modal.initLocation();
        modal.initAudio();
        modal.initGoods();

        $("form").submit(function () {
            $(this).find("input[name='keywords']").blur();
        });
    };
    modal.initNotice = function () {
        if ($(".fui-notice").length > 0) {
            $(".fui-notice").each(function () {
                var _this = $(this);
                var speed = _this.data('speed') * 1000;
                setInterval(function () {
                    var length = _this.find("li").length;
                    if (length > 1) {
                        _this.find("ul").animate({marginTop: "-1rem"}, 500, function () {
                            $(this).css({marginTop: "0px"}).find("li:first").appendTo(this)
                        })
                    }
                }, speed)
            })
        }

        if($(".fui-topmenu").length > 0){
            $(".topmenu_tab").each(function(index,item){
                var textcolor = $(this).data('textcolor');
                var activecolor = $(this).data('activecolor');
                var bgcolor = $(this).data('bgcolor');
                var activebgcolor = $(this).data('activebgcolor');
                if(index == 0){
                    $(this).css({'background-color':activebgcolor,'border-color':activecolor,'color':activecolor});
                    var notskip = $(this).data('notskip')
                    var url = $(this).data('url');
                    modal.initTopmenu(notskip,url);
                }else{
                    $(this).css({'background-color':bgcolor,'border-color':"#fff",'color':textcolor});
                }
            });

            $('.tab').click(function(){
                if($(this).data('index') == 0 && ($(this).data('url') == '' || $(this).data('url') == undefined)){
                    location.href = core.getUrl('index');
                }
                var textcolor = $(this).data('textcolor');
                var activecolor = $(this).data('activecolor');
                var bgcolor = $(this).data('bgcolor');
                var activebgcolor = $(this).data('activebgcolor');
                $(this).prevAll().css({'background-color':bgcolor,'border-color':"#fff",'color':textcolor});
                $(this).css({'background-color':activebgcolor,'border-color':activecolor,'color':activecolor});
                $(this).nextAll().css({'background-color':bgcolor,'border-color':"#fff",'color':textcolor});
                var notskip = $(this).data('notskip');
                var url = $(this).data('url');
                modal.initTopmenu(notskip,url);
            })
        }

        if($(".fui-tabbar").length > 0){
            $('.tabbar-num').each(function(indexs,items){
                var $this = $(this);
                $this.find('.tab-a').each(function(index,items){
                    var textcolor = $(this).data('textcolor1');
                    var activecolor = $(this).data('activecolor1');
                    var bgcolor = $(this).data('bgcolor1');
                    var activebgcolor = $(this).data('activebgcolor1');
                    console.log(modal.tabbar_index)
                    if(index == modal.tabbar_index){
                        $(this).css({'background-color':activebgcolor,'border-color':activecolor,'color':activecolor});
                        var notskip = $(this).data('notskip');
                        var url = $(this).data('url');
                        modal.initTabbar(notskip,url,$this);
                    }else{
                        $(this).css({'background-color':bgcolor,'border-color':"#fff",'color':textcolor});
                    }
                });
            });
            $(document).on('click', '.tab-a', function () {
                var $this = $(this);
                var textcolor = $this.data('textcolor1');
                var activecolor = $this.data('activecolor1');
                var bgcolor = $this.data('bgcolor1');
                var activebgcolor = $this.data('activebgcolor1');
                modal.tabbar_index = $this.data('index');
                $this.prevAll().css({'background-color':bgcolor,'border-color':"#fff",'color':textcolor}).removeClass('active');
                $this.css({'background-color':activebgcolor,'border-color':activecolor,'color':activecolor}).addClass('active');
                $this.nextAll().css({'background-color':bgcolor,'border-color':"#fff",'color':textcolor}).removeClass('active');
                var notskip = $this.data('notskip');
                var url = $this.data('url');
                //console.log($(this).closest('.tabbar-num'));
                var $this = $this.closest('.tabbar-num');
                modal.initTabbar(notskip,url,$this);
            })


        }

        $(document).off('click', '.tabbar-getmorestore').on('click', '.tabbar-getmorestore', function () {
            var notskip = $(this).data('notskip');
            var url = $(this).data('url');
            var num = $(this).data('num');
            var $this = $(this).closest('.bar-storeslist').prevAll('.tabbar-num').eq(0);
            modal.initTabbar(notskip,url,$this,num);
        });

        $(document).off('click', '.tabbar-getmoregoods').on('click', '.tabbar-getmoregoods', function () {
            var notskip = $(this).data('notskip');
            var url = $(this).data('url');
            var num = $(this).data('num');
            var $this = $(this).closest('.tab-goodslist').prevAll('.tabbar-num').eq(0);
            modal.initTabbar(notskip,url,$this,num);
        });

        $(document).off('click', '.topmenu-getmorestore').on('click', '.topmenu-getmorestore', function () {
            var notskip = $(this).data('notskip');
            var url = $(this).data('url');
            var num = $(this).data('num');
            modal.initTopmenu(notskip,url,num);
        });

        $(document).off('click', '.topmenu-getmoregoods').on('click', '.topmenu-getmoregoods', function () {
            var notskip = $(this).data('notskip');
            var url = $(this).data('url');
            var num = $(this).data('num');
            modal.initTopmenu(notskip,url,num);
        });

    };
    modal.initSwiper = function () {

        if($('[data-toggle="timer"]').length>0){
            require(['../addons/ewei_shopv2/plugin/seckill/static/js/timer.js'],function(timerUtil){
                timerUtil.initTimers();
            });
        }

        if ($(".swiper").length > 0) {
            require(['swiper'], function (modal) {
                $(".swiper").each(function () {
                    var obj = $(this);
                    var ele = $(this).data('element');
                    var container = ele + " .swiper-container";
                    var view = $(this).data('view');
                    var btn = $(this).data('btn');
                    var free = $(this).data('free');
                    var space = $(this).data('space');
                    var callback = $(this).data('callback');
                    var slideTo = $(this).data('slideto');
                    var options = {
                        pagination: container + ' .swiper-pagination',
                        slidesPerView: view,
                        paginationClickable: true,
                        loop : true,
                        autoHeight: true,
                        nextButton: container + ' .swiper-button-next',
                        prevButton: container + ' .swiper-button-prev',
                        spaceBetween: space > 0 ? space : 0,
                        /*preventClicks : false,*/
                        preventLinksPropagation : true,
                        onSlideChangeEnd: function (swiper) {
                            if (swiper.isEnd && callback) {
                                if (callback == 'seckill') {
                                    location.href = core.getUrl('seckill');
                                }
                            }
                        }
                    };
                    if (!btn) {
                        delete options.nextButton;
                        delete options.prevButton;
                        $(container).find(".swiper-button-next").remove();
                        $(container).find(".swiper-button-prev").remove()
                    }
                    if (free) {
                        options.freeMode = true
                    }
                    var swiper = new Swiper(container, options);
                    if(slideTo){
                        swiper.slideTo(slideTo, 0, false);
                    }
                });
            })
        }
    };
    modal.initLocation = function () {
        if ($(".merchgroup[data-openlocation='1']").length > 0) {
            /*读取缓存坐标*/
            var lat=modal.getCookie("lat");
            var lng=modal.getCookie("lng");
            if(lat!="" && lng!=""){
                modal.location.lat = lat;
                modal.location.lng = lng;
                modal.initMerch();
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
                            modal.location.lat = result.position.lat;
                            modal.location.lng = result.position.lng;
                            modal.initMerch()
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
                                    modal.location.lat = result.point.lat;
                                    modal.location.lng = result.point.lng;
                                    modal.initMerch()
                                } else {
                                    FoxUI.toast.show("位置获取失败!");
                                    return
                                }
                            }, {enableHighAccuracy: true});
                        }
                    });
                });
            }
        }
    };
    modal.initMerch = function () {
        $(".merchgroup").each(function () {
            var _this = $(this);
            var item = _this.data('itemdata');
            if (!item || !item.params.openlocation) {
                return
            }
            core.json('diypage/getmerch', {
                lat: modal.location.lat,
                lng: modal.location.lng,
                item: item
            }, function (result) {
                if (result.status == 1) {
                    var list = result.result.list;
                    if (list) {
                        _this.empty();
                        $.each(list, function (id, merch) {
                            var thumb = merch.thumb ? merch.thumb : '../addons/ewei_shopv2/plugin/diypage/static/images/default/logo.jpg';
                            var html = '';
                            html = '<div class="fui-list jump">';
                            html += '<a class="fui-list-media" href="' + core.getUrl("merch", {merchid: merch.id}) + '" data-nocache="true"><img src="' + thumb + '"/></a>';
                            html += '<a class="fui-list-inner" href="' + core.getUrl("merch", {merchid: merch.id}) + '" data-nocache="true">';
                            html += '<div class="title" style="color: ' + item.style.titlecolor + ';">' + merch.name + '</div>';
                            if (merch.desc) {
                                html += '<div class="subtitle" style="color: ' + item.style.textcolor + ';">' + merch.desc + '</div>'
                            }
                            if (merch.distance && item.params.openlocation) {
                                html += '<div class="subtitle" style="color: ' + item.style.rangecolor + '; font-size: 0.6rem"><i class="icon icon-dingwei1" style="color: ' + item.style.rangecolor + '; font-size: 0.6rem;"></i>距离您: ' + merch.distance + 'km</div>'
                            }
                            html += '</a>';
                            html += '<a class="fui-remark jump" style="padding-right: 0.2rem; height: 2rem; width: 2rem; text-align: center; line-height: 2rem;" href="' + core.getUrl("merch/map", {merchid: merch.id}) + '" data-nocache="true">';
                            html += '</a>';
                            html += '</div>';
                            _this.append(html)
                        });
                        _this.show()
                    }
                }
            }, true, true)
        })
    };
    modal.initAudio = function () {
        if ($(".play-audio").length > 0) {
            $(".play-audio").each(function () {
                var _this = $(this);
                var autoplay = _this.data('autoplay');
                var audio = _this.find("audio")[0];
                var duration = audio.duration;
                if(!isNaN(duration)){
                    var time = modal.formatSeconds(duration);
                    _this.find(".time").text(time).show();
                }

                if (autoplay) {
                    /*modal.playAudio(_this)*/
                }
                $(_this).click(function () {
                    if (!audio.paused) {
                        modal.stopAudio(_this)
                    } else {
                        modal.playAudio(_this)
                    }
                })
            })
        }
    };
    modal.playAudio = function (_this) {
        _this.siblings().find("audio").each(function () {
            var __this = $(this).closest(".play-audio");
            modal.stopAudio(__this)
        });
        var audio = _this.find("audio")[0];
        var duration = audio.duration;

        if(!isNaN(duration)){
            var time = modal.formatSeconds(duration);
            _this.find(".time").text(time).show();
        }

        audio.play();
        _this.find(".horn").addClass('playing');
        if (audio.paused) {
            _this.find(".speed").css({width: '0px'})
        }
        var timer = setInterval(function () {
            var currentTime = audio.currentTime;
            if (currentTime >= duration) {
                modal.stopAudio(_this);
                clearInterval(timer)
            }
            var _thiswidth = _this.outerWidth();
            var _width = (currentTime / duration) * _thiswidth;
            _this.find(".speed").css({width: _width + 'px'})
        }, 1000)
    };
    modal.stopAudio = function (_this) {
        var audio = _this.find("audio")[0];
        if (audio) {
            var stop = _this.data('pausestop');
            if (stop) {
                audio.currentTime = 0
            }
            audio.pause();
            _this.find(".horn").removeClass('playing')
        }
    };
    modal.formatSeconds = function (value) {
        var theTime = parseInt(value);
        var theTime1 = 0;
        var theTime2 = 0;
        if (theTime > 60) {
            theTime1 = parseInt(theTime / 60);
            theTime = parseInt(theTime % 60);
            if (theTime1 > 60) {
                theTime2 = parseInt(theTime1 / 60);
                theTime1 = parseInt(theTime1 % 60)
            }
        }
        var result = "" + parseInt(theTime) + "''";
        result = "" + parseInt(theTime1) + "'" + result;
        if (theTime2 > 0) {
            result = "" + parseInt(theTime2) + "'" + result
        }
        return result
    };

    modal.initGoods = function () {
        if($('.fui-goods-group').length>0){
            require(['biz/goods/picker','biz/goods/wholesalePicker'], function (picker,wholesalePicker) {
                $('.fui-goods-group .fui-goods-item .buy .buy').click(function (e) {
                    var item = $(this).closest('.fui-goods-item');
                    var gid = item.data('goodsid'), type = item.data('type');
                    var is_bargain = $(this).hasClass('bargain-btn');
                    if (is_bargain){/*砍价*/
                        type = 20;
                    }
                    if(!type || type == 20) {
                        return;
                    } else if(type ==4) {
                        wholesalePicker.open({
                            goodsid: gid
                        });
                    } else {
                        picker.open({
                            goodsid: gid,
                            refresh: true,
                            cangift: 1,
                            total: 1
                        });
                    }
                    e.stopPropagation();
                    e.preventDefault();
                });
            });
        }
    };
    modal.initTopmenu = function(notskip,url,num){

        if(notskip == 1 && url != ''){
            if(url.indexOf('stores') >= 0){
                $.get(core.getUrl('diypage/getInfo'),{url:url,num:num,paramsType:'stores'},function(ret){
                    var ret = JSON.parse(ret);
                    if(ret.status == 1){
                        var list = ret.result.list;
                        var html = '';
                        var num = list.length;
                        var count = ret.result.count;
                        $.each(list,function(id,item){
                            html += '<a class="store" data-goodsid="'+ item.id +'" href="'+ core.getUrl('store/detail',{id:item.id}) +'" data-type="'+ item.id +'" >';
                            html += '<div style="height: 1.8rem;border-bottom:1px solid #ededed;line-height: 1.8rem;padding: 0 0.6rem;font-size: 0.65rem;color: #333;">';
                            html += '<div style="float:left;">'+ item.storename +'</div>';
                            html += '<div style="float:right;"  class="icon icon-dingwei"></div>';
                            html += '</div>';
                            html += '</a>';
                        })
                        if(count > num) {
                            html += '<div class="topmenu-getmorestore" style="background:#f3f3f3;width: 100%;height: 1.8rem;line-height: 1.8rem;text-align: center;color: #999;font-size: 0.65rem;" data-notskip="'+notskip+'" data-url="'+url+'" data-num="'+num+'">加载更多</div>';
                        }
                        $('.storeslist').html(html);
                        $('.store-list').css('display','block');
                        $('.goodslist').css('display','none');
                        $('.fui-content .default-items').show();
                        $('.fui-content .custom-items').hide();
                    }else{

                    }
                });
            }else{
                $.get(core.getUrl('diypage/getInfo'),{url:url,num:num,paramsType:'goods'},function(ret){
                    var ret = JSON.parse(ret);
                    if(ret.status == 1){
                        var list = ret.result.list;
                        var html = '';
                        var num = list.length;
                        var count = ret.result.count;
                        $.each(list,function(id,item){
                            html += '<a class="fui-goods-item" data-goodsid="'+ item.id +'" href="'+ core.getUrl('goods/detail',{id:item.id}) +'" data-type="'+ item.id +'" data-nocache="true" style="position: relative;">';
                            html += '<div class="image " data-text="" data-lazyloaded="true" style="background-image: url('+item.thumb+');">';
                            if(item.seecommission>0 && item.cansee ==1){
                                html += '<div class="goods-Commission">'+ (item.seetitle ? '预计最高佣金': item.seetitle) + '￥'+  item.seecommission + '</div>';}
                            if(item.total <= 0){
                                html += '<div class="salez diy" style="background-image: url(\'../addons/ewei_shopv2/static/images/shouqin.png\'); "></div>';
                            }
                            html += '</div>';
                            html += '<div class="detail">';
                            html += '<div class="name" style="color: #000000;">'+ item.title +'</div>';
                            html += '<p class="productprice noheight"></p>';
                            html += '<div class="price">';
                            html += '<span class="text" style="color: #ff5555;">';
                            html += '<p class="minprice">¥'+ item.minprice +'</p>';
                            html += '</span>';
                            html += '';
                            if(item.bargain > 0){
                                html += '<span class="buy bargain-btnbuy btn-1" style="border-color: #ff5555;color:  #ff5555">砍价活动</span>';
                            }else{
                                html += '<span class="buy btn-1" style="border-color: #ff5555;color:  #ff5555">购买</span>';
                            }
                            html += '</div>';
                            html += '</div>';
                            html += '</a>';
                        })
                        if(count > num) {
                            html += '<div class="topmenu-getmoregoods" style="float:left;width: 100%;height: 1.8rem;line-height: 1.8rem;text-align: center;color: #999;font-size: 0.65rem;" data-notskip="'+notskip+'" data-url="'+url+'" data-num="'+num+'">加载更多</div>';
                        }
                        $('.store-list').hide();
                        $('.goodslist').html(html);
                        $('.goodslist').show();

                        $('.fui-content .default-items').show();
                        $('.fui-content .custom-items').hide();
                    }else{

                    }
                });
            }

        }else if(notskip == 0 && url != ''){
            $.get(url,{simple: 1},function(ret){
                $('.fui-content .default-items').hide();
                $('.fui-content .custom-items').html(ret).show();
                $('.goods_list').show();
                $('.fui-content ').lazyload();
                $('.fui-swipe').swipe();
                if($(".fui-tabbar").length > 0) {
                    $('.tabbar-num').each(function (indexs, items) {
                        var $this = $(this);
                        $this.find('.tab-a').each(function (index, items) {
                            var textcolor = $(this).data('textcolor1');
                            var activecolor = $(this).data('activecolor1');
                            var bgcolor = $(this).data('bgcolor1');
                            var activebgcolor = $(this).data('activebgcolor1');
                            if (index == 0) {
                                $(this).css({
                                    'background-color': activebgcolor,
                                    'border-color': activecolor,
                                    'color': activecolor
                                });
                                var notskip = $(this).data('notskip');
                                var url = $(this).data('url');
                                modal.initTabbar(notskip, url, $this);
                            } else {
                                $(this).css({'background-color': bgcolor, 'border-color': "#fff", 'color': textcolor});
                            }
                        });
                    });
                    modal.initAudio();
                }
            });
        }
    };
    modal.initTabbar = function(notskip,url,$this,num){
        if(notskip == 1 && url != ''){
            if(url.indexOf('stores') >= 0){
                $.get(core.getUrl('diypage/getInfo'),{url:url,num:num,paramsType:'stores'},function(ret){
                    var ret = JSON.parse(ret);
                    if(ret.status == 1){
                        var list = ret.result.list;
                        var html = '';
                        var num = list.length;
                        var count = ret.result.count;
                        $.each(list,function(id,item){
                            html += '<a class="store" data-goodsid="'+ item.id +'" href="'+ core.getUrl('store/detail',{id:item.id}) +'" data-type="'+ item.id +'" >';
                            html += '<div style="height: 1.8rem;border-bottom:1px solid #ededed;line-height: 1.8rem;padding: 0 0.6rem;font-size: 0.65rem;color: #333;">';
                            html += '<div style="float:left;">'+ item.storename +'</div>';
                            html += '<div style="float:right;"  class="icon icon-dingwei"></div>';
                            html += '</div>';
                            html += '</a>';
                        })
                        if(count > num){
                            html += '<div class="tabbar-getmorestore" style="background:#f3f3f3;width: 100%;height: 1.8rem;line-height: 1.8rem;text-align: center;color: #999;font-size: 0.65rem;" data-notskip="'+notskip+'" data-url="'+url+'" data-num="'+num+'">加载更多</div>';
                        }
                        $($this).nextAll('.bar-storeslist').eq(0).find('.tab-storeslist').html(html);
                        $($this).nextAll('.bar-storeslist').eq(0).show();
                        $($this).next('.tab-goodslist').hide();
                        // $('.fui-content .default-items').show();
                        // $('.fui-content .custom-items').hide();
                    }else{

                    }
                });
            }else{
                $.get(core.getUrl('diypage/getInfo'),{url:url,num:num,paramsType:'goods'},function(ret){
                    var ret = JSON.parse(ret);
                    if(ret.status == 1){
                        var list = ret.result.list;
                        var html = '';
                        var num = list.length;
                        var count = ret.result.count;
                        $.each(list,function(id,item){
                            html += '<a class="fui-goods-item" data-goodsid="'+ item.id +'" href="'+ core.getUrl('goods/detail',{id:item.id}) +'" data-type="'+ item.id +'" data-nocache="true" style="position: relative;">';
                            html += '<div class="image " data-text="" data-lazyloaded="true" style="background-image: url('+item.thumb+');">';
                            if(item.seecommission>0 && item.cansee ==1){
                            html += '<div class="goods-Commission">'+ (item.seetitle ? '预计最高佣金': item.seetitle) + '￥'+  item.seecommission + '</div>';}
                            if(item.total <= 0){
                                html += '<div class="salez diy" style="background-image: url(\'../addons/ewei_shopv2/static/images/shouqin.png\'); "></div>';
                            }
                            html += '</div>';
                            html += '<div class="detail">';
                            html += '<div class="name" style="color: #000000;">'+ item.title +'</div>';
                            html += '<p class="productprice noheight"></p>';
                            html += '<div class="price">';
                            html += '<span class="text" style="color: #ff5555;">';
                            html += '<p class="minprice">¥'+ item.minprice +'</p>';
                            html += '</span>';
                            html += '';
                            if(item.bargain > 0){
                                html += '<span class="buy bargain-btnbuy btn-1" style="border-color: #ff5555;color:  #ff5555">砍价活动</span>';
                            }else{
                                html += '<span class="buy btn-1" style="border-color: #ff5555;color:  #ff5555">购买</span>';
                            }
                            html += '</div>';
                            html += '</div>';
                            html += '</a>';
                        });
                        if(count > num) {
                            html += '<div class="tabbar-getmoregoods" style="width: 100%;height: 1.8rem;float: left;line-height: 1.8rem;text-align: center;color: #999;font-size: 0.65rem;" data-notskip="' + notskip + '" data-url="' + url + '" data-num="'+num+'">加载更多</div>';
                        }
                        $($this).next('.tab-goodslist').html(html);
                        $($this).next('.tab-goodslist').show();
                        $($this).nextAll('.bar-storeslist').eq(0).hide();
                        // $('.fui-content .default-items').show();
                        // $('.fui-content .custom-items').hide();
                    }else{

                    }
                });
            }

        }else if(notskip == 0 && url != ''){
            $.get(url,{simple: 1},function(ret){
                $('.fui-content .default-items').hide();
                $('.fui-content .custom-items').html(ret).show();
                $('.goods_list').css('display','block');
                $('.fui-content ').lazyload();
                $('.fui-swipe').swipe();
            });
        }
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
