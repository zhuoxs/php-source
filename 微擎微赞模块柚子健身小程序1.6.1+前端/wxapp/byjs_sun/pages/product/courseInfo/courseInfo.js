var app = getApp();

Page({
    data: {
        index: 0,
        name: "",
        nameindex: 0,
        date: "",
        course_id: "",
        userName: "",
        mobile: "",
        is_open: ""
    },
    onLoad: function(e) {
        var a = this, t = e.id, o = e.cid;
        a.setData({
            coach_id: o
        });
        var n = e.money, s = e.price, i = e.img;
        0 == n ? a.setData({
            money: s,
            img: i
        }) : a.setData({
            money: n,
            img: i
        }), app.util.request({
            url: "entry/wxapp/GetMbmessage",
            cachetime: 0,
            success: function(e) {
                a.setData({
                    is_open: e.data.is_open,
                    mb1: e.data.mb1
                });
            }
        }), app.util.request({
            url: "entry/wxapp/CourseInfo",
            data: {
                id: t,
                cid: o
            },
            cachetime: 0,
            success: function(e) {
                console.log(e), a.setData({
                    name: e.data.coach.coach_name,
                    type: e.data.course_type,
                    date: e.data.course_time,
                    course_id: e.data.id
                });
            }
        });
    },
    bindnameChange: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value), this.setData({
            nameindex: e.detail.value
        });
    },
    bindPickerChange: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value), this.setData({
            index: e.detail.value
        });
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
    onReachBottom: function() {},
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
    formSubmit: function(s) {
        var i = this, e = this.data.userName, a = this.data.mobile;
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
        if (!/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1}))+\d{8})$/.test(a)) return wx.showToast({
            title: "手机号有误！",
            icon: "success",
            duration: 1500
        }), !1;
        wx.getStorageSync("users").id;
        console.log(s.detail.target.dataset.course_id), wx.getStorage({
            key: "openid",
            success: function(e) {
                var a = e.data, t = i.data.money;
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
                                money: i.data.money,
                                user_name: i.data.userName,
                                tel: i.data.mobile,
                                good_name: "课程预约",
                                good_money: i.data.money,
                                good_img: i.data.img
                            },
                            success: function(e) {
                                console.log(e.data);
                                var o = e.data;
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
                                                order_id: o
                                            },
                                            success: function(e) {
                                                app.util.request({
                                                    url: "entry/wxapp/Appointment",
                                                    data: {
                                                        course_id: s.detail.target.dataset.course_id,
                                                        coach_id: i.data.coach_id,
                                                        name: s.detail.value.name,
                                                        phone: s.detail.value.phone,
                                                        user_id: n
                                                    },
                                                    success: function(e) {
                                                        wx.navigateTo({
                                                            url: "/byjs_sun/pages/course/course"
                                                        });
                                                    }
                                                });
                                            }
                                        }), 2 == i.data.is_open) {
                                            var a = s.detail.formId, t = {
                                                access_token: wx.getStorageSync("access_token"),
                                                touser: wx.getStorageSync("users").openid,
                                                template_id: i.data.mb1,
                                                page: "byjs_sun/pages/myUser/myBespoke/myBespoke",
                                                form_id: a,
                                                value1: i.data.type,
                                                color1: "#4a4a4a",
                                                value2: i.data.name,
                                                color2: "#9b9b9b",
                                                value3: i.data.date,
                                                color3: "#9b9b9b"
                                            };
                                            app.util.request({
                                                url: "entry/wxapp/Send",
                                                data: t,
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
    }
});