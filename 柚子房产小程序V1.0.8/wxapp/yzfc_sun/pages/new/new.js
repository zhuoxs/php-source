var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var e = arguments[a];
        for (var s in e) Object.prototype.hasOwnProperty.call(e, s) && (t[s] = e[s]);
    }
    return t;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js");

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
    data: _extends({}, _reload.data, {
        areaChoose: 0,
        sort: "desc",
        search: ""
    }),
    onLoad: function() {},
    onDownTab: function() {
        "desc" == this.data.sort ? this.setData({
            sort: "asc"
        }) : this.setData({
            sort: "desc"
        }), this.setData({
            list: {
                load: !1,
                over: !1,
                page: 1,
                length: 10,
                none: !1,
                data: []
            }
        }), this.getListData();
    },
    onloadData: function(t) {
        var a = this;
        if (t.detail.login) {
            var e = {
                page: this.data.list.page,
                length: this.data.list.length,
                region: 0,
                sort: this.data.sort
            };
            this.checkUrl().then(function(t) {
                return (0, _api.RegionListData)(e);
            }).then(function(t) {
                return t.unshift({
                    name: "区域",
                    id: 0
                }), a.setData({
                    area: t,
                    show: !0
                }), (0, _api.NewHouseData)(e);
            }).then(function(t) {
                a.dealList(t, e.page);
            }).catch(function(t) {
                -1 === t.code ? a.tips(t.msg) : a.tips("false");
            });
        }
    },
    onSearchTab: function(t) {
        this.setData({
            search: t.detail.value
        });
    },
    bindPickerChange: function(t) {
        this.setData({
            areaChoose: t.detail.value,
            list: {
                load: !1,
                over: !1,
                page: 1,
                length: 10,
                none: !1,
                data: []
            }
        }), this.getListData();
    },
    getListData: function() {
        var a = this;
        if (this.data.list.over) this.tips("已全部加载完。"); else {
            this.setData(_defineProperty({}, "list.load", !0));
            var e = {
                page: this.data.list.page,
                length: this.data.list.length,
                region: this.data.area[this.data.areaChoose].id,
                sort: this.data.sort,
                keyword: this.data.search
            };
            (0, _api.NewHouseData)(e).then(function(t) {
                a.dealList(t, e.page);
            }).catch(function(t) {
                -1 == t.code ? a.tips(t.msg) : a.tips("false");
            });
        }
    },
    onReachBottom: function() {
        this.getListData();
    },
    onHousesTab: function(t) {
        var a = t.currentTarget.dataset.idx;
        this.navTo("../houses/houses?hid=" + this.data.list.data[a].id);
    },
    onShareAppMessage: function() {
        return {
            title: "新房",
            path: "/yzxc_sun/pages/new/new"
        };
    }
}));