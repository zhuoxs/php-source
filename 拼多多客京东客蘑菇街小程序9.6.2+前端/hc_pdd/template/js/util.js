! function(window) {
	function getQuery(e) {
		i = "";
		if(-1 != e.indexOf("?")) var i = e.split("?")[1];
		return i
	}
	var util = {};
	util.tips = function(msg, speed) {
		speed || (speed = 1500);
		var modalobj = $("#tips-container");
		0 == modalobj.length && ($(document.body).append('<div id="tips-container" class="text-center"><span></span></div>'), modalobj = $("#tips-container"));
		var reg = /^\".*\"$/;
		msg = reg.test(msg) ? eval(msg) : util.decode(msg), modalobj.hide().find("span").html(msg), $("#tips-container").fadeIn(), $("#tips-container").fadeOut(speed)
	}, util.serialize = function(a) {
		var b = a.serializeArray(),
			c = {};
		for (i in b) {
			var d = b[i];
			c[d.name] = d.value
		}
		return c
	},util.decode = function(a) {
		return unescape(a.replace(/\\(u[0-9a-fA-F]{4})/gm, "%$1"))
	},
	util.iconBrowser = function(e) {
		require(["fontawesome"], function() {
			var i = util.dialog("请选择图标", window.util.templates["fontawesome-content.tpl"], '<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>', {
				containerName: "icon-container"
			});
			i.modal({
				keyboard: !1
			}), i.find(".modal-dialog").css({
				width: "70%"
			}), i.find(".modal-body").css({
				height: "70%",
				"overflow-y": "scroll"
			}), i.modal("show"), window.selectIconComplete = function(t) {
				$.isFunction(e) && (e(t), i.modal("hide"))
			}
		})
	}, util.emojiBrowser = function(e) {
		require(["emoji"], function() {
			var i = util.dialog("请选择表情", window.util.templates["emoji-content-emoji.tpl"], '<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>', {
				containerName: "icon-container"
			});
			i.modal({
				keyboard: !1
			}), i.find(".modal-dialog").css({
				width: "70%"
			}), i.find(".modal-body").css({
				height: "70%",
				"overflow-y": "scroll"
			}), i.modal("show"), window.selectEmojiComplete = function(t) {
				$.isFunction(e) && (e(t), i.modal("hide"))
			}
		})
	}, util.qqEmojiBrowser = function(e, i, t) {
		require(["emoji"], function() {
			var o = window.util.templates["emoji-content-qq.tpl"];
			$(e).popover({
				html: !0,
				content: o,
				placement: "bottom"
			}), $(e).one("shown.bs.popover", function() {
				$(e).next().mouseleave(function() {
					$(e).popover("hide")
				}), $(e).next().delegate(".eItem", "mouseover", function() {
					var i = '<img src="' + $(this).attr("data-gifurl") + '" alt="mo-' + $(this).attr("data-title") + '" />';
					$(this).attr("data-code");
					$(e).next().find(".emotionsGif").html(i)
				}), $(e).next().delegate(".eItem", "click", function() {
					var o = "/" + $(this).attr("data-code");
					$(e).popover("hide"), $.isFunction(t) && t(o, e, i)
				})
			})
		})
	}, util.emotion = function(e, i, t) {
		util.qqEmojiBrowser(e, i, t)
	}, util.linkBrowser = function(e) {
		var i = util.dialog("请选择链接", ["./index.php?c=utility&a=link&callback=selectLinkComplete"], '<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>', {
			containerName: "link-container"
		});
		i.modal({
			keyboard: !1
		}), i.find(".modal-body").css({
			height: "300px",
			"overflow-y": "auto"
		}), i.modal("show"), window.selectLinkComplete = function(t) {
			$.isFunction(e) && (e(t), i.modal("hide"))
		}
	}, util.pageBrowser = function(e, i) {
		var t = util.dialog("", ["./index.php?c=utility&a=link&do=page&callback=pageLinkComplete&page=" + i], "", {
			containerName: "link-container"
		});
		t.modal({
			keyboard: !1
		}), t.find(".modal-body").css({
			height: "700px",
			"overflow-y": "auto"
		}), t.modal("show"), window.pageLinkComplete = function(i, o) {
			$.isFunction(e) && (e(i, o), "" != o && void 0 != o || t.modal("hide"))
		}
	}, util.newsBrowser = function(e, i) {
		var t = util.dialog("", ["./index.php?c=utility&a=link&do=news&callback=newsLinkComplete&page=" + i], "", {
			containerName: "link-container"
		});
		t.modal({
			keyboard: !1
		}), t.find(".modal-body").css({
			height: "700px",
			"overflow-y": "auto"
		}), t.modal("show"), window.newsLinkComplete = function(i, o) {
			$.isFunction(e) && (e(i, o), "" != o && void 0 != o || t.modal("hide"))
		}
	}, util.articleBrowser = function(e, i) {
		var t = util.dialog("", ["./index.php?c=utility&a=link&do=article&callback=articleLinkComplete&page=" + i], "", {
			containerName: "link-container"
		});
		t.modal({
			keyboard: !1
		}), t.find(".modal-body").css({
			height: "700px",
			"overflow-y": "auto"
		}), t.modal("show"), window.articleLinkComplete = function(i, o) {
			$.isFunction(e) && (e(i, o), "" != o && void 0 != o || t.modal("hide"))
		}
	}, util.phoneBrowser = function(e, i) {
		var t = util.dialog("一键拨号", ["./index.php?c=utility&a=link&do=phone&callback=phoneLinkComplete&page=" + i], "", {
			containerName: "link-container"
		});
		t.modal({
			keyboard: !1
		}), t.find(".modal-body").css({
			height: "700px",
			"overflow-y": "auto"
		}), t.modal("show"), window.phoneLinkComplete = function(i, o) {
			$.isFunction(e) && (e(i, o), "" != o && void 0 != o || t.modal("hide"))
		}
	}, util.showModuleLink = function(e) {
		var i = util.dialog("模块链接选择", ["./index.php?c=utility&a=link&do=modulelink&callback=moduleLinkComplete"], "");
		i.modal({
			keyboard: !1
		}), i.find(".modal-body").css({
			height: "700px",
			"overflow-y": "auto"
		}), i.modal("show"), window.moduleLinkComplete = function(t, o) {
			$.isFunction(e) && (e(t, o), i.modal("hide"))
		}
	}, util.colorpicker = function(e, i) {
		require(["colorpicker"], function() {
			$(e).spectrum({
				className: "colorpicker",
				showInput: !0,
				showInitial: !0,
				showPalette: !0,
				maxPaletteSize: 10,
				preferredFormat: "hex",
				change: function(e) {
					$.isFunction(i) && i(e)
				},
				palette: [
					["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)", "rgb(153, 153, 153)", "rgb(183, 183, 183)", "rgb(204, 204, 204)", "rgb(217, 217, 217)", "rgb(239, 239, 239)", "rgb(243, 243, 243)", "rgb(255, 255, 255)"],
					["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)", "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"],
					["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)", "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)", "rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)", "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)", "rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)", "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)", "rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)", "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)", "rgb(133, 32, 12)", "rgb(153, 0, 0)", "rgb(180, 95, 6)", "rgb(191, 144, 0)", "rgb(56, 118, 29)", "rgb(19, 79, 92)", "rgb(17, 85, 204)", "rgb(11, 83, 148)", "rgb(53, 28, 117)", "rgb(116, 27, 71)", "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)", "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
				]
			})
		})
	}, util.tomedia = function(e, i) {
		if(0 == e.indexOf("http://") || 0 == e.indexOf("https://") || 0 == e.indexOf("./resource")) return e;
		if(0 == e.indexOf("./addons")) {
			var t = window.document.location.href,
				o = window.document.location.pathname,
				n = t.indexOf(o),
				a = t.substring(0, n);
			return "." == e.substr(0, 1) && (e = e.substr(1)), a + e
		}
		return i ? window.sysinfo.attachurl_local + e : window.sysinfo.attachurl + e
	}, util.clip = function(e, i) {
		require(["clipboard"], function(t) {
			var o = new t(e, {
				text: function() {
					return i
				}
			});
			o.on("success", function(e) {
				util.message("复制成功", "", "success"), e.clearSelection()
			}), o.on("error", function(e) {
				util.message("复制失败，请重试", "", "error")
			})
		})
	}, util.uploadMultiPictures = function(e, t) {
		var o = {
			type: "image",
			tabs: {
				upload: "active",
				browser: "",
				crawler: ""
			},
			path: "",
			direct: !1,
			multiple: !0,
			dest_dir: ""
		};
		o = $.extend({}, o, t), require(["fileUploader"], function(t) {
			t.show(function(t) {
				if(t.length > 0) {
					for(i in t) t[i].filename = t[i].attachment;
					$.isFunction(e) && e(t)
				}
			}, o)
		})
	}, util.editor = function(e, t) {
		if(!e && "" != e) return "";
		var o = "string" == typeof e ? e : e.id;
		o || (o = "editor-" + Math.random(), e.id = o);
		var n = {
			height: "200",
			dest_dir: "",
			image_limit: "1024",
			allow_upload_video: 1,
			audio_limit: "1024",
			callback: null
		};
		$.isFunction(t) && (t = {
			callback: t
		}), t = $.extend({}, n, t), window.UEDITOR_HOME_URL = window.sysinfo.siteroot + "web/resource/components/ueditor/";
		var a = function(n, a) {
			var r = {
					autoClearinitialContent: !1,
					toolbars: [
						["fullscreen", "source", "preview", "|", "bold", "italic", "underline", "strikethrough", "forecolor", "backcolor", "|", "justifyleft", "justifycenter", "justifyright", "|", "insertorderedlist", "insertunorderedlist", "blockquote", "emotion", "link", "removeformat", "|", "rowspacingtop", "rowspacingbottom", "lineheight", "indent", "paragraph", "fontfamily", "fontsize", "|", "inserttable", "deletetable", "insertparagraphbeforetable", "insertrow", "deleterow", "insertcol", "deletecol", "mergecells", "mergeright", "mergedown", "splittocells", "splittorows", "splittocols", "|", "anchor", "map", "print", "drafts"]
					],
					elementPathEnabled: !1,
					catchRemoteImageEnable: !1,
					initialFrameHeight: t.height,
					focus: !1,
					maximumWords: 9999999999999
				},
				l = {
					type: "image",
					direct: !1,
					multiple: !0,
					tabs: {
						upload: "active",
						browser: "",
						crawler: ""
					},
					path: "",
					dest_dir: t.dest_dir,
					global: !1,
					thumb: !1,
					width: 0,
					fileSizeLimit: 1024 * t.image_limit
				};
			if(n.registerUI("myinsertimage", function(e, t) {
					e.registerCommand(t, {
						execCommand: function() {
							a.show(function(t) {
								if(0 != t.length)
									if(1 == t.length) e.execCommand("insertimage", {
										src: t[0].url,
										_src: t[0].attachment,
										width: "100%",
										alt: t[0].filename
									});
									else {
										var o = [];
										for(i in t) o.push({
											src: t[i].url,
											_src: t[i].attachment,
											width: "100%",
											alt: t[i].filename
										});
										e.execCommand("insertimage", o)
									}
							}, l)
						}
					});
					var o = new n.ui.Button({
						name: "插入图片",
						title: "插入图片",
						cssRules: "background-position: -726px -77px",
						onclick: function() {
							e.execCommand(t)
						}
					});
					return e.addListener("selectionchange", function() {
						var i = e.queryCommandState(t); - 1 == i ? (o.setDisabled(!0), o.setChecked(!1)) : (o.setDisabled(!1), o.setChecked(i))
					}), o
				}, 19), n.registerUI("myinsertvideo", function(e, i) {
					e.registerCommand(i, {
						execCommand: function() {
							a.show(function(i) {
								if(i) {
									var t = i.isRemote ? "iframe" : "video";
									e.execCommand("insertvideo", {
										url: i.url,
										width: 300,
										height: 200
									}, t)
								}
							}, {
								fileSizeLimit: 1024 * t.audio_limit,
								type: "video",
								allowUploadVideo: t.allow_upload_video
							})
						}
					});
					var o = new n.ui.Button({
						name: "插入视频",
						title: "插入视频",
						cssRules: "background-position: -320px -20px",
						onclick: function() {
							e.execCommand(i)
						}
					});
					return e.addListener("selectionchange", function() {
						var t = e.queryCommandState(i); - 1 == t ? (o.setDisabled(!0), o.setChecked(!1)) : (o.setDisabled(!1), o.setChecked(t))
					}), o
				}, 20), o) {
				var d = n.getEditor(o, r);
				$("#" + o).removeClass("form-control"), $("#" + o).data("editor", d), $("#" + o).parents("form").submit(function() {
					d.queryCommandState("source") && d.execCommand("source")
				}), $.isFunction(t.callback) && t.callback(e, d)
			}
		};
		require(["ueditor", "fileUploader"], function(e, i) {
			a(e, i)
		}, function(e) {
			var i = e.requireModules && e.requireModules[0];
			"ueditor" === i && (requirejs.undef(i), requirejs.config({
				paths: {
					ueditor: "../../components/ueditor/ueditor.all.min"
				},
				shim: {
					ueditor: {
						deps: ["./resource/components/ueditor/third-party/zeroclipboard/ZeroClipboard.min.js", "./resource/components/ueditor/ueditor.config.js"],
						exports: "UE",
						init: function(e) {
							window.ZeroClipboard = e
						}
					}
				}
			}), require(["ueditor", "fileUploader"], function(e, i) {
				a(e, i)
			}))
		})
	}, util.loading = function(e) {
		e || (e = "正在努力加载...");
		var i = $("#modal-loading");
		return 0 == i.length ? ($(document.body).append('<div id="modal-loading" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"></div>'), i = $("#modal-loading"), html = '<div class="modal-dialog">\t<div style="text-align:center; background-color: transparent;">\t\t<img style="width:48px; height:48px; margin-top:100px;" src="../attachment/images/global/loading.gif" title="正在努力加载...">\t\t<div>' + e + "</div>\t</div></div>", i.html(html), i.modal("show"), i.next().css("z-index", 999999)) : i.modal("show"), i
	}, util.loaded = function() {
		var e = $("#modal-loading");
		e.length > 0 && (e.modal("hide"), e.hide())
	}, util.dialog = function(e, i, t, o) {
		o || (o = {}), o.containerName || (o.containerName = "modal-message");
		var n = $("#" + o.containerName);
		if(0 == n.length && ($(document.body).append('<div id="' + o.containerName + '" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"></div>'), n = $("#" + o.containerName)), html = '<div class="modal-dialog we7-modal-dialog">\t<div class="modal-content">', e && (html += '<div class="modal-header">\t<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>\t<h3>' + e + "</h3></div>"), i && ($.isArray(i) ? html += '<div class="modal-body">正在加载中</div>' : html += '<div class="modal-body">' + i + "</div>"), t && (html += '<div class="modal-footer">' + t + "</div>"), html += "\t</div></div>", n.html(html), i && $.isArray(i)) {
			var a = function(e) {
				n.find(".modal-body").html(e)
			};
			2 == i.length ? $.post(i[0], i[1]).success(a) : $.get(i[0]).success(a)
		}
		return n
	}, util.message = function(e, i, t) {
		i || t || (t = "info"), -1 == $.inArray(t, ["success", "error", "info", "warning"]) && (t = ""), "" == t && (t = "" == i ? "error" : "success");
		var o = {
			success: "right-sign",
			error: "error-sign",
			danger: "error-sign",
			info: "info-sign",
			warning: "warning-sign"
		};
		if(i && i.length > 0) {
			if("success" == t) {
				var n = new Object;
				return n.type = t, n.msg = e, util.cookie.set("message", JSON.stringify(n), 600), "back" == i ? window.history.back(-1) : "refresh" == i ? (i = location.href, window.location.href = i) : window.location.href = i
			}
			"back" == i ? i = "javascript:history.back(-1)" : "refresh" == i && (i = location.href);
			a = "\t\t\t<a href=" + i + ' class="btn btn-primary">确认</a>'
		} else var a = '\t\t\t<button type="button" class="btn btn-primary" data-dismiss="modal">确认</button>';
		var r = '\t\t\t<div class="text-center">\t\t\t\t<p>\t\t\t\t\t<i class="text-' + t + " wi wi-" + o[t] + '"></i>' + e + '\t\t\t\t</p>\t\t\t</div>\t\t\t<div class="clearfix"></div>',
			l = util.dialog("系统提示", r, a, {
				containerName: "modal-message"
			});
		return i && i.length > 0 && "success" != t && l.on("hidden.bs.modal", function() {
			return window.location.href = i
		}), l.on("hidden.bs.modal", function() {
			$("body").css("padding-right", 0)
		}), l.modal("show"), l
	}, util.cookie_message = function(time) {
		var message = util.cookie.get("message");
		if(message) {
			var del = util.cookie.del("message");
			message = eval("(" + message + ")");
			var msg = message.msg;
			msg = decodeURIComponent(msg), util.modal_message(message.title, msg, message.redirect, message.type, time)
		}
	}, util.modal_message = function(e, i, t, o, n) {
		function a() {
			setTimeout(function() {
				u.modal("hide")
			}, 1e3 * n)
		}
		if(!t || getQuery(t) == getQuery(window.location.href)) {
			var r = {
					success: "right-sign",
					error: "error-sign",
					danger: "error-sign",
					info: "info-sign",
					warning: "warning-sign"
				},
				l = !1,
				d = "";
			o || (o = "info"), -1 == $.inArray(o, ["success", "error", "info", "warning", "danger"]) && (o = ""), "" == o && (o = "success"), -1 != $.inArray(o, ["success"]) && (l = !0, n = n || 3);
			var s = '\t\t\t<div class="text-center">\t\t\t\t\t<i class="text-' + o + " wi wi-" + r[o] + '"></i>' + i + '\t\t\t</div>\t\t\t<div class="clearfix"></div>';
			l || (t = t || "./?refresh", e = e || "系统提示", d = '\t\t<a href="' + t + '" class="btn btn-primary">确认</a>');
			var c = Math.floor(1e4 * Math.random()),
				u = util.dialog(e, s, d, {
					containerName: "modal-message-" + c
				});
			return l ? (u.modal({
				backdrop: !1
			}), u.addClass("modal-" + o), u.on("show.bs.modal", function() {
				a()
			}), u.on("hidden.bs.modal", function() {
				u.remove()
			})) : u.on("hidden.bs.modal", function() {
				return window.location.href = t
			}), u.modal("show"), u
		}
	}, util.map = function(e, i) {
		require(["map"], function() {
			function t(e) {
				n.getPoint(e, function(e) {
					map.panTo(e), marker.setPosition(e), marker.setAnimation(BMAP_ANIMATION_BOUNCE), setTimeout(function() {
						marker.setAnimation(null)
					}, 3600)
				})
			}
			e || (e = {}), e.lng || (e.lng = 116.403851), e.lat || (e.lat = 39.915177);
			var o = new BMap.Point(e.lng, e.lat),
				n = new BMap.Geocoder,
				a = $("#map-dialog");
			if(0 == a.length) {
				(a = util.dialog("请选择地点", '<div class="form-group"><div class="input-group"><input type="text" class="form-control" placeholder="请输入地址来直接查找相关位置"><div class="input-group-btn"><button class="btn btn-default"><i class="icon-search"></i> 搜索</button></div></div></div><div id="map-container" style="height:400px;"></div>', '<button type="button" class="btn btn-default" data-dismiss="modal">取消</button><button type="button" class="btn btn-primary">确认</button>', {
					containerName: "map-dialog"
				})).find(".modal-dialog").css("width", "80%"), a.modal({
					keyboard: !1
				}), map = util.map.instance = new BMap.Map("map-container"), map.centerAndZoom(o, 12), map.enableScrollWheelZoom(), map.enableDragging(), map.enableContinuousZoom(), map.addControl(new BMap.NavigationControl), map.addControl(new BMap.OverviewMapControl), marker = util.map.marker = new BMap.Marker(o), marker.setLabel(new BMap.Label("请您移动此标记，选择您的坐标！", {
					offset: new BMap.Size(10, -20)
				})), map.addOverlay(marker), marker.enableDragging(), marker.addEventListener("dragend", function(e) {
					var i = marker.getPosition();
					n.getLocation(i, function(e) {
						a.find(".input-group :text").val(e.address)
					})
				}), a.find(".input-group :text").keydown(function(e) {
					13 == e.keyCode && t($(this).val())
				}), a.find(".input-group button").click(function() {
					t($(this).parent().prev().val())
				})
			}
			a.off("shown.bs.modal"), a.on("shown.bs.modal", function() {
				marker.setPosition(o), map.panTo(marker.getPosition())
			}), a.find("button.btn-primary").off("click"), a.find("button.btn-primary").on("click", function() {
				if($.isFunction(i)) {
					var e = util.map.marker.getPosition();
					n.getLocation(e, function(t) {
						var o = {
							lng: e.lng,
							lat: e.lat,
							label: t.address
						};
						i(o)
					})
				}
				a.modal("hide")
			}), a.modal("show")
		})
	}, util.image = function(e, i, t, o) {
		var n = {
			type: "image",
			direct: !1,
			multiple: !1,
			path: e,
			dest_dir: "",
			global: !1,
			thumb: !1,
			width: 0,
			needType: 2
		};
		!t && o && (t = o), (n = $.extend({}, n, t)).type = "image", require(["fileUploader"], function(e) {
			e.show(function(e) {
				e && $.isFunction(i) && i(e)
			}, n)
		})
	}, util.wechat_image = function(e, i, t) {
		var o = {
			type: "image",
			direct: !1,
			multiple: !1,
			acid: 0,
			path: e,
			dest_dir: "",
			isWechat: !0,
			needType: 1
		};
		o = $.extend({}, o, t), require(["fileUploader"], function(e) {
			e.show(function(e) {
				e && $.isFunction(i) && i(e)
			}, o)
		})
	}, util.audio = function(e, i, t, o) {
		var n = {
			type: "voice",
			direct: !1,
			multiple: !1,
			path: "",
			dest_dir: "",
			needType: 2
		};
		e && (n.path = e), !t && o && (t = o), n = $.extend({}, n, t), require(["fileUploader"], function(e) {
			e.show(function(e) {
				e && $.isFunction(i) && i(e)
			}, n)
		})
	}, util.wechat_audio = function(e, i, t) {
		var o = {
			type: "voice",
			direct: !1,
			multiple: !1,
			path: "",
			dest_dir: "",
			isWechat: !0,
			needType: 1
		};
		e && (o.path = e), o = $.extend({}, o, t), require(["fileUploader"], function(e) {
			e.show(function(e) {
				e && $.isFunction(i) && i(e)
			}, o)
		})
	}, util.ajaxshow = function(e, t, o, n) {
		var a = {
				show: !0
			},
			r = {},
			l = $.extend({}, a, o),
			d = ("function" == typeof(n = $.extend({}, r, n)).confirm ? '<a href="#" class="btn btn-primary confirm">确定</a>' : "") + '<a href="#" class="btn" data-dismiss="modal" aria-hidden="true">关闭</a><iframe id="_formtarget" style="display:none;" name="_formtarget"></iframe>',
			s = util.dialog(t || "系统信息", "正在加载中", d, {
				containerName: "modal-panel-ajax"
			});
		if("undeinfed" != typeof l.width && l.width > 0 && s.find(".modal-dialog").css({
				width: l.width
			}), n)
			for(i in n) "function" == typeof n[i] && s.on(i, n[i]);
		var c;
		return s.find(".modal-body").load(e, function(e) {
			try {
				c = $.parseJSON(e), s.find(".modal-body").html('<div class="modal-body"><i class="pull-left fa fa-4x ' + (c.message.errno ? "fa-info-circle" : "fa-check-circle") + '"></i><div class="pull-left"><p>' + c.message.message + '</p></div><div class="clearfix"></div></div>')
			} catch(i) {
				s.find(".modal-body").html(e)
			}
			$("form.ajaxfrom").each(function() {
				$(this).attr("action", $(this).attr("action") + "&isajax=1&target=formtarget"), $(this).attr("target", "_formtarget")
			})
		}), s.on("hidden.bs.modal", function() {
			if(c && c.redirect) return location.href = c.redirect, !1;
			s.remove()
		}), "function" == typeof n.confirm && s.find(".confirm", s).on("click", n.confirm), s.modal(l)
	}, util.cookie = {
		prefix: window.sysinfo ? window.sysinfo.cookie.pre : "",
		set: function(e, i, t) {
			expires = new Date, expires.setTime(expires.getTime() + 1e3 * t), document.cookie = this.name(e) + "=" + escape(i) + "; expires=" + expires.toGMTString() + "; path=/"
		},
		get: function(e) {
			for(cookie_name = this.name(e) + "=", cookie_length = document.cookie.length, cookie_begin = 0; cookie_begin < cookie_length;) {
				if(value_begin = cookie_begin + cookie_name.length, document.cookie.substring(cookie_begin, value_begin) == cookie_name) {
					var i = document.cookie.indexOf(";", value_begin);
					return -1 == i && (i = cookie_length), unescape(document.cookie.substring(value_begin, i))
				}
				if(cookie_begin = document.cookie.indexOf(" ", cookie_begin) + 1, 0 == cookie_begin) break
			}
			return null
		},
		del: function(e) {
			new Date;
			document.cookie = this.name(e) + "=; expires=Thu, 01-Jan-70 00:00:01 GMT; path=/"
		},
		name: function(e) {
			return this.prefix + e
		}
	}, util.coupon = function(e, i) {
		var t = {
			type: "all",
			multiple: !0
		};
		t = $.extend({}, t, i), require(["coupon"], function(i) {
			i.init(function(i) {
				i && $.isFunction(e) && e(i)
			}, t)
		})
	}, util.material = function(e, i) {
		var t = {
			type: "news",
			multiple: !1,
			ignore: {}
		};
		t = $.extend({}, t, i), require(["material"], function(i) {
			i.init(function(i) {
				i && $.isFunction(e) && e(i)
			}, t)
		})
	}, util.encrypt = function(e) {
		if("string" == typeof(e = $.trim(e)) && e.length > 3) {
			for(var i = /^./, t = i.exec(e), o = (i = /.$/).exec(e)[0], n = "", a = 0; a < e.length - 2; a++) n += "*";
			return e = t + n + o
		}
		return e
	}, util.toast = function(e, i, t) {
		util.modal_message(t, e, "", i, "")
	}, util.Guid = 1,
	util.guid = function() {
		return "random_name_" + util.Guid++
	},util.popover = function(a, b, c) {
		var d = "mall-popover-" + util.guid();
		if (c) {
			"object" != typeof c && (c = {
				html: c
			}), c = $.extend({
				placement: "left",
				html: "",
				bodyClick: "remove"
			}, c);
			var e = $(a),
				f = e.offset(),
				g = f.left,
				h = f.top,
				i = e.outerWidth(!0),
				j = e.outerHeight(!0),
				k = '<div class="mall-popover ' + c.placement + '" id="' + d + '">	<div class="arrow"></div>' + c.html + "</div>",
				l = $(k);
			l.click(function(a) {
				void 0 != a && (a.stopPropagation ? a.stopPropagation() : a.cancelBubble = !0)
			}), $.isFunction(b) && b(l, a), $("body").append(l), "remove" == c.bodyClick && $("body").one("click", function(a) {
				void 0 != a && (a.stopPropagation ? a.stopPropagation() : a.cancelBubble = !0), l.remove()
			});
			var m = l.outerWidth(!0),
				n = l.outerHeight(!0);
			return "top" == c.placement ? l.css({
				left: g - (m - i) / 2 + "px",
				top: h - n + "px"
			}) : "bottom" == c.placement ? l.css({
				left: g - (m - i) / 2 + "px",
				top: h + j + "px"
			}) : "right" == c.placement ? l.css({
				left: g + i + "px",
				top: h + j / 2 - n / 2 + "px"
			}) : l.css({
				left: g - m + "px",
				top: h + j / 2 - n / 2 + "px"
			}), l
		}
	}, util.nailConfirm = function(a, b, c) {
		$(".nail-confirm").remove(), "string" == typeof c && (c = {
			html: c
		}), c = $.extend({
			html: "确认删除?",
			placement: "left"
		}, c), c.html = "<span> " + c.html + ' </span> <a class="btn btn-primary confirm">确定</a> <a class="btn btn-default cancel">取消</a>', util.popover(a, function(a, c) {
			a.addClass("nail-confirm").find("a").one("click", function(d) {
				d.stopPropagation();
				var e = $(this).hasClass("confirm");
				$.isFunction(b) && b(e, a, c), a.hide().remove()
			})
		}, c)
	}, "function" == typeof define && define.amd ? define(function() {
		return util
	}) : window.util = util
}(window),
function(e, i) {
	e["util.map.content.html"] = '<div class="form-group"><div class="input-group"><input type="text" class="form-control" placeholder="请输入地址来直接查找相关位置"><div class="input-group-btn"><button class="btn btn-default"><i class="icon-search"></i> 搜索</button></div></div></div><div id="map-container" style="height:400px"></div>'
}(this.window.util.templates = this.window.util.templates || {});