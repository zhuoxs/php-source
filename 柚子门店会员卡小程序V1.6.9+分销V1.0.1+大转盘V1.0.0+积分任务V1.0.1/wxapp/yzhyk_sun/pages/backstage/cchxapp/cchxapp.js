var app = getApp();

Page({
    data: {
        navTile: "订单详情",
        goods: [],
        is_hx: 0
    },
    onLoad: function(t) {
        var n = this, e = t.id;
        app.get_imgroot().then(function(o) {
            app.get_store_info().then(function(t) {
                n.setData({
                    store: t,
                    imgroot: o,
                    appid: e
                }), app.util.request({
                    url: "entry/wxapp/GetAppOrder",
                    fromcache: !1,
                    data: {
                        store_id: t.id,
                        appid: e
                    },
                    success: function(t) {
                        n.setData({
                            goods: t.data
                        }), console.log(t.data);
                    }
                });
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
        var o = this.data.appid;
        wx.showModal({
            title: "提示",
            content: "是否确认核销此预约订单？",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/SetAppOrder",
                    fromcache: !1,
                    data: {
                        order_number: o
                    },
                    success: function(t) {
                        1 == t.data ? wx.showModal({
                            title: "提示",
                            content: "核销成功",
                            showCancel: !1,
                            success: function(t) {
                                wx.navigateBack({});
                            }
                        }) : wx.showModal({
                            title: "提示",
                            content: "核销失败",
                            showCancel: !1
                        });
                    }
                });
            }
        });
    }
});