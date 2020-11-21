function _defineProperty(a, t, e) {
    return t in a ? Object.defineProperty(a, t, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = e, a;
}

var app = getApp();

Page({
    data: {
        navChoose: 0,
        sending: !1,
        reload: !1
    },
    onLoad: function(a) {
        this.onLoadData();
    },
    onShow: function() {
        this.data.reload && (this.setData({
            reload: !1
        }), this.onLoadData());
    },
    onLoadData: function() {
        var e = this, a = wx.getStorageSync("userInfo");
        if (a) {
            e.setData({
                uInfo: a,
                list: {
                    page: 1,
                    length: 10,
                    over: !1,
                    load: !1,
                    none: !1,
                    data: []
                }
            });
            var o = {
                user_id: a.id,
                type: e.data.navChoose,
                page: this.data.list.page,
                length: this.data.list.length
            };
            app.ajax({
                url: "Cintegral|orderList",
                data: o,
                success: function(a) {
                    for (var t in e.setData({
                        show: !0
                    }), a.data) a.data[t].goodsinfo.cover = a.other.img_root + a.data[t].goodsinfo.cover;
                    e.dealList(a.data, o.page);
                }
            });
        } else wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(a) {
                a.confirm ? app.reTo("/sqtg_sun/pages/home/login/login?id=/sqtg_sun/pages/home/my/my") : a.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
    },
    onNavTab: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData({
            navChoose: t,
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
    loadList: function() {
        var e = this, a = wx.getStorageSync("userInfo");
        if (!this.data.list.over) {
            this.setData(_defineProperty({}, "list.load", !0));
            var o = {
                user_id: a.id,
                type: e.data.navChoose,
                page: e.data.list.page,
                length: e.data.list.length
            };
            app.ajax({
                url: "Cintegral|orderList",
                data: o,
                success: function(a) {
                    for (var t in a.data) a.data[t].goodsinfo.cover = a.other.img_root + a.data[t].goodsinfo.cover;
                    e.dealList(a.data, o.page);
                }
            });
        }
    },
    onReachBottom: function() {
        this.loadList();
    },
    onCancelTab: function(a) {
        var t = this, e = a.currentTarget.dataset.idx, o = {
            goods_id: t.data.list.data[e].goodsinfo.id,
            user_id: t.data.uInfo.id,
            oid: t.data.list.data[e].id
        };
        wx.showModal({
            title: "提示",
            content: "确定取消该订单吗！",
            success: function(a) {
                a.confirm ? app.ajax({
                    url: "Cintegral|cancelOrder",
                    data: o,
                    success: function(a) {
                        t.data.list.data.splice(e, 1), t.setData({
                            list: t.data.list
                        }), app.tips(a.msg);
                    }
                }) : a.cancel;
            }
        });
    },
    onCheckReceiveTab: function(a) {
        var t = this, e = a.currentTarget.dataset.idx, o = {
            goods_id: t.data.list.data[e].goodsinfo.id,
            user_id: t.data.uInfo.id,
            oid: t.data.list.data[e].id
        };
        wx.showModal({
            title: "提示",
            content: "确定已经收到快递！",
            success: function(a) {
                a.confirm ? app.ajax({
                    url: "Cintegral|checkGet",
                    data: o,
                    success: function(a) {
                        app.tips("收货成功！"), setTimeout(function() {
                            app.reTo("/sqtg_sun/pages/public/pages/integralorder/integralorder");
                        }, 1e3);
                    }
                }) : a.cancel;
            }
        });
    },
    onDelectTab: function(a) {
        var t = this, e = a.currentTarget.dataset.idx, o = {
            goods_id: t.data.list.data[e].goodsinfo.id,
            user_id: t.data.uInfo.id,
            oid: t.data.list.data[e].id
        };
        wx.showModal({
            title: "提示",
            content: "确定删除该订单记录！",
            success: function(a) {
                a.confirm ? app.ajax({
                    url: "Cintegral|delOrd",
                    data: o,
                    success: function(a) {
                        app.tips("删除成功！"), setTimeout(function() {
                            app.reTo("/sqtg_sun/pages/public/pages/integralorder/integralorder");
                        }, 1e3);
                    }
                }) : a.cancel;
            }
        });
    }
});