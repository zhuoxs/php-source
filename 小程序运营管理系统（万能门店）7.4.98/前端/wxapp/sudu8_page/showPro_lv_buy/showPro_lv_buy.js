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
        couponlist: [],
        picList: [],
        datas: "",
        comment: "",
        jhsl: 1,
        dprice: "",
        yhje: 0,
        hjjg: "",
        sfje: 0,
        order: "",
        pro_name: "",
        pro_tel: "",
        pro_address: "",
        pro_txt: "",
        my_num: "",
        xg_num: "",
        shengyu: "",
        userInfo: "",
        chuydate: "选择日期",
        chuytime: "选择时间",
        num: [],
        duogg: [],
        xz_num: [],
        couponprice: 0,
        jqdjg: "请选择",
        yhqid: "0",
        oldsfje: "",
        pagedata: {},
        imgcount_xz: 0,
        pagedata_set: [],
        zhixin: !1,
        xuanz: 0,
        lixuanz: -1,
        ttcxs: 0,
        chooseNum: 0,
        myscore: 0,
        jifen_u: 2,
        zf_money: 0,
        dkmoney: 0,
        type: "",
        testKey: "",
        testKeys: "",
        order_id: "",
        discounts: 0,
        sw: !1
    },
    onPullDownRefresh: function() {
        this.refreshSessionkey(), this.getinfos(), wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var t = this;
        t.refreshSessionkey();
        var e = a.id;
        null != a.testPrice && t.setData({
            testPrice: a.testPrice
        }), null != a.testKey && t.setData({
            testKey: a.testKey
        }), null != a.testKeys && t.setData({
            testKeys: a.testKeys
        }), t.setData({
            id: e,
            order_id: a.order_id
        }), "table" == a.type && t.setData({
            type: a.type,
            NowSelectStr: a.NowSelectStr,
            appoint_date: a.appoint_date
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
                var t = e.data.id;
                e.getShowPic(t);
            }
        });
    },
    getShowPic: function(a) {
        var x = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/mycoupon",
            data: {
                openid: t,
                flag: 0
            },
            success: function(a) {
                x.setData({
                    couponlist: a.data.data
                });
            },
            fail: function(a) {}
        }), app.util.request({
            url: "entry/wxapp/showPro",
            data: {
                id: a,
                openid: t
            },
            success: function(a) {
                var t = a.data.data.userinfo.grade, e = a.data.data.discount_status;
                if (0 < t && 0 < e) {
                    var n = a.data.data.discount;
                    if (2 == e) {
                        if (0 < n.length) for (var d = 0; d < n.length; d++) if (t == n[d].grade) {
                            var s = n[d].discount;
                            break;
                        }
                    } else s = n;
                } else s = 0;
                var o = a.data.data.userinfo.money, i = a.data.data.userinfo.score;
                a.data.data.price;
                if ("table" != x.data.type) {
                    var r = x.data.yhje;
                    if (0 == a.data.data.pro_xz) u = 1; else var u = a.data.data.pro_xz - a.data.data.my_num;
                    var c = a.data.data.more_type_x, l = [], p = {}, f = 0;
                    for (d = 0; d < c.length; d++) p[d] = 0, l.push(p), f += 0 * c[d][1];
                    if (x.setData({
                        bg: a.data.data.text[0],
                        picList: a.data.data.text,
                        title: a.data.data.title,
                        datas: a.data.data,
                        duogg: c,
                        hjjg: f,
                        zf_money: f,
                        dprice: f,
                        sfje: f - r,
                        myscore: i,
                        mymoney: o,
                        xz_num: a.data.data.more_type_num,
                        num: l,
                        xg_num: a.data.data.pro_xz,
                        shengyu: a.data.data.pro_kc,
                        xg_buy: u,
                        pagedata: a.data.data.forms,
                        formdescs: a.data.data.formdescs,
                        discounts: s
                    }), "" != x.data.testKey && x.jia(), 1 == x.data.testKeys && 0 < c.length) for (d = 0; d < c.length; d++) x.setData({
                        testPrice: c[d][1],
                        testKey: d
                    }), x.jia();
                } else {
                    r = x.data.yhje;
                    var h, y, g = x.data.NowSelectStr.split(","), m = g.length;
                    for (d = 0; d < m; d++) h = g[d].split("a"), y = a.data.data.table.rowstr[h[0] - 1] + "，", 
                    y += a.data.data.table.columnstr[h[1] - 1], g[d] = y;
                    x.setData({
                        myscore: i,
                        mymoney: o,
                        select_arr: g,
                        bg: a.data.data.text[0],
                        title: a.data.data.title,
                        datas: a.data.data,
                        hjjg: a.data.data.price * m,
                        zf_money: a.data.data.price * m,
                        dprice: a.data.data.price,
                        select_num: m,
                        sfje: Math.floor(100 * (a.data.data.price * m - r)) / 100,
                        pagedata: a.data.data.forms,
                        formdescs: a.data.data.formdescs,
                        discounts: s
                    });
                }
                wx.setNavigationBarTitle({
                    title: x.data.title
                }), wx.setStorageSync("isShowLoading", !1), wx.hideNavigationBarLoading(), wx.stopPullDownRefresh(), 
                app.util.request({
                    url: "entry/wxapp/getmoneyoff",
                    success: function(a) {
                        for (var t = a.data.data.moneyoff, e = "", n = 0; n < t.length; n++) n == t.length - 1 ? e += "满" + t[n].reach + "减" + t[n].del : e += "满" + t[n].reach + "减" + t[n].del + "，";
                        x.data.sfje;
                        x.setData({
                            moneyoff: t,
                            moneyoffstr: t ? e : ""
                        }), x.getmyinfo();
                    }
                });
            }
        });
    },
    getmyinfo: function() {
        var a = this, t = (wx.getStorageSync("openid"), a.data.moneyoff), e = a.data.hjjg, n = a.data.discounts;
        if (0 < n && 0 < e && (e = (e = e * n / 10) < .01 ? .01 : e.toFixed(2)), t) for (var d = t.length - 1; 0 <= d; d--) if (e >= parseFloat(t[d].reach)) {
            e -= parseFloat(t[d].del);
            break;
        }
        a.setData({
            sfje: e,
            zf_type: parseFloat(a.data.mymoney) >= e ? 0 : 1,
            zf_money: parseFloat(a.data.mymoney) >= e ? e : Math.round(100 * (e - a.data.mymoney)) / 100
        });
    },
    jian: function(a) {
        var t = this, e = (t.data.yhje, a.currentTarget.dataset.testid), n = a.currentTarget.dataset.testkey, d = t.data.num[n][n], s = (t.data.duogg, 
        t.data.sfje), o = t.data.oldsfje, i = t.data.hjjg;
        if (--d < 0) d = 0; else {
            var r = Math.round(100 * o - 100 * e * d + 100 * e * (d - 1)) / 100;
            o = i = s = r;
            var u = t.data.num;
            u[n][n] = d;
            var c = t.data.chooseNum - 1;
            t.setData({
                num: u,
                sfje: s,
                hjjg: i,
                jqdjg: "请选择",
                oldsfje: o,
                yhqid: 0,
                chooseNum: c,
                ischecked: !1,
                dkscore: 0,
                dkmoney: 0,
                jifen_u: 2
            }), t.getmyinfo();
        }
    },
    jia: function(a) {
        var t = this;
        t.data.yhje;
        if (null == a) {
            if ("" !== (n = t.data.testKey)) var e = t.data.testPrice;
        } else {
            e = a.currentTarget.dataset.testid;
            var n = a.currentTarget.dataset.testkey;
        }
        var d = t.data.num[n][n], s = (t.data.duogg, t.data.sfje, t.data.oldsfje), o = t.data.hjjg;
        if (t.data.xz_num[n].shennum < ++d) return d--, wx.showModal({
            title: "提醒",
            content: "库存量不足！",
            showCancel: !1
        }), !1;
        var i = Math.round(100 * e * d + 100 * s - 100 * e * (d - 1)) / 100;
        o = s = i;
        var r = t.data.num;
        t.data.datas;
        r[n][n] = d;
        var u = t.data.chooseNum + 1;
        t.setData({
            num: r,
            hjjg: o,
            jqdjg: "请选择",
            oldsfje: s,
            yhqid: 0,
            chooseNum: u,
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
    submit: function(a) {
        var e = this, t = e.data.jhsl, n = e.data.shengyu, d = e.data.type, s = a.detail.formId;
        if (e.setData({
            formId: s
        }), n < t && -1 != n && "table" != d) return t--, wx.showModal({
            title: "提醒",
            content: "库存量不足！",
            showCancel: !1
        }), !1;
        var o = e.data.sfje, i = wx.getStorageSync("openid"), r = (e.data.duogg, e.data.num), u = e.data.chuydate, c = e.data.chuytime, l = (e.data.yhje, 
        e.data.id), p = e.data.order, f = e.data.pro_name, h = e.data.pro_tel, y = e.data.pro_address, g = e.data.pro_txt, m = (e.data.id, 
        e.data.yhqid), x = !0, w = e.data.hjjg;
        if (0 == ("table" == d ? e.data.select_num : e.data.chooseNum)) return x = !1, wx.showModal({
            title: "提醒",
            content: "您至少要选择1个产品或服务",
            showCancel: !1
        }), !1;
        if (!f && 2 == e.data.datas.pro_flag) return x = !1, wx.showModal({
            title: "提醒",
            content: "姓名为必填！",
            showCancel: !1
        }), !1;
        if (!h && 2 == e.data.datas.pro_flag_tel) return x = !1, wx.showModal({
            title: "提醒",
            content: "手机号为必填！",
            showCancel: !1
        }), !1;
        if (!/^(((13[0-9]{1})|(14[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1})|(19[0-9]{1}))+\d{8})$/.test(h) && 2 == e.data.datas.pro_flag_tel) return wx.showModal({
            title: "提醒",
            content: "请输入有效的手机号码！",
            showCancel: !1
        }), !1;
        if (!y && 2 == e.data.datas.pro_flag_add) return x = !1, wx.showModal({
            title: "提醒",
            content: "地址为必填！",
            showCancel: !1
        }), !1;
        if (0 == e.data.datas.tableis) {
            if ("选择日期" == u && 2 == e.data.datas.pro_flag_data) return x = !1, wx.showModal({
                title: "提醒",
                content: "请选择日期！",
                showCancel: !1
            }), !1;
            if ("选择时间" == c && 2 == e.data.datas.pro_flag_time) return x = !1, wx.showModal({
                title: "提醒",
                content: "请选择时间！",
                showCancel: !1
            }), !1;
        }
        for (var v = e.data.pagedata, _ = 0; _ < v.length; _++) if (1 == v[_].ismust) if (5 == v[_].type) {
            if ("" == v[_].z_val) return x = !1, wx.showModal({
                title: "提醒",
                content: v[_].name + "为必填项！",
                showCancel: !1
            }), !1;
        } else if ("" == v[_].val) return x = !1, wx.showModal({
            title: "提醒",
            content: v[_].name + "为必填项！",
            showCancel: !1
        }), !1;
        e.formSubmits(), x && app.util.request({
            url: "entry/wxapp/createorder",
            data: {
                types: "yuyue",
                openid: i,
                num: JSON.stringify(r[0]),
                id: l,
                hjjg: w,
                zhifu: o,
                zf_money: e.data.zf_money,
                zf_type: e.data.zf_type,
                order: p,
                pro_name: f,
                pro_tel: h,
                pro_address: y,
                pro_txt: g,
                chuydate: u,
                chuytime: c,
                yhqid: m,
                type: "table" == e.data.type ? "table" : "",
                NowSelectStr: e.data.NowSelectStr,
                appoint_date: e.data.appoint_date,
                dkscore: e.data.dkscore,
                dkmoney: e.data.dkmoney,
                pagedata: JSON.stringify(v),
                fid: e.data.datas.formset,
                discounts: e.data.discounts
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(a) {
                if ("1" == a.data.data.errcode) wx.showModal({
                    title: a.data.data.err,
                    content: "请重新下单",
                    showCancel: !1
                }); else if ("3" == a.data.data.errcode) wx.showModal({
                    title: a.data.data.err,
                    content: "当前库存为" + a.data.data.kc + "件",
                    showCancel: !1
                }); else {
                    var t = a.data.data;
                    e.setData({
                        orderid: t
                    }), parseFloat(o) <= parseFloat(e.data.mymoney) ? e.pay1(t) : e.pay2(t);
                }
            }
        });
    },
    formSubmits: function(a) {
        for (var e = this, n = e.data.id, t = e.data.pagedata, d = 0; d < t.length; d++) if (1 == t[d].ismust) if (5 == t[d].type) {
            if ("" == t[d].z_val) return goto = !1, wx.showModal({
                title: "提醒",
                content: t[d].name + "为必填项！",
                showCancel: !1
            }), !1;
        } else if ("" == t[d].val) return goto = !1, wx.showModal({
            title: "提醒",
            content: t[d].name + "为必填项！",
            showCancel: !1
        }), !1;
        app.util.request({
            url: "entry/wxapp/Formval",
            data: {
                id: n,
                pagedata: JSON.stringify(t),
                types: "showPro_lv_buy",
                fid: e.data.datas.formset
            },
            success: function(a) {
                var t = a.data.data.id;
                e.sendMail_form(n, t);
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
        var t = this, e = a.currentTarget.id, n = a.currentTarget.dataset.index, d = n.coupon.pay_money, s = t.data.hjjg;
        if (1 * s < 1 * d) wx.showModal({
            title: "提示",
            content: "价格未满" + d + "元，不可使用该优惠券！",
            showCancel: !1
        }); else {
            var o = (100 * t.data.sfje - 100 * parseFloat(e) + 100 * t.data.dkmoney) / 100;
            t.setData({
                ischecked: !1
            }), t.switchChange({
                detail: {
                    value: !1
                }
            });
            var i = parseFloat(o.toPrecision(12));
            i < 0 && (i = 0), t.setData({
                jqdjg: e,
                yhqid: n.id,
                sfje: i,
                oldsfje: s,
                zf_type: parseFloat(t.data.mymoney) >= parseFloat(i) ? 0 : 1,
                zf_money: parseFloat(t.data.mymoney) >= parseFloat(i) ? parseFloat(i) : Math.round(100 * (parseFloat(i) - parseFloat(t.data.mymoney))) / 100
            });
        }
        t.hideModal();
    },
    qxyh: function() {
        var a = this.data.jqdjg;
        "请选择" == a && (a = 0);
        var t = this.data.sfje, e = Math.round(100 * t + 100 * a) / 100;
        this.hideModal(), this.setData(_defineProperty({
            jqdjg: 0,
            yhqid: 0,
            sfje: e
        }, "jqdjg", "请选择"));
    },
    showModal: function() {
        var a = this, t = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = t).translateY(300).step(), this.setData({
            animationData: t.export(),
            showModalStatus: !0
        }), setTimeout(function() {
            t.translateY(0).step(), this.setData({
                animationData: t.export()
            });
        }.bind(this), 200);
        var e = a.data.jqdjg;
        if (0 < e) {
            var n = (100 * parseFloat(a.data.sfje) + 100 * parseFloat(e)) / 100;
            a.setData({
                jqdjg: 0,
                sfje: n,
                zf_type: a.data.mymoney >= n ? 0 : 1,
                zf_money: a.data.mymoney >= n ? n : Math.round(100 * (n - a.data.mymoney)) / 100
            });
        }
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
    choiceimg1111: function(a) {
        var s = this, t = 0, o = s.data.zhixin, i = a.currentTarget.dataset.index, r = s.data.pagedata, e = r[i].val, n = r[i].tp_text[0];
        e ? t = e.length : (t = 0, e = []);
        var d = n - t, u = app.util.url("entry/wxapp/wxupimg", {
            m: "sudu8_page"
        }), c = r[i].z_val ? r[i].z_val : [];
        wx.chooseImage({
            count: d,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                o = !0, s.setData({
                    zhixin: o
                }), wx.showLoading({
                    title: "图片上传中"
                });
                var t = a.tempFilePaths, n = 0, d = t.length;
                !function e() {
                    wx.uploadFile({
                        url: u,
                        filePath: t[n],
                        name: "file",
                        success: function(a) {
                            var t = JSON.parse(a.data);
                            c.push(t), r[i].z_val = c, s.setData({
                                pagedata: r
                            }), ++n < d ? e() : (o = !1, s.setData({
                                zhixin: o
                            }), wx.hideLoading());
                        }
                    });
                }();
            }
        });
    },
    delimg: function(a) {
        var t = a.currentTarget.dataset.index, e = a.currentTarget.dataset.id, n = this.data.pagedata, d = n[t].z_val;
        d.splice(e, 1), 0 == d.length && (d = ""), n[t].z_val = d, this.setData({
            pagedata: n
        });
    },
    namexz: function(a) {
        for (var t = a.currentTarget.dataset.index, e = this.data.pagedata[t], n = [], d = 0; d < e.tp_text.length; d++) {
            var s = {};
            s.keys = e.tp_text[d], s.val = 1, n.push(s);
        }
        this.setData({
            ttcxs: 1,
            formindex: t,
            xx: n,
            xuanz: 0,
            lixuanz: -1
        }), this.riqi();
    },
    riqi: function() {
        for (var a = new Date(), t = new Date(a.getTime()), e = t.getFullYear() + "-" + (t.getMonth() + 1) + "-" + t.getDate(), n = this.data.xx, d = 0; d < n.length; d++) n[d].val = 1;
        this.setData({
            xx: n
        }), this.gettoday(e);
        var s = [], o = [], i = new Date();
        for (d = 0; d < 5; d++) {
            var r = new Date(i.getTime() + 24 * d * 3600 * 1e3), u = r.getFullYear(), c = r.getMonth() + 1, l = r.getDate(), p = c + "月" + l + "日", f = u + "-" + c + "-" + l;
            s.push(p), o.push(f);
        }
        this.setData({
            arrs: s,
            fallarrs: o,
            today: e
        });
    },
    xuanzd: function(a) {
        for (var t = a.currentTarget.dataset.index, e = this.data.fallarrs[t], n = this.data.xx, d = 0; d < n.length; d++) n[d].val = 1;
        this.setData({
            xuanz: t,
            today: e,
            lixuanz: -1,
            xx: n
        }), this.gettoday(e);
    },
    goux: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData({
            lixuanz: t
        });
    },
    gettoday: function(a) {
        var d = this, t = d.data.id, e = d.data.formindex, s = d.data.xx;
        app.util.request({
            url: "entry/wxapp/Duzhan",
            data: {
                id: t,
                types: "showPro_lv_buy",
                days: a,
                pagedatekey: e
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                for (var t = a.data.data, e = 0; e < t.length; e++) s[t[e]].val = 2;
                var n = 0;
                t.length == s.length && (n = 1), d.setData({
                    xx: s,
                    isover: n
                });
            }
        });
    },
    save_nb: function() {
        var a = this, t = a.data.today, e = a.data.xx, n = a.data.lixuanz;
        if (-1 == n) return wx.showModal({
            title: "提现",
            content: "请选择预约的选项",
            showCancel: !1
        }), !1;
        var d = "已选择" + t + "，" + e[n].keys.yval, s = a.data.pagedata, o = a.data.formindex;
        s[o].val = d, s[o].days = t, s[o].indexkey = o, s[o].xuanx = n, a.setData({
            ttcxs: 0,
            pagedata: s
        });
    },
    quxiao: function() {
        this.setData({
            ttcxs: 0
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
        var n = this, t = a.detail.iv, e = a.detail.encryptedData;
        "getPhoneNumber:ok" == a.detail.errMsg ? wx.checkSession({
            success: function() {
                app.util.request({
                    url: "entry/wxapp/jiemiNew",
                    data: {
                        newSessionKey: n.data.newSessionKey,
                        iv: t,
                        encryptedData: e
                    },
                    success: function(a) {
                        if (a.data.data) {
                            for (var t = n.data.pagedata, e = 0; e < t.length; e++) 0 == t[e].type && 5 == t[e].tp_text[0].yval && (t[e].val = a.data.data);
                            n.setData({
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
    },
    weixinadd: function() {
        var o = this;
        wx.chooseAddress({
            success: function(a) {
                for (var t = a.provinceName + " " + a.cityName + " " + a.countyName + " " + a.detailInfo, e = a.userName, n = a.telNumber, d = o.data.pagedata, s = 0; s < d.length; s++) 0 == d[s].type && 2 == d[s].tp_text[0].yval && (d[s].val = e), 
                0 == d[s].type && 3 == d[s].tp_text[0].yval && (d[s].val = n), 0 == d[s].type && 4 == d[s].tp_text[0].yval && (d[s].val = t);
                o.setData({
                    myname: e,
                    mymobile: n,
                    myaddress: t,
                    pagedata: d
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
    switchChange: function(a) {
        var s = this, t = a.detail.value, e = wx.getStorageSync("openid"), o = s.data.sfje, n = s.data.sw, i = 0, d = "table" == s.data.type ? s.data.select_num : s.data.chooseNum;
        if (1 == t && 0 == n) app.util.request({
            url: "entry/wxapp/scoreDeduction",
            data: {
                id: s.data.id,
                num: d,
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
                if (o < i && (i = parseInt(o)), 0 == i) var d = 0; else d = i * n / e;
                o = Math.round(100 * (o - i)) / 100, s.setData({
                    sw: !0,
                    sfje: o,
                    dkmoney: i,
                    dkscore: d,
                    jifen_u: 1,
                    zf_type: s.data.mymoney >= o ? 0 : 1,
                    zf_money: s.data.mymoney >= o ? o : Math.round(100 * (o - s.data.mymoney)) / 100
                });
            }
        }); else {
            var r = s.data.zf_money;
            i = s.data.dkmoney;
            r = Math.round(100 * r + 100 * i) / 100, o = r, s.setData({
                sw: !1,
                dkmoney: 0,
                dkscore: 0,
                jifen_u: 0,
                zf_money: r,
                sfje: o
            });
        }
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
                }), setTimeout(function() {
                    wx.hideLoading();
                }, 3e3)) : wx.redirectTo({
                    url: "/sudu8_page/order/order"
                });
            },
            fail: function(a) {
                wx.redirectTo({
                    url: "/sudu8_page/order/order"
                });
            }
        });
    },
    pay2: function(t) {
        var e = this, a = wx.getStorageSync("openid"), n = e.data.sfje, d = e.data.zf_money, s = e.data.hjjg;
        app.util.request({
            url: "entry/wxapp/beforepay",
            data: {
                openid: a,
                price: s,
                pay_price: d,
                true_price: n,
                order_id: t,
                types: "yuyue",
                formId: e.data.formId
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
                            mask: !0,
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
                                                url: "/sudu8_page/order/order"
                                            });
                                        }, 1500);
                                    }
                                });
                            }
                        });
                    },
                    fail: function(a) {
                        wx.navigateTo({
                            url: "/sudu8_page/order/order"
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
                types: "yuyue",
                flag: 0,
                formId: this.data.formId
            },
            success: function(a) {
                wx.showToast({
                    title: "购买成功！",
                    icon: "success",
                    mask: !0,
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
    }
});