var app = getApp();

Page({
    data: {},
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), console.log(t), a.url(), app.util.request({
            url: "entry/wxapp/ansData",
            cachetime: "0",
            data: {
                pid: t.pid,
                mid: t.mid,
                fid: t.fid
            },
            success: function(t) {
                a.setData({
                    answer: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/queslawyer",
            cachetime: "0",
            data: {
                pid: t.pid,
                mid: t.mid,
                fid: t.fid
            },
            success: function(t) {
                console.log(t.data), a.setData({
                    qulawyer: t.data
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
    goQuestion: function(t) {
        console.log(t), wx.navigateTo({
            url: "../consult/fufei?id=" + t.currentTarget.dataset.id
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