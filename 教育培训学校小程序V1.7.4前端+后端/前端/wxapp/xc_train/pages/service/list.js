function t(t) {
    var a = t.data.store_id, e = t.data.name, s = t.data.mobile, o = t.data.total, i = !0;
    "" != a && null != a || (i = !1), "" != e && null != e || (i = !1), "" != s && null != s || (i = !1), 
    /^(((13[0-9]{1})|(14[0-9]{1})|(17[0-9]{1})|(15[0-3]{1})|(15[5-9]{1})|(18[0-9]{1}))+\d{8})$/.test(s) || (i = !1), 
    "" != o && null != o || (i = !1), t.setData({
        submit: i
    });
}

var a = getApp(), e = require("../common/common.js");

Page({
    data: {
        choose: -1,
        page: 1,
        pagesize: 20,
        isbottom: !1,
        submit: !1,
        store_page: 1,
        store_pagesize: 20,
        store_isbottom: !1,
        is_load: !1
    },
    menu_on: function(t) {
        var a = this, e = t.currentTarget.dataset.index;
        a.setData({
            shadow: !0,
            menu: !0,
            choose: e
        });
    },
    menu_close: function() {
        this.setData({
            menu: !1,
            shadow: !1,
            name: "",
            total: "",
            mobile: ""
        });
    },
    choose: function(t) {
        var a = this, e = t.currentTarget.dataset.index;
        e != a.data.choose && a.setData({
            choose: e
        });
    },
    input: function(a) {
        var e = this;
        switch (a.currentTarget.dataset.name) {
          case "name":
            e.setData({
                name: a.detail.value
            });
            break;

          case "mobile":
            e.setData({
                mobile: a.detail.value
            });
            break;

          case "total":
            e.setData({
                total: a.detail.value
            });
        }
        t(e);
    },
    store_on: function() {
        this.setData({
            store_pages: !0
        });
    },
    store_choose: function(a) {
        var e = this, s = a.currentTarget.dataset.index;
        e.setData({
            store_id: e.data.store_list[s].id,
            store_name: e.data.store_list[s].name,
            store_pages: !1
        }), t(e);
    },
    store_close: function() {
        this.setData({
            store_pages: !1
        });
    },
    submit: function(t) {
        var e = this, s = t.currentTarget.dataset.index;
        if (-1 == e.data.choose) wx.showModal({
            title: "错误",
            content: "请先选择一门课程！",
            success: function(t) {
                t.confirm ? console.log("用户点击确定") : t.cancel && console.log("用户点击取消");
            }
        }); else if (1 == s) wx.navigateTo({
            url: "../sign/sign?&pid=" + e.data.list[e.data.choose].id
        }); else if (2 == s && e.data.submit) {
            var o = {
                pid: e.data.list[e.data.choose].id,
                name: e.data.name,
                mobile: e.data.mobile,
                total: e.data.total,
                form_id: t.detail.formId,
                order_type: s,
                store: e.data.store_id
            };
            a.util.request({
                url: "entry/wxapp/setorder",
                data: o,
                success: function(t) {
                    "" != t.data.data && (e.setData({
                        menu: !1,
                        shadow: !1,
                        name: "",
                        total: "",
                        mobile: ""
                    }), wx.showToast({
                        title: "预约成功",
                        icon: "success",
                        duration: 2e3
                    }));
                }
            });
        }
    },
    store_scroll: function() {
        var t = this;
        if (!t.data.store_isbottom && !t.data.is_load) {
            t.setData({
                is_load: !0
            });
            var e = {
                op: "school",
                page: t.data.store_page,
                pagesize: t.data.store_pagesize
            };
            null != t.data.latitude && "" != t.data.latitude && (e.latitude = t.data.latitude), 
            null != t.data.longitude && "" != t.data.longitude && (e.longitude = t.data.longitude), 
            a.util.request({
                url: "entry/wxapp/index",
                data: e,
                success: function(a) {
                    var e = a.data;
                    "" != e.data ? t.setData({
                        list: t.data.store_list.concat(e.data),
                        page: t.data.store_page + 1
                    }) : t.setData({
                        store_isbottom: !0
                    }), t.setData({
                        is_load: !1
                    });
                }
            });
        }
    },
    onLoad: function(t) {
        var s = this;
        e.config(s), e.theme(s), "" != t.curr && null != t.curr && s.setData({
            curr: t.curr
        }), a.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "list",
                curr: s.data.curr,
                page: s.data.page,
                pagesize: s.data.pagesize
            },
            success: function(t) {
                var a = t.data;
                "" != a.data ? s.setData({
                    list: a.data,
                    page: s.data.page + 1
                }) : s.setData({
                    isbottom: !0
                });
            }
        }), wx.getLocation({
            type: "wgs84",
            success: function(t) {
                var a = t.latitude, e = t.longitude;
                t.speed, t.accuracy;
                s.setData({
                    latitude: a,
                    longitude: e
                });
            },
            complete: function() {
                var t = {
                    op: "school",
                    page: s.data.store_page,
                    pagesize: s.data.store_pagesize
                };
                null != s.data.latitude && "" != s.data.latitude && (t.latitude = s.data.latitude), 
                null != s.data.longitude && "" != s.data.longitude && (t.longitude = s.data.longitude), 
                a.util.request({
                    url: "entry/wxapp/index",
                    data: t,
                    success: function(t) {
                        var a = t.data;
                        "" != a.data ? s.setData({
                            store_list: a.data,
                            page: s.data.store_page + 1
                        }) : s.setData({
                            store_isbottom: !0
                        });
                    }
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        e.audio_end(this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var t = this;
        t.setData({
            page: 1,
            isbottom: !1
        }), a.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "list",
                curr: t.data.curr,
                page: t.data.page,
                pagesize: t.data.pagesize
            },
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
        t.data.isbottom || a.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "list",
                curr: t.data.curr,
                page: t.data.page,
                pagesize: t.data.pagesize
            },
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
});