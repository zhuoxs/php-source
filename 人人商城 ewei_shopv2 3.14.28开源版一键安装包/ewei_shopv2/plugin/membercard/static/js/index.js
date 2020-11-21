define([], function () {
    var modal = {
        params: {
            orderid: 0,

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
    modal.init = function (params) {
        $('.cardindex').click(function () {
           card_index = $(this).attr('data-index');


        })
        var cate='all';
        if(modal.getCookie('cate')){

            cate=modal.getCookie('cate');
        }else if(params.cate){
            cate=params.cate;
        }

        $('div[data-cate='+cate+']').addClass('active').siblings().removeClass('active');
        if(cate == 'all'){
            $('.all-card').css('display', 'block')
            $('.my-card').css('display', 'none')
        }else{
            $('.all-card').css('display', 'none')
            $('.my-card').css('display', 'block')
        }
        $('.tab .item').click(function () {
            $(this).addClass('active').siblings().removeClass('active')
            var cate = $(this).data('cate');
            if(cate == 'all'){
                document.cookie = "cate=all";
                $('.all-card').css('display', 'block')
                $('.my-card').css('display', 'none')
            }else{
                document.cookie = "cate=my";

                $('.all-card').css('display', 'none')
                $('.my-card').css('display', 'block')
            }
            modal.getList();
           window.location.reload();


        })
        $('.cardbtn').bind('click',function () {
            document.cookie = "cate=all";
            $('.all-card').css('display', 'block')
            $('.my-card').css('display', 'none');
            $('div[data-cate=all]').addClass('active').siblings().removeClass('active');
        });
        $('.buybtn').bind('click',function () {
            modal.params.card_id=$(this).data('cartid');
            modal.submit(this, modal.params.token)
        });

        
        //    window.addEventListener("popstate", function (e) {
        //
        //        document.cookie = "cate" + '=;  expires=Thu, 01 Jan 1970 00:00:01 GMT;'
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

    modal.getList = function () {
        core.json('membercard/index/get_query', {}, function (ret) {

            var result = ret.result;
            $('div[data-cate=all]').html('全部('+result.all_counts+')');
            $('div[data-cate=my]').html('我的会员卡('+result.my_counts+')');

        })
    };
    return modal;
});