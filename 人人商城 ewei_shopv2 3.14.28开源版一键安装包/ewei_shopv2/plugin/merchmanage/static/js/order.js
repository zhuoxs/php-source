define(['core', './order-base.js'], function (core, obase) {
    var modal = {page: 1, status: 0, offset: 0, keywords: ''};
    modal.initList = function (params) {
        modal.status = params.status;
        modal.keywords = params.keywords;
        modal.initClick();
        obase.init();
        if (window.orderid) {
            var elm = $(document).find(".fui-list-group[data-order='" + window.orderid + "']");
            if (window.remarksaler == 1) {
                elm.find(".icon-pin").show()
            } else if (window.remarksaler == 2) {
                elm.find(".icon-pin").hide()
            }
        }
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
        $("#tab a").unbind('click').click(function () {
            var status = $(this).data("status");
            if (modal.status == status) {
                return
            }
            modal.status = status;
            $(this).addClass("active").siblings().removeClass("active");
            modal.page = 1;
            $(".container").empty();
            modal.getList()
        });
        $(".fui-search-btn").unbind('click').click(function () {
            var keywords = $.trim($("#keywords").val());
            if (keywords == '') {
                FoxUI.toast.show("请输入搜索关键字");
                return
            }
            modal.keywords = keywords;
            modal.page = 1;
            $(".container").empty();
            modal.getList()
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
        var obj = {page: modal.page, status: modal.status, keyword: modal.keywords, offset: modal.offset};
        if (obj.keyword != '') {
            obj.searchfield = modal.selectVal('searchfieid', true)
        }
        core.json('merchmanage/order/getlist', obj, function (json) {
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
            core.tpl('.container', 'tpl_order', result, modal.page > 1);
            FoxUI.loader.hide()
        }, false, true)
    };
    modal.selectVal = function (elm, isVal) {
        if (isVal) {
            return $("#" + elm).find('option:selected').val()
        }
        return $("#" + elm).find('option:selected').text()
    };
    return modal
});