define(['core', 'tpl'], function (core, tpl) {
    var modal = {page: 1, cate: 0, keywords: ''};
    modal.init = function (params) {
        modal.page = params.page;
        modal.cate = params.cate;
        modal.keywords = params.keywords;
        $('.fui-content').infinite({
            onLoading: function () {
                modal.getList()
            }
        });
        if (modal.page == 1) {
            $('#container').html('');
            modal.getList(modal.keywords)
        }
        ;
        $("#tab a").off("click").on("click", function () {
            $(this).addClass("active").siblings().removeClass("active");
            modal.type = $(this).attr("data-type");
            modal.changeTab(modal.type)
        })
    };
    modal.changeTab = function (type) {
        $('.fui-content').infinite('init');
        $('.content-empty').hide(), $('#container').html(''), $('.infinite-loading').show();
        modal.page = 1, modal.type = type, modal.getList()
    };
    modal.getList = function (keyword) {
        $(".content-loading").show();
        core.json('live/follow/get_list', {page: modal.page, type: modal.type}, function (ret) {
            var result = ret.result;
            if (result.total <= 0) {
                $('.content-empty').show();
                $('.fui-content').infinite('stop')
            } else {
                $('.content-empty').hide();
                $('.fui-content').infinite('init');
                if (result.list.length <= 0 || result.list.length < result.pagesize) {
                    $('.fui-content').infinite('stop')
                }
            }
            modal.page++;
            core.tpl('#container', 'tpl_live_list', result, modal.page > 1);
            $(".content-loading").hide()
        })
    };
    return modal
});