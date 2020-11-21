define(['core', 'tpl', 'biz/order/op'], function(core, tpl, op) {
    var modal = {
        page: 1,
        status: '',
        merchid: 0
    };
    modal.init = function(params) {
        modal.status = params.status;
        modal.merchid = params.merchid;
        op.init();

        $('.icon-delete').click(function() {
            $('.fui-tab-danger a').removeClass('active');
        });
    };
    return modal
});