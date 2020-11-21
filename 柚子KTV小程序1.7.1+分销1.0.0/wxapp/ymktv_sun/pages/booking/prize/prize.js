var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {},
    onLoad: function(t) {
        var a = t.id;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.setStorageSync("pid", a), this.url();
    },
    url: function(t) {
        var a = this;
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
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
    },
    onShow: function() {
        var a = this, t = wx.getStorageSync("pid");
        app.util.request({
            url: "entry/wxapp/PrizeData",
            cachetime: "0",
            data: {
                pid: t
            },
            success: function(t) {
                console.log(t.data), a.setData({
                    prizeData: t.data
                });
            }
        });
    },
    onReady: function() {},
    address: function() {
        var a = this;
        wx.chooseAddress({
            success: function(t) {
                a.setData({
                    userName: t.userName,
                    provinceName: t.provinceName,
                    cityName: t.cityName,
                    countyName: t.countyName,
                    detailInfo: t.detailInfo,
                    telNumber: t.telNumber
                });
            }
        });
    },
    bindSave: function(t) {
        var a = this, e = wx.getStorageSync("bid"), o = t.detail.value.remark;
        if (a.data.userName) {
            var n = a.data.userName, i = a.data.telNumber, r = a.data.cityName + a.data.countyName + a.data.detailInfo, c = wx.getStorageSync("userid");
            console.log(r), app.util.request({
                url: "entry/wxapp/GiftData",
                cachetime: "0",
                data: {
                    id: a.data.prizeData.id,
                    remark: o,
                    username: n,
                    tel: i,
                    address: r,
                    openid: c,
                    bid: e
                },
                success: function(t) {
                    console.log(t.data), 1 == t.data ? (wx.showToast({
                        title: "兑换成功！",
                        icon: "success",
                        duration: 2e3
                    }), wx.redirectTo({
                        url: "../../my/mycollect/mycollect"
                    })) : 2 == t.data ? wx.showToast({
                        title: "您已经领取过该奖品了！",
                        icon: "none",
                        duration: 2e3
                    }) : 3 == t.data ? wx.showToast({
                        title: "奖品已经兑换完了！",
                        icon: "none",
                        duration: 2e3
                    }) : wx.showToast({
                        title: "兑换失败！",
                        icon: "none",
                        duration: 2e3
                    });
                }
            });
        } else wx.showToast({
            title: "请选择地址！",
            icon: "none"
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});