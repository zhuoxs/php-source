function a() {
    var a = getCurrentPages();
    return a[a.length - 1];
}

Object.defineProperty(exports, "__esModule", {
    value: !0
});

var t = new getApp(), e = {
    getThisMonthDays: function(a, t) {
        return new Date(a, t, 0).getDate();
    },
    getFirstDayOfWeek: function(a, t) {
        return new Date(Date.UTC(a, t - 1, 1)).getDay();
    },
    getNowday: function() {
        var a = new Date();
        return a.getFullYear() + "/" + (a.getMonth() + 1) + "/" + a.getDate();
    },
    calculateEmptyGrids: function(a, t) {
        var r = e.getFirstDayOfWeek(a, t), n = [];
        if (r > 0) {
            for (var s = 0; s < r; s++) n.push(s);
            this.setData({
                "calendar.hasEmptyGrid": !0,
                "calendar.empytGrids": n
            });
        } else this.setData({
            "calendar.hasEmptyGrid": !1,
            "calendar.empytGrids": []
        });
    },
    calculateDays: function(a, t) {
        var r = [], n = e.getThisMonthDays(a, t), s = e.getNowday();
        s = new Date(s);
        for (var d = 1; d <= n; d++) {
            var c = a + "/" + t + "/" + d;
            c = new Date(c);
            var i = void 0;
            i = !(s.getTime() - c.getTime() > 0), r.push({
                day: d,
                choosed: !1,
                size: i,
                sign: !1
            });
        }
        this.setData({
            "calendar.days": r
        });
    },
    handleCalendar: function(a) {
        var r = a.currentTarget.dataset.handle, n = this.data.calendar.curYear, s = this.data.calendar.curMonth, d = 0, c = 0;
        "prev" === r ? (c = n, (d = s - 1) < 1 && (c = n - 1, d = 12), e.calculateDays.call(this, c, d), 
        e.calculateEmptyGrids.call(this, c, d), this.setData({
            "calendar.curYear": c,
            "calendar.curMonth": d
        })) : (c = n, (d = s + 1) > 12 && (c = n + 1, d = 1), e.calculateDays.call(this, c, d), 
        e.calculateEmptyGrids.call(this, c, d), this.setData({
            "calendar.curYear": c,
            "calendar.curMonth": d
        }));
        var i = wx.getStorageSync("kundian_farm_uid"), l = t.siteInfo.uniacid, o = this, u = o.data.calendar;
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "sign",
                op: "getChangeSign",
                uid: i,
                uniacid: l,
                year: c,
                month: d
            },
            success: function(a) {
                if (console.log(a), a.data.signData) {
                    for (var t = a.data.signData, e = 0; e < u.days.length; e++) for (var r = 0; r < t.length; r++) u.days[e].day == t[r].day && (u.days[e].choosed = !0, 
                    u.days[e].sign = !0);
                    o.setData({
                        calendar: u
                    });
                }
            }
        });
    },
    tapDayItem: function(a) {
        var r = a.currentTarget.dataset.idx, n = this.data.calendar.days, s = this.data.calendar.curYear + "/" + this.data.calendar.curMonth + "/" + n[r].day;
        console.log(s), s = new Date(s);
        var d = e.getNowday();
        if ((d = new Date(d)).getTime() - s.getTime() == 0) {
            n[r].choosed = !n[r].choosed, this.setData({
                "calendar.days": n
            });
            var c = this.data.calendar.curYear, i = this.data.calendar.curMonth, l = n[r].day, o = wx.getStorageSync("kundian_farm_uid"), u = t.siteInfo.uniacid, h = this;
            t.util.request({
                url: "entry/wxapp/class",
                data: {
                    control: "sign",
                    op: "addSign",
                    uid: o,
                    uniacid: u,
                    year: c,
                    month: i,
                    day: l
                },
                success: function(a) {
                    console.log(a), 1 == a.data.code ? (wx.showToast({
                        title: "签到成功"
                    }), h.setData({
                        userData: a.data.userData,
                        is_sign: 1
                    })) : 2 == a.data.code ? wx.showToast({
                        title: "签到失败"
                    }) : 3 == a.data.code ? wx.showToast({
                        title: "今日已签到"
                    }) : wx.showToast({
                        title: "签到失败1"
                    });
                }
            });
        }
    }
};

exports.default = function() {
    var t = a(), r = new Date(), n = r.getFullYear(), s = r.getMonth() + 1, d = [ "日", "一", "二", "三", "四", "五", "六" ];
    t.setData({
        calendar: {
            curYear: n,
            curMonth: s,
            weeksCh: d,
            hasEmptyGrid: !1
        }
    }), e.calculateEmptyGrids.call(t, n, s), e.calculateDays.call(t, n, s), t.tapDayItem = e.tapDayItem.bind(t), 
    t.handleCalendar = e.handleCalendar.bind(t);
};