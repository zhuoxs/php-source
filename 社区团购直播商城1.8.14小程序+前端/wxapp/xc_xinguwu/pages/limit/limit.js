var app = getApp();

Page({
    data: {
        curIndex: 0,
        list: null
    },
    bindTap: function(t) {
        var a = parseInt(t.currentTarget.dataset.index);
        this.setData({
            curIndex: a
        }), this.settimedown();
    },
    onLoad: function(t) {
        var s = this;
        this.setData({
            "goHome.blackhomeimg": app.globalData.blackhomeimg
        }), app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !1,
            data: {
                op: "flash_sale"
            },
            success: function(t) {
                var a = t.data;
                if (console.log(a.data.list), a.data.list) {
                    for (var n = a.data.list, e = 0, o = n.length; e < o; e++) if (2 == n[e].stus) {
                        s.setData({
                            curIndex: e
                        });
                        break;
                    }
                    s.setData({
                        list: a.data.list
                    }), s.settimedown();
                }
            }
        });
    },
    settimedown: function() {
        var t = this.data.list, a = this.data.curIndex, n = new app.util.date(), e = n.dateToLong(new Date());
        if (2 == t[a].stus) var o = t[a].date_end; else {
            if (3 != t[a].stus) return;
            o = t[a].date_start;
        }
        o = n.dateToLong(new Date(app.look.change_date(o))), o = Math.floor((o - e) / 1e3), 
        this.countDown(o);
    },
    onReady: function() {
        app.look.navbar(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var s = this;
        app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !0,
            data: {
                op: "flash_sale"
            },
            success: function(t) {
                wx.stopPullDownRefresh();
                var a = t.data;
                if (console.log(a.data.list), a.data.list) {
                    for (var n = a.data.list, e = 0, o = n.length; e < o; e++) if (2 == n[e].stus) {
                        s.setData({
                            curIndex: e
                        });
                        break;
                    }
                    s.setData({
                        list: n
                    }), s.settimedown();
                }
            }
        });
    },
    onReachBottom: function() {},
    toBuy: function(t) {
        var a = this, n = t.currentTarget.dataset.index;
        if (2 == a.data.list[a.data.curIndex].stus && parseInt(a.data.list[a.data.curIndex].contents[n].sale) < parseInt(a.data.list[a.data.curIndex].contents[n].limitnum)) {
            var e = a.data.list[a.data.curIndex].contents[n].id;
            wx.navigateTo({
                url: "../limitDetail/limitDetail?id=" + e
            });
        }
    },
    onShareAppMessage: function(t) {
        wx.showShareMenu({
            withShareTicket: !0
        });
        var a = "", n = "";
        if (app.look.istrue(app.globalData.webset.webname) && (n = app.globalData.webset.webname), 
        "menu" == t.from) return a = "/" + this.route, {
            title: n,
            path: "/xc_xinguwu/pages/base/base?share=" + (a = encodeURIComponent(a)) + "&userid=" + app.globalData.userInfo.id,
            imageUrl: "",
            success: function(t) {
                wx.showToast({
                    title: "转发成功"
                });
            },
            fail: function(t) {}
        };
    },
    countDown: function(d, t) {
        var c = this;
        clearInterval(this.data.interval);
        var h = setInterval(function() {
            var t = d, a = Math.floor(t / 3600 / 24), n = a.toString();
            1 == n.length && (n = "0" + n);
            var e = Math.floor((t - 3600 * a * 24) / 3600), o = e.toString();
            1 == o.length && (o = "0" + o);
            var s = Math.floor(t / 3600).toString();
            1 == s.length && (s = "0" + s);
            var i = Math.floor((t - 3600 * a * 24 - 3600 * e) / 60), r = i.toString();
            1 == r.length && (r = "0" + r);
            var l = (t - 3600 * a * 24 - 3600 * e - 60 * i).toString();
            if (1 == l.length && (l = "0" + l), c.setData({
                countHour: s,
                countDownDay: n,
                countDownHour: o,
                countDownMinute: r,
                countDownSecond: l
            }), --d < 0) {
                if (clearInterval(h), 2 == c.data.list[c.data.curIndex].stus && wx.showToast({
                    title: "活动已结束"
                }), 3 == c.data.list[c.data.curIndex].stus) {
                    var u = c.data.list;
                    u[c.data.curIndex].stus = 2, c.setData({
                        list: u
                    });
                }
                c.setData({
                    countHour: "00",
                    countDownDay: "00",
                    countDownHour: "00",
                    countDownMinute: "00",
                    countDownSecond: "00"
                });
            }
        }.bind(c), 1e3);
        c.setData({
            interval: h
        });
    }
});