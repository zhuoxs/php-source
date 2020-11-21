function t(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

function a(t) {
    var a = t.data.name, e = t.data.mobile, n = t.data.store_id;
    "" != n && null != n || (i = !1);
    var i = !0;
    "" != t.data.pid && null != t.data.pid || "" != t.data.cut && null != t.data.cut || (i = !1);
    var s = t.data.sign_config;
    1 == s.name_status && ("" != a && null != a || (i = !1)), 1 == s.mobile_status && ("" != e && null != e || (i = !1), 
    /^[1][0-9]{10}$/.test(e) || (i = !1)), t.setData({
        submit: i
    });
}

function e(t, a) {
    t.appId;
    var e = t.timeStamp.toString(), n = t.package, i = t.nonceStr, s = t.paySign.toUpperCase();
    wx.requestPayment({
        timeStamp: e,
        nonceStr: i,
        package: n,
        signType: "MD5",
        paySign: s,
        success: function(t) {
            wx.showToast({
                title: "支付成功",
                icon: "success",
                duration: 2e3
            }), setTimeout(function() {
                wx.reLaunch({
                    url: "../index/index"
                });
            }, 2e3);
        },
        fail: function(t) {}
    });
}

var n = getApp(), i = require("../common/common.js");

Page({
    data: {
        submit: !1,
        coupon_curr: -1,
        page: 1,
        pagesize: 20,
        isbottom: !1,
        team_page: 1,
        team_pagesize: 20,
        team_isbottom: !1,
        is_load: !1,
        cut: ""
    },
    team_on: function() {
        this.setData({
            team_pages: !0
        });
    },
    team_close: function() {
        this.setData({
            team_pages: !1
        });
    },
    team_choose: function(t) {
        var e = this, i = t.currentTarget.dataset.index;
        e.setData({
            pid: e.data.team_list[i].id,
            team_pages: !1,
            coupon_curr: -1,
            coupon_price: ""
        }), n.util.request({
            url: "entry/wxapp/user",
            data: {
                op: "sign",
                pid: e.data.pid
            },
            success: function(t) {
                var a = t.data;
                "" != a.data && (e.setData({
                    list: a.data,
                    amount: "¥" + a.data.amount,
                    cut: ""
                }), "" != a.data.list && null != a.data.list ? e.setData({
                    coupon: a.data.list
                }) : e.setData({
                    coupon: []
                }));
            }
        }), a(e);
    },
    input: function(e) {
        var n = this, i = e.currentTarget.dataset.name;
        n.setData(t({}, i, e.detail.value)), a(n);
    },
    choose: function(t) {
        this.setData({
            shadow: !0,
            menu: !0
        });
    },
    menu_close: function() {
        this.setData({
            shadow: !1,
            menu: !1
        });
    },
    coupon_choose: function(t) {
        var a = this, e = t.currentTarget.dataset.index;
        if (e != a.data.coupon_curr) {
            var n = a.data.coupon[e].name, i = a.data.list.amount;
            i = (parseFloat(i) - parseFloat(n)).toFixed(2), a.setData({
                coupon_curr: e,
                coupon_price: "¥" + n,
                amount: "¥" + i
            });
        } else {
            var i = a.data.list.amount, s = a.data.card;
            "" != s && null != s && 1 == s.content.discount_status && (o_amount = (parseFloat(o_amount) * parseFloat(s.content.discount) / 10).toFixed(2)), 
            a.setData({
                coupon_curr: -1,
                coupon_price: "",
                amount: "¥" + a.data.list.amount
            });
        }
    },
    submit: function(t) {
        var a = this;
        if (a.data.submit) {
            var i = {
                name: a.data.name,
                mobile: a.data.mobile,
                form_id: t.detail.formId,
                order_type: 1,
                total: 1,
                store: a.data.store_id
            };
            "" != a.data.pid && null != a.data.pid && (i.pid = a.data.pid), "" != a.data.cut && null != a.data.cut && (i.cut = a.data.cut), 
            "" != a.data.mobile2 && null != a.data.mobile2 && (i.mobile2 = a.data.mobile2), 
            -1 != a.data.coupon_curr && (i.coupon_id = a.data.coupon[a.data.coupon_curr].cid), 
            "" != a.data.content && null != a.data.content && (i.content = a.data.content), 
            "" != a.data.tui && null != a.data.tui && (i.tui = a.data.tui), "" != a.data.sign_config && null != a.data.sign_config && "" != a.data.sign_config.list && null != a.data.sign_config.list && (i.form = JSON.stringify(a.data.sign_config.list)), 
            n.util.request({
                url: "entry/wxapp/setorder",
                data: i,
                success: function(t) {
                    var a = t.data;
                    "" != a.data && (1 == a.data.status ? (wx.showToast({
                        title: "支付成功",
                        icon: "success",
                        duration: 2e3
                    }), setTimeout(function() {
                        wx.reLaunch({
                            url: "../index/index"
                        });
                    }, 2e3)) : "" != a.data.errno && null != a.data.errno ? wx.showModal({
                        title: "错误",
                        content: a.data.message,
                        showCancel: !1
                    }) : e(a.data));
                }
            });
        }
    },
    store_on: function() {
        this.setData({
            store_page: !0
        });
    },
    store_choose: function(t) {
        var e = this, n = t.currentTarget.dataset.index;
        e.setData({
            store_id: e.data.store_list[n].id,
            store_name: e.data.store_list[n].name,
            store_page: !1
        }), a(e);
    },
    store_close: function() {
        this.setData({
            store_page: !1
        });
    },
    team_scroll: function() {
        var t = this;
        t.data.team_isbottom || t.data.is_load || (t.setData({
            is_load: !0
        }), n.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "sign",
                page: t.data.team_page,
                pagesize: t.data.team_pagesize
            },
            success: function(a) {
                var e = a.data;
                "" != e.data ? t.setData({
                    team_list: t.data.team_list.concat(e.data),
                    team_page: t.data.team_page + 1
                }) : t.setData({
                    team_isbottom: !0
                }), t.setData({
                    is_load: !1
                });
            }
        }));
    },
    store_scroll: function() {
        var t = this;
        if (!t.data.isbottom && !t.data.is_load) {
            t.setData({
                is_load: !0
            });
            var a = {
                op: "school",
                page: t.data.page,
                pagesize: t.data.pagesize
            };
            null != t.data.latitude && "" != t.data.latitude && (a.latitude = t.data.latitude), 
            null != t.data.longitude && "" != t.data.longitude && (a.longitude = t.data.longitude), 
            n.util.request({
                url: "entry/wxapp/index",
                data: a,
                success: function(a) {
                    var e = a.data;
                    "" != e.data ? t.setData({
                        list: t.data.store_list.concat(e.data),
                        page: t.data.page + 1
                    }) : t.setData({
                        isbottom: !0
                    }), t.setData({
                        is_load: !1
                    });
                }
            });
        }
    },
    sign_input: function(t) {
        var a = this, e = a.data.sign_config, n = t.currentTarget.dataset.index;
        e.list[n].value = t.detail.value, a.setData({
            sign_config: e
        });
    },
    onLoad: function(t) {
        var a = this;
        i.config(a), i.theme(a);
        var e = {
            op: "sign"
        };
        "" != t.pid && null != t.pid && (e.pid = t.pid, a.setData({
            pid: t.pid
        })), "" != t.cut && null != t.cut && (e.cut = t.cut, a.setData({
            cut: t.cut
        })), n.util.request({
            url: "entry/wxapp/user",
            data: e,
            success: function(e) {
                var n = e.data;
                "" != n.data && (a.setData({
                    list: n.data,
                    amount: "¥" + n.data.amount
                }), "" != t.cut && null != t.cut || a.setData({
                    pid: n.data.id
                }), "" != n.data.list && null != n.data.list && a.setData({
                    coupon: n.data.list
                }));
            }
        }), wx.getLocation({
            type: "wgs84",
            success: function(t) {
                var e = t.latitude, n = t.longitude;
                t.speed, t.accuracy;
                a.setData({
                    latitude: e,
                    longitude: n
                });
            },
            complete: function() {
                var t = {
                    op: "school",
                    page: a.data.page,
                    pagesize: a.data.pagesize
                };
                null != a.data.latitude && "" != a.data.latitude && (t.latitude = a.data.latitude), 
                null != a.data.longitude && "" != a.data.longitude && (t.longitude = a.data.longitude), 
                n.util.request({
                    url: "entry/wxapp/index",
                    data: t,
                    success: function(t) {
                        var e = t.data;
                        "" != e.data ? a.setData({
                            store_list: e.data,
                            page: a.data.page + 1
                        }) : a.setData({
                            isbottom: !0
                        });
                    }
                });
            }
        }), n.util.request({
            url: "entry/wxapp/service",
            showLoading: !1,
            data: {
                op: "sign",
                page: a.data.team_page,
                pagesize: a.data.team_pagesize
            },
            success: function(t) {
                var e = t.data;
                "" != e.data ? a.setData({
                    team_list: e.data,
                    team_page: a.data.team_page + 1
                }) : a.setData({
                    team_isbottom: !0
                });
            }
        }), n.util.request({
            url: "entry/wxapp/user",
            showLoading: !1,
            data: {
                op: "sign_config"
            },
            success: function(t) {
                var e = t.data;
                "" != e.data ? a.setData({
                    sign_config: e.data
                }) : a.setData({
                    sign_config: {
                        name_status: 1,
                        mobile_status: 1,
                        coupon_status: 1,
                        content_status: 1,
                        tui_status: 1
                    }
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        i.audio_end(this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    onReachBottom: function() {}
});