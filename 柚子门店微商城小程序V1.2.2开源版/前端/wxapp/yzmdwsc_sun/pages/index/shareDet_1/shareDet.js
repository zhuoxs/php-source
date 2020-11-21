Page({
    data: {
        navTile: "商品详情",
        indicatorDots: !1,
        autoplay: !1,
        interval: 3e3,
        duration: 800,
        goods: [ {
            imgUrls: [ "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152540565197.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152540565217.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152229433564.png" ],
            title: "发财树绿萝栀子花海棠花卉盆栽",
            shareprice: "0.15",
            detail: [ "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264562.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264579.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/15254126459.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264601.png" ],
            visitnum: 6
        } ]
    },
    onLoad: function(t) {
        wx.setNavigationBarTitle({
            title: this.data.navTile
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var t = wx.getStorageSync("openid");
        return console.log(t), "button" === res.from && console.log(res.target), {
            title: "商品",
            path: "/page/user?id=123",
            success: function(t) {},
            fail: function(t) {}
        };
    }
});