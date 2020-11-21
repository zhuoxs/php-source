define(['core', './sortable.js'], function (core, Sortable) {
    var modal = {paction: false};
    modal.initDetail = function (params) {
        modal.category = params.category;
        modal.initClick();
        modal.initSort()
    };
    modal.getVal = function (elm, int, isClass) {
        var mark = isClass ? "." : "#";
        var value = $.trim($(mark + elm).val());
        if (int) {
            if (value == '') {
                return 0
            }
            value = parseInt(value)
        }
        return value
    };
    modal.checkVal = function (elm, isClass) {
        var mark = isClass ? "." : "#";
        var checked = $(mark + elm).is(":checked") ? 1 : 0;
        return checked
    };
    modal.radioVal = function (name, int) {
        if (!name || name == '') {
            return int ? 0 : ''
        }
        var value = $("input[name='" + name + "']:checked").val();
        return value
    };
    modal.initSort = function () {
        new Sortable(thumbs, {draggable: 'li'})
    };
    modal.initClick = function () {
        $('.fui-uploader').uploader({
            uploadUrl: core.getUrl('mmanage/util/uploader'),
            removeUrl: core.getUrl('mmanage/util/uploader/remove')
        });
        $(".btn-submit").unbind('click').click(function () {
            if (modal.stop) {
                return
            }
            var obj = {
                id: modal.getVal('id', true),
                title: modal.getVal('title'),
                subtitle: modal.getVal('subtitle'),
                unit: modal.getVal('unit'),
                status: modal.checkVal('status'),
                showtotal: modal.checkVal('showtotal'),
                cash: modal.checkVal('cash') ? 2 : 0,
                invoice: modal.checkVal('invoice'),
                isnodiscount: modal.checkVal('isnodiscount') ? 0 : 1,
                nocommission: modal.checkVal('nocommission') ? 0 : 1,
                isrecommand: modal.checkVal('isrecommand'),
                isnew: modal.checkVal('isnew'),
                ishot: modal.checkVal('ishot'),
                issendfree: modal.checkVal('issendfree'),
                totalcnf: modal.getVal('totalcnf', true),
                showlevels: modal.getVal('showlevels'),
                showgroups: modal.getVal('showgroups'),
                buylevels: modal.getVal('buylevels'),
                buygroups: modal.getVal('buygroups'),
                cates: modal.getVal('cates'),
                maxbuy: modal.getVal('maxbuy', true),
                minbuy: modal.getVal('minbuy', true),
                usermaxbuy: modal.getVal('usermaxbuy', true),
                diypage: modal.getVal('diypage', true),
                diyformid: modal.getVal('diyformid', true),
                dispatchtype: modal.radioVal('dispatchtype', true),
                displayorder: modal.getVal('displayorder', true)
            };
            var thumbs = [];
            $("#thumbs li").each(function () {
                var filename = $.trim($(this).data('filename'));
                if (filename) {
                    thumbs.push(filename)
                }
            });
            if (thumbs.length < 1) {
                FoxUI.toast.show("请选择商品图片");
                return
            }
            obj.thumbs = thumbs;
            if (obj.id < 1) {
                obj.type = modal.getVal('type', true)
            }
            var hasoption = modal.getVal('hasoption', true);
            if (hasoption == 0) {
                obj.marketprice = modal.getVal('marketprice');
                obj.productprice = modal.getVal('productprice');
                obj.costprice = modal.getVal('costprice');
                obj.hasoption = 0;
                obj.total = modal.getVal('total', true);
                obj.weight = modal.getVal('weight');
                obj.goodssn = modal.getVal('goodssn');
                obj.productsn = modal.getVal('productsn')
            }
            if (obj.dispatchtype == 0) {
                obj.dispatchid = modal.radioVal("dispatchid", true)
            } else {
                obj.dispatchprice = modal.getVal("dispatchprice")
            }
            if (obj.title == '') {
                FoxUI.toast.show("请填写商品名称");
                return
            }
            FoxUI.confirm("确定保存编辑吗？", function () {
                modal.stop = true;
                var postUrl = obj.id < 1 ? "mmanage/goods/add" : "mmanage/goods/edit";
                core.json(postUrl, obj, function (json) {
                    if (json.status == 1) {
                        FoxUI.toast.show("操作成功");
                        if (json.result.id) {
                            location.href = core.getUrl('mmanage/goods/edit', {id: json.result.id});
                            return
                        }
                    } else {
                        FoxUI.toast.show(json.result.message)
                    }
                    modal.stop = false
                }, true, true)
            })
        });
        $(".check-param").unbind('click').click(function () {
            var action = $(this).data('action');
            if (action) {
                modal.paction = action;
                modal.showParams()
            }
        });
        $(".cancel-params").unbind('click').click(function () {
            modal.hideParams()
        });
        $(".submit-params").unbind('click').click(function () {
            var action = modal.paction;
            if (!action) {
                modal.hideParams();
                return
            }
            if (action == 'type') {
                var value = $(this).data('value');
                $("#type").val(value);
                var text = $(this).find(".fui-cell-text").text();
                $(".check-param[data-action='type']").find('.fui-cell-info').text(text)
            } else if (action == 'cate') {
                var cateArr = [], catetitleArr = [];
                $(".param-cate .small-block .item").each(function () {
                    var cateid = $(this).data('cateid');
                    var catename = $.trim($(this).text());
                    if (cateid) {
                        cateArr.push(cateid);
                        catetitleArr.push(catename)
                    }
                });
                var cates = cateArr.join(',');
                var text = catetitleArr.join(',');
                $("#cates").val(cates);
                $(".check-param[data-action='cate']").find('.fui-cell-info').text(text || "未分类")
            } else if (action == 'prop') {
                var prop = [];
                $(".param-prop .param-child").each(function () {
                    var checked = $(this).is(":checked");
                    var text = $(this).data('text');
                    if (checked) {
                        prop.push(text)
                    }
                });
                var text = prop.join("、") || "无";
                $(".check-param[data-action='prop']").find('.fui-cell-info').text(text)
            } else if (action == 'viewlevel') {
                var levels = [], level_ids = [];
                $(".param-viewlevel .param-child").each(function () {
                    var checked = $(this).is(":checked");
                    var text = $(this).data('text');
                    var value = $(this).val();
                    if (checked) {
                        levels.push(text);
                        level_ids.push(parseInt(value))
                    }
                });
                var text = levels.join("、") || "不限制";
                var levelids = level_ids.join(",") || "";
                $("#showlevels").val(levelids);
                $(".check-param[data-action='viewlevel']").find('.fui-cell-info').text(text)
            } else if (action == 'viewgroup') {
                var groups = [], group_ids = [];
                $(".param-viewgroup .param-child").each(function () {
                    var checked = $(this).is(":checked");
                    var text = $(this).data('text');
                    var value = $(this).val();
                    if (checked) {
                        groups.push(text);
                        group_ids.push(parseInt(value))
                    }
                });
                var text = groups.join("、") || "不限制";
                var groupids = group_ids.join(",") || "";
                $("#showgroups").val(groupids);
                $(".check-param[data-action='viewgroup']").find('.fui-cell-info').text(text)
            } else if (action == 'buylevel') {
                var levels = [], level_ids = [];
                $(".param-buylevel .param-child").each(function () {
                    var checked = $(this).is(":checked");
                    var text = $(this).data('text');
                    var value = $(this).val();
                    if (checked) {
                        levels.push(text);
                        level_ids.push(parseInt(value))
                    }
                });
                var text = levels.join("、") || "不限制";
                var levelids = level_ids.join(",") || "";
                $("#buylevels").val(levelids);
                $(".check-param[data-action='buylevel']").find('.fui-cell-info').text(text)
            } else if (action == 'buygroup') {
                var groups = [], group_ids = [];
                $(".param-buygroup .param-child").each(function () {
                    var checked = $(this).is(":checked");
                    var text = $(this).data('text');
                    var value = $(this).val();
                    if (checked) {
                        groups.push(text);
                        group_ids.push(parseInt(value))
                    }
                });
                var text = groups.join("、") || "不限制";
                var groupids = group_ids.join(",") || "";
                $("#buygroups").val(groupids);
                $(".check-param[data-action='buygroup']").find('.fui-cell-info').text(text)
            } else if (action == 'totalcnf') {
                var value = $(this).data('value');
                $("#totalcnf").val(value);
                var text = $(this).find(".fui-cell-text").text();
                $(".check-param[data-action='totalcnf']").find('.fui-cell-remark').text(text)
            } else if (action == 'diypage') {
                var value = $(this).data('id');
                $("#diypage").val(value);
                var text = $(this).find(".fui-cell-text").text();
                $(".check-param[data-action='diypage']").find('.fui-cell-info').text(text)
            } else if (action == 'diyform') {
                var value = $(this).data('id');
                $("#diyformid").val(value);
                var text = $(this).find(".fui-cell-text").text();
                $(".check-param[data-action='diyform']").find('.fui-cell-info').text(text)
            } else if (action == 'dispatch') {
                var dispatchtype = $("input[name='dispatchtype']:checked").val();
                if (dispatchtype == 0) {
                    var dispatchid = $("input[name='dispatchid']:checked").val();
                    var dispatchname = $("input[name='dispatchid']:checked").closest(".fui-list").find(".subtitle").text();
                    var text = "模板: " + dispatchname;
                    $("#dispatchid").val(dispatchid)
                } else {
                    var dispatchprice = modal.getVal("dispatchprice");
                    var text = "统一运费 " + dispatchprice + "元"
                }
                $(".check-param[data-action='dispatch']").find('.fui-cell-info').text(text)
            }
            modal.hideParams()
        });
        $(".bindclick").unbind('click').click(function () {
            var item = $(this).closest(".fui-list");
            var input = item.find("input");
            if (!input.is(":checked")) {
                input.prop('checked', 'checked').trigger('change')
            } else {
                if (input.attr('type') == 'checkbox') {
                    input.removeAttr('checked').trigger('change')
                }
            }
            var show = $(this).data('show');
            var hide = $(this).data('hide');
            if (hide) {
                $("." + hide).hide()
            }
            if (show) {
                $("." + show).show()
            }
        });
        $(".toggle").unbind('click').click(function () {
            var show = $(this).data('show');
            var hide = $(this).data('hide');
            if (hide) {
                $("." + hide).hide()
            }
            if (show) {
                $("." + show).show()
            }
        });
        $(document).off('click', '.cate-list nav');
        $(document).on('click', '.cate-list nav', function () {
            var catlevel = $(this).closest('.cate-list').data('catlevel');
            var item = $(this).closest(".item");
            var level = item.data('level');
            $(this).addClass('active').siblings().removeClass('active');
            modal.lastcateid = $(this).data('id');
            if (level >= catlevel) {
                return
            }
            var next = $(this).closest('.item').next('.item');
            if (level == 1 || level == 2) {
                next.empty().html('<div class="empty">请选择上级</div>')
            }
            if (level == 1) {
                next.next(".item").empty().html('<div class="empty">请选择上级</div>')
            }
            var children = modal.category['children'];
            if ($.isEmptyObject(children)) {
                children = {}
            }
            children = children = children[modal.lastcateid];
            if ($.isEmptyObject(children)) {
                next.html('<div class="empty">无子分类</div>');
                if (level == 1) {
                    next.next(".item").html('<div class="empty">无子分类</div>')
                }
                return
            }
            var HTML = "";
            $.each(children, function () {
                HTML += "<nav data-id='" + this.id + "'>" + this.name + "</nav> "
            });
            next.html(HTML)
        });
        $(".btn-choose-cate").unbind('click').click(function () {
            var cate = [];
            $(".cate-list").find(".item").each(function (i, e) {
                var cateitem = $(this).find("nav.active");
                if (cateitem.length > 0) {
                    var text = cateitem.text();
                    cate.push(text)
                }
            });
            var texts = cate.join('-');
            var block = $(".small-block");
            var find = block.find(".item[data-cateid='" + modal.lastcateid + "']").length;
            if (find > 0) {
                FoxUI.toast.show("该分类已经选择");
                return
            }
            $(".small-block").append('<span class="item" data-cateid="' + modal.lastcateid + '">' + texts + ' <i class="icon icon-close"></i></span>')
        });
        $(".small-block .item .icon-close").unbind('click').click(function () {
            $(this).closest(".item").remove()
        })
    };
    modal.showParams = function () {
        if (!modal.paction) {
            return
        } else if (modal.paction == 'prop' || modal.paction == 'cate' || modal.paction == 'dispatch' || modal.paction == 'viewlevel' || modal.paction == 'viewgroup' || modal.paction == 'buylevel' || modal.paction == 'buygroup') {
            $(".params-block .fui-navbar .submit-params").css('display', 'table-cell')
        } else if (modal.paction == 'type' || modal.paction == 'totalcnf' || modal.paction == 'diyform' || modal.paction == 'diypage') {
            $(".params-block .fui-navbar .cancel-params").css('display', 'table-cell')
        }
        var params_item = $(".params-block").find(".param-" + modal.paction);
        if (params_item.length < 1) {
            return
        }
        params_item.show();
        $(".params-block").addClass('in');
        $(".btn-back").hide()
    };
    modal.hideParams = function () {
        $(".params-block .fui-navbar .nav-item").hide();
        $(".params-block").find(".param-item").hide();
        $(".params-block").removeClass('in');
        $(".btn-back").show();
        modal.paction = false
    };
    return modal
});