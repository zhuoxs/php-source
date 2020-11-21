var app = getApp();

Page({
    data: {
        num: 0,
        light: "",
        kong: ""
    },
    onLoad: function(t) {
        var a = t.id;
        wx.setStorageSync("id", a), this.url();
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
    gozixun: function(t) {
        wx.navigateTo({
            url: "../consult/fufei?id=" + t.currentTarget.dataset.id
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this, t = wx.getStorageSync("id");
        app.util.request({
            url: "entry/wxapp/Nowlawyer",
            cachetime: "0",
            data: {
                id: t
            },
            success: function(t) {
                console.log(t.data), a.setData({
                    lawyerdetails: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});