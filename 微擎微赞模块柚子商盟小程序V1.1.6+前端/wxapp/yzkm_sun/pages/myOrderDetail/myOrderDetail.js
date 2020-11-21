var app = getApp();

Page({
    data: {},
    onLoad: function(o) {
        var t = this;
        console.log("初始下标"), console.log(o);
        var n = o.id;
        app.util.request({
            url: "entry/wxapp/Url",
            success: function(o) {
                console.log("页面加载请求"), console.log(o), wx.getStorageSync("url", o.data), t.setData({
                    url: o.data,
                    dd_id: n
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Order_details",
            data: {
                dd_id: n
            },
            success: function(o) {
                console.log("页面加载请求"), console.log(o), t.setData({
                    list: o.data
                });
            }
        });
    },
    details_goods: function(o) {
        var t = this.data.list.goodsId;
        wx.navigateTo({
            url: "../goodsDetails/goodsDetails?id=" + t
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