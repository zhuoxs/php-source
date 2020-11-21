var t, e = getApp(), a = require("../../utils/qqmap-wx-jssdk.min.js");

Page({
    data: {
        StatusBar: e.globalData.StatusBar,
        CustomBar: e.globalData.CustomBar,
        hidden: !0
    },
    formatList: function(t, e) {
        for (var a = /^[A-Z]$/, i = new Array(), n = 0; n < t.length; n++) {
            i["#"] = new Array();
            var r = t[n][e][0].substr(0, 1).toUpperCase();
            a.test(r) || (r = "#"), r in i || (i[r] = new Array()), i[r].push(t[n]);
        }
        var s = new Array();
        for (var o in i) s.push({
            letter: o,
            list: i[o]
        });
        s.sort(function(t, e) {
            return t.letter.charCodeAt(0) - e.letter.charCodeAt(0);
        });
        var u = s[0];
        s.splice(0, 1), s.push(u);
        for (var c = {}, n = 0; n < s.length; n++) c[s[n].letter] = s[n].list;
        return c;
    },
    onLoad: function() {
        var e = this;
        t = new a({
            key: "HEQBZ-R6TWR-3YHWF-WJACM-ZH6LE-3SFB6"
        }), wx.getStorage({
            key: "citys",
            success: function(t) {
                e.setData({
                    citys: t.data
                });
            },
            fail: function(a) {
                t.getCityList({
                    success: function(t) {
                        var a = e.formatList(t.result[1], "pinyin");
                        wx.setStorage({
                            key: "citys",
                            data: a
                        });
                    },
                    fail: function(t) {
                        console.error(t);
                    },
                    complete: function(t) {
                        console.log(t);
                    }
                });
            }
        });
    },
    onShow: function() {},
    onReady: function() {
        var t = this;
        wx.createSelectorQuery().select(".indexBar-box").boundingClientRect(function(e) {
            t.setData({
                boxTop: e.top
            });
        }).exec(), wx.createSelectorQuery().select(".indexes").boundingClientRect(function(e) {
            t.setData({
                barTop: e.top
            });
        }).exec();
    },
    setCity: function(t) {
        var e = t.currentTarget.dataset.text;
        wx.switchTab({
            url: "../index/index",
            success: function(t) {
                wx.setStorage({
                    key: "location",
                    data: e
                });
                var a = getCurrentPages().pop();
                void 0 != a && null != a && a.onLoad();
            },
            fail: function(t) {
                console.error(t);
            }
        });
    },
    getCur: function(t) {
        this.setData({
            hidden: !1,
            listCur: t.target.id
        });
    },
    setCur: function(t) {
        this.setData({
            hidden: !0,
            listCur: this.data.listCur
        });
    },
    tMove: function(t) {
        var e = t.touches[0].clientY, a = this.data.boxTop;
        if (e > a) {
            parseInt((e - a) / 20);
            this.setData({
                listCur: t.target.id
            });
        }
    },
    tStart: function() {
        this.setData({
            hidden: !1
        });
    },
    tEnd: function() {
        this.setData({
            hidden: !0,
            listCurID: this.data.listCur
        });
    },
    indexSelect: function(t) {
        for (var e = this, a = this.data.barHeight, i = this.data.list, n = Math.ceil(i.length * t.detail.y / a), r = 0; r < i.length; r++) if (n < r + 1) return e.setData({
            listCur: i[r],
            movableY: 20 * r
        }), !1;
    }
});