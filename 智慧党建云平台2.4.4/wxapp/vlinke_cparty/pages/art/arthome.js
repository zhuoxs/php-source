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
    getMore: function() {
        var n = this;
        wx.showToast({
            title: "加载中",
            icon: "loading"
        });
        var t = n.data.pindex, e = n.data.psize;
        _request2.default.get("arthome", {
            op: "getmore",
            pindex: t,
            psize: e
        }).then(function(t) {
            var e = n.data.list;
            1 == n.data.pindex && (e = []);
            var a = t;
            a.length < n.data.psize ? n.setData({
                list: e.concat(a),
                hasMore: !1
            }) : n.setData({
                list: e.concat(a),
                hasMore: !0,
                pindex: n.data.pindex + 1
            }), wx.hideToast();
        });
    },
    onLoad: function(t) {
        var e = this, a = wx.getStorageSync("param") || null, n = wx.getStorageSync("user") || null;
        e.setData({
            param: a,
            user: n
        }), 0 == a.openart && null == n && wx.redirectTo({
            url: "../login/login"
        }), _request2.default.get("arthome").then(function(t) {
            e.setData({
                catelist: t.catelist,
                catenav: t.catenav,
                slide: t.slide
            }), e.getMore();
        }, function(t) {
            wx.showModal({
                title: "提示信息",
                content: t,
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.redirectTo({
                        url: "../art/arthome"
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
    onPullDownRefresh: function() {
        this.data.pindex = 1, this.getMore();
    },
    onReachBottom: function() {
        this.data.hasMore ? this.getMore() : wx.showToast({
            title: "没有更多数据"
        });
    },
    onShareAppMessage: function() {
        return {
            title: this.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: this.data.param.wxappshareimageurl
        };
    }
});