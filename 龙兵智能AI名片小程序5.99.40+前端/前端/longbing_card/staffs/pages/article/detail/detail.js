var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

function _asyncToGenerator(e) {
    return function() {
        var u = e.apply(this, arguments);
        return new Promise(function(a, i) {
            return function t(e, n) {
                try {
                    var o = u[e](n), r = o.value;
                } catch (e) {
                    return void i(e);
                }
                if (!o.done) return Promise.resolve(r).then(function(e) {
                    t("next", e);
                }, function(e) {
                    t("throw", e);
                });
                a(r);
            }("next");
        });
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        openType: "getUserInfo"
    },
    onLoad: function(P) {
        var M = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, n, o, r, a, i, u, c, l, s, d, f, g, h, _, p, x, m, v, w, A, S, y;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return t = M, wx.showShareMenu({
                        withShareTicket: !0
                    }), n = P.scene ? _xx_util2.default.getSceneParam(decodeURIComponent(P.scene)) : P, 
                    o = n.id, r = n.uid, a = n.to_uid, i = n.fid, u = n.from_id, c = n.err, l = wx.getStorageSync("userid"), 
                    s = {
                        id: o,
                        uid: r || a || l,
                        fid: i || u,
                        err: c
                    }, d = r == l, f = -1 == c ? "导入失败" : "文章详情", wx.setNavigationBarTitle({
                        title: f
                    }), e.next = 10, getApp().getConfigInfo(!0);

                  case 10:
                    return g = getApp().globalData, h = g.isIphoneX, _ = g.productDefault, p = g.userDefault, 
                    x = g.configInfo, m = x.checkArticle, v = x.config, w = v.btn_consult, A = wx.getStorageSync("user"), 
                    S = A.phone, y = {
                        isIphoneX: h,
                        productDefault: _,
                        userDefault: p,
                        hasClientPhone: !!S,
                        btn_consult: w
                    }, t.setData({
                        optionsParam: s,
                        $gd: y,
                        from_id: l,
                        detail_btn_show: d,
                        checkArticle: m
                    }), e.next = 19, t.firstLoad();

                  case 19:
                    t.getAuthInfoSuc(), t.data.article.id || wx.hideShareMenu();

                  case 21:
                  case "end":
                    return e.stop();
                }
            }, e, M);
        }))();
    },
    onHide: function() {
        console.log("onHide"), this.toArticleRecord();
    },
    onUnload: function() {
        console.log("onUnload"), this.toArticleRecord();
    },
    onPageScroll: function(e) {
        this.setData({
            scrollTop: e.scrollTop
        });
    },
    onShareAppMessage: function(e) {
        var t = this, n = t.data.optionsParam, o = n.id, r = n.uid, a = t.data, i = a.from_id, u = a.checkArticle, c = t.data.article, l = c.title, s = c.cover, d = c.is_staff, f = c.my_article_id, g = c.need_confirm, h = "/longbing_card/staffs/pages/article/detail/detail?id=" + (1 == d && u ? f : o) + "&uid=" + r + "&fid=" + i;
        return console.log(h, "tmp_path**"), _index.pluginModel.toArticleShare({
            id: o,
            to_uid: r
        }), 1 == d && u && 1 == g && Promise.all([ _index.pluginModel.toConfirmSync({
            article_id: f
        }), _index.pluginModel.toArticleShare({
            id: f,
            to_uid: r
        }) ]), {
            title: l,
            path: h,
            imageUrl: s
        };
    },
    onPullDownRefresh: function() {
        var t = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return wx.showNavigationBarLoading(), e.next = 3, t.firstLoad();

                  case 3:
                    t.getAuthInfoSuc(), _xx_util2.default.hideAll();

                  case 5:
                  case "end":
                    return e.stop();
                }
            }, e, t);
        }))();
    },
    previewImage: function(e) {
        var t = _xx_util2.default.getData(e).img;
        wx.previewImage({
            current: t,
            urls: [ t ]
        });
    },
    toArticleRecord: function() {
        var e = this.data.optionsParam.uid, t = this.data.article, n = t.id, o = t.record_id;
        o && _index.pluginModel.toArticleShare({
            id: n,
            to_uid: e,
            record_id: o
        });
    },
    contactCallback: function(e) {
        console.log(e, "contactCallback e");
        var t = e.detail.errMsg;
        t.includes("ok") && console.log(t.includes("ok"), "errMsg.includes('ok') contactCallback");
    },
    toShowPanel: function() {
        var e = this.data.detail_btn_show;
        this.setData({
            detail_btn_show: 1 != e
        });
    },
    getAuthInfoSuc: function(e) {
        console.log(e, "getAuthInfoSuc");
        var t = this.data.openType, n = this.data.optionsParam.uid, o = getApp().getCurUserInfo(n, t);
        this.setData(o);
    },
    firstLoad: function() {
        var s = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, n, o, r, a, i, u, c, l;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return n = (t = s).data.optionsParam, o = n.id, r = n.uid, _xx_util2.default.showLoading(), 
                    e.next = 5, Promise.all([ getApp().getConfigInfo(!0), _index.userModel.getCardShow({
                        to_uid: r
                    }), _index.pluginModel.getArticleDetail({
                        id: o,
                        to_uid: r
                    }), _index.pluginModel.getMyArticle({
                        hot: 1,
                        article_id: o,
                        to_uid: r,
                        page: 1
                    }), _index.pluginModel.getArticleQr({
                        id: o,
                        to_uid: r
                    }) ]);

                  case 5:
                    a = e.sent, _xx_util2.default.hideAll(), i = a[1].data, u = a[2].data, c = a[3].data, 
                    l = a[4].data.image, t.setData({
                        staffInfo: i,
                        article: u,
                        hot: c,
                        qr: l
                    });

                  case 12:
                  case "end":
                    return e.stop();
                }
            }, e, s);
        }))();
    },
    toSyncMyArticle: function() {
        var i = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, n, o, r, a;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    if (console.log("同步到我的文章"), t = that.data, n = t.checkArticle, o = t.article, r = o.my_article_id, 
                    a = o.need_confirm, !n || 1 != a) {
                        e.next = 6;
                        break;
                    }
                    return e.next = 6, _index.pluginModel.toConfirmSync({
                        article_id: r
                    });

                  case 6:
                  case "end":
                    return e.stop();
                }
            }, e, i);
        }))();
    },
    toSyncMyNews: function() {
        var o = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, n;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return console.log("同步到动态"), t = o.data.optionsParam.id, e.next = 4, _index.pluginModel.toSyncMyNews({
                        id: t
                    });

                  case 4:
                    n = e.sent, 0 == n.errno && _xx_util2.default.showToast("success", "同步成功");

                  case 7:
                  case "end":
                    return e.stop();
                }
            }, e, o);
        }))();
    },
    getPhoneNumber: function(e) {
        var t = e.detail, n = t.encryptedData, o = t.iv;
        n && o ? (console.log("getPhoneNumber==> 同意授权获取电话号码"), this.setPhoneInfo(n, o)) : console.log("getPhoneNumber==> 拒绝授权获取电话号码"), 
        this.toConsult();
    },
    setPhoneInfo: function(e, t) {
        var n = this, o = n.data.optionsParam.uid;
        _index.baseModel.getPhone({
            encryptedData: e,
            iv: t,
            to_uid: o
        }).then(function(t) {
            _xx_util2.default.hideAll(), getApp().globalData.hasClientPhone = !0, getApp().globalData.auth.authPhoneStatus = !0, 
            n.setData({
                "$gd.hasClientPhone": !0
            }, function() {
                if (t.data.phone) {
                    var e = wx.getStorageSync("user");
                    e.phone = t.data.phone, wx.setStorageSync("user", e);
                }
                n.getAuthInfoSuc();
            });
        });
    },
    toConsult: function() {
        var e = this.data.optionsParam.uid;
        if (0 == e) return console.log(e, "toConsult to_uid"), !1;
        var t = "/longbing_card/chat/userChat/userChat?chat_to_uid=" + e;
        console.log(t, "tmp_path"), wx.navigateTo({
            url: t
        });
    }
});