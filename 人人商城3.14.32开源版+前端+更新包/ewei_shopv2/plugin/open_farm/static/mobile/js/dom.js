window.onpageshow=function(e){
    if(e.persisted) {
        window.location.reload();
    }
};
$(".new").click(function () {
    $(".bg-model_new").fadeTo(300, 1);
    //隐藏窗体的滚动条
    $("body").css({"overflow": "hidden"});
});
$(".suspension").click(function () {
    if($('.integral_box').css('top')){
        setTimeout(function () {
            var top= parseInt($('.integral_box').css('height'))+parseInt($('.integral_box').css('marginTop'));
            $('.close_a').css('top',top+50+'px');
        })
    }else{
        setTimeout(function () {
            var top= parseInt($('.red_envelopes_box').css('height'))+parseInt($('.red_envelopes_box').css('top'));
            $('.close_a').css('top',top+50+'px');
        })
    }
    $(".bg-model_red").fadeTo(300, 1);
    //隐藏窗体的滚动条
    $("body").css({"overflow": "hidden"});
});
$(".friend_img").click(function () {
    $(".bg-model_friend").fadeTo(300, 1);
    //隐藏窗体的滚动条
    $("body").css({"overflow": "hidden"});
});
$(".xinqing").click(function () {
    $(".bg-model_mood").fadeTo(300, 1);
    //隐藏窗体的滚动条
    $("body").css({"overflow": "hidden"});
});

$(".presentation").click(function () {
    $(".bg-model_Presentation").fadeTo(300, 1);
    //隐藏窗体的滚动条
    $("body").css({"overflow": "hidden"});
});
$(".bank").click(function () {
    $(".bg-model_bank").fadeTo(300, 1);
    $(".front_chicken").css('display','none');
    //隐藏窗体的滚动条
    $("body").css({"overflow": "hidden"});
});
$(".collar_feed").click(function () {
    $(".bg-model_task").fadeTo(300, 1);
    //隐藏窗体的滚动条
    $("body").css({"overflow": "hidden"});
});
$(".content").click(function(event){
    return false;
});
$(".red_envelopes").click(function(event){
    return false;
});
$(".tcp_content").focus(function(){
    if($(this).val()===""){
        $(".tcp_box p").css('display','none');
    }
}).blur(function(){
    if($(this).val()===""){
        $(".tcp_box p").css('display','block');
    }else{
        $(".tcp_box p").css('display','none');
    }
});
$(".pl_tcp").click(function(){
    $(this).css('display','none');
    $(".tcp_content").focus();
});
$(".tcp_content").change(function(){
    this.value=this.value.substring(0,16);
    $(".t_h i").html($(".tcp_content").val().length);
});
$(".tcp_content").keydown(function(){
    this.value=this.value.substring(0,16);
    $(".t_h i").html($(".tcp_content").val().length);
});
$(".tcp_content").keyup(function(){
    this.value=this.value.substring(0,16);
    $(".t_h i").html($(".tcp_content").val().length);
});
//模态框OK按钮点击事件
$("body").delegate(".bg-model", "click", function () {
    $(".bg-model").hide();
    //显示窗体的滚动条
    $("body").css({"overflow": "visible"});
}).hover(function () {
    $(this).css({"backgroundColor": "#8CC8C8"});
}, function () {
    $(this).css({"backgroundColor": "#8CD4E6"});
});

$(".close_a").click(function () {
    $(".bg-model_red").hide();
    //显示窗体的滚动条
    $("body").css({"overflow": "visible"});
});
$(".Tips").click(function () {
    $(".bg-model").hide();
    //显示窗体的滚动条
    $("body").css({"overflow": "visible"});
}).hover(function () {
    $('body').css({"backgroundColor": "#8CC8C8"});
}, function () {
    $('body').css({"backgroundColor": "#8CD4E6"});
});

function isIPhoneX() {
    var u = navigator.userAgent;
    var isIOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
    if (isIOS) {
        if (screen.height === 812 && screen.width === 375) {
            //是iphoneX
            return true;
        } else {
            //不是iphoneX
            return false;
        }
    }
}
if (isIPhoneX()) {
    $(".second_forest").css({'bottom': '36.9vh'});
    $(".house_brushwood_2").css({'bottom': '40.3vh'});
    $(".house_brushwood_1").css({'bottom': '40.3vh'});
    $(".third_level").css({'bottom': '24.9vh'});
    $(" .fourth_level ").css({'bottom': '44.9vh'});
    $(".windmill").css({'bottom': '54vh', 'right': '49%'});
}
// 下蛋
var is_egg = false;
if (is_egg) {
    $(".right_chicken").css({'left': '44%', 'bottom': '16%'});
    $(".right_foot").css({'bottom': '-0.5rem'});
    $(" .right_chicken").addClass("chicken_down");
    $(" .right_foot").addClass("tui_down");
    setTimeout(function () {
        $(" .roll_egg") .removeClass('dis')
            .addClass("Lay_eggs");
    }, 500);
}
// 吃饲料动画
to_eat=function(){
    $('.fodder').css('display','block');
    $('.box').css('display','block');
    $('.front_food').css('display','block');
    $('.front_chicken-body').addClass('front_chickenbody_an before_an');
    $('.eye').addClass('eye_before');
    $('.blusher').addClass('blusher_an');
    $('.front_face').addClass('front_face_an');
    $('.front_wing-right').addClass('front_wing-right-an');
    $('.front_wing-content span').addClass('content_span_an');
    $('.front_food p').addClass('food_an');
    $('.front_mouth span').addClass('front_mouth_an');
    $('.front_mouth span:nth-child(2)').addClass('mouth_two');
    $('.front_mouth p').addClass('front_mouth_p_an');
};
// 吃完饲料动画
function xh(){
    $('.fodder').css('display','none');
    $('.box').css('display','none');
    $('.front_food').css('display','none');
    $('.front_chicken-body').removeClass('front_chickenbody_an before_an');
    $('.eye').removeClass('eye_before');
    $('.blusher').removeClass('blusher_an');
    $('.front_face').removeClass('front_face_an');
    $('.front_wing-right').removeClass('front_wing-right-an');
    $('.front_wing-content span').removeClass('content_span_an');
    $('.front_food p').removeClass('food_an');
    $('.front_mouth span').removeClass('front_mouth_an');
    $('.front_mouth span:nth-child(2)').removeClass('mouth_two');
    $('.front_mouth p').removeClass('front_mouth_p_an');
    return;
}
// 校验是不是数字
function isNumber(val){
    var regPos = /^\d+(\.\d+)?$/; //非负浮点数
    var regNeg = /^(-(([0-9]+\.[0-9]*[1-9][0-9]*)|([0-9]*[1-9][0-9]*\.[0-9]+)|([0-9]*[1-9][0-9]*)))$/; //负浮点数
    if(regPos.test(val) || regNeg.test(val)){
        return true;
    }else{
        return false;
    }
}
// 弹出提示
function showtoastFromDiv(title){
    $('.toast_div').css('display','block');
    $('.toast_div').toast({
        content:title,
        duration:1200
    });
}
$(function () {
    $('.flow_1').addClass('flow1_an');
    $('.flow_2').addClass('flow2_an');
    $('.flow_3').addClass('flow3_an');
    $('.spray').addClass('spray_an');
    $('.spray_1').addClass('spray1_an');
    $('.spray_2').addClass('spray2_an');
    $('.spray_3').addClass('spray3_an');
});
// 软键盘
var screenHeight;
if (window.innerHeight){
    screenHeight = window.innerHeight;
} else if ((document.body) && (document.body.clientHeight)){
    screenHeight = document.body.clientHeight;
}
$("html,body").height(screenHeight);
$(".bg-model_bank").height(screenHeight);
$(".container_my").height(screenHeight);
var os = function (){
    var ua = navigator.userAgent,
        isWindowsPhone = /(?:Windows Phone)/.test(ua),
        isSymbian = /(?:SymbianOS)/.test(ua) || isWindowsPhone,
        isAndroid = /(?:Android)/.test(ua),
        isFireFox = /(?:Firefox)/.test(ua),
        isChrome = /(?:Chrome|CriOS)/.test(ua),
        isTablet = /(?:iPad|PlayBook)/.test(ua) || (isAndroid && !/(?:Mobile)/.test(ua)) || (isFireFox && /(?:Tablet)/.test(ua)),
        isPhone = /(?:iPhone)/.test(ua) && !isTablet,
        isPc = !isPhone && !isAndroid && !isSymbian;
    return {
        isTablet: isTablet,
        isPhone: isPhone,
        isAndroid: isAndroid,
        isPc: isPc
    };
}();

if (os.isTablet) {
    $('.front_chicken').css('transform','scale(1.5)');
    $('.waterfall_bg').css({
        'transform':'scale(1.5)',
        'bottom': '37.6%'
    });
    $('.house').css({
        'transform':'scale(1.5) '+$('.house').css('transform'),
        'right': '4%',
        'bottom': '42.5%',
    });
    $('.Grassland_2').css('transform','scale(1.8) skew(152deg)');
    $('.Grassland_3').css('display','none');
    $('.second_forest').css({
        'transform':'scale(2)',
        'right': '35%',
        'bottom': '33.9vh',
    });
    $('.house_brushwood_item').css({
        'transform':'scale(1.5)',
        'bottom': '43vh'
    });
    $('.house_brushwood_1').css({
        'right': '15%'
    });
    $('.egg-wrapper').css({
        'left': '6%',
        'transform':'scale(1.5)'
    });
    $(' .trough').css({
        'transform':'scale(1.5)'
    });
    $(' .windmill').css({
        'bottom': '61vh',
        'transform':'scale(1.5)'
    });
    $(' .snow_mountain').css({
        'bottom': '60.5vh',
    });
    $(' .tree').css({
        'transform':'scale(1.5)'
    });
}
// 进度条
var bot =parseInt($('.front_chicken').css('height'))+parseInt($('.front_chicken').css('bottom'));
$('.box').css('bottom',bot+30+"px");


