define(['jquery', 'bootstrap'], function($, bs) {
	window.redirect = function(url) {
        location.href = url
    }, $(document).on('click', '[data-toggle=refresh]', function(e) {
        e && e.preventDefault();
        var url = $(e.target).data("href");
        url ? window.location = url : window.location.reload()
    }), $(document).on('click', '[data-toggle=back]', function(e) {
        e && e.preventDefault();
        var url = $(e.target).data("href");
        url ? window.location = url : window.history.back()
    });

    function _bindCssEvent(events, callback) {
        var dom = this;

        function fireCallBack(e) {
            if (e.target !== this) {
                return
            }
            callback.call(this, e);
            for (var i = 0; i < events.length; i++) {
                dom.off(events[i], fireCallBack)
            }
        }
        if (callback) {
            for (var i = 0; i < events.length; i++) {
                dom.on(events[i], fireCallBack)
            }
        }
    }
    $.fn.animationEnd = function(callback) {
        _bindCssEvent.call(this, ['webkitAnimationEnd', 'animationend'], callback);
        return this
    };
    $.fn.transitionEnd = function(callback) {
        _bindCssEvent.call(this, ['webkitTransitionEnd', 'transitionend'], callback);
        return this
    };
    $.fn.transition = function(duration) {
        if (typeof duration !== 'string') {
            duration = duration + 'ms'
        }
        for (var i = 0; i < this.length; i++) {
            var elStyle = this[i].style;
            elStyle.webkitTransitionDuration = elStyle.MozTransitionDuration = elStyle.transitionDuration = duration
        }
        return this
    };
    $.fn.transform = function(transform) {
        for (var i = 0; i < this.length; i++) {
            var elStyle = this[i].style;
            elStyle.webkitTransform = elStyle.MozTransform = elStyle.transform = transform
        }
        return this
    };
    $.toQueryPair = function(key, value) {
        if (typeof value == 'undefined') {
            return key
        }
        return key + '=' + encodeURIComponent(value === null ? '' : String(value))
    };
    $.toQueryString = function(obj) {
        var ret = [];
        for (var key in obj) {
            key = encodeURIComponent(key);
            var values = obj[key];
            if (values && values.constructor == Array) {
                var queryValues = [];
                for (var i = 0, len = values.length, value; i < len; i++) {
                    value = values[i];
                    queryValues.push($.toQueryPair(key, value))
                }
                ret = concat(queryValues)
            } else {
                ret.push($.toQueryPair(key, values))
            }
        }
        return ret.join('&')
    };
    $.fn.append2 = function(html, callback) {
        var len = $("body").html().length;
        this.append(html);
        var e = 1,
            interval = setInterval(function() {
                e++;
                var clear = function() {
                    clearInterval(interval);
                    callback && callback()
                };
                if (len != $("body").html().length || e > 1000) {
                    clear()
                }
            }, 1)
    };
    myrequire(['js/tip']);
    myrequire(['js/table']);
    myrequire(['js/biz']);
    if ($('form.form-validate').length > 0 || $('form.form-modal').length > 0) {
		myrequire(['js/form'], function(form) {
			form.init()
		})
	}
    if ($('.multi-img-details').length > 0) {
    	myrequire(['jquery.ui'],function(){
		    $('.multi-img-details').sortable({scroll:'false'});
		    $('.multi-img-details').sortable('option', 'scroll', false);
		})
    }
	if($('form').hasClass('layui-form')){
		myrequire(['layui'],function(){
			layui.use(['form','laydate'], function(){
				form = layui.form();
			});
		});
	}
	if ($('.scrollLoading').length > 0) {
		myrequire(['scrollLoading'], function() {
			$(".scrollLoading").scrollLoading();
			var $pop = null;
			$('.scrollLoading').hover(function(){
				var img = $(this).attr('src');
				var obj = this;
				var $pop = util.popover(obj, function($popover, obj){
					obj.$popover = $popover;
				}, '<div><img src="'+img+'" style="max-width:200px; max-height:200px;"></div>');
			}, function(){
				this.$popover.remove();
			});
		})
	}
	if ($('.select2').length > 0) {
		myrequire(['select2'], function() {
			$(".select2").each(function() {
				$(this).select2({}), $(this).hasClass("js-select2") && $(this).change(function() {
					$(this).parents("form").submit()
				})
			})
		})
	}
	if ($('.js-switch').length > 0) {
		myrequire(['switchery'], function() {
			$('.js-switch').switchery()
		})
	}
	if ($('.js-clip').length > 0) {
		require(['jquery.zclip'], function() {
			$('.js-clip').each(function() {
				var text = $(this).data('text') || $(this).data('href') || $(this).data('url');
				$(this).zclip({
					path: './resource/components/zclip/ZeroClipboard.swf',
					copy: text,
					afterCopy: function() {
						tip.msgbox.suc('复制成功')
					}
				});
				this.clip = true
			})
		})
	}
	if ($(".form-editor-group").length > 0) {
		$(".form-editor-group .form-editor-btn").click(function() {
			var editor = $(this).closest(".form-editor-group");
			editor.find(".form-editor-show").hide();
			editor.find(".form-editor-edit").css('display', 'table')
		});
		$(".form-editor-group .form-editor-finish").click(function() {
			if ($(this).closest(".form-group").hasClass("has-error")) {
				return
			}
			var editor = $(this).closest(".form-editor-group");
			editor.find(".form-editor-show").show();
			editor.find(".form-editor-edit").hide();
			var input = editor.find(".form-editor-input");
			var value = $.trim(input.val());
			editor.find(".form-editor-text").text(value)
		})
	}
	$(".js-daterange").length > 0 && ($(document).on("click", ".js-daterange .js-btn-custom", function() {
		$(this).siblings().removeClass("btn-primary").addClass("btn-default"), $(this).addClass("btn-primary"), $(this).parent().next(".js-btn-daterange").removeClass("hide"), $(this).parents("form").find(':hidden[name="days"]').val(-1)
	}), require(["daterangepicker"], function() {
		$(".js-daterange").each(function() {
			var a = $(this).data("form");
			$(this).find(".daterange").on("apply.daterangepicker", function(b, c) {
				$(a).submit()
			})
		})
	}));
	$('[data-toggle="popover"]').popover();
    $(document).on("click", '[data-toggle="ajaxModal"]', function(e) {
        e.preventDefault();
        var obj = $(this),
            confirm = obj.data("confirm");
        var handler = function() {
                $("#ajaxModal").remove(), e.preventDefault();
                var url = obj.data("href") || obj.attr("href"),
                    data = obj.data("set"),
                    modal;
                $.ajax(url, {
                    type: "get",
                    dataType: "html",
                    cache: false,
                    data: data
                }).done(function(html) {
                    if (html.substr(0, 8) == '{"status') {
                        json = eval("(" + html + ')');
                        if (json.status == 0) {
                            msg = typeof(json.result) == 'object' ? json.result.message : json.result;
                            tip.msgbox.err(msg || tip.lang.err);
                            return
                        }
                    }
                    modal = $('<div class="modal fade" id="ajaxModal"><div class="modal-body "></div></div>');
                    $(document.body).append(modal), modal.modal('show');
                    myrequire(['js/jquery.gcjs'], function() {
                        modal.append2(html, function() {
                            var form_validate = $('form.form-validate', modal);
                            if (form_validate.length > 0) {
                                $("button[type='submit']", modal).length && $("button[type='submit']", modal).attr("disabled", true);
                                myrequire(['js/form'], function(form) {
                                    form.init();
                                    $("button[type='submit']", modal).length && $("button[type='submit']", modal).removeAttr("disabled")
                                })
                            }
                        })
                    })
                })
            },
            a;
        if (confirm) {
            tip.confirm(confirm, handler)
        } else {
            handler()
        }
    }), $(document).on("click", '[data-toggle="ajaxPost"]', function(e) {
        e.preventDefault();
        var obj = $(this),
            confirm = obj.data("confirm"),
            url = obj.data('href') || obj.attr('href'),
            data = obj.data('set') || {},
            html = obj.html();
        handler = function() {
            e.preventDefault();
            if (obj.attr('submitting') == '1') {
                return
            }
            obj.html('<i class="fa fa-spinner fa-spin"></i>').attr('submitting', 1);
            $.post(url, {
                data: data
            }, function(ret) {
                ret = eval("(" + ret + ")");
                if (ret.status == 1) {
                    tip.msgbox.suc(ret.result.message || tip.lang.success, ret.result.url)
                } else {
                    tip.msgbox.err(ret.result.message || tip.lang.error, ret.result.url), obj.removeAttr('submitting').html(html)
                }
            }).fail(function() {
                obj.removeAttr('submitting').html(html), tip.msgbox.err(tip.lang.exception)
            })
        };
        confirm && tip.confirm(confirm, handler);
        !confirm && handler()
    }), $(document).on("click", '[data-toggle="ajaxEdit"]', function(e) {
		var obj = $(this),
			url = obj.data('href') || obj.attr('href'),
			data = obj.data('set') || {},
			html = $.trim(obj.text()),
			required = obj.data('required') || true,
			edit = obj.data('edit') || 'input',
			executionMethod = obj.data('function');
		var oldval = $.trim($(this).text());
		e.preventDefault();
		submit = function() {
			e.preventDefault();
			var val = $.trim(input.val());
			if (required) {
				if (val == '') {
					tip.msgbox.err(tip.lang.empty);
					return
				}
			}
			if (val == html) {
				input.remove(), obj.html(val).show();
				return
			}
			if (url) {
				$.post(url, {
					value: val
				}, function(ret) {
					ret = eval("(" + ret + ")");
					if (ret.status == 1) {
						if(ret.result.data){
							obj.html(ret.result.data).show();
						}else{
							obj.html(val).show();
						}
						tip.msgbox.suc(ret.result.message);
					} else {
						tip.msgbox.err(ret.result.message, ret.result.url)
						if(ret.result.data){
							obj.html(ret.result.data).show();
						}
					}
					input.remove()
				}).fail(function() {
					input.remove(), tip.msgbox.err(tip.lang.exception)
				})
			} else {
				input.remove();
				obj.html(val).show()
			}
			obj.trigger('valueChange', [val, oldval])
		}, obj.hide().html('<i class="fa fa-spinner fa-spin"></i>');
		var input = $('<input type="text" class="form-control input-sm" style="width: 80%;display: inline;" />');
		if (edit == 'textarea') {
			input = $('<textarea type="text" class="form-control" style="resize:none" rows=3 ></textarea>')
		}
		obj.after(input);
		input.val(html).select().blur(function() {
			submit(input);
		}).keypress(function(e) {
			if (e.which == 13) {
				submit(input)
			}
		})
	}), $(document).on("click", '[data-toggle="ajaxSwitch"]', function(e) {
        e.preventDefault();
        var obj = $(this),
            confirm = obj.data('msg') || obj.data('confirm'),
            othercss = obj.data('switch-css'),
            other = obj.data('switch-other'),
            refresh = obj.data('switch-refresh') || false;
        if (obj.attr('submitting') == '1') {
            return
        }
        var value = obj.data('switch-value'),
            value0 = obj.data('switch-value0'),
            value1 = obj.data('switch-value1');
        if (value === undefined || value0 === undefined || value1 === undefined) {
            return
        }
        var url, css, text, newvalue, newurl, newcss, newtext;
        value0 = value0.split('|');
        value1 = value1.split('|');
        if (value == value0[0]) {
            url = value0[3], css = value0[2], text = value0[1], newvalue = value1[0], newtext = value1[1], newcss = value1[2]
        } else {
            url = value1[3], css = value1[2], text = value1[1], newvalue = value0[0], newtext = value0[1], newcss = value0[2]
        }
        var html = obj.html();
        var submit = function() {
                $.post(url).done(function(data) {
                    data = eval("(" + data + ")");
                    if (data.status == 1) {
                        if (other && othercss) {
                            if (newvalue == '1') {
                                $(othercss).each(function() {
                                    if ($(this).data('switch-value') == newvalue) {
                                        this.className = css;
                                        $(this).data('switch-value', value).html(text || html)
                                    }
                                })
                            }
                        }
                        obj.data('switch-value', newvalue);
                        obj.html(newtext || html);
                        obj[0].className = newcss;
                        refresh && location.reload()
                    } else {
                        obj.html(html), tip.msgbox.err(data.result.message || tip.lang.error, data.result.url)
                    }
                    obj.removeAttr('submitting')
                }).fail(function() {
                    obj.removeAttr('submitting');
                    obj.button('reset');
                    tip.msgbox.err(tip.lang.exception)
                })
            },
            a;
        if (confirm) {
            tip.confirm(confirm, function() {
                obj.html('<i class="fa fa-spinner fa-spin"></i>').attr('submitting', 1), submit()
            })
        } else {
            obj.html('<i class="fa fa-spinner fa-spin"></i>').attr('submitting', 1), submit()
        }
    }), $(document).on('click', '[data-toggle="selectUrl"]', function() {
		$("#selectUrl").remove();
		var _input = $(this).data('input');
		var _full = $(this).data('full');
		var _platform = $(this).data('platform');
		var _callback = $(this).data('callback') || false;
		var _cbfunction = !_callback ? false : eval("(" + _callback + ")");
		if (!_input && !_callback) {
			return
		}
		var merch = $(".diy-phone").data("merch");
		var url = biz.url('utility/select/comurl', null, merch);
		var store = $(".diy-phone").data("store");
		if (store) {
			url = biz.url('store/diypage/selecturl')
		}
		if (_full) {
			url = url + "&full=1"
		}
		if (_platform) {
			url = url + "&platform=" + _platform
		}
        //在装修页面要判断是添加小程序页面 还是添加公众号页面 获取对应链接地址 (默认获取公众号地址)
		var pageClass = $(".app-content").attr("pageClass")?$(".app-content").attr("pageClass"):1;//默认为公众号地址
        if(pageClass == 2){
            //获取小程序地址
            url = biz.url('utility/select/getWeChatUrl')
        }
		$.ajax(url, {
			type: "get",
            data:{pageClass:pageClass},
			dataType: "html",
			cache: false
		}).done(function(html) {
			modal = $('<div class="modal fade" id="selectUrl"></div>');
			$(document.body).append(modal), modal.modal('show');
			modal.append2(html, function() {
				$(document).off("click", '#selectUrl nav').on("click", '#selectUrl nav', function() {
					var _href = $.trim($(this).data("href"));
					var _type = $.trim($(this).data("type"));
					var _page_path = $.trim($(this).data("page_path"));
					if (_input) {
						$(_input).attr("data-types",_type);
                        $(_input).attr("data-page_path",_page_path);
						$(_input).val(_href).trigger('change');
					} else if (_cbfunction) {
						_cbfunction(_href)
					}
					modal.find(".close").click()
				})
			})
		})
	}),$(document).on('click', '[data-toggle="selectImg"]', function() {
		var _input = $(this).data('input');
		var _img = $(this).data('img');
		var _full = $(this).data('full');
		var dest_dir = $('.diy-phone').length > 0 ? $('.diy-phone').data('merch') : '';
		var options = {};
		if (dest_dir) {
			options.dest_dir = 'merch/' + dest_dir
		}
		require(['jquery', 'util'], function($, util) {
			util.image('', function(data) {
				var imgurl = data.attachment;
				if (_full) {
					imgurl = data.url
				}
				if (_input) {
					$(_input).val(imgurl).trigger('change')
				}
				if (_img) {
					$(_img).attr('src', data.url)
				}
			}, options)
		})
	}),$(document).on('click', '[data-toggle="selectIcon"]', function() {
		var _input = $(this).data('input');
		var _element = $(this).data('element');
		if (!_input && !_element) {
			return
		}
		var merch = $(".diy-phone").data("merch");
		var url = biz.url('utility/select/comicon', null, merch);
		$.ajax(url, {
			type: "get",
			dataType: "html",
			cache: false
		}).done(function(html) {
			modal = $('<div class="modal fade" id="selectIcon"></div>');
			$(document.body).append(modal), modal.modal('show');
			modal.append2(html, function() {
				$(document).off("click", '#selectIcon nav').on("click", '#selectIcon nav', function() {
					var _class = $.trim($(this).data("class"));
					if (_input) {
						$(_input).val(_class).trigger('change')
					}
					if (_element) {
						$(_element).removeAttr("class").addClass("icon " + _class)
					}
					modal.find(".close").click()
				})
			})
		})
	}),$(document).on('click', '[data-toggle="selectGoods"]', function() {
		var the = $(this);
		var page = $(this).attr("page");
		page = page ? page : 1;
		var url = biz.url('utility/select/getWholeGoods',{page:page},'');
		$.ajax(url, {
			type: "get",
			dataType: "html",
			cache: false
		}).done(function(html) {
			modal = $('<div class="modal fade" id="selectGoods">'+html+'</div>');
			modal.modal('show');
			//选择商品
			$(document).on('click','.determineSelectGoods',function () {
				var id = $(this).attr("id"),
					name = $(this).attr("name"),
					plugin = $(this).attr("plugin"),
					sid = $(this).attr("sid"),
				    record = localStorage.getItem("selectGoodsId");
				if(record != id){
					//将商品的id，name，类型赋值到表单中
					the.closest(".input-group").find(".selectGoods_name").val(name);
					the.closest(".input-group").find(".selectGoods_id").val(id);
					the.closest(".input-group").find(".selectGoods_plugin").val(plugin);
					the.closest(".input-group").find(".selectGoods_sid").val(sid);
					localStorage.setItem('selectGoodsId',id);
				}
				modal.find(".close").click();
			});
		})
	});
	$('#page-loading').remove();
});