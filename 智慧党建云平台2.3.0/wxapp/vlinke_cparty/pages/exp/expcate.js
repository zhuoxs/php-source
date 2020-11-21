var t = function(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}(require("../../util/request.js")), e = getApp();

Page({
    data: {
        pindex: 1,
        psize: 50,
        hasMore: !0,
        list: []
    },
    getMore: function() {
        var e = this;
        wx.showToast({
            title: "加载中",
            icon: "loading"
        });
        var a = e.data.user.id, n = e.data.pindex, i = e.data.psize;
        t.default.get("expcate", {
            op: "getmore",
            userid: a,
            pindex: n,
            psize: i
        }).then(function(t) {
            var a = e.data.list;
            1 == e.data.pindex && (a = []);
            var n = t;
            n.length < e.data.psize ? e.setData({
                list: a.concat(n),
                hasMore: !1
            }) : e.setData({
                list: a.concat(n),
                hasMore: !0,
                pindex: e.data.pindex + 1
            }), wx.hideToast();
        });
    },
    onLoad: function(t) {
        var e = this, a = wx.getStorageSync("param") || null, n = wx.getStorageSync("user") || null;
        e.setData({
            param: a,
            user: n
        }), null == n && wx.redirectTo({
            url: "../login/login"
        }), e.getMore();
    },
    onReady: function() {
        e.util.footer(this);
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