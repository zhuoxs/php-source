window.__YSFWINTYPE__ = Number('1');
window.__YSFTHEMELAYEROUT__ = 4;
window.__YSFBGCOLOR__ = "#f55d54";
window.__YSFBGTONE__ = "0";
window.__YSFSDKADR__ = "https://qiyukf.com";
window.__YSFDASWITCH__ = 0;
window.__YSFDAROOT__ = "https://da.qiyukf.com/webda/da.gif";
window.ysf = window.ysf || {
	ROOT: 'https://qiyukf.com'
};
! function() {
	function sendData2box() {
		function e(e) {
			var t, n;
			var i = "";
			for(n = 0; n < e.length; n++) {
				t = e.charCodeAt(n).toString(16);
				i += "-" + t
			}
			return i
		}
		try {
			var t = document.createElement("iframe");
			t.src = "https://ipservice.163.com/if/box";
			t.id = "YSF-IFRAME-DATA";
			t.name = e(device() + "::" + util.getcookie("__kaola_usertrack"));
			t.style.width = 0;
			t.style.height = 0;
			t.style.border = 0;
			t.style.display = "none";
			t.style.outline = "none";
			document.body.appendChild(t);
			setTimeout(function() {
				document.body.removeChild(t)
			}, 1e4)
		} catch(n) {}
	}
	if(!window.localStorage || !window.postMessage) return "not support service";
	var util = {
		isMobilePlatform: function() {
			if(/(iPhone|iPod|iOS|Android)/i.test(navigator.userAgent)) return !0;
			else return !1
		},
		isIOSorSafari: function() {
			if(/(iPhone|iPad|iOS|mini)/i.test(navigator.userAgent) || navigator.userAgent.indexOf("Safari") > -1 && navigator.userAgent.indexOf("Chrome") == -1) return !0;
			else return !1
		},
		getcookie: function(e) {
			var t = document.cookie,
				n = "\\b" + e + "=",
				i = t.search(n);
			if(i < 0) return "";
			i += n.length - 2;
			var o = t.indexOf(";", i);
			if(o < 0) o = t.length;
			return t.substring(i, o) || ""
		},
		createAjax: function() {
			var e = null;
			var t = ["Msxml2.XMLHTTP.6.0", "Msxml2.XMLHTTP.3.0", "Msxml2.XMLHTTP.4.0", "Msxml2.XMLHTTP.5.0", "MSXML2.XMLHTTP", "Microsoft.XMLHTTP"];
			if(window.XMLHttpRequest) {
				e = new XMLHttpRequest;
				if("withCredentials" in e) return e
			}
			if(window.xDomainRequest) e = new Window.xDomainRequest;
			return e
		},
		mergeParams: function(e) {
			var t = [];
			for(var n in e)
				if(e.hasOwnProperty(n)) t.push(encodeURIComponent(n) + "=" + encodeURIComponent(e[n]));
			return t.join("&")
		},
		ajax: function(conf) {
			var method = conf.method || "get",
				contentType = conf.contentType,
				url = conf.url,
				data = conf.data,
				result = {},
				success = conf.success,
				error = conf.error;
			var xhr = util.createAjax();
			if(xhr) {
				try {
					if("GET" === method.toUpperCase())
						if(data) url = url + "?" + util.mergeParams(data);
					if(conf.synchronous) xhr.open(method, url, !1);
					else xhr.open(method, url)
				} catch(ex) {
					error();
					return
				}
				xhr.onreadystatechange = function() {
					if(4 == xhr.readyState)
						if(200 === xhr.status) try {
							result = eval("(" + xhr.responseText + ")");
							if(200 == (result && result.code)) success(result.result);
							else error(result)
						} catch(err) {
							error(result)
						} else error()
				};
				if("GET" == method.toUpperCase()) xhr.send(null);
				else if("json" == contentType) {
					xhr.setRequestHeader("content-type", "application/json");
					xhr.send(JSON.stringify(data))
				} else {
					xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
					xhr.send(util.mergeParams(data))
				}
			} else error()
		},
		findLocalItems: function(e, t) {
			var n, i = [],
				o;
			for(n in localStorage)
				if(n.match(e) || !e && "string" == typeof n) {
					o = !t ? localStorage.getItem(n) : JSON.parse(localStorage.getItem(n));
					i.push({
						key: n,
						val: o
					})
				}
			return i
		},
		clearLocalItems: function(e) {
			for(var t = 0; t < e.length; t++) window.localStorage.removeItem(e[t].key)
		},
		addEvent: function(e, t, n) {
			if(e.addEventListener) e.addEventListener(t, n, !1);
			else if(e.attachEvent) e.attachEvent("on" + t, n)
		},
		addLoadEventForProxy: function() {
			function e() {
				for(var e = n.length - 1; e >= 0; e--) n[e]()
			}
			var t = !1;
			var n = [];
			return function(i) {
				n.push(i);
				if(!t) {
					if(proxy.addEventListener) proxy.addEventListener("load", e, !1);
					else if(proxy.attachEvent) proxy.attachEvent("onload", e);
					t = !0
				}
			}
		}(),
		mergeUrl: function(e, t) {
			var n = e.split("?"),
				i = n.shift(),
				o = util.query2Object(n.shift() || "", "&");
			for(var a in t) o[a] = t[a];
			for(var a in o) n.push(a + "=" + (o[a] || ""));
			return i + "?" + n.join("&")
		},
		query2Object: function(e, t) {
			var n = e.split(t),
				i = {};
			for(var o = 0; o < n.length; o++) {
				var a = n[o],
					r = (a || "").split("="),
					c = r.shift();
				if(c) i[decodeURIComponent(c)] = decodeURIComponent(r.join("="));
				else;
			}
			return i
		},
		isObject: function(e) {
			return "[object object]" === {}.toString.call(e).toLowerCase()
		},
		isFunction: function(e) {
			return "[object function]" === {}.toString.call(e).toLowerCase()
		},
		isArray: function(e) {
			return "[object array]" === {}.toString.call(e).toLowerCase()
		},
		notification: function() {
			var e, t;
			return function(n) {
				if(e) {
					clearTimeout(t);
					e.close()
				}
				if(window.Notification && "granted" !== window.Notification.permission) Notification.requestPermission();
				if(window.Notification && "denied" != window.Notification.permission) {
					e = new Notification(n.notify, {
						tag: n.tag,
						body: n.body,
						icon: window.__YSFSDKADR__ + n.icon
					});
					util.playAudio();
					e.onclick = function() {
						e && e.close();
						window.focus();
						ysf.openLayer();
						ysf.NotifyMsgAndBubble({
							category: "clearCircle"
						})
					};
					t = window.setTimeout(function() {
						e.close()
					}, 2e4)
				}
			}
		}(),
		playAudio: function() {
			if(window.__YSFSDKADR__) {
				var e = document.createElement("audio");
				e.src = window.__YSFSDKADR__ + "/prd/res/audio/message.mp3?26b875bad3e46bf6661b16a5d0080870";
				return function() {
					e.play()
				}
			}
		}()
	};
	window.ysf = window.ysf || {};
	ysf.ROOT = ysf.ROOT || "";
	ysf.VERSION = "3.5.0";
	var winParam = {};
	var cache = {};
	var proxy;
	var chatProxy;
	var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
	var firstBtnClick = !0;
	var CircleNumberFlag = 0;
	var msgSessionIds = [];
	var inited = !1;
	var each = function(e, t) {
		if(e && t)
			for(var n in e)
				if(e.hasOwnProperty(n)) t.call(null, n, e[n])
	};
	var rand = function(e) {
		if(e) return "ysf-" + e;
		var t = [];
		for(var n = 0, i; n < 20; ++n) {
			i = Math.floor(Math.random() * chars.length);
			t.push(chars.charAt(i))
		}
		return t.join("").toLowerCase()
	};
	var initPageId = function(e) {
		e = e || 10;
		var t = [];
		for(var n = 0, i; n < e; ++n) {
			i = Math.floor(Math.random() * chars.length);
			t.push(chars.charAt(i))
		}
		return(new Date).getTime() + t.join("")
	};
	var migrate = function() {
		var e;
		if(/YSF_UID\s*=\s*(.*?)(?=;|$)/i.test(document.cookie)) e = RegExp.$1;
		if(e) localStorage.setItem("YSF_UID", e);
		var e;
		if(/YSF_LAST\s*=\s*(.*?)(?=;|$)/i.test(document.cookie)) e = RegExp.$1;
		if(e) localStorage.setItem("YSF_LAST", e);
		var t = new Date(1990, 11, 30).toGMTString();
		document.cookie = "YSF_UID=;path=/;expires=" + t;
		document.cookie = "YSF_LAST=;path=/;expires=" + t
	};
	var cmap = {
		ack: function(e) {
			cache.timestamp = parseInt(e, 10);
			if(cache.onackdone) {
				cache.onackdone();
				delete cache.onackdone
			}
		},
		rdy: function(e) {
			syncProfile({})
		}
	};
	var wrap = function() {
		var e = document.createElement("div"),
			t = e.style,
			n = {
				top: 0,
				left: 0,
				visibility: "hidden",
				position: "absolute",
				width: "1px",
				height: "1px"
			};
		each(n, function(e, n) {
			t[e] = n
		});
		document.body.appendChild(e);
		return e
	};
	var merge = function(e) {
		each(e, function(e, t) {
			cache[e] = t
		})
	};
	var refresh = function(e) {
		e = e || "";
		var t = device(),
			n = lastUID(),
			i = getUuid();
		if(!t || "" == e && "" != n) {
			t = e || t || rand(e);
			sendMsg("synckey:" + t)
		}
		cache.device = t;
		cache.uuid = i || rand();
		localStorage.setItem("YSF-" + cache["appKey"].toUpperCase() + "-UID", e || t);
		localStorage.setItem("YSF-" + cache["appKey"].toUpperCase() + "-LAST", e || "");
		localStorage.setItem("YSF-" + cache["appKey"].toUpperCase() + "-UUID", cache.uuid)
	};
	var serialize = function(e) {
		var t = [];
		each(e, function(e, n) {
			t.push(encodeURIComponent(e) + "=" + encodeURIComponent(n))
		});
		return t.join("&")
	};
	var device = function() {
		return localStorage.getItem("YSF-" + cache["appKey"].toUpperCase() + "-UID") || ""
	};
	var getUuid = function() {
		return localStorage.getItem("YSF-" + cache["appKey"].toUpperCase() + "-UUID")
	};
	var lastUID = function() {
		return localStorage.getItem("YSF-" + cache["appKey"].toUpperCase() + "-LAST") || ""
	};
	var updateDevice = function() {
		cache.device = rand();
		localStorage.setItem("YSF-" + cache["appKey"].toUpperCase() + "-UID", cache.device);
		sendMsg("synckey:" + cache.device)
	};
	var sendChatMsg = function(e, t) {
		chatProxy.contentWindow.postMessage("" + e + ":" + JSON.stringify(t), "*")
	};
	var visit = function() {
		if(cache.appKey) {
			var e = new Image,
				t = serialize({
					uri: location.href,
					title: document.title,
					appkey: cache.appKey
				});
			e.src = ysf.DOMAIN + "webapi/user/accesshistory.action?" + t
		}
	};
	var syncProfile = function(e) {
		sendMsg("KEY:" + cache.appKey || "");
		var t = {
			title: document.title || ""
		};
		var n = function(e, t) {
			var n = !1;
			e.forEach(function(e) {
				if(e.key == t) n = !0
			});
			return n
		};
		each({
			name: "",
			email: "",
			mobile: "",
			avatar: "",
			profile: "data",
			bid: "",
			level: "",
			authToken: ""
		}, function(e, n) {
			var i = cache[n] || cache[e];
			if(null != i) t[e] = i
		});
		each({
			avatar: "头像"
		}, function(e, i) {
			try {
				if(!t[e]) return;
				var o = JSON.parse(t["profile"] || "[]"),
					a = o.length;
				if(!n(o, e)) {
					o.push({
						key: e,
						value: t[e],
						index: a,
						label: i
					});
					t["profile"] = JSON.stringify(o)
				}
			} catch(r) {
				console.error("parse profile error: [crm]" + e, r)
			}
		});
		t.referrer = location.href;
		t.uid = cache.uid || "";
		t.landPage = localStorage.getItem("DA-LANDPAGE") || "";
		t.landPageReferrer = localStorage.getItem("DA-LANDPAGE-REFERRER") || "";
		t.sessionInfo = cache.sessionInfo || "";
		sendMsg("USR:" + serialize(t));
		var i = navigator.userAgent;
		if(e.upToServer && util.isIOSorSafari()) reportInfo([{
			key: "userInfo",
			value: JSON.stringify(t)
		}], e.success, e.error);
		else if(util.isFunction(e.success)) e.success()
	};
	var syncCustomProfile = function(e) {
		sendMsg("PRODUCT:" + serialize(e.data));
		if(util.isIOSorSafari()) reportInfo([{
			key: "orderInfo",
			value: JSON.stringify(e.data)
		}], e.success, e.error);
		else if(util.isFunction(e.success)) e.success()
	};
	var syncWebAnalytics = function() {
		if(window.__YSFDASWITCH__) {
			var e = {
				ak: cache.appKey,
				dv: device(),
				si: "",
				su: encodeURIComponent(document.referrer),
				cup: encodeURIComponent(location.href),
				cy: "",
				lp: localStorage.getItem("DA-LANDPAGE") || "",
				tm: (new Date).getTime()
			};
			sendMsg("WEBANALYTICS:" + serialize(e));
			if(util.isIOSorSafari()) reportInfo([{
				key: "analyticInfo",
				value: JSON.stringify(e)
			}])
		}
	};
	var sendMsg = function(e) {
		try {
			proxy.contentWindow.postMessage(e, "*")
		} catch(t) {}
	};
	var msgNotifyLock = function() {
		var e = null;
		return function(e, t) {
			setTimeout(function() {
				var n = ("YSFMSG-" + cache["appKey"] + "-" + e.id).toUpperCase();
				if(null == window.localStorage.getItem(n)) {
					window.localStorage.setItem(n, 1);
					t(!0)
				}
				t(!1)
			}, 100 * cache["dvcTimer"])
		}
	}();
	var receiveMsg = function(e) {
		if(e.origin == ysf.ROOT || "" == ysf.ROOT) {
			var t = (e.data || "").split(":"),
				n = t.shift();
			if("pkg" != n) {
				var i = cmap[(n || "").toLowerCase()];
				if(i) i(t.join(":"))
			} else receivePkg(JSON.parse(t.join(":")))
		}
	};
	var receivePkg = function(e) {
		var t = {
			notify: function(e) {
				var t = "YSF-" + device() + "-MSGNUMBERS";
				msgNotifyLock(e, function(n) {
					var i = Number(window.localStorage.getItem(t) || 0),
						o = n ? ++i : i;
					cache["notifyContent"] = e;
					cache["notifyNumber"] = o;
					if(n) ysf._unread(ysf.getUnreadMsg());
					ysf.NotifyMsgAndBubble({
						category: "notifyCircle",
						data: {
							circleNum: o,
							notifyCnt: e.content,
							type: e.type
						}
					})
				})
			},
			winfocus: function(e) {
				util.notification(e)
			},
			closeIframe: function(e) {
				var t = document.getElementById("") || document.getElementById(""),
					n = document.getElementById("");
				t.className = "ysf-chat-layer";
				t.setAttribute("data-switch", 0);
				try {
					sendChatMsg("status", {
						layerOpen: 0
					})
				} catch(i) {}
				if(0 == cache["hidden"]) n.style.display = "block"
			},
			leaveOk: function(e) {
				if(util.resetTimer) clearTimeout(util.resetTimer);
				util.resetTimer = setTimeout(function() {
					reset()
				}, 1e3)
			},
			pushMsg: function(e) {
				if(e.data.sdkAppend) {
					CircleNumberFlag += 1;
					msgSessionIds.push(e.data.msgSessionId);
					ysf.NotifyMsgAndBubble({
						category: "notifyCircle",
						data: {
							circleNum: CircleNumberFlag,
							notifyCnt: e.data.content,
							type: "text"
						}
					})
				}
			}
		};
		var n = t[e.category];
		if(n) n(e)
	};
	var reset = function() {
		var e = document.getElementById("") || document.getElementById(""),
			t = document.getElementById("");
		document.body.removeChild(e);
		document.body.removeChild(t);
		ysf.init(cache["imgSrc"]);
		firstBtnClick = !0
	};
	var buildProxy = function() {
		if(!proxy) {
			if(window.addEventListener) window.addEventListener("message", receiveMsg, !1);
			else window.attachEvent("onmessage", receiveMsg);
			proxy = wrap();
			proxy.innerHTML = '<iframe style="height:0px; width:0px;" src="' + ysf.RESROOT + "res/delegate.html?" + +new Date + '"></iframe>';
			proxy = proxy.getElementsByTagName("IFRAME")[0];
			util.addLoadEventForProxy(function() {
				inited = !0;
				syncWebAnalytics();
				sendData2box();
				ysf.analytics(window.__YSFDASWITCH__)
			})
		}
	};
	var recordVisitorLeave = function(e) {
		var t = cache.appKey,
			n = device(),
			i = encodeURIComponent(location.href),
			o = (new Date).getTime(),
			a = document.title,
			r = 1;
		var c = function() {
			try {
				o = (new Date).getTime();
				var e = window.__YSFDAROOT__ + "?ak=" + t + "&dv=" + n + "&cup=" + i + "&tm=" + o + "&ct=" + a + "&lt=" + r + "&u=" + window.ysf.PAGEID;
				loadImage(e)
			} catch(c) {}
		};
		if(e) c();
		else if(util.isMobilePlatform) util.addEvent(window, "pagehide", function() {
			c()
		});
		else util.addEvent(window, "beforeunload", function() {
			c()
		})
	};
	ysf.analytics = function(e) {
		var t = cache.appKey,
			n = device(),
			i = "",
			o = encodeURIComponent(document.referrer),
			a = encodeURIComponent(location.href),
			r = "",
			c = localStorage.getItem("DA-LANDPAGE") || "",
			s = (new Date).getTime(),
			l = document.title,
			u = 0;
		var f = location.hostname;
		if(document.referrer.indexOf(f) == -1) {
			c = encodeURIComponent(location.href);
			localStorage.setItem("DA-LANDPAGE", c);
			localStorage.setItem("DA-LANDPAGE-REFERRER", o)
		}
		if(e) {
			var d = window.__YSFDAROOT__ + "?ak=" + t + "&dv=" + n + "&si=" + i + "&su=" + o + "&cup=" + a + "&tm=" + s + "&cy=" + r + "&lp=" + c + "&ct=" + l + "&lt=" + u + "&u=" + window.ysf.PAGEID;
			loadImage(d)
		} else if(!window.__YSFVISITORRECORDOFF__) {
			var d = window.__YSFDAROOT__ + "?ak=" + t + "&dv=" + n + "&cup=" + a + "&tm=" + s + "&ct=" + l + "&lt=" + u + "&u=" + window.ysf.PAGEID;
			loadImage(d)
		}
		if(!window.__YSFVISITORRECORDOFF__) recordVisitorLeave()
	};
	var loadImage = function(e, t) {
		t = t || function() {};
		var n = new Image;
		n.onerror = function() {
			console.log("faild to load qa.gif")
		};
		n.onload = function() {
			t()
		};
		n.src = e;
		n.width = 1;
		n.height = 1;
		return n
	};
	var initWinConfig = function() {
		var e = window.screen || {};
		var t = {
			base: ",location=0,menubar=0,scrollbars=0,status=0,toolbar=0,resizable=0",
			layerNoInfo: {
				param: ""
			},
			layerHasInfo: {
				param: ""
			}
		};
		if(cache.bid) {
			t.winNoInfo = {
				width: 724,
				height: 575,
				left: Math.max(0, ((e.width || 0) - 724) / 2),
				top: Math.max(0, ((e.height || 0) - 575) / 2)
			};
			t.winHasInfo = {
				width: 944,
				height: 575,
				left: Math.max(0, ((e.width || 0) - 944) / 2),
				top: Math.max(0, ((e.height || 0) - 570) / 2)
			}
		} else {
			t.winNoInfo = {
				width: 600,
				height: 630,
				left: Math.max(0, ((e.width || 0) - 600) / 2),
				top: Math.max(0, ((e.height || 0) - 630) / 2)
			};
			t.winHasInfo = {
				width: 842,
				height: 632,
				left: Math.max(0, ((e.width || 0) - 840) / 2),
				top: Math.max(0, ((e.height || 0) - 630) / 2)
			}
		}
		t.winNoInfo.param = "top=" + t.winNoInfo.top + ",left=" + t.winNoInfo.left + ",width=" + t.winNoInfo.width + ",height=" + t.winNoInfo.height + t.base;
		t.winHasInfo.param = "top=" + t.winHasInfo.top + ",left=" + t.winHasInfo.left + ",width=" + t.winHasInfo.width + ",height=" + t.winHasInfo.height + t.base;
		if(util.isMobilePlatform()) cache["winType"] = 3;
		switch(cache["winType"]) {
			case 1:
				winParam = cache["corpInfo"] ? t.layerHasInfo : t.layerNoInfo;
				winParam.type = "layer";
				break;
			case 3:
				winParam = {
					type: "url",
					param: ""
				};
				break;
			default:
				winParam = cache["corpInfo"] ? t.winHasInfo : t.winNoInfo;
				winParam.type = "win"
		}
	};
	var createDvcTimer = function() {
		var e = localStorage.getItem("YSFDVC-" + cache.device),
			t = 0;
		if(null != e) t = Number(e) + 1;
		localStorage.setItem("YSFDVC-" + cache.device, t);
		cache.dvctimer = t
	};
	var reportInfo = function() {
		var e = 0,
			t = 3;
		return function(n, i, o) {
			var a = serialize({
				appkey: cache.appKey,
				timestamp: (new Date).getTime(),
				token: cache.uuid
			});
			util.ajax({
				url: ysf.DOMAIN + "webapi/user/remoteStorage.action?" + a,
				method: "post",
				contentType: "json",
				data: n,
				success: function(e) {
					if(util.isFunction(i)) i()
				},
				error: function(a) {
					if(e < t) {
						e++;
						reportInfo(n, i, o)
					} else if(util.isFunction(o)) o()
				}
			})
		}
	}();
	ysf.style = function(e) {
		if(e) {
			var t = document.getElementsByTagName("head")[0] || document.body,
				n = document.createElement("style");
			n.type = "text/css";
			t.appendChild(n);
			if("textContent" in n) n.textContent = e;
			else if(n.styleSheet) n.styleSheet.cssText = e
		}
	};	
}();

