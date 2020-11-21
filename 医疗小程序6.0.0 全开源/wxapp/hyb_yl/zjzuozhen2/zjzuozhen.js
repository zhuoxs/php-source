var app = getApp();

Page({
    data: {
        radioCheckVal: 0,
        time1: "",
        time2: "",
        time3: ""
    },
    onLoad: function() {
        var e = Date.parse(new Date());
        e /= 1e3;
        var t = new Date(1e3 * e), a = t.getFullYear(), o = t.getMonth() + 1 < 10 ? "0" + (t.getMonth() + 1) : t.getMonth() + 1, n = t.getDate() < 10 ? "0" + t.getDate() : t.getDate(), g = e + 172800, i = new Date(1e3 * (e + 86400)), l = new Date(1e3 * g), c = i.getFullYear(), s = l.getFullYear(), h = i.getMonth() + 1 < 10 ? "0" + (i.getMonth() + 1) : i.getMonth() + 1, r = l.getMonth() + 1 < 10 ? "0" + (l.getMonth() + 1) : l.getMonth() + 1, u = i.getDate() < 10 ? "0" + i.getDate() : i.getDate(), D = l.getDate() < 10 ? "0" + l.getDate() : l.getDate();
        console.log(a + "-" + o + "-" + n), console.log(c + "-" + h + "-" + u), console.log(s + "-" + r + "-" + D);
        var d = a + "-" + o + "-" + n, p = c + "-" + h + "-" + u, z = s + "-" + r + "-" + D;
        this.setData({
            time1: d,
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