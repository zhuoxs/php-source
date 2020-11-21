var app = getApp(), WxParse = require("../wxParse/wxParse.js");

Page({
    data: {
        current: ""
    },
    onLoad: function(t) {
        var a = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: a
        }), this.setData({
            backgroundColor: a
        });
    },
    nextClick: function(t) {
        console.log(t);
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "/hyb_yl/record_2/record_2?con=" + t.currentTarget.dataset.con + "&id=" + a
        });
    },
    onReady: function() {
        this.getBase(), this.getCategoryf1();
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    getBase: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(t) {
                a.setData({
                    baseinfo: t.data.data
                }), WxParse.wxParse("articles", "html", t.data.data.yy_content, a, 5);
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    getCategoryf1: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Categoryf1",
            success: function(t) {
                console.log(t), a.setData({
                    items: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    }
});