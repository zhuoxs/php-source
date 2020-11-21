define(['core', 'tpl'], function (core, tpl) {
    var modal = {params: {}};
    modal.init = function () {
        $('.btn-cancel').click(function () {
            if ($(this).attr('stop')) {
                return
            }
            FoxUI.confirm('确定您要取消申请?', '', function () {
                $(this).attr('stop', 1).attr('buttontext', $(this).html()).html('正在处理..');
                core.json('cycelbuy/order/list/cancelApply', {applyid: $( '#applyid' ).val() }, function (postjson) {
                    if (postjson.status == 1) {
                        history.back();
                        return
                    } else {
                        FoxUI.toast.show('取消失败')
                    }
                    $('.btn-cancel').removeAttr('stop').html($('.btn-cancel').attr('buttontext')).removeAttr('buttontext')
                }, true, true)
            })
        });

        $('#express_submit').click(function () {
            if ($(this).attr('stop')) {
                return
            }
            if ($('#expresssn').isEmpty()) {
                FoxUI.toast.show('请填写快递单号');
                return
            }
            $(this).html('正在处理...').attr('stop', 1);
            core.json('order/refund/express', {
                id: modal.params.orderid,
                refundid: modal.params.refundid,
                express: $('#express').val(),
                expresscom: $('#expresscom').val(),
                expresssn: $('#expresssn').val()
            }, function (postjson) {
                if (postjson.status == 1) {
                    location.href = core.getUrl('order/detail', {id: modal.params.orderid})
                } else {
                    $('#express_submit').html('确认').removeAttr('stop');
                    FoxUI.toast.show(postjson.result.message)
                }
            }, true, true)
        });
    };
    return modal
});