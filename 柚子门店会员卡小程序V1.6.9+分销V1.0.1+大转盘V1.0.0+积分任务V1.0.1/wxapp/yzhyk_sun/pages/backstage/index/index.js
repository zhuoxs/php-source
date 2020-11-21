var _slicedToArray = function(t, e) {
    if (Array.isArray(t)) return t;
    if (Symbol.iterator in Object(t)) return function(t, e) {
        var a = [], o = !0, n = !1, i = void 0;
        try {
            for (var s, r = t[Symbol.iterator](); !(o = (s = r.next()).done) && (a.push(s.value), 
            !e || a.length !== e); o = !0) ;
        } catch (t) {
            n = !0, i = t;
        } finally {
            try {
                !o && r.return && r.return();
            } finally {
                if (n) throw i;
            }
        }
        return a;
    }(t, e);
    throw new TypeError("Invalid attempt to destructure non-iterable instance");
}, app = getApp();

Page({
    data: {
        list: [],
        finance: [],
        arrayShop: [ "woniujiaz", "hyk" ],
        index: 0,
        isIpx: app.globalData.isIpx
    },
    onLoad: function(t) {
        var n = this;
        Promise.all([ app.get_user_info(), app.api.get_setting() ]).then(function(t) {
            var e = _slicedToArray(t, 2), a = e[0], o = e[1];
            n.setData({
                user: a,
                setting: o
            });
        });
    },
    onReady: function() {},
    onShow: function() {
        this.updatereport();
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    toMessage: function(t) {
        wx.redirectTo({
            url: "../message/message"
        });
    },
    toSet: function(t) {
        wx.redirectTo({
            url: "../set/set"
        });
    },
    toSet1: function(t) {
        wx.redirectTo({
            url: "../set1/set1"
        });
    },
    scanCode: function(t) {
        var n = this.data.store.id;
        console.log(n), wx.scanCode({
            success: function(t) {
                var e = t.result;
                if (console.log(e.indexOf("appgoods")), console.log(e.indexOf("userid")), console.log(e.indexOf("ordertype")), 
                -1 != e.indexOf("userid")) {
                    var a = e.substring(7);
                    wx.navigateTo({
                        url: "/yzhyk_sun/pages/backstage/cchx/cchx?id=" + a
                    });
                } else if (-1 != e.indexOf("ordertype")) {
                    console.log(JSON.parse(e));
                    e = JSON.parse(e);
                    app.util.request({
                        url: "entry/wxapp/isStore",
                        data: {
                            storeid: n,
                            id: e.id
                        },
                        success: function(t) {
                            1 == t.data ? wx.navigateTo({
                                url: "/yzhyk_sun/pages/backstage/eatoff/eatoff?id=" + e.id
                            }) : wx.showModal({
                                title: "失败提示",
                                content: "二维码与当前门店不符！",
                                showCancel: !1,
                                success: function(t) {}
                            });
                        }
                    });
                } else if (-1 != e.indexOf("appgoods")) {
                    var o = e.substring(9);
                    app.util.request({
                        url: "entry/wxapp/isStoreapp",
                        data: {
                            storeid: n,
                            id: o
                        },
                        success: function(t) {
                            1 == t.data ? wx.navigateTo({
                                url: "/yzhyk_sun/pages/backstage/cchxapp/cchxapp?id=" + o
                            }) : wx.showModal({
                                title: "失败提示",
                                content: "二维码与当前门店不符！",
                                showCancel: !1,
                                success: function(t) {}
                            });
                        }
                    });
                } else wx.navigateTo({
                    url: "/yzhyk_sun/pages/backstage/writeoff/writeoff?code=" + e
                });
            }
        });
    },
    bindPickerChange: function(t) {
        var o = this;
        this.setData({
            index: t.detail.value,
            store: this.data.stores[t.detail.value]
        }), console.log(this.data.stores[t.detail.value].id), app.util.request({
            url: "entry/wxapp/GetAdminReport",
            data: {
                store_id: this.data.stores[t.detail.value].id
            },
            success: function(t) {
                console.log(t.data.num);
                var e = [ {
                    title: "今日订单数",
                    detail: t.data.today_count
                }, {
                    title: "总订单数",
                    detail: t.data.count
                }, {
                    title: "待配送",
                    detail: t.data.send_count
                } ], a = [ {
                    title: "今日销售额",
                    detail: t.data.today_amount
                }, {
                    title: "昨日销售额",
                    detail: t.data.yesterday_amount
                }, {
                    title: "总销售额",
                    detail: t.data.amount
                } ];
                o.setData({
                    list: e,
                    finance: a
                });
            }
        });
    },
    chooseLocation: function() {
        var e = this;
        wx.chooseLocation({
            success: function(t) {
                console.log(t), app.util.request({
                    url: "entry/wxapp/UpdateStoreLocation",
                    data: {
                        store_id: e.data.store.id,
                        latitude: t.latitude,
                        longitude: t.longitude
                    },
                    success: function(t) {
                        app.get_admin_store_info(!0).then(function(t) {
                            e.setData({
                                store: t
                            });
                        });
                    }
                });
            }
        });
    },
    updatereport: function() {
        var o = this;
        app.get_admin_stores(!1).then(function(t) {
            o.setData({
                stores: t
            }), app.get_admin_store_info(!1).then(function(t) {
                o.setData({
                    store: t
                }), console.log(t), app.util.request({
                    url: "entry/wxapp/GetAdminReport",
                    data: {
                        store_id: t.id
                    },
                    success: function(t) {
                        console.log(t.data.num);
                        var e = [ {
                            title: "今日订单数",
                            detail: t.data.today_count
                        }, {
                            title: "总订单数",
                            detail: t.data.count
                        }, {
                            title: "待配送",
                            detail: t.data.send_count
                        } ], a = [ {
                            title: "今日销售额",
                            detail: t.data.today_amount
                        }, {
                            title: "昨日销售额",
                            detail: t.data.yesterday_amount
                        }, {
                            title: "总销售额",
                            detail: t.data.amount
                        } ];
                        o.setData({
                            list: e,
                            finance: a
                        });
                    }
                });
            });
        });
    },
    toCash: function(t) {
        wx.navigateTo({
            url: "/yzhyk_sun/pages/backstage/cash/cash"
        });
    }
});