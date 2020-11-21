var cdInterval, app = getApp(), tool = require("../../../../style/utils/countDown.js");

Page({
    data: {
        navTile: "我的拼团",
        curIndex: 0,
        nav: [ "拼团中", "已拼成", "拼团失败" ],
        hasMore: !0
    },
    onLoad: function(t) {
        wx.setNavigationBarTitle({
            title: this.data.navTile
        }), this.get_group_list(t.status);
    },
    get_group_list: function(n) {
        var o = this, r = o.data.pageIndex || 1;
        n = n || 0, app.get_imgroot().then(function(e) {
            app.get_user_info().then(function(t) {
                o.setData({
                    user: t,
                    imgroot: e
                }), app.util.request({
                    url: "entry/wxapp/GetGroupOrders",
                    fromcache: !1,
                    data: {
                        user_id: t.id,
                        page: r,
                        status: n
                    },
                    success: function(t) {
                        if (console.log(r), 1 == r) o.setData({
                            groups: t.data
                        }); else {
                            for (var e = o.data.groups, a = 0; a < t.data.length; a++) e.push(t.data[a]);
                            o.setData({
                                groups: e
                            });
                        }
                        o.countDown(n), r += 1, o.setData({
                            pageIndex: r
                        }), t.data.length < 10 && o.setData({
                            hasMore: !1
                        });
                    }
                });
            });
        });
    },
    onReady: function() {},
    countDown: function(t) {
        var a = this, n = a.data.groups;
        console.log(cdInterval), clearInterval(cdInterval), 0 == t && (cdInterval = setInterval(function() {
            for (var t = 0; t < n.length; t++) {
                var e = tool.countDown(a, n[t].endtime);
                n[t].clock = e ? e[2] + " : " + e[3] + " : " + e[4] : "00 : 00 : 00", a.setData({
                    groups: n
                });
            }
        }, 1e3));
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var t = this, e = t.data.status;
        t.data.hasMore ? t.get_group_list(e) : wx.showToast({
            title: "没有更多数据啦",
            icon: "none",
            duration: 2500
        });
    },
    onShareAppMessage: function(t) {
        var e = t.target.dataset.index, a = this.data.groups[e], n = {};
        return n.title = a.title, n.path = "yzhyk_sun/pages/index/groupjoin/groupjoin?id=" + a.group_id, 
        n;
    },
    bargainTap: function(t) {
        var e = t.currentTarget.dataset.index;
        e != this.data.curIndex && (this.setData({
            curIndex: e,
            pageIndex: 1
        }), this.get_group_list(e));
    },
    toBuy: function(t) {
        var e = t.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "../../index/goodsDet/goodsDet?gid=" + e
        });
    },
    togroupdet: function(t) {
        var e = t.currentTarget.dataset.group_id;
        console.log(e), wx.navigateTo({
            url: "../groupdet/groupdet?id=" + e
        });
    },
    toCancel: function(t) {
        var e = this, a = t.currentTarget.dataset.index, n = e.data.groups[a];
        wx.showModal({
            title: "提示",
            content: "确定订单取消吗",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/CancelGroupOrder",
                    data: {
                        id: n.id
                    },
                    success: function(t) {
                        0 == t.data.code ? (e.get_group_list(), e.get_user_info(!1)) : wx.showModal({
                            title: "提示",
                            content: t.data.msg
                        });
                    }
                });
            }
        });
    },
    toDelete: function(t) {
        var e = this, a = t.currentTarget.dataset.index, n = t.currentTarget.dataset.id, o = e.data.groups;
        wx.showModal({
            title: "提示",
            content: "订单删除后将不再显示",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/DeleteGroupOrder",
                    cachetime: "0",
                    data: {
                        id: n
                    },
                    success: function(t) {
                        o.splice(a, 1), e.setData({
                            groups: o
                        });
                    }
                });
            }
        });
    }
});