var app = getApp();

Page({
    data: {
        navTile: "订单详情",
        order: {
            uname: "李星和",
            phone: 13e7,
            remark: "留言",
            ordernum: "123215678469463",
            times: "2018-06-06 10:10:10",
            status: 2
        },
        address: "厦门市集美区",
        shopPhone: 13e8,
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
        is_hx: 0,
        isIpx: app.globalData.isIpx
    },
    onLoad: function(t) {
        var e = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var o = t.orderid, a = t.uid;
        e.setData({
            url: wx.getStorageSync("url"),
            orderid: o
        }), app.util.request({
            url: "entry/wxapp/getOrderDetail",
            cachetime: "0",
            data: {
                id: o,
                uid: a
            },
            success: function(t) {
                console.log(t.data.data), 3 == t.data.data.order_status && e.setData({
                    is_hx: 1
                }), e.setData({
                    order: t.data.data
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
    Dialog: function(t) {
        console.log(t), wx.makePhoneCall({
            phoneNumber: t.currentTarget.dataset.phone
        });
    },
    toConfirm: function(t) {
        var e = this, o = t.currentTarget.dataset.order_id;
        app.util.request({
            url: "entry/wxapp/setCheckOrder",
            cachetime: "0",
            data: {
                id: o,
                uid: wx.getStorageSync("openid")
            },
            success: function(t) {
                0 == t.data.errcode && wx.showModal({
                    title: "提示",
                    content: t.data.errmsg,
                    showCancel: !1,
                    success: function(t) {
                        e.setData({
                            is_hx: 1
                        });
                    }
                });
            }
        });
    },
    toOrderlist: function(t) {
        wx.navigateBack({});
    }
});