var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var e = arguments[a];
        for (var n in e) Object.prototype.hasOwnProperty.call(e, n) && (t[n] = e[n]);
    }
    return t;
}, _reload = require("../../common/js/reload.js"), _api = require("../../common/js/api.js");

function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp();

Page(_extends({}, _reload.reload, {
    data: {
        pxopen: !1,
        pxshow: !1,
        active: !0,
        option_2: [ {
            name: "默认排序"
        }, {
            name: "总价由高到低"
        }, {
            name: "总价由低到高"
        }, {
            name: "车龄最短"
        }, {
            name: "里程最少"
        } ],
        list: {
            load: !1,
            over: !1,
            page: 1,
            length: 10,
            none: !1,
            data: []
        },
        _sort: "默认排序",
        _city: "不限",
        _pai: "不限",
        _condition: "筛选",
        option_type: !1,
        city: [],
        city_id: ""
    },
    onLoad: function(t) {
        wx.getLocation({
            success: function(t) {
                console.log(t);
            }
        });
    },
    onShow: function() {
        this.onloadData();
    },
    onloadData: function(t) {
        var e = this;
        this.getUrl().then(function(t) {
            var a = {
                page: 1,
                sort: 1,
                city_id: e.data.city_id ? e.data.city_id : 0,
                brand_id: e.data.brand_id ? e.data.brand_id : 0,
                carnum: ""
            };
            return e.setData({
                param: a
            }), (0, _api.Userdcarlist)(a);
        }).then(function(t) {
            e.setData(_defineProperty({}, "list.data", t));
        });
    },
    onReachBottom: function() {
        this.loadList();
    },
    toCity: function() {
        this.navTo("Second_city/Second_city");
    },
    toBrand: function() {
        this.navTo("Second_brand/Second_brand");
    },
    open_options: function(t) {
        this.data.pxopen ? this.setData({
            pxopen: !1,
            pxshow: !0,
            active: !0,
            imgUrl: ""
        }) : this.setData({
            pxopen: !0,
            pxshow: !1,
            active: !1,
            imgUrl: ""
        });
    },
    close_options: function(t) {
        this.data.pxopen && this.setData({
            pxopen: !1,
            pxshow: !0,
            active: !0,
            imgUrl: ""
        });
    },
    openLocations: function(t) {
        var a = parseFloat(this.data.detail[t.currentTarget.dataset.index].lng), e = parseFloat(this.data.detail[t.currentTarget.dataset.index].lat), n = this.data.detail[t.currentTarget.dataset.index].name, i = this.data.detail[t.currentTarget.dataset.index].address;
        wx.openLocation({
            latitude: e,
            longitude: a,
            name: n,
            address: i
        });
    },
    loadList: function(t) {
        var n = this;
        if (this.data.list.over) this.tips("已全部加载完。"); else {
            this.setData(_defineProperty({}, "list.load", !0));
            var i = this.data.param;
            ++i.page, (0, _api.Userdcarlist)(i).then(function(t) {
                var a;
                1 == i.page && n.setData({
                    list: {
                        load: !1,
                        over: !1,
                        page: 1,
                        length: 10,
                        none: !1,
                        data: []
                    }
                }), console.log(t);
                var e = n.data.list.data.concat(t);
                t.length < n.data.list.length && n.setData(_defineProperty({}, "list.over", !0)), 
                0 === e.length && n.setData(_defineProperty({}, "list.none", !0)), n.setData((_defineProperty(a = {}, "list.load", !1), 
                _defineProperty(a, "list.page", ++n.data.list.page), _defineProperty(a, "list.data", e), 
                a));
            });
        }
    },
    changeSort: function(e) {
        var n = this, t = this.data.param;
        t.sort = e.currentTarget.dataset.index + 1, (0, _api.Userdcarlist)(t).then(function(t) {
            var a;
            console.log(t), n.setData((_defineProperty(a = {}, "list.data", t), _defineProperty(a, "_sort", e.currentTarget.dataset.name), 
            a)), n.open_options();
        });
    },
    toInfo: function(t) {
        this.navTo("Second_info/Second_info?id=" + t.currentTarget.dataset.id);
    },
    close_search: function() {
        this.data.pxopen && this.setData({
            pxopen: !1,
            pxshow: !1,
            active: !0,
            imgUrl: ""
        });
    },
    watchSearch: function(t) {
        var a = this, e = this.data.param;
        console.log(t), e.page = 1, e.carnum = t.detail.value, (0, _api.Userdcarlist)(e).then(function(t) {
            a.setData(_defineProperty({}, "list.data", t));
        });
    },
    set_carnum: function(t) {
        this.setData({
            carnum: t.detail.value
        });
    },
    search: function() {
        var a = this, t = this.data.param;
        t.page = 1, t.carnum = this.data.carnum, (0, _api.Userdcarlist)(t).then(function(t) {
            a.setData(_defineProperty({}, "list.data", t));
        });
    }
}));