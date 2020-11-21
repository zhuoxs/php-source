var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

function _asyncToGenerator(t) {
    return function() {
        var n = t.apply(this, arguments);
        return new Promise(function(s, i) {
            return function e(t, a) {
                try {
                    var o = n[t](a), r = o.value;
                } catch (t) {
                    return void i(t);
                }
                if (!o.done) return Promise.resolve(r).then(function(t) {
                    e("next", t);
                }, function(t) {
                    e("throw", t);
                });
                s(r);
            }("next");
        });
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        openType: "getUserInfo",
        globalData: {},
        bgStatus: !1,
        shareStatus: !1
    },
    onLoad: function(t) {
        var l = this;
        console.log(t, "options");
        var e = t.id, a = t.collage_id, o = t.to_uid, d = {
            detailID: e,
            collage_id: a,
            to_uid: o,
            from_id: t.from_id,
            status: t.status,
            sharestatus: t.sharestatus
        };
        o && (getApp().globalData.to_uid = o), getApp().getConfigInfo(!0).then(function() {
            var t = getApp().globalData, e = t.isIphoneX, a = t.moreImgs, o = t.noUserImg, r = t.ingImg, s = t.logoImg, i = t.auth, n = i.authStatus, u = i.authPhoneStatus;
            l.setData({
                paramData: d,
                isIphoneX: e,
                moreImgs: a,
                noUserImg: o,
                ingImg: r,
                logoImg: s,
                authStatus: n,
                authPhoneStatus: u
            }, function() {
                l.getAuthInfoSuc(), l.getProductDetail(), wx.hideLoading();
            });
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var a = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return e = a, wx.showNavigationBarLoading(), t.next = 4, getApp().getConfigInfo(!0);

                  case 4:
                    e.getAuthInfoSuc(), e.getProductDetail();

                  case 6:
                  case "end":
                    return t.stop();
                }
            }, t, a);
        }))();
    },
    onShareAppMessage: function(t) {
        var e = this.data.paramData, a = e.to_uid, o = e.detailID, r = e.collage_id, s = this.data.detailData, i = s.name, n = s.cover_true, u = "/longbing_card/users/pages/shop/releaseCollage/releaseCollage?id=" + o + "&collage_id=" + r + "&to_uid=" + a + "&from_id=" + wx.getStorageSync("userid") + "&status=toPay&sharestatus=fromshare";
        return console.log(u), {
            title: i,
            path: u,
            imageUrl: n
        };
    },
    getAuthInfoSuc: function(t) {
        console.log(t, "getAuthInfoSuc");
        var e = this.data.openType, a = this.data.paramData.to_uid, o = getApp().getCurUserInfo(a, e);
        this.setData(o);
    },
    getProductDetail: function() {
        var o = this;
        console.log(o.data.paramData.to_uid, "app.globalData.to_uid");
        var t = o.data.paramData, e = t.detailID, a = t.to_uid;
        _index.userModel.getShopGoodsDetail({
            goods_id: e,
            to_uid: a
        }).then(function(t) {
            var e = t.data, a = {
                name: e.name,
                collage_count: e.collage_count,
                cover_true: e.cover_true,
                qr: e.qr
            };
            o.setData({
                shareParamObj: a,
                detailData: e,
                tmp_is_self: 1 == e.is_self
            }, function() {
                o.getCollageList();
            });
        });
    },
    getCollageList: function() {
        var c = this, t = c.data.paramData.detailID;
        _index.userModel.getShopCollageList({
            goods_id: t
        }).then(function(t) {
            var e, a = t.data, o = {};
            for (var r in a) c.data.paramData.collage_id == a[r].id && (o = a[r]);
            a = o, console.log(a, "////////////////////////****tmpData");
            var s = 1 * a.left_time - 1, i = parseInt(s / 24 / 60 / 60);
            e = (i = 0 < i ? i + "天 " : "") + _xx_util2.default.formatTime(1e3 * s, "h:m:s"), 
            c.setData({
                tmpTimes: e
            });
            var n = [];
            if (a.users) for (var u in a.users) n.push(a.users[u].id);
            for (var l in a.own && n.push(a.own.id), console.log(n, "************///"), n) wx.getStorageSync("userid") == n[l] && c.setData({
                "paramData.status": "toShare"
            });
            console.log(a, "//////////////////******collageList");
            var d = a, g = {
                price: d.price,
                people: d.people
            };
            c.setData({
                shareParamObj2: g,
                collageList: a
            });
        });
    },
    toJump: function(t) {
        var e = this, a = _xx_util2.default.getData(t).status;
        if ("toCopyright" == a || "toJumpIndex" == a) _xx_util2.default.goUrl(t); else if ("toShare" == a) e.setData({
            bgStatus: !0,
            shareStatus: !0
        }); else if ("toCheckShare" == a) {
            var o = t.currentTarget.dataset.num;
            1 == o || 2 == o && wx.navigateTo({
                url: "/longbing_card/users/pages/shop/collageShare/collageShare"
            }), e.setData({
                bgStatus: !1,
                shareStatus: !1
            });
        } else if ("toJoinCollage" == a) {
            var r = e.data.collageList, s = e.data.detailData, i = e.data.tmp_is_self;
            for (var n in s.spe_price) r.spe_price_id == s.spe_price[n].id && (s.stock = s.spe_price[n].stock);
            e.setData({
                detailData: s
            });
            var u = {
                count_price: r.number * r.price,
                tmp_trolley_ids: s.id,
                tmp_is_self: i,
                dataList: [ {
                    name: s.name,
                    number: r.number,
                    goods_id: s.id,
                    cover_true: s.cover_true,
                    freight: s.freight,
                    spe: e.data.spe_text,
                    price2: r.price,
                    stock: s.stock,
                    collage_id: r.id
                } ]
            };
            wx.setStorageSync("storageToOrder", u);
            var l = "/longbing_card/users/pages/shop/car/toOrder/toOrder?status=" + a;
            "fromshare" == e.data.paramData.sharestatus && (l += "&sharestatus=fromshare"), 
            console.log("dddddddddddddd", l), wx.redirectTo({
                url: l
            });
        }
    }
});