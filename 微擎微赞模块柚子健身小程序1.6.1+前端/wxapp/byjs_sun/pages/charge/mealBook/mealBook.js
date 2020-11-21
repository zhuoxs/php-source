var app = getApp(), util = require("../../../resource/utils/util.js");

Page({
    data: {
        hasAddress: !1,
        num: 1
    },
    onLoad: function(e) {
        var t = this, a = e.oid, s = Date.parse(new Date());
        s /= 1e3;
        var n = util.formatTimeTwo(s, "h"), o = util.formatTimeTwo(s, "Y/M/D h:m:s");
        app.util.request({
            url: "entry/wxapp/GetMealOrder",
            data: {
                oid: a
            },
            success: function(e) {
                console.log(e.data), t.setData({
                    res: e.data.res,
                    time: e.data.time,
                    nowtime: n,
                    sendtime: o
                }), n < t.data.time.lunch || n >= t.data.time.dinner ? t.setData({
                    type: 1
                }) : n >= t.data.time.lunch && n < t.data.time.dinner && t.setData({
                    type: 2
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetMbmessage",
            cachetime: 0,
            success: function(e) {
                t.setData({
                    is_open: e.data.is_open,
                    mb2: e.data.mb2
                });
            }
        });
    },
    jian: function() {
        var e = this, t = e.data.num - 1;
        0 == t ? e.setData({
            num: 1
        }) : e.setData({
            num: t
        });
    },
    jia: function() {
        var e = this, t = e.data.num + 1;
        t > e.data.res.count ? e.setData({
            num: t - 1
        }) : e.setData({
            num: t
        });
    },
    bindinput: function(e) {
        var t = e.detail.value;
        this.setData({
            note: t
        });
    },
    buy: function(s) {
        var n = this, t = s.currentTarget.dataset.oid;
        s.detail.formId;
        if (n.data.address) var a = n.data.address.provinceName + n.data.address.cityName + n.data.address.countyName + n.data.address.detailInfo, o = n.data.address.telNumber, d = n.data.address.userName;
        var i = n.data.note;
        wx.showModal({
            content: "确认提交？",
            cancelColor: "#000",
            confirmColor: "#3daddd",
            success: function(e) {
                console.log(n.data.address), e.confirm && (null == n.data.address ? wx.showToast({
                    title: "地址不得为空！",
                    icon: "none",
                    duration: 2e3
                }) : app.util.request({
                    url: "entry/wxapp/MealAppointment",
                    data: {
                        oid: t,
                        type: n.data.type,
                        addr: a,
                        phone: o,
                        name: d,
                        note: i,
                        num: n.data.num
                    },
                    success: function(e) {
                        if (1 == e.data) {
                            if (2 == n.data.is_open) {
                                var t = s.detail.formId, a = {
                                    access_token: wx.getStorageSync("access_token"),
                                    touser: wx.getStorageSync("users").openid,
                                    template_id: n.data.mb2,
                                    page: "byjs_sun/pages/myUser/myBespoke/myBespoke?navIndex=2",
                                    form_id: t,
                                    value1: "预约健身餐",
                                    color1: "#4a4a4a",
                                    value2: "您已预约健身餐成功！",
                                    color2: "#9b9b9b",
                                    value3: n.data.sendtime,
                                    color3: "#9b9b9b"
                                };
                                app.util.request({
                                    url: "entry/wxapp/Send",
                                    data: a,
                                    method: "POST",
                                    success: function(e) {
                                        console.log("push msg"), console.log(e);
                                    },
                                    fail: function(e) {
                                        console.log("push err"), console.log(e);
                                    }
                                });
                            } else wx.showToast({
                                title: "预约成功",
                                icon: "success",
                                duration: 2e3
                            });
                            wx.reLaunch({
                                url: "/byjs_sun/pages/myUser/myBespoke/myBespoke?navIndex=2"
                            });
                        } else wx.showToast({
                            title: "预约失败",
                            icon: "none",
                            duration: 2e3
                        });
                    }
                }));
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    toAddress: function() {
        var t = this;
        wx.chooseAddress({
            success: function(e) {
                console.log("获取地址成功"), t.setData({
                    address: e,
                    hasAddress: !0
                });
            },
            fail: function(e) {
                console.log("获取地址失败"), wx.getSetting({
                    success: function(e) {
                        e.authSetting["scope.address"] || (console.log("进入信息授权开关页面"), wx.openSetting({
                            success: function(e) {
                                console.log("openSetting success", e.authSetting);
                            }
                        }));
                    }
                });
            }
        });
    }
});