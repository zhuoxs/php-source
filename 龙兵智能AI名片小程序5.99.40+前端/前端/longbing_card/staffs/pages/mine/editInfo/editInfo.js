var _slicedToArray = function(e, t) {
    if (Array.isArray(e)) return e;
    if (Symbol.iterator in Object(e)) return function(e, t) {
        var a = [], n = !0, r = !1, o = void 0;
        try {
            for (var i, s = e[Symbol.iterator](); !(n = (i = s.next()).done) && (a.push(i.value), 
            !t || a.length !== t); n = !0) ;
        } catch (e) {
            r = !0, o = e;
        } finally {
            try {
                !n && s.return && s.return();
            } finally {
                if (r) throw o;
            }
        }
        return a;
    }(e, t);
    throw new TypeError("Invalid attempt to destructure non-iterable instance");
}, _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js"), _staff = require("../../../../resource/apis/staff.js"), _staff2 = _interopRequireDefault(_staff);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

function _defineProperty(e, t, a) {
    return t in e ? Object.defineProperty(e, t, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = a, e;
}

function _asyncToGenerator(e) {
    return function() {
        var s = e.apply(this, arguments);
        return new Promise(function(o, i) {
            return function t(e, a) {
                try {
                    var n = s[e](a), r = n.value;
                } catch (e) {
                    return void i(e);
                }
                if (!n.done) return Promise.resolve(r).then(function(e) {
                    t("next", e);
                }, function(e) {
                    t("throw", e);
                });
                o(r);
            }("next");
        });
    };
}

var app = getApp(), recorderManager = wx.getRecorderManager(), innerAudioContext = wx.createInnerAudioContext(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        openType: "getUserInfo",
        color: "23,162,52",
        currentTags: 0,
        showAddUseSec: !1,
        textAreaFocus: !1,
        showTextArea: !1,
        cardTypeImgList: [ "https://retail.xiaochengxucms.com/images/12/2018/11/Yg7rq8Y1CBi2S1R7s2c22TEcqrshCT.png", "https://retail.xiaochengxucms.com/images/12/2018/11/Lb6BO6B7b2M67O64d6b4b2b776Bd6O.png", "https://retail.xiaochengxucms.com/images/12/2018/11/nR22ZLhs8lQoX77DQX1fJ97fc7Ryzl.png" ],
        cardTypeList: [ "cardType1", "cardType4", "cardType2" ],
        cardTypeIndex: 0,
        job: -1,
        company: -1,
        firstCreate: 0,
        playPushStatus: 1,
        startPushStatus: 1,
        recordAuthMethod: 1,
        globalData: {},
        uploadUrl: "",
        recordStatusText: "开始录音 按住说话",
        staffInfo: {
            images: []
        },
        currentIndex: 0,
        recordStatus: !0,
        icon_voice_png: "https://retail.xiaochengxucms.com/images/12/2018/11/IgvvwVNUIVn6UMh4Dmh4m6nM4Widug.png",
        icon_voice_gif: "https://retail.xiaochengxucms.com/images/12/2018/11/CRFPPPTKf6f45J6H3N44BNCrjbFZxH.gif",
        settingNum: 0,
        start: !1,
        play: !1,
        cardIndexData: {
            info: {
                avatar_2: "",
                name: "",
                phone: "",
                wechat: "",
                ww_account: "",
                telephone: "",
                email: "",
                desc: "",
                voice: "",
                voice_time: "",
                images: "",
                code: "",
                job_id: "",
                card_type: "",
                company_id: ""
            }
        }
    },
    onLoad: function(c) {
        var d = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var n, t, a, r, o, i, s;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return n = d, _xx_util2.default.showLoading(), t = c.status, e.next = 5, getApp().getConfigInfo(!0);

                  case 5:
                    if (a = 0, r = getApp().globalData.configInfo, o = r.my_company, i = r.company_list, 
                    o && i) for (s in i) o.id == i[s].id && (a = s);
                    return n.setData({
                        paramStatus: t || "",
                        company: a,
                        globalData: getApp().globalData,
                        authStatus: getApp().globalData.auth.authStatus,
                        logo: getApp().globalData.logoImg
                    }), e.next = 11, Promise.all([ n.getAuthInfoSuc(), n.getStaffCard(), n.getCardIndexData(), n.getTagsList() ]);

                  case 11:
                    _xx_util2.default.hideAll(), recorderManager.onStart(function() {
                        console.log("开始录音"), n.setData({
                            start: !0,
                            record_status: 1
                        });
                    }), recorderManager.onStop(function(e) {
                        console.log("结束录音", e);
                        var t = e.tempFilePath, a = e.duration;
                        n.setData({
                            start: !1,
                            record_status: 2,
                            showTostImg: !1,
                            "cardIndexData.info.voice": t,
                            "cardIndexData.info.voice_time": (a / 1e3).toFixed(0)
                        }), innerAudioContext.src = t, console.log(innerAudioContext.src, "***************innerAudioContext.src 22222222222222222 tempFilePath");
                    }), recorderManager.onError(function(e) {
                        console.log("录音异常");
                        e.errMsg;
                    }), innerAudioContext.onError(function(e) {
                        console.log(e, "innerAudioContext.onError");
                    }), innerAudioContext.onPlay(function() {
                        console.log("开始播放:src=>", innerAudioContext.src), n.setData({
                            play: !0
                        });
                    }), innerAudioContext.onStop(function(e) {
                        console.log("结束播放"), n.setData({
                            play: !1,
                            record_status: 2
                        });
                    }), innerAudioContext.onEnded(function(e) {
                        console.log("结束播放"), n.setData({
                            play: !1,
                            record_status: 2
                        });
                    });

                  case 19:
                  case "end":
                    return e.stop();
                }
            }, e, d);
        }))();
    },
    onShow: function() {},
    onHide: function() {
        1 == this.data.record_status && this.end();
    },
    onUnload: function() {
        innerAudioContext.src = "", 1 == this.data.record_status && this.end();
    },
    onPullDownRefresh: function() {
        var t = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return wx.showNavigationBarLoading(), e.next = 3, getApp().getConfigInfo(!0);

                  case 3:
                    t.getAuthInfoSuc();

                  case 4:
                  case "end":
                    return e.stop();
                }
            }, e, t);
        }))();
    },
    getAuthInfoSuc: function(r) {
        var o = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, a, n;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    console.log(r, "getAuthInfoSuc"), t = o.data.openType, a = wx.getStorageSync("userid"), 
                    (n = getApp().getCurUserInfo(a, t)).userInfo.force_phone = 0, n.openType = "getUserInfo", 
                    o.setData(n);

                  case 7:
                  case "end":
                    return e.stop();
                }
            }, e, o);
        }))();
    },
    pickerSelected: function(e) {
        var t = _xx_util2.default.getData(e).status;
        if (console.log(t, "**********status pickerSelected"), "job" == t) {
            var a = e.detail.value, n = this.data.staffInfo.jobList[a], r = n.name, o = n.id;
            this.setData({
                job: a,
                "cardIndexData.info.job_name": r,
                "cardIndexData.info.job_id": o
            });
        }
        if ("address" == t) {
            var i = e.detail.value, s = this.data.globalData.configInfo.company_list[i], c = s.id, d = s.logo, u = s.addr, l = s.name, f = s.short_name;
            this.setData({
                company: i,
                "cardIndexData.info.company_id": c,
                "cardIndexData.info.myCompany.logo": d,
                "cardIndexData.info.myCompany.addr": u,
                "cardIndexData.info.myCompany.name": l,
                "cardIndexData.info.myCompany.short_name": f
            });
        }
    },
    getCardIndexData: function() {
        var a = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var d, t;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    d = a, _xx_util2.default.showLoading(), t = {
                        to_uid: wx.getStorageSync("userid")
                    }, _index.userModel.getCardShow(t).then(function(e) {
                        _xx_util2.default.hideAll();
                        var t = e.data, a = t.info, n = a.company_id, r = a.voice, o = d.data, i = o.company, s = o.globalData.configInfo.company_list[i].id;
                        t.info.company_id = !n || n < 1 ? s : n;
                        var c = r.path || r ? "重新录音 按住说话" : "开始录音 按住说话";
                        d.setData({
                            cardIndexData: t,
                            recordStatusText: c
                        });
                    });

                  case 4:
                  case "end":
                    return e.stop();
                }
            }, e, a);
        }))();
    },
    getStaffCard: function() {
        var t = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var P;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    P = t, _xx_util2.default.showLoading(), console.log("getStaffCard"), _index.staffModel.getStaffCardInfo().then(function(e) {
                        if (_xx_util2.default.hideAll(), 0 == e.errno) {
                            var t = e.data, a = t.job_index, n = t.job_list, r = t.count, o = n[a], i = o.id, s = o.name, c = r.id ? 0 : 1, d = P.data, u = d.company, l = d.cardTypeIndex, f = d.cardTypeList, g = d.globalData.configInfo, _ = g.my_company, x = g.company_list, p = r.id, h = r.is_staff, m = r.avatar, y = r.voice, v = r.voice_time, D = r.card_type, w = r.images, I = r.desc, A = r.desc2, T = {
                                jobList: n,
                                id: p,
                                is_staff: h || 0
                            };
                            for (var b in w) w[b] || w.splice(b, 1);
                            var S = _ = _ || x[u], C = S.id, R = S.logo, M = S.name, k = S.short_name, L = S.addr;
                            for (var j in f) r.card_type == f[j] && (l = j);
                            innerAudioContext.src = y || "", console.log(innerAudioContext.src, "***************innerAudioContext.src 111111111111111111111 "), 
                            r.card_type = D || "cardType1", r.avatar_2 = m, r.voice = y || "", r.desc = A || I || "", 
                            r.voice_time = v || 0, r.job_id = i, r.job_name = s, r.company_id = C, r.myCompany = {
                                logo: R,
                                name: M,
                                short_name: k,
                                addr: L
                            }, P.setData({
                                firstCreate: c,
                                job: a,
                                staffInfo: T,
                                cardTypeIndex: l,
                                "cardIndexData.info": r
                            });
                        }
                    });

                  case 4:
                  case "end":
                    return e.stop();
                }
            }, e, t);
        }))();
    },
    getTagsList: function() {
        var t = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var s;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    s = t, _index.userModel.getTagsList().then(function(e) {
                        _xx_util2.default.hideAll(), console.log("getTagsList ==>", e.data);
                        var t = e.data, a = t.my_tags, n = t.sys_tags, r = [];
                        for (var o in n) for (var i in r.push(0), a) n[o].tag == a[i].tag && (r[o] = 1);
                        s.setData({
                            my_tags: a,
                            sys_tags: n,
                            sys_check: r
                        });
                    });

                  case 2:
                  case "end":
                    return e.stop();
                }
            }, e, t);
        }))();
    },
    cropperImage: function(e) {
        var t = _xx_util2.default.getData(e), a = t.key, n = t.ratio;
        wx.chooseImage({
            count: 1,
            success: function(e) {
                var t = e.tempFiles;
                wx.navigateTo({
                    url: "/longbing_card/pages/common/cropper/cropper?key=" + a + "&src=" + t[0].path + "&ratio=" + n
                });
            }
        });
    },
    chooseImage: function(l) {
        var f = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, a, n, r, o, i, s, c, d, u;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return t = f, a = _xx_util2.default.getData(l), n = a.key, r = a.size, o = t.data.cardIndexData.info[n] || [], 
                    e.next = 5, wx.pro.chooseImage({
                        count: r - 1 * o.length
                    });

                  case 5:
                    i = e.sent, s = i.tempFiles, _xx_util2.default.showLoading({
                        title: "上传中"
                    }), c = 0;

                  case 9:
                    if (!(c < s.length)) {
                        e.next = 17;
                        break;
                    }
                    return e.next = 12, _index.baseModel.toUpload({
                        filePath: s[c].path
                    });

                  case 12:
                    d = e.sent, o.push({
                        path: d.path,
                        img: d.img
                    });

                  case 14:
                    c++, e.next = 9;
                    break;

                  case 17:
                    _xx_util2.default.hideAll(), u = "cardIndexData.info." + n, f.setData(_defineProperty({}, u, o));

                  case 20:
                  case "end":
                    return e.stop();
                }
            }, e, f);
        }))();
    },
    toDeleteImg: function(e) {
        var t = _xx_util2.default.getData(e), a = t.index, n = t.key, r = this.data.cardIndexData.info[n];
        r.splice(a, 1), n = "cardIndexData.info." + n, this.setData(_defineProperty({}, n, r));
    },
    setFormValue: function(e, t) {
        e = "cardIndexData.info." + e, this.setData(_defineProperty({}, e, t));
    },
    handerImageChange: function(e, t) {
        this.setFormValue(e, t);
    },
    handerInputChange: function(e) {
        var t = _xx_util2.default.getData(e).key, a = _xx_util2.default.getValue(e);
        this.setFormValue(t, a);
    },
    toAuthRecord: function(e) {
        var t = this;
        wx.authorize({
            scope: "scope.record",
            success: function(e) {
                t.setData({
                    showTostImg: !0,
                    recordAuthMethod: 2,
                    record_status: 1
                }), recorderManager.start({
                    duration: 6e4,
                    sampleRate: 16e3,
                    numberOfChannels: 1,
                    encodeBitRate: 96e3,
                    format: "mp3",
                    frameSize: 50
                });
            },
            fail: function(e) {
                t.setData({
                    isSetting: !0,
                    record_status: 0,
                    recordAuthMethod: 1
                });
            }
        });
    },
    toReRecord: function() {
        var e = this;
        e.setData({
            start: !0,
            record_status: 1,
            showTostImg: !1,
            "cardIndexData.info.voice": "",
            "cardIndexData.info.voice_time": ""
        }, function() {
            innerAudioContext.stop(), e.toAuthRecord();
        });
    },
    start: function(e) {
        var t = this.data;
        t.start;
        t.play ? wx.showToast({
            title: "正在播放语音",
            icon: "none"
        }) : this.toAuthRecord();
    },
    end: function(e) {
        recorderManager.stop();
    },
    play: function() {
        var e = this.data, t = e.start, a = e.play;
        t ? wx.showToast({
            title: "正在录音",
            icon: "none"
        }) : a ? innerAudioContext.stop() : innerAudioContext.play();
    },
    validate: function(e) {
        var t = e.name, a = e.phone, n = e.email, r = new _xx_util2.default.Validate();
        return r.add(t, "isNoEmpty", "请填写姓名"), _xx_util2.default.isEmpty(a) || r.add(a, "isMobile", "请填写11位手机号"), 
        _xx_util2.default.isEmpty(n) || r.add(n, "isEmail", "请填写正确的邮箱地址"), r.start();
    },
    toEditStaff: function() {
        var a = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    1 == (t = a).data.record_status ? (t.end(), wx.showLoading({
                        title: "录音上传中",
                        mask: !0
                    }), setTimeout(function() {
                        _xx_util2.default.hideAll(), t.toSaveBtn();
                    }, 1500)) : t.toSaveBtn();

                  case 3:
                  case "end":
                    return e.stop();
                }
            }, e, a);
        }))();
    },
    toSaveBtn: function() {
        var b = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, a, n, r, o, i, s, c, d, u, l, f, g, _, x, p, h, m, y, v, D, w, I, A, T;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    for (I in a = (t = b).data, n = a.staffInfo, r = a.cardIndexData, o = a.globalData, 
                    i = r.info, s = i.avatar_2, c = i.name, d = i.phone, u = i.wechat, l = i.ww_account, 
                    f = i.telephone, g = i.email, _ = i.desc, x = i.voice_time, p = i.images, h = i.code, 
                    m = i.job_id, y = i.card_type, v = i.company_id, D = s.img || s, w = "", p) w += (p[I].img || p[I]) + ",";
                    if (w = w.slice(0, -1), A = {
                        avatar: D,
                        name: c,
                        phone: d,
                        wechat: u,
                        ww_account: l,
                        telephone: f,
                        email: g,
                        desc: _,
                        voice_time: x,
                        images: w,
                        job_id: m,
                        card_type: y || "cardType1",
                        company_id: v
                    }, 0 == n.is_staff && o.configInfo.config.code && (A.code = h), !(T = b.validate(A))) {
                        e.next = 13;
                        break;
                    }
                    return _xx_util2.default.showModal({
                        content: T
                    }), e.abrupt("return");

                  case 13:
                    t.toUpRecord(function() {
                        var e = t.data.cardIndexData.info.voice;
                        A.voice = e.img || e, t.toEditBtn(A);
                    });

                  case 14:
                  case "end":
                    return e.stop();
                }
            }, e, b);
        }))();
    },
    toUpRecord: function(r) {
        var o = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, a, n;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    if (-1 != (a = (t = o).data.cardIndexData.info.voice).indexOf("wxfile://")) {
                        e.next = 5;
                        break;
                    }
                    return r && r(), e.abrupt("return");

                  case 5:
                    return _xx_util2.default.showLoading({
                        title: "上传中"
                    }), e.next = 8, _index.baseModel.toUpload({
                        filePath: a
                    });

                  case 8:
                    n = e.sent, _xx_util2.default.hideAll(), t.setData({
                        "cardIndexData.info.voice": {
                            path: n.path,
                            img: n.img
                        }
                    }), r && r();

                  case 12:
                  case "end":
                    return e.stop();
                }
            }, e, o);
        }))();
    },
    toEditBtn: function(f) {
        var g = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, a, n, r, o, i, s, c, d, u, l;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return t = g, e.next = 3, Promise.all([ _index.userModel.getEditStaffV2(f), getApp().getConfigInfo(!0) ]);

                  case 3:
                    a = e.sent, n = _slicedToArray(a, 2), r = n[0], o = n[1], console.log(r, o, "res_staff,res_config"), 
                    i = r.errno, s = r.message, c = o.config, d = c.btn_code_miss, u = c.btn_code_err, 
                    "need code" == (l = s) && (l = d || "需要填写免审口令"), "code error" == l && (l = u || "免审口令错误"), 
                    0 == i ? (_xx_util2.default.showSuccess(l), setTimeout(function() {
                        _xx_util2.default.hideAll(), "createCard" == t.data.paramStatus ? wx.reLaunch({
                            url: "/longbing_card/pages/index/index?currentTabBar=cardList&paramStatus=createCard"
                        }) : wx.navigateBack();
                    }, 1500)) : _xx_util2.default.showModal({
                        content: l
                    });

                  case 14:
                  case "end":
                    return e.stop();
                }
            }, e, g);
        }))();
    },
    toCheckSysTags: function(e) {
        var t = this, a = _xx_util2.default.getData(e), n = a.index, r = a.type, o = t.data, i = o.my_tags, s = o.sys_tags, c = o.sys_check;
        if (0 == r) {
            for (var d in i) if (s[n].tag == i[d].tag) return _xx_util2.default.showModal({
                content: "不能添加重复的印象标签哦！"
            }), !1;
            if (9 < i.length) return _xx_util2.default.showModal({
                content: "不能添加更多印象标签哦！"
            }), !1;
            c[n] = 1;
            var u = s[n], l = {
                tag: s[n].tag
            };
            _index.userModel.getAddDeleteTags(l).then(function(e) {
                _xx_util2.default.hideAll(), u.id = e.data.tag_id, i.push(u), t.setData({
                    my_tags: i,
                    sys_check: c
                });
            });
        }
        if (1 == r) for (var f in i) if (s[n].tag == i[f].tag) {
            var g = {
                tag_id: i[f].id
            };
            i.splice(f, 1), c[n] = 0, t.setData({
                my_tags: i,
                sys_check: c
            }), _index.userModel.getAddDeleteTags(g).then(function(e) {
                _xx_util2.default.hideAll();
            });
        }
    },
    toDeleteTags: function(e) {
        var t = _xx_util2.default.getData(e).index, a = this.data, n = a.my_tags, r = a.sys_tags, o = a.sys_check;
        for (var i in r) n[t].tag == r[i].tag && (o[i] = 0, this.setData({
            sys_check: o
        }));
        var s = {
            tag_id: n[t].id
        };
        n.splice(t, 1), this.setData({
            my_tags: n
        }), _index.userModel.getAddDeleteTags(s), _xx_util2.default.hideAll();
    },
    toCardType: function(e) {
        var t = _xx_util2.default.getData(e).index, a = this.data.cardTypeList;
        this.setData({
            cardTypeIndex: t,
            "cardIndexData.info.card_type": a[t]
        });
    },
    toShowAddSec: function(e) {
        var t = _xx_util2.default.getData(e).type;
        this.setData({
            showAddUseSec: !t
        });
    },
    formSubmit: function(e) {
        var t = this, a = _xx_util2.default.getFormData(e).status, n = e.detail.value.content;
        if ("toSaveUseMessage" == a) {
            if (!n) return _xx_util2.default.showModal({
                content: "请输入印象标签！"
            }), !1;
            var r = {
                tag: n
            };
            _index.userModel.getAddDeleteTags(r).then(function(e) {
                _xx_util2.default.hideAll(), -1 != e.errno || "already" != e.message ? t.setData({
                    showAddUseSec: !1
                }, function() {
                    t.getTagsList();
                }) : _xx_util2.default.showModal({
                    content: "不能添加重复的印象标签哦！"
                });
            });
        }
    }
});