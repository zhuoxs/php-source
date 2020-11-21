function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp();

Page({
    data: {
        choose: 0
    },
    onLoad: function(t) {
        this.onLoadData();
    },
    onLoadData: function() {
        var t = wx.getStorageSync("userInfo");
        t ? (this.setData({
            uInfo: t
        }), this.loadList()) : wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(t) {
                if (t.confirm) {
                    var a = encodeURIComponent("/sqtg_sun/pages/plugin/spell/myorder/myorder");
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + a);
                } else t.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
    },
    loadList: function() {
        var a = this;
        if (!this.data.list.over) {
            this.setData(_defineProperty({}, "list.load", !0));
            var e = {
                user_id: this.data.uInfo.id,
                page: this.data.list.page,
                length: this.data.list.length,
                type: this.data.choose
            };
            app.api.getCpinOrderList(e).then(function(t) {
                console.log(t.data), 1 == e.page && a.setData({
                    show: !0,
                    imgRoot: t.other.img_root
                }), a.dealList(t.data, e.page);
            }).catch(function(t) {
                t.code, app.tips(t.msg);
            });
        }
    },
    onReachBottom: function() {
        this.loadList();
    },
    onNavTab: function(t) {
        this.setData({
            choose: t.target.dataset.index,
            list: {
                page: 1,
                length: 10,
                over: !1,
                load: !1,
                none: !1,
                data: []
            }
        }), this.loadList();
    },
    onBtnTab: function(t) {
        var a = t.target.dataset.idx, e = t.target.dataset.leaderid;
        if (console.log(t.target.dataset), 1 == this.data.list.data[a].order_status) {
            var o = wx.getStorageSync("userInfo"), s = this.data.list.data[a].heads_id + "-" + this.data.list.data[a].goods_id + "-" + o.id + "-" + e;
            app.navTo("/sqtg_sun/pages/plugin/spell/join/join?id=" + s);
        } else if (3 == this.data.list.data[a].order_status && 2 == this.data.list.data[a].sincetype) wx.showToast({
            title: "请等待团长收到货物后，再去团长处取货",
            icon: "none"
        }); else {
            var i = this.data.list.data[a].id;
            app.navTo("/sqtg_sun/pages/plugin/spell/orderinfo/orderinfo?id=" + i);
        }
    },
    onCancel: function(a) {
        var e = this, t = 1 == a.currentTarget.dataset.headid ? "团长取消订单时，所属的团员也会默认取消订单，确认取消吗？" : "确认取消该订单吗？";
        wx.showModal({
            title: "提示",
            content: t,
            success: function(t) {
                t.confirm ? (console.log("用户点击确定"), app.ajax({
                    url: "Cpin|cancleOrder",
                    data: {
                        oid: a.currentTarget.dataset.id,
                        user_id: e.data.uInfo.id
                    },
                    success: function(t) {
                        console.log(t), "取消成功" == t.data && (e.setData({
                            list: {
                                page: 1,
                                length: 10,
                                over: !1,
                                load: !1,
                                none: !1,
                                data: []
                            }
                        }), e.loadList(), wx.showToast({
                            title: "取消拼团成功",
                            duration: 2e3
                        }));
                    }
                })) : t.cancel && console.log("用户点击取消");
            }
        });
    }
});