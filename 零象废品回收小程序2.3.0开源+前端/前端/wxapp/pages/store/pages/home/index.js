var e = getApp();

Page({
    data: {
        user: "",
        admin: [ {
            icon: "cuIcon-punch",
            title: "单次回收",
            url: "/pages/store/pages/order/index",
            type: 0
        }, {
            icon: "cuIcon-time",
            title: "定期回收",
            url: "/pages/store/pages/cycle/index",
            type: 0
        }, {
            icon: "cuIcon-sponsor",
            title: "提现审核",
            url: "/pages/store/pages/take/index",
            type: 0
        } ]
    },
    onLoad: function(t) {
        var a = this;
        e.util.request({
            url: "entry/wxapp/Api",
            showLoading: !1,
            data: {
                m: "ox_reclaim",
                r: "store.index",
                uid: wx.getStorageSync("uid")
            },
            success: function(e) {
                a.setData({
                    user: e.data.data.user
                }), 1 != a.data.user.jiedan && wx.navigateTo({
                    url: "/pages/me/index"
                });
            }
        });
    },
    goUrl: function(e) {
        var t = e.currentTarget.dataset.url;
        1 == e.currentTarget.dataset.type && this.data.store.store_id && (t += this.data.store.store_id), 
        wx.navigateTo({
            url: t
        });
    },
    cash: function() {
        wx.navigateTo({
            url: "/pages/store/pages/cash/index"
        });
    }
});