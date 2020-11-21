var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var start_clientX, end_clientX, app = getApp();

Page({
    data: {
        id: 0,
        uzan: 0,
        ucollect: 0,
        replypost: !0,
        replydetails: "",
        windowWidth: wx.getSystemInfoSync().windowWidth
    },
    touchstart: function(t) {
        start_clientX = t.changedTouches[0].clientX;
    },
    touchend: function(t) {
        120 < (end_clientX = t.changedTouches[0].clientX) - start_clientX ? this.setData({
            display: "block",
            translate: "transform: translateX(" + .7 * this.data.windowWidth + "px); position: fixed; z-index: 1;"
        }) : 0 < start_clientX - end_clientX && this.setData({
            display: "none",
            translate: ""
        });
    },
    showview: function() {
        this.setData({
            display: "block",
            translate: "transform: translateX(" + .7 * this.data.windowWidth + "px); position: fixed; z-index: 1;"
        });
    },
    hideview: function() {
        this.setData({
            display: "none",
            translate: ""
        });
    },
    clickCollect: function(t) {
        var e = this, a = e.data.id, n = e.data.user.id;
        _request2.default.get("bbstopic", {
            op: "clickcollect",
            id: a,
            userid: n
        }).then(function(t) {
            e.setData({
                ucollect: t.ucollect
            });
        });
    },
    clickZan: function(t) {
        var e = this, a = e.data.id, n = e.data.user.id;
        _request2.default.get("bbstopic", {
            op: "clickzan",
            id: a,
            userid: n
        }).then(function(t) {
            e.setData({
                zanarr: t.zanarr,
                zantol: t.zantol,
                uzan: t.uzan
            });
        });
    },
    clickReply: function(t) {
        this.setData({
            replypost: !1
        });
    },
    replyClose: function(t) {
        this.setData({
            replypost: !0
        });
    },
    replyPost: function(t) {
        var e = this, a = e.data.id, n = e.data.user.id, i = t.detail.value.details;
        _request2.default.get("bbstopic", {
            op: "replypost",
            id: a,
            userid: n,
            details: i
        }).then(function(t) {
            e.setData({
                replypost: !0,
                replydetails: "",
                replyarr: t.replyarr,
                replytol: t.replytol
            });
        }, function(t) {
            wx.showModal({
                title: "提示信息",
                content: t,
                showCancel: !1,
                success: function(t) {}
            });
        });
    },
    replyDelete: function(t) {
        var e = this, a = e.data.user.id, n = t.currentTarget.dataset.replyid;
        _request2.default.get("bbstopic", {
            op: "replydelete",
            userid: a,
            replyid: n
        }).then(function(t) {
            e.setData({
                replyarr: t.replyarr,
                replytol: t.replytol
            });
        }, function(t) {
            wx.showModal({
                title: "提示信息",
                content: t,
                showCancel: !1,
                success: function(t) {}
            });
        });
    },
    onLoad: function(t) {
        var e = this, a = wx.getStorageSync("param") || null, n = wx.getStorageSync("user") || null;
        e.setData({
            param: a,
            user: n
        }), null == n && wx.redirectTo({
            url: "../login/login"
        });
        var i = parseInt(t.id);
        e.setData({
            id: i
        });
        var o = n.id;
        _request2.default.get("bbstopic", {
            id: i,
            userid: o
        }).then(function(t) {
            e.setData({
                topic: t.topic,
                zanarr: t.zanarr,
                zantol: t.zantol,
                uzan: t.uzan,
                replyarr: t.replyarr,
                replytol: t.replytol,
                ucollect: t.ucollect
            });
        }, function(t) {
            wx.showModal({
                title: "提示信息",
                content: t,
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.redirectTo({
                        url: "../bbs/bbshome"
                    });
                }
            });
        });
    },
    onReady: function() {
        app.util.footer(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        return {
            title: this.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: this.data.param.wxappshareimageurl
        };
    }
});