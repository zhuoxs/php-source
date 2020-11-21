var t = require("../../BB9047D36A7AF98CDDF62FD409E19D70.js"), o = getApp();

Page({
    data: {
        logintag: "",
        searchLetter: [],
        showLetter: "",
        winHeight: 0,
        tHeight: 0,
        bHeight: 0,
        cityList: [],
        isShowLetter: !1,
        scrollTop: 0,
        scrollTopId: "",
        hotcityList: [],
        session: "",
        hotbrand: [],
        list: [],
        carlogoimg: "",
        info: "",
        location: ""
    },
    onLoad: function(e) {
        for (var a = this, n = t.searchLetter, i = t.cityList(), s = wx.getSystemInfoSync().windowHeight, c = s / n.length, r = [], l = 0; l < n.length; l++) {
            var g = {};
            g.name = n[l], g.tHeight = l * c, g.bHeight = (l + 1) * c, r.push(g);
        }
        this.setData({
            winHeight: s,
            itemH: c,
            searchLetter: r,
            cityList: i
        });
        try {
            (h = wx.getStorageSync("session")) && (console.log("logintag:", h), a.setData({
                logintag: h
            }));
        } catch (t) {}
        try {
            var h = wx.getStorageSync("location");
            h && (console.log("location:", h), a.setData({
                location: h
            }));
        } catch (t) {}
        var u = a.data.logintag;
        wx.request({
            url: o.data.url + "morecitylist",
            data: {
                logintag: u
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                if (console.log("morecitylist => 获取地址数据信息"), console.log(t), "0000" == t.data.retCode) {
                    var o = t.data.info;
                    a.setData({
                        info: o
                    });
                } else wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        });
    },
    hotCity: function() {
        this.setData({
            scrollTop: 0
        });
    },
    clickLetter: function(t) {
        console.log(t);
        var o = t.currentTarget.dataset.letter;
        this.setData({
            showLetter: o,
            isShowLetter: !0,
            scrollTopId: o
        });
        var e = this;
        setTimeout(function() {
            e.setData({
                isShowLetter: !1
            });
        }, 1e3);
    },
    name: function(t) {
        var o = t.currentTarget.dataset.id;
        o ? (wx.setStorage({
            key: "location",
            data: o
        }), this.setData({
            location: o
        }), wx.navigateBack({
            delta: 1,
            success: function(t) {
                var o = getCurrentPages().pop();
                void 0 != o && null != o && o.onLoad();
            }
        })) : wx.showToast({
            title: "暂不支持切换城市",
            icon: "none",
            duration: 1e3
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