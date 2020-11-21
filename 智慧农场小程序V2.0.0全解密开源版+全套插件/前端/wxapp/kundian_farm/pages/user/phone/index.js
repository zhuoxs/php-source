var e = new getApp(), t = e.siteInfo.uniacid;

Page({
    data: {
        isUpdate: !1,
        curindex: 1,
        phone: "",
        currentTime: 61,
        time: "获取验证码",
        hand_phone: "",
        msgCode: "",
        userInfo: [],
        farmSetData: [],
        code: ""
    },
    onLoad: function(n) {
        var a = wx.getStorageSync("kundian_farm_uid"), o = wx.getStorageSync("kundian_farm_setData"), i = this;
        e.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "index",
                op: "getUserBindPhone",
                uid: a,
                uniacid: t
            },
            success: function(e) {
                i.setData({
                    userInfo: e.data.userInfo,
                    farmSetData: o,
                    setData: e.data.setData || []
                });
            }
        }), wx.login({
            success: function(e) {
                i.setData({
                    code: e.code
                });
            }
        });
    },
    changeCurrent: function(e) {
        var t = e.currentTarget.dataset.curindex;
        this.setData({
            curindex: t
        });
    },
    getPhoneNumber: function(n) {
        if ("getPhoneNumber:fail user deny" != n.detail.errMsg) {
            var a = this, o = wx.getStorageSync("kundian_farm_uid"), i = a.data, s = i.code, c = i.userInfo;
            s ? e.util.request({
                url: "entry/wxapp/class",
                data: {
                    encryptedData: n.detail.encryptedData,
                    iv: n.detail.iv,
                    code: s,
                    op: "savePhone",
                    uniacid: t,
                    uid: o,
                    control: "index"
                },
                method: "POST",
                header: {
                    "content-type": "application/json"
                },
                success: function(e) {
                    var t = e.data, n = t.msg, o = t.phone;
                    t.code;
                    wx.showToast({
                        title: n,
                        icon: "none"
                    }), c.phone = o, a.setData({
                        phone: o,
                        isUpdate: !1,
                        code: "",
                        userInfo: c
                    });
                },
                fail: function(e) {
                    console.log(e);
                }
            }) : wx.login({
                success: function(i) {
                    wx.login({
                        success: function(i) {
                            console.log(i.code), e.util.request({
                                url: "entry/wxapp/class",
                                data: {
                                    encryptedData: n.detail.encryptedData,
                                    iv: n.detail.iv,
                                    code: i.code,
                                    op: "savePhone",
                                    uniacid: t,
                                    uid: o,
                                    control: "index"
                                },
                                method: "POST",
                                header: {
                                    "content-type": "application/json"
                                },
                                success: function(e) {
                                    var t = e.data, n = t.msg, o = t.phone;
                                    t.code;
                                    wx.showToast({
                                        title: n,
                                        icon: "none"
                                    }), c.phone = o, a.setData({
                                        phone: o,
                                        isUpdate: !1,
                                        userInfo: c
                                    });
                                },
                                fail: function(e) {
                                    console.log(e);
                                }
                            });
                        }
                    });
                }
            });
        } else wx.showModal({
            title: "提示",
            content: "您拒绝了授权！",
            showCancel: !1
        });
    },
    getCode: function(e) {
        var t = this, n = t.data.currentTime, a = setInterval(function() {
            n--, t.setData({
                time: n + "秒"
            }), n <= 0 && (clearInterval(a), t.setData({
                time: "重新发送",
                currentTime: 61,
                disabled: !1
            }));
        }, 1e3);
    },
    getPhone: function(e) {
        this.setData({
            hand_phone: e.detail.value
        });
    },
    getVerificationCode: function() {
        var n = this, a = this.data.hand_phone;
        "" != a ? 11 == a.length ? (/^(((13[0-9]{1})|(15[0-9]{1})|(19[0-9]{1})|(18[0-9]{1})|(17[0-9]{1}))+\d{8})$/.test(a) || wx.showToast({
            title: "手机号有误！",
            icon: "none"
        }), e.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "index",
                op: "getPhoneCode",
                phone: a,
                uniacid: t
            },
            success: function(e) {
                var t = e.data, a = t.code, o = t.result;
                0 == o.err_code ? n.setData({
                    msgCode: a
                }) : wx.showModal({
                    title: "提示",
                    content: o.msg,
                    showCancel: !1
                });
            }
        }), this.getCode(), this.setData({
            disabled: !0
        })) : wx.showToast({
            title: "电话号码长度有误！",
            icon: "none"
        }) : wx.showToast({
            title: "请输入手机号",
            icon: "none"
        });
    },
    savePhone: function(n) {
        var a = this, o = a.data, i = o.msgCode, s = o.hand_phone, c = o.userInfo, d = n.detail.value.code, r = n.detail.formId, u = wx.getStorageSync("kundian_farm_uid");
        "" != i && void 0 != i ? "" != d && void 0 != d ? i == d ? e.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "index",
                op: "saveHandPhone",
                phone: s,
                form_id: r,
                uniacid: t,
                uid: u
            },
            success: function(e) {
                wx.showModal({
                    title: "提示",
                    content: e.data.msg,
                    showCancel: !1
                }), c.phone = s, a.setData({
                    isUpdate: !1,
                    phone: s,
                    userInfo: c
                });
            }
        }) : wx.showModal({
            title: "提示",
            content: "验证码输入错误！",
            showCancel: !1
        }) : wx.showModal({
            title: "提示",
            content: "请输入验证码",
            showCancel: !1
        }) : wx.showModal({
            title: "提示",
            content: "请先获取验证码",
            showCancel: !1
        });
    },
    bindPhone: function(e) {
        this.setData({
            isUpdate: !0
        });
    },
    completeBind: function(e) {
        wx.navigateBack({
            delta: 1
        });
    }
});