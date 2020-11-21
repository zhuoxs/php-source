var _typeof2 = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
    return typeof e;
} : function(e) {
    return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e;
};

!function(e, t) {
    if ("object" === ("undefined" == typeof exports ? "undefined" : _typeof2(exports)) && "object" === ("undefined" == typeof module ? "undefined" : _typeof2(module))) module.exports = t(); else if ("function" == typeof define && define.amd) define([], t); else {
        var n = t();
        for (var o in n) ("object" === ("undefined" == typeof exports ? "undefined" : _typeof2(exports)) ? exports : e)[o] = n[o];
    }
}(void 0, function() {
    return function(n) {
        var o = {};
        function r(e) {
            if (o[e]) return o[e].exports;
            var t = o[e] = {
                i: e,
                l: !1,
                exports: {}
            };
            return n[e].call(t.exports, t, t.exports, r), t.l = !0, t.exports;
        }
        return r.m = n, r.c = o, r.i = function(e) {
            return e;
        }, r.d = function(e, t, n) {
            r.o(e, t) || Object.defineProperty(e, t, {
                configurable: !1,
                enumerable: !0,
                get: n
            });
        }, r.n = function(e) {
            var t = e && e.__esModule ? function() {
                return e.default;
            } : function() {
                return e;
            };
            return r.d(t, "a", t), t;
        }, r.o = function(e, t) {
            return Object.prototype.hasOwnProperty.call(e, t);
        }, r.p = "", r(r.s = 11);
    }([ function(e, t, n) {
        var o = "function" == typeof Symbol && "symbol" === _typeof2(Symbol.iterator) ? function(e) {
            return void 0 === e ? "undefined" : _typeof2(e);
        } : function(e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : void 0 === e ? "undefined" : _typeof2(e);
        };
        e.exports = {
            type: function(e) {
                return Object.prototype.toString.call(e).slice(8, -1).toLowerCase();
            },
            isObject: function(e, t) {
                return t ? "object" === this.type(e) : e && "object" === (void 0 === e ? "undefined" : o(e));
            },
            isFormData: function(e) {
                return "undefined" != typeof FormData && e instanceof FormData;
            },
            trim: function(e) {
                return e.replace(/(^\s*)|(\s*$)/g, "");
            },
            encode: function(e) {
                return encodeURIComponent(e).replace(/%40/gi, "@").replace(/%3A/gi, ":").replace(/%24/g, "$").replace(/%2C/gi, ",").replace(/%20/g, "+").replace(/%5B/gi, "[").replace(/%5D/gi, "]");
            },
            formatParams: function(e) {
                var i = "", a = !0, u = this;
                return function n(e, o) {
                    var t = u.encode, r = u.type(e);
                    if ("array" == r) e.forEach(function(e, t) {
                        n(e, o + "%5B%5D");
                    }); else if ("object" == r) for (var s in e) n(e[s], o ? o + "%5B" + t(s) + "%5D" : t(s)); else a || (i += "&"), 
                    a = !1, i += o + "=" + t(e);
                }(e, ""), i;
            },
            merge: function(e, t) {
                for (var n in t) e.hasOwnProperty(n) ? this.isObject(t[n], 1) && this.isObject(e[n], 1) && this.merge(e[n], t[n]) : e[n] = t[n];
                return e;
            }
        };
    }, function(e, t, n) {
        var d = "function" == typeof Symbol && "symbol" === _typeof2(Symbol.iterator) ? function(e) {
            return void 0 === e ? "undefined" : _typeof2(e);
        } : function(e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : void 0 === e ? "undefined" : _typeof2(e);
        }, o = function() {
            function o(e, t) {
                for (var n = 0; n < t.length; n++) {
                    var o = t[n];
                    o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), 
                    Object.defineProperty(e, o.key, o);
                }
            }
            return function(e, t, n) {
                return t && o(e.prototype, t), n && o(e, n), e;
            };
        }();
        var s = n(0), p = "undefined" != typeof document;
        e.exports = function(r) {
            return function() {
                function e() {
                    !function(e, t) {
                        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
                    }(this, e), this.requestHeaders = {}, this.readyState = 0, this.timeout = 0, this.responseURL = "", 
                    this.responseHeaders = {};
                }
                return o(e, [ {
                    key: "_call",
                    value: function(e) {
                        this[e] && this[e].apply(this, [].splice.call(arguments, 1));
                    }
                }, {
                    key: "_changeReadyState",
                    value: function(e) {
                        this.readyState = e, this._call("onreadystatechange");
                    }
                }, {
                    key: "open",
                    value: function(e, t) {
                        if (this.method = e, t) {
                            if (0 !== (t = s.trim(t)).indexOf("http") && p) {
                                var n = document.createElement("a");
                                n.href = t, t = n.href;
                            }
                        } else t = location.href;
                        this.responseURL = t, this._changeReadyState(1);
                    }
                }, {
                    key: "send",
                    value: function(e) {
                        var t = this;
                        if (e = e || null, p) {
                            var n = document.cookie;
                            n && (this.requestHeaders.cookie = n);
                        }
                        var f = this;
                        if (r) {
                            var l, o = {
                                method: f.method,
                                url: f.responseURL,
                                headers: f.requestHeaders || {},
                                body: e
                            };
                            s.merge(o, f._options || {}), "GET" === o.method && (o.body = null), f._changeReadyState(3), 
                            f.timeout = f.timeout || 0, 0 < f.timeout && (l = setTimeout(function() {
                                3 === f.readyState && (t._call("onloadend"), f._changeReadyState(0), f._call("ontimeout"));
                            }, f.timeout)), o.timeout = f.timeout, r(o, function(n) {
                                function e(e) {
                                    var t = n[e];
                                    return delete n[e], t;
                                }
                                if (3 === f.readyState) {
                                    clearTimeout(l), f.status = e("statusCode") - 0;
                                    var t = e("responseText"), o = e("statusMessage");
                                    if (f.status) {
                                        var r = e("headers"), s = {};
                                        for (var i in r) {
                                            var a = r[i], u = i.toLowerCase();
                                            "object" === (void 0 === a ? "undefined" : d(a)) ? s[u] = a : (s[u] = s[u] || [], 
                                            s[u].push(a));
                                        }
                                        var c = s["set-cookie"];
                                        p && c && c.forEach(function(e) {
                                            document.cookie = e.replace(/;\s*httpOnly/gi, "");
                                        }), f.responseHeaders = s, f.statusText = o || "", f.response = f.responseText = t, 
                                        f._response = n, f._changeReadyState(4), f._call("onload");
                                    } else f.statusText = t, f._call("onerror", {
                                        msg: o
                                    });
                                    f._call("onloadend");
                                }
                            });
                        } else console.error("Ajax require adapter");
                    }
                }, {
                    key: "setRequestHeader",
                    value: function(e, t) {
                        this.requestHeaders[s.trim(e)] = t;
                    }
                }, {
                    key: "getResponseHeader",
                    value: function(e) {
                        return (this.responseHeaders[e.toLowerCase()] || "").toString() || null;
                    }
                }, {
                    key: "getAllResponseHeaders",
                    value: function() {
                        var e = "";
                        for (var t in this.responseHeaders) e += t + ":" + this.getResponseHeader(t) + "\r\n";
                        return e || null;
                    }
                }, {
                    key: "abort",
                    value: function(e) {
                        this._changeReadyState(0), this._call("onerror", {
                            msg: e
                        }), this._call("onloadend");
                    }
                } ], [ {
                    key: "setAdapter",
                    value: function(e) {
                        r = e;
                    }
                } ]), e;
            }();
        };
    }, function(e, t, n) {
        var o = function() {
            function o(e, t) {
                for (var n = 0; n < t.length; n++) {
                    var o = t[n];
                    o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), 
                    Object.defineProperty(e, o.key, o);
                }
            }
            return function(e, t, n) {
                return t && o(e.prototype, t), n && o(e, n), e;
            };
        }();
        var x = n(0), _ = "undefined" != typeof document, r = function() {
            function r(e) {
                function t(e) {
                    var t;
                    x.merge(e, {
                        lock: function() {
                            t || (e.p = new Promise(function(e) {
                                t = e;
                            }));
                        },
                        unlock: function() {
                            t && (t(), e.p = t = null);
                        }
                    });
                }
                !function(e, t) {
                    if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
                }(this, r), this.engine = e || XMLHttpRequest;
                var n = (this.default = this).interceptors = {
                    response: {
                        use: function(e, t) {
                            this.handler = e, this.onerror = t;
                        }
                    },
                    request: {
                        use: function(e) {
                            this.handler = e;
                        }
                    }
                }, o = n.request;
                t(n.response), t(o), this.config = {
                    method: "GET",
                    baseURL: "",
                    headers: {},
                    timeout: 0,
                    parseJson: !0,
                    withCredentials: !1
                };
            }
            return o(r, [ {
                key: "request",
                value: function(y, m, n) {
                    var o = this, v = new this.engine(), b = "Content-Type", r = b.toLowerCase(), e = this.interceptors, s = e.request, g = e.response, i = s.handler, t = new Promise(function(l, d) {
                        function p(e) {
                            return e && e.then && e.catch;
                        }
                        function h(e, t) {
                            e ? e.then(function() {
                                t();
                            }) : t();
                        }
                        x.isObject(y) && (y = (n = y).url), (n = n || {}).headers = n.headers || {}, h(s.p, function() {
                            x.merge(n, o.config);
                            var e = n.headers;
                            e[b] = e[b] || e[r] || "", delete e[r], n.body = m || n.body, y = x.trim(y || ""), 
                            n.method = n.method.toUpperCase(), n.url = y;
                            var t = n;
                            i && (t = i.call(s, n, Promise) || n), p(t) || (t = Promise.resolve(t)), t.then(function(e) {
                                e === n ? function(a) {
                                    m = a.body, y = x.trim(a.url);
                                    var e = x.trim(a.baseURL || "");
                                    if (y || !_ || e || (y = location.href), 0 !== y.indexOf("http")) {
                                        var t = "/" === y[0];
                                        if (!e && _) {
                                            var n = location.pathname.split("/");
                                            n.pop(), e = location.protocol + "//" + location.host + (t ? "" : n.join("/"));
                                        }
                                        if ("/" !== e[e.length - 1] && (e += "/"), y = e + (t ? y.substr(1) : y), _) {
                                            var o = document.createElement("a");
                                            o.href = y, y = o.href;
                                        }
                                    }
                                    var r = x.trim(a.responseType || "");
                                    v.withCredentials = !!a.withCredentials;
                                    var s = "GET" === a.method;
                                    s && m && ("string" !== x.type(m) && (m = x.formatParams(m)), y += (-1 === y.indexOf("?") ? "?" : "&") + m), 
                                    v.open(a.method, y);
                                    try {
                                        v.timeout = a.timeout || 0, "stream" !== r && (v.responseType = r);
                                    } catch (e) {}
                                    for (var i in s || ("application/x-www-form-urlencoded" === a.headers[b].toLowerCase() ? m = x.formatParams(m) : x.isFormData(m) || -1 === [ "object", "array" ].indexOf(x.type(m)) || (a.headers[b] = "application/json;charset=utf-8", 
                                    m = JSON.stringify(m))), a.headers) if (i !== b || !x.isFormData(m) && m && !s) try {
                                        v.setRequestHeader(i, a.headers[i]);
                                    } catch (e) {} else delete a.headers[i];
                                    function u(t, n, o) {
                                        h(g.p, function() {
                                            if (t) {
                                                o && (n.request = a);
                                                var e = t.call(g, n, Promise);
                                                n = void 0 === e ? n : e;
                                            }
                                            p(n) || (n = Promise[0 === o ? "resolve" : "reject"](n)), n.then(function(e) {
                                                l(e);
                                            }).catch(function(e) {
                                                d(e);
                                            });
                                        });
                                    }
                                    function c(e) {
                                        e.engine = v, u(g.onerror, e, -1);
                                    }
                                    function f(e, t) {
                                        this.message = e, this.status = t;
                                    }
                                    v.onload = function() {
                                        var e = v.response || v.responseText;
                                        a.parseJson && -1 !== (v.getResponseHeader(b) || "").indexOf("json") && !x.isObject(e) && (e = JSON.parse(e));
                                        var n = {}, t = (v.getAllResponseHeaders() || "").split("\r\n");
                                        t.pop(), t.forEach(function(e) {
                                            var t = e.split(":")[0];
                                            n[t] = v.getResponseHeader(t);
                                        });
                                        var o = v.status, r = v.statusText, s = {
                                            data: e,
                                            headers: n,
                                            status: o,
                                            statusText: r
                                        };
                                        if (x.merge(s, v._response), 200 <= o && o < 300 || 304 === o) s.engine = v, s.request = a, 
                                        u(g.handler, s, 0); else {
                                            var i = new f(r, o);
                                            i.response = s, c(i);
                                        }
                                    }, v.onerror = function(e) {
                                        c(new f(e.msg || "Network Error", 0));
                                    }, v.ontimeout = function() {
                                        c(new f("timeout [ " + v.timeout + "ms ]", 1));
                                    }, v._options = a, setTimeout(function() {
                                        v.send(s ? null : m);
                                    }, 0);
                                }(e) : l(e);
                            }, function(e) {
                                d(e);
                            });
                        });
                    });
                    return t.engine = v, t;
                }
            }, {
                key: "all",
                value: function(e) {
                    return Promise.all(e);
                }
            }, {
                key: "spread",
                value: function(t) {
                    return function(e) {
                        return t.apply(null, e);
                    };
                }
            }, {
                key: "lock",
                value: function() {
                    this.interceptors.request.lock();
                }
            }, {
                key: "unlock",
                value: function() {
                    this.interceptors.request.unlock();
                }
            } ]), r;
        }();
        r.default = r, [ "get", "post", "put", "patch", "head", "delete" ].forEach(function(o) {
            r.prototype[o] = function(e, t, n) {
                return this.request(e, t, x.merge({
                    method: o
                }, n));
            };
        }), e.exports = r;
    }, , , , function(e, t, n) {
        e.exports = function(e, t) {
            var n = {
                method: e.method,
                url: e.url,
                dataType: e.dataType || void 0,
                header: e.headers,
                data: e.body || {},
                success: function(e) {
                    t({
                        statusCode: e.statusCode,
                        responseText: e.data,
                        headers: e.header,
                        statusMessage: e.errMsg
                    });
                },
                fail: function(e) {
                    t({
                        statusCode: e.statusCode || 0,
                        statusMessage: e.errMsg
                    });
                }
            };
            wx.request(n);
        };
    }, , , , , function(e, t, n) {
        var o = n(2), r = n(1)(n(6));
        e.exports = function(e) {
            return new o(e || r);
        };
    } ]);
});