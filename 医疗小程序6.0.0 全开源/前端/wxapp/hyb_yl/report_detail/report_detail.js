var app = getApp();

Page({
    data: {
        navTab: [ {
            con: "耳"
        }, {
            con: "鼻喉"
        }, {
            con: "鼻"
        }, {
            con: "喉"
        }, {
            con: "耳鼻喉"
        }, {
            con: "耳喉"
        }, {
            con: "鼻喉"
        }, {
            con: "耳鼻喉"
        } ],
        infoarr: [],
        current: 0,
        reportArr: [ {
            title: "血常规五类",
            project: [ {
                title: "白细胞",
                values: "5.51  10^9/L",
                now: 126,
                lowStandard: 125,
                highStandard: 250
            }, {
                title: "血小板",
                values: "369  10^9/L",
                now: 369,
                lowStandard: 125,
                highStandard: 350
            } ]
        }, {
            title: "血常规五类",
            project: [ {
                title: "白细胞",
                values: "5.51  10^9/L",
                now: 300,
                lowStandard: 125,
                highStandard: 350
            }, {
                title: "血小板",
                values: "369  10^9/L",
                now: 349,
                lowStandard: 125,
                highStandard: 350
            }, {
                title: "血小板",
                images: "/hyb_yl/images/active_01.jpg",
                state: "normal"
            }, {
                title: "血小板",
                images: "/hyb_yl/images/active_01.jpg",
                state: "abnormal"
            } ]
        } ],
        pageWrapCount: []
    },
    onLoad: function(a) {
        var t = a.hzid, n = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: n
        }), this.setData({
            hzid: t
        }), this.getBginfo(0);
    },
    navTab: function(a) {
        var t = this;
        if (t.removal(t.data.pageWrapCount, a.currentTarget.dataset.index)) t.setData({
            current: a.currentTarget.dataset.index
        }); else {
            for (var n = t.data.arrs, r = [], e = 0; e < n[a.currentTarget.dataset.index].data.length; e++) r.push(n[a.currentTarget.dataset.index].data[e][0]);
            app.globalData.reportArr = r, t.setData({
                pageWrapCount: t.data.pageWrapCount.concat([ a.currentTarget.dataset.index ]),
                current: a.currentTarget.dataset.index
            });
        }
    },
    removal: function(a, t) {
        for (var n = 0, r = a.length; n < r; n++) if (t == a[n]) return !0;
        return !1;
    },
    abnormalClick: function() {
        wx.navigateTo({
            url: "/hyb_yl/abnormal/abnormal"
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    getBginfo: function(i) {
        var d = this, a = d.data.hzid, l = d.data.infoarr;
        app.util.request({
            url: "entry/wxapp/Bginfo",
            data: {
                hzid: a
            },
            success: function(a) {
                console.log(a, i);
                for (var t = a.data.data, n = [], r = 0, e = t.length; r < e; r++) l.push(t[r].name);
                for (var o = 0; o < t[0].data.length; o++) n.push(t[0].data[o][0]);
                app.globalData.reportArr = n, d.setData({
                    pageWrapCount: d.data.pageWrapCount.concat([ i ]),
                    infoarr: l,
                    arrs: t
                });
            }
        });
    }
});