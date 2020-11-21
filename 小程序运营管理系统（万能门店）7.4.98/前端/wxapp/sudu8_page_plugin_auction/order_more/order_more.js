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
        title: "订单提交",
        yhq_hidden: 0,
        yhq: [ "不使用优惠券", "满100减10", "满200减30", "满500减100" ],
        yhq_i: 0,
        yhq_tishi: 1,
        yhq_u: 0,
        nav: 1,
        jqdjg: "请选择",
        jifen_u: 0,
        yhqid: 0,
        yhdq: 0,
        sfje: 0,
        szmoney: 0,
        dkmoney: 0,
        dkscore: 0,
        mjly: "",
        px: 0,
        yunfei: 0,
        yfjian: 0,
        pd_val: [],
        zf_type: 2
    },
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var t = this;
        wx.setNavigationBarTitle({
            title: "订单提交"
        }), wx.setNavigationBarColor({
            frontColor: "#000000",
            backgroundColor: "#31C489"
        });
        var e = JSON.parse(a.id), d = a.addressid, n = a.orderid;
        t.setData({
            addressid: d,
            orderid: n
        }), t.setData({
            id: e.id
        }), null != this.data.id ? t.getthispagedata(this.data.id) : null != a.addressid ? (t.getthispagedata(this.data.orderid), 
        t.setData({
            id: t.data.orderid
        }), t.getmraddresszd(a.addressid)) : t.getmraddress();
    },
    makePhoneCallC: function(a) {
        var t = a.currentTarget.dataset.tel;
        wx.makePhoneCall({
            phoneNumber: t
        });
    },
    redirectto: function(a) {
        var t = a.currentTarget.dataset.link, e = a.currentTarget.dataset.linktype;
        app.util.redirectto(t, e);
    },
    getinfos: function() {
        var r = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                var t = a.data, e = r.data.addressid, s = r.data.orderid;
                r.setData({
                    openid: t
                }), e ? r.getmraddresszd(e) : r.getmraddress(), null != s && "undefined" != s && app.util.request({
                    url: "entry/wxapp/duoorderinfo",
                    data: {
                        orderid: s
                    },
                    success: function(a) {
                        for (var t = a.data.data.jsondata, e = 0, d = 0; d < t.length; d++) {
                            var n = t[d].num, i = t[d].proinfo.price;
                            e = 1 * e + Math.round(1 * i * (1 * n) * 100) / 100;
                        }
                        r.setData({
                            jsdata: a.data.data.jsondata,
                            jsprice: e,
                            sfje: e,
                            px: 1,
                            orderid: s
                        });
                    }
                });
            }
        });
    },
    getmyinfo: function() {
        var t = this, a = wx.getStorageSync("openid");
        t.data.jsdata, t.data.sfje, t.data.moneyoff;
        app.util.request({
            url: "entry/wxapp/mymoney",
            data: {
                openid: a
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                t.setData({
                    money: parseFloat(a.data.data.money),
                    score: parseFloat(a.data.data.score)
                });
            }
        });
    },
    switchChange: function(a) {
        for (var i = this, t = a.detail.value, e = wx.getStorageSync("openid"), d = i.data.jsdata, s = i.data.sfje, r = 0, n = [], o = 0; o < d.length; o++) {
            var u = {};
            u.num = d[o].num, u.pvid = d[o].pvid, n.push(u);
        }
        if (1 == t) app.util.request({
            url: "entry/wxapp/setgwcscore",
            data: {
                jsdata: JSON.stringify(n),
                openid: e
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                var t = a.data.data;
                r = t.moneycl;
                var e = t.gzmoney, d = t.gzscore;
                s < r && (r = parseInt(s));
                var n = r * d / e;
                s = Math.round(100 * (s - r)) / 100, i.setData({
                    sfje: s,
                    szmoney: r,
                    dkmoney: r,
                    dkscore: n,
                    zf_type: i.data.money >= s ? 0 : 1,
                    zf_money: i.data.money >= s ? s : Math.round(100 * (s - i.data.money)) / 100,
                    jifen_u: 1
                });
            }
        }); else {
            r = i.data.szmoney;
            s = 1 * s + 1 * r, i.setData({
                sfje: s,
                zf_type: i.data.money >= s ? 0 : 1,
                zf_money: i.data.money >= s ? s : Math.round(100 * (s - i.data.money)) / 100,
                szmoney: 0,
                dkmoney: 0,
                dkscore: 0,
                jifen_u: 0
            });
        }
    },
    nav: function(a) {
        var t = this, e = 0, d = t.data.yunfei;
        1 == a.currentTarget.dataset.id ? e -= d : (e = d, t.setData({
            sfje: t.data.sfje + t.data.szmoney,
            szmoney: 0,
            dkmoney: 0,
            dkscore: 0
        }));
        var n = Math.round(100 * (t.data.sfje - e)) / 100;
        t.setData({
            ischecked: !1,
            jifen_u: 0,
            nav: a.currentTarget.dataset.id,
            yfjian: 1 == a.currentTarget.dataset.id ? 0 : d,
            sfje: n,
            zf_type: t.data.money >= n ? 0 : 1,
            zf_money: t.data.money >= n ? n : Math.round(100 * (n - t.data.money)) / 100
        });
    },
    add_address: function() {
        wx.navigateTo({
            url: "/sudu8_page/address/address?shareid=" + this.data.shareid + "&pid=" + this.data.id + "&orderid=" + this.data.id
        });
    },
    yhq_sub: function() {
        var a = this.data.yhq_i;
        this.setData({
            yhq_r: a,
            yhq_hidden: 0,
            yhq_tishi: 0
        });
    },
    yhq_block: function() {
        this.setData({
            yhq_hidden: 1
        });
    },
    yhq_choose: function(a) {
        var t = a.currentTarget.dataset.i;
        this.setData({
            yhq_i: t
        });
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
    getmraddress: function() {
        var e = this, a = wx.getStorageSync("openid"), t = app.util.url("entry/wxapp/getmraddress", {
            m: "sudu8_page"
        });
        wx.request({
            url: t,
            data: {
                openid: a
            },
            success: function(a) {
                var t = a.data.data;
                e.setData({
                    mraddress: t
                });
            }
        });
    },
    getmraddresszd: function(a) {
        var e = this, t = wx.getStorageSync("openid"), d = app.util.url("entry/wxapp/getmraddresszd", {
            m: "sudu8_page"
        });
        wx.request({
            url: d,
            data: {
                openid: t,
                id: a
            },
            success: function(a) {
                var t = a.data.data;
                e.setData({
                    mraddress: t
                });
            }
        });
    },
    qxyh: function() {
        var a, t = this, e = t.data.jqdjg;
        t.data.yhdq;
        "请选择" == e && (e = 0);
        var d = (100 * t.data.sfje + 100 * e) / 100;
        t.hideModal(), t.setData((_defineProperty(a = {
            jqdjg: 0,
            yhqid: 0,
            sfje: d,
            zf_type: t.data.money >= d ? 0 : 1,
            zf_money: t.data.money >= d ? d : Math.round(100 * (d - t.data.money)) / 100
        }, "jqdjg", "请选择"), _defineProperty(a, "yhdq", 0), a));
    },
    getmoney: function(a) {
        var t = this, e = a.currentTarget.id, d = a.currentTarget.dataset.index, n = d.coupon.pay_money, i = t.data.sfje;
        i = 1 * i + 1 * t.data.yhdq;
        var s = t.data.yhqid;
        if (0 == s || d.id != s) if (1 * i - parseFloat(t.data.yunfei) + parseFloat(t.data.yfjian) < 1 * n) wx.showModal({
            title: "提示",
            content: "价格未满" + n + "元，不可使用该优惠券！",
            showCancel: !1
        }); else {
            var r = Math.floor(100 * (1 * i - 1 * e)) / 100;
            r < 0 && (r = 0), t.setData({
                jqdjg: e,
                yhqid: d.id,
                sfje: r,
                zf_type: t.data.money >= r ? 0 : 1,
                zf_money: t.data.money >= r ? r : Math.round(100 * (r - t.data.money)) / 100,
                oldsfje: i,
                yhdq: e
            }), t.hideModal();
        }
    },
    submit: function(a) {
        var e = this, t = a.detail.formId;
        e.setData({
            formId: t
        });
        var d = e.data.mraddress;
        if (!(1 != e.data.nav || null != d && d)) return wx.showModal({
            title: "提示",
            content: "请先选择/设置收货地址！",
            showCancel: !1
        }), !1;
        var n = wx.getStorageSync("openid"), i = e.data.id, s = e.data.order.cost;
        app.util.request({
            url: "entry/wxapp/topaygoods",
            data: {
                openid: n,
                price: s,
                types: "auction",
                gid: i,
                formId: t,
                address: e.data.mraddress.address,
                address_more: e.data.mraddress.more_address,
                phone: e.data.mraddress.mobile,
                other: e.data.mjly
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                "purse" == a.data.message && (wx.showToast({
                    title: "余额支付完成"
                }), e.payisok("okpurse"));
                -1 != [ 1, 2, 3, 4 ].indexOf(a.data.data.err) && wx.showModal({
                    title: "支付失败",
                    content: a.data.data.message,
                    showCancel: !1
                });
                var t = a.data.data.order_id;
                0 == a.data.data.err && (app.util.request({
                    url: "entry/wxapp/savePrepayid",
                    data: {
                        types: "auction",
                        order_id: t,
                        prepayid: a.data.data.package
                    },
                    success: function(a) {}
                }), wx.requestPayment({
                    timeStamp: a.data.data.timeStamp,
                    nonceStr: a.data.data.nonceStr,
                    package: a.data.data.package,
                    signType: "MD5",
                    paySign: a.data.data.paySign,
                    success: function(a) {
                        e.payisok("okwx");
                    },
                    fail: function(a) {
                        wx.showToast({
                            title: "取消支付"
                        });
                    },
                    complete: function(a) {
                        wx.showToast({
                            title: ""
                        });
                    }
                }));
            }
        });
    },
    doshend: function(a) {
        for (var e = this, t = e.data.jsdata, d = [], n = 0; n < t.length; n++) {
            var i = {};
            i.baseinfo = t[n].baseinfo.id, i.proinfo = t[n].proinfo.id, i.num = t[n].num, i.pvid = t[n].pvid, 
            i.one_bili = t[n].one_bili, i.two_bili = t[n].two_bili, i.three_bili = t[n].three_bili, 
            t[n].buy_type ? i.id = 0 : i.id = t[n].id, d.push(i);
        }
        var s = wx.getStorageSync("openid"), r = e.data.yhqid, o = e.data.sfje, u = e.data.nav, c = e.data.yunfei, p = e.data.yfjian, l = e.data.dkscore, f = (e.data.dkmoney, 
        e.data.mraddress), h = e.data.mjly;
        if (c -= p, !(1 != u || null != f && f)) return wx.showModal({
            title: "提示",
            content: "请先选择/设置收货地址！",
            showCancel: !1
        }), !1;
        if (2 == u) ; else f.id;
        if (0 == e.data.px) app.util.request({
            url: "entry/wxapp/createorder",
            header: {
                "content-type": "application/json"
            },
            data: {
                types: "duo",
                openid: s,
                jsdata: JSON.stringify(d),
                couponid: r,
                price: o,
                dkscore: l,
                address: f.id,
                mjly: h,
                nav: u,
                formid: a,
                yunfei: c
            },
            success: function(a) {
                if ("1" == a.data.data.errcode) wx.showModal({
                    title: a.data.data.err,
                    content: "请重新下单",
                    showCancel: !1
                }); else if ("2" == a.data.data.errcode) wx.showModal({
                    title: a.data.data.err,
                    content: a.data.data.title + "还剩:" + a.data.data.kc
                }); else {
                    var t = a.data.data;
                    e.setData({
                        orderid: t
                    }), o <= e.data.money ? e.pay1(t) : e.pay2(t);
                }
            }
        }); else {
            var y = e.data.orderid;
            app.util.request({
                url: "entry/wxapp/duoorderchangegg",
                header: {
                    "content-type": "application/json"
                },
                data: {
                    orderid: y,
                    couponid: r,
                    price: o,
                    dkscore: l,
                    openid: s,
                    address: f.id,
                    mjly: h,
                    nav: u
                },
                success: function(a) {
                    o <= e.data.money ? e.pay1(y) : e.pay2(y);
                }
            });
        }
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
        for (var e = this, t = (e.data.datas, !0), d = e.data.pagedata, n = 0; n < d.length; n++) if (1 == d[n].ismust) if (5 == d[n].type) {
            if ("" == d[n].z_val) return t = !1, wx.showModal({
                title: "提醒",
                content: d[n].name + "为必填项！",
                showCancel: !1
            }), !1;
        } else if ("" == d[n].val) return t = !1, wx.showModal({
            title: "提醒",
            content: d[n].name + "为必填项！",
            showCancel: !1
        }), !1;
        t && app.util.request({
            url: "entry/wxapp/Formval",
            data: {
                id: 0,
                pagedata: JSON.stringify(d),
                types: "showOrder"
            },
            cachetime: "30",
            success: function(a) {
                var t = a.data.data.id;
                wx.showModal({
                    title: "提示",
                    content: a.data.data.con,
                    showCancel: !1,
                    success: function(a) {
                        e.sendMail_form(0, t), e.doshend(t);
                    }
                });
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
        var i = this, t = 0, s = i.data.zhixin, r = a.currentTarget.dataset.index, o = i.data.pagedata, e = o[r].val, d = o[r].tp_text[0];
        e ? t = e.length : (t = 0, e = []);
        var n = d - t, u = app.util.url("entry/wxapp/wxupimg", {
            m: "sudu8_page"
        }), c = i.data.pd_val;
        wx.chooseImage({
            count: n,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                s = !0, i.setData({
                    zhixin: s
                }), wx.showLoading({
                    title: "图片上传中"
                });
                var t = a.tempFilePaths;
                e = e.concat(t), o[r].val = e, i.setData({
                    pagedata: o
                });
                var d = 0, n = t.length;
                !function e() {
                    wx.uploadFile({
                        url: u,
                        filePath: t[d],
                        name: "file",
                        success: function(a) {
                            var t = JSON.parse(a.data);
                            c.push(t), o[r].z_val = c, i.setData({
                                pagedata: o,
                                pd_val: c
                            }), ++d < n ? e() : (s = !1, i.setData({
                                zhixin: s
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
            var i = {};
            i.keys = e.tp_text[n], i.val = 1, d.push(i);
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
        var i = [], s = [], r = new Date();
        for (n = 0; n < 5; n++) {
            var o = new Date(r.getTime() + 24 * n * 3600 * 1e3), u = o.getFullYear(), c = o.getMonth() + 1, p = o.getDate(), l = c + "月" + p + "日", f = u + "-" + c + "-" + p;
            i.push(l), s.push(f);
        }
        this.setData({
            arrs: i,
            fallarrs: s,
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
        var n = this, t = n.data.id, e = n.data.formindex, i = n.data.xx;
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
                for (var t = a.data.data, e = 0; e < t.length; e++) i[t[e]].val = 2;
                var d = 0;
                t.length == i.length && (d = 1), n.setData({
                    xx: i,
                    isover: d
                });
            }
        });
    },
    save: function() {
        var a = this, t = a.data.today, e = a.data.xx, d = a.data.lixuanz;
        if (-1 == d) return wx.showModal({
            title: "提现",
            content: "请选择预约的选项",
            showCancel: !1
        }), !1;
        var n = "已选择" + t + "，" + e[d].keys, i = a.data.pagedata, s = a.data.formindex;
        i[s].val = n, i[s].days = t, i[s].indexkey = s, i[s].xuanx = d, a.setData({
            ttcxs: 0,
            pagedata: i
        });
    },
    quxiao: function() {
        this.setData({
            ttcxs: 0
        });
    },
    weixinadd: function() {
        var s = this;
        wx.chooseAddress({
            success: function(a) {
                for (var t = a.provinceName + " " + a.cityName + " " + a.countyName + " " + a.detailInfo, e = a.userName, d = a.telNumber, n = s.data.pagedata, i = 0; i < n.length; i++) 0 == n[i].type && 2 == n[i].tp_text[0] && (n[i].val = e), 
                0 == n[i].type && 3 == n[i].tp_text[0] && (n[i].val = d), 0 == n[i].type && 4 == n[i].tp_text[0] && (n[i].val = t);
                s.setData({
                    myname: e,
                    mymobile: d,
                    myaddress: t,
                    pagedata: n
                });
            }
        });
    },
    pay1: function(t) {
        var e = this;
        wx.showModal({
            title: "请注意",
            content: "您将使用余额支付" + e.data.sfje + "元",
            success: function(a) {
                a.confirm && (e.payover_do(t), e.payover_fxs(t));
            }
        });
    },
    pay2: function(t) {
        var a = wx.getStorageSync("openid"), e = this.data.sfje;
        app.util.request({
            url: "entry/wxapp/beforepay",
            data: {
                openid: a,
                price: e,
                order_id: t,
                types: "duo",
                formId: this.data.formId
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                -1 != [ 1, 2, 3, 4 ].indexOf(a.data.data.err) && wx.showModal({
                    title: "支付失败",
                    content: a.data.data.message,
                    showCancel: !1
                }), 0 == a.data.data.err && (app.util.request({
                    url: "entry/wxapp/savePrepayid",
                    data: {
                        types: "duo",
                        order_id: t,
                        prepayid: a.data.data.package
                    },
                    success: function(a) {}
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
                            success: function(a) {}
                        });
                    },
                    fail: function(a) {},
                    complete: function(a) {}
                }));
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
                fxsid: e
            },
            success: function(a) {},
            fail: function(a) {}
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
                types: "duo",
                flag: 0,
                formId: this.data.formId
            },
            success: function(a) {
                wx.navigateBack({
                    delta: 9
                }), wx.navigateTo({
                    url: "/sudu8_page/order_more_list/order_more_list"
                });
            }
        });
    },
    getthispagedata: function(a) {
        var t = this, e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/getorderbyid",
            data: {
                vs1: 1,
                openid: e,
                id: a
            },
            success: function(a) {
                t.setData({
                    goods: a.data.data.goods,
                    order: a.data.data.order,
                    myinfo: a.data.data.myinfo
                }), t.data.order.cost < t.data.myinfo.money ? t.setData({
                    zf_type: 0
                }) : t.setData({
                    zf_type: 1
                });
            },
            fail: function(a) {}
        });
    },
    payisok: function(a) {
        var t = this, e = wx.getStorageSync("openid"), d = t.data.id, n = t.data.order.cost;
        app.util.request({
            url: "entry/wxapp/topaygoods",
            data: {
                vs1: 1,
                openid: e,
                gid: d,
                cc: a,
                price: n,
                address: t.data.mraddress.address,
                address_more: t.data.mraddress.more_address,
                phone: t.data.mraddress.mobile
            },
            success: function(a) {
                wx.showToast({
                    title: "支付完成!"
                }), wx.redirectTo({
                    url: "/sudu8_page_plugin_auction/record/record"
                });
            },
            fail: function(a) {}
        });
    }
});