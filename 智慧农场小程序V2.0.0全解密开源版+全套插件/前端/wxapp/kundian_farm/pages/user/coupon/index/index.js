var t = new getApp(), a = t.siteInfo.uniacid;

wx.getStorageSync("kundian_farm_uid");

Page({
    data: {
        currenType: 1,
        couponData: [],
        farmSetData: wx.getStorageSync("kundian_farm_setData")
    },
    onLoad: function(o) {
        var n = this, e = 1;
        e = o.type ? o.type : n.data.currenType;
        var u = wx.getStorageSync("kundian_farm_uid");
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "coupon",
                op: "getCouponList",
                uniacid: a,
                type: e,
                uid: u
            },
            success: function(t) {
                n.setData({
                    couponData: t.data.couponData,
                    currenType: e
                });
            }
        }), t.util.setNavColor(a);
    },
    changeType: function(o) {
        var n = this, e = o.currentTarget.dataset.index, u = wx.getStorageSync("kundian_farm_uid");
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "coupon",
                op: "getCouponList",
                uniacid: a,
                type: e,
                uid: u
            },
            success: function(t) {
                n.setData({
                    couponData: t.data.couponData,
                    currenType: e
                });
            }
        });
    },
    getCoupon: function(o) {
        var n = this, e = o.currentTarget.dataset.cid, u = n.data.couponData, c = wx.getStorageSync("kundian_farm_uid");
        0 != c ? t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "coupon",
                op: "getCoupon",
                cid: e,
                uid: c,
                uniacid: a
            },
            success: function(t) {
                1 == t.data.code ? (wx.showToast({
                    title: "领取成功"
                }), u.map(function(t) {
                    t.id == e && (t.isget = 0);
                }), n.setData({
                    couponData: u
                })) : 2 == t.data.code ? wx.showToast({
                    title: "领取失败"
                }) : 3 == t.data.code ? wx.showToast({
                    title: "已领取过了"
                }) : 4 == t.data.code ? wx.showModal({
                    title: "提示",
                    content: "优惠券已被领完"
                }) : wx.showToast({
                    title: "请稍后重试"
                });
            }
        }) : wx.navigateTo({
            url: "../../../login/index"
        });
    },
    onShow: function(a) {
        t.globalData.uid = wx.getStorageSync("kundian_farm_uid");
    }
});