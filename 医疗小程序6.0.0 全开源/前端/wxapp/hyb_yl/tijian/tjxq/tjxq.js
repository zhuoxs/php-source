var app = getApp();

Page({
    data: {
        yiyuanList: [ {
            id: 0,
            yytitle: "北京同仁医院亦庄院区同仁医院亦庄院区",
            num: 8,
            money: 63536
        }, {
            id: 1,
            yytitle: "北京同仁医院亦庄院区同仁医院亦庄院区",
            num: 8,
            money: 63536
        }, {
            id: 2,
            yytitle: "北京同仁医院亦庄院区同仁医院亦庄院区",
            num: 8,
            money: 63536
        }, {
            id: 3,
            yytitle: "北京同仁医院亦庄院区同仁医院亦庄院区",
            num: 8,
            money: 63536
        } ]
    },
    onLoad: function(t) {
        var a = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: a
        });
        var i = t.tjt_id;
        this.getTijian_taocan_typexq(i), this.getTijian_taocan_typexqs(i), this.getTijian_taocan_yiyuanlist(i);
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        wx.showNavigationBarLoading(), setTimeout(function() {
            wx.hideNavigationBarLoading(), wx.stopPullDownRefresh();
        }, 1e3);
        var t = data.tjt_id;
        this.getTijian_taocan_typexq(t), this.getTijian_taocan_typexqs(t), this.getTijian_taocan_yiyuanlist(t);
    },
    getTijian_taocan_typexq: function(t) {
        var a = this;
        console.log(app), app.util.request({
            url: "entry/wxapp/Tijian_taocan_typexq",
            data: {
                tjt_id: t
            },
            cachetime: "30",
            success: function(t) {
                a.setData({
                    tc_typexq: t.data.data
                }), wx.setNavigationBarTitle({
                    title: a.data.tc_typexq.type
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    getTijian_taocan_typexqs: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Tijian_taocan_typexqs",
            data: {
                tjt_id: t
            },
            success: function(t) {
                a.setData({
                    tc_typexqs: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    getTijian_taocan_yiyuanlist: function(t) {
        var a = this;
        console.log(app), app.util.request({
            url: "entry/wxapp/Tijian_taocan_yiyuanlist",
            data: {
                tjt_id: t
            },
            cachetime: "30",
            success: function(t) {
                a.setData({
                    tc_yylist: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    tjxqClick: function(t) {
        var a = t.currentTarget.dataset.tt_id, i = t.currentTarget.dataset.ty_id;
        wx.navigateTo({
            url: "../tcxq/tcxq?tt_id=" + a + "&ty_id=" + i
        });
    }
});