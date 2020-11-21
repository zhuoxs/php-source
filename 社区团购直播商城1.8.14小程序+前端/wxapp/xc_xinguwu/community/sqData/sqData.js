var wxCharts = require("../../../utils/wxcharts.js"), app = getApp(), areaChart = null;

Page({
    data: {
        curIndex: 1
    },
    touchHandler: function(a) {
        console.log(areaChart.getCurrentDataIndex(a)), areaChart.showToolTip(a);
    },
    change: function(a) {
        var t = a.currentTarget.dataset.index;
        if (this.setData({
            curIndex: t
        }), 1 == t) this.setData({
            totalbrokerage: this.data.club.totalbrokerage
        }); else {
            var e = this;
            app.util.request({
                url: "entry/wxapp/community",
                showLoading: !1,
                method: "POST",
                data: {
                    op: "brokerageData",
                    curIndex: t
                },
                success: function(a) {
                    var t = a.data;
                    e.setData({
                        totalbrokerage: t.data.list
                    });
                }
            });
        }
    },
    toSell: function() {
        wx.navigateTo({
            url: "../sqBrokerage/sqBrokerage?"
        });
    },
    onLoad: function(a) {
        var s = 320;
        try {
            var t = wx.getSystemInfoSync();
            s = t.windowWidth;
        } catch (a) {
            console.error("getSystemInfoSync failed!");
        }
        var i = this;
        app.util.request({
            url: "entry/wxapp/community",
            showLoading: !1,
            method: "POST",
            data: {
                op: "commissionTrend"
            },
            success: function(a) {
                for (var t = [], o = [ 0, 0, 0, 0, 0, 0, 0 ], e = new app.util.date(), r = 6; 0 <= r; r--) t.push(e.dateToStr("MM-dd", e.dateAdd("d", -r)));
                var n = a.data;
                n.data.list && n.data.list.forEach(function(e, a) {
                    t.forEach(function(a, t) {
                        e.createtime == a && (o[t] = o[t] + parseFloat(e.fee) * parseInt(e.type));
                    });
                }), n.data.club && i.setData({
                    club: n.data.club,
                    totalbrokerage: n.data.club.totalbrokerage
                }), areaChart = new wxCharts({
                    canvasId: "areaCanvas",
                    type: "area",
                    categories: t,
                    animation: !0,
                    series: [ {
                        name: "佣金",
                        data: o,
                        format: function(a) {
                            return a.toFixed(2);
                        }
                    } ],
                    yAxis: {
                        format: function(a) {
                            return a.toFixed(2);
                        },
                        min: 0,
                        fontColor: "#888",
                        gridColor: "#efefef"
                    },
                    xAxis: {
                        fontColor: "#888",
                        gridColor: "#efefef"
                    },
                    extra: {
                        legendTextColor: "#f45a46"
                    },
                    width: s,
                    height: 200
                });
            }
        });
    },
    onReady: function() {
        var a = {};
        a.sq_sell_bg = app.module_url + "resource/wxapp/community/sq-sell-bg.png", a.sq_data = app.module_url + "resource/wxapp/community/sq-data.png", 
        a.sq_deposit = app.module_url + "resource/wxapp/community/sq-deposit.png", a.sq_account = app.module_url + "resource/wxapp/community/sq-account.png", 
        this.setData({
            images: a
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});