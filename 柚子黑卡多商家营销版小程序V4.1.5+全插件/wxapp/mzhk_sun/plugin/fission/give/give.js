/*   time:2019-08-09 13:18:40*/
var app = getApp();
Page({
    data: {
        list: [],
        content: [],
        opacity: 0
    },
    onLoad: function(t) {
        var e = this,
            a = t.fid,
            i = t.bid,
            o = wx.getStorageSync("openid");
        console.log(a + i + o), a && i && o && app.util.request({
            url: "entry/wxapp/GetUserFission",
            showLoading: !1,
            data: {
                fid: a,
                bid: i,
                openid: o,
                type: 3,
                m: app.globalData.Plugin_fission
            },
            success: function(t) {
                if (console.log(t.data), t.data.give) {
                    for (var a = 0; a < t.data.give.length; a++) t.data.give[a].opacity = 1 - a / 10, t.data.give[a].index = 2 * (5 - a), t.data.give[a].left = 60 * a, t.data.give[a].scale = 1 - a / 10;
                    e.setData({
                        content: t.data,
                        list: t.data.give
                    })
                } else e.setData({
                    content: [],
                    list: []
                })
            }
        })
    },
    onShow: function() {},
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
            var i = (n = this.data.list).pop();
            n.unshift(i), console.log(n);
            for (var o = 0; o < n.length; o++) n[o].opacity = 1 - o / 10, n[o].index = 2 * (5 - o), n[o].left = 60 * o, n[o].scale = 1 - o / 10;
            this.setData({
                list: n
            })
        }
        if (e[0] - a[0] < 20) {
            var n;
            wx.createAnimation({
                duration: 1e3,
                timingFunction: "ease"
            }), i = (n = this.data.list).pop();
            n.unshift(i), console.log(n);
            for (o = 0; o < n.length; o++) n[o].opacity = 1 - o / 10, n[o].index = 2 * (5 - o), n[o].left = 60 * o, n[o].scale = 1 - o / 10;
            this.setData({
                list: n
            })
        }
        this.onShow()
    },
    onShareAppMessage: function(t) {
        var a = wx.getStorageSync("users"),
            e = this.data.content,
            i = e.fid,
            o = e.bid,
            n = e.give[0].fname,
            s = e.give[0].order_id;
        return "button" === t.from && console.log(t.target), {
            title: n,
            path: "/mzhk_sun/plugin/fission/detail/detail?id=" + i + "&bid=" + o + "&user_id=" + a.id + "&order_id=" + s + "&is_share=1",
            success: function(t) {
                console.log("转发成功")
            },
            fail: function(t) {
                console.log("转发失败")
            }
        }
    }
});