define(['core', 'tpl'], function (core, tpl) {
    var modal = {page: 1, cashierid: 0,starttime:0,endtime:0,type:0};
    modal.init = function (params) {
        modal.cashierid = params.cashierid;
        modal.type = params.type;
        modal.starttime = params.starttime;
        modal.endtime = params.endtime;

        $("#select").unbind('change').change(function () {
            var $type = $("#type1");
            $type.hide();
            if (this.value == '1'){
                $type.show();
            }
        });
        $('.fui-content').infinite({
            onLoading: function () {
                modal.getList()
            }
        });
        if (modal.page == 1) {
            modal.getList()
        }
    };

    modal.getList = function () {
        core.json('cashier/manage/get_list', {page: modal.page,type: modal.type, cashierid: modal.cashierid,starttime:modal.starttime,endtime:modal.endtime}, function (ret) {
            var result = ret.result;
            $('#total').html(result.total);
            $('#money').html(result.money);
            if (result.total <= 0) {
                $('.content-empty').show();
                $('#container').hide();
                $('.fui-content').infinite('stop')
            } else {
                $('#container').show();
                $('.content-empty').hide();
                $('.fui-content').infinite('init');
                if (result.list.length <= 0 || result.list.length < result.pagesize) {
                    $('.fui-content').infinite('stop')
                }
            }
            modal.page++;
            core.tpl('#container', 'tpl_cashier_manage_list', result, modal.page > 1)
        })
    };
    return modal;
});