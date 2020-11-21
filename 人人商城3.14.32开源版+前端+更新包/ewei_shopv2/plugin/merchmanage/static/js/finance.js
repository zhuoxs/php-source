define(['core'], function (core) {
    var modal = {page: 1, type: 0};
    modal.initList = function (params) {
        modal.type = params.type;
        modal.initClick();
        modal.getList();
        $('.fui-content').infinite({
            onLoading: function () {
                modal.getList()
            }
        })
    };
    modal.initClick = function () {
        $("#tab a").unbind('click').click(function () {
            var type = $(this).data("tab");
            if (modal.type == type) {
                return
            }
            modal.type = type;
            $(this).addClass("active").siblings().removeClass("active");
            modal.page = 1;
            $(".container").empty();
            modal.getList()
        });
        $(".searchbtn").unbind('click').click(function () {
            var keywords = $.trim($("#keywords").val());
            if (keywords != '') {
                modal.keywords = keywords;
                modal.page = 1;
                $(".container").empty();
                modal.getList()
            }
        });
        $("#keywords").bind('input propertychange', function () {
            var keywords = $.trim($(this).val());
            if (keywords == '') {
                modal.keywords = '';
                modal.page = 1;
                modal.offset = 0;
                $(".container").empty();
                modal.getList()
            }
        });
        $(document).off('click', '.btn-refund');
        $(document).on('click', '.btn-refund', function () {
            if (modal.stop) {
                return
            }
            var _this = $(this);
            var logid = $(this).closest(".fui-list-group").data('id');
            var rechargetype = $(this).closest(".fui-list-group").data('rechargetype');
            var confirm_text = rechargetype == 'alipay' ? "支付宝" : "微信";
            confirm_text = "确定要退款到 " + confirm_text + " 中吗？";
            var obj = {id: logid};
            FoxUI.confirm(confirm_text, function () {
                modal.stop = true;
                core.json("merchmanage/finance/refund", obj, function (json) {
                    if (json.status == 1) {
                        _this.closest(".fui-list-group").find(".label-status").removeClass("fui-label-success").addClass("fui-label-danger").text("退款");
                        _this.closest(".fui-list").remove()
                    } else {
                        FoxUI.toast.show(json.result.message)
                    }
                    modal.stop = false
                }, true, true)
            })
        });
        $(document).off('click', '.btn-apply');
        $(document).on('click', '.btn-apply', function () {
            if (modal.stop) {
                return
            }
            var _this = $(this);
            var logid = $(this).closest(".fui-list-group").data('id');
            var type = $(this).data('type');
            var typestr = "";
            if (type == 'alipay') {
                typestr = "提现到 支付宝"
            } else if (type == 'wechat') {
                typestr = "提现到 微信"
            } else if (type == 'manual') {
                typestr = "手动提现"
            } else if (type == 'refuse') {
                typestr = "拒绝提现申请"
            }
            var confirm_text = "确定要 " + typestr + " 吗？";
            var obj = {id: logid};
            if (type == 'alipay' || type == 'wechat' || type == 'manual' || type == 'refuse') {
                FoxUI.confirm(confirm_text, function () {
                    modal.stop = true;
                    core.json("merchmanage/finance/" + type, obj, function (json) {
                        if (json.status == 1) {
                            if (type == 'refuse') {
                                _this.closest(".fui-list-group").find(".label-status").removeClass("fui-label-default").addClass("fui-label-danger").text("拒绝提现")
                            } else {
                                _this.closest(".fui-list-group").find(".label-status").removeClass("fui-label-default").addClass("fui-label-success").text("提现成功")
                            }
                            _this.closest(".fui-list").remove()
                        } else {
                            FoxUI.toast.show(json.result.message)
                        }
                    }, true, true)
                })
            } else {
                FoxUI.toast.show("请求参数错误")
            }
        })
    };
    modal.getList = function () {
        var obj = {page: modal.page, type: modal.type, keyword: modal.keywords};
        core.json('merchmanage/finance/getlist', obj, function (json) {
            if (json.status != 1) {
                return
            }
            var result = json.result;
            if (result.total < 1) {
                $('#content-empty').show();
                $('#content-nomore').hide();
                $('#content-more').hide();
                $('.fui-content').infinite('stop')
            } else {
                $('#content-empty').hide();
                $('.fui-content').infinite('init');
                if (result.list.length <= 0 || result.list.length < result.pagesize) {
                    $('#content-more').hide();
                    $("#content-nomore").show();
                    $("#content-empty").hide();
                    $('.fui-content').infinite('stop')
                } else {
                    $("#content-nomore").hide()
                }
            }
            modal.page++;
            result.status = modal.status;
            result.type = modal.type;
            if (modal.type == 2 || modal.type == 3) {
                core.tpl('.container_c', 'tpl_credit', result, modal.page > 1)
            } else {
                core.tpl('.container_l', 'tpl_log_' + modal.type, result, modal.page > 1)
            }
            FoxUI.loader.hide()
        }, false, true)
    };
    return modal
});