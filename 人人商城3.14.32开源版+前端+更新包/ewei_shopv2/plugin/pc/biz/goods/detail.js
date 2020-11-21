define(['core', 'tpl', '../goods/picker.js', '../member/favorite.js', '../member/cart.js', 'biz/plugin/diyform'], function (core, tpl, picker, favorite, cart, diyform) {
    var modal = {};
    modal.init = function (params) {
        modal.goodsid = params.goodsid;
        modal.optionid = 0;
        modal.total = 1;
        modal.getComments = params.getComments;
        FoxUI.tab({
            container: $('#tab'),
            handlers: {
                tab1: function () {
                    $('.basic-block').show();
                    modal.hideDetail();
                    modal.hideParams();
                    modal.hideComment()
                },
                tab2: function () {
                    modal.hideParams();
                    modal.hideComment();
                    modal.showDetail()
                },
                tab3: function () {
                    modal.showParams();
                    modal.hideComment()
                },
                tab4: function () {
                    modal.showComment()
                }
            }
        });
        modal.hideDetail();
        modal.hideParams();
        modal.hideComment();
        $('.option-selector').click(function () {
            modal.optionPicker('')
        });
        $('#alert-click').on("click", function () {
            $("#alert-picker").show()
        });
        $('.alert-close').on("click", function () {
            $("#alert-picker").hide()
        });
        $('#alert-mask').on("click", function () {
            $("#alert-picker").hide()
        });
        $('#city-picker').click(function () {
            modal.salePicker = new FoxUIModal({
                content: $('#city-picker-modal').html(),
                extraClass: 'picker-modal',
                maskClick: function () {
                    modal.salePicker.close()
                }
            });
            modal.salePicker.container.find('.btn-danger').click(function () {
                modal.salePicker.close()
            });
            modal.salePicker.show()
        });
        $('#sale-picker').click(function () {
            modal.salePicker = new FoxUIModal({
                content: $('#sale-picker-modal').html(),
                extraClass: 'picker-modal',
                maskClick: function () {
                    modal.salePicker.close()
                }
            });
            modal.salePicker.container.find('.btn-danger').click(function () {
                modal.salePicker.close()
            });
            modal.salePicker.show()
        });
        $(".cartbtn").click(function () {
            modal.optionPicker('cart')
        });
        $(".buynow").click(function () {
            modal.optionPicker('buy')
        });
        $('.fui-labeltext').timer({
            onEnd: function () {
                location.reload()
            },
            onStart: function () {
                location.reload()
            }
        });
        $('.favorite-item').click(function () {
            var self = $(this);
            if (self.attr('submit') == '1') {
                return
            }
            self.attr('submit', 1);
            
        });
        if (core.isWeixin()) {
            $('#btn-share').click(function () {
                $('#cover').fadeIn(200)
            });
            $('#cover').click(function () {
                $('#cover').hide()
            })
        } else {
            $('#btn-share').click(function () {
                FoxUI.alert("请复制链接发送给好友")
            })
        }
        if (modal.getComments) {
            core.json('goods/detail/get_comments', {
                id: modal.goodsid
            }, function (ret) {
                var result = ret.result;
                $(".fui-icon-col[data-level='all']").find('.count').html(result.count.all);
                $(".fui-icon-col[data-level='good']").find('.count').html(result.count.good);
                $(".fui-icon-col[data-level='normal']").find('.count').html(result.count.normal);
                $(".fui-icon-col[data-level='bad']").find('.count').html(result.count.bad);
                $(".fui-icon-col[data-level='pic']").find('.count').html(result.count.pic);
                if (ret.status == 1 && result.list.length > 0) {
                    modal.initComment();
                    $('#tabcomment').show();
                    core.tpl('#comments-container', 'tpl_goods_detail_comments', ret.result);
                    $('#comments-container .fui-cell:first-child').click(function () {
                        $("#tabcomment").click()
                    });
                    $('#comments-container').lazyload()
                };
                core.showImages('#comments-container .remark.img img')
            })
        }

        if (typeof(window.cartcount) !== 'undefined') {
            picker.changeCartcount(window.cartcount)
        }
        core.showImages('.fui-swipe .fui-swipe-item img')
    };
    modal.getDetail = function () {
        if ($('.detail-block').find('.content-block').html() != '') {
            return
        }
        FoxUI.loader.show('mini');
        $.ajax({
            url: core.getUrl('goods/detail/get_detail', {
                id: modal.goodsid
            }),
            cache: true,
            success: function (html) {
                FoxUI.loader.hide();
                $('.detail-block').find('.content-block').html(html);
                setTimeout(function () {
                    $('.detail-block').lazyload();
                    core.showImages('.content-block img')
                }, 10)
            }
        })
    };
    modal.showDetail = function () {
        $('.basic-block').hide();
        modal.getDetail();
        $('.detail-block').transition(300).addClass('in').transitionEnd(function () {
            $('.detail-block').transition('')
        })
    };
    modal.hideDetail = function () {
        $('.basic-block').show();
        $('.detail-block').transition(300).removeClass('in').transitionEnd(function () {
            $('.detail-block').transition('')
        })
    };
    modal.showParams = function () {
        $('.param-block').show().addClass('in')
    };
    modal.hideParams = function () {
        $('.param-block').removeClass('in')
    };
    modal.optionPicker = function (action) {
        picker.open({
            goodsid: modal.goodsid,
            total: modal.total,
            split: ';',
            optionid: modal.optionid,
            showConfirm: true,
            autoClose: false,
            mustbind: modal.mustbind,
            backurl: modal.backurl,
            onConfirm: function (total, optionid, optiontitle) {
                modal.total = total;
                modal.optionid = optionid;
                $('.option-selector').html("已选: 数量x" + total + " " + optiontitle);
                if (action == 'buy') {
                    if ($('.diyform-container').length > 0) {
                        var diyformdata = diyform.getData('.diyform-container');
                        if (!diyformdata) {
                            return
                        } else {
                            core.json('order/create/diyform', {
                                id: modal.goodsid,
                                diyformdata: diyformdata
                            }, function (ret) {
                                $.router.load(core.getUrl('pc/order/create', {
                                    id: modal.goodsid,
                                    optionid: modal.optionid,
                                    total: modal.total,
                                    gdid: ret.result.goods_data_id
                                }), true)
                            }, true, true);
                            picker.close()
                        }
                    } else {
                        picker.close();
                        $.router.load(core.getUrl('pc/order/create', {
                            id: modal.goodsid,
                            optionid: modal.optionid,
                            total: modal.total
                        }), false)
                    }
                } else if (action == 'cart') {
                    if ($('.diyform-container').length > 0) {
                        var diyformdata = diyform.getData('.diyform-container');
                        if (!diyformdata) {
                            return
                        } else {
                            cart.add(modal.goodsid, modal.optionid, modal.total, diyformdata, function (ret) {
                                $('.cart-item').find('.badge').html(ret.cartcount).removeClass('out').addClass('in');
                                window.cartcount = ret.cartcount
                            });
                            picker.close()
                        }
                    } else {
                        cart.add(modal.goodsid, modal.optionid, modal.total, false, function (ret) {
                            $('.cart-item').find('.badge').html(ret.cartcount).removeClass('out').addClass('in');
                            window.cartcount = ret.cartcount
                        });
                        picker.close()
                    }
                } else {
                    picker.close()
                }
            }
        })
    };
    modal.showComment = function () {
        $('.comment-block').show().addClass('in').transitionEnd(function () {
            if (!$('.comment-block').attr('loaded')) {
                $('.comment-block').attr('loaded', 1);
                modal.getCommentList()
            }
        })
    };
    modal.hideComment = function () {
        $('.comment-block').removeClass('in')
    };
    modal.initComment = function () {
        modal.commentPage = 1;
        modal.commentLevel = '';
        modal.commentCount = 1;
        $('.fui-content').infinite({
            onLoading: function () {
                modal.getCommentList()
            }
        });
        if (modal.commentPage == 1) {
            modal.getCommentList()
        }
    };
    modal.getCommentList = function () {
        $('#comments-list-container .content-empty').hide();
        $('#comments-list-container .infinite-loading').show();
        core.json('goods/detail/get_comment_list', {
            id: modal.goodsid,
            page: modal.commentPage,
            level: modal.commentLevel,
            getcount: modal.commentCount
        }, function (ret) {
            var result = ret.result;
            if (result.total <= 0) {
                $('#comments-list-container .container').html('').hide();
                $('#comments-list-container .content-empty').show();
                $('#comments-list-container').infinite('stop')
            } else {
                $('#comments-list-container .container').show();
                $('#comments-list-container .content-empty').hide();
                $('#comments-list-container').infinite('init');
                if (result.list.length <= 0 || result.list.length < result.pagesize) {
                    $('#comments-list-container').infinite('stop')
                }
            }
            modal.commentCount = 0;
            modal.commentPage++;
            core.tpl('#comments-list-container .container', 'tpl_goods_detail_comments_list', result, modal.commentPage > 1);
            $('#comments-list-container .fui-icon-group .fui-icon-col').unbind('click').click(function () {
                $('#comments-list-container .fui-icon-group .fui-icon-col span.text-danger').removeClass('text-danger');
                $(this).find('span').addClass('text-danger');
                modal.commentPage = 1;
                modal.commentCount = 1;
                modal.commentLevel = $(this).data('level');
                $('#comments-list-container .container').html('');
                modal.getCommentList()
            });
            core.showImages('#comments-all .remark.img img')
        }, false)
    };
    return modal
});