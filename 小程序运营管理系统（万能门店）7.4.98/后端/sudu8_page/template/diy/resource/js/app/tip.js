define(function(require, exports, module) {
	var tip = {};
	tip.lang = {
		"success": "操作成功",
		"error": "操作失败",
		"exception": "网络异常",
		"processing": "处理中..."
	};
	if ($("div.msgbox", top.window.document).length == 0) {
		$("body", top.window.document).append('<div class="msgbox"></div>')
	}
	window.msgbox = $("div.msgbox", top.window.document);
	tip.confirm = function(msg, callback, cancel_callback) {
		require(['jquery.confirm'], function() {
			$.confirm({
				title: '提示',
				content: msg,
				confirmButtonClass: 'btn-primary',
				cancelButtonClass: 'btn-default',
				confirmButton: '确 定',
				cancelButton: '取 消',
				animation: 'top',
				confirm: function() {
					if (callback && typeof(callback) == 'function') {
						callback()
					}
				},
				cancel: function() {
					if (cancel_callback && typeof(cancel_callback) == 'function') {
						cancel_callback()
					}
				}
			})
		})
	}, tip.alert = function(msg, callback) {
		require(['jquery.confirm'], function() {
			$.alert({
				title: '提示',
				content: msg,
				confirmButtonClass: 'btn-primary',
				confirmButton: '确 定',
				animation: 'top',
				confirm: function() {
					if (callback && typeof(callback) == 'function') {
						callback()
					}
				}
			})
		})
	}, 1;
	var Notify = function(element, options) {
			this.$element = $(element);
			this.$note = $('<span class="msg"></span>');
			this.options = $.extend({}, $.fn.notify.defaults, options);
			this.$note.addClass(this.options.type ? "msg-" + this.options.type : "msg-success");
			if (this.options.message) {
				this.$note.html(this.options.message)
			}
			return this
		};
	Notify.prototype.show = function() {
		this.$element.addClass('in'), this.$element.append(this.$note);
		var autoClose = this.options.autoClose || true;
		if (autoClose) {
			var self = this;
			setTimeout(function() {
				self.close()
			}, this.options.delay || 2000)
		}
	}, Notify.prototype.close = function() {
		var self = this;
		self.$element.removeClass('in').transitionEnd(function() {
			self.$element.empty();
			if (self.options.onClosed) {
				self.options.onClosed(self)
			}
		});
		if (self.options.onClose) {
			self.options.onClose(self)
		}
	}, $.fn.notify = function(options) {
		return new Notify(this, options)
	}, $.fn.notify.defaults = {
		type: "success",
		delay: 3000,
		message: ''
	}, tip.msgbox = {
		show: function(options) {
			if (options.url) {
				options.url = options.url.replace(/&amp;/ig, "&");
				options.onClose = function() {
					redirect(options.url)
				}
			}
			if (options.message && options.message.length > 17) {
				tip.alert(options.message, function() {
					if (options.url) {
						redirect(options.url)
					}
				});
				return
			}
			notify = window.msgbox.notify(options), notify.show()
		},
		suc: function(msg, url, onClose, onClosed) {
			tip.msgbox.show({
				delay: 2000,
				type: "success",
				message: msg,
				url: url,
				onClose: onClose,
				onClosed: onClosed
			})
		},
		err: function(msg, url, onClose, onClosed) {
			tip.msgbox.show({
				delay: 4000,
				type: "error",
				message: msg,
				url: url,
				onClose: onClose,
				onClosed: onClosed
			})
		}
	};
	window.tip = tip
});