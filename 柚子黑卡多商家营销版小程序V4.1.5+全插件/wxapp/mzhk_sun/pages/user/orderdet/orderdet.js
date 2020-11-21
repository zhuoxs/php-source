var wxbarcode = require("../../../../style/utils/index.js"), app = getApp();

Page({
    data: {
        orderinfo: [],
        url: "",
        navTile: "订单详情",
        statusstr: [ "", "已取消订单", "待支付", "待使用", "已支付", "已完成" ],
        statusstr_jk: [ "待发货", "待收货", "已完成" ]
    },
    onLoad: function(e) {
        var a = this;
        wx.setNavigationBarTitle({
            title: a.data.navTile
        });
        var t = app.getSiteUrl();
        t ? a.setData({
            url: t
        }) : app.util.request({
            url: "entry/wxapp/Url",
            success: function(e) {
                wx.setStorageSync("url", e.data), t = e.data, a.setData({
                    url: t
                });
            }
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor,
            backgroundColor: wx.getStorageSync("System").color,
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var r = e.ordertype ? e.ordertype : 0;
        0 == r && a.setData({
            prefix: "QG"
        }), 1 == r && a.setData({
            prefix: "PT"
        }), 2 == r && a.setData({
            prefix: "KJ"
        }), 3 == r && a.setData({
            prefix: "JK"
        }), 4 == r && a.setData({
            prefix: "OR"
        }), 6 == r && a.setData({
            prefix: "MD"
        });
        var o = e.order_id;
        app.util.request({
            url: "entry/wxapp/GetOrderDetail",
            cachetime: "30",
            data: {
                order_id: o,
                ordertype: r
            },
            success: function(e) {
                console.log("查看order——id:" + o), console.log(e.data), a.setData({
                    orderinfo: e.data,
                    ordertype: r
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 5
            },
            showLoading: !1,
            success: function(e) {
                var t = 2 != e.data && e.data;
                a.setData({
                    open_redpacket: t
                });
            }
        });
        var n = '{ "id": ' + o + ', "ordertype": ' + r + "}";
        wxbarcode.qrcode("qrcode", n, 420, 420);
    },
    copyshipnum: function(e) {
        var t = e.currentTarget.dataset.shipnum;
        wx.setClipboardData({
            data: t,
            success: function(e) {
                wx.showToast({
                    title: "复制成功！",
                    icon: "none",
                    duration: 2e3
                });
            }
        });
    },
    gotoGoods: function(e) {
        var t, a = e.currentTarget.dataset.gid, r = this.data.ordertype;
        t = 1 == r ? "/mzhk_sun/pages/index/groupdet/groupdet?id=" + a : 2 == r ? "/mzhk_sun/pages/index/bardet/bardet?id=" + a : 3 == r ? "/mzhk_sun/pages/index/cardsdet/cardsdet?gid=" + a : 4 == r ? "/mzhk_sun/pages/index/goods/goods?gid=" + a : 6 == r ? "/mzhk_sun/pages/index/freedet/freedet?id=" + a : "/mzhk_sun/pages/index/package/package?id=" + a, 
        wx.redirectTo({
            url: t
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});