var _slicedToArray = function(t, e) {
    if (Array.isArray(t)) return t;
    if (Symbol.iterator in Object(t)) return function(t, e) {
        var a = [], r = !0, n = !1, i = void 0;
        try {
            for (var o, s = t[Symbol.iterator](); !(r = (o = s.next()).done) && (a.push(o.value), 
            !e || a.length !== e); r = !0) ;
        } catch (t) {
            n = !0, i = t;
        } finally {
            try {
                !r && s.return && s.return();
            } finally {
                if (n) throw i;
            }
        }
        return a;
    }(t, e);
    throw new TypeError("Invalid attempt to destructure non-iterable instance");
}, _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

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

function _defineProperty(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

function _asyncToGenerator(t) {
    return function() {
        var s = t.apply(this, arguments);
        return new Promise(function(i, o) {
            return function e(t, a) {
                try {
                    var r = s[t](a), n = r.value;
                } catch (t) {
                    return void o(t);
                }
                if (!r.done) return Promise.resolve(n).then(function(t) {
                    e("next", t);
                }, function(t) {
                    e("throw", t);
                });
                i(n);
            }("next");
        });
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime, echarts = require("../../../../templates/ec-canvas/echarts");

Page({
    data: {
        tabList: [ {
            status: "toSetTab",
            name: "雷达能力图"
        }, {
            status: "toSetTab",
            name: "数据分析"
        }, {
            status: "toSetTab",
            name: "客户互动"
        }, {
            status: "toSetTab",
            name: "TA的跟进"
        } ],
        currentIndex: 0,
        scrollNav: "scrollNav0",
        setCount: [ "汇总", "昨天", "近7天", "近30天" ],
        count: 0,
        is_more: 1,
        nine: {
            new_client: 0,
            view_client: 0,
            mark_client: 0,
            chat_client: 0,
            sale_money: 0,
            sale_order: 0,
            share_count: 0,
            save_count: 0,
            thumbs_count: 0
        },
        dataList: [ {
            modelMethod: "getStaffView",
            param: {
                page: 1,
                staff_id: 0
            },
            list: {
                page: 1,
                total_page: 0,
                list: []
            }
        }, {
            modelMethod: "getStaffFollow",
            param: {
                page: 1,
                staff_id: 0
            },
            list: {
                page: 1,
                total_page: 0,
                list: []
            }
        } ],
        refresh: !1,
        loading: !0,
        curr_radar_record: [ {
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
        } ]
    },
    onLoad: function(p) {
        var _ = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, r, n, i, o, s, u, l, c, f, d;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return e = _, console.log(p, "options"), a = p.id, t.next = 5, getApp().getConfigInfo();

                  case 5:
                    return r = getApp().globalData, n = r.isIphoneX, i = r.userDefault, o = r.price_switch, 
                    (s = e.data.dataList)[0].param.staff_id = a, s[1].param.staff_id = a, e.setData({
                        price_switch: o,
                        staff_id: a,
                        dataList: s,
                        isIphoneX: n,
                        userDefault: i
                    }), t.next = 12, e.toGetStaffNumber();

                  case 12:
                    u = _xx_util2.default.getPage(-1).data, l = u.staff_ai_data, c = u.aiList, f = c.max, 
                    (d = l.info.name) || (d = l.nickName), wx.setNavigationBarTitle({
                        title: d + "员工"
                    }), e.setData({
                        staff_ai_data: l,
                        max: f
                    }, function() {
                        e.init_echart(l.value_2, 1);
                    });

                  case 18:
                  case "end":
                    return t.stop();
                }
            }, t, _);
        }))();
    },
    onPullDownRefresh: function() {
        var n = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, r;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    a = (e = n).data.currentIndex, wx.showNavigationBarLoading(), 0 == a ? e.toGetStaffNumber() : 1 == a ? e.setData({
                        is_more: 1
                    }, function() {
                        e.toGetStaffEchart();
                    }) : (r = "dataList[" + (1 * a - 2) + "].param.page", e.setData(_defineProperty({
                        refresh: !0
                    }, r, 1)), e.getList());

                  case 4:
                  case "end":
                    return t.stop();
                }
            }, t, n);
        }))();
    },
    onReachBottom: function() {
        var t = this, e = this.data, a = e.loading, r = e.dataList, n = e.currentIndex;
        if (1 < n) {
            var i = r[1 * n - 2].list, o = i.page;
            if (o != i.total_page && !a) {
                var s, u = "dataList[" + (1 * n - 2) + "].param.page";
                t.setData((_defineProperty(s = {}, u, o + 1), _defineProperty(s, "loading", !0), 
                s), function() {
                    t.getList();
                });
            }
        }
    },
    getList: function() {
        var x = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, r, n, i, o, s, u, l, c, f, d, p, _, m, g, h, v;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return r = (a = x).data, n = r.refresh, i = r.dataList, o = r.currentIndex, s = i[1 * o - 2], 
                    u = s.list, l = s.param, t.next = 5, _index.bossModel[i[1 * o - 2].modelMethod](l);

                  case 5:
                    for (p in c = t.sent, f = c.data, _xx_util2.default.hideAll(), n || (f.list = [].concat(_toConsumableArray(u.list), _toConsumableArray(f.list))), 
                    d = f.list) d[p].create_time && (d[p].create_time1 = _xx_util2.default.formatTime(1e3 * d[p].create_time, "YY/M/D"), 
                    d[p].create_time2 = _xx_util2.default.formatTime(1e3 * d[p].create_time, "h:m")), 
                    2 == o && (_ = d[p], m = _.sign, g = _.type, h = _.count, d[p].countText = "", "copy" == m && (d[p].countText = g < 4 || 11 == g ? "，请随时保持电话畅通" : 4 == g ? "，请随时查看微信通讯录" : 5 == g ? "，可能随时邮寄文件给你，请注意查收" : 10 == g ? "，请及时留意雷达动态" : ""), 
                    "order" == m && (d[p].countText = 1 == g || 2 == g ? "，详情请查看订单中心并发货" : ""), "praise" == m && (2 == g && (d[p].countText = h < 2 ? "，TA正在了解你" : 2 <= h && h < 5 ? "，你成功的吸引了TA" : "，高意向客户立刻主动沟通"), 
                    4 == g && (d[p].countText = "，请及时留意雷达动态")), "view" == m && (d[p].countText = 1 == g || 15 == g ? 1 == h ? "，请尽快把握商机" : 2 == h ? 1 == g ? "，潜在购买客户" : "，潜在预约客户" : 3 == h ? "，高意向客户立刻主动沟通" : 1 == g ? "，购买欲望强烈" : "，预约欲望强烈" : 3 == g || 6 == g ? 1 == h ? 3 == g ? "，看来TA对公司动态感兴趣" : "，看来TA对公司官网感兴趣" : 2 == h ? "，赶快主动沟通" : "，高意向客户成交在望" : 2 == g || 17 == g ? "，尽快把握商机" : 18 == g ? "，请尽快处理" : ""));
                    f.page = 1 * f.page, v = "dataList[" + (1 * o - 2) + "].list", a.setData((_defineProperty(e = {}, v, f), 
                    _defineProperty(e, "loading", !1), _defineProperty(e, "refresh", !1), e));

                  case 14:
                  case "end":
                    return t.stop();
                }
            }, t, x);
        }))();
    },
    toGetStaffNumber: function() {
        var o = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, r, n, i;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return e = o.data.staff_id, t.next = 3, Promise.all([ _index.userModel.getCardShow({
                        to_uid: e
                    }), _index.bossModel.getStaffNumber({
                        staff_id: e
                    }) ]);

                  case 3:
                    a = t.sent, r = _slicedToArray(a, 2), n = r[0], i = r[1], o.setData({
                        cardIndexData: n.data,
                        staff_info: i.data
                    });

                  case 8:
                  case "end":
                    return t.stop();
                }
            }, t, o);
        }))();
    },
    toGetStaffEchart: function() {
        var f = this, t = f.data, e = t.staff_id, d = t.is_more, a = t.count, r = {
            is_more: d,
            type: a,
            staff_id: e
        };
        1 == d && _xx_util2.default.showLoading(), _index.bossModel.getStaffEchart(r).then(function(t) {
            if (_xx_util2.default.hideAll(), 0 == d) {
                var e = t.data.nine;
                for (var a in e) e[a] || (e[a] = 0);
                f.setData({
                    nine: e
                });
            }
            if (1 == d) {
                var r = t.data, n = r.nine, i = r.dealRate, o = r.interest, s = r.activity, u = r.activityBarGraph, l = [ {
                    data: i,
                    type: 2
                }, {
                    data: o,
                    type: 3
                }, {
                    data: s,
                    type: 4
                }, {
                    data: u,
                    type: 5
                } ];
                for (var c in n) n[c] || (n[c] = 0);
                f.setData({
                    nine: n,
                    dealRate: i,
                    interest: o,
                    activity: s,
                    activityBarGraph: u,
                    tmpCountData: l
                }, function() {
                    for (var t in l) f.init_echart(l[t].data, l[t].type);
                });
            }
        });
    },
    init_echart: function(n, i) {
        var o = this;
        o.selectComponent("#mychart" + i).init(function(t, e, a) {
            var r = echarts.init(t, null, {
                width: e,
                height: a
            });
            return 1 == i ? r.setOption(o.geRadarOption(n)) : 2 == i ? r.setOption(o.getFunnelOption(n)) : 3 == i ? r.setOption(o.getPieOption(n, i)) : 4 == i ? r.setOption(o.getLineOption(n, i)) : 5 == i && r.setOption(o.getCategoryOption(n, i)), 
            r;
        });
    },
    getFunnelOption: function(t) {
        return {
            legend: {
                data: [ "总用户数" + t.client, "跟进数量" + t.mark_client, "成交数量" + t.deal_client ],
                bottom: "0"
            },
            color: [ "#91c7ae", "#d48265", "#c23531" ],
            calculable: !0,
            funnelAlign: "left",
            series: [ {
                name: "漏斗图",
                type: "funnel",
                top: "10",
                bottom: "45",
                left: "20%",
                min: 40,
                max: 100,
                minSize: "40%",
                maxSize: "100%",
                width: "60%",
                sort: "descending",
                legendHoverLink: !0,
                gap: 2,
                label: {
                    normal: {
                        show: !0,
                        position: "inside"
                    },
                    emphasis: {
                        textStyle: {
                            fontSize: 16
                        }
                    }
                },
                data: [ {
                    value: 100,
                    name: "总用户数" + t.client
                }, {
                    value: 80,
                    name: "跟进数量" + t.mark_client
                }, {
                    value: 60,
                    name: "成交数量" + t.deal_client
                } ]
            } ]
        };
    },
    getPieOption: function(t) {
        return {
            legend: {
                bottom: 0,
                left: "center",
                data: []
            },
            color: [ "#91c7ae", "#d48265", "#c23531" ],
            series: [ {
                name: "访问来源",
                type: "pie",
                radius: [ "60%", "80%" ],
                center: [ "50%", "60%" ],
                data: [ {
                    value: t.compony.number,
                    name: t.compony.rate + "%"
                }, {
                    value: t.staff.number,
                    name: t.staff.rate + "%"
                }, {
                    value: t.goods.number,
                    name: t.goods.rate + "%"
                } ]
            } ]
        };
    },
    getCategoryOption: function(t) {
        var e = [], a = [];
        for (var r in t) e.push(t[r].title), a.push(t[r].number);
        return {
            tooltip: {
                trigger: "axis",
                axisPointer: {
                    type: "shadow"
                }
            },
            color: [ "#91c7ae" ],
            legend: {
                data: [ "" ]
            },
            grid: {
                top: 20,
                left: "3%",
                right: "5%",
                bottom: "3%",
                containLabel: !0
            },
            xAxis: {
                type: "value",
                boundaryGap: [ 0, .01 ]
            },
            yAxis: [ {
                type: "category",
                data: e,
                axisLabel: {
                    interval: 0,
                    rotate: 0
                },
                splitLine: {
                    show: !1
                }
            } ],
            series: [ {
                type: "bar",
                label: {
                    normal: {
                        position: "right",
                        show: !0
                    }
                },
                data: a
            } ]
        };
    },
    geRadarOption: function(t) {
        var e = [], a = [], r = this.data.max;
        for (var n in t) e.push({
            text: t[n].titlle + t[n].value,
            max: parseFloat(r[n])
        }), a.push(parseFloat(t[n].value));
        return {
            legend: {
                x: "center",
                data: [ "" ]
            },
            radar: [ {
                indicator: e,
                center: [ "50%", "50%" ],
                radius: 80
            } ],
            series: [ {
                type: "radar",
                tooltip: {
                    trigger: "item"
                },
                itemStyle: {
                    normal: {
                        areaStyle: {
                            type: "default"
                        }
                    }
                },
                data: [ {
                    value: a
                } ]
            } ]
        };
    },
    getLineOption: function(t) {
        var e = [], a = [];
        for (var r in t) e.push(t[r].date), a.push(t[r].number);
        return {
            legend: {
                data: []
            },
            color: [ "#1774dc" ],
            grid: {
                top: "10",
                left: "3%",
                right: "5%",
                bottom: "10",
                containLabel: !0
            },
            xAxis: [ {
                type: "category",
                boundaryGap: !1,
                data: e
            } ],
            yAxis: [ {
                type: "value"
            } ],
            series: [ {
                name: "",
                type: "line",
                stack: "",
                areaStyle: {},
                data: a
            } ]
        };
    },
    toJump: function(t) {
        var e = this, a = _xx_util2.default.getData(t), r = a.status, n = a.index, i = a.type;
        if ("toJumpUrl" == r) if ("toCusDetail" == i) {
            var o = e.data.staff_ai_data.avatarUrl;
            o || (o = getApp().globalData.userDefault), getApp().globalData.avatarUrlStaff = o, 
            _xx_util2.default.goUrl(t);
        } else _xx_util2.default.goUrl(t); else "toCount" == r && e.setData({
            count: n,
            is_more: 0
        }, function() {
            e.toGetStaffEchart();
        });
    },
    toTabClick: function(t) {
        var r = this, n = _xx_util2.default.getData(t).index;
        r.setData({
            currentIndex: n,
            scrollNav: "scrollNav" + n
        }, function() {
            if (0 == n) {
                var t = r.data.staff_ai_data;
                r.init_echart(t.value_2, 1);
            } else if (1 == n) {
                var e = r.data.tmpCountData;
                if (e) for (var a in e) r.init_echart(e[a].data, e[a].type); else r.setData({
                    is_more: 1
                }, function() {
                    r.toGetStaffEchart();
                });
            } else this.onPullDownRefresh();
        });
    }
});