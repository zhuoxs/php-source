var e = getApp(), t = e.requirejs("/core"), a = e.requirejs("/foxui"), i = (e.requirejs("jquery"), 
e.requirejs("biz/diyform"));

Page({
    data: {
        checked: !1,
        msg: {}
    },
    onLoad: function(e) {
        this.getlist();
    },
    onShow: function() {
        this.getlist();
    },
    changeinput: function(e) {
        var t = this, a = e.detail.value, i = e.target.dataset.input, r = t.data.msg;
        r[i] = a, t.setData({
            msg: r
        });
    },
    selected: function(e) {
        var t = 1 != e.currentTarget.dataset.checked;
        this.setData({
            checked: t
        });
    },
    getlist: function() {
        var e = this;
        t.get("dividend/register", "", function(t) {
            1 == t.error && (console.error(t.message), a.toast(e, t.message), setTimeout(function() {
                wx.reLaunch({
                    url: "/pages/index/index"
                });
            }, 1e3)), 82025 == t.error && wx.redirectTo({
                url: "/pages/commission/register/index"
            }), wx.setNavigationBarTitle({
                title: "申请" + t.set.texts.become || "申请成为队长"
            }), 0 == t.error && e.setData({
                message: t,
                diyform: {
                    f_data: t.f_data,
                    fields: t.fields
                }
            });
        });
    },
    opendeal: function() {
        this.setData({
            isdeal: !0
        });
    },
    close: function() {
        this.setData({
            isdeal: !1
        });
    },
    submit: function(e) {
        var r = this, s = r.data.msg, o = r.data.checked, n = e.currentTarget.dataset.open_protocol;
        if (o || 1 != n) {
            if (r.data.message.template_flag) {
                var d = this.data.diyform;
                if (!i.verify(this, d)) return;
                s = {
                    memberdata: this.data.diyform.f_data
                };
            } else {
                if (!s.realname) return void a.toast(r, "请输入姓名");
                if (!s.mobile) return void a.toast(r, "请输入手机号");
            }
            t.post("dividend/register", s, function(e) {
                0 == e.error ? r.getlist() : a.toast(r, e.message);
            });
        }
    },
    DiyFormHandler: function(e) {
        return i.DiyFormHandler(this, e);
    }
});