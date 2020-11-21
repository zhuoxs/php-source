var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var start_clientX, end_clientX, app = getApp();

Page({
    data: {
        cateid: 0,
        catelist: [],
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
        var i = this;
        wx.showToast({
            title: "加载中",
            icon: "loading"
        });
        var t = i.data.user.id, e = i.data.cateid, a = i.data.stustatus, n = i.data.pindex, s = i.data.psize;
        _request2.default.get("educate", {
            op: "getmore",
            userid: t,
            cateid: e,
            stustatus: a,
            pindex: n,
            psize: s
        }).then(function(t) {
            var e = i.data.list;
            1 == i.data.pindex && (e = []);
            var a = t;
            a.length < i.data.psize ? i.setData({
                list: e.concat(a),
                hasMore: !1
            }) : i.setData({
                list: e.concat(a),
                hasMore: !0,
                pindex: i.data.pindex + 1
            }), wx.hideToast();
        });
    },
    onLoad: function(t) {
        var e = this, a = wx.getStorageSync("param"), i = wx.getStorageSync("user");
        e.setData({
            param: a,
            user: i
        }), null == i && wx.redirectTo({
            url: "../login/login"
        });
        var n = t.cateid, s = t.stustatus;
        e.setData({
            cateid: n
        }), e.setData({
            stustatus: s
        }), e.getMore(), _request2.default.get("educate").then(function(t) {
            e.setData({
                catelist: t.catelist
            }), e.getMore();
        }, function(t) {
            wx.showModal({
                title: "提示信息",
                content: t,
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.redirectTo({
                        url: "../ser/serhome"
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