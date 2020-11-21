define(['core'], function (core, tpl, picker) {
    var modal = {backurl: ''};
    modal.initLogin = function (params) {
        modal.backurl = params.backurl;
        $('#btnSubmit').click(function () {
            if ($('#btnSubmit').attr('stop')) {
                return
            }
            if ($.trim($('#mobile').val()) !== '' && /^1[3|4|5|7|8][0-9]\d{8}$/.test($.trim($('#mobile').val()))) {

            }
            else
            {
                FoxUI.toast.show('请填写正确手机号码');
                return

            }
            if ($('#pwd').val()== undefined || $.trim($('#pwd').val()) == '' ) {
                FoxUI.toast.show('请输入登录密码!');
                return
            }
            $('#btnSubmit').html('正在登录...').attr('stop', 1);
            core.json('pc.account.login', {mobile: $('#mobile').val(), pwd: $('#pwd').val()}, function (ret) {
                FoxUI.toast.show(ret.result.message);
                if (ret.status != 1) {
                    $('#btnSubmit').html('立即登录').removeAttr('stop');
                    return
                } else {
                    $('#btnSubmit').html('正在跳转...')
                }
                setTimeout(function () {
                    if (modal.backurl) {
                        location.href = modal.backurl;
                        return
                    }
                    location.href = core.getUrl('pc')
                }, 1000)
            }, false, true)
        })
    };
    modal.verifycode = function () {
        modal.seconds--;
        if (modal.seconds > 0) {
            $('#btnCode').html(modal.seconds + '秒后重发').addClass('disabled').attr('disabled', 'disabled');
            setTimeout(function () {
                modal.verifycode()
            }, 1000)
        } else {
            $('#btnCode').html('获取验证码').removeClass('disabled').removeAttr('disabled')
        }
    };
    modal.initRf = function (params) {
        modal.backurl = params.backurl;
        modal.type = params.type;
        modal.endtime = params.endtime;
        if (modal.endtime > 0) {
            modal.seconds = modal.endtime;
            modal.verifycode()
        }
        $('#btnCode').click(function () {
            if ($('#btnCode').hasClass('disabled')) {
                return
            }
            if ($.trim($('#mobile').val()) !== '' && /^1[3|4|5|7|8][0-9]\d{8}$/.test($.trim($('#mobile').val()))) {

            }
            else
            {
                FoxUI.toast.show('请填写正确手机号码');
                return

            }
            modal.seconds = 60;
            modal.verifycode();
            core.json('pc.account.verifycode', {
                mobile: $('#mobile').val(),
                temp: !modal.type ? "sms_reg" : "sms_forget"
            }, function (ret) {
                FoxUI.toast.show(ret.result.message);
                if (ret.status != 1) {
                    $('#btnCode').html('获取验证码').removeClass('disabled').removeAttr('disabled')
                }
            }, false, true)
        });
        $('#btnSubmit').click(function () {
            if ($('#btnSubmit').attr('stop')) {
                return
            }
            if ($.trim($('#mobile').val()) !== '' && /^1[3|4|5|7|8][0-9]\d{8}$/.test($.trim($('#mobile').val()))) {

            }
            else
            {
                FoxUI.toast.show('请填写正确手机号码');
                return
            }
            var isnum
            if ($('#verifycode').val().length != 5) {
                FoxUI.toast.show('请输入5位数字验证码!');
                return
            }
            if ($('#pwd').val()== undefined || $.trim($('#pwd').val()) == '' ) {
                FoxUI.toast.show('请输入登录密码!');
                return
            }
            if ($('#pwd').val() !== $('#pwd1').val()) {
                FoxUI.toast.show('两次密码输入不一致!');
                return
            }
            $('#btnSubmit').html('正在处理...').attr('stop', 1);
            var url = !modal.type ? "pc.account.register" : "pc.account.forget";
            core.json(url, {
                mobile: $('#mobile').val(),
                verifycode: $('#verifycode').val(),
                pwd: $('#pwd').val()
            }, function (ret) {
                if (ret.status != 1) {
                    FoxUI.toast.show(ret.result.message);
                    var text = modal.type ? "立即找回" : "立即注册";
                    $('#btnSubmit').html(text).removeAttr('stop');
                    return
                } else {
                    FoxUI.alert(ret.result.message, '', function () {
                        if (modal.backurl) {
                            location.href = core.getUrl('pc.account.login', {
                                mobile: $('#mobile').val(),
                                backurl: modal.backurl
                            })
                        } else {
                            location.href = core.getUrl('pc.account.login', {mobile: $('#mobile').val()})
                        }
                    })
                }
            }, false, true)
        })
    };
    modal.initBind = function (params) {
        modal.endtime = params.endtime;
        modal.backurl = params.backurl;
        if (modal.endtime > 0) {
            modal.seconds = modal.endtime;
            modal.verifycode()
        }
        $('#btnCode').click(function () {
            if ($('#btnCode').hasClass('disabled')) {
                return
            }
            if ($.trim($('#mobile').val()) !== '' && /^1[3|4|5|7|8][0-9]\d{8}$/.test($.trim($('#mobile').val()))) {

            }
            else
            {
                FoxUI.toast.show('请输入11位手机号码');
                return

            }
            modal.seconds = 60;
            modal.verifycode();
            core.json('account/verifycode', {mobile: $('#mobile').val(), temp: 'sms_bind'}, function (ret) {
                if (ret.status != 1) {
                    FoxUI.toast.show(ret.result.message);
                    $('#btnCode').html('获取验证码').removeClass('disabled').removeAttr('disabled')
                }
            }, false, true)
        });
        $('#btnSubmit').click(function () {
            if ($('#btnSubmit').attr('stop')) {
                return
            }
            if ($.trim($('#mobile').val()) !== '' && /^1[3|4|5|7|8][0-9]\d{8}$/.test($.trim($('#mobile').val()))) {

            }
            else
            {
                FoxUI.toast.show('请输入11位手机号码');
                return

            }
            if ($('#verifycode').val().length != 5) {
                FoxUI.toast.show('请输入5位数字验证码!');
                return
            }
            if ($('#pwd').val()== undefined || $.trim($('#pwd').val()) == '' ) {
                FoxUI.toast.show('请输入登录密码!');
                return
            }
            if ($('#pwd').val() !== $('#pwd1').val()) {
                FoxUI.toast.show('两次密码输入不一致!');
                return
            }
            $('#btnSubmit').html('正在绑定...').attr('stop', 1);
            core.json('member/bind', {
                mobile: $('#mobile').val(),
                verifycode: $('#verifycode').val(),
                pwd: $('#pwd').val()
            }, function (ret) {
                if (ret.status == 0) {
                    FoxUI.toast.show(ret.result.message);
                    $('#btnSubmit').html('立即绑定').removeAttr('stop');
                    return
                }
                if (ret.status < 0) {
                    FoxUI.confirm(ret.result.message, "注意", function () {
                        core.json('pc.member.bind', {
                            mobile: $('#mobile').val(),
                            verifycode: $('#verifycode').val(),
                            pwd: $('#pwd').val(),
                            confirm: 1
                        }, function (ret) {
                            if (ret.status == 1) {
                                FoxUI.alert('绑定成功!', '', function () {
                                    location.href = params.backurl ? atob(params.backurl) : core.getUrl('pc.member')
                                });
                                return
                            }
                            FoxUI.toast.show(ret.result.message);
                            $('#btnSubmit').html('立即绑定').removeAttr('stop');
                            return
                        }, true, true)
                    }, function () {
                        $('#btnSubmit').html('立即绑定').removeAttr('stop')
                    });
                    return
                }
                FoxUI.alert('绑定成功!', '', function () {
                    location.href = params.backurl ? atob(params.backurl) : core.getUrl('pc.member')
                })
            }, true, true)
        })
    };
    modal.initChange = function (params) {
        modal.endtime = params.endtime;
        if (modal.endtime > 0) {
            modal.seconds = modal.endtime;
            modal.verifycode()
        }
        $('#btnCode').click(function () {
            if ($('#btnCode').hasClass('disabled')) {
                return
            }
            if ($.trim($('#mobile').val()) !== '' && /^1[3|4|5|7|8][0-9]\d{8}$/.test($.trim($('#mobile').val()))) {

            }
            else
            {
                FoxUI.toast.show('请输入11位手机号码');
                return

            }
            modal.seconds = 60;
            modal.verifycode();
            core.json('pc.account.verifycode', {mobile: $('#mobile').val(), temp: 'sms_changepwd'}, function (ret) {
                if (ret.status != 1) {
                    FoxUI.toast.show(ret.result.message);
                    $('#btnCode').html('获取验证码').removeClass('disabled').removeAttr('disabled')
                }
            }, false, true)
        });
        $('#btnSubmit').click(function () {
            if ($('#btnSubmit').attr('stop')) {
                return
            }
            if ($.trim($('#mobile').val()) !== '' && /^1[3|4|5|7|8][0-9]\d{8}$/.test($.trim($('#mobile').val()))) {

            }
            else
            {
                FoxUI.toast.show('请输入11位手机号码');
                return

            }
            if ( $('#verifycode').val().length != 5) {
                FoxUI.toast.show('请输入5位数字验证码!');
                return
            }
            if ($('#pwd').val()== undefined || $.trim($('#pwd').val()) == '' ) {
                FoxUI.toast.show('请输入登录密码!');
                return
            }
            if ($('#pwd').val() !== $('#pwd1').val()) {
                FoxUI.toast.show('两次密码输入不一致!');
                return
            }
            $('#btnSubmit').html('正在修改...').attr('stop', 1);
            core.json('pc.member.changepwd', {
                mobile: $('#mobile').val(),
                verifycode: $('#verifycode').val(),
                pwd: $('#pwd').val()
            }, function (ret) {
                if (ret.status != 1) {
                    FoxUI.toast.show(ret.result.message);
                    $('#btnSubmit').html('立即修改').removeAttr('stop');
                    return
                }
                FoxUI.alert('修改成功!', '', function () {
                    location.href = core.getUrl('pc.member')
                })
            }, false, true)
        })
    };
    return modal
});