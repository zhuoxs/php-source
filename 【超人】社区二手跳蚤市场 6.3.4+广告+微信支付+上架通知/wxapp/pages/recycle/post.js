var app = getApp(), Toptips = require("../../libs/zanui/toptips/index");

Page({
    data: {
        region: [],
        form_field: []
    },
    onLoad: function() {
        this.getRecycleForm();
    },
    bindRegionChange: function(e) {
        this.setData({
            region: e.detail.value
        });
    },
    getRecycleForm: function() {
        var n = this;
        app.util.request({
            url: "entry/wxapp/recycle",
            data: {
                m: "superman_hand2",
                act: "form"
            },
            fail: function(e) {
                console.log(e), wx.showModal({
                    title: "系统提示",
                    content: e.data.errmsg + "(" + e.data.errno + ")"
                });
            },
            success: function(e) {
                console.log(e), e.data.data.region.length && n.setData({
                    region: e.data.data.region
                });
                var t = e.data.data.form_fields || [];
                if (t) {
                    for (var a = 0; a < t.length; a++) if ("radio" == t[a].type || "checkbox" == t[a].type) {
                        for (var i = t[a].extra.option, o = [], r = 0; r < i.length; r++) o[r] = new Object(), 
                        o[r].value = i[r], o[r].checked = !1;
                        t[a].extra.option = o;
                    } else "single_select" == t[a].type && (t[a].extra.value = "");
                    n.setData({
                        form_field: t
                    });
                }
            }
        });
    },
    radioChange: function(e) {
        for (var t = this.data.form_field, a = t[e.currentTarget.dataset.index].extra.option, i = 0; i < a.length; i++) a[i].value == e.detail.value ? a[i].checked = !0 : a[i].checked = !1;
        this.setData({
            form_field: t
        });
    },
    checkboxChange: function(e) {
        for (var t = this.data.form_field, a = t[e.currentTarget.dataset.index].extra.option, i = e.detail.value, o = 0; o < a.length; o++) {
            a[o].checked = !1;
            for (var r = 0; r < i.length; r++) if (a[o].value == i[r]) {
                a[o].checked = !0;
                break;
            }
        }
        this.setData({
            form_field: t
        });
    },
    bindPickChange: function(e) {
        var t = this.data.form_field, a = e.currentTarget.dataset.index, i = t[a].extra.option, o = e.detail.value;
        t[a].extra.value = i[o], this.setData({
            form_field: t
        });
    },
    submitPost: function(e) {
        var t = e.detail.value.contact, a = e.detail.value.mobile, i = this.data.region, o = e.detail.value.address, r = e.detail.formId;
        if ("" != t) if ("" != a) if (i.length) if ("" != o) {
            app.util.request({
                url: "entry/wxapp/notice",
                cachetime: "0",
                data: {
                    act: "formid",
                    formid: r,
                    m: "superman_hand2"
                },
                success: function(e) {
                    0 == e.data.errno ? console.log("formid已添加") : console.log(e.data.errmsg);
                },
                fail: function(e) {
                    console.log(e.data.errmsg);
                }
            });
            var n = this.getFormFields(e);
            app.util.request({
                url: "entry/wxapp/recycle",
                data: {
                    m: "superman_hand2",
                    act: "post",
                    fields: app.util.base64Encode(JSON.stringify(n)),
                    contact: t,
                    mobile: a,
                    province: i[0],
                    city: i[1],
                    district: i[2],
                    address: o
                },
                fail: function(e) {
                    console.log(e), wx.showModal({
                        title: "系统提示",
                        content: e.data.errmsg + "(" + e.data.errno + ")"
                    });
                },
                success: function(e) {
                    console.log(e), wx.showToast({
                        icon: "success",
                        title: "提交成功",
                        duration: 2e3,
                        success: function() {
                            setTimeout(function() {
                                wx.redirectTo({
                                    url: "../home/index"
                                });
                            }, 2e3);
                        }
                    });
                }
            });
        } else Toptips("请输入详细地址"); else Toptips("请选择地区"); else Toptips("请输入手机号"); else Toptips("请输入联系人");
    },
    getFormFields: function(e) {
        for (var t = [], a = e.detail.value, i = this.data.form_field, o = 0; o < i.length; o++) if (1 == i[o].required && "" == a[o]) return void Toptips("请输入" + i[o].title);
        for (var r in a) {
            var n = encodeURIComponent(a[r]);
            t.push(n);
        }
        return t;
    }
});