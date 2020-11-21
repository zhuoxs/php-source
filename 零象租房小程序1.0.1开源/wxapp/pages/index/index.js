var t, a = getApp(), e = require("../../utils/qqmap-wx-jssdk.min.js"), i = 1;

Page({
    data: {
        listUrls: [],
        houseList: [],
        config: [],
        topBar: [ {
            icon: "icon-unfold",
            title: "方式"
        }, {
            icon: "icon-order",
            title: "价格"
        }, {
            icon: "icon-order",
            title: "排序"
        }, {
            icon: "icon-moreandroid",
            title: "更多筛选"
        } ],
        imgUrls: [],
        indicatorDots: !0,
        autoplay: !0,
        interval: 5e3,
        duration: 1e3,
        tabCur: -1,
        scrollLeft: 0,
        display: !0,
        mode: 0,
        price: 0,
        rec: 0,
        renovation: 0,
        oriented: 0,
        layer: 0,
        pingtai: [],
        search: ""
    },
    onLoad: function() {
        var a = this;
        a.getList(0), a.getConfig();
        var i, s;
        t = new e({
            key: "HEQBZ-R6TWR-3YHWF-WJACM-ZH6LE-3SFB6"
        }), wx.getStorage({
            key: "location",
            success: function(t) {
                var e = t.data.split(",");
                i = e[0], s = e[1], a.getCity(i, s);
            },
            fail: function() {
                wx.getLocation({
                    type: "wgs84",
                    success: function(t) {
                        a.getCity(t.latitude, t.longitude);
                    }
                });
            }
        });
    },
    onReachBottom: function() {
        this.getList(i);
    },
    onPullDownRefresh: function() {
        var a = this;
        a.getList(0), a.clearCache(), a.getConfig();
        var i, s;
        t = new e({
            key: "HEQBZ-R6TWR-3YHWF-WJACM-ZH6LE-3SFB6"
        }), wx.getStorage({
            key: "location",
            success: function(t) {
                var e = t.data.split(",");
                i = e[0], s = e[1], a.getCity(i, s);
            },
            fail: function() {
                wx.getLocation({
                    type: "wgs84",
                    success: function(t) {
                        a.getCity(t.latitude, t.longitude);
                    }
                });
            }
        });
    },
    search: function(t) {
        this.clearCache(), this.setData({
            search: t.detail.value
        }), this.getList(i, t.detail.value);
    },
    clearCache: function() {
        i = 1, this.setData({
            houseList: [],
            search: ""
        });
    },
    getList: function(t, e) {
        var s = this;
        a.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reathouse",
                r: "home.index",
                page: t,
                search: e || s.data.search,
                mode: this.data.mode,
                price: this.data.price,
                renovation: this.data.renovation,
                oriented: this.data.oriented,
                layer: this.data.layer
            },
            success: function(t) {
                if (s.setData({
                    listUrls: t.data.data.type,
                    imgUrls: t.data.data.banner,
                    pingtai: t.data.data.info
                }), wx.setNavigationBarTitle({
                    title: s.data.pingtai.title
                }), 0 !== t.data.data.list.length) {
                    var a = s.data.houseList;
                    a.push.apply(a, t.data.data.list), s.setData({
                        houseList: a,
                        listUrls: t.data.data.type,
                        imgUrls: t.data.data.banner
                    }), i++;
                } else s.setData({
                    display: !1
                });
            }
        });
    },
    getConfig: function() {
        var t = this;
        a.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reathouse",
                r: "home.filterConfig"
            },
            success: function(a) {
                t.setData({
                    config: a.data.data
                });
            }
        });
    },
    serActive: function(t) {
        var a = t.target.dataset.id, e = t.target.dataset.type;
        this.clearCache(), 0 == a && this.setData({
            tabCur: -1
        }), "mode" == e && this.setData({
            mode: a
        }), "price" == e && this.setData({
            price: a
        }), "rec" == e && this.setData({
            rec: a
        }), "renovation" == e && this.setData({
            renovation: a
        }), "oriented" == e && this.setData({
            oriented: a
        }), "layer" == e && this.setData({
            layer: a
        }), this.getList(i), this.hideModal();
    },
    showModal: function(t) {
        this.setData({
            modalName: t.currentTarget.dataset.target,
            tabCur: t.currentTarget.dataset.id
        });
    },
    hideModal: function(t) {
        console.log(t), void 0 !== t && this.setData({
            tabCur: -1
        }), this.setData({
            modalName: null
        });
    },
    tabSelect: function(t) {
        this.setData({
            tabCur: t.currentTarget.dataset.id,
            scrollLeft: 60 * (t.currentTarget.dataset.id - 1)
        });
    },
    getCity: function(a, e) {
        var i = this;
        t.reverseGeocoder({
            location: {
                latitude: a,
                longitude: e
            },
            success: function(t) {
                var t = t.result, a = [];
                a.push({
                    title: t.address_component.city
                }), i.setData({
                    title: a[0].title
                });
            },
            fail: function(t) {
                console.error(t);
            }
        });
    },
    clicks: function(t) {
        var a = t.currentTarget.dataset.type, e = t.currentTarget.dataset.id;
        this.setData({
            serId: t.currentTarget.dataset.id,
            type: a,
            renovation: e,
            tabCur: t.currentTarget.dataset.id
        });
    },
    clicks1: function(t) {
        var a = t.currentTarget.dataset.type, e = t.currentTarget.dataset.id;
        this.setData({
            serId1: t.currentTarget.dataset.id,
            type1: a,
            oriented: e,
            tabCur: t.currentTarget.dataset.id
        });
    },
    clicks2: function(t) {
        var a = t.currentTarget.dataset.type, e = t.currentTarget.dataset.id;
        this.setData({
            serId2: t.currentTarget.dataset.id,
            type2: a,
            layer: e,
            tabCur: t.currentTarget.dataset.id
        });
    },
    submit: function(t) {
        this.clearCache(), this.getList(i), this.hideModal();
    },
    cancel: function(t) {
        this.clearCache(), this.setData({
            layer: "",
            oriented: "",
            renovation: "",
            type: "",
            type1: "",
            type2: ""
        });
    },
    out: function(t) {
        "/pages/user/index" == t.target.dataset.path || "/pages/fav/index" == t.target.dataset.path ? wx.switchTab({
            url: t.target.dataset.path
        }) : wx.navigateTo({
            url: t.target.dataset.path
        });
    },
    wxout: function(t) {
        wx.navigateTo({
            url: "/pages/richtext/index?id=" + t.currentTarget.dataset.id
        });
    },
    onShareAppMessage: function() {
        return {
            title: this.data.pingtai.title
        };
    }
});