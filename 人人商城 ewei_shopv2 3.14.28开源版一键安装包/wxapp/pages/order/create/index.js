var t = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(t) {
    return typeof t;
} : function(t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t;
}, e = getApp(), a = e.requirejs("core"), i = e.requirejs("foxui"), r = e.requirejs("biz/diyform"), s = e.requirejs("jquery"), d = e.requirejs("biz/selectdate");

Page({
    data: {
        icons: e.requirejs("icons"),
        list: {},
        goodslist: {},
        data: {
            dispatchtype: 0,
            remark: ""
        },
        areaDetail: {
            detail: {
                realname: "",
                mobile: "",
                areas: "",
                street: "",
                address: ""
            }
        },
        merchid: 0,
        showPicker: !1,
        pvalOld: [ 0, 0, 0 ],
        pval: [ 0, 0, 0 ],
        areas: [],
        street: [],
        streetIndex: 0,
        noArea: !1,
        showaddressview: !1,
        city_express_state: !1,
        currentDate: "",
        dayList: "",
        currentDayList: "",
        currentObj: "",
        currentDay: "",
        cycelbuy_showdate: "",
        receipttime: "",
        scope: "",
        bargainid: "",
        selectcard: ""
    },
    onLoad: function(t) {
        var i = this, r = [];
        if (t.goods) {
            var s = JSON.parse(t.goods);
            t.goods = s, this.setData({
                ispackage: !0
            });
        }
        i.setData({
            options: t
        }), i.setData({
            bargainid: t.bargainid
        }), e.url(t), a.get("order/create", i.data.options, function(t) {
            if (0 == t.error) {
                r = i.getGoodsList(t.goods);
                var s = (i.data.originalprice - t.goodsprice).toFixed(2);
                i.setData({
                    list: t,
                    goods: t,
                    show: !0,
                    address: !0,
                    card_info: t.card_info || {},
                    cardid: t.card_info.cardid || "",
                    cardname: t.card_info.cardname || "",
                    carddiscountprice: t.card_info.carddiscountprice,
                    goodslist: r,
                    merchid: t.merchid,
                    comboprice: s,
                    diyform: {
                        f_data: t.f_data,
                        fields: t.fields
                    },
                    city_express_state: t.city_express_state,
                    cycelbuy_showdate: t.selectDate,
                    receipttime: t.receipttime,
                    iscycel: t.iscycel,
                    scope: t.scope,
                    fromquick: t.fromquick,
                    hasinvoice: t.hasinvoice
                }), e.setCache("goodsInfo", {
                    goodslist: r,
                    merchs: t.merchs
                }, 1800);
            } else a.toast(t.message, "loading"), setTimeout(function() {
                wx.navigateBack();
            }, 1e3);
            if ("" != t.fullbackgoods) {
                if (void 0 == t.fullbackgoods) return;
                var d = t.fullbackgoods.fullbackratio, c = t.fullbackgoods.maxallfullbackallratio, d = Math.round(d), c = Math.round(c);
                i.setData({
                    fullbackratio: d,
                    maxallfullbackallratio: c
                });
            }
            1 == t.iscycel && i.show_cycelbuydate();
        }), this.getQuickAddressDetail(), e.setCache("coupon", ""), setTimeout(function() {
            i.setData({
                areas: e.getCache("cacheset").areas
            });
        }, 3e3);
    },
    show_cycelbuydate: function() {
        var t = this, e = d.getCurrentDayString(this, t.data.cycelbuy_showdate), a = [ "周日", "周一", "周二", "周三", "周四", "周五", "周六" ];
        t.setData({
            currentObj: e,
            currentDate: e.getFullYear() + "." + (e.getMonth() + 1) + "." + e.getDate() + " " + a[e.getDay()],
            currentYear: e.getFullYear(),
            currentMonth: e.getMonth() + 1,
            currentDay: e.getDate(),
            initDate: Date.parse(e.getFullYear() + "/" + (e.getMonth() + 1) + "/" + e.getDate()),
            checkedDate: Date.parse(e.getFullYear() + "/" + (e.getMonth() + 1) + "/" + e.getDate()),
            maxday: t.data.scope
        });
    },
    onShow: function() {
        var i = this, r = e.getCache("orderAddress"), d = e.getCache("orderShop");
        e.getCache("isIpx") ? i.setData({
            isIpx: !0,
            iphonexnavbar: "fui-iphonex-navbar",
            paddingb: "padding-b"
        }) : i.setData({
            isIpx: !1,
            iphonexnavbar: "",
            paddingb: ""
        }), r && (this.setData({
            "list.address": r
        }), i.caculate(i.data.list)), d && this.setData({
            "list.carrierInfo": d,
            "list.storeInfo": d
        });
        var c = e.getCache("coupon");
        "object" == (void 0 === c ? "undefined" : t(c)) && 0 != c.id ? (this.setData({
            "data.couponid": c.id,
            "data.couponname": c.name
        }), a.post("order/create/getcouponprice", {
            couponid: c.id,
            goods: this.data.goodslist,
            goodsprice: this.data.list.goodsprice,
            discountprice: this.data.list.discountprice,
            isdiscountprice: this.data.list.isdiscountprice
        }, function(t) {
            0 == t.error ? (delete t.$goodsarr, i.setData({
                coupon: t
            }), i.caculate(i.data.list)) : a.alert(t.message);
        }, !0)) : (this.setData({
            "data.couponid": 0,
            "data.couponname": null,
            coupon: null
        }), s.isEmptyObject(i.data.list) || i.caculate(i.data.list));
    },
    getGoodsList: function(t) {
        var e = [];
        s.each(t, function(t, a) {
            s.each(a.goods, function(t, a) {
                e.push(a);
            });
        });
        for (var a = 0, i = 0; i < e.length; i++) a += e[i].price;
        return this.setData({
            originalprice: a
        }), e;
    },
    toggle: function(t) {
        var e = a.pdata(t), i = e.id, r = e.type, s = {};
        s[r] = 0 == i || void 0 === i ? 1 : 0, this.setData(s);
    },
    phone: function(t) {
        a.phone(t);
    },
    dispatchtype: function(t) {
        var e = a.data(t).type;
        this.setData({
            "data.dispatchtype": e
        }), this.caculate(this.data.list);
    },
    number: function(t) {
        var e = this, r = a.pdata(t), d = i.number(this, t), c = r.id, o = e.data.list, n = 0, l = 0;
        s.each(o.goods, function(t, e) {
            s.each(e.goods, function(e, a) {
                a.id == c && (o.goods[t].goods[e].total = d), n += parseInt(o.goods[t].goods[e].total), 
                l += parseFloat(n * o.goods[t].goods[e].price);
            });
        }), o.total = n, o.goodsprice = s.toFixed(l, 2), e.setData({
            list: o,
            goodslist: e.getGoodsList(o.goods)
        }), this.caculate(o);
    },
    caculate: function(t) {
        var e = this, i = 0;
        e.data.data && 0 != e.data.data.couponid && (i = e.data.data.couponid), a.post("order/create/caculate", {
            goods: this.data.goodslist,
            dflag: this.data.data.dispatchtype,
            addressid: this.data.list.address ? this.data.list.address.id : 0,
            packageid: this.data.list.packageid,
            bargain_id: this.data.bargainid,
            discountprice: this.data.list.discountprice,
            cardid: this.data.cardid,
            couponid: i
        }, function(a) {
            t.dispatch_price = a.price, t.enoughdeduct = a.deductenough_money, t.enoughmoney = a.deductenough_enough, 
            t.taskdiscountprice = a.taskdiscountprice, t.discountprice = a.discountprice, t.isdiscountprice = a.isdiscountprice, 
            t.seckill_price = a.seckill_price, t.deductcredit2 = a.deductcredit2, t.deductmoney = a.deductmoney, 
            t.deductcredit = a.deductcredit, t.gifts = a.gifts, e.data.data.deduct && (a.realprice -= a.deductmoney), 
            e.data.data.deduct2 && (a.realprice -= a.deductcredit2), e.data.coupon && void 0 !== e.data.coupon.deductprice && (e.setData({
                "coupon.deductprice": a.coupon_deductprice
            }), a.realprice -= a.coupon_deductprice), a.card_info && (t.card_free_dispatch = a.card_free_dispatch), 
            0 == e.data.goods.giftid && e.setData({
                "goods.gifts": a.gifts
            }), t.realprice <= 0 && (t.realprice = 1e-6), t.realprice = s.toFixed(a.realprice, 2), 
            e.setData({
                list: t,
                cardid: a.card_info.cardid,
                cardname: a.card_info.cardname,
                goodsprice: a.card_info.goodsprice ? a.card_info.goodsprice : 0,
                carddiscountprice: a.card_info.carddiscountprice,
                city_express_state: a.city_express_state
            });
        }, !0);
    },
    submit: function() {
        var t = this.data, e = this, i = this.data.diyform, d = t.goods.giftid || t.giftid;
        if (0 == this.data.goods.giftid && 1 == this.data.goods.gifts.length && (d = this.data.goods.gifts[0].id), 
        !t.submit && r.verify(this, i)) {
            t.list.carrierInfo = t.list.carrierInfo || {};
            var c = {
                id: t.options.id ? t.options.id : 0,
                goods: t.goodslist,
                gdid: t.options.gdid,
                dispatchtype: t.data.dispatchtype,
                fromcart: t.list.fromcart,
                carrierid: 1 == t.data.dispatchtype && t.list.carrierInfo ? t.list.carrierInfo.id : 0,
                addressid: t.list.address ? t.list.address.id : 0,
                carriers: 1 == t.data.dispatchtype || t.list.isvirtual || t.list.isverify ? {
                    carrier_realname: t.list.member.realname,
                    carrier_mobile: t.list.member.mobile,
                    realname: t.list.carrierInfo.realname,
                    mobile: t.list.carrierInfo.mobile,
                    storename: t.list.carrierInfo.storename,
                    address: t.list.carrierInfo.address
                } : "",
                remark: t.data.remark,
                deduct: t.data.deduct,
                deduct2: t.data.deduct2,
                couponid: t.data.couponid,
                cardid: t.cardid,
                invoicename: t.list.invoicename,
                submit: !0,
                packageid: t.list.packageid,
                giftid: d,
                diydata: t.diyform.f_data,
                receipttime: t.receipttime,
                bargain_id: e.data.options.bargainid,
                fromquick: t.fromquick
            };
            if (t.list.storeInfo && (c.carrierid = t.list.storeInfo.id), 1 == t.data.dispatchtype || t.list.isvirtual || t.list.isverify) {
                if ("" == s.trim(t.list.member.realname) && "0" == t.list.set_realname) return void a.alert("请填写联系人!");
                if ("" == s.trim(t.list.member.mobile) && "0" == t.list.set_mobile) return void a.alert("请填写联系方式!");
                if (!/^[1][3-9]\d{9}$|^([6|9])\d{7}$|^[0][9]\d{8}$|^[6]([8|6])\d{5}$/.test(s.trim(t.list.member.mobile))) return void a.alert("请填写正确联系电话!");
                if (t.list.isforceverifystore && !t.list.storeInfo) return void a.alert("请选择门店!");
                c.addressid = 0;
            } else if (!c.addressid && !t.list.isonlyverifygoods) return void a.alert("地址没有选择!");
            e.setData({
                submit: !0
            }), a.post("order/create/submit", c, function(t) {
                e.setData({
                    submit: !1
                }), 0 == t.error ? wx.navigateTo({
                    url: "/pages/order/pay/index?id=" + t.orderid
                }) : a.alert(t.message);
            }, !0);
        }
    },
    dataChange: function(t) {
        var e = this.data.data, a = this.data.list;
        switch (t.target.id) {
          case "remark":
            e.remark = t.detail.value;
            break;

          case "deduct":
            if (e.deduct = t.detail.value, e.deduct2) return;
            i = parseFloat(a.realprice);
            i += e.deduct ? -parseFloat(a.deductmoney) : parseFloat(a.deductmoney), a.realprice = i;
            break;

          case "deduct2":
            if (e.deduct2 = t.detail.value, e.deduct) return;
            var i = parseFloat(a.realprice);
            i += e.deduct2 ? -parseFloat(a.deductcredit2) : parseFloat(a.deductcredit2), a.realprice = i;
        }
        a.realprice <= 0 && (a.realprice = 1e-6), a.realprice = s.toFixed(a.realprice, 2), 
        this.setData({
            data: e,
            list: a
        });
    },
    listChange: function(t) {
        var e = this.data.list;
        switch (t.target.id) {
          case "invoicename":
            e.invoicename = t.detail.value;
            break;

          case "realname":
            e.member.realname = t.detail.value;
            break;

          case "mobile":
            e.member.mobile = t.detail.value;
        }
        this.setData({
            list: e
        });
    },
    url: function(t) {
        var e = a.pdata(t).url;
        wx.redirectTo({
            url: e
        });
    },
    onChange: function(t) {
        return r.onChange(this, t);
    },
    DiyFormHandler: function(t) {
        return r.DiyFormHandler(this, t);
    },
    selectArea: function(t) {
        return r.selectArea(this, t);
    },
    bindChange: function(t) {
        return r.bindChange(this, t);
    },
    onCancel: function(t) {
        return r.onCancel(this, t);
    },
    onConfirm: function(t) {
        r.onConfirm(this, t);
        var e = this.data.pval, a = this.data.areas, i = this.data.areaDetail.detail;
        i.province = a[e[0]].name, i.city = a[e[0]].city[e[1]].name, i.datavalue = a[e[0]].code + " " + a[e[0]].city[e[1]].code, 
        a[e[0]].city[e[1]].area && a[e[0]].city[e[1]].area.length > 0 ? (i.area = a[e[0]].city[e[1]].area[e[2]].name, 
        i.datavalue += " " + a[e[0]].city[e[1]].area[e[2]].code, this.getStreet(a, e)) : i.area = "", 
        i.street = "", this.setData({
            "areaDetail.detail": i,
            streetIndex: 0,
            showPicker: !1
        });
    },
    getIndex: function(t, e) {
        return r.getIndex(t, e);
    },
    showaddressview: function(t) {
        var e = "";
        e = "open" == t.target.dataset.type, this.setData({
            showaddressview: e
        });
    },
    onChange2: function(t) {
        var e = this, a = e.data.areaDetail.detail, i = t.currentTarget.dataset.type, r = s.trim(t.detail.value);
        "street" == i && (a.streetdatavalue = e.data.street[r].code, r = e.data.street[r].name), 
        a[i] = r, e.setData({
            "areaDetail.detail": a
        });
    },
    getStreet: function(t, e) {
        if (t && e) {
            var i = this;
            if (i.data.areaDetail.detail.province && i.data.areaDetail.detail.city && this.data.openstreet) {
                var r = t[e[0]].city[e[1]].code, s = t[e[0]].city[e[1]].area[e[2]].code;
                a.get("getstreet", {
                    city: r,
                    area: s
                }, function(t) {
                    var e = t.street, a = {
                        street: e
                    };
                    if (e && i.data.areaDetail.detail.streetdatavalue) for (var r in e) if (e[r].code == i.data.areaDetail.detail.streetdatavalue) {
                        a.streetIndex = r, i.setData({
                            "areaDetail.detail.street": e[r].name
                        });
                        break;
                    }
                    i.setData(a);
                });
            }
        }
    },
    getQuickAddressDetail: function() {
        var t = this, e = t.data.id;
        a.get("member/address/get_detail", {
            id: e
        }, function(e) {
            var a = {
                openstreet: e.openstreet,
                show: !0
            };
            if (!s.isEmptyObject(e.detail)) {
                var i = e.detail.province + " " + e.detail.city + " " + e.detail.area, r = t.getIndex(i, t.data.areas);
                a.pval = r, a.pvalOld = r, a.areaDetail.detail = e.detail;
            }
            t.setData(a), e.openstreet && r && t.getStreet(t.data.areas, r);
        });
    },
    submitaddress: function() {
        var t = this, e = t.data.areaDetail.detail;
        t.data.posting || ("" != e.realname && e.realname ? "" != e.mobile && e.mobile ? "" != e.city && e.city ? !(t.data.street.length > 0) || "" != e.street && e.street ? "" != e.address && e.address ? e.datavalue ? (e.id = 0, 
        t.setData({
            posting: !0
        }), a.post("member/address/submit", e, function(r) {
            if (0 != r.error) return t.setData({
                posting: !1
            }), void i.toast(t, r.message);
            e.id = r.addressid, t.setData({
                showaddressview: !1,
                "list.address": e
            }), a.toast("保存成功");
        })) : i.toast(t, "地址数据出错，请重新选择") : i.toast(t, "请填写详细地址") : i.toast(t, "请选择所在街道") : i.toast(t, "请选择所在地区") : i.toast(t, "请填写联系电话") : i.toast(t, "请填写收件人"));
    },
    giftPicker: function() {
        this.setData({
            active: "active",
            gift: !0
        });
    },
    emptyActive: function() {
        this.setData({
            active: "",
            slider: "out",
            tempname: "",
            showcoupon: !1,
            gift: !1
        });
    },
    radioChange: function(t) {
        this.setData({
            giftid: t.currentTarget.dataset.giftgoodsid,
            gift_title: t.currentTarget.dataset.title
        });
    },
    sendclick: function() {
        wx.navigateTo({
            url: "/pages/map/index"
        });
    },
    clearform: function() {
        var t = this.data.diyform, e = {};
        s.each(t, function(a, i) {
            s.each(i, function(a, i) {
                5 == i.data_type && (t.f_data[i.diy_type].count = 0, t.f_data[i.diy_type].images = [], 
                e[i.diy_type] = t.f_data[i.diy_type]);
            });
        }), t.f_data = e, this.setData({
            diyform: t
        });
    },
    syclecancle: function() {
        this.setData({
            cycledate: !1
        });
    },
    sycleconfirm: function() {
        this.setData({
            cycledate: !1
        });
    },
    editdate: function(t) {
        d.setSchedule(this), this.setData({
            cycledate: !0,
            create: !0
        });
    },
    doDay: function(t) {
        d.doDay(t, this);
    },
    selectDay: function(t) {
        d.selectDay(t, this), d.setSchedule(this);
    },
    showinvoicepicker: function() {
        var t = this.data.list;
        0 == t.invoice_type && (t.invoice_info.entity = !0), 1 == t.invoice_type && (t.invoice_info.entity = !1), 
        this.setData({
            invoicepicker: !0,
            list: t
        });
    },
    noinvoicepicker: function() {
        this.setData({
            invoicepicker: !1
        });
    },
    clearinvoice: function() {
        var t = this.data.list;
        t.invoicename = "", this.setData({
            invoicepicker: !1,
            list: t
        });
    },
    chaninvoice: function(t) {
        var e = this.data.list;
        "0" == t.currentTarget.dataset.type ? e.invoice_info.entity = !1 : e.invoice_info.entity = !0, 
        this.setData({
            list: e
        });
    },
    changeType: function(t) {
        var e = this.data.list;
        "0" == t.currentTarget.dataset.type ? e.invoice_info.company = !1 : e.invoice_info.company = !0, 
        this.setData({
            list: e
        });
    },
    invoicetitle: function(t) {
        var e = this.data.list;
        e.invoice_info.title = t.detail.value.replace(/\s+/g, ""), this.setData({
            list: e
        });
    },
    invoicenumber: function(t) {
        var e = this.data.list;
        e.invoice_info.number = t.detail.value.replace(/\s+/g, ""), this.setData({
            list: e
        });
    },
    confirminvoice: function() {
        var t = this.data.list;
        t.invoice_info.company || this.setData({
            invoicenumber: ""
        });
        var e = t.invoice_info.entity ? "[纸质] " : "[电子] ", a = t.invoice_info.title + " ", r = t.invoice_info.company ? "（单位: " + t.invoice_info.number + "）" : "（个人）";
        t.invoicename = e + a + r, t.invoice_info.title ? t.invoice_info.company && !t.invoice_info.number ? i.toast(this, "请填写税号") : this.setData({
            list: t,
            invoicepicker: !1
        }) : i.toast(this, "请填写发票抬头");
    },
    selectCard: function() {
        this.setData({
            selectcard: "in"
        });
    },
    cancalCard: function() {
        this.setData({
            cardid: ""
        });
    },
    changecard: function(t) {
        var e = this;
        e.data.card_info;
        e.setData({
            selectcard: "",
            cardid: t.currentTarget.dataset.id
        });
        var i = t.currentTarget.dataset.id, r = {
            cardid: i,
            goodsprice: this.data.list.goodsprice,
            dispatch_price: this.data.list.dispatch_price,
            discountprice: this.data.list.discountprice
        };
        a.post("order/create/getcardprice", r, function(t) {
            if ("" != i) if (0 == t.error) {
                var r = {
                    carddiscount_rate: t.carddiscount_rate,
                    carddiscountprice: t.carddiscountprice,
                    cardid: t.cardid,
                    cardname: t.name,
                    dispatch_price: t.dispatch_price,
                    totalprice: t.totalprice,
                    comboprice: 0
                };
                e.setData(r), e.caculate(e.data.list);
            } else a.alert(t.message); else {
                var d = {
                    cardid: "",
                    selectcard: "",
                    cardname: "",
                    carddiscountprice: 0,
                    ispackage: !1
                }, c = (e.data.originalprice - e.data.list.goodsprice).toFixed(2);
                e.data.options.goods && (d.ispackage = !0, d.comboprice = c), e.setData(d), s.isEmptyObject(e.data.list) || e.caculate(e.data.list);
            }
        }, !0);
    },
    closeCardModal: function() {
        this.setData({
            selectcard: ""
        });
    }
});