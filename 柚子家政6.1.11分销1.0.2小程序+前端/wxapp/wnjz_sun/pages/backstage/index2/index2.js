var app = getApp();

Page({
    data: {
        orderNum: ""
    },
    onLoad: function(t) {
        var e = this, o = t.id;
        wx.setStorageSync("sid", o), app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        }), wx.getUserInfo({
            success: function(t) {
                e.setData({
                    thumb: t.userInfo.avatarUrl,
                    nickname: t.userInfo.nickName
                });
            }
        }), app.util.request({
            url: "entry/wxapp/system",
            cachetime: "0",
            success: function(t) {
                e.setData({
                    pt_name: t.data.pt_name
                });
            }
        });
    },
    gocurrent: function(t) {
        var e = wx.getStorageSync("sid");
        wx.navigateTo({
            url: "../current/current?sid=" + e
        });
    },
    gofinish: function(t) {
        var e = wx.getStorageSync("sid");
        wx.navigateTo({
            url: "../../backstage/finish/finish?sid=" + e
        });
    },
    Signout: function(t) {
        wx.navigateTo({
            url: "../backstage"
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this, t = wx.getStorageSync("sid");
        app.util.request({
            url: "entry/wxapp/Nowuser",
            cachetime: "0",
            data: {
                sid: t
            },
            success: function(t) {
                e.setData({
                    count: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    scanCode: function(t) {
        var a = this, n = wx.getStorageSync("sid");
        wx.scanCode({
            scanType: "",
            success: function(t) {
                console.log("扫描获取数据-成功"), console.log(t);
                var e = JSON.parse(t.result);
                console.log(e.id), app.util.request({
                    url: "entry/wxapp/GetSidOrderInfo",
                    cachetime: "0",
                    data: {
                        id: e.id,
                        sid: n
                    },
                    success: function(t) {
                        console.log("获取订单数据");
                        var e = t.data;
                        if (5 == e.status && (e.b_name = "该订单已核销"), n != e.sid) {
                            var o = 2;
                            e.b_name = "该订单您无权查看";
                        } else o = 1;
                        console.log(e), a.setData({
                            writeoff: e,
                            show: !0,
                            is_build: o
                        });
                    }
                });
            },
            fail: function(t) {
                console.log("扫描获取数据-失败"), console.log(t);
            }
        });
    },
    writeoff: function(t) {
        var e = this, o = e.data.writeoff, a = wx.getStorageSync("sid");
        app.util.request({
            url: "entry/wxapp/SaoSIDOrder",
            cachetime: "0",
            data: {
                id: o.oid,
                sid: a
            },
            success: function(t) {
                console.log("核销订单"), console.log(t.data), e.setData({
                    show: !1
                }), 1 == t.data ? wx.showToast({
                    title: "核销成功",
                    icon: "success",
                    duration: 2e3
                }) : 3 == t.data ? wx.showToast({
                    title: "该订单不存在！",
                    icon: "none",
                    duration: 2e3
                }) : wx.showToast({
                    title: "该订单已核销！",
                    icon: "none",
                    duration: 2e3
                });
            },
            fial: function(t) {
                console.log("核销订单11"), console.log(t.data), wx.showModal({
                    title: "提示信息",
                    content: t.data.message,
                    showCancel: !1
                });
            }
        });
    },
    showModel: function(t) {
        this.setData({
            show: !1
        });
    },
    orderNum: function(t) {
        this.setData({
            orderNum: t.detail.value
        });
    },
    submit: function(t) {
        var e = this, o = e.data.orderNum;
        console.log(o), null == o ? wx.showModal({
            content: "请输入订单号",
            showCancel: !1
        }) : app.util.request({
            url: "entry/wxapp/IsUserorder",
            cachetime: "0",
            data: {
                orderNum: o
            },
            success: function(t) {
                1 == t.data ? (e.setData({
                    orderNum: ""
                }), wx.showToast({
                    title: "确认成功",
                    icon: "success",
                    duration: 2e3
                }), e.onShow()) : wx.showToast({
                    title: "确认失败",
                    icon: "none",
                    duration: 2e3
                });
            }
        });
    }
});