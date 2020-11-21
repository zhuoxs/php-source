var app = getApp();

Page({
    data: {
        navTile: "订单详情",
        goods: [],
        is_hx: 0
    },
    onLoad: function(t) {
        var n = this, a = t.id;
        app.get_imgroot().then(function(o) {
            app.get_store_info().then(function(t) {
                n.setData({
                    store: t,
                    imgroot: o
                }), app.util.request({
                    url: "entry/wxapp/GetOutOrder",
                    fromcache: !1,
                    data: {
                        store_id: t.id,
                        user_id: a
                    },
                    success: function(t) {
                        n.setData({
                            goods: t.data.list,
                            ids: t.data.ids
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
        var o = this.data.ids;
        app.util.request({
            url: "entry/wxapp/SetOutOrder",
            fromcache: !1,
            data: {
                ids: o
            },
            success: function(t) {
                0 == t.data.code ? wx.showModal({
                    title: "提示",
                    content: "核销成功",
                    showCancel: !1,
                    success: function(t) {
                        wx.navigateBack({});
                    }
                }) : wx.showModal({
                    title: "提示",
                    content: "出场核销失败",
                    showCancel: !1
                });
            }
        });
    },
    toOrderlist: function(t) {
        wx.navigateBack({});
    },
    toBack: function(t) {
        wx.navigateBack({});
    }
});