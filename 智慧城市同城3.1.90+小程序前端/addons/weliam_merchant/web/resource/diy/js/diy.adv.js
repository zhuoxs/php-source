define(['jquery.ui'], function (ui) {
    var modal = {itemid: ''};
    modal.init = function (params) {
        window.tpl = params.tpl;
        modal.attachurl = params.attachurl;
        modal.advs = params.menu;
        modal.id = params.id;
        modal.merch = params.merch;
        modal.adv_class = params.adv_class;
        modal.back_url = params.back_url;
        if (!modal.advs) {
            modal.advs = {
                name: '未命名启动广告',
                params: {
                    'style': 'small-bot',
                    'showtype': '1',
                    'showtime': '60',
                    'autoclose': '10',
                    'canclose': '1'
                },
                style: {
                    'background': '#000000',
                    'opacity': '0.6'
                },
                data: {
                    M0123456789101: {
                        imgurl: '../addons/weliam_merchant/web/resource/diy/images/adv-1.jpg',
                        linkurl: '',
                        click: '0',
                        url_type:'',
                    },
                    M0123456789102: {
                        imgurl: '../addons/weliam_merchant/web/resource/diy/images/adv-2.jpg',
                        linkurl: '',
                        click: '0',
                        url_type:'',
                    },
                    M0123456789103: {
                        imgurl: '../addons/weliam_merchant/web/resource/diy/images/adv-3.jpg',
                        linkurl: '',
                        click: '0',
                        url_type:'',
                    }
                }
            }
        }
        tpl.helper("imgsrc", function (src) {
            if (typeof src != 'string') {
                return ''
            }
            if (src.indexOf('http://') == 0 || src.indexOf('https://') == 0 || src.indexOf('../addons') == 0) {
                return src
            } else if (src.indexOf('images/') == 0) {
                return modal.attachurl + src
            }
        });
        tpl.helper("count", function (data) {
            return modal.length(data)
        });
        tpl.helper("link", function (link) {
            if (!link) {
                return
            }
            return '../app/' + link
        });
        tpl.helper("px", function (num) {
            return num / 20
        });
        modal.initItems();
        modal.initEditor();
        modal.initGotop();
        modal.selectGoods();
        $(".btn-save").unbind('click').click(function () {
            var status = $(this).data('status');
            if (status) {
                tip.msgbox.err("正在保存，请稍候。。。");
                return
            }
            modal.save()
        })
    };
    modal.initItems = function () {
        var html = tpl("tpl_show_menu", modal.advs);
        $("#phone").html(html).show();
        var len = $(".diymenu .child").length;
        $(".diymenu .child").each(function (i) {
            var width = $(this).outerWidth();
            var margin = -(width / 2);
            var left = '50%';
            var pleft = $(this).position().left - width / 2;
            if(i==0 && pleft<2){
                left = 2;
                margin = 0;
                var pwidth = $(this).closest('.item').width();
                var arrowleft = pwidth / 2;
                var oldleft = parseFloat($(this).find('.arrow').css('left').replace('px', ''));
                $(this).find('.arrow').css({'left': arrowleft - 10, 'margin-left': 0})
            } else if (i + 1 == len) {
                var pwidth = $(this).closest('.item').width();
                if(width>pwidth){
                    var left =  - (width - pwidth) - 2;
                    margin = 0;
                    var c = $(this).closest('.item').width() / 2;
                    var arrowleft = width - c;
                    $(this).find('.arrow').css({'left': arrowleft - 8, 'margin-left': 0})
                }
            }
            $(this).css({'position': 'absolute', 'left': left, 'margin-left': margin, 'z-index': 0})
        })
    };
    modal.initSortable = function () {
        $("#diy-editor .inner").sortable({
            opacity: 0.8,
            placeholder: "highlight",
            items: '.item',
            revert: 100,
            scroll: false,
            cancel: '.goods-selector,input,.btn',
            start: function (event, ui) {
                var height = ui.item.height();
                $(".highlight").css({"height": height + 22 + "px"});
                $(".highlight").html('<div><i class="fa fa-plus"></i> 放置此处</div>');
                $(".highlight div").css({"line-height": height + 16 + "px"})
            },
            update: function (event, ui) {
                modal.sortItems()
            }
        });
        $("#diy-editor .inner .item-child").sortable({
            opacity: 0.8,
            placeholder: "highlight",
            items: '.item-body',
            revert: 100,
            scroll: false,
            cancel: '.goods-selector,input,.btn',
            start: function (event, ui) {
                var height = ui.item.height();
                $(".highlight").css({"height": height + "px"});
                $(".highlight").html('<div><i class="fa fa-plus"></i> 放置此处</div>');
                $(".highlight div").css({"line-height": height + 16 + "px"})
            },
            update: function (event, ui) {
                modal.sortChild()
            }
        })
    };
    modal.sortItems = function () {
        var newItems = {};
        $("#diy-editor .inner .item").each(function () {
            var thisid = $(this).data('id');
            newItems[thisid] = modal.advs.data[thisid]
        });
        modal.advs.data = newItems;
        modal.initItems()
    };
    modal.sortChild = function () {
        var newChild = {};
        var itemid = modal.itemid;
        $("#diy-editor .inner").find(".item[data-id='" + itemid + "'] .item-child .child").each(function () {
            var thisid = $(this).data('id');
            newChild[thisid] = modal.advs.data[itemid].child[thisid]
        });
        modal.advs.data[itemid].child = newChild;
        modal.initItems()
    };
    modal.initEditor = function () {
        var html = tpl("tpl_edit_menu", modal.advs);
        $("#diy-editor .inner").html(html);
        $("#diy-editor #addChild").unbind('click').click(function () {
            var itemid = $(this).closest('.item').data('id');
            var childid = modal.getId('C', 0);
            if (!modal.advs.data[itemid].child) {
                modal.advs.data[itemid].child = {}
            }
            modal.advs.data[itemid].child[childid] = {linkurl: '', text: '二级菜单'};
            modal.initItems();
            modal.initEditor()
        });
        $("#diy-editor #addItem").unbind('click').click(function () {
            var itemid = modal.getId('M', 0);
            var max = $(this).closest('.form-items').data('max');
            var num = modal.length(modal.advs.data);
            if (num >= max) {
                tip.msgbox.err("最大添加 " + max + " 个！");
                return
            }
            modal.advs.data[itemid] = {
                imgurl: '../addons/weliam_merchant/web/resource/diy/images/adv-3.jpg',
                linkurl: '',
                click: '0',
                url_type:'',
            };
            modal.initItems();
            modal.initEditor()
        });
        $("#diy-editor .del-item").unbind('click').click(function () {
            var min = $(this).closest('.form-items').data('min');
            var itemid = $(this).closest('.item').data('id');
            if (min) {
                var length = modal.length(modal.advs.data);
                if (length <= min) {
                    tip.msgbox.err("至少保留 " + min + " 个！");
                    return
                }
            }
            tip.confirm("确定删除吗", function () {
                delete modal.advs.data[itemid];
                modal.initItems();
                modal.initEditor()
            })
        });
        $("#diy-editor .del-child").unbind('click').click(function () {
            var itemid = $(this).closest('.item').data('id');
            var childid = $(this).closest('.child').data('id');
            var item = modal.advs.data[itemid];
            if (item) {
                var child = modal.advs.data[itemid].child[childid];
                if (child) {
                    tip.confirm("确定删除吗", function () {
                        delete modal.advs.data[itemid].child[childid];
                        modal.initItems();
                        modal.initEditor()
                    })
                }
            }
        });
        $("#diy-editor .fold").unbind('click').click(function () {
            var type = $(this).data('type');
            if (type == 1) {
                $(this).text('收起').data('type', 0).closest('.item').find('.item-child').show()
            } else {
                $(this).text('展开').data('type', 1).closest('.item').find('.item-child').hide()
            }
        });
        $(document).on('mousedown', "#diy-editor .item-child .child", function () {
            var itemid = $(this).closest('.item').data('id');
            modal.itemid = itemid
        });
        $("#diy-editor .slider").each(function () {
            var decimal = $(this).data('decimal');
            var multiply = $(this).data('multiply');
            var defaultValue = $(this).data("value");
            if (decimal) {
                defaultValue = defaultValue * decimal
            }
            $(this).slider({
                slide: function (event, ui) {
                    var sliderValue = ui.value;
                    if (decimal) {
                        sliderValue = sliderValue / decimal
                    }
                    $(this).siblings(".input").val(sliderValue).trigger("propertychange");
                    $(this).siblings(".count").find("span").text(sliderValue)
                }, value: defaultValue, min: $(this).data("min"), max: $(this).data("max")
            })
        });
        $("#diy-editor").find(".diy-bind").bind('input propertychange change', function () {
            var _this = $(this);
            var bind = _this.data("bind");
            var bindchild = _this.data('bind-child');
            var bindparent = _this.data('bind-parent');
            var bindthree = _this.data('bind-three');
            var initEditor = _this.data('bind-init');
            var url_type    = $(this).data("types");
            var value = '';
            var tag = this.tagName;
            if (tag == 'INPUT') {
                var placeholder = _this.data('placeholder');
                value = _this.val();
                value = value == '' ? placeholder : value
            } else if (tag == 'SELECT') {
                value = _this.find('option:selected').val()
            } else if (tag == 'TEXTAREA') {
                value = _this.val()
            }
            value = $.trim(value);
            if (bindchild) {
                if (bindparent) {
                    if (bindthree) {
                        modal.advs[bindchild][bindparent].child[bindthree][bind] = value;
                    } else {
                        modal.advs[bindchild][bindparent][bind] = value;
                        if(url_type){
                            modal.advs[bindchild][bindparent]['url_type'] = url_type;
                        }
                    }
                } else {
                    modal.advs[bindchild][bind] = value
                }
            } else {
                modal.advs[bind] = value
            }

            modal.initItems();
            if (initEditor) {
                modal.initEditor()
            }
        });
        $("#phone").mouseenter(function () {
            $("#diy-editor").find('.diy-bind').blur()
        });
        $("#diy-editor").show();
        modal.initSortable()
    };
    modal.initGotop = function () {
        $(window).bind('scroll resize', function () {
            var scrolltop = $(window).scrollTop();
            if (scrolltop > 100) {
                $("#gotop").show()
            } else {
                $("#gotop").hide()
            }
            $("#gotop").unbind('click').click(function () {
                $('body').animate({scrollTop: "0px"}, 1000)
            })
        })
    };
    modal.length = function (json) {
        if (typeof(json) === 'undefined') {
            return 0
        }
        var jsonlen = 0;
        for (var item in json) {
            jsonlen++
        }
        return jsonlen
    };
    modal.getId = function (S, N) {
        var date = +new Date();
        var id = S + (date + N);
        return id
    };
    modal.save = function () {
        if (!modal.advs.data) {
            tip.msgbox.err("广告内容为空！");
            return
        }
        $(".btn-save").data('status', 1).text("保存中...");
        var posturl = biz.url("diy/diy/saveAdv", null, modal.merch);
        $.post(posturl, {id: modal.id, advs: modal.advs,adv_class:modal.adv_class}, function (ret) {
            if (ret.errno == 0) {
                tip.msgbox.err(ret.message);
                $(".btn-save").text("保存广告").data("status", 0);
                return
            }
            tip.msgbox.suc("保存成功！", ret.data);
        }, 'json')
    };
    //选择商品
    modal.selectGoods = function () {
        //商品组件 - 点击选择商品
        $("#diy-editor").on('click','.selectGoods',function () {
            var itemid = $(this).attr("itemid");
            modal.getGoods(0, '', '', itemid);
        });
        //商品组件 - 点击商品信息栏分页获取当前页内容
        $("#SelectGoodsContent").on('click', '.paging_button', function() {
            var plugin = $(this).data("plugin");
            var page = $(this).data("page");
            var itemid = $("#SelectGoodsContent").attr("itmeid");
            var search = $("#SelectGoodsContent .searchContent").children("input").val();
            modal.getGoods(plugin, page,search,itemid);
        });
        //商品组件 - 搜索商品
        $("#SelectGoodsContent").on('click', '.goodsSelect', function() {
            var plugin = $(this).data("plugin");
            var search = $(this).prev(".searchContent").children("input").val();
            var itemid = $("#SelectGoodsContent").attr("itmeid");
            modal.getGoods(plugin, 1, search,itemid);
        });
        //商品组件 - 点击选中商品
        $("#SelectGoodsContent").on('click', '.selectGoods', function() {
            var key = $(this).data("key");
            var keys = $(this).data("keys");
            var info = modal.goods[key];
            modal.advs.data[keys]['imgurl'] = info.logo;
            modal.advs.data[keys]['linkurl'] = info.detail_url;
            modal.initItems();
            //更新配置信息
            var urlid = '#curl-'+keys;
            var imgid = '#cimg-'+keys;
            $(urlid).val(info.detail_url);
            $(imgid).val(info.logo);
            //关闭弹框
            $("#SelectGoodsContent").modal('hide');
        });

    };
    //获取商品信息，显示弹框
    modal.getGoods = function(plugin, page, search, keys) {
        var info;
        $.ajax({
            url: biz.url('diy/diy/getGoodsInfo'),
            data: {
                plugin: plugin,
                page: page,
                search: search,
                geturl:1//需要返回商品详情页面的跳转地址
            },
            dataType: "json",
            async: false,
            success: function(res) {
                if(res.errno == 0) {
                    tip.msgbox.err(res.message);
                    return false;
                }
                info = res.data;
                modal.goods = info['goods'];
                info['plugin'] = plugin;
                info['keys'] = keys;
                info['search'] = search;
                //显示弹框
                var html = tpl("tplSelectGoods", info);
                $("#SelectGoodsContent").html(html);
                $("#SelectGoodsContent").modal();
                $("#SelectGoodsContent").attr("itmeid",keys);
                if(info['page_number'] <= 1) {
                    return false
                }
                //建立分页内容
                modal.createPaging(info, plugin);
            }
        });
    };
    //为弹框建立分页的页码按钮
    modal.createPaging = function(info, plugin) {
        var page_html = '';
        if(info['page'] > 1) {
            page_html += "<div class='paging_button' data-plugin='" + plugin + "' data-page='1'>首页</div>";
            page_html += "<div class='paging_button' data-plugin='" + plugin + "' data-page='" + (info['page'] - 1) + "'>上一页</div>";
        }
        for(var i = 1; i <= info['page_number']; i++) {
            if(i == info['page']) {
                page_html += "<div class='paging_button paging_pageNumber paging_active' data-plugin='" + plugin + "' data-page='" + i + "'>" + i + "</div>";
            } else {
                page_html += "<div class='paging_button paging_pageNumber' data-plugin='" + plugin + "' data-page='" + i + "'>" + i + "</div>";
            }
        }
        var show_num = 5; //显示的按钮数量
        var but_num = Math.floor(parseInt(show_num) / parseInt(2)); //两边的数量
        if(info['page_number'] > info['page']) {
            page_html += "<div  class='paging_button' data-plugin='" + plugin + "' data-page='" + (parseInt(info['page']) + parseInt(1)) + "'>下一页</div>";
            page_html += "<div  class='paging_button' data-plugin='" + plugin + "' data-page='" + info['page_number'] + "'>尾页</div>";
        }
        if(info['state'] == 'headline') {
            $("#SelectHeadlineContent .paging").html(page_html);
        }else if(info['state'] == 'shop'){
            $("#SelectShopContent .paging").html(page_html);
        } else {
            $("#SelectGoodsContent .paging").html(page_html);
        }
        //删除多余的分页按钮
        if(info['page_number'] > show_num) {
            if(info['page'] <= (parseInt(but_num) + parseInt(1))) {
                //删除大于五的内容
                $(".paging_pageNumber:gt(" + (show_num - 1) + ")").remove();
            } else if(info['page'] >= (parseInt(info['page_number']) - parseInt(but_num))) {
                //删除小于总页数减 show_num 的数的内容
                var maxNumber = parseInt(info['page_number']) - parseInt(show_num);
                $(".paging_pageNumber:lt(" + maxNumber + ")").remove();
            } else {
                //删除两边 当前数位移 but_num 数量后的内容
                var min_num = parseInt(info['page']) - (parseInt(but_num) + parseInt(1)); //最小显示的页面 左
                $(".paging_pageNumber:lt(" + min_num + ")").remove();
                $(".paging_pageNumber:gt(" + (show_num - 1) + ")").remove();
            }
        }
    };
    return modal
});