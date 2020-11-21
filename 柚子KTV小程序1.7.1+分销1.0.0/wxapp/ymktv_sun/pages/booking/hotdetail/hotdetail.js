var app = getApp();

Page({
    data: {
        goods_img: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152634825519.png",
        goods_name: "199元美食套餐",
        goods_price: "199",
        bookingTime: "12:00-24:00",
        msg: {
            imgSrc: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152634825519.png",
            name: "199元美食套餐"
        },
        list: [ {
            goods: "煮鱼1份 ",
            price: "68"
        }, {
            goods: "水煮肉片1份 ",
            price: "68"
        }, {
            goods: "泡椒田鸡1份泡椒田鸡1份泡椒田鸡1份泡椒田鸡1份 ",
            price: "68"
        } ],
        list1: [ "可用时间 ", "如下指定日期2018-05-20到2018-05-20比照周末使用11:00 - 18:00;17:00 - 21:00;17:00 - 20:30 ", "包厢安排：主题中包及以下（6-8人）" ]
    },
    onLoad: function(t) {
        var e = this, o = t.bid, a = t.id;
        wx.setStorageSync("bid", o), wx.setStorageSync("id", a), wx.setStorageSync("tel", t.tel), 
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        });
    },
    onShow: function() {
        var e = this, t = wx.getStorageSync("id");
        app.util.request({
            url: "entry/wxapp/drinkIdData",
            cachetime: "0",
            data: {
                id: t
            },
            success: function(t) {
                e.setData({
                    drinkData: t.data
                });
            }
        });
    },
    getPhoneNumber: function(t) {
        var e = wx.getStorageSync("tel");
        wx.makePhoneCall({
            phoneNumber: e
        });
    },
    goHotyes: function(t) {
        var e = wx.getStorageSync("bid"), o = wx.getStorageSync("id");
        wx.navigateTo({
            url: "../hotyes/hotyes?id=" + o + "&bid=" + e
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});