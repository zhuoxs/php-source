var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

function _asyncToGenerator(t) {
    return function() {
        var u = t.apply(this, arguments);
        return new Promise(function(r, i) {
            return function e(t, a) {
                try {
                    var n = u[t](a), o = n.value;
                } catch (t) {
                    return void i(t);
                }
                if (!n.done) return Promise.resolve(o).then(function(t) {
                    e("next", t);
                }, function(t) {
                    e("throw", t);
                });
                r(o);
            }("next");
        });
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        refreshCompany: !1
    },
    onLoad: function(f) {
        var p = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, n, o, r, i, u, s, c, d, l;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return console.log(f, "options"), _xx_util2.default.showLoading(), e = p, a = f.type, 
                    n = f.name, o = f.identification, r = f.fromshare, i = f.to_uid, u = f.from_id, 
                    s = {
                        type: a,
                        name: n,
                        identification: o,
                        fromshare: r,
                        to_uid: i,
                        from_id: u
                    }, n && wx.setNavigationBarTitle({
                        title: n
                    }), i && (getApp().globalData.to_uid = i), e.setData({
                        paramData: s
                    }), t.next = 10, p.firstLoad(1);

                  case 10:
                    _xx_util2.default.hideAll(), c = getApp().globalData, d = c.isIphoneX, l = c.configInfo, 
                    e.setData({
                        isIphoneX: d,
                        copyright: l.config
                    });

                  case 13:
                  case "end":
                    return t.stop();
                }
            }, t, p);
        }))();
    },
    onPageScroll: function(t) {
        var e = this.data.companyData;
        for (var a in e) 8 == e[a].type && (e[a].showTextArea = !1);
        this.setData({
            companyData: e
        });
    },
    onPullDownRefresh: function() {
        var e = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return e.setData({
                        refreshCompany: !0
                    }), wx.showNavigationBarLoading(), t.next = 5, e.firstLoad();

                  case 5:
                  case "end":
                    return t.stop();
                }
            }, t, e);
        }))();
    },
    onShareAppMessage: function(t) {
        var e = this.data.paramData, a = e.to_uid, n = e.name, o = e.type, r = e.identification, i = wx.getStorageSync("userid");
        return console.log("/longbing_card/users/pages/company/contact/contact?to_uid=" + a + "&from_id=" + i + "&type=" + o + "&name=" + n + "&identification=" + r + "&fromshare=true"), 
        {
            title: n,
            path: "/longbing_card/users/pages/company/contact/contact?to_uid=" + a + "&from_id=" + i + "&type=" + o + "&name=" + n + "&identification=" + r + "&fromshare=true",
            imageUrl: ""
        };
    },
    firstLoad: function(g) {
        var _ = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, n, o, r, i, u, s, c, d, l, f, p, m, x;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    if (a = (e = _).data, n = a.refreshCompany, o = a.paramData, r = o.fromshare, i = o.to_uid, 
                    u = o.from_id, s = wx.getStorageSync("userid"), n || _xx_util2.default.showLoading(), 
                    c = void 0, 1 != g || i == s) {
                        t.next = 12;
                        break;
                    }
                    return t.next = 9, Promise.all([ getApp().getConfigInfo(!0), _index.userModel.getModular({
                        to_uid: i
                    }), getApp().getCardAfter() ]);

                  case 9:
                    c = t.sent, t.next = 15;
                    break;

                  case 12:
                    return t.next = 14, Promise.all([ getApp().getConfigInfo(!0), _index.userModel.getModular({
                        to_uid: i
                    }) ]);

                  case 14:
                    c = t.sent;

                  case 15:
                    for (m in _xx_util2.default.hideAll(), d = c[1], l = d.data.company_modular, p = !(n = !(f = [])), 
                    l) l[m].id == o.identification && l[m].type == o.type && (f.push(l[m]), 4 == l[m].type && (p = !1, 
                    l[m].info.markers = [ {
                        iconPath: "https://retail.xiaochengxucms.com/images/12/2018/11/A33zQycihMM33y337LH23myTqTl3tl.png",
                        id: 1,
                        callout: {
                            content: l[m].info.address,
                            fontSize: 14,
                            bgColor: "#ffffff",
                            padding: 4,
                            display: "ALWAYS",
                            textAlign: "center",
                            borderRadius: 2
                        },
                        latitude: l[m].info.latitude,
                        longitude: l[m].info.longitude,
                        width: 28,
                        height: 28
                    } ]), 8 == l[m].type && (p = !1, l[m].showTextArea = !1));
                    1 == p && (u || (u = wx.getStorageSync("userid")), x = "确定", "true" == r && (x = "返回首页"), 
                    wx.showModal({
                        title: "提示",
                        content: "该内容不存在或已删除",
                        confirmText: x,
                        showCancel: !1,
                        success: function(t) {
                            t.confirm && "true" == r && wx.reLaunch({
                                url: "/longbing_card/pages/index/index?to_uid=" + i + "&from_id=" + u + "&currentTabBar=toCompany"
                            });
                        }
                    })), e.setData({
                        companyData: f,
                        refreshCompany: n
                    });

                  case 24:
                  case "end":
                    return t.stop();
                }
            }, t, _);
        }))();
    },
    getModularForm: function(t, e, a, n) {
        var o = {
            modular_id: this.data.companyData[n].id,
            name: t,
            phone: e,
            content: a
        };
        _index.userModel.getModularForm(o).then(function(t) {
            _xx_util2.default.hideAll(), wx.showModal({
                title: "",
                content: "留言成功，请等待管理员处理",
                showCancel: !1,
                confrimText: "知道啦"
            });
        });
    },
    toOnBlur: function(t) {
        var e = _xx_util2.default.getData(t).index, a = this.data.companyData;
        a[e].showTextArea = !1, this.setData({
            companyData: a
        });
    },
    getTextAreaVal: function(t) {
        var e = _xx_util2.default.getData(t).index, a = this.data.companyData;
        a[e].textVal = t.detail.value, this.setData({
            companyData: a
        });
    },
    toJump: function(o) {
        var e = this, t = _xx_util2.default.getData(o), a = t.status, r = t.content;
        t.index;
        if ("toCopyright" == a) _xx_util2.default.goUrl(o); else if ("toCall" == a) {
            if (!r || "暂未填写" == r) return !1;
            wx.makePhoneCall({
                phoneNumber: r,
                success: function(t) {}
            });
        } else "toCompanyMap" == a && wx.authorize({
            scope: "scope.userLocation",
            success: function(t) {
                wx.getLocation({
                    type: "gcj02",
                    success: function(t) {
                        var e = _xx_util2.default.getData(o), a = e.latitude, n = e.longitude;
                        wx.openLocation({
                            latitude: +a,
                            longitude: +n,
                            name: r,
                            scale: 28
                        });
                    }
                });
            },
            fail: function(t) {
                e.setData({
                    isSetting: !0
                });
            }
        });
    },
    formTmpSubmit: function(t) {
        var e = t.detail.formId, a = _xx_util2.default.getFormData(t), n = a.status, o = a.index, r = t.detail.value, i = r.name, u = r.phone, s = r.content;
        if ("toFormSubmit" == n) {
            if (!i) return wx.showModal({
                title: "",
                content: "请填写您的名字！"
            }), !1;
            if (!u) return wx.showModal({
                title: "",
                content: "请填写您的联系电话！"
            }), !1;
            if (!s) return wx.showModal({
                title: "",
                content: "请填写您想说的话！"
            }), !1;
            this.getModularForm(i, u, s, o);
        }
        this.toSaveFormIds(e);
    },
    formSubmit: function(t) {
        var e = t.detail.formId, a = _xx_util2.default.getFormData(t), n = (a.index, a.status);
        _index.baseModel.getFormId({
            formId: e
        }), "toHome" == n && wx.reLaunch({
            url: "/longbing_card/pages/index/index?to_uid=" + app.globalData.to_uid + "&from_id=" + app.globalData.from_id + "&currentTabBar=toCard"
        });
    }
});