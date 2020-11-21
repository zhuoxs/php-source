/*   time:2019-08-09 13:18:39*/
var _data;

function _defineProperty(a, e, t) {
    return e in a ? Object.defineProperty(a, e, {
        value: t,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[e] = t, a
}
var app = getApp();
Page({
    data: (_data = {
        menuTapCurrent: 0,
        page: 1,
        page1: 1,
        page2: 1,
        is_modal_Hidden: !0,
        page3: 1,
        pagesize: 10,
        list: [],
        sign: [],
        send: [],
        complete: [],
        lid: ""
    }, _defineProperty(_data, "menuTapCurrent", ""), _defineProperty(_data, "current", ""), _defineProperty(_data, "all", []), _data),
    onLoad: function(a) {
        app.wxauthSetting();
        var e = a.check_type;
        0 < e || (e = 0), this.setData({
            menuTapCurrent: e
        }), this.getMyOrder()
    },
    onShow: function() {
        app.func.islogin(app, this)
    },
    getMyOrder: function() {
        var o = this,
            a = wx.getStorageSync("users").openid,
            r = o.data.page,
            s = (o.data.pagesize, o.data.all),
            e = o.data.menuTapCurrent;
        app.util.request({
            url: "entry/wxapp/getMyOrder",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: a,
                page: o.data.page,
                pagesize: o.data.pagesize,
                type: e,
                lid: 1
            },
            showLoading: !1,
            success: function(a) {
                var e = a.data.data.length == o.data.pagesize;
                if (1 == r) s = a.data.data;
                else for (var t in a.data.data) s.push(a.data.data[t]);
                r += 1, console.log(r), o.setData({
                    all: s,
                    imgroot: a.data.other.img_root,
                    page: r,
                    hasMore: e
                })
            }
        })
    },
    getALL: function() {
        var o = this,
            a = wx.getStorageSync("users").openid,
            r = o.data.page,
            s = (o.data.pagesize, o.data.all);
        app.util.request({
            url: "entry/wxapp/getMyOrder",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: a,
                page: o.data.page,
                pagesize: o.data.pagesize,
                lid: 1
            },
            showLoading: !1,
            success: function(a) {
                console.log("订单全部"), console.log(a.data.data);
                var e = a.data.data.length == o.data.pagesize;
                if (1 == r) s = a.data.data;
                else for (var t in a.data.data) s.push(a.data.data[t]);
                r += 1, console.log("你的页面是多少"), console.log(r), o.setData({
                    all: s,
                    imgroot: a.data.other.img_root,
                    page: r,
                    hasMore: e
                })
            }
        })
    },
    getSign: function() {
        var o = this,
            a = wx.getStorageSync("users").openid,
            r = o.data.page1,
            s = (o.data.pagesize, o.data.sign);
        app.util.request({
            url: "entry/wxapp/getMyOrder",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: a,
                type: 1,
                page1: o.data.page1,
                pagesize: o.data.pagesize,
                lid: 1
            },
            showLoading: !1,
            success: function(a) {
                console.log(a), console.log("订单进行中");
                var e = a.data.data.length == o.data.pagesize;
                if (1 == r) s = a.data.data;
                else for (var t in a.data.data) s.push(a.data.data[t]);
                r += 1, o.setData({
                    sign: s,
                    imgroot: a.data.other.img_root,
                    page1: r,
                    hasMore: e
                })
            }
        })
    },
    getSend: function() {
        var o = this,
            a = wx.getStorageSync("users").openid,
            r = o.data.page2,
            s = (o.data.pagesize, o.data.send);
        app.util.request({
            url: "entry/wxapp/getMyOrder",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: a,
                type: 2,
                page2: o.data.page2,
                pagesize: o.data.pagesize,
                lid: 1
            },
            showLoading: !1,
            success: function(a) {
                console.log(a), console.log("订单全部");
                var e = a.data.data.length == o.data.pagesize;
                if (1 == r) s = a.data.data;
                else for (var t in a.data.data) s.push(a.data.data[t]);
                r += 1, o.setData({
                    send: s,
                    imgroot: a.data.other.img_root,
                    page2: r,
                    hasMore: e
                })
            }
        })
    },
    getComplete: function() {
        var o = this,
            a = wx.getStorageSync("users").openid,
            r = o.data.page3,
            s = (o.data.pagesize, o.data.complete);
        app.util.request({
            url: "entry/wxapp/getMyOrder",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: a,
                type: 3,
                page3: o.data.page3,
                pagesize: o.data.pagesize,
                lid: 1
            },
            showLoading: !1,
            success: function(a) {
                console.log(a), console.log("订单完成"), console.log(a);
                var e = a.data.data.length == o.data.pagesize;
                if (1 == r) s = a.data.data;
                else for (var t in a.data.data) s.push(a.data.data[t]);
                r += 1, o.setData({
                    complete: s,
                    imgroot: a.data.other.img_root,
                    page3: r,
                    hasMore: e
                })
            }
        })
    },
    menuTap: function(a) {
        var e = a.currentTarget.dataset.current;
        this.setData({
            menuTapCurrent: e,
            page: 1
        }), this.getMyOrder()
    },
    lower: function(a) {
        console.log("下拉");
        this.data.hasMore ? this.getMyOrder() : wx.showToast({
            title: "没有更多订单啦~",
            icon: "none"
        })
    },
    onReachBottom: function() {
        console.log("上拉");
        this.data.hasMore ? this.getMyOrder() : wx.showToast({
            title: "没有更多订单啦~",
            icon: "none"
        })
    },
    orderDetails: function(a) {
        var e = a.currentTarget.dataset.id;
        console.log("你的id是多少"), console.log(e), wx.navigateTo({
            url: "../orderDetails/orderDetails?id=" + e
        })
    },
    productsDetails: function(a) {
        var e = a.currentTarget.dataset.id,
            t = a.currentTarget.dataset.oid,
            o = (a.currentTarget.dataset.lottery_type, a.currentTarget.dataset.order_status);
        console.log(o), 0 == o ? wx.navigateTo({
            url: "/pages/plugin/shoppingMall/details/details?id=" + e
        }) : wx.navigateTo({
            url: "/pages/plugin/shoppingMall/productsDetails/productsDetails?id=" + e + "&oid=" + t
        })
    },
    method: function(a) {
        var e = a.currentTarget.dataset.status,
            t = a.currentTarget.dataset.id,
            o = a.currentTarget.dataset.oid,
            r = a.currentTarget.dataset.lottery_type;
        if (console.log(e), "0" == e) {
            t = a.currentTarget.dataset.id;
            console.log("你的id是多少"), console.log(t), wx.navigateTo({
                url: "../orderDetails/orderDetails?id=" + t
            })
        } else {
            if (console.log(o), 2 == r) return;
            wx.navigateTo({
                url: "../productsDetails/productsDetails?id=" + t + "&oid=" + o
            })
        }
    },
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh()
    },
    updateUserInfo: function(a) {
        app.wxauthSetting()
    }
});