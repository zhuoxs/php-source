function ajaxPost() {

    $.post(window.sysinfo.siteroot + "app/index.php?c=entry&do=save&m=xiaof_toupiao&sid=" + window.sysinfo.sid + "&i=" + window.sysinfo.uniacid, $("#join-form").serialize(), function (data) {
        var result = new Function('return' + data)();
        if (result.errno == 0) {
            xfdialog(result.message, true);
            setTimeout(function () {
                if (reloadurl) {
                    window.location.href = reloadurl;
                } else {
                    location.reload();
                }
            }, 3000);
        } else if (result.errno == 109) {
            feetips();
        } else {
            xfdialog(result.message, true);
            setTimeout(function () {
                if (reloadurl) {
                    window.location.href = reloadurl;
                } else {
                    location.reload();
                }
            }, 3000);
        }
    });
}

function imagefileUpload(imgvalue) {
    localNum = imgvalue.length;
    if ($("#imagefile").length > 0 && localNum > 0) {
        $.ajaxFileUpload({
            url: window.sysinfo.siteroot + "app/index.php?c=entry&do=uploadimage&m=xiaof_toupiao&sid=" + window.sysinfo.sid + "&i=" + window.sysinfo.uniacid,
            secureuri: false,
            fileElementId: 'imagefile',
            dataType: 'text',
            success: function (data) {
                var result = $.parseJSON(data);
                if (result.errno == 0) {
                    $.each(result.message, function (k, v) {
                        $("#pic-container").append("<span class='picid' onclick='$(this).remove();'><input type='hidden' name='pics[]' value='" + v + "'/><div class='pic-close'>x</div><img src='" + window.sysinfo.attachurl + v + "'/></span>");
                    });
                } else {
                    xfdialog(result.message);
                }
            },
            error: function (data, status, e) {
                xfdialog(e);
            }
        });
    }
}

$(function () {
    $("#form-submit").click(function () {

        localNum = $("#pic-container .picid").length;

        if (localNum <= 0) {
            xfdialog("没有选择照片，不能为空", true);
            return;
        }

        if($("#opensound").val() == 1  && $("#mustsound").val() == 1){
            if ($("#sound").val() == "") {
                xfdialog("没有上传语音，不能为空", true);
                return;
            }
        }
        if($("#openvideo").val() == 1  && $("#mustvideo").val() == 1){
            if ($("#videofile").val() == "") {
                xfdialog("没有上传视频，不能为空", true);
                return;
            }
        }

        var phonereg = /^((0\d{2,3}-\d{7,8})|(1([358][0-9]|4[579]|66|7[0135678]|9[89])[0-9]{8}))$/;
        var phonereg_mo =  /^((((0?)|((00)?))(((\s){0,2})|([-_－—\s\(]?)))|([+]?))(853)?([\)]?)([-_－—\s]?)(28[0-9]{2}|((6|8)[0-9]{3}))[-_－—\s]?[0-9]{4}$/;//澳门手机号码验证

        if ($("#name").val() == "") {
            xfdialog("名称不能为空", true);
        } else if (phonerequired && $("#phone").val() == "") {
            xfdialog("手机号不能为空", true);
        } else if (phonerequired && !phonereg.test($("#phone").val()) && !phonereg_mo.test($("#phone").val())) {
            xfdialog("不是正确手机号", true);
        } else if (localNum > limitpic) {
            xfdialog("照片最多不超过" + limitpic + "张", true);
        } else {
            xfdialog("正在上传，请等待完成，不要关闭本页面");
            if ($("#videofile").length > 0 && $("#videofile").val().length > 0) {
                $.get(window.sysinfo.siteroot + "app/index.php?c=entry&do=token&m=xiaof_toupiao&sid=" + window.sysinfo.sid + "&i=" + window.sysinfo.uniacid, function (data, status) {
                    if (status == 'success') {
                        var formData = new FormData();
                        formData.append('file', $("#videofile")[0].files[0]);
                        formData.append('token', data);
                        formData.append('accept', 'text/plain; charset=utf-8');
                        $.ajax({
                            url: 'https://upload.qiniup.com/',
                            type: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function (data) {
                                var result = $.parseJSON(data);
                                $("#video-input").val(result.key);
                                ajaxPost();
                            },
                            error: function (xhr, data, err) {
                                if (xhr.status === 413) {
                                    xfdialog('上传视频文件超过大小限制');
                                } else if (xhr.status === 403) {
                                    xfdialog('必须是视频格式文件');
                                } else {
                                    xfdialog('视频上传失败');
                                }
                            }
                        });
                    } else {
                        xfdialog('上传视频参数错误');
                    }
                });
            } else {
                ajaxPost();
            }
        }
    });
});