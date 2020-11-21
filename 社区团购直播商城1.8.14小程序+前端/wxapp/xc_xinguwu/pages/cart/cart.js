var app = getApp();

Page({
    data: {
        carts: [],
        hasList: "",
        totalPrice: 0,
        selectAllStatus: !1,
        totalNum: 0,
        edit_hidden: !1
    },
    onShow: function() {
        var n = this, o = wx.getStorageSync("cars") || [];
        console.log(o);
        var e = [];
        0 < o.length ? (o.forEach(function(t, a) {
            e.push(t.id);
        }), wx.showLoading({
            title: "加载中"
        }), app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !1,
            method: "POST",
            data: {
                op: "cars",
                ids: e
            },
            success: function(t) {
                var a = t.data;
                if (a.data.list) {
                    var e = JSON.parse(JSON.stringify(a.data.list));
                    console.log("nnnnnn");
                    for (var s = [], i = 0, r = o.length; i < r; i++) app.look.istrue(e[o[i].id]) && e[o[i].id].attrs[o[i].attr] ? s.push({
                        status: 1,
                        num: o[i].num,
                        stock: e[o[i].id].attrs[o[i].attr].stock,
                        attr: o[i].attr,
                        price: e[o[i].id].attrs[o[i].attr].price,
                        id: o[i].id,
                        bimg: e[o[i].id].bimg,
                        name: e[o[i].id].name,
                        weight: e[o[i].id].weight,
                        vprice: e[o[i].id].vprice
                    }) : (console.log("-1111"), o[i].del = -1);
                    n.setData({
                        hasList: !0,
                        carts: s
                    });
                    for (i = o.length - 1; 0 <= i; i--) -1 == o[i].del && o.splice(i, 1);
                    wx.setStorage({
                        key: "cars",
                        data: o
                    });
                } else wx.setStorage({
                    key: "cars",
                    data: []
                }), n.setData({
                    hasList: !1
                });
            }
        })) : n.setData({
            hasList: !1
        });
    },
    edit: function() {
        this.setData({
            edit_hidden: !0
        });
    },
    edit_no: function() {
        this.setData({
            edit_hidden: !1
        });
    },
    onLoad: function() {
        console.log(app.globalData), app.look.footer(this), app.look.navbar(this);
    },
    onGotUserInfo: function(t) {
        app.look.getuserinfo(t, this);
    },
    selectList: function(t) {
        var a = t.currentTarget.dataset.index, e = this.data.carts, s = e[a].selected;
        e[a].selected = !s, this.setData({
            carts: e
        }), this.getTotalPrice();
    },
    clearcart: function(t) {
        this.setData({
            hasList: !1
        });
    },
    selectAll: function(t) {
        var a = this.data.selectAllStatus;
        a = !a;
        for (var e = this.data.carts, s = 0; s < e.length; s++) e[s].selected = a;
        this.setData({
            selectAllStatus: a,
            carts: e
        }), this.getTotalPrice();
    },
    addCount: function(t) {
        var a = t.currentTarget.dataset.index, e = this.data.carts;
        e[a].num += 1, e[a].num > e[a].stock || (this.setData({
            carts: e
        }), this.getTotalPrice());
    },
    minusCount: function(t) {
        var a = t.currentTarget.dataset.index, e = this.data.carts;
        1 != e[a].num && (e[a].num -= 1, e[a].num < 1 && e.splice(a, 1), this.setData({
            carts: e
        }), this.getTotalPrice());
    },
    getTotalPrice: function() {
        var t = this.data.carts, a = 0, e = 0;
        console.log(t);
        for (var s = 0; s < t.length; s++) if (t[s].selected) {
            var i = t[s].price;
            1 == app.globalData.webset.vip && app.globalData.userInfo.member && (i = 0 < t[s].vprice ? (t[s].vprice * i / 100).toFixed(2) : (app.globalData.userInfo.member.discount * i / 100).toFixed(2)), 
            a += t[s].num * i, e += t[s].num;
        }
        this.setData({
            carts: t,
            totalPrice: a.toFixed(2),
            totalNum: e
        });
    },
    Settlement: function() {
        var t = this.data.carts, a = this.data.totalPrice, e = this.data.totalNum, s = [], i = [];
        t.forEach(function(t, a) {
            !0 === t.selected && s.push({
                id: t.id,
                img: t.bimg,
                num: t.num,
                price: t.price,
                name: t.name,
                attr: t.attr,
                weight: t.weight
            });
        }), s.length < 1 || (i = {
            content: s,
            totalPrice: a,
            totalNum: e,
            cid: 1
        }, i = JSON.stringify(i), i = encodeURIComponent(i), wx.navigateTo({
            url: "../submit/submit?order=" + i
        }));
    },
    Deltlement: function() {
        var e = this.data.carts, t = this, s = [], i = [];
        e.forEach(function(t, a) {
            1 == t.selected || (s.push(e[a]), i.push({
                id: t.id,
                num: t.num,
                price: t.price,
                attr: t.attr,
                cid: t.cid
            }));
        }), wx.setStorage({
            key: "cars",
            data: i,
            success: function() {
                t.setData({
                    carts: s,
                    edit_hidden: !1
                }), 0 == s.length && t.setData({
                    hasList: !1
                });
            }
        });
    },
    onReady: function() {
        app.look.navbar(this);
    },
    onPullDownRefresh: function() {
        var n = this, o = wx.getStorageSync("cars") || [];
        console.log(o);
        var e = [];
        0 < o.length ? (o.forEach(function(t, a) {
            e.push(t.id);
        }), wx.showLoading({
            title: "加载中"
        }), app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !1,
            method: "POST",
            data: {
                op: "cars",
                ids: e
            },
            success: function(t) {
                var a = t.data;
                if (a.data.list) {
                    for (var e = JSON.parse(JSON.stringify(a.data.list)), s = [], i = 0, r = o.length; i < r; i++) app.look.istrue(e[o[i].id]) ? s.push({
                        status: 1,
                        num: o[i].num,
                        stock: e[o[i].id].attrs[o[i].attr].stock,
                        attr: o[i].attr,
                        price: e[o[i].id].attrs[o[i].attr].price,
                        id: o[i].id,
                        bimg: e[o[i].id].bimg,
                        name: e[o[i].id].name,
                        weight: e[o[i].id].weight
                    }) : s.push({
                        status: -1
                    });
                    n.setData({
                        hasList: !0,
                        carts: s
                    });
                }
            }
        })) : n.setData({
            hasList: !1
        });
    }
});