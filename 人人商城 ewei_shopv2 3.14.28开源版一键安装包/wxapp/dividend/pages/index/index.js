var e = getApp(), t = e.requirejs("/core"), i = e.requirejs("/foxui");

e.requirejs("jquery");

Page({
    data: {
        loading: !1
    },
    onLoad: function(e) {
        this.getlist();
    },
    getlist: function() {
        var e = this;
        t.get("dividend", "", function(t) {
            1 == t.error && (console.error(t.message), i.toast(e, t.message), setTimeout(function() {
                wx.reLaunch({
                    url: "/pages/index/index"
                });
            }, 1e3)), e.setData({
                message: t
            }), t.member || wx.redirectTo({
                url: "/dividend/pages/register/index"
            });
        });
    },
    found: function() {
        var e = this;
        e.setData({
            loading: !0
        }), t.post("dividend/createTeam", "", function(t) {
            0 == t.error && (e.setData({
                loading: !1
            }), i.toast(e, "创建完成"), e.getlist());
        });
    }
});