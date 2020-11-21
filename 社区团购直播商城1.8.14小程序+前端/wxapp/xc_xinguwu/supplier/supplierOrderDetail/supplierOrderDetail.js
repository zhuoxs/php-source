function _defineProperty(t, a, i) {
    return a in t ? Object.defineProperty(t, a, {
        value: i,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = i, t;
}

var app = getApp();

function countNum(t) {
    for (var a = 0, i = t.list.length; a < i; a++) {
        var o = 0;
        for (var e in t.list[a].attrs) o += parseInt(t.list[a].attrs[e]);
        t.list[a].num = o;
    }
    return t;
}

Page({
    data: {
        state: 1,
        orderId: "123456789"
    },
    copy: function() {
        wx.setClipboardData({
            data: this.data.list.id,
            success: function(t) {
                app.look.ok("复制成功");
            }
        });
    },
    inputValue: function(t) {
        this.inputvalue = t.detail.value, console.log(this.inputvalue);
    },
    confirmDelivery: function() {
        var i = -this;
        app.util.request({
            url: "entry/wxapp/supplier",
            showLoading: !0,
            data: {
                op: "confirmDelivery",
                id: taht.options.id
            },
            success: function(t) {
                var a;
                app.look.ok(t.data.message), i.setData((_defineProperty(a = {}, "list.status", 2), 
                _defineProperty(a, "list.deliver_time", t.data.data), a));
            }
        });
    },
    onLoad: function(t) {
        t.id = 1, this.options = t;
        var i = this;
        app.util.request({
            url: "entry/wxapp/supplier",
            showLoading: !1,
            method: "POST",
            data: {
                op: "supplierOrderDetail",
                id: t.id
            },
            success: function(t) {
                var a = t.data;
                a.data.list && i.setData({
                    list: countNum(a.data.list)
                });
            }
        }), null == app.location ? app.util.request({
            url: "entry/wxapp/index",
            showLoading: !1,
            method: "POST",
            data: {
                op: "getLocation"
            },
            success: function(t) {
                app.location = t.data.data, i.setData({
                    location: t.data.data
                });
            }
        }) : i.setData({
            location: app.location
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var i = this;
        app.util.request({
            url: "entry/wxapp/supplier",
            showLoading: !0,
            method: "POST",
            data: {
                op: "supplierOrderDetail",
                id: options.id
            },
            success: function(t) {
                wx.stopPullDownRefresh();
                var a = t.data;
                a.data.list && i.setData({
                    list: countNum(a.data.list)
                });
            }
        });
    },
    onReachBottom: function() {}
});