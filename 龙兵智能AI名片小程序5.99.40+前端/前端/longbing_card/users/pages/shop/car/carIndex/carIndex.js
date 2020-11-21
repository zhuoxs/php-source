var _xx_util = require("../../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index3 = require("../../../../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        globalData: {},
        dataList: [],
        manageStatus: 0,
        idList: {},
        isAll: !1,
        icon_car_empty: "http://retail.xiaochengxucms.com/images/12/2018/11/uAsB6O4AbAC6cs3IU4OZZaa64cBu3Z.png"
    },
    onLoad: function(t) {
        console.log(this);
        this.setData({
            globalData: app.globalData
        });
    },
    onShow: function() {
        _xx_util2.default.showLoading();
        var t = this;
        t.setData({
            isAll: !1
        }, function() {
            t.getShopMyTrolley();
        }), _xx_util2.default.hideAll();
    },
    onPullDownRefresh: function() {
        wx.showNavigationBarLoading(), this.getShopMyTrolley();
    },
    getShopMyTrolley: function() {
        var o = this;
        _index3.userModel.getShopMyTrolley().then(function(t) {
            _xx_util2.default.hideAll();
            var e = t.data, i = [];
            for (var a in e.list) i.push(0);
            o.setData({
                dataList: e,
                idList: i
            });
        });
    },
    toShopUpdateTrolley: function(t) {
        var e = this;
        _index3.userModel.getShopUpTro(t).then(function(t) {
            _xx_util2.default.hideAll(), 0 == t.errno && e.toCountPrice();
        });
    },
    toShopDelTrolley: function(t, a) {
        var o = this;
        _index3.userModel.getShopDelTro(t).then(function(t) {
            if (_xx_util2.default.hideAll(), 0 != t.errno) return !1;
            if ("delete" != a) {
                var e = o.data.dataList, i = o.data.idList;
                i.splice(a, 1), e.list.splice(a, 1), o.setData({
                    idList: i,
                    dataList: e
                }), o.toCountPrice();
            }
        });
    },
    RemoveAddNum: function(t) {
        var i = this, e = t.currentTarget.dataset.status, a = t.currentTarget.dataset.index, o = i.data.dataList, l = o.list[a].stock, s = 1;
        "remove" == e && (s = 2);
        var r = {
            id: o.list[a].id,
            type: s,
            number: 1
        };
        if ("remove" == e && (console.log("购物车-1", a), 1 == o.list[a].number ? wx.showModal({
            title: "",
            content: "是否确认删除本条数据",
            success: function(t) {
                if (t.confirm) {
                    var e = {
                        id: o.list[a].id
                    };
                    i.toShopDelTrolley(e, a);
                } else t.cancel;
            }
        }) : (o.list[a].number = 1 * o.list[a].number - 1, o.list[a].price = o.list[a].number * o.list[a].price2, 
        i.toShopUpdateTrolley(r))), "add" == e) {
            if (console.log("购物车+1", a), o.list[a].number > l - 1) return wx.showModal({
                title: "",
                content: "库存不足，不能再添加了",
                confirmText: "知道啦",
                showCancel: !1,
                success: function(t) {
                    t.confirm;
                }
            }), !1;
            o.list[a].number = 1 * o.list[a].number + 1, o.list[a].price = o.list[a].number * o.list[a].price2, 
            i.toShopUpdateTrolley(r);
        }
        i.setData({
            dataList: o
        }), i.toCountPrice();
    },
    toCountPrice: function() {
        var t = this, e = t.data.dataList, i = t.data.idList, a = 0, o = "", l = !1, s = [];
        for (var r in e.list) 1 == i[r] && (a += 1 * e.list[r].price, s.push(e.list[r]), 
        o += e.list[r].id + ",", 1 == e.list[r].is_self && (l = !0));
        o = o.slice(0, -1);
        var n = {
            count_price: a.toFixed(2),
            tmp_trolley_ids: o,
            tmp_is_self: l,
            dataList: s
        };
        t.setData({
            dataList: e,
            countPrice: a.toFixed(2),
            tmpCarList: n,
            tmp_is_self: l,
            trolley_ids: o
        });
    },
    checkIsAll: function() {
        var t = this, e = t.data.isAll, i = t.data.idList, a = !0;
        for (var o in i) 0 == i[o] && (a = !1);
        e = a, t.setData({
            isAll: e
        });
    },
    toJump: function(t) {
        var a = this, e = _xx_util2.default.getData(t), i = e.status, o = e.index, l = a.data.dataList.list;
        if ("toProductDetail" == i) _xx_util2.default.goUrl(t); else if ("toManage" == i) {
            var s;
            console.log("管理商品"), 0 == o && (s = 1), 1 == o && (s = 0), a.setData({
                manageStatus: s
            });
        } else if ("toDelete" == i) console.log("删除本条数据"), wx.showModal({
            title: "",
            content: "是否确认删除本条数据",
            success: function(t) {
                if (t.confirm) {
                    _xx_util2.default.showLoading({
                        title: "数据删除中"
                    });
                    var e = {
                        id: l[o].id
                    };
                    a.toShopDelTrolley(e, o), wx.hideLoading();
                } else t.cancel;
            }
        }); else if ("toCheck" == i) {
            console.log("选择产品");
            var r = a.data.idList;
            r[o] ? (r[o] = 0, a.isAll = !1, a.setData({
                isAll: !1
            })) : r[o] = 1, a.setData({
                idList: r
            }), a.toCountPrice(), a.checkIsAll();
        } else if ("toChooseAll" == i) {
            console.log("全选");
            var n = (a = this).data.isAll, d = a.data.idList;
            if (n = !n, a.isAll = n, a.setData({
                isAll: n
            }), n) for (var u in d) d[u] = 1; else for (var c in d) d[c] = 0;
            a.setData({
                idList: d
            }), a.toCountPrice();
        } else if ("toOrderPay" == i) {
            var f = a.data.manageStatus, h = (d = a.data.idList, a.data.dataList.list);
            if (1 == f) {
                console.log("批量删除");
                var x = !1, _ = 0;
                for (var p in d) 1 == d[p] && (x = !0, _++);
                if (0 == x) return _xx_util2.default.showFail("请选择要进行删除的商品！"), !1;
                var g = "是否要进行删除操作？";
                1 < _ && (g = "是否要进行批量删除？"), wx.showModal({
                    title: "",
                    content: g,
                    success: function(t) {
                        if (t.confirm) {
                            for (var e in _xx_util2.default.showLoading({
                                title: "数据删除中"
                            }), d) if (1 == d[e]) {
                                var i = {
                                    id: h[e].id
                                };
                                a.toShopDelTrolley(i, "delete");
                            }
                            setTimeout(function() {
                                a.getShopMyTrolley(), wx.hideLoading();
                            }, 500);
                        } else t.cancel;
                    }
                });
            } else if (0 == f) {
                if (console.log("去结算"), !a.data.trolley_ids) return wx.showToast({
                    icon: "none",
                    title: "暂未选择任何商品哦",
                    duration: 2e3
                }), !1;
                wx.setStorageSync("storageToOrder", a.data.tmpCarList), wx.navigateTo({
                    url: "/longbing_card/users/pages/shop/car/toOrder/toOrder?status=toCarOrder"
                });
            }
        }
    }
});