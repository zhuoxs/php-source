var _request = require("../../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

Page({
    data: {
        navTile: "领券中心"
    },
    onLoad: function(t) {
        var e = this;
        wx.setNavigationBarTitle({
            title: e.data.navTile
        }), _request2.default.get("getActivityCoupon", {
            store_id: wx.getStorageSync("storeId")
        }).then(function(t) {
            console.log(t), e.setData({
                cards: t
            });
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    receRards: function(t) {
        var e = this, n = t.currentTarget.dataset.status, o = t.currentTarget.dataset.index, a = e.data.cards;
        "2" == n ? wx.showModal({
            title: "提示",
            content: "您已经领取过该优惠券啦~",
            showCancel: !1
        }) : 1 == n ? wx.showModal({
            title: "提示",
            content: "优惠券已被抢光啦~下次早点来",
            showCancel: !1
        }) : "0" == n && _request2.default.post("receiveCoupon", {
            coupon_id: a[o].id
        }).then(function(t) {
            console.log(t), a[o].status = 2, wx.showModal({
                title: "提示",
                content: "恭喜你，领取成功",
                showCancel: !1,
                success: function(t) {
                    e.setData({
                        cards: a
                    });
                }
            });
        });
    }
});