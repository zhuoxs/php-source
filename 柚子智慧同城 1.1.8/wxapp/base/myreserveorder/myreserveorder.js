/*www.lanrenzhijia.com   time:2019-06-01 22:11:55*/
var t = getApp();
t.Base({
    data: {
        nav: [{
            title: "全部",
            status: 0
        }, {
            title: "待支付",
            status: 1
        }, {
            title: "待使用",
            status: 2
        }, {
            title: "完成",
            status: 6
        }, {
            title: "售后",
            status: 7
        }],
        curHdIndex: 0,
        page: 1,
        length: 10,
        olist: []
    },
    onLoad: function(t) {},
    onShow: function() {
        var t = this;
        this.checkLogin(function(a) {
            t.setData({
                user_id: a.id,
                page: 1
            }), t.onLoadData(a)
        }, "/base/mygoodsorder/mygoodsorder")
    },
    onLoadData: function() {
        var a = this,
            e = a.data.olist,
            s = a.data.length,
            o = a.data.page,
            r = {
                user_id: a.data.user_id,
                page: o,
                length: s,
                type: a.data.curHdIndex,
                order_lid: 2
            };
        t.api.apiOrderGetOrderList(r).then(function(t) {
            var r = !(t.data.length < s);
            if (t.data.length < s && a.setData({
                nomore: !0,
                show: !0
            }), 1 == o) e = t.data;
            else for (var n in t.data) e.push(t.data[n]);
            o += 1, a.setData({
                olist: e,
                show: !0,
                hasMore: r,
                page: o,
                img_root: t.other.img_root
            })
        }).
        catch (function(a) {
            t.tips(a.msg)
        })
    },
    swichNav: function(t) {
        var a = this,
            e = t.currentTarget.dataset.status;
        a.setData({
            curHdIndex: e,
            page: 1
        }), this.onLoadData()
    },
    onReachBottom: function() {
        var t = this;
        t.data.hasMore ? t.onLoadData() : this.setData({
            nomore: !0
        })
    },
    cancelOrder: function(a) {
        var e = this,
            s = a.currentTarget.dataset.index,
            o = e.data.olist;
        wx.showModal({
            title: "提示",
            content: "确定取消该订单吗",
            success: function(a) {
                a.confirm && t.ajax({
                    url: "Corder|cancelOrder",
                    data: {
                        order_id: o[s].id
                    },
                    success: function(t) {
                        wx.showToast({
                            title: "取消成功"
                        }), o.splice(s, 1), e.setData({
                            olist: o
                        })
                    }
                })
            }
        })
    },
    deleteOrder: function(a) {
        var e = this,
            s = a.currentTarget.dataset.index,
            o = e.data.olist;
        wx.showModal({
            title: "提示",
            content: "订单删除后不再显示",
            success: function(a) {
                a.confirm && t.ajax({
                    url: "Corder|deleteOrder",
                    data: {
                        order_id: o[s].id
                    },
                    success: function(t) {
                        wx.showToast({
                            title: "删除成功"
                        }), o.splice(s, 1), e.setData({
                            olist: o
                        })
                    }
                })
            }
        })
    },
    payNow: function(a) {
        var e = this,
            s = a.currentTarget.dataset.index;
        t.ajax({
            url: "Corder|payOrder",
            data: {
                order_id: e.data.olist[s].id
            },
            success: function(a) {
                a.other.paydata && wx.requestPayment({
                    timeStamp: a.other.paydata.timeStamp,
                    nonceStr: a.other.paydata.nonceStr,
                    package: a.other.paydata.package,
                    signType: a.other.paydata.signType,
                    paySign: a.other.paydata.paySign,
                    success: function(a) {
                        t.reTo("/sqtg_sun/pages/zkx/pages/ordersuccess/ordersuccess")
                    }
                })
            },
            complete: function() {
                e.setData({
                    isRequest: 0
                })
            }
        })
    },
    onReserveorderinfoTap: function(a) {
        t.navTo("/base/reserveorderinfo/reserveorderinfo?id=" + a.currentTarget.dataset.id)
    }
});