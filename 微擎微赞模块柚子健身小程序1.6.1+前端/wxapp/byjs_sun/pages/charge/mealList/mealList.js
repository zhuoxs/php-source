var app = getApp(), util = require("../../../resource/utils/util.js");

Page({
    data: {
        tab1: "套餐列表",
        tab2: "我的套餐",
        tabArr: {
            curHdIndex: 0,
            curBdIndex: 0
        }
    },
    onLoad: function(t) {
        var e = this, a = t.typeid;
        e.setData({
            typeid: a
        });
        var o = wx.getStorageSync("users").id;
        console.log(o), app.util.request({
            url: "entry/wxapp/GetMeal",
            data: {
                typeid: a,
                uid: o
            },
            success: function(t) {
                console.log(t), e.setData({
                    itemarr: t.data.res,
                    my: t.data.my,
                    time: t.data.time
                });
            }
        });
        var n = wx.getStorageSync("url");
        e.setData({
            url: n
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    swichNav: function(t) {
        var e = t.target.dataset.index, a = {};
        a.curHdIndex = e, a.curBdIndex = e, this.setData({
            tabArr: a
        });
    },
    book: function(t) {
        t.currentTarget.dataset.index, t.currentTarget.dataset.count;
        var e = t.currentTarget.dataset.oid;
        console.log(e), wx.navigateTo({
            url: "/byjs_sun/pages/charge/mealBook/mealBook?oid=" + e
        });
        var a = Date.parse(new Date());
        a /= 1e3;
        util.formatTimeTwo(a, "h"), util.formatTimeTwo(a, "Y/M/D h:m:s");
    }
});