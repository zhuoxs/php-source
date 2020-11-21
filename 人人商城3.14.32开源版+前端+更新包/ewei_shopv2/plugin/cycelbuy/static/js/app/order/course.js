define(['core', 'tpl'], function (core, tpl) {
    var modal = {params: {}};
    modal.init = function () {
        $('.btn-cancel').click(function () {
            if ($(this).attr('stop')) {
                return
            }
            FoxUI.confirm('确定您要取消申请?', '', function () {
                $(this).attr('stop', 1).attr('buttontext', $(this).html()).html('正在处理..');
                core.json('cycelbuy/order/deferred/del', {id: $( '#id' ).val() }, function (postjson) {
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
    };
    return modal
});