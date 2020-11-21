var t = getApp();

Page({
    data: {
        list: [],
        need: !1
    },
    onLoad: function(t) {
        t.id && this.setData({
            need: !0
        });
    },
    onShow: function() {
        var a = this;
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "address.addressList",
                uid: wx.getStorageSync("uid")
            },
            method: "get",
            success: function(t) {
                a.setData({
                    list: t.data.data
                });
            }
        });
    },
    selectAddress: function(t) {
        var a = this;
        if (this.data.need) {
            var e = a.data.list[t.currentTarget.dataset.index], d = getCurrentPages();
            d[d.length - 2].setData({
                address: e
            }), wx.navigateBack({
                delta: 1
            });
        }
    },
    add: function(t) {
        t.currentTarget.dataset.id ? wx.navigateTo({
            url: "/pages/me/address/detail/index?id=" + t.currentTarget.dataset.id
        }) : wx.navigateTo({
            url: "/pages/me/address/detail/index"
        });
    }
});