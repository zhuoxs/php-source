var t = new getApp(), a = t.siteInfo.uniacid;

wx.getStorageSync("kundian_farm_uid");

Page({
    data: {
        isUsed: !1,
        userCoupon: [],
        type: 1
    },
    onLoad: function(e) {
        var n = this, o = e.type, s = wx.getStorageSync("kundian_farm_uid"), u = e.totalPrice;
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "coupon",
                op: "getUseCoupon",
                uniacid: a,
                uid: s,
                type: o,
                totalPrice: u
            },
            success: function(t) {
                n.setData({
                    userCoupon: t.data.userCoupon,
                    type: o
                });
            }
        }), t.util.setNavColor(a);
    },
    isUsed: function() {
        var t = this.data.isUsed;
        this.setData({
            isUsed: !t
        }), wx.navigateBack({
            delta: 1
        });
    },
    useCoupon: function(t) {
        var a = t.currentTarget.dataset.id, e = this.data.userCoupon, n = new Array();
        e.map(function(t) {
            t.id == a && (n = t);
        }), wx.setStorageSync("user_coupon", n), wx.navigateBack({
            delta: 1
        });
    }
});