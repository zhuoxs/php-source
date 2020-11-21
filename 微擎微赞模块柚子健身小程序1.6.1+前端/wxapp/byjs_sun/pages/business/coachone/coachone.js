var app = getApp();

Page({
    data: {
        user: {},
        fight: []
    },
    onLoad: function(t) {
        var e = this, n = t.id;
        e.setData({
            id: n
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/CoachInfo",
            cachetime: "0",
            data: {
                id: e.data.id
            },
            success: function(t) {
                console.log(t), e.setData({
                    user: t.data.res,
                    today: t.data.today,
                    total: t.data.total,
                    noSure1: t.data.noSure1,
                    noSure2: t.data.noSure2,
                    Sure1: t.data.Sure1,
                    Sure2: t.data.Sure2
                });
            }
        });
    },
    goBespoke: function(t) {
        var e = t.currentTarget.dataset.state, n = t.currentTarget.dataset.id, a = this.data.id;
        wx.navigateTo({
            url: "/byjs_sun/pages/myUser/myBespoketwo/myBespoketwo?id=" + a + "&navIndex=" + e + "&Bespoketid=" + n
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    goOrder: function() {
        wx.navigateTo({
            url: "/byjs_sun/pages/business/businessOrder/businessOrder"
        });
    },
    goSettings: function() {
        wx.navigateTo({
            url: "/byjs_sun/pages/business/businessSettings/businessSettings"
        });
    },
    soso: function() {
        wx.scanCode({
            success: function(t) {
                console.log(t);
            }
        });
    },
    ordernum: function(t) {
        console.log(t);
        this.setData({
            order_num: t.detail.value
        });
    },
    confirm: function() {
        var t = this.data.order_num;
        app.util.request({
            url: "entry/wxapp/OrderConfirm",
            data: {
                order_num: t
            },
            success: function(t) {
                wx.showModal({
                    title: "成功",
                    content: "核销成功"
                });
            }
        });
    },
    loginout: function() {
        wx.removeStorageSync("coach_name"), wx.showModal({
            title: "",
            content: "是否确认退出？",
            success: function(t) {
                t.confirm && wx.reLaunch({
                    url: "../../../../byjs_sun/pages/product/index/index"
                });
            }
        });
    }
});