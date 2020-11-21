var t = function(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}(require("../../util/request.js")), a = getApp();

Page({
    data: {
        param: [],
        wxapphomenavrpx: 1,
        user: [],
        currentTab: 0,
        tabwidth: 1
    },
    getData: function() {
        var a = this, e = a.data.param.openhome, n = null == a.data.user ? 0 : a.data.user.id, r = null == a.data.user ? 0 : a.data.user.branchid;
        t.default.get("home", {
            op: "getdata",
            openhome: e,
            userid: n,
            branchid: r
        }).then(function(t) {
            a.setData({
                slide: t.slide,
                article: t.article,
                notice: t.notice,
                edulesson: t.edulesson,
                activity: t.activity,
                seritem: t.seritem
            });
        }, function(t) {
            wx.showModal({
                title: "提示",
                content: t,
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.reLaunch({
                        url: "../login/login"
                    });
                }
            }), console.log(t);
        });
    },
    onLoad: function(a) {
        var e = this;
        t.default.get("attachurl").then(function(t) {
            wx.setStorageSync("attachurl", t), e.setData({
                attachurl: t
            });
        }), t.default.get("home").then(function(t) {
            wx.setStorageSync("param", t.param), wx.setStorageSync("user", t.user), e.setData({
                param: t.param,
                user: null == t.user ? null : t.user,
                wxapphomenavrpx: 750 / t.param.wxapphomenav.number,
                tabwidth: 750 / t.param.wxapphomecon.length
            }), e.getData();
        }, function(t) {
            wx.showModal({
                title: "提示",
                content: t,
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.reLaunch({
                        url: "home"
                    });
                }
            }), console.log(t);
        });
    },
    clickTab: function(t) {
        var a = this;
        if (this.data.currentTab === t.target.dataset.current) return !1;
        a.setData({
            currentTab: t.target.dataset.current
        });
    },
    onReady: function() {
        a.util.footer(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var t = this;
        return {
            title: t.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: t.data.param.wxappshareimageurl
        };
    }
});