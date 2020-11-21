define(['core', 'tpl', '../goods/picker.js'], function(core, tpl, picker) {
    var modal = {
        status: 'cart'
    };
    modal.init = function() {
        $('.fui-number').numbers({
            callback: function(num, container) {
                modal.caculate()
            }
        });
        modal.caculate();
        $('.check-item').unbind('click').click(function() {
            var cartid = $(this).closest('.goods-item').data('cartid');
            modal.select(cartid, $(this).prop('checked'))
        });
        $('.checkall').unbind('click').click(function() {
            var checked = $(this).find(':checkbox').prop('checked');
            $(".check-item").prop('checked', checked);
            modal.caculate();
            modal.select('all', checked)
        });
        $('.btn-submit').unbind('click').click(function() {
            if ($(this).attr('stop')) {
                return
            }
            window.location.href=core.getUrl('pc.order.create');
        });
        $('.btn-edit').unbind('click').click(function() {
            modal.changeMode()
        });
        $('.btn-delete').unbind('click').click(function() {
            var cartid=$(this).parent().parent().data('cartid');
            modal.remove(cartid);
        });
        $('.btn-favorite').unbind('click').click(function() {
            if ($('.edit-item:checked').length <= 0) {
                return
            }
            modal.toFavorite()
        });
        $('.editcheckall').unbind('click').click(function() {
            var checked = $(this).find(':checkbox').prop('checked');
            $(".edit-item").prop('checked', checked);
            modal.caculateEdit()
        });
        $('.edit-item').unbind('click').click(function() {
            modal.caculateEdit()
        });
        $('.choose-option').unbind('click').click(function(e) {
            if (modal.status == 'edit') {
                e.preventDefault();
                modal.changeOption(this)
            }
        })
    };
    modal.select = function(cartid, select) {
        core.json('pc.member.cart.select', {
            id: cartid,
            select: select ? "1" : '0'
        }, function(ret) {
            if (ret.status == 0) {
                FoxUI.toast.show(ret.result.message)
            }
            modal.caculate()
        }, true, true)
    };
    modal.caculate = function() {
        var total = 0;
        var totalprice = 0;
        $('.goods-item').each(function() {
            var totalprice_er=parseInt($(this).find('.shownum').val()) * core.getNumber($(this).find('.marketprice').html());
            $(this).find('.totalprice_er').html(totalprice_er);
            if ($(this).find('.check-item').prop('checked')) {
                total += parseInt($(this).find('.shownum').val());
                totalprice += parseInt($(this).find('.shownum').val()) * core.getNumber($(this).find('.marketprice').html());
                var count = parseInt($(this).find('.shownum').val());
                var cartid = $(this).data('cartid');
                var optionid = $(this).data('optionid');
                modal.update(cartid, count, optionid)
            }
        });
        $(".total").html(total);
        window.cartcount = total;
        if (total != 0) {
            $("#menucart span.badge").text(total).show()
        } else {
            $("#menucart span.badge").hide()
        }
        $(".totalprice").html(core.number_format(totalprice, 0));
        if (total <= 0) {
            $(".btn-submit").attr('stop', 1).removeClass('btn-danger').addClass('btn-default disabled')
        } else {
            $(".btn-submit").removeAttr('stop').removeClass('btn-default disabled').addClass('btn-danger')
        }
        $('.checkall .fui-radio').prop('checked', $('.check-item').length == $('.check-item:checked').length)
    };
    modal.caculateEdit = function() {
        $('.editcheckall .fui-radio').prop('checked', $('.edit-item').length == $('.edit-item:checked').length);
        var selects = $('.edit-item:checked').length;
        if (selects > 0) {
            $('.btn-delete').removeClass('disabled');
            $('.btn-favorite').removeClass('disabled')
        } else {
            $('.btn-delete').addClass('disabled');
            $('.btn-favorite').addClass('disabled')
        }
    };
    modal.update = function(cartid, num, optionid) {
        core.json('pc.member.cart.update', {
            id: cartid,
            total: num,
            optionid: optionid
        }, function(ret) {
            if (ret.status == 0) {
                FoxUI.toast.show(ret.result.message)
            }
        }, true, true)
    };
    modal.add = function(goodsid, optionid, total, diyformdata, callback) {
        core.json('pc.member.cart.add', {
            id: goodsid,
            optionid: optionid,
            total: total,
            diyformdata: diyformdata
        }, function(ret) {
            if (ret.status == 0) {
                FoxUI.toast.show(ret.result.message);
                if (ret.result.url) {
                    setTimeout(function() {
                        location.href = ret.result.url
                    }, 800)
                }
                return
            }
            if (callback) {
                callback(ret.result)
            }
        }, true, true)
    };
    modal.remove = function(cartid) {
        var ids = [];

        ids.push(cartid);
        if (ids.length <= 0) {
            return
        }
        FoxUI.confirm('确认要从购物车删除吗?', function() {
            core.json('pc.member.cart.remove', {
                ids: ids
            }, function(ret) {
                if (ret.status == 0) {
                    FoxUI.toast.show(ret.result.message);
                    return
                }
                $.each(ids, function() {
                    $(".goods-item[data-cartid='" + this + "']").remove()
                });
                modal.caculate();
            }, true, true)
        })
    };
    modal.changeOption = function(btn) {
        var goodsitem = $(btn).closest('.goods-item');
        var goodsid = goodsitem.data('goodsid'),
            total = parseInt(goodsitem.find('.shownum').val()),
            optionid = goodsitem.data('optionid');
        var cartid = goodsitem.data('cartid');
        picker.open({
            goodsid: goodsid,
            total: total,
            split: '+',
            optionid: optionid,
            showConfirm: true,
            onConfirm: function(total, optionid, optiontitle, optionthumb) {
                $("#gimg_" + cartid).attr('src', optionthumb);
                $(btn).html(optiontitle);
                goodsitem.data('optionid', optionid);
                goodsitem.find('.fui-number').numbers('refresh', total);
                $(".goods-item[data-cartid='" + cartid + "']").find('.cartmode .choose-option').html(optiontitle);
                modal.caculate()
            }
        })
    };
    return modal
});