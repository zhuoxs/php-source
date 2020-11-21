define(['core'], function (core) {
    var modal = {paction: false};
    modal.initDetail = function (params) {
        modal.hascom = params.hascom;
        modal.bind = params.bind;
        modal.binded = params.binded;
        modal.mobile = params.mobile;
        $("#tab a").unbind('click').click(function () {
            var tab = $(this).data("tab");
            $(this).addClass("active").siblings().removeClass("active");
            $(".tab-content").hide();
            $("#tab_" + tab).show()
        });
        $(".check-param").unbind('click').click(function () {
            var action = $(this).data('action');
            if (action) {
                modal.paction = action;
                modal.showParams()
            }
        });
        $(".cancel-params").unbind('click').click(function () {
            modal.hideParams()
        });
        $("#btn-submit").unbind('click').click(function () {
            if (modal.stop) {
                return
            }
            var obj = {
                id: modal.getVal("mid", true),
                realname: modal.getVal("realname"),
                weixin: modal.getVal("weixin"),
                isblack: modal.checkVal("isblack"),
                content: modal.getVal("content"),
                level: modal.getVal("level", true),
                groupid: modal.getVal("group", true),
                mobile: modal.getVal("mobile")
            };
            if (modal.hascom) {
                obj.fixagentid = modal.checkVal("fixagentid");
                obj.isagent = modal.checkVal("isagent");
                obj.status = modal.checkVal("status");
                obj.agentnotupgrade = modal.checkVal("agentnotupgrade") ? 0 : 1;
                obj.agentlevel = modal.getVal("agentlevel", true);
                obj.agentselectgoods = modal.getVal("agentselectgoods", true)
            }
            if (modal.bind) {
                if (!modal.binded || modal.mobile == '') {
                    obj.password = modal.getVal("password");
                    obj.mobileverify = modal.checkVal("mobileverify");
                    if (obj.mobileverify == 1 && obj.mobile == '') {
                        FoxUI.toast.show("开启绑定前请先填写手机号");
                        return
                    }
                    if (obj.mobileverify == 1 && obj.password == '') {
                        FoxUI.toast.show("开启绑定前请为用户设置密码");
                        return
                    }
                }
                if (modal.getVal("password")!='' && modal.binded){
                    obj.password = modal.getVal("password");
                }

            }
            core.json('mmanage/member/detail', obj, function (json) {
                if (json.status == 1) {
                    FoxUI.toast.show("操作成功")
                } else {
                    FoxUI.toast.show(json.result.message)
                }
                modal.stop = false
            }, true, true)
        });
        $(".submit-params").unbind('click').click(function () {
            var action = modal.paction;
            if (!action) {
                modal.hideParams();
                return
            }
            if (action == 'level' || action == 'group' || action == 'agentlevel') {
                var value = $(this).data('value');
                $("#" + action).val(value);
                var text = $(this).find(".fui-cell-text").text();
                $(".check-param[data-action='" + action + "']").find('.fui-cell-info').text(text)
            } else if (action == 'goods') {
                var value = $(this).data('value');
                $("#agentselectgoods").val(value);
                var text = $(this).find(".fui-cell-text").text();
                $(".check-param[data-action='" + action + "']").find('.fui-cell-remark').text(text)
            }
            modal.hideParams()
        })
    };
    modal.showParams = function () {
        if (!modal.paction) {
            return
        }
        $(".params-block .fui-navbar .cancel-params").css('display', 'table-cell');
        var params_item = $(".params-block").find(".param-" + modal.paction);
        if (params_item.length < 1) {
            return
        }
        params_item.show();
        $(".params-block").addClass('in');
        $(".btn-back").hide()
    };
    modal.hideParams = function () {
        $(".params-block .fui-navbar .nav-item").hide();
        $(".params-block").find(".param-item").hide();
        $(".params-block").removeClass('in');
        $(".btn-back").show();
        modal.paction = false
    };
    modal.getVal = function (elm, int, isClass) {
        var mark = isClass ? "." : "#";
        var value = $.trim($(mark + elm).val());
        if (int) {
            if (value == '') {
                return 0
            }
            value = parseInt(value)
        }
        return value
    };
    modal.checkVal = function (elm, isClass) {
        var mark = isClass ? "." : "#";
        var checked = $(mark + elm).is(":checked") ? 1 : 0;
        return checked
    };
    modal.initRecharge = function () {
        $("#tab a").unbind('click').click(function () {
            var type = parseInt($(this).data('type'));
            $("#type").val(type);
            var text = type == 1 ? "积分" : "余额";
            $(".credit_text").text(text);
            $(this).addClass("active").siblings().removeClass("active")
        });
        $(".check-param").unbind('click').click(function () {
            var action = $(this).data('action');
            if (action) {
                modal.paction = action;
                modal.showParams()
            }
        });
        $(".cancel-params").unbind('click').click(function () {
            modal.hideParams()
        });
        $(".submit-params").unbind('click').click(function () {
            var action = modal.paction;
            if (!action) {
                modal.hideParams();
                return
            }
            if (action == 'changetype') {
                var value = $(this).data('value');
                $("#changetype").val(value);
                var html = $(this).find(".fui-cell-text").html();
                $(".check-param[data-action='changetype']").find('.fui-cell-info').html(html)
            }
            modal.hideParams()
        });
        $("#btn-submit").unbind('click').click(function () {
            if (modal.stop) {
                return
            }
            var num = $.trim($("#num").val());
            if (num == '') {
                FoxUI.toast.show("请填写充值数目");
                return
            }
            num = parseFloat(num);
            if (num <= 0) {
                FoxUI.toast.show("请填写大于0.01的数值");
                return
            }
            var nickname = $("#nickname").text();
            var changetype = parseInt($("#changetype").val());
            var type = parseInt($("#type").val());
            var type_text = type == 1 ? "积分" : "余额";
            var confirm_text = "确定为用户“" + nickname + "”" + "增加 " + num + " " + type_text + "吗？";
            if (changetype == 1) {
                confirm_text = "确定为用户“" + nickname + "”" + "减少 " + num + " " + type_text + "吗？"
            } else if (changetype == 2) {
                confirm_text = "确定将用户“" + nickname + "”" + "的最终" + type_text + "设置为 " + num + " 吗？"
            }
            var obj = {num: num, changetype: changetype, type: type};
            obj.id = parseInt($("#mid").val());
            FoxUI.confirm(confirm_text, function () {
                modal.stop = true;
                core.json('mmanage/member/recharge', obj, function (json) {
                    if (json.status == 1) {
                        FoxUI.toast.show("操作成功");
                        location.reload()
                    } else {
                        FoxUI.toast.show(json.result.message);
                        modal.stop = false
                    }
                }, true, true)
            })
        })
    };
    return modal
});