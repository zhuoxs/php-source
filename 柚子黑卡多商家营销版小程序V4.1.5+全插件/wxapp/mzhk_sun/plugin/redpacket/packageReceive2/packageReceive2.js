/*   time:2019-08-09 13:18:40*/
var app = getApp();
Page({
    data: {
        isPackage: !0,
        content: [],
        list: [],
        page: 1,
        isRule: !1
    },
    onPackage: function() {
        this.setData({
            isPackage: !this.data.isPackage
        })
    },
    onLoad: function(a) {
        var n = this;
        app.util.request({
            url: "entry/wxapp/RedPacketSet",
            showLoading: !1,
            data: {
                m: app.globalData.Plugin_redpacket
            },
            success: function(a) {
                return console.log(a.data), 2 == a.data ? (wx.showModal({
                    title: "提示",
                    content: "未开启活动",
                    showCancel: !1,
                    success: function(a) {
                        wx.reLaunch({
                            url: "/mzhk_sun/pages/index/index"
                        })
                    }
                }), !1) : 0 == a.data.open_redpacket || 0 == a.data.open_redpacket2 ? (wx.showModal({
                    title: "提示",
                    content: "未开启活动",
                    showCancel: !1,
                    success: function(a) {
                        wx.reLaunch({
                            url: "/mzhk_sun/pages/index/index"
                        })
                    }
                }), !1) : void n.setData({
                    redset: a.data
                })
            }
        }), app.util.request({
            url: "entry/wxapp/Getredpacket1",
            showLoading: !1,
            data: {
                type: 1,
                m: app.globalData.Plugin_redpacket
            },
            success: function(a) {
                console.log(a.data);
                var t = parseInt(a.data.id);
                if (2 != a.data) {
                    n.setData({
                        content: a.data,
                        list: a.data.goods
                    });
                    var e = wx.getStorageSync("openid");
                    app.util.request({
                        url: "entry/wxapp/InsertRedPacket2",
                        showLoading: !1,
                        data: {
                            rid: t,
                            openid: e,
                            m: app.globalData.Plugin_redpacket
                        },
                        success: function(a) {
                            console.log(a.data)
                        }
                    })
                } else n.setData({
                    content: [],
                    list: [],
                    snum: 1,
                    nrid: 0
                })
            }
        })
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var e = this,
            n = e.data.page,
            o = e.data.list;
        app.util.request({
            url: "entry/wxapp/Getredpacket1",
            cachetime: "0",
            data: {
                type: 1,
                page: n,
                m: app.globalData.Plugin_redpacket
            },
            success: function(a) {
                if (console.log(a.data), console.log(a.data.goods), 0 < a.data.goods.length) {
                    var t = a.data.goods;
                    o = o.concat(t), e.setData({
                        list: o,
                        page: n + 1
                    })
                } else wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                })
            }
        })
    },
    toDetail: function(a) {
        var t = a.currentTarget.dataset.lid,
            e = a.currentTarget.dataset.gid;
        1 == t ? wx.navigateTo({
            url: "../../../pages/index/goods/goods?gid=" + e
        }) : 2 == t ? wx.navigateTo({
            url: "../../../pages/index/bardet/bardet?id=" + e
        }) : 3 == t ? wx.navigateTo({
            url: "../../../pages/index/groupdet/groupdet?id=" + e
        }) : 5 == t ? wx.navigateTo({
            url: "../../../pages/index/package/package?id=" + e
        }) : 12 == t && wx.navigateTo({
            url: "/mzhk_sun/plugin2/secondary/detail/detail?id=" + e
        })
    },
    onAnchorPoint: function() {
        wx.pageScrollTo({
            scrollTop: 400,
            duration: 500
        })
    },
    onAnchorPoint1: function() {
        this.setData({
            isPackage: !this.data.isPackage
        }), wx.pageScrollTo({
            scrollTop: 400,
            duration: 500
        })
    },
    onRule: function() {
        this.setData({
            isRule: !this.data.isRule
        })
    }
});