$(function () {
    var timer, minutes, seconds, ci, qi;
    timer = parseInt(order.remainseconds) - 1;
    ci = setInterval(function () {
        minutes = parseInt(timer / 60, 10)
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        $(".minutes b").text(minutes);
        $(".seconds b").text(seconds);
        if (--timer < 0) {
            $(".qrcode .expired").removeClass("hidden");
            $(".warning").html('<a href="javascript:;" onclick="location.reload()" class="text-danger">' + addon.expiretips + '</a>').removeClass("hidden");
            clearInterval(ci);
            clearInterval(qi);
        }
    }, 1000);

    //定时查询订单状态
    var checkOrderStatus = function () {
        clearTimeout(qi);
        $.ajax({
            url: order.queryurl,
            success: function (ret) {
                if (ret.code == 1) {
                    var data = ret.data;
                    if (data.status !== 'inprogress' && data.status != 'expired') {
                        clearTimeout(ci);

                        $(".qrcode .paid").removeClass("hidden");
                        if (data.returnurl != '') {
                            $(".warning").addClass("success").html(addon.jumptips).removeClass("hidden");
                            setTimeout(function () {
                                location.href = data.returnurl;
                            }, 2000);
                        } else {
                            $(".warning").addClass("success").html(addon.successtips).removeClass("hidden");
                        }
                    } else if (data.status == 'expired') {
                        $(".qrcode .expired").removeClass("hidden");
                    } else {
                        qi = setTimeout(function () {
                            checkOrderStatus();
                        }, 3000);
                    }
                } else {
                    qi = setTimeout(function () {
                        checkOrderStatus();
                    }, 3000);
                }
            },
            error: function () {
                qi = setTimeout(function () {
                    checkOrderStatus();
                }, 3000);
            }
        })

    };

    //checkOrderStatus();

});