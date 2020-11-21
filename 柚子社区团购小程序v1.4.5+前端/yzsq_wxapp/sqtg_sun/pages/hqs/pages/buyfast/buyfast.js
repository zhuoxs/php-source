var app = getApp(), posCount = 0;

Page({
    data: {
        spindex: 0,
        activeIndex: 0,
        hadchoice: !1,
        carGray: !0,
        carYel: !1,
        posImg: !1,
        carNum: 0,
        cart: {
            num: 0,
            amount: 0,
            goodses: {}
        },
        jioncar: !0
    },
    onLoad: function(a) {
        var t = this;
        t.loadData(), wx.getSystemInfo({
            success: function(a) {
                t.setData({
                    winWid: a.windowWidth,
                    winHei: a.windowHeight
                });
            }
        });
    },
    onShow: function() {
        this.clearCar();
        for (var a = this, t = (a.data.user_id, a.data.goods || []), s = 0; s < t.length; s++) for (var e = 0; e < t[s].fastgoodses.length; e++) t[s].fastgoodses[e].carNum = 0;
        a.setData({
            cart: {
                num: 0,
                amount: 0,
                goodses: {}
            },
            hadchoice: !1,
            goods: t,
            carGray: !0,
            carYel: !1
        });
    },
    clearCar: function() {
        var a = this.data.user_id;
        app.ajax({
            url: "Ccart|emptyCart",
            data: {
                user_id: a,
                type: 2
            },
            success: function(a) {}
        });
    },
    loadData: function() {
        var a = wx.getStorageSync("userInfo");
        a.id ? (this.setData({
            user_id: a.id
        }), this.getList()) : wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(a) {
                if (a.confirm) {
                    var t = encodeURIComponent("/sqtg_sun/pages/hqs/pages/buyfast/buyfast");
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + t);
                } else a.cancel && app.reTo("/sqtg_sun/pages/home/index/index");
            }
        });
    },
    getList: function() {
        var d = this;
        app.ajax({
            url: "Cgoods|getFastGoodses",
            success: function(a) {
                if (0 == a.code) {
                    for (var t = a.data, s = {}, e = {}, r = 0; r < t.length; r++) {
                        s = t[r];
                        for (var o = 0; o < s.fastgoodses.length; o++) (e = s.fastgoodses[o]).carNum = 0, 
                        t[r].fastgoodses[o] = e;
                    }
                    d.setData({
                        goods: t,
                        img_root: a.other.img_root,
                        show: !0
                    });
                }
            }
        });
    },
    addList: function(a) {
        var e = this, r = e.data.goods, o = a.detail.x, d = a.detail.y, i = a.currentTarget.dataset.imgsrc, c = a.currentTarget.dataset.index, n = a.currentTarget.dataset.sindex, t = e.data.user_id, u = r[c].fastgoodses[n];
        app.ajax({
            url: "Ccart|setCart",
            data: {
                user_id: t,
                type: 2,
                gid: u.id,
                num: 1,
                attr_ids: 0
            },
            success: function(a) {
                app.Func.func.Beziercurve(e, o, d, posCount), r[c].fastgoodses[n].carNum = ++r[c].fastgoodses[n].carNum;
                var t = e.data.cart, s = "id_" + u.id;
                t.goodses[s] = {
                    name: u.name,
                    price: u.price,
                    num: u.carNum,
                    attr: 0,
                    cart_id: a.data.cart_id,
                    oindex: c,
                    sindex: n
                }, t.num++, t.amount = parseFloat(t.amount - 0 + (u.price - 0)).toFixed(2), e.setData({
                    carGray: !1,
                    carYel: !0,
                    goods: r,
                    posimg: i,
                    cart: t,
                    oindex: c,
                    sindex: n
                });
            }
        });
    },
    inaddList: function(a) {
        var s = this, e = s.data.goods, r = a.currentTarget.dataset.index, o = a.currentTarget.dataset.oindex, d = a.currentTarget.dataset.sindex, t = s.data.user_id, i = e[o].fastgoodses[d], c = (s.data.popcar, 
        s.data.cart), n = (i.id, c.goodses[r].attr);
        Array.isArray(n) || (n = []), app.ajax({
            url: "Ccart|setCart",
            data: {
                user_id: t,
                type: 2,
                gid: i.id,
                num: 1,
                attr_ids: "," + n.join(",") + ","
            },
            success: function(a) {
                if (e[o].fastgoodses[d].carNum = ++c.goodses[r].num, n.length) var t = "id_" + i.id + "," + n.join(",") + ","; else t = "id_" + i.id;
                c.goodses[t] = c.goodses[t] || {}, c.goodses[t].name = i.name, c.goodses[t].price = c.goodses[t].price, 
                c.goodses[t].num = c.goodses[r].num, c.goodses[t].attr = n, c.goodses[t].cart_id = a.data.cart_id, 
                c.goodses[t].oindex = o, c.goodses[t].sindex = d, c.num++, c.amount = parseFloat(c.amount - 0 + (c.goodses[t].price - 0)).toFixed(2), 
                s.setData({
                    carGray: !1,
                    carYel: !0,
                    goods: e,
                    cart: c,
                    oindex: o,
                    sindex: d
                });
            }
        });
    },
    minusList: function(a) {
        var r = this, o = r.data.goods, d = a.currentTarget.dataset.index, i = a.currentTarget.dataset.sindex, c = o[d].fastgoodses[i], t = (r.data.cart, 
        r.data.user_id);
        app.ajax({
            url: "Ccart|setCart",
            data: {
                user_id: t,
                type: 2,
                gid: c.id,
                num: -1,
                attr_ids: 0
            },
            success: function(a) {
                var t = r.data.cart, s = "id_" + c.id, e = o[d].fastgoodses[i].carNum;
                e <= 0 || (o[d].fastgoodses[i].carNum = --e, t.num--, t.amount = parseFloat(t.amount - 0 - (c.price - 0)).toFixed(2), 
                c.carNum ? t.goodses[s].num = c.carNum : delete t.goodses[s], e <= 0 ? r.setData({
                    goods: o,
                    cart: t,
                    oindex: d,
                    sindex: i
                }) : r.setData({
                    goods: o,
                    cart: t
                }), r.data.cart.num < 1 ? r.setData({
                    carGray: !0,
                    carYel: !1
                }) : r.setData({
                    carGray: !1,
                    carYel: !0
                }));
            }
        });
    },
    inminusList: function(a) {
        var e = this, r = e.data.goods, o = a.currentTarget.dataset.index, d = a.currentTarget.dataset.oindex, i = a.currentTarget.dataset.sindex, t = e.data.user_id, c = r[d].fastgoodses[i], n = e.data.cart, u = (c.id, 
        n.goodses[o].attr);
        Array.isArray(u) || (u = []), app.ajax({
            url: "Ccart|setCart",
            data: {
                user_id: t,
                type: 2,
                gid: c.id,
                num: -1,
                attr_ids: "," + u.join(",") + ","
            },
            success: function(a) {
                if (u.length) var t = "id_" + c.id + "," + u.join(",") + ","; else t = "id_" + c.id;
                var s = n.goodses[o].num;
                r[d].fastgoodses[i].carNum = --s, n.num--, n.amount = parseFloat(n.amount - 0 - (n.goodses[t].price - 0)).toFixed(2), 
                s ? n.goodses[t].num = s : delete n.goodses[t], s <= 0 ? e.setData({
                    goods: r,
                    minus: !1,
                    minusGray: !0,
                    cart: n,
                    oindex: d,
                    sindex: i
                }) : e.setData({
                    goods: r,
                    cart: n
                }), e.data.cart.num < 1 ? e.setData({
                    carGray: !0,
                    carYel: !1
                }) : e.setData({
                    carGray: !1,
                    carYel: !0
                });
            }
        });
    },
    jumpTo: function(a) {
        var t = a.currentTarget.dataset.index, s = a.currentTarget.dataset.opt;
        this.setData({
            toView: s,
            activeIndex: t
        });
    },
    choiceRule: function(a) {
        var t = this.data.goods, s = this.data.gprice, e = (this.data.popcar, a.currentTarget.dataset.index), r = a.currentTarget.dataset.sindex, o = t[e].fastgoodses[r];
        o.oindex = e, o.sindex = r, o.jioncar = !s, this.setData({
            popcar: o,
            gprice: o.checkedPrice || o.price,
            showModalStatus: !0
        });
    },
    spTap: function(a) {
        var t = this, s = a.currentTarget.dataset.index, e = a.currentTarget.dataset.groupindex, r = t.data.popcar;
        r.attr_group_list[e].check_index = s;
        var o = r.id, d = (r.attr_group_list[e].attr_list[s].id, r.checkedAttrs || []);
        d[e] = r.attr_group_list[e].attr_list[s].id, r.checkedAttrs = d;
        var i = r.checkedAttrsTxt || [];
        i[e] = r.attr_group_list[e].attr_list[s].name, r.checkedAttrsTxt = i, app.ajax({
            url: "Cgoods|getGoodsAttrInfo",
            data: {
                gid: o,
                attr_ids: "," + d.join(",") + ","
            },
            success: function(a) {
                a.data && (r.checkedPrice = a.data.price, t.setData({
                    gprice: a.data.price
                }));
            }
        });
        var c = t.data.cart, n = "id_" + r.id + "," + d.join(",") + ",";
        r.carNum = c.goodses[n] ? c.goodses[n].num : 0, t.setData({
            popcar: r
        });
    },
    jioncar: function(a) {
        var e = this, r = e.data.gprice, o = (e.data.jioncar, e.data.popcar), d = o.oindex, i = o.sindex, t = e.data.user_id, c = e.data.goods, n = c[d].fastgoodses[i], u = o.checkedAttrs, g = o.checkedAttrsTxt;
        app.ajax({
            url: "Ccart|setCart",
            data: {
                user_id: t,
                gid: o.id,
                num: 1,
                type: 2,
                attr_ids: "," + u.join(",") + ","
            },
            success: function(a) {
                o.carNum = c[d].fastgoodses[i].carNum = ++c[d].fastgoodses[i].carNum;
                var t = e.data.cart, s = "id_" + n.id + "," + u.join(",") + ",";
                t.goodses[s] = {
                    name: n.name,
                    price: r,
                    num: n.carNum,
                    attr: Object.assign([], u),
                    checkedAttrsTxt: Object.assign([], g),
                    cart_id: a.data.cart_id,
                    oindex: d,
                    sindex: i
                }, t.num++, t.amount = parseFloat(t.amount - 0 + (r - 0)).toFixed(2), o.jioncar = !1, 
                e.setData({
                    carGray: !1,
                    carYel: !0,
                    goods: c,
                    cart: t,
                    popcar: o,
                    oindex: d,
                    sindex: i
                });
            }
        });
    },
    popminus: function(a) {
        var e = this, r = e.data.gprice, o = (e.data.jioncar, e.data.popcar), d = o.oindex, i = o.sindex, t = e.data.user_id, c = e.data.goods, n = c[d].fastgoodses[i], u = o.checkedAttrs, g = o.checkedAttrsTxt;
        app.ajax({
            url: "Ccart|setCart",
            data: {
                user_id: t,
                gid: o.id,
                num: -1,
                type: 2,
                attr_ids: "," + u.join(",") + ","
            },
            success: function(a) {
                o.carNum = c[d].fastgoodses[i].carNum = --c[d].fastgoodses[i].carNum;
                var t = e.data.cart, s = "id_" + n.id + "," + u.join(",") + ",";
                t.goodses[s] = {
                    name: n.name,
                    price: r,
                    num: n.carNum,
                    attr: u,
                    checkedAttrsTxt: Object.assign([], g),
                    cart_id: a.data.cart_id,
                    oindex: d,
                    sindex: i
                }, t.num--, t.amount = parseFloat(t.amount - 0 - (r - 0)).toFixed(2), n.carNum ? t.goodses[s].num = n.carNum : delete t.goodses[s], 
                e.setData({
                    carGray: !1,
                    carYel: !0,
                    goods: c,
                    cart: t,
                    popcar: o,
                    oindex: d,
                    sindex: i,
                    jioncar: !1
                });
            }
        });
    },
    close: function(a) {
        a.currentTarget.dataset.statu;
        this.setData({
            showModalStatus: !1
        });
    },
    carImg: function(a) {
        this.setData({
            hadchoice: !this.data.hadchoice
        });
    },
    emptyCart: function() {
        var e = this, a = e.data.user_id, r = e.data.goods;
        app.ajax({
            url: "Ccart|emptyCart",
            data: {
                user_id: a,
                type: 2
            },
            success: function(a) {
                for (var t = 0; t < r.length; t++) for (var s = 0; s < r[t].fastgoodses.length; s++) r[t].fastgoodses[s].carNum = 0;
                e.setData({
                    cart: {
                        num: 0,
                        amount: 0,
                        goodses: {}
                    },
                    goods: r,
                    hadchoice: !1,
                    carGray: !0,
                    carYel: !1
                });
            }
        });
    },
    toOrder: function(a) {
        var t = this.data.goods, s = this.data.oindex, e = this.data.sindex, r = (t[s].fastgoodses[e], 
        "");
        for (var o in this.data.cart.goodses) r += this.data.cart.goodses[o].cart_id + ",";
        "" != this.data.gid ? app.navTo("/sqtg_sun/pages/hqs/pages/classifyorder/classifyorder?type=2&cartsid=" + r) : wx.showToast({
            title: "请选择商品",
            icon: "none"
        });
    }
});