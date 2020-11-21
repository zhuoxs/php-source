var app = getApp();

Page({
    data: {
        taocan: [ "未支付", "已支付", "待评价", "已评价" ],
        dingdan: [ {
            jieshao: "返回来凤凰来划分会发生好大好大杀地煞 到哈市的撒旦"
        }, {
            jieshao: "粉红女郎士大夫喝的时候发生的粉色的恢复联合国里说过类似的故事的  到哈市的撒旦"
        }, {
            jieshao: "推荐看宏观和人家给人家公务员和个人未绝望解放后无关我感觉 到哈市的撒旦"
        } ],
        currentTab: 0
    },
    taocan: function(n) {
        var a = this, t = parseInt(n.currentTarget.dataset.index), e = wx.getStorageSync("openid");
        if (console.log(t), 1 == t && (console.log("已支付"), app.util.request({
            url: "entry/wxapp/Allordersyi",
            data: {
                openid: e
            },
            success: function(n) {
                console.log(n), a.setData({
                    dingdan: n.data.data
                });
            },
            fail: function(n) {
                console.log(n);
            }
        })), 2 == t) {
            console.log("待评价");
            e = wx.getStorageSync("openid");
            app.util.request({
                url: "entry/wxapp/Allorderspingj",
                data: {
                    openid: e
                },
                success: function(n) {
                    console.log(n), a.setData({
                        dingdan: n.data.data,
                        index: t
                    });
                },
                fail: function(n) {
                    console.log(n);
                }
            });
        }
        if (3 == t) {
            console.log("已评价");
            e = wx.getStorageSync("openid");
            app.util.request({
                url: "entry/wxapp/Allordersypj",
                data: {
                    openid: e
                },
                success: function(n) {
                    console.log(n), a.setData({
                        dingdan: n.data.data,
                        index: t
                    });
                },
                fail: function(n) {
                    console.log(n);
                }
            });
        }
        this.setData({
            currentTab: n.currentTarget.dataset.index + 1
        });
    },
    taocan1: function(n) {
        var a = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Allorders",
            data: {
                openid: t
            },
            success: function(n) {
                console.log(n), a.setData({
                    dingdan: n.data.data
                });
            },
            fail: function(n) {
                console.log(n);
            }
        });
        var e = n.currentTarget.dataset.index;
        console.log(e), this.setData({
            currentTab: 0
        });
    },
    deleteProduct: function(n) {
        var a = n.currentTarget.dataset.index, t = this.data.dingdan, e = n.currentTarget.dataset.id, o = wx.getStorageSync("openid");
        console.log(e);
        var i = app.siteInfo.uniacid;
        t.splice(a, 1), app.util.request({
            url: "entry/wxapp/Delvideo",
            data: {
                id: e,
                uniacid: i,
                openid: o
            },
            success: function(n) {
                console.log(n);
            },
            fail: function(n) {
                console.log(n);
            }
        }), this.setData({
            dingdan: t
        });
    },
    onLoad: function(n) {
        var a = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Allorders",
            data: {
                openid: t
            },
            success: function(n) {
                console.log(n), a.setData({
                    dingdan: n.data.data
                });
            },
            fail: function(n) {
                console.log(n);
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    pingjia: function(n) {
        n.currentTarget.dataset.id;
        wx.navigateTo({
            url: "/hyb_yl/jibingxq/jibingxq?id=" + n.currentTarget.dataset.id
        });
    }
});