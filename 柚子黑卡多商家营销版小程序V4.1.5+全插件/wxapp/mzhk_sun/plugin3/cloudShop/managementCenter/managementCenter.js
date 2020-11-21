/*   time:2019-08-09 13:18:47*/
var app = getApp();
Page({
    data: {
        curindex: 0
    },
    onLoad: function(n) {
        var e = wx.getStorageSync("openid");
        this.setData({
            openid: e
        }), this.getShopkeeper()
    },
    ontab: function(n) {
        if (n) {
            if (this.data.curindex == n.currentTarget.dataset.tabid) return !1;
            this.setData({
                curindex: n.currentTarget.dataset.tabid
            })
        }
    },
    getShopkeeper: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/CloudShopUser",
            data: {
                openid: e.data.openid,
                m: app.globalData.Plugin_cloud
            },
            success: function(n) {
                console.log("获取店主信息"), console.log(n), e.setData({
                    shopkeeper: n.data
                })
            }
        })
    },
    onDetailed: function() {
        wx.navigateTo({
            url: "/mzhk_sun/plugin3/cloudShop/detailed/detailed"
        })
    },
    onOrderOrdinary: function() {
        wx.navigateTo({
            url: "/mzhk_sun/plugin3/cloudShop/orderOrdinary/orderOrdinary"
        })
    },
    onOrderAssemble: function() {
        wx.navigateTo({
            url: "/mzhk_sun/plugin3/cloudShop/orderAssemble/orderAssemble"
        })
    },
    onOrderBargain: function() {
        wx.navigateTo({
            url: "/mzhk_sun/plugin3/cloudShop/orderBargain/orderBargain"
        })
    },
    onOrderRush: function() {
        wx.navigateTo({
            url: "/mzhk_sun/plugin3/cloudShop/orderRush/orderRush"
        })
    },
    onOrderSubCard: function() {
        wx.navigateTo({
            url: "/mzhk_sun/plugin3/cloudShop/orderSubCard/orderSubCard"
        })
    },
    onCommodityManagement: function(n) {
        var e = n.currentTarget.dataset.lid,
            o = n.currentTarget.dataset.curindex;
        wx.navigateTo({
            url: "/mzhk_sun/plugin3/cloudShop/commodityManagement/commodityManagement?lid=" + e + "&&curindex=" + o
        })
    },
    onEdit: function(n) {
        var e = n.currentTarget.dataset.editid;
        wx.navigateTo({
            url: "/mzhk_sun/plugin3/cloudShop/settledIn/settledIn?editid=" + e
        })
    },
    onRenew: function() {
        wx.navigateTo({
            url: "/mzhk_sun/plugin3/cloudShop/renew/renew"
        })
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});