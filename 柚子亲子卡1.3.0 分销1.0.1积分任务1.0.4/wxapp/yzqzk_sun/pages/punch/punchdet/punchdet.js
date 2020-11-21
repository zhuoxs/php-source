var _DataService = require("../../../../style/utils/DataService"), _DataService2 = _interopRequireDefault(_DataService), _Config = require("../../../../style/utils/Config"), _util = require("../../../../style/utils/util");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var app = getApp();

function changeDate(t) {
    var a, e, n, o, r, i = t || new Date(), s = new Date(), c = void 0, d = [];
    n = i.getDate(), a = i.getMonth() + 1, e = i.getFullYear(), i.getDay(), r = new Date(e, a, 0).getDate(), 
    i.setDate(1), o = i.getDay(), i.setDate(r);
    var u, l, h, g, f = 0, D = 0, p = 0;
    l = 1 === a ? 12 : a - 1, u = 1 === a ? e - 1 : e, g = 12 === a ? 1 : a + 1, h = 12 === a ? e + 1 : e, 
    0 != (c = i.getDay()) ? D = 7 - c : c = 0;
    var w = r + (f = 0 != o ? o - 1 : 6) + D;
    w <= 35 && (D += 42 - w);
    var v = this.data.data.selected || {
        year: e,
        month: a,
        date: n
    }, y = v.year + "年" + (0, _util.formatNumber)(v.month) + "月" + (0, _util.formatNumber)(v.date) + "日";
    d = {
        currentDate: s.getDate(),
        currentYear: s.getFullYear(),
        currentDay: s.getDay(),
        currentMonth: s.getMonth() + 1,
        showMonth: a,
        showDate: n,
        showYear: e,
        beforeYear: u,
        beforMonth: l,
        afterYear: h,
        afterMonth: g,
        selected: v,
        selectDateText: y
    };
    var m = [], _ = 0;
    if (0 < f) {
        p = new Date(u, l, 0).getDate();
        for (var T = 0; T < f; T++) m.unshift({
            _id: _,
            year: u,
            month: l,
            date: p - T
        }), _++;
    }
    for (var k = 1; k <= r; k++) m.push({
        _id: _,
        active: v.year == e && v.month == a && v.date == k,
        year: e,
        month: a,
        date: k
    }), _++;
    if (0 < D) for (var x = 1; x <= D; x++) m.push({
        _id: _,
        year: h,
        month: g,
        date: x
    }), _++;
    d.dates = m, this.setData({
        data: d,
        pickerDateValue: e + "-" + a,
        dates: m,
        year: e,
        month: this.months(a)
    }), this.get_punch();
}

Page({
    data: {
        navTile: "打卡",
        data: {},
        selectDateText: "",
        updatePanelTop: 1e4,
        updatePanelAnimationData: {},
        todoInputValue: "",
        todoTextAreaValue: "",
        arr: [],
        curDay: "",
        totalDay: "",
        showGift: !1,
        isCurPunch: !1
    },
    onLoad: function(t) {
        var a = this, e = wx.getStorageSync("setting");
        e ? wx.setNavigationBarColor({
            frontColor: e.fontcolor,
            backgroundColor: e.color
        }) : app.get_setting(!0).then(function(t) {
            wx.setNavigationBarColor({
                frontColor: t.fontcolor,
                backgroundColor: t.color
            });
        }), wx.setNavigationBarTitle({
            title: a.data.navTile
        }), app.get_imgroot().then(function(t) {
            a.setData({
                imgroot: t
            });
        }), (0, _util.promiseHandle)(wx.getSystemInfo).then(function(t) {
            a.setData({
                updatePanelTop: t.windowHeight
            });
        }), changeDate.call(this);
        a.data.arr, a.data.data.dates;
        var n = new Date(), o = n.getFullYear(), r = a.months(n.getMonth() + 1), i = a.months(n.getDate());
        a.setData({
            years: o,
            month: r,
            today: i,
            task_id: t.id
        }), console.log(r);
    },
    months: function(t) {
        return t < 10 ? "0" + t : t;
    },
    get_punch: function() {
        var n = this;
        app.get_openid().then(function(e) {
            app.util.request({
                url: "entry/wxapp/getPunchTaskDetail",
                cachetime: "0",
                data: {
                    openid: e,
                    task_id: n.data.task_id,
                    year: n.data.years,
                    month: n.data.month
                },
                success: function(t) {
                    console.log(t.data);
                    var a = t.data;
                    n.setData({
                        task: a,
                        baby: t.data,
                        arr: a.record,
                        openid: e
                    }), console.log(n.data.arr), n.ArrayCombine();
                }
            });
        });
    },
    onReady: function() {},
    onShow: function() {
        this.get_punch();
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    ArrayCombine: function() {
        var a = this, t = a.data.arr, o = a.data.dates, r = a.data.years, i = a.data.month, s = a.data.today;
        console.log(r, i, s), t.forEach(function(e, t) {
            for (var n in console.log(e), r == e.year && i == e.month && s == e.date && a.setData({
                isCurPunch: !0
            }), e) o.forEach(function(t) {
                for (var a in t) t.date == e.date && t.month == e.month && t.year == t.year && (t[n] = e[n]);
            });
        }), a.setData({
            dates: o
        });
    },
    toRecord: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../record/record?id=" + a
        });
    },
    datePickerChangeEvent: function(t) {
        var a = new Date(Date.parse(t.detail.value));
        changeDate.call(this, new Date(a.getFullYear(), a.getMonth(), 1));
    },
    changeDateEvent: function(t) {
        var a = t.currentTarget.dataset, e = a.year, n = a.month;
        changeDate.call(this, new Date(e, parseInt(n) - 1, 1));
    },
    dateClickEvent: function(t) {
        var a = t.currentTarget.dataset, e = a.year, n = a.month, o = a.date, r = this.data.data;
        r.selected.year = e, r.selected.month = n, r.selected.date = o, this.setData({
            data: r
        }), changeDate.call(this, new Date(e, parseInt(n) - 1, o));
    },
    punch: function(t) {
        var a = this, e = a.data.curDay + 1, n = {}, o = new Date(), r = a.data.arr;
        n.year = o.getFullYear(), n.month = o.getMonth() + 1, n.date = o.getUTCDate(), n.isSignIn = !0, 
        r.push(n), wx.showToast({
            title: "打卡成功",
            success: function() {
                a.setData({
                    curDay: e,
                    arr: r
                }), console.log(r);
            }
        });
    },
    toSubdiary: function(t) {
        if (this.data.task.wc_num != this.data.task.task_num) {
            var a = t.currentTarget.dataset.id;
            wx.navigateTo({
                url: "../subdiary/subdiary?id=" + a
            });
        } else wx.showToast({
            title: "该打卡任务已完成",
            icon: "none",
            duration: 3e3
        });
    },
    showGift: function(t) {
        var n = this, o = t.currentTarget.dataset.id, r = t.currentTarget.dataset.index, a = t.currentTarget.dataset.day;
        n.data.task.wc_num < a ? wx.showToast({
            title: "您还没有达到领取天数喔",
            icon: "none"
        }) : app.get_openid().then(function(a) {
            app.util.request({
                url: "entry/wxapp/getReceivePunchPrizeDetail",
                cachetime: "0",
                data: {
                    openid: a,
                    task_id: n.data.task_id,
                    prize_id: o
                },
                success: function(t) {
                    console.log(t.data);
                    var e = t.data;
                    app.util.request({
                        url: "entry/wxapp/setPunchReceiveRecord",
                        cachetime: "0",
                        data: {
                            openid: a,
                            task_id: n.data.task_id,
                            prize_id: o
                        },
                        success: function(t) {
                            console.log(t.data);
                            var a = n.data.task;
                            a.prize[r].receive_status = 1, wx.showToast({
                                title: "领取成功",
                                duration: 2e3
                            }), n.setData({
                                task: a,
                                coupon: e,
                                showGift: !n.data.showGift
                            });
                        },
                        fail: function(t) {
                            wx.showModal({
                                title: "提示",
                                content: t.data.message,
                                showCancel: !1
                            });
                        }
                    });
                },
                fail: function(t) {
                    wx.showToast({
                        title: "领取失败",
                        icon: "none"
                    });
                }
            });
        });
    },
    hiddenGift: function(t) {
        this.setData({
            showGift: !this.data.showGift
        });
    }
});