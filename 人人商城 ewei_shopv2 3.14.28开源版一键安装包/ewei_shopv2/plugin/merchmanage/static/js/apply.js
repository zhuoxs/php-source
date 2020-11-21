define(['core', 'tpl'], function(core, tpl) {
    var modal = {};
    modal.init = function(params) {
        var checked_applytype = $('#applytype').find("option:selected").val();
        if (checked_applytype == 2) {
            $('.ab-group').show();
            $('.alipay-group').show();
            $('.bank-group').hide()
        } else if (checked_applytype == 3) {
            $('.ab-group').show();
            $('.alipay-group').hide();
            $('.bank-group').show()
        } else {
            $('.ab-group').hide();
            $('.alipay-group').hide();
            $('.bank-group').hide()
        }
        $('#applytype').change(function() {
            var applytype = $(this).find("option:selected").val();
            if (applytype == 2) {
                $('.ab-group').show();
                $('.alipay-group').show();
                $('.bank-group').hide()
            } else if (applytype == 3) {
                $('.ab-group').show();
                $('.alipay-group').hide();
                $('.bank-group').show()
            } else {
                $('.ab-group').hide();
                $('.alipay-group').hide();
                $('.bank-group').hide()
            }
        });
        
        $('.btn-submit').click(function() {
            var btn = $(this);
            if (btn.attr('stop')) {
                return
            }
            
            var html = '';
            var realname = '';
            var alipay = '';
            var alipay1 = '';
            var bankname = '';
            var bankcard = '';
            var bankcard1 = '';
            var applytype = $('#applytype').find("option:selected").val();
            var typename = $('#applytype').find("option:selected").html();
            if (applytype == undefined) {
                FoxUI.toast.show('未选择提现方式，请您选择提现方式后重试!');
                return
            }
            if (applytype == 0) {
                html = typename;
            } else if (applytype == 1) {
                html = typename;
            } else if (applytype == 2) {
                if ($('#realname').val() == '') {
                    FoxUI.toast.show('请填写姓名!');
                    return
                }
                if ($('#alipay').val() == '') {
                    FoxUI.toast.show('请填写支付宝帐号!');
                    return
                }
                if ($('#alipay1').val() == '') {
                    FoxUI.toast.show('请填写确认帐号!');
                    return
                }
                if ($('#alipay').val() != $('#alipay1').val()) {
                    FoxUI.toast.show('支付宝帐号与确认帐号不一致!');
                    return
                }
                realname = $('#realname').val();
                alipay = $('#alipay').val();
                alipay1 = $('#alipay1').val();
                html = typename + "?<br>姓名:" + realname + "<br>支付宝帐号:" + alipay
            } else if (applytype == 3) {
                if ($('#realname').val() == '') {
                    FoxUI.toast.show('请填写姓名!');
                    return
                }
                if ($('#bankcard').val() == '') {
                    FoxUI.toast.show('请填写银行卡号!');
                    return
                }
                
                if ($('#bankcard1').val() == '') {
                    FoxUI.toast.show('请填写确认卡号!');
                    return
                }
                if ($('#bankcard').val() != $('#bankcard1').val()) {
                    FoxUI.toast.show('银行卡号与确认卡号不一致!');
                    return
                }
                realname = $('#realname').val();
                bankcard = $('#bankcard').val();
                bankcard1 = $('#bankcard1').val();
                bankname = $('#bankname').find("option:selected").html();
                html = typename + "?<br>姓名:" + realname + "<br>" + bankname + " 卡号:" + $('#bankcard').val()
            }
            if (applytype < 2) {
                var confirm_msg = '确认要' + html + "?"
            } else {
                var confirm_msg = '确认要' + html
            }
            FoxUI.confirm(confirm_msg, function() {
                btn.html('正在处理...').attr('stop', 1);
                core.json('merchmanage/apply', {
                    applytype: applytype,
                    realname: realname,
                    alipay: alipay,
                    alipay1: alipay1,
                    bankname: bankname,
                    bankcard: bankcard,
                    bankcard1: bankcard1
                }, function(ret) {
                    if (ret.status == 0) {
                        btn.removeAttr('stop').html(html);
                        FoxUI.toast.show(ret.result.message);
                        return
                    }
                    FoxUI.toast.show('申请已经提交，请等待审核!');
                    location.href = core.getUrl('merchmanage/apply')
                }, true, true)
            })
        })
    };
    return modal
});