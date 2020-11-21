define(['./jquery.event.ue.js', './jquery.udraggable.js'], function () {
    var modal = {
        selected: 'avatar',
        inputfocus: false
    };

    modal.colors = ['#ffffff', '#f7f8fc', '#f7f4ef', '#ffb204', '#fff681', '#fbf9c9', '#009845', '#4cc601', '#1d2089', '#61cdfc', '#888888', '#dcdcdc', '#a50083', '#b43f83', '#fcd6a5', '#000000', '#e50112', '#e30047'];

    modal.defaultlist = [
        {
            tempid: 'default1',
            title: '模板1',
            thumb: '../addons/ewei_shopv2/plugin/app/static/images/poster/thumb_01.png',
            bgimg: '../addons/ewei_shopv2/plugin/app/static/images/poster/bg_01.png',
            psdurl: 'addons/ewei_shopv2/plugin/app/static/others/template_01.psd',
            items: [
                {
                    type: 'qrcode',
                    size: 'big',
                    top: 158,
                    left: 99
                },
                {
                    type: 'nickname',
                    size: 'small',
                    color: '#000000',
                    align: 'center',
                    top: 98,
                    left: 124
                },
                {
                    type: 'avatar',
                    size: 'medium',
                    style: 'circle',
                    align: 'center',
                    top: 30,
                    left: 129
                }
            ]
        },
        {
            tempid: 'default2',
            title: '模板2',
            thumb: '../addons/ewei_shopv2/plugin/app/static/images/poster/thumb_02.png',
            bgimg: '../addons/ewei_shopv2/plugin/app/static/images/poster/bg_02.png?v=2',
            psdurl: 'addons/ewei_shopv2/plugin/app/static/others/template_02.psd',
            items: [
                {
                    type: 'qrcode',
                    size: 'big',
                    top: 950,
                    left: 101
                },
                {
                    type: 'nickname',
                    size: 'small',
                    color: '#000000',
                    top: 48,
                    left: 110
                },
                {
                    type: 'avatar',
                    size: 'medium',
                    style: 'circle',
                    top: 44,
                    left: 36
                }
            ]
        },
        {
            tempid: 'default3',
            title: '模板3',
            thumb: '../addons/ewei_shopv2/plugin/app/static/images/poster/thumb_03.png',
            bgimg: '../addons/ewei_shopv2/plugin/app/static/images/poster/bg_03.png?v=2',
            psdurl: 'addons/ewei_shopv2/plugin/app/static/others/template_03.psd',
            items: [
                {
                    type: 'qrcode',
                    size: 'small',
                    top: 102,
                    left: 210
                },
                {
                    type: 'nickname',
                    size: 'small',
                    color: '#000000',
                    top: 151,
                    left: 54
                },
                {
                    type: 'avatar',
                    size: 'big',
                    style: 'circle',
                    top: 73,
                    left: 51
                }
            ]
        }
    ];

    modal.init = function (params) {
        if(params){
            modal.id = params.id || 0;
            modal.attachurl = params.attachurl || '';
            if(params.data){
                modal.data = $.extend(true, {}, params.data);
            }else{
                modal.data = $.extend(true, {}, modal.defaultlist[0]);
                modal.data.title = '未命名海报';
            }
        }

        modal.initTpl();
        modal.initPreview();
        modal.initEditor();
        modal.initClick();
    };

    modal.initClick = function () {
        $(document).keydown(function(event){
            if(event.keyCode >36 && event.keyCode < 41 && !modal.inputfocus){
                if(!modal.selected || modal.selected == ''){
                    return true;
                }
                if(event.keyCode == 37){
                    modal.update('left', -1, true, true);
                }
                else if(event.keyCode == 38){
                    modal.update('top', -1, true, true);
                }
                else if(event.keyCode == 39){
                    modal.update('left', +1, true, true);
                }
                else if(event.keyCode == 40){
                    modal.update('top', +1, true, true);
                }
                event.stopPropagation();
                event.preventDefault();
            }
        });

        $(window).bind('scroll resize', function () {
            var scrolltop = $(window).scrollTop();
            if (scrolltop > 200) {
                $('.page-panel-right').addClass('fixed');
            }else{
                $('.page-panel-right').removeClass('fixed');
            }
        });

        $('#btn-submit').click(function () {
            var $this = $(this);
            if($this.hasClass('disabled')){
                return;
            }

            if(!modal.data.title || modal.data.title == ''){
                tip.msgbox.err('请填写海报名称');
            }

            if(!modal.data.items || modal.data.items.length<1){
                tip.msgbox.err('海报元素出错，请刷新重试');
            }

            $this.text('保存中...').addClass('disabled');
            $.post(biz.url('app/poster/edit'), {
                id: modal.id,
                data: modal.data
            }, function (ret) {
                $this.text('保存海报').removeClass('disabled');
                if(ret.status != 1){
                    tip.msgbox.err(ret.result.message)
                    return;
                }
                tip.msgbox.suc(ret.result.message);
                setTimeout(function () {
                    if(ret.result.id != modal.id){
                        location.href = biz.url('app/poster/edit', {id: ret.result.id});
                    }
                }, 500);
            }, 'json');
        });
    };

    // 初始化编辑器
    modal.initEditor = function () {
        modal.selectedItem = modal.getSelected();
        var html = tpl('tpl_editor', modal);
        $('#editor').html(html);

        $('.btn-item').click(function () {
            modal.selected = $(this).data('type');
            modal.initPreview();
            modal.initEditor();
        });
        
        $('.template-list .item').click(function () {
            var index = $(this).data('index');
            var title = $(this).data('title');
            var confirmText = '确认要使用模板"'+title+'"的布局吗？';
            if(index==-1){
                confirmText = '确认使用空白模板吗？';
            }
            tip.confirm(confirmText + '<span class="text-danger">确定后将重置当前布局</span>', function () {
                if(index==-1){
                    modal.data = {
                        title: modal.data.title,
                        items: [
                            {
                                type: 'qrcode',
                                size: 'big',
                                align: 'center',
                                top: 280,
                                left: 99
                            },
                            {
                                type: 'nickname',
                                size: 'small',
                                align: 'center',
                                top: 125,
                                left: 124
                            },
                            {
                                type: 'avatar',
                                size: 'medium',
                                style: 'circle',
                                align: 'center',
                                top: 30,
                                left: 129
                            }
                        ]
                    }
                }else{
                    var old = modal.data;
                    modal.data = $.extend(true, {}, modal.defaultlist[index]);
                    modal.data.title = old.title;
                }
                modal.initPreview();
                modal.initEditor();
            });
        });

        $('.template-list .item .text .down').click(function (event) {
            event.preventDefault();
            event.stopPropagation();
            var index = $(this).closest('.item').data('index');
            if(!modal.defaultlist[index]){
                tip.msgbox.err('数据错误，请刷新重新');
                return;
            }
            var url = modal.defaultlist[index].psdurl;
            if(!url || url==''){
                tip.msgbox.err('数据错误，请刷新重新');
                return;
            }
            alert('下载pad');
        });

        $('#editor input[type="radio"]').change(function () {
            var name = $(this).attr('name');
            var val = $(this).val();
            modal.update(name, val, true);
        });

        $('#editor input[type="text"], #editor input[type="hidden"]').bind('input propertychange change', function () {
            var name = $(this).attr('name');
            var val = $(this).val();
            modal.data[name] = val;
            if(name == 'bgimg'){
                modal.initPreview();
            }
        });

        $('.btn-align').click(function () {
            if(!modal.selected || modal.selected==''){
                return;
            }
            var elm = $('.drag[data-type="' + modal.selected + '"]');
            if(elm.length<1){
                return;
            }

            var width = elm.outerWidth();
            var align = $(this).data('align');
            if(align=='left'){
                modal.update('left', 0, true);
            }
            else if(align=='right'){
                modal.update('left', 318 - width, true);
            }
            else{
                modal.update('left', 159 - width/2, true);
            }
            modal.update('align', align);
            $(this).addClass('btn-primary').removeClass('btn-default').siblings('.btn').removeClass('btn-primary').addClass('btn-default');
        });

        $('.color-list .color-block').click(function () {
            var color = $(this).data('color');
            modal.update('color', color, true);
            $('.btn-color .inner').css('background', color);
        });

        $('#editor input').focusin(function () {
            modal.inputfocus = true;
        }).focusout(function () {
            modal.inputfocus = false;
        });

        require(['bootstrap'], function ($) {
            $('[data-toggle="tooltip"]').tooltip({
                container: $(document.body)
            });
            $('[data-toggle="dropdown"]').dropdown()
        });
    };

    // 初始或左侧预览
    modal.initPreview = function () {
        var html = tpl('tpl_preview', modal);
        $('#poster').html(html);
        $('#poster .drag').on('mousedown' ,function () {
            modal.inputfocus = false;
            modal.selected = $(this).data('type');
            $(this).addClass('selected').siblings().removeClass('selected');
            modal.initEditor();
        });
        modal.initDrag();
    };

    // 初始化左侧元素拖拽
    modal.initDrag = function () {
        $('#poster .drag').udraggable({
            containment: 'parent',
            stop: function (e) {
                var elm = $(e.elem_target);
                var type = elm.data('type');
                var top = elm.css('top');
                var left = elm.css('left');
                modal.update('top', parseInt(top));
                modal.update('left', parseInt(left));
                modal.update('align', '');
                modal.initEditor();
            },
        });
    };

    // 获取当前选中元素内容
    modal.getSelected = function () {
        if(!modal.selected || modal.selected == ''){
            return {};
        }
        var selected = {};
        $.each(modal.data.items, function (index, item) {
            if(item.type == modal.selected){
                selected = item;
                return false;
            }
        });
        return selected;
    };

    // 更新当前选中元素内容
    modal.update = function (name, value, init, calc) {
        if(!modal.selected || modal.selected == '' || !name || name==''){
            return false;
        }
        var selected = {};
        $.each(modal.data.items, function (index, item) {
            if(item.type == modal.selected){
                selected = index;
                return false;
            }
        });
        if(!modal.data.items[selected]){
            return false;
        }
        if(calc){
            modal.data.items[selected][name] += value;
        }else{
            modal.data.items[selected][name] = value;
        }

        if(init){
            modal.initPreview();
        }
    };

    /**
     * 列表操作
     */
    modal.initList = function () {
        $('.btn-delete').click(function () {
            var id = $(this).closest('.item').data('id');
            if(!id || id == ''){
                tip.msgbox.err('删除失败，刷新重试');
                return;
            }
            var title = $(this).closest('.item').find('.title').text();
            tip.confirm('确认删除海报"'+ title+ '"吗？', function () {
                $.getJSON(biz.url('app/poster/delete'), {
                    id: id
                }, function (ret) {
                    tip.msgbox.suc('删除成功');
                    setTimeout(function () {
                        location.reload();
                    }, 500);
                });
            });
        });

        $('.btn-handle').click(function () {
            var action = $(this).data('action');
            var id = $(this).closest('.item').data('id');
            if(!id || id==''){
                tip.msgbox.err('数据错误，请刷新重试');
                return;
            }
            var title = $(this).closest('.item').find('.title').text();
            var confirmText = action=='disabled'? '取消使用': '立即使用';
            tip.confirm('确认' + confirmText + '海报"'+ title+ '"吗？', function () {
                $.getJSON(biz.url('app/poster/status'), {
                    id: id,
                    status: action=='disabled'? 0: 1
                }, function (ret) {
                    if(ret.status==1){
                        tip.msgbox.suc('操作成功');
                    }else{
                        tip.msgbox.err(ret.result.message);
                    }
                    setTimeout(function () {
                        location.reload();
                    }, 500);
                });
            })
        });
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
        tpl.helper("classname", function (item, selected) {
            if(typeof(item) != 'object'){
                return '';
            }
            var classname = item.type + '-' + item.size;
            if(item.style){
                classname += ' ' + item.style;
            }
            if(selected && selected == item.type){
                classname += ' selected';
            }

            return classname;
        });
    };

    return modal
});