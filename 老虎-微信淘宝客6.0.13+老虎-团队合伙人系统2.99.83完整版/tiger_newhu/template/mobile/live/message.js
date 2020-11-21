// JavaScript Document
///获取cookie值
function getCookie(name) {
    var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
    if (arr = document.cookie.match(reg))
        return unescape(arr[2]);
    else
        return null;
}
function _getCookie(NameOfCookie) {
    // 首先我们检查下cookie是否存在.   
    // 如果不存在则document.cookie的长度为0   
    if (document.cookie.length > 0) {
        // 接着我们检查下cookie的名字是否存在于document.cookie   
        // 因为不止一个cookie值存储,所以即使document.cookie的长度不为0也不能保证我们想要的名字的cookie存在   
        //所以我们需要这一步看看是否有我们想要的cookie   
        //如果begin的变量值得到的是-1那么说明不存在   
        begin = document.cookie.indexOf(NameOfCookie + "=");
        if (begin != -1) {// 说明存在我们的cookie.    
            begin += NameOfCookie.length + 1;//cookie值的初始位置   
            end = document.cookie.indexOf(";", begin);//结束位置   
            if (end == -1)
                end = document.cookie.length;//没有;则end为字符串结束位置   
            return unescape(document.cookie.substring(begin, end));
        }
    }
    return null;
    // cookie不存在返回null   
}
var token = getCookie('user_token');
//----

var nickname = getCookie('user_nickname');
function onWebSocket() {
    websocket = new WebSocket(wsUri);
    websocket.onopen = function (evt) {
        onOpen(evt)
    };
    websocket.onclose = function (evt) {
        onClose(evt)
    };
    websocket.onmessage = function (evt) {
        onMessage(evt)
    };
    websocket.onerror = function (evt) {
        onError(evt)
    };
}

function onOpen(evt) {
    doSend('{"action":"bind","data":"' + token + '","nickname":"' + nickname + '"}');
}

function onClose(evt) {
}

function onMessage(evt) {
    data = JSON.parse(evt.data);
    action = data.action
    switch (action) {
        case "newuser":
            newuser(data);
            break;
        case "userleave":
            userleave(data);
            break;
        case "pushgoods":
            pushgoods(data);
            break;
        case "danmu":
            danmu(data);
            break;
        case "fahongbao":
            fahongbao(data);
            break;
        case "hongbaoyugao":
            hongbaoyugao(data);
            break;
    }
}

function onError(evt) {
}

function doSend(message) {
    websocket.send(message);
}

function newuser(data) {
    avatar_num = $('#avatar li').length;
    str = '<li id="fd_' + data.fd + '"><img class="headPics" src="' + data.avatar + '"/></li>';
    $('#avatar li:first').before(str);
    if (avatar_num > 30) {
        $('#avatar li:last').remove();
    }
    fc_num = parseInt($('#fc_num').html()) + 1 + parseInt(data.rand);
    $('#fc_num').html(fc_num);
}
function userleave(data) {
    $('#fd_' + data.fd).remove();
    fc_num = parseInt($('#fc_num').html()) - 1;
    $('#fc_num').html(parseInt(fc_num));
}

function pushgoods(data) {
    goods = data.goods;
    qid = parseInt($(".goods-box:last").find(".num").children("span").html()) + 1;
    //url = "http://uland.taobao.com/coupon/edetail?activityId="+goods.coupon_id+"&pid="+pid+"&itemId="+goods.num_iid+"&src=xc_xcwx";
    str = '<div class="goods-box"><div class="publishTime">' + data.time + '</div><div class="contentImg"><img class="headPic" src="' + live_head_img + '" /><a href="' + url + '&id=' + goods.goods_id + '&mode=' + goods.goods_mode + '"><img class="conPic" src="' + goods.pic_url + '" /></a></div><div class="contents"><img class="triangle" src="/Application/Home/View/theme3/statics/images/live/triangle.png" /><img class="headPic" src="' + live_head_img + '"/><p>' + goods.title + '原价' + goods.price + '元<span style="text-decoration:underline">【券后仅需' + goods.discount_price + '元】</span><br/><span style="font-weight:bold">推荐理由：</span>' + goods.introduce + '</p><div class="purchase"><a href="' + url + '&id=' + goods.goods_id + '&mode=' + goods.goods_mode + '"><div class="buy">领券购买</div></a><div class="num"><span>' + qid + '</span>号</div></div></div></div>';
    $('#content .goods-box:last').after(str);

    height = $('#scroller').height();
    trans = $('#scroller').css('transform');
    try {
        var scrollTop = Math.abs(trans.match(/-[0-9]+/)[0]);
    } catch (err) {
        var scrollTop = 0;
    }
    myScroll.refresh();
    if (height - scrollTop > 1500) {
        msg_num = parseInt($("#newgoods_notice span").html()) + 1;
        $("#newgoods_notice span").html(msg_num);
        $("#newgoods_notice").fadeIn();
    } else {
        myScroll.scrollToElement(document.querySelector('#content .goods-box:last-child'), 1000);
    }
    //$('body,html').animate({scrollTop: height}, 2000);
}

var dm_t;

function danmu(data) {
    class_name = "name" + 'data.rand';
    li_no = $(".discuss li").length + 1;
    if(encodeURI(data.user_nick)==nickname ){
         str = '<li  id="dm_li_' + li_no + '"><div><span style="color: #f7941d;" class="' + class_name + ' name-box">' + data.user_nick + '：</span><span class="msg-box">' + data.msg + '</span></div></li>';
    
    }else{
         str = '<li  id="dm_li_' + li_no + '"><div><span  class="' + class_name + ' name-box">' + data.user_nick + '：</span><span class="msg-box">' + data.msg + '</span></div></li>';
    
    }
   $('#msg_end').before(str);
    for (i = 0; i < 999; i++) {
        total = $('.discuss li').length;
        if (total > 4) {
            $('.discuss li:first').remove();
        } else {
            break;
        }
    }
    document.getElementById("msg_end").scrollIntoView();
    clearInterval(dm_t);
    dm_t = setTimeout(function () {
        $('.discuss li').fadeOut(500);
        setTimeout(function () {
            $('.discuss li').remove()
        }, 500);
    }, 15000)
}




$('#newgoods_notice').click(function () {
    $("#newgoods_notice span").html(0);
    $(this).hide();
    myScroll.scrollToElement(document.querySelector('#content .goods-box:last-child'), 1000);
});
$('.sendmsg').click(function () {
    msg_str = $('#searchKeywords').val();
    $('#searchKeywords').val("");
    dm = '{"action":"danmu","data":"' + msg_str + '"}';
    doSend(dm);
});

setTimeout(function () {
    setInterval(function () {
        heartbeat = '{"action":"heartbeat","data":"heartbeat"}';
        doSend(heartbeat);
    }, 50000);
}, 5000);


