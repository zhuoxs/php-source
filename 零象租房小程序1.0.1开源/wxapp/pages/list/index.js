var t = getApp(), a = (require("../../utils/qqmap-wx-jssdk.min.js"), 1);

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
        layer: 0
    },
    onLoad: function(t) {
        var a = this;
        switch (t.id) {
          case "1":
            a.setData({
                mode: 1
            });
            break;

          case "2":
            console.log(111), a.setData({
                mode: 2
            });
            break;

          case "3":
            a.setData({
                mode: 3
            });
        }
        a.getList(0), a.getConfig();
    },
    onReachBottom: function() {
        this.getList(a);
    },
    search: function(t) {
        this.clearCache(), this.getList(a, t.detail.value);
    },
    clearCache: function() {
        a = 1, this.setData({
            houseList: []
        });
    },
    getList: function(e, i) {
        var r = this;
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reathouse",
                r: "home.index",
                page: e,
                search: i || "",
                mode: this.data.mode,
                price: this.data.price,
                renovation: this.data.renovation,
                oriented: this.data.oriented,
                layer: this.data.layer
            },
            success: function(t) {
                if (r.setData({
                    listUrls: t.data.data.type,
                    imgUrls: t.data.data.banner
                }), 0 !== t.data.data.list.length) {
                    var e = r.data.houseList;
                    e.push.apply(e, t.data.data.list), r.setData({
                        houseList: e,
                        listUrls: t.data.data.type,
                        imgUrls: t.data.data.banner
                    }), a++;
                } else r.setData({
                    display: !1
                });
            }
        });
    },
    getConfig: function() {
        var a = this;
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reathouse",
                r: "home.filterConfig"
            },
            success: function(t) {
                a.setData({
                    config: t.data.data
                });
            }
        });
    },
    serActive: function(t) {
        var e = t.target.dataset.id, i = t.target.dataset.type;
        this.clearCache(), 0 == e && this.setData({
            tabCur: -1
        }), "mode" == i && this.setData({
            mode: e
        }), "price" == i && this.setData({
            price: e
        }), "rec" == i && this.setData({
            rec: e
        }), "renovation" == i && this.setData({
            renovation: e
        }), "oriented" == i && this.setData({
            oriented: e
        }), "layer" == i && this.setData({
            layer: e
        }), this.getList(a), this.hideModal();
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
    getCity: function(t, a) {
        var e = this;
        (void 0).reverseGeocoder({
            location: {
                latitude: t,
                longitude: a
            },
            success: function(t) {
                var t = t.result, a = [];
                a.push({
                    title: t.address_component.city
                }), e.setData({
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
        this.clearCache(), this.getList(a), this.hideModal();
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
        wx.navigateTo({
            url: t.target.dataset.path
        });
    },
    wxout: function(t) {
        wx.navigateToMiniProgram({
            appId: t.target.dataset.appid,
            path: t.target.dataset.path,
            extraData: {
                foo: "bar"
            },
            envVersion: "develop",
            success: function(t) {}
        });
    }
});