/*   time:2019-08-09 13:18:40*/
var app = getApp();
Page({
    data: {
        list: [],
        content: [],
        opacity: 0,
        oid: ""
    },
    onLoad: function(t) {
        var e = this,
            a = t.fid,
            n = t.bid,
            i = wx.getStorageSync("openid");
        a && n && i && app.util.request({
            url: "entry/wxapp/GetUserFission",
            showLoading: !1,
            data: {
                fid: a,
                bid: n,
                openid: i,
                type: 1,
                m: app.globalData.Plugin_fission
            },
            success: function(t) {
                if (console.log(t.data), t.data.use) {
                    for (var a = 0; a < t.data.use.length; a++) t.data.use[a].opacity = 1 - a / 10, t.data.use[a].index = 2 * (5 - a), t.data.use[a].left = 60 * a, t.data.use[a].scale = 1 - a / 10;
                    e.setData({
                        content: t.data,
                        list: t.data.use
                    })
                } else e.setData({
                    content: [],
                    list: []
                })
            }
        })
    },
    onReady: function() {},
    onShow: function(t) {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    touchstart: function(t) {
        this.setData({
            startPoint: [t.touches[0].pageX, t.touches[0].pageY]
        })
    },
    touchend: function(t) {
        var a = [t.changedTouches[0].pageX, t.changedTouches[0].pageY],
            e = this.data.startPoint;
        if (20 < e[0] - a[0]) {
            wx.createAnimation({
                duration: 1e3,
                timingFunction: "ease"
            });
            var n = this.data.list;
            console.log(n);
            var i = n.pop();
            n.unshift(i);
            for (var o = 0; o < n.length; o++) n[o].opacity = 1 - o / 10, n[o].index = 2 * (5 - o), n[o].left = 60 * o, n[o].scale = 1 - o / 10;
            this.setData({
                list: n
            }), this.onShow(n)
        }
        if (e[0] - a[0] < 20) {
            wx.createAnimation({
                duration: 1e3,
                timingFunction: "ease"
            }), i = (n = this.data.list).pop();
            n.unshift(i), console.log(n);
            for (o = 0; o < n.length; o++) n[o].opacity = 1 - o / 10, n[o].index = 2 * (5 - o), n[o].left = 60 * o, n[o].scale = 1 - o / 10;
            this.setData({
                list: n
            }), this.onShow(n)
        }
    },
    toWithdraw: function(t) {
        var a = this.data.list[0],
            e = parseInt(a.id),
            n = parseInt(a.bid);
        wx.navigateTo({
            url: "/mzhk_sun/plugin/fission/withdraw/withdraw?oid=" + e + "&bid=" + n
        })
    },
    getAddress: function(t) {
        var a = t.currentTarget.dataset.lat,
            e = t.currentTarget.dataset.lng,
            n = t.currentTarget.dataset.address;
        wx.openLocation({
            latitude: a - 0,
            longitude: e - 0,
            address: n,
            scale: 28
        })
    }
});