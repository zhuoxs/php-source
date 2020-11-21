define(['core', 'tpl'], function (core, tpl) {
    var modal = {page: 1, status: ''};
    modal.init = function (params) {

        modal.status = params.status;
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
        core.json('abonus/bonus/get_list', {page: modal.page, status: modal.status}, function (ret) {
            var result = ret.result;
            $('#total').html(result.total);
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
            core.tpl('#container', 'tpl_abonus_bonus_list', result, modal.page > 1)
        })
    };
    return modal;
});