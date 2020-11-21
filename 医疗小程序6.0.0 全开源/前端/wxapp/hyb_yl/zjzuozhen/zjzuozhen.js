var app = getApp();

Page({
    data: {
        dateArr: [],
        formData: [],
        pp_id: ""
    },
    changeDate: function(t) {
        var a = this, e = t.detail.value.split("-")[0] + " 年 " + t.detail.value.split("-")[1] + " 月 " + t.detail.value.split("-")[2] + " 日 ", i = t.currentTarget.dataset.index, d = t.currentTarget.dataset.d_id, r = a.data.dateArr, n = a.data.formData;
        n[i].date = e, console.log(d), r[i].riqi.date = e, a.setData({
            dateArr: r,
            formData: n,
            d_id: d
        }), console.log(n);
    },
    changeArr: function(t) {
        console.log(t);
        var a = this, e = t.currentTarget.dataset.index, i = a.data.dateArr, d = t.detail.value, r = a.data.formData;
        i[e].id = d, i[e].day = !1, r[e].day = i[e].arr[i[e].id], a.setData({
            dateArr: i,
            formData: r
        });
    },
    startTime: function(t) {
        var a = this, e = t.currentTarget.dataset.index, i = t.detail.value, d = a.data.dateArr, r = a.data.formData;
        d[e].id;
        d[e].times[d[e].id][0].time = i, r[e].startTime = i, a.setData({
            dateArr: d,
            formData: r
        });
    },
    endTime: function(t) {
        var a = this, e = t.currentTarget.dataset.index, i = t.detail.value, d = a.data.dateArr, r = a.data.formData;
        d[e].id;
        d[e].times[d[e].id][1].time = i, r[e].endTime = i, a.setData({
            dateArr: d,
            formData: r
        });
    },
    submit: function(t) {
        for (var a = this, e = a.data.formData, i = (a.data.date, a.data.day, a.data.endTime, 
        a.data.startTime, wx.getStorageSync("openid")), d = a.data.pp_id, r = [], n = 0; n < e.length; n++) {
            var o = e[n];
            r.push(o.d_id);
        }
        console.log(r), "" == e ? wx.showModal({
            content: "请选择出诊时间"
        }) : app.util.request({
            url: "entry/wxapp/Dozhuantime",
            data: {
                arrs: e,
                openid: i,
                pp_id: d,
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
        var a = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: a
        });
        var m = this, e = t.id;
        console.log(e);
        var i = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Dozhuantimeselect",
            data: {
                openid: i
            },
            success: function(t) {
                for (var a = t.data.data, e = m.data.dateArr, i = m.data.formData, d = 0; d < a.length; d++) {
                    var r = a[d], n = r.startTime.split("-"), o = {}, s = {};
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
                    s.startTime = n[0], s.endTime = n[1], e.push(o), i.push(s);
                }
                m.setData({
                    dateArr: e,
                    formData: i
                });
            },
            fail: function(t) {
                console.log(t);
            }
        }), m.setData({
            pp_id: e
        });
    },
    add: function() {
        var t = {}, a = {
            d_id: ""
        }, e = this.data.dateArr, i = this.data.formData;
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
        } ] ], e.push(t), i.push(a), this.setData({
            dateArr: e,
            formData: i
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