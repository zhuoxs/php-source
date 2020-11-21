var app = getApp();

Page({
    data: {
        curIndex: 0,
        page: 1,
        pagesize: 20,
        loadend: !1,
        nav: [ {
            text: "全部"
        }, {
            text: "待付款"
        }, {
            text: "待发货"
        }, {
            text: "已发货"
        }, {
            text: "已退款"
        }, {
            text: "已完成"
        }, {
            text: "待退款"
        } ]
    },
    searchvalue: function(a) {
        this.setData({
            searchvale: a.detail.value
        });
    },
    search: function() {
        var a = this.data.searchvale, e = this;
        e.setData({
            curIndex: 0,
            list: []
        }), app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !1,
            data: {
                op: "orderlist",
                page: 1,
                pagesize: e.data.pagesize,
                search: a
            },
            success: function(a) {
                var t = a.data;
                t.data.list && e.setData({
                    list: t.data.list
                });
            },
            fail: function() {
                e.setData({
                    loadend: !0,
                    list: []
                });
            }
        });
    },
    toDetail: function(a) {
        wx.navigateTo({
            url: "../manageOrderDetail/manageOrderDetail?id=" + this.data.list[a.currentTarget.dataset.index].id
        });
    },
    toRefund: function(a) {
        wx.navigateTo({
            url: "../manageOrderDetail/manageOrderDetail?id=" + this.data.list[a.currentTarget.dataset.index].id
        });
    },
    bindTap: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData({
            curIndex: t,
            list: []
        });
        var e = this;
        app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !1,
            data: {
                op: "orderlist",
                page: 1,
                pagesize: e.data.pagesize,
                curindex: e.data.curIndex
            },
            success: function(a) {
                var t = a.data;
                t.data.list && e.setData({
                    list: t.data.list,
                    page: 1,
                    loadend: !1
                });
            },
            fail: function() {
                e.setData({
                    loadend: !0
                });
            }
        });
    },
    toSend: function(a) {
        wx.navigateTo({
            url: "../mSend/mSend?id=" + this.data.list[a.currentTarget.dataset.index].id
        });
    },
    toAddress: function(a) {
        var t = a.currentTarget.dataset.index, e = this.data.list;
        wx.navigateTo({
            url: "../manageAddress/manageAddress?id=" + e[t].id + "&name=" + e[t].name + "&phone=" + e[t].phone + "&region=" + e[t].region + "&detail=" + e[t].detail
        });
    },
    deleteList: function(a) {
        var t = a.currentTarget.dataset.index, e = this, i = this.data.list;
        wx.showModal({
            title: "提示",
            content: "确定取消订单",
            success: function(a) {
                a.confirm ? app.util.request({
                    url: "entry/wxapp/manage",
                    showLoading: !1,
                    data: {
                        op: "order_close",
                        id: i[t].id
                    },
                    success: function(a) {
                        app.look.ok(a.data.message), i.splice(t, 1), e.setData({
                            list: i
                        });
                    }
                }) : a.cancel && console.log("用户点击取消");
            }
        });
    },
    alterPrice: function(a) {
        wx.navigateTo({
            url: "../manageOrderDetail/manageOrderDetail?id=" + this.data.list[a.currentTarget.dataset.index].id
        });
    },
    onLoad: function(a) {
        var e = this;
        this.setData({
            curIndex: a.curIndex ? a.curIndex : 0
        }), app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !1,
            data: {
                op: "orderlist",
                page: e.data.page,
                pagesize: e.data.pagesize,
                curindex: e.data.curIndex
            },
            success: function(a) {
                var t = a.data;
                t.data.list && (console.log(t.data.list), e.setData({
                    list: t.data.list
                }));
            },
            fail: function() {
                e.setData({
                    loadend: !0
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !1,
            data: {
                op: "orderlist",
                page: 1,
                pagesize: e.data.pagesize,
                curindex: e.data.curIndex
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var t = a.data;
                t.data.list && (console.log(t.data.list), e.setData({
                    list: t.data.list,
                    page: 1,
                    loadend: !1
                }));
            },
            fail: function() {
                e.setData({
                    loadend: !0,
                    list: []
                });
            }
        });
    },
    onReachBottom: function() {
        if (!this.data.loadend) {
            var e = this;
            app.util.request({
                url: "entry/wxapp/manage",
                showLoading: !1,
                data: {
                    op: "orderlist",
                    page: e.data.page + 1,
                    pagesize: e.data.pagesize,
                    curindex: e.data.curIndex
                },
                success: function(a) {
                    var t = a.data;
                    t.data.list && e.setData({
                        list: e.data.list.concat(t.data.list),
                        page: e.data.page + 1
                    });
                },
                fail: function() {
                    e.setData({
                        loadend: !0
                    });
                }
            });
        }
    }
});