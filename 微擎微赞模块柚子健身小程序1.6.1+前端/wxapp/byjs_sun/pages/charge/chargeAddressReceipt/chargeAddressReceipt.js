var app = getApp(), tcity = require("../../../../byjs_sun/resource/utils/citys.js");

Page({
    data: {
        provinces: [],
        province: "",
        citys: [],
        city: "",
        countys: [],
        county: "",
        value: [ 0, 0, 0 ],
        values: [ 0, 0, 0 ],
        condition: !1
    },
    onLoad: function(n) {
        console.log("onLoad");
        var t = this;
        tcity.init(t);
        for (var o = t.data.cityData, s = [], a = [], e = [], u = 0; u < o.length; u++) s.push(o[u].name);
        console.log("省份完成");
        for (var i = 0; i < o[0].sub.length; i++) a.push(o[0].sub[i].name);
        console.log("city完成");
        for (var c = 0; c < o[0].sub[0].sub.length; c++) e.push(o[0].sub[0].sub[c].name);
        t.setData({
            provinces: s,
            citys: a,
            countys: e,
            province: o[0].name,
            city: o[0].sub[0].name,
            county: o[0].sub[0].sub[0].name
        }), console.log("初始化完成");
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    previousPage: function() {
        wx.navigateBack({
            data: 1
        });
    },
    bindChange: function(n) {
        var t = n.detail.value, o = this.data.values, s = this.data.cityData;
        if (t[0] == o[0]) if (t[1] == o[1]) {
            if (t[2] != o[2]) return console.log("county no"), void this.setData({
                county: this.data.countys[t[2]],
                values: t
            });
        } else {
            console.log("city no");
            for (var a = [], e = 0; e < s[t[0]].sub[t[1]].sub.length; e++) a.push(s[t[0]].sub[t[1]].sub[e].name);
            this.setData({
                city: this.data.citys[t[1]],
                county: s[t[0]].sub[t[1]].sub[0].name,
                countys: a,
                values: t,
                value: [ t[0], t[1], 0 ]
            });
        } else {
            console.log("province no ");
            for (var u = [], i = [], c = 0; c < s[t[0]].sub.length; c++) u.push(s[t[0]].sub[c].name);
            for (var l = 0; l < s[t[0]].sub[0].sub.length; l++) i.push(s[t[0]].sub[0].sub[l].name);
            this.setData({
                province: this.data.provinces[t[0]],
                city: s[t[0]].sub[0].name,
                citys: u,
                county: s[t[0]].sub[0].sub[0].name,
                countys: i,
                values: t,
                value: [ t[0], 0, 0 ]
            });
        }
    },
    open: function() {}
});