var app = getApp();

Page({
    data: {
        gwc: "",
        allprice: "",
        xiansz: !1,
        chuydate: "请选择日期",
        chuytime: "请选择时间",
        address: "",
        xinxi: {
            username: "",
            usertel: "",
            address: "",
            userdate: "",
            usertime: "",
            userbeiz: ""
        },
        usname: 0,
        ustel: 0,
        usadd: 0,
        usdate: 0,
        ustime: 0,
        dikou_jf: 0,
        dikou_jf_val: 0,
        dikou_score: 0,
        dikou_score_val: 0,
        zz_pay_money: 0,
        zz_my_paymoney: 0,
        zz_my_paymoney2: 0,
        zbiao: 0,
        index: -1
    },
    onPullDownRefresh: function() {
        this.getinfos(), wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var t = this;
        wx.getStorage({
            key: "arrkey",
            success: function(a) {
                t.setData({
                    index: a.data
                });
            }
        }), wx.getStorage({
            key: "gwcdata",
            success: function(a) {
                t.setData({
                    gwc: a.data
                });
            }
        }), wx.getStorage({
            key: "gwcprice",
            success: function(a) {
                t.setData({
                    allprice: a.data
                });
            }
        }), wx.getStorage({
            key: "mp_address",
            success: function(a) {
                t.setData({
                    address: a.data
                });
            }
        });
        var e = 0;
        a.fxsid && (e = a.fxsid, t.setData({
            fxsid: a.fxsid
        })), t.getIndex(), app.util.getUserInfo(t.getinfos, e);
    },
    redirectto: function(a) {
        var t = a.currentTarget.dataset.link, e = a.currentTarget.dataset.linktype;
        app.util.redirectto(t, e);
    },
    getinfos: function() {
        var t = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                t.setData({
                    openid: a.data
                }), t.zhchange(), t.getSjbase();
            }
        });
    },
    zhchange: function() {
        var e = this, n = e.data.index;
        app.util.request({
            url: "entry/wxapp/zhchange",
            success: function(a) {
                -1 == n && (n = 0);
                var t = a.data.data.zhs[n];
                e.setData({
                    zho: a.data.data,
                    zhs: a.data.data.zhs,
                    zbiao: t
                });
            },
            fail: function(a) {}
        });
    },
    bindPickerChange: function(a) {
        var t = a.detail.value;
        if (0 == t) this.setData({
            index: a.detail.value,
            zbiao: "打包/拼桌"
        }); else {
            var e = this.data.zhs;
            this.setData({
                index: a.detail.value,
                zbiao: e[t]
            });
        }
    },
    getIndex: function() {
        var n = this, a = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: a,
            data: {
                vs1: 1
            },
            success: function(a) {
                if (a.data.data.video) var t = "show";
                if (a.data.data.c_b_bg) var e = "bg";
                n.setData({
                    baseinfo: a.data.data,
                    show_v: t,
                    c_b_bg1: e
                }), wx.setNavigationBarTitle({
                    title: n.data.baseinfo.name
                }), wx.setNavigationBarColor({
                    frontColor: n.data.baseinfo.base_tcolor,
                    backgroundColor: n.data.baseinfo.base_color
                });
            },
            fail: function(a) {}
        });
    },
    getSjbase: function() {
        var f = this, a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Shangjbs",
            data: {
                openid: a
            },
            success: function(a) {
                var t = a.data.data.dk_money, e = a.data.data.dk_score, n = f.data.allprice, s = a.data.data.jf_gz, i = a.data.data.user_money, o = 0, d = 0, r = 0, u = 0;
                if (t <= n) {
                    d = e;
                    var c = n - (o = t);
                    i < c ? (r = c - i, u = i) : (u = c, r = 0);
                } else {
                    d = 1e3 * (o = n) / (1e3 * s.money) * (1e3 * s.scroe) / 1e3, u = r = 0;
                }
                0 < r && f.setData({
                    money_yhpay: 0
                });
                var l = n - o;
                f.setData({
                    shangjbs: a.data.data,
                    usname: a.data.data.usname,
                    ustel: a.data.data.ustel,
                    usadd: a.data.data.usadd,
                    usdate: a.data.data.usdate,
                    ustime: a.data.data.ustime,
                    dikou_jf: o,
                    dikou_jf_val: o,
                    dikou_score: d,
                    dikou_score_val: d,
                    zz_pay_money: r,
                    zz_my_paymoney: u,
                    zz_my_paymoney2: l
                });
            },
            fail: function(a) {}
        });
    },
    pay: function(a) {
        var e = this, t = wx.getStorageSync("openid"), n = e.data.allprice, s = e.data.gwc, i = e.data.address, o = e.data.xinxi, d = e.data.zbiao, r = a.detail.formId;
        if (e.setData({
            formId: r
        }), null == d) return wx.showModal({
            content: "请先选择桌号"
        }), !1;
        e.data.dikou_jf;
        var u = e.data.dikou_score, c = e.data.zz_my_paymoney, l = e.data.zz_pay_money;
        e.setData({
            money_yhpay: l
        });
        var f = e.data.usname, p = e.data.ustel, w = e.data.usadd, x = e.data.usdate, h = e.data.ustime;
        if (0 < l) {
            if (0 == d) {
                return wx.showModal({
                    title: "提醒",
                    content: "您选择的是“打包/拼桌”，请确认",
                    success: function(a) {
                        if (a.confirm) {
                            if (2 == f && "" == o.username) return !1, wx.showModal({
                                title: "提醒",
                                content: "姓名为必填！",
                                showCancel: !1
                            }), !1;
                            if (2 == p && "" == o.usertel) return !1, wx.showModal({
                                title: "提醒",
                                content: "手机号为必填！",
                                showCancel: !1
                            }), !1;
                            if (!/^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/.test(o.usertel) && 2 == p) return wx.showModal({
                                title: "提醒",
                                content: "请输入有效的手机号码！",
                                showCancel: !1
                            }), !1;
                            if (2 == w && "" == o.address) return !1, wx.showModal({
                                title: "提醒",
                                content: "地址为必填！",
                                showCancel: !1
                            }), !1;
                            if (2 == x && "" == o.userdate) return !1, wx.showModal({
                                title: "提醒",
                                content: "日期为必填！",
                                showCancel: !1
                            }), !1;
                            if (2 == h && "" == o.usertime) return !1, wx.showModal({
                                title: "提醒",
                                content: "时间为必填！",
                                showCancel: !1
                            }), !1;
                            e.setData({
                                xiansz: !0
                            }), app.util.request({
                                url: "entry/wxapp/Orderpaymoney",
                                data: {
                                    openid: t,
                                    price: l,
                                    xinxi: JSON.stringify(o)
                                },
                                success: function(a) {
                                    if ("success" == a.data.message) {
                                        var t = a.data.data.order_id;
                                        e.setData({
                                            prepay_id: a.data.data.package
                                        }), wx.requestPayment({
                                            timeStamp: a.data.data.timeStamp,
                                            nonceStr: a.data.data.nonceStr,
                                            package: a.data.data.package,
                                            signType: "MD5",
                                            paySign: a.data.data.paySign,
                                            success: function(a) {
                                                e.changflag(t), wx.showToast({
                                                    title: "支付成功",
                                                    icon: "success",
                                                    duration: 3e3,
                                                    success: function(a) {
                                                        wx.redirectTo({
                                                            url: "/sudu8_page_plugin_food/food_my/food_my"
                                                        });
                                                    }
                                                });
                                            },
                                            fail: function(a) {
                                                e.setData({
                                                    xiansz: !1
                                                });
                                            },
                                            complete: function(a) {
                                                e.setData({
                                                    xiansz: !1
                                                });
                                            }
                                        });
                                    }
                                    "error" == a.data.message && wx.showModal({
                                        title: "提醒",
                                        content: a.data.data.message,
                                        showCancel: !1
                                    });
                                }
                            });
                        } else if (a.cancel) ;
                    }
                }), !1;
            }
            if (2 == f && "" == o.username) return !1, wx.showModal({
                title: "提醒",
                content: "姓名为必填！",
                showCancel: !1
            }), !1;
            var y = /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
            if (2 == p && "" == o.usertel) return !1, wx.showModal({
                title: "提醒",
                content: "手机号为必填！",
                showCancel: !1
            }), !1;
            if (!y.test(o.usertel) && 2 == p) return wx.showModal({
                title: "提醒",
                content: "请输入有效的手机号码！",
                showCancel: !1
            }), !1;
            if (2 == w && "" == o.address) return !1, wx.showModal({
                title: "提醒",
                content: "地址为必填！",
                showCancel: !1
            }), !1;
            if (2 == x && "" == o.userdate) return !1, wx.showModal({
                title: "提醒",
                content: "日期为必填！",
                showCancel: !1
            }), !1;
            if (2 == h && "" == o.usertime) return !1, wx.showModal({
                title: "提醒",
                content: "时间为必填！",
                showCancel: !1
            }), !1;
            e.setData({
                xiansz: !0
            }), app.util.request({
                url: "entry/wxapp/Orderpaymoney",
                data: {
                    openid: t,
                    price: l,
                    xinxi: JSON.stringify(o)
                },
                header: {
                    "content-type": "application/x-www-form-urlencoded"
                },
                success: function(a) {
                    if ("success" == a.data.message) {
                        var t = a.data.data.order_id;
                        wx.requestPayment({
                            timeStamp: a.data.data.timeStamp,
                            nonceStr: a.data.data.nonceStr,
                            package: a.data.data.package,
                            signType: "MD5",
                            paySign: a.data.data.paySign,
                            success: function(a) {
                                e.changflag(t), wx.showToast({
                                    title: "支付成功",
                                    icon: "success",
                                    duration: 3e3,
                                    success: function(a) {
                                        wx.redirectTo({
                                            url: "/sudu8_page_plugin_food/food_my/food_my"
                                        });
                                    }
                                });
                            },
                            fail: function(a) {
                                e.setData({
                                    xiansz: !1
                                });
                            },
                            complete: function(a) {
                                e.setData({
                                    xiansz: !1
                                });
                            }
                        });
                    }
                    "error" == a.data.message && wx.showModal({
                        title: "提醒",
                        content: a.data.data.message,
                        showCancel: !1
                    });
                }
            });
        } else {
            if (0 == d) {
                if (2 == f && "" == o.username) return !1, wx.showModal({
                    title: "提醒",
                    content: "姓名为必填！",
                    showCancel: !1
                }), !1;
                y = /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
                return 2 == p && "" == o.usertel ? (!1, wx.showModal({
                    title: "提醒",
                    content: "手机号为必填！",
                    showCancel: !1
                })) : y.test(o.usertel) || 2 != p ? 2 == w && "" == o.address ? (!1, wx.showModal({
                    title: "提醒",
                    content: "地址为必填！",
                    showCancel: !1
                })) : 2 == x && "" == o.userdate ? (!1, wx.showModal({
                    title: "提醒",
                    content: "日期为必填！",
                    showCancel: !1
                })) : 2 == h && "" == o.usertime ? (!1, wx.showModal({
                    title: "提醒",
                    content: "时间为必填！",
                    showCancel: !1
                })) : wx.showModal({
                    title: "提醒",
                    content: "您选择的是“打包/拼桌”，请确认",
                    success: function(a) {
                        a.confirm && app.util.request({
                            url: "entry/wxapp/Zjkk",
                            data: {
                                openid: t,
                                price: n,
                                money_mypay: c,
                                jifen_score: u,
                                gwc: JSON.stringify(s),
                                address: i,
                                xinxi: JSON.stringify(o),
                                zh: d,
                                formId: r
                            },
                            header: {
                                "content-type": "application/json"
                            },
                            success: function(a) {
                                wx.redirectTo({
                                    url: "/sudu8_page_plugin_food/food_my/food_my"
                                });
                            }
                        });
                    }
                }) : wx.showModal({
                    title: "提醒",
                    content: "请输入有效的手机号码！",
                    showCancel: !1
                }), !1;
            }
            if (2 == f && "" == o.username) return !1, wx.showModal({
                title: "提醒",
                content: "姓名为必填！",
                showCancel: !1
            }), !1;
            y = /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
            if (2 == p && "" == o.usertel) return !1, wx.showModal({
                title: "提醒",
                content: "手机号为必填！",
                showCancel: !1
            }), !1;
            if (!y.test(o.usertel) && 2 == p) return wx.showModal({
                title: "提醒",
                content: "请输入有效的手机号码！",
                showCancel: !1
            }), !1;
            if (2 == w && "" == o.address) return !1, wx.showModal({
                title: "提醒",
                content: "地址为必填！",
                showCancel: !1
            }), !1;
            if (2 == x && "" == o.userdate) return !1, wx.showModal({
                title: "提醒",
                content: "日期为必填！",
                showCancel: !1
            }), !1;
            if (2 == h && "" == o.usertime) return !1, wx.showModal({
                title: "提醒",
                content: "时间为必填！",
                showCancel: !1
            }), !1;
            wx.showModal({
                title: "提醒",
                content: "是否使用余额支付",
                success: function(a) {
                    a.confirm && app.util.request({
                        url: "entry/wxapp/Zjkk",
                        data: {
                            openid: t,
                            price: n,
                            money_mypay: c,
                            jifen_score: u,
                            gwc: JSON.stringify(s),
                            address: i,
                            xinxi: JSON.stringify(o),
                            zh: d,
                            formId: r
                        },
                        header: {
                            "content-type": "application/json"
                        },
                        success: function(a) {
                            wx.redirectTo({
                                url: "/sudu8_page_plugin_food/food_my/food_my"
                            });
                        }
                    });
                }
            });
        }
    },
    changflag: function(t) {
        var e = this, a = wx.getStorageSync("openid"), n = e.data.allprice, s = e.data.gwc, i = e.data.address, o = e.data.xinxi, d = e.data.zbiao;
        e.data.dikou_jf, e.data.dikou_score, e.data.zz_my_paymoney, e.data.zz_pay_money;
        app.util.request({
            url: "entry/wxapp/Zhifdingd",
            data: {
                openid: a,
                price: n,
                gwc: JSON.stringify(s),
                order_id: t,
                address: i,
                xinxi: JSON.stringify(o),
                zh: d,
                formId: e.data.formId
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                e.sendMail_order(t), e.printer(t, s, o, n, i, d);
            }
        });
    },
    printer: function(a, t, e, n, s, i) {
        app.util.request({
            url: "entry/wxapp/Printer",
            data: {
                order_id: a,
                gwc: JSON.stringify(t),
                xinxi: JSON.stringify(e),
                price: n,
                address: s,
                zh: i,
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {},
            fail: function(a) {}
        });
    },
    sendMail_order: function(a) {
        var t = app.util.url("entry/wxapp/sendMail_foodorder", {
            m: "sudu8_page"
        });
        wx.request({
            url: t,
            data: {
                order_id: a
            },
            success: function(a) {},
            fail: function(a) {}
        });
    },
    userNameInput: function(a) {
        var t = this.data.xinxi, e = a.detail.value;
        t.username = e, this.setData({
            xinxi: t
        });
    },
    userTelInput: function(a) {
        var t = this.data.xinxi, e = a.detail.value;
        t.usertel = e, this.setData({
            xinxi: t
        });
    },
    userAddInput: function(a) {
        var t = this.data.xinxi, e = a.detail.value;
        t.address = e, this.setData({
            xinxi: t
        });
    },
    bindDateChange: function(a) {
        var t = this.data.xinxi, e = a.detail.value;
        t.userdate = e, this.setData({
            xinxi: t,
            chuydate: e
        });
    },
    bindTimeChange: function(a) {
        var t = this.data.xinxi, e = a.detail.value;
        t.usertime = e, this.setData({
            xinxi: t,
            chuytime: e
        });
    },
    userTextInput: function(a) {
        var t = this.data.xinxi, e = a.detail.value;
        t.userbeiz = e, this.setData({
            xinxi: t
        });
    },
    switch1Change: function(a) {
        var t = this, e = (t.data.dikou_jf, t.data.dikou_jf_val), n = (t.data.dikou_score, 
        t.data.dikou_score_val), s = (t.data.zz_pay_money, t.data.shangjbs.user_money), i = t.data.allprice, o = t.data.zz_my_paymoney, d = t.data.zz_my_paymoney2, r = 0, u = 0, c = 0;
        a.detail.value ? (u = n, d = i - (r = e), s - e < i ? c = i - s - e : (c = 0, o = i)) : (r = 0, 
        s < (d = i) ? c = i - s : (c = 0, o = i)), t.setData({
            dikou_jf: r,
            dikou_score: u,
            zz_pay_money: c,
            zz_my_paymoney: o,
            zz_my_paymoney2: d
        });
    }
});