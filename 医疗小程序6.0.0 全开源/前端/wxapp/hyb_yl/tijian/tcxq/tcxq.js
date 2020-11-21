var app = getApp(), WxParse = require("../../wxParse/wxParse.js");

Page({
    data: {
        ty_id: ""
    },
    onLoad: function(a) {
        var t = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: t
        });
        var i = a.tt_id;
        a.ty_id;
        this.setData({
            ty_id: a.ty_id
        });
        a.ty_id;
        this.getTijian_yiyuantaocanxq(i), this.getTijian_yiyuantaocan(i);
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        wx.showNavigationBarLoading(), setTimeout(function() {
            wx.hideNavigationBarLoading(), wx.stopPullDownRefresh();
        }, 1e3);
        var a = data.tt_id;
        this.getTijian_yiyuantaocanxq(a), this.getTijian_yiyuantaocan(a);
    },
    getTijian_yiyuantaocanxq: function(a) {
        var t = this;
        console.log(app), app.util.request({
            url: "entry/wxapp/Tijian_yiyuantaocanxq",
            data: {
                tt_id: a
            },
            cachetime: "30",
            success: function(a) {
                t.setData({
                    tijian_taocanxq: a.data.data
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    getTijian_yiyuantaocan: function(a) {
        var t = this;
        console.log(app), app.util.request({
            url: "entry/wxapp/Tijian_yiyuantaocan",
            data: {
                tt_id: a
            },
            cachetime: "30",
            success: function(a) {
                t.setData({
                    tijian_taocan: a.data.data
                }), WxParse.wxParse("article", "html", a.data.data.tt_tongzhi, t, 5);
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    yyClick: function(a) {
        var t = a.currentTarget.dataset.tt_id, i = a.currentTarget.dataset.ty_id;
        wx.navigateTo({
            url: "../yybianji/yybianji?tt_id=" + t + "&ty_id=" + i
        });
    }
});