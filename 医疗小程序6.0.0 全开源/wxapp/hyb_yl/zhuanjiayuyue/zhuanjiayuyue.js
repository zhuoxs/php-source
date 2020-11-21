var app = getApp(), WxParse = require("../wxParse/wxParse.js");

Page({
    data: {},
    onLoad: function(a) {
        var t = this, n = a.id, e = a.ksname, i = app.siteInfo.uniacid, o = a.date, s = a.day, c = wx.getStorageSync("openid");
        t.setData({
            ksname: e
        }), app.util.request({
            url: "entry/wxapp/Zhuanjiaxiangqing",
            data: {
                id: n
            },
            success: function(a) {
                t.setData({
                    xiangqing: a.data.data,
                    zid: n
                }), WxParse.wxParse("article", "html", a.data.data.z_content, t, 5);
            },
            fail: function(a) {
                console.log(a);
            }
        }), app.util.request({
            url: "entry/wxapp/Zhuanpaibid",
            data: {
                pp_id: n,
                date: o,
                day: s
            },
            success: function(a) {
                t.setData({
                    zhuanpaibid: a.data.data[0],
                    startTime: a.data.data.startTime
                });
            },
            fail: function(a) {
                console.log(a);
            }
        }), app.util.request({
            url: "entry/wxapp/Myinforsarray",
            data: {
                openid: c,
                uniacid: i
            },
            success: function(a) {
                t.setData({
                    mygerzl: a.data.data
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    yuyuezhifu: function(e) {
        var a = this, t = a.data.mygerzl, n = a.data.xiangqing, i = t.my_id, o = (n.id, 
        a.data.zid), s = app.siteInfo.uniacid, c = (a.data.myshifouyy, e.currentTarget.dataset.time), u = e.currentTarget.dataset.midday, r = e.currentTarget.dataset.year, d = wx.getStorageSync("openid"), p = a.data.ksname;
        app.util.request({
            url: "entry/wxapp/Myshifouyy",
            data: {
                zy_openid: d,
                uniacid: s,
                zy_riqi: u,
                zy_type: c,
                zy_yibao: times
            },
            success: function(a) {
                return !1 !== a.data.data ? (wx.showToast({
                    title: "您已预约",
                    icon: "success",
                    duration: 800
                }), !1) : 0 == t ? (wx.showModal({
                    content: "请完善您的个人资料后再预约",
                    success: function(a) {
                        a.confirm && wx.reLaunch({
                            url: "../gerenxinxi/gerenxinxi"
                        });
                    }
                }), !1) : void wx.showModal({
                    content: "确认预约吗？",
                    success: function(a) {
                        var t = e.currentTarget.dataset.data, n = wx.getStorageSync("openid");
                        a.confirm && app.util.request({
                            url: "entry/wxapp/Orderpay",
                            method: "GET",
                            data: {
                                s_openid: n,
                                s_ormoney: t
                            },
                            success: function(a) {
                                wx.requestPayment({
                                    timeStamp: a.data.timeStamp,
                                    nonceStr: a.data.nonceStr,
                                    package: a.data.package,
                                    signType: a.data.signType,
                                    paySign: a.data.paySign,
                                    success: function(a) {
                                        console.log(a), app.util.request({
                                            url: "entry/wxapp/Myzhuanjiayy",
                                            data: {
                                                zy_money: t,
                                                zy_name: i,
                                                z_name: o,
                                                zy_openid: n,
                                                uniacid: s,
                                                zy_type: c,
                                                zy_riqi: u,
                                                zy_yibao: r,
                                                ksname: p
                                            },
                                            success: function(a) {
                                                console.log(a), wx.showToast({
                                                    title: "预约成功",
                                                    icon: "success",
                                                    duration: 800
                                                }), app.util.request({
                                                    url: "entry/wxapp/PaysendSms",
                                                    data: {
                                                        my_id: i,
                                                        zid: o
                                                    },
                                                    success: function(a) {
                                                        console.log(a);
                                                    },
                                                    fail: function(a) {
                                                        console.log(a);
                                                    }
                                                });
                                            },
                                            fail: function(a) {
                                                console.log(a);
                                            }
                                        });
                                    },
                                    fail: function(a) {
                                        console.log(a);
                                    }
                                });
                            }
                        });
                    }
                });
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