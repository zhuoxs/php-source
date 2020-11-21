var a = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(a) {
    return typeof a;
} : function(a) {
    return a && "function" == typeof Symbol && a.constructor === Symbol && a !== Symbol.prototype ? "symbol" : typeof a;
}, e = getApp(), t = e.requirejs("jquery"), r = e.requirejs("core"), i = e.requirejs("foxui");

module.exports = {
    getIndex: function(a, e) {
        if ("" == t.trim(a) || !t.isArray(e)) return [ 0, 0, 0 ];
        var r = a.split(" "), i = [ 0, 0, 0 ];
        for (var n in e) if (e[n].name == r[0]) {
            i[0] = Number(n);
            for (var d in e[n].city) if (e[n].city[d].name == r[1]) {
                i[1] = Number(d);
                for (var f in e[n].city[d].area) if (e[n].city[d].area[f].name == r[2]) {
                    i[2] = Number(f);
                    break;
                }
                break;
            }
            break;
        }
        return i;
    },
    onConfirm: function(a, e) {
        var r = a.data.pval, i = a.data.bindAreaField, n = t.isEmptyObject(a.data.diyform.f_data) ? {} : a.data.diyform.f_data, d = a.data.areas;
        if (n[i] = n[i] || {}, n[i].province = d[r[0]].name, n[i].city = d[r[0]].city[r[1]].name, 
        a.data.areaKey) {
            var f = a.data.areaDetail[a.data.areaKey];
            f.province = d[r[0]].name, f.city = d[r[0]].city[r[1]].name;
        }
        if (a.data.noArea || (n[i].area = d[r[0]].city[r[1]].area[r[2]].name, a.data.areaKey && (f.area = d[r[0]].city[r[1]].area[r[2]].name)), 
        a.setData({
            "diyform.f_data": n,
            showPicker: !1,
            bindAreaField: !1
        }), a.data.areaKey) {
            var o = a.data.areaDetail || {};
            o[a.data.areaKey] = f, a.setData({
                areaDetail: o
            });
        }
    },
    onCancel: function(a, e) {
        a.setData({
            showPicker: !1
        });
    },
    onChange: function(a, e) {
        var i = e.detail.value, n = r.pdata(e).type, d = a.data.postData;
        d[n] = t.trim(i), a.setData({
            postData: d
        });
    },
    bindChange: function(a, e) {
        var t = a.data.pvalOld, r = e.detail.value;
        t[0] != r[0] && (r[1] = 0), t[1] != r[1] && (r[2] = 0), a.setData({
            pval: r,
            pvalOld: r
        });
    },
    selectArea: function(a, e) {
        var t = e.currentTarget.dataset.area, r = e.currentTarget.dataset.field, i = 1 != e.currentTarget.dataset.hasarea, n = a.getIndex(t, a.data.areas), d = e.currentTarget.dataset.areakey, f = {
            pval: n,
            pvalOld: n,
            showPicker: !0,
            noArea: i,
            bindAreaField: r
        };
        d && (f.areaKey = d), a.setData(f);
    },
    DiyFormHandler: function(e, i) {
        var n = i.target.dataset, d = n.type, f = n.field, o = n.datatype, s = e.data.diyform.f_data;
        (t.isArray(s) || "object" != (void 0 === s ? "undefined" : a(s))) && (s = {});
        var m = e.data.diyform.fields;
        if ("input" == d || "textarea" == d || "checkbox" == d || "date" == d || "datestart" == d || "dateend" == d || "time" == d || "timestart" == d || "timeend" == d || "radio" == d) if ("datestart" == d || "timestart" == d) t.isArray(s[f]) || (s[f] = []), 
        s[f][0] = i.detail.value; else if ("dateend" == d || "timeend" == d) t.isArray(s[f]) || (s[f] = []), 
        s[f][1] = i.detail.value; else if ("checkbox" == d) {
            s[f] = {};
            for (var l in i.detail.value) {
                var u = i.detail.value[l];
                s[f][u] = 1;
            }
        } else "radio" == d ? s[f] = i.detail.value : 10 == o ? (t.isEmptyObject(s[f]) && (s[f] = {}), 
        s[f][n.name] = i.detail.value) : s[f] = i.detail.value; else if ("picker" == d) {
            for (var y in s) if (y == f) {
                for (var p in m) if (m[p].diy_type == f) {
                    s[f] = [ i.detail.value, m[p].tp_text[i.detail.value] ];
                    break;
                }
                break;
            }
        } else if ("image" == d) r.upload(function(a) {
            for (var t in s) if (t == f) {
                s[f] || (s[f] = {}), s[f].images || (s[f].images = []), s[f].images.push({
                    url: a.url,
                    filename: a.filename
                });
                break;
            }
            s[f].count = s[f].images.length, e.setData({
                "diyform.f_data": s
            });
        }); else if ("image-remove" == d) {
            for (var y in s) if (y == f) {
                var c = {
                    images: []
                };
                for (var p in s[f].images) s[f].images[p].filename != n.filename && c.images.push(s[f].images[p]);
                c.count = c.images.length, s[f] = c;
                break;
            }
        } else if ("image-preview" == d) for (var y in s) if (y == f) {
            var v = [];
            for (var p in s[f].images) v.push(s[f].images[p].url);
            wx.previewImage({
                current: v[n.index],
                urls: v
            });
            break;
        }
        e.setData({
            "diyform.f_data": s
        });
    },
    verify: function(a, e) {
        for (var r in e.fields) {
            var n = e.fields[r], d = n.diy_type;
            if (1 == n.tp_must) if (5 == n.data_type) {
                if (!e.f_data[d] || e.f_data[d].count < 1) return i.toast(a, "请选择" + n.tp_name), 
                !1;
            } else if (9 == n.data_type) {
                if (t.isEmptyObject(e.f_data[d]) || !e.f_data[d].province || !e.f_data[d].city) return i.toast(a, "请选择" + n.tp_name), 
                !1;
            } else if (10 == n.data_type) {
                if (t.isEmptyObject(e.f_data[d]) || !e.f_data[d].name1) return i.toast(a, "请填写" + n.tp_name), 
                !1;
                if (!e.f_data[d].name2 || "" == e.f_data[d].name2) return i.toast(a, "请填写" + n.tp_name2), 
                !1;
            } else if (11 == n.data_type) {
                if (!e.f_data[d]) return i.toast(a, "请填写" + n.tp_name), !1;
            } else if (3 == n.data_type) {
                if (!e.f_data[d] || "{}" == JSON.stringify(e.f_data[d])) return i.toast(a, "请填写" + n.tp_name), 
                !1;
            } else if (!e.f_data[d]) return i.toast(a, "请填写" + n.tp_name), !1;
            if (6 == n.data_type && !/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/.test(e.f_data[d])) return i.toast(a, "请填写正确的" + n.tp_name), 
            !1;
            if (10 == n.data_type && (t.isEmptyObject(e.f_data[d]) || e.f_data[d].name1 != e.f_data[d].name2)) return i.toast(a, n.tp_name + "与" + n.tp_name2 + "不一致"), 
            !1;
        }
        return !0;
    }
};