var t = getApp(), e = t.requirejs("core"), s = t.requirejs("jquery");

Page({
    data: {
        search: !1,
        show_distance: !1
    },
    onLoad: function(e) {
        this.setData({
            options: e
        }), t.url(e);
    },
    onReady: function() {},
    onShow: function() {
        this.get_list();
    },
    onHide: function() {},
    get_list: function() {
        var s = this, i = {
            ids: s.data.options.ids,
            type: s.data.options.type,
            merchid: s.data.options.merchid
        };
        wx.getSetting({
            success: function(o) {
                o.authSetting["scope.userLocation"] ? wx.getLocation({
                    type: "wgs84",
                    success: function(t) {
                        i.lat = t.latitude, i.lng = t.longitude, s.setData({
                            show_distance: !0
                        }), e.get("store/selector", i, function(t) {
                            s.setData({
                                list: t.list,
                                show: !0
                            });
                        });
                    },
                    fail: function(t) {
                        setTimeout(function() {
                            e.toast("位置获取失败");
                        }, 1e3), e.get("store/selector", i, function(t) {
                            s.setData({
                                list: t.list,
                                show: !0
                            });
                        });
                    }
                }) : wx.authorize({
                    scope: "scope.userLocation",
                    success: function() {
                        wx.getLocation({
                            type: "wgs84",
                            success: function(t) {
                                i.lat = t.latitude, i.lng = t.longitude, s.setData({
                                    show_distance: !0
                                }), e.get("store/selector", i, function(t) {
                                    s.setData({
                                        list: t.list,
                                        show: !0
                                    });
                                });
                            },
                            fail: function(t) {
                                setTimeout(function() {
                                    e.toast("位置获取失败");
                                }, 1e3), e.get("store/selector", i, function(t) {
                                    s.setData({
                                        list: t.list,
                                        show: !0
                                    });
                                });
                            }
                        });
                    },
                    fail: function(e) {
                        o.authSetting["scope.userLocation"] && wx.showModal({
                            title: "警告",
                            content: "位置信息获取受限，请点击确定打开授权页面,在打开的页面中开启位置信息授权",
                            success: function(e) {
                                e.confirm && wx.openSetting({
                                    success: function(t) {
                                        wx.navigateBack();
                                    }
                                }), e.cancel && t.close();
                            }
                        });
                    }
                });
            }
        });
    },
    bindSearch: function(t) {
        this.setData({
            search: !0
        });
    },
    phone: function(t) {
        e.phone(t);
    },
    select: function(s) {
        var i = e.pdata(s).index;
        t.setCache("orderShop", this.data.list[i], 30), wx.navigateBack();
    },
    search: function(t) {
        var e = t.detail.value, i = this.data.old_list, o = this.data.list, n = [];
        s.isEmptyObject(i) && (i = o), s.isEmptyObject(i) || s.each(i, function(t, s) {
            -1 != s.storename.indexOf(e) && n.push(s);
        }), this.setData({
            list: n,
            old_list: i
        });
    }
});