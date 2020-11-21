

//xc statistics
;!(function(window, document) {
    "use strict"
    try {
        var space = "xctj";

        // 创建队列
        window["xckj"] = space;
        window[space] = window[space] || function () {
                (window[space].list = window[space].list || new Array()).push(arguments)
            };
        window[space].time = window[space].time || 1 * new Date();

        // 创建元素
        var script = document.createElement("script");

        // 设置元素
        script.type = "text/javascript";
        script.src = "https://tj.ffquan.com/satc.js?z=20170801" ; /* 配置satc.js路径 */
        script.async = 1;

        // 添加元素
        var node = document.getElementsByTagName("script")[0];
        node.parentNode.insertBefore(script, node)
    } catch (error) { }
})(window, document);

var tid = "tid=xc-dtk-cms-"+document.getElementsByTagName("body")[0].getAttribute('data-appid'),
    instr = "in="+document.getElementsByTagName("body")[0].getAttribute('data-in');
//xc statistics 必填项
if(document.getElementsByTagName("body")[0].getAttribute('data-appid') != null){
    xctj(tid, "at=pageview","ds=wap",instr);
}

var pageR =window.location.href.split('r=').length>1?"r="+window.location.href.split('r=')[1].split('&')[0]:'noR';

for(var i = 0 ; i < coutData.length ; i++){
    if(coutData[i].page == pageR || coutData[i].page=="0"){//事件触发页面
        (function(s){
            var paramBoole =true;
            for(var a = 0 ;a < coutData[s].is_param.split(',').length ; a ++){
                var paramKey = coutData[s].is_param.split(',')[a]+"=";
                if(coutData[s].is_param.split(',')[a] != ''){
                    if( window.location.href.split(paramKey).length<2){
                        paramBoole = false;
                        return false;
                    }
                }
            }

            if(paramBoole ==false){//如果有参数，是否满足参数条件
                return false
            }

            var isData = coutData[s].is_data !=""?(($(coutData[s].page_class).data(coutData[s].is_data)!='' && $(coutData[s].page_class).data(coutData[s].is_data)!=undefined)?',"'+coutData[s].is_data+'='+$(coutData[s].page_class).data(coutData[s].is_data)+'"':''):'',//是否获取元素自定义数据
                xcStr = '"'+tid+'","ds=wap","ec='+coutData[s].page_event+'","'+instr+'"'+isData;

            if(coutData[s].is_posting_events == 0){//是否事件代理
                $(coutData[s].page_class).on(coutData[s].page_event,function(){
                    var eventName = coutData[s].is_num==1?',"ea='+coutData[s].event_name+'_'+($(this).index()+1)+'"':',"ea='+coutData[s].event_name+'"';//是否添加序号
                    eval('xctj('+xcStr+eventName+')');
                });
            }else{
                $('body').on(coutData[s].page_event,coutData[s].page_class,function(){
                    var eventName = coutData[s].is_num==1?',"ea='+coutData[s].event_name+'_'+($(this).index()+1)+'"':',"ea='+coutData[s].event_name+'"';//是否添加序号
                    eval('xctj('+xcStr+eventName+')');
                })
            }
        })(i)
    }
}



var mainTitle = '.main-title';
var cms_ua = navigator.userAgent.toLowerCase();
var isFocus = 0;

function ok(){}

$(window).scroll(function (e) {
    if(!cms_ua){
        var cms_ua = navigator.userAgent.toLowerCase();
    }
    if (cms_ua.match(/iphone/i) == "iphone" || cms_ua.match(/ipad/i) == "ipad") {
        if ($(".search_area").is(":focus") && isFocus ) {
            var y = $(document).scrollTop();
            $(document).scrollTop(y);
            $(mainTitle).css({'position': 'absolute', 'top': y});
        } else {
            $(mainTitle).css({'position': 'fixed', 'top': 0});
        }
    }
});

<!-- 首页顶部搜索自动宽 -->
var oPh = $('.search_area').attr('placeholder');
$(".search_area").focus(
    function(){
        isFocus = 1;
        if (cms_ua.match(/iphone/i) == "iphone" || cms_ua.match(/ipad/i) == "ipad") {

            if (cms_ua.match(/MicroMessenger/i) == 'micromessenger') {

                setTimeout(function(){
                    var y = $(document).scrollTop();
                    $(mainTitle).css({'position': 'absolute', 'top': y+44});
                },0);

                setTimeout(function(){
                    var y = $(document).scrollTop();
                    $(mainTitle).css({'position': 'absolute', 'top': y});
                },3000);
            }else{
                var y = $(document).scrollTop();
                $(document).scrollTop(y);
                $(mainTitle).css({'position': 'absolute', 'top': y});
            }
        }
        $('.search_submit').removeClass('search-in');
        if($('.main-back').length>0) {
            $('.search-kw').remove();
        }
        $('.search_area').attr('placeholder','');
    }
);
$(".search_area").blur(
    function(){
        isFocus = 0;
        $(mainTitle).css({'position': 'fixed', 'top': 0});
        if($('.search_area').val() == ''){
            $('.search_area').attr('placeholder',oPh);

        }
    }
);
if($('.search')){
    topSearchWid();
}
$(window).resize(function () {
    if($('.search')){
        topSearchWid();
    }
});

function topSearchWid(){
    if($('.main-back').length>0){
        var searchWid = Math.ceil($('.main-title').width())-Math.ceil($('.main-back').width())-32;
        // 搜索框宽度
        // 搜索页面搜索关键词宽度
        var inputWid = searchWid;

        $('.search_area').css('padding-left',0);
    }else{
        var riBtnwid = 0;
        for(var i = 0 ; i < $('.mui-action-menu').length ; i ++){
            riBtnwid += $('.mui-action-menu').eq(i).width();
        }
        var searchWid = Math.ceil($('.main-title').width())-Math.ceil($('.main-logo').width())-Math.ceil(riBtnwid)-42;
        var inputWid = searchWid - 32;
    }
    $('.search').width(searchWid);
    $('.search input').width(inputWid);
}


<!-- 分类栏目隐藏显示 -->

function hideCate(){
    $('#show-top-menu').css('z-index',-1);
    $('.menu-content').removeClass('show');
    $('#menu-mask').removeClass('show');
    if($('.menu-cat')){
        $('.menu-cat i').removeClass('show');
    }
}
$('.main-title').click(function(e){
    if(e.target.id == "mui-action-menu" || e.target.id == "menu-cat-btn"){
        if($('#menu-mask').hasClass('show') || $('#detail-top-menu').hasClass('show')){
            var  maskShow = 1;
        }else{
            var  maskShow = 0;
        }

        if(maskShow == 0){
            $('#show-top-menu').css('z-index',12);
            $('.menu-content').addClass('show');
            $('#menu-mask').addClass('show');
            if($('.menu-cat')){
                $('.menu-cat i').addClass('show');
            }
        }else  {
            hideCate();
        }



    }else {
        if($(this).parent().parent().find('#menu-cat')){

        }else{
            hideCate();
        }
    }
});
$('#menu-cat-btn i').click(function(){
    if($('#menu-mask').hasClass('show')){
        var  maskShow = 1;
    }else{
        var  maskShow = 0;
    }
    if(maskShow == 0){
        $('#show-top-menu').css('z-index',12);
        $('.menu-content').addClass('show');
        $('#menu-mask').addClass('show');
        if($('.menu-cat')){
            $('.menu-cat i').addClass('show');
        }
    }else  {
        hideCate();
    }
})


$('.up-menu').click(function(){
    hideCate();
});
$('#menu-mask').click(function(){
    hideCate();
});




$(document).ready(function () {
    //展开/收起 分类
    var menu = $('#show-top-meun');
    var menuHeight = $('#menu-mask').height();
    var windowHeight = $(window).height();
    $(menu).find('.mask').css('height', (menuHeight > windowHeight ? menuHeight : windowHeight) + 'px');
    $(menu).find('.menu-content').css('height', (menuHeight > windowHeight ? menuHeight : windowHeight) + 'px');

    $(window).resize(function () {
        $(menu).find('.mask').css('height', (menuHeight > windowHeight ? menuHeight : windowHeight) + 'px');
        $(menu).find('.menu-content').css('height', (menuHeight > windowHeight ? menuHeight : windowHeight) + 'px');
    });


    <!-- 返回顶部 -->
    $(window).scroll(function () {
        if ($(window).scrollTop() > 500) {
            $(".toTop").fadeIn(1500);
        }
        else {
            $(".toTop").fadeOut(1500);
        }
    });
    $('.toTop').click(function(){
        $('body,html').animate({scrollTop:0},1000);
    })
});

function setState(p){
    var list = '';
    if($('.goods-list')){
        list = $('.goods-list') ;
    }else if($('.first-list')){
        list = $('.goods-list') ;
    }else  if($('.ads-list')){
        list = $('.ads-list') ;
    }else{

    }
    var statusUrl = window.location.href;
    var stateobj = ({
        //里面存放url等信息，stateobj将作为pushState()的第一个参数
        url:statusUrl,
        list: list.html(),
        title:'',
        page: p
    });
    if(window.history.state){
        window.history.replaceState(stateobj,null,statusUrl);//将当前url加入堆栈中
    }else{
        window.history.pushState(stateobj,null,statusUrl);//将当前url加入堆栈中
    }
};

$('.main-back').click(function(){
    if(window.history.length>1){
        window.history.back();
        return false;
    }else{
        window.location.href = '/';
    }
})
function aClick(){
    $('a').click(
        function(event){
            event.preventDefault();
            if($('.goods-list')){
                var page = $('.goods-list').data('page');
            }else if($('.ads-list')){
                var page = $('.ads-list').data('page');
            }else if($('.first-list')){
                var page = $('.first-list').data('page');
            }else{
                var page = 0;
            }


            if(!$(this).hasClass('tb_app')){
                setState(page);
            }

            var cms_ua = navigator.userAgent.toLowerCase();
            if($(this).hasClass('ui-link') && cms_ua.match(/MicroMessenger/i) == 'micromessenger'){
            }else{
                window.location.href = $(this).attr('href');
            }
        }
    )
}

$('.search form').submit(function(e){
    var $title = $.trim($('.search_area').val());
    if($title=='') {
        return false;
    }
});