var app = getApp();

Page({
    data: {
        nav: [ {
            id: 2,
            text: "竞拍中"
        }, {
            id: 4,
            text: "未拍中"
        }, {
            id: 3,
            text: "已拍中(待付款)"
        }, {
            id: 6,
            text: "待发货"
        }, {
            id: 7,
            text: "已发货"
        }, {
            id: 9,
            text: "已完成"
        } ],
        a: 2,
        state1: "正在参与竞拍",
        state2: "进行中",
        pro: []
    },
    onLoad: function(t) {
        var a = this, i = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: i,
            data: {
                vs1: 1
            },
            cachetime: "30",
            success: function(t) {
                t.data.data;
                a.setData({
                    baseinfo: t.data.data
                }), wx.setNavigationBarColor({
                    frontColor: a.data.baseinfo.base_tcolor,
                    backgroundColor: a.data.baseinfo.base_color
                }), wx.setNavigationBarTitle({
                    title: "订单中心"
                }), app.util.getUserInfo(a.getinfos, 0);
            }
        });
    },
    onReady: function() {
        this.visitwxapp(2, app.util.url("entry/wxapp/auctionjoinlog"));
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var t = {
            currentTarget: {
                dataset: {
                    id: this.data.a
                }
            }
        };
        this.select(t), wx.stopPullDownRefresh();
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    select: function(t) {
        var a = t.currentTarget.dataset.id;
        this.setData({
            a: a
        });
        var i = "";
        2 == a ? i = app.util.url("entry/wxapp/auctionjoinlog", {
            m: "sudu8_page_plugin_auction"
        }) : 3 == a ? i = app.util.url("entry/wxapp/auctionjoinlog", {
            m: "sudu8_page_plugin_auction"
        }) : 4 == a ? i = app.util.url("entry/wxapp/auctionjoinlog", {
            m: "sudu8_page_plugin_auction"
        }) : 6 == a ? i = app.util.url("entry/wxapp/auctionjoinlog", {
            m: "sudu8_page_plugin_auction"
        }) : 7 == a ? i = app.util.url("entry/wxapp/auctionjoinlog", {
            m: "sudu8_page_plugin_auction"
        }) : 9 == a && (i = app.util.url("entry/wxapp/auctionjoinlog", {
            m: "sudu8_page_plugin_auction"
        })), this.visitwxapp(a, i);
    },
    visitwxapp: function(t, a) {
        var i = this;
        i.setData({
            pro: {}
        });
        var n = wx.getStorageSync("openid");
        wx.request({
            url: a,
            data: {
                vs1: 1,
                openid: n,
                id: t
            },
            success: function(t) {
                wx.stopPullDownRefresh(), i.setData({
                    pro: t.data.data
                });
            },
            fail: function(t) {}
        });
    },
    togoodspage: function(t) {
        wx.navigateTo({
            url: "/sudu8_page_plugin_auction/auction_page/auction_page?id=" + t.currentTarget.id
        });
    },
    gotopay: function(t) {
        var a = t.detail.formId, i = t.currentTarget.id, n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/topay",
            data: {
                vs1: 1,
                openid: n,
                id: i,
                formid: a,
                tp: "buy"
            },
            success: function(t) {
                wx.showToast({
                    title: t.data.data.send
                });
            },
            fail: function(t) {}
        });
    },
    gotopaypage: function(t) {
        var a = {
            id: t.currentTarget.id,
            stat: 2
        };
        app.globalData.auction_id = t.currentTarget.id, wx.navigateTo({
            url: "/sudu8_page_plugin_auction/order_more/order_more?id=" + JSON.stringify(a)
        });
    },
    userconfirm: function(n) {
        var e = this;
        wx.showModal({
            title: "提示",
            content: "您确认收货吗？",
            success: function(t) {
                if (t.confirm) {
                    var a = n.currentTarget.id, i = wx.getStorageSync("openid");
                    app.util.request({
                        url: "entry/wxapp/userconfirm",
                        data: {
                            vs1: 1,
                            openid: i,
                            gid: a
                        },
                        success: function(t) {
                            if ("ok" == t.data.message) {
                                wx.showToast({
                                    title: "完成"
                                });
                                var a = {
                                    currentTarget: {
                                        dataset: {
                                            id: e.data.a
                                        }
                                    }
                                };
                                e.select(a);
                            }
                        },
                        fail: function(t) {}
                    });
                } else t.cancel && wx.showToast({
                    title: "取消收货"
                });
            }
        });
    },
    reminding: function(t) {
        var a = t.currentTarget.id, i = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/reminding",
            data: {
                vs1: 1,
                gid: a,
                openid: i
            },
            success: function(t) {
                wx.showToast({
                    title: "设置成功"
                });
            },
            fail: function(t) {}
        });
    }
});