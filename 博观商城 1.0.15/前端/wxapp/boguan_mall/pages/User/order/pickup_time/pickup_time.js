var e = require("../../../../utils/base.js"), t = require("../../../../../api.js"), a = new e.Base();

Page({
    data: {
        timeIndex: 0
    },
    onLoad: function(e) {
        console.log(e), 0 == e.Ttype ? e.pickId && this.getPickpoint(e.pickId) : this.getDelivery(), 
        "undefined" != e.timeIndex ? this.setData({
            timeIndex: e.timeIndex
        }) : this.setData({
            timeIndex: 0
        }), "undefined" != e.period && this.setData({
            period: e.period
        }), "undefined" != e.timeIdx && this.setData({
            timeIdx: e.timeIdx
        }), "undefined" != e.am && this.setData({
            am: e.am
        });
    },
    getPickpoint: function(e) {
        var i = this, d = {
            url: t.default.pickpoint_time,
            data: {
                pickId: e
            }
        };
        a.getData(d, function(e) {
            console.log("时间res=>", e), 1 == e.errorCode && i.setData({
                timeData: e.data,
                timeType: e.type
            });
        });
    },
    getDelivery: function() {
        var e = this, i = {
            url: t.default.delivery_time
        };
        a.getData(i, function(t) {
            console.log("同城时间res=>", t), 1 == t.errorCode && e.setData({
                timeData: t.data,
                timeType: t.type
            });
        });
    },
    selectTime: function(e) {
        var t = e.currentTarget.dataset.index, a = e.currentTarget.dataset.idx || "", i = e.currentTarget.dataset.am || "", d = e.currentTarget.dataset.day, r = e.currentTarget.dataset.time || "", n = e.currentTarget.dataset.period || "", s = getCurrentPages(), o = s[s.length - 2];
        if (1 == e.currentTarget.dataset.is_dayoff) wx.showToast({
            title: "当前时间不可选",
            icon: "none",
            duration: 2e3
        }); else {
            var m = {
                day: d + " " + r,
                timeIndex: t,
                period: n,
                timeIdx: a,
                am: i
            }, c = {
                day: d + " " + r,
                timeIndex: t,
                period: n,
                timeIdx: a,
                am: i
            };
            o.data.daydata = m, o.data.deliveryTime = c, o.setData({
                daydata: m,
                deliveryTime: c
            }), wx.navigateBack({
                delta: 1
            }), this.setData({
                timeIndex: t,
                period: n,
                timeIdx: a,
                am: i
            });
        }
    },
    selectDay: function(e) {
        var t = e.currentTarget.dataset.index;
        1 == e.currentTarget.dataset.is_dayoff ? wx.showToast({
            title: "您选择的时间不在营业时间，请重新选择",
            icon: "none",
            duration: 2e3
        }) : this.setData({
            timeIndex: t
        });
    }
});