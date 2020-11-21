var t = getApp(), a = t.requirejs("core"), s = (t.requirejs("icons"), t.requirejs("foxui"));

t.requirejs("wxParse/wxParse"), t.requirejs("jquery");

Page({
    data: {
        status: 0,
        showcode: !1,
        list: {},
        page: 1,
        total: 0,
        more: !0,
        load: !0,
        notgoods: !0
    },
    onLoad: function(t) {
        this.get_list();
    },
    tab: function(t) {
        var a = t.currentTarget.dataset.type;
        this.setData({
            status: a
        }), this.setData({
            page: 1
        }), this.get_list();
    },
    finish: function(t) {
        var e = this, o = t.currentTarget.dataset.logid;
        wx.showModal({
            title: "提示",
            content: "确认已收到货了吗？",
            success: function(t) {
                t.confirm && a.get("creditshop/log/finish", {
                    id: o
                }, function(t) {
                    0 == t.error ? (s.toast(e, "确认收货"), e.onShow()) : s.toast(e, t.message);
                });
            }
        });
    },
    get_list: function(t) {
        var s = this;
        a.post("creditshop/log/getlist", {
            page: s.data.page,
            status: s.data.status
        }, function(a) {
            0 == a.error && (t ? (a.list = s.data.list.concat(a.list), s.setData({
                list: a.list
            })) : s.setData({
                list: a.list
            }), s.setData({
                total: a.total
            })), a.pagesize >= a.next_page && s.setData({
                more: !1
            }), 0 == a.total && s.setData({
                more: !0
            }), t ? (a.list = s.data.datas.concat(a.list), s.setData({
                datas: a.list
            })) : s.setData({
                datas: a.list
            }), s.data.total <= 0 ? s.setData({
                notgoods: !1
            }) : s.setData({
                notgoods: !0
            });
        });
    },
    onReachBottom: function(t) {
        this.setData({
            page: this.data.page + 1,
            load: !1
        }), this.get_list(!0), this.setData({
            load: !0
        });
    }
});