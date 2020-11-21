var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(t) {
    return typeof t;
} : function(t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t;
}, app = getApp();

Page({
    data: {
        reportObj: {},
        items: [ {
            names: "自己"
        } ],
        currents: 0,
        current: 0,
        hzid: "0",
        overflow: !1
    },
    historicalContrast: function(t) {
        console.log(t);
        var a = t.target.dataset.hzid;
        wx.navigateTo({
            url: "/hyb_yl/historical_contrast/historical_contrast?hzid=" + a
        });
    },
    onLoad: function(t) {
        var e = this, a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Allmyjiaren",
            data: {
                openid: a
            },
            success: function(t) {
                var a = e.data.items;
                a = a.concat(t.data.data), e.setData({
                    items: a
                });
            }
        });
        var o = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: o
        }), e.setData({
            backgroundColor: o
        }), this.getAlltijianbaogao();
    },
    showClick: function() {
        this.setData({
            overflow: !0
        });
    },
    getNames: function(t) {
        var a = t.detail.value;
        this.setData({
            values: a
        });
    },
    addItems: function(t) {
        var a = this, e = a.data.values, o = a.data.items, r = wx.getStorageSync("openid");
        if (console.log(e), app.util.request({
            url: "entry/wxapp/Addtijian",
            data: {
                openid: r,
                names: e
            },
            success: function(t) {
                console.log(t), a.setData({
                    j_id: t.data.data
                });
            }
        }), e) {
            var n = {};
            n.names = e, o.push(n);
            a.setData({
                items: o,
                values: ""
            });
        } else wx.showToast({
            title: "请输入报告名称"
        });
    },
    chooseItems: function(t) {
        if (a = t.currentTarget.dataset.hzid) a = t.currentTarget.dataset.hzid; else var a = 0;
        this.setData({
            current: t.currentTarget.dataset.index,
            hzid: a
        });
    },
    removeItems: function() {
        var t = this, a = t.data.current, e = t.data.items;
        0 != a && (e.splice(a, 1), t.setData({
            items: e,
            current: a - 1
        }));
    },
    confirmItems: function(t) {
        var a = this, e = a.data.reportObj, o = a.data.hzid;
        console.log(_typeof(e["reportArr_" + a.data.current])), "object" !== _typeof(e["reportArr_" + a.data.current]) && (app.util.request({
            url: "entry/wxapp/Alltijianbaogao",
            data: {
                useropenid: wx.getStorageSync("openid"),
                hzid: o
            },
            success: function(t) {
                console.log(t), e["reportArr_" + a.data.current] = t.data.data, a.setData({
                    reportObj: e
                });
            }
        }), a.setData({
            reportObj: e
        })), console.log(e, o), a.setData({
            overflow: !1,
            currents: a.data.current,
            hzid: o
        });
    },
    hideClick: function() {
        this.setData({
            overflow: !1,
            currents: this.data.current
        });
    },
    reportDetailClick: function(t) {
        console.log(t);
        var a = t.target.dataset.hzid;
        wx.navigateTo({
            url: "/hyb_yl/report_detail/report_detail?hzid=" + a
        });
    },
    addreportArr: function(t) {
        console.log(t);
        var a = t.currentTarget.dataset.hzid;
        wx.navigateTo({
            url: "/hyb_yl/record_0/record_0?hzid=" + a
        });
    },
    healthyAnalysis: function(t) {
        var a = t.target.dataset.hzid;
        wx.navigateTo({
            url: "/hyb_yl/healthy_analysis/healthy_analysis?hzid=" + a
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    getAlltijianbaogao: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Alltijianbaogao",
            data: {
                useropenid: wx.getStorageSync("openid"),
                hzid: 0
            },
            success: function(t) {
                console.log(t);
                var a = e.data.reportObj;
                a.reportArr_0 = t.data.data, e.setData({
                    reportObj: a
                });
            }
        });
    }
});