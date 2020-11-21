function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp(), Page = require("../../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        currentTab: 0
    },
    onLoad: function(t) {
        var a = t.nav;
        wx.setStorageSync("currentTab", a);
    },
    onReady: function() {},
    onShow: function() {
        var s = this, t = wx.getStorageSync("sid"), i = wx.getStorageSync("currentTab");
        app.util.request({
            url: "entry/wxapp/AdminGift",
            data: {
                sid: t
            },
            success: function(t) {
                console.log(t.data), s.setData({
                    list1: t.data.res1,
                    list2: t.data.res2
                });
                var a = t.data.res1, e = t.data.res2;
                if (0 == i) var n = 222 * a.length + 106; else n = 222 * e.length + 106;
                s.setData({
                    swiperH: n,
                    currentTab: i
                });
            }
        }), s.getUrl();
    },
    getUrl: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    bindKeyInpu1t: function(t) {
        var a = t.currentTarget.dataset.index, e = (this.data.list1, "list1[" + a + "].inputValue");
        this.setData(_defineProperty({}, e, t.detail.value));
    },
    noUse: function(t) {
        var a = this, e = t.currentTarget.dataset.id;
        1 == t.currentTarget.dataset.status ? wx.showModal({
            title: "提示",
            content: "确定将此礼物上架吗？",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/use",
                    data: {
                        id: e
                    },
                    success: function(t) {
                        a.onShow(), a.setData({
                            currentTab: 1
                        }), wx.showToast({
                            title: "上架成功！！",
                            icon: "success",
                            duration: 2e3
                        });
                    }
                });
            }
        }) : wx.showModal({
            title: "提示",
            content: "确定将此礼物下架吗？",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/noUse",
                    data: {
                        id: e
                    },
                    success: function(t) {
                        a.onShow(), a.setData({
                            currentTab: 0
                        }), wx.showToast({
                            title: "下架成功！！",
                            icon: "success",
                            duration: 2e3
                        });
                    }
                });
            }
        });
    },
    doNoUse: function(t) {
        var a = this, e = wx.getStorageSync("sid"), n = t.currentTarget.dataset.status, s = a.data.list1, i = a.data.list2;
        console.log(n), 1 == n ? 0 < s.length ? wx.showModal({
            title: "提示",
            content: "确定下架所有礼物吗？",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/doNoUse",
                    data: {
                        sid: e,
                        status: 1
                    },
                    success: function(t) {
                        a.onShow(), wx.showToast({
                            title: "一键下架成功！！",
                            icon: "success",
                            duration: 2e3
                        }), a.setData({
                            currentTab: 0
                        });
                    }
                });
            }
        }) : wx.showToast({
            title: "当前无可下架项！",
            icon: "none",
            duration: 2e3,
            mask: !0
        }) : 0 < i.length ? wx.showModal({
            title: "提示",
            content: "确定上架所有礼物吗？",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/doNoUse",
                    data: {
                        sid: e,
                        status: 2
                    },
                    success: function(t) {
                        a.onShow(), wx.showToast({
                            title: "一键上架成功！！",
                            icon: "success",
                            duration: 2e3
                        }), a.setData({
                            currentTab: 1
                        });
                    }
                });
            }
        }) : wx.showToast({
            title: "当前无可上架项！",
            icon: "none",
            duration: 2e3,
            mask: !0
        });
    },
    replenish: function(t) {
        var a = t.currentTarget.dataset.index, e = (t.currentTarget.dataset.id, this.data.list1), n = "list1[" + a + "].playBtn";
        console.log(n);
        for (var s = 0; s < e.length; s++) e[s].playBtn = !1, e[a].playBtn = !0;
        this.setData({
            list1: e
        });
    },
    replenish2: function(t) {
        var a = t.currentTarget.dataset.index, e = (t.currentTarget.dataset.id, this.data.list2), n = "list2[" + a + "].playBtn";
        console.log(n);
        for (var s = 0; s < e.length; s++) e[s].playBtn = !1, e[a].playBtn = !0;
        this.setData({
            list2: e
        });
    },
    addStock: function(t) {
        var a = this, e = t.currentTarget.dataset.index, n = t.currentTarget.dataset.id, s = a.data.count1;
        a.data.list1;
        if (console.log(s), null != s) app.util.request({
            url: "entry/wxapp/addNum",
            data: {
                id: n,
                count: s
            },
            success: function(t) {
                a.onShow();
            }
        }); else {
            var i = "list1[" + e + "].playBtn";
            a.setData(_defineProperty({}, i, !1));
        }
    },
    addStock2: function(t) {
        var a = this, e = t.currentTarget.dataset.index, n = t.currentTarget.dataset.id, s = a.data.count2;
        a.data.list2;
        if (null != s) app.util.request({
            url: "entry/wxapp/addNum",
            data: {
                id: n,
                count: s
            },
            success: function(t) {
                a.onShow();
            }
        }); else {
            var i = "list2[" + e + "].playBtn";
            a.setData(_defineProperty({}, i, !1));
        }
    },
    bindKeyInput1: function(t) {
        var a = t.detail.value;
        this.setData({
            count1: a
        });
    },
    bindKeyInput2: function(t) {
        var a = t.detail.value;
        this.setData({
            count2: a
        });
    },
    goDetail: function(t) {
        var a = t.currentTarget.dataset.id;
        console.log(a), wx.navigateTo({
            url: "../../../gift/giftlistdetail/giftlistdetail?id=" + a
        });
    },
    swichNav: function(t) {
        var a = this;
        if (this.data.currentTab === t.target.dataset.index) return !1;
        if (a.setData({
            currentTab: t.target.dataset.index
        }), 0 == t.target.dataset.index) {
            var e = 222 * a.data.list1.length + 106;
            a.setData({
                swiperH: e
            });
        } else {
            e = 222 * a.data.list2.length + 106;
            a.setData({
                swiperH: e
            });
        }
    },
    bindChange: function(t) {
        console.log(t);
        var a = this;
        if (a.setData({
            currentTab: t.detail.current
        }), 0 == t.detail.current) {
            var e = 222 * a.data.list1.length + 106;
            a.setData({
                swiperH: e
            });
        } else {
            e = 222 * a.data.list2.length + 106;
            a.setData({
                swiperH: e
            });
        }
    }
});