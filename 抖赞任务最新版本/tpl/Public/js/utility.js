/**
 * Created by Administrator on 2015/7/15.
 */
Array.prototype.uniquearr = function() {
    var n = {},r=[]; //n为hash表，r为临时数组
    for(var i = 0; i < this.length; i++){//遍历当前数组
        if (!n[this[i]]){//如果hash表中没有当前项
            n[this[i]] = true; //存入hash表
            r.push(this[i]); //把当前数组的当前项push到临时数组里面
        }
    }
    return r;
};
//触发input onchange事件 例：$("input").update("values");
(function($) {
    $.fn.update = function(value){
        $(this).each(function(){
            if(value!=this.value){
                this.value = value;
                if(this.getAttribute("onchange")) {//onchange事件
                    this.onchange();
                }
            }
        });
    };
})(jQuery);
//模拟select选择框 例：$.divselect("#divselect","#inputselect");
jQuery.divselect = function(divselectid,inputselectid) {
    var inputselect = $(inputselectid);
    $(divselectid+" div").click(function(){
        var ul = $(divselectid+" ul");
        if(ul.css("display")=="none"){
            ul.slideDown("fast");
        }else{
            ul.slideUp("fast");
        }
    });
    $(divselectid+" ul li").click(function(){
        var txt = $(this).children("a").text();
        $(divselectid+" div:first").html(txt);
        var value = $(this).children("a").attr("selectid");

        //inputselect.val(value);
        //inputselect.change();
        inputselect.update(value);

        $(divselectid+" ul").hide();

        if($(this).attr("disabled") == "disabled"){
            $(divselectid+" div").unbind("click"); //移除click
        }
    });
    var sli = $(divselectid+" ul li[selected='selected']");
    if(sli.length){
        sli.click();
    }else{
        $(divselectid+" ul li:first").click();
    }
};

//验证QQ
function checkIsQQ(qq){
    var reg = /^[1-9][0-9]{4,9}$/;
    if(reg.test(qq)){
        return true;
    }else{
        return false;
    }
}
//验证邮箱
function checkEmail(email){
    var email_reg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
    //var email_reg = /^[\\w-]+(\\.[\\w-]+)*@[\\w-]+(\\.[\\w-]+)+$/;
    //var email_reg = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9_\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(email_reg.test(email)){
        return true;
    }else{
        return false;
    }
}
//验证帐号
function checkUser(account){
    /*var re = /^[a-zA-z]\w{4,19}$/;*/  /*验证规则：字母、数字、下划线组成，字母开头，5-20位。*/
    var re = /^[A-Za-z0-9]{6,20}$/; /*6到20个纯英文字母、或纯数字、或英文字母加数字的组合*/
    if(re.test(account)){
        return true;
    }else{
        return false;
    }
}
//验证规则：中文、字母或数字，且长度是1到10个字
function checkCWN(value){
    var reg = /^(\w|[\u4E00-\u9FA5]){1,10}$/;
    if(value.match(reg)) {
        return true;
    } else {
        return false;
    }
}
//验证手机号码
function checkMobile(mobile) {
    var re = /^1\d{10}$/;
    if (re.test(mobile)) {
        return true;
    } else {
        return false;
    }
}
//验证电话号码
function checkPhone(phone){
    var re = /^0\d{2,3}-?\d{7,8}$/;
    if(re.test(phone)){
        return true;
    }else{
        return false;
    }
}

/**
 * 优化弹窗效果
 * @param arguments[0] string ： 弹出内容信息
 * @param arguments[1] string|int ： 弹出框标题，或秒数
 * @param arguments[2] string ：弹出框确定按钮，或提示n秒后关闭/跳转【arguments[1]为数字】
 * @example
 * yz_alerts('更新成功', 5);    5秒钟后自动关闭弹窗
 * yz_alerts('更新成功', 5, 'http://baidu.com');    5秒钟后自动跳转到百度首页
 */
function yz_alerts_old() {
    var content = arguments[0] ? arguments[0] : '成功';
    var title = arguments[1] ? arguments[1] : '提示';
    var btnText = arguments[2] ? arguments[2] : '';

    var second_str = "";
    var sure_btn_str = "";
    if(typeof(arguments[1]) == "number"){
        var link_text = (btnText == '') ? '关闭' : '<a href="'+ btnText +'">跳转</a>';
        second_str = '<tr><td class="alerts_sure_td"><span id="alerts_second">'+ title +'</span>秒后自动'+ link_text +'</td></tr>';
        title = '温馨提示';
    }else{
        btnText = (btnText != '') ? btnText : '确定';
        sure_btn_str = '<div class="alerts_sure_btn_box"><button type="button" class="alerts_sure_btn" onclick="yz_close_alerts()">'+ btnText +'</button></div>';
    }
    var tem_html = '<div id="yz_alerts_box" class="tips">'+
        '<div class="Mdown" onmousedown="yz_move_alerts(this)" ondblclick="yz_close_alerts()">'+ title +
        /*'<span class="closeit" title="close" onclick="yz_close_alerts()">X</span>'+*/
        '</div>'+
        '<div class="tipsContents">'+
        /*'<form method="post" action="" class="form-inline">'+*/
        '<table border="0" cellspacing="0" cellpadding="0" summary="" class="alerts_box_table">'+
        '<tr><td class="alerts_sure_td">'+ content +'</td></tr>'+ second_str +
        '</table>'+ sure_btn_str +
        /*'</form>'+*/
        '</div>'+
        '</div><div id="alerts_info_mask"></div>';
    $("#alerts_info_mask,#yz_alerts_box").remove();
    $("body").append(tem_html);
    $("#yz_alerts_box").center();
    $("#alerts_info_mask").css({"height":$(document).height()}).show();
    $("#alerts_info_mask,#yz_alerts_box").show();

    if(typeof(arguments[1]) == "number" && arguments[1] == 0){
        if(btnText != ""){
            location.href = btnText;
        }else {
            yz_close_alerts();
        }
    }
    if(second_str != ""){
        timer = setInterval(function(){do_alerts_act(btnText);},1000);
    }
}

/**
 * 提示信息
 * icon -
 success          成功
 failure            失败
 illegal             警告
 laugh             笑脸
 nuber_500     500
 nuber_404     404
 */
function yz_alerts() {
    var content = arguments[0] ? arguments[0] : '成功';/*第一个参数：主要提示信息*/
    var text_font = content.length > 9 ? "text_2" : "text_1";

    if(typeof(arguments[1]) == "number"){/*成功处理提示框  exam：yz_alerts("成功",0); yz_alerts("成功",0,"/index.php"); yz_alerts("成功",3,"/index.php");*/
        var icon = arguments[4] ? arguments[4] : 'success';/*第五个参数 图标*/
        var seconds = parseInt(arguments[1]);/*第二个参数：秒数*/
        var link_url = arguments[2] ? arguments[2] : '';/*第三个参数：链接地址*/
        /*第四个参数：其他描述信息*/
        var msg_info = arguments[3] ?
            (seconds > 0 ? '<div class="text_2">'+ arguments[3] +'，<span id="alerts_second">'+ seconds +'</span>秒后自动跳转</div>' : '<div class="text_2">'+ arguments[3] +'</div>') :
            (seconds > 0 ? '<div class="text_2"><span id="alerts_second">'+ seconds +'</span>秒后自动跳转</div>' : "");

        var link_text = (link_url != "") ? 'href="'+ link_url +'"' : 'onclick="$(\'.prompt_bk,.prompt_bomb\').remove();"';

        var tem_html = '<div class="prompt_bomb">'+
            '<div class="ico '+icon+'"></div>'+
            '<div class="'+ text_font +'">'+ content +'</div>'+ msg_info +
            '<a class="button_1" '+ link_text +'>确定</a>'+
            '</div><div class="prompt_bk"></div>';
        $(".prompt_bk,.prompt_bomb").remove();
        $("body").append(tem_html);

        if(seconds > 0){
            timer = setInterval(function(){
                var s = $("#alerts_second").html();
                s = parseInt(s) - 1;
                $("#alerts_second").html( s );
                if(s == 0){
                    clearInterval(timer);
                    if(link_url != ""){
                        location.href = link_url;
                    }else {
                        $(".prompt_bk,.prompt_bomb").remove();
                    }
                }
            },1000);
        }
    }else{/*普通错误提示框（无跳转链接*  exam：yz_alerts("字段为空");yz_alerts("提交成功","失败原因失败原因失败原因");*/
        var msg_info = arguments[1] ? '<div class="text_2">'+ arguments[1] +'</div>' : '';//错误描述
        var icon = arguments[2] ? arguments[2] : 'illegal';/*第三个参数 图标  failure*/
        var link = arguments[3] ? 'href="'+arguments[3]+'"' : 'onclick="$(\'.prompt_bk,.prompt_bomb\').remove();"';/*第四个参数 调整链接*/
        var btnText = arguments[4] ? arguments[4] : '确定';/*第四个参数 调整链接*/
        var tem_html = '<div class="prompt_bomb">'+
            '<div class="ico '+ icon +'"></div>'+
            '<div class="'+ text_font +'">'+ content +'</div>'+ msg_info +
            '<a class="button_1" '+ link +'>'+btnText+'</a>'+
            '</div><div class="prompt_bk"></div>';
        $(".prompt_bk,.prompt_bomb").remove();
        $("body").append(tem_html);
    }
}
//n秒后自动关闭或跳转link
function do_alerts_act(link){
    var s = $("#alerts_second").html();
    s = parseInt(s) - 1;
    console.log(s);
    $("#alerts_second").html( s );
    if(s == 0){
        clearInterval(timer);
        if(link != ""){
            location.href = link;
        }else {
            yz_close_alerts();
        }
    }
}


function dashang(t)
{
    var post_id = parseInt($(t).attr('data-post_id'));
    var chapter_id = parseInt($(t).attr('data-chapter_id'));
    var price = $(t).attr('data-price');
    if( price == '' || price == 0 ) {
        price = '2,5';
    }
    var prices = price.split(',');
    if( prices.length == 1 ) {
        //如果只有一个价格，直接跳转
        window.location.href = '/index.php/Home/Contribution/pay/post_id/'+post_id+'/chapter_id/'+chapter_id+'/price/'+prices[0];
    } else {
        var _price_html = '';
        for( var i = 0; i < prices.length; i++ ) {
            _price_html += '<a href="/index.php/Home/Contribution/pay/post_id/'+post_id+'/chapter_id/'+chapter_id+'/price/'+prices[i]+'">'+prices[i]+'</a>';
        }
        var form_html = '<form class="Comment_form" action="" method="post">' +
            '<div class="title" style="margin-top: 10px; ">打赏金额(元)</div>' +
            '<dt class="contribution_prices">' + _price_html +
            '</dt>' +
            '</form>';

        var html = '<div class="prompt_bomb" id="dashang_form">'+
            '<div>'+ form_html +'<br><br></div>' +
            '</div><div class="prompt_bk" id="dashang_close" onclick="dashang_c();"></div>';
        $("body").append(html);
    }

}
function dashang_c(){
    $('#dashang_close').remove();
    $('#dashang_form').remove();
}


jQuery.fn.center = function () {
    this.css("position","absolute");
    this.css("top", ( $(window).height() - this.height() ) / 2+$(window).scrollTop() + "px");
    this.css("left", ( $(window).width() - this.width() ) / 2+$(window).scrollLeft() + "px");
    return this;
};
function yz_move_alerts(ts) {
    window.getSelection ? window.getSelection().removeAllRanges() : document.selection.empty();//禁止拖放对象文本被选择
    var obx = $(ts).parent(".tips");
    var IsMousedown = true;
    var e = e||event;
    var LET = e.clientX - obx.offset().left;
    var TOP = e.clientY - obx.offset().top;
    $(document).mousemove(function(e) {
        if (IsMousedown) {
            e = e||event;
            var _x = e.clientX - LET;
            var _y = e.clientY - TOP;
            obx.offset({ left: _x, top: _y });
        }
    });
    $(document).mouseup(function(){
        IsMousedown = false;
    });
}
function yz_close_alerts(){
    $("#alerts_info_mask,.tips").remove();
}


/**
 * 锁定屏幕，显示加载中
 */
var is_lock = false;
function yz_lock() {
    if( is_lock == true ) {
        return false;
    }
    is_lock = true;
    var popu = document.createElement("div");
    popu.setAttribute('id','yz_lock');
    popu.innerHTML = '<div class="loading"></div><div id="shadow_bg"></div>';
    document.body.appendChild(popu);
}
/**
 * 解锁屏幕
 */
function yz_unlock(){
    is_lock = false;
    $('#yz_lock').remove();
}

/**
 * 删除左右两端的空格
 * @param str
 * @returns {XML|string|void}
 */
function yz_trim(str){
    return str.replace(/(^\s*)|(\s*$)/g, "");
}
/**
 * 去掉html注释符
 * @param str
 */
function yz_cut_notes(str){
    str = yz_trim(str);

    var s = '<!--';
    var reg = new RegExp("("+s+")","g");
    var newstr = str.replace(reg,"");

    s = '-->';
    reg = new RegExp("("+s+")","g");
    newstr = newstr.replace(reg,"");

    return newstr;
}

/**
 * 某些情况下代替 <a> 标签
 * @param url
 */
function yz_gourl(url) {
    window.location.href = url;
}

/**
 * 将时间戳转成日期
 * @param unix_time 时间戳
 * @returns {string}
 */
function yz_time2str (unix_time) {
    var date;
    var newDate = new Date();
    newDate.setTime(unix_time * 1000);
    date = newDate.toLocaleDateString(); //toLocaleString 获取到时分秒
    return date;
}

function yz_is_confirm(){
    // 关闭或退出窗口时弹出确认提示
    $(window).bind('beforeunload', function(){
        // 只有在标识变量is_confirm不为false时，才弹出确认提示
        if(window.is_confirm !== false) {
            return '您的内容尚未保存，确定要退出吗？';
        }
    });
}

function edit_confirm(){
    $("#back").attr("data-confirm","您的内容尚未保存，确定要退出吗？");
}

/**
 * 模拟thinkphp U方法
 * @param url exp:Home/Controller/Action
 * @param params array
 * @returns {string}
 * @constructor
 */
function yz_u(url, params) {
    var website = '/index.php';
    url = url.split('/');
    website = website+'?m='+url[0]+'&c='+url[1]+'&a='+url[2];
    if(params) {
        params = params.join('&');
        website = website + '&' + params;
    }
    return website;
}
/**
 * 用JS实现PHP的sprintf函数
 * @returns {*|string}
 */
function yz_sprintf(){
    var arg = arguments,
        str = arg[0] || '',
        i, n;
    for (i = 1, n = arg.length; i < n; i++) {
        str = str.replace(/%s/, arg[i]);
    }
    return str;
}
/**
 * 用JS实现PHP的sprintf函数
 * @returns {*|string}
 */
function yz_replace_str(){
    var arg = arguments,
        str = arg[0] || '',
        data = arg[1] || [],
        x;
    for (x in data) {
        str = str.replace(new RegExp('{%' + x + '%}', 'g'), data[x]);
        //console.log("X:" + x + " > D:" + data[x]);
    }
    return str;
}
/**
 * 异步访问页面，或提交数据
 * @param url ：访问或提交的路径
 * 有第三个参数则是回调函数
 */
function yz_ajax_page(url){
    var param = arguments[1] ? arguments[1] : "";//传参，默认无
    var type = (arguments[2] && arguments[2]=="post") ? arguments[2] : 'GET';//请求方式，默认get
    var callback = arguments[3] ? arguments[3] : false;//回调函数，默认无
    var page_html;
    $.ajax({
        type: type,
        url: url,
        data: param,/*"id=12&type=1",*/ /*{"param1":param1,"param2":param2},*/
        success: function(result, textstatus){
            if(callback){
                callback(result);
            }else{
                page_html = result;
            }
        },
        error: function(err){
            console.log(err);
            yz_alerts('请求出错处理！');
        },
        dataType: "html"
        ,async:false
    });
    return page_html;
}
/**
 * 异步访问页面，或提交数据
 * @param url ：访问或提交的路径
 * 有第二个参数则是回调函数
 */
function yz_ajax(url){
    if( yz_lock() === false ) return false;
    var param = arguments[1] ? arguments[1] : "";//传参，默认无
    var callback = arguments[2] ? arguments[2] : false;//回调函数，默认无
    var type = (arguments[3] && arguments[3]=="post") ? arguments[3] : 'GET';//请求方式，默认get
    var async = typeof(arguments[4]) == "boolean" ? arguments[4] : true;//请求方式，默认true
    $.ajax({
        type: type,
        url: url,
        data: param,/*"id=12&type=1",*/ /*{"param1":param1,"param2":param2},*/
        success: function(result){
            console.log(result);
            if(result.status) {
                if(callback){
                    callback(result);
                }else{
                    yz_alerts(result.info,3,result.url);
                }
            }else{
                yz_alerts(result.info,'','',result.url);
            }
            yz_unlock();
        },
        error: function(){
            yz_unlock();
            yz_alerts('请求出错处理！');
        },
        dataType: "json",
        async:async
    });
}

/**
 *
 * 获取模板并对应替换数据，最终获得HTML模板
 * @param d array : 数据数组
 * @param template_obj_id string : 模板所在标签的id
 *
 *      数据数组的顺序 与 模板中要替换的的替换变量（%s）的顺序 一致
 * @returns {*|string}
 */
function yz_sub_roast_html(d,template_obj_id){
    var template_html = yz_cut_notes($("#" + template_obj_id).html());
    /*d.unshift(template_html); // 添加到第一个位置
     var list_html = yz_sprintf.apply(this, d);*/
    var list_html = yz_replace_str(template_html,d);
    return list_html;
}

/**
 * 异步追加数据列表通用函数
 * @param more_params array 参数包含 :
 *      var arr = new Array(7);
 *      arr["get_more_url"] = rl_get_more_url;//请求追加数据的链接地址
 *      arr["is_btn_click_n"] = parseInt("{$is_rl_btn_click_n}");//吐槽列表是否需要 点击加载按钮is_btn_click_n次后跳转到相关页面 的功能
 *      arr["btn_click_n"] = 0;//统计吐槽列表加载按钮点击了几次
 *      arr["dump_self_lk"] = yz_u('Home/Entry/roast_list',['entry_id='+entry_id]);//点击加载按钮is_btn_click_n次后跳转到相关页面的链接地址
 *      arr["data"] = {"g_m":rl_per_num,"g_n":rl_per_add_n,"entry_id":entry_id};//提交的数据；//index_m：当前已读取显示的数据记录数  从第index_m+1条开始，取number_n条 //number_n：当前已读取显示的数据记录数   从第index_m+1条开始，取number_n条
 * @param template_obj_id string : 获取模板的（模板所在标签的id
 * @param insert_before_obj_id string : 在此标签id前插入数据
 * @returns {boolean}
 */
function yz_get_more_list(more_params,template_obj_id,insert_before_obj_id){

    var obj_btn_id,insert_before_id;
    if(typeof(insert_before_obj_id) == "object"){
        obj_btn_id = insert_before_obj_id.obj_btn_id;//加载更多按钮id
        insert_before_id = insert_before_obj_id.insert_before_id;//此id上面插入数据
    }else{
        obj_btn_id = insert_before_id = insert_before_obj_id;
    }

    var empty_tips = arguments[3] ? arguments[3] : "";

    yz_lock();
    if( more_params['is_btn_click_n'] == undefined ) more_params['is_btn_click_n'] = 0;
    if( more_params['btn_click_n'] == undefined ) more_params['btn_click_n'] = 0;

    if( more_params['is_btn_click_n'] > 0 && more_params['btn_click_n'] >= (more_params['is_btn_click_n'] - 1) ) {
        yz_unlock();
        yz_gourl(more_params['dump_self_lk']);return false;
    }
    $.ajax({
        type: "POST",
        url: more_params['get_more_url'],
        data: more_params['data'],
        success: function(result){
            console.log(result);
            if(result.status) {

                //console.log(more_params['data'].index_m);

                if(result.data && result.data.length > 0) {
                    var lgh = result.data.length;
                    var list_html = "";
                    for (var i = 0; i < lgh; i++) {
                        list_html += yz_sub_roast_html(result.data[i],template_obj_id);
                    }
                    $(list_html).insertBefore("#" + insert_before_id);

                    //左右宽度
                    var item_db = $('.item_db').width();
                    var width_le = $('.width_le').width();
                    width_le = parseFloat(width_le) + 10;
                    item_db =  parseFloat(item_db) - width_le;
                    $('.width_f').css("width",item_db<0 ? 0 : item_db);


                    more_params['data'].index_m += more_params['data'].number_n;
                    if( more_params['is_btn_click_n'] > 0 ) {
                        more_params['btn_click_n'] += 1;
                    }
                    yz_init_star();
                    if(more_params['count_total_num'] && more_params['data'].index_m >= more_params['count_total_num']){
                        if(typeof(empty_tips) == "object"){
                            $("#"+obj_btn_id).attr(empty_tips.attr_name,empty_tips.attr_value).html(empty_tips.text);//都加载完后，给 加载更多按钮 添加属性、改变 加载更多按钮 的文字
                        }else{
                            $("#" + obj_btn_id).html(empty_tips);
                        }
                    }
                }else{
                    if(typeof(empty_tips) == "object"){
                        $("#"+obj_btn_id).attr(empty_tips.attr_name,empty_tips.attr_value).html(empty_tips.text);//都加载完后，给 加载更多按钮 添加属性、改变 加载更多按钮 的文字
                    }else{
                        $("#" + obj_btn_id).html(empty_tips);
                    }
                }
            }else{
                yz_alerts(result.info);
            }
            yz_unlock();
        },
        error: function(){
            yz_unlock();
            yz_alerts('请求出错处理！');
        },
        dataType: "json"
    });
}
/**
 * 图片/文件 上传函数
 * @param upload_url    服务器上传地址
 * @param form_id       表单ID
 * @param set_value_id  接受图片/文件上传后返回结果的对象
 */
function yz_upload_file(files, upload_url, form_id, set_value_id ) {
    //回调函数，默认无
    var callback = arguments[4] ? arguments[4] : false;

    //弹出显示上传进度的层
    var popHtml = '<div class="prompt_bk"></div>' +
        '<div class="prompt_bomb">' +
        '<div class="canvas canvas_t">' +
        '<div class="prg-cont rad-prg" id="indicatorContainerWap"></div>' +
        '</div>' +
        '<div class="text_3">正在上传，请稍后 :）</div>' +
        '<div class="text_3">成功后自动关闭，如上传失败<a href=javascript:$(".prompt_bk").remove();$(".prompt_bomb").remove();>点击这里</a></div>' +
        '</div>';
    $("body").append(popHtml);

    //初始化百分比圆
    var container6Prog = $('#indicatorContainerWap').radialIndicator({
        radius: 80,
        percentage: true,
        displayNumber: true
    }).data('radialIndicator');

    // 获取目前上传的文件
    var URL = window.URL || window.webkitURL;
    // 通过 file 生成目标 url
    var imgURL = URL.createObjectURL(files);
    //创建图片对象;
    var img = new Image();
    img.src = imgURL;
    img.onload = function(){
        var width = img.width;
        if( width > 640 ) width = 640;
        lrz(files, {width:width}, function (lrz_results) {
            console.log(lrz_results);
            $("#base64").val(lrz_results.base64); //将生成的base64图片编码加入表单
            /* AJAX File upload Progress */
            var options = {
                //向服务器发送请求前执行一些动作
                beforeSend: function() {
                },
                //监听上传进度
                uploadProgress: function(event, position, total, percentComplete) {
                    container6Prog.animate(percentComplete);
                    if( percentComplete == 100 ) {
                        //上传完成，关闭弹出层
                        $('.prompt_bk').remove();
                        $('.prompt_bomb').remove();
                    }
                },
                url: upload_url,
                dataType:'json',
                success: function (result) {
                    if( result.status == 1 ) {
                        if( callback ) {
                            //执行回调函数
                            callback(result);
                        } else {
                            $('#' + set_value_id).val(result.data);
                        }
                    } else {
                        yz_alerts(result.data);
                    }
                },
                error: function (result) {
                    yz_alerts('上传出错');
                    console.log(result);
                }
            };
            $('#' + form_id).ajaxSubmit(options);

        })
        // 释放内存中 url 的伺服, 使之无效
        URL.revokeObjectURL(imgURL);
    }
}


/**
 * 图片上传函数
 * @param files         文件表单object
 * @param upload_url    服务器路径
 * @param formID       表单ID
 * @param ProcessID         进程ID，当一个页面多次调用此函数时，以此ID区别回调函数要处理的对象,结果集原样返回
 * @param callback      上传成功后回调函数
 * arguments[6]         返回当前上传进度百分比
 * arguments[7]         返回上传前的内存图片地址
 */
function yz_upload_base64image(files, upload_url, formID, inputID, ProcessID, callback ) {
    //回调返回当前上传进度
    var callPercent = arguments[6] ? arguments[6] : false;
    //回调返回上传前的内存图片地址
    var callBefore = arguments[7] ? arguments[7] : false;
    // 获取目前上传的文件
    var URL = window.URL || window.webkitURL;
    // 通过 file 生成目标 url

    //判断上传文件格式
    var type = files.type.toLowerCase();
    if( type != 'image/png' && type != 'image/jpg' && type != 'image/jpeg' && type != 'image/bmp' ) {
        var result = new Object();
        result.ProcessID = ProcessID;
        result.info = '只支持jpg、jpeg、png、bmp格式的图片';
        callback(result);
        return false;
    }

    var imgURL = URL.createObjectURL(files);
    //创建图片对象;
    var img = new Image();
    img.src = imgURL;
    img.onload = function(){
        var width = img.width;
        if( width > 640 ) width = 640;
        //使用lrz插件压缩图片成base64编码
        lrz(files, {width:width}, function (lrz_results) {

            $("#"+inputID).val(lrz_results.base64); //将生成的base64图片编码加入表单
            /* AJAX File upload Progress */
            var options = {
                //向服务器发送请求前执行一些动作
                beforeSend: function() {
                    if(callBefore) callBefore(imgURL);
                },
                //监听上传进度
                uploadProgress: function(event, position, total, percentComplete) {
                    if(callPercent) callPercent(percentComplete);
                },
                url: upload_url,
                dataType:'json',
                success: function (result) {
                    result.ProcessID = ProcessID;
                    //执行回调函数
                    callback(result);

                    //释放内存中 url 的伺服, 使之无效
                    URL.revokeObjectURL(imgURL);
                },
                error: function (result) {
                    console.log(result);
                    result.ProcessID = ProcessID;
                    result.info = '网络错误';
                    //释放内存中 url 的伺服, 使之无效
                    URL.revokeObjectURL(imgURL);
                    callback(result);
                }
            };
            $('#' + formID).ajaxSubmit(options);

        });

    }

}




//发送短信验证码
var timer = 0;
function sendVerify(ts){
    var url = sms_url;
    var mobilephone = $("input[name='user_mobilephone']").val();
    var __hash__ = $("input[name=__hash__]").val();
    if( mobilephone == '' ) {
        yz_alerts('请输入手机号码!');
        return false;
    }
    if(!checkMobile(mobilephone)) {
        yz_alerts('请输入有效的手机号码！');
        return false;
    }
    var obj = $(ts);
    var seconds = obj.attr("scs");

    obj.attr("disabled","disabled");
    clearInterval(timer);
    timer = setInterval(function(){doAct(obj,seconds);},1000);
    $("input[name='user_mobilephone']").attr("readonly","readonly");//发送验证码后不让修改手机号
    var type = arguments[1] ? arguments[1] : 0;
    $.get(url,{mobilephone:mobilephone,type:type, __hash__:__hash__}, function(data){
        //console.log(data);
        if( data.status == 1 ) {
        } else {
            yz_alerts(data.msg);
        }
    },'jsonp');
}

//n秒后可以重发短信验证码
function doAct(obj,seconds){
    var s = obj.attr("scs");
    s = parseInt(s) - 1;
    obj.attr("scs",s);
    obj.attr("id","fontsize").html( s + " 秒后可重发");
    if(s == 0){
        clearInterval(timer);
        timer = 0;
        obj.attr("scs",seconds);
        obj.removeAttr("id").html("获取短信验证码");
        obj.attr("disabled",false);
    }
}

//添加用户标签
function tags(tagname){
    var obj = $("input[name='tag']");
    var tag = obj.val() + " " + tagname;
    var ret = splitStr(tag);
    var lg = ret.length;
    var str = "";
    for(var i = 0;i < lg;i++){
        str += ret[i] + " ";
    }
    obj.val(str);
    console.log(str);
    //canInputTagNum();
}
//以空格分割字符串
function splitStr(str){
    var ret = str.split(/\s+/);
    ret = ret.uniquearr();
    return ret;
}

/**
 * 检测标签
 * @param str
 * @param max_num 标签个数
 * @param tag_len 单个标签长度
 * @returns {boolean}
 */
function checkTag(str, max_num, tag_len){
    //var str = "test1   \t 获取 test2 test3 获取短信验证码 获取 短信验证码 test2";
    var ret = splitStr(str);
    var lg = ret.length;
    if(lg > max_num){
        yz_alerts("不能超过"+max_num+"个标签！");
        return false;
    }
    for(var i = 0;i < lg;i++){
        //console.log(ret[i].length + "|" + ret[i]);
        if(ret[i].length > tag_len){
            yz_alerts("标签之间以空格隔开，每个标签最多"+tag_len+"个字！");
            return false;
        }
    }
    return true;
}
/**
 * 剩余可输入标签数
 * @param name ：输入框ID  <textarea id="desc" onkeyup="inputNum('desc', 'introNum');"></textarea>
 * @param id ：提示文字中的字数数字所在标签ID  如 ：<span>剩余可输入<b id="introNum">120</b>个字</span>
 */
function inputNum(name,id){
    var obj = $("#"+id);
    var cin = obj.attr("cin");//可以输入限制字数
    if(parseInt(cin) > -1){
    }else{
        cin = obj.html();
        obj.attr("cin", cin);
    }
    var input_obj = $("#" + name);
    var d = input_obj.val().length;
    var n = parseInt(cin) - d;
    if(n > -1){
        obj.html(n);
    }else{
        var val = input_obj.val().substring(0, cin);
        input_obj.val(val);
    }
}
/**
 * 剩余可输入标签数
 * @param ue 百度编辑器
 * @param id ：提示文字中的字数数字所在标签ID  如 ：<span>剩余可输入<b id="introNum">120</b>个字</span>
 */
function editorInputNum(ue,id){
    var obj = $("#"+id);
    var cin = obj.attr("cin");//可以输入限制字数
    if(parseInt(cin) > -1){
    }else{
        cin = obj.html();
        obj.attr("cin", cin);
    }
    var d = ue_get_content_txt(ue).length;
    var n = parseInt(cin) - d;
    if(n > -1){
        obj.html(n);
    }
}
function ue_get_content(ue) {
    window.txt = "";
    ue.ready(function () {
        window.txt = ue.getContent();
    });
    return window.txt;
}
function ue_get_content_txt(ue) {
    window.txt = "";
    ue.ready(function () {
        window.txt = ue.getContentTxt();
    });
    return window.txt;
}

/**
 * 鼠标焦点定位在文字后面
 */
function yz_focus_on_text_footer(id, t) {
    var obj = document.getElementById(id);

    var reply_name = t.getAttribute("data-reply");
    var reply_id = t.getAttribute("data-id");
    document.getElementById('rpu_user_id').value = reply_id;
    obj.value = reply_name;
    obj.focus();
    var len = obj.value.length;
    if (document.selection) {
        var sel = obj.createTextRange();
        sel.moveStart('character', len);
        sel.collapse();
        sel.select();
    } else if (typeof obj.selectionStart == 'number'
        && typeof obj.selectionEnd == 'number') {
        obj.selectionStart = obj.selectionEnd = len;
    }
}
/**
 * 字符串长度（一个英文字符算一个字符，一个中文字符算两个字符计算
 * @param str
 * @returns {number}
 */
function myStrLen(str) {
    var myLen = 0;
    for (var i = 0; i < str.length; i++) {
        if (str.charCodeAt(i) > 0 && str.charCodeAt(i) < 128)
            myLen++;
        else
            myLen += 2;
    }
    return myLen;
}
/**
 * 添加标签
 <span>
 <input id="input_lable" name="" type="text" />
 <input type="button" onclick='' value="添加" />
 </span>


 <div style="display: none;" id="increase_lable_box">
 <div id="increase_lable_here">
 </div>
 </div>
 =>incRease(["input_lable","increase_lable_box","increase_lable_here"], 10, 10);
 或
 <div style="display: none;" id="increase_lable_here">
 </div>
 =>incRease(["input_lable","increase_lable_here","increase_lable_here"], 10, 10);

 * @param obj_ids array : 0=>输入标签input的id，1=>显示标签的容器id，2=>插入标签的容器id
 * @param max_num 标签个数
 * @param tag_len 单个标签最大字符数
 */
function incRease(obj_ids, max_num, tag_len){
    var act_tags = arguments[3] ? arguments[3] : "";//活动标签
    //id约定
    var input_id_obj = $("#"+obj_ids[0]);
    var show_obj = $("#"+obj_ids[1]);
    var insert_id = obj_ids[2];
    var tags_input_name = obj_ids[3]+"[]";

    var text_input = input_id_obj.val().replace(/(^\s*)|(\s*$)/g, ""); //获取输入框值并去掉左右两边空格
    if( text_input == '') return false;
    show_obj.show();
    //判断输入一样时
    var systems = $("#"+insert_id+" .system");
    var tag_nums = systems.length;
    for(var i=0; i < tag_nums; i++) {
        if(text_input == systems.eq(i).html()){
            return false;
        }
    }
    if(tag_nums >= max_num){
        yz_alerts("已经有"+max_num+"个标签，不能再多了！");
        return false;
    }
    if(myStrLen(text_input) > tag_len){
    //if(text_input.length > tag_len){
        yz_alerts("每个标签最多"+ (tag_len/2) +"个汉字！");
        return false;
    }
    var act = "";//活动标签class样式
    for (x in act_tags) {
        var act_tag = act_tags[x];
        if(act_tag == text_input){
            act = " activity act";
        }
    }
    var system_html = "<span class='form'><a href='#' class='lable system "+ act +"'>" + text_input + "</a><i title='关闭'></i><input name=\"" + tags_input_name + "\" type=\"hidden\" value=\"" + text_input + "\"/></span>"; //要添加html
    $("#"+insert_id).append(system_html);
    input_id_obj.val('');
    //删除
    $("#"+insert_id+" .form i").click(function(){
        $(this).parent(".form").remove();
    });
}
/**
 * 删除标签
 * @param tags_input_name
 * @param tag_name
 */
function removeTag(tags_input_name, tag_name) {
    $("input[name='"+tags_input_name+"'][value='"+tag_name+"']").prev("i").click();
}
/**
 * 在TextArea回车时多加一个\n换行
 * exam ：<textarea onkeyup="textarea_br(this,event);"></textarea>
 */
function textarea_br(th,e){
    if (e.keyCode == "13") {
        var str = "\n";
        insertText(th,str);
        return false;
    }
}
/**
 * 在TextArea不允许回车，即不能换行
 * exam ：<textarea onkeyup="textarea_can_not_enter(this,event);"></textarea>
 */
function textarea_can_not_enter(th,e){
    if (e.keyCode == "13") {
        e.preventDefault();
        return false;
    }
}
/**
 * 在TextArea光标位置插入文字
 * @param obj
 * @param str
 */
function insertText(obj,str) {
    if (document.selection) {
        var sel = document.selection.createRange();
        sel.text = str;
    } else if (typeof obj.selectionStart === 'number' && typeof obj.selectionEnd === 'number') {
        var startPos = obj.selectionStart,
            endPos = obj.selectionEnd,
            cursorPos = startPos,
            tmpStr = obj.value;
        obj.value = tmpStr.substring(0, startPos) + str + tmpStr.substring(endPos, tmpStr.length);
        cursorPos += str.length;
        obj.selectionStart = obj.selectionEnd = cursorPos;
    } else {
        obj.value += str;
    }
}
/**
 * 检测是否超过最大上传图片限制的数量，或返回已经上传的好了的数量
 * @param input_str_name
 * @returns {*}
 */
function is_over_max_upload_img(input_str_name){
    var is_return_num = arguments[1] ? arguments[1] : "";//是否返回已上传数量
    var photos = $('form input[name='+ input_str_name +']').val();
    var num = (photos != "") ? photos.split(',') : [];
    if(typeof(is_return_num) == "boolean" && is_return_num == true){
        return num.length;
    }
    if (num.length > 20) {
        yz_alerts('最多只能上传20张图片');
        return true;
    }
    return false;
}
/**
 * 图片按比例缩放
 * @param _this_img ：原始图片对象 如：<img src="..." onclick="ratio_img(this, 160, 235)"/>
 * @param w ：要缩放成的宽度
 * @param h ：要缩放成的高度
 */
function ratio_img(_this_img,w,h) {
    console.log($(_this_img).attr("src"));
    var img_w = $(_this_img).width();
    var img_h = $(_this_img).height();
    console.log(img_w+"|"+img_h);
    var new_h = parseInt((w*img_h)/img_w);/*以宽为准按比例缩放*/
    if(new_h > h){
        $(_this_img).width(w);
        $(_this_img).height(new_h);
        var mar_top = -(new_h - h)/2;
        $(_this_img).css('margin-top', mar_top );
        console.log("mar_top:"+mar_top);
    }else if(new_h < h){
        var new_w = parseInt((h*img_w)/img_h);/*以高为准按比例缩放*/
        var mar_left = -(new_w - w)/2;
        $(_this_img).width(new_w);
        $(_this_img).height(h);
        $(_this_img).css('margin-left', mar_left );
        console.log("mar_left:"+mar_left);
    }else{
        $(_this_img).width(w);
        $(_this_img).height(h);
    }
    console.log($(_this_img).width()+"|"+$(_this_img).height());
}
function img_ratio_init() {
    var type = arguments[0] ? arguments[0] : 0;/*图片按比例缩放的比例类型*/
    if(type == 1 || type == 0){
        $("img.mem_sub_img").each(function(){
            var img = new Image();
            img.src = $(this).attr("src");
            img.onload = ratio_img(this, 160, 235);
        });
    }
    if(type == 2 || type == 0){
        $("img.judge_book_img").each(function(){
            var img = new Image();
            img.src = $(this).attr("src");
            img.onload = ratio_img(this, 130, 190);
        });
    }
    if(type == 3 || type == 0){
        $("img.book_img_self").each(function(){
            var img = new Image();
            img.src = $(this).attr("src");
            img.onload = ratio_img(this, 128, 118);
        });
    }
    if(type == 4 || type == 0){
        $("img.book_img_dynamic").each(function(){
            var img = new Image();
            img.src = $(this).attr("src");
            img.onload = ratio_img(this, 130, 130);
        });
    }
    if(type == 5 || type == 0){
        $("img.judge_geometric_img").each(function(){
            var img = new Image();
            img.src = $(this).attr("src");
            img.onload = ratio_img(this, 235, 345);
        });
    }
    if(type == 6 || type == 0){
        $("img.hot_zp_img").each(function(){
            var img = new Image();
            img.src = $(this).attr("src");
            img.onload = ratio_img(this, 176, 257);
        });
    }
}
$(window).load(function(){
    console.log("utility load");
    // 首页图片比例自适应
    $("img.mem_sub_img").each(function(){
        var img = new Image();
        img.src = $(this).attr("src");
        img.onload = ratio_img(this, 160, 235);
    });
    $("img.judge_book_img").each(function(){
        var img = new Image();
        img.src = $(this).attr("src");
        img.onload = ratio_img(this, 130, 190);
    });
    $("img.book_img_self").each(function(){
        var img = new Image();
        img.src = $(this).attr("src");
        img.onload = ratio_img(this, 128, 118);
    });
    $("img.book_img_dynamic").each(function(){
        var img = new Image();
        img.src = $(this).attr("src");
        img.onload = ratio_img(this, 130, 130);
    });
    $("img.judge_geometric_img").each(function(){
        var img = new Image();
        img.src = $(this).attr("src");
        img.onload = ratio_img(this, 235, 345);
    });
    $("img.hot_zp_img").each(function(){
        var img = new Image();
        img.src = $(this).attr("src");
        img.onload = ratio_img(this, 176, 257);
    });
});


//异步追加列表
function get_more(url, id){
    var result_html = yz_ajax_page(url, {}, "get");
    $("#" + id).replaceWith(result_html);

    yz_init_star();
    setTimeout("img_ratio_init()", 500);//img_ratio_init();//图片按比例缩放
}

function get_more_subject(url, id){
    var more_tpl = arguments[2] ? arguments[2] : "";//模版参数
    var result_html = yz_ajax_page(url, {more_tpl:more_tpl}, "get");
    $("#" + id).replaceWith(result_html);

    if( more_tpl == 'subject_page_1' ) {
        new Waterfall({
            "container":"masonry",
            "colWidth":344,
            "cls":"box",
            "colCount":2
        });

        $(".img_b img").load(function(){
            new Waterfall({
                "container":"masonry",
                "colWidth":344,
                "cls":"box",
                "colCount":2
            });
        });
    }

    yz_init_star();
    setTimeout("img_ratio_init()", 500);//img_ratio_init();//图片按比例缩放
}