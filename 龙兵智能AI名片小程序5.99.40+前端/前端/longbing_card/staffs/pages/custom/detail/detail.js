var _data, _slicedToArray = function(t, e) {
    if (Array.isArray(t)) return t;
    if (Symbol.iterator in Object(t)) return function(t, e) {
        var a = [], i = !0, r = !1, n = void 0;
        try {
            for (var o, d = t[Symbol.iterator](); !(i = (o = d.next()).done) && (a.push(o.value), 
            !e || a.length !== e); i = !0) ;
        } catch (t) {
            r = !0, n = t;
        } finally {
            try {
                !i && d.return && d.return();
            } finally {
                if (r) throw n;
            }
        }
        return a;
    }(t, e);
    throw new TypeError("Invalid attempt to destructure non-iterable instance");
}, _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(t) {
    return typeof t;
} : function(t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t;
}, _echarts = require("../../../../templates/ec-canvas/echarts"), echarts = _interopRequireWildcard(_echarts), _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js"), _staff = require("../../../../resource/apis/staff"), _staff2 = _interopRequireDefault(_staff);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

function _interopRequireWildcard(t) {
    if (t && t.__esModule) return t;
    var e = {};
    if (null != t) for (var a in t) Object.prototype.hasOwnProperty.call(t, a) && (e[a] = t[a]);
    return e.default = t, e;
}

function _toConsumableArray(t) {
    if (Array.isArray(t)) {
        for (var e = 0, a = Array(t.length); e < t.length; e++) a[e] = t[e];
        return a;
    }
    return Array.from(t);
}

function _asyncToGenerator(t) {
    return function() {
        var d = t.apply(this, arguments);
        return new Promise(function(n, o) {
            return function e(t, a) {
                try {
                    var i = d[t](a), r = i.value;
                } catch (t) {
                    return void o(t);
                }
                if (!i.done) return Promise.resolve(r).then(function(t) {
                    e("next", t);
                }, function(t) {
                    e("throw", t);
                });
                n(r);
            }("next");
        });
    };
}

function _defineProperty(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: (_data = {
        globalData: [],
        tabList: [ {
            status: "browse",
            name: "浏览记录"
        }, {
            status: "follow",
            name: "跟进记录"
        }, {
            status: "analysis",
            name: "AI分析"
        } ],
        currentIndex: 0,
        scrollNav: "scrollNav0",
        currentTab: "browse",
        Customer: [],
        currEditInd: -1,
        toFolledit: "toSave",
        content: "",
        date: "",
        startDate: "",
        page: 1,
        dateindex: 0,
        dateindex2: 0
    }, _defineProperty(_data, "content", ""), _defineProperty(_data, "dataList", [ {
        modelMethod: "getClientView",
        param: {
            page: 1
        },
        list: {
            page: 1,
            total_page: 0,
            list: []
        }
    }, {
        modelMethod: "getStaffFollow",
        param: {
            page: 1
        },
        list: {
            page: 1,
            total_page: 0,
            list: []
        }
    } ]), _defineProperty(_data, "refresh", !1), _defineProperty(_data, "loading", !0), 
    _defineProperty(_data, "toFollowType", []), _defineProperty(_data, "page", 1), _defineProperty(_data, "more", !0), 
    _defineProperty(_data, "isEmpty", !1), _defineProperty(_data, "index1", "2"), _defineProperty(_data, "index2", "2"), 
    _defineProperty(_data, "Labellist", []), _defineProperty(_data, "types", ""), _defineProperty(_data, "ai_Interest", []), 
    _defineProperty(_data, "ai_Interest_x", []), _defineProperty(_data, "ai_Interest_y", []), 
    _defineProperty(_data, "ai_active_x", []), _defineProperty(_data, "ai_active_y", []), 
    _defineProperty(_data, "ai_Interaction", []), _defineProperty(_data, "setInterest", [ {
        name: "今日"
    }, {
        name: "近7天"
    }, {
        name: "近30天"
    }, {
        name: "本月"
    } ]), _defineProperty(_data, "interest", 2), _defineProperty(_data, "setActivity", [ {
        name: "近7天"
    }, {
        name: "近30天"
    } ]), _defineProperty(_data, "activity", 1), _defineProperty(_data, "setClient", [ {
        name: "今日"
    }, {
        name: "近7天"
    }, {
        name: "近30天"
    }, {
        name: "本月"
    }, {
        name: "全部"
    } ]), _defineProperty(_data, "client", 2), _defineProperty(_data, "firstTime", ""), 
    _defineProperty(_data, "RecordShow", !1), _defineProperty(_data, "vagueShow", !1), 
    _defineProperty(_data, "textValue", ""), _defineProperty(_data, "ec", {
        lazyLoad: !0
    }), _defineProperty(_data, "isShowFooter", !0), _defineProperty(_data, "curr_radar_record", [ {
        copy: [ "保存", "拨打", "拨打", "复制", "复制", "复制", "查看", "咨询", "播放", "保存", "拨打" ],
        view: [ "浏览", "浏览", "浏览", "点赞", "评论", "浏览公司官网", "浏览", "浏览", "浏览", "浏览", "浏览", "浏览", "分享", "保存", "查看", "浏览", "查看", "", "购买", "购买", "购买", "购买", "购买", "购买", "浏览", "浏览", "浏览", "在" ],
        praise: [ "", "查看", "", "分享" ],
        order: [ "购买", "购买", "预约" ],
        qr: [ "在" ]
    }, {
        copy: [ "", "", "", "", "", "你公司的", "你公司的", "你公司的", "", "", "" ],
        view: [ "", "", "", "", "", " ", "", "", "", "", "", "", "", "", "", "", "", "在你的", "", "", "", "", "", "" ],
        praise: [ "给你的录音点赞了，看来TA对你的介绍", "名片", "给你点赞了，看来TA觉得你", "名片" ],
        order: [ "", "", "" ],
        qr: [ "" ]
    }, {
        copy: [ "电话", "手机号", "座机号", "微信", "邮箱", "公司名称", "导航定位", "产品", "语音", "名片海报", "400热线" ],
        view: [ "商城列表", "", "动态列表", "动态", "动态", "公司官网", "动态详情", "动态视频", "动态外链", "动态跳转小程序", "商城栏目", "获客文章", "获客文章", "获客文章", "预约", "预约栏目", "预约栏目", "官网留言", "商品", "自提商品", "商品", "商品", "商品", "商品", "", "", "", "" ],
        praise: [ "非常感兴趣", "名片", "非常靠谱", "名片" ],
        order: [ "", "", "" ],
        qr: [ "名片" ]
    } ]), _data),
    onLoad: function(y) {
        var v = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var a, e, i, r, n, o, d, s, l, f, u, c, _, p, h, m, x, g;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return a = v, _xx_util2.default.showLoading(), y.type && v.setData({
                        types: y.type
                    }), e = y.id, i = y.fromstatus, r = y.staffid, n = y.client_id, o = y.cur, d = {
                        id: e,
                        fromstatus: i,
                        staff_id: r,
                        client_id: n
                    }, (s = a.data.dataList)[0].param.client_id = e, s[1].param.client_id = e, d.staff_id && null != _typeof(d.staff_id) && (s[0].param.staff_id = d.staff_id, 
                    s[1].param.staff_id = d.staff_id), _index.staffModel.getStaffInfo({
                        target_id: e
                    }).then(function(t) {
                        if (_xx_util2.default.hideAll(), 0 == t.errno) {
                            var e = t.data.avatarUrl;
                            a.setData({
                                img2: e
                            });
                        }
                    }), l = a.data, f = l.currentTab, u = l.currentIndex, f = "f" == o ? "follow" : f, 
                    a.setData({
                        param: d
                    }), t.next = 15, getApp().getConfigInfo(!0);

                  case 15:
                    c = getApp().globalData, _ = c.isIphoneX, p = c.userDefault, h = c.configInfo, m = h.config, 
                    x = m.question_switch, g = m.question_text, a.setData({
                        globalData: app.globalData,
                        currentTab: "f" == o ? "follow" : f,
                        currentIndex: "f" == o ? 1 : u,
                        isIphoneX: _,
                        userDefault: p,
                        question_switch: x,
                        question_text: g,
                        dataList: s
                    }, function() {
                        this.getDealDate(), this.getRate(), this.firsttime(), this.ifOK(), this.getList();
                        var t = (new Date().getTime() / 1e3).toFixed(0), e = _xx_util2.default.formatTime(1e3 * t, "YY-M-D");
                        a.setData({
                            startDate: e
                        }), wx.hideLoading();
                    });

                  case 18:
                  case "end":
                    return t.stop();
                }
            }, t, v);
        }))();
    },
    onReady: function() {},
    onShow: function(t) {
        this.shuaxin(), this.biaoqian();
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var r = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, i;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    a = (e = r).data.currentIndex, wx.showNavigationBarLoading(), 2 == a ? e.getAnalysis() : (i = "dataList[" + a + "].param.page", 
                    e.setData(_defineProperty({
                        refresh: !0
                    }, i, 1)), e.getList()), e.shuaxin(), wx.stopPullDownRefresh(), _xx_util2.default.hideAll();

                  case 7:
                  case "end":
                    return t.stop();
                }
            }, t, r);
        }))();
    },
    onReachBottom: function() {
        var t = this, e = this.data, a = e.loading, i = e.dataList, r = e.currentIndex;
        if (r < 2) {
            var n = i[r].list, o = n.page;
            if (o != n.total_page && !a) {
                var d, s = "dataList[" + r + "].param.page";
                t.setData((_defineProperty(d = {}, s, o + 1), _defineProperty(d, "loading", !0), 
                d), function() {
                    t.getList();
                });
            }
        }
        _xx_util2.default.hideAll();
    },
    onPageScroll: function(t) {},
    onShareAppMessage: function(t) {},
    getList: function() {
        var b = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, i, r, n, o, d, s, l, f, u, c, _, p, h, m, x, g, y, v, w, D;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    if (i = (a = b).data, r = i.refresh, n = i.dataList, o = i.currentIndex, d = i.toFollowType, 
                    s = i.param, l = i.img2, f = n[o], u = f.list, c = f.param, 0 != o) {
                        t.next = 9;
                        break;
                    }
                    return t.next = 6, _index.staffModel[n[o].modelMethod](c);

                  case 6:
                    t.t0 = t.sent, t.next = 12;
                    break;

                  case 9:
                    return t.next = 11, _index.bossModel[n[o].modelMethod](c);

                  case 11:
                    t.t0 = t.sent;

                  case 12:
                    for (m in _ = t.t0, p = _.data, _xx_util2.default.hideAll(), r || (p.list = [].concat(_toConsumableArray(u.list), _toConsumableArray(p.list))), 
                    h = p.list) h[m].create_time && (h[m].create_time1 = _xx_util2.default.formatTime(1e3 * h[m].create_time, "YY/M/D"), 
                    h[m].create_time2 = _xx_util2.default.formatTime(1e3 * h[m].create_time, "h:m")), 
                    0 == o && (x = h[m], g = x.sign, y = x.type, v = x.count, h[m].countText = "", "copy" == g && (h[m].countText = y < 4 || 11 == y ? "，请随时保持电话畅通" : 4 == y ? "，请随时查看微信通讯录" : 5 == y ? "，可能随时邮寄文件给你，请注意查收" : 10 == y ? "，请及时留意雷达动态" : ""), 
                    "order" == g && (h[m].countText = 1 == y || 2 == y ? "，详情请查看订单中心并发货" : ""), "praise" == g && (2 == y && (h[m].countText = v < 2 ? "，TA正在了解你" : 2 <= v && v < 5 ? "，你成功的吸引了TA" : "，高意向客户立刻主动沟通"), 
                    4 == y && (h[m].countText = "，请及时留意雷达动态")), "view" == g && (h[m].countText = 1 == y || 15 == y ? 1 == v ? "，请尽快把握商机" : 2 == v ? 1 == y ? "，潜在购买客户" : "，潜在预约客户" : 3 == v ? "，高意向客户立刻主动沟通" : 1 == y ? "，购买欲望强烈" : "，预约欲望强烈" : 3 == y || 6 == y ? 1 == v ? 3 == y ? "，看来TA对公司动态感兴趣" : "，看来TA对公司官网感兴趣" : 2 == v ? "，赶快主动沟通" : "，高意向客户成交在望" : 2 == y || 17 == y ? "，尽快把握商机" : 18 == y ? "，请尽快处理" : "")), 
                    1 == o && d.push(0);
                    w = s.fromstatus, 1 == o && "boss" == w && (l = getApp().globalData.avatarUrlStaff), 
                    p.page = 1 * p.page, D = "dataList[" + o + "].list", a.setData((_defineProperty(e = {}, D, p), 
                    _defineProperty(e, "loading", !1), _defineProperty(e, "refresh", !1), _defineProperty(e, "toFollowType", d), 
                    _defineProperty(e, "img2", l), e));

                  case 24:
                  case "end":
                    return t.stop();
                }
            }, t, b);
        }))();
    },
    pickerSelected: function(t) {
        var e = "" + _xx_util2.default.getData(t).status;
        this.setData(_defineProperty({}, e, t.detail.value)), this.getAnalysis();
    },
    getAnalysis: function() {
        var T = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, i, r, n, o, d, s, l, f, u, c, _, p, h, m, x, g, y, v, w, D, b, P, A;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return a = (e = T).data, i = a.param, r = a.interest, n = a.activity, o = a.client, 
                    d = i.id, s = i.staff_id, l = {
                        client_id: d,
                        type: 1 * r + 1
                    }, f = {
                        client_id: d,
                        type: 1 * n + 1
                    }, u = {
                        client_id: d,
                        type: 1 * o + 1
                    }, s && (l.staff_id = s, f.staff_id = s, u.staff_id = s), t.next = 9, Promise.all([ _index.staffModel.getInterest(l), _index.staffModel.getActivity(f), _index.staffModel.getClientInteraction(u) ]);

                  case 9:
                    for (P in c = t.sent, _ = _slicedToArray(c, 3), p = _[0], h = _[1], m = _[2], x = p.data, 
                    g = [], y = [], x.qr && (g.push("名片" + x.qr.count + "(" + x.qr.rate + "%)"), y.push({
                        value: x.qr.count,
                        name: "名片" + x.qr.count + "(" + x.qr.rate + "%)"
                    })), x.timeline && (g.push("动态" + x.timeline.count + "(" + x.timeline.rate + "%)"), 
                    y.push({
                        value: x.timeline.count,
                        name: "动态" + x.timeline.count + "(" + x.timeline.rate + "%)"
                    })), x.goods && (g.push("产品" + x.goods.count + "(" + x.goods.rate + "%)"), y.push({
                        value: x.goods.count,
                        name: "产品" + x.goods.count + "(" + x.goods.rate + "%)"
                    })), x.custom_qr && (g.push("自定义码" + x.custom_qr.count + "(" + x.custom_qr.rate + "%)"), 
                    y.push({
                        value: x.custom_qr.count,
                        name: "自定义码" + x.custom_qr.count + "(" + x.custom_qr.rate + "%)"
                    })), 0 == g.length && (g.push("暂无数据(100%)"), y.push({
                        value: 100,
                        name: "暂无数据(100%)"
                    })), v = h.data.reverse(), w = [], D = [], v.forEach(function(t) {
                        var e = t.date;
                        w.push(e.slice(5)), D.push(t.count);
                    }), b = m.data) A = parseInt(b[P].rate / 100 * 200), b[P].width = A;
                    e.setData({
                        ai_Interest_x: g,
                        ai_Interest_y: y,
                        ai_active_x: w,
                        ai_active_y: D,
                        ai_Interaction: b
                    }), e.barComponent = e.selectComponent("#mychart"), e.barComponent2 = e.selectComponent("#mychart2"), 
                    e.init_bar("1"), e.init_bar("2");

                  case 33:
                  case "end":
                    return t.stop();
                }
            }, t, T);
        }))();
    },
    listenerDatePickerSelected: function(t) {
        var e = t.detail.value, a = e.split("-");
        this.setData({
            date: e,
            year: a[0],
            month: a[1],
            day: a[2],
            content: "将预计成交日期更改为" + e
        }), this.getDealDate(), this.adds();
    },
    getDealDate: function() {
        var i = this, t = {
            client_id: i.data.param.id
        }, e = i.data, a = e.date, r = e.param;
        a && (t.date = a), r.staff_id && (t.staff_id = r.staff_id), _index.staffModel.getDealDate(t).then(function(t) {
            if (_xx_util2.default.hideAll(), t.data.date) {
                var e = t.data.date, a = e.split("-");
                i.setData({
                    date: e,
                    year: a[0],
                    month: a[1],
                    day: a[2]
                });
            }
        });
    },
    getRate: function() {
        var e = this, t = {
            client_id: e.data.param.id
        }, a = e.data.param;
        a.staff_id && (t.staff_id = a.staff_id), _index.staffModel.getRate(t).then(function(t) {
            _xx_util2.default.hideAll(), 0 == t.errno && e.setData({
                rate: t.data.rate
            });
        });
    },
    Edit: function(t) {
        var e = "/longbing_card/staffs/pages/custom/editInfo/editInfo?id=" + this.data.param.id;
        this.data.param.fromstatus && (e = e + "&fromstatus=" + this.data.param.fromstatus + "&staff_id=" + this.data.param.staff_id), 
        wx.navigateTo({
            url: e
        });
    },
    addslables: function(t) {
        var e = "/longbing_card/staffs/pages/custom/tag/tag?id=" + this.data.param.id;
        this.data.param.fromstatus && (e = e + "&fromstatus=" + this.data.param.fromstatus + "&staff_id=" + this.data.param.staff_id), 
        wx.navigateTo({
            url: e
        });
    },
    addsRecord: function(t) {
        this.setData({
            RecordShow: !0,
            vagueShow: !0,
            content: ""
        });
    },
    textValue: function(t) {
        this.setData({
            content: t.detail.value
        });
    },
    cancel: function(t) {
        this.setData({
            RecordShow: !1,
            vagueShow: !1,
            textValue: "",
            content: ""
        });
    },
    adds: function(t) {
        var e = this;
        if (e.setData({
            RecordShow: !1,
            vagueShow: !1
        }), "toSave" == e.data.toFolledit) {
            var a = {
                client_id: e.data.param.id,
                content: this.data.content
            };
            -1 < e.data.content.indexOf("将预计成交日期更改为") && (a.type = 2), _index.staffModel.getfollowInsert(a).then(function(t) {
                _xx_util2.default.hideAll(), 0 == t.errno && (e.setData({
                    currentIndex: 1,
                    currentTab: "follow",
                    content: ""
                }), e.onPullDownRefresh());
            });
        } else e.getFollowEdit();
    },
    index99: function(t) {
        this.setData({
            RecordShow: !1,
            vagueShow: !1,
            textValue: ""
        });
    },
    BottomOK: function(t) {
        var e = this, a = e.data, i = a.tmp_errno;
        a.Customer.tmpVal;
        1 == i ? _index.staffModel.getDeal({
            client_id: e.data.param.id
        }).then(function(t) {
            _xx_util2.default.hideAll(), 0 == t.errno && e.setData({
                tmp_errno: 0,
                "Customer.value1": "已成交"
            });
        }) : 0 == i && _index.staffModel.getCancelDeal({
            client_id: e.data.param.id
        }).then(function(t) {
            _xx_util2.default.hideAll(), 0 == t.errno && e.setData({
                tmp_errno: 1
            }, function() {
                e.shuaxin();
            });
        });
    },
    ifOK: function(t) {
        var i = this;
        _index.staffModel.getCheckDeal({
            client_id: i.data.param.id
        }).then(function(t) {
            if (_xx_util2.default.hideAll(), console.log(t, "ifOk"), 0 == t.errno) {
                var e = t.message, a = 0;
                "未成交" == e && (a = 1), console.log(e, a, "message"), i.setData({
                    tmp_errno: a
                });
            }
        });
    },
    init_bar: function(t) {
        var r = this;
        "1" == t && this.barComponent.init(function(t, e, a) {
            var i = echarts.init(t, null, {
                width: e,
                height: a
            });
            return i.setOption(r.getBarOption()), i;
        }), "2" == t && this.barComponent2.init(function(t, e, a) {
            var i = echarts.init(t, null, {
                width: e,
                height: a
            });
            return i.setOption(r.getBarOption2()), i;
        });
    },
    getBarOption: function() {
        return {
            legend: {
                orient: "vertical",
                top: "10%",
                right: "10%",
                data: this.data.ai_Interest_x
            },
            series: [ {
                type: "pie",
                center: [ "30%", "40%" ],
                radius: [ "40%", "60%" ],
                avoidLabelOverlap: !1,
                label: {
                    normal: {
                        show: !1,
                        position: "center"
                    }
                },
                data: this.data.ai_Interest_y
            } ]
        };
    },
    getBarOption2: function() {
        var t;
        return {
            grid: {
                left: "15%",
                right: "15%",
                top: "10%",
                bottom: "15%"
            },
            xAxis: (t = {
                type: "category",
                minInterval: "100",
                boundaryGap: !1
            }, _defineProperty(t, "minInterval", "1"), _defineProperty(t, "data", this.data.ai_active_x), 
            _defineProperty(t, "axisLabel", {
                showMinLabel: !0
            }), t),
            yAxis: {
                type: "value"
            },
            series: [ {
                symbol: "none",
                data: this.data.ai_active_y,
                type: "line",
                areaStyle: {
                    color: "#e89e9e"
                }
            } ]
        };
    },
    shuaxin: function(t) {
        var a = this, e = {
            client_id: a.data.param.id
        }, i = a.data.param;
        i.staff_id && (e.staff_id = i.staff_id), _index.staffModel.getClientInfo(e).then(function(t) {
            if (_xx_util2.default.hideAll(), 0 == t.errno) {
                var e = t.data;
                "0" == e.is_new || ("1" == e.is_new ? e.value1 = "新客户" : "2" == e.is_new ? e.value1 = "跟进中" : "3" == e.is_new && (e.value1 = "已成交")), 
                a.setData({
                    Customer: e
                });
            }
        });
    },
    firsttime: function() {
        var e = this;
        _index.staffModel.getfirstTime({
            client_id: e.data.param.id
        }).then(function(t) {
            _xx_util2.default.hideAll(), 0 == t.errno && e.setData({
                firstTime: t.data.time
            });
        });
    },
    biaoqian: function() {
        var e = this, t = {
            target_id: e.data.param.id
        }, a = e.data.param;
        a.staff_id && (t.staff_id = a.staff_id), _index.staffModel.getLabels(t).then(function(t) {
            _xx_util2.default.hideAll(), 0 == t.errno && e.setData({
                Labellist: t.data
            });
        });
    },
    qq: function() {
        var t = this, a = t.data.param.id, i = t.data.Customer.nickName, r = t.data.Customer.avatarUrl;
        t.data.Customer.phone;
        _index.staffModel.getStaffInfo({
            target_id: t.data.param.id
        }).then(function(t) {
            if (_xx_util2.default.hideAll(), 0 == t.errno) {
                var e = t.data.avatarUrl;
                wx.navigateTo({
                    url: "/longbing_card/chat/staffChat/staffChat?chat_to_uid=" + a + "&contactUserName=" + i + "&chatAvatarUrl=" + r + "&toChatAvatarUrl=" + e
                });
            }
        });
    },
    getFollowEdit: function() {
        var n = this, t = n.data, e = t.toFolledit, a = t.content;
        _index.staffModel.getFollowUpdate({
            id: e,
            content: a
        }).then(function(t) {
            if (_xx_util2.default.hideAll(), 0 == t.errno) {
                wx.showToast({
                    icon: "none",
                    title: "已成功修改跟进记录！",
                    duration: 1e3
                });
                var e = n.data.dataList, a = e[1].list.list, i = n.data.toFolledit;
                for (var r in a) i == a[r].id && (a[r].content = n.data.content);
                e[1].list.list = a, n.setData({
                    dataList: e,
                    toFolledit: "toSave",
                    currEditInd: "-1",
                    content: ""
                });
            }
        });
    },
    getFollowDelete: function(n) {
        var o = this, t = o.data.dataList[1].list.list[n].id;
        _index.staffModel.getFollowDelete({
            id: t
        }).then(function(t) {
            if (_xx_util2.default.hideAll(), 0 == t.errno) {
                wx.showToast({
                    icon: "none",
                    title: "已成功删除跟进记录！",
                    duration: 1e3
                });
                var e = o.data.dataList, a = e[1].list.list, i = o.data.toFollowType;
                for (var r in a.splice(n, 1), i) i[r] = 0;
                e[1].list.list = a, o.setData({
                    dataList: e,
                    currEditInd: "-1",
                    toFollowType: i
                });
            }
        });
    },
    toSetStarMark: function() {
        var a = this, t = {
            client_id: a.data.param.id
        };
        _index.staffModel.getStarMark(t).then(function(t) {
            _xx_util2.default.hideAll();
            var e = 1;
            1 == a.data.Customer.start && (e = 0), a.setData({
                "Customer.start": e
            });
        });
    },
    goUrl: function(t) {
        _xx_util2.default.goUrl(t);
    },
    toJump: function(t) {
        var e = this, a = _xx_util2.default.getData(t), i = a.status, r = a.index, n = a.type, o = a.content;
        if ("toCall" == i) {
            if (!o) return !1;
            wx.makePhoneCall({
                phoneNumber: o,
                success: function(t) {
                    app.globalData.to_uid != wx.getStorageSync("userid") && e.toCopyRecord(n);
                }
            });
        } else if ("toFollowEdit" == i) {
            var d = e.data, s = d.currEditInd, l = d.toFollowType;
            0 == n && (l[s = r] = 1), 1 == n && (s = "-1", l[r] = 0), e.setData({
                currEditInd: s,
                toFollowType: l
            });
        } else if ("toFolledit" == i) {
            e.addsRecord();
            var f = e.data.dataList[1].list.list[r], u = f.id, c = f.content;
            e.setData({
                toFolledit: u,
                content: c
            });
        } else "toFolldelete" == i ? wx.showModal({
            title: "",
            content: "是否删除此条数据？",
            success: function(t) {
                t.confirm && e.getFollowDelete(r);
            }
        }) : "toStarMark" == i && e.toSetStarMark();
    },
    toTabClick: function(t) {
        var e = _xx_util2.default.getData(t).index, a = 2 != e;
        this.setData({
            currentIndex: e,
            scrollNav: "scrollNav" + e,
            isShowFooter: a
        }), this.onPullDownRefresh();
    }
});