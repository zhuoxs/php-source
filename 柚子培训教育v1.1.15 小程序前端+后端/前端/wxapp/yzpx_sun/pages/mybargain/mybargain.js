var _extends = Object.assign || function(a) {
    for (var t = 1; t < arguments.length; t++) {
        var e = arguments[t];
        for (var i in e) Object.prototype.hasOwnProperty.call(e, i) && (a[i] = e[i]);
    }
    return a;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js");

function _defineProperty(a, t, e) {
    return t in a ? Object.defineProperty(a, t, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = e, a;
}

var app = getApp();

Page(_extends({}, _reload.reload, {
    data: {
        choose: 0,
        nav: [ {
            name: "我的参与",
            choose: !0
        }, {
            name: "我的购买",
            choose: !1
        } ],
        list: {
            load: !1,
            over: !1,
            page: 1,
            length: 10,
            data: []
        }
    },
    onLoad: function(a) {
        this.onloadData();
    },
    onloadData: function() {
        var t = this;
        this.checkUrl().then(function(a) {
            t.getListData();
        }).catch(function(a) {
            wx.showToast({
                title: a.msg,
                icon: "none",
                duration: 2e3
            });
        });
    },
    getListData: function() {
        var t = this;
        if (!this.data.list.over) {
            this.setData(_defineProperty({}, "list.load", !0));
            var e = {
                uid: wx.getStorageSync("userInfo").wxInfo.id,
                page: this.data.list.page,
                length: this.data.list.length,
                type: this.data.choose - 0 + 1
            };
            (0, _api.MyBargainData)(e).then(function(a) {
                t.dealList(a, e.page);
            });
        }
    },
    onReachBottom: function() {
        this.getListData();
    },
    onBargainTab: function(a) {
        var t = a.currentTarget.dataset.idx, e = this.data.list.data[t].course_info.id;
        this.navTo("../bargain/bargain?cid=" + e);
    },
    onOrderTab: function(a) {
        var t = a.currentTarget.dataset.idx, e = this.data.list.data[t].course_info.id, i = this.data.list.data[t].id;
        0 == this.data.choose ? this.navTo("../bargain/bargain?cid=" + e) : this.navTo("../order/order?bargain=1&id=" + i);
    },
    onNavTab: function(a) {
        var t = a.currentTarget.dataset.idx, e = this.data.nav;
        for (var i in e) {
            e[i = i - 0].choose = i === t;
        }
        this.setData({
            nav: e,
            choose: t,
            list: {
                load: !1,
                over: !1,
                page: 1,
                length: 10,
                data: []
            }
        }), this.getListData();
    }
}));