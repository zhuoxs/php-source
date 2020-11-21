/*   time:2019-08-09 13:18:40*/
var app = getApp();
Page({
    data: {
        isPackage: !0,
        snum: 1,
        is_modal_Hidden: !0,
        rid: 0,
        uid: 0,
        isshare: 0,
        list: [],
        nrid: 0,
        isgive: 0,
        userimg: [],
        page: 1,
        isRule: !1
    },
    onPackage: function() {
        this.setData({
            isPackage: !this.data.isPackage
        })
    },
    onLoad: function(a) {
        var o = this;
        app.wxauthSetting(), app.util.request({
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
                }), !1) : 0 == a.data.open_redpacket || 0 == a.data.open_redpacket1 ? (wx.showModal({
                    title: "提示",
                    content: "未开启活动",
                    showCancel: !1,
                    success: function(a) {
                        wx.reLaunch({
                            url: "/mzhk_sun/pages/index/index"
                        })
                    }
                }), !1) : void o.setData({
                    redset: a.data
                })
            }
        });
        var e = a.is_share,
            t = a.id,
            n = a.user_id;
        e && t && n && o.setData({
            rid: t,
            uid: n,
            isshare: e
        });
        o.data.snum, o.data.list, o.data.nrid;
        app.util.request({
            url: "entry/wxapp/Getredpacket1",
            showLoading: !1,
            data: {
                m: app.globalData.Plugin_redpacket
            },
            success: function(a) {
                console.log(a.data), console.log(a.data.id);
                var e = parseInt(a.data.snum),
                    t = parseInt(a.data.id);
                if (2 != a.data) {
                    o.setData({
                        content: a.data,
                        list: a.data.goods,
                        snum: e,
                        nrid: a.data.id
                    });
                    var n = wx.getStorageSync("openid");
                    app.util.request({
                        url: "entry/wxapp/IsGive",
                        showLoading: !1,
                        data: {
                            rid: t,
                            openid: n,
                            m: app.globalData.Plugin_redpacket
                        },
                        success: function(a) {
                            console.log(a.data), a.data && o.setData({
                                isgive: a.data.isgive,
                                userimg: a.data.friends
                            })
                        }
                    })
                } else o.setData({
                    content: [],
                    list: [],
                    snum: 1,
                    nrid: 0
                })
            }
        })
    },
    onReady: function() {},
    onShow: function() {
        var a = this;
        app.func.islogin(app, a);
        var e = a.data.isshare,
            t = a.data.rid,
            n = a.data.uid,
            o = wx.getStorageSync("openid");
        console.log(e), console.log(t), console.log(n), console.log(o), 1 == e && 0 < t && 0 < n && o && app.util.request({
            url: "entry/wxapp/InsertRedPacket",
            showLoading: !1,
            data: {
                rid: t,
                uid: n,
                openid: o,
                m: app.globalData.Plugin_redpacket
            },
            success: function(a) {
                console.log(111)
            }
        })
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var t = this,
            n = t.data.page,
            o = t.data.list;
        app.util.request({
            url: "entry/wxapp/Getredpacket1",
            cachetime: "0",
            data: {
                page: n,
                m: app.globalData.Plugin_redpacket
            },
            success: function(a) {
                if (console.log(a.data), console.log(a.data.goods), 0 < a.data.goods.length) {
                    var e = a.data.goods;
                    o = o.concat(e), t.setData({
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
    onShareAppMessage: function(a) {
        var e = wx.getStorageSync("users"),
            t = this.data.content,
            n = t.id,
            o = t.rname;
        return "button" === a.from && console.log(a.target), {
            title: o,
            path: "/mzhk_sun/plugin/redpacket/packageReceive/packageReceive?id=" + n + "&user_id=" + e.id + "&is_share=1",
            success: function(a) {
                console.log("转发成功")
            },
            fail: function(a) {
                console.log("转发失败")
            }
        }
    },
    toDetail: function(a) {
        var e = a.currentTarget.dataset.lid,
            t = a.currentTarget.dataset.gid;
        1 == e ? wx.navigateTo({
            url: "../../../pages/index/goods/goods?gid=" + t
        }) : 2 == e ? wx.navigateTo({
            url: "../../../pages/index/bardet/bardet?id=" + t
        }) : 3 == e ? wx.navigateTo({
            url: "../../../pages/index/groupdet/groupdet?id=" + t
        }) : 5 == e ? wx.navigateTo({
            url: "../../../pages/index/package/package?id=" + t
        }) : 12 == e && wx.navigateTo({
            url: "/mzhk_sun/plugin2/secondary/detail/detail?id=" + t
        })
    },
    updateUserInfo: function(a) {
        console.log("授权操作更新");
        app.wxauthSetting()
    },
    toIndex: function(a) {
        wx.reLaunch({
            url: "/mzhk_sun/pages/index/index"
        })
    },
    onRule: function() {
        this.setData({
            isRule: !this.data.isRule
        })
    },
    onAnchorPoint: function() {
        wx.pageScrollTo({
            scrollTop: 470,
            duration: 500
        })
    }
});