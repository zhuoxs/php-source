function goback(){
    history.go(-1);
}

/**
 * 异步访问页面，或提交数据
 * @param url ：访问或提交的路径
 * 有第二个参数则是回调函数
 */
function yz_ajax(url){
    yz_lock();
    var param = arguments[1] ? arguments[1] : "";//传参，默认无
    var callback = arguments[2] ? arguments[2] : false;//回调函数，默认无
    var type = (arguments[3] && arguments[3]=="post") ? arguments[3] : 'GET';//请求方式，默认get
    $.ajax({
        type: type,
        url: url,
        data: param,/*"id=12&type=1",*/ /*{"param1":param1,"param2":param2},*/
        success: function(result){
            console.log(result);
            if((result.status && !callback) || !result.status) {/*提交成功却没有回调函数 或者 提交失败 弹出提示信息*/
                alert(result.info);
            }
            if(callback){/*无论提交成功与否，有回调函数就调用回调函数*/
                callback(result);
            }
            yz_unlock();
        },
        error: function(){
            yz_unlock();
            alert('请求出错处理！');
        },
        dataType: "json"
    });
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
 * 锁定屏幕，显示加载中
 */
function yz_lock() {
    var popu = document.createElement("div");
    popu.setAttribute('id','yz_lock');
    popu.innerHTML = '<div class="loading"></div><div id="shadow_bg"></div>';
    document.body.appendChild(popu);
}
/**
 * 解锁屏幕
 */
function yz_unlock(){
    $('#yz_lock').remove();
}


/**
 * 删除内容提示
 * @param url
 * @param title
 */
function yz_del(url,title){
    var msg = (title != '' && title != undefined) ? '您确定删除 【' + title + '】 吗' : '您确定删除此条信息吗？';
    var d = dialog({
        title: '提示',
        content: msg,
        okValue: '确定',
        ok: function () {
            window.location.href = url;
            return false;
        },
        cancelValue: '取消',
        cancel: function () {}
    });
    d.show();
}
/**
 * 添加标签
 <span>
 <input class="input_lable" name="" type="text" />
 <input type="button" onclick='incRease(10, 10);' value="添加" />
 </span>

 <div style="display: none;" id="increase_lable" class="increase_lable_box">
 </div>
 * @param max_num 标签个数
 * @param tag_len 单个标签长度
 */
function incRease(max_num, tag_len){
    var act_tags = arguments[2] ? arguments[2] : "";//活动标签
    var text_input = $(".input_lable").val().replace(/(^\s*)|(\s*$)/g, ""); //获取输入框值并去掉左右两边空格
    if( text_input == '') return false;
    $(".increase_lable_box").show();
    //判断输入一样时
    var systems = $(".system");
    var tag_nums = systems.length;
    for(var i=0; i < tag_nums; i++) {
        if(text_input == systems.eq(i).html()){
            return false;
        }
    }
    if(tag_nums >= max_num){
        alert("已经有"+max_num+"个标签，不能再多了！");
        return false;
    }
    if(text_input.length > tag_len){
        alert("每个标签最多"+tag_len+"个字！");
        return false;
    }
    var act = "";//活动标签class样式
    for (x in act_tags) {
        var act_tag = act_tags[x];
        if(act_tag == text_input){
            act = " act";
        }
    }
    var system_html = "<span class='form'><a href='#' class='lable system "+ act +"'>" + text_input + "</a><i title='关闭'>删除</i><input name=\"tags[]\" type=\"hidden\" value=\"" + text_input + "\"/></span>"; //要添加html
    $("#increase_lable").append(system_html);
    $(".input_lable").val('');
    //删除
    $("#increase_lable .form i").click(function(){
        $(this).parent(".form").remove();
    });
}


/**
 +----------------------------------------------------------
 * 全选、全不选
 +----------------------------------------------------------
 * t		object
 * id	input name exp: id[]
 +----------------------------------------------------------
 */
function selectAll(t, id) {
    var ids = document.getElementsByName(id);
    if(t.checked===true){
        for(i = 0;i < ids.length;i++){
            if(ids[i].type == "checkbox") {
                ids[i].checked = true;
            }
        }
    } else {
        for(i = 0;i < ids.length;i++){
            if(ids[i].type == "checkbox") {
                ids[i].checked = false;
            }
        }
    }
}



/**
 +----------------------------------------------------------
 * 表单验证函数
 +----------------------------------------------------------
 * Author: dav <85168163@qq.com>
 * Date  : 2014-04-23
 +----------------------------------------------------------
 * required		必填			exp: class='required'
 * phone			验证手机号
 * tel			验证电话号码
 * email			验证email
 * length		长度
 * minlength		最小长度		exp: minlength='6'
 * maxlength		最大长度
 * min			最小值
 * max			最大值
 * integer		整数
 * number		浮点数
 * equalto		确认密码		exp: equalto='xxxID'
 *
 +----------------------------------------------------------
 */

function trim(str){ //删除左右两端的空格
    return str.replace(/(^\s*)|(\s*$)/g, "");
}


var form = {};
//验证成功样式
form.success = function(obj){
    obj.removeClass('form-error').addClass('form-success');;
    obj.find('.text-error').hide();
}
//验证失败样式
form.error = function(obj){
    obj.removeClass('form-success').addClass('form-error');
    obj.find('.text-error').show();
    return false;
}
//验证单个表单
form.check = function(input_obj,node){
    var result = true;
    result = form.validation(input_obj.parents(node));
    return result;
};
//遍历验证
form.checkAll = function(formID, node){
    var result = true;
    $("#" + formID +" " + node).each(function(){
        var res = form.validation($(this));
        if( res === false ) result = false;
    })
    return result;
};
//验证规则
form.validation = function(obj){
    //验证必填input
    var result = true;
    if( obj.find('textarea').length > 0 ) {
        var input = obj.find('textarea');
    } else {
        var input = obj.find('input');
    }
    if( input.length > 0 ) {
        //验证必填
        if( input.attr('class').indexOf('required') != -1 && trim(input.val()) == '' ){
            result = form.error(obj);
        } else {
            form.success(obj);
        }

        //验证手机号码 - 简单验证
        if( input.attr('class').indexOf('phone') != -1 && trim(input.val()) != '' ){
            if( trim(input.val()).length != 11 || isNaN(trim(input.val())) === true ) {
                result = form.error(obj);
            } else {
                form.success(obj);
            }
        }

        //验证电话
        if( input.attr('class').indexOf('tel') != -1 && trim(input.val()) != '' ){
            var patrn = /^(\(\d{3,4}\)|\d{3,4}-|\s)?\d{6,8}$/;
            if( !patrn.exec(trim(input.val())) ){
                result = form.error(obj);
            } else {
                form.success(obj);
            }
        }


        //验证email
        if( input.attr('class').indexOf('email') != -1 && trim(input.val()) != '' ){
            var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
            if( reg.test(trim(input.val())) != true ){
                result = form.error(obj);
            } else {
                form.success(obj);
            }
        }

        //长度
        if( input.attr('length') != undefined && trim(input.val()) != '' ){
            if( trim(input.val()).length != input.attr('length') ){
                result = form.error(obj);
            } else {
                form.success(obj);
            }
        }


        //验证是否为浮点数
        if( input.attr('class').indexOf('integer') != -1 && trim(input.val()) != '' ){
            if( isNaN(trim(input.val())) === true ) {
                result = form.error(obj);
            } else {
                form.success(obj);
            }
        }

        //长度为X的数字
        if( input.attr('class').indexOf('integer') != -1 && input.attr('length') != undefined && trim(input.val()) != '' ){
            var reg = /^[-+]?\d*$/;
            if( reg.test(trim(input.val())) != true || trim(input.val()).length != input.attr('length') ){
                result = form.error(obj);
            } else {
                form.success(obj);
            }
        }


        //验证是否为浮点数
        if( input.attr('class').indexOf('number') != -1 && trim(input.val()) != '' ){
            if( isNaN(trim(input.val())) === true ) {
                result = form.error(obj);
            } else {
                form.success(obj);
            }
        }


        //确认密码
        if ( input.attr('equalto') != undefined ) {
            var equalID = input.attr('equalto');
            if( trim(input.val()) != $('#' + equalID).val() ) {
                result = form.error(obj);
            } else {
                form.success(obj);
            }
        }


        //验证字符最小长度
        if ( input.attr('minlength') != undefined && input.attr('maxlength') == undefined  && trim(input.val()) != '' ) {
            if( input.attr('minlength') > trim(input.val()).length ) {
                result = form.error(obj);
            } else {
                form.success(obj);
            }
        }
        //验证字符最大长度
        if ( input.attr('maxlength') != undefined && input.attr('minlength') == undefined  && trim(input.val()) != '' ) {
            if( input.attr('maxlength') < trim(input.val()).length ) {
                result = form.error(obj);
            } else {
                form.success(obj);
            }
        }
        //验证字符最大长度、最小长度
        if ( input.attr('minlength') != undefined && input.attr('maxlength') != undefined  && trim(input.val()) != '' ) {
            if( input.attr('maxlength') < trim(input.val()).length || input.attr('minlength') > trim(input.val()).length ) {
                result = form.error(obj);
            } else {
                form.success(obj);
            }
        }

        //验证字符最小值
        if ( ( input.attr('min') != undefined && input.attr('max') == undefined ) && trim(input.val()) != '' ) {
            if( input.attr('min') > parseInt(trim(input.val()))  || isNaN(trim(input.val())) === true ) {
                result = form.error(obj);
            } else {
                form.success(obj);
            }
        }
        //验证字符最大值
        if ( ( input.attr('max') != undefined && input.attr('min') == undefined ) && trim(input.val()) != '') {
            if( input.attr('max') < parseInt(trim(input.val())) || isNaN(trim(input.val())) === true  ) {
                result = form.error(obj);
            } else {
                form.success(obj);
            }
        }
        //验证字符最大值、最小值
        if ( ( input.attr('min') != undefined && input.attr('max') != undefined ) && trim(input.val()) != '' ) {
            if( ( input.attr('max') < parseInt(trim(input.val())) || input.attr('min') > parseInt(trim(input.val())) ) || isNaN(trim(input.val())) === true ) {
                result = form.error(obj);
            } else {
                form.success(obj);
            }
        }

    }

    //验证必选
    var sel = obj.find('select');
    if( sel.length > 0 ) {
        if( sel.attr('class').indexOf('required') != -1 && sel.val() == '' ){
            result = form.error(obj);
        } else {
            form.success(obj);
        }
    }
    return result;
}
//提交
form.send = function(formID,node){
    var result = form.checkAll(formID,node);
    if( result === true ){
        $('#'+formID).submit();
    }
}