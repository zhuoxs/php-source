var app = getApp();

Page({
    data: {
        goods: [ {
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264562.png",
            name: "这是标题啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊"
        }, {
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264562.png",
            name: "这是标题啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊"
        }, {
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264562.png",
            name: "这是标题啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊"
        } ]
    },
    onLoad: function(o) {
        var t = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var n = wx.getStorageSync("url");
        this.setData({
            url: n
        }), app.util.request({
            url: "entry/wxapp/getGoodsList",
            cachetime: "0",
            success: function(o) {
                console.log(o.data), t.setData({
                    goodslist: o.data
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
    onShareAppMessage: function() {},
    goodsChoose: function(o) {
        var t = o.currentTarget.dataset.gid, n = o.currentTarget.dataset.gname;
        wx.setStorageSync("goodsChoose_gid", t), wx.setStorageSync("goodsChoose_gname", n), 
        wx.navigateBack({});
    }
});