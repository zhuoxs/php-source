var app = getApp();

Page({
    data: {
        navTile: "订单详情",
        address: "",
        shopPhone: "",
        is_hx: 0
    },
    onLoad: function(t) {
        var n = this, o = wx.getStorageSync("setting");
        o ? wx.setNavigationBarColor({
            frontColor: o.fontcolor,
            backgroundColor: o.color
        }) : app.get_setting(!0).then(function(t) {
            wx.setNavigationBarColor({
                frontColor: t.fontcolor,
                backgroundColor: t.color
            });
        });
        t.orderid;
        var e = t.uid;
        app.get_imgroot().then(function(o) {
            app.util.request({
                url: "entry/wxapp/getOrderDetail",
                cachetime: "0",
                data: {
                    id: t.orderid,
                    openid: e
                },
                success: function(t) {
                    3 == t.data.data.order_status && n.setData({
                        is_hx: 1
                    }), n.setData({
                        imgroot: o,
                        order: t.data.data
                    });
                }
            });
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
        var o = this, n = t.currentTarget.dataset.order_id;
        app.get_openid().then(function(t) {
            app.util.request({
                url: "entry/wxapp/checkOrder",
                cachetime: "0",
                data: {
                    id: n,
                    uid: t
                },
                success: function(t) {
                    0 == t.data.errcode && wx.showModal({
                        title: "提示",
                        content: t.data.errmsg,
                        showCancel: !1,
                        success: function(t) {
                            o.setData({
                                is_hx: 1
                            });
                        }
                    });
                }
            });
        });
    },
    toOrderlist: function(t) {
        wx.navigateBack({});
    }
});