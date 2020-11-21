var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js"), _xx_request = require("../../../../resource/js/xx_request.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

function _toConsumableArray(t) {
    if (Array.isArray(t)) {
        for (var e = 0, a = Array(t.length); e < t.length; e++) a[e] = t[e];
        return a;
    }
    return Array.from(t);
}

var app = getApp(), voucher = require("../../../../templates/voucher/voucher.js"), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        currPage: "voulist",
        tabList: [ {
            status: "toSetTab",
            name: "待使用"
        }, {
            status: "toSetTab",
            name: "已使用"
        }, {
            status: "toSetTab",
            name: "已过期"
        } ],
        currentIndex: 0,
        scrollNav: "scrollNav0",
        voucherStatus: {
            show: !1,
            status: "unreceive"
        },
        dataList: {
            page: 1,
            total_page: "",
            list: [],
            refresh: !1,
            loading: !0
        },
        checkvou: []
    },
    onLoad: function(t) {
        var e = this;
        console.log(t, "options");
        var a = t.status, o = t.check, u = t.to_uid, r = t.money, s = {
            status: a,
            check: o
        }, n = {
            to_uid: u,
            money: r
        };
        getApp().getConfigInfo().then(function() {
            e.setData({
                globalData: app.globalData,
                paramObj: s,
                couponObj: n
            }, function() {
                "checkvou" == s.status ? e.toGetSouponshop() : e.toGetCouponList();
            });
        });
    },
    onPullDownRefresh: function() {
        var t = this;
        getApp().getConfigInfo(!0).then(function() {
            t.setData({
                globalData: app.globalData
            }, function() {
                t.setData({
                    "dataList.page": 1,
                    "dataList.refresh": !0
                }, function() {
                    wx.showNavigationBarLoading(), "checkvou" == t.data.paramObj.status ? t.toGetSouponshop() : t.toGetCouponList();
                });
            });
        });
    },
    onReachBottom: function() {
        var t = this;
        if ("checkvou" != t.data.paramObj.status) {
            var e = t.data.dataList;
            e.page == e.total_page || e.loading || t.setData({
                "dataList.page": parseInt(e.page) + 1,
                "dataList.loading": !1
            }, function() {
                t.toGetCouponList();
            });
        }
    },
    toGetCouponList: function() {
        var o = this, t = o.data, e = t.currentIndex, u = t.dataList, a = (t.checkvou, {
            page: parseInt(u.page),
            type: e
        });
        (!u.refresh || 0 <= e) && _xx_util2.default.showLoading(), _index.userModel.getCouponList(a).then(function(t) {
            _xx_util2.default.hideAll(), console.log("getCouponList ==>", t.data);
            var e = u, a = t.data;
            u.refresh || (a.list = [].concat(_toConsumableArray(e.list), _toConsumableArray(a.list))), 
            a.refresh = !1, a.loading = !1, o.setData({
                dataList: a
            });
        });
    },
    toGetSouponshop: function() {
        var r = this, t = r.data, e = t.couponObj, s = t.checkvou, n = t.dataList;
        n.refresh || _xx_util2.default.showLoading(), _index.userModel.getSouponshop(e).then(function(t) {
            _xx_util2.default.hideAll(), console.log("getSouponshop ==>", t.data);
            var e = n, a = t.data;
            n.refresh || (a.list = [].concat(_toConsumableArray(e.list), _toConsumableArray(a.list))), 
            a.refresh = !1, a.loading = !1;
            var o = r.data.paramObj;
            if ("checkvou" == o.status) for (var u in a.list) s.push(0), o.check && (s[o.check] = 1);
            r.setData({
                dataList: a,
                checkvou: s
            });
        });
    },
    toGetCouponQr: function(t) {
        var o = this, e = {
            record_id: t
        };
        _index.userModel.getCouponQr(e).then(function(t) {
            _xx_util2.default.hideAll(), console.log("getCouponQr ==>", t.data);
            var e = t.data.path, a = "unreceive";
            1 == o.data.currentIndex && (a = "receive"), o.setData({
                tmp_qr: e,
                "voucherStatus.show": !0,
                "voucherStatus.status": a
            });
        });
    },
    toCloseVoucher: function() {
        voucher.toCloseVoucher(this);
    },
    toJump: function(t) {
        var e = this, a = _xx_util2.default.getData(t), o = a.status, u = a.index, r = e.data, s = r.currentIndex, n = r.dataList, i = r.checkvou, c = r.paramObj, l = n.list[u], h = l.id, d = l.type, p = n.list[u];
        if ("toUseVoucher" == o && 0 == s) if (1 == d) if ("checkvou" == c.status) {
            if (app.globalData.checkvoucher = !1, 0 == i[u]) {
                for (var f in i) i[f] = 0;
                i[u] = 1;
            } else 1 == i[u] && (i[u] = 0);
            e.setData({
                checkvou: i
            }, function() {
                1 == i[u] && (app.globalData.checkvoucher = p, app.globalData.checkvoucher.checkvoucher = u, 
                wx.navigateBack());
            });
        } else _xx_util2.default.goUrl(t); else 2 == d && e.setData({
            currentVoucher: p
        }, function() {
            e.toGetCouponQr(h);
        });
    },
    toTabClick: function(t) {
        var e = _xx_util2.default.getData(t).index;
        this.setData({
            currentIndex: e,
            scrollNav: "scrollNav" + e
        }), this.onPullDownRefresh();
    }
});