var app = getApp();

Page({
    data: {
        currentTab: 0,
        typesetting1: !0,
        typesettin2: !1,
        page: 1,
        swith: !0
    },
    onLoad: function(t) {
        var a = this;
        t.id && (console.log(t), this.setData({
            cateid: t.id
        })), t.id ? app.util.request({
            url: "entry/wxapp/getcategoods",
            data: {
                cateid: t.id,
                curetindex: 0
            },
            success: function(t) {
                console.log(t), 2 == t.data ? a.setData({
                    categoryPageList: []
                }) : a.setData({
                    categoryPageList: t.data
                });
            }
        }) : app.util.request({
            url: "entry/wxapp/getcategoods",
            data: {
                curetindex: 0
            },
            success: function(t) {
                console.log(t), 2 == t.data ? a.setData({
                    categoryPageList: []
                }) : a.setData({
                    categoryPageList: t.data
                });
            }
        }), this.onAllCassifications(), this.getBase();
    },
    onSwitchTypesetting: function() {
        this.setData({
            typesetting1: !this.data.typesetting1,
            typesetting2: !this.data.typesetting2
        });
    },
    onCategoryPage: function(t) {
        var a = this;
        a.setData({
            page: 1
        }), t && a.data.currentTab !== t.currentTarget.dataset.tabid && a.setData({
            currentTab: t.currentTarget.dataset.tabid
        });
        var e = t.currentTarget.dataset.tabid;
        0 == e || 1 == e ? a.setData({
            swith: !0
        }) : 2 == e ? a.setData({
            swith: !a.data.swith
        }) : 3 == e && a.setData({
            swith: !a.data.swith
        }), a.data.cateid ? app.util.request({
            url: "entry/wxapp/getcategoods",
            data: {
                cateid: a.data.cateid,
                curetindex: e
            },
            success: function(t) {
                console.log(t), 2 == t.data ? a.setData({
                    categoryPageList: []
                }) : a.setData({
                    categoryPageList: t.data
                });
            }
        }) : app.util.request({
            url: "entry/wxapp/getcategoods",
            data: {
                curetindex: e
            },
            success: function(t) {
                console.log(t), 2 == t.data ? a.setData({
                    categoryPageList: []
                }) : a.setData({
                    categoryPageList: t.data
                });
            }
        });
    },
    onAllCassificationsData: function(t) {
        var a = this;
        a.setData({
            page: 1
        }), a.setData({
            cateid: t.currentTarget.dataset.cateid
        }), app.util.request({
            url: "entry/wxapp/getcategoods",
            data: {
                cateid: a.data.cateid,
                curetindex: a.data.currentTab
            },
            success: function(t) {
                console.log(t), 2 == t.data ? a.setData({
                    categoryPageList: []
                }) : a.setData({
                    categoryPageList: t.data
                });
            }
        });
    },
    onSearch: function(t) {
        var a = this;
        console.log(t.detail.value), console.log(a.data.cateid), app.util.request({
            url: "entry/wxapp/getcatesearch",
            data: {
                cateid: a.data.cateid,
                keywords: t.detail.value
            },
            success: function(t) {
                console.log(t), 2 == t.data ? a.setData({
                    categoryPageList: []
                }) : a.setData({
                    categoryPageList: t.data
                });
            }
        });
    },
    onAllCassifications: function() {
        var c = this;
        app.util.request({
            url: "entry/wxapp/getAllCate",
            data: {},
            success: function(t) {
                if (2 != t.data) {
                    console.log(t);
                    for (var a = t.data, e = a.length, s = e % 5 == 0 ? e / 5 : Math.floor(e / 5 + 1), n = [], o = 0; o < s; o++) {
                        var i = a.slice(5 * o, 5 * o + 5);
                        n.push(i);
                    }
                    console.log(n), c.setData({
                        cassificationsList: n
                    });
                }
            }
        });
    },
    getBase: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/system",
            data: {},
            success: function(t) {
                console.log(t), a.setData({
                    catetopbg: t.data.catetopbg
                });
            }
        });
    },
    putongbon: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../index/goods/goods?gid=" + a
        });
    },
    ptbon: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../index/groupdet/groupdet?id=" + a
        });
    },
    kjbon: function(t) {
        var a = t.currentTarget.dataset.id;
        console.log(a), wx.navigateTo({
            url: "../index/bardet/bardet?id=" + a
        });
    },
    qgbon: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../index/package/package?id=" + a
        });
    },
    mdbon: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../index/freedet/freedet?id=" + a
        });
    },
    jkbon: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../index/cardsdet/cardsdet?gid=" + a
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var e = this, s = e.data.page, n = e.data.categoryPageList;
        e.data.cateid ? app.util.request({
            url: "entry/wxapp/getcategoods",
            data: {
                page: s,
                cateid: e.data.cateid,
                curetindex: e.data.currentTab
            },
            success: function(t) {
                if (console.log(t.data), 0 < t.data.length) {
                    var a = t.data;
                    n = n.concat(a), e.setData({
                        categoryPageList: n,
                        page: s + 1
                    });
                } else wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                });
            }
        }) : app.util.request({
            url: "entry/wxapp/getcategoods",
            data: {
                page: s,
                curetindex: e.data.currentTab
            },
            success: function(t) {
                if (console.log(t.data), 0 < t.data.length) {
                    var a = t.data;
                    n = n.concat(a), e.setData({
                        categoryPageList: n,
                        page: s + 1
                    });
                } else wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                });
            }
        });
    },
    onShareAppMessage: function() {}
});