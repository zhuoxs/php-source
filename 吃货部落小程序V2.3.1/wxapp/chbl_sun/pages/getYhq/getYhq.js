var app = getApp();

Page({
    data: {
        statusType: [ "距离最近", "最新发布" ],
        currentType: 0
    },
    onLoad: function(t) {
        var e = wx.getStorageSync("user_info"), o = wx.getStorageSync("url");
        this.setData({
            user_info: e,
            url: o
        });
    },
    goToStore: function(t) {
        wx.navigateTo({
            url: "../shops/shops?id=" + t.currentTarget.dataset.id
        });
    },
    goYhqList: function(t) {
        wx.navigateTo({
            url: "../hadYhq/hadYhq"
        });
    },
    statusTap: function(t) {
        this.setData({
            currentType: t.currentTarget.dataset.index
        }), this.onShow();
    },
    onReady: function() {},
    onShow: function() {
        var n = this, t = wx.getStorageSync("openid"), a = n.data.currentType;
        console.log(a), wx.getLocation({
            type: "wgs84",
            success: function(t) {
                console.log(t), wx.setStorageSync("latitude", t.latitude), wx.setStorageSync("longitude", t.longitude);
                var e = t.latitude, o = t.longitude;
                app.util.request({
                    url: "entry/wxapp/getCoupon",
                    cachetime: "30",
                    data: {
                        latitude: e,
                        longitude: o,
                        currentType: a
                    },
                    success: function(t) {
                        console.log(t), n.setData({
                            couponList: t.data
                        });
                    }
                });
            },
            fail: function(t) {
                wx.showModal({
                    title: "请授权获得地理信息",
                    content: '点击右上角...，进入关于页面，再点击右上角...，进入设置,开启"使用我的地理位置"'
                });
            }
        }), app.util.request({
            url: "entry/wxapp/MyCoupon",
            cachetime: "0",
            data: {
                openid: t
            },
            success: function(t) {
                console.log(t), n.setData({
                    Mycoupon: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/AllUserCoupon",
            cachetime: "0",
            success: function(t) {
                console.log(t), n.setData({
                    allUserCoupon: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});