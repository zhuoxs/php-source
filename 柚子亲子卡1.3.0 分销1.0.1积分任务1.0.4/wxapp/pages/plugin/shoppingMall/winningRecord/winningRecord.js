var app = getApp();

Page({
    data: {
        menuTapCurrent: 0,
        page: 1,
        page1: 1,
        page2: 1,
        page3: 1,
        pagesize: 10,
        list: [],
        send: [],
        complete: [],
        lid: "",
        lottery_type: ""
    },
    onLoad: function(a) {
        var t = a.check_type;
        0 < t || (t = 0), this.setData({
            menuTapCurrent: t
        }), this.getMyOrder();
    },
    getMyOrder: function() {
        var o = this, a = wx.getStorageSync("user").openid, s = o.data.page, d = (o.data.pagesize, 
        o.data.all), t = o.data.menuTapCurrent;
        app.util.request({
            url: "entry/wxapp/getMyOrder",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: a,
                page: o.data.page,
                pagesize: o.data.pagesize,
                type: t,
                lid: 2
            },
            showLoading: !1,
            success: function(a) {
                var t = a.data.data.length == o.data.pagesize;
                if (1 == s) d = a.data.data; else for (var e in a.data.data) d.push(a.data.data[e]);
                s += 1, console.log(s), o.setData({
                    all: d,
                    imgroot: a.data.other.img_root,
                    page: s,
                    hasMore: t
                });
            }
        });
    },
    getALL: function() {
        var o = this, a = wx.getStorageSync("user").openid, s = o.data.page, d = (o.data.pagesize, 
        o.data.all);
        app.util.request({
            url: "entry/wxapp/getMyOrder",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: a,
                page: o.data.page,
                pagesize: o.data.pagesize,
                lid: 2
            },
            showLoading: !1,
            success: function(a) {
                console.log("订单全部"), console.log(a.data.data);
                var t = a.data.data.length == o.data.pagesize;
                if (1 == s) d = a.data.data; else for (var e in a.data.data) d.push(a.data.data[e]);
                s += 1, console.log("你的页面是多少"), console.log(s), console.log(), o.setData({
                    all: d,
                    imgroot: a.data.other.img_root,
                    page: s,
                    hasMore: t
                });
            }
        });
    },
    getSend: function() {
        var o = this, a = wx.getStorageSync("user").openid, s = o.data.page2, d = (o.data.pagesize, 
        o.data.send);
        app.util.request({
            url: "entry/wxapp/getMyOrder",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: a,
                type: 2,
                page2: o.data.page2,
                pagesize: o.data.pagesize,
                lid: 2
            },
            showLoading: !1,
            success: function(a) {
                console.log("中奖待发货"), console.log(a);
                var t = a.data.data.length == o.data.pagesize;
                if (1 == s) d = a.data.data; else for (var e in a.data.data) d.push(a.data.data[e]);
                s += 1, o.setData({
                    send: d,
                    imgroot: a.data.other.img_root,
                    page2: s,
                    hasMore: t
                });
            }
        });
    },
    getComplete: function() {
        var o = this, a = wx.getStorageSync("user").openid, s = o.data.page3, d = (o.data.pagesize, 
        o.data.complete);
        app.util.request({
            url: "entry/wxapp/getMyOrder",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: a,
                type: 3,
                page3: o.data.page3,
                pagesize: o.data.pagesize,
                lid: 2
            },
            showLoading: !1,
            success: function(a) {
                console.log(a), console.log("订单全部");
                var t = a.data.data.length == o.data.pagesize;
                if (1 == s) d = a.data.data; else for (var e in a.data.data) d.push(a.data.data[e]);
                s += 1, o.setData({
                    complete: d,
                    imgroot: a.data.other.img_root,
                    page3: s,
                    hasMore: t
                });
            }
        });
    },
    menuTap: function(a) {
        var t = a.currentTarget.dataset.current;
        this.setData({
            menuTapCurrent: t,
            page: 1
        }), this.getMyOrder();
    },
    lower: function(a) {
        this.data.hasMore ? this.getMyOrder() : wx.showToast({
            title: "没有更多订单啦~",
            icon: "none"
        });
    },
    onReachBottom: function() {
        this.data.hasMore ? this.getMyOrder() : wx.showToast({
            title: "没有更多订单啦~",
            icon: "none"
        });
    },
    productsDetails: function(a) {
        var t = a.currentTarget.dataset.id, e = a.currentTarget.dataset.oid, o = a.currentTarget.dataset.lottery_type;
        console.log("你的oid是多少"), console.log(e), 2 != o && wx.navigateTo({
            url: "../productsDetails/productsDetails?id=" + t + "&oid=" + e
        });
    },
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    }
});