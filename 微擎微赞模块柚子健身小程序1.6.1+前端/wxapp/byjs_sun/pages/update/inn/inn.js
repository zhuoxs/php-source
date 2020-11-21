var app = getApp(), QQMapWX = require("../../../resource/utils/qqmap-wx-jssdk.js"), demo = new QQMapWX({
    key: "5KFBZ-F6RHW-UKORS-R674O-PLPJ2-QHFFQ"
});

Page({
    data: {
        list: []
    },
    onLoad: function(t) {
        var a = this, e = t.mall_name, n = t.latitude_dq, o = t.longitude_dq;
        a.setData({
            mall_name: e
        }), console.log(t), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetMall1",
            cachetime: "0",
            data: {
                longitude_dq: o,
                latitude_dq: n
            },
            success: function(t) {
                a.setData({
                    list: t.data
                });
            }
        });
    },
    goInndetail: function(t) {
        var a = t.currentTarget.dataset.text;
        console.log(a), wx.reLaunch({
            url: "../../product/index/index?mall_name=" + a
        }), wx.setStorageSync("mall_name", a);
    },
    onShow: function() {
        console.log(this.data.list[0]);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    getDistance: function(t, a, e, n) {
        a = a || 0, e = e || 0, n = n || 0;
        var o = (t = t || 0) * Math.PI / 180, s = e * Math.PI / 180, l = o - s, i = a * Math.PI / 180 - n * Math.PI / 180;
        return (12756274 * Math.asin(Math.sqrt(Math.pow(Math.sin(l / 2), 2) + Math.cos(o) * Math.cos(s) * Math.pow(Math.sin(i / 2), 2)))).toFixed(0) / 1e3;
    }
});