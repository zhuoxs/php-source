var app = getApp();

Page({
    data: {
        order: {},
        navTile: "订单详情",
        shopname: "柚子商店",
        goods: [ {
            title: "发财树绿萝栀子花海棠花卉盆栽",
            goodsThumb: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png",
            price: "2.50",
            specConn: "s",
            num: "1"
        }, {
            title: "发财树绿萝栀子花海棠花卉盆栽",
            goodsThumb: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png",
            price: "2.50",
            specConn: "套餐1",
            num: "1"
        } ],
        totalprice: "2.50",
        discount: "30.00",
        orderNnum: "1234567897",
        time: "2018-05-01 10:10:10",
        status: 1,
        paytype: "余额支付"
    },
    onLoad: function(t) {
        var e = this;
        wx.setNavigationBarTitle({
            title: e.data.navTile
        }), app.get_imgroot().then(function(t) {
            e.setData({
                imgroot: t
            });
        }), app.util.request({
            url: "entry/wxapp/GetOrderScanInfo",
            cachetime: "0",
            data: {
                id: t.id
            },
            success: function(t) {
                e.setData({
                    order: t.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    deletes: function(t) {
        var e = this;
        wx.showModal({
            title: "提示",
            content: "订单删除后不再显示!",
            success: function(t) {
                if (t.confirm) app.util.request({
                    url: "entry/wxapp/DeleteOrderScan",
                    cachetime: "0",
                    data: {
                        id: e.data.order.id
                    },
                    success: function(t) {
                        wx.navigateBack({});
                    }
                }); else if (t.cancel) return;
            }
        });
    },
    cancel: function(t) {
        wx.showModal({
            title: "提示",
            content: "确定取消订单",
            success: function(t) {
                if (t.confirm) console.log("确定"); else if (t.cancel) return;
            }
        });
    },
    dialog: function(t) {
        wx.makePhoneCall({
            phoneNumber: this.data.order.tel
        });
    }
});