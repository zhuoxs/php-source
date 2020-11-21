var app = getApp(), Toast = require("../../libs/zanui/toast/toast");

Page({
    data: {
        pages: 1,
        hide: !0,
        more: !0,
        refresh: !0
    },
    onLoad: function(t) {
        var a = this, e = wx.getStorageSync("loading_img");
        if (e ? a.setData({
            loadingImg: e
        }) : a.setData({
            loadingImg: "../../libs/images/loading.gif"
        }), app.viewCount(), t.type) a.setData({
            type: t.type
        }), a.getItemList(); else if (t.action) {
            var i = wx.getStorageSync("userInfo");
            a.setData({
                author: i.memberInfo.uid,
                action: t.action
            }), a.getItemList();
        } else a.showIconToast("参数错误");
    },
    onUnload: function() {
        var t = this;
        if (t.data.action && 0 < t.data.list.length) {
            t.checkAction(0);
        }
    },
    checkAction: function(a) {
        var e = this, t = e.data.list;
        a < t.length && app.util.request({
            url: "entry/wxapp/my",
            cachetime: "0",
            data: {
                act: "check_action",
                action: e.data.action,
                itemid: t[a].item_id,
                uid: t[a].uid,
                m: "superman_hand2"
            },
            success: function(t) {
                t.data.errno || (a++, e.checkAction(a));
            }
        });
    },
    getItemList: function() {
        var e = this;
        e.data.type ? app.util.request({
            url: "entry/wxapp/my",
            cachetime: "0",
            data: {
                act: "item_list",
                type: e.data.type,
                m: "superman_hand2"
            },
            success: function(t) {
                if (wx.setNavigationBarTitle({
                    title: "我发布的"
                }), t.data.errno) e.showIconToast(t.data.errmsg); else if (t.data.data.item) {
                    var a = t.data.data.item;
                    e.setData({
                        type: !0,
                        list: a,
                        pages: 1,
                        more: !0,
                        refresh: !0,
                        canSetTop: 1 == t.data.data.pay_item,
                        completed: !0
                    });
                }
            },
            fail: function(t) {
                e.setData({
                    completed: !0
                }), e.showIconToast(t.data.errmsg);
            }
        }) : e.data.action && app.util.request({
            url: "entry/wxapp/my",
            cachetime: "0",
            data: {
                act: "item_list",
                action: e.data.action,
                m: "superman_hand2"
            },
            success: function(t) {
                var a = "";
                1 == e.data.action ? a = "点赞" : 2 == e.data.action && (a = "收藏"), wx.setNavigationBarTitle({
                    title: a
                }), t.data.errno ? e.showIconToast(t.data.errmsg) : e.setData({
                    list: t.data.data.item ? t.data.data.item : [],
                    pages: 1,
                    more: !0,
                    refresh: !0,
                    completed: !0
                });
            },
            fail: function(t) {
                e.setData({
                    completed: !0
                }), e.showIconToast(t.data.errmsg);
            }
        });
    },
    toChat: function(t) {
        var a = this, e = t.currentTarget.dataset.id, i = t.currentTarget.dataset.uid;
        app.util.request({
            url: "entry/wxapp/my",
            cachetime: "0",
            data: {
                act: "init_chat",
                item_id: e,
                from_uid: i,
                m: "superman_hand2"
            },
            success: function(t) {
                t.data.errno ? a.showIconToast(t.data.errmsg) : wx.navigateTo({
                    url: "../chat/index?fromuid=" + i + "&itemid=" + e
                });
            }
        });
    },
    deleteItem: function(t) {
        var a = this, e = t.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/my",
            cachetime: "0",
            data: {
                act: "delete",
                id: e,
                m: "superman_hand2"
            },
            success: function(t) {
                t.data.errno ? a.showIconToast(t.data.errmsg) : (wx.pageScrollTo({
                    scrollTop: 0
                }), a.showIconToast("删除成功", "success"), a.getItemList());
            },
            fail: function(t) {
                a.showIconToast(t.data.errmsg);
            }
        });
    },
    stickItem: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../set_top/index?post=1&id=" + a
        });
    },
    checkLog: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../set_top/index?log=1&id=" + a
        });
    },
    onReachBottom: function() {
        var i = this;
        if (i.data.refresh) if (i.data.list.length < 20) i.setData({
            more: !1
        }); else {
            i.setData({
                hide: !1
            });
            var s = i.data.pages + 1, t = {
                act: "item_list",
                page: s,
                m: "superman_hand2"
            };
            i.data.action && (t.action = i.data.action), i.data.type && (t.type = i.data.type), 
            app.util.request({
                url: "entry/wxapp/my",
                cachetime: "0",
                data: t,
                success: function(t) {
                    if (i.setData({
                        hide: !0
                    }), 0 == t.data.errno) {
                        var a = t.data.data.item;
                        if (0 < a.length) {
                            var e = i.data.list.concat(a);
                            i.setData({
                                total: a.length,
                                list: e,
                                pages: s
                            });
                        } else i.setData({
                            more: !1,
                            refresh: !1
                        });
                    } else i.showIconToast(t.data.errmsg);
                },
                fail: function(t) {
                    i.showIconToast(t.data.errmsg);
                }
            });
        }
    },
    onPullDownRefresh: function() {
        this.getItemList(), wx.stopPullDownRefresh();
    },
    showIconToast: function(t) {
        var a = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "fail";
        Toast({
            type: a,
            message: t,
            selector: "#zan-toast"
        });
    }
});