var app = getApp();

Page({
    data: {
        detail: null
    },
    onLoad: function(e) {
        this.getRecycleDetail(e.id);
    },
    getRecycleDetail: function(e) {
        var s = this;
        e && app.util.request({
            url: "entry/wxapp/recycle",
            data: {
                m: "superman_hand2",
                act: "detail",
                id: e
            },
            fail: function(e) {
                console.log(e), wx.showModal({
                    title: "系统提示",
                    content: e.data.errmsg + "(" + e.data.errno + ")"
                });
            },
            success: function(e) {
                console.log(e);
                var t = e.data.data.detail;
                if (t.form_fields) {
                    for (var a = 0; a < t.form_fields.length; a++) if ("radio" == t.form_fields[a].type) {
                        for (var l = t.form_fields[a].extra.option, o = [], i = 0; i < l.length; i++) o[i] = new Object(), 
                        o[i].value = l[i], o[i].checked = !1, o[i].value != t.form_fields[a].value || (o[i].checked = !0);
                        t.form_fields[a].extra.option = o;
                    } else if ("checkbox" == t.form_fields[a].type) {
                        for (var r = t.form_fields[a].extra.option, f = t.form_fields[a].value, c = [], n = 0; n < r.length; n++) if (c[n] = new Object(), 
                        c[n].value = r[n], c[n].checked = !1, "string" == typeof f) {
                            if (c[n].value == f) {
                                c[n].checked = !0;
                                continue;
                            }
                        } else for (var d = 0; d < f.length; d++) c[n].value != f[d] || (c[n].checked = !0);
                        t.form_fields[a].extra.option = c;
                    }
                    console.log(t), s.setData({
                        detail: t
                    });
                }
            }
        });
    }
});