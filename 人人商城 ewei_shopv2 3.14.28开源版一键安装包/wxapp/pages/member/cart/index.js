var t = getApp(), e = t.requirejs("core"), i = t.requirejs("foxui"), a = t.requirejs("jquery");

Page({
    data: {
        route: "cart",
        icons: t.requirejs("icons"),
        merch_list: !1,
        list: !1,
        edit_list: [],
        modelShow: !1
    },
    onLoad: function(i) {
        t.checkAuth();
        var a = this;
        e.get("black", {}, function(t) {
            t.isblack && wx.showModal({
                title: "无法访问",
                content: "您在商城的黑名单中，无权访问！",
                success: function(t) {
                    t.confirm && a.close(), t.cancel && a.close();
                }
            });
        }), t.url(i);
    },
    onShow: function() {
        this.get_cart();
        var e = this;
        e.setData({
            imgUrl: t.globalData.approot
        }), wx.getSetting({
            success: function(t) {
                var i = t.authSetting["scope.userInfo"];
                e.setData({
                    limits: i
                });
            }
        });
    },
    get_cart: function() {
        var t, i = this;
        e.get("member/cart/get_cart", {}, function(e) {
            t = {
                show: !0,
                ismerch: !1,
                ischeckall: e.ischeckall,
                total: e.total,
                cartcount: e.total,
                totalprice: e.totalprice,
                empty: e.empty || !1,
                sysset: e.sysset
            }, void 0 === e.merch_list ? (t.list = e.list || [], i.setData(t)) : (t.merch_list = e.merch_list || [], 
            t.ismerch = !0, i.setData(t));
        });
    },
    edit: function(t) {
        if ((c = this).data.limits) {
            var s, c = this;
            switch (e.data(t).action) {
              case "edit":
                this.setData({
                    edit: !0
                });
                break;

              case "complete":
                this.allgoods(!1), this.setData({
                    edit: !1
                });
                break;

              case "move":
                s = this.checked_allgoods().data, a.isEmptyObject(s) || e.post("member/cart/tofavorite", {
                    ids: s
                }, function(t) {
                    c.get_cart();
                });
                break;

              case "delete":
                s = this.checked_allgoods().data, a.isEmptyObject(s) || e.confirm("是否确认删除该商品?", function() {
                    e.post("member/cart/remove", {
                        ids: s
                    }, function(t) {
                        c.get_cart();
                    });
                });
                break;

              case "pay":
                this.data.total > 0 && e.get("member/cart/submit", {}, function(t) {
                    if (0 != t.error) return i.toast(c, t.message), void c.get_cart();
                    wx.navigateTo({
                        url: "/pages/order/create/index"
                    });
                });
            }
        }
    },
    checkall: function(t) {
        e.loading();
        var i = this, a = this.data.ischeckall ? 0 : 1;
        e.post("member/cart/select", {
            id: "all",
            select: a
        }, function(t) {
            i.get_cart(), e.hideLoading();
        });
    },
    update: function(t) {
        var i = this, a = this.data.ischeckall ? 0 : 1;
        e.post("member/cart/select", {
            id: "all",
            select: a
        }, function(t) {
            i.get_cart();
        });
    },
    number: function(t) {
        var a = this, s = e.pdata(t), c = i.number(this, t), o = s.id, r = s.optionid;
        1 == c && 1 == s.value && "minus" == t.target.dataset.action || s.value == s.max && "plus" == t.target.dataset.action || e.post("member/cart/update", {
            id: o,
            optionid: r,
            total: c
        }, function(t) {
            a.get_cart();
        });
    },
    selected: function(t) {
        e.loading();
        var i = this, a = e.pdata(t), s = a.id, c = 1 == a.select ? 0 : 1;
        e.post("member/cart/select", {
            id: s,
            select: c
        }, function(t) {
            i.get_cart(), e.hideLoading();
        });
    },
    allgoods: function(t) {
        var e = this.data.edit_list;
        if (!a.isEmptyObject(e) && void 0 === t) return e;
        if (t = void 0 !== t && t, this.data.ismerch) for (var i in this.data.merch_list) for (var s in this.data.merch_list[i].list) e[this.data.merch_list[i].list[s].id] = t; else for (var i in this.data.list) e[this.data.list[i].id] = t;
        return e;
    },
    checked_allgoods: function() {
        var t = this.allgoods(), e = [], i = 0;
        for (var a in t) t[a] && (e.push(a), i++);
        return {
            data: e,
            cartcount: i
        };
    },
    editcheckall: function(t) {
        var i = e.pdata(t).check, a = this.allgoods(!i);
        this.setData({
            edit_list: a,
            editcheckall: !i
        }), this.editischecked();
    },
    editischecked: function() {
        var t = !1, e = !0, i = this.allgoods();
        for (var a in this.data.edit_list) if (this.data.edit_list[a]) {
            t = !0;
            break;
        }
        for (var s in i) if (!i[s]) {
            e = !1;
            break;
        }
        this.setData({
            editischecked: t,
            editcheckall: e
        });
    },
    edit_list: function(t) {
        var i = e.pdata(t), a = this.data.edit_list;
        void 0 !== a[i.id] && 1 == a[i.id] ? a[i.id] = !1 : a[i.id] = !0, this.setData({
            edit_list: a
        }), this.editischecked();
    },
    url: function(t) {
        var i = e.pdata(t);
        wx.navigateTo({
            url: i.url
        });
    },
    onShareAppMessage: function() {
        return e.onShareAppMessage();
    },
    cancelclick: function() {
        this.setData({
            modelShow: !1
        }), wx.switchTab({
            url: "/pages/index/index"
        });
    },
    confirmclick: function() {
        this.setData({
            modelShow: !1
        }), wx.openSetting({
            success: function(t) {}
        });
    },
    close: function() {
        t.globalDataClose.flag = !0, wx.reLaunch({
            url: "/pages/index/index"
        });
    }
});