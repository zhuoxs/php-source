var t = new getApp(), a = t.siteInfo.uniacid;

wx.getStorageSync("kundian_farm_uid");

Page({
    data: {
        currenType: 0,
        currentCoupons: [],
        userCoupon: [],
        farmSetData: []
    },
    onLoad: function(e) {
        var n = this, u = wx.getStorageSync("kundian_farm_uid");
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "coupon",
                op: "getUserCouponList",
                uniacid: a,
                uid: u
            },
            success: function(t) {
                n.setData({
                    userCoupon: t.data.userCoupon
                }), n.filter();
            }
        }), t.util.setNavColor(a), n.setData({
            farmSetData: wx.getStorageSync("kundian_farm_setData")
        });
    },
    filter: function() {
        var t = this, a = [];
        this.data.userCoupon.map(function(e) {
            e.state === t.data.currenType && a.push(e);
        }), this.setData({
            currentCoupons: a
        });
    },
    changeState: function(t) {
        var a = t.currentTarget.dataset.state;
        this.setData({
            currenType: a
        }), this.filter();
    },
    useCoupon: function(t) {
        var a = t.currentTarget.dataset.type;
        1 == a ? wx.navigateTo({
            url: "../../../shop/index/index"
        }) : 2 == a ? wx.navigateTo({
            url: "../../../shop/Group/index/index"
        }) : 3 == a ? wx.navigateTo({
            url: "../../../shop/Adopt/index"
        }) : 4 == a ? wx.navigateTo({
            url: "../../land/selectionLands/index"
        }) : 5 == a && wx.navigateTo({
            url: "../../land/personLand/index"
        });
    },
    onShow: function(e) {
        var n = this, u = wx.getStorageSync("kundian_farm_uid");
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "coupon",
                op: "getUserCouponList",
                uniacid: a,
                uid: u
            },
            success: function(t) {
                n.setData({
                    userCoupon: t.data.userCoupon
                }), n.filter();
            }
        });
    }
});