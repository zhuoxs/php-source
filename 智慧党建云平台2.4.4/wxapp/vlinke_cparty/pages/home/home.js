var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp();

Page({
    data: {
        param: [],
        wxapphomenavrpx: 1,
        user: [],
        currentTab: 0,
        tabwidth: 1
    },
    getData: function() {
        var t = this, e = t.data.param.openhome, a = null == t.data.user ? 0 : t.data.user.id, n = null == t.data.user ? 0 : t.data.user.branchid;
        _request2.default.get("home", {
            op: "getdata",
            openhome: e,
            userid: a,
            branchid: n
        }).then(function(e) {
            t.setData({
                slide: e.slide,
                article: e.article,
                notice: e.notice,
                edulesson: e.edulesson,
                activity: e.activity,
                seritem: e.seritem,
                exapaper: e.exapaper
            });
        }, function(e) {
            wx.showModal({
                title: "提示",
                content: e,
                showCancel: !1,
                success: function(e) {
                    e.confirm && wx.reLaunch({
                        url: "../login/login"
                    });
                }
            }), console.log(e);
        });
    },
    onLoad: function(e) {
        var t = this;
        _request2.default.get("attachurl").then(function(e) {
            wx.setStorageSync("attachurl", e), t.setData({
                attachurl: e
            });
        }), _request2.default.get("home").then(function(e) {
            wx.setStorageSync("param", e.param), wx.setStorageSync("user", e.user), t.setData({
                param: e.param,
                user: null == e.user ? null : e.user,
                wxapphomenavrpx: 750 / e.param.wxapphomenav.number,
                tabwidth: 750 / e.param.wxapphomecon.length
            }), t.getData(), wx.setNavigationBarTitle({
                title: e.param.title
            }), app.tabBar = JSON.parse(e.param.wxappfootnav), app.util.footer(t);
        }, function(e) {
            wx.showModal({
                title: "提示",
                content: e,
                showCancel: !1,
                success: function(e) {
                    e.confirm && wx.reLaunch({
                        url: "home"
                    });
                }
            }), console.log(e);
        });
    },
    clickTab: function(e) {
        if (this.data.currentTab === e.target.dataset.current) return !1;
        this.setData({
            currentTab: e.target.dataset.current
        });
    },
    onReady: function() {},
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