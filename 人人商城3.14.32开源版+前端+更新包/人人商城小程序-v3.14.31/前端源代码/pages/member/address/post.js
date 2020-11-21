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
        noArea: !1
    },
    onLoad: function(a) {
        a.params && this.setData({
            detail: JSON.parse(a.params)
        }), this.setData({
            id: Number(a.id)
        }), this.setData({
            areas: t.getCache("cacheset").areas,
            type: a.type
        }), t.url(a), this.getDetail(), a.id || wx.setNavigationBarTitle({
            title: "添加收货地址"
        });
    },
    getDetail: function() {
        var t = this, e = t.data.id;
        a.get("member/address/get_detail", {
            id: e
        }, function(a) {
            var e = {
                openstreet: a.openstreet,
                show: !0
            };
            if (i.isEmptyObject(a.detail)) {
                if (t.data.detail) {
                    console.log(t.data.detail);
                    var r = t.data.detail.province + " " + t.data.detail.city + " " + t.data.detail.area, s = t.getIndex(r, t.data.areas);
                    e.pval = s, e.pvalOld = s;
                }
            } else {
                wx.setNavigationBarTitle({
                    title: "编辑收货地址"
                });
                var r = a.detail.province + " " + a.detail.city + " " + a.detail.area, s = t.getIndex(r, t.data.areas);
                e.pval = s, e.pvalOld = s, e.detail = a.detail;
            }
            console.log(s), t.setData(e), a.openstreet && s && t.getStreet(t.data.areas, s);
        });
    },
    submit: function() {
        var i = this, r = i.data.detail;
        i.data.posting || ("" != r.realname && r.realname ? "" != r.mobile && r.mobile ? "" != r.city && r.city ? !(i.data.street.length > 0) || "" != r.street && r.street ? "" != r.address && r.address ? (console.log(r), 
        r.is_from_wx && i.onConfirm("is_from_wx"), console.log(r), r.datavalue ? /^[1][3-9]\d{9}$|^([6|9])\d{7}$|^[0][9]\d{8}$|^[6]([8|6])\d{5}$/.test(r.mobile) ? (r.id = i.data.id || "", 
        i.setData({
            posting: !0
        }), a.post("member/address/submit", r, function(s) {
            if (0 != s.error) return i.setData({
                posting: !1
            }), void e.toast(i, s.message);
            i.setData({
                subtext: "保存成功"
            }), a.toast("保存成功"), setTimeout(function() {
                r.id = s.addressid, console.log(i.data.type), console.log("member" == i.data.type), 
                "member" != i.data.type ? "quickaddress" == i.data.type ? (t.setCache("orderAddress", r, 30), 
                wx.navigateBack()) : wx.navigateTo({
                    url: "/pages/member/address/select"
                }) : wx.navigateBack();
            }, 1e3);
        })) : e.toast(i, "请填写正确联系电话") : e.toast(i, "地址数据出错，请重新选择")) : e.toast(i, "请填写详细地址") : e.toast(i, "请选择所在街道") : e.toast(i, "请选择所在地区") : e.toast(i, "请填写联系电话") : e.toast(i, "请填写收件人"));
    },
    onChange: function(t) {
        var a = this, e = a.data.detail, r = t.currentTarget.dataset.type, s = i.trim(t.detail.value);
        "street" == r && (e.streetdatavalue = a.data.street[s].code, s = a.data.street[s].name), 
        e[r] = s, a.setData({
            detail: e
        });
    },
    getStreet: function(t, e) {
        if (console.log(t, e), t && e) {
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
        "is_from_wx" != t && (i.street = ""), this.setData({
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
                for (var o in a[s].city[d].area) if (a[s].city[d].area[o].name == e[2]) {
                    r[2] = Number(o);
                    break;
                }
                break;
            }
            break;
        }
        return r;
    }
});