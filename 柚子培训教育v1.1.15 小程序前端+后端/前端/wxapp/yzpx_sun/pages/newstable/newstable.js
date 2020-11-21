var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var e = arguments[a];
        for (var i in e) Object.prototype.hasOwnProperty.call(e, i) && (t[i] = e[i]);
    }
    return t;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js");

function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp();

Page(_extends({}, _reload.reload, {
    data: {
        nonePage: !1,
        list: {
            load: !1,
            over: !1,
            page: 1,
            length: 10,
            data: []
        }
    },
    onLoad: function(t) {
        t.sid ? this.setData({
            sid: t.sid
        }) : this.setData({
            sid: 0
        });
    },
    onloadData: function(t) {
        var a = this;
        t.detail.login && (this.setData({
            login: t.detail.login
        }), this.checkUrl().then(function(t) {
            a.getNavData();
        }).catch(function(t) {
            wx.showToast({
                title: t.msg,
                icon: "none",
                duration: 2e3
            });
        }));
    },
    getNavData: function() {
        var a = this, e = this;
        (0, _api.NewsclassifyData)({
            sid: this.data.sid
        }).then(function(t) {
            t.length < 1 ? (a.setData({
                nonePage: !0
            }), wx.showModal({
                title: "提示",
                content: "还没有新闻哦！",
                showCancel: !1,
                success: function(t) {
                    e.lunchTo("../home/home");
                }
            })) : (t[0].choose = !0, a.setData({
                nav: t,
                choose: 0
            }), a.getListData());
        });
    },
    getListData: function() {
        var a = this;
        if (!this.data.list.over) {
            this.setData(_defineProperty({}, "list.load", !0));
            var e = {
                cid: this.data.nav[this.data.choose].id,
                page: this.data.list.page,
                length: this.data.list.length,
                sid: this.data.sid
            };
            (0, _api.NewslistData)(e).then(function(t) {
                a.dealList(t, e.page);
            });
        }
    },
    onReachBottom: function() {
        this.getListData();
    },
    onNavTab: function(t) {
        var a = t.currentTarget.dataset.idx, e = this.data.nav;
        for (var i in e) {
            e[i = i - 0].choose = i === a;
        }
        this.setData({
            nav: e,
            choose: a,
            list: {
                load: !1,
                over: !1,
                page: 1,
                length: 10,
                data: []
            }
        }), this.getListData();
    },
    onNewsTab: function(t) {
        var a = t.currentTarget.dataset.idx, e = this.data.list.data[a].id;
        this.navTo("../news/news?nid=" + e);
    },
    onShareAppMessage: function(t) {
        return {
            title: "新闻列表",
            path: "/yzpx_sun/pages/newstable/newstable"
        };
    }
}));