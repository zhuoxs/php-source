function _defineProperty(a, t, e) {
    return t in a ? Object.defineProperty(a, t, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = e, a;
}

var app = getApp();

Page({
    data: {
        id: "",
        bg: "",
        picList: [],
        datas: "",
        comment: "",
        jhsl: 1,
        dprice: "",
        yhje: 0,
        hjjg: "",
        sfje: "",
        order: "",
        pro_name: "",
        pro_tel: "",
        pro_address: "",
        pro_txt: "",
        my_num: "",
        my_gml: "",
        xg_num: "",
        shengyu: "",
        cdd: "",
        chuydate: "",
        chuytime: "",
        num: [],
        xz_num: [],
        couponprice: 0,
        jqdjg: "请选择",
        yhqid: "0",
        oldsfje: "",
        pagedata: {},
        hxmm: "",
        showhx: 0,
        orderFormDisable: !0,
        isChange: "",
        formchangeBtn: 1,
        dkscore: 0,
        dkmoney: 0,
        yhqmoney_s: 0,
        zf_type: "",
        tableis: 0,
        orderid: "",
        manjian_info: ""
    },
    changeOrderFormDisable: function() {
        this.setData({
            orderFormDisable: !1,
            isChange: "isChange",
            formchangeBtn: 3
        });
    },
    changeOrderFormConfirm: function() {
        var t = this;
        wx.showModal({
            title: "确定提交吗",
            content: "只有一次修改的机会哦",
            success: function(a) {
                a.confirm && app.util.request({
                    url: "entry/wxapp/applyModifyAppointInfo",
                    data: {
                        pro_name: t.data.pro_name,
                        pro_tel: t.data.pro_tel,
                        pro_address: t.data.pro_address,
                        chuydate: t.data.chuydate,
                        chuytime: t.data.chuytime,
                        order_id: t.data.order
                    },
                    success: function(a) {
                        t.setData({
                            orderFormDisable: !0,
                            isChange: "",
                            formchangeBtn: 4
                        }), wx.showModal({
                            title: "提示",
                            content: "信息修改成功，请等待后台管理员审核！",
                            showCancel: !1
                        });
                    }
                });
            }
        });
    },
    changeOrderFormCancel: function() {
        this.setData({
            orderFormDisable: !0,
            isChange: "",
            formchangeBtn: 2
        });
    },
    ContactMerchant: function() {
        var e = this;
        wx.showModal({
            title: "提示",
            content: "请联系商家咨询具体信息！",
            confirmText: "联系商家",
            success: function(a) {
                if (a.confirm) {
                    var t = e.data.baseinfo.tel;
                    wx.makePhoneCall({
                        phoneNumber: t
                    });
                }
            }
        });
    },
    onPullDownRefresh: function() {
        var a = this.data.order;
        this.getOrder(a), wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var t = this, e = a.id;
        t.setData({
            order: e
        }), a.tableis && t.setData({
            tableis: a.tableis
        }), 0 == a.tsid ? t.setData({
            tableis: 0
        }) : t.setData({
            tableis: 1
        });
        var n = 0;
        a.fxsid && (n = a.fxsid, t.setData({
            fxsid: a.fxsid
        })), app.util.request({
            url: "entry/wxapp/BaseMin",
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(a) {
                a.data.data;
                t.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: t.data.baseinfo.base_tcolor,
                    backgroundColor: t.data.baseinfo.base_color
                });
            }
        }), app.util.getUserInfo(t.getinfos, n);
    },
    redirectto: function(a) {
        var t = a.currentTarget.dataset.link, e = a.currentTarget.dataset.linktype;
        app.util.redirectto(t, e);
    },
    getinfos: function() {
        var e = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                e.setData({
                    openid: a.data
                });
                var t = e.data.order;
                e.getOrder(t);
            }
        });
    },
    getOrder: function(a) {
        var c = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Orderinfo",
            data: {
                order: a,
                openid: t
            },
            success: function(a) {
                c.data.yhje;
                var t = a.data.data.yhInfo, e = a.data.data.order_id;
                0 != t && (0 < t.score.money ? c.setData({
                    ischecked: !0,
                    jifen_u: 1,
                    dkscore: t.score.msg.slice(0, t.score.msg.indexOf("积分")),
                    dkmoney: t.score.money
                }) : c.setData({
                    jifen_u: 0
                }), t.mj ? c.setData({
                    manjian_info: t.mj.msg
                }) : c.setData({
                    manjian_info: "无"
                }), t.yhq ? c.setData({
                    jqdjg: t.yhq.msg
                }) : c.setData({
                    jqdjg: "无"
                }));
                for (var n = a.data.data.more_type_x, d = [], o = {}, s = 0, i = 0; i < n.length; i++) o[i] = n[i][4], 
                d.push(o), s = (100 * s + 100 * n[i][4]) / 100;
                if ("3" == a.data.data.flag && "1" == a.data.data.pro_flag_ding ? c.setData({
                    formchangeBtn: 0
                }) : "1" != a.data.data.flag || 0 != a.data.data.can_modify || a.data.data.modify_info ? "1" != a.data.data.flag || 1 != a.data.data.can_modify || a.data.data.modify_info ? a.data.data.modify_info && 1 == a.data.data.modify_flag ? c.setData({
                    formchangeBtn: 4
                }) : a.data.data.modify_info && 2 == a.data.data.modify_flag ? c.setData({
                    formchangeBtn: 5
                }) : a.data.data.modify_info && 3 == a.data.data.modify_flag && c.setData({
                    formchangeBtn: 6
                }) : c.setData({
                    formchangeBtn: 2
                }) : c.setData({
                    formchangeBtn: 1
                }), c.setData({
                    id: a.data.data.pid,
                    datas: a.data.data,
                    dprice: a.data.data.price,
                    jhsl: a.data.data.num,
                    hjjg: a.data.data.price,
                    sfje: parseFloat(a.data.data.true_price),
                    pro_name: a.data.data.pro_user_name,
                    pro_tel: a.data.data.pro_user_tel,
                    pro_address: a.data.data.pro_user_add,
                    pro_txt: a.data.data.pro_user_txt,
                    my_num: a.data.data.my_num,
                    xg_num: a.data.data.pro_xz,
                    shengyu: a.data.data.pro_kc,
                    my_gml: a.data.data.my_num,
                    cdd: a.data.data.mcount,
                    chuydate: a.data.data.chuydate,
                    chuytime: a.data.data.chuytime,
                    modify_date_begin: a.data.data.modify_date_begin,
                    num: d,
                    chooseNum: s,
                    xz_num: a.data.data.more_type_num,
                    oldsfje: a.data.data.price,
                    yhqid: a.data.data.couponid,
                    pagedata: a.data.data.beizhu_val,
                    myscore: parseFloat(a.data.data.my_score),
                    mymoney: parseFloat(a.data.data.my_money),
                    zf_type: parseFloat(a.data.data.my_money) >= a.data.data.true_price ? 0 : 1,
                    orderid: e,
                    pay_price: a.data.data.pay_price
                }), 1 == c.data.zf_type) {
                    var r = (c.data.sfje - c.data.pay_price).toFixed(2);
                    c.setData({
                        yue: r
                    });
                }
                wx.setNavigationBarTitle({
                    title: c.data.datas.product
                }), wx.setStorageSync("isShowLoading", !1);
            }
        }), app.util.request({
            url: "entry/wxapp/mycoupon",
            data: {
                openid: t
            },
            success: function(a) {
                c.setData({
                    couponlist: a.data.data
                });
            },
            fail: function(a) {}
        });
    },
    getmyinfo: function() {
        wx.getStorageSync("openid");
        var a = this.data.moneyoff, t = this.data.hjjg;
        if (a) for (var e = a.length - 1; 0 <= e; e--) if (t >= parseFloat(a[e].reach)) {
            t -= parseFloat(a[e].del);
            break;
        }
        this.setData({
            sfje: t,
            zf_type: this.data.mymoney >= t ? 0 : 1
        });
    },
    jian: function(a) {
        var t = this, e = t.data.yhje, n = a.currentTarget.dataset.testid, d = a.currentTarget.dataset.testkey, o = t.data.num[d][d], s = (t.data.duogg, 
        t.data.sfje), i = t.data.hjjg, r = t.data.oldsfje;
        if (--o < 0) o = 0; else {
            var c = Math.round(100 * r - 100 * n * o + 100 * n * (o - 1)) / 100;
            s = c - e, r = i = c;
            var u = t.data.num;
            u[d][d] = o, t.setData({
                num: u,
                sfje: s,
                hjjg: i,
                jqdjg: "请选择",
                oldsfje: r,
                yhqid: 0
            });
        }
        t.getmyinfo();
    },
    jia: function(a) {
        var t = this, e = (t.data.yhje, a.currentTarget.dataset.testid), n = a.currentTarget.dataset.testkey, d = t.data.num[n][n], o = (t.data.duogg, 
        t.data.oldsfje), s = t.data.hjjg;
        if (t.data.xz_num[n].shennum < ++d) return d--, wx.showModal({
            title: "提醒",
            content: "库存量不足！",
            showCancel: !1
        }), !1;
        var i = Math.round(100 * e * d + 100 * o - 100 * e * (d - 1)) / 100;
        s = o = i;
        var r = t.data.num;
        r[n][n] = d;
        var c = t.data.chooseNum + 1;
        t.setData({
            num: r,
            hjjg: s,
            jqdjg: "请选择",
            oldsfje: o,
            yhqid: 0,
            chooseNum: c,
            ischecked: !1,
            dkscore: 0,
            dkmoney: 0,
            jifen_u: 2
        }), t.getmyinfo();
    },
    userNameInput: function(a) {
        this.setData({
            pro_name: a.detail.value
        });
    },
    userTelInput: function(a) {
        this.setData({
            pro_tel: a.detail.value
        });
    },
    userAddInput: function(a) {
        this.setData({
            pro_address: a.detail.value
        });
    },
    userTextInput: function(a) {
        this.setData({
            pro_txt: a.detail.value
        });
    },
    save: function() {
        var a = this.data.zf_type, t = this.data.order;
        0 == a ? this.pay1(t) : this.pay2(t);
    },
    pay1: function(t) {
        var e = this;
        wx.showModal({
            title: "请注意",
            content: "您将使用余额支付" + e.data.sfje + "元",
            success: function(a) {
                a.confirm && (e.payover_do(t), e.payover_fxs(t), wx.showLoading({
                    title: "下单中...",
                    mask: !0
                }));
            }
        });
    },
    pay2: function(t) {
        var e = this, a = wx.getStorageSync("openid"), n = e.data.sfje;
        app.util.request({
            url: "entry/wxapp/beforepay",
            data: {
                openid: a,
                price: n,
                order_id: t,
                types: "yuyue",
                formId: e.data.formId
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                1 == a.data.data.errs && wx.showModal({
                    title: "支付失败",
                    content: a.data.data.return_msg,
                    showCancel: !1
                });
                -1 != [ 1, 2, 3, 4 ].indexOf(a.data.data.err) && wx.showModal({
                    title: "支付失败",
                    content: a.data.data.message,
                    showCancel: !1
                }), 0 == a.data.data.err && (app.util.request({
                    url: "entry/wxapp/savePrepayid",
                    data: {
                        types: "yuyue",
                        order_id: t,
                        prepayid: a.data.data.package
                    },
                    success: function(a) {},
                    fail: function(a) {}
                }), wx.requestPayment({
                    timeStamp: a.data.data.timeStamp,
                    nonceStr: a.data.data.nonceStr,
                    package: a.data.data.package,
                    signType: "MD5",
                    paySign: a.data.data.paySign,
                    success: function(a) {
                        wx.showToast({
                            title: "支付成功",
                            icon: "success",
                            duration: 3e3,
                            success: function(a) {
                                e.payover_fxs(t), wx.showToast({
                                    title: "购买成功！",
                                    icon: "success",
                                    success: function() {
                                        setTimeout(function() {
                                            wx.navigateBack({
                                                delta: 9
                                            }), wx.navigateTo({
                                                url: "/sudu8_page/sudu8_page/order/order"
                                            });
                                        }, 1500);
                                    }
                                });
                            }
                        });
                    },
                    fail: function(a) {},
                    complete: function(a) {}
                }));
            }
        });
    },
    payover_do: function(a) {
        var t = wx.getStorageSync("openid"), e = this.data.sfje;
        app.util.request({
            url: "entry/wxapp/paynotify",
            data: {
                out_trade_no: a,
                openid: t,
                payprice: e,
                types: "yuyue",
                flag: 0,
                formId: this.data.formId
            },
            success: function(a) {
                wx.showToast({
                    title: "购买成功！",
                    icon: "success",
                    success: function() {
                        setTimeout(function() {
                            wx.navigateBack({
                                delta: 9
                            }), wx.navigateTo({
                                url: "/sudu8_page/order/order"
                            });
                        }, 1500);
                    }
                });
            }
        });
    },
    payover_fxs: function(a) {
        var t = wx.getStorageSync("openid"), e = wx.getStorageSync("fxsid");
        app.util.request({
            url: "entry/wxapp/payoverFxs",
            data: {
                openid: t,
                order_id: a,
                fxsid: e,
                types: "yuyue"
            },
            success: function(a) {},
            fail: function(a) {}
        });
    },
    passd: function() {
        var t = this.data.order;
        wx.showModal({
            title: "提醒",
            content: "亲，您确定要删除该订单？",
            success: function(a) {
                a.confirm && app.util.request({
                    url: "entry/wxapp/dpass",
                    data: {
                        order: t
                    },
                    header: {
                        "content-type": "application/json"
                    },
                    success: function(a) {
                        1 == a.data.data && wx.showToast({
                            title: "订单取消成功",
                            icon: "success",
                            duration: 2e3,
                            success: function() {
                                wx.redirectTo({
                                    url: "/sudu8_page/order/order?type=9"
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    bindDateChange2: function(a) {
        this.setData({
            chuydate: a.detail.value
        });
    },
    bindTimeChange2: function(a) {
        this.setData({
            chuytime: a.detail.value
        });
    },
    getmoney: function(a) {
        var t = this, e = a.currentTarget.id, n = a.currentTarget.dataset.index, d = n.coupon.pay_money, o = t.data.hjjg, s = t.data.sfje;
        if (1 * o < 1 * d) wx.showModal({
            title: "提示",
            content: "价格未满" + d + "元，不可使用该优惠券！",
            showCancel: !1
        }); else {
            var i = (100 * s - 100 * e) / 100;
            t.setData({
                ischecked: !1
            }), t.switchChange({
                detail: {
                    value: !1
                }
            }), (s = parseFloat(i.toPrecision(12)) + parseFloat(t.data.dkmoney)) < 0 && (s = 0), 
            t.setData({
                jqdjg: e,
                yhqid: n.id,
                sfje: s,
                oldsfje: o,
                yhqmoney_s: e,
                zf_type: t.data.mymoney >= s ? 0 : 1
            }), t.hideModal();
        }
    },
    qxyh: function() {
        var a = this.data.jqdjg;
        "请选择" == a && (a = 0);
        this.data.sfje;
        this.hideModal(), this.setData(_defineProperty({
            jqdjg: 0,
            yhqid: 0,
            sfje: huany
        }, "jqdjg", "请选择"));
    },
    showModal: function() {
        var a = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = a).translateY(300).step(), this.setData({
            animationData: a.export(),
            showModalStatus: !0
        }), setTimeout(function() {
            a.translateY(0).step(), this.setData({
                animationData: a.export()
            });
        }.bind(this), 200);
    },
    hideModal: function() {
        var a = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = a).translateY(300).step(), this.setData({
            animationData: a.export()
        }), setTimeout(function() {
            a.translateY(0).step(), this.setData({
                animationData: a.export(),
                showModalStatus: !1
            });
        }.bind(this), 200);
    },
    switchChange: function(a) {
        var o = this, t = a.detail.value, e = wx.getStorageSync("openid"), s = o.data.sfje, i = 0, n = "table" == o.data.type ? o.data.select_num : o.data.chooseNum;
        1 == t ? app.util.request({
            url: "entry/wxapp/scoreDeduction",
            data: {
                id: o.data.id,
                num: n,
                openid: e,
                is_more: 1
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                var t = a.data.data;
                i = t.moneycl;
                var e = t.gzmoney, n = t.gzscore;
                if (s < i && (i = parseInt(s)), 0 == i) var d = 0; else d = i * n / e;
                s = Math.round(100 * (s - i)) / 100, o.setData({
                    sfje: s,
                    dkmoney: i,
                    dkscore: d,
                    jifen_u: 1,
                    zf_type: o.data.mymoney >= s ? 0 : 1
                });
            }
        }) : (s = parseFloat(s) + parseFloat(o.data.dkmoney), o.setData({
            dkmoney: 0,
            dkscore: 0,
            jifen_u: 0,
            zf_type: o.data.mymoney >= s ? 0 : 1
        }));
    },
    bindInputChange: function(a) {
        var t = a.detail.value, e = a.currentTarget.dataset.index, n = this.data.pagedata;
        n[e].val = t, this.setData({
            pagedata: n
        });
    },
    bindPickerChange: function(a) {
        var t = a.detail.value, e = a.currentTarget.dataset.index, n = this.data.pagedata, d = n[e].tp_text[t];
        n[e].val = d, this.setData({
            pagedata: n
        });
    },
    bindDateChange: function(a) {
        var t = a.detail.value, e = a.currentTarget.dataset.index, n = this.data.pagedata;
        n[e].val = t, this.setData({
            pagedata: n
        });
    },
    bindTimeChange: function(a) {
        var t = a.detail.value, e = a.currentTarget.dataset.index, n = this.data.pagedata;
        n[e].val = t, this.setData({
            pagedata: n
        });
    },
    checkboxChange: function(a) {
        var t = a.detail.value, e = a.currentTarget.dataset.index, n = this.data.pagedata;
        n[e].val = t, this.setData({
            pagedata: n
        });
    },
    radioChange: function(a) {
        var t = a.detail.value, e = a.currentTarget.dataset.index, n = this.data.pagedata;
        n[e].val = t, this.setData({
            pagedata: n
        });
    },
    hxmmInput: function(a) {
        this.setData({
            hxmm: a.detail.value
        });
    },
    hxmmpass: function() {
        var e = this, a = e.data.hxmm, n = e.data.datas;
        a ? app.util.request({
            url: "entry/wxapp/hxmm",
            data: {
                hxmm: a,
                order_id: n.order_id,
                types: "yuyue",
                openid: wx.getStorageSync("openid")
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                0 == a.data.data ? wx.showModal({
                    title: "提示",
                    content: "核销密码不正确！",
                    showCancel: !1
                }) : wx.showToast({
                    title: "消费成功",
                    icon: "success",
                    duration: 2e3,
                    success: function(a) {
                        n.flag = 2, e.setData({
                            datas: n,
                            showhx: 0,
                            hxmm: ""
                        });
                        var t = e.data.order;
                        e.getOrder(t);
                    }
                });
            }
        }) : wx.showModal({
            title: "提示",
            content: "请输入核销密码！",
            showCancel: !1
        });
    },
    hxshow: function() {
        this.setData({
            showhx: 1
        });
    },
    hxhide: function() {
        this.setData({
            showhx: 0,
            hxmm: ""
        });
    }
});