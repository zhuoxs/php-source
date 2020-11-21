var app = getApp();

Page({
    data: {
        nav: 1,
        num: 1,
        jifen_u: 0,
        yunfei: 0,
        yfjian: 0,
        jqdjg: "请选择",
        yhqid: 0,
        yhdq: 0,
        dkmoney: 0,
        dkscore: 0,
        zf_type: null,
        pagedata: {},
        imgcount_xz: 0,
        pagedata_set: [],
        xuanz: 0,
        lixuanz: -1,
        ttcxs: 0,
        get_yf: 0,
        baoyou: 0,
        has_yf: 1,
        kuaidi: 2,
        again: 0,
        pro_city: "",
        mj_order: "",
        yhq_order: "",
        score_order: "",
        score_money_order: 0,
        yhq_money_order: 0,
        yunfei_order: 0,
        mj_money_order: 0,
        m_address: [],
        m_address_l: 0,
        beizhu_val: "",
        sw: !1,
        free_package: 0,
        disabled: !1
    },
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var e = this;
        e.refreshSessionkey(), a.id && (e.data.id = a.id);
        var t = a.addressid, d = a.orderid;
        e.setData({
            addressid: t,
            orderid: d
        });
        var n = 0;
        a.fxsid && (n = a.fxsid, e.setData({
            fxsid: a.fxsid
        })), a.again && (e.setData({
            again: 1
        }), app.util.request({
            url: "entry/wxapp/getDanOrder",
            data: {
                orderid: d
            },
            success: function(a) {
                var t = a.data.data.err;
                1 == t ? wx.showModal({
                    title: "提示",
                    content: "该订单数据错误，请重新下单",
                    showCancel: !1,
                    success: function() {
                        wx.redirectTo({
                            url: "/sudu8_page/index/index"
                        });
                    }
                }) : 0 == t && e.setData({
                    beizhu_val: a.data.data.beizhu_val,
                    yue_order: a.data.data.yue,
                    nav_order: a.data.data.nav,
                    true_price_order: a.data.data.true_price,
                    m_address: a.data.data.m_address,
                    m_address_l: a.data.data.m_address_l,
                    yunfei_order: 0 < parseFloat(a.data.data.yhInfo.yunfei) ? a.data.data.yhInfo.yunfei : 0,
                    mj_order: 0 < parseFloat(a.data.data.yhInfo.mj.money) ? a.data.data.yhInfo.mj.msg : "无",
                    mj_money_order: 0 < parseFloat(a.data.data.yhInfo.mj.money) ? a.data.data.yhInfo.mj.money : 0,
                    yhq_order: 0 < parseFloat(a.data.data.yhInfo.yhq.money) ? a.data.data.yhInfo.yhq.msg : "未使用",
                    yhq_money_order: 0 < parseFloat(a.data.data.yhInfo.yhq.money) ? parseFloat(a.data.data.yhInfo.yhq.money) : 0,
                    score_order: 0 < parseFloat(a.data.data.yhInfo.score.money) ? a.data.data.yhInfo.score.msg : "未使用",
                    score_money_order: 0 < parseFloat(a.data.data.yhInfo.score.money) ? parseFloat(a.data.data.yhInfo.score.money) : 0
                });
            }
        })), app.util.request({
            url: "entry/wxapp/BaseMin",
            data: {
                vs1: 1
            },
            success: function(a) {
                e.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: e.data.baseinfo.base_tcolor,
                    backgroundColor: e.data.baseinfo.base_color
                });
            },
            fail: function(a) {}
        }), app.util.getUserInfo(e.getinfos, n);
    },
    getinfos: function() {
        var s = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                var e = a.data, d = s.data.again, n = s.data.orderid;
                s.setData({
                    openid: e
                }), 0 == d && app.util.request({
                    url: "entry/wxapp/checkFreePackage",
                    data: {
                        openid: e
                    },
                    success: function(a) {
                        s.setData({
                            free_package: a.data.data
                        });
                    }
                }), app.util.request({
                    url: "entry/wxapp/showPro",
                    data: {
                        openid: e,
                        id: s.data.id,
                        orderid: n || ""
                    },
                    success: function(a) {
                        if (0 == a.data.data.pro_xz) var t = 1; else t = a.data.data.pro_xz - a.data.data.my_num;
                        s.setData({
                            mymoney: parseFloat(a.data.data.userinfo.money),
                            myscore: parseFloat(a.data.data.userinfo.score),
                            thumb: a.data.data.thumb,
                            title: a.data.data.title,
                            datas: a.data.data,
                            dprice: a.data.data.price,
                            hjjg: a.data.data.order_num ? (a.data.data.price * a.data.data.order_num).toFixed(2) : a.data.data.price,
                            my_num: a.data.data.my_num,
                            xg_num: a.data.data.pro_xz,
                            shengyu: a.data.data.pro_kc,
                            xg_buy: t,
                            num: a.data.data.order_num ? a.data.data.order_num : 1,
                            pagedata: a.data.data.forms,
                            nav: n && "2" == a.data.data.nav ? 2 : 1,
                            formdescs: a.data.data.formdescs,
                            kuaidi: a.data.data.kuaidi
                        }), 0 == s.data.kuaidi ? s.setData({
                            nav: 1
                        }) : 1 == s.data.kuaidi ? s.setData({
                            nav: 2
                        }) : 2 == s.data.kuaidi && s.setData({
                            nav: 1
                        }), wx.setNavigationBarTitle({
                            title: s.data.title
                        }), wx.setStorageSync("isShowLoading", !1), wx.hideNavigationBarLoading(), wx.stopPullDownRefresh(), 
                        0 == d && app.util.request({
                            url: "entry/wxapp/mycoupon",
                            data: {
                                openid: e
                            },
                            success: function(a) {
                                s.setData({
                                    couponlist: a.data.data
                                });
                            }
                        }), app.util.request({
                            url: "entry/wxapp/getmoneyoff",
                            success: function(a) {
                                for (var t = a.data.data.moneyoff, e = "", d = 0; d < t.length; d++) d == t.length - 1 ? e += "满" + t[d].reach + "减" + t[d].del : e += "满" + t[d].reach + "减" + t[d].del + "，";
                                s.setData({
                                    moneyoff: t,
                                    moneyoffstr: t ? e : ""
                                });
                                var n = s.data.addressid;
                                n ? s.getmraddresszd(n) : s.getmraddress();
                            }
                        });
                    }
                });
            }
        });
    },
    getmyinfo: function() {
        var d = this, a = (wx.getStorageSync("openid"), d.data.moneyoff), n = d.data.hjjg, s = d.data.nav, t = d.data.again;
        if (1 == t) d.data.mj_money_order, d.data.yhq_money_order, d.data.score_money_order, 
        d.data.yunfei_order;
        if (a && 0 == t) {
            for (var e = a.length - 1; 0 <= e; e--) if (n >= parseFloat(a[e].reach)) {
                n -= parseFloat(a[e].del);
                break;
            }
            var i = d.data.pro_city, o = d.data.free_package;
            "" != i && 2 != d.data.nav && 0 == o ? app.util.request({
                url: "entry/wxapp/yunfeigetnew",
                data: {
                    id: d.data.id,
                    type: "miaosha",
                    hjjg: d.data.hjjg,
                    num: d.data.num,
                    pro_city: i
                },
                success: function(a) {
                    var t = a.data.data, e = 0;
                    e = parseFloat(n) >= parseFloat(t.byou) && "" != t.byou ? 0 : t.yfei, n = 2 == s ? Math.round(1 * n * 100) / 100 : Math.round(100 * (1 * n + 1 * e)) / 100, 
                    d.setData({
                        yunfei: e,
                        sfje: n,
                        zf_type: d.data.mymoney >= n ? 0 : 1,
                        zf_money: d.data.mymoney >= n ? n : Math.round(100 * (n - d.data.mymoney)) / 100,
                        get_yf: t.yfei,
                        baoyou: t.byou
                    });
                }
            }) : d.setData({
                sfje: n,
                zf_type: d.data.mymoney >= n ? 0 : 1,
                zf_money: d.data.mymoney >= n ? n : Math.round(100 * (n - d.data.mymoney)) / 100
            });
        } else 1 == t && (n = d.data.true_price_order), d.setData({
            sfje: n,
            zf_type: d.data.mymoney >= n ? 0 : 1,
            zf_money: d.data.mymoney >= n ? n : Math.round(100 * (n - d.data.mymoney)) / 100
        });
    },
    switchChange: function(a) {
        var s = this, t = a.detail.value, e = wx.getStorageSync("openid"), i = s.data.sfje, d = s.data.sw, o = 0;
        if (1 == t && 0 == d) app.util.request({
            url: "entry/wxapp/scoreDeduction",
            data: {
                id: s.data.id,
                num: s.data.num,
                openid: e
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                var t = a.data.data;
                o = t.moneycl;
                var e = t.gzmoney, d = t.gzscore;
                if (i < o && (o = parseInt(i)), 0 == o) var n = 0; else n = o * d / e;
                i = Math.round(100 * (i - o)) / 100, s.setData({
                    sfje: i,
                    sw: !0,
                    dkmoney: o,
                    dkscore: n,
                    zf_type: s.data.mymoney >= i ? 0 : 1,
                    zf_money: s.data.mymoney >= i ? i : Math.round(100 * (i - s.data.mymoney)) / 100,
                    jifen_u: 1
                });
            }
        }); else {
            o = s.data.dkmoney;
            i = 1 * i + 1 * o, s.setData({
                sw: !1,
                sfje: i,
                zf_type: s.data.mymoney >= i ? 0 : 1,
                zf_money: s.data.mymoney >= i ? i : Math.round(100 * (i - s.data.mymoney)) / 100,
                dkmoney: 0,
                dkscore: 0,
                jifen_u: 0
            });
        }
    },
    redirectto: function(a) {
        var t = a.currentTarget.dataset.link, e = a.currentTarget.dataset.linktype;
        app.util.redirectto(t, e);
    },
    onShow: function() {
        0 == this.data.again && this.getmraddress(), this.qxyh(), this.setData({
            disabled: !1
        });
    },
    onShareAppMessage: function() {},
    nav: function(a) {
        var t = this, e = parseInt(a.detail.value), d = 0, n = t.data.yunfei;
        if (1 == e ? t.data.sfje < t.data.baoyou ? 0 != n ? d = 0 : d -= n : d = t.data.get_yf : d = n, 
        1 == e) if (t.data.sfje < t.data.baoyou) if (0 == t.data.has_yf) var s = Math.round(100 * t.data.sfje) / 100; else {
            s = Math.round(100 * (1 * t.data.sfje + 1 * t.data.get_yf)) / 100;
            t.setData({
                has_yf: 1
            });
        } else s = Math.round(100 * t.data.sfje) / 100; else s = Math.round(100 * (t.data.sfje - d)) / 100;
        t.setData({
            nav: e,
            yfjian: 1 == e ? 0 : n,
            sfje: s,
            zf_type: t.data.mymoney >= s ? 0 : 1,
            zf_money: t.data.mymoney >= s ? s : Math.round(100 * (s - t.data.mymoney)) / 100,
            yunfei: n
        });
    },
    add_address: function() {
        0 == this.data.again && wx.navigateTo({
            url: "/sudu8_page/address/address?shareid=" + this.data.shareid + "&pid=" + this.data.id + "&orderid=" + this.data.orderid + "&addressid=" + this.data.addressid
        });
    },
    getmraddress: function() {
        var d = this, a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/getmraddress",
            data: {
                openid: a
            },
            success: function(a) {
                var t = a.data.data;
                if ("" != t) d.setData({
                    mraddress: t,
                    pro_city: t.pro_city,
                    addressid: t.id
                }); else {
                    var e = d.data.again;
                    0 == e ? d.setData({
                        mraddress: ""
                    }) : 1 == e && wx.showModal({
                        title: "提示",
                        content: "该订单数据错误，请重新下单",
                        showCancel: !1,
                        success: function() {
                            wx.redirectTo({
                                url: "/sudu8_page/index/index"
                            });
                        }
                    });
                }
                d.getmyinfo();
            }
        });
    },
    getmraddresszd: function(a) {
        var d = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/getmraddresszd",
            data: {
                openid: t,
                id: a
            },
            success: function(a) {
                var t = a.data.data;
                if ("" != t) d.setData({
                    mraddress: t,
                    pro_city: t.pro_city
                }); else {
                    var e = d.data.again;
                    0 == e ? d.setData({
                        mraddress: ""
                    }) : 1 == e && 0 == d.data.m_address_l ? d.setData({
                        mraddress: ""
                    }) : 1 == e && wx.showModal({
                        title: "提示",
                        content: "该订单数据错误，请重新下单",
                        showCancel: !1,
                        success: function() {
                            wx.redirectTo({
                                url: "/sudu8_page/index/index"
                            });
                        }
                    });
                }
                d.getmyinfo();
            }
        });
    },
    jian: function() {
        var a = this.data.num;
        --a <= 0 && (a = 1);
        var t = 100 * this.data.dprice * a / 100;
        this.setData({
            num: a,
            hjjg: t,
            dkmoney: 0,
            dkscore: 0,
            jifen_u: 0,
            jqdjg: "请选择",
            yhqid: 0,
            yhdq: 0,
            ischecked: !1
        }), this.getmyinfo();
    },
    jia: function() {
        var a = this, t = a.data.num, e = a.data.my_num, d = a.data.xg_num, n = a.data.shengyu, s = a.data.dprice;
        n < ++t && -1 != n && (t--, wx.showModal({
            title: "提醒",
            content: "库存量不足！",
            showCancel: !1
        })), d < t + e && 0 != d && (1 < t && t--, wx.showModal({
            title: "提醒",
            content: "该商品为限购产品，您总购买数已超过限额！",
            showCancel: !1
        }));
        var i = 100 * s * t / 100;
        a.setData({
            num: t,
            hjjg: i,
            dkmoney: 0,
            dkscore: 0,
            jifen_u: 0,
            jqdjg: "请选择",
            yhqid: 0,
            yhdq: 0,
            ischecked: !1
        }), a.getmyinfo();
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
    qxyh: function() {
        var a = this;
        a.setData({
            ischecked: !1
        }), a.switchChange({
            detail: {
                value: !1
            }
        });
        var t = a.data.yhdq, e = a.data.sfje;
        e = (100 * e + 100 * t) / 100, a.hideModal(), a.setData({
            jqdjg: "请选择",
            yhqid: 0,
            sfje: e,
            zf_type: a.data.mymoney >= e ? 0 : 1,
            zf_money: a.data.mymoney >= e ? e : Math.round(100 * (e - a.data.mymoney)) / 100,
            yhdq: 0
        });
    },
    getmoney: function(a) {
        var t = this;
        t.setData({
            ischecked: !1
        }), t.switchChange({
            detail: {
                value: !1
            }
        });
        var e = a.currentTarget.id, d = a.currentTarget.dataset.index, n = d.coupon.pay_money, s = t.data.sfje;
        s = 1 * s + 1 * t.data.yhdq;
        var i = t.data.yhqid;
        0 != i && d.id == i || (1 * s - parseFloat(t.data.yunfei) + parseFloat(t.data.yfjian) < 1 * n ? wx.showModal({
            title: "提示",
            content: "价格未满" + n + "元，不可使用该优惠券！",
            showCancel: !1
        }) : ((s = Math.floor(100 * (1 * s - 1 * e)) / 100) < 0 && (s = 0), t.setData({
            jqdjg: e,
            yhqid: d.id,
            sfje: s,
            zf_type: t.data.mymoney >= s ? 0 : 1,
            zf_money: t.data.mymoney >= s ? s : Math.round(100 * (s - t.data.mymoney)) / 100,
            yhdq: e
        }), t.hideModal()));
    },
    mjly: function(a) {
        var t = a.detail.value;
        this.setData({
            mjly: t
        });
    },
    bindInputChange: function(a) {
        var t = a.detail.value, e = a.currentTarget.dataset.index, d = this.data.pagedata;
        d[e].val = t, this.setData({
            pagedata: d
        });
    },
    bindPickerChange: function(a) {
        var t = a.detail.value, e = a.currentTarget.dataset.index, d = this.data.pagedata, n = d[e].tp_text[t];
        d[e].val = n, this.setData({
            pagedata: d
        });
    },
    bindDateChange: function(a) {
        var t = a.detail.value, e = a.currentTarget.dataset.index, d = this.data.pagedata;
        d[e].val = t, this.setData({
            pagedata: d
        });
    },
    bindTimeChange: function(a) {
        var t = a.detail.value, e = a.currentTarget.dataset.index, d = this.data.pagedata;
        d[e].val = t, this.setData({
            pagedata: d
        });
    },
    checkboxChange: function(a) {
        var t = a.detail.value, e = a.currentTarget.dataset.index, d = this.data.pagedata;
        d[e].val = t, this.setData({
            pagedata: d
        });
    },
    radioChange: function(a) {
        var t = a.detail.value, e = a.currentTarget.dataset.index, d = this.data.pagedata;
        d[e].val = t, this.setData({
            pagedata: d
        });
    },
    formSubmit: function(a) {
        for (var e = this, d = (e.data.datas, e.data.id), t = !0, n = e.data.pagedata, s = 0; s < n.length; s++) if (1 == n[s].ismust) if (5 == n[s].type) {
            if ("" == n[s].z_val) return t = !1, wx.showModal({
                title: "提醒",
                content: n[s].name + "为必填项！",
                showCancel: !1
            }), e.setData({
                disabled: !1
            }), !1;
        } else if ("" == n[s].val) return t = !1, wx.showModal({
            title: "提醒",
            content: n[s].name + "为必填项！",
            showCancel: !1
        }), e.setData({
            disabled: !1
        }), !1;
        t && app.util.request({
            url: "entry/wxapp/Formval",
            data: {
                id: d,
                pagedata: JSON.stringify(n),
                types: "showProDan",
                fid: e.data.datas.formset,
                openid: wx.getStorageSync("openid")
            },
            cachetime: "30",
            success: function(a) {
                var t = a.data.data.id;
                e.sendMail_form(d, t), e.doshend(t);
            }
        });
    },
    sendMail_form: function(a, t) {
        app.util.request({
            url: "entry/wxapp/sendMail_form",
            data: {
                id: a,
                cid: t
            },
            success: function(a) {
                return !0;
            },
            fail: function(a) {}
        });
    },
    choiceimg1111: function(a) {
        var s = this, t = 0, i = s.data.zhixin, o = a.currentTarget.dataset.index, r = s.data.pagedata, e = r[o].val, d = r[o].tp_text[0];
        e ? t = e.length : (t = 0, e = []);
        var n = d - t, u = app.util.url("entry/wxapp/wxupimg", {
            m: "sudu8_page"
        }), c = r[o].z_val ? r[o].z_val : [];
        wx.chooseImage({
            count: n,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                i = !0, s.setData({
                    zhixin: i
                }), wx.showLoading({
                    title: "图片上传中"
                });
                var t = a.tempFilePaths;
                e = e.concat(t), r[o].val = e, s.setData({
                    pagedata: r
                });
                var d = 0, n = t.length;
                !function e() {
                    wx.uploadFile({
                        url: u,
                        filePath: t[d],
                        name: "file",
                        success: function(a) {
                            var t = JSON.parse(a.data);
                            c.push(t), r[o].z_val = c, s.setData({
                                pagedata: r
                            }), ++d < n ? e() : (i = !1, s.setData({
                                zhixin: i
                            }), wx.hideLoading());
                        }
                    });
                }();
            }
        });
    },
    delimg: function(a) {
        var t = a.currentTarget.dataset.index, e = a.currentTarget.dataset.id, d = this.data.pagedata, n = d[t].val;
        n.splice(e, 1), 0 == n.length && (n = ""), d[t].val = n, this.setData({
            pagedata: d
        });
    },
    onPreviewImage: function(a) {
        app.util.showImage(a);
    },
    namexz: function(a) {
        for (var t = a.currentTarget.dataset.index, e = this.data.pagedata[t], d = [], n = 0; n < e.tp_text.length; n++) {
            var s = {};
            s.keys = e.tp_text[n], s.val = 1, d.push(s);
        }
        this.setData({
            ttcxs: 1,
            formindex: t,
            xx: d,
            xuanz: 0,
            lixuanz: -1
        }), this.riqi();
    },
    riqi: function() {
        for (var a = new Date(), t = new Date(a.getTime()), e = t.getFullYear() + "-" + (t.getMonth() + 1) + "-" + t.getDate(), d = this.data.xx, n = 0; n < d.length; n++) d[n].val = 1;
        this.setData({
            xx: d
        }), this.gettoday(e);
        var s = [], i = [], o = new Date();
        for (n = 0; n < 5; n++) {
            var r = new Date(o.getTime() + 24 * n * 3600 * 1e3), u = r.getFullYear(), c = r.getMonth() + 1, l = r.getDate(), y = c + "月" + l + "日", p = u + "-" + c + "-" + l;
            s.push(y), i.push(p);
        }
        this.setData({
            arrs: s,
            fallarrs: i,
            today: e
        });
    },
    xuanzd: function(a) {
        for (var t = a.currentTarget.dataset.index, e = this.data.fallarrs[t], d = this.data.xx, n = 0; n < d.length; n++) d[n].val = 1;
        this.setData({
            xuanz: t,
            today: e,
            lixuanz: -1,
            xx: d
        }), this.gettoday(e);
    },
    goux: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData({
            lixuanz: t
        });
    },
    gettoday: function(a) {
        var n = this, t = n.data.id, e = n.data.formindex, s = n.data.xx;
        app.util.request({
            url: "entry/wxapp/Duzhan",
            data: {
                id: t,
                types: "showArt",
                days: a,
                pagedatekey: e
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                for (var t = a.data.data, e = 0; e < t.length; e++) s[t[e]].val = 2;
                var d = 0;
                t.length == s.length && (d = 1), n.setData({
                    xx: s,
                    isover: d
                });
            }
        });
    },
    save_nb: function() {
        var a = this, t = a.data.today, e = a.data.xx, d = a.data.lixuanz;
        if (-1 == d) return wx.showModal({
            title: "提现",
            content: "请选择预约的选项",
            showCancel: !1
        }), !1;
        var n = "已选择" + t + "，" + e[d].keys.yval, s = a.data.pagedata, i = a.data.formindex;
        s[i].val = n, s[i].days = t, s[i].indexkey = i, s[i].xuanx = d, a.setData({
            ttcxs: 0,
            pagedata: s
        });
    },
    quxiao: function() {
        this.setData({
            ttcxs: 0
        });
    },
    weixinadd: function() {
        var i = this;
        wx.chooseAddress({
            success: function(a) {
                for (var t = a.provinceName + " " + a.cityName + " " + a.countyName + " " + a.detailInfo, e = a.userName, d = a.telNumber, n = i.data.pagedata, s = 0; s < n.length; s++) 0 == n[s].type && 2 == n[s].tp_text[0].yval && (n[s].val = e), 
                0 == n[s].type && 3 == n[s].tp_text[0].yval && (n[s].val = d), 0 == n[s].type && 4 == n[s].tp_text[0].yval && (n[s].val = t);
                i.setData({
                    myname: e,
                    mymobile: d,
                    myaddress: t,
                    pagedata: n
                });
            },
            fail: function(a) {
                wx.getSetting({
                    success: function(a) {
                        a.authSetting["scope.address"] || wx.openSetting({
                            success: function(a) {}
                        });
                    }
                });
            }
        });
    },
    submit: function(a) {
        var t = this, e = a.detail.formId, d = t.data.again;
        t.setData({
            formId: e,
            disabled: !0
        });
        var n = t.data.datas, s = t.data.mraddress;
        if (0 < n.formset) {
            if (2 != t.data.nav && (null == s || !s) && 0 == d) return wx.showModal({
                title: "提示",
                content: "请先选择/设置收货地址！",
                showCancel: !0,
                success: function(a) {
                    if (!a.confirm) return t.setData({
                        disabled: !1
                    }), !1;
                    wx.navigateTo({
                        url: "/sudu8_page/address/address?shareid=" + t.data.shareid + "&pid=" + t.data.id + "&orderid=" + t.data.orderid
                    });
                }
            }), !1;
            t.formSubmit();
        } else {
            if (2 != t.data.nav && (null == s || !s) && 0 == d) return wx.showModal({
                title: "提示",
                content: "请先选择/设置收货地址！",
                showCancel: !0,
                success: function(a) {
                    if (a.confirm) wx.navigateTo({
                        url: "/sudu8_page/address/address?shareid=" + t.data.shareid + "&pid=" + t.data.id + "&orderid=" + t.data.orderid
                    }); else if (a.cancel) return t.setData({
                        disabled: !1
                    }), !1;
                }
            }), !1;
            t.doshend(0);
        }
    },
    doshend: function(a) {
        var e = this, t = wx.getStorageSync("openid"), d = e.data.yhqid, n = e.data.sfje, s = e.data.nav, i = e.data.yunfei, o = e.data.yfjian, r = e.data.dkscore, u = (e.data.dkmoney, 
        e.data.mraddress), c = e.data.mjly, l = e.data.orderid, y = e.data.again;
        if (1 == s ? i -= o : i = 0, !(2 == s || null != u && u || 0 != y)) return wx.showModal({
            title: "提示",
            content: "请先选择/设置收货地址！",
            showCancel: !0,
            success: function(a) {
                if (!a.confirm) return e.setData({
                    disabled: !1
                }), !1;
                wx.navigateTo({
                    url: "/sudu8_page/address/address?shareid=" + e.data.shareid + "&pid=" + e.data.id + "&orderid=" + e.data.orderid
                });
            }
        }), !1;
        u.id;
        app.util.request({
            url: "entry/wxapp/createorder",
            header: {
                "content-type": "application/json"
            },
            data: {
                pid: e.data.id,
                num: e.data.num,
                types: "miaosha",
                openid: t,
                couponid: d,
                price: n,
                dkscore: r,
                address: u.id,
                mjly: c,
                nav: s,
                formid: a,
                yunfei: i,
                orderid: l || "",
                again: e.data.again
            },
            success: function(a) {
                if ("1" == a.data.data.errcode) wx.showModal({
                    title: a.data.data.err,
                    content: "请重新下单",
                    showCancel: !1
                }), e.setData({
                    disabled: !1
                }); else if ("2" == a.data.data.errcode) wx.showModal({
                    title: a.data.data.err,
                    content: a.data.data.can_buy <= 0 ? "去逛逛其他商品吧~" : "您还可购买" + a.data.data.can_buy + "件",
                    showCancel: !1
                }), e.setData({
                    disabled: !1
                }); else if ("3" == a.data.data.errcode) wx.showModal({
                    title: a.data.data.err,
                    content: "当前库存为" + a.data.data.kc + "件",
                    showCancel: !1
                }), e.setData({
                    disabled: !1
                }); else if ("4" == a.data.data.errcode) wx.showModal({
                    title: a.data.data.err,
                    content: "商品已经下架",
                    showCancel: !1,
                    success: function() {
                        wx.redirectTo({
                            url: "/sudu8_page/index/index"
                        });
                    }
                }); else if ("0" == a.data.errno) {
                    var t = a.data.data;
                    e.setData({
                        orderid: t
                    }), n <= e.data.mymoney && 0 == e.data.zf_type ? e.pay1(t) : e.pay2(t);
                }
            }
        });
    },
    pay1: function(t) {
        var e = this;
        wx.showModal({
            title: "请注意",
            content: "您将使用余额支付" + e.data.sfje + "元",
            success: function(a) {
                a.confirm ? (e.payover_do(t), e.payover_fxs(t), wx.showLoading({
                    title: "下单中...",
                    mask: !0
                })) : wx.redirectTo({
                    url: "/sudu8_page/orderlist_dan/orderlist_dan"
                });
            }
        });
    },
    pay2: function(t) {
        var e = this, a = wx.getStorageSync("openid"), d = e.data.sfje;
        app.util.request({
            url: "entry/wxapp/beforepay",
            data: {
                openid: a,
                price: d,
                order_id: t,
                types: "miaosha",
                formId: e.data.formId
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                1 == a.data.data.errs && (wx.showModal({
                    title: "支付失败",
                    content: a.data.data.return_msg,
                    showCancel: !1
                }), e.setData({
                    disabled: !1
                }));
                -1 != [ 1, 2, 3, 4 ].indexOf(a.data.data.err) && (wx.showModal({
                    title: "支付失败",
                    content: a.data.data.message,
                    showCancel: !1
                }), e.setData({
                    disabled: !1
                })), 0 == a.data.data.err && (app.util.request({
                    url: "entry/wxapp/savePrepayid",
                    data: {
                        types: "miaosha",
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
                            mask: !0,
                            duration: 3e3,
                            success: function(a) {
                                e.payover_fxs(t), wx.showToast({
                                    title: "购买成功！",
                                    icon: "success",
                                    mask: !0,
                                    success: function() {
                                        setTimeout(function() {
                                            wx.navigateBack({
                                                delta: 9
                                            }), wx.navigateTo({
                                                url: "/sudu8_page/orderlist_dan/orderlist_dan?type=9"
                                            });
                                        }, 1500);
                                    }
                                });
                            }
                        });
                    },
                    fail: function(a) {
                        wx.redirectTo({
                            url: "/sudu8_page/orderlist_dan/orderlist_dan"
                        });
                    },
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
                types: "miaosha",
                flag: 0,
                formId: this.data.formId
            },
            success: function(a) {
                "失败" == a.data.data.message ? wx.showToast({
                    title: "付款失败, 请刷新后重新付款！",
                    icon: "none",
                    mask: !0,
                    success: function() {
                        setTimeout(function() {
                            wx.navigateBack({
                                delta: 9
                            }), wx.navigateTo({
                                url: "/sudu8_page/order_more_list/order_more_list"
                            });
                        }, 1500);
                    }
                }) : wx.showToast({
                    title: "购买成功！",
                    icon: "success",
                    mask: !0,
                    success: function() {
                        setTimeout(function() {
                            wx.navigateBack({
                                delta: 9
                            }), wx.navigateTo({
                                url: "/sudu8_page/orderlist_dan/orderlist_dan?type=9"
                            });
                        }, 1500), wx.hideLoading();
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
                types: "miaosha"
            },
            success: function(a) {},
            fail: function(a) {}
        });
    },
    refreshSessionkey: function() {
        var t = this;
        wx.login({
            success: function(a) {
                app.util.request({
                    url: "entry/wxapp/getNewSessionkey",
                    data: {
                        code: a.code
                    },
                    success: function(a) {
                        t.setData({
                            newSessionKey: a.data.data
                        });
                    }
                });
            }
        });
    },
    getPhoneNumber1: function(a) {
        var d = this, t = a.detail.iv, e = a.detail.encryptedData;
        "getPhoneNumber:ok" == a.detail.errMsg ? wx.checkSession({
            success: function() {
                app.util.request({
                    url: "entry/wxapp/jiemiNew",
                    data: {
                        newSessionKey: d.data.newSessionKey,
                        iv: t,
                        encryptedData: e
                    },
                    success: function(a) {
                        if (a.data.data) {
                            for (var t = d.data.pagedata, e = 0; e < t.length; e++) 0 == t[e].type && 5 == t[e].tp_text[0].yval && (t[e].val = a.data.data);
                            d.setData({
                                wxmobile: a.data.data,
                                pagedata: t
                            });
                        } else wx.showModal({
                            title: "提示",
                            content: "sessionKey已过期，请下拉刷新！"
                        });
                    },
                    fail: function(a) {}
                });
            },
            fail: function() {
                wx.showModal({
                    title: "提示",
                    content: "sessionKey已过期，请下拉刷新！"
                });
            }
        }) : wx.showModal({
            title: "提示",
            content: "请先授权获取您的手机号！",
            showCancel: !1
        });
    }
});