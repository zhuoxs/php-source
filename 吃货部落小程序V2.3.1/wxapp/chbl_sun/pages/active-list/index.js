var util = require("../../resource/js/utils/util.js"), app = getApp();

Page({
    data: {
        statusType: [ "最热活动", "最新活动" ],
        currentType: 0,
        tabClass: [ "", "", "", "" ],
        orderListStatus: [ "待支付", "进行中", "已完成", "已完成" ]
    },
    onLoad: function(t) {
        var e = this;
        console.log(this.data.activeList), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
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
        var o = wx.getStorageSync("latitude");
        console.log(o);
        wx.getStorageSync("longitude");
        console.log(o);
        var a = wx.getStorageSync("county");
        app.get_location().then(function(t) {
            app.util.request({
                url: "entry/wxapp/activeList",
                cachetime: "10",
                data: {
                    currCityId: a.id,
                    latitude: t.latitude,
                    longitude: t.longitude
                },
                success: function(t) {
                    console.log(t), e.setData({
                        activeList: t.data.data
                    });
                }
            });
        });
    },
    goJoin: function(t) {
        var e = t.currentTarget.dataset.overtime, o = t.currentTarget.dataset.begintime;
        console.log(o), 1 == e ? 2 == o ? wx.navigateTo({
            url: "../active-list/details?id=" + t.currentTarget.dataset.id
        }) : wx.showToast({
            title: "活动尚未开始！",
            icon: "none"
        }) : wx.showToast({
            title: "活动已结束！",
            icon: "none"
        });
    },
    onReady: function() {},
    onShow: function() {
        var n = util.formatTime(new Date());
        setInterval(function() {
            var t = new Date(), e = t.getHours(), o = t.getMinutes(), a = t.getSeconds();
            1 == e && 0 == o && 0 == a && (console.log(n), wx.getStorage({
                key: "openid",
                success: function(t) {
                    app.util.request({
                        url: "entry/wxapp/autoNum",
                        cachetime: "0",
                        data: {
                            openid: t.data
                        },
                        success: function(t) {
                            console.log(t);
                        }
                    });
                }
            }));
        }, 1e3), this.setData({
            time: n
        }), console.log(this.data.time);
    },
    gameover: function() {
        wx.showToast({
            title: "活动已结束！",
            icon: "none",
            duration: 2e3
        });
    },
    statusTap: function(t) {
        var e = this;
        console.log(t);
        var o = t.currentTarget.dataset.index;
        e.data.currentType = o, e.setData({
            currentType: o
        }), e.onShow();
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});