var app = getApp();

Page({
    data: {
        page: 1,
        pagesize: 20,
        loadend: !1,
        cid: 0,
        staus: 1,
        style: "",
        nav: !1,
        sortsPrice: 0,
        srotsSales: 0,
        tagid: 0,
        oblong: "../../../images/list/oblong.png",
        square: "../../../images/list/square.png",
        third: "../../../images/list/third.png",
        sale: [],
        menu: []
    },
    close_nav: function() {
        this.setData({
            nav: !1
        });
    },
    switchnav: function() {
        this.setData({
            nav: !this.data.nav
        });
    },
    changeclass: function(a) {
        var s = this, e = a.currentTarget.dataset.id;
        this.setData({
            nav: !1,
            sortsPrice: 0,
            srotsSales: 0
        }), app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !0,
            method: "POST",
            data: {
                op: "list",
                page: 1,
                pagesize: s.data.pagesize,
                cid: e
            },
            success: function(a) {
                var t = a.data;
                t.data.goods && s.setData({
                    sale: t.data.goods,
                    page: 2,
                    cid: e,
                    loadend: !1
                });
            },
            fail: function(a) {
                wx.showToast({
                    title: a.data.message,
                    icon: "none"
                }), s.setData({
                    loadend: !0,
                    sale: [],
                    page: 1,
                    cid: e
                });
            }
        });
    },
    changestyle: function(a) {
        var t = a.currentTarget.dataset.value;
        this.setData({
            staus: t
        }), app.sale.rownum = t;
    },
    srotsSales: function(a) {
        var t = this.data.srotsSales, s = this.data.cid, e = this.data.tagid, o = this;
        0 == t || 2 == t ? app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !0,
            method: "POST",
            data: {
                op: "list",
                page: 1,
                pagesize: o.data.pagesize,
                cid: s,
                srotsSales: 1,
                tagid: e
            },
            success: function(a) {
                var t = a.data;
                t.data.goods && o.setData({
                    sale: t.data.goods,
                    nav: !1,
                    sortsPrice: 0,
                    srotsSales: 1,
                    page: 2,
                    loadend: !1
                });
            },
            fail: function() {
                o.setData({
                    sale: [],
                    nav: !1,
                    sortsPrice: 0,
                    srotsSales: 1,
                    loadend: !0
                });
            }
        }) : app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !0,
            method: "POST",
            data: {
                op: "list",
                page: 1,
                pagesize: o.data.pagesize,
                cid: s,
                srotsSales: 2
            },
            success: function(a) {
                var t = a.data;
                t.data.goods && o.setData({
                    sale: t.data.goods,
                    nav: !1,
                    sortsPrice: 0,
                    srotsSales: 2,
                    page: 2,
                    loadend: !1
                });
            },
            fail: function() {
                o.setData({
                    sale: [],
                    nav: !1,
                    sortsPrice: 0,
                    srotsSales: 2,
                    loadend: !0
                });
            }
        });
    },
    sortsPrice: function() {
        var s = this, a = this.data.sortsPrice, t = this.data.cid, e = this.data.tagid;
        0 == a || 2 == a ? app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !0,
            method: "POST",
            data: {
                op: "list",
                page: 1,
                pagesize: s.data.pagesize,
                cid: t,
                sortsPrice: 1,
                tagid: e
            },
            success: function(a) {
                var t = a.data;
                t.data.goods && s.setData({
                    sale: t.data.goods,
                    nav: !1,
                    sortsPrice: 1,
                    srotsSales: 0,
                    page: 2,
                    loadend: !1
                });
            },
            fail: function() {
                s.setData({
                    sale: [],
                    nav: !1,
                    sortsPrice: 1,
                    srotsSales: 0,
                    loadend: !0
                });
            }
        }) : app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !0,
            method: "POST",
            data: {
                op: "list",
                page: 1,
                pagesize: s.data.pagesize,
                cid: t,
                sortsPrice: 2
            },
            success: function(a) {
                var t = a.data;
                t.data.goods && s.setData({
                    sale: t.data.goods,
                    nav: !1,
                    sortsPrice: 2,
                    srotsSales: 0,
                    page: 2,
                    loadend: !1
                });
            },
            fail: function() {
                s.setData({
                    sale: [],
                    nav: !1,
                    sortsPrice: 2,
                    srotsSales: 0,
                    loadend: !0
                });
            }
        });
    },
    tosearch: function() {
        wx.navigateTo({
            url: "../search/search"
        });
    },
    showAll: function(a) {
        var s = this, t = parseInt(a.currentTarget.dataset.index);
        this.setData({
            nav: !1,
            curIndex: t
        }), app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !0,
            method: "POST",
            data: {
                op: "list",
                page: 1,
                pagesize: s.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                t.data.goods && s.setData({
                    sale: t.data.goods,
                    page: s.data.page + 1,
                    cid: 0,
                    loadend: !1
                });
            },
            fail: function(a) {
                wx.showToast({
                    title: a.data.message,
                    icon: "none"
                }), s.setData({
                    loadend: !0,
                    sale: [],
                    page: 1,
                    cid: 0
                });
            }
        });
    },
    onLoad: function(a) {
        console.log(a);
        var s = this;
        app.look.istrue(a.tagid) && s.setData({
            tagid: a.tagid
        }), app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !1,
            method: "POST",
            data: {
                op: "category"
            },
            success: function(a) {
                var t = a.data;
                t.data.category && s.setData({
                    menu: t.data.category
                });
            }
        }), app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !1,
            method: "POST",
            data: {
                op: "list",
                page: s.data.page,
                pagesize: s.data.pagesize,
                cid: s.data.cid,
                tagid: s.data.tagid
            },
            success: function(a) {
                var t = a.data;
                console.log(t), t.data.goods && s.setData({
                    sale: t.data.goods,
                    page: s.data.page + 1
                });
            },
            fail: function(a) {
                wx.showToast({
                    title: a.data.message,
                    icon: "none"
                }), s.setData({
                    loadend: !0
                });
            }
        }), this.setData({
            staus: app.sale.rownum
        }), null != app.globalData.webset && 1 == app.globalData.webset.list_type ? this.setData({
            style: "style"
        }) : this.setData({
            style: ""
        });
    },
    onReady: function() {
        app.look.footer(this), app.look.navbar(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var s = this;
        app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !0,
            method: "POST",
            data: {
                op: "list",
                page: 1,
                pagesize: s.data.pagesize,
                cid: s.data.cid,
                tagid: s.data.tagid
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var t = a.data;
                t.data.goods && s.setData({
                    sale: t.data.goods,
                    page: 2,
                    loadend: !1
                });
            },
            fail: function(a) {
                wx.showToast({
                    title: a.data.message,
                    icon: "none"
                }), s.setData({
                    loadend: !0,
                    sale: []
                });
            }
        });
    },
    onReachBottom: function() {
        var s = this;
        this.data.loadend || app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !0,
            method: "POST",
            data: {
                op: "list",
                page: s.data.page,
                pagesize: s.data.pagesize,
                cid: s.data.cid,
                sortsPrice: s.data.sortsPrice,
                srotsSales: s.data.srotsSales,
                tagid: s.data.tagid
            },
            success: function(a) {
                var t = a.data;
                t.data.goods && s.setData({
                    sale: s.data.sale.concat(t.data.goods),
                    page: s.data.page + 1,
                    loadend: !1
                });
            },
            fail: function(a) {
                wx.showToast({
                    title: a.data.message,
                    icon: "none"
                }), s.setData({
                    loadend: !0
                });
            }
        });
    },
    onGotUserInfo: function(a) {
        app.look.getuserinfo(a, this);
    },
    onShareAppMessage: function(a) {
        wx.showShareMenu({
            withShareTicket: !0
        });
        var t = "", s = "";
        if (app.look.istrue(app.globalData.webset.webname) && (s = app.globalData.webset.webname), 
        "menu" == a.from) return t = "/" + this.route, {
            title: s,
            path: "/xc_xinguwu/pages/base/base?share=" + (t = encodeURIComponent(t)) + "&userid=" + app.globalData.userInfo.id,
            imageUrl: "",
            success: function(a) {
                wx.showToast({
                    title: "转发成功"
                });
            },
            fail: function(a) {}
        };
    }
});