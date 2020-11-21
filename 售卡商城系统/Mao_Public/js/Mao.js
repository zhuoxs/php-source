var Mao={
    postData: function(url, parameter, callback, dataType, ajaxType, callerror) {
        dataType = dataType||'html';
        ajaxType = ajaxType||"POST";
        $.ajax({
            type: ajaxType,
            url: url,
            async: true,
            dataType: dataType,
            timeout : 60000,
            data: parameter,
            success: function(data) {
                if (callback == null) {$("#ajaxshow").html(data);return false;}
                callback(data);
            },
            error: function(error) {
                if (callerror == null) {}
                callerror(error);
            }
        });
    }
};
function kefu(){
    var loading = layer.load();
    $.ajax({
        url: '../api/api.php',
        type: 'POST',
        dataType: 'json',
        data: {mod: "kefu"},
        success: function (a) {
            layer.close(loading);
            if (a.code == 0) {
                layer.alert('客服QQ：'+a.qq+'<br>客服微信：'+a.wx)
            } else {
                layer.msg(a.msg);
            }
        },
        error: function() {
            layer.close(loading);
            layer.msg('~连接服务器失败！', {icon: 5});
        }
    });
}
function goBack(){
    if (navigator.userAgent && /(iPhone|iPad|iPod|Safari)/i.test(navigator.userAgent)) {
        window.location.href = window.document.referrer;
    } else {
        window.history.back(-1);
    }
}
function logout() {
    var loading = layer.load();
    $.ajax({
        url: '../api/api.php',
        type: 'POST',
        dataType: 'json',
        data: {mod: "logout"},
        success: function (a) {
            layer.close(loading);
            if (a.code == 0) {
                layer.msg(a.msg, {icon: 1}, function(){window.open("/index.php", "_self");});
            } else {
                layer.msg(a.msg);
            }
        },
        error: function() {
            layer.close(loading);
            layer.msg('~连接服务器失败！', {icon: 5});
        }
    });
}//注销
function fz(id) {
    var Url2=document.getElementById(id).innerText;
    var oInput = document.createElement('input');
    oInput.value = Url2;
    document.body.appendChild(oInput);
    oInput.select();
    document.execCommand("Copy");
    oInput.className = 'oInput';
    oInput.style.display='none';
    layer.open({
        content: '复制成功，请粘贴到你的QQ/微信上推荐给你的好友~'
        ,skin: 'msg'
        ,time: 2
    });
}