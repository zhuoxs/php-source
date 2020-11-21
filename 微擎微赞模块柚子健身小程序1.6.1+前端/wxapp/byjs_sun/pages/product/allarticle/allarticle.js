var app = getApp();

Page({
    data: {
        allarticle: [ {
            imgSrc: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152634825519.png",
            name: "增肌增重课程"
        } ]
    },
    onLoad: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GoodsArticle",
            cachetime: "0",
            success: function(t) {
                console.log(t.data), a.setData({
                    allarticle: t.data
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
    goWritings: function(t) {
        var a = t.currentTarget.dataset.id, n = t.currentTarget.dataset.goods_id;
        wx.navigateTo({
            url: "/byjs_sun/pages/product/writings/writingsInfo/writingsInfo?id=" + a + "&goods_id=" + n
        });
    }
});