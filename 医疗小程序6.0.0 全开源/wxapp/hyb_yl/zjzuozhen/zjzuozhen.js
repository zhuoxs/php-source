var app = getApp();

Page({
    data: {
        dateArr: [],
        formData: [],
        pp_id: ""
    },
    changeDate: function(t) {
        var a = this, e = t.detail.value.split("-")[0] + " 年 " + t.detail.value.split("-")[1] + " 月 " + t.detail.value.split("-")[2] + " 日 ", d = t.currentTarget.dataset.index, i = t.currentTarget.dataset.d_id, r = a.data.dateArr, n = a.data.formData;
        n[d].date = e, console.log(i), r[d].riqi.date = e, a.setData({
            dateArr: r,
            formData: n,
            d_id: i
        }), console.log(n);
    },
    changeArr: function(t) {
        console.log(t);
        var a = this, e = t.currentTarget.dataset.index, d = a.data.dateArr, i = t.detail.value, r = a.data.formData;
        d[e].id = i, d[e].day = !1, r[e].day = d[e].arr[d[e].id], a.setData({
            dateArr: d,
            formData: r
        });
    },
    startTime: function(t) {
        var a = this, e = t.currentTarget.dataset.index, d = t.detail.value, i = a.data.dateArr, r = a.data.formData;
        i[e].id;
        i[e].times[i[e].id][0].time = d, r[e].startTime = d, a.setData({
            dateArr: i,
            formData: r
        });
    },
    endTime: function(t) {
        var a = this, e = t.currentTarget.dataset.index, d = t.detail.value, i = a.data.dateArr, r = a.data.formData;
        i[e].id;
        i[e].times[i[e].id][1].time = d, r[e].endTime = d, a.setData({
            dateArr: i,
            formData: r
        });
    },
    submit: function(t) {
        for (var a = this, e = a.data.formData, d = (a.data.date, a.data.day, a.data.endTime, 
        a.data.startTime, wx.getStorageSync("openid")), i = a.data.pp_id, r = [], n = 0; n < e.length; n++) {
            var o = e[n];
            r.push(o.d_id);
        }
        console.log(r), "" == e ? wx.showModal({
            content: "请选择出诊时间"
        }) : app.util.request({
            url: "entry/wxapp/Dozhuantime",
            data: {
                arrs: e,
                openid: d,
                pp_id: i,
                ids: r
            },
            success: function(t) {
                return console.log(t), wx.showToast({
                    title: "添加成功",
                    icon: "success",
                    duration: 800
                }), !1;
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    onLoad: function(t) {
        var m = this, a = t.id;
        console.log(a);
        var e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Dozhuantimeselect",
            data: {
                openid: e
            },
            success: function(t) {
                for (var a = t.data.data, e = m.data.dateArr, d = m.data.formData, i = 0; i < a.length; i++) {
                    var r = a[i], n = r.startTime.split("-"), o = {}, s = {};
                    "上午" == r.day ? (o.id = 0, o.times = [ [ {
                        startTime: "09:00",
                        end: "12:00",
                        time: n[0]
                    }, {
                        startTime: "09:00",
                        end: "12:00",
                        time: n[1]
                    } ], [ {
                        startTime: "14:00",
                        end: "18:00",
                        time: "--:--"
                    }, {
                        startTime: "14:00",
                        end: "18:00",
                        time: "--:--"
                    } ] ]) : (o.id = 1, o.times = [ [ {
                        startTime: "09:00",
                        end: "12:00",
                        time: "--:--"
                    }, {
                        startTime: "09:00",
                        end: "12:00",
                        time: "--:--"
                    } ], [ {
                        startTime: "14:00",
                        end: "18:00",
                        time: n[0]
                    }, {
                        startTime: "14:00",
                        end: "18:00",
                        time: n[1]
                    } ] ]), o.riqi = {
                        start: "2018 - 01 - 01",
                        end: "2028 - 01 - 01",
                        date: r.date
                    }, o.arr = [ "上午", "下午" ], o.day = !1, s.d_id = r.d_id, s.date = r.date, s.day = r.day, 
                    s.startTime = n[0], s.endTime = n[1], e.push(o), d.push(s);
                }
                m.setData({
                    dateArr: e,
                    formData: d
                });
            },
            fail: function(t) {
                console.log(t);
            }
        }), m.setData({
            pp_id: a
        });
    },
    add: function() {
        var t = {}, a = {
            d_id: ""
        }, e = this.data.dateArr, d = this.data.formData;
        t.id = 0, t.riqi = {
            start: "2018 - 01 - 01",
            end: "2028 - 01 - 01",
            date: "---- 年 -- 月 -- 日"
        }, t.arr = [ "上午", "下午" ], t.day = !0, t.times = [ [ {
            startTime: "09:00",
            end: "12:00",
            time: "--:--"
        }, {
            startTime: "09:00",
            end: "12:00",
            time: "--:--"
        } ], [ {
            startTime: "14:00",
            end: "18:00",
            time: "--:--"
        }, {
            startTime: "14:00",
            end: "18:00",
            time: "--:--"
        } ] ], e.push(t), d.push(a), this.setData({
            dateArr: e,
            formData: d
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});