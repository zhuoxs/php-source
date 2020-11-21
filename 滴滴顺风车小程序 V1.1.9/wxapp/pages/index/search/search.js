var t = getApp();

Page({
    data: {
        date: "",
        time: "00:00",
        time2: "00:00",
        origin: "",
        terminus: "",
        yval: "",
        xval: ""
    },
    onLoad: function(t) {
        var a = this;
        try {
            (e = wx.getStorageSync("session")) && (console.log("logintag:", e), a.setData({
                logintag: e
            }));
        } catch (t) {}
        try {
            (e = wx.getStorageSync("nclass")) && (console.log("nclass:", e), a.setData({
                nclass: e
            }));
        } catch (t) {}
        try {
            var e = wx.getStorageSync("location");
            e && (console.log("location:", e), a.setData({
                location: e
            }));
        } catch (t) {}
        wx.getLocation({
            type: "gcj02",
            success: function(t) {
                var e = t.latitude, o = t.longitude;
                console.log("yval:", e), console.log("xval:", o), a.setData({
                    yval: e,
                    xval: o
                });
            }
        });
    },
    information: function(a) {
        var e = this, o = e.data.logintag, n = e.data.yval, i = e.data.xval, s = e.data.nclass, l = e.data.location, c = e.data.origin, r = e.data.terminus, d = e.data.date, u = d + " " + e.data.time, g = d + " " + e.data.time2;
        if ("" != c) if ("" != r) if ("" != d && void 0 != d) if ("00:00" != u) if ("00:00" != g) {
            if (0 == s || 1 == s) h = "passenger_search_car_owner_task"; else var h = "car_owner_search_passenger_task";
            wx.request({
                url: t.data.url + h,
                data: {
                    logintag: o,
                    starting_place: c,
                    end_place: r,
                    begin_time: u,
                    end_time: g,
                    area_name: l,
                    yval: n,
                    xval: i
                },
                header: {
                    "content-type": "application/x-www-form-urlencoded"
                },
                success: function(t) {
                    if (console.log(h + " => 搜索任务信息提交"), console.log(t), "0000" == t.data.retCode) {
                        wx.showToast({
                            title: t.data.retDesc,
                            icon: "none",
                            duration: 1e3
                        });
                        var a = [ c, r, u, g, l, i, n ];
                        wx.setStorage({
                            key: "look",
                            data: a
                        }), setTimeout(function() {
                            console.log("延迟调用 => information"), wx.navigateTo({
                                url: "information/information"
                            });
                        }, 1e3);
                    } else wx.showToast({
                        title: t.data.retDesc,
                        icon: "none",
                        duration: 1e3
                    });
                }
            });
        } else wx.showToast({
            title: "最晚出发时间未选择",
            icon: "none",
            duration: 1e3
        }); else wx.showToast({
            title: "最早出发时间未选择",
            icon: "none",
            duration: 1e3
        }); else wx.showToast({
            title: "出发日期未选择",
            icon: "none",
            duration: 1e3
        }); else wx.showToast({
            title: "目的地未填写",
            icon: "none",
            duration: 1e3
        }); else wx.showToast({
            title: "出发地未填写",
            icon: "none",
            duration: 1e3
        });
    },
    bindTimeChange: function(t) {
        var a = this.data.time2;
        "00:00" !== a ? a > t.detail.value ? this.setData({
            time: t.detail.value
        }) : wx.showToast({
            title: "时间顺序错误",
            icon: "none",
            duration: 1e3
        }) : this.setData({
            time: t.detail.value
        });
    },
    bindTimeChange2: function(t) {
        this.data.time < t.detail.value ? this.setData({
            time2: t.detail.value
        }) : wx.showToast({
            title: "时间顺序错误",
            icon: "none",
            duration: 1e3
        });
    },
    bindDateChange: function(t) {
        console.log("picker发送选择改变，携带值为", t.detail.value), this.setData({
            date: t.detail.value
        });
    },
    origin: function(t) {
        this.setData({
            origin: t.detail.value
        });
    },
    terminus: function(t) {
        this.setData({
            terminus: t.detail.value
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