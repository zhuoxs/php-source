function _defineProperty(a, e, t) {
    return e in a ? Object.defineProperty(a, e, {
        value: t,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[e] = t, a;
}

var app = getApp();

Page({
    data: {},
    onLoad: function(a) {
        a.regions = a.region.split(" "), this.setData({
            options: a
        });
    },
    bindRegionChange: function(a) {
        console.log("picker发送选择改变，携带值为", a.detail.value), this.setData({
            region: a.detail.value
        });
    },
    myform: function(o) {
        var d = this;
        console.log(o), "" != o.detail.value.name && "" != o.detail.value.phone && "" != o.detail.value.detail || app.look.alert("请先补全信息"), 
        app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !1,
            data: {
                op: "alter_order_address",
                id: d.data.options.id,
                name: o.detail.value.name,
                phone: o.detail.value.phone,
                detail: o.detail.value.detail,
                region: o.detail.value.region.join(" ")
            },
            success: function(a) {
                app.look.ok(a.data.message);
                for (var e = getCurrentPages(), t = 0, i = e.length; t < i; t++) {
                    if ("xc_xinguwu/pages/manageOrderDetail/manageOrderDetail" == e[t].route && (e[t].data.list.name = o.detail.value.name, 
                    e[t].data.list.phone = o.detail.value.phone, e[t].data.list.detail = o.detail.value.detail, 
                    e[t].data.list.region = o.detail.value.region.join(" "), e[t].setData({
                        list: e[t].data.list
                    })), "xc_xinguwu/pages/mList/mList" == e[t].route) for (var n = 0, l = e[t].data.list.length; n < l; n++) e[t].data.list[n].id == d.data.options.id && (e[t].data.list[n].name = o.detail.value.name, 
                    e[t].data.list[n].phone = o.detail.value.phone, e[t].data.list[n].detail = o.detail.value.detail, 
                    e[t].data.list[n].region = o.detail.value.region.join(" "), e[t].setData(_defineProperty({}, "list[" + n + "]", e[t].data.list[n])));
                    "xc_xinguwu/pages/mSendSuccess/mSendSuccess" == e[t].route && (e[t].data.down.name = o.detail.value.name, 
                    e[t].data.down.phone = o.detail.value.phone, e[t].data.down.detail = o.detail.value.detail, 
                    e[t].data.down.region = o.detail.value.region.join(" "), e[t].setData({
                        down: e[t].data.down
                    }));
                }
                wx.navigateBack({
                    delta: 1
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});