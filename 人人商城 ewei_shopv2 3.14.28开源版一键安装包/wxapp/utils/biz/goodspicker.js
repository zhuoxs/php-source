var t = getApp(), a = (t.requirejs("jquery"), t.requirejs("core")), e = t.requirejs("foxui"), o = t.requirejs("biz/diyform");

module.exports = {
    number: function(t, o) {
        var i = a.pdata(t), d = e.number(o, t), s = (i.id, i.optionid, i.min);
        i.max;
        1 == d && 1 == i.value && "minus" == t.target.dataset.action || d < s && "minus" == t.target.dataset.action ? e.toast(o, "单次最少购买" + i.value + "件") : i.value == i.max && "plus" == t.target.dataset.action || (parseInt(o.data.stock) < parseInt(d) ? e.toast(o, "库存不足") : o.setData({
            total: d
        }));
    },
    inputNumber: function(t, a) {
        var o = a.data.goods.maxbuy, i = a.data.goods.minbuy, d = t.detail.value;
        if (d > 0) {
            if (o > 0 && o <= parseInt(t.detail.value) && (d = o, e.toast(a, "单次最多购买" + o + "件")), 
            i > 0 && i > parseInt(t.detail.value) && (d = i, e.toast(a, "单次最少购买" + i + "件")), 
            parseInt(a.data.stock) < parseInt(d)) return void e.toast(a, "库存不足");
        } else d = i > 0 ? i : 1;
        a.setData({
            total: d
        });
    },
    chooseGift: function(t, a) {
        a.setData({
            giftid: t.currentTarget.dataset.id
        });
    },
    buyNow: function(t, i, d) {
        t.currentTarget.dataset.type && (d = t.currentTarget.dataset.type);
        var s = i.data.optionid, r = i.data.goods.hasoption, n = i.data.diyform, g = i.data.giftid;
        if (9 == i.data.goods.type) var l = i.data.checkedDate / 1e3;
        if (r > 0 && !s) e.toast(i, "请选择规格"); else if (n && n.fields.length > 0) {
            if (!o.verify(i, n)) return;
            a.post("order/create/diyform", {
                id: i.data.id,
                diyformdata: n.f_data
            }, function(t) {
                0 == i.data.goods.isgift || "goods_detail" != d ? wx.redirectTo({
                    url: "/pages/order/create/index?id=" + i.data.id + "&total=" + i.data.total + "&optionid=" + s + "&gdid=" + t.gdid + "&selectDate=" + l
                }) : g ? wx.redirectTo({
                    url: "/pages/order/create/index?id=" + i.data.id + "&total=" + i.data.total + "&optionid=" + s + "&gdid=" + t.gdid + "&giftid=" + g
                }) : "" != g ? (i.data.goods.giftinfo && 1 == i.data.goods.giftinfo.length && (g = i.data.goods.giftinfo[0].id), 
                i.data.goods.gifts && 1 == i.data.goods.gifts.length && (g = i.data.goods.gifts[0].id), 
                wx.redirectTo({
                    url: "/pages/order/create/index?id=" + i.data.id + "&total=" + i.data.total + "&optionid=" + s + "&gdid=" + t.gdid + "&giftid=" + g
                })) : e.toast(i, "请选择赠品");
            });
        } else g ? wx.navigateTo({
            url: "/pages/order/create/index?id=" + i.data.id + "&total=" + i.data.total + "&optionid=" + s + "&giftid=" + g
        }) : 0 == i.data.goods.isgift || "goods_detail" != d ? wx.navigateTo({
            url: "/pages/order/create/index?id=" + i.data.id + "&total=" + i.data.total + "&optionid=" + s + "&selectDate=" + l
        }) : "" != g ? (i.data.goods.giftinfo && 1 == i.data.goods.giftinfo.length && (g = i.data.goods.giftinfo[0].id), 
        i.data.goods.gifts && 1 == i.data.goods.gifts.length && (g = i.data.goods.gifts[0].id), 
        wx.navigateTo({
            url: "/pages/order/create/index?id=" + i.data.id + "&total=" + i.data.total + "&optionid=" + s + "&giftid=" + g
        })) : e.toast(i, "请选择赠品");
    },
    getCart: function(t, i) {
        var d = i.data.optionid, s = i.data.goods.hasoption, r = i.data.diyform;
        if (s > 0 && !d) e.toast(i, "请选择规格"); else if (i.data.quickbuy) {
            if (r && r.fields.length > 0) {
                if (!(n = o.verify(i, r))) return;
                i.setData({
                    formdataval: {
                        diyformdata: r.f_data
                    }
                });
            }
            i.addCartquick(d, i.data.total);
        } else if (r && r.fields.length > 0) {
            var n = o.verify(i, r);
            if (!n) return;
            a.post("order/create/diyform", {
                id: i.data.id,
                diyformdata: r.f_data
            }, function(t) {
                a.post("member/cart/add", {
                    id: i.data.id,
                    total: i.data.total,
                    optionid: d,
                    diyformdata: r.f_data
                }, function(t) {
                    0 == t.error ? (i.setData({
                        "goods.carttotal": t.carttotal,
                        active: "",
                        slider: "out",
                        isSelected: !0,
                        tempname: ""
                    }), e.toast(i, "添加成功")) : e.toast(i, t.message);
                });
            });
        } else a.post("member/cart/add", {
            id: i.data.id,
            total: i.data.total,
            optionid: d
        }, function(t) {
            if (0 == t.error) {
                e.toast(i, "添加成功");
                var a = i.data.goods;
                i.setData({
                    "goods.carttotal": t.carttotal,
                    active: "",
                    slider: "out",
                    isSelected: !0,
                    tempname: "",
                    goods: a
                });
            } else e.toast(i, t.message);
        });
    },
    selectpicker: function(o, i, d, s) {
        1 == o.currentTarget.dataset.home && i.setData({
            giftid: ""
        }), t.checkAuth(), i.setData({
            optionid: "",
            specsData: "",
            specsTitle: "",
            "goods.member_discount": ""
        });
        var r = i.data.active, n = o.currentTarget.dataset.id;
        "" == r && i.setData({
            slider: "in",
            show: !0
        }), a.get("goods/get_picker", {
            id: n
        }, function(t) {
            if (t.goods.presellstartstatus || void 0 == t.goods.presellstartstatus || "1" != t.goods.ispresell) if (t.goods.presellendstatus || void 0 == t.goods.presellstartstatus || "1" != t.goods.ispresell) {
                t.goods && t.goods.giftinfo && 1 == t.goods.giftinfo.length && i.setData({
                    giftid: t.goods.giftinfo[0].id
                });
                var a = t.options;
                if ("goodsdetail" == d) if (i.setData({
                    pickerOption: t,
                    canbuy: i.data.goods.canbuy,
                    buyType: o.currentTarget.dataset.buytype,
                    options: a,
                    minpicker: d,
                    "goods.thistime": t.goods.thistime
                }), 0 != t.goods.minbuy && i.data.total < t.goods.minbuy) r = t.goods.minbuy; else r = i.data.total; else if (i.setData({
                    pickerOption: t,
                    goods: t.goods,
                    options: a,
                    minpicker: d
                }), i.setData({
                    optionid: !1,
                    specsData: [],
                    specs: []
                }), 0 != t.goods.minbuy && i.data.total < t.goods.minbuy) r = t.goods.minbuy; else var r = 1;
                t.diyform && i.setData({
                    diyform: {
                        fields: t.diyform.fields,
                        f_data: t.diyform.lastdata
                    }
                }), i.setData({
                    id: n,
                    pagepicker: d,
                    total: r,
                    tempname: "select-picker",
                    active: "active",
                    show: !0,
                    modeltakeout: s
                });
            } else e.toast(i, t.goods.presellstatustitle); else e.toast(i, t.goods.presellstatustitle);
        });
    },
    sortNumber: function(t, a) {
        return t - a;
    },
    specsTap: function(t, a) {
        var o = a.data.specs;
        o[t.target.dataset.idx] = {
            id: t.target.dataset.id,
            title: t.target.dataset.title
        };
        var i = "", d = "", s = [];
        o.forEach(function(t) {
            i += t.title + ";", s.push(t.id);
        });
        var r = s.sort(this.sortNumber);
        d = r.join("_");
        var n = a.data.options;
        "" != t.target.dataset.thumb && a.setData({
            "goods.thumb": t.target.dataset.thumb
        }), n.forEach(function(t) {
            t.specs == d && (a.setData({
                optionid: t.id,
                "goods.total": t.stock,
                "goods.maxprice": t.marketprice,
                "goods.minprice": t.marketprice,
                "goods.marketprice": t.marketprice,
                "goods.member_discount": t.member_discount,
                "goods.seecommission": t.seecommission,
                "goods.presellprice": a.data.goods.ispresell > 0 ? t.presellprice : a.data.goods.presellprice,
                optionCommission: !0
            }), parseInt(t.stock) < parseInt(a.data.total) ? (a.setData({
                canBuy: "库存不足",
                stock: t.stock
            }), e.toast(a, "库存不足")) : a.setData({
                canBuy: "",
                stock: t.stock
            }));
        }), a.setData({
            specsData: o,
            specsTitle: i
        });
    }
};