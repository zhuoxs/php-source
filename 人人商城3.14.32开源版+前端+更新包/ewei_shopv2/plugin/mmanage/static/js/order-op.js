define(['core'], function (core) {
    var modal = {orderid: 0};
    modal.initRemark = function (params) {
        modal.orderid = params.orderid;
        $(".cancel-params").unbind('click').click(function () {
            window.history.back()
        });
        $(".submit-params").unbind('click').click(function () {
            if (modal.stop) {
                return
            }
            var obj = {id: modal.orderid, remarksaler: modal.getVal('remarksaler')};
            FoxUI.confirm("确定保存修改吗？", function () {
                modal.stop = true;
                core.json("mmanage/order/op/remarksaler", obj, function (json) {
                    modal.stop = false;
                    if (json.status != 1) {
                        FoxUI.toast.show(json.result.message)
                    } else {
                        FoxUI.toast.show("保存成功");
                        setTimeout(function () {
                            window.remarksaler = obj.remarksaler != '' ? 1 : 2;
                            window.orderid = obj.id;
                            window.history.back()
                        }, 500)
                    }
                }, true, true)
            })
        })
    };
    modal.initAddress = function (params) {
        modal.orderid = params.orderid;
        $(".toggle").unbind('click').click(function () {
            var _this = $(this);
            var check = _this.data('toggle-check');
            var show = _this.data('show');
            var hide = _this.data('hide');
            if (check) {
                var checked = _this.is(":checked");
                if (checked) {
                    $("." + hide).hide();
                    $("." + show).show()
                } else {
                    $("." + show).hide();
                    $("." + hide).show()
                }
            } else {
                $("." + hide).hide();
                $("." + show).show()
            }
        });
        $(".cancel-params").unbind('click').click(function () {
            window.history.back()
        });
        $(".submit-params").unbind('click').click(function () {
            if (modal.stop) {
                return
            }
            var obj = {
                id: modal.orderid,
                realname: modal.getVal('sel-realname'),
                mobile: modal.getVal('sel-mobile'),
                changead: modal.checkVal('changead')
            };
            if (obj.changead) {
                obj.province = modal.selectVal('sel-provance');
                obj.city = modal.selectVal('sel-city');
                obj.area = modal.selectVal('sel-area');
                obj.street = modal.selectVal('sel-street');
                obj.address = modal.getVal('sel-address');
                if (obj.province == '') {
                    FoxUI.toast.show('请选择省份');
                    return
                }
                if (obj.city == '') {
                    FoxUI.toast.show('请选择城市');
                    return
                }
                if (obj.area == '') {
                    FoxUI.toast.show('请选择区/县');
                    return
                }
                if (obj.address == '') {
                    FoxUI.toast.show('请填写详细地址');
                    return
                }
            }
            FoxUI.confirm("确定要修改收货信息吗？", function () {
                modal.stop = true;
                core.json("mmanage/order/op/changeaddress", obj, function (json) {
                    if (json.status != 1) {
                        FoxUI.toast.show(json.result.message);
                        modal.stop = false
                    } else {
                        FoxUI.toast.show("修改成功");
                        setTimeout(function () {
                            window.history.back()
                        }, 500)
                    }
                }, true, true)
            })
        })
    };
    modal.initSend = function (params) {
        modal.orderid = params.orderid;
        modal.flag = params.flag;
        modal.bundles = params.bundles;

        $("#btn-qrcode").unbind('click').click(function () {
            wx.scanQRCode({
                needResult: 1, scanType: ["barCode"], success: function (res) {
                    if (res.errMsg != "scanQRCode:ok") {
                        FoxUI.toast.show(res.errMsg);
                        return
                    }
                    var text = res.resultStr.split(',')[1];
                    $("#expresssn").val(text);
                    FoxUI.toast.show("扫描成功")
                }
            })
        });
        $("#myTab a").unbind('click').click(function () {
            var tab = $(this).data('tab');
            $(this).addClass('active').siblings().removeClass('active');
            $(".tab-pane").hide();
            $("#" + tab).show()
        });
        $(".check-group .fui-list .fui-list-media,.check-group .fui-list .fui-list-inner").unbind('click').click(function () {
            var item = $(this).closest('.fui-list').find('.fui-list-media');
            var checkbox = item.find("input");
            if (checkbox.is(":checked")) {
                checkbox.removeAttr('checked')
            } else {
                checkbox.prop('checked', 'checked')
            }
        });
        $(".toggle").unbind('click').click(function () {
            var _this = $(this);
            var check = _this.data('toggle-check');
            var show = _this.data('show');
            var hide = _this.data('hide');
            if (check) {
                var checked = _this.is(":checked");
                if (checked) {
                    $("." + hide).hide();
                    $("." + show).show()
                } else {
                    $("." + show).hide();
                    $("." + hide).show()
                }
            } else {
                $("." + hide).hide();
                $("." + show).show()
            }
        });
        $(".cancel-params").unbind('click').click(function () {
            window.history.back()
        });
        $(".submit-params").unbind('click').click(function () {
            if (modal.stop) {
                return
            }
            var express = modal.selectVal('express', true);
            var expresscom = modal.selectVal('express');
            var expresssn = modal.getVal('expresssn');

            var express_name=$("#express").find("option:selected").text();
            if (expresssn == '' && express_name !='同城配送') {
                FoxUI.toast.show("请输入快递单号");
                return
            }
            var obj = {
                id: modal.orderid,
                express: express,
                expresssn: expresssn,
                expresscom: expresscom,
                sendtype: modal.checkVal('sendtype')
            };
            if (obj.sendtype == 1) {
                obj.sendgoodsids = modal.checkVals('.parcel .fui-list input', true);
                if (obj.sendgoodsids == '') {
                    FoxUI.toast.show("请选择发货商品");
                    return
                }
            }
            var confirm_text = "确定要为此订单发货吗？";
            var route = "send";
            if (modal.flag == 1) {
                if(params.bundles==1){
                    obj.bundles = modal.checkVals(".check-group input", true);
                    if (obj.bundles == '') {
                        FoxUI.toast.show("请选择修改物流的包裹");
                        return
                    }
                    confirm_text = "确定修改选定包裹物流吗？";
                }else{
                    confirm_text = "确定修改物流吗？";
                }
                route = "changeexpress"
            }
            FoxUI.confirm(confirm_text, function () {
                modal.stop = true;
                core.json("mmanage/order/op/" + route, obj, function (json) {
                    if (json.status != 1) {
                        FoxUI.toast.show(json.result.message)
                    } else {
                        FoxUI.toast.show(modal.flag == 1 ? "修改物流成功" : "发货成功");
                        setTimeout(function () {
                            window.backreload = true;
                            window.history.back()
                        }, 500)
                    }
                    modal.stop = false
                }, true, true)
            })
        })
    };
    modal.initCancel = function (params) {
        modal.orderid = params.orderid;
        modal.bundle = params.bundle;
        $(".cancel-params").unbind('click').click(function () {
            window.history.back()
        });
        $(".submit-params").unbind('click').click(function () {
            if (modal.stop) {
                return
            }
            var obj = {id: modal.orderid, remark: modal.getVal("remarksend")};
            var confirm_text = "确定为此订单取消发货吗？";
            if (modal.bundle) {
                confirm_text = "确定要为选中包裹取消发货吗";
                obj.bundles = modal.checkVals(".check-group input", true);
                if (obj.bundles == '') {
                    FoxUI.toast.show("请选择取消发货的包裹");
                    return
                }
            }
            FoxUI.confirm(confirm_text, function () {
                modal.stop = true;
                core.json("mmanage/order/op/sendcancel", obj, function (json) {
                    if (json.status != 1) {
                        FoxUI.toast.show(json.result.message);
                        modal.stop = false
                    } else {
                        FoxUI.toast.show("取消发货成功");
                        setTimeout(function () {
                            window.history.back()
                        }, 500)
                    }
                }, true, true)
            })
        })
    };
    modal.initPrice = function (params) {
        modal.orderid = params.orderid;
        $(".cancel-params").unbind('click').click(function () {
            window.history.back()
        })
    };
    modal.initRefund = function (params) {
        modal.orderid = params.orderid;
        $(".fui-navbar:not(.params) .cancel-params").unbind('click').click(function () {
            window.history.back()
        });
        $(".fui-navbar.params .cancel-params").unbind('click').click(function () {
            modal.hideParams()
        });
        $(".submit-params").unbind('click').click(function () {
            if (modal.stop) {
                return
            }
            var obj = {id: modal.orderid, refundstatus: modal.radioVal('refundstatus', true)};
            if (!obj.refundstatus) {
                FoxUI.toast.show("请选择处理结果");
                return
            }
            if (obj.refundstatus == -1) {
                obj.refundcontent = modal.getVal('refundcontent');
                if (!obj.refundcontent || obj.refundcontent == '') {
                    FoxUI.toast.show("请填写驳回原因");
                    return
                }
            }
            FoxUI.confirm("确认提交吗？", function () {
                modal.stop = true;
                core.json("mmanage/order/op/refund", obj, function (json) {
                    if (json.status != 1) {
                        FoxUI.toast.show(json.result.message);
                        modal.stop = false
                    } else {
                        FoxUI.toast.show("提交成功");
                        setTimeout(function () {
                            window.history.back()
                        }, 500)
                    }
                }, true, true)
            })
        });
        $(".check-param").unbind('click').click(function () {
            var action = $(this).data('action');
            if (action) {
                modal.paction = action;
                modal.showParams()
            }
        });
        $(".radio-group .fui-list").unbind('click').click(function () {
            var item = $(this).closest('.fui-list').find('.fui-list-media');
            var radio = item.find("input");
            if (!radio.is(":checked")) {
                radio.prop('checked', 'checked')
            }
            if (radio.val() == 1) {
                $(".help-group").show()
            } else {
                $(".help-group").hide()
            }
            if (radio.val() == -1) {
                $(".refuse-group").show()
            } else {
                $(".refuse-group").hide()
            }
        })
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
    modal.selectVal = function (elm, isVal) {
        if (isVal) {
            return $("#" + elm).find('option:selected').val()
        }
        return $("#" + elm).find('option:selected').text()
    };
    modal.checkVal = function (elm, isClass) {
        var mark = isClass ? "." : "#";
        var checked = $(mark + elm).is(":checked") ? 1 : 0;
        return checked
    };
    modal.checkVals = function (elm, isStr) {
        var arr = [];
        $(elm).each(function () {
            var id = $(this).val();
            var checked = $(this).is(":checked");
            if (checked && id) {
                arr.push(id)
            }
        });
        if (isStr) {
            return arr.join(",")
        }
        return arr
    };
    modal.radioVal = function (name, int) {
        if (!name || name == '') {
            return int ? 0 : ''
        }
        var value = $("input[name='" + name + "']:checked").val();
        return value
    };
    modal.showParams = function () {
        if (!modal.paction) {
            return
        }
        $(".params-block .fui-navbar .cancel-params").css('display', 'table-cell');
        if (modal.paction == 'submit') {
            $(".params-block .fui-navbar .submit-params").css('display', 'table-cell')
        }
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
        modal.paction = false;
        modal.orderid = 0
    };
    return modal
});