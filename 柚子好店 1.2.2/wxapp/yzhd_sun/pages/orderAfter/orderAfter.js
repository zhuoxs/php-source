var app = getApp();

Page({
    data: {},
    onLoad: function(a) {
        console.log(a), console.log(a.orderID);
        var t = this;
        wx.getStorage({
            key: "url",
            success: function(o) {
                t.setData({
                    url: o.data,
                    boss: a.boss
                });
            }
        });
        var o = wx.getStorageSync("openid");
        console.log(a.boss_id), app.util.request({
            url: "entry/wxapp/GetOrderDetail",
            cachetime: "0",
            data: {
                openid: o,
                order_id: a.orderID,
                boss_id: a.boss_id
            },
            success: function(o) {
                console.log(o), t.setData({
                    orderDetails: o.data.data
                }), app.util.request({
                    url: "entry/wxapp/GetGoodsDetail",
                    cachetime: "0",
                    data: {
                        gid: t.data.orderDetails.good_id
                    },
                    success: function(o) {
                        console.log(o), t.setData({
                            goodsInfo: o.data.data
                        });
                    }
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetBranchDetail",
            cachetime: "0",
            data: {
                bid: a.store_id
            },
            success: function(o) {
                console.log(o), t.setData({
                    shopInfo: o.data.data
                });
            }
        }), t.diyWinColor();
    },
    goShopTap: function(o) {
        wx.navigateTo({
            url: "../shopDetails/shopDetails?store_id=" + this.data.orderDetails.branch_id + "&&orderno=" + this.data.orderDetails.out_trade_no
        });
    },
    makePhone: function(o) {
        console.log(o);
        wx.makePhoneCall({
            phoneNumber: this.data.shopInfo.phone
        });
    },
    diyWinColor: function(o) {
        var a = wx.getStorageSync("system");
        wx.setNavigationBarColor({
            frontColor: a.color,
            backgroundColor: a.fontcolor,
            animation: {
                duration: 400,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: "订单详情"
        });
    }
});