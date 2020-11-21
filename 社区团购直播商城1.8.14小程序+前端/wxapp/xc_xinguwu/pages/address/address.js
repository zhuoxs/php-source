var app = getApp();

Page({
    data: {},
    onLoad: function() {},
    onReady: function() {
        app.look.navbar(this);
    },
    onShow: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/my",
            showLoading: !1,
            data: {
                op: "address"
            },
            success: function(a) {
                var s = a.data;
                s.data.list && t.setData({
                    address: s.data.list
                });
            }
        });
    },
    deleteList: function(a) {
        var s = this, t = a.currentTarget.dataset.index, d = this.data.address, e = d[t].id;
        wx.showModal({
            title: "提示",
            content: "确定删除地址?",
            success: function(a) {
                a.confirm ? app.util.request({
                    url: "entry/wxapp/my",
                    showLoading: !1,
                    data: {
                        op: "del_address",
                        id: e
                    },
                    success: function(a) {
                        app.look.ok(a.data.message), d.splice(t, 1), s.setData({
                            address: d
                        });
                    }
                }) : a.cancel && console.log("用户点击取消");
            }
        });
    },
    addAddre: function(a) {
        wx.navigateTo({
            url: "../addAddress/addAddress"
        });
    },
    chooseCatalog: function(a) {
        var s = this, t = a.currentTarget.dataset.index, d = this.data.address;
        d[t].id;
        d.forEach(function(a, s) {
            s == t ? 1 == a.ison ? a.ison = 0 : a.ison = 1 : a.ison = 0;
        }), console.log(d), s.setData({
            address: d
        });
    }
});