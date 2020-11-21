define(['core', 'tpl'], function (core, tpl) {
    var modal = {page: 1};
    modal.init = function (params) {
        modal.page = 1;
        modal.type = "orderday";

        $(".container").empty();
        modal.getList()

        $('.fui-content').infinite({
            onLoading: function () {
                modal.getList()
            }
        });
        $(".fui-tab a").unbind('click').click(function () {
            modal.type = $(this).data('type');
            $(this).addClass('active').siblings().removeClass('active');
            modal.page = 1;
            $(".container").empty();
            modal.getList()
        })
    };
    modal.getList = function () {
        core.json('sign/getRank', {type: modal.type, page: modal.page}, function (ret) {
            var result = ret.result;
            if (result.total <= 0) {
                $('.content-empty').show();
                $('.fui-content').infinite('stop')
            } else {
                $(".container").show();
                $('.content-empty').hide();
                $('.fui-content').infinite('init');
                if (result.list.length <= 0 || result.list.length < result.pagesize) {
                    $('.fui-content').infinite('stop')
                }
            }
            modal.page++;
            result.num = result.pagesize * modal.page - 19;
            core.tpl('.container', 'record_tpl', result, modal.page > 1)
        })
    };
    return modal
});