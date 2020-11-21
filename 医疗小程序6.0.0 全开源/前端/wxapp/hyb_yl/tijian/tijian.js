var app = getApp();

Page({
    data: {},
    onLoad: function(t) {
        var a = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: a
        });
    },
    onReady: function() {
        this.getBase(), this.getTijian_taocan_type(), this.getTijian_yiyuan();
    },
    getBase: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(t) {
                a.setData({
                    baseinfo: t.data.data
                }), wx.setNavigationBarTitle({
                    title: a.data.baseinfo.show_title
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    getTijian_taocan_type: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Tijian_taocan_type",
            success: function(t) {
                a.setData({
                    taocan_type: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    getTijian_yiyuan: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Tijian_yiyuan",
            cachetime: "30",
            success: function(t) {
                a.setData({
                    tijian_yiyuan: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    claimsClick: function() {
        wx.navigateTo({
            url: "/hyb_yl/patient/patient"
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        wx.showNavigationBarLoading(), setTimeout(function() {
            wx.hideNavigationBarLoading(), wx.stopPullDownRefresh();
        }, 1e3);
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    sjClick: function(t) {
        var a = t.currentTarget.dataset.tjt_id;
        wx.navigateTo({
            url: "tjxq/tjxq?tjt_id=" + a
        });
    },
    yyxqClick: function(t) {
        var a = t.currentTarget.dataset.ty_id;
        wx.navigateTo({
            url: "yyxq/yyxq?ty_id=" + a
        });
    },
    whyClick: function() {
        wx.navigateTo({
            url: "yychose/yychose"
        });
    }
});