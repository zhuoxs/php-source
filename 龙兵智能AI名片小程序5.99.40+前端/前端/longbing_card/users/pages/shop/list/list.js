var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(a) {
    return a && a.__esModule ? a : {
        default: a
    };
}

function _toConsumableArray(a) {
    if (Array.isArray(a)) {
        for (var t = 0, e = Array(a.length); t < a.length; t++) e[t] = a[t];
        return e;
    }
    return Array.from(a);
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        globalData: {},
        paramShop: {
            page: 1,
            type_id: 0
        },
        refreshShop: !1,
        loadingShop: !0,
        shop_all: {
            page: 1,
            total_page: "",
            list: []
        },
        showMoreStatus: ""
    },
    onLoad: function(a) {
        var e = this;
        console.log(a, "options");
        var t = a.keyword, o = a.all_categoryid, r = a.status, i = a.id, l = {
            keyword: t,
            all_categoryid: o,
            status: r,
            id: i
        }, p = e.data.paramShop, s = wx.getStorageSync("navTypes");
        if ("all" == r) l.categoryid = o, p.type_id = o, l.activeIndex = "100000101"; else if ("nav" == r) for (var n in l.categoryid = i, 
        p.type_id = i, s.sec) i == s.sec[n].id && (l.activeIndex = n);
        s && (l.navTypes = s), getApp().getConfigInfo().then(function() {
            var a = getApp().globalData.price_switch;
            e.setData({
                price_switch: a,
                tmpData: l,
                paramShop: p,
                globalData: app.globalData,
                scrollNav: "scrollNav" + l.categoryid
            }), e.data.tmpData.keyword ? e.getShopSearch() : e.getShopList();
            var t = _xx_util2.default.getTabTextInd(getApp().globalData.tabBar, "toShop")[0];
            t || (t = "商城"), wx.setNavigationBarTitle({
                title: t
            });
        });
    },
    onHide: function() {
        wx.removeStorageSync("navTypes");
    },
    onUnload: function() {
        wx.removeStorageSync("navTypes");
    },
    onPullDownRefresh: function() {
        var a = this;
        a.setData({
            "paramShop.page": 1,
            refreshShop: !0,
            loadingShop: !0
        }, function() {
            wx.showNavigationBarLoading(), a.data.tmpData.keyword ? a.getShopSearch() : a.getShopList();
        });
    },
    onReachBottom: function() {
        var a = this;
        a.setData({
            refreshShop: !1
        });
        var t = a.data.loadingShop, e = a.data.shop_all, o = e.page;
        o == e.total_page || t || (a.setData({
            "paramShop.page": parseInt(o) + 1,
            refreshShop: !1,
            loadingShop: !0
        }), a.data.tmpData.keyword ? a.getShopSearch() : a.getShopList());
    },
    getShopSearch: function() {
        var r = this, a = {
            keyword: r.data.tmpData.keyword
        };
        _index.userModel.getShopSearch(a).then(function(a) {
            _xx_util2.default.hideAll(), console.log("getShopSearch ==>", a.data), console.log(a.data);
            var t = {
                page: 1,
                total_page: 1,
                list: a.data
            }, e = t.list;
            for (var o in e) e[o].shop_price = _xx_util2.default.getNormalPrice((e[o].price / 1e4).toFixed(4));
            r.setData({
                shop_all: t,
                loadingShop: !1,
                refreshShop: !1
            });
        });
    },
    getShopList: function() {
        var i = this, a = i.data, l = a.refreshShop, t = a.paramShop, p = a.shop_all;
        t.to_uid = i.data.globalData.to_uid, l && _xx_util2.default.showLoading(), _index.userModel.getShopList(t).then(function(a) {
            console.log("getShopList ==>", a.data), _xx_util2.default.hideAll();
            var t = p, e = a.data;
            l || (e.list = [].concat(_toConsumableArray(t.list), _toConsumableArray(e.list)));
            var o = e.list;
            for (var r in o) o[r].shop_price = _xx_util2.default.getNormalPrice((o[r].price / 1e4).toFixed(4));
            i.setData({
                shop_all: e,
                loadingShop: !1,
                refreshShop: !1
            });
        });
    },
    toJump: function(a) {
        var t = this, e = _xx_util2.default.getData(a), o = e.status, r = e.type, i = (e.id, 
        e.index), l = e.categoryid;
        if ("toCopyright" == o && _xx_util2.default.goUrl(a), "toShowMore" == o) {
            var p = 0 == r ? 1 : 0;
            t.setData({
                showMoreStatus: p
            });
        } else if ("toTabClickMore" == o || "toTabClick" == o) {
            var s = i, n = l;
            "toTabClickMore" == o && (s = "100000101", n = "All"), t.setData({
                "tmpData.activeIndex": s,
                "tmpData.categoryid": l,
                scrollNav: "scrollNav" + n,
                shop_all: [],
                showMoreStatus: 0,
                "paramShop.page": 1,
                "paramShop.type_id": l,
                refreshShop: !0
            }), t.getShopList();
        } else "toShopDetail" == o && _xx_util2.default.goUrl(a);
    }
});