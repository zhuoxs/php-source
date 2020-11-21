var app = getApp();

Page({
    data: {
        curIndex: 0,
        pagestyle: 1,
        page: 1,
        pagesize: 20
    },
    onLoad: function(a) {
        console.log(a);
        var e = this;
        if (app.look.istrue(a.pagestyle)) var t = a.pagestyle; else t = 1;
        e.setData({
            pagestyle: t
        }), 1 == t ? (wx.setNavigationBarTitle({
            title: "砍价"
        }), app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !1,
            data: {
                op: "bargain_list",
                page: e.data.page,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                console.log(t.data.list), t.data.list && e.setData({
                    list: t.data.list
                });
            },
            fail: function() {
                e.setData({
                    loadend: !0
                });
            }
        })) : 2 == t && (wx.setNavigationBarTitle({
            title: "我的砍价"
        }), app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !1,
            data: {
                op: "my_bargain_list",
                page: e.data.page,
                pagesize: e.data.pagesize
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
        }));
    },
    toBargainDetail: function(a) {
        console.log(a);
        var t = a.currentTarget.dataset.index, e = this.data.list;
        parseInt(e[t].number) >= parseInt(e[t].limit_num) || parseInt(e[t].stock <= 0) || wx.navigateTo({
            url: "../bargainDetail/bargainDetail?id=" + e[t].id + "&staus=1"
        });
    },
    toBuy: function(a) {
        app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !1,
            data: {
                op: "my_bargain_detail",
                id: a.target.dataset.id
            },
            success: function(a) {
                var t = a.data.data, e = [];
                e.push({
                    id: t.bargain.good_id,
                    img: t.bargain.img,
                    floor_price: t.bargain.floor_price,
                    name: t.bargain.good_name,
                    num: 1,
                    price: t.bargain_self.new_price,
                    attr_name: t.bargain.attr_name,
                    weight: t.bargain.weight
                });
                var i = [];
                i = {
                    content: e,
                    totalPrice: t.bargain_self.new_price,
                    totalNum: 1,
                    cid: 4,
                    bargain_self_id: t.bargain_self.id
                }, console.log(i), i = JSON.stringify(i), i = encodeURIComponent(i), wx.navigateTo({
                    url: "../submit/submit?order=" + i
                }), console.log(t);
            }
        });
    },
    changePagestyle: function(a) {
        var e = this, t = parseInt(a.currentTarget.dataset.pagestyle);
        this.setData({
            pagestyle: t,
            list: []
        }), 1 == e.data.pagestyle ? (wx.setNavigationBarTitle({
            title: "砍价"
        }), app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !0,
            data: {
                op: "bargain_list",
                page: 1,
                pagesize: e.data.pagesize
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
        })) : (wx.setNavigationBarTitle({
            title: "我的砍价"
        }), app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !0,
            data: {
                op: "my_bargain_list",
                page: 1,
                pagesize: e.data.pagesize
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
        }));
    },
    onReady: function() {
        app.util.footer(this), app.look.navbar(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var e = this;
        1 == e.data.pagestyle ? app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !0,
            data: {
                op: "bargain_list",
                page: 1,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                wx.stopPullDownRefresh();
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
        }) : app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !0,
            data: {
                op: "my_bargain_list",
                page: 1,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                wx.stopPullDownRefresh();
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
    onReachBottom: function() {
        if (!this.data.loadend) {
            var e = this;
            1 == e.data.pagestyle ? app.util.request({
                url: "entry/wxapp/goods",
                showLoading: !0,
                data: {
                    op: "bargain_list",
                    page: e.data.page + 1,
                    pagesize: e.data.pagesize
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
            }) : app.util.request({
                url: "entry/wxapp/goods",
                showLoading: !0,
                data: {
                    op: "my_bargain_list",
                    page: e.data.page,
                    pagesize: e.data.pagesize
                },
                success: function(a) {
                    var t = a.data;
                    t.data.list && e.setData({
                        list: e.data.list.concat(t.data.list),
                        page: e.data.page
                    });
                },
                fail: function() {
                    e.setData({
                        loadend: !0
                    });
                }
            });
        }
    },
    toIndex: function() {
        wx.redirectTo({
            url: "../index/index"
        });
    }
});