var app = getApp();

Page({
    data: {
        navTile: "预约订单",
        nav: [ "待支付", "待核销", "已核销" ],
        curIndex: 0,
        current: [ {
            ordernum: "2018032015479354825174",
            status: "1",
            img: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152360015252.png",
            title: "可口可乐可口可乐可口可乐可口可乐可口可乐可口可乐",
            price: "2.50",
            num: "1",
            times: "2018-05-05 10:10:10",
            goodsnum: "23"
        } ],
        pageIndex: 1,
        hasMore: !0,
        goods: []
    },
    onLoad: function(t) {
        var e = this;
        wx.setNavigationBarTitle({
            title: e.data.navTile
        }), t.cur && e.setData({
            curIndex: t.cur
        }), app.get_imgroot().then(function(t) {
            e.setData({
                imgroot: t
            });
        }), app.get_user_info().then(function(t) {
            e.setData({
                userId: t.id
            });
        });
    },
    onReady: function() {},
    onShow: function() {
        this.goodsOrder();
    },
    goodsOrder: function() {
        var n = this, o = n.data.pageIndex, e = n.data.curIndex || 0;
        app.get_user_info().then(function(t) {
            app.util.request({
                url: "entry/wxapp/GetOrderapp",
                cachetime: "0",
                data: {
                    user_id: t.id,
                    page: o,
                    state: e
                },
                success: function(t) {
                    if (1 == o) o += 1, n.setData({
                        pageIndex: o,
                        goods: t.data
                    }); else {
                        var e = n.data.goods;
                        for (var a in o += 1, t.data) e.push(t.data[a]);
                        n.setData({
                            pageIndex: o,
                            goods: e
                        });
                    }
                    t.data.length < 10 && n.setData({
                        hasMore: !1
                    }), console.log(t.data);
                }
            });
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        this.goodsOrder();
    },
    toDel: function(t) {
        var e = this, a = t.currentTarget.dataset.id, n = t.currentTarget.dataset.index, o = e.data.goods;
        wx.showModal({
            title: "提示",
            content: "订单删除后将不再显示",
            success: function(t) {
                t.confirm ? app.util.request({
                    url: "entry/wxapp/DeleteOrderapp",
                    cachetime: "0",
                    data: {
                        id: a
                    },
                    success: function(t) {
                        o.splice(n, 1), e.setData({
                            goods: o
                        });
                    }
                }) : t.cancel;
            }
        });
    },
    toApporderdet: function(t) {
        var e = t.currentTarget.dataset.id;
        console.log(e), wx.navigateTo({
            url: "../apporderdet/apporderdet?id=" + e
        });
    },
    bargainTap: function(t) {
        var e = parseInt(t.currentTarget.dataset.index);
        this.setData({
            curIndex: e,
            pageIndex: 1
        }), this.goodsOrder();
    }
});