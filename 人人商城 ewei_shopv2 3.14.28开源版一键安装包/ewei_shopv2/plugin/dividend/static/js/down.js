define(['core', 'tpl'], function (core, tpl) {
    var modal = {page: 1};
    modal.init = function () {
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
        core.json('dividend/down/get_list', {page: modal.page}, function (ret) {
            var result = ret.result;
            if (result.total <= 0) {
                $('#container').hide();
                $('.content-empty').show();
                $('.fui-title').hide();
                $('.fui-content').infinite('stop')
            } else {
                $('#container').show();
                $('.content-empty').hide();
                $('.fui-title').show();
                $('.fui-content').infinite('init');
                if (result.list.length <= 0 || result.list.length < result.pagesize) {
                    $('.fui-content').infinite('stop')
                }
            }
            modal.page++;
            core.tpl('#container', 'tpl_dividend_down_list', result, modal.page > 1)
        })
    };
    return modal
});