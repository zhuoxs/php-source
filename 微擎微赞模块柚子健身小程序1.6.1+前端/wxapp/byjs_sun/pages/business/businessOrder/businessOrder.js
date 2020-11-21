var app = getApp();

Page({
    data: {
        goId: 1,
        yy_money: ""
    },
    onLoad: function(t) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        });
        app.util.request({
            url: "entry/wxapp/OrderBusiness",
            data: {
                goId: 1
            },
            cachetime: 0,
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/GetYymoney",
                    cachetime: 0,
                    success: function(t) {
                        e.setData({
                            yy_money: t.data
                        });
                    }
                }), e.setData({
                    order: t.data,
                    total: t.data.money
                });
            }
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    goIndex: function() {
        wx.navigateTo({
            url: "/byjs_sun/pages/business/businessIndex2/businessIndex"
        });
    },
    goSettings: function() {
        wx.navigateTo({
            url: "/byjs_sun/pages/business/businessSettings/businessSettings"
        });
    },
    orderTab: function(t) {
        var e = this;
        console.log(t);
        var a = Number(t.currentTarget.dataset.id || 4);
        app.util.request({
            url: "entry/wxapp/OrderBusiness",
            data: {
                goId: a
            },
            cachetime: 0,
            success: function(t) {
                e.setData({
                    order: t.data,
                    total: t.data.money
                });
            }
        }), e.setData({
            goId: a
        });
    },
    goToConfirm: function(e) {
        var a = this, t = e.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/OrderBusinessConfirm",
            data: {
                id: t
            },
            cachetime: 0,
            success: function(t) {
                a.orderTab(e), a.setData({
                    goId: 4
                });
            }
        });
    }
});