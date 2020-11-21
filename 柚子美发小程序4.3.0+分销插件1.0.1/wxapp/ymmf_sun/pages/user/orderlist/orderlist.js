var app = getApp();

Page({
    data: {
        orderlist: [ {
            shop: "没名堂",
            stysrc: "../../../../style/images/styimg.png",
            styname: "托尼",
            style: "洗剪吹",
            time: "2018-01-21 10:30",
            status: "已完成"
        }, {
            shop: "没名堂",
            stysrc: "../../../../style/images/styimg.png",
            styname: "托尼",
            style: "洗剪吹",
            time: "2018-01-21 10:30",
            status: "未完成"
        } ]
    },
    onLoad: function(t) {
        var e = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/allOrder",
                    cachetime: "0",
                    data: {
                        uid: t.data
                    },
                    success: function(t) {
                        console.log(t.data.data), e.setData({});
                    }
                });
            }
        }), e.urls();
    },
    urls: function(t) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Url2",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url2", t.data);
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        });
    },
    delorder: function(t) {
        var e = this, n = t.currentTarget.dataset.id;
        wx.showModal({
            title: "提示",
            content: "确定删除订单吗",
            success: function(t) {
                t.confirm ? app.util.request({
                    url: "entry/wxapp/Delappion",
                    cachetime: "0",
                    data: {
                        id: n
                    },
                    success: function(t) {
                        e.onLoad();
                    }
                }) : t.cancel && console.log("用户点击取消");
            }
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