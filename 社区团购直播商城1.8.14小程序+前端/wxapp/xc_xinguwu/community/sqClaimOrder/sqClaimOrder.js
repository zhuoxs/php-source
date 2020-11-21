function _defineProperty(a, t, e) {
    return t in a ? Object.defineProperty(a, t, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = e, a;
}

var app = getApp();

function getOrderNum(t) {
    app.util.request({
        url: "entry/wxapp/community",
        showLoading: !1,
        method: "POST",
        data: {
            op: "getOrderNum",
            style: t.data.style,
            club_id: t.data.options.club_id
        },
        success: function(a) {
            console.log(a), t.setData({
                num: a.data.data
            });
        }
    });
}

Page({
    data: {
        curIndex: 1,
        page: 1,
        pagesize: 20,
        loadend: !1,
        value: "",
        shadow: !1
    },
    delivery: function(a) {
        this.setData({
            index: a.currentTarget.dataset.index,
            shadow: !0,
            sureGet: !0
        });
    },
    orderVer: function(a) {
        this.setData({
            index: a.currentTarget.dataset.index,
            shadow: !0,
            ver: !0
        });
    },
    cancel: function() {
        this.setData({
            shadow: !1,
            sureGet: !1,
            ver: !1
        });
    },
    makesure: function() {
        var e = this, a = e.data.list[e.data.index].id;
        app.util.request({
            url: "entry/wxapp/community",
            showLoading: !0,
            method: "POST",
            data: {
                op: "sureShouh",
                id: a
            },
            success: function(a) {
                if (app.look.ok(a.data.message), e.setData({
                    shadow: !1,
                    sureGet: !1,
                    ver: !1
                }), e.setData({
                    num: e.data.num - 1
                }), 1 == e.data.curIndex) e.setData(_defineProperty({}, "list[" + e.data.index + "].status", 5)); else {
                    var t = e.data.list;
                    t.splice(e.data.index, 1), e.setData({
                        list: t
                    });
                }
            }
        }), this.setData({
            shadow: !1,
            sureGet: !1,
            ver: !1
        });
    },
    contactSeller: function(a) {
        wx.makePhoneCall({
            phoneNumber: a.currentTarget.dataset.value
        });
    },
    change: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData({
            curIndex: t,
            list: [],
            value: ""
        });
        var e = this;
        app.util.request({
            url: "entry/wxapp/community",
            showLoading: !0,
            method: "POST",
            data: {
                op: "loadClubOrder",
                page: 1,
                pagesize: e.data.pagesize,
                curIndex: e.data.curIndex,
                style: e.data.style,
                club_id: e.data.options.club_id
            },
            success: function(a) {
                var t = a.data;
                t.data.list && e.setData({
                    list: t.data.list,
                    loadend: !1,
                    page: 1
                });
            },
            fail: function(a) {
                app.look.alert(a.data.message), e.setData({
                    loadend: !0
                });
            }
        });
    },
    bindDateChange: function(a) {
        this.setData({
            value: a.detail.value
        });
    },
    search: function(a) {
        var t = a.detail.value;
        if ("" != t) {
            var e = this;
            app.util.request({
                url: "entry/wxapp/community",
                showLoading: !0,
                method: "POST",
                data: {
                    op: "loadClubOrder",
                    page: 1,
                    pagesize: e.data.pagesize,
                    curIndex: 1,
                    style: e.data.style,
                    club_id: e.data.options.club_id,
                    order: t
                },
                success: function(a) {
                    e.setData({
                        list: a.data.data.list,
                        loadend: !0
                    });
                },
                fail: function(a) {
                    app.look.alert("没有查询到"), e.setData({
                        loadend: !1,
                        list: []
                    });
                }
            });
        }
    },
    cancelAfterVerify: function() {
        var e = this, a = e.data.list[e.data.index].id;
        app.util.request({
            url: "entry/wxapp/community",
            showLoading: !1,
            method: "get",
            data: {
                op: "cancelAfterVerify",
                id: a
            },
            success: function(a) {
                if (app.look.ok(a.data.message), e.setData({
                    ver: !1,
                    shadow: !1
                }), e.setData({
                    num: e.data.num - 1
                }), 1 == e.data.curIndex) e.setData(_defineProperty({}, "list[" + e.data.index + "].community_status", 2)); else {
                    var t = e.data.list;
                    t.splice(e.data.index, 1), e.setData({
                        list: t
                    });
                }
            },
            fail: function(a) {
                app.look.no(a.data.message);
            }
        });
    },
    scan: function() {
        var e = this;
        wx.scanCode({
            onlyFromCamera: !1,
            success: function(a) {
                console.log(a);
                var t = a.result;
                t = t.split("#"), app.util.request({
                    url: "entry/wxapp/community",
                    showLoading: !0,
                    method: "POST",
                    data: {
                        op: "scanHex",
                        hex: t[0],
                        order: t[1]
                    },
                    success: function(a) {
                        if (app.look.ok(a.data.message), e.setData({
                            ver: !1,
                            shadow: !1
                        }), e.setData({
                            num: e.data.num - 1
                        }), 1 == e.data.curIndex) e.setData(_defineProperty({}, "list[" + e.data.index + "].community_status", 2)); else {
                            var t = e.data.list;
                            t.splice(e.data.index, 1), e.setData({
                                list: t
                            });
                        }
                    },
                    fail: function(a) {
                        app.look.no(a.data.message);
                    }
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    onLoad: function(a) {
        this.setData({
            style: a.style,
            webset: app.globalData.webset,
            options: a
        });
        var e = this;
        app.util.request({
            url: "entry/wxapp/community",
            showLoading: !1,
            method: "POST",
            data: {
                op: "loadClubOrder",
                page: 1,
                pagesize: e.data.pagesize,
                curIndex: e.data.curIndex,
                style: e.data.style,
                club_id: e.data.options.club_id
            },
            success: function(a) {
                var t = a.data;
                t.data.list && (console.log(t.data.list), e.setData({
                    list: t.data.list
                }));
            },
            fail: function(a) {
                app.look.alert(a.data.message), e.setData({
                    loadend: !0
                });
            }
        });
    },
    onReady: function() {
        var a = {};
        a.sq_date_icon = app.module_url + "resource/wxapp/community/sq-date-icon.png", a.sq_gcall = app.module_url + "resource/wxapp/community/sq-gcall.png", 
        a.sq_mem_pos = app.module_url + "resource/wxapp/community/sq-mem-pos.png", a.sq_get = app.module_url + "resource/wxapp/community/sq-get.png", 
        this.setData({
            images: a
        }), 1 == this.data.style ? wx.setNavigationBarTitle({
            title: "收货订单"
        }) : wx.setNavigationBarTitle({
            title: "取货订单"
        }), getOrderNum(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var e = this;
        this.setData({
            value: ""
        }), app.util.request({
            url: "entry/wxapp/community",
            showLoading: !0,
            method: "POST",
            data: {
                op: "loadClubOrder",
                page: 1,
                pagesize: e.data.pagesize,
                curIndex: e.data.curIndex,
                style: e.data.style,
                club_id: e.data.options.club_id
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
            fail: function(a) {
                app.look.alert(a.data.message), e.setData({
                    loadend: !0
                });
            }
        });
    },
    onReachBottom: function() {
        if (!this.data.loadend) {
            var e = this;
            app.util.request({
                url: "entry/wxapp/community",
                showLoading: !0,
                method: "POST",
                data: {
                    op: "loadClubOrder",
                    page: e.data.page + 1,
                    pagesize: e.data.pagesize,
                    curIndex: e.data.curIndex,
                    style: e.data.style,
                    club_id: e.data.options.club_id
                },
                success: function(a) {
                    var t = a.data;
                    t.data.list && e.setData({
                        list: e.data.list.concat(t.data.list),
                        page: e.data.page + 1
                    });
                },
                fail: function(a) {
                    app.look.alert(a.data.message), e.setData({
                        loadend: !0
                    });
                }
            });
        }
    }
});