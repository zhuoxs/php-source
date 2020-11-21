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

	require(['../new/jquery.slimscroll.min']);

	require(['../new/nav']);

	require(['layer']);//提示插件

	require(['jquery.gcjs']);//各种数据类型判断

	require(['tip']);//各种提示

	require(['web.form'], function(form) {//表单验证

		form.init()

	});

	require(['../diypage/biz']);

	require(['table']);//表格的批量操作

	if ($('.select2').length > 0) {

		require(['select2'], function() {

			$('.select2').each(function() {

				$(this).select2({})

			})

		})

	}

	if ($('.js-switch').length > 0) {

		require(['switchery'], function() {

			$('.js-switch').switchery()

		})

	}

	if ($('.js-clip').length > 0) {

		require(['jquery.zclip'], function() {

			$('.js-clip').each(function() {

				var text = $(this).data('text') || $(this).data('href') || $(this).data('url');

				$(this).zclip({

					path: ASSETS_PATH+'resource/components/zclip/ZeroClipboard.swf',

					copy: text,

					afterCopy: function() {

						tip.msgbox.suc('复制成功')

					}

				});

				this.clip = true

			})

		})

	}

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

					require(['jquery.gcjs'], function() {

						modal.append2(html, function() {

							var form_validate = $('form.form-validate', modal);

							if (form_validate.length > 0) {

								$("button[type='submit']", modal).length && $("button[type='submit']", modal).attr("disabled", true);

								require(['web.form'], function(form) {

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

			edit = obj.data('edit') || 'input';

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

					if (ret.type == 'success') {

						obj.html(val).show(),tip.msgbox.suc('修改成功')

					} else {

						tip.msgbox.err(ret.message, ret.redirect)

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

			submit(input)

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

			effectcss = obj.data('effect-css'),

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

						if(effectcss){

							if(data.result.returndata==1){

								obj.parent().parent().find("div ."+effectcss).css('display','block');

							}else{

								obj.parent().parent().find("div ."+effectcss).css('display','none');

							}

							

						}

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

	});

	$(document).on('click', '[data-toggle="selectUrl"]', function() {

		$("#selectUrl").remove();

		var _input = $(this).data('input');

		var _callback = $(this).data('callback') || false;

		var _cbfunction = !_callback ? false : eval("(" + _callback + ")");

		var _linktype = $(this).data("linktype");

		var tplid_only = $("#tplid_only").val();

		if (!_input && !_callback) {

			return

		}

		var url = biz.url('site/entry/Diy','op=make&opt=selecturl&m=sudu8_page');

		// var app = $(".diy-phone").data("app");

		// if (app == 'company') {

		// 	var siteid = $(".diy-phone").data("siteid");

		// 	url = biz.url('utility/select/comurl',{siteid:siteid});

		// } else if (app == 'menu') {

		// 	url = biz.url('utility/select/menuurl');

		// }

		$.ajax(url, {

			type: "get",

			dataType: "html",

			cache: false,
			data:{
				tplid_only:tplid_only //模板id
			}

		}).done(function(html) {

			modal = $('<div class="modal fade" id="selectUrl"></div>');

			$(document.body).append(modal), modal.modal('show');

			modal.append2(html, function() {

				$(document).off("click", '#selectUrl nav').on("click", '#selectUrl nav', function() {

					var _href = $.trim($(this).data("href")); //获取链接的地址

					var _type = $.trim($(this).data("linktype")); //设置链接的类型

					if (_input) {

						$(_input).val(_href).trigger('change')

					} else if (_cbfunction) {

						_cbfunction(_href)

					}

					if(_linktype){

						$(_linktype).val(_type).trigger('change');

					}

					modal.find(".close").click()

				})

			})

		})

	});

	$(document).on('click', '[data-toggle="selectImg"]', function() {

		var _input = $(this).data('input');

		var _img = $(this).data('img');

		var _full = $(this).data('full');

		require(['jquery', "util"], function($, util) {

			/*修改图片选择方式，以及加载方式*/

			util.image('', function(data) {

				var imgurl = data.attachment;

				if (_full) {

					imgurl = data.url

				}

				if (_input) {

					$(_input).val(data.url).trigger('change')

				}

				if (_img) {

					$(_img).attr('src', data.url)

				}

			})

		})

	});

	$(document).on('click', '[data-toggle="selectIcon"]', function() {

		var _input = $(this).data('input');

		var _element = $(this).data('element');

		if (!_input && !_element) {

			return

		}

		var merch = $(".diy-phone").data("merch");

		var url = biz.url('site/entry/Diy', 'op=make&opt=selecticon&m=sudu8_page', merch);

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

						$(_element).removeAttr("class").addClass("iconfont  " + _class)

					}

					modal.find(".close").click()

				})

			})

		})

	});

	$(document).on('click', '[data-toggle="getSappQrcode"]', function() {

		var obj = $(this);

		var _path = obj.data('path');

		var _scene = obj.data('scene');

		var _name = obj.data('name');

		if (!_path || !_name) {

			return

		}

		var url = biz.url('utility/sappqrcode',{path:_path,name:_name,scene:_scene});

		$.post(url).done(function(data) {

			data = eval("(" + data + ")");

			if (data.status == 1) {

				var chtml = "<img src='" + data.result.message + "' width='300' class='margin-20'>";

				layer.open({type: 1,title: '小程序二维码',shadeClose: true,shade: 0.8,area: ['340px', '382px'],content: chtml});

			} else {

				tip.msgbox.err(data.result.message || tip.lang.error, data.result.url)

			}

		}).fail(function() {

			tip.msgbox.err(tip.lang.exception)

		})

	});

	$(document).on('click', '[data-toggle="selectAudio"]', function() {

		var _input = $(this).data('input');

		var _full = $(this).data('full');

		require(['jquery', 'util'], function($, util) {

			util.audio('', function(data) {

				var audiourl = data.attachment;

				if (_full) {

					audiourl = data.url

				}

				if (_input) {

					$(_input).val(audiourl).trigger('change')

				}

			})

		})

	});

	$(document).on('click', '[data-toggle="selectVideo"]', function() {

		var _input = $(this).data('input');

		var _full = $(this).data('full');

		require(['jquery', 'util'], function($, util) {

			util.audio('', function(data) {

				var audiourl = data.attachment;

				if (_full) {

					audiourl = data.url

				}

				if (_input) {

					$(_input).val(audiourl).trigger('change')

				}

			}, {

				type: 'video'

			})

		})

	});

	$(document).on('click', '[data-toggle="previewVideo"]', function() {

		var videoelm = $(this).data('input');

		if (!videoelm) {

			return

		}

		var video = $(videoelm).data('url');

		if (!video || video == '') {

			tip.msgbox.err('未选择视频');

			return

		}

		if ($('#previewVideo').length < 1) {

			$('body').append('<div class="modal fade" id="previewVideo"><div class="modal-dialog" style="min-width: 400px !important;"><div class="modal-content"><div class="modal-header"><button data-dismiss="modal" class="close" type="button">×</button><h4 class="modal-title">视频预览</h4></div><div class="modal-body" style="padding: 0; background: #000;"><video src="' + video + '" style="height: 450px; width: 100%; display: block;" controls="controls"></video></div></div></div></div>')

		} else {

			$("#previewVideo video").attr("src", video)

		}

		$("#previewVideo").modal();

		$("#previewVideo").on("hidden.bs.modal", function() {

			$(this).find("video")[0].pause()

		})

	});



	/*选择系统链接资源*/

	$(document).on('click','[data-toggle="selectSource"]',function () {

		var _type = $(this).data("source");

		var _input = $(this).data("input");



        var url = biz.url('site/entry/Diy','op=make&opt=selectsource&m=sudu8_page&type='+_type);

        $.ajax(url, {

            type: "get",

            dataType: "html",

            cache: false

        }).done(function(html) {

            modal = $('<div class="modal fade" id="selectUrl_url"></div>');

            $(document.body).append(modal), modal.modal('show');

            modal.append2(html, function() {

                $(document).off("click", '#selectUrl_url nav').on("click", '#selectUrl_url nav', function() {

                    var _href = $.trim($(this).data("href")); //获取链接的地址

                    $(_input).val(_href).trigger('change')

                    modal.find(".close").click()

                })

            })

        })

    });

});