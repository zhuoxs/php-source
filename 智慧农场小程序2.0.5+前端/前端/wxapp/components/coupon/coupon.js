var e = new getApp();

Component({
    options: {
        multipleSlots: !0
    },
    properties: {
        couponData: {
            type: Array,
            value: []
        },
        icon: {
            type: String,
            value: ""
        },
        noIcon: {
            type: String,
            value: ""
        }
    },
    data: {
        setData: wx.getStorageSync("kundian_farm_setData")
    },
    methods: {
        examineMoreCoupon: function(e) {
            wx.navigateTo({
                url: "/kundian_farm/pages/user/coupon/index/index"
            });
        },
        getCoupon: function(n) {
            var t = n.currentTarget.dataset.type;
            wx.getStorageSync("kundian_farm_uid"), e.siteInfo.uniacid;
            wx.navigateTo({
                url: "/kundian_farm/pages/user/coupon/index/index?type=" + t
            });
        }
    }
});