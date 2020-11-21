var app = getApp();

Page({
    data: {
        navIndex: 0,
        playBtn: !1,
        shopNum: ""
    },
    onLoad: function(t) {
        var e = wx.getStorageSync("url");
        this.setData({
            url: e
        }), t.navIndex && this.setData({
            navIndex: t.navIndex
        });
    },
    onShow: function() {
        var e = this, t = wx.getStorageSync("bid");
        app.util.request({
            url: "entry/wxapp/buildkeepwineData",
            cachetime: "0",
            data: {
                bid: t
            },
            success: function(t) {
                console.log(t.data), e.setData({
                    Dkeep: t.data.Dkeep,
                    Ykeep: t.data.Ykeep,
                    extwine: t.data.extwine
                });
            }
        });
    },
    changeNav: function(t) {
        var e = t.currentTarget.dataset.index;
        this.setData({
            navIndex: e
        });
    },
    confirm: function(t) {
        var e = this, a = t.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/delivery",
            cachetime: "0",
            data: {
                id: a
            },
            success: function(t) {
                console.log(t.data), 1 == t.data ? (wx.showToast({
                    title: "确认存酒成功",
                    icon: "success",
                    duration: 2e3
                }), e.onShow()) : wx.showToast({
                    title: "确认存酒失败",
                    icon: "none",
                    duration: 2e3
                });
            }
        });
    },
    deleteList: function() {
        var t = this, e = t.data.deleteBtn, a = t.data.list2Index, n = t.data.Ykeep;
        1 == e && (n.splice(a, 1), t.setData({
            Ykeep: n
        }), t.onShow());
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});