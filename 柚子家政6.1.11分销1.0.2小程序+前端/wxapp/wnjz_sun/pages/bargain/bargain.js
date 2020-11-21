var app = getApp(), Page = require("../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

function count_down(a, t, n) {
    parseInt(n);
    var o = a.data.bargainList, e = t - Date.parse(new Date());
    if (o[n].clock = date_format(e), e <= 0) return o[n].clock = "已经截止", void a.setData({
        bargainList: o
    });
    setTimeout(function() {
        e -= 100, count_down(a, a.data.bargainList[n].endtime, n);
    }, 100), a.setData({
        bargainList: o
    });
}

function date_format(a) {
    var t = Math.floor(a / 1e3), n = Math.floor(t / 3600 / 24), o = Math.floor((t - 60 * n * 60 * 24) / 3600), e = Math.floor(t / 3600), r = fill_zero_prefix(Math.floor((t - 3600 * e) / 60));
    return "还剩" + n + "天" + o + "时" + r + "分" + fill_zero_prefix(t - 3600 * e - 60 * r) + "秒";
}

function fill_zero_prefix(a) {
    return a < 10 ? "0" + a : a;
}

Page({
    data: {
        imgUrls: [],
        bargainList: [],
        url: [],
        indicatorDots: !1,
        autoplay: !1,
        interval: 3e3,
        duration: 800,
        isIpx: app.globalData.isIpx,
        whichone: 4
    },
    onLoad: function(a) {
        app.editTabBar();
        var e = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var r = wx.getStorageSync("system"), t = wx.getStorageSync("build_id");
        console.log(r), app.util.request({
            url: "entry/wxapp/Kanjia",
            data: {
                build_id: t
            },
            success: function(a) {
                console.log(a.data);
                var t = a.data;
                e.setData({
                    bargainList: t,
                    bargain_open: r.is_bargainopen
                }), e.getUrl();
                for (var n = t.length, o = 0; o < n; o++) count_down(e, e.data.bargainList[o].endTime, o);
            }
        });
    },
    onReady: function() {
        app.getNavList(2);
    },
    onShow: function() {},
    getUrl: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(a) {
                wx.setStorageSync("url", a.data), t.setData({
                    url: a.data
                }), t.getBannerd();
            }
        });
    },
    getBannerd: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/KanBanner",
            cachetime: "0",
            success: function(a) {
                t.setData({
                    imgUrls: a.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    join: function(a) {
        var t = wx.getStorageSync("openid"), n = a.currentTarget.dataset.id;
        console.log(n), app.util.request({
            url: "entry/wxapp/Kanjiaorder",
            data: {
                id: n,
                openid: t
            },
            success: function(a) {
                console.log(a);
            }
        });
    }
});