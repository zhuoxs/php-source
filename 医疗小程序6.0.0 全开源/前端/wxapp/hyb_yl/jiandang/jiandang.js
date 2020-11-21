var app = getApp();

Page({
    data: {
        current: 0,
        tabArr: []
    },
    onLoad: function(t) {
        var a = this, e = wx.getStorageSync("color");
        console.log(e), wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: e
        }), a.setData({
            backgroundColor: e
        }), app.util.request({
            url: "entry/wxapp/Allfeilei",
            success: function(t) {
                console.log(t), a.setData({
                    items: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
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
        var a = this, e = a.data.tabArr, n = (t.currentTarget.dataset.index, t.currentTarget.dataset.idx);
        wx.chooseImage({
            count: 9,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(t) {
                e[n].imgArr = e[n].imgArr.concat(t.tempFilePaths), 9 <= e[n].imgArr.length && (e[n].imgArr.length = 9), 
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