function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp(), WxParse = require("../../../wxParse/wxParse.js"), id_of_settimtout = null;

function changeList(t) {
    console.log(t);
    var s = new app.util.date();
    return t.forEach(function(t, a, e) {
        e[a].time = s.dateToStr("yyyy年MM月dd日/周W", new Date(app.look.change_date(t.start_time))), 
        t.end_time < s.dateToStr("yyyy-MM-dd HH:mm:ss") ? e[a].join_status = 3 : t.start_time > s.dateToStr("yyyy-MM-dd HH:mm:ss") ? e[a].join_status = 1 : e[a].join_status = 2;
    }), t;
}

function isToday(t) {
    var a = new app.util.date();
    return a.dateToStr("yyyy-MM-DD", a.longToDate(1e3 * t)) == a.dateToStr("yyyy-MM-DD");
}

Page({
    data: {
        curIndex: 0,
        apply: !1,
        page: 1,
        pagesize: 20,
        loadend: !1,
        list: [],
        registrationSuccess: !1
    },
    rule: function() {
        this.setData({
            srule: !0,
            shadow: !0
        });
    },
    toLog: function() {
        wx.navigateTo({
            url: "../sportCombat/sportCombat"
        });
    },
    submitGrade: function(t) {
        this.setData({
            submit: !0,
            shadow: !0,
            index: t.currentTarget.dataset.index
        });
    },
    close: function() {
        this.setData({
            submit: !1,
            srule: !1,
            shadow: !1,
            registrationSuccess: !1
        });
    },
    toSubmitGrade: function() {
        var e = this;
        console.log(this.data.list[this.data.index].id), console.log(this.data.step), app.util.request({
            url: "entry/wxapp/sport",
            showLoading: !0,
            method: "POST",
            data: {
                op: "sumbitGrade",
                chall_id: e.data.list[e.data.index].id,
                step: e.data.step
            },
            success: function(t) {
                var a;
                e.setData((_defineProperty(a = {}, "list[" + e.data.index + "].status", 3), _defineProperty(a, "list[" + e.data.index + "].finish_num", parseInt(e.data.list[e.data.index].finish_num) + 1), 
                _defineProperty(a, "submit", !1), _defineProperty(a, "shadow", !1), a)), wx.navigateTo({
                    url: "../sportGradeSuccess/sportGradeSuccess"
                });
            },
            fail: function(t) {
                app.look.no(t.data.message);
            }
        });
    },
    apply: function(t) {
        this.setData({
            apply: !0,
            index: t.currentTarget.dataset.index
        });
    },
    hideApply: function() {
        this.setData({
            apply: !1
        });
    },
    signApply: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/sport",
            showLoading: !0,
            method: "POST",
            data: {
                op: "signApply",
                chall_id: e.data.list[e.data.index].id,
                time: e.data.list[e.data.index].time
            },
            success: function(t) {
                var a;
                e.setData((_defineProperty(a = {
                    registrationSuccess: !0,
                    shadow: !0,
                    apply: !1
                }, "list[" + e.data.index + "].status", "2"), _defineProperty(a, "list[" + e.data.index + "].join_num", parseInt(e.data.list[e.data.index].join_num) + 1), 
                a));
            },
            fail: function(t) {
                app.look.no(t.data.message);
            }
        });
    },
    changeNav: function(t) {
        console.log(t);
        var e = this;
        clearTimeout(id_of_settimtout), this.setData({
            curIndex: t.currentTarget.dataset.index,
            list: []
        }), app.util.request({
            url: "entry/wxapp/sport",
            showLoading: !1,
            method: "POST",
            data: {
                op: "loadChall",
                step: e.data.chall[t.currentTarget.dataset.index],
                page: 1,
                pagesize: e.data.pagesize
            },
            success: function(t) {
                var a = t.data;
                a.data.list && (e.setData({
                    page: 1,
                    loadend: !1
                }), e.countDown(changeList(a.data.list), "start_time"));
            },
            fail: function(t) {
                app.look.alert(t.data.message), e.setData({
                    loadend: !0
                });
            }
        });
    },
    onLoad: function(t) {
        var e = this, a = wx.getStorageSync("weRunData");
        a && isToday(a.timestamp) ? this.setData({
            step: a.step
        }) : this.setData({
            step: 0
        }), app.util.request({
            url: "entry/wxapp/sport",
            showLoading: !1,
            method: "POST",
            data: {
                op: "getChallList"
            },
            success: function(t) {
                var a = t.data;
                a.data.list && (console.log(a.data.list), e.setData({
                    chall: a.data.list
                }), app.util.request({
                    url: "entry/wxapp/sport",
                    showLoading: !1,
                    method: "POST",
                    data: {
                        op: "loadChall",
                        step: a.data.list[0],
                        page: 1,
                        pagesize: e.data.pagesize
                    },
                    success: function(t) {
                        var a = t.data;
                        a.data.list && e.countDown(changeList(a.data.list), "start_time");
                    },
                    fail: function(t) {
                        app.look.alert(t.data.messge), e.setData({
                            loadend: !0
                        });
                    }
                }));
            }
        });
    },
    onReady: function() {
        app.look.sport_footer(this);
        var t = {};
        t.sport_warn = app.module_url + "resource/wxapp/sport/sport-warn.png", t.step_price = app.module_url + "resource/wxapp/sport/step-price.png", 
        t.sport_success2 = app.module_url + "resource/wxapp/sport/sport-success2.png", t.sport_success1 = app.module_url + "resource/wxapp/sport/sport-success1.png", 
        t.flag = app.module_url + "resource/wxapp/sport/flag.png", t.shield = app.module_url + "resource/wxapp/sport/shield.png", 
        t.trophy = app.module_url + "resource/wxapp/sport/trophy.png", this.setData({
            images: t
        }), WxParse.wxParse("article", "html", app.sportSet.rule, this, 10);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        if (!this.data.loadend) {
            var e = this;
            app.util.request({
                url: "entry/wxapp/sport",
                showLoading: !1,
                method: "POST",
                data: {
                    op: "getChallList"
                },
                success: function(t) {
                    var a = t.data;
                    a.data.list && (console.log(a.data.list), e.setData({
                        chall: a.data.list
                    }), app.util.request({
                        url: "entry/wxapp/sport",
                        showLoading: !1,
                        method: "POST",
                        data: {
                            op: "loadChall",
                            step: a.data.list[0],
                            page: e.data.page + 1,
                            pagesize: e.data.pagesize
                        },
                        success: function(t) {
                            var a = t.data;
                            a.data.list && (thats.setData({
                                page: e.data.page + 1
                            }), e.countDown(e.data.list.concat(changeList(a.data.list)), "start_time"));
                        },
                        fail: function(t) {
                            app.look.alert(t.data.messge), e.setData({
                                loadend: !0
                            });
                        }
                    }));
                }
            });
        }
    },
    countDown: function(t, a) {
        function e(t) {
            return t < 10 ? "0" + t : t;
        }
        for (var s = new Date().getTime(), o = 0, i = t.length; o < i; o++) if (1 == t[o].status && 1 == t[o].join_status) {
            var n = new Date(app.look.change_date(t[o][a])).getTime(), r = null;
            if (0 < n - s) {
                var p = (n - s) / 1e3, d = parseInt(p / 86400), l = parseInt(p / 3600), u = parseInt(p % 86400 / 3600), c = parseInt(p % 86400 % 3600 / 60), h = parseInt(p % 86400 % 3600 % 60);
                r = {
                    day: e(d),
                    talhou: e(l),
                    hou: e(u),
                    min: e(c),
                    sec: e(h)
                };
            } else r = {
                day: "00",
                hou: "00",
                talhou: "00",
                min: "00",
                sec: "00"
            }, t[o].join_status = 2;
            t[o].countDownArr = r;
        }
        this.setData({
            list: t
        });
        var g = this;
        id_of_settimtout = setTimeout(function() {
            g.countDown(g.data.list, a);
        }, 1e3);
    }
});