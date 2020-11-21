define(['core', 'tpl'], function (core, tpl) {
    var modal = {roomid: 0, start: 0, end: 0};
    modal.init = function (params) {
        modal.roomid = params.roomid;
        modal.start = params.start;
        modal.end = params.end;
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
            modal.cate = $(this).attr("data-status");
            modal.changeTab(modal.cate)
        })
    };
    modal.getList = function (keyword) {
        $(".content-loading").show();
        core.json('live/room/statistics_goodslist', {
            page: modal.page,
            cate: modal.cate,
            keywords: modal.keywords
        }, function (ret) {
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