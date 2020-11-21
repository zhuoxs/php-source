define(['core'], function (core) {
    var modal = {page: 1, status: 'sale', offset: 0, keywords: ''};
    modal.initList = function () {
        modal.initClick();
        var leng = $.trim($('.container').html());
        if (leng == '') {
            modal.page = 1;
            modal.getList();
        }
        $('.fui-content').infinite({
            onLoading: function () {
                modal.getList()
            }
        })
    };
    modal.initClick = function () {
        $(document).off('click', '.container .fui-list .fui-list-media,.fui-list .fui-list-inner');
        $(document).on('click', '.container .fui-list .fui-list-media,.fui-list .fui-list-inner', function () {
            var mid = $(this).closest('.fui-list').data('id');
            var canJump = $(this).closest('.fui-list').data('can');
            if (mid && canJump) {
                $.router.load(core.getUrl('mmanage/member/detail', {id: mid}), true)
            }
        });
        $(".searchbtn").unbind('click').click(function () {
            var keywords = $.trim($("#keywords").val());
            if (keywords != '') {
                modal.keywords = keywords;
                modal.page = 1;
                $(".container").empty();
                modal.getList()
            }
        });
        $("#keywords").bind('input propertychange', function () {
            var keywords = $.trim($(this).val());
            if (keywords == '') {
                modal.keywords = '';
                modal.page = 1;
                modal.offset = 0;
                $(".container").empty();
                modal.getList()
            }
        })
    };
    modal.getList = function () {
        var obj = {page: modal.page, status: modal.status, keywords: modal.keywords, offset: modal.offset};
        core.json('mmanage/member/getlist', obj, function (json) {
            if (json.status != 1) {
                return
            }
            var result = json.result;
            if (result.total < 1) {
                $('#content-empty').show();
                $('#content-nomore').hide();
                $('#content-more').hide();
                $('.fui-content').infinite('stop')
            } else {
                $('#content-empty').hide();
                $('.fui-content').infinite('init');
                if (result.list.length <= 0 || result.list.length < result.pagesize) {
                    $('#content-more').hide();
                    $("#content-nomore").show();
                    $("#content-empty").hide();
                    $('.fui-content').infinite('stop')
                } else {
                    $("#content-nomore").hide()
                }
            }
            modal.page++;
            result.status = modal.status;
            core.tpl('.container', 'tpl_member', result, modal.page > 1);
            FoxUI.loader.hide()
        }, false, true)
    };
    return modal
});