var t = getApp(),
    a = t.requirejs("core"),
    e = t.requirejs("jquery"),
    i = t.requirejs("foxui");
Page({
    data: {},
    onShow: function() {
        this.getData()
    },
    getData: function() {
        var t = this;
        a.get("changce/merch/apply", {}, function(e) {
            1 == e.canapply ? (e.show = !0, t.setData(e)) : a.alert(e.message)
        }, !1, !0)
    },
    typeChange: function(t) {
        var a = t.detail.value,
            e = this.data.type_array[a].type;
        this.setData({
            applytype: e,
            applyIndex: a
        })
    },
    bankChange: function(t) {
        var a = t.detail.value;
        this.setData({
            bankIndex: a
        })
    },
    inputChange: function(t) {
        var a = this.data.reg,
            i = t.currentTarget.dataset.type,
            s = e.trim(t.detail.value);
        a[i] = s, this.setData({
            reg: a
        })
    },
    submit: function(t) {
        var e = this,
            s = this.data;
        if (s.canapply && !s.isSubmit) {
            if (!s.reg.merchname) return void i.toast(e, "请填写商户名称");
            if (!s.reg.salecate) return void i.toast(e, "请填写主营项目");
            if (!s.reg.realname) return void i.toast(e, "请填写联系人");
            if (!s.reg.mobile) return void i.toast(e, "请填写手机号");
            if (!s.reg.uname) return void i.toast(e, "请填写账号");
            if (!s.reg.upass) return void i.toast(e, "请填写密码");
            a.confirm("确认要提交申请吗？", function() {
                e.setData({
                    isSubmit: !0
                }), a.post("changce/merch/apply", s.reg, function(t) {
                    if (1 != t.status) return i.toast(e, t.result.message), void e.setData({
                        isSubmit: !1
                    });
                    i.toast(e, "申请成功，请等待审核！"), setTimeout(function() {
                        wx.navigateBack()
                    }, 2e3)
                }, !0, !0)
            })
        }
    },
    confirmjoin: function(t) {
        var e = this,
            s = this.data;
        s.isSubmit || (e.setData({
            isSubmit: !0
        }), a.post("changce/merch/confirmjoin", s.reg, function(t) {
            if (1 != t.status) return i.toast(e, t.result.message), void e.setData({
                isSubmit: !1
            });
            i.toast(e, "入驻成功！"), setTimeout(function() {
                wx.navigateBack()
            }, 2e3)
        }, !0, !0))
    }
});