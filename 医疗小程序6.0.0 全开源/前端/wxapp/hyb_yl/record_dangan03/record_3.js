var app = getApp();

Page({
    data: {
        current: 0,
        tabArr: []
    },
    onLoad: function(t) {
        var a = t.str, e = JSON.parse(a);
        this.setData({
            tabArr: e
        });
        var r = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: r
        }), this.setData({
            backgroundColor: r
        });
        t.con;
    },
    switchTab: function(t) {
        this.setData({
            current: t.currentTarget.dataset.index
        });
    },
    secTabClick: function(t) {
        t.currentTarget.dataset.id;
    },
    nextClick: function() {
        wx.navigateBack({
            delta: 4
        });
    },
    choosePhoto: function(t) {
        var a = this, e = a.data.tabArr, r = (t.currentTarget.dataset.index, t.currentTarget.dataset.idx);
        wx.chooseImage({
            count: 9,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(t) {
                e[r].imgArr = e[r].imgArr.concat(t.tempFilePaths), 9 <= e[r].imgArr.length && (e[r].imgArr.length = 9), 
                console.log(e), a.setData({
                    tabArr: e
                });
            }
        });
    },
    delClick: function(t) {
        var a = this.data.tabArr, e = t.currentTarget.dataset.index;
        a[t.currentTarget.dataset.idx].imgArr.splice(e, 1), this.setData({
            tabArr: a
        });
    },
    subClick: function(t) {
        console.log(t), wx.navigateBack({
            delta: 4
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});