var wxCharts = require("../../../utils/wxcharts.js"), app = getApp(), areaChart = null;

Page({
    data: {},
    bindDateChange: function(a) {
        this.setData({
            date: a.detail.value
        });
        var e = this;
        app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !0,
            data: {
                op: "statistics",
                date: a.detail.value
            },
            success: function(a) {
                var t = a.data;
                t.data.list && (e.setData({
                    list: t.data.list,
                    x: t.data.x,
                    y: t.data.y
                }), e.chart(t.data.x, t.data.y));
            }
        });
    },
    touchHandler: function(a) {
        console.log(areaChart.getCurrentDataIndex(a)), areaChart.showToolTip(a);
    },
    chart: function(a, t) {
        var e = 320;
        try {
            e = wx.getSystemInfoSync().windowWidth;
        } catch (a) {
            console.error("getSystemInfoSync failed!");
        }
        areaChart = new wxCharts({
            canvasId: "areaCanvas",
            type: "area",
            categories: a,
            animation: !0,
            series: [ {
                name: "成交量",
                data: t,
                format: function(a) {
                    return a.toFixed(2);
                }
            } ],
            yAxis: {
                format: function(a) {
                    return a.toFixed(2);
                },
                min: 0,
                fontColor: "#c1c1c1",
                gridColor: "#efefef"
            },
            xAxis: {
                fontColor: "#c1c1c1",
                gridColor: "#efefef"
            },
            extra: {
                legendTextColor: "#f45a46"
            },
            width: e,
            height: 200
        });
    },
    onLoad: function(a) {
        var e = this, t = new app.util.date().dateToStr("yyyy-MM");
        console.log(t), e.setData({
            date: t
        }), app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !1,
            data: {
                op: "statistics",
                date: e.data.date
            },
            success: function(a) {
                var t = a.data;
                t.data.list && (e.setData({
                    list: t.data.list,
                    x: t.data.x,
                    y: t.data.y
                }), e.chart(t.data.x, t.data.y));
            }
        });
    }
});