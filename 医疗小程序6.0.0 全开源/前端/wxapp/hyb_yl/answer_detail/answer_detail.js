var app = getApp();

Page({
    data: {
        answerArr: []
    },
    onLoad: function(n) {
        var a = this, t = n.p_id, e = wx.getStorageSync("openid"), i = n.user_openid;
        a.setData({
            user_openid: i,
            id: t,
            openid: e
        }), app.util.request({
            url: "entry/wxapp/Zhuanjiaxiangqing",
            data: {
                id: t
            },
            success: function(n) {
                console.log(n), a.setData({
                    xiangqing: n.data.data
                });
            },
            fail: function(n) {}
        });
    },
    onReady: function() {
        this.getSelecthzq(), this.getBase();
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    getSelecthzq: function() {
        var a = this, n = a.data.user_openid, t = a.data.id;
        app.util.request({
            url: "entry/wxapp/Selethzq",
            data: {
                user_openid: n,
                zid: t
            },
            success: function(n) {
                console.log(n), a.setData({
                    answerArr: n.data.data
                });
            }
        });
    },
    index: function() {
        wx.reLaunch({
            url: "/hyb_yl/index/index"
        });
    },
    doc: function() {
        var n = wx.getStorageSync("openid"), a = this.data.id;
        wx.navigateTo({
            url: "/hyb_yl/zhuanjiatiwen/zhuanjiatiwen?id=" + a + "&openid=" + n
        });
    },
    getBase: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(n) {
                a.setData({
                    base: n.data.data
                });
            },
            fail: function(n) {}
        });
    }
});