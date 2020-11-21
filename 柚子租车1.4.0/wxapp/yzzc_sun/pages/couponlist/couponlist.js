var _extends = Object.assign || function(t) {
    for (var e = 1; e < arguments.length; e++) {
        var a = arguments[e];
        for (var o in a) Object.prototype.hasOwnProperty.call(a, o) && (t[o] = a[o]);
    }
    return t;
}, _reload = require("../../common/js/reload.js"), _api = require("../../common/js/api.js");

function _defineProperty(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

var app = getApp();

function timestampToTime(t) {
    var e = new Date(1e3 * t);
    return e.getFullYear() + "-" + ((e.getMonth() + 1 < 10 ? "0" + (e.getMonth() + 1) : e.getMonth() + 1) + "-") + e.getDate();
}

Page(_extends({}, _reload.reload, {
    data: {
        show: !1,
        list: {
            load: !1,
            over: !1,
            page: 1,
            length: 10,
            none: !1,
            data: []
        },
        isShare: !1,
        showHome: !1
    },
    onLoad: function(t) {
        var e = getCurrentPages();
        null == e[e.length - 2] && this.setData({
            showHome: !0
        });
    },
    onloadData: function(t) {
        var e = this;
        t.detail.login && (this.setData({
            show: !0
        }), this.checkUrl().then(function(t) {
            e.getListData();
        }).catch(function(t) {
            -1 === t.code ? e.tips(t.msg) : e.tips("false");
        }));
    },
    getListData: function() {
        var o = this;
        if (!this.data.list.over) {
            this.setData(_defineProperty({}, "list.load", !0));
            var i = {
                page: this.data.list.page,
                length: this.data.list.length,
                uid: wx.getStorageSync("userInfo").wxInfo.id
            };
            (0, _api.CouponListData)(i).then(function(t) {
                var e = t;
                for (var a in e) e[a].createtime = timestampToTime(e[a].createtime), e[a].start_time = timestampToTime(e[a].start_time), 
                e[a].end_time = timestampToTime(e[a].end_time);
                o.dealList(e, i.page);
            }).catch(function(t) {
                -1 == t.code ? o.tips(t.msg) : o.tips("false");
            });
        }
    },
    onReachBottom: function() {
        this.getListData();
    },
    onGetTab: function(t) {
        var e = t.currentTarget.dataset.idx, a = this.data.list.data[e];
        this.setData({
            choose: a,
            chooseIdx: e
        }), "2" !== a.limit || this.data.isShare ? this.onReceiveTab() : wx.showModal({
            content: "点击右上角将小程序分享至微信即可领取优惠券！",
            showCancel: !1,
            confirmText: "朕知道了",
            success: function(t) {
                t.confirm ? console.log("用户点击确定") : t.cancel && console.log("用户点击取消");
            }
        });
    },
    onReceiveTab: function() {
        var e = this, t = {
            uid: wx.getStorageSync("userInfo").wxInfo.id,
            cid: this.data.choose.id
        };
        (0, _api.GetCouponData)(t).then(function(t) {
            wx.showToast({
                title: "领取成功！",
                icon: "none",
                duration: 1e3
            }), e.setData(_defineProperty({}, "list.data[" + e.data.chooseIdx + "].isget", 1));
        }, function(t) {
            wx.showToast({
                title: t.msg,
                icon: "none",
                duration: 1e3
            });
        });
    },
    onHomeTab: function() {
        this.lunchTo("/yzzc_sun/pages/home/home");
    },
    onShareAppMessage: function() {
        return this.setData({
            isShare: !0
        }), {
            title: "优惠券",
            path: "/yzzc_sun/pages/couponlist/couponlist"
        };
    }
}));