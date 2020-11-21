$(document).on('click', '#btn-submit-cycle', function () {
    if ($(this).attr('submit')) {
        return
    }
    if ($('#realname').isEmpty()) {
        FoxUI.toast.show("请填写收件人");
        return
    }
    var jingwai = /(境外地区)+/.test($('#areas').val());
    var taiwan = /(台湾)+/.test($('#areas').val());
    var aomen = /(澳门)+/.test($('#areas').val());
    var xianggang = /(香港)+/.test($('#areas').val());
    if (jingwai || taiwan || aomen || xianggang) {
        if ($('#mobile').isEmpty()) {
            FoxUI.toast.show("请填写手机号码");
            return
        }
    } else {
        if (!$('#mobile').isMobile()) {
            FoxUI.toast.show("请填写正确手机号码");
            return
        }
    }
    if ($('#areas').isEmpty()) {
        FoxUI.toast.show("请填写所在地区");
        return
    }
    if ($('#address').isEmpty()) {
        FoxUI.toast.show("请填写详细地址");
        return
    }
    $('#btn-submit-cycle').html('正在处理...').attr('submit', 1);
    window.editAddressData = {
        realname: $('#realname').val(),
        mobile: $('#mobile').val(),
        address: $('#address').val(),
        areas: $('#areas').val(),
        street: $('#street').val(),
        streetdatavalue: $('#street').attr('data-value'),
        datavalue: $('#areas').attr('data-value'),
    };
    core.json('cycelbuy/order/list/submit', {
        id: $('#addressid').val(),
        orderid:$( '#orderid' ).val(),
        ordersn:$('#ordersn').val(),
        applyid:$('#applyid').val(),
        addressdata: window.editAddressData,
        cycleid:$('#cycleid').val(),
        isall: $('#isall').val(),
    }, function (json) {
        $('#btn-submit-cycle').html('提交申请').removeAttr('submit');
        window.editAddressData.id = json.result.addressid;
        if (json.status == 1) {
            FoxUI.toast.show(json.result.message);
            history.back()
        } else {
            FoxUI.toast.show(json.result.message)
        }
    }, true, true)
});


$('*[data-toggle=delete]').unbind('click').click(function () {
    var item = $(this).closest('.address-item');
    var id = item.data('addressid');
    if (!id) {
        id = $(this).data("addressid");
        var i = id
    }
    FoxUI.confirm('删除后无法恢复, 确认要删除吗 ?', function () {
        core.json('cycelbuy/order/delete', {id: id}, function (ret) {
            if (ret.status == 1) {
                if (ret.result.defaultid) {
                    $("[data-addressid='" + ret.result.defaultid + "']").find(':radio').prop('checked', true)
                }
                item.remove();
                setTimeout(function () {
                    if ($(".address-item").length <= 0) {
                        $('.content-empty').show()
                    }
                }, 100);
                return
            }
            FoxUI.toast.show(ret.result.message)
        }, true, true);
        if (id == i) {
            // window.history.back()
        }
    })
});