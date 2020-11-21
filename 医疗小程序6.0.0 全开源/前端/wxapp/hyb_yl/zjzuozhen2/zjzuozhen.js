var app = getApp();

Page({
    data: {
        radioCheckVal: 0,
        time1: "",
        time2: "",
        time3: ""
    },
    onLoad: function() {
        var e = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: e
        });
        var t = Date.parse(new Date());
        t /= 1e3;
        var a = new Date(1e3 * t), o = a.getFullYear(), n = a.getMonth() + 1 < 10 ? "0" + (a.getMonth() + 1) : a.getMonth() + 1, g = a.getDate() < 10 ? "0" + a.getDate() : a.getDate(), i = t + 172800, l = new Date(1e3 * (t + 86400)), r = new Date(1e3 * i), c = l.getFullYear(), s = r.getFullYear(), h = l.getMonth() + 1 < 10 ? "0" + (l.getMonth() + 1) : l.getMonth() + 1, u = r.getMonth() + 1 < 10 ? "0" + (r.getMonth() + 1) : r.getMonth() + 1, D = l.getDate() < 10 ? "0" + l.getDate() : l.getDate(), d = r.getDate() < 10 ? "0" + r.getDate() : r.getDate();
        console.log(o + "-" + n + "-" + g), console.log(c + "-" + h + "-" + D), console.log(s + "-" + u + "-" + d);
        var f = o + "-" + n + "-" + g, p = c + "-" + h + "-" + D, z = s + "-" + u + "-" + d;
        this.setData({
            time1: f,
            time2: p,
            time3: z
        });
        var m = wx.getStorageSync("openid");
        this.getZjzz(m);
    },
    getZjzz: function(e) {
        var t = this;
        console.log(app), app.util.request({
            url: "entry/wxapp/Zjzz",
            data: {
                openid: e
            },
            cachetime: "30",
            success: function(e) {
                console.log("time=========================="), console.log(e.data.data), t.setData({
                    time: e.data.data
                });
            },
            fail: function(e) {
                console.log(e);
            }
        });
    },
    radioCheckedChange: function(e) {
        this.setData({
            radioCheckVal: e.detail.value
        });
    },
    timegClick: function() {
        wx.navigateTo({
            url: "../zjzuozhen/zjzuozhen"
        });
    }
});