function _defineProperty(e, a, t) {
    return a in e ? Object.defineProperty(e, a, {
        value: t,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[a] = t, e;
}

var app = getApp();

Page({
    data: {
        express_number: "",
        index: 0
    },
    bindPickerChange: function(e) {
        this.setData({
            index: e.detail.value
        });
    },
    scan: function() {
        var a = this;
        wx.scanCode({
            success: function(e) {
                a.setData({
                    express_number: e.result
                });
            }
        });
    },
    myform: function(e) {
        var o = this, a = e.detail.value.express_code, t = e.detail.value.express_name, n = e.detail.value.express_number, s = e.detail.value.vendor_remark;
        if ("" != n) {
            e.detail.value;
            app.util.request({
                url: "entry/wxapp/manage",
                showLoading: !1,
                data: {
                    op: "deliver_sure",
                    id: o.data.options.id,
                    express_code: a,
                    express_name: t,
                    express_number: n,
                    vendor_remark: s
                },
                success: function(e) {
                    var i = getCurrentPages();
                    i.forEach(function(n, s) {
                        "xc_xinguwu/pages/mList/mList" == n.route && n.data.list.forEach(function(e, a) {
                            if (e.id == o.data.list.id) if (console.log(n.data.curIndex), console.log(a), 0 == n.data.curIndex) i[s].setData(_defineProperty({}, "list[" + a + "].status", 3)); else {
                                var t = i[s].data.list;
                                t.splice(a, 1), i[s].setData({
                                    list: t
                                });
                            }
                        });
                    }), wx.redirectTo({
                        url: "../mSendSuccess/mSendSuccess?id=" + o.data.options.id
                    });
                }
            });
        } else app.look.alert("请输入快递单号");
    },
    onLoad: function(e) {
        var t = this;
        t.setData({
            options: e
        }), null != app.ex_company ? t.setData({
            ex_company: app.ex_company
        }) : app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !1,
            data: {
                op: "get_express_name"
            },
            success: function(e) {
                var a = e.data;
                a.data.list && (console.log(a.data.list), t.setData({
                    ex_company: a.data.list
                }), app.ex_company = a.data.list);
            }
        }), app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !1,
            data: {
                op: "order_detail",
                id: e.id
            },
            success: function(e) {
                var a = e.data;
                a.data.list && t.setData({
                    list: a.data.list
                });
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