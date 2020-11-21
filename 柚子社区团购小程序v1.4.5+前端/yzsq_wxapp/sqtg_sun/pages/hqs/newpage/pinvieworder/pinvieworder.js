var app = getApp();

Page({
    data: {
        currenttab: -1,
        imgAdd: "",
        shopId: 0,
        type: -1,
        orderData: [],
        page: 1,
        limit: 10,
        hasMore: !0
    },
    onLoad: function(t) {
        var a = this;
        a.setData({
            shopId: t.shopId
        }), app.ajax({
            url: "Cpin|storeOrderList",
            data: {
                store_id: t.shopId,
                state: -1,
                ordertype: "desc",
                orderfield: "create_time"
            },
            success: function(t) {
                console.log(t), a.setData({
                    orderData: t.data,
                    imgAdd: t.other.img_root
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onOrder: function(t) {
        var a = this;
        if (a.setData({
            page: 1,
            limit: 10,
            hasMore: !0
        }), t) {
            if (this.data.currenttab == t.currentTarget.dataset.tabid) return !1;
            this.setData({
                currenttab: t.currentTarget.dataset.tabid,
                type: t.currentTarget.dataset.tabid
            });
        }
        app.ajax({
            url: "Cpin|storeOrderList",
            data: {
                store_id: a.data.shopId,
                state: t.currentTarget.dataset.tabid,
                ordertype: "desc",
                orderfield: "create_time"
            },
            success: function(t) {
                console.log(t), a.setData({
                    orderData: t.data,
                    imgAdd: t.other.img_root
                });
            }
        });
    },
    confirmGoods: function(t) {
        var a = this;
        console.log(t.currentTarget.dataset.orderid), console.log(t.currentTarget.dataset.index), 
        console.log(a.data.orderData.splice(t.currentTarget.dataset.index, 1)), console.log(a.data.orderData), 
        app.ajax({
            url: "Cpin|batchsend",
            data: {
                ids: t.currentTarget.dataset.orderid
            },
            success: function(t) {
                console.log(t), a.setData({
                    orderData: a.data.orderData
                }), wx.showToast({
                    title: "发货成功",
                    icon: "success",
                    duration: 3e3
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
            url: "Cpin|storeOrderList",
            data: {
                store_id: r.data.shopId,
                state: r.data.type,
                page: r.data.page,
                limit: r.data.limit,
                ordertype: "desc",
                orderfield: "create_time"
            },
            success: function(t) {
                console.log(t);
                var a = r.data.orderData.concat(t.data), e = parseInt(t.other.count), o = r.data.page * r.data.limit < e;
                r.setData({
                    orderData: a,
                    hasMore: o
                });
            }
        })) : wx.showToast({
            title: "没有更多数据了",
            icon: "none"
        });
    },
    onShareAppMessage: function() {}
});