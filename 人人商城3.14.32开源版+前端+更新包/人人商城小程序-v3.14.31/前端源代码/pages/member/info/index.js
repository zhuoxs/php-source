var t = getApp(), e = t.requirejs("core"), a = t.requirejs("foxui"), i = t.requirejs("biz/diyform"), n = t.requirejs("jquery");

Page({
    data: {
        icons: t.requirejs("icons"),
        member: {},
        diyform: {},
        postData: {},
        openbind: !1,
        index: 0,
        submit: !1,
        showPicker: !1,
        pvalOld: [ 0, 0, 0 ],
        pval: [ 0, 0, 0 ],
        areas: [],
        noArea: !0
    },
    onLoad: function(e) {
        t.url(e);
        var a = this;
        setTimeout(function() {
            a.setData({
                areas: t.getCache("cacheset").areas
            });
        }, 1e3);
    },
    onShow: function() {
        this.getInfo();
    },
    getInfo: function() {
        var t = this;
        e.get("member/info", {}, function(e) {
            var a = e.member, i = {
                member: a,
                diyform: e.diyform,
                openbind: e.openbind,
                show: !0
            };
            0 == e.diyform.template_flag && (i.postData = {
                realname: a.realname,
                mobile: a.mobile,
                weixin: a.weixin,
                birthday: a.birthday,
                city: a.city
            }), t.setData(i);
        });
    },
    onChange: function(t) {
        var a = t.detail.value, i = e.pdata(t).type, r = this.data.postData;
        r[i] = n.trim(a), this.setData({
            postData: r
        });
    },
    DiyFormHandler: function(t) {
        return i.DiyFormHandler(this, t);
    },
    submit: function() {
        if (!this.data.submit) {
            var t = this, r = t.data, o = r.diyform;
            if (0 == o.template_flag) {
                if (!r.postData.realname) return void a.toast(t, "请填写姓名");
                if (!n.isMobile(r.postData.mobile) && !r.openbind) return void a.toast(t, "请填写正确手机号码");
            } else if (!i.verify(this, o)) return;
            t.setData({
                submit: !0
            });
            var s = {
                memberdata: r.postData
            };
            o.template_flag && (s.memberdata = o.f_data), e.post("member/info/submit", s, function(e) {
                0 == e.error ? (t.setData({
                    submit: !1
                }), a.toast(t, "修改成功"), setTimeout(function() {
                    wx.navigateBack();
                }, 500)) : a.toast(t, e.message);
            });
        }
    },
    selectArea: function(t) {
        return i.selectArea(this, t);
    },
    bindChange: function(t) {
        return i.bindChange(this, t);
    },
    onCancel: function(t) {
        return i.onCancel(this, t);
    },
    onConfirm: function(t) {
        if (this.data.diyform.template_flag) return i.onConfirm(this, t);
        var e = this.data.pval, a = this.data.areas, n = this.data.postData;
        n.city = a[e[0]].name + " " + a[e[0]].city[e[1]].name, this.setData({
            postData: n,
            showPicker: !1
        });
    },
    getIndex: function(t, e) {
        return i.getIndex(t, e);
    }
});