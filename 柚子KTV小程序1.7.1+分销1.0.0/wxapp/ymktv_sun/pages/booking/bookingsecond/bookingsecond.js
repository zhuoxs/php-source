var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        dateArrays_time: []
    },
    onLoad: function(e) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.setStorageSync("bid", e.bid), wx.setStorageSync("gid", e.gid), wx.setStorageSync("spec", e.spec);
    },
    goBookdingorder: function() {
        var e = this, t = wx.getStorageSync("bid"), a = e.data.useindex;
        e.data.lenData.price || wx.showToast({
            title: "请选择时间",
            icon: "none",
            duration: 2e3
        });
        var i = e.data.lenData.price, s = e.data.spec, r = e.data.dateArrays_time, n = (e.data.times, 
        e.data.gid), d = e.data.newuseAtime[a], o = e.data.newuseNtime[a], c = e.data.date_dr[a], p = e.data.date_cr[a];
        console.log(d), d ? wx.navigateTo({
            url: "../bookdingorder/bookdingorder?bid=" + t + "&price=" + i + "&spec=" + s + "&dateArrays_time=" + r + "&newuseAtime=" + d + "&newuseNtime=" + o + "&date_dr=" + c + "&date_cr=" + p + "&gid=" + n
        }) : wx.showToast({
            title: "请选择时间",
            icon: "none",
            duration: 2e3
        });
    },
    chosetime: function(e) {
        var y = this, t = wx.getStorageSync("bid"), a = e.currentTarget.dataset.index, i = y.data.timeindex, s = (y.data.dateArrays[a], 
        y.data.dateArrays_timies[a]);
        i = a;
        var r = new Date(), x = r.getHours(), n = Date.parse(r), D = wx.getStorageSync("gid"), S = wx.getStorageSync("spec");
        console.log(x), console.log(n), console.log(S);
        var d = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Lengthtime",
            cachetime: "0",
            data: {
                gid: D,
                spec: S,
                dateArrays_time: s,
                gettime: n,
                bid: t,
                openid: d
            },
            success: function(e) {
                console.log(e.data);
                var t = parseInt(S);
                if (console.log(t), 1 == e.data.overtype) var a = t; else a = 0;
                for (var i = {
                    date: [],
                    is_qi: []
                }, s = {
                    date: [],
                    is_qi: []
                }, r = [], n = [], d = [], o = [], c = e.data.or, p = 0, g = parseInt(e.data.valb); g < parseInt(e.data.valc) + 1 - t; g++, 
                p++) if (0 < c.length) for (var _ = 0; _ < c.length; _++) {
                    if (23 < g) {
                        var l = "次日" + (g - 24);
                        if (i.date[p] = l, r[p] = g - 24, d[p] = "次日", "当日" == c[_].date_dr && "当日" == c[_].date_cr) var u = parseInt(c[_].timie), m = parseInt(c[_].times); else if ("当日" == c[_].date_dr && "次日" == c[_].date_cr) u = parseInt(c[_].timie), 
                        m = parseInt(24) + parseInt(c[_].times); else u = 0 == parseInt(c[_].timie) ? parseInt(24) : parseInt(c[_].timie) + parseInt(24), 
                        m = parseInt(24) + parseInt(c[_].times);
                        if (1 == e.data.a) if (x < g + a && 1 == e.data.a) u < g && g < m || u < g + t && g + t < m || g == u ? i.is_qi[p] = 2 : 1 != i.is_qi[p] && 2 != i.is_qi[p] && (i.is_qi[p] = 0); else if (1 == e.data.a) i.is_qi[p] = 1; else {
                            if ("次日" == c[_].date_dr) u = 0 == parseInt(c[_].timie) ? parseInt(0) : parseInt(c[_].timie), 
                            m = parseInt(u) + parseInt(t); else if ("次日" == c[_].date_cr) u = parseInt(0), m = parseInt(u) + parseInt(t);
                            u < g && g < m || u < g + t && g + t < m || g == u ? i.is_qi[p] = 2 : 1 != i.is_qi[p] && 2 != i.is_qi[p] && (i.is_qi[p] = 0);
                        } else (u < g && g < m || u < g + t && g + t < m || g == u) && 1 == c[_].iscurrent ? i.is_qi[p] = 2 : (u < g + 24 && g + 24 < m || u < g + 24 + t && g + 24 + t < m || g + 24 == u) && 0 == c[_].iscurrent ? i.is_qi[p] = 2 : 1 != i.is_qi[p] && 2 != i.is_qi[p] && (i.is_qi[p] = 0);
                    } else {
                        l = "当日" + g;
                        if (i.date[p] = l, r[p] = g, (d[p] = "当日") == c[_].date_dr && "当日" == c[_].date_cr) u = parseInt(c[_].timie), 
                        m = parseInt(c[_].times); else if ("当日" == c[_].date_dr && "次日" == c[_].date_cr) u = parseInt(c[_].timie), 
                        m = parseInt(24) + parseInt(c[_].times); else u = 0 == parseInt(c[_].timie) ? parseInt(24) : parseInt(c[_].timie) + parseInt(24), 
                        m = parseInt(24) + parseInt(c[_].times);
                        if (1 == e.data.a) if (x < g + a) u < g && g < m || u < g + t && g + t < m || g == u ? i.is_qi[p] = 2 : 1 != i.is_qi[p] && 2 != i.is_qi[p] && (i.is_qi[p] = 0); else if (1 == e.data.a) i.is_qi[p] = 1; else {
                            if ("次日" == c[_].date_dr) u = 0 == parseInt(c[_].timie) ? parseInt(0) : parseInt(c[_].timie), 
                            m = parseInt(u) + parseInt(t); else if ("次日" == c[_].date_cr) u = parseInt(0), m = parseInt(u) + parseInt(t);
                            u < g && g < m || u < g + t && g + t < m || g == u ? i.is_qi[p] = 2 : 1 != i.is_qi[p] && 2 != i.is_qi[p] && (i.is_qi[p] = 0);
                        } else (u < g && g < m || u < g + t && g + t < m || g == u) && 1 == c[_].iscurrent ? i.is_qi[p] = 2 : (u < g + 24 && g + 24 < m || u < g + 24 + t && g + 24 + t < m || g + 24 == u) && 0 == c[_].iscurrent ? i.is_qi[p] = 2 : 1 != i.is_qi[p] && 2 != i.is_qi[p] && (i.is_qi[p] = 0);
                    }
                    if (23 < g + t) {
                        var q = "次日" + (I = g + t - 24);
                        s.date[p] = q, n[p] = g + t - 24, o[p] = "次日";
                    } else {
                        var I = "当日" + (g + t);
                        s.date[p] = I, n[p] = g + t, o[p] = "当日";
                    }
                    console.log(i), console.log(g), console.log(g + t), console.log(i);
                } else {
                    if (23 < g) {
                        l = "次日" + (g - 24);
                        i.date[p] = l, r[p] = g - 24, d[p] = "次日", x < g + a ? i.is_qi[p] = 0 : 1 == e.data.a ? i.is_qi[p] = 1 : i.is_qi[p] = 0;
                    } else {
                        l = "当日" + g;
                        i.date[p] = l, r[p] = g, d[p] = "当日", x < g + a ? i.is_qi[p] = 0 : 1 == e.data.a ? i.is_qi[p] = 1 : i.is_qi[p] = 0;
                    }
                    if (23 < g + t) {
                        q = "次日" + (I = g + t - 24);
                        s.date[p] = q, n[p] = g + t - 24, o[p] = "次日";
                    } else {
                        I = "当日" + (g + t);
                        s.date[p] = I, n[p] = g + t, o[p] = "当日";
                    }
                }
                var f = [], h = [], w = {
                    date: [],
                    is_qi: []
                };
                for (p = 0; p < i.date.length; p++) f.push(r[p] + ":00"), h.push(n[p] + ":00"), 
                w.date.push(i.date[p] + ":00-" + s.date[p] + ":00"), w.is_qi.push(i.is_qi[p]);
                console.log(w);
                var v = w[0];
                y.setData({
                    lenData: e.data,
                    spec: S,
                    newdurning: w,
                    times: v,
                    gid: D,
                    newuseAtime: f,
                    newuseNtime: h,
                    date_dr: d,
                    date_cr: o
                });
            }
        }), y.setData({
            timeindex: i,
            dateArrays_time: s
        });
    },
    choseprice: function(e) {
        var t = e.currentTarget.dataset.index, a = this.data.priceindex, i = this.data.newdurning.date[t];
        0 == this.data.newdurning.is_qi[t] && (a = t, this.setData({
            useindex: t,
            priceindex: a,
            times: i
        }));
    },
    onReady: function() {},
    onShow: function() {
        var e = [ "周日", "周一", "周二", "周三", "周四", "周五", "周六" ], t = new Date();
        t.setDate(t.getDate());
        for (var a, i = [], s = [], r = 0; r < 4; r++) {
            var n = "", d = "";
            n = t.getMonth() + 1 < 10 ? "0" + (t.getMonth() + 1) : t.getMonth() + 1, d = t.getDate() < 10 ? "0" + t.getDate() : t.getDate(), 
            a = 0 == r ? n + "月" + d + "日 今天" : 1 == r ? n + "月" + d + "日 明天" : n + "月" + d + "日 " + e[t.getDay()], 
            i.push(a), s.push(Date.parse(t)), console.log(s), t.setDate(t.getDate() + 1);
        }
        var o = i[0];
        this.setData({
            dateArrays: i,
            timeData: o,
            dateArrays_time: s[0],
            dateArrays_timies: s
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});