define(['core', 'tpl','swiper','biz/order/op'], function (core, tpl,swiper,op) {
    var modal = {
        params: {
            orderid: 0,
            location: window.location.href,
            card_count:0,

        },


    };
    function getURLVar(key) {
        var value = [];

        var query = String(document.location).split('?');

        if (query[1]) {
            var part = query[1].split('&');

            for (i = 0; i < part.length; i++) {
                var data = part[i].split('=');

                if (data[0] && data[1]) {
                    value[data[0]] = data[1];
                }
            }

            if (value[key]) {
                return value[key];
            } else {
                return '';
            }
        }
    }
    modal.init = function (params, invoice_info) {

        modal.params = $.extend(modal.params, params || {});
        if(typeof card_index!="undefined"){
            var k= card_index;
        }else{
            var k= 0;
        }
        var mySwiper = new Swiper('.swiper-container', {
            slidesPerView: 'auto',
            centeredSlides: true,
            initialSlide :k,
            // loop: true,
            onSlideChangeEnd: function(swiper){
                modal.params.card_id=$(".swiper-slide").eq(swiper.activeIndex).attr("data-id");
                modal.page = 1;
                modal.getList();
            }
            , onInit: function(swiper){
                //  alert(swiper.activeIndex);
                modal.params.card_id=$(".swiper-slide").eq(swiper.activeIndex).attr("data-id");
                modal.page = 1;
                modal.getList();
            },
        })

        // if(modal.params.card_count>1){
        //     // modal.params.card_id=id;
        //     // modal.page = 1;
        //     // modal.getList();
        //     var mySwiper = new Swiper('.swiper-container', {
        //         slidesPerView: 'auto',
        //         centeredSlides: true,
        //         initialSlide :k,
        //        // loop: true,
        //         onSlideChangeEnd: function(swiper){
        //             modal.params.card_id=$(".swiper-slide").eq(swiper.activeIndex).attr("data-id");
        //             modal.page = 1;
        //             modal.getList();
        //         }
        //         , onInit: function(swiper){
        //
        //             //  alert(swiper.activeIndex);
        //             modal.params.card_id=$(".swiper-slide").eq(swiper.activeIndex).attr("data-id");
        //             modal.page = 1;
        //             modal.getList();
        //         },
        //     })
        // }else{
        //     var mySwiper = new Swiper('.swiper-container', {
        //         slidesPerView: 'auto',
        //         centeredSlides: true,
        //         initialSlide :k,
        //         onInit: function(swiper){
        //
        //             //  alert(swiper.activeIndex);
        //             modal.params.card_id=$(".swiper-slide").eq(swiper.activeIndex).attr("data-id");
        //             modal.page = 1;
        //             modal.getList();
        //         },
        //
        //     })
        // }







     // var location= modal.params.location.replace(/.detail/, ".index");
     //
     //    var state = {
     //        title: "",
     //        url: location
     //    };
     //   // window.history.pushState(state, "", state.url);
     //    window.addEventListener("popstate", function (e) {
     //        if (history.state){
     //            var state = e.state;
     //            //do something(state.url, state.title);
     //           document.location.href = location;
     //
     //        }
     //
     //    }, false);







   








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
        return ""
    };





    modal.submit = function (obj, token) {
        var $this = $(obj);

        if (modal.params.mustbind) {

            /*FoxUI.alert("请先绑定手机", "提示", function () {
                location.href = core.getUrl('member/bind', {backurl: btoa(location.href)})
            });
            return*/
        }
        if ($this.attr('stop')) {
            return
        }



        $this.attr('stop', 1);
        var data = {
            'orderid': modal.params.orderid,
            'card_id': modal.params.card_id,
            'submit': true,
            'token': token,

        };



        FoxUI.loader.show('mini');
        core.json('membercard/orders/submit', data, function (ret) {
            $this.removeAttr('stop', 1);
            if (ret.status == 0) {
                FoxUI.loader.hide();
                FoxUI.toast.show(ret.result.message);
                return
            }
            if (ret.status == -1) {
                FoxUI.loader.hide();
                FoxUI.alert(ret.result.message);
                return
            }

            var payurl = core.getUrl('membercard/pay', {id: ret.result.orderid});
            if(core.options && core.options.siteUrl){
                payurl = core.options.siteUrl+ 'app' + payurl.substr(1);
            }
            //location.href = core.getUrl('order/pay', {id: ret.result.orderid});
            location.href = payurl;
        }, false, true)
    };

    modal.loading = function () {
        modal.page++
    };
    modal.getList = function () {
        core.json('membercard/detail/get_list', {page: modal.page,card_id: modal.params.card_id,}, function (ret) {
            $('.infinite-loading').hide();
            var result = ret.result;
            if(ret.result.list.card_name){
               // $('.head-card-name').html(ret.result.list.card_name);
            }
            if (result.total <= 0) {
                $('.content-empty').show();
                $('.fui-content').infinite('stop')
            } else {
                $('.content-empty').hide();
                $('.fui-content').infinite('init');

                if (result.list.length <= 0 || result.list.length < result.pagesize) {
                    $('.fui-content').infinite('stop')
                }
            }
           modal.page++;

          //  core.tpl('.container', 'tpl_order_index_list', result, modal.page > 1);
            core.tpl('.container', 'tpl_order_index_list', result);




            op.init();
           modal.getCoupon();
           modal.getPoints();
            $('.buybtn').bind('click',function () {
                modal.submit(this, modal.params.token)
            });
            $('.card-modal-submit').bind('click',function () {
                $('.card-modal').hide();
            });



        })
    };

    modal.getCoupon = function () {

        $(".btn-coupon-receive").bind('click',function () {
            var btn = $(this);
            var coupon_id=$(this).data('couponid');
            var href = "";
            var button = "";
            if (btn.attr('submitting') == '1') {
                return
            }
            FoxUI.confirm('确认领取吗?', '提示语', function () {
                $(".fui-message-popup .btn-danger").text('正在处理...');
                btn.attr('oldhtml', btn.html()).html('操作中..').attr('submitting', 1);
                core.json('membercard/coupon/get_month_coupon', {couponid: coupon_id,card_id: modal.params.card_id}, function (ret) {
                    if (ret.status <= 0) {
                        btn.html(btn.attr('oldhtml')).removeAttr('oldhtml').removeAttr('submitting');
                        $(".fui-message-popup .btn-danger").text('确定');
                        FoxUI.toast.show(ret.result.message);
                        return
                    }else{
                        $('.card-modal').hide();
                        btn.addClass('gary');
                        btn.html('已领取');
                        // text = "恭喜您，优惠券到手啦";
                        // button = "立即查看";
                        // href = core.getUrl('sale/coupon/my');
                        // FoxUI.message.show({
                        //     icon: 'icon icon-success',
                        //     content: text,
                        //     buttons: [{
                        //         text: button, extraClass: 'btn-danger', onclick: function () {
                        //             location.href = href
                        //         }
                        //     }, {
                        //         text: '取消', extraClass: 'btn-default', onclick: function () {
                        //             location.href = core.getUrl('membercard/detail')
                        //         }
                        //     }]
                        // });
                    }

                }, true, true);
            });
            return
        })
    };
    modal.getPoints = function () {

        $(".btn-month-points").bind('click',function () {
            var btn = $(this);
            var href = "";
            var button = "";
            if (btn.attr('submitting') == '1') {
                return
            }
            FoxUI.confirm('确认领取吗?', '提示语', function () {
                $(".fui-message-popup .btn-danger").text('正在处理...');
                btn.attr('oldhtml', btn.html()).html('操作中..').attr('submitting', 1);
                core.json('membercard/coupon/get_month_point', {card_id: modal.params.card_id}, function (ret) {
                    if (ret.status <= 0) {
                        btn.html(btn.attr('oldhtml')).removeAttr('oldhtml').removeAttr('submitting');
                        $(".fui-message-popup .btn-danger").text('确定');
                        FoxUI.toast.show(ret.result.message);
                        return
                    }else{
                        btn.addClass('gary');
                        btn.html('已领取');
                        // text = "积分领取成功";
                        // button = "立即查看";
                        // href = core.getUrl('member/index');
                        // FoxUI.message.show({
                        //     icon: 'icon icon-success',
                        //     content: text,
                        //     buttons: [{
                        //         text: button, extraClass: 'btn-danger', onclick: function () {
                        //             location.href = href
                        //         }
                        //     }, {
                        //         text: '取消', extraClass: 'btn-default', onclick: function () {
                        //             location.href = core.getUrl('membercard/detail')
                        //         }
                        //     }]
                        // });
                    }

                }, true, true);
            });
            return
        })
    };
    modal.infinite = function () {
        $('.fui-content').infinite({
            onLoading: function () {
                modal.getList()
            }
        })
    };

    return modal
});