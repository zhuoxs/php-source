var week = require("../resource/js/date_week.js"), app = getApp();

Page({
    data: {
        id: 0,
        date_: "",
        date: "",
        table: [],
        NowSelect: [],
        otherSelect: [],
        NowSelectStr: "",
        weekday: [ "", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六", "星期天" ]
    },
    onPullDownRefresh: function() {
        var t = this;
        t.getbase(), t.proTable(), t.getSelected(), wx.stopPullDownRefresh();
    },
    onLoad: function(t) {
        var e = this, a = t.id, r = t.tableid;
        if (e.setData({
            tableid: r,
            id: a
        }), t.appoint_date) {
            var s = new Date(t.appoint_date).getDay();
            s = t.appoint_date + " (" + e.data.weekday[s] + ")";
        }
        var o = t.startdate ? t.startdate : week.getDates(1)[0].year + "-" + week.getDates(1)[0].month + "-" + week.getDates(1)[0].day;
        e.setData({
            start: t.startdate ? t.startdate : o,
            date_: t.appoint_date ? t.appoint_date : o,
            date: t.appoint_date ? s : o + " (" + week.getDates(parseInt(t.afterdays) + 1)[parseInt(t.afterdays)].week + ")"
        }), t.NowSelectStr && e.setData({
            NowSelectStr: t.NowSelectStr
        }), e.getbase(), e.proTable(), e.getSelected();
    },
    getbase: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/BaseMin",
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(t) {
                e.setData({
                    baseinfo: t.data.data
                }), wx.setNavigationBarColor({
                    frontColor: e.data.baseinfo.base_tcolor,
                    backgroundColor: e.data.baseinfo.base_color
                });
            },
            fail: function(t) {}
        });
    },
    proTable: function() {
        var l = this;
        app.util.request({
            url: "entry/wxapp/proTable",
            data: {
                tableid: l.data.tableid
            },
            success: function(t) {
                var e = t.data.data;
                if (l.setData({
                    table: e
                }), "" != l.data.NowSelectStr) {
                    for (var a = l.data.NowSelectStr.split(","), r = [], s = [], o = 0; o < a.length; o++) r = a[o].split("a"), 
                    s[o] = {}, s[o].row = e.rowstr[parseInt(r[0]) - 1], s[o].column = e.columnstr[parseInt(r[1]) - 1];
                    l.setData({
                        selected: s,
                        NowSelect: a
                    });
                }
                wx.setNavigationBarTitle({
                    title: t.data.data.name
                });
            },
            fail: function(t) {}
        });
    },
    selectThis: function(t) {
        var e = this, a = t.currentTarget.dataset.num, r = e.data.NowSelect;
        r.push(a);
        for (var s = [], o = [], l = 0; l < r.length; l++) s = r[l].split("a"), o[l] = {}, 
        o[l].row = e.data.table.rowstr[parseInt(s[0]) - 1], o[l].column = e.data.table.columnstr[parseInt(s[1]) - 1];
        var n = r.join(",");
        e.setData({
            selected: o,
            NowSelect: r,
            NowSelectStr: n
        });
    },
    removeThis: function(t) {
        for (var e = this, a = t.currentTarget.dataset.num, r = e.data.NowSelect, s = 0; s < r.length; s++) r[s] == a && r.splice(s, 1);
        for (var o = [], l = [], n = 0; n < r.length; n++) o = r[n].split("a"), l[n] = {}, 
        l[n].row = e.data.table.rowstr[parseInt(o[0]) - 1], l[n].column = e.data.table.columnstr[parseInt(o[1]) - 1];
        var d = r.join(",");
        e.setData({
            selected: l,
            NowSelect: r,
            NowSelectStr: d
        });
    },
    bindDateChange: function(t) {
        for (var e = [], a = 0; a < 1; a++) {
            var r = week.dateLater(t.detail.value, a);
            e.push(r);
        }
        return this.setData({
            date_: t.detail.value,
            date: e[0].year + "-" + e[0].month + "-" + e[0].day + " (" + e[0].week + ")"
        }), this.getSelected(), e;
    },
    getSelected: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/getSelected",
            data: {
                date: a.data.date_,
                id: a.data.id
            },
            success: function(t) {
                var e = t.data.data.split(",");
                a.setData({
                    otherSelect: e
                });
            }
        });
    }
});