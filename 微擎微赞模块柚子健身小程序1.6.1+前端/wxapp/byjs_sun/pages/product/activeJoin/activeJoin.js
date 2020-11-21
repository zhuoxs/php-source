var app = getApp();

Page({
    data: {
        money: 99,
        sex: [ "男", "女" ],
        sexIndex: 0
    },
    onLoad: function(e) {
        var t = this, a = e.aid, n = e.price, o = e.is_open;
        if (0 == e.price) var s = "免费报名！"; else s = "￥" + e.price;
        t.setData({
            aid: a,
            price: s,
            money: n,
            is_open1: o
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
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    bindPickerChange: function(e) {
        this.setData({
            sexIndex: e.detail.value
        });
    },
    formSubmit: function(s) {
        var c = this, e = !0, t = "", n = s.detail.value.uname, o = s.detail.value.tel, i = s.detail.value.IDcard, u = s.detail.value.text;
        c.data.sex[c.data.sexIndex];
        if ("" == n ? t = "请输入姓名" : /^1(3|4|5|7|8|9)\d{9}$/.test(o) ? 1 != c.data.is_open1 || /^\d{6}(18|19|20)?\d{2}(0[1-9]|1[012])(0[1-9]|[12]\d|3[01])\d{3}(\d|[xX])$/.test(i) ? e = !1 : (t = "请输入身份证号", 
        console.log(i)) : t = "请输入联系方式", e) wx.showToast({
            title: t,
            icon: "none"
        }); else {
            var a = c.data.money, r = wx.getStorageSync("users").id;
            0 == a ? app.util.request({
                url: "entry/wxapp/activityOrder",
                data: {
                    aid: c.data.aid,
                    name: n,
                    phone: o,
                    uid: r,
                    gender: c.data.sexIndex,
                    money: 0,
                    IDcard: i,
                    text: u
                },
                success: function(e) {
                    if (wx.showToast({
                        title: "报名成功！！",
                        icon: "success",
                        duration: 2e3
                    }), 2 == c.data.is_open) {
                        var t = s.detail.formId, a = wx.getStorageSync("access_token"), n = (new Date().getTime(), 
                        wx.getStorageSync("active")), o = {
                            access_token: a,
                            touser: wx.getStorageSync("users").openid,
                            template_id: c.data.mb2,
                            page: "byjs_sun/pages/product/activeDet/activeDet",
                            form_id: t,
                            value1: n.typename,
                            color1: "#4a4a4a",
                            value2: n.name,
                            color2: "#9b9b9b",
                            value3: n.starttime,
                            color3: "#9b9b9b"
                        };
                        app.util.request({
                            url: "entry/wxapp/Send",
                            data: o,
                            method: "POST",
                            success: function(e) {
                                console.log("push msg"), console.log(e);
                            },
                            fail: function(e) {
                                console.log("push err"), console.log(e);
                            }
                        });
                    }
                    setTimeout(function() {
                        wx.reLaunch({
                            url: "/byjs_sun/pages/mineAct/mineAct?currIdx=1"
                        });
                    }, 2e3);
                }
            }) : wx.getStorage({
                key: "openid",
                success: function(e) {
                    var t = e.data, a = c.data.money;
                    app.util.request({
                        url: "entry/wxapp/Orderarr",
                        cachetime: "30",
                        data: {
                            price: a,
                            openid: t
                        },
                        success: function(e) {
                            console.log("-----直接购买=------"), wx.requestPayment({
                                timeStamp: e.data.timeStamp,
                                nonceStr: e.data.nonceStr,
                                package: e.data.package,
                                signType: "MD5",
                                paySign: e.data.paySign,
                                success: function(e) {
                                    wx.showToast({
                                        title: "支付成功",
                                        icon: "success",
                                        duration: 2e3
                                    }), app.util.request({
                                        url: "entry/wxapp/activityOrder",
                                        data: {
                                            aid: c.data.aid,
                                            name: n,
                                            phone: o,
                                            uid: r,
                                            gender: c.data.sexIndex,
                                            money: a,
                                            IDcard: i,
                                            text: u
                                        },
                                        success: function(e) {
                                            if (wx.showToast({
                                                title: "报名成功！！",
                                                icon: "success",
                                                duration: 2e3
                                            }), 2 == c.data.is_open) {
                                                var t = s.detail.formId, a = wx.getStorageSync("access_token"), n = (new Date().getTime(), 
                                                wx.getStorageSync("active")), o = {
                                                    access_token: a,
                                                    touser: wx.getStorageSync("users").openid,
                                                    template_id: c.data.mb2,
                                                    page: "byjs_sun/pages/product/activeDet/activeDet",
                                                    form_id: t,
                                                    value1: n.typename,
                                                    color1: "#4a4a4a",
                                                    value2: n.name,
                                                    color2: "#9b9b9b",
                                                    value3: n.starttime,
                                                    color3: "#9b9b9b"
                                                };
                                                app.util.request({
                                                    url: "entry/wxapp/Send",
                                                    data: o,
                                                    method: "POST",
                                                    success: function(e) {
                                                        console.log("push msg"), console.log(e);
                                                    },
                                                    fail: function(e) {
                                                        console.log("push err"), console.log(e);
                                                    }
                                                });
                                            }
                                            setTimeout(function() {
                                                wx.reLaunch({
                                                    url: "/byjs_sun/pages/mineAct/mineAct?currIdx=1"
                                                });
                                            }, 2e3);
                                        }
                                    });
                                },
                                fail: function(e) {
                                    console.log(e + "ssssss");
                                }
                            });
                        }
                    });
                }
            });
        }
    }
});