var app = getApp();

Page({
    data: {},
    supplierStatistics: function() {
        wx.navigateTo({
            url: "../supplierStatistics/supplierStatistics"
        });
    },
    orderSite: function() {
        wx.navigateTo({
            url: "../supplierOrderSite/supplierOrderSite"
        });
    },
    supplierGroup: function() {
        wx.navigateTo({
            url: "../supplierGroup/supplierGroup"
        });
    },
    supplierGoods: function() {
        wx.navigateTo({
            url: "../supplierGoods/supplierGoods"
        });
    },
    toLive: function() {
        wx.navigateTo({
            url: "/xc_xinguwu/live/createLive/createLive?supplier_id=" + this.data.supplier.id
        });
    },
    onLoad: function(o) {
        var a = this;
        this.setData({
            "goHome.blackhomeimg": app.globalData.blackhomeimg
        }), app.util.request({
            url: "entry/wxapp/supplier",
            showLoading: !1,
            data: {
                op: "supplier"
            },
            success: function(o) {
                var t = o.data;
                console.log(t), a.setData({
                    supplier: t.data.supplier,
                    goods: t.data.goods,
                    todayNum: t.data.todayNum,
                    totalNum: t.data.totalNum
                });
            },
            fail: function(o) {
                1 == o.data.errno ? wx.redirectTo({
                    url: "../supplierApply/supplierApply"
                }) : 2 == o.data.errno && app.look.no(o.data.message, function() {
                    app.look.back(1);
                });
            }
        });
    },
    onReady: function() {
        app.look.goHome(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});