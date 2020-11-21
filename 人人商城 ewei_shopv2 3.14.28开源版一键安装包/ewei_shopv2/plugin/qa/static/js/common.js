define(['core', 'tpl'], function (core, tpl) {
    var modal = {page: 1};

    modal.init = function (params) {
        modal.cate = params.cate;
        modal.keyword = params.keyword;
        modal.isrecommand = params.isrecommand;

        modal.toDetail2 = false;

        if (!modal.toDetail1) {
            modal.page = 1;
            modal.getList();
        } else {
            modal.toDetail1 = false
        }

        $('.fui-content').infinite({
            onLoading: function () {
                modal.getList();
            }
        });

        $(document).off('click', '#container .fui-list, a');
        $(document).on('click', '#container .fui-list, a', function () {
            modal.toDetail1 = true;
        });

    };

    modal.initList = function (params) {
        modal.cate = params.cate;
        modal.keyword = params.keyword;
        modal.isrecommand = 0;

        if (!modal.toDetail2) {
            modal.page = 1;
            modal.getList();
        } else {
            modal.toDetail2 = false
        }

        $('.fui-content').infinite({
            onLoading: function () {
                modal.getList();
            }
        });

        $(document).off('click', '#container .fui-list, a');
        $(document).on('click', '#container .fui-list, a', function () {
            modal.toDetail2 = true;
        });

    };
    modal.getList = function () {
        core.json('qa/getlist', {
            page: modal.page,
            cate: modal.cate,
            keyword: modal.keyword,
            isrecommand: modal.isrecommand
        }, function (ret) {
            var result = ret.result;
            if (result.total <= 0) {
                //$('.question-title').hide();
                $("#container").hide();
                $('.fui-content').infinite('stop')
                $(".empty").show();
            } else {
                $('.question-title').show();
                $("#container").show();
                $(".empty").hide();
                $('.fui-content').infinite('init');
                if (result.list.length <= 0 || result.list.length < result.pagesize) {
                    $('.fui-content').infinite('stop')
                }
            }
            modal.page++;
            core.tpl('#container', 'tpl_list', result, modal.page > 1);
            FoxUI.according.init();
            $('#container').lazyload();
        })
    };
    return modal
});