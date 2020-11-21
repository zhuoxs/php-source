var app = getApp();

Page({
    data: {
        navTile: "我发起的砍价",
        curIndex: 0,
        nav: [ "正在砍价中", "已完成" ],
        curBargain: [],
        curPage: 1,
        state: 0
    },
    onLoad: function(t) {
        var e = this, a = t.index ? t.index : 0;
        e.setData({
            curIndex: a,
            state: a
        }), wx.setNavigationBarTitle({
            title: e.data.navTile
        }), app.get_imgroot().then(function(a) {
            app.get_user_info().then(function(t) {
                e.setData({
                    imgroot: a,
                    user: t
                }), e.updategoods();
            });
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        this.data.hasMore ? this.updategoods() : wx.showToast({
            title: "没有更多数据啦~",
            icon: "none"
        });
    },
    onShareAppMessage: function(t) {
        var a = t.target.dataset.index, e = this.data.goodsList[a], o = {};
        return o.title = e.title, o.path = "yzhyk_sun/pages/index/help/help?id=" + e.id, 
        o.success = function() {
            console.log("成功");
        }, o.fail = function() {
            console.log("失败");
        }, o;
    },
    bargainTap: function(t) {
        var a = parseInt(t.currentTarget.dataset.index);
        this.setData({
            curIndex: a,
            state: a,
            curPage: 1
        }), this.updategoods();
    },
    toBuy: function(t) {
        var a = t.currentTarget.dataset.index, e = this.data.goodsList[a];
        app.group_cart_clear(), app.group_cart_add({
            id: e.storecutgoods_id,
            price: parseFloat(e.shopprice - e.cut_price, 2),
            src: e.pic,
            num: 1,
            title: e.title
        }), wx.navigateTo({
            url: "../../index/cforder3/cforder3?iscut=1&cut_id=" + e.id
        });
    },
    toCancel: function(t) {
        var a = this, e = t.currentTarget.dataset.index, o = a.data.goodsList[e];
        wx.showModal({
            title: "提示",
            content: "订单删除后将不再显示",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/DeleteCut",
                    cachetime: "0",
                    data: {
                        id: o.id
                    },
                    success: function(t) {
                        0 == t.data.code ? a.updategoods() : wx.showModal({
                            title: "提示",
                            content: t.data.msg
                        });
                    }
                });
            }
        });
    },
    updategoods: function() {
        var o = this, n = o.data.curPage, t = o.data.user.id, a = o.data.state;
        app.util.request({
            url: "entry/wxapp/GetCuts",
            cachetime: "0",
            data: {
                state: a,
                page: n,
                user_id: t
            },
            success: function(t) {
                if (1 == n) var a = {}; else a = o.data.goodsList;
                for (var e in t.data) {
                    a["id_" + t.data[e].id] = t.data[e];
                }
                o.setData({
                    goodsList: a,
                    curPage: n + 1
                }), t.data.length < 10 && o.setData({
                    hasMore: !1
                });
            }
        });
    },
    toInfo: function(t) {
        var a = t.currentTarget.dataset.index, e = this.data.goodsList[a];
        wx.navigateTo({
            url: "/yzhyk_sun/pages/index/bardet/bardet?id=" + e.storecutgoods_id
        });
    }
});