var app = getApp();

Page({
    data: {
        news: !0
    },
    onLoad: function(a) {
        this.setData({
            quickCheck: app.globalData.quickCheck,
            getfutj: app.globalData.getfutj
        });
    },
    searchClick: function() {
        wx.navigateTo({
            url: "/hyb_yl/search/search"
        });
    },
    checkClick: function(a) {
        var t = a.currentTarget.dataset.gId, n = a.currentTarget.dataset.data, e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Addhistory",
            data: {
                pid: t,
                openid: e
            },
            success: function(a) {
                wx.navigateTo({
                    url: "/hyb_yl/check/check?id=" + t + "&title=" + n
                });
            }
        });
    },
    moreClick: function() {
        wx.navigateTo({
            url: "/hyb_yl/more/more"
        });
    },
    historyClick: function() {
        wx.navigateTo({
            url: "/hyb_yl/history/history"
        });
    },
    tijianDetail: function(a) {
        var t = a.currentTarget.dataset.f_id;
        wx.navigateTo({
            url: "/hyb_yl/tijian_detail/tijian_detail?f_id=" + t
        });
    },
    onReady: function() {
        this.getBase(), this.getZhuanjia();
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    getBase: function() {
        var n = this;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(a) {
                var t = a.data.data.ztcolor;
                n.setData({
                    bq_thumb: a.data.data.bq_thumb,
                    bq_name: a.data.data.bq_name
                }), wx.setNavigationBarColor({
                    frontColor: "#ffffff",
                    backgroundColor: t
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    getZhuanjia: function() {
        var o = this;
        app.util.request({
            url: "entry/wxapp/zhuanjia",
            cachetime: "0",
            success: function(a) {
                for (var e = a.data.data, t = [], n = 0; n < e.length; n++) {
                    var i = e[n].openid;
                    t.push(i);
                }
                app.util.request({
                    url: "entry/wxapp/Alldcouid",
                    data: {
                        nArr: t
                    },
                    success: function(a) {
                        for (var t = a.data.data, n = 0; n < t.length; n++) Object.assign(e[n], t[n]);
                        o.setData({
                            zhuanjia: e
                        });
                    }
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    getTjyzfw: function() {},
    tjdoc: function(a) {
        console.log(a);
        var t = a.currentTarget.dataset.id, n = a.currentTarget.dataset.u_id;
        wx.navigateTo({
            url: "/hyb_yl/zhuanjiazhuye/zhuanjiazhuye?id=" + t + "&u_id=" + n
        });
    }
});