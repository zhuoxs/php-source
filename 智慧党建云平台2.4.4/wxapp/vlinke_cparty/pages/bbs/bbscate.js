var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var start_clientX, end_clientX, app = getApp();

Page({
    data: {
        catelist: [],
        catenav: [],
        slide: [],
        pindex: 1,
        psize: 20,
        hasMore: !0,
        list: [],
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
    onLoad: function(t) {
        var e = this, n = wx.getStorageSync("param") || null, a = wx.getStorageSync("user") || null;
        e.setData({
            param: n,
            user: a
        }), null == a && wx.redirectTo({
            url: "../login/login"
        });
        var i = a.scort;
        _request2.default.get("bbscate", {
            userscort: i
        }).then(function(t) {
            e.setData({
                cate1: t.cate1,
                cate2: t.cate2
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