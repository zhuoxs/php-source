/**
 * 调用参数,方法如:$('#more').more({'url': 'data.php'});
 * amount  :'10'           每次显示记录数
 * url :'comments.php'     请求后台的地址
 * data:{},                自定义参数
 * template:'.single_item' html记录DIV的class属性
 * trigger :'#get_more'    触发加载更多记录的class属性
 * scroll  :'false'        是否支持滚动触发加载
 * offset  :'100'          滚动触发加载时的偏移量
 */
(function($) {
    var target = null;
    var template = null;
    var lock = false;
    var variables = {
        'last': 0
    };
    var settings = {
        'amount': '10',
        'url': '',
        'template': '.single_item',
        'data':{},
        'trigger': '#get_more',
        'scroll': 'false',
        'offset': '100'
    };
    var methods = {
        init: function(options) {
            return this.each(function() {
                if (options) {
                    $.extend(settings, options);
                }
                template = $(this).children(settings.template).wrap('<div/>').parent();
                template.css('display', 'none');
                $(this).append('<div class="loading ft12" id="waitbox"><img src="/static/m/images/loading.gif" width="19" height="19" />载入中..</div>');
                $(this).children(settings.template).remove();
                target = $(this);
                if (settings.scroll == 'false') {
                    $(this).find(settings.trigger).bind('click.more', methods.get_data);
                    $(this).more('get_data');
                } else {
                    if ($(this).height() <= $(this).attr('scrollHeight')) {
                        target.more('get_data', settings.amount * 2);
                    }
                    $(this).bind('scroll.more', methods.check_scroll);
                }
            });
        },
        check_scroll: function() {
            if ((target.scrollTop() + target.height() + parseInt(settings.offset)) >= target.attr('scrollHeight') && lock == false) {
                target.more('get_data');
            }
        },
        remove: function() {
            target.children(settings.trigger).unbind('.more');
            target.unbind('.more');
            target.children(settings.trigger).remove();
        },
        add_elements: function(data) {
            var root = target;
            var counter = 0;
            if (data) {
                $(data).each(function() {
                    counter++;
                    var t = template;
                    $.each(this, function(key, value) {
                        if (t.find('.' + key))
                            t.find('.' + key).html(value);
                    });
                    if (settings.scroll == 'true') {
                        root.children('.more_loader_spinner').before(t.html());
                    } else {
                        root.children(settings.trigger).before(t.html());
                    }
                    root.children(settings.template + ':last').attr('id', 'more_element_' + ((variables.last++) + 1));
                });
            } else {
                methods.remove();
            }
            target.children('.more_loader_spinner').css('display', 'none');
            if (counter < settings.amount)
                methods.remove();
        },
        get_data: function() {
            var ile;
            lock = true;
            target.children(".more_loader_spinner").css('display', 'block');
            $(settings.trigger).css('display', 'none');
            if (typeof (arguments[0]) == 'number')
                ile = arguments[0];
            else {
                ile = settings.amount;
            }
            var postdata = settings.data;
                postdata['last'] = variables.last;
                postdata['amount'] = ile;
            $.post(settings.url, postdata, function(data) {
                $(settings.trigger).css('display', 'block');
                methods.add_elements(data);
                lock = false;
                $("#waitbox").remove();
            }, 'json');
        }
    };
    $.fn.more = function(method) {
        if (methods[method])
            return methods[ method ].apply(this, Array.prototype.slice.call(arguments, 1));
        else if (typeof method == 'object' || !method)
            return methods.init.apply(this, arguments);
        else
            $.error('Method ' + method + ' does not exist!');
    }
})(jQuery)