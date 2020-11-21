var app = getApp();

Page({
    data: {
        currenttab: 0,
        imgAdd: "",
        shopId: 0,
        type: 0,
        orderData: [],
        page: 1,
        limit: 10,
        hasMore: !0
    },
    onLoad: function(a) {
        var t = this;
        t.setData({
            shopId: a.shopId
        }), app.ajax({
            url: "Corder|index",
            data: {
                store_id: a.shopId,
                state: 0
            },
            success: function(a) {
                console.log(a), t.setData({
                    orderData: a.data,
                    imgAdd: a.other.img_root
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onOrder: function(a) {
        var t = this;
        if (t.setData({
            page: 1,
            limit: 10,
            hasMore: !0
        }), a) {
            if (this.data.currenttab == a.currentTarget.dataset.tabid) return !1;
            this.setData({
                currenttab: a.currentTarget.dataset.tabid,
                type: a.currentTarget.dataset.tabid
            });
        }
        app.ajax({
            url: "Corder|index",
            data: {
                store_id: t.data.shopId,
                state: a.currentTarget.dataset.tabid
            },
            success: function(a) {
                console.log(a), t.setData({
                    orderData: a.data,
                    imgAdd: a.other.img_root
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var r = this;
        console.log("上拉触底"), r.data.hasMore ? (r.setData({
            page: ++r.data.page,
            limit: r.data.limit
        }), app.ajax({
            url: "Corder|index",
            data: {
                store_id: r.data.shopId,
                state: r.data.type,
                page: r.data.page,
                limit: r.data.limit
            },
            success: function(a) {
                console.log(a);
                var t = r.data.orderData.concat(a.data), e = parseInt(a.other.count), o = r.data.page * r.data.limit < e;
                r.setData({
                    orderData: t,
                    hasMore: o
                });
            }
        })) : wx.showToast({
            title: "没有更多数据了",
            icon: "none"
        });
    },
    onRefund: function(e) {
        console.log(e);
        var o = this;
        console.log(e.currentTarget.dataset.index), app.ajax({
            url: "Corder|batchchecked",
            data: {
                ids: e.currentTarget.dataset.orderid,
                check_state: e.currentTarget.dataset.state
            },
            success: function(a) {
                console.log(a), 2 == e.currentTarget.dataset.state ? (wx.showToast({
                    title: "退款成功",
                    icon: "success",
                    duration: 3e3
                }), o.data.orderData.forEach(function(a, t) {
                    t == e.currentTarget.dataset.index && (o.data.orderData[t].check_state = 2);
                })) : (wx.showToast({
                    title: "拒绝退款",
                    icon: "success",
                    duration: 3e3
                }), o.data.orderData.forEach(function(a, t) {
                    t == e.currentTarget.dataset.index && (o.data.orderData[t].check_state = 3);
                })), o.setData({
                    orderData: o.data.orderData
                });
            }
        });
    },
    onShareAppMessage: function() {},
    confirmGoods: function(a) {
        var t = this;
        console.log(a.currentTarget.dataset.orderid), console.log(a.currentTarget.dataset.index), 
        console.log(t.data.orderData.splice(a.currentTarget.dataset.index, 1)), console.log(t.data.orderData), 
        app.ajax({
            url: "Corder|batchsend",
            data: {
                ids: a.currentTarget.dataset.orderid
            },
            success: function(a) {
                console.log(a), t.setData({
                    orderData: t.data.orderData
                }), wx.showToast({
                    title: "发货成功",
                    icon: "success",
                    duration: 3e3
                });
            }
        });
    }
});