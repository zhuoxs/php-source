var app = getApp();

Page({
    data: {
        maxNum: 24,
        list: [ {
            imgSrc: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152634825519.png",
            num: 5
        }, {
            imgSrc: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152634825519.png",
            num: 4
        }, {
            imgSrc: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152634825519.png",
            num: 2
        }, {
            imgSrc: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152634825519.png",
            num: 1
        }, {
            imgSrc: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152634825519.png",
            num: 5
        } ]
    },
    onLoad: function(n) {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(n) {
                wx.setStorageSync("url", n.data), t.setData({
                    url: n.data
                });
            }
        }), t.allNumfunc();
    },
    onShow: function() {
        var t = this, n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/wineDatanum",
            cachetime: "0",
            data: {
                openid: n
            },
            success: function(n) {
                console.log("存酒说明：" + n.data.winedetails), t.setData({
                    y_num: n.data.y_num,
                    k_num: n.data.k_num,
                    wineData: n.data.wineData,
                    alcoholExplain: n.data.winedetails
                });
            }
        });
    },
    allNumfunc: function() {
        for (var n = this.data.list, t = 0, a = 0; a < n.length; a++) t += n[a].num;
        this.setData({
            allNum: t
        });
    },
    goWineorder: function() {
        wx.navigateTo({
            url: "../wineorder/wineorder?navIndex=1"
        });
    },
    goWinetwo: function() {
        wx.navigateTo({
            url: "../winetwo/winetwo"
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});