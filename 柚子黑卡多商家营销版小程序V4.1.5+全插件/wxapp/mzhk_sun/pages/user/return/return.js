var app = getApp();

Page({
    data: {
        curIndex: 0,
        nav: [ "赠送余额", "赠送优惠券", "赠送商品" ],
        orderlist: [],
        page: [ 1, 1, 1 ]
    },
    onLoad: function(t) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/GetReturnList",
            showLoading: !1,
            data: {
                type: 0,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                console.log(t.data), 2 != t.data ? e.setData({
                    orderlist: t.data
                }) : e.setData({
                    orderlist: []
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var a = this, o = a.data.curIndex, n = a.data.orderlist, r = a.data.page, d = r[o];
        app.util.request({
            url: "entry/wxapp/GetReturnList",
            showLoading: !1,
            data: {
                type: o,
                page: d,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                if (console.log(t.data), 2 == t.data) wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                }); else {
                    var e = t.data;
                    n = n.concat(e), r[o] = d + 1, a.setData({
                        orderlist: n,
                        page: r
                    });
                }
            }
        });
    },
    bargainTap: function(t) {
        var e = this, a = parseInt(t.currentTarget.dataset.index);
        app.util.request({
            url: "entry/wxapp/GetReturnList",
            showLoading: !1,
            data: {
                type: a,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                console.log(t.data), 2 != t.data ? e.setData({
                    orderlist: t.data
                }) : e.setData({
                    orderlist: []
                });
            }
        }), e.setData({
            curIndex: a
        });
    },
    toOrderder: function(t) {
        var e = t.currentTarget.dataset.order_id;
        wx.navigateTo({
            url: "../orderdet/orderdet?order_id=" + e + "&ordertype=4"
        });
    },
    toCoupon: function(t) {
        wx.navigateTo({
            url: "../welfare/welfare"
        });
    }
});