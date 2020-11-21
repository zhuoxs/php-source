var app = getApp();

Page({
    data: {},
    onLoad: function(a) {
        var t = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: t
        });
        var i = a.ty_id;
        this.getTijian_yiyuanxq(i), this.getTijian_yiyuantaocanlist(i);
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        wx.showNavigationBarLoading(), setTimeout(function() {
            wx.hideNavigationBarLoading(), wx.stopPullDownRefresh();
        }, 1e3);
        var a = data.ty_id;
        this.getTijian_yiyuanxq(a);
    },
    getTijian_yiyuanxq: function(a) {
        var t = this;
        console.log(app), app.util.request({
            url: "entry/wxapp/Tijian_yiyuanxq",
            data: {
                ty_id: a
            },
            cachetime: "30",
            success: function(a) {
                t.setData({
                    tijian_yiyuanxq: a.data.data
                }), wx.setNavigationBarTitle({
                    title: t.data.tijian_yiyuanxq.ty_name
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    getTijian_yiyuantaocanlist: function(a) {
        var t = this;
        console.log(app), app.util.request({
            url: "entry/wxapp/Tijian_yiyuantaocanlist",
            data: {
                ty_id: a
            },
            cachetime: "30",
            success: function(a) {
                t.setData({
                    tijian_yiyuantaocanxq: a.data.data
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    tjxqClick: function(a) {
        var t = a.currentTarget.dataset.tt_id, i = a.currentTarget.dataset.ty_id;
        wx.navigateTo({
            url: "../tcxq/tcxq?tt_id=" + t + "&ty_id=" + i
        });
    },
    mapClick: function() {
        this.openMap();
    },
    openMap: function(a) {
        var t = this;
        wx.openLocation({
            latitude: parseFloat(t.data.tijian_yiyuanxq.latitude),
            longitude: parseFloat(t.data.tijian_yiyuanxq.longitude),
            address: t.data.tijian_yiyuanxq.ty_address,
            scale: 22
        });
    }
});