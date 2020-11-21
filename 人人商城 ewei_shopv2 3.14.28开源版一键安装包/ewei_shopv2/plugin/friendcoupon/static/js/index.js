define(['core', 'tpl'], function (core, tpl) {
    var modal = {};

    // 刷新页面方法,后面+随机时间戳是因为部分安卓手机
    // TODO做判断的时候要先看下是否带了t参数,如果
    // 不检查会出现
    // https://yctcs.100cms.com/app/index.php?i=2&c=entry&m=ewei_shopv2&do=mobile&r=friendcoupon&id=1&mid=9&wxref=mp.weixin.qq.com&t=1547792529883&t=1547792616058&t=1547793041276&t=1547794092584这种情况
    modal.reload = function () {
        window.location.href = window.location.href + "&t=" + (+new Date)
    };

    // 倒计时方法
    modal.countDown = function (timePoint, time) {
        // 当前时间
        var now = parseInt(Date.now() / 1000);
        var leftTime = 0;
        if (timePoint) {
            leftTime = timePoint > now ? (timePoint - now) : (now - timePoint); //时间差
            leftTime = parseInt(leftTime);
        }
        if (time) {
            leftTime = parseInt(time);
        }
        if (leftTime == 0) {
            return false;
        } else {
            let day = Math.floor(leftTime / (60 * 60 * 24));
            let hour = Math.floor((leftTime - day * 24 * 60 * 60) / 3600);
            let minute = Math.floor((leftTime - day * 24 * 60 * 60 - hour * 3600) / 60);
            let second = Math.floor(leftTime - day * 24 * 60 * 60 - hour * 3600 - minute * 60);
            let time = [day, hour < 10 ? '0' + hour : hour, minute < 10 ? '0' + minute : minute, second < 10 ? '0' + second : second];
            return time;
        }
    };

    modal.init = function (params) {
        // 倒计时效果
        var id = params.id || 0;

        $(".invitation").on("click", function () {
            if ($("#cover").css("display") == 'none') {
                $("#cover").show();
                $("#guide").show();
                $(".fui-page-current").css('overflow', 'hidden');
            }
        });
        $('#receiveActivity').on('click', function () {

            core.json('friendcoupon/receive', {id: id}, function (response) {
                if (response.status === 0) {
                    $('#tips_content').html(response.result.message);
                    $('#tips').show();
                } else {
                    FoxUI.toast.show(response.result.message);
                    setTimeout(function () {
                        modal.reload();
                    }, 2000);
                }
            })
        });

        // 点击之后立即瓜分优惠券
        $('#divide').on('click', function () {
            core.json('friendcoupon/divide', {id: id}, function (response) {
                if (response.status === 0) {
                    FoxUI.toast.show(response.result.message);
                    if (typeof response.result.url != 'undefined') {
                        setTimeout(function () {
                            window.location.href = response.result.url
                        }, 2000);
                    }
                } else {
                    FoxUI.toast.show(response.result.message);
                    setTimeout(function () {
                        modal.reload();
                    }, 2000);
                }
            });

        });


        $('#cover,#guide').on('click', function () {
            $('#cover,#guide').css({display: 'none'});
            $(".fui-page-current").css('overflow', 'scroll');
        });

        // 点击更多,点击限流,防止出现重复数据
        var _clickTimer = null;
        // 点击函数
        var clickEvent = function () {
            var $this = $('#more');
            var pindex = $('.inner .item').length + 1;
            var id, mid;
            var queryArr = location.search.split('?').pop().split('&');
            queryArr.forEach(function (item) {
                if (item.search(/id/) === 0) {
                    id = item.split('=')[1]
                }
                if (item.search(/mid/) === 0) {
                    mid = item.split('=')[1]
                }
            });

            if(typeof mid == 'undefined') {
                mid = $('#header').data('id')
            }

            core.json('friendcoupon/more', {id: id, mid: mid, pindex: pindex}, function (response) {
                if (response.result.list.length >= 1) {
                    var list = response.result.list;
                    for (var i = 0; i < list.length; i++) {
                        var $dom = $(
                            '<div class="item">' +
                            '<img class="adver" src="' + list[i]['avatar'] + '">' +
                            '<span class="name">' + list[i]['nickname'] + '</span>' +
                            '<span>￥ ' + list[i]['deduct'] + '</span>' +
                            '</div>'
                        );
                        $('#content .item:last').after($dom)
                    }
                } else {
                    FoxUI.toast.show("已没有更多了哦");
                }


            })
        };
        $('#more').click(function () {
            clearTimeout(_clickTimer);
            _clickTimer = setTimeout(function () {
                clickEvent();
            }, 200)
        });


        core.json('friendcoupon/deadline', {id: id, mid: $('#mid').val()}, function (response) {
            var deadline = parseInt(response.result.deadline);
            var currentTime = parseInt(+(new Date()) / 1000);
            if (currentTime < deadline) {
                var timer = setInterval(function () {
                    var countDownArray = modal.countDown(deadline);

                    var day = countDownArray[0];
                    var hour = countDownArray[1];
                    var minutes = countDownArray[2];
                    var seconds = countDownArray[3];

                    $('.countDown .day').text(day);
                    $('.countDown .hour').text(hour);
                    $('.countDown .minutes').text(minutes);
                    $('.countDown .seconds').text(seconds);

                    // 倒计时结束
                    if (countDownArray === false) {
                        clearInterval(timer);
                        $('#tips_content').text('很遗憾，没有在规定时间内完成瓜分，下次要快一点哦~');
                        $('#tips').show();
                    }


                }, 1000);
            }
        });
    };

    return modal;

});