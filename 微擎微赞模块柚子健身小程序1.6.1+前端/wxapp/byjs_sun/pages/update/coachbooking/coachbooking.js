var app = getApp();

Page({
    data: {
        userName: "",
        mobile: "",
        date: "",
        items: []
    },
    onLoad: function(e) {
        console.log(e);
        var a = this;
        a.setData({
            id: e.id,
            money: e.money,
            coach: e.coach,
            logo: e.logo
        }), app.util.request({
            url: "entry/wxapp/GetMbmessage",
            cachetime: 0,
            success: function(e) {
                a.setData({
                    is_open: e.data.is_open,
                    mb2: e.data.mb2
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(e) {
                wx.setStorageSync("url", e.data), a.setData({
                    url: e.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetCoachCourse",
            data: {
                id: e.id
            },
            cachetime: "0",
            success: function(e) {
                a.setData({
                    items: e.data
                });
            }
        });
    },
    formSubmit: function(i) {
        var c = this, e = c.data.userName, a = c.data.mobile, t = c.data.date, u = c.data.id;
        if ("" == e) return wx.showToast({
            title: "请输入用户名",
            icon: "succes",
            duration: 1e3,
            mask: !0
        }), !1;
        if ("" == a) return wx.showToast({
            title: "手机号不能为空"
        }), !1;
        if (11 != a.length) return wx.showToast({
            title: "手机号长度有误！",
            icon: "success",
            duration: 1500
        }), !1;
        if ("" == t) return wx.showToast({
            title: "请选择时间",
            icon: "success",
            duration: 1500
        }), !1;
        if (!/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1}))+\d{8})$/.test(a)) return wx.showToast({
            title: "手机号有误！",
            icon: "success",
            duration: 1500
        }), !1;
        console.log("form发生了submit事件，携带数据为：", i.detail.value), wx.getStorage({
            key: "openid",
            success: function(e) {
                var a = e.data, t = c.data.money;
                app.util.request({
                    url: "entry/wxapp/Orderarr",
                    cachetime: "30",
                    data: {
                        price: t,
                        openid: a
                    },
                    success: function(a) {
                        var n = wx.getStorageSync("users").id;
                        console.log("-----直接购买=------"), app.util.request({
                            url: "entry/wxapp/Order",
                            cachetime: "0",
                            data: {
                                user_id: n,
                                money: c.data.money,
                                user_name: c.data.userName,
                                tel: c.data.mobile,
                                good_name: "教练课程预约",
                                good_money: c.data.money,
                                good_img: c.data.logo,
                                coach: c.data.coach
                            },
                            success: function(e) {
                                console.log(e.data);
                                var s = e.data;
                                console.log(a), wx.requestPayment({
                                    timeStamp: a.data.timeStamp,
                                    nonceStr: a.data.nonceStr,
                                    package: a.data.package,
                                    signType: "MD5",
                                    paySign: a.data.paySign,
                                    success: function(e) {
                                        if (wx.showToast({
                                            title: "支付成功",
                                            icon: "success",
                                            duration: 2e3
                                        }), app.util.request({
                                            url: "entry/wxapp/PayOrder",
                                            cachetime: "0",
                                            data: {
                                                order_id: s
                                            },
                                            success: function(e) {
                                                app.util.request({
                                                    url: "entry/wxapp/AppointmentCoach",
                                                    data: {
                                                        coach_id: u,
                                                        name: i.detail.value.name,
                                                        phone: i.detail.value.tel,
                                                        user_id: n
                                                    },
                                                    success: function(e) {
                                                        wx.navigateTo({
                                                            url: "../../product/reservationYes/reservationYes"
                                                        });
                                                    }
                                                });
                                            }
                                        }), 2 == c.data.is_open) {
                                            var a = i.detail.formId, t = wx.getStorageSync("access_token"), o = (new Date().getTime(), 
                                            {
                                                access_token: t,
                                                touser: wx.getStorageSync("users").openid,
                                                template_id: c.data.mb2,
                                                page: "byjs_sun/pages/myUser/myBespoke/myBespoke",
                                                form_id: a,
                                                value1: "教练课程预约",
                                                color1: "#4a4a4a",
                                                value2: "您已预约教练成功，点击查看！",
                                                color2: "#9b9b9b",
                                                value3: c.data.date,
                                                color3: "#9b9b9b"
                                            });
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
                                        wx.navigateTo({
                                            url: "../reservationYes/reservationYes"
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
        });
    },
    userNameInput: function(e) {
        this.setData({
            userName: e.detail.value
        });
    },
    mobileInput: function(e) {
        this.setData({
            mobile: e.detail.value
        });
    },
    radioChange: function(e) {
        console.log("radio发生change事件，携带value值为：", e.detail.value);
    },
    bindDateChange: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value), this.setData({
            date: e.detail.value
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});