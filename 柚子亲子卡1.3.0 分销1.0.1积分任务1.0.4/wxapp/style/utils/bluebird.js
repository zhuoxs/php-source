var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(t) {
    return typeof t;
} : function(t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t;
};

!function(t) {
    if ("object" == ("undefined" == typeof exports ? "undefined" : _typeof(exports)) && "undefined" != typeof module) module.exports = t(); else if ("function" == typeof define && define.amd) define([], t); else {
        var e;
        "undefined" != typeof window ? e = window : "undefined" != typeof global ? e = global : "undefined" != typeof self && (e = self), 
        e.Promise = t();
    }
}(function() {
    return function o(a, s, c) {
        function l(n, t) {
            if (!s[n]) {
                if (!a[n]) {
                    var e = "function" == typeof _dereq_ && _dereq_;
                    if (!t && e) return e(n, !0);
                    if (u) return u(n, !0);
                    var r = new Error("Cannot find module '" + n + "'");
                    throw r.code = "MODULE_NOT_FOUND", r;
                }
                var i = s[n] = {
                    exports: {}
                };
                a[n][0].call(i.exports, function(t) {
                    var e = a[n][1][t];
                    return l(e || t);
                }, i, i.exports, o, a, s, c);
            }
            return s[n].exports;
        }
        for (var u = "function" == typeof _dereq_ && _dereq_, t = 0; t < c.length; t++) l(c[t]);
        return l;
    }({
        1: [ function(t, e, n) {
            function r() {
                this._customScheduler = !1, this._isTickUsed = !1, this._lateQueue = new l(16), 
                this._normalQueue = new l(16), this._haveDrainedQueues = !1, this._trampolineEnabled = !0;
                var t = this;
                this.drainQueues = function() {
                    t._drainQueues();
                }, this._schedule = c;
            }
            function i(t, e, n) {
                this._lateQueue.push(t, e, n), this._queueTick();
            }
            function o(t, e, n) {
                this._normalQueue.push(t, e, n), this._queueTick();
            }
            function a(t) {
                this._normalQueue._pushOne(t), this._queueTick();
            }
            var s;
            try {
                throw new Error();
            } catch (t) {
                s = t;
            }
            var c = t("./schedule"), l = t("./queue"), u = t("./util");
            r.prototype.setScheduler = function(t) {
                var e = this._schedule;
                return this._schedule = t, this._customScheduler = !0, e;
            }, r.prototype.hasCustomScheduler = function() {
                return this._customScheduler;
            }, r.prototype.enableTrampoline = function() {
                this._trampolineEnabled = !0;
            }, r.prototype.disableTrampolineIfNecessary = function() {
                u.hasDevTools && (this._trampolineEnabled = !1);
            }, r.prototype.haveItemsQueued = function() {
                return this._isTickUsed || this._haveDrainedQueues;
            }, r.prototype.fatalError = function(t, e) {
                e ? (process.stderr.write("Fatal " + (t instanceof Error ? t.stack : t) + "\n"), 
                process.exit(2)) : this.throwLater(t);
            }, r.prototype.throwLater = function(t, e) {
                if (1 === arguments.length && (e = t, t = function() {
                    throw e;
                }), "undefined" != typeof setTimeout) setTimeout(function() {
                    t(e);
                }, 0); else try {
                    this._schedule(function() {
                        t(e);
                    });
                } catch (t) {
                    throw new Error("No async scheduler available\n\n    See http://goo.gl/MqrFmX\n");
                }
            }, u.hasDevTools ? (r.prototype.invokeLater = function(t, e, n) {
                this._trampolineEnabled ? i.call(this, t, e, n) : this._schedule(function() {
                    setTimeout(function() {
                        t.call(e, n);
                    }, 100);
                });
            }, r.prototype.invoke = function(t, e, n) {
                this._trampolineEnabled ? o.call(this, t, e, n) : this._schedule(function() {
                    t.call(e, n);
                });
            }, r.prototype.settlePromises = function(t) {
                this._trampolineEnabled ? a.call(this, t) : this._schedule(function() {
                    t._settlePromises();
                });
            }) : (r.prototype.invokeLater = i, r.prototype.invoke = o, r.prototype.settlePromises = a), 
            r.prototype.invokeFirst = function(t, e, n) {
                this._normalQueue.unshift(t, e, n), this._queueTick();
            }, r.prototype._drainQueue = function(t) {
                for (;0 < t.length(); ) {
                    var e = t.shift();
                    if ("function" == typeof e) {
                        var n = t.shift(), r = t.shift();
                        e.call(n, r);
                    } else e._settlePromises();
                }
            }, r.prototype._drainQueues = function() {
                this._drainQueue(this._normalQueue), this._reset(), this._haveDrainedQueues = !0, 
                this._drainQueue(this._lateQueue);
            }, r.prototype._queueTick = function() {
                this._isTickUsed || (this._isTickUsed = !0, this._schedule(this.drainQueues));
            }, r.prototype._reset = function() {
                this._isTickUsed = !1;
            }, e.exports = r, e.exports.firstLineError = s;
        }, {
            "./queue": 17,
            "./schedule": 18,
            "./util": 21
        } ],
        2: [ function(t, e, n) {
            e.exports = function(o, a, s, c) {
                var l = !1, n = function(t, e) {
                    this._reject(e);
                }, u = function(t, e) {
                    e.promiseRejectionQueued = !0, e.bindingPromise._then(n, n, null, this, t);
                }, p = function(t, e) {
                    0 == (50397184 & this._bitField) && this._resolveCallback(e.target);
                }, f = function(t, e) {
                    e.promiseRejectionQueued || this._reject(t);
                };
                o.prototype.bind = function(t) {
                    l || (l = !0, o.prototype._propagateFrom = c.propagateFromFunction(), o.prototype._boundValue = c.boundValueFunction());
                    var e = s(t), n = new o(a);
                    n._propagateFrom(this, 1);
                    var r = this._target();
                    if (n._setBoundTo(e), e instanceof o) {
                        var i = {
                            promiseRejectionQueued: !1,
                            promise: n,
                            target: r,
                            bindingPromise: e
                        };
                        r._then(a, u, void 0, n, i), e._then(p, f, void 0, n, i), n._setOnCancel(e);
                    } else n._resolveCallback(r);
                    return n;
                }, o.prototype._setBoundTo = function(t) {
                    void 0 !== t ? (this._bitField = 2097152 | this._bitField, this._boundTo = t) : this._bitField = -2097153 & this._bitField;
                }, o.prototype._isBound = function() {
                    return 2097152 == (2097152 & this._bitField);
                }, o.bind = function(t, e) {
                    return o.resolve(e).bind(t);
                };
            };
        }, {} ],
        3: [ function(t, e, n) {
            var r;
            "undefined" != typeof Promise && (r = Promise);
            var i = t("./promise")();
            i.noConflict = function() {
                try {
                    Promise === i && (Promise = r);
                } catch (t) {}
                return i;
            }, e.exports = i;
        }, {
            "./promise": 15
        } ],
        4: [ function(c, t, e) {
            t.exports = function(t, e, n, r) {
                var i = c("./util"), o = i.tryCatch, a = i.errorObj, s = t._async;
                t.prototype.break = t.prototype.cancel = function() {
                    if (!r.cancellation()) return this._warn("cancellation is disabled");
                    for (var t = this, e = t; t._isCancellable(); ) {
                        if (!t._cancelBy(e)) {
                            e._isFollowing() ? e._followee().cancel() : e._cancelBranched();
                            break;
                        }
                        var n = t._cancellationParent;
                        if (null == n || !n._isCancellable()) {
                            t._isFollowing() ? t._followee().cancel() : t._cancelBranched();
                            break;
                        }
                        t._isFollowing() && t._followee().cancel(), t._setWillBeCancelled(), e = t, t = n;
                    }
                }, t.prototype._branchHasCancelled = function() {
                    this._branchesRemainingToCancel--;
                }, t.prototype._enoughBranchesHaveCancelled = function() {
                    return void 0 === this._branchesRemainingToCancel || this._branchesRemainingToCancel <= 0;
                }, t.prototype._cancelBy = function(t) {
                    return t === this ? (this._branchesRemainingToCancel = 0, this._invokeOnCancel(), 
                    !0) : (this._branchHasCancelled(), !!this._enoughBranchesHaveCancelled() && (this._invokeOnCancel(), 
                    !0));
                }, t.prototype._cancelBranched = function() {
                    this._enoughBranchesHaveCancelled() && this._cancel();
                }, t.prototype._cancel = function() {
                    this._isCancellable() && (this._setCancelled(), s.invoke(this._cancelPromises, this, void 0));
                }, t.prototype._cancelPromises = function() {
                    0 < this._length() && this._settlePromises();
                }, t.prototype._unsetOnCancel = function() {
                    this._onCancelField = void 0;
                }, t.prototype._isCancellable = function() {
                    return this.isPending() && !this._isCancelled();
                }, t.prototype.isCancellable = function() {
                    return this.isPending() && !this.isCancelled();
                }, t.prototype._doInvokeOnCancel = function(t, e) {
                    if (i.isArray(t)) for (var n = 0; n < t.length; ++n) this._doInvokeOnCancel(t[n], e); else if (void 0 !== t) if ("function" == typeof t) {
                        if (!e) {
                            var r = o(t).call(this._boundValue());
                            r === a && (this._attachExtraTrace(r.e), s.throwLater(r.e));
                        }
                    } else t._resultCancelled(this);
                }, t.prototype._invokeOnCancel = function() {
                    var t = this._onCancel();
                    this._unsetOnCancel(), s.invoke(this._doInvokeOnCancel, this, t);
                }, t.prototype._invokeInternalOnCancel = function() {
                    this._isCancellable() && (this._doInvokeOnCancel(this._onCancel(), !0), this._unsetOnCancel());
                }, t.prototype._resultCancelled = function() {
                    this.cancel();
                };
            };
        }, {
            "./util": 21
        } ],
        5: [ function(t, e, n) {
            e.exports = function(p) {
                var f = t("./util"), h = t("./es5").keys, _ = f.tryCatch, d = f.errorObj;
                return function(c, l, u) {
                    return function(t) {
                        var e = u._boundValue();
                        t: for (var n = 0; n < c.length; ++n) {
                            var r = c[n];
                            if (r === Error || null != r && r.prototype instanceof Error) {
                                if (t instanceof r) return _(l).call(e, t);
                            } else if ("function" == typeof r) {
                                var i = _(r).call(e, t);
                                if (i === d) return i;
                                if (i) return _(l).call(e, t);
                            } else if (f.isObject(t)) {
                                for (var o = h(r), a = 0; a < o.length; ++a) {
                                    var s = o[a];
                                    if (r[s] != t[s]) continue t;
                                }
                                return _(l).call(e, t);
                            }
                        }
                        return p;
                    };
                };
            };
        }, {
            "./es5": 10,
            "./util": 21
        } ],
        6: [ function(t, e, n) {
            e.exports = function(o) {
                function a() {
                    this._trace = new a.CapturedTrace(s());
                }
                function s() {
                    var t = n.length - 1;
                    return 0 <= t ? n[t] : void 0;
                }
                var c = !1, n = [];
                return o.prototype._promiseCreated = function() {}, o.prototype._pushContext = function() {}, 
                o.prototype._popContext = function() {
                    return null;
                }, o._peekContext = o.prototype._peekContext = function() {}, a.prototype._pushContext = function() {
                    void 0 !== this._trace && (this._trace._promiseCreated = null, n.push(this._trace));
                }, a.prototype._popContext = function() {
                    if (void 0 !== this._trace) {
                        var t = n.pop(), e = t._promiseCreated;
                        return t._promiseCreated = null, e;
                    }
                    return null;
                }, a.CapturedTrace = null, a.create = function() {
                    return c ? new a() : void 0;
                }, a.deactivateLongStackTraces = function() {}, a.activateLongStackTraces = function() {
                    var t = o.prototype._pushContext, e = o.prototype._popContext, n = o._peekContext, r = o.prototype._peekContext, i = o.prototype._promiseCreated;
                    a.deactivateLongStackTraces = function() {
                        o.prototype._pushContext = t, o.prototype._popContext = e, o._peekContext = n, o.prototype._peekContext = r, 
                        o.prototype._promiseCreated = i, c = !1;
                    }, c = !0, o.prototype._pushContext = a.prototype._pushContext, o.prototype._popContext = a.prototype._popContext, 
                    o._peekContext = o.prototype._peekContext = s, o.prototype._promiseCreated = function() {
                        var t = this._peekContext();
                        t && null == t._promiseCreated && (t._promiseCreated = this);
                    };
                }, a;
            };
        }, {} ],
        7: [ function(K, t, e) {
            t.exports = function(a, n) {
                function t(t, e) {
                    return {
                        promise: e
                    };
                }
                function r() {
                    return !1;
                }
                function i(t, e, n) {
                    var r = this;
                    try {
                        t(e, n, function(t) {
                            if ("function" != typeof t) throw new TypeError("onCancel must be a function, got: " + O.toString(t));
                            r._attachCancellationCallback(t);
                        });
                    } catch (t) {
                        return t;
                    }
                }
                function o(t) {
                    if (!this._isCancellable()) return this;
                    var e = this._onCancel();
                    void 0 !== e ? O.isArray(e) ? e.push(t) : this._setOnCancel([ e, t ]) : this._setOnCancel(t);
                }
                function s() {
                    return this._onCancelField;
                }
                function c(t) {
                    this._onCancelField = t;
                }
                function l() {
                    this._cancellationParent = void 0, this._onCancelField = void 0;
                }
                function u(t, e) {
                    if (0 != (1 & e)) {
                        var n = (this._cancellationParent = t)._branchesRemainingToCancel;
                        void 0 === n && (n = 0), t._branchesRemainingToCancel = n + 1;
                    }
                    0 != (2 & e) && t._isBound() && this._setBoundTo(t._boundTo);
                }
                function e() {
                    var t = this._boundTo;
                    return void 0 !== t && t instanceof a ? t.isFulfilled() ? t.value() : void 0 : t;
                }
                function p() {
                    this._trace = new C(this._peekContext());
                }
                function f(t, e) {
                    if (S(t)) {
                        var n = this._trace;
                        if (void 0 !== n && e && (n = n._parent), void 0 !== n) n.attachExtraTrace(t); else if (!t.__stackCleaned__) {
                            var r = d(t);
                            O.notEnumerableProp(t, "stack", r.message + "\n" + r.stack.join("\n")), O.notEnumerableProp(t, "__stackCleaned__", !0);
                        }
                    }
                }
                function h(t, e, n) {
                    if (X.warnings) {
                        var r, i = new T(t);
                        if (e) n._attachExtraTrace(i); else if (X.longStackTraces && (r = a._peekContext())) r.attachExtraTrace(i); else {
                            var o = d(i);
                            i.stack = o.message + "\n" + o.stack.join("\n");
                        }
                        G("warning", i) || v(i, "", !0);
                    }
                }
                function _(t) {
                    for (var e = [], n = 0; n < t.length; ++n) {
                        var r = t[n], i = "    (No stack trace)" === r || A.test(r), o = i && W(r);
                        i && !o && (N && " " !== r.charAt(0) && (r = "    " + r), e.push(r));
                    }
                    return e;
                }
                function d(t) {
                    var e = t.stack;
                    return {
                        message: t.toString(),
                        stack: _(e = "string" == typeof e && 0 < e.length ? function(t) {
                            for (var e = t.stack.replace(/\s+$/g, "").split("\n"), n = 0; n < e.length; ++n) {
                                var r = e[n];
                                if ("    (No stack trace)" === r || A.test(r)) break;
                            }
                            return 0 < n && (e = e.slice(n)), e;
                        }(t) : [ "    (No stack trace)" ])
                    };
                }
                function v(t, e, n) {
                    if ("undefined" != typeof console) {
                        var r;
                        if (O.isObject(t)) {
                            var i = t.stack;
                            r = e + L(i, t);
                        } else r = e + String(t);
                        "function" == typeof E ? E(r, n) : ("function" == typeof console.log || "object" == _typeof(console.log)) && console.log(r);
                    }
                }
                function y(t, e, n, r) {
                    var i = !1;
                    try {
                        "function" == typeof e && (i = !0, "rejectionHandled" === t ? e(r) : e(n, r));
                    } catch (t) {
                        F.throwLater(t);
                    }
                    "unhandledRejection" === t ? G(t, n, r) || i || v(n, "Unhandled rejection ") : G(t, r);
                }
                function g(t) {
                    var e, n;
                    if ("function" == typeof t) e = "[function " + (t.name || "anonymous") + "]"; else {
                        e = t && "function" == typeof t.toString ? t.toString() : O.toString(t);
                        if (/\[object [a-zA-Z0-9$_]+\]/.test(e)) try {
                            e = JSON.stringify(t);
                        } catch (t) {}
                        0 === e.length && (e = "(empty array)");
                    }
                    return "(<" + ((n = e).length < 41 ? n : n.substr(0, 38) + "...") + ">, no stack trace)";
                }
                function m() {
                    return "function" == typeof z;
                }
                function b(t) {
                    var e = t.match($);
                    return e ? {
                        fileName: e[1],
                        line: parseInt(e[2], 10)
                    } : void 0;
                }
                function C(t) {
                    this._parent = t, this._promisesCreated = 0;
                    var e = this._length = 1 + (void 0 === t ? 0 : t._length);
                    z(this, C), 32 < e && this.uncycle();
                }
                var w, k, E, j = a._getDomain, F = a._async, T = K("./errors").Warning, O = K("./util"), S = O.canAttachTrace, P = /[\\\/]bluebird[\\\/]js[\\\/](release|debug|instrumented)/, R = /\((?:timers\.js):\d+:\d+\)/, x = /[\/<\(](.+?):(\d+):(\d+)\)?\s*$/, A = null, L = null, N = !1, B = !(0 == O.env("BLUEBIRD_DEBUG") || !O.env("BLUEBIRD_DEBUG") && "development" !== O.env("NODE_ENV")), U = !(0 == O.env("BLUEBIRD_WARNINGS") || !B && !O.env("BLUEBIRD_WARNINGS")), I = !(0 == O.env("BLUEBIRD_LONG_STACK_TRACES") || !B && !O.env("BLUEBIRD_LONG_STACK_TRACES")), H = 0 != O.env("BLUEBIRD_W_FORGOTTEN_RETURN") && (U || !!O.env("BLUEBIRD_W_FORGOTTEN_RETURN"));
                a.prototype.suppressUnhandledRejections = function() {
                    var t = this._target();
                    t._bitField = -1048577 & t._bitField | 524288;
                }, a.prototype._ensurePossibleRejectionHandled = function() {
                    0 == (524288 & this._bitField) && (this._setRejectionIsUnhandled(), F.invokeLater(this._notifyUnhandledRejection, this, void 0));
                }, a.prototype._notifyUnhandledRejectionIsHandled = function() {
                    y("rejectionHandled", w, void 0, this);
                }, a.prototype._setReturnedNonUndefined = function() {
                    this._bitField = 268435456 | this._bitField;
                }, a.prototype._returnedNonUndefined = function() {
                    return 0 != (268435456 & this._bitField);
                }, a.prototype._notifyUnhandledRejection = function() {
                    if (this._isRejectionUnhandled()) {
                        var t = this._settledValue();
                        this._setUnhandledRejectionIsNotified(), y("unhandledRejection", k, t, this);
                    }
                }, a.prototype._setUnhandledRejectionIsNotified = function() {
                    this._bitField = 262144 | this._bitField;
                }, a.prototype._unsetUnhandledRejectionIsNotified = function() {
                    this._bitField = -262145 & this._bitField;
                }, a.prototype._isUnhandledRejectionNotified = function() {
                    return 0 < (262144 & this._bitField);
                }, a.prototype._setRejectionIsUnhandled = function() {
                    this._bitField = 1048576 | this._bitField;
                }, a.prototype._unsetRejectionIsUnhandled = function() {
                    this._bitField = -1048577 & this._bitField, this._isUnhandledRejectionNotified() && (this._unsetUnhandledRejectionIsNotified(), 
                    this._notifyUnhandledRejectionIsHandled());
                }, a.prototype._isRejectionUnhandled = function() {
                    return 0 < (1048576 & this._bitField);
                }, a.prototype._warn = function(t, e, n) {
                    return h(t, e, n || this);
                }, a.onPossiblyUnhandledRejection = function(t) {
                    var e = j();
                    k = "function" == typeof t ? null === e ? t : O.domainBind(e, t) : void 0;
                }, a.onUnhandledRejectionHandled = function(t) {
                    var e = j();
                    w = "function" == typeof t ? null === e ? t : O.domainBind(e, t) : void 0;
                };
                var D = function() {};
                a.longStackTraces = function() {
                    if (F.haveItemsQueued() && !X.longStackTraces) throw new Error("cannot enable long stack traces after promises have been created\n\n    See http://goo.gl/MqrFmX\n");
                    if (!X.longStackTraces && m()) {
                        var t = a.prototype._captureStackTrace, e = a.prototype._attachExtraTrace;
                        X.longStackTraces = !0, D = function() {
                            if (F.haveItemsQueued() && !X.longStackTraces) throw new Error("cannot enable long stack traces after promises have been created\n\n    See http://goo.gl/MqrFmX\n");
                            a.prototype._captureStackTrace = t, a.prototype._attachExtraTrace = e, n.deactivateLongStackTraces(), 
                            F.enableTrampoline(), X.longStackTraces = !1;
                        }, a.prototype._captureStackTrace = p, a.prototype._attachExtraTrace = f, n.activateLongStackTraces(), 
                        F.disableTrampolineIfNecessary();
                    }
                }, a.hasLongStackTraces = function() {
                    return X.longStackTraces && m();
                };
                var V = function() {
                    try {
                        if ("function" == typeof CustomEvent) {
                            var t = new CustomEvent("CustomEvent");
                            return O.global.dispatchEvent(t), function(t, e) {
                                var n = new CustomEvent(t.toLowerCase(), {
                                    detail: e,
                                    cancelable: !0
                                });
                                return !O.global.dispatchEvent(n);
                            };
                        }
                        if ("function" == typeof Event) {
                            t = new Event("CustomEvent");
                            return O.global.dispatchEvent(t), function(t, e) {
                                var n = new Event(t.toLowerCase(), {
                                    cancelable: !0
                                });
                                return n.detail = e, !O.global.dispatchEvent(n);
                            };
                        }
                        return (t = document.createEvent("CustomEvent")).initCustomEvent("testingtheevent", !1, !0, {}), 
                        O.global.dispatchEvent(t), function(t, e) {
                            var n = document.createEvent("CustomEvent");
                            return n.initCustomEvent(t.toLowerCase(), !1, !0, e), !O.global.dispatchEvent(n);
                        };
                    } catch (t) {}
                    return function() {
                        return !1;
                    };
                }(), Q = O.isNode ? function() {
                    return process.emit.apply(process, arguments);
                } : O.global ? function(t) {
                    var e = "on" + t.toLowerCase(), n = O.global[e];
                    return !!n && (n.apply(O.global, [].slice.call(arguments, 1)), !0);
                } : function() {
                    return !1;
                }, q = {
                    promiseCreated: t,
                    promiseFulfilled: t,
                    promiseRejected: t,
                    promiseResolved: t,
                    promiseCancelled: t,
                    promiseChained: function(t, e, n) {
                        return {
                            promise: e,
                            child: n
                        };
                    },
                    warning: function(t, e) {
                        return {
                            warning: e
                        };
                    },
                    unhandledRejection: function(t, e, n) {
                        return {
                            reason: e,
                            promise: n
                        };
                    },
                    rejectionHandled: t
                }, G = function(t) {
                    var e = !1;
                    try {
                        e = Q.apply(null, arguments);
                    } catch (t) {
                        F.throwLater(t), e = !0;
                    }
                    var n = !1;
                    try {
                        n = V(t, q[t].apply(null, arguments));
                    } catch (t) {
                        F.throwLater(t), n = !0;
                    }
                    return n || e;
                };
                a.config = function(t) {
                    if ("longStackTraces" in (t = Object(t)) && (t.longStackTraces ? a.longStackTraces() : !t.longStackTraces && a.hasLongStackTraces() && D()), 
                    "warnings" in t) {
                        var e = t.warnings;
                        X.warnings = !!e, H = X.warnings, O.isObject(e) && "wForgottenReturn" in e && (H = !!e.wForgottenReturn);
                    }
                    if ("cancellation" in t && t.cancellation && !X.cancellation) {
                        if (F.haveItemsQueued()) throw new Error("cannot enable cancellation after promises are in use");
                        a.prototype._clearCancellationData = l, a.prototype._propagateFrom = u, a.prototype._onCancel = s, 
                        a.prototype._setOnCancel = c, a.prototype._attachCancellationCallback = o, a.prototype._execute = i, 
                        M = u, X.cancellation = !0;
                    }
                    "monitoring" in t && (t.monitoring && !X.monitoring ? (X.monitoring = !0, a.prototype._fireEvent = G) : !t.monitoring && X.monitoring && (X.monitoring = !1, 
                    a.prototype._fireEvent = r));
                }, a.prototype._fireEvent = r, a.prototype._execute = function(t, e, n) {
                    try {
                        t(e, n);
                    } catch (t) {
                        return t;
                    }
                }, a.prototype._onCancel = function() {}, a.prototype._setOnCancel = function(t) {}, 
                a.prototype._attachCancellationCallback = function(t) {}, a.prototype._captureStackTrace = function() {}, 
                a.prototype._attachExtraTrace = function() {}, a.prototype._clearCancellationData = function() {}, 
                a.prototype._propagateFrom = function(t, e) {};
                var M = function(t, e) {
                    0 != (2 & e) && t._isBound() && this._setBoundTo(t._boundTo);
                }, W = function() {
                    return !1;
                }, $ = /[\/<\(]([^:\/]+):(\d+):(?:\d+)\)?\s*$/;
                O.inherits(C, Error), (n.CapturedTrace = C).prototype.uncycle = function() {
                    var t = this._length;
                    if (!(t < 2)) {
                        for (var e = [], n = {}, r = 0, i = this; void 0 !== i; ++r) e.push(i), i = i._parent;
                        for (r = (t = this._length = r) - 1; 0 <= r; --r) {
                            var o = e[r].stack;
                            void 0 === n[o] && (n[o] = r);
                        }
                        for (r = 0; r < t; ++r) {
                            var a = n[e[r].stack];
                            if (void 0 !== a && a !== r) {
                                0 < a && (e[a - 1]._parent = void 0, e[a - 1]._length = 1), e[r]._parent = void 0, 
                                e[r]._length = 1;
                                var s = 0 < r ? e[r - 1] : this;
                                a < t - 1 ? (s._parent = e[a + 1], s._parent.uncycle(), s._length = s._parent._length + 1) : (s._parent = void 0, 
                                s._length = 1);
                                for (var c = s._length + 1, l = r - 2; 0 <= l; --l) e[l]._length = c, c++;
                                return;
                            }
                        }
                    }
                }, C.prototype.attachExtraTrace = function(t) {
                    if (!t.__stackCleaned__) {
                        this.uncycle();
                        for (var e = d(t), n = e.message, r = [ e.stack ], i = this; void 0 !== i; ) r.push(_(i.stack.split("\n"))), 
                        i = i._parent;
                        (function(t) {
                            for (var e = t[0], n = 1; n < t.length; ++n) {
                                for (var r = t[n], i = e.length - 1, o = e[i], a = -1, s = r.length - 1; 0 <= s; --s) if (r[s] === o) {
                                    a = s;
                                    break;
                                }
                                for (s = a; 0 <= s; --s) {
                                    var c = r[s];
                                    if (e[i] !== c) break;
                                    e.pop(), i--;
                                }
                                e = r;
                            }
                        })(r), function(t) {
                            for (var e = 0; e < t.length; ++e) (0 === t[e].length || e + 1 < t.length && t[e][0] === t[e + 1][0]) && (t.splice(e, 1), 
                            e--);
                        }(r), O.notEnumerableProp(t, "stack", function(t, e) {
                            for (var n = 0; n < e.length - 1; ++n) e[n].push("From previous event:"), e[n] = e[n].join("\n");
                            return n < e.length && (e[n] = e[n].join("\n")), t + "\n" + e.join("\n");
                        }(n, r)), O.notEnumerableProp(t, "__stackCleaned__", !0);
                    }
                };
                var z = function() {
                    var t = /^\s*at\s*/, e = function(t, e) {
                        return "string" == typeof t ? t : void 0 !== e.name && void 0 !== e.message ? e.toString() : g(e);
                    };
                    if ("number" == typeof Error.stackTraceLimit && "function" == typeof Error.captureStackTrace) {
                        Error.stackTraceLimit += 6, A = t, L = e;
                        var n = Error.captureStackTrace;
                        return W = function(t) {
                            return P.test(t);
                        }, function(t, e) {
                            Error.stackTraceLimit += 6, n(t, e), Error.stackTraceLimit -= 6;
                        };
                    }
                    var r, i = new Error();
                    if ("string" == typeof i.stack && 0 <= i.stack.split("\n")[0].indexOf("stackDetection@")) return A = /@/, 
                    L = e, N = !0, function(t) {
                        t.stack = new Error().stack;
                    };
                    try {
                        throw new Error();
                    } catch (t) {
                        r = "stack" in t;
                    }
                    return "stack" in i || !r || "number" != typeof Error.stackTraceLimit ? (L = function(t, e) {
                        return "string" == typeof t ? t : "object" != (void 0 === e ? "undefined" : _typeof(e)) && "function" != typeof e || void 0 === e.name || void 0 === e.message ? g(e) : e.toString();
                    }, null) : (A = t, L = e, function(e) {
                        Error.stackTraceLimit += 6;
                        try {
                            throw new Error();
                        } catch (t) {
                            e.stack = t.stack;
                        }
                        Error.stackTraceLimit -= 6;
                    });
                }();
                "undefined" != typeof console && void 0 !== console.warn && (E = function(t) {
                    console.warn(t);
                }, O.isNode && process.stderr.isTTY ? E = function(t, e) {
                    var n = e ? "[33m" : "[31m";
                    console.warn(n + t + "[0m\n");
                } : O.isNode || "string" != typeof new Error().stack || (E = function(t, e) {
                    console.warn("%c" + t, e ? "color: darkorange" : "color: red");
                }));
                var X = {
                    warnings: U,
                    longStackTraces: !1,
                    cancellation: !1,
                    monitoring: !1
                };
                return I && a.longStackTraces(), {
                    longStackTraces: function() {
                        return X.longStackTraces;
                    },
                    warnings: function() {
                        return X.warnings;
                    },
                    cancellation: function() {
                        return X.cancellation;
                    },
                    monitoring: function() {
                        return X.monitoring;
                    },
                    propagateFromFunction: function() {
                        return M;
                    },
                    boundValueFunction: function() {
                        return e;
                    },
                    checkForgottenReturns: function(t, e, n, r, i) {
                        if (void 0 === t && null !== e && H) {
                            if (void 0 !== i && i._returnedNonUndefined()) return;
                            if (0 == (65535 & r._bitField)) return;
                            n && (n += " ");
                            var o = "", a = "";
                            if (e._trace) {
                                for (var s = e._trace.stack.split("\n"), c = _(s), l = c.length - 1; 0 <= l; --l) {
                                    var u = c[l];
                                    if (!R.test(u)) {
                                        var p = u.match(x);
                                        p && (o = "at " + p[1] + ":" + p[2] + ":" + p[3] + " ");
                                        break;
                                    }
                                }
                                if (0 < c.length) {
                                    var f = c[0];
                                    for (l = 0; l < s.length; ++l) if (s[l] === f) {
                                        0 < l && (a = "\n" + s[l - 1]);
                                        break;
                                    }
                                }
                            }
                            var h = "a promise was created in a " + n + "handler " + o + "but was not returned from it, see http://goo.gl/rRqMUw" + a;
                            r._warn(h, !0, e);
                        }
                    },
                    setBounds: function(t, e) {
                        if (m()) {
                            for (var n, r, i = t.stack.split("\n"), o = e.stack.split("\n"), a = -1, s = -1, c = 0; c < i.length; ++c) if (l = b(i[c])) {
                                n = l.fileName, a = l.line;
                                break;
                            }
                            for (c = 0; c < o.length; ++c) {
                                var l;
                                if (l = b(o[c])) {
                                    r = l.fileName, s = l.line;
                                    break;
                                }
                            }
                            a < 0 || s < 0 || !n || !r || n !== r || s <= a || (W = function(t) {
                                if (P.test(t)) return !0;
                                var e = b(t);
                                return !!(e && e.fileName === n && a <= e.line && e.line <= s);
                            });
                        }
                    },
                    warn: h,
                    deprecated: function(t, e) {
                        var n = t + " is deprecated and will be removed in a future version.";
                        return e && (n += " Use " + e + " instead."), h(n);
                    },
                    CapturedTrace: C,
                    fireDomEvent: V,
                    fireGlobalEvent: Q
                };
            };
        }, {
            "./errors": 9,
            "./util": 21
        } ],
        8: [ function(t, e, n) {
            e.exports = function(n) {
                function r() {
                    return this.value;
                }
                function i() {
                    throw this.reason;
                }
                n.prototype.return = n.prototype.thenReturn = function(t) {
                    return t instanceof n && t.suppressUnhandledRejections(), this._then(r, void 0, void 0, {
                        value: t
                    }, void 0);
                }, n.prototype.throw = n.prototype.thenThrow = function(t) {
                    return this._then(i, void 0, void 0, {
                        reason: t
                    }, void 0);
                }, n.prototype.catchThrow = function(t) {
                    if (arguments.length <= 1) return this._then(void 0, i, void 0, {
                        reason: t
                    }, void 0);
                    var e = arguments[1];
                    return this.caught(t, function() {
                        throw e;
                    });
                }, n.prototype.catchReturn = function(t) {
                    if (arguments.length <= 1) return t instanceof n && t.suppressUnhandledRejections(), 
                    this._then(void 0, r, void 0, {
                        value: t
                    }, void 0);
                    var e = arguments[1];
                    e instanceof n && e.suppressUnhandledRejections();
                    return this.caught(t, function() {
                        return e;
                    });
                };
            };
        }, {} ],
        9: [ function(t, e, n) {
            function r(e, n) {
                function r(t) {
                    return this instanceof r ? (p(this, "message", "string" == typeof t ? t : n), p(this, "name", e), 
                    void (Error.captureStackTrace ? Error.captureStackTrace(this, this.constructor) : Error.call(this))) : new r(t);
                }
                return u(r, Error), r;
            }
            function i(t) {
                return this instanceof i ? (p(this, "name", "OperationalError"), p(this, "message", t), 
                this.cause = t, this.isOperational = !0, void (t instanceof Error ? (p(this, "message", t.message), 
                p(this, "stack", t.stack)) : Error.captureStackTrace && Error.captureStackTrace(this, this.constructor))) : new i(t);
            }
            var o, a, s = t("./es5"), c = s.freeze, l = t("./util"), u = l.inherits, p = l.notEnumerableProp, f = r("Warning", "warning"), h = r("CancellationError", "cancellation error"), _ = r("TimeoutError", "timeout error"), d = r("AggregateError", "aggregate error");
            try {
                o = TypeError, a = RangeError;
            } catch (t) {
                o = r("TypeError", "type error"), a = r("RangeError", "range error");
            }
            for (var v = "join pop push shift unshift slice filter forEach some every map indexOf lastIndexOf reduce reduceRight sort reverse".split(" "), y = 0; y < v.length; ++y) "function" == typeof Array.prototype[v[y]] && (d.prototype[v[y]] = Array.prototype[v[y]]);
            s.defineProperty(d.prototype, "length", {
                value: 0,
                configurable: !1,
                writable: !0,
                enumerable: !0
            }), d.prototype.isOperational = !0;
            var g = 0;
            d.prototype.toString = function() {
                var t = Array(4 * g + 1).join(" "), e = "\n" + t + "AggregateError of:\n";
                g++, t = Array(4 * g + 1).join(" ");
                for (var n = 0; n < this.length; ++n) {
                    for (var r = this[n] === this ? "[Circular AggregateError]" : this[n] + "", i = r.split("\n"), o = 0; o < i.length; ++o) i[o] = t + i[o];
                    e += (r = i.join("\n")) + "\n";
                }
                return g--, e;
            }, u(i, Error);
            var m = Error.__BluebirdErrorTypes__;
            m || (m = c({
                CancellationError: h,
                TimeoutError: _,
                OperationalError: i,
                RejectionError: i,
                AggregateError: d
            }), s.defineProperty(Error, "__BluebirdErrorTypes__", {
                value: m,
                writable: !1,
                enumerable: !1,
                configurable: !1
            })), e.exports = {
                Error: Error,
                TypeError: o,
                RangeError: a,
                CancellationError: m.CancellationError,
                OperationalError: m.OperationalError,
                TimeoutError: m.TimeoutError,
                AggregateError: m.AggregateError,
                Warning: f
            };
        }, {
            "./es5": 10,
            "./util": 21
        } ],
        10: [ function(t, e, n) {
            var r = function() {
                return void 0 === this;
            }();
            if (r) e.exports = {
                freeze: Object.freeze,
                defineProperty: Object.defineProperty,
                getDescriptor: Object.getOwnPropertyDescriptor,
                keys: Object.keys,
                names: Object.getOwnPropertyNames,
                getPrototypeOf: Object.getPrototypeOf,
                isArray: Array.isArray,
                isES5: r,
                propertyIsWritable: function(t, e) {
                    var n = Object.getOwnPropertyDescriptor(t, e);
                    return !(n && !n.writable && !n.set);
                }
            }; else {
                var i = {}.hasOwnProperty, o = {}.toString, a = {}.constructor.prototype, s = function(t) {
                    var e = [];
                    for (var n in t) i.call(t, n) && e.push(n);
                    return e;
                };
                e.exports = {
                    isArray: function(t) {
                        try {
                            return "[object Array]" === o.call(t);
                        } catch (t) {
                            return !1;
                        }
                    },
                    keys: s,
                    names: s,
                    defineProperty: function(t, e, n) {
                        return t[e] = n.value, t;
                    },
                    getDescriptor: function(t, e) {
                        return {
                            value: t[e]
                        };
                    },
                    freeze: function(t) {
                        return t;
                    },
                    getPrototypeOf: function(t) {
                        try {
                            return Object(t).constructor.prototype;
                        } catch (t) {
                            return a;
                        }
                    },
                    isES5: r,
                    propertyIsWritable: function() {
                        return !0;
                    }
                };
            }
        }, {} ],
        11: [ function(n, t, e) {
            t.exports = function(a, s) {
                function i(t, e, n) {
                    this.promise = t, this.type = e, this.handler = n, this.called = !1, this.cancelPromise = null;
                }
                function c(t) {
                    this.finallyHandler = t;
                }
                function l(t, e) {
                    return null != t.cancelPromise && (1 < arguments.length ? t.cancelPromise._reject(e) : t.cancelPromise._cancel(), 
                    !(t.cancelPromise = null));
                }
                function u() {
                    return e.call(this, this.promise._target()._settledValue());
                }
                function p(t) {
                    return l(this, t) ? void 0 : (h.e = t, h);
                }
                function e(t) {
                    var e = this.promise, n = this.handler;
                    if (!this.called) {
                        this.called = !0;
                        var r = this.isFinallyHandler() ? n.call(e._boundValue()) : n.call(e._boundValue(), t);
                        if (void 0 !== r) {
                            e._setReturnedNonUndefined();
                            var i = s(r, e);
                            if (i instanceof a) {
                                if (null != this.cancelPromise) {
                                    if (i._isCancelled()) {
                                        var o = new f("late cancellation observer");
                                        return e._attachExtraTrace(o), h.e = o, h;
                                    }
                                    i.isPending() && i._attachCancellationCallback(new c(this));
                                }
                                return i._then(u, p, void 0, this, void 0);
                            }
                        }
                    }
                    return e.isRejected() ? (l(this), h.e = t, h) : (l(this), t);
                }
                var t = n("./util"), f = a.CancellationError, h = t.errorObj;
                return i.prototype.isFinallyHandler = function() {
                    return 0 === this.type;
                }, c.prototype._resultCancelled = function() {
                    l(this.finallyHandler);
                }, a.prototype._passThrough = function(t, e, n, r) {
                    return "function" != typeof t ? this.then() : this._then(n, r, void 0, new i(this, e, t), void 0);
                }, a.prototype.lastly = a.prototype.finally = function(t) {
                    return this._passThrough(t, 0, e, e);
                }, a.prototype.tap = function(t) {
                    return this._passThrough(t, 1, e);
                }, i;
            };
        }, {
            "./util": 21
        } ],
        12: [ function(s, t, e) {
            t.exports = function(t, i, e, n, r, o) {
                var a = s("./util");
                a.canEvaluate, a.tryCatch, a.errorObj, t.join = function() {
                    var t, e = arguments.length - 1;
                    0 < e && "function" == typeof arguments[e] && (t = arguments[e]);
                    var n = [].slice.call(arguments);
                    t && n.pop();
                    var r = new i(n).promise();
                    return void 0 !== t ? r.spread(t) : r;
                };
            };
        }, {
            "./util": 21
        } ],
        13: [ function(e, t, n) {
            t.exports = function(a, s, t, c, l) {
                var u = e("./util"), p = u.tryCatch;
                a.method = function(r) {
                    if ("function" != typeof r) throw new a.TypeError("expecting a function but got " + u.classString(r));
                    return function() {
                        var t = new a(s);
                        t._captureStackTrace(), t._pushContext();
                        var e = p(r).apply(this, arguments), n = t._popContext();
                        return l.checkForgottenReturns(e, n, "Promise.method", t), t._resolveFromSyncValue(e), 
                        t;
                    };
                }, a.attempt = a.try = function(t) {
                    if ("function" != typeof t) return c("expecting a function but got " + u.classString(t));
                    var e, n = new a(s);
                    if (n._captureStackTrace(), n._pushContext(), 1 < arguments.length) {
                        l.deprecated("calling Promise.try with more than 1 argument");
                        var r = arguments[1], i = arguments[2];
                        e = u.isArray(r) ? p(t).apply(i, r) : p(t).call(i, r);
                    } else e = p(t)();
                    var o = n._popContext();
                    return l.checkForgottenReturns(e, o, "Promise.try", n), n._resolveFromSyncValue(e), 
                    n;
                }, a.prototype._resolveFromSyncValue = function(t) {
                    t === u.errorObj ? this._rejectCallback(t.e, !1) : this._resolveCallback(t, !0);
                };
            };
        }, {
            "./util": 21
        } ],
        14: [ function(t, e, n) {
            function a(t) {
                var e, n;
                if ((n = t) instanceof Error && u.getPrototypeOf(n) === Error.prototype) {
                    (e = new l(t)).name = t.name, e.message = t.message, e.stack = t.stack;
                    for (var r = u.keys(t), i = 0; i < r.length; ++i) {
                        var o = r[i];
                        p.test(o) || (e[o] = t[o]);
                    }
                    return e;
                }
                return s.markAsOriginatingFromRejection(t), t;
            }
            var s = t("./util"), c = s.maybeWrapAsError, l = t("./errors").OperationalError, u = t("./es5"), p = /^(?:name|message|stack|cause)$/;
            e.exports = function(i, o) {
                return function(t, e) {
                    if (null !== i) {
                        if (t) {
                            var n = a(c(t));
                            i._attachExtraTrace(n), i._reject(n);
                        } else if (o) {
                            var r = [].slice.call(arguments, 1);
                            i._fulfill(r);
                        } else i._fulfill(e);
                        i = null;
                    }
                };
            };
        }, {
            "./errors": 9,
            "./es5": 10,
            "./util": 21
        } ],
        15: [ function(S, P, t) {
            P.exports = function() {
                function s() {}
                function h(t) {
                    this._bitField = 0, this._fulfillmentHandler0 = void 0, this._rejectionHandler0 = void 0, 
                    this._promise0 = void 0, this._receiver0 = void 0, t !== g && (function(t, e) {
                        if ("function" != typeof e) throw new p("expecting a function but got " + d.classString(e));
                        if (t.constructor !== h) throw new p("the promise constructor cannot be invoked directly\n\n    See http://goo.gl/MqrFmX\n");
                    }(this, t), this._resolveFromExecutor(t)), this._promiseCreated(), this._fireEvent("promiseCreated", this);
                }
                function t(t) {
                    this.promise._resolveCallback(t);
                }
                function e(t) {
                    this.promise._rejectCallback(t, !1);
                }
                function n(t) {
                    var e = new h(g);
                    e._fulfillmentHandler0 = t, e._rejectionHandler0 = t, e._promise0 = t, e._receiver0 = t;
                }
                var _, c = function() {
                    return new p("circular promise resolution chain\n\n    See http://goo.gl/MqrFmX\n");
                }, l = function() {
                    return new h.PromiseInspection(this._target());
                }, a = function(t) {
                    return h.reject(new p(t));
                }, u = {}, d = S("./util");
                _ = d.isNode ? function() {
                    var t = process.domain;
                    return void 0 === t && (t = null), t;
                } : function() {
                    return null;
                }, d.notEnumerableProp(h, "_getDomain", _);
                var r = S("./es5"), i = S("./async"), v = new i();
                r.defineProperty(h, "_async", {
                    value: v
                });
                var o = S("./errors"), p = h.TypeError = o.TypeError;
                h.RangeError = o.RangeError;
                var y = h.CancellationError = o.CancellationError;
                h.TimeoutError = o.TimeoutError, h.OperationalError = o.OperationalError, h.RejectionError = o.OperationalError, 
                h.AggregateError = o.AggregateError;
                var g = function() {}, f = {}, m = {}, b = S("./thenables")(h, g), C = S("./promise_array")(h, g, b, a, s), w = S("./context")(h), k = (w.create, 
                S("./debuggability")(h, w)), E = (k.CapturedTrace, S("./finally")(h, b)), j = S("./catch_filter")(m), F = S("./nodeback"), T = d.errorObj, O = d.tryCatch;
                return h.prototype.toString = function() {
                    return "[object Promise]";
                }, h.prototype.caught = h.prototype.catch = function(t) {
                    var e = arguments.length;
                    if (1 < e) {
                        var n, r = new Array(e - 1), i = 0;
                        for (n = 0; n < e - 1; ++n) {
                            var o = arguments[n];
                            if (!d.isObject(o)) return a("expecting an object but got A catch statement predicate " + d.classString(o));
                            r[i++] = o;
                        }
                        return r.length = i, t = arguments[n], this.then(void 0, j(r, t, this));
                    }
                    return this.then(void 0, t);
                }, h.prototype.reflect = function() {
                    return this._then(l, l, void 0, this, void 0);
                }, h.prototype.then = function(t, e) {
                    if (k.warnings() && 0 < arguments.length && "function" != typeof t && "function" != typeof e) {
                        var n = ".then() only accepts functions but was passed: " + d.classString(t);
                        1 < arguments.length && (n += ", " + d.classString(e)), this._warn(n);
                    }
                    return this._then(t, e, void 0, void 0, void 0);
                }, h.prototype.done = function(t, e) {
                    this._then(t, e, void 0, void 0, void 0)._setIsFinal();
                }, h.prototype.spread = function(t) {
                    return "function" != typeof t ? a("expecting a function but got " + d.classString(t)) : this.all()._then(t, void 0, void 0, f, void 0);
                }, h.prototype.toJSON = function() {
                    var t = {
                        isFulfilled: !1,
                        isRejected: !1,
                        fulfillmentValue: void 0,
                        rejectionReason: void 0
                    };
                    return this.isFulfilled() ? (t.fulfillmentValue = this.value(), t.isFulfilled = !0) : this.isRejected() && (t.rejectionReason = this.reason(), 
                    t.isRejected = !0), t;
                }, h.prototype.all = function() {
                    return 0 < arguments.length && this._warn(".all() was passed arguments but it does not take any"), 
                    new C(this).promise();
                }, h.prototype.error = function(t) {
                    return this.caught(d.originatesFromRejection, t);
                }, h.getNewLibraryCopy = P.exports, h.is = function(t) {
                    return t instanceof h;
                }, h.fromNode = h.fromCallback = function(t) {
                    var e = new h(g);
                    e._captureStackTrace();
                    var n = 1 < arguments.length && !!Object(arguments[1]).multiArgs, r = O(t)(F(e, n));
                    return r === T && e._rejectCallback(r.e, !0), e._isFateSealed() || e._setAsyncGuaranteed(), 
                    e;
                }, h.all = function(t) {
                    return new C(t).promise();
                }, h.resolve = h.fulfilled = h.cast = function(t) {
                    var e = b(t);
                    return e instanceof h || ((e = new h(g))._captureStackTrace(), e._setFulfilled(), 
                    e._rejectionHandler0 = t), e;
                }, h.reject = h.rejected = function(t) {
                    var e = new h(g);
                    return e._captureStackTrace(), e._rejectCallback(t, !0), e;
                }, h.setScheduler = function(t) {
                    if ("function" != typeof t) throw new p("expecting a function but got " + d.classString(t));
                    return v.setScheduler(t);
                }, h.prototype._then = function(t, e, n, r, i) {
                    var o = void 0 !== i, a = o ? i : new h(g), s = this._target(), c = s._bitField;
                    o || (a._propagateFrom(this, 3), a._captureStackTrace(), void 0 === r && 0 != (2097152 & this._bitField) && (r = 0 != (50397184 & c) ? this._boundValue() : s === this ? void 0 : this._boundTo), 
                    this._fireEvent("promiseChained", this, a));
                    var l = _();
                    if (0 != (50397184 & c)) {
                        var u, p, f = s._settlePromiseCtx;
                        0 != (33554432 & c) ? (p = s._rejectionHandler0, u = t) : 0 != (16777216 & c) ? (p = s._fulfillmentHandler0, 
                        u = e, s._unsetRejectionIsUnhandled()) : (f = s._settlePromiseLateCancellationObserver, 
                        p = new y("late cancellation observer"), s._attachExtraTrace(p), u = e), v.invoke(f, s, {
                            handler: null === l ? u : "function" == typeof u && d.domainBind(l, u),
                            promise: a,
                            receiver: r,
                            value: p
                        });
                    } else s._addCallbacks(t, e, a, r, l);
                    return a;
                }, h.prototype._length = function() {
                    return 65535 & this._bitField;
                }, h.prototype._isFateSealed = function() {
                    return 0 != (117506048 & this._bitField);
                }, h.prototype._isFollowing = function() {
                    return 67108864 == (67108864 & this._bitField);
                }, h.prototype._setLength = function(t) {
                    this._bitField = -65536 & this._bitField | 65535 & t;
                }, h.prototype._setFulfilled = function() {
                    this._bitField = 33554432 | this._bitField, this._fireEvent("promiseFulfilled", this);
                }, h.prototype._setRejected = function() {
                    this._bitField = 16777216 | this._bitField, this._fireEvent("promiseRejected", this);
                }, h.prototype._setFollowing = function() {
                    this._bitField = 67108864 | this._bitField, this._fireEvent("promiseResolved", this);
                }, h.prototype._setIsFinal = function() {
                    this._bitField = 4194304 | this._bitField;
                }, h.prototype._isFinal = function() {
                    return 0 < (4194304 & this._bitField);
                }, h.prototype._unsetCancelled = function() {
                    this._bitField = -65537 & this._bitField;
                }, h.prototype._setCancelled = function() {
                    this._bitField = 65536 | this._bitField, this._fireEvent("promiseCancelled", this);
                }, h.prototype._setWillBeCancelled = function() {
                    this._bitField = 8388608 | this._bitField;
                }, h.prototype._setAsyncGuaranteed = function() {
                    v.hasCustomScheduler() || (this._bitField = 134217728 | this._bitField);
                }, h.prototype._receiverAt = function(t) {
                    var e = 0 === t ? this._receiver0 : this[4 * t - 4 + 3];
                    return e === u ? void 0 : void 0 === e && this._isBound() ? this._boundValue() : e;
                }, h.prototype._promiseAt = function(t) {
                    return this[4 * t - 4 + 2];
                }, h.prototype._fulfillmentHandlerAt = function(t) {
                    return this[4 * t - 4 + 0];
                }, h.prototype._rejectionHandlerAt = function(t) {
                    return this[4 * t - 4 + 1];
                }, h.prototype._boundValue = function() {}, h.prototype._migrateCallback0 = function(t) {
                    var e = (t._bitField, t._fulfillmentHandler0), n = t._rejectionHandler0, r = t._promise0, i = t._receiverAt(0);
                    void 0 === i && (i = u), this._addCallbacks(e, n, r, i, null);
                }, h.prototype._migrateCallbackAt = function(t, e) {
                    var n = t._fulfillmentHandlerAt(e), r = t._rejectionHandlerAt(e), i = t._promiseAt(e), o = t._receiverAt(e);
                    void 0 === o && (o = u), this._addCallbacks(n, r, i, o, null);
                }, h.prototype._addCallbacks = function(t, e, n, r, i) {
                    var o = this._length();
                    if (65531 <= o && (o = 0, this._setLength(0)), 0 === o) this._promise0 = n, this._receiver0 = r, 
                    "function" == typeof t && (this._fulfillmentHandler0 = null === i ? t : d.domainBind(i, t)), 
                    "function" == typeof e && (this._rejectionHandler0 = null === i ? e : d.domainBind(i, e)); else {
                        var a = 4 * o - 4;
                        this[a + 2] = n, this[a + 3] = r, "function" == typeof t && (this[a + 0] = null === i ? t : d.domainBind(i, t)), 
                        "function" == typeof e && (this[a + 1] = null === i ? e : d.domainBind(i, e));
                    }
                    return this._setLength(o + 1), o;
                }, h.prototype._proxy = function(t, e) {
                    this._addCallbacks(void 0, void 0, e, t, null);
                }, h.prototype._resolveCallback = function(t, e) {
                    if (0 == (117506048 & this._bitField)) {
                        if (t === this) return this._rejectCallback(c(), !1);
                        var n = b(t, this);
                        if (!(n instanceof h)) return this._fulfill(t);
                        e && this._propagateFrom(n, 2);
                        var r = n._target();
                        if (r === this) return void this._reject(c());
                        var i = r._bitField;
                        if (0 == (50397184 & i)) {
                            var o = this._length();
                            0 < o && r._migrateCallback0(this);
                            for (var a = 1; a < o; ++a) r._migrateCallbackAt(this, a);
                            this._setFollowing(), this._setLength(0), this._setFollowee(r);
                        } else if (0 != (33554432 & i)) this._fulfill(r._value()); else if (0 != (16777216 & i)) this._reject(r._reason()); else {
                            var s = new y("late cancellation observer");
                            r._attachExtraTrace(s), this._reject(s);
                        }
                    }
                }, h.prototype._rejectCallback = function(t, e, n) {
                    var r = d.ensureErrorObject(t), i = r === t;
                    if (!i && !n && k.warnings()) {
                        var o = "a promise was rejected with a non-error: " + d.classString(t);
                        this._warn(o, !0);
                    }
                    this._attachExtraTrace(r, !!e && i), this._reject(t);
                }, h.prototype._resolveFromExecutor = function(t) {
                    var e = this;
                    this._captureStackTrace(), this._pushContext();
                    var n = !0, r = this._execute(t, function(t) {
                        e._resolveCallback(t);
                    }, function(t) {
                        e._rejectCallback(t, n);
                    });
                    n = !1, this._popContext(), void 0 !== r && e._rejectCallback(r, !0);
                }, h.prototype._settlePromiseFromHandler = function(t, e, n, r) {
                    var i = r._bitField;
                    if (0 == (65536 & i)) {
                        var o;
                        r._pushContext(), e === f ? n && "number" == typeof n.length ? o = O(t).apply(this._boundValue(), n) : (o = T).e = new p("cannot .spread() a non-array: " + d.classString(n)) : o = O(t).call(e, n);
                        var a = r._popContext();
                        0 == (65536 & (i = r._bitField)) && (o === m ? r._reject(n) : o === T ? r._rejectCallback(o.e, !1) : (k.checkForgottenReturns(o, a, "", r, this), 
                        r._resolveCallback(o)));
                    }
                }, h.prototype._target = function() {
                    for (var t = this; t._isFollowing(); ) t = t._followee();
                    return t;
                }, h.prototype._followee = function() {
                    return this._rejectionHandler0;
                }, h.prototype._setFollowee = function(t) {
                    this._rejectionHandler0 = t;
                }, h.prototype._settlePromise = function(t, e, n, r) {
                    var i = t instanceof h, o = this._bitField, a = 0 != (134217728 & o);
                    0 != (65536 & o) ? (i && t._invokeInternalOnCancel(), n instanceof E && n.isFinallyHandler() ? (n.cancelPromise = t, 
                    O(e).call(n, r) === T && t._reject(T.e)) : e === l ? t._fulfill(l.call(n)) : n instanceof s ? n._promiseCancelled(t) : i || t instanceof C ? t._cancel() : n.cancel()) : "function" == typeof e ? i ? (a && t._setAsyncGuaranteed(), 
                    this._settlePromiseFromHandler(e, n, r, t)) : e.call(n, r, t) : n instanceof s ? n._isResolved() || (0 != (33554432 & o) ? n._promiseFulfilled(r, t) : n._promiseRejected(r, t)) : i && (a && t._setAsyncGuaranteed(), 
                    0 != (33554432 & o) ? t._fulfill(r) : t._reject(r));
                }, h.prototype._settlePromiseLateCancellationObserver = function(t) {
                    var e = t.handler, n = t.promise, r = t.receiver, i = t.value;
                    "function" == typeof e ? n instanceof h ? this._settlePromiseFromHandler(e, r, i, n) : e.call(r, i, n) : n instanceof h && n._reject(i);
                }, h.prototype._settlePromiseCtx = function(t) {
                    this._settlePromise(t.promise, t.handler, t.receiver, t.value);
                }, h.prototype._settlePromise0 = function(t, e, n) {
                    var r = this._promise0, i = this._receiverAt(0);
                    this._promise0 = void 0, this._receiver0 = void 0, this._settlePromise(r, t, i, e);
                }, h.prototype._clearCallbackDataAtIndex = function(t) {
                    var e = 4 * t - 4;
                    this[e + 2] = this[e + 3] = this[e + 0] = this[e + 1] = void 0;
                }, h.prototype._fulfill = function(t) {
                    var e = this._bitField;
                    if (!((117506048 & e) >>> 16)) {
                        if (t === this) {
                            var n = c();
                            return this._attachExtraTrace(n), this._reject(n);
                        }
                        this._setFulfilled(), this._rejectionHandler0 = t, 0 < (65535 & e) && (0 != (134217728 & e) ? this._settlePromises() : v.settlePromises(this));
                    }
                }, h.prototype._reject = function(t) {
                    var e = this._bitField;
                    if (!((117506048 & e) >>> 16)) return this._setRejected(), this._fulfillmentHandler0 = t, 
                    this._isFinal() ? v.fatalError(t, d.isNode) : void (0 < (65535 & e) ? v.settlePromises(this) : this._ensurePossibleRejectionHandled());
                }, h.prototype._fulfillPromises = function(t, e) {
                    for (var n = 1; n < t; n++) {
                        var r = this._fulfillmentHandlerAt(n), i = this._promiseAt(n), o = this._receiverAt(n);
                        this._clearCallbackDataAtIndex(n), this._settlePromise(i, r, o, e);
                    }
                }, h.prototype._rejectPromises = function(t, e) {
                    for (var n = 1; n < t; n++) {
                        var r = this._rejectionHandlerAt(n), i = this._promiseAt(n), o = this._receiverAt(n);
                        this._clearCallbackDataAtIndex(n), this._settlePromise(i, r, o, e);
                    }
                }, h.prototype._settlePromises = function() {
                    var t = this._bitField, e = 65535 & t;
                    if (0 < e) {
                        if (0 != (16842752 & t)) {
                            var n = this._fulfillmentHandler0;
                            this._settlePromise0(this._rejectionHandler0, n, t), this._rejectPromises(e, n);
                        } else {
                            var r = this._rejectionHandler0;
                            this._settlePromise0(this._fulfillmentHandler0, r, t), this._fulfillPromises(e, r);
                        }
                        this._setLength(0);
                    }
                    this._clearCancellationData();
                }, h.prototype._settledValue = function() {
                    var t = this._bitField;
                    return 0 != (33554432 & t) ? this._rejectionHandler0 : 0 != (16777216 & t) ? this._fulfillmentHandler0 : void 0;
                }, h.defer = h.pending = function() {
                    return k.deprecated("Promise.defer", "new Promise"), {
                        promise: new h(g),
                        resolve: t,
                        reject: e
                    };
                }, d.notEnumerableProp(h, "_makeSelfResolutionError", c), S("./method")(h, g, b, a, k), 
                S("./bind")(h, g, b, k), S("./cancel")(h, C, a, k), S("./direct_resolve")(h), S("./synchronous_inspection")(h), 
                S("./join")(h, C, b, g, v, _), (h.Promise = h).version = "3.4.6", d.toFastProperties(h), 
                d.toFastProperties(h.prototype), n({
                    a: 1
                }), n({
                    b: 2
                }), n({
                    c: 3
                }), n(1), n(function() {}), n(void 0), n(!1), n(new h(g)), k.setBounds(i.firstLineError, d.lastLineError), 
                h;
            };
        }, {
            "./async": 1,
            "./bind": 2,
            "./cancel": 4,
            "./catch_filter": 5,
            "./context": 6,
            "./debuggability": 7,
            "./direct_resolve": 8,
            "./errors": 9,
            "./es5": 10,
            "./finally": 11,
            "./join": 12,
            "./method": 13,
            "./nodeback": 14,
            "./promise_array": 16,
            "./synchronous_inspection": 19,
            "./thenables": 20,
            "./util": 21
        } ],
        16: [ function(r, t, e) {
            t.exports = function(s, n, c, a, t) {
                function e(t) {
                    var e = this._promise = new s(n);
                    t instanceof s && e._propagateFrom(t, 3), e._setOnCancel(this), this._values = t, 
                    this._length = 0, this._totalResolved = 0, this._init(void 0, -2);
                }
                var l = r("./util");
                return l.isArray, l.inherits(e, t), e.prototype.length = function() {
                    return this._length;
                }, e.prototype.promise = function() {
                    return this._promise;
                }, e.prototype._init = function t(e, n) {
                    var r = c(this._values, this._promise);
                    if (r instanceof s) {
                        var i = (r = r._target())._bitField;
                        if (this._values = r, 0 == (50397184 & i)) return this._promise._setAsyncGuaranteed(), 
                        r._then(t, this._reject, void 0, this, n);
                        if (0 == (33554432 & i)) return 0 != (16777216 & i) ? this._reject(r._reason()) : this._cancel();
                        r = r._value();
                    }
                    if (null !== (r = l.asArray(r))) return 0 === r.length ? void (-5 === n ? this._resolveEmptyArray() : this._resolve(function(t) {
                        switch (t) {
                          case -2:
                            return [];

                          case -3:
                            return {};
                        }
                    }(n))) : void this._iterate(r);
                    var o = a("expecting an array or an iterable object but got " + l.classString(r)).reason();
                    this._promise._rejectCallback(o, !1);
                }, e.prototype._iterate = function(t) {
                    var e = this.getActualLength(t.length);
                    this._length = e, this._values = this.shouldCopyValues() ? new Array(e) : this._values;
                    for (var n = this._promise, r = !1, i = null, o = 0; o < e; ++o) {
                        var a = c(t[o], n);
                        a instanceof s ? i = (a = a._target())._bitField : i = null, r ? null !== i && a.suppressUnhandledRejections() : null !== i ? 0 == (50397184 & i) ? (a._proxy(this, o), 
                        this._values[o] = a) : r = 0 != (33554432 & i) ? this._promiseFulfilled(a._value(), o) : 0 != (16777216 & i) ? this._promiseRejected(a._reason(), o) : this._promiseCancelled(o) : r = this._promiseFulfilled(a, o);
                    }
                    r || n._setAsyncGuaranteed();
                }, e.prototype._isResolved = function() {
                    return null === this._values;
                }, e.prototype._resolve = function(t) {
                    this._values = null, this._promise._fulfill(t);
                }, e.prototype._cancel = function() {
                    !this._isResolved() && this._promise._isCancellable() && (this._values = null, this._promise._cancel());
                }, e.prototype._reject = function(t) {
                    this._values = null, this._promise._rejectCallback(t, !1);
                }, e.prototype._promiseFulfilled = function(t, e) {
                    return this._values[e] = t, ++this._totalResolved >= this._length && (this._resolve(this._values), 
                    !0);
                }, e.prototype._promiseCancelled = function() {
                    return this._cancel(), !0;
                }, e.prototype._promiseRejected = function(t) {
                    return this._totalResolved++, this._reject(t), !0;
                }, e.prototype._resultCancelled = function() {
                    if (!this._isResolved()) {
                        var t = this._values;
                        if (this._cancel(), t instanceof s) t.cancel(); else for (var e = 0; e < t.length; ++e) t[e] instanceof s && t[e].cancel();
                    }
                }, e.prototype.shouldCopyValues = function() {
                    return !0;
                }, e.prototype.getActualLength = function(t) {
                    return t;
                }, e;
            };
        }, {
            "./util": 21
        } ],
        17: [ function(t, e, n) {
            function r(t) {
                this._capacity = t, this._length = 0, this._front = 0;
            }
            r.prototype._willBeOverCapacity = function(t) {
                return this._capacity < t;
            }, r.prototype._pushOne = function(t) {
                var e = this.length();
                this._checkCapacity(e + 1), this[this._front + e & this._capacity - 1] = t, this._length = e + 1;
            }, r.prototype._unshiftOne = function(t) {
                var e = this._capacity;
                this._checkCapacity(this.length() + 1);
                var n = (this._front - 1 & e - 1 ^ e) - e;
                this[n] = t, this._front = n, this._length = this.length() + 1;
            }, r.prototype.unshift = function(t, e, n) {
                this._unshiftOne(n), this._unshiftOne(e), this._unshiftOne(t);
            }, r.prototype.push = function(t, e, n) {
                var r = this.length() + 3;
                if (this._willBeOverCapacity(r)) return this._pushOne(t), this._pushOne(e), void this._pushOne(n);
                var i = this._front + r - 3;
                this._checkCapacity(r);
                var o = this._capacity - 1;
                this[i + 0 & o] = t, this[i + 1 & o] = e, this[i + 2 & o] = n, this._length = r;
            }, r.prototype.shift = function() {
                var t = this._front, e = this[t];
                return this[t] = void 0, this._front = t + 1 & this._capacity - 1, this._length--, 
                e;
            }, r.prototype.length = function() {
                return this._length;
            }, r.prototype._checkCapacity = function(t) {
                this._capacity < t && this._resizeTo(this._capacity << 1);
            }, r.prototype._resizeTo = function(t) {
                var e = this._capacity;
                this._capacity = t, function(t, e, n, r, i) {
                    for (var o = 0; o < i; ++o) n[o + r] = t[o + e], t[o + e] = void 0;
                }(this, 0, this, e, this._front + this._length & e - 1);
            }, e.exports = r;
        }, {} ],
        18: [ function(t, e, n) {
            var r, i = t("./util"), o = i.getNativePromise();
            if (i.isNode && "undefined" == typeof MutationObserver) {
                var a = global.setImmediate, s = process.nextTick;
                r = i.isRecentNode ? function(t) {
                    a.call(global, t);
                } : function(t) {
                    s.call(process, t);
                };
            } else if ("function" == typeof o && "function" == typeof o.resolve) {
                var c = o.resolve();
                r = function(t) {
                    c.then(t);
                };
            } else r = "undefined" == typeof MutationObserver || "undefined" != typeof window && window.navigator && (window.navigator.standalone || window.cordova) ? "undefined" != typeof setImmediate ? function(t) {
                setImmediate(t);
            } : "undefined" != typeof setTimeout ? function(t) {
                setTimeout(t, 0);
            } : function() {
                throw new Error("No async scheduler available\n\n    See http://goo.gl/MqrFmX\n");
            } : function() {
                var n = document.createElement("div"), r = {
                    attributes: !0
                }, i = !1, o = document.createElement("div");
                new MutationObserver(function() {
                    n.classList.toggle("foo"), i = !1;
                }).observe(o, r);
                return function(t) {
                    var e = new MutationObserver(function() {
                        e.disconnect(), t();
                    });
                    e.observe(n, r), i || (i = !0, o.classList.toggle("foo"));
                };
            }();
            e.exports = r;
        }, {
            "./util": 21
        } ],
        19: [ function(t, e, n) {
            e.exports = function(t) {
                function e(t) {
                    void 0 !== t ? (t = t._target(), this._bitField = t._bitField, this._settledValueField = t._isFateSealed() ? t._settledValue() : void 0) : (this._bitField = 0, 
                    this._settledValueField = void 0);
                }
                e.prototype._settledValue = function() {
                    return this._settledValueField;
                };
                var n = e.prototype.value = function() {
                    if (!this.isFulfilled()) throw new TypeError("cannot get fulfillment value of a non-fulfilled promise\n\n    See http://goo.gl/MqrFmX\n");
                    return this._settledValue();
                }, r = e.prototype.error = e.prototype.reason = function() {
                    if (!this.isRejected()) throw new TypeError("cannot get rejection reason of a non-rejected promise\n\n    See http://goo.gl/MqrFmX\n");
                    return this._settledValue();
                }, i = e.prototype.isFulfilled = function() {
                    return 0 != (33554432 & this._bitField);
                }, o = e.prototype.isRejected = function() {
                    return 0 != (16777216 & this._bitField);
                }, a = e.prototype.isPending = function() {
                    return 0 == (50397184 & this._bitField);
                }, s = e.prototype.isResolved = function() {
                    return 0 != (50331648 & this._bitField);
                };
                e.prototype.isCancelled = function() {
                    return 0 != (8454144 & this._bitField);
                }, t.prototype.__isCancelled = function() {
                    return 65536 == (65536 & this._bitField);
                }, t.prototype._isCancelled = function() {
                    return this._target().__isCancelled();
                }, t.prototype.isCancelled = function() {
                    return 0 != (8454144 & this._target()._bitField);
                }, t.prototype.isPending = function() {
                    return a.call(this._target());
                }, t.prototype.isRejected = function() {
                    return o.call(this._target());
                }, t.prototype.isFulfilled = function() {
                    return i.call(this._target());
                }, t.prototype.isResolved = function() {
                    return s.call(this._target());
                }, t.prototype.value = function() {
                    return n.call(this._target());
                }, t.prototype.reason = function() {
                    var t = this._target();
                    return t._unsetRejectionIsUnhandled(), r.call(t);
                }, t.prototype._value = function() {
                    return this._settledValue();
                }, t.prototype._reason = function() {
                    return this._unsetRejectionIsUnhandled(), this._settledValue();
                }, t.PromiseInspection = e;
            };
        }, {} ],
        20: [ function(t, e, n) {
            e.exports = function(s, c) {
                var l = t("./util"), u = l.errorObj, i = l.isObject, o = {}.hasOwnProperty;
                return function(t, e) {
                    if (i(t)) {
                        if (t instanceof s) return t;
                        var n = function(t) {
                            try {
                                return t.then;
                            } catch (t) {
                                return u.e = t, u;
                            }
                        }(t);
                        if (n === u) {
                            e && e._pushContext();
                            var r = s.reject(n.e);
                            return e && e._popContext(), r;
                        }
                        if ("function" == typeof n) return function(t) {
                            try {
                                return o.call(t, "_promise0");
                            } catch (t) {
                                return !1;
                            }
                        }(t) ? (r = new s(c), t._then(r._fulfill, r._reject, void 0, r, null), r) : function(t, e, n) {
                            var r = new s(c), i = r;
                            n && n._pushContext(), r._captureStackTrace(), n && n._popContext();
                            var o = !0, a = l.tryCatch(e).call(t, function(t) {
                                r && (r._resolveCallback(t), r = null);
                            }, function(t) {
                                r && (r._rejectCallback(t, o, !0), r = null);
                            });
                            return o = !1, r && a === u && (r._rejectCallback(a.e, !0, !0), r = null), i;
                        }(t, n, e);
                    }
                    return t;
                };
            };
        }, {
            "./util": 21
        } ],
        21: [ function(t, e, n) {
            function r() {
                try {
                    var t = u;
                    return u = null, t.apply(this, arguments);
                } catch (t) {
                    return h.e = t, h;
                }
            }
            function i(t) {
                return null == t || !0 === t || !1 === t || "string" == typeof t || "number" == typeof t;
            }
            function o(t, e, n) {
                if (i(t)) return t;
                var r = {
                    value: n,
                    configurable: !0,
                    enumerable: !1,
                    writable: !0
                };
                return p.defineProperty(t, e, r), t;
            }
            function a(t) {
                try {
                    return t + "";
                } catch (t) {
                    return "[no string representation]";
                }
            }
            function s(t) {
                return null !== t && "object" == (void 0 === t ? "undefined" : _typeof(t)) && "string" == typeof t.message && "string" == typeof t.name;
            }
            function c(t) {
                return s(t) && p.propertyIsWritable(t, "stack");
            }
            function l(t) {
                return {}.toString.call(t);
            }
            var u, p = t("./es5"), f = "undefined" == typeof navigator, h = {
                e: {}
            }, _ = "undefined" != typeof self ? self : "undefined" != typeof window ? window : "undefined" != typeof global ? global : void 0 !== this ? this : null, d = function() {
                var i = [ Array.prototype, Object.prototype, Function.prototype ], s = function(t) {
                    for (var e = 0; e < i.length; ++e) if (i[e] === t) return !0;
                    return !1;
                };
                if (p.isES5) {
                    var c = Object.getOwnPropertyNames;
                    return function(t) {
                        for (var e = [], n = Object.create(null); null != t && !s(t); ) {
                            var r;
                            try {
                                r = c(t);
                            } catch (t) {
                                return e;
                            }
                            for (var i = 0; i < r.length; ++i) {
                                var o = r[i];
                                if (!n[o]) {
                                    n[o] = !0;
                                    var a = Object.getOwnPropertyDescriptor(t, o);
                                    null != a && null == a.get && null == a.set && e.push(o);
                                }
                            }
                            t = p.getPrototypeOf(t);
                        }
                        return e;
                    };
                }
                var o = {}.hasOwnProperty;
                return function(t) {
                    if (s(t)) return [];
                    var e = [];
                    t: for (var n in t) if (o.call(t, n)) e.push(n); else {
                        for (var r = 0; r < i.length; ++r) if (o.call(i[r], n)) continue t;
                        e.push(n);
                    }
                    return e;
                };
            }(), v = /this\s*\.\s*\S+\s*=/, y = /^[a-z$_][a-z$_0-9]*$/i, g = "stack" in new Error() ? function(t) {
                return c(t) ? t : new Error(a(t));
            } : function(t) {
                if (c(t)) return t;
                try {
                    throw new Error(a(t));
                } catch (t) {
                    return t;
                }
            }, m = function(t) {
                return p.isArray(t) ? t : null;
            };
            if ("undefined" != typeof Symbol && Symbol.iterator) {
                var b = "function" == typeof Array.from ? function(t) {
                    return Array.from(t);
                } : function(t) {
                    for (var e, n = [], r = t[Symbol.iterator](); !(e = r.next()).done; ) n.push(e.value);
                    return n;
                };
                m = function(t) {
                    return p.isArray(t) ? t : null != t && "function" == typeof t[Symbol.iterator] ? b(t) : null;
                };
            }
            var C, w = "undefined" != typeof process && "[object process]" === l(process).toLowerCase(), k = {
                isClass: function(t) {
                    try {
                        if ("function" == typeof t) {
                            var e = p.names(t.prototype), n = p.isES5 && 1 < e.length, r = 0 < e.length && !(1 === e.length && "constructor" === e[0]), i = v.test(t + "") && 0 < p.names(t).length;
                            if (n || r || i) return !0;
                        }
                        return !1;
                    } catch (t) {
                        return !1;
                    }
                },
                isIdentifier: function(t) {
                    return y.test(t);
                },
                inheritedDataKeys: d,
                getDataPropertyOrDefault: function(t, e, n) {
                    if (!p.isES5) return {}.hasOwnProperty.call(t, e) ? t[e] : void 0;
                    var r = Object.getOwnPropertyDescriptor(t, e);
                    return null != r ? null == r.get && null == r.set ? r.value : n : void 0;
                },
                thrower: function(t) {
                    throw t;
                },
                isArray: p.isArray,
                asArray: m,
                notEnumerableProp: o,
                isPrimitive: i,
                isObject: function(t) {
                    return "function" == typeof t || "object" == (void 0 === t ? "undefined" : _typeof(t)) && null !== t;
                },
                isError: s,
                canEvaluate: f,
                errorObj: h,
                tryCatch: function(t) {
                    return u = t, r;
                },
                inherits: function(e, n) {
                    function t() {
                        for (var t in this.constructor = e, (this.constructor$ = n).prototype) r.call(n.prototype, t) && "$" !== t.charAt(t.length - 1) && (this[t + "$"] = n.prototype[t]);
                    }
                    var r = {}.hasOwnProperty;
                    return t.prototype = n.prototype, e.prototype = new t(), e.prototype;
                },
                withAppended: function(t, e) {
                    var n, r = t.length, i = new Array(r + 1);
                    for (n = 0; n < r; ++n) i[n] = t[n];
                    return i[n] = e, i;
                },
                maybeWrapAsError: function(t) {
                    return i(t) ? new Error(a(t)) : t;
                },
                toFastProperties: function(t) {
                    function e() {}
                    e.prototype = t;
                    for (var n = 8; n--; ) new e();
                    return t;
                },
                filledRange: function(t, e, n) {
                    for (var r = new Array(t), i = 0; i < t; ++i) r[i] = e + i + n;
                    return r;
                },
                toString: a,
                canAttachTrace: c,
                ensureErrorObject: g,
                originatesFromRejection: function(t) {
                    return null != t && (t instanceof Error.__BluebirdErrorTypes__.OperationalError || !0 === t.isOperational);
                },
                markAsOriginatingFromRejection: function(t) {
                    try {
                        o(t, "isOperational", !0);
                    } catch (t) {}
                },
                classString: l,
                copyDescriptors: function(t, e, n) {
                    for (var r = p.names(t), i = 0; i < r.length; ++i) {
                        var o = r[i];
                        if (n(o)) try {
                            p.defineProperty(e, o, p.getDescriptor(t, o));
                        } catch (t) {}
                    }
                },
                hasDevTools: "undefined" != typeof chrome && chrome && "function" == typeof chrome.loadTimes,
                isNode: w,
                env: function(t, e) {
                    return w ? process.env[t] : e;
                },
                global: _,
                getNativePromise: function() {
                    if ("function" == typeof Promise) try {
                        var t = new Promise(function() {});
                        if ("[object Promise]" === {}.toString.call(t)) return Promise;
                    } catch (t) {}
                },
                domainBind: function(t, e) {
                    return t.bind(e);
                }
            };
            k.isRecentNode = k.isNode && (0 === (C = process.versions.node.split(".").map(Number))[0] && 10 < C[1] || 0 < C[0]), 
            k.isNode && k.toFastProperties(process);
            try {
                throw new Error();
            } catch (t) {
                k.lastLineError = t;
            }
            e.exports = k;
        }, {
            "./es5": 10
        } ]
    }, {}, [ 3 ])(3);
}), "undefined" != typeof window && null !== window ? window.P = window.Promise : "undefined" != typeof self && null !== self && (self.P = self.Promise);