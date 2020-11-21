/*   time:2019-08-09 13:18:48*/
var wxbarcode = require("../../../../style/utils/index.js"),
    app = getApp();
Page({
    data: {
        orderinfo: [],
        url: "",
        navTile: "订单详情",
        statusstr: ["", "已取消订单", "待支付", "待配送", "配送中", "已完成"],
        statusstr_jk: ["待发货", "待收货", "已完成"],
        shows: 1
    },
    onLoad: function(a) {
        var e = this;
        console.log(a), wx.setNavigationBarTitle({
            title: e.data.navTile
        });
        var o = app.getSiteUrl();
        o ? e.setData({
            url: o
        }) : app.util.request({
            url: "entry/wxapp/Url",
            success: function(t) {
                wx.setStorageSync("url", t.data), o = t.data, e.setData({
                    url: o
                })
            }
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor,
            backgroundColor: wx.getStorageSync("System").color,
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var t = a.oid;
        app.util.request({
            url: "entry/wxapp/psOrderDetail",
            data: {
                oid: t
            },
            success: function(t) {
                e.setData({
                    orderinfo: t.data,
                    shows: a.users ? 0 : 1,
                    viptype: wx.getStorageSync("viptype").viptype
                })
            }
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 5
            },
            showLoading: !1,
            success: function(t) {
                var a = 2 != t.data && t.data;
                e.setData({
                    open_redpacket: a
                })
            }
        })
    },
    copyshipnum: function(t) {
        var a = t.currentTarget.dataset.shipnum;
        wx.setClipboardData({
            data: a,
            success: function(t) {
                wx.showToast({
                    title: "复制成功！",
                    icon: "none",
                    duration: 2e3
                })
            }
        })
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    toComment: function(a) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/IsComment",
            showLoading: !1,
            data: {
                oid: e.data.orderinfo.oid,
                gid: a.currentTarget.dataset.gid,
                type: 14
            },
            success: function(t) {
                if (console.log(t.data), 2 == t.data) return wx.showModal({
                    title: "提示信息",
                    content: "已评论",
                    showCancel: !1
                }), !1;
                wx.navigateTo({
                    url: "/mzhk_sun/pages/dynamic/dynamicedit/dynamicedit?gid=" + a.currentTarget.dataset.gid + "&oid=" + e.data.orderinfo.oid
                })
            }
        })
    }
});