var t = new getApp(), a = t.siteInfo.uniacid;

Page({
    data: {
        money: "",
        userInfo: [],
        farmSetData: []
    },
    onLoad: function(n) {
        var e = this, i = wx.getStorageSync("kundian_farm_uid");
        i ? t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "distribution",
                op: "getUserInfo",
                uniacid: a,
                uid: i
            },
            success: function(t) {
                e.setData({
                    userInfo: t.data.user
                });
            }
        }) : wx.navigateTo({
            url: "../../login/index"
        }), e.setData({
            farmSetData: wx.getStorageSync("kundian_farm_setData")
        });
    },
    allMoney: function() {
        this.setData({
            money: this.data.userInfo.price
        });
    },
    input: function(t) {
        var a = t.detail.value;
        this.setData({
            money: a
        });
    },
    intoOrder: function(t) {
        var a = t.currentTarget.dataset.ordertype;
        wx.navigateTo({
            url: "../orderList/index?order_type=" + a
        });
    },
    intoTixian: function(t) {
        wx.navigateTo({
            url: "../cash/cash"
        });
    },
    intoWithdrawRecord: function(t) {
        wx.navigateTo({
            url: "../recode/index"
        });
    },
    intoSalePrice: function(t) {
        wx.navigateTo({
            url: "../commission/index"
        });
    },
    intoTeam: function(t) {
        wx.navigateTo({
            url: "../team/index"
        });
    },
    intoCode: function(t) {
        wx.navigateTo({
            url: "../share/index"
        });
    }
});