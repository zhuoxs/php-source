var t = function(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}(require("../../util/request.js")), a = getApp();

Page({
    data: {
        pindex: 1,
        psize: 20,
        hasMore: !0,
        list: []
    },
    getMore: function() {
        var a = this;
        wx.showToast({
            title: "加载中",
            icon: "loading"
        });
        var e = a.data.user.branchid, n = a.data.pindex, i = a.data.psize;
        t.default.get("notice", {
            op: "getmore",
            branchid: e,
            pindex: n,
            psize: i
        }).then(function(t) {
            var e = a.data.list;
            1 == a.data.pindex && (e = []);
            var n = t;
            n.length < a.data.psize ? a.setData({
                list: e.concat(n),
                hasMore: !1
            }) : a.setData({
                list: e.concat(n),
                hasMore: !0,
                pindex: a.data.pindex + 1
            }), wx.hideToast();
        });
    },
    onLoad: function(t) {
        var a = this, e = wx.getStorageSync("param") || null, n = wx.getStorageSync("user") || null;
        a.setData({
            param: e,
            user: n
        }), null == n && wx.redirectTo({
            url: "../login/login"
        }), a.getMore();
    },
    onReady: function() {
        a.util.footer(this);
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
        var t = this;
        return {
            title: t.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: t.data.param.wxappshareimageurl
        };
    }
});