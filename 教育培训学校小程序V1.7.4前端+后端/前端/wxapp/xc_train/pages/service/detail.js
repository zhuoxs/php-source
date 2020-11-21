function a(a, t, e) {
    return t in a ? Object.defineProperty(a, t, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = e, a;
}

function t(a) {
    var t = a.data.name, e = a.data.mobile, s = a.data.total, i = !0;
    "" != t && null != t || (i = !1), "" != e && null != e || (i = !1), /^(((13[0-9]{1})|(14[0-9]{1})|(17[0-9]{1})|(15[0-3]{1})|(15[5-9]{1})|(18[0-9]{1}))+\d{8})$/.test(e) || (i = !1), 
    "" != s && null != s || (i = !1), a.setData({
        submit: i
    });
}

var e = getApp(), s = require("../../../wxParse/wxParse.js"), i = require("../common/common.js");

Page({
    data: {
        curr: 1,
        page: 1,
        pagesize: 20,
        isbottom: !1,
        submit: !1,
        store_page: 1,
        store_pagesize: 20,
        store_isbottom: !1,
        is_load: !1,
        code: ""
    },
    tab: function(a) {
        var t = this, s = a.currentTarget.dataset.index;
        s != t.data.curr && (t.setData({
            curr: s,
            page: 1,
            pagesize: 20,
            isbottom: !1,
            tui: []
        }), 2 == s ? e.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "service",
                tui: 1,
                page: t.data.page,
                pagesize: t.data.pagesize
            },
            success: function(a) {
                var e = a.data;
                "" != e.data ? t.setData({
                    tui: e.data,
                    page: t.data.page + 1
                }) : t.setData({
                    isbottom: !0
                });
            }
        }) : 3 == s ? e.util.request({
            url: "entry/wxapp/order",
            data: {
                op: "discuss",
                page: t.data.page,
                pagesize: t.data.pagesize,
                id: t.data.list.id,
                type: 1
            },
            success: function(a) {
                var e = a.data;
                "" != e.data ? t.setData({
                    tui: e.data,
                    page: t.data.page + 1
                }) : t.setData({
                    isbottom: !0
                });
            }
        }) : 4 == s && e.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "video",
                page: t.data.page,
                pagesize: t.data.pagesize,
                service: t.data.list.id
            },
            success: function(a) {
                var e = a.data;
                "" != e.data ? t.setData({
                    tui: e.data,
                    page: t.data.page + 1
                }) : t.setData({
                    isbottom: !0
                });
            }
        }));
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
    input: function(e) {
        var s = this, i = e.currentTarget.dataset.name;
        s.setData(a({}, i, e.detail.value)), t(s);
    },
    submit: function(a) {
        var t = this, e = a.currentTarget.dataset.index, s = t.data.list;
        "" != s.price && null != s.price ? wx.navigateTo({
            url: "../sign/sign?&pid=" + s.team[e].id
        }) : t.setData({
            shadow: !0,
            menu: !0,
            choose: e
        });
    },
    menu_submit: function(a) {
        var t = this;
        if (t.data.submit) {
            var s = {
                pid: t.data.list.team[t.data.choose].id,
                name: t.data.name,
                mobile: t.data.mobile,
                total: t.data.total,
                form_id: a.detail.formId,
                order_type: 2,
                store: t.data.store_id
            };
            e.util.request({
                url: "entry/wxapp/setorder",
                data: s,
                success: function(a) {
                    "" != a.data.data && (t.setData({
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
    zan: function() {
        var a = this;
        1 != a.data.list.is_zan && e.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "detail_zan",
                id: a.data.list.id
            },
            success: function(t) {
                if ("" != t.data.data) {
                    wx.showToast({
                        title: "点赞成功",
                        icon: "success",
                        duration: 2e3
                    });
                    var e = a.data.list;
                    e.is_zan = 1, e.zan = parseInt(e.zan) + 1, a.setData({
                        list: e
                    });
                }
            }
        });
    },
    discuss_on: function() {
        var a = this, t = a.data.content;
        "" != t && null != t ? e.util.request({
            url: "entry/wxapp/order",
            data: {
                op: "discuss_on",
                id: a.data.list.id,
                content: t,
                type: 1
            },
            success: function(t) {
                "" != t.data.data && (wx.showToast({
                    title: "评论成功",
                    icon: "success",
                    duration: 2e3
                }), a.setData({
                    page: 1,
                    isbottom: !1,
                    content: ""
                }), e.util.request({
                    url: "entry/wxapp/order",
                    data: {
                        op: "discuss",
                        page: a.data.page,
                        pagesize: a.data.pagesize,
                        id: a.data.list.id
                    },
                    success: function(t) {
                        var e = t.data;
                        "" != e.data ? a.setData({
                            tui: e.data,
                            page: a.data.page + 1
                        }) : a.setData({
                            isbottom: !0
                        });
                    }
                }));
            }
        }) : wx.showModal({
            title: "错误",
            content: "评论内容不能为空",
            success: function(a) {
                a.confirm ? console.log("用户点击确定") : a.cancel && console.log("用户点击取消");
            }
        });
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
    store_scroll: function() {
        var a = this;
        if (!a.data.store_isbottom && !a.data.is_load) {
            a.setData({
                is_load: !0
            });
            var t = {
                op: "school",
                page: a.data.store_page,
                pagesize: a.data.store_pagesize
            };
            null != a.data.latitude && "" != a.data.latitude && (t.latitude = a.data.latitude), 
            null != a.data.longitude && "" != a.data.longitude && (t.longitude = a.data.longitude), 
            e.util.request({
                url: "entry/wxapp/index",
                data: t,
                success: function(t) {
                    var e = t.data;
                    "" != e.data ? a.setData({
                        list: a.data.store_list.concat(e.data),
                        page: a.data.store_page + 1
                    }) : a.setData({
                        store_isbottom: !0
                    }), a.setData({
                        is_load: !1
                    });
                }
            });
        }
    },
    code_on: function() {
        this.setData({
            showShare: !0
        });
    },
    closeShare: function() {
        this.setData({
            showShare: !1
        });
    },
    showhb: function() {
        var a = this;
        "" != a.data.code ? a.setData({
            showShare: !1,
            showhb: !0
        }) : e.util.request({
            url: "entry/wxapp/user",
            data: {
                op: "getCode",
                id: a.data.list.id
            },
            success: function(t) {
                var e = t.data;
                "" != e.data && a.setData({
                    showShare: !1,
                    showhb: !0,
                    code: e.data.code
                });
            }
        });
    },
    closehb: function() {
        this.setData({
            showhb: !1
        });
    },
    dlimg: function() {
        var a = this;
        wx.showLoading({
            title: "保存中"
        }), wx.downloadFile({
            url: a.data.code,
            success: function(a) {
                wx.saveImageToPhotosAlbum({
                    filePath: a.tempFilePath,
                    success: function(a) {
                        wx.hideLoading(), wx.showToast({
                            title: "保存成功",
                            icon: "success",
                            duration: 2e3
                        });
                    },
                    fail: function(a) {
                        wx.hideLoading(), wx.showToast({
                            title: "保存失败",
                            icon: "success",
                            duration: 2e3
                        });
                    }
                });
            }
        });
    },
    onLoad: function(a) {
        var t = this;
        i.config(t), i.theme(t), e.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "detail",
                id: a.id
            },
            success: function(a) {
                var e = a.data;
                if ("" != e.data && (t.setData({
                    list: e.data
                }), 2 == e.data.content_type)) {
                    var i = e.data.content2;
                    s.wxParse("content2", "html", i, t, 5);
                }
            }
        }), wx.getLocation({
            type: "wgs84",
            success: function(a) {
                var e = a.latitude, s = a.longitude;
                a.speed, a.accuracy;
                t.setData({
                    latitude: e,
                    longitude: s
                });
            },
            complete: function() {
                var a = {
                    op: "school",
                    page: t.data.page,
                    pagesize: t.data.pagesize
                };
                null != t.data.latitude && "" != t.data.latitude && (a.latitude = t.data.latitude), 
                null != t.data.longitude && "" != t.data.longitude && (a.longitude = t.data.longitude), 
                e.util.request({
                    url: "entry/wxapp/index",
                    data: a,
                    success: function(a) {
                        var e = a.data;
                        "" != e.data ? t.setData({
                            store_list: e.data,
                            page: t.data.page + 1
                        }) : t.setData({
                            isbottom: !0
                        });
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
        var a = this;
        e.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "detail",
                id: a.data.list.id
            },
            success: function(t) {
                wx.stopPullDownRefresh();
                var e = t.data;
                "" != e.data && a.setData({
                    list: e.data
                });
            }
        });
    },
    onReachBottom: function() {
        var a = this;
        a.data.isbottom ? 3 == index ? e.util.request({
            url: "entry/wxapp/order",
            data: {
                op: "discuss",
                page: a.data.page,
                pagesize: a.data.pagesize,
                id: a.data.list.id,
                type: 1
            },
            success: function(t) {
                var e = t.data;
                "" != e.data ? a.setData({
                    tui: a.data.tui.concat(e.data),
                    page: a.data.page + 1
                }) : a.setData({
                    isbottom: !0
                });
            }
        }) : 4 == index && e.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "video",
                page: a.data.page,
                pagesize: a.data.pagesize,
                service: a.data.list.id
            },
            success: function(t) {
                var e = t.data;
                "" != e.data ? a.setData({
                    tui: a.data.tui.concat(e.data),
                    page: a.data.page + 1
                }) : a.setData({
                    isbottom: !0
                });
            }
        }) : 2 == a.data.curr && e.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "service",
                tui: 1,
                page: a.data.page,
                pagesize: a.data.pagesize
            },
            success: function(t) {
                var e = t.data;
                "" != e.data ? a.setData({
                    tui: a.data.tui.concat(e.data),
                    page: a.data.page + 1
                }) : a.setData({
                    isbottom: !0
                });
            }
        });
    },
    onShareAppMessage: function() {
        var a = this, t = "/xc_train/pages/service/detail?&id=" + a.data.list.id;
        return t = escape(t), {
            title: a.data.config.title + "-" + a.data.list.name,
            path: "/xc_train/pages/base/base?&share=" + t,
            success: function(a) {
                console.log(a);
            },
            fail: function(a) {
                console.log(a);
            }
        };
    }
});