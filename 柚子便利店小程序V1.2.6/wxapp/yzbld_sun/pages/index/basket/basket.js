var app = getApp();

Page({
    data: {
        shopName: "柚子商店（杏林湾店）",
        cart: {},
        isIpx: app.globalData.isIpx,
        goodses: [ {
            id: 1,
            src: "",
            title: "标题啊啊啊啊啊啊吧",
            price: "20.00"
        } ]
    },
    onLoad: function(o) {},
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    add: function(o) {
        var t = o.currentTarget.dataset.id;
        this.data.cart.goodses[t];
    },
    reduce: function(o) {
        o.currentTarget.dataset.id;
    },
    toGoods: function(o) {
        var t = o.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../../index/goods/goods?id=" + t
        });
    },
    toCforder: function(o) {
        0 < this.data.cart.amount && wx.navigateTo({
            url: "../cforder/cforder"
        });
    },
    toScan: function(o) {
        wx.scanCode({
            success: function(o) {
                o.result;
            }
        });
    }
});