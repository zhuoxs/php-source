var app = getApp();

Page({
    data: {
        analysisArr: []
    },
    onLoad: function(n) {
        var t = n.hzid, a = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: a
        }), this.setData({
            hzid: t,
            backgroundColor: a
        });
    },
    analysisResult: function(n) {
        var t = this.data.analysisArr.length, a = n.currentTarget.dataset.index, o = this.data.contrastArr;
        console.log(o, a);
        var e = JSON.stringify(o);
        wx.navigateTo({
            url: "/hyb_yl/analysis_result/analysis_result?length=" + t + "&index=" + a + "&str=" + e
        });
    },
    onReady: function() {
        this.getFenxi();
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    getFenxi: function() {
        var i = this, n = i.data.hzid;
        app.util.request({
            url: "entry/wxapp/Fenxi",
            data: {
                useropenid: wx.getStorageSync("openid"),
                hzid: n
            },
            success: function(n) {
                console.log(n);
                for (var t = n.data.data, a = i.data.analysisArr, o = 0, e = t.length; o < e; o++) a[o] = {}, 
                a[o].img = "../images/newimg/icon_21.png", a[o].title = t[o][0].title;
                i.setData({
                    contrastArr: t,
                    analysisArr: a
                });
            }
        });
    }
});