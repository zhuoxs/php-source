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
        $(".batch-btn").unbind('click').click(function () {
            $(".head-menu-mask").fadeOut();
            $(".head-menu").fadeOut();
            $(".fundot").removeClass('active');
            $(".funmenu").addClass('out').removeClass('in');
            $(".fui-navbar").hide();
            $(".batch-out").hide();
            $(".batch-hide").hide();
            $(".batch-item").show();
            if (modal.status == 'sale' || modal.status == 'out') {
                $(".batch-putoff").show();
                $(".batch-delete").show()
            } else if (modal.status == 'stock') {
                $(".batch-puton").show();
                $(".batch-delete").show()
            } else if (modal.status == 'cycle') {
                $(".batch-restore").show()
            }
            modal.batch = true
        });
        $(".batch-cancel").unbind('click').click(function () {
            $(".batch-item").hide();
            $(".batch-out").show();
            $(".batch-hide").show();
            $(".fui-navbar").show();
            $(".fui-footer.batch-item .fui-list-angle").hide();
            modal.batch = false
        });
        $(".checkall").unbind('click').click(function () {
            var checked = $(this).find(':checkbox').prop('checked');
            $(".batch-item-check").prop('checked', checked)
        });
        $(document).off('click', '.container .fui-list .fui-list-media,.fui-list .fui-list-inner');
        $(document).on('click', '.container .fui-list .fui-list-media,.fui-list .fui-list-inner', function () {
            var item = $(this).closest('.fui-list').find('.batch-item');
            if (item.css('display') != 'none') {
                var checkbox = item.find("input");
                if (checkbox.is(":checked")) {
                    checkbox.removeAttr('checked');
                    $(".checkall input:checkbox").removeAttr('checked')
                } else {
                    checkbox.prop('checked', 'checked');
                    modal.checkAll()
                }
            } else {
                var goodsid = $(this).closest('.fui-list').data('id');
                var canJump = $(this).closest('.fui-list').data('can');
                if (goodsid && canJump) {
                    $.router.load(core.getUrl('mmanage/goods/edit', {id: goodsid}), true)
                }
            }
        });
        $("#tab a").unbind('click').click(function () {
            var status = $(this).data('status');
            if (status == modal.status) {
                return
            }
            FoxUI.loader.hide();
            $(this).addClass('active').siblings().removeClass('active');
            FoxUI.loader.show('loading');
            $(".batch-item").hide();
            $(".batch-out").show();
            $(".batch-hide").show();
            $(".fui-navbar").show();
            modal.batch = false;
            modal.offset = 0;
            modal.status = $(this).data('status');
            modal.page = 1;
            $(".container").empty();
            modal.getList()
        });
        $(document).on('click', '.btn-goods', function () {
            if (modal.stop) {
                return
            }
            var _this = $(this);
            var goodsid = _this.closest('.fui-list').data('id');
            if (goodsid == '') {
                FoxUI.toast.show("参数错误，请刷新");
                return
            }
            var obj = {id: goodsid};
            var action = _this.data('action');
            if (action == 'view') {
                $.router.load(core.getUrl('goods/detail', {id: goodsid}), true);
                return
            } else if (action == 'edit') {
                $.router.load(core.getUrl('mmanage/goods/edit', {id: goodsid}), true);
                return
            } else if (action == 'delete') {
                var confirm_text = "确认删除吗？"
            } else if (action == 'status') {
                var status = _this.data('status');
                if (status == 1) {
                    var confirm_text = "确认上架吗？";
                    obj.status = 1
                } else {
                    var confirm_text = "确认下架吗？";
                    obj.status = 0
                }
            } else if (action == 'restore') {
                var confirm_text = "确认恢复到仓库吗？"
            }
            if (action == 'delete' || action == 'status' || action == 'restore') {
                FoxUI.confirm(confirm_text, function () {
                    modal.stop = true;
                    core.json("mmanage/goods/" + action, obj, function (json) {
                        if (json.status == 1) {
                            FoxUI.toast.show("操作成功");
                            _this.closest('.fui-list').remove();
                            modal.offset++;
                            modal.getLess()
                        } else {
                            FoxUI.toast.show(json.result.message)
                        }
                        modal.stop = false
                    })
                })
            }
        });
        $(".btn-goods-batch").unbind('click').click(function () {
            if (modal.stop) {
                return
            }
            var _this = $(this);
            var ids = modal.getIds();
            if (ids.length < 1) {
                FoxUI.toast.show("请选择要批量操作的商品");
                return
            }
            var obj = {ids: ids.join(',')};
            var action = _this.data('action');
            if (action == 'delete') {
                var confirm_text = "确认删除选中商品吗？"
            } else if (action == 'status') {
                var status = _this.data('status');
                if (status == 1) {
                    var confirm_text = "确认上架选中商品吗？";
                    obj.status = 1
                } else {
                    var confirm_text = "确认下架选中商品吗？";
                    obj.status = 0
                }
            } else if (action == 'restore') {
                var confirm_text = "确认恢复到仓库吗？"
            }
            if (action == 'delete' || action == 'status' || action == 'restore') {
                FoxUI.confirm(confirm_text, function () {
                    modal.stop = true;
                    core.json("mmanage/goods/" + action, obj, function (json) {
                        if (json.status == 1) {
                            FoxUI.toast.show("操作成功");
                            $(".batch-cancel").trigger('click');
                            modal.removeCheck();
                            modal.checkAll();
                            modal.offset = modal.offset + ids.length;
                            modal.getLess()
                        } else {
                            FoxUI.toast.show(json.result.message)
                        }
                        modal.stop = false
                    })
                })
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
        if (modal.batch) {
            return
        }
        var obj = {page: modal.page, status: modal.status, keywords: modal.keywords, offset: modal.offset};
        core.json('mmanage/goods/getlist', obj, function (json) {
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
            core.tpl('.container', 'tpl_goods', result, modal.page > 1);
            FoxUI.loader.hide()
        }, false, true)
    };
    modal.getLess = function () {
        var len = $(".container").find(".fui-list").length;
        if (len <= 5) {
            modal.getList()
        }
    };
    modal.checkAll = function () {
        var checkAll = $(".batch-item-check").length < 1 ? false : true;
        $(".batch-item-check").each(function () {
            var check = $(this).is(":checked");
            if (!check) {
                checkAll = false;
                return false
            }
        });
        if (checkAll) {
            $(".checkall input:checkbox").prop('checked', 'checked')
        } else {
            $(".checkall input:checkbox").removeAttr('checked')
        }
    };
    modal.getIds = function () {
        var ids = [];
        $(".batch-item-check").each(function () {
            var check = $(this).is(":checked");
            var id = $(this).val();
            if (check && id) {
                ids.push(id)
            }
        });
        return ids
    };
    modal.removeCheck = function () {
        $(".batch-item-check").each(function () {
            var check = $(this).is(":checked");
            if (check) {
                $(this).closest(".fui-list").remove()
            }
        })
    };
    return modal
});