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
    obj.removeClass('has-error').addClass('success');;
    obj.find('.text-error').hide();
}
//验证失败样式
form.error = function(obj){
    obj.removeClass('success').addClass('has-error');
    obj.find('.text-error').show();
    return false;
}
//验证单个表单
form.check = function(input_obj){
    var result = true;
    result = form.validation(input_obj.parents('.control-group'));
    return result;
};
//遍历验证
form.checkAll = function(formID){
    var result = true;
    $("#" + formID +" .form-group").each(function(){
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
            var results=/^[1-9]+/.test(trim(input.val()))?true:false;
            if( results === true ) {
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
form.send = function(formID){
    var result = form.checkAll(formID);
    if( result === true ){
        $('#'+formID).submit();
    }
}


/**
 * 通用跳转函数
 * @param  String url	 跳转的目标url	
 * @param  Number second  多少秒后跳转
 * @param  String message 提示信息
 */
function xbGoTo(url,second,message){
	var url=arguments[0] ? arguments[0] : '/',
		second=arguments[1] ? arguments[1] : 0,
		message=arguments[2] ? arguments[2] : '';
	// 转换为毫秒 为了处理0毫秒的问题所以+1
	second=second*1000+1;
	// 设置提示信息
	if (message!='') {
		xbAlert(message);
	}
	// 设置跳转时间
	setTimeout(function(){
		location.href=url;
	},second)
}

/**
 * 刷新本页
 * @param  {Number}  second  多少秒后刷新 默认是0立即刷新
 * @param  {Boolean} history 默认为  false刷新后停留在当前位置  true 刷新后到顶部
 */
function xbRefresh(second,history){
	var second=arguments[0] ? arguments[0] : 0,
		history=arguments[1] ? arguments[1] : false;
	// 转换为毫秒 为了处理0毫秒的问题所以+1
	second=second*1000+1;
	setTimeout(function(){
		if (history) {
			location.reload(true);
		}else{
			console.log(history);
			location.reload(false);
		}
	},second)
}

/**
 * 检测是否登录
 * @return {boolean} 登录：true    未登录：false；
 */
function xbCheckLogin(){
	var isLogin=false;
	$.ajaxSetup({ 
	    async : false 
	});  
	// ajax检测是否登录
	$.get(xbCheckLoginUrl, function(data) {
		if (data['error_code']==0) {
			isLogin=true;
		}
	},'json');
	return isLogin;
}

/**
 * 如果登录直接访问连接；未登录则弹出登录框
 * @param  {string} url 连接
 */
function xbNeedLogin(url){
	if(xbCheckLogin()){
		xbGoTo(url);
	}else{
		xbAlert('您需要登录');
		// 设置cookie
		xbSetCookie('thisUrl',url);
		// 显示登录框
		xbShowLogin()
	}
}

/**
 * 需要确认的跳转
 * @param  {string} url  跳转的连接
 * @param  {string} word 确认的提示语 默认是 确认操作？
 */
function xbNeedConfirm(url,word){
	var word=arguments[1] ? arguments[1] : '确认操作';
	if (confirm(word)) {
		location.href=url;
	}
}

/**
 * 获取form中的数据并转为json对象格式
 * @param  {object} obj form对象
 * @return {json}       json对象
 */
function xbGetForm(obj){
	var formData=$(obj).serializeArray();
	var formArray={};
	$.each(formData, function(index, val) {
		formArray[val['name']]=val['value'];
	});
	return formArray;
}

/**
 * 设置cookie
 * @param {string} name  键名
 * @param {string} value 键值
 * @param {integer} days cookie周期
 */
function xbSetCookie(name,value,days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();
    }else{
        var expires = "";
    }
    document.cookie = name+"="+value+expires+"; path=/";
}
 
// 获取cookie
function xbGetCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
 
// 删除cookie
function xbDeleteCookie(name) {
    xbSetCookie(name,"",-1);
}




/**
 +----------------------------------------------------------
 * swf上传完回调方法
 +----------------------------------------------------------
 * Author: dav <85168163@qq.com>
 * Date  : 2014-04-23
 +----------------------------------------------------------
 * uploadid		dialog id
 * name			dialog名称
 * inputid		最后数据返回插入的容器id
 * funcName		回调函数
 * path			保存路径 news_thumb 表示存在默认路径如Uploads下的 news/thumb 目录
 * thumb_width	缩略图宽
 * thumb_height	缩略图高
 * authkey 		参数密钥，验证args
 *
 +----------------------------------------------------------
 */
function flashupload(uploadid, name, inputid, funcName, path, thumb_width, thumb_height, authkey) {
    var param = '?path=' + path + '&thumb_width=' + thumb_width + '&thumb_height=' + thumb_height + '&authkey=' + authkey;
    art.dialog.open('/index.php/Admin/Public/swfupload/' + param, {
        title: name,
        id: uploadid,
        width: '650px',
        height: '420px',
        lock: true,
        fixed: true,
        background: "#CCCCCC",
        opacity: 0,
        ok: function () {
            if (funcName) {
                funcName.apply(this, [this, inputid]);
            } else {
                return_value.apply(this, [this, inputid]);
            }
        },
        cancel: true
    });
}
//上传回调
function return_value(uploadid, returnid) {
    //取得iframe对象
    var d = uploadid.iframe.contentWindow;
    //取得选择的图片
    var in_content = d.$("#returnValue").val();
    $('#' + returnid).val(in_content);
}




/**
 * Created by Administrator on 2016/11/25.
 */


$(function(){

    /**
     * 弹出iframe
     */
    $('.layer-dialog').click(function(e){
        e.preventDefault();
        var url = e.currentTarget.href;
        var title = e.currentTarget.title;
        var width = $(this).attr('data-width');
        var height = $(this).attr('data-height');
        var is_full = $(this).attr('data-full');
        if( width == undefined || width == '' ) {
            width = '1000px';
        }
        if( height == undefined || height == '' ) {
            height = '720px';
        }

        //窗口小于500统一设置为 90%宽高
        var client_w =  document.body.clientWidth;
        if( client_w < 500 ) {
            width = '90%';
            height = '90%';
        }

        var this_index = layer.open({
            /*skin: 'layui-layer-lan',*/
            type: 2,
            title: title,
            fix: false,
            shade:0.7,
            maxmin: true,
            shadeClose: true, //是否点击关闭遮罩层
            area: [width, height],
            //maxWidth: '500px',// area为auto时才生效
            /*btn: ['按钮一'],
             yes: function(index, layero){
             alert(1111);
             },*/
            content: url,
            end: function(){
                //关闭窗口后执行
            }/*,
             success: function(layero, index) {
             layer.iframeAuto(index);
             }*/
            /*,cancel: function(index, layero){
                if(confirm('確定要關閉窗口嗎？')){ //只有当点击confirm框的确定时，该层才会关闭
                    layer.close(index)
                }
                return false;
            }*/
        });
        if( is_full == 1 ) {
            layer.full(this_index);
        }
    });

    /**
     * ajax提交
     */
    $('.submit-ajax').submit(function(){
        var url = $(this).attr('action');
        var data = $(this).serialize();
        var refresh = $(this).attr('data-refresh'); //1刷新当前页/跳转url  2刷新父层/跳转url  3刷新父层 other不刷新

        //是否验证表单
        var validate = $(this).attr('validate');
        if( validate != '' && validate != undefined ) {
            var form_id = $(this).attr('id');
            var validate_result = form.checkAll(form_id);
            if( !validate_result ) {
                return false;
            }
        }

        layer.load();
        $.ajax({
            type: "post",
            url:url,
            data:data,
            dataType:"json",
            success:function(data){
                if( data.status == 1 ) {
                    layer.msg(data.info);
                    if( refresh == 1 ) {
                        if( data.url != '' ) {
                            window.location.href = data.url;
                        } else {
                            window.location.reload();
                        }
                    } else if( refresh == 2 ) {
                        if( data.url != '' ) {
                            parent.location.href = data.url;
                        } else {
                            parent.location.reload();
                        }
                    }  else if( refresh == 3 ) {
                        parent.location.reload();
                    } else {
                        //不刷新
                    }
                } else {
                    layer.msg(data.info);
                }
                layer.closeAll('loading');
            },
            error:function(data){
                layer.closeAll('loading');
                alert(data);
            }
        });
        return false;
    })


    //删除前提示
    $(".delete").click(function(e) {
        e.preventDefault();
        var url = e.currentTarget.href;
        if( e.currentTarget.title == undefined || e.currentTarget.title == '' ) {
            var tip = '确定要删除该信息吗？';
        } else {
            var tip = e.currentTarget.title;
        }
        console.log(url);

        bootbox.confirm({
                message: tip,
                buttons: {
                    confirm: {
                        label: "删除",
                        className: "btn-primary btn-sm"
                    },
                    cancel: {
                        label: "取消",
                        className: "btn-sm"
                    }
                },
                callback: function(result) {
                    if(result) {
                        window.location.href = url;
                    }
                }
            }
        );
    });

    //时间插件
    $('.date-picker').datepicker({
        autoclose: true,
        todayHighlight: true
    })
})



//弹出alert，自动关掉
function sp_tip(tip){
    var time = arguments[1] ? arguments[1] : 2;
    layer.open({
        content: tip,
        time: time,
        skin: 'msg'
    });
}

/**
 * 弹出对话窗  不会自动关掉
 * @param msg
 */
function sp_alert(msg){
    var btn_text = arguments[1] ? arguments[1] : '我知道了';
    layer.open({
        content: msg,
        btn: btn_text,
        yes: function(index){
            //location.reload();
            layer.close(index);
        }
    });
}

function sp_alert_reload(msg){
    var btn_text = arguments[1] ? arguments[1] : '我知道了';
    layer.open({
        content: msg,
        btn: btn_text,
        yes: function(index){
            location.reload();
            //layer.close(index);
        }
    });
}

/**
 * 点击确定后跳转URL
 * @param msg
 * @param btn_text
 * @param btn_url
 */
function sp_alert_gourl(msg,btn_text,btn_url){
    layer.open({
        content: msg,
        btn: btn_text,
        yes: function(){
            window.location.href = btn_url;
        }
    });
}
