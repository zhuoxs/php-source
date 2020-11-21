function _defineProperty(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

var app = getApp();

Page({
    data: {
        inputvalue: "",
        cutprice: "",
        refuse_info: "",
        refuse: !1
    },
    copy: function(t) {
        console.log(t), wx.setClipboardData({
            data: t.currentTarget.dataset.value,
            success: function(t) {
                app.look.ok("复制成功");
            }
        });
    },
    refuse_info: function(t) {
        this.setData({
            refuse_info: t.detail.value
        });
    },
    refund_refuse: function() {
        this.setData({
            refuse: !0
        });
    },
    close_refuse: function() {
        this.setData({
            refuse: !1
        });
    },
    holdblock: function() {},
    refuse: function() {
        var s = this, t = this.data.refuse_info;
        app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !0,
            data: {
                op: "refund_refuse",
                id: s.data.list.id,
                text: t
            },
            success: function(t) {
                var e = getCurrentPages(), a = e[e.length - 2].data.list;
                console.log(a);
                for (var i = 0, o = a.length; i < o; i++) if (console.log(a[i]), console.log(a[i].id), 
                console.log(a[i].id), console.log(s.data.list.id), a[i].id == s.data.list.id) {
                    0 == e[e.length - 2].data.curIndex ? (a[i].refund = 3, e[e.length - 2].setData(_defineProperty({}, "list[" + i + "].refund", 3))) : (a.splice(i, 1), 
                    e[e.length - 2].setData({
                        list: a
                    }));
                    break;
                }
                app.look.ok("操作成功", function() {
                    wx.navigateBack({
                        delta: 1
                    });
                });
            }
        });
    },
    close_order: function() {
        app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !1,
            data: {
                op: "order_close",
                id: this.data.list.id
            },
            success: function(t) {}
        });
    },
    ipt: function(t) {
        var e = 0;
        if ("" != t.detail.value && (e = t.detail.value), e > parseFloat(this.data.list.order_price)) return app.look.alert("不能大于订单总金额"), 
        void this.setData({
            cutprice: this.data.cutprice
        });
        this.setData({
            cutprice: t.detail.value,
            total: (parseFloat(this.data.list.price) - e).toFixed(2)
        });
    },
    alter: function() {
        this.setData({
            showAlter: !0
        });
    },
    hide: function() {
        this.setData({
            showAlter: !1
        });
    },
    sure: function(t) {
        var n = this.data.cutprice, r = this;
        n > r.data.list.order_price && app.look.alert("不能大于订单金额"), app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !0,
            data: {
                op: "change_order_price",
                id: r.data.options.id,
                cutprice: n
            },
            success: function(t) {
                app.look.ok(t.data.message);
                var e = r.data.list;
                e.order_price = (parseFloat(e.order_price) - parseFloat(n)).toFixed(2), e.price = (parseFloat(e.price) - parseFloat(n)).toFixed(2), 
                r.setData({
                    list: e
                });
                for (var a = getCurrentPages(), i = a[a.length - 2].data.list, o = 0, s = i.length; o < s; o++) if (i[o].id == r.data.options.id) {
                    i[o].order_price = (parseFloat(i[o].order_price) - parseFloat(n)).toFixed(2), i[o].price = (parseFloat(i[o].price) - parseFloat(n)).toFixed(2), 
                    a[a.length - 2].setData(_defineProperty({}, "list[" + o + "]", i[o]));
                    break;
                }
                r.hide();
            }
        });
    },
    onLoad: function(t) {
        var a = this;
        a.setData({
            options: t
        }), app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !1,
            data: {
                op: "order_detail",
                id: t.id
            },
            success: function(t) {
                var e = t.data;
                e.data.list && (console.log(e.data.list), a.setData({
                    list: e.data.list,
                    total: e.data.list.price
                }));
            }
        });
    },
    inputvalue: function(t) {
        console.log(t), this.setData({
            inputvalue: t.detail.value
        });
    },
    refund_sure: function() {
        var i = this;
        console.log(i.data.list), app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !0,
            data: {
                op: "refund_sure",
                id: i.data.list.id
            },
            success: function(t) {
                console.log(t), app.look.ok(t.data.message, function() {
                    for (var t = getCurrentPages(), e = t[t.length - 2].data.list, a = 0; a < e.length; a++) e[a].id == i.data.list.id && (0 == t[t.length - 2].data.curIndex ? (e[a].refund = 2, 
                    t[t.length - 2].setData(_defineProperty({}, "list[" + a + "].refund", 2))) : (e.splice(a, 1), 
                    t[t.length - 2].setData({
                        list: e
                    }), a--));
                    wx.navigateBack({
                        delta: 1
                    });
                }, 2e3);
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});