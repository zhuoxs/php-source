function a(a) {
    var t = setInterval(function() {
        var r = a.data.fail;
        if (r > 0) {
            r -= 1;
            var e = [ 0, 0, 0 ];
            e[0] = parseInt(r / 60 / 60), e[2] = parseInt(r % 60), e[1] = parseInt(r / 60 % 60), 
            a.setData({
                fail: r,
                times: e
            });
        } else {
            clearInterval(t);
            var s = a.data.list;
            s.status, a.setData({
                list: s
            });
        }
    }, 1e3);
}

function t(a) {
    setInterval(function() {
        for (var t = a.data.list.group_order, r = 0; r < t.length; r++) if (-1 == t[r].status && parseInt(t[r].fail) > 0) {
            t[r].fail = t[r].fail - 1;
            var e = [ 0, 0, 0 ];
            e[0] = parseInt(parseInt(t[r].fail) / 60 / 60), e[2] = parseInt(parseInt(t[r].fail) % 60), 
            e[1] = parseInt(parseInt(t[r].fail) / 60 % 60), t[r].times = e;
        } else t[r].status;
        var s = a.data.list;
        s.group_order = t, a.setData({
            list: s
        });
    }, 1e3);
}

var r = getApp(), e = require("../common/common.js");

Page({
    data: {
        times: [ 0, 0, 0 ],
        fail: 0,
        numbervalue: 1,
        format: -1
    },
    showbuy: function(a) {
        var t = this, r = a.currentTarget.dataset.index;
        if (2 == r) {
            var e = a.currentTarget.dataset.id;
            t.setData({
                showbuy: !0,
                group_status: r,
                group_id: e
            });
        } else t.setData({
            showbuy: !0,
            group_status: r
        });
    },
    closebuy: function() {
        this.setData({
            showbuy: !1
        });
    },
    numMinus: function() {
        var a = this, t = a.data.numbervalue;
        1 == t || (t--, a.setData({
            numbervalue: t
        }));
    },
    numPlus: function() {
        var a = this, t = a.data.numbervalue;
        t++, a.setData({
            numbervalue: t
        });
    },
    valChange: function(a) {
        var t = this, r = a.detail.value;
        r >= 1 || (r = 1), t.setData({
            numbervalue: r
        });
    },
    radiochange: function(a) {
        var t = this, r = a.detail.value;
        t.data.xc;
        t.setData({
            format: r
        });
    },
    submit: function() {
        var a = this;
        -1 == a.data.format ? wx.showModal({
            title: "错误",
            content: "请选择规格"
        }) : 1 == a.data.group_status ? wx.navigateTo({
            url: "../mall/porder?&id=" + a.data.list.service + "&format=" + a.data.format + "&member=" + a.data.numbervalue + "&group=1&group_id=" + a.data.list.id
        }) : -1 == a.data.group_status ? wx.navigateTo({
            url: "../mall/porder?&id=" + a.data.list.service + "&format=" + a.data.format + "&member=" + a.data.numbervalue + "&group=1"
        }) : 2 == a.data.group_status && wx.navigateTo({
            url: "../mall/porder?&id=" + a.data.list.service + "&format=" + a.data.format + "&member=" + a.data.numbervalue + "&group=1&group_id=" + a.data.group_id
        });
    },
    onLoad: function(s) {
        var o = this;
        e.config(o), e.theme(o), r.util.request({
            url: "entry/wxapp/order",
            method: "POST",
            data: {
                op: "group",
                id: s.group
            },
            success: function(r) {
                var e = r.data;
                if ("" != e.data) {
                    if (-1 == e.data.status && parseInt(e.data.fail) > 0 && ((i = [ 0, 0, 0 ])[0] = parseInt(e.data.fail / 60 / 60), 
                    i[2] = parseInt(e.data.fail % 60), i[1] = parseInt(e.data.fail / 60 % 60), o.setData({
                        fail: e.data.fail,
                        times: i
                    })), "" != e.data.service_list && null != e.data.service_list && "" != e.data.service_list.format && null != e.data.service_list.format && o.setData({
                        format: 0
                    }), (1 == e.data.status || 2 == e.data.status) && "" != e.data.group_order && null != e.data.group_order) {
                        for (var s = 0; s < e.data.group_order.legnth; s++) if (parseInt(e.data.group_order[s].fail) > 0) {
                            var i = [ 0, 0, 0 ];
                            i[0] = parseInt(parseInt(e.data.group_order[s].fail) / 60 / 60), i[2] = parseInt(parseInt(e.data.group_order[s].fail) % 60), 
                            i[1] = parseInt(parseInt(e.data.group_order[s].fail) / 60 % 60), e.data.group_order[s].times = i;
                        } else e.data.group_order[s].status = 2;
                        t(o);
                    }
                    o.setData({
                        list: e.data
                    }), a(o);
                }
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        e.audio_end(this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    onReachBottom: function() {}
});