define(['core', 'tpl'], function (core, tpl) {
    var modal = {};
    modal.init = function (params) {
        var checked_applytype =  $('input[name="1"]:checked').data('type');
        if (checked_applytype == 2) {
            $('.alipay-group').show();
            $('.bank-group').hide();
        } else if (checked_applytype == 3) {
            $('.alipay-group').hide();
            $('.bank-group').show();
        } else {
            $('.alipay-group').hide();
            $('.bank-group').hide();
        }

        $('.applyradio').click(function () {
            var applytype = $(this).find(".data-bind").data("type");
            // $("input[name='1']").get(applytype).checked=true;
            $(this).find(".data-bind").attr('checked',true);
            if(applytype == 2) {
                $('.alipay-group').show();
                $('.bank-group').hide();
            } else if (applytype == 3) {
                $('.alipay-group').hide();
                $('.bank-group').show();
            } else {
                $('.alipay-group').hide();
                $('.bank-group').hide();
            }
        });

        $('#chargeinfo').click(function () {
            $('.charge-group').toggle();
        });

        $('.btn-submit').click(function () {
            var btn = $(this);
            if (btn.attr('stop')) {
                return
            }
            var current = core.getNumber($('#current').html());
            if(current<=0){
                return
            }
            if (current < params.withdraw) {
                FoxUI.toast.show('满 ' + params.withdraw + ' 元才能提现!');
                return
            }

            var html = '';
            var realname = '';
            var alipay = '';
            var alipay1 = '';
            var bankname = '';
            var bankcard = '';
            var bankcard1 = '';
            var applytype = $('input[name="1"]:checked').data('type');
            var typename = $('input[name="1"]:checked').closest(".fui-cell").find(".text").html();
                // console.log(typename);
            if (applytype == undefined) {
                FoxUI.toast.show('未选择提现方式，请您选择提现方式后重试!');
                return
            }

            if (applytype == 0) {
                html = typename;
            } else if (applytype == 1) {
                html = typename;
            } else if (applytype == 2) {

                console.log($('#realname'));
                if ($('#realname').isEmpty()) {
                    FoxUI.toast.show('请填写姓名!');
                    return
                }
                if ($('#alipay').isEmpty()) {
                    FoxUI.toast.show('请填写支付宝帐号!');
                    return
                }
                if ($('#alipay1').isEmpty()) {
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
                html = typename + "?<br>姓名:" + realname + "<br>支付宝帐号:" + alipay;
            } else if (applytype == 3) {
                if ($('#realname2').isEmpty()) {
                    FoxUI.toast.show('请填写姓名!');
                    return
                }
                if ($('#bankcard').isEmpty()) {
                    FoxUI.toast.show('请填写银行卡号!');
                    return
                }
                if (!$('#bankcard').isNumber()) {
                    FoxUI.toast.show('银行卡号格式不正确!');
                    return
                }
                if ($('#bankcard1').isEmpty()) {
                    FoxUI.toast.show('请填写确认卡号!');
                    return
                }
                if ($('#bankcard').val() != $('#bankcard1').val()) {
                    FoxUI.toast.show('银行卡号与确认卡号不一致!');
                    return
                }
                realname = $('#realname2').val();
                bankcard = $('#bankcard').val();
                bankcard1 = $('#bankcard1').val();
                bankname = $('#bankname').find("option:selected").html();
                html = typename + "?<br>姓名:" + realname + "<br>" + bankname + " 卡号:" + $('#bankcard').val();
            }

            if (applytype < 2) {
                var confirm_msg = '确认要' + html + "?";
            } else {
                var confirm_msg = '确认要' + html;
            }

            FoxUI.confirm(confirm_msg, function () {
                btn.html('正在处理...').attr('stop', 1);
                core.json('dividend/apply', {type: applytype, realname: realname, alipay: alipay, alipay1: alipay1, bankname: bankname, bankcard: bankcard, bankcard1: bankcard1}, function (ret) {
                    if (ret.status == 0) {
                        btn.removeAttr('stop').html(html);
                        FoxUI.toast.show(ret.result.message);
                        return
                    }
                    FoxUI.toast.show('申请已经提交，请等待审核!');
                    location.href = core.getUrl('dividend/withdraw')
                }, true, true)
            })
        })
    };
    return modal
});