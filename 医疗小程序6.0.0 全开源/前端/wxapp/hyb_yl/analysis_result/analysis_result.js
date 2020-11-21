var Charts = require("../../utils/wxcharts-min.js");

Page({
    data: {
        touchHandler: [],
        series: [],
        categories: [],
        categoriesX: [],
        seriesX: [],
        index: 0,
        overflow: !1,
        simulation: [ {
            time: "2014.09.24",
            values: "362",
            state: "正常"
        }, {
            time: "2015.09.24",
            values: "390",
            state: "正常"
        }, {
            time: "2016.09.24",
            values: "375",
            state: "正常"
        }, {
            time: "2017.09.24",
            values: "360",
            state: "正常"
        }, {
            time: "2018.09.24",
            values: "360",
            state: "正常"
        }, {
            time: "2019.09.24",
            values: "370",
            state: "正常"
        }, {
            time: "2020.09.24",
            values: "300",
            state: "正常"
        }, {
            time: "2021.09.24",
            values: "500",
            state: "正常"
        }, {
            time: "2022.09.24",
            values: "350",
            state: "正常"
        }, {
            time: "2023.09.24",
            values: "390",
            state: "正常"
        }, {
            time: "2024.09.24",
            values: "300",
            state: "正常"
        }, {
            time: "2025.09.24",
            values: "660",
            state: "正常"
        }, {
            time: "2026.09.24",
            values: "888",
            state: "正常"
        }, {
            time: "2027.09.24",
            values: "80",
            state: "正常"
        }, {
            time: "2028.09.24",
            values: "3",
            state: "正常"
        }, {
            time: "2029.09.24",
            values: "362",
            state: "正常"
        } ]
    },
    onLoad: function(a) {
        var t = this, e = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: e
        }), t.setData({
            backgroundColor: e
        });
        var i = a.str, s = JSON.parse(i), n = s[a.index];
        t.setData({
            idx: a.index,
            length: a.length,
            contrastArr: s,
            simulation: n
        });
        var o = t.data.categoriesX, r = t.data.seriesX, l = t.data.categories, d = t.data.series;
        l.length = n.length, d.length = n.length;
        for (var c = 0, g = n.length; c < g; c++) l[c] = n[c].time, d[c] = n[c].description;
        var h = t.data.index;
        if (4 <= n.length) for (var v = h; v < h + 4; v++) o[v] = l[v], r[v] = d[v]; else for (v = h; v < h + n.length; v++) o[v] = l[v], 
        r[v] = d[v];
        console.log(o, r);
        var u = t.getMin(r) - 50, f = t.getMax(r) - 0 + 50;
        this.drawCanvas(o, r, u, f);
    },
    getMax: function(a) {
        for (var t = Array.from(a), e = 0, i = t.length; e < i; e++) if (e + 1 < i && (t[e] - t[e + 1] <= 0 ? t.splice(e, 1) : t.splice(e + 1, 1), 
        e--, i--), 1 == i) return t[0];
    },
    getMin: function(a) {
        for (var t = Array.from(a), e = 0, i = t.length; e < i; e++) if (e + 1 < i && (0 <= t[e] - t[e + 1] ? t.splice(e, 1) : t.splice(e + 1, 1), 
        e--, i--), 1 == i) return t[0];
    },
    drawCanvas: function(a, t, e, i) {
        new Charts({
            canvasId: "area",
            type: "area",
            categories: a,
            dataLabel: !0,
            extra: {
                lineStyle: "curve"
            },
            series: [ {
                name: "点击查看更多",
                color: "#ffb332",
                data: t
            } ],
            yAxis: {
                disabled: !1,
                min: e,
                max: i,
                format: function(a) {
                    return a.toFixed();
                }
            },
            width: 350,
            height: 200
        });
    },
    changClick: function(a) {
        var t = this, e = t.data.categories, i = t.data.categoriesX, s = t.data.series, n = t.data.seriesX, o = t.data.index;
        t.data.touchX;
        if (64 < a.detail.y && a.detail.y < 270) {
            if (210 < a.detail.x && a.detail.x < 360) {
                ++o >= e.length - 4 && (o = e.length - 4);
                for (var r = o, l = 0; l < 4; l++) i[l] = e[r], n[l] = s[r], r++;
                t.setData({
                    index: o
                });
            } else if (a.detail.x < 200 && 55 < a.detail.x) {
                --o <= 0 && (o = 0);
                for (r = o, l = 0; l < 4; l++) i[l] = e[r], n[l] = s[r], r++;
                t.setData({
                    index: o
                });
            }
            var d = t.getMin(n) - 50, c = t.getMax(n) - 0 + 50;
            this.drawCanvas(i, n, d, c), this.drawCanvas(i, n, d, c);
        }
    },
    onTouch: function(a) {
        var t = a.touches[0].x;
        a.touches[0].y;
        this.setData({
            touchX: t
        });
    },
    onTouchMove: function(a) {},
    onTouchEnd: function(a) {
        var t = this, e = t.data.categories, i = t.data.categoriesX, s = t.data.series, n = t.data.seriesX, o = t.data.index, r = t.data.touchX;
        if (40 < a.changedTouches[0].x - r) {
            --o <= 0 && (o = 0);
            for (var l = o, d = 0; d < 4; d++) i[d] = e[l], n[d] = s[l], l++;
            t.setData({
                index: o
            });
        } else if (a.changedTouches[0].x - r < -40) {
            ++o >= e.length - 4 && (o = e.length - 4);
            for (l = o, d = 0; d < 4; d++) i[d] = e[l], n[d] = s[l], l++;
            t.setData({
                index: o
            });
        }
        var c = t.getMin(n) - 50, g = t.getMax(n) - 0 + 50;
        this.drawCanvas(i, n, c, g), this.drawCanvas(i, n, c, g);
    },
    lastClick: function(a) {
        var t = this, e = t.data.idx;
        e--, t.setData({
            overflow: !0,
            idx: e
        }), wx.showLoading({
            title: "加载中"
        });
        var i = t.data.simulation, s = t.data.categoriesX, n = t.data.seriesX, o = t.data.categories, r = t.data.series;
        o.length = i.length, r.length = i.length;
        for (var l = 0, d = i.length; l < d; l++) o[l] = i[l].time, r[l] = i[l].values;
        for (var c = t.data.index, g = 0; g < 4; g++) s[g] = o[c], n[g] = r[c], c++;
        var h = t.getMin(n) - 50, v = t.getMax(n) - 0 + 50;
        this.drawCanvas(s, n, h, v), setTimeout(function() {
            wx.hideLoading(), t.setData({
                overflow: !1
            });
        }, 3e3);
    },
    nextClick: function(a) {
        var t = this, e = t.data.idx;
        e++, t.setData({
            overflow: !0,
            idx: e
        }), wx.showLoading({
            title: "加载中"
        });
        var i = t.data.contrastArr[e];
        console.log(i);
        var s = t.data.categoriesX, n = t.data.seriesX, o = t.data.categories, r = t.data.series;
        o.length = i.length, r.length = i.length;
        for (var l = 0, d = i.length; l < d; l++) o[l] = i[l].time, r[l] = i[l].description;
        var c = t.data.index;
        console.log(c);
        var g = c;
        if (4 <= i.length) for (var h = 0; h < 4; h++) s[h] = o[g], n[h] = r[g], g++; else for (h = 0; h < i.length; h++) s[h] = o[g], 
        n[h] = r[g], g++;
        console.log(s, n);
        var v = t.getMin(n) - 50, u = t.getMax(n) - 0 + 50;
        this.drawCanvas(s, n, v, u), setTimeout(function() {
            wx.hideLoading(), t.setData({
                overflow: !1
            });
        }, 3e3);
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});