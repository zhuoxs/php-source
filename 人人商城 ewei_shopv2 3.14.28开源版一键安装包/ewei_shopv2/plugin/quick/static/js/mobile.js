define(['core', 'tpl', 'biz/goods/picker', './picker.js', 'biz/plugin/diyform', 'jquery.fly'], function (core, tpl, picker2, picker, diyform) {
    var modal = {selected: 0, child: 0};
    modal.init = function (params) {
        modal.template = params.template;
        modal.data = params.datas || modal.data;
        modal.cart = modal.cart || params.cart;
        modal.fromquick = params.fromquick;
        modal.merchid = params.merchid;
        /*商城购物车角标dom*/
        modal.totaldom=null;
        modal.inited =false;
        
        if (modal.template == '1') {
            modal.initT2()
        } else {
            modal.initTpl();
            modal.initClick();
            modal.initNavs();
            modal.initTitle();
            if(!modal.inited) {
                modal.initGoods();
            }
            modal.initCart();
            $('.container').infinite({
                onLoading: function () {
                    modal.getGoods()
                }
            })
        }

        modal.inited =true;
    };
    modal.initT2 = function () {
        $(".fui-goods-tab .menu .nav").unbind('click').click(function () {
            var index = $(this).data('index');
            $(this).addClass('active').siblings().removeClass('active');
            $(".fui-content.quick").addClass('scrolling');
            var elm = $(".fui-goods-tab .main .item-title[data-index='" + index + "']");
            if (elm.length > 0) {
                var tabTop = $(".fui-goods-tab").position().top;
                var elmTop = elm.position().top;
                var scrollTop = tabTop + elmTop + 10;
                $(".fui-content.quick").stop(true, false).animate({scrollTop: scrollTop + "px"}, 1000, function () {
                    $(".fui-content.quick").removeClass('scrolling')
                })
            }
        });
        $('.fui-content.quick').scroll(function () {
            var h = $('.fui-header').height();
            if (h == null) {
                h = 0
            }
            if ($('.fui-goods-tab').offset().top < h) {
                $('.fui-goods-tab .menu').css({position: 'fixed', top: h + 'px', bottom: '0'});
                $('.fui-goods-tab .main').css({'margin-left': $('.fui-goods-tab .menu').outerWidth()})
            } else {
                $('.fui-goods-tab .menu').css({position: 'relative', top: '0', left: '0'});
                $('.fui-goods-tab .main').css({'margin-left': 0})
            }
            if ($(this).hasClass('scrolling')) {
                return
            }
            var arr = [];
            $('.fui-goods-tab .main .item-title').each(function () {
                var index = parseInt($(this).data('index')) + 1;
                var elm = $(".fui-goods-tab .main .item-title[data-index='" + index + "']");
                if (elm.length > 0 && elm.offset().top >= h + 2) {
                    arr.push($(this).data('index'))
                } else if (elm.length < 1) {
                    arr.push($(".fui-goods-tab .menu .nav").length - 1)
                }
            });
            $('.fui-goods-tab .menu .nav[data-index="' + arr[0] + '"]').addClass('active').siblings().removeClass('active')
        });
        $(".buybtn").unbind('click').click(function () {
            var goodsid = $(this).closest('.item').data('goodsid');
            if (goodsid) {
                picker2.open({goodsid: goodsid, total: 1})
            } else {
                FoxUI.toast.show("数据错误请刷新重试")
            }
        });
        if ($("#notice ul").length > 0) {
            var _this = $("#notice");
            setInterval(function () {
                _this.find("ul").animate({marginTop: "-1rem"}, 1000, function () {
                    $(this).css({marginTop: "0px"}).find("li:first").appendTo(this)
                })
            }, 5000)
        }
    };
    modal.initNavs = function () {
        $("#tab").empty();
        var html = tpl("tpl_nav", modal);
        $("#tab").html(html)
    };
    modal.initClick = function () {
        $(document).off('click', "#tab nav");
        $(document).on('click', '#tab nav', function () {
            $('.container').infinite('init');
            var index = $(this).data('index');
            if (index == modal.selected) {
                return
            }
            modal.selected = parseInt(index);
            modal.initNavs();
            modal.initTitle();
            modal.initGoods();
        });
        $(document).off('click', "#quick-cart-btn");
        $(document).on('click', "#quick-cart-btn", function () {
            if ($(this).hasClass("empty")) {
                return
            }
            var cart = $("#quick-cart");
            if (cart.data('open') == 1) {
                cart.removeClass('in').addClass('out');
                cart.data('open', 0);
                $(".mask-cart").fadeOut()
            } else {
                cart.removeClass('out').addClass('in');
                cart.data('open', 1);
                $(".mask-cart").fadeIn()
            }
        });
        $(document).off('click', ".fui-content.quick .plus");
        $(document).on('click', ".fui-content.quick .plus", function () {
            var index = modal.selected;
            var child = $(this).closest(".quick-item").data('index');
            var item = modal.data[index].data[child];
            if (!item) {
                FoxUI.alert("数据错误！请刷新");
                return
            }
            item.num = parseInt(item.num) || 0;
            item.minbuy = parseInt(item.minbuy);
            item.totalmaxbuy = parseInt(item.totalmaxbuy);
            item.diyformtype = parseInt(item.diyformtype);
            item.diyformid = parseInt(item.diyformid);
            if (item.gotodetail) {
                location.href = core.getUrl('goods/detail', {id: item.id});
                return
            }
            if (item.cannotbuy) {
                FoxUI.toast.show(item.cannotbuy);
                return
            }
            if (item.totalmaxbuy > 0) {
                if (item.totalmaxbuy <= item.num) {
                    FoxUI.toast.show("最多购买" + item.totalmaxbuy + item.unit);
                    return
                }
            }
            if (item.hasoption == 1 || (item.diyformtype > 0 && item.diyformid > 0) || !item.canAddCart) {
                modal.child = child;
                modal.childelm = $(this);
                if (item.canAddCart && item.minbuy > 0 && item.num < item.minbuy) {
                    FoxUI.toast.show("最少购买/" + item.minbuy + item.unit)
                }
                modal.initSpec(item);
                return
            }
            if (item.minbuy > 0 && item.num < item.minbuy) {
                FoxUI.toast.show("最少购买" + item.minbuy + item.unit);
                modal.updateCart($(this), 2, child, parseInt(item.minbuy));
                return
            }
            modal.updateCart($(this), 2, child, parseInt(item.num) + 1)
        });
        $(document).off('click', ".fui-content.quick .minus");
        $(document).on('click', ".fui-content.quick .minus", function () {
            var index = modal.selected;
            var child = $(this).closest(".quick-item").data('index');
            var item = modal.data[index].data[child];
            if (!item) {
                FoxUI.alert("数据错误！请刷新");
                return
            }
            item.num = parseInt(item.num) || 0;
            item.minbuy = parseInt(item.minbuy);
            if (item.hasoption == 1 && item.num > 1) {
                FoxUI.toast.show("多规格商品请至购物车内删除");
                return
            }
            if (item.minbuy > 0 && item.num <= item.minbuy) {
                FoxUI.toast.show("最少购买" + item.minbuy + item.unit);
                modal.updateCart($(this), 2, child, 0);
                return
            }
            modal.updateCart($(this), 2, child, parseInt(item.num) - 1)
        });
        $(document).off('click', "#quick-cart .plus");
        $(document).on('click', "#quick-cart .plus", function () {
            var child = $(this).closest(".item").data('index');
            var item = modal.cart.list[child];
            if (!item) {
                FoxUI.alert("数据错误！请刷新");
                return
            }
            item.totalmaxbuy = parseInt(item.totalmaxbuy);
            item.minbuy = parseInt(item.minbuy);
            item.total = parseInt(item.total);
            if (item.minbuy > 0 && item.total < item.minbuy) {
                FoxUI.toast.show("最少购买" + item.minbuy + item.unit);
                modal.updateCart($(this), 1, child, parseInt(item.minbuy), 1);
                return
            }
            if (item.totalmaxbuy > 0) {
                if (item.totalmaxbuy <= item.total) {
                    FoxUI.toast.show("最多购买" + item.totalmaxbuy + item.unit);
                    return
                }
            }
            modal.updateCart($(this), 1, child, parseInt(item.total) + 1, 0)
        });
        $(document).off('click', "#quick-cart .minus");
        $(document).on('click', "#quick-cart .minus", function () {
            var child = $(this).closest(".item").data('index');
            var item = modal.cart.list[child];
            if (!item) {
                FoxUI.alert("数据错误！请刷新");
                return
            }
            item.minbuy = parseInt(item.minbuy);
            item.total = parseInt(item.total);
            if (item.minbuy > 0 && item.total <= item.minbuy) {
                FoxUI.toast.show("最少购买" + item.minbuy + item.unit);
                modal.updateCart($(this), 1, child, 0);
                return
            }
            modal.updateCart($(this), 1, child, parseInt(item.total) - 1)
        });
        $(".mask-cart").unbind('click').click(function () {
            $("#quick-cart").removeClass('in').addClass('out');
            $(this).fadeOut()
        });
        $(".mask-page").unbind('click').click(function () {
            $(".fui-page-group").addClass("scale-out").removeClass("scale-in");
            $(this).fadeOut()
        });
        $("#btn-clear").unbind('click').click(function () {
            var _this = $(this);
            if (_this.attr('stop')) {
                return
            }
            FoxUI.confirm("确定要清空购物车吗？", function () {
                $("#quick-cart").removeClass('in').addClass('out');
                $("#quick-cart").data('open', 0);
                $(".mask").fadeOut();
                FoxUI.loader.show('loading');
                core.json('quick/clearCart', {quickid: modal.fromquick, merchid: modal.merchid}, function (ret) {
                    modal.cart = {list: [], total: 0};
                    modal.initCart();
                    if (modal.data && modal.data.length > 0) {
                        $.each(modal.data, function (i, g) {
                            if (g.data && g.data.length > 0) {
                                $.each(g.data, function (ii, gg) {
                                    modal.data[i].data[ii].num = 0;
                                    modal.data[i].data[ii].dismin = 0;
                                    modal.data[i].data[ii].dismax = 0
                                })
                            }
                        })
                    }
                    modal.showGoods()
                }, true, true)
            })
        });
        $("#btn-submit").unbind('click').click(function () {
            var _this = $(this);
            var cart = modal.cart;
            if (!cart.list || !$.isArray(cart.list) || cart.list.length < 1) {
                return
            }
            if (_this.attr('stop')) {
                return
            }
            _this.html("加载中...");
            var time = 200;
            if ($("#quick-cart").data('open')) {
                $("#quick-cart-btn").trigger("click");
                time = 1000
            }
            setTimeout(function () {
                core.json('quick/submit', {quickid: modal.fromquick, merchid: modal.merchid}, function (ret) {
                    if (ret.status != 1) {
                        FoxUI.toast.show(ret.result.message);
                        _this.removeAttr("stop").html("去结算");
                        return
                    }
                    var obj = {fromquick: modal.fromquick};
                    if (modal.fromquick == 0) {
                        obj.fromcart = 1
                    }
                    location.href = core.getUrl('order/create', obj)
                }, true, true)
            }, time)
        })
    };
    modal.updateCart = function (_this, form, child, num, optionid, diyformdata) {
        var el = _this.closest(".quick-num");
        if (form == 1) {
            var item = modal.cart.list[child];
            if (!item || !item.id) {
                FoxUI.alert("数据错误！请刷新");
                return
            }
            var oldNum = item.total;
            var optionid = item.optionid;
            var goodsid = item.goodsid;
            item.dismin = 0;
            item.dismax = 0
        } else {
            var index = modal.selected;
            var item = modal.data[index].data[child];
            if (!item || !item.id) {
                FoxUI.alert("数据错误！请刷新");
                return
            }
            var oldNum = item.num;
            var goodsid = item.id;
            modal.data[index].data[child].dismin = item.dismin = 0;
            modal.data[index].data[child].dismax = item.dismax = 0
        }
        if (num < 0) {
            num = 0
        }
        optionid = optionid || 0;
        var update = 0;
        var realNum = num;
        if (form == 3) {
            num = oldNum + num;
            update = 1
        }
        core.json('quick/update', {
            goodsid: goodsid,
            quickid: modal.fromquick,
            total: realNum,
            optionid: optionid || 0,
            update: update,
            merchid: modal.merchid,
            diyformdata: diyformdata || ''
        }, function (ret) {
            if (ret.status == 0) {
                FoxUI.toast.show(ret.result.message);
                return
            }
            if (num > oldNum) {
                modal.zoom(form > 1 ? _this : '')
            }
            modal.getCart();
            if (num > oldNum) {
                if (oldNum < 1 && form > 1) {
                    el.addClass('open').removeClass('close')
                }
                if (num == item.totalmaxbuy) {
                    item.dismax = 1;
                    el.find(".plus").addClass("disabled")
                }
                if (num > item.minbuy) {
                    el.find(".minus").removeClass('disabled')
                } else {
                    el.find(".minus").addClass('disabled')
                }
            } else {
                if (num <= item.minbuy) {
                    _this.addClass('disabled');
                    item.dismin = 1;
                    if (form != 1) {
                        modal.data[index].data[child].dismin = 1
                    }
                }
                if (num == 0) {
                    el.addClass('close').removeClass('open')
                }
                if (num < item.totalmaxbuy) {
                    el.find(".plus").removeClass('disabled')
                }
            }
            if (form == 1) {
                num = 0;
                $.each(modal.cart.list, function (i, g) {
                    if (g.goodsid == item.goodsid) {
                        num += g.total
                    }
                });
                if (num > 0) {
                    num = num - 1
                }
            }
            $.each(modal.data, function (i, g) {
                if (g.data && g.data.length > 0) {
                    $.each(g.data, function (ii, gg) {
                        if (gg.id == goodsid) {
                            modal.data[i].data[ii].num = num;
                            modal.data[i].data[ii].dismin = item.dismin;
                            modal.data[i].data[ii].dismax = item.dismax
                        }
                    })
                }
            });
            if (form == 1) {
                modal.showGoods();
                return
            }
            el.find(".num").text(num);
        }, true, true)
    };
    modal.initSpec = function (item) {
        if (!item || !item.id || modal.child < 0) {
            FoxUI.toast.show("数据错误！请刷新");
            return
        }
        var _this = modal.childelm || '';
        $('.picker-modal').remove();
        $('.fui-mask').remove();
        picker.open({
            goodsid: item.id,
            total: 1,
            action: 'cart',
            optionid: 0,
            showConfirm: true,
            autoClose: false,
            mustbind: modal.mustbind,
            backurl: modal.backurl,
            onConfirm: function (total, optionid, optiontitle) {
                if (item.canAddCart) {
                    if ($('.diyform-container').length > 0) {
                        var diyformdata = diyform.getData('.diyform-container');
                        if (!diyformdata) {
                            return
                        } else {
                            core.json('order/create/diyform', {id: item.id, diyformdata: diyformdata}, function (ret) {
                                modal.updateCart(_this, 3, modal.child, total, optionid, diyformdata);
                                modal.child = '';
                                modal.childelm = ''
                            }, true, true);
                            picker.close()
                        }
                    } else {
                        modal.updateCart(_this, 3, modal.child, total, optionid);
                        modal.child = '';
                        modal.childelm = '';
                        picker.close()
                    }
                } else {
                    if ($('.diyform-container').length > 0) {
                        var diyformdata = diyform.getData('.diyform-container');
                        if (!diyformdata) {
                            return
                        } else {
                            FoxUI.loader.show("loading");
                            core.json('order/create/diyform', {id: item.id, diyformdata: diyformdata}, function (ret) {
                                location.href = core.getUrl('order/create', {
                                    id: item.id,
                                    optionid: optionid,
                                    total: total,
                                    gdid: ret.result.goods_data_id
                                });
                                modal.child = '';
                                modal.childelm = ''
                            }, true, true);
                            picker.close()
                        }
                    } else {
                        FoxUI.loader.show("loading");
                        var obj = {id: item.id, total: total};
                        if (optionid > 0) {
                            obj.optionid = optionid
                        }
                        location.href = core.getUrl('order/create', obj);
                        modal.child = '';
                        modal.childelm = '';
                        picker.close()
                    }
                }
            }
        })
    };
    modal.initTitle = function () {
        var index = modal.selected;
        var item = modal.data[index];
        if (item) {
            $("#title").text(item.title || "未命名");
            if (item.desc) {
                $("#subtitle").text(item.desc).show()
            } else {
                $("#subtitle").hide()
            }
        }
    };
    modal.initGoods = function () {
        var index = modal.selected;
        var item = modal.data[index];
        if (!item) {
            modal.initNavs();
            modal.initTitle();
            modal.initGoods();
            return
        }
        if (item.data && item.data.length > 0) {
            modal.showGoods()
        } else {
            modal.getGoods()
        }
    };
    modal.showGoods = function () {
        var index = modal.selected;
        if (!modal.data[index]) {
            return
        }
        $("#list").empty();
        if (!modal.data[index].data || modal.data[index].data.length < 1) {
            return
        }
        $(".quick-list-empty").hide();
        var html = tpl("tpl_goods", modal.data[index]);
        $("#list").html(html);
    };
    modal.getGoods = function () {
        var index = modal.selected;
        var item = modal.data[index];
        item.page = item.page || 1;
        if (item.empty) {
            $(".quick-list-empty").show();
            $("#list").empty();
            return
        }
        FoxUI.loader.show("loading");
        var obj = {page: item.page, datatype: item.datatype, goodssort: item.goodssort, merchid: modal.merchid};
        if (item.datatype == 0) {
            if ($.isArray(item.goodsids)) {
                item.goodsids = item.goodsids.toString()
            }
            obj.goodsids = item.goodsids
        } else if (item.datatype == 1) {
            obj.cateid = item.cateid
        } else if (item.datatype == 2) {
            obj.groupid = item.groupid
        }
        core.json('quick/get_list', obj, function (ret) {
            var result = ret.result;
            if (result.total <= 0 || (item.page == 1 && result.list.length < 1)) {
                modal.data[index].empty = 1;
                modal.data[index].data = [];
                $(".quick-list-empty").show();
                $('.container').infinite('stop')
            } else {
                var data = modal.data[index].data || [];
                var cart = modal.cart.list || [];
                if (cart.length > 0 && result.list.length > 0) {
                    $.each(cart, function (i, cg) {
                        $.each(result.list, function (ii, lg) {
                            if (lg.cannotbuy == '' && lg.id == cg.goodsid) {
                                result.list[ii].num = result.list[ii].num + cg.total;
                                if ((cg.minbuy > 0 && cg.total <= cg.minbuy)) {
                                    result.list[ii].dismin = 1
                                }
                                if (cg.totalmaxbuy > 0 && cg.total >= cg.totalmaxbuy) {
                                    result.list[ii].dismax = 1
                                }
                            }
                        })
                    })
                }
                $('.container').infinite('init');
                if (result.list.length <= 0 || result.list.length < result.pagesize) {
                    $('.container').infinite('stop')
                }
                modal.data[index].data = data.concat(result.list);
                modal.data[index].page++
            }
            FoxUI.loader.hide();
            modal.showGoods()
        })
    };
    modal.initCart = function () {
        var cart = modal.cart;
        if (!$.isArray(cart.list)) {
            cart.list = []
        }
        $("#quick-cart .inner").empty();
        if (cart.list.length < 1) {
            $("#quick-cart-btn").addClass("empty");
            $("#quick-cart-btn .dot").hide();
            $("#quick-cart").addClass('out').removeClass('in');
            $(".mask").fadeOut();
            $("#btn-submit").addClass("disabled");
            $("#cart-price").html("￥0.00").next().html("当前购物车为空")
        } else {
            $("#quick-cart-btn").removeClass("empty");
            $("#quick-cart-btn .dot").text(modal.cart.total).show();

            /*更新商城购物车角标数量*/
            if($(document).find("#menucart .badge").length >0){
                modal.totaldom=$(document).find("#menucart .badge");
            }
            if (modal.totaldom!=null) {
                modal.totaldom.text(modal.cart.total.toString());
            }

            $("#btn-submit").removeClass("disabled");
            var html = tpl("tpl_cart", modal.cart);
            $("#quick-cart .inner").html(html);
            $("#cart-price").html("￥" + modal.cart.totalprice).next().html("优惠信息请至结算页面查看")
        }
    };
    modal.getCart = function () {
        core.json('quick/getCart', {quickid: modal.fromquick, merchid: modal.merchid}, function (ret) {
            if (ret.status == 0) {
                FoxUI.toast.show(ret.result.message);
                return
            }
            modal.cart = ret.result;
            modal.initCart()
        })
    };
    modal.zoom = function (_this) {
        var cart = $(".quick-cart");
        if (!cart.hasClass('an')) {
            cart.addClass('an');
            setTimeout(function () {
                cart.removeClass('an')
            }, 500)
        }
        if (_this) {
            var offset = $('#quick-cart-btn').offset();
            var dot = $('<i class="fly-dot"></i>');
            dot.fly({
                speed: 1.5,
                start: {left: _this.offset().left - 5, top: _this.offset().top - 14},
                end: {left: offset.left + 30, top: offset.top - 5},
                onEnd: function () {
                    dot.remove()
                }
            })
        }
    };
    modal.initTpl = function () {
        tpl.helper("imgsrc", function (src) {
            if (typeof src != 'string') {
                return ''
            }
            if (src.indexOf('http://') == 0 || src.indexOf('https://') == 0 || src.indexOf('../addons/ewei_shopv2/') == 0) {
                return src
            } else if (src.indexOf('images/') == 0 || src.indexOf('audios/') == 0) {
                return modal.attachurl + src
            }
        });
        tpl.helper("calculate", function (value) {
            return parseFloat(value).toFixed(2)
        })
    };
    return modal
});