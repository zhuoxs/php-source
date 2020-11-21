var _xx_util = require("../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

function _toConsumableArray(t) {
    if (Array.isArray(t)) {
        for (var a = 0, e = Array(t.length); a < t.length; a++) e[a] = t[a];
        return e;
    }
    return Array.from(t);
}

function _asyncToGenerator(t) {
    return function() {
        var s = t.apply(this, arguments);
        return new Promise(function(i, r) {
            return function a(t, e) {
                try {
                    var o = s[t](e), n = o.value;
                } catch (t) {
                    return void r(t);
                }
                if (!o.done) return Promise.resolve(n).then(function(t) {
                    a("next", t);
                }, function(t) {
                    a("throw", t);
                });
                i(n);
            }("next");
        });
    };
}

var timer, timerCoupon, app = getApp(), auth = require("../../templates/auth/auth.js"), voucher = require("../../templates/voucher/voucher.js"), regeneratorRuntime = _xx_util2.default.regeneratorRuntime, innerAudioContext = wx.createInnerAudioContext(), innerAudioContextBG = wx.createInnerAudioContext();

Page({
    data: {
        toshowBG: !1,
        isToShowCard: !1,
        changeCardText: "交换手机号码",
        color: "23,162,52",
        voucherStatus: {
            show: !0,
            status: "unreceive"
        },
        tmp_coupon_i: 0,
        coupon_record: !1,
        coupon_nickName: "",
        coupon_reduce: "",
        sharePanel: !1,
        globalData: {},
        userid: "",
        showTabBar: !1,
        currentTabBarInd: "",
        currentTabBar: "cardList",
        toLeavingMessage: "",
        qrImg: "",
        avatarUrl: "",
        avatarName: "",
        cardToAddStatus: !1,
        customID: "",
        collectStatus: "-1",
        collectionList: {
            page: 1,
            total_page: "",
            list: []
        },
        paramCardList: {
            page: 1
        },
        refreshCardList: !1,
        loadingCardList: !0,
        moreStatus: 1,
        playPushStatus: 1,
        playPushBgStatus: 0,
        showShareStatus: 0,
        cardZanType: "",
        cardIndexData: {},
        refreshCardIndex: !1,
        paramNews: {
            page: 1,
            to_uid: ""
        },
        refreshNews: !1,
        loadingNews: !0,
        newsList: {
            page: 1,
            total_page: "",
            list: []
        },
        newsIndex: [],
        evaStatus: !1,
        currentNewsIndex: "",
        evaContent: "",
        ThumbsId: "",
        evaId: "",
        swiperStatus: {
            indicatorDots: !1,
            autoplay: !0
        },
        swiperIndexCur: 0,
        refreshCompany: !1,
        icon_voice_png: "https://retail.xiaochengxucms.com/images/12/2018/11/IgvvwVNUIVn6UMh4Dmh4m6nM4Widug.png",
        icon_voice_gif: "https://retail.xiaochengxucms.com/images/12/2018/11/CRFPPPTKf6f45J6H3N44BNCrjbFZxH.gif"
    },
    onLoad: function(G) {
        var k = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var a, e, o, n, i, r, s, u, d, l, c, g, p, f, h, _, m, x, w, b, v, S, D, y, C, A, I, T, B, P, L, N, M;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return a = k, _xx_util2.default.showLoading(), console.log("options************", G), 
                    wx.hideShareMenu(), e = G.scene ? _xx_util2.default.getSceneParam(decodeURIComponent(G.scene)) : G, 
                    o = e.to_uid, n = e.uid, i = e.from_id, r = e.fid, s = e.currentTabBar, e.type, 
                    u = e.custom, d = e.is_qr, (l = "cardList" != (s = s || "cardList")) && wx.showShareMenu({
                        withShareTicket: "toCard" == s
                    }), u && a.getCustomQrRecordInsert(u), c = {
                        to_uid: o || n,
                        from_id: i || r
                    }, g = {
                        page: 1,
                        to_uid: o || n
                    }, getApp().globalData.to_uid = c.to_uid || "", a.setData({
                        is_qr: d || 0,
                        showTabBar: l,
                        currentTabBar: s,
                        paramData: c,
                        paramNews: g,
                        userid: wx.getStorageSync("userid")
                    }), t.next = 15, getApp().getConfigInfo();

                  case 15:
                    _xx_util2.default.hideAll(), (p = wx.getStorageSync("user")) && (getApp().globalData.hasClientPhone = !!p.phone, 
                    getApp().globalData.auth.authStatus = !!p.nickName, getApp().globalData.auth.authPhoneStatus = !!p.phone), 
                    f = getApp().globalData, h = f.price_switch, _ = f.configInfo, m = f.hasClientPhone, 
                    x = f.auth, w = _.config, b = w.plugin, v = w.force_phone, S = w.exchange_switch, 
                    D = w.exchange_btn, y = w.btn_consult, C = w.btn_talk, A = w.motto_switch, I = w.mini_app_name, 
                    T = x.authPhoneStatus, B = x.authStatus, T = !(1 == v && B && !T), P = "cardList" == s ? [ "名片列表", 0 ] : "toCard" == s ? I ? [ I, 0 ] : [ getApp().globalData.tabBar.list[0].text, 0 ] : _xx_util2.default.getTabTextInd(getApp().globalData.tabBar, s), 
                    wx.setNavigationBarTitle({
                        title: P[0] || P
                    }), a.setData({
                        nowPageIndex: P[1] || 0
                    }), "toShop" == s && (L = P[1], (N = getApp().globalData.tabBar.list)[L].pagePath2 && (M = N[L].pagePath2 + "?uid=" + G.to_uid + "&fid=" + G.from_id, 
                    wx.reLaunch({
                        url: M,
                        fail: function(t) {
                            console.log(t);
                        }
                    }))), a.setData({
                        globalData: getApp().globalData,
                        plugin: b,
                        hasClientPhone: m,
                        authPhoneStatus: T,
                        authStatus: B,
                        exchange_switch: S,
                        changeCardText: D,
                        isToShowCard: !1,
                        price_switch: h,
                        btn_consult: y,
                        btn_talk: C,
                        motto_switch: A
                    }, function() {
                        setTimeout(function() {
                            "cardList" == s ? a.setData({
                                collectionList: {
                                    page: 1,
                                    total_page: "",
                                    list: []
                                }
                            }, function() {
                                a.getCollectionList();
                            }) : (a.getCardIndexData(), "toCard" == s ? 1044 == getApp().globalData.loginParam.scene && (timer = setInterval(function() {
                                getApp().globalData.encryptedData && (a.toGetShareInfo(), clearInterval(timer));
                            }, 1e3)) : "toShop" == s ? console.log("加载toShop onLoad") : "toNews" == s ? a.getNewsList() : "toCompany" == s && a.getModular());
                        }, 200);
                    }), 0 == a.data.cardToAddStatus && setTimeout(function() {
                        a.setData({
                            cardToAddStatus: !0
                        }, setTimeout(function() {
                            a.setData({
                                cardToAddStatus: !1
                            }, setTimeout(function() {
                                a.setData({
                                    nofont: !0
                                });
                            }, 1e3));
                        }, 1e4));
                    }, 3e3);

                  case 29:
                  case "end":
                    return t.stop();
                }
            }, t, k);
        }))();
    },
    subscribe: function() {
        var a = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    a.toSendUnMsg(), getApp().websocket.subscribe("unread", a.getUserUnreadNum), getApp().websocket.subscribe("getMsg", a.getMsgUnreadNum);

                  case 3:
                  case "end":
                    return t.stop();
                }
            }, t, a);
        }))();
    },
    toSendUnMsg: function() {
        var t = wx.getStorageSync("userid"), a = getApp().globalData.to_uid;
        getApp().websocket.sendMessage({
            unread: !0,
            user_id: t,
            to_uid: a
        });
    },
    getUserUnreadNum: function(t) {
        var a = t.data, e = a.user_count, o = {
            user_count: e,
            staff_count: a.staff_count
        };
        getApp().getUnReadNum(o), this.toMsgAnimatoins(e);
    },
    getMsgUnreadNum: function(t) {
        var a = t.user_count, e = t.staff_count;
        if (t.data2.user_id == getApp().globalData.to_uid) {
            var o = {
                user_count: a,
                staff_count: e
            };
            getApp().getUnReadNum(o), this.toMsgAnimatoins(a);
        }
    },
    toMsgAnimatoins: function(t) {
        var a = this;
        a.setData({
            clientUnread: t
        }), t <= 0 || (a.setData({
            clientUnreadImg: !0
        }), setTimeout(function() {
            a.setData({
                clientUnreadImg: !1
            });
        }, 5e3));
    },
    onShow: function(t) {
        console.log("页面显示");
        var a = this;
        console.log(t, "***************** options");
        var e = a.data.currentTabBar, o = a.data.globalData.tabBarList;
        for (var n in o) e == o[n].type && a.setData({
            currentTabBarInd: n
        });
        "createCard" == a.data.onshowStatus && (getApp().globalData.configInfo = !1, getApp().getConfigInfo(!0).then(function() {
            a.setData({
                showTabBar: !1,
                company_company: {},
                company_modular: [],
                globalData: getApp().globalData,
                collectionList: {
                    page: 1,
                    total_page: "",
                    list: []
                },
                "paramCardList.page": 1,
                onshowStatus: ""
            }, function() {
                a.getCollectionList();
            });
        }));
        var i = a.data, r = i.currentTabBar, s = i.cardIndexData, u = i.toshowBG;
        "toCard" == r && s.info && a.setData({
            "voucherStatus.status": 0
        }, function() {
            a.getCardAfter(), s.info.bg && 1 == u && (innerAudioContextBG.src = s.info.bg, a.toPlayBgMusic()), 
            console.log(u, "toshowBG");
        }), a.subscribe();
    },
    onHide: function() {
        console.log("页面隐藏");
        getApp().websocket.unSubscribe("unread"), getApp().websocket.unSubscribe("getMsg"), 
        clearInterval(timer), clearInterval(timerCoupon);
    },
    onUnload: function() {
        console.log("页面关闭");
        innerAudioContext.src = "", innerAudioContextBG.src = "", getApp().websocket.unSubscribe("unread"), 
        getApp().websocket.unSubscribe("getMsg"), clearInterval(timer), clearInterval(timerCoupon);
    },
    onPullDownRefresh: function() {
        var u = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var a, e, o, n, i, r, s;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return a = u, wx.getStorageSync("user").avatarUrl || a.checkAuthStatus(), e = a.data.currentTabBar, 
                    o = "cardList" != e, t.next = 6, getApp().getConfigInfo(!0);

                  case 6:
                    n = getApp().globalData, i = n.price_switch, r = n.configInfo, s = r.config.motto_switch, 
                    a.setData({
                        price_switch: i,
                        motto_switch: s,
                        showTabBar: o,
                        globalData: getApp().globalData
                    }, function() {
                        wx.showNavigationBarLoading(), "cardList" == e ? a.setData({
                            refreshCardList: !0,
                            cardSearchKey: "",
                            "paramCardList.page": 1,
                            "collectionList.page": 1,
                            "collectionList.list": []
                        }, function() {
                            a.getCollectionList();
                        }) : "toCard" == e ? (clearInterval(timerCoupon), a.setData({
                            refreshCardIndex: !0
                        }, function() {
                            a.toBGdestroy(), a.setData({
                                toshowBG: !1
                            }), a.getCardIndexData();
                        })) : "toNews" == e ? a.setData({
                            refreshNews: !0,
                            "paramNews.page": 1,
                            "newsList.page": 1,
                            "newsList.list": []
                        }, function() {
                            a.getNewsList();
                        }) : "toCompany" == e && a.setData({
                            refreshCompany: !0
                        }, function() {
                            a.getModular();
                        });
                    });

                  case 9:
                  case "end":
                    return t.stop();
                }
            }, t, u);
        }))();
    },
    onReachBottom: function() {
        var r = this, t = !1;
        "cardList" != r.data.currentTabBar && (t = !0), r.setData({
            showTabBar: t,
            loadingShop: !1,
            loadingNews: !1
        }, function() {
            if ("cardList" == r.data.currentTabBar) {
                var t = r.data.loadingCardList, a = r.data.collectionList, e = a.page;
                e == a.total_page || t || (r.setData({
                    "paramCardList.page": parseInt(e) + 1,
                    loadingCardList: !0
                }), r.getCollectionList());
            } else if ("toNews" == r.data.currentTabBar) {
                var o = r.data.loadingNews, n = r.data.newsList, i = n.page;
                i == n.total_page || o || (r.setData({
                    "paramNews.page": parseInt(i) + 1,
                    loadingNews: !0
                }), r.getNewsList());
            }
        });
    },
    onPageScroll: function(t) {
        var a = this.data.newsIndex;
        for (var e in a) (a[e] = 1) && (a[e] = 0);
        this.setData({
            evaStatus: !1,
            newsIndex: a
        }), "cardList" != this.data.currentTabBar && this.setData({
            showTabBar: !0
        });
    },
    onShareAppMessage: function(t) {
        var a = this, e = a.data.paramData.to_uid, o = wx.getStorageSync("userid");
        if ("toCard" == a.data.currentTabBar) {
            a.toVideoStop(), a.toBGdestroy();
            var n = a.data.cardIndexData;
            a.getShareRecord();
            var i = Date.now(), r = n.info, s = r.share_text, u = r.job_name, d = r.name, l = r.myCompany, c = s;
            if (e != wx.getStorageSync("userid")) a.getForwardRecord(1, 0), c = "这是" + (l.short_name ? "" + l.short_name + u + d : "" + d) + "的名片，请查看。";
            var g = n.share_img;
            if (g && "cardType1" != n.info.card_type && "cardType4" != n.info.card_type || (g = n.info.avatar_2), 
            g = g + "?" + i, "button" === t.from && n.coupon.id) {
                var p = t.target.dataset.status;
                console.log(p, "status"), "toVoucher" == p && (c = n.coupon.title, g = "https://retail.xiaochengxucms.com/images/2/2019/01/mFL0pH86Fd8bsLS3HF98oIJeFdcs6F.png");
            }
            var f = "/longbing_card/pages/index/index?to_uid=" + e + "&from_id=" + o + "&currentTabBar=toCard";
            return console.log(f, "==> toCard share_path"), {
                title: c,
                path: f,
                imageUrl: g
            };
        }
        if ("toNews" == a.data.currentTabBar) {
            if ("button" === t.from) {
                var h = t.target.dataset, _ = h.index, m = (h.status, h.id), x = void 0, w = (n = a.data.newsList.list)[_].cover[0];
                if (0 == n[_].type) {
                    if (x = "/longbing_card/users/pages/news/detail/detail?id=" + m + "&fromshare=true&from_id=" + o, 
                    0 != n[_].user_id && (x = x + "&isStaff=true&to_uid=" + n[_].user_info.fans_id), 
                    0 == n[_].user_id) x = x + "&companyName=" + a.data.newsList.timeline_company.name + "&to_uid=" + e;
                } else if (1 == n[_].type) x = "/longbing_card/users/pages/news/detail/detail?to_uid=" + e + "&from_id=" + o + "&id=" + m + "&status=toPlayVideo&name=" + n[_].title + "&fromshare=true"; else if (2 == n[_].type) x = "/longbing_card/common/transtion/transtion?to_uid=" + e + "&from_id=" + o + "&id=" + m + "&status=toNewsLine&name=" + n[_].title + "&fromshare=true"; else if (3 == n[_].type) {
                    var b = n[_];
                    x = "/longbing_card/staffs/pages/article/detail/detail?id=" + b.article_id + "&uid=" + b.user_info.fans_id;
                }
                return a.data.paramData.to_uid != wx.getStorageSync("userid") && a.getForwardRecord(3, m), 
                console.log(x, "==> toNews share_path"), {
                    title: n[_].title,
                    path: x,
                    imageUrl: w
                };
            }
            return console.log("/longbing_card/pages/index/index?to_uid=" + e + "&from_id=" + o + "&currentTabBar=toNews", "==> toNews share_path"), 
            {
                title: "",
                path: "/longbing_card/pages/index/index?to_uid=" + e + "&from_id=" + o + "&currentTabBar=toNews",
                imageUrl: ""
            };
        }
        if ("toCompany" == a.data.currentTabBar) return a.data.paramData.to_uid != wx.getStorageSync("userid") && a.getForwardRecord(4, 0), 
        console.log("/longbing_card/pages/index/index?to_uid=" + e + "&from_id=" + o + "&currentTabBar=toCompany", "==> toCompany share_path"), 
        {
            title: "",
            path: "/longbing_card/pages/index/index?to_uid=" + e + "&from_id=" + o + "&currentTabBar=toCompany",
            imageUrl: ""
        };
    },
    toConsult: function() {
        var r = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var a, e, o, n, i;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    if (a = r, e = getApp().globalData, o = e.to_uid, n = e.nickName, 0 != o) {
                        t.next = 7;
                        break;
                    }
                    return console.log(o, "toConsult to_uid"), t.abrupt("return", !1);

                  case 7:
                    o == wx.getStorageSync("userid") ? wx.showModal({
                        title: "",
                        content: "不能和自己进行对话哦！",
                        confirmText: "知道啦",
                        showCancel: !1,
                        success: function(t) {
                            t.confirm;
                        }
                    }) : (a.toVideoStop(), a.toBGdestroy(), i = "/longbing_card/chat/userChat/userChat?chat_to_uid=" + o + "&contactUserName=" + n, 
                    console.log(i, "toConsult"), wx.navigateTo({
                        url: i
                    }));

                  case 8:
                  case "end":
                    return t.stop();
                }
            }, t, r);
        }))();
    },
    getCustomQrRecordInsert: function(t) {
        var a = getApp().globalData.to_uid;
        _index.userModel.getCodeRecord({
            to_uid: a,
            qr_id: t
        }), _xx_util2.default.hideAll();
    },
    toSearchCardBlur: function() {
        this.setData({
            toSearchCard: !1
        });
    },
    toSearchCard: function(t) {
        var a = t.detail.value;
        this.setData({
            cardSearchKey: a
        });
    },
    toSearchCardConfirm: function() {
        var t = this;
        t.setData({
            refreshCardList: !0,
            "paramCardList.page": 1,
            "collectionList.page": 1,
            "collectionList.list": []
        }, function() {
            t.getCollectionList();
        });
    },
    getCollectionList: function() {
        var n = this, t = n.data, i = t.refreshCardList, a = t.paramCardList, r = t.collectionList, e = t.cardSearchKey;
        e && (a.keyword = e), _index.userModel.getCollectionList(a).then(function(t) {
            console.log("getCollectionList==>", t.data), _xx_util2.default.hideAll();
            var a = r, e = t.data;
            i || (e.list = [].concat(_toConsumableArray(a.list), _toConsumableArray(e.list)));
            var o = "-1";
            0 == e.list.length && (o = !1), e.page = 1 * e.page, n.setData({
                collectionList: e,
                collectStatus: o,
                loadingCardList: !1,
                refreshCardList: !1,
                cardSearchKey: "",
                "paramCardList.keyword": ""
            });
        });
    },
    toGetShareimg: function() {
        var e = this;
        _index.baseModel.getShareimg().then(function(t) {
            _xx_util2.default.hideAll();
            var a = t.data.path;
            e.setData({
                getShareImg: a
            });
        });
    },
    getCardIndexData: function() {
        var I = this, t = I.data.paramData.to_uid;
        _index.userModel.getCardShow({
            to_uid: t
        }).then(function(t) {
            if (_xx_util2.default.hideAll(), console.log(t, "getCardShow"), 0 == t.errno) {
                console.log("getCardShow==>", t.data);
                var a = t.data, e = a.goods, o = a.info, n = a.info.images;
                for (var i in n) n[i] || n.splice(i, 1);
                for (var r in e) e[r].shop_price = _xx_util2.default.getNormalPrice((e[r].price / 1e4).toFixed(4));
                getApp().globalData.to_uid = o.fans_id, getApp().globalData.nickName = a.info.name, 
                getApp().globalData.avatarUrl = a.info.avatar, getApp().globalData.job_name = a.info.job_name, 
                a.peoplesInfo = "";
                var s = a.info.myCompany.addr;
                s && (a.info.myCompany.addrMap = 20 < s.length ? s.slice(0, 20) + "..." : s);
                var u = a.info, d = u.bg, l = u.bg_switch, c = u.my_video, g = u.my_video_cover, p = u.vr_cover, f = u.vr_path, h = u.vr_tittle, _ = u.vr_switch, m = I.data.globalData.configInfo.config, x = m.default_voice, w = m.default_voice_switch, b = m.default_video, v = m.default_video_cover, S = m.vr_cover, D = m.vr_path, y = m.vr_tittle, C = m.vr_switch;
                a.info.bg = d || x, a.info.bg_switch = 1 == l ? l : w, a.info.my_video = c || b, 
                a.info.my_video_cover = g || v, a.info.vr_cover = p || S, a.info.vr_path = f || D, 
                a.info.vr_tittle = h || y, a.info.vr_switch = _ || C, I.setData({
                    cardIndexData: a,
                    refreshCardIndex: !1,
                    showTabBar: !0,
                    "paramData.to_uid": o.fans_id
                }, function() {
                    auth.checkAuth(I, _index.baseModel, _xx_util2.default);
                    var t = I.data, a = t.currentTabBar, e = t.cardIndexData;
                    if ("toCard" == a) {
                        e.info.bg && (innerAudioContextBG.src = e.info.bg);
                        var o = 1;
                        1 == e.info.bg_switch && e.info.bg && (console.log("自动播放背景音乐"), o = 2, innerAudioContextBG.play(function() {})), 
                        I.setData({
                            playPushBgStatus: o
                        });
                    }
                    setTimeout(function() {
                        I.getCardAfter();
                    }, 500);
                });
            }
            if (-2 == t.errno) {
                console.log(t.message);
                var A = t.message;
                "card not found" == A && (A = "未找到该名片，去名片列表页看看吧"), wx.showModal({
                    title: "",
                    content: A,
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && I.setData({
                            currentTabBar: "cardList",
                            showTabBar: !1,
                            cardIndexData: {},
                            "collectionList.page": 1,
                            "paramCardList.page": 1,
                            "collectionList.list": [],
                            loadingCardList: !1
                        }, function() {
                            I.getCollectionList();
                        });
                    }
                });
            }
        });
    },
    getCardAfter: function() {
        var m = this, t = {
            to_uid: m.data.paramData.to_uid
        }, a = wx.getStorageSync("loginParamObj"), e = a.is_qr, o = a.is_group, n = a.type, i = a.target_id, r = a.from_id;
        t.from_id = r, t.is_qr = e, t.is_group = o, t.type = n, t.target_id = i, t.from_id = r, 
        getApp().globalData.openGId_2 && (t.openGId = getApp().globalData.openGId_2), _index.userModel.getCardAfter(t).then(function(t) {
            _xx_util2.default.hideAll();
            var a = m.data.cardIndexData, e = t.data, o = e.to_uid, n = e.is_boss, i = e.is_staff, r = wx.getStorageSync("userid"), s = o == r && 1 == i, u = o == r && 1 == n;
            getApp().globalData.isStaff = s, getApp().globalData.isBoss = u;
            var d = e.thumbs_up, l = e.peoples, c = e.peoplesInfo, g = a.info, p = g.t_number, f = g.view_number;
            for (var h in e.thumbs_up2 = d + 1 * p, e.peoples2 = l + 1 * f, c) o == r && r == c[h].id && c.splice(h, 1);
            e.peoplesInfo = c;
            var _ = Object.assign(a, e);
            m.setData({
                cardIndexData: _,
                "globalData.isStaff": s,
                "globalData.isBoss": u
            }, function() {
                m.toShowVoucherFunction();
            });
        });
    },
    toPlayBgMusic: function() {
        var a = this, t = a.data, e = t.playPushBgStatus, o = t.cardIndexData, n = e;
        o.info.bg && (innerAudioContextBG.src = o.info.bg, 2 == n ? (a.setData({
            playPushBgStatus: 1
        }, function() {
            -2 == a.data.playPush_Status && (a.setData({
                playPushStatus: 2
            }), innerAudioContext.play(function() {}));
        }), innerAudioContextBG.pause(function() {})) : -1 == n ? (innerAudioContextBG.pause(function() {}), 
        a.setData({
            playPushBgStatus: 1
        })) : (innerAudioContextBG.play(function() {}), a.setData({
            playPushBgStatus: 2
        }, function() {
            -2 == a.data.playPush_Status && (a.setData({
                playPushStatus: 1
            }), innerAudioContext.pause(function() {}));
        }))), innerAudioContextBG.onPlay(function(t) {
            console.log("开始播放", t);
        }), innerAudioContextBG.onStop(function(t) {
            console.log("结束播放", t);
        }), innerAudioContextBG.onEnded(function(t) {
            console.log("结束播放", t), a.setData({
                playPushBgStatus: 1
            }, function() {
                -2 == a.data.playPush_Status && (a.setData({
                    playPushStatus: 2
                }), innerAudioContext.play(function() {}));
            });
        });
    },
    toVideoStop: function() {
        this.setData({
            playPushStatus: 1
        }), innerAudioContext.stop();
    },
    toBGdestroy: function() {
        var t = void 0;
        1 == this.data.playPushBgStatus && (t = -1), 2 == this.data.playPushBgStatus && (t = -2), 
        this.setData({
            playPushBgStatus: t,
            toshowBG: !0
        }, function() {
            innerAudioContextBG.stop();
        });
    },
    toShowVoucherFunction: function() {
        var a = this, t = a.data, e = t.cardIndexData, o = t.price_switch, n = e.coupon_last_record, i = !0, r = "unreceive";
        if (n && 0 < n.length) {
            var s = [];
            for (var u in n) s.push(n[u].user_id);
            -1 < s.indexOf(e.user_id) && (i = !1, r = "receive");
        }
        a.setData({
            "voucherStatus.show": i,
            "voucherStatus.status": r
        }), 0 < n.length && a.data.voucherStatus.status && 1 == o && (timerCoupon = setInterval(function() {
            var t = a.data.tmp_coupon_i;
            a.setData({
                coupon_nickName: n[t].user_info.nickName,
                coupon_reduce: n[t].reduce,
                coupon_record: !0
            }, function() {
                setTimeout(function() {
                    ++t == n.length && (t = 0), a.setData({
                        coupon_record: !1,
                        tmp_coupon_i: t
                    });
                }, 5e3);
            });
        }, 1e4));
    },
    getEditPraiseStatus: function() {
        var o = this;
        console.log(getApp().globalData, "getEditPraiseStatus to_uid");
        var t = {
            to_uid: getApp().globalData.to_uid,
            type: o.data.cardZanType
        };
        _index.userModel.getEditPraiseStatus(t).then(function(t) {
            _xx_util2.default.hideAll();
            var a = o.data.cardIndexData, e = "";
            3 == o.data.cardZanType ? (e = 1 == a.isThumbs ? "取消靠谱！" : "认为靠谱！", a.thumbs_up2 = 1 == a.isThumbs ? 1 * a.thumbs_up2 - 1 : 1 * a.thumbs_up2 + 1, 
            a.isThumbs = 1 == a.isThumbs ? 0 : 1) : 1 == o.data.cardZanType && (e = 1 == a.voiceThumbs ? "取消点赞！" : "点赞成功！", 
            a.voiceThumbs = 1 == a.voiceThumbs ? 0 : 1), _xx_util2.default.showFail(e), o.setData({
                cardIndexData: a
            });
        });
    },
    toGetShareInfo: function() {
        var e = this;
        wx.login({
            success: function(t) {
                var a = {
                    encryptedData: getApp().globalData.encryptedData,
                    iv: getApp().globalData.iv,
                    type: 1,
                    code: t.code,
                    to_uid: e.data.paramData.to_uid
                };
                _index.userModel.getShareInfo(a).then(function(t) {
                    _xx_util2.default.hideAll(), clearInterval(timer);
                });
            }
        });
    },
    getNewsList: function() {
        var d = this, t = d.data, l = t.refreshNews, a = t.paramNews, c = t.newsList;
        _index.userModel.getNewsList(a).then(function(t) {
            _xx_util2.default.hideAll(), console.log("getNewsList==>", t.data);
            var a = c, e = t.data, o = e.list, n = d.data.newsIndex;
            for (var i in o) {
                for (var r in n.push(0), 2 == o[i].type && 3 == o[i].url_type && (o[i].content = "tel:" + o[i].content), 
                o[i].show_more = 0, o[i].show_type = 0, o[i].thumbs) 0 != o[i].thumbs[r].user && o[i].thumbs[r].user.nickName || o[i].thumbs.splice(r, 1), 
                20 < o[i].thumbs.length && (o[i].show_more = 1);
                for (var s in o[i].show_c_more = 0, o[i].show_c_type = 0, o[i].comments) 0 != o[i].comments[s].user && o[i].comments[s].user.nickName || o[i].comments.splice(s, 1), 
                5 < o[i].comments.length && (o[i].show_c_more = 1);
                for (var u in o[i].cover) 1 == o[i].type || o[i].cover[u] || o[i].cover.splice(u, 1);
            }
            l || (e.list = [].concat(_toConsumableArray(a.list), _toConsumableArray(e.list))), 
            d.setData({
                newsList: e,
                newsIndex: n,
                loadingNews: !1,
                refreshNews: !1
            });
        });
    },
    addEva: function(t) {
        var a = t.detail.value;
        this.setData({
            evaContent: a
        });
    },
    getThumbs: function(e) {
        var o = this, t = {
            id: o.data.ThumbsId,
            to_uid: getApp().globalData.to_uid
        };
        _index.userModel.getThumbs(t).then(function(t) {
            _xx_util2.default.hideAll(), console.log("getThumbs==>", t.data);
            var a = o.data.newsList;
            0 < a.list.length ? (1 == a.list[e].is_thumbs ? a.list[e].is_thumbs = 0 : a.list[e].is_thumbs = 1, 
            20 < a.list[e].thumbs.length && (a.list[e].show_type = 1), o.setData({
                newsList: a,
                evaStatus: !1,
                showTabBar: !0
            }, function() {
                o.getNewThumbsComment(o.data.ThumbsId);
            })) : o.setData({
                evaStatus: !1,
                showTabBar: !0
            }, function() {
                o.getNewThumbsComment(o.data.ThumbsId);
            });
        });
    },
    getComment: function() {
        var n = this, t = {
            id: n.data.evaId,
            to_uid: getApp().globalData.to_uid,
            content: n.data.evaContent
        };
        _index.userModel.getComment(t).then(function(t) {
            _xx_util2.default.hideAll(), console.log("getComment==>", t.data);
            var a = n.data, e = a.currentNewsIndex, o = a.newsList;
            5 < o.list[e].comments.length && (o.list[e].show_c_type = 1), n.setData({
                evaStatus: !1,
                showTabBar: !0,
                newsList: o
            }, function() {
                n.getNewThumbsComment(n.data.evaId);
            });
        });
    },
    getNewThumbsComment: function(t) {
        var u = this, a = {
            id: t,
            to_uid: getApp().globalData.to_uid
        };
        _index.userModel.getNewThumbsComment(a).then(function(t) {
            _xx_util2.default.hideAll(), console.log("getNewThumbsComment==>", t.data);
            var a = u.data.newsList, e = u.data.currentNewsIndex, o = t.data, n = o.thumbs, i = o.comments;
            for (var r in n) 0 != n[r].user && n[r].user.nickName || n.splice(r, 1);
            for (var s in i) 0 != i[s].user && i[s].user.nickName || i.splice(s, 1);
            a.list[e].thumbs = n, a.list[e].comments = i, u.setData({
                newsList: a,
                evaStatus: !1,
                showTabBar: !0,
                evaContent: "",
                ThumbsId: "",
                evaId: "",
                index: ""
            });
        });
    },
    getModular: function() {
        var i = this, r = i.data, t = {
            to_uid: i.data.paramData.to_uid
        };
        _index.userModel.getModular(t).then(function(t) {
            _xx_util2.default.hideAll(), console.log("getModular==>", t.data);
            var a = t.data, e = a.company_company, o = a.company_modular;
            for (var n in r = !1, o) 4 == o[n].type && (o[n].info.markers = [ {
                iconPath: "https://retail.xiaochengxucms.com/images/12/2018/11/A33zQycihMM33y337LH23myTqTl3tl.png",
                id: 1,
                callout: {
                    content: o[n].info.address,
                    fontSize: 14,
                    bgColor: "#ffffff",
                    padding: 4,
                    display: "ALWAYS",
                    textAlign: "center",
                    borderRadius: 2
                },
                latitude: o[n].info.latitude,
                longitude: o[n].info.longitude,
                width: 28,
                height: 28
            } ]);
            i.setData({
                company_company: e,
                company_modular: o,
                refreshCompany: r,
                showTabBar: !0
            });
        });
    },
    swiperChange: function(t) {
        var a = t.detail.current;
        this.setData({
            swiperIndexCur: a
        });
    },
    getForwardRecord: function(t, a) {
        var e = {
            type: t,
            to_uid: getApp().globalData.to_uid
        };
        2 != t && 3 != t || (e.target_id = a), _index.userModel.getForwardRecord(e).then(function(t) {
            _xx_util2.default.hideAll();
        });
    },
    getCopyRecord: function(t) {
        var a = {
            type: t,
            to_uid: getApp().globalData.to_uid
        };
        _index.userModel.getCopyRecord(a).then(function(t) {
            _xx_util2.default.hideAll();
        });
    },
    getShareRecord: function() {
        var t = {
            to_uid: getApp().globalData.to_uid
        };
        _index.userModel.getShareRecord(t).then(function(t) {
            _xx_util2.default.hideAll();
        });
    },
    getPhoneNumber: function(t) {
        var a = t.detail, e = a.encryptedData, o = a.iv;
        e && o ? (console.log("getPhoneNumber==> 同意授权获取电话号码"), this.setPhoneInfo(e, o)) : console.log("getPhoneNumber==> 拒绝授权获取电话号码"), 
        this.toConsult();
    },
    setPhoneInfo: function(t, a) {
        var e = this, o = {
            encryptedData: t,
            iv: a,
            to_uid: getApp().globalData.to_uid
        };
        _index.baseModel.getPhone(o).then(function(a) {
            _xx_util2.default.hideAll(), getApp().globalData.hasClientPhone = !0, getApp().globalData.auth.authPhoneStatus = !0, 
            e.setData({
                hasClientPhone: !0,
                authPhoneStatus: !0
            }, function() {
                if (a.data.phone) {
                    var t = wx.getStorageSync("user");
                    t.phone = a.data.phone, wx.setStorageSync("user", t);
                }
            });
        });
    },
    getVoucher: function(t) {
        voucher.getVoucher(this, _index.userModel, _xx_util2.default, t);
    },
    getDismantling: function(t) {
        voucher.toGetCoupon(this, _index.userModel, _xx_util2.default);
    },
    toShareVoucher: function() {
        voucher.toShareVoucher(this);
    },
    toBigVoucher: function() {
        voucher.toBigVoucher(this);
    },
    toCloseVoucher: function() {
        voucher.toCloseVoucher(this);
    },
    checkAuthStatus: function() {
        auth.checkAuth(this, _index.baseModel, _xx_util2.default);
    },
    getAuthPhoneNumber: function(t) {
        auth.getAuthPhoneNumber(t);
    },
    getUserInfo: function(t) {
        auth.getUserInfo(t), console.log(" auth.getUserInfo(e)  *******************", t);
    },
    addEvaBtn: function(t) {
        if (!this.data.evaContent) return wx.showToast({
            icon: "none",
            title: "请输入评论内容！",
            duration: 2e3
        }), !1;
        this.getComment();
    },
    officialAccountErr: function(t) {
        console.log(t, "officialAccountErr");
    },
    officialAccount: function(t) {
        var a = t.detail, e = a.status, o = a.errMsg;
        console.log("official-account ==>", e, o);
    },
    getChangeCard: function(t) {
        var a = this, e = t.detail, o = e.encryptedData, n = e.iv;
        if (o && n) console.log("getChangeCard==> 同意交换手机号码"), a.setData({
            changeCardText: "存入手机通讯录"
        }, function() {
            a.toSavePhoneNumber(1), a.setPhoneInfo(o, n), a.setData({
                isToShowCard: !1
            });
        }); else {
            console.log("getChangeCard==> 拒绝交换手机号码");
            var i = a.data.globalData.configInfo.config.force_phone;
            i || (i = 0), 1 == i && 0 == a.data.hasClientPhone ? (getApp().globalData.auth.authPhoneStatus = !1, 
            a.setData({
                authPhoneStatus: !1
            })) : a.toSavePhoneNumber(1), a.setData({
                isToShowCard: !1
            });
        }
    },
    toSavePhoneNumber: function(a) {
        var e = this, t = e.data.cardIndexData.info, o = t.avatar, n = t.name, i = t.phone, r = t.telephone, s = t.wechat, u = t.email, d = t.myCompany, l = t.bg;
        e.toVideoStop(), e.toBGdestroy(), wx.addPhoneContact({
            photoFilePath: o,
            firstName: n,
            mobilePhoneNumber: i,
            hostNumber: r,
            weChatNumber: s,
            email: u,
            organization: d.name,
            workAddressCity: d.addr,
            success: function(t) {
                e.setData({
                    isToShowCard: !1
                }, function() {
                    getApp().globalData.to_uid != wx.getStorageSync("userid") && e.getCopyRecord(a);
                });
            },
            complete: function(t) {
                innerAudioContextBG.src = l;
            }
        });
    },
    toCheckAuthPhoneStatus: function() {
        var t = !0;
        getApp().globalData.configInfo.config && 1 == getApp().globalData.configInfo.config.force_phone && 0 == getApp().globalData.hasClientPhone && (t = !1), 
        getApp().globalData.auth.authStatus = !0, getApp().globalData.auth.authPhoneStatus = t, 
        this.setData({
            authStatus: !0,
            authPhoneStatus: t
        });
    },
    toPreviewImg: function(t) {
        var a = _xx_util2.default.getData(t), e = a.status, o = a.index, n = a.src;
        if ("toNewsPreview" == e) {
            var i = this.data.newsList.list[o].cover;
            0 < i.length && wx.previewImage({
                current: n,
                urls: i
            });
        }
    },
    toPagePay: function(t) {
        var a = getApp().globalData.to_uid, e = _xx_util2.default.getData(t).url;
        t.currentTarget.dataset.url = e + "?to_uid=" + a, _xx_util2.default.goUrl(t);
    },
    toJump: function(n) {
        var e = this, t = _xx_util2.default.getData(n), o = t.status, a = t.index, i = t.id, r = t.content, s = t.type, u = t.shareimg, d = t.url;
        if ("toSee" == o && e.setData({
            isToShowCard: -1
        }, setTimeout(function() {
            e.setData({
                isToShowCard: !1
            }), e.toCheckAuthPhoneStatus();
        }, 500)), "toTagsClick" == o) {
            var l = e.data.cardIndexData.tags;
            l[a].clicked = 1, l[a].count = 1 * l[a].count + 1, e.setData({
                "cardIndexData.tags": l
            }, setTimeout(function() {
                e.setData({
                    clickedInd: a
                }, setTimeout(function() {
                    e.setData({
                        clickedInd: "-1"
                    });
                }, 1e3));
            }, 200));
            var c = {
                tag_id: l[a].id
            };
            _index.userModel.getTagsClick(c).then(function(t) {
                _xx_util2.default.hideAll();
            });
        }
        if ("toTagsAgainClick" == o && _xx_util2.default.showFail("已经点赞过了！"), "toSearchCardFocus" == o && e.setData({
            toSearchCard: !0
        }), "toCopyright" == o && e.data.globalData.configInfo.config.logo_phone && _xx_util2.default.goUrl(n), 
        "toJumpUrl" != o && "toStaff" != o && "toBoss" != o && "toShowMore" != o && "toCarIndex" != o && "toMine" != o || ("toStaff" != o && "toBoss" != o || (e.toVideoStop(), 
        innerAudioContextBG.stop()), _xx_util2.default.goUrl(n)), "toImgJump" == o) {
            var g = e.data.globalData.configInfo.config.preview_switch, p = e.data.cardIndexData.info.images;
            if (1 == g) {
                e.toVideoStop(), e.toBGdestroy();
                var f = n.target.dataset.src;
                wx.previewImage({
                    current: f,
                    urls: p
                });
            } else _xx_util2.default.goUrl(n);
        }
        if ("toMoreDetail" == o && (d = d + "&to_uid=" + getApp().globalData.to_uid, wx.navigateTo({
            url: d
        })), "toSearchCard" == o) ; else if ("toAddCard" == o) e.setData({
            onshowStatus: "createCard"
        }, function() {
            wx.navigateTo({
                url: "/longbing_card/staffs/pages/mine/editInfo/editInfo?status=createCard"
            });
        }); else if ("toCardIndex" == o) {
            e.toBGdestroy(), _xx_util2.default.showLoading();
            var h = wx.getStorageSync("userid"), _ = wx.getStorageSync("user"), m = wx.getStorageSync("token") || "", x = wx.getStorageSync("lb_token") || "", w = wx.getStorageSync("isShowCard"), b = wx.getStorageSync("isShowMessage");
            wx.clearStorageSync(), wx.setStorageSync("userid", h), wx.setStorageSync("user", _), 
            wx.setStorageSync("token", m), wx.setStorageSync("lb_token", x), wx.setStorageSync("isShowCard", w), 
            wx.setStorageSync("isShowMessage", b);
            var v = e.data.collectionList.list, S = v[a].userInfo.fans_id, D = wx.getStorageSync("userid"), y = v[a].userInfo.name;
            getApp().globalData.isStaff = -1, getApp().globalData.to_uid = S, getApp().globalData.nickName = y, 
            e.subscribe(), wx.showShareMenu({
                withShareTicket: !0
            }), e.setData({
                "paramData.isStaff": -1,
                "paramData.to_uid": S,
                "paramData.from_id": D,
                currentTabBarInd: 0,
                currentTabBar: "toCard",
                showTabBar: !0,
                globalData: getApp().globalData,
                refreshCardIndex: !1,
                cardIndexData: {}
            });
            var C = getApp().globalData.tabBar.list[0].text;
            getApp().globalData.configInfo.config.mini_app_name && (C = getApp().globalData.configInfo.config.mini_app_name), 
            wx.setNavigationBarTitle({
                title: C
            }), e.getCardIndexData(), setTimeout(function() {
                if ("cardList" != e.data.currentTabBar && e.data.paramData.to_uid != wx.getStorageSync("userid") && (0 == getApp().globalData.clientUnread && 0 == e.data.clientUnread || 0 == getApp().globalData.clientUnread && 1 == e.data.clientUnread)) {
                    var t = e.data.cardIndexData.to_uid, a = wx.getStorageSync("isShowMessage");
                    a || (a = []), -1 < a.indexOf(t) || t == wx.getStorageSync("userid") ? getApp().globalData.clientUnread = 0 : (e.toMsgAnimatoins(1), 
                    a.push(t), wx.setStorageSync("isShowMessage", a));
                }
            }, 1e3), wx.pageScrollTo({
                duration: 0,
                scrollTop: 0
            }), _xx_util2.default.hideAll();
        }
        if ("toCardZan" == o ? (e.setData({
            toLeavingMessage: !1,
            cardZanType: s
        }), e.getEditPraiseStatus()) : "toVoice" == o ? (innerAudioContext.autoplay = !0, 
        innerAudioContext.src = e.data.cardIndexData.info.voice, console.log(innerAudioContext.src, "****************innerAudioContext.src"), 
        innerAudioContext.onWaiting(function(t) {
            console.log(t, "onWaiting");
        }), innerAudioContext.onError(function(t) {
            console.log(t, "onError");
        }), 1 == s && (e.setData({
            playPushStatus: 2,
            playPush_Status: -2
        }, function() {
            2 == e.data.playPushBgStatus && (e.setData({
                playPushBgStatus: -2
            }), innerAudioContextBG.pause(function() {}));
        }), innerAudioContext.play(function() {
            console.log("开始播放");
        }), getApp().globalData.to_uid != wx.getStorageSync("userid") && e.getCopyRecord(9)), 
        2 == s && (innerAudioContext.pause(function() {
            console.log("暂停播放");
        }), e.setData({
            playPushStatus: 1,
            playPush_Status: 1
        }, function() {
            if (-2 == e.data.playPushBgStatus) {
                var t = e.data.cardIndexData;
                t.info.bg && (innerAudioContextBG.src = t.info.bg, e.setData({
                    playPushBgStatus: 2
                }, function() {
                    innerAudioContextBG.play(function() {});
                }));
            }
        })), innerAudioContext.onEnded(function() {
            console.log("音频自然播放结束事件"), e.setData({
                playPushStatus: 1,
                playPush_Status: 1
            }, function() {
                if (-2 == e.data.playPushBgStatus) {
                    var t = e.data.cardIndexData;
                    console.log(t.info.bg, "cardIndexData.info.bg  音频自然播放结束事件"), t.info.bg && (innerAudioContextBG.src = t.info.bg, 
                    e.setData({
                        playPushBgStatus: 2
                    }, function() {
                        innerAudioContextBG.play(function() {});
                    }));
                }
            });
        })) : "toCardList" == o ? (_xx_util2.default.showLoading(), clearInterval(timerCoupon), 
        e.setData({
            showTabBar: !1,
            currentTabBar: "cardList",
            show: !1,
            moreStatus: 1,
            sharePanel: !1,
            playPushStatus: 1,
            playPushBgStatus: 1,
            collectionList: {
                page: 1,
                total_page: "",
                list: []
            },
            "paramCardList.page": 1,
            voucherStatus: {
                show: 0,
                status: "unreceive"
            },
            "globalData.isStaff": !1,
            "globalData.isBoss": !1,
            cardIndexData: {},
            newsList: {
                page: 1,
                total_page: "",
                list: []
            },
            newsIndex: [],
            company_company: {},
            company_modular: [],
            tmp_coupon_i: 0,
            coupon_record: !1,
            coupon_nickName: "",
            coupon_reduce: ""
        }, function() {
            e.toVideoStop(), innerAudioContextBG.stop();
        }), wx.setNavigationBarTitle({
            title: "名片列表"
        }), wx.hideShareMenu(), e.getCollectionList(), wx.pageScrollTo({
            duration: 0,
            scrollTop: 0
        }), _xx_util2.default.hideAll()) : "toConsult" == o ? (e.setData({
            toLeavingMessage: !0
        }), getApp().globalData.to_uid != wx.getStorageSync("userid") && e.getCopyRecord(8), 
        e.data.hasClientPhone, e.toConsult()) : "toShareCard" == o && (2 == s && (e.toVideoStop(), 
        e.toBGdestroy()), e.setData({
            showShareStatus: 0
        })), wx.onBackgroundAudioStop(function() {
            e.setData({
                playPushStatus: 1
            });
        }), "toShopDetail" == o) {
            var A = "";
            "toCard" == e.data.currentTabBar && (A = e.data.cardIndexData.goods, e.toVideoStop(), 
            e.toBGdestroy());
            var I = getApp().globalData.to_uid, T = wx.getStorageSync("userid"), B = "/longbing_card/pages/shop/detail/detail?id=" + A[a].id + "&to_uid=" + I + "&from_id=" + T;
            console.log(B, "tmp_path"), wx.navigateTo({
                url: B
            });
        }
        if ("toNewsShow" == o) {
            var P = e.data.newsIndex;
            1 != s ? P[a] = 1 : 1 == s && (P[a] = 2), e.setData({
                newsIndex: P,
                currentNewsIndex: a
            });
        } else if ("toShowTag" == o) {
            var L = e.data.newsList.list;
            (L[a].show_type = 1) == s && (L[a].show_type = 0), e.setData({
                "newsList.list": L
            });
        } else if ("toShowComment" == o) {
            var N = e.data.newsList.list;
            (N[a].show_c_type = 1) == s && (N[a].show_c_type = 0), e.setData({
                "newsList.list": N
            });
        } else if ("toNewsZan" == o) {
            var M = e.data.newsIndex;
            for (var G in M) 1 == M[G] && (M[G] = 0);
            e.setData({
                newsIndex: M,
                toLeavingMessage: !1,
                ThumbsId: i
            }, function() {
                e.getThumbs(a);
            });
        } else if ("toEva" == o) {
            var k = e.data.newsIndex;
            for (var U in k) 1 == k[U] && (k[U] = 0);
            e.setData({
                newsIndex: k,
                toLeavingMessage: !1,
                evaId: i,
                evaStatus: !0,
                showTabBar: !1
            });
        } else if ("toAddEvaBtn" == o) {
            if (!e.data.evaContent) return wx.showToast({
                icon: "none",
                title: "请输入评论内容！",
                duration: 2e3
            }), !1;
            e.getComment();
        } else if ("toNewsDetail" == o) {
            var R = getApp().globalData.to_uid, V = wx.getStorageSync("userid"), F = e.data.newsList.list;
            if (1 == F[a].type) {
                var E = "/longbing_card/users/pages/news/detail/detail?to_uid=" + R + "&from_id=" + V + "&id=" + F[a].id + "&status=toPlayVideo&name=" + F[a].title + "&fromshare=true";
                console.log(E, "tmpVideoUrl*************"), wx.navigateTo({
                    url: E
                });
            } else if (2 == F[a].type) if (1 == F[a].url_type) {
                var j = "/longbing_card/common/webview/webview?to_uid=" + R + "&from_id=" + V + "&id=" + F[a].id + "&status=newsLine&name=" + F[a].title + "&fromshare=true";
                console.log(j, "tmpHrefUrl*************"), wx.navigateTo({
                    url: j
                });
            } else if (2 == F[a].url_type) {
                var q = {
                    to_uid: getApp().globalData.to_uid,
                    sign: "view",
                    type: 10,
                    target: F[a].id,
                    scene: getApp().globalData.loginParam.scene,
                    uniacid: app.siteInfo.uniacid
                };
                getApp().globalData.to_uid != wx.getStorageSync("userid") && e.toGetReport(q), _xx_util2.default.goUrl(n);
            } else _xx_util2.default.goUrl(n); else if (3 == F[a].type) {
                var H = F[a], Z = "/longbing_card/staffs/pages/article/detail/detail?id=" + H.article_id + "&uid=" + H.user_info.fans_id;
                console.log(Z, "article_path"), wx.navigateTo({
                    url: Z
                });
            } else if (0 == F[a].type) {
                var J = "/longbing_card/users/pages/news/detail/detail?id=" + i + "&from_id=" + wx.getStorageSync("userid");
                0 != F[a].user_id && (J = J + "&isStaff=true&to_uid=" + F[a].user_info.fans_id), 
                0 == !F[a].user_id && (J = J + "&companyName=" + e.data.newsList.timeline_company.name), 
                wx.navigateTo({
                    url: J
                });
            }
        }
        if ("toDetail" == o) {
            var O = e.data.company_modular;
            if (5 == O[a].type) return !1;
            var z = e.data.cardIndexData.to_uid;
            wx.navigateTo({
                url: "/longbing_card/users/pages/company/detail/detail?table_name=" + O[a].table_name + "&type=" + O[a].type + "&id=" + i + "&name=" + O[a].name + "&to_uid=" + z
            });
        } else if ("toCallHot" == o || "toCall" == o) {
            if (e.toVideoStop(), e.toBGdestroy(), !r || "暂未填写" == r) return !1;
            wx.makePhoneCall({
                phoneNumber: r,
                success: function(t) {
                    if (getApp().globalData.to_uid != wx.getStorageSync("userid")) if ("toCallHot" == o) {
                        var a = {
                            to_uid: e.data.paramData.to_uid,
                            sign: "copy",
                            type: s,
                            scene: getApp().globalData.loginParam.scene,
                            uniacid: app.siteInfo.uniacid
                        };
                        e.toGetReport(a);
                    } else "toCall" == o && e.getCopyRecord(s);
                }
            });
        } else "toPlayVideo" == o ? ("toCard" == e.data.currentTabBar && (e.toVideoStop(), 
        e.toBGdestroy()), r = r + "&shareimg=" + encodeURIComponent(u), wx.navigateTo({
            url: r
        })) : "toCompanyMap" == o && wx.authorize({
            scope: "scope.userLocation",
            success: function(t) {
                wx.getLocation({
                    type: "gcj02",
                    success: function(t) {
                        var a = _xx_util2.default.getData(n), e = a.latitude, o = a.longitude;
                        wx.openLocation({
                            latitude: +e,
                            longitude: +o,
                            name: r,
                            scale: 28
                        });
                    }
                });
            },
            fail: function(t) {
                e.setData({
                    isSetting: !0,
                    settingText: [ "地理位置", "你的地理位置将用于地图导航" ]
                });
            }
        });
    },
    toGetReport: function(t) {
        _index.baseModel.getReport(t), _xx_util2.default.hideAll();
    },
    toSharePanel: function() {
        this.setData({
            sharePanel: !0
        });
    },
    getModularForm: function(t, a, e, o) {
        var n = this.data, i = n.company_modular, r = n.paramData, s = i[o].id, u = r.to_uid;
        _index.userModel.getModularForm({
            to_uid: u,
            modular_id: s,
            name: t,
            phone: a,
            content: e
        }).then(function(t) {
            _xx_util2.default.hideAll(), wx.showModal({
                title: "",
                content: "留言成功，请等待管理员处理",
                showCancel: !1,
                confrimText: "知道啦"
            });
        });
    },
    validate: function(t) {
        var a = new _xx_util2.default.Validate(), e = t.name, o = t.phone, n = t.content;
        return a.add(e, "isNoEmpty", "请填写您的名字"), a.add(o, "isNoEmpty", "请填写您的联系电话"), a.add(n, "isNoEmpty", "请填写您想说的话"), 
        a.start();
    },
    formTmpSubmit: function(t) {
        var a = t.detail.formId, e = _xx_util2.default.getFormData(t), o = e.status, n = e.index, i = t.detail.value, r = i.name, s = i.phone, u = i.content;
        if ("toFormSubmit" == o) {
            var d = this.validate({
                name: r,
                phone: s,
                content: u
            });
            if (d) return void _xx_util2.default.showModal({
                content: d
            });
            this.getModularForm(r, s, u, n);
        }
        this.toSaveFormIds(a);
    },
    tabJump: function(t) {
        var a = this, e = t.detail, o = e.url, n = e.method, i = e.type, r = e.curr, s = e.index, u = e.text, d = e.formId;
        a.setData({
            currentTabBarInd: s,
            toCardStatus: "tabBar"
        }, function() {
            wx.getStorageSync("user").avatarUrl || auth.checkAuth(a, _index.baseModel, _xx_util2.default);
        });
        var l = a.data.paramData.to_uid, c = wx.getStorageSync("userid");
        if (o) {
            0 == o.indexOf("wx") || -1 < o.indexOf("http") || (o = o + "?uid=" + l + "&fid=" + c), 
            t.currentTarget.dataset = {
                url: o,
                method: n,
                type: i,
                curr: r,
                index: s,
                text: u,
                formId: d
            };
            var g = void 0;
            1 == a.data.playPushBgStatus && (g = -1), 2 == a.data.playPushBgStatus && (g = -2), 
            a.setData({
                playPushStatus: 1,
                playPushBgStatus: g
            }, function() {
                innerAudioContext.stop(), innerAudioContextBG.stop(), _xx_util2.default.goUrl(t);
            });
        } else {
            var p = a.data.globalData.tabBar.list;
            if (p[s].pagePath2 && (o = p[s].pagePath2 + "?uid=" + l + "&fid=" + c, t.currentTarget.dataset = {
                url: o,
                method: n,
                type: i,
                curr: r,
                index: s,
                text: u,
                formId: d
            }, _xx_util2.default.goUrl(t)), a.setData({
                currentTabBar: r,
                nowPageIndex: s
            }), "toCard" == i) a.toPlayBgMusic(), wx.showShareMenu({
                withShareTicket: !0
            }), getApp().globalData.configInfo.config.mini_app_name && (u = getApp().globalData.configInfo.config.mini_app_name); else {
                var f = void 0;
                1 == a.data.playPushBgStatus && (f = -1), 2 == a.data.playPushBgStatus && (f = -2), 
                a.setData({
                    playPushStatus: 1,
                    playPushBgStatus: f
                }, function() {
                    innerAudioContext.stop(), innerAudioContextBG.stop();
                });
            }
            wx.setNavigationBarTitle({
                title: u
            });
        }
        wx.pageScrollTo({
            duration: 0,
            scrollTop: 0
        });
        var h = a.data, _ = h.currentTabBar, m = h.toCardStatus;
        getApp().getConfigInfo(!0).then(function() {
            a.setData({
                globalData: getApp().globalData
            }, function() {
                "toCard" == _ ? a.setData({
                    refreshCardIndex: !1
                }, function() {
                    "tabBar" == m && (a.data.cardIndexData.to_uid || a.getCardIndexData());
                }) : "toNews" == _ ? a.setData({
                    "paramNews.to_uid": a.data.paramData.to_uid,
                    refreshNews: !1
                }, function() {
                    0 == a.data.newsList.list.length && a.getNewsList();
                }) : "toShop" == _ ? console.log("加载toShop tabChange") : "toCompany" == _ && a.setData({
                    refreshCompany: !1
                }, function() {
                    a.data.company_modular && 0 != a.data.company_modular.length || a.getModular();
                }), a.toSaveFormIds(d);
            });
        });
    },
    formSubmit: function(t) {
        var n = this, a = _xx_util2.default.getFormData(t), e = a.status, o = (a.index, 
        a.type), i = (a.text, a.content);
        if (console.log(t, "status, index, type, text, content "), n.setData({
            toCardStatus: ""
        }), "toJumpUrlAppid" == e && (console.log(e, "//////**88"), _xx_util2.default.goUrl(t, !0)), 
        "toCardMore" == e) {
            var r = 1;
            1 == i && (r = 2), n.setData({
                moreStatus: r
            });
        }
        if ("toCallHot" == e || "toCall" == e) {
            if (!i || "暂未填写" == i) return !1;
            wx.makePhoneCall({
                phoneNumber: i,
                success: function(t) {
                    if (getApp().globalData.to_uid != wx.getStorageSync("userid")) if ("toCallHot" == e) {
                        var a = {
                            to_uid: n.data.paramData.to_uid,
                            sign: "copy",
                            type: o,
                            scene: getApp().globalData.loginParam.scene,
                            uniacid: app.siteInfo.uniacid
                        };
                        n.toGetReport(a);
                    } else "toCall" == e && n.getCopyRecord(o);
                }
            });
        }
        if ("toCopy" == e) {
            if (!i || "暂未填写" == i) return !1;
            wx.setClipboardData({
                data: i,
                success: function(t) {
                    wx.getClipboardData({
                        success: function(t) {
                            getApp().globalData.to_uid != wx.getStorageSync("userid") && n.getCopyRecord(o);
                        }
                    });
                }
            });
        }
        "toMap" == e && (n.toVideoStop(), n.toBGdestroy(), wx.authorize({
            scope: "scope.userLocation",
            success: function(t) {
                wx.getLocation({
                    type: "gcj02",
                    success: function(t) {
                        var a = n.data.cardIndexData.info.myCompany, e = a.latitude, o = a.longitude;
                        wx.openLocation({
                            latitude: +e,
                            longitude: +o,
                            name: i,
                            scale: 28
                        });
                    }
                });
            },
            fail: function(t) {
                console.log(t, "**************fail  scope.userLocation"), n.setData({
                    isSetting: !0,
                    settingText: [ "地理位置", "你的地理位置将用于地图导航" ]
                });
            }
        })), "toAddPhone" == e && n.toSavePhoneNumber(o), "toNav" == e && _xx_util2.default.goUrl(t, !0);
    },
    toSaveFormIds: function(t) {
        _index.baseModel.getFormId({
            formId: t
        });
    }
});