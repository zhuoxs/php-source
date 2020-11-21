var app = getApp();

Page({
    data: {
        current: 0
    },
    radioChange: function(t) {
        console.log("radio发生change事件，携带value值为：", t.detail.value);
    },
    consultDetails: function(t) {
        t.currentTarget.dataset.pid && wx.navigateTo({
            url: "../consult/details?pid=" + t.currentTarget.dataset.pid
        }), t.currentTarget.dataset.mid && wx.navigateTo({
            url: "../consult/details?mid=" + t.currentTarget.dataset.mid
        }), t.currentTarget.dataset.fid && wx.navigateTo({
            url: "../consult/details?fid=" + t.currentTarget.dataset.fid
        });
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), a.url(), app.util.request({
            url: "entry/wxapp/anliData",
            cachetime: "0",
            success: function(t) {
                a.setData({
                    anliData: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Wellanswer",
            cachetime: "0",
            success: function(t) {
                a.setData({
                    well: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Wellpay",
            cachetime: "0",
            success: function(t) {
                console.log(t.data), a.setData({
                    paywell: t.data
                });
            }
        });
    },
    inputFocus: function(t) {
        this.setData({
            keyword: t.detail.value
        });
    },
    toSearch: function(t) {
        var a = this, e = a.data.keyword;
        "" == e || null == e ? wx.showToast({
            title: "请输入关键词",
            icon: "none"
        }) : app.util.request({
            url: "entry/wxapp/keywordData",
            cachetime: "0",
            data: {
                keyword: e
            },
            success: function(t) {
                a.setData({
                    well: t.data.well,
                    paywell: t.data.paywell
                });
            }
        });
    },
    url: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Url2",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url2", t.data);
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
    },
    goFenLei: function(t) {
        wx.navigateTo({
            url: "../anli/fenlei?id=" + t.currentTarget.dataset.id + "&&title=" + t.currentTarget.dataset.title
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});