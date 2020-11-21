var a = getApp(), t = require("../common/common.js");

Page({
    data: {
        curr: 1,
        page: 1,
        pagesize: 20,
        isbottom: !1,
        menu_index: "",
        menu_list: "",
        p_curr: -1
    },
    tab: function(t) {
        var e = this, s = t.currentTarget.dataset.index;
        if (s != e.data.curr) {
            e.setData({
                curr: s,
                page: 1,
                isbottom: !1,
                list: []
            });
            var r = {
                op: "index",
                page: e.data.page,
                pagesize: e.data.pagesize,
                curr: e.data.curr
            };
            -1 != e.data.p_curr && (r.cid = e.data.pclass[e.data.p_curr].id), "" != e.data.shop && null != e.data.shop && (r.store = e.data.shop), 
            a.util.request({
                url: "entry/wxapp/manage",
                data: r,
                success: function(a) {
                    var t = a.data;
                    "" != t.data ? e.setData({
                        list: t.data,
                        page: e.data.page + 1
                    }) : e.setData({
                        isbottom: !0
                    });
                }
            });
        }
    },
    p_tab: function(t) {
        var e = this, s = t.currentTarget.dataset.index;
        if (s != e.data.p_curr) {
            e.setData({
                p_curr: s,
                list: [],
                page: 1,
                isbottom: !1
            });
            var r = {
                op: "index",
                page: e.data.page,
                pagesize: e.data.pagesize,
                curr: e.data.curr
            };
            -1 != e.data.p_curr && (r.cid = e.data.pclass[e.data.p_curr].id), a.util.request({
                url: "entry/wxapp/manage",
                data: r,
                success: function(a) {
                    var t = a.data;
                    "" != t.data ? e.setData({
                        list: t.data,
                        page: e.data.page + 1
                    }) : e.setData({
                        isbottom: !0
                    });
                }
            });
        }
    },
    choose: function(a) {
        var t = this, e = a.currentTarget.dataset.index, s = t.data.list, r = t.data.name_curr;
        2 == s[r].order[e].status ? s[r].order[e].status = 1 : s[r].order[e].status = 2, 
        t.setData({
            list: s
        });
    },
    call: function(a) {
        var t = this, e = a.currentTarget.dataset.index;
        "" != t.data.list[e].mobile && null != t.data.list[e].mobile ? wx.makePhoneCall({
            phoneNumber: t.data.list[e].mobile
        }) : wx.makePhoneCall({
            phoneNumber: t.data.list[e].userinfo.mobile
        });
    },
    menu_on: function(a) {
        var t = this, e = a.currentTarget.dataset.index;
        t.setData({
            menu: !0,
            shadow: !0,
            menu_index: e + 1,
            menu_list: t.data.list[e],
            menu_curr: t.data.curr
        });
    },
    menu_close: function() {
        this.setData({
            menu: !1,
            shadow: !1,
            menu2: !1,
            menu_index: "",
            menu_list: "",
            name_curr: ""
        });
    },
    menu_name: function(a) {
        var t = this, e = a.currentTarget.dataset.index;
        t.setData({
            menu2: !0,
            shadow: !0,
            name_curr: e
        });
    },
    submit: function() {
        var t = this, e = t.data.menu_list;
        -1 == e.use && wx.showModal({
            title: "提示",
            content: "确定核销吗？",
            success: function(s) {
                s.confirm ? a.util.request({
                    url: "entry/wxapp/manage",
                    data: {
                        op: "order_status",
                        id: e.id,
                        curr: t.data.menu_curr
                    },
                    success: function(a) {
                        if ("" != a.data.data) {
                            if ("" != t.data.menu_index && null != t.data.menu_index) {
                                var s = t.data.list;
                                1 == t.data.menu_curr || 2 == t.data.menu_curr ? (e.is_use = parseInt(e.is_use) + 1, 
                                s[t.data.menu_index - 1].is_use = e.is_use, parseInt(e.is_use) == parseInt(e.can_use) && (e.use = 1, 
                                s[t.data.menu_index - 1].use = 1), t.setData({
                                    list: s
                                })) : (e.use = 1, s[t.data.menu_index - 1].use = 1, t.setData({
                                    list: s
                                }));
                            }
                            t.setData({
                                menu_list: e
                            }), wx.showToast({
                                title: "核销成功",
                                icon: "success",
                                duration: 2e3
                            });
                        }
                    }
                }) : s.cancel && console.log("用户点击取消");
            }
        });
    },
    input: function(a) {
        this.setData({
            search: a.detail.value
        });
    },
    search: function() {
        var t = this, e = t.data.search;
        if (null != e && "" != e) {
            var s = {
                op: "search2",
                content: e
            };
            "" != t.data.shop && null != t.data.shop && (s.store = t.data.shop), a.util.request({
                url: "entry/wxapp/manage",
                data: s,
                success: function(a) {
                    var e = a.data;
                    "" != e.data && t.setData({
                        menu_list: e.data.list,
                        menu_curr: e.data.curr,
                        shadow: !0,
                        menu: !0
                    });
                }
            });
        } else wx.showModal({
            title: "错误",
            content: "请输入订单号或姓名",
            success: function(a) {
                a.confirm ? console.log("用户点击确定") : a.cancel && console.log("用户点击取消");
            }
        });
    },
    scan: function() {
        var t = this;
        wx.scanCode({
            onlyFromCamera: !0,
            success: function(e) {
                var s = {
                    op: "search",
                    content: e.result
                };
                "" != t.data.shop && null != t.data.shop && (s.store = t.data.shop), a.util.request({
                    url: "entry/wxapp/manage",
                    data: s,
                    success: function(a) {
                        var e = a.data;
                        "" != e.data && t.setData({
                            menu_list: e.data.list,
                            menu_curr: e.data.curr,
                            shadow: !0,
                            menu: !0
                        });
                    }
                });
            }
        });
    },
    sign: function() {
        var t = this, e = t.data.list, s = t.data.name_curr, r = [];
        if ("" != e[s].order && null != e[s].order) for (var n = 0; n < e[s].order.length; n++) 2 == e[s].order[n].status && r.push(e[s].order[n].id);
        r.length > 0 ? a.util.request({
            url: "entry/wxapp/manage",
            data: {
                op: "sign",
                id: JSON.stringify(r)
            },
            success: function(a) {
                if ("" != a.data.data) {
                    for (var r = 0; r < e[s].order.length; r++) 2 == e[s].order[r].status && (e[s].order[r].is_use = parseInt(e[s].order[r].is_use) + 1, 
                    e[s].order[r].status = 1);
                    t.setData({
                        list: e
                    }), wx.showToast({
                        title: "核销成功",
                        icon: "success",
                        duration: 2e3
                    });
                }
            }
        }) : wx.showModal({
            title: "错误",
            content: "请选择学员"
        });
    },
    submit2: function() {
        var t = this, e = t.data.menu_list;
        a.util.request({
            url: "entry/wxapp/manage",
            data: {
                op: "order_status2",
                id: e.id
            },
            success: function(a) {
                if ("" != a.data.data) {
                    if ("" != t.data.menu_index && null != t.data.menu_index) {
                        var s = t.data.list;
                        s[t.data.menu_index - 1].order_status = 1, t.setData({
                            list: s
                        });
                    }
                    e.order_status = 1, t.setData({
                        menu_list: e
                    }), wx.showToast({
                        title: "核销成功",
                        icon: "success",
                        duration: 2e3
                    });
                }
            }
        });
    },
    onLoad: function(e) {
        var s = this;
        t.config(s), t.theme(s), "" != e.shop && null != e.shop && (s.setData({
            shop: e.shop
        }), a.util.request({
            url: "entry/wxapp/index",
            data: {
                op: "school_detail",
                id: e.shop
            },
            success: function(a) {
                var t = a.data;
                "" != t.data && (wx.setNavigationBarTitle({
                    title: t.data.name
                }), s.setData({
                    shop_list: t.data
                }));
            }
        })), a.util.request({
            url: "entry/wxapp/user",
            data: {
                op: "userinfo"
            },
            showLoading: !1,
            success: function(a) {
                var t = a.data;
                "" != t.data && s.setData({
                    userinfo: t.data
                });
            }
        });
        var r = {
            op: "index",
            page: s.data.page,
            pagesize: s.data.pagesize,
            curr: s.data.curr
        };
        "" != e.shop && null != e.shop && (r.store = e.shop), a.util.request({
            url: "entry/wxapp/manage",
            data: r,
            success: function(a) {
                var t = a.data;
                "" != t.data ? s.setData({
                    list: t.data,
                    page: s.data.page + 1
                }) : s.setData({
                    isbottom: !0
                });
            }
        }), a.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "service_class",
                type: 1
            },
            success: function(a) {
                var t = a.data;
                "" != t.data && s.setData({
                    pclass: t.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        t.audio_end(this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var t = this;
        t.setData({
            page: 1,
            isbottom: !1
        });
        var e = {
            op: "index",
            page: t.data.page,
            pagesize: t.data.pagesize,
            curr: t.data.curr
        };
        -1 != t.data.p_curr && (e.cid = t.data.pclass[t.data.p_curr].id), "" != t.data.shop && null != t.data.shop && (e.store = t.data.shop), 
        a.util.request({
            url: "entry/wxapp/manage",
            data: e,
            success: function(a) {
                var e = a.data;
                "" != e.data ? (wx.stopPullDownRefresh(), t.setData({
                    list: e.data,
                    page: t.data.page + 1
                })) : t.setData({
                    isbottom: !0
                });
            }
        });
    },
    onReachBottom: function() {
        var t = this;
        if (!t.data.isbottom) {
            var e = {
                op: "index",
                page: t.data.page,
                pagesize: t.data.pagesize,
                curr: t.data.curr
            };
            -1 != t.data.p_curr && (e.cid = t.data.pclass[t.data.p_curr].id), "" != t.data.shop && null != t.data.shop && (e.store = t.data.shop), 
            a.util.request({
                url: "entry/wxapp/manage",
                data: e,
                success: function(a) {
                    var e = a.data;
                    "" != e.data ? t.setData({
                        list: t.data.list.concat(e.data),
                        page: t.data.page + 1
                    }) : t.setData({
                        isbottom: !0
                    });
                }
            });
        }
    }
});