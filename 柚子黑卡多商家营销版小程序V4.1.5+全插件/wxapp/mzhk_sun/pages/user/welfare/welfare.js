var wxbarcode = require("../../../../style/utils/index.js"), app = getApp();

Page({
    data: {
        navTile: "我的福利",
        curIndex: 0,
        nav: [ "全部", "未使用", "已使用", "已过期" ],
        status: [ 0, 1, 2, 3 ],
        page: [ 1, 1, 1, 1 ],
        all: [],
        url: "",
        show: !1,
        orderurl: ""
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarTitle({
            title: a.data.navTile
        });
        var e = app.getSiteUrl();
        a.setData({
            url: e
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor,
            backgroundColor: wx.getStorageSync("System").color,
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var n = a.data.status[0], o = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/GetUserCounpon",
            data: {
                status: n,
                openid: o
            },
            success: function(t) {
                console.log("获取优惠券数据"), console.log(t.data), 2 == t.data ? a.setData({
                    all: []
                }) : a.setData({
                    all: t.data
                });
            }
        });
    },
    getUrl: function() {
        var t = app.getSiteUrl();
        this.setData({
            url: t
        });
    },
    open: function(t) {
        var a = this.data.show, e = '{ "id": ' + t.currentTarget.dataset.id + ', "ordertype": 10}';
        wxbarcode.qrcode("qrcode", e, 420, 420), this.setData({
            show: !a
        });
    },
    onReady: function() {},
    onShow: function() {},
    onShareAppMessage: function(t) {
        var a = this;
        if (console.log(t), "button" === t.from) {
            var e = t.target.dataset.id;
            return {
                title: t.target.dataset.title,
                path: "/mzhk_sun/pages/index/sendwelfare/sendwelfare?id=" + t.target.dataset.cid + "&ucid=" + e + "&uid=" + wx.getStorageSync("openid"),
                success: function(t) {
                    a.setData({
                        showModalStatus: !1
                    });
                }
            };
        }
        return {
            title: "",
            path: "/mzhk_sun/pages/index/index",
            success: function(t) {
                a.setData({
                    showModalStatus: !1
                });
            }
        };
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var e = this, n = e.data.curIndex, t = e.data.status[n], a = wx.getStorageSync("openid"), o = e.data.page, s = o[n], r = e.data.all;
        app.util.request({
            url: "entry/wxapp/GetUserCounpon",
            data: {
                status: t,
                openid: a,
                page: s
            },
            success: function(t) {
                if (console.log(t.data), 2 == t.data) wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                }); else {
                    var a = t.data;
                    r = r.concat(a), o[n] = s + 1, e.setData({
                        all: r,
                        page: o
                    });
                }
            }
        });
    },
    bargainTap: function(t) {
        var a = this, e = parseInt(t.currentTarget.dataset.index), n = a.data.status[e], o = wx.getStorageSync("openid");
        console.log(n), app.util.request({
            url: "entry/wxapp/GetUserCounpon",
            data: {
                status: n,
                openid: o
            },
            success: function(t) {
                console.log(t.data), 2 == t.data ? a.setData({
                    all: [],
                    curIndex: e
                }) : a.setData({
                    all: t.data,
                    curIndex: e
                });
            }
        });
    },
    toCancel: function(t) {
        wx.showModal({
            title: "提示",
            content: "确认取消该订单吗",
            showCancel: !0,
            success: function(t) {},
            fail: function(t) {},
            complete: function(t) {}
        });
    }
});