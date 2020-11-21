var t = getApp(), a = require("../common/common.js");

Page({
    data: {
        pagePath: "../coupon/coupon",
        curr: 1
    },
    tab: function(a) {
        var o = this, n = a.currentTarget.dataset.index;
        n != o.data.curr && (o.setData({
            curr: n,
            list: []
        }), t.util.request({
            url: "entry/wxapp/index",
            data: {
                op: "coupon",
                curr: o.data.curr
            },
            showLoading: !1,
            success: function(t) {
                var a = t.data;
                "" != a.data && o.setData({
                    list: a.data
                });
            }
        }));
    },
    setcoupon: function(a) {
        var o = this, n = a.currentTarget.dataset.index;
        wx.showModal({
            title: "提示",
            content: "是否领取优惠券？",
            success: function(a) {
                a.confirm ? t.util.request({
                    url: "entry/wxapp/user",
                    data: {
                        op: "set_coupon",
                        id: o.data.list[n].id
                    },
                    showLoading: !1,
                    success: function(t) {
                        if ("" != t.data.data) {
                            wx.showToast({
                                title: "领取成功",
                                icon: "success",
                                duration: 2e3
                            });
                            var a = o.data.list;
                            delete a[n], o.setData({
                                list: a
                            });
                        }
                    }
                }) : a.cancel && console.log("用户点击取消");
            }
        });
    },
    to_shop: function(t) {
        wx.navigateTo({
            url: "../service/index"
        });
    },
    onLoad: function(o) {
        var n = this;
        a.config(n), a.theme(n), t.util.request({
            url: "entry/wxapp/index",
            data: {
                op: "coupon",
                curr: n.data.curr
            },
            showLoading: !1,
            success: function(t) {
                var a = t.data;
                "" != a.data && n.setData({
                    list: a.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        a.audio_end(this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var a = this;
        t.util.request({
            url: "entry/wxapp/index",
            data: {
                op: "coupon",
                curr: a.data.curr
            },
            showLoading: !1,
            success: function(t) {
                wx.stopPullDownRefresh();
                var o = t.data;
                "" != o.data && a.setData({
                    list: o.data
                });
            }
        });
    },
    onReachBottom: function() {}
});