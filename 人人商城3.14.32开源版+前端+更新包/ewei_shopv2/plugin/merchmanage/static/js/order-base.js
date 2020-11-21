define(['core'], function (core) {
    var modal = {};
    modal.init = function () {
        $(document).off('click', '.order-btn');
        $(document).on('click', '.order-btn', function () {
            var action = $(this).data('action');
            var orderid = $(this).data('orderid');
            if (action == '' || orderid == '') {
                FoxUI.toast.show("参数错误");
                return
            }
            if (action == 'send' || action == 'remarksaler' || action == 'sendcancel' || action == 'refund') {
                $.router.load(core.getUrl('merchmanage/order/op/' + action, {id: orderid}), true);
                return
            } else if (action == 'payorder') {
                confirm_text = "确认此订单已付款吗？"
            } else if (action == 'fetch') {
                confirm_text = "确认取货吗？"
            } else if (action == 'finish') {
                confirm_text = "确认订单收货吗？"
            } else {
                FoxUI.toast.show("参数错误");
                return
            }
            var obj = {orderid: orderid};
            FoxUI.confirm(confirm_text, function () {
                core.json("merchmanage/order/op/" + action, obj, function (json) {
                    if (json.status == 1) {
                        FoxUI.toast.show("操作成功");
                        location.reload()
                    } else {
                        FoxUI.toast.show(json.result.message)
                    }
                }, true, true)
            })
        })
    };
    return modal
});