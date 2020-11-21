define(['core', 'tpl', 'biz/goods/picker'], function (core, tpl, picker) {
    var defaults = {
        keywords: '',
        isrecommand: '',
        ishot: '',
        isnew: '',
        isdiscount: '',
        issendfree: '',
        istime: '',
        cate: '',
        order: '',
        by: 'desc',
        merchid: 0,
        couponid:0
    };
    var modal = {page: 1, params: {}, lastcate: false};
    modal.init = function (params) {
        modal.params = $.extend(defaults, params || {});
        if (!modal.toGoods) {
            modal.page = 1
        } else {
            modal.toGoods = false
        }
        $('#goods-list-container').html('');
        modal.getList();
        $('form').submit(function () {
            $('.container').empty();
            modal.params = defaults;
            modal.page = 1;
            modal.params.keywords = $('#search').val();
            modal.getList();
            return false
        });

        $('#search').bind('input propertychange', function () {
            if ($.trim($(this).val()) == '') {
                $('.container').empty();
                $('.sort .item-price').removeClass('desc').removeClass('asc');
                modal.params = defaults;
                modal.page = 1;
                modal.params.keywords = '';
                modal.getList()
            }
        });
        $('.sort .item').click(function () {
            var keywords = modal.params.keywords;
            var order = $(this).data('order') || '';
            if (order == '') {
                if (modal.params.order == order) {
                    return
                }
                modal.params = defaults
            } else if (order == 'minprice') {
                $(this).removeClass('asc').removeClass('desc');
                if (modal.params.order == order) {
                    if (modal.params.by == 'desc') {
                        modal.params.by = 'asc';
                        $(this).addClass('asc')
                    } else {
                        modal.params.by = 'desc';
                        $(this).addClass('desc')
                    }
                } else {
                    modal.params.by = 'asc';
                    $(this).addClass('asc')
                }
                modal.params.order = order
            } else if (order == 'sales') {
                if (modal.params.order == order) {
                    return
                }
                modal.params = defaults, modal.params.order = 'sales', modal.params.by = 'desc'
            }
            $('.sort .item.on').removeClass('on'), $(this).addClass('on');
            if (order != 'minprice') {
                $('.sort .item-price').removeClass('desc').removeClass('asc')
            }
            if (order == 'filter') {
                modal.showFilter();
                return
            }
            modal.params.keywords = keywords;
            modal.page = 1;
            $('.container').html(''), $('.infinite-loading').show(), $(".content-empty").hide();
            modal.getList()
        });
        $('#listblock').click(function () {
            if ($(this).hasClass('icon-app')) {
                $(this).removeClass('icon-app').addClass('icon-sort')
            } else {
                $(this).removeClass('icon-sort').addClass('icon-app')
            }
            $('.container').toggleClass('block')
        });
        $('.fui-content').infinite({
            onLoading: function () {
                modal.getList()
            }
        });
        modal.bindEvents()
    };
    modal.showFilter = function () {
        $('.fui-mask-m').show().addClass('visible');
        $('.screen').addClass('in');
        $('.screen .btn').unbind('click').click(function () {
            var type = $(this).data('type');
            if ($(this).hasClass('btn-danger-o')) {
                $(this).removeClass('btn-danger-o').addClass('btn-default-o');
                $(this).find('.icon').hide()
            } else {
                $(this).removeClass('btn-default-o').addClass('btn-danger-o');
                $(this).find('.icon').show()
            }
        });
        $('.screen .cancel').unbind('click').click(function () {
            modal.cancelFilter()
        });
        $('.screen .confirm').unbind('click').click(function () {
            $('.screen .btn').each(function () {
                var type = $(this).data('type');
                if ($(this).hasClass('btn-danger-o')) {
                    modal.params[type] = "1"
                } else {
                    modal.params[type] = ""
                }
            });
            if (modal.lastcateid) {
                modal.params.cate = modal.lastcateid
            }
            modal.closeFilter();
            $('.container').html(''), $('.infinite-loading').show(), $(".content-empty").hide();
            modal.page = 1, modal.getList()
        });
        modal.bindCategoryEvents();
        $('.fui-mask-m').unbind('click').click(function () {
            modal.closeFilter()
        })
    };
    modal.cancelFilter = function () {
        modal.closeFilter();
        $('.screen .btn').each(function () {
            if ($(this).hasClass('btn-danger-o')) {
                $(this).removeClass('btn-danger-o').addClass('btn-default-o');
                $(this).find('.icon').hide();
                modal.params[$(this).data('type')] = ""
            }
        });
        $('.screen .cate .item nav').removeClass('on');
        $('.screen .cate .item:first-child ~ .item').html('');
        defaults.cate = '';
        modal.params = defaults, modal.getList()
    };
    modal.bindCategoryEvents = function () {
        $('.screen .cate .item nav').unbind('click').click(function () {
            var catlevel = $(this).closest('.cate').data('catlevel');
            var item = $(this).parent();
            item.find('nav.on').removeClass('on');
            $(this).addClass('on');
            var level = item.data('level');
            modal.lastcateid = $(this).data('id');
            if (level >= catlevel) {
                return
            }
            var items = $(".screen .cate .item[data-level='" + level + "'] ~ .item");
            items.html('');
            var next = $(this).closest('.item').next('.item');
            var children = window.category['children'][modal.lastcateid];
            var HTML = "";
            $.each(children, function () {
                HTML += "<nav data-id='" + this.id + "'>" + this.name + "</nav> "
            });
            next.html(HTML);
            modal.bindCategoryEvents()
        })
    };
    modal.closeFilter = function () {
        $('.fui-mask-m').removeClass('visible').transitionEnd(function () {
            $('.fui-mask-m').hide()
        });
        $('.screen').removeClass('in')
    };
    modal.bindEvents = function () {
        $("#goods-list-container .fui-goods-item").click(function () {
            modal.toGoods = true
        });
        $('.buy').unbind('click').click(function () {
            var goodsid = $(this).closest('.fui-goods-item').data('goodsid');
            picker.open({goodsid: goodsid, total: 1})
        })
    };
    modal.getList = function () {
        modal.params.page = modal.page;
        core.json('sale/coupon/my/get_list', modal.params, function (ret) {
            $('.infinite-loading').hide();
            var result = ret.result;
            if (result.total <= 0) {
                $('.content-empty').show();
                $('.fui-content').infinite('stop')
            } else {
                $('.content-empty').hide();
                $('.fui-content').infinite('init');
                if (result.list.length <= 0 || result.list.length < result.pagesize) {
                    modal.stopLoading = true;
                    $('.fui-content').infinite('stop')
                }
            }
            modal.page++;
            core.tpl('.container', 'tpl_goods_list', result, modal.page > 1);
            modal.bindEvents()
        })
    };
    return modal
});