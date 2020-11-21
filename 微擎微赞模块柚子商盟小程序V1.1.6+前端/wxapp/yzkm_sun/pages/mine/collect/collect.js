var app = getApp();

Page({
    data: {
        currentIndex: 0,
        showModalStatus: !1,
        currentTab: 0,
        statusType: [ "收藏的圈子", "收藏的商家" ],
        light: "",
        kong: "",
        num: 5,
        hadImg: !0
    },
    onLoad: function(t) {
        var e = wx.getStorageSync("openid");
        console.log(".............................................."), console.log(e);
        var o = this;
        console.log("接收页面数据"), console.log(e), o.setData({
            light: o.data.num,
            kong: 5 - o.data.num
        }), app.util.request({
            url: "entry/wxapp/Url",
            success: function(t) {
                console.log(t), wx.getStorageSync("url", t.data), o.setData({
                    url: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/User_id",
            data: {
                openid: e
            },
            success: function(t) {
                console.log("查看用户id"), console.log(t), wx.setStorageSync("dqyh_id", t.data.id);
            }
        }), o.diyWinColor();
    },
    statusTap: function(a) {
        var n = this;
        console.log(a);
        var i = wx.getStorageSync("dqyh_id");
        n.setData({
            currentIndex: a.currentTarget.dataset.index
        }), wx.getLocation({
            type: "gcj02",
            success: function(t) {
                var e = t.latitude, o = t.longitude;
                app.util.request({
                    url: "entry/wxapp/Mine_sc",
                    data: {
                        dqyh_id: i,
                        currentIndex: a.currentTarget.dataset.index,
                        latitude: e,
                        longitude: o
                    },
                    success: function(t) {
                        console.log("商家数据请求"), console.log(t), n.setData({
                            list: t.data
                        });
                    }
                });
            }
        });
    },
    toCircleDetails: function(t) {
        console.log("跳转圈子详情页id"), console.log(t);
        var e = t.currentTarget.dataset.id;
        if (2 == t.currentTarget.dataset.dele_sta) return wx.showToast({
            title: "该收藏已被删除或下架",
            icon: "none"
        }), !1;
        wx.navigateTo({
            url: "../../circle/details/details?id=" + e
        });
    },
    toSellerDeatils: function(t) {
        console.log("跳转商家详情页id"), console.log(t);
        var e = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../../seller/details/details?id=" + e
        });
    },
    writeComments: function(t) {
        var e = t.currentTarget.dataset.statu;
        this.util(e), console.log(t);
    },
    close: function(t) {
        var e = t.currentTarget.dataset.statu;
        this.util(e);
    },
    util: function(t) {
        var e = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = e).opacity(0).height(0).step(), this.setData({
            animationData: e.export()
        }), setTimeout(function() {
            e.opacity(1).height("630rpx").step(), this.setData({
                animationData: e
            }), "close" == t && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == t && this.setData({
            showModalStatus: !0
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this, t = wx.getStorageSync("user_id");
        console.log("当前用户id"), console.log(t), 1 == this.data.currentIndex ? app.util.request({
            url: "entry/wxapp/Mine_sc",
            data: {
                dqyh_id: t,
                currentIndex: 1
            },
            success: function(t) {
                console.log("收藏的圈子"), console.log(t), e.setData({
                    list: t.data
                });
            }
        }) : (console.log(777), app.util.request({
            url: "entry/wxapp/Mine_sc",
            data: {
                dqyh_id: t,
                currentIndex: 0
            },
            success: function(t) {
                console.log("收藏的圈子"), console.log(t), e.setData({
                    list: t.data
                });
            }
        }));
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    diyWinColor: function(t) {
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: "#ffb62b"
        }), wx.setNavigationBarTitle({
            title: "我的收藏"
        });
    }
});