var t = getApp(), a = t.requirejs("core"), e = t.requirejs("foxui"), i = t.requirejs("jquery");

Page({
    data: {
        id: null,
        posting: !1,
        subtext: "保存地址",
        detail: {
            realname: "",
            mobile: "",
            areas: "",
            street: "",
            address: ""
        },
        showPicker: !1,
        pvalOld: [ 0, 0, 0 ],
        pval: [ 0, 0, 0 ],
        areas: [],
        street: [],
        streetIndex: 0,
        noArea: !1,
        cycelid: ""
    },
    onLoad: function(a) {
        this.setData({
            id: Number(a.orderid),
            cycelid: Number(a.cycelid),
            applyid: Number(a.applyid)
        }), t.url(a), this.getDetail(), a.id || wx.setNavigationBarTitle({
            title: "添加收货地址"
        }), this.setData({
            areas: t.getCache("cacheset").areas,
            type: a.type
        });
    },
    getDetail: function() {
        var t = this, e = t.data.id;
        a.get("order/address", {
            id: e,
            applyid: t.data.applyid,
            cycelid: t.data.cycelid
        }, function(a) {
            var e = {
                openstreet: a.openstreet,
                show: !0
            };
            if (!i.isEmptyObject(a.detail)) {
                wx.setNavigationBarTitle({
                    title: "编辑收货地址"
                });
                var r = a.detail.province + " " + a.detail.city + " " + a.detail.area, s = t.getIndex(r, t.data.areas);
                e.pval = s, e.pvalOld = s, e.detail = a.detail;
            }
            t.setData(e), a.openstreet && s && t.getStreet(t.data.areas, s);
        });
    },
    submit: function() {
        var t = this, i = t.data.detail;
        t.data.posting || ("" != i.realname && i.realname ? "" != i.mobile && i.mobile ? "" != i.city && i.city ? !(t.data.street.length > 0) || "" != i.street && i.street ? "" != i.address && i.address ? i.datavalue ? (i.orderid = t.data.id, 
        i.cycelid = t.data.cycelid, t.setData({
            posting: !0
        }), a.post("order/addressSubmit", i, function(i) {
            if (0 != i.error) return t.setData({
                posting: !1
            }), void e.toast(t, i.message);
            t.setData({
                subtext: "提交成功"
            }), a.toast("提交成功");
        })) : e.toast(t, "地址数据出错，请重新选择") : e.toast(t, "请填写详细地址") : e.toast(t, "请选择所在街道") : e.toast(t, "请选择所在地区") : e.toast(t, "请填写联系电话") : e.toast(t, "请填写收件人"));
    },
    onChange: function(t) {
        var a = this, e = a.data.detail, r = t.currentTarget.dataset.type, s = i.trim(t.detail.value);
        "street" == r && (e.streetdatavalue = a.data.street[s].code, s = a.data.street[s].name), 
        e[r] = s, a.setData({
            detail: e
        });
    },
    getStreet: function(t, e) {
        if (t && e) {
            var i = this;
            if (i.data.detail.province && i.data.detail.city && this.data.openstreet) {
                var r = t[e[0]].city[e[1]].code, s = t[e[0]].city[e[1]].area[e[2]].code;
                a.get("getstreet", {
                    city: r,
                    area: s
                }, function(t) {
                    var a = t.street, e = {
                        street: a
                    };
                    if (a && i.data.detail.streetdatavalue) for (var r in a) if (a[r].code == i.data.detail.streetdatavalue) {
                        e.streetIndex = r, i.setData({
                            "detail.street": a[r].name
                        });
                        break;
                    }
                    i.setData(e);
                });
            }
        }
    },
    selectArea: function(t) {
        var a = t.currentTarget.dataset.area, e = this.getIndex(a, this.data.areas);
        this.setData({
            pval: e,
            pvalOld: e,
            showPicker: !0
        });
    },
    bindChange: function(t) {
        var a = this.data.pvalOld, e = t.detail.value;
        a[0] != e[0] && (e[1] = 0), a[1] != e[1] && (e[2] = 0), this.setData({
            pval: e,
            pvalOld: e
        });
    },
    onCancel: function(t) {
        this.setData({
            showPicker: !1
        });
    },
    onConfirm: function(t) {
        var a = this.data.pval, e = this.data.areas, i = this.data.detail;
        i.province = e[a[0]].name, i.city = e[a[0]].city[a[1]].name, i.datavalue = e[a[0]].code + " " + e[a[0]].city[a[1]].code, 
        e[a[0]].city[a[1]].area && e[a[0]].city[a[1]].area.length > 0 ? (i.area = e[a[0]].city[a[1]].area[a[2]].name, 
        i.datavalue += " " + e[a[0]].city[a[1]].area[a[2]].code, this.getStreet(e, a)) : i.area = "", 
        i.street = "", this.setData({
            detail: i,
            streetIndex: 0,
            showPicker: !1
        });
    },
    getIndex: function(t, a) {
        if ("" == i.trim(t) || !i.isArray(a)) return [ 0, 0, 0 ];
        var e = t.split(" "), r = [ 0, 0, 0 ];
        for (var s in a) if (a[s].name == e[0]) {
            r[0] = Number(s);
            for (var d in a[s].city) if (a[s].city[d].name == e[1]) {
                r[1] = Number(d);
                for (var n in a[s].city[d].area) if (a[s].city[d].area[n].name == e[2]) {
                    r[2] = Number(n);
                    break;
                }
                break;
            }
            break;
        }
        return r;
    },
    updateAll: function(t) {}
});