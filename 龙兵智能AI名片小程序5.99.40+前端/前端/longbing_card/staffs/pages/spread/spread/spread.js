var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

function _asyncToGenerator(t) {
    return function() {
        var s = t.apply(this, arguments);
        return new Promise(function(o, n) {
            return function e(t, a) {
                try {
                    var i = s[t](a), r = i.value;
                } catch (t) {
                    return void n(t);
                }
                if (!i.done) return Promise.resolve(r).then(function(t) {
                    e("next", t);
                }, function(t) {
                    e("throw", t);
                });
                o(r);
            }("next");
        });
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        type: "",
        dataList: [],
        tmpMore: [],
        page: 1,
        more: !0,
        loading: !1,
        isEmpty: !1,
        show: !1
    },
    onLoad: function(n) {
        var s = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, i, r, o;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return e = s, _xx_util2.default.showLoading(), wx.hideShareMenu(), a = n.type, t.next = 6, 
                    getApp().getConfigInfo();

                  case 6:
                    i = getApp().globalData, r = i.isIphoneX, i.configInfo, e.setData({
                        type: a,
                        isIphoneX: r
                    }), o = void 0, 1 == n.type ? o = "产品推广" : 2 == n.type ? o = "动态推广" : 3 == n.type && (o = "名片推广", 
                    e.getCardIndexData()), wx.setNavigationBarTitle({
                        title: o
                    }), e.getListData(), _xx_util2.default.hideAll();

                  case 13:
                  case "end":
                    return t.stop();
                }
            }, t, s);
        }))();
    },
    onPullDownRefresh: function() {
        _xx_util2.default.showLoading();
        wx.showNavigationBarLoading(), this.setData({
            dataList: [],
            page: 1,
            more: !0,
            loading: !1,
            isEmpty: !1,
            show: !1
        }), this.getListData(), wx.stopPullDownRefresh(), _xx_util2.default.hideAll();
    },
    onReachBottom: function() {
        _xx_util2.default.showLoading();
        var t = this;
        t.setData({
            show: !0
        }), 0 == t.data.isEmpty && (t.setData({
            page: t.data.page + 1
        }), t.getListData()), _xx_util2.default.hideAll();
    },
    getCardIndexData: function() {
        var a = this;
        _xx_util2.default.showLoading();
        var t = {
            to_uid: wx.getStorageSync("userid")
        };
        _index.userModel.getCardShow(t).then(function(t) {
            _xx_util2.default.hideAll(), console.log("getCardShow ==>", t.data);
            var e = t.data;
            a.setData({
                cardIndexData: e
            });
        });
    },
    getListData: function() {
        var p = this, t = p.data, e = t.page, a = t.type;
        _index.staffModel.getExtDetail({
            page: e,
            type: a
        }).then(function(t) {
            _xx_util2.default.hideAll();
            var e = t.data.list;
            if (0 == e.length) return p.setData({
                more: !1,
                loading: !1,
                isEmpty: !0,
                show: !0
            }), !1;
            p.setData({
                loading: !0
            });
            var a = p.data.dataList, i = (new Date().getTime() / 1e3).toFixed(0);
            for (var r in e) {
                for (var o in e[r].cover) e[r].cover[o] || e[r].cover.splice(o, 1);
                for (var n in e[r].groups) if (e[r].groups[n].update_time = parseInt(e[r].groups[n].update_time), 
                e[r].groups[n].update_time) {
                    e[r].groups[n].update_time = i - e[r].groups[n].update_time;
                    var s = parseInt(e[r].groups[n].update_time / 86400), u = parseInt(e[r].groups[n].update_time / 3600);
                    e[r].groups[n].update_time = 0 < s ? s + "天前互动" : 0 < u ? u + "小时前互动" : "";
                } else e[r].groups[n].update_time = "";
                a.push(e[r]);
            }
            p.setData({
                dataList: a
            });
            var d = p.data.dataList, l = [];
            for (var g in d) l.push("0");
            p.setData({
                tmpMore: l
            });
        });
    },
    toJump: function(t) {
        var e = _xx_util2.default.getData(t), a = e.status, i = e.id, r = e.opengid;
        "toCopyright" == a && _xx_util2.default.goUrl(t), "toShopDetail" == a ? wx.navigateTo({
            url: "/longbing_card/pages/shop/detail/detail?id=" + i
        }) : "toNewsDetail" == a ? wx.navigateTo({
            url: "/longbing_card/users/pages/news/detail/detail?id=" + i + "&to_uid=" + wx.getStorageSync("userid") + "&from_id=" + wx.getStorageSync("userid")
        }) : "toCodeDetail" == a ? 0 == i ? wx.navigateTo({
            url: "/longbing_card/users/pages/card/share/share"
        }) : wx.navigateTo({
            url: "/longbing_card/staffs/pages/spread/code/code?id=" + i + "&name=" + this.data.cardIndexData.info.name + "&avatar=" + this.data.cardIndexData.info.avatar
        }) : "toSpreadDetail" == a && wx.navigateTo({
            url: "/longbing_card/staffs/pages/spread/detail/detail?id=" + i + "&opengid=" + r
        });
    }
});