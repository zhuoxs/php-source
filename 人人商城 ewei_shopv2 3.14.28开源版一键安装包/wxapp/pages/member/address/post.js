var t = getApp(), e = t.requirejs("core"), a = t.requirejs("foxui"), i = t.requirejs("jquery");

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
    onLoad: function(e) {
        this.setData({
            id: Number(e.id)
        }), t.url(e), this.getDetail(), e.id || wx.setNavigationBarTitle({
            title: "添加收货地址"
        }), this.setData({
            areas: t.getCache("cacheset").areas,
            type: e.type
        });
    },
    getDetail: function() {
        var t = this, a = t.data.id;
        e.get("member/address/get_detail", {
            id: a
        }, function(e) {
            var a = {
                openstreet: e.openstreet,
                show: !0
            };
            if (!i.isEmptyObject(e.detail)) {
                wx.setNavigationBarTitle({
                    title: "编辑收货地址"
                });
                var r = e.detail.province + " " + e.detail.city + " " + e.detail.area, s = t.getIndex(r, t.data.areas);
                a.pval = s, a.pvalOld = s, a.detail = e.detail;
            }
            t.setData(a), e.openstreet && s && t.getStreet(t.data.areas, s);
        });
    },
    submit: function() {
        var i = this, r = i.data.detail;
        i.data.posting || ("" != r.realname && r.realname ? "" != r.mobile && r.mobile ? "" != r.city && r.city ? !(i.data.street.length > 0) || "" != r.street && r.street ? "" != r.address && r.address ? r.datavalue ? /^[1][3-9]\d{9}$|^([6|9])\d{7}$|^[0][9]\d{8}$|^[6]([8|6])\d{5}$/.test(r.mobile) ? (r.id = i.data.id, 
        i.setData({
            posting: !0
        }), e.post("member/address/submit", r, function(s) {
            if (0 != s.error) return i.setData({
                posting: !1
            }), void a.toast(i, s.message);
            i.setData({
                subtext: "保存成功"
            }), e.toast("保存成功"), setTimeout(function() {
                r.id = s.addressid, "member" == i.data.type && wx.navigateBack(), "quickaddress" == i.data.type ? (t.setCache("orderAddress", r, 30), 
                wx.navigateBack()) : wx.redirectTo({
                    url: "/pages/member/address/select"
                });
            }, 1e3);
        })) : a.toast(i, "请填写正确联系电话") : a.toast(i, "地址数据出错，请重新选择") : a.toast(i, "请填写详细地址") : a.toast(i, "请选择所在街道") : a.toast(i, "请选择所在地区") : a.toast(i, "请填写联系电话") : a.toast(i, "请填写收件人"));
    },
    onChange: function(t) {
        var e = this, a = e.data.detail, r = t.currentTarget.dataset.type, s = i.trim(t.detail.value);
        "street" == r && (a.streetdatavalue = e.data.street[s].code, s = e.data.street[s].name), 
        a[r] = s, e.setData({
            detail: a
        });
    },
    getStreet: function(t, a) {
        if (t && a) {
            var i = this;
            if (i.data.detail.province && i.data.detail.city && this.data.openstreet) {
                var r = t[a[0]].city[a[1]].code, s = t[a[0]].city[a[1]].area[a[2]].code;
                e.get("getstreet", {
                    city: r,
                    area: s
                }, function(t) {
                    var e = t.street, a = {
                        street: e
                    };
                    if (e && i.data.detail.streetdatavalue) for (var r in e) if (e[r].code == i.data.detail.streetdatavalue) {
                        a.streetIndex = r, i.setData({
                            "detail.street": e[r].name
                        });
                        break;
                    }
                    i.setData(a);
                });
            }
        }
    },
    selectArea: function(t) {
        var e = t.currentTarget.dataset.area, a = this.getIndex(e, this.data.areas);
        this.setData({
            pval: a,
            pvalOld: a,
            showPicker: !0
        });
    },
    bindChange: function(t) {
        var e = this.data.pvalOld, a = t.detail.value;
        e[0] != a[0] && (a[1] = 0), e[1] != a[1] && (a[2] = 0), this.setData({
            pval: a,
            pvalOld: a
        });
    },
    onCancel: function(t) {
        this.setData({
            showPicker: !1
        });
    },
    onConfirm: function(t) {
        var e = this.data.pval, a = this.data.areas, i = this.data.detail;
        i.province = a[e[0]].name, i.city = a[e[0]].city[e[1]].name, i.datavalue = a[e[0]].code + " " + a[e[0]].city[e[1]].code, 
        a[e[0]].city[e[1]].area && a[e[0]].city[e[1]].area.length > 0 ? (i.area = a[e[0]].city[e[1]].area[e[2]].name, 
        i.datavalue += " " + a[e[0]].city[e[1]].area[e[2]].code, this.getStreet(a, e)) : i.area = "", 
        i.street = "", this.setData({
            detail: i,
            streetIndex: 0,
            showPicker: !1
        });
    },
    getIndex: function(t, e) {
        if ("" == i.trim(t) || !i.isArray(e)) return [ 0, 0, 0 ];
        var a = t.split(" "), r = [ 0, 0, 0 ];
        for (var s in e) if (e[s].name == a[0]) {
            r[0] = Number(s);
            for (var d in e[s].city) if (e[s].city[d].name == a[1]) {
                r[1] = Number(d);
                for (var n in e[s].city[d].area) if (e[s].city[d].area[n].name == a[2]) {
                    r[2] = Number(n);
                    break;
                }
                break;
            }
            break;
        }
        return r;
    }
});