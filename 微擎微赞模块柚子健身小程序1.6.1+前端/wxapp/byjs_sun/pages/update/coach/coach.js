function _defineProperty(a, t, e) {
    return t in a ? Object.defineProperty(a, t, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = e, a;
}

var app = getApp();

Page({
    data: {
        showpaly: !1,
        palylist: [],
        palylistIndex: 1,
        coach: [],
        list: [ {
            shop: "柚子健身集美店",
            coach: []
        } ]
    },
    onLoad: function(a) {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(a) {
                wx.setStorageSync("url", a.data), t.setData({
                    url: a.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetMall",
            data: {
                op: 1
            },
            cachetime: "0",
            success: function(a) {
                t.setData({
                    list: a.data
                });
            }
        });
        var e = t.data.list;
        if (1 == e.length) e[0].xiala = !0; else for (var c = 0; c < e.length; c++) e[c].xiala = !1;
        t.setData({
            list: e
        }), app.util.request({
            url: "entry/wxapp/GetMallCoach",
            cachetime: "0",
            success: function(a) {
                t.setData({
                    coach: a.data
                });
            }
        });
    },
    showPlay: function(a) {
        var t = this, e = a.currentTarget.dataset.id, c = a.currentTarget.dataset.index, l = t.data.list, n = l[c].xiala, i = "list[" + c + "].xiala";
        t.setData(_defineProperty({}, i, !n)), app.util.request({
            url: "entry/wxapp/GetMallCoach",
            data: {
                id: e
            },
            cachetime: "0",
            success: function(a) {
                console.log("教练"), console.log(a.data), l[c].coach = a.data, console.log(l), t.setData({
                    list: l
                });
            }
        });
    },
    goCoachdetail: function(a) {
        var t = a.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../coachdetail/coachdetail?id=" + t
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});