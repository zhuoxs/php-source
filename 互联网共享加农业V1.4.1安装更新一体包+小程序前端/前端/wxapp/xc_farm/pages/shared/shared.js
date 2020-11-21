var common = require("../common/common.js"), app = getApp();

function time_up(e) {
    var s = setInterval(function() {
        var a = e.data.fail;
        if (0 < a) {
            a -= 1;
            var t = [ 0, 0, 0 ];
            t[0] = parseInt(a / 60 / 60), t[2] = parseInt(a % 60), t[1] = parseInt(a / 60 % 60), 
            e.setData({
                fail: a,
                times: t
            });
        } else {
            clearInterval(s);
            var r = e.data.list;
            r.status, e.setData({
                list: r
            });
        }
    }, 1e3);
}

function time_up2(s) {
    setInterval(function() {
        for (var a = s.data.list.group_order, t = 0; t < a.length; t++) if (-1 == a[t].status && 0 < parseInt(a[t].fail)) {
            a[t].fail = a[t].fail - 1;
            var r = [ 0, 0, 0 ];
            r[0] = parseInt(parseInt(a[t].fail) / 60 / 60), r[2] = parseInt(parseInt(a[t].fail) % 60), 
            r[1] = parseInt(parseInt(a[t].fail) / 60 % 60), a[t].times = r;
        } else a[t].status;
        var e = s.data.list;
        e.group_order = a, s.setData({
            list: e
        });
    }, 1e3);
}

Page({
    data: {
        times: [ 0, 0, 0 ],
        fail: 0,
        numbervalue: 1,
        format: -1
    },
    showbuy: function(a) {
        var t = a.currentTarget.dataset.index;
        if (2 == t) {
            var r = a.currentTarget.dataset.id;
            this.setData({
                showbuy: !0,
                group_status: t,
                group_id: r
            });
        } else this.setData({
            showbuy: !0,
            group_status: t
        });
    },
    closebuy: function() {
        this.setData({
            showbuy: !1
        });
    },
    numMinus: function() {
        var a = this.data.numbervalue;
        1 == a || (a--, this.setData({
            numbervalue: a
        }));
    },
    numPlus: function() {
        var a = this.data.numbervalue;
        a++, this.setData({
            numbervalue: a
        });
    },
    valChange: function(a) {
        var t = a.detail.value;
        1 <= t || (t = 1), this.setData({
            numbervalue: t
        });
    },
    radiochange: function(a) {
        var t = a.detail.value;
        this.data.xc;
        this.setData({
            format: t
        });
    },
    submit: function() {
        var a = this;
        common.is_bind(function() {
            -1 == a.data.format ? wx.showModal({
                title: "错误",
                content: "请选择规格"
            }) : 1 == a.data.group_status ? wx.navigateTo({
                url: "../cart_pay/cart_pay?&id=" + a.data.list.service + "&format_index=" + a.data.format + "&member=" + a.data.numbervalue + "&order_type=2&group=" + a.data.list.id
            }) : -1 == a.data.group_status ? wx.navigateTo({
                url: "../cart_pay/cart_pay?&id=" + a.data.list.service + "&format_index=" + a.data.format + "&member=" + a.data.numbervalue + "&order_type=2"
            }) : 2 == a.data.group_status && wx.navigateTo({
                url: "../cart_pay/cart_pay?&id=" + a.data.list.service + "&format_index=" + a.data.format + "&member=" + a.data.numbervalue + "&order_type=2&group=" + a.data.group_id
            });
        });
    },
    onLoad: function(a) {
        var s = this;
        common.config(s), app.util.request({
            url: "entry/wxapp/order",
            method: "POST",
            data: {
                op: "group",
                group: a.group
            },
            success: function(a) {
                var t = a.data;
                if ("" != t.data) {
                    if (-1 == t.data.status && 0 < parseInt(t.data.fail)) (e = [ 0, 0, 0 ])[0] = parseInt(t.data.fail / 60 / 60), 
                    e[2] = parseInt(t.data.fail % 60), e[1] = parseInt(t.data.fail / 60 % 60), s.setData({
                        fail: t.data.fail,
                        times: e
                    });
                    if ("" != t.data.service_list && null != t.data.service_list && "" != t.data.service_list.format && null != t.data.service_list.format && s.setData({
                        format: 0
                    }), (1 == t.data.status || 2 == t.data.status) && "" != t.data.group_order && null != t.data.group_order) {
                        for (var r = 0; r < t.data.group_order.legnth; r++) {
                            var e;
                            if (0 < parseInt(t.data.group_order[r].fail)) (e = [ 0, 0, 0 ])[0] = parseInt(parseInt(t.data.group_order[r].fail) / 60 / 60), 
                            e[2] = parseInt(parseInt(t.data.group_order[r].fail) % 60), e[1] = parseInt(parseInt(t.data.group_order[r].fail) / 60 % 60), 
                            t.data.group_order[r].times = e; else t.data.group_order[r].status = 2;
                        }
                        time_up2(s);
                    }
                    s.setData({
                        list: t.data
                    }), time_up(s);
                }
            }
        });
    },
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    }
});