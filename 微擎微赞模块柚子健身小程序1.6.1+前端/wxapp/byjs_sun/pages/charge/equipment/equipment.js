var app = getApp();

Page({
    data: {
        list: [ {
            imgSrc: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152472139629.jpg",
            name: "动感单车静音磁控健身",
            price: "68"
        } ]
    },
    onLoad: function(t) {
        var a = this, e = t.navTitleText;
        a.setData({
            navTitleText: e
        }), wx.setNavigationBarTitle({
            title: e
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
        var n = t.id;
        app.util.request({
            url: "entry/wxapp/GetGoods",
            cachetime: 0,
            data: {
                id: n
            },
            success: function(t) {
                a.setData({
                    list: t.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    goUrl: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "/byjs_sun/pages/charge/chargeProductInfo/chargeProductInfo?id=" + a
        });
    }
});