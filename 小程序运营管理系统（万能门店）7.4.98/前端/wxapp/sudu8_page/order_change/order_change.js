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
        couponprice: 0,
        jqdjg: "请选择",
        yhqid: "0",
        hxmm: "",
        showhx: 0
    },
    onPullDownRefresh: function() {
        var a = this.data.order;
        this.getOrder(a), wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var t = this, e = a.id;
        t.setData({
            order: e
        });
        var d = 0;
        a.fxsid && (d = a.fxsid, t.setData({
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
        }), app.util.getUserInfo(t.getinfos, d);
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
        var t = this, e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/mycoupon",
            data: {
                openid: e
            },
            success: function(a) {
                t.setData({
                    couponlist: a.data.data
                });
            },
            fail: function(a) {}
        }), app.util.request({
            url: "entry/wxapp/Orderinfo",
            data: {
                order: a,
                openid: e
            },
            cachetime: "30",
            success: function(a) {
                t.data.yhje;
                t.setData({
                    id: a.data.data.pid,
                    datas: a.data.data,
                    dprice: a.data.data.price,
                    jhsl: a.data.data.num,
                    hjjg: a.data.data.price * a.data.data.num,
                    sfje: a.data.data.true_price,
                    pro_name: a.data.data.pro_user_name,
                    pro_tel: a.data.data.pro_user_tel,
                    pro_address: a.data.data.pro_user_add,
                    pro_txt: a.data.data.pro_user_txt,
                    my_num: a.data.data.my_num,
                    xg_num: a.data.data.pro_xz,
                    shengyu: a.data.data.pro_kc,
                    my_gml: a.data.data.my_num,
                    cdd: a.data.data.mcount,
                    yhqid: a.data.data.couponid,
                    jqdjg: a.data.data.coupon.price
                }), wx.setNavigationBarTitle({
                    title: t.data.datas.product
                }), wx.setStorageSync("isShowLoading", !1);
            }
        });
    },
    jian: function() {
        var a = this, t = a.data.jhsl, e = (a.data.xg_num, a.data.my_num), d = a.data.my_gml, o = a.data.dprice, s = a.data.yhje, n = a.data.cdd;
        e--, 0 == --t && (e = (t = 1) < n ? d : 1);
        var i = 100 * o * t / 100, r = i - s;
        a.setData({
            jhsl: t,
            my_num: e,
            hjjg: i,
            sfje: r,
            jqdjg: "请选择",
            yhqid: 0
        });
    },
    jia: function() {
        var a = this, t = a.data.jhsl, e = a.data.my_num, d = a.data.xg_num, o = a.data.shengyu, s = a.data.dprice, n = a.data.yhje;
        a.data.my_gml;
        e++, o < ++t && -1 != o && (t--, e--, wx.showModal({
            title: "提醒",
            content: "库存量不足！",
            showCancel: !1
        })), d < e && 0 != d && (t--, e--, wx.showModal({
            title: "提醒",
            content: "该商品为限购产品，您总购买数已超过限额！",
            showCancel: !1
        }));
        var i = 100 * s * t / 100, r = i - n;
        a.setData({
            jhsl: t,
            my_num: e,
            hjjg: i,
            sfje: r,
            jqdjg: "请选择",
            yhqid: 0
        });
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
        var t = this, a = (t.data.jhsl, t.data.sfje), e = wx.getStorageSync("openid"), d = t.data.jhsl, o = t.data.dprice, s = t.data.yhje, n = t.data.id, i = t.data.order, r = t.data.pro_name, c = t.data.pro_tel, u = t.data.pro_address, l = t.data.pro_txt, h = t.data.yhqid, p = !0;
        if (!r && 2 == t.data.datas.pro_flag) return p = !1, wx.showModal({
            title: "提醒",
            content: "姓名为必填！",
            showCancel: !1
        }), !1;
        return c || 2 != t.data.datas.pro_flag_tel ? /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/.test(c) || 2 != t.data.datas.pro_flag_tel ? u || 2 != t.data.datas.pro_flag_add ? void (p && app.util.request({
            url: "entry/wxapp/Dingd",
            data: {
                openid: e,
                id: n,
                price: o,
                count: d,
                youhui: s,
                zhifu: a,
                order: i,
                pro_name: r,
                pro_tel: c,
                pro_address: u,
                pro_txt: l,
                yhqid: h
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                return 0 == a.data.data.success && 0 == a.data.data.syl ? (wx.showModal({
                    title: "提醒",
                    content: "很遗憾！商品售完了！",
                    showCancel: !1,
                    success: function() {
                        wx.reLaunch({
                            url: "../showPro/showPro?id=" + a.data.data.id
                        });
                    }
                }), !1) : 0 == a.data.data.success && 0 < a.data.data.syl ? (wx.showModal({
                    title: "提醒",
                    content: "很遗憾！商品只剩下" + a.data.data.syl + "个",
                    showCancel: !1,
                    success: function() {
                        wx.reLaunch({
                            url: "../showPro/showPro?id=" + a.data.data.id
                        });
                    }
                }), !1) : void (1 == a.data.data.success && (t.setData({
                    order: a.data.data
                }), wx.reLaunch({
                    url: "../show_Pro_d/show_Pro_d?order=" + a.data.data.order_id
                })));
            }
        })) : (p = !1, wx.showModal({
            title: "提醒",
            content: "地址为必填！",
            showCancel: !1
        }), !1) : (wx.showModal({
            title: "提醒",
            content: "请输入有效的手机号码！",
            showCancel: !1
        }), !1) : (p = !1, wx.showModal({
            title: "提醒",
            content: "手机号为必填！",
            showCancel: !1
        }), !1);
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
    getmoney: function(a) {
        var t = a.currentTarget.id, e = a.currentTarget.dataset.index, d = e.coupon.pay_money, o = this.data.hjjg;
        if (1 * o < 1 * d) wx.showModal({
            title: "提示",
            content: "价格未满" + d + "元，不可使用该优惠券！",
            showCancel: !1
        }); else {
            this.hideModal();
            var s = parseFloat(((100 * o - 100 * t) / 100).toPrecision(12));
            s < 0 && (s = 0), this.setData({
                jqdjg: t,
                yhqid: e.id,
                sfje: s,
                oldsfje: o
            });
        }
    },
    qxyh: function() {
        var a = this.data.jqdjg;
        "请选择" == a && (a = 0);
        var t = (100 * this.data.sfje + 100 * a) / 100;
        this.hideModal(), this.setData(_defineProperty({
            jqdjg: 0,
            yhqid: 0,
            sfje: t
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
    hxmmInput: function(a) {
        this.setData({
            hxmm: a.detail.value
        });
    },
    hxmmpass: function() {
        var e = this, a = e.data.hxmm, d = e.data.datas;
        a ? app.util.request({
            url: "entry/wxapp/hxmm",
            data: {
                hxmm: a,
                order_id: d.order_id
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
                        d.flag = 2, e.setData({
                            datas: d,
                            showhx: 0
                        });
                        var t = e.data.order;
                        this.getOrder(t);
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
            showhx: 0
        });
    }
});