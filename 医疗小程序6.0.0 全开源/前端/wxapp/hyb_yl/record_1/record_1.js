var app = getApp(), WxParse = require("../wxParse/wxParse.js");

Page({
    data: {
        current: "",
        none: [ {
            img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/微信图片_20180727121929.png",
            con: "暂无信息"
        } ]
    },
    onLoad: function(o) {
        var t = JSON.parse(o.obj);
        console.log(t);
        var a = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: a
        }), this.setData({
            val: t,
            backgroundColor: a
        });
    },
    nextClick: function(o) {
        console.log(o);
        var t = JSON.stringify(this.data.val), a = o.currentTarget.dataset.id;
        console.log(t), wx.navigateTo({
            url: "/hyb_yl/record_2/record_2?con=" + o.currentTarget.dataset.con + "&id=" + a + "&val=" + t
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
        var t = this;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(o) {
                t.setData({
                    baseinfo: o.data.data
                }), WxParse.wxParse("articles", "html", o.data.data.yy_content, t, 5);
            },
            fail: function(o) {
                console.log(o);
            }
        });
    },
    getCategoryf1: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Categoryf1",
            success: function(o) {
                console.log(o), t.setData({
                    items: o.data.data
                });
            },
            fail: function(o) {
                console.log(o);
            }
        });
    }
});