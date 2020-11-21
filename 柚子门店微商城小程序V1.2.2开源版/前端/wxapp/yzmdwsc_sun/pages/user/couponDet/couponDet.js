var app = getApp(), wxbarcode = require("../../../../style/utils/index.js");

Page({
    data: {
        navTile: "优惠券详情",
        shopname: "柚子鲜花坊",
        price: "30",
        minprice: "398",
        time: "2018.01.12-2018.02.12",
        remark: "本优惠券仅适用于线下门店x消费使用，请到店出示二维码，给店员核销，如有疑问咨询商家客服",
        phone: "0582-0000",
        explain: "这里是使用说明啊啊啊啊啊啊"
    },
    onLoad: function(t) {
        var n = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: n.data.navTile
        });
        var e = t.id, a = wx.getStorageSync("url"), o = wx.getStorageSync("openid"), i = wx.getStorageSync("settings");
        n.setData({
            url: a,
            settings: i
        }), app.util.request({
            url: "entry/wxapp/getCouponDetail",
            cachetime: "0",
            data: {
                uid: o,
                id: e
            },
            success: function(t) {
                n.setData({
                    coupondetail: t.data.data
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
    dialog: function(t) {
        wx.makePhoneCall({
            phoneNumber: this.data.settings.tel
        });
    }
});