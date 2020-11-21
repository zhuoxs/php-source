var a = getApp();

Page({
    data: {
        logintag: "",
        nclass: "",
        look: "",
        info: []
    },
    onLoad: function(o) {
        var t = this;
        try {
            (n = wx.getStorageSync("session")) && (console.log("logintag:", n), t.setData({
                logintag: n
            }));
        } catch (a) {}
        try {
            (n = wx.getStorageSync("nclass")) && (console.log("nclass:", n), t.setData({
                nclass: n
            }));
        } catch (a) {}
        try {
            var n = wx.getStorageSync("look");
            n && (console.log("look:", n), t.setData({
                look: n
            }));
        } catch (a) {}
        var e = t.data.look, s = t.data.logintag, c = t.data.nclass, r = e[4], l = e[0], i = e[1], g = e[2], d = e[3], u = e[5], f = e[6];
        if (0 == c || 1 == c) w = "passenger_search_car_owner_task"; else var w = "car_owner_search_passenger_task";
        wx.request({
            url: a.data.url + w,
            data: {
                logintag: s,
                starting_place: l,
                end_place: i,
                begin_time: g,
                end_time: d,
                area_name: r,
                yval: f,
                xval: u
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(a) {
                console.log(w + " => 搜索任务信息提交"), console.log(a), "0000" == a.data.retCode ? (wx.showToast({
                    title: a.data.retDesc,
                    icon: "none",
                    duration: 1e3
                }), t.setData({
                    info: a.data.info
                })) : wx.showToast({
                    title: a.data.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        });
    },
    route: function(a) {
        var o = a.currentTarget.dataset.id;
        wx.navigateTo({
            url: "route/route?nid=" + o
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