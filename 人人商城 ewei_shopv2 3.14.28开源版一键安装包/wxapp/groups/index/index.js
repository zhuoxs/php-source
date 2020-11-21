var n = getApp(), t = n.requirejs("core");

n.requirejs("jquery"), n.requirejs("foxui");

Page({
    onPullDownRefresh: function() {
        var n = this;
        t.get("groups", {}, function(t) {
            0 == t.error && (n.setData({
                res: t
            }), wx.stopPullDownRefresh());
        });
    },
    data: {},
    onLoad: function(e) {
        var a = this;
        n.getCache("isIpx") ? a.setData({
            isIpx: !0,
            iphonexnavbar: "fui-iphonex-navbar"
        }) : a.setData({
            isIpx: !1,
            iphonexnavbar: ""
        }), t.get("groups", {}, function(n) {
            a.setData({
                res: n
            });
        });
    },
    advheight: function(n) {
        var t = this, e = n.detail.width / n.detail.height;
        t.setData({
            advheight: 750 / e
        });
    },
    navigate: function(n) {
        var e = t.pdata(n).link;
        wx.navigateTo({
            url: e,
            fail: function() {
                wx.switchTab({
                    url: e
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onReachBottom: function() {
        this.onPullDownRefresh();
    },
    onShareAppMessage: function() {}
});