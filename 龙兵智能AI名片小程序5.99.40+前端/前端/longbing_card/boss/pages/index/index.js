var _xx_util = require("../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../resource/apis/index.js");

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

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime, echarts = require("../../../templates/ec-canvas/echarts");

Page({
    data: {
        radarList: [ "1", "2", "3", "4" ],
        tabBarList: [ {
            status: "toTabBar",
            type: "toOverview",
            name: "总览"
        }, {
            status: "toTabBar",
            type: "toRank",
            name: "销售排行"
        }, {
            status: "toTabBar",
            type: "toAnalysis",
            name: "AI分析"
        } ],
        currentTabBar: "toOverview",
        tabList: [],
        tmp_Index: [ {
            status: "toSetTab",
            name: "汇总"
        }, {
            status: "toSetTab",
            name: "昨天"
        }, {
            status: "toSetTab",
            name: "近7天"
        }, {
            status: "toSetTab",
            name: "近30天"
        } ],
        tmp_Rank: [ {
            status: "toSetTab",
            name: "客户人数"
        }, {
            status: "toSetTab",
            name: "订单量"
        }, {
            status: "toSetTab",
            name: "互动频率"
        }, {
            status: "toSetTab",
            name: "成交率区间"
        } ],
        currentIndex: 0,
        currentRank: 0,
        is_more: 1,
        setCount: [ "近7天", "近15天", "近30天" ],
        count1: 0,
        count2: 0,
        count3: 0,
        count4: 0,
        setRank1: [],
        setRank2: [],
        tmp_rank1: [ "客户总数", "新增客户" ],
        tmp_rank2: [ "总跟进数", "总成交数" ],
        tmp_rank3: [ "昨天", "近7天", "近15天", "近30天" ],
        tmp_rank4: [ "1%-50%", "50%-100%", "全部" ],
        rank1: [ 0, 3 ],
        rank2: 3,
        rank3: [ 0, 3 ],
        rank4: 2,
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
        dataList: {
            page: 1,
            total_page: "",
            total_count: "",
            list: []
        },
        aiList: {
            com: {},
            list: [],
            max: {},
            page: 1,
            total_page: ""
        },
        refresh: !1,
        refreshAI: !1,
        loading: !0,
        loadingAI: !0
    },
    onLoad: function(t) {
        _xx_util2.default.showLoading();
        var i = this, a = i.data, e = a.tmp_Index, n = a.tmp_Rank, o = a.tabList, r = a.currentTabBar, s = void 0;
        "toOverview" == r ? (o = e, s = "Boss雷达") : "toRank" == r ? (o = n, s = "销售排行") : "toAnalysis" == r && (s = "AI分析", 
        i.toGetAI()), wx.setNavigationBarTitle({
            title: s
        }), getApp().getConfigInfo().then(function() {
            _xx_util2.default.hideAll();
            var t = wx.getStorageSync("userid");
            t && (getApp().globalData.userid = t, getApp().globalData.to_uid = t);
            var a = getApp().globalData, e = a.isIphoneX, n = a.userDefault, r = a.to_uid;
            i.setData({
                tabList: o,
                isIphoneX: e,
                userDefault: n,
                this_to_uid: r
            }, function() {
                "toOverview" == i.data.currentTabBar && i.toGetOverview();
            });
        });
    },
    onPullDownRefresh: function() {
        var t = this, a = t.data, e = a.currentTabBar, n = a.currentRank;
        getApp().getConfigInfo(!0).then(function() {
            "toOverview" == e ? t.setData({
                is_more: 1
            }, function() {
                wx.showNavigationBarLoading(), t.toGetOverview();
            }) : "toRank" == e ? t.setData({
                refresh: !0,
                "dataList.page": 1
            }, function() {
                wx.showNavigationBarLoading(), 0 == n ? t.toGetRankClients() : 1 == n ? t.toGetRankOrder() : 2 == n ? t.toGetRankInteraction() : 3 == n && t.toGetRankRate();
            }) : "toAnalysis" == e && t.setData({
                refreshAI: !0,
                "aiList.page": 1
            }, function() {
                t.toGetAI();
            });
        });
    },
    onReachBottom: function() {
        var t = this, a = t.data, e = a.loading, n = a.currentTabBar, r = a.currentRank;
        if ("toRank" == n) {
            var i = t.data.dataList, o = i.page;
            o == i.total_page || e || t.setData({
                "dataList.page": parseInt(o) + 1,
                loading: !0
            }, function() {
                0 == r ? t.toGetRankClients() : 1 == r ? t.toGetRankOrder() : 2 == r ? t.toGetRankInteraction() : 3 == r && t.toGetRankRate();
            });
        } else if ("toAnalysis" == n) {
            var s = t.data.loadingAI, l = t.data.aiList, u = l.page;
            u == l.total_page || s || t.setData({
                "aiList.page": parseInt(u) + 1,
                loadingAI: !0
            }, function() {
                t.toGetAI();
            });
        }
    },
    toGetOverview: function() {
        var _ = this, t = _.data, m = t.is_more, a = t.currentIndex, e = {
            is_more: m,
            type: a
        };
        1 == m && _xx_util2.default.showLoading(), _index.bossModel.getOverview(e).then(function(t) {
            if (_xx_util2.default.hideAll(), 0 == m) {
                var a = t.data.nine;
                for (var e in a) a[e] || (a[e] = 0);
                _.setData({
                    nine: a
                });
            }
            if (1 == m) {
                var n = t.data, r = n.nine, i = n.dealRate, o = n.orderMoney, s = n.newClient, l = n.askClient, u = n.markClient, d = n.interest, c = n.activity, p = n.activityBarGraph, f = [ {
                    data: i,
                    type: 1
                }, {
                    data: o,
                    type: 2
                }, {
                    data: s,
                    type: 3
                }, {
                    data: l,
                    type: 4
                }, {
                    data: u,
                    type: 5
                }, {
                    data: d,
                    type: 6
                }, {
                    data: c,
                    type: 7
                }, {
                    data: p,
                    type: 8
                } ];
                for (var g in r) r[g] || (r[g] = 0);
                _.setData({
                    nine: r,
                    dealRate: i,
                    orderMoney: o,
                    newClient: s,
                    askClient: l,
                    markClient: u,
                    interest: d,
                    activity: c,
                    activityBarGraph: p,
                    tmpCountData: f
                }, function() {
                    for (var t in f) _.init_echart(f[t].data, f[t].type);
                });
            }
        });
    },
    toGetRankClients: function() {
        var n = this, t = n.data, a = t.rank1, r = t.refresh, i = t.dataList, e = {
            page: i.page,
            sign: 1 * a[0] + 1,
            type: 1 * a[1] + 1
        };
        r || _xx_util2.default.showLoading(), _index.bossModel.getRankClients(e).then(function(t) {
            _xx_util2.default.hideAll();
            var a = i, e = t.data;
            r || (e.list = [].concat(_toConsumableArray(a.list), _toConsumableArray(e.list))), 
            n.setData({
                dataList: e,
                refresh: !1,
                loading: !1
            });
        });
    },
    toGetRankOrder: function() {
        var n = this, t = n.data, a = t.rank2, r = t.refresh, i = t.dataList, e = {
            page: i.page,
            type: 1 * a + 1
        };
        _index.bossModel.getRankOrder(e).then(function(t) {
            _xx_util2.default.hideAll();
            var a = i, e = t.data;
            r || (e.list = [].concat(_toConsumableArray(a.list), _toConsumableArray(e.list))), 
            n.setData({
                dataList: e,
                refresh: !1,
                loading: !1
            });
        });
    },
    toGetRankInteraction: function() {
        var n = this, t = n.data, a = t.rank3, r = t.refresh, i = t.dataList, e = {
            page: i.page,
            sign: 1 * a[0] + 1,
            type: 1 * a[1] + 1
        };
        _index.bossModel.getRankInteraction(e).then(function(t) {
            _xx_util2.default.hideAll();
            var a = i, e = t.data;
            r || (e.list = [].concat(_toConsumableArray(a.list), _toConsumableArray(e.list))), 
            n.setData({
                dataList: e,
                refresh: !1,
                loading: !1
            });
        });
    },
    toGetRankRate: function() {
        var n = this, t = n.data, a = t.rank4, r = t.refresh, i = t.dataList, e = {
            page: i.page,
            type: 1 * a + 1
        };
        _index.bossModel.getRankRate(e).then(function(t) {
            _xx_util2.default.hideAll();
            var a = i, e = t.data;
            r || (e.list = [].concat(_toConsumableArray(a.list), _toConsumableArray(e.list))), 
            n.setData({
                dataList: e,
                refresh: !1,
                loading: !1
            });
        });
    },
    toGetAI: function() {
        var i = this, t = i.data, n = t.refreshAI, r = t.aiList, a = {
            page: r.page
        };
        _index.bossModel.getAi(a).then(function(t) {
            _xx_util2.default.hideAll();
            var a = r, e = t.data;
            n || (e.com = [].concat(_toConsumableArray(a.com), _toConsumableArray(e.com)), e.list = [].concat(_toConsumableArray(a.list), _toConsumableArray(e.list)), 
            e.max = [].concat(_toConsumableArray(a.max), _toConsumableArray(e.max))), e.page = 1 * e.page, 
            i.setData({
                aiList: e,
                refreshAI: !1,
                loadingAI: !1,
                "aiList.page": r.page
            }, function() {
                var t = i.data.aiList, a = t.page, e = t.list;
                if (1 * a == 1) {
                    var n = [ e[0], e[1], e[2] ];
                    for (var r in n) i.init_echart(n[r].value_2, 9 + 1 * r);
                }
            });
        });
    },
    pickerSelected: function(t) {
        var a = this, e = _xx_util2.default.getData(t).status, n = t.detail.value, r = a.data, i = r.rank1, o = r.rank2, s = r.rank3, l = r.rank4, u = r.currentRank;
        0 == u ? ("toRank1" == e && (i[0] = n), "toRank2" == e && (i[1] = n), a.setData({
            rank1: i,
            dataList: {
                page: 1,
                total_page: "",
                total_count: "",
                list: []
            }
        }, function() {
            a.toGetRankClients();
        })) : 1 == u ? "toRank3" == e && (o = n, a.setData({
            rank2: o,
            dataList: {
                page: 1,
                total_page: "",
                total_count: "",
                list: []
            }
        }, function() {
            a.toGetRankOrder();
        })) : 2 == u ? ("toRank1" == e && (s[0] = n), "toRank2" == e && (s[1] = n), a.setData({
            rank3: s,
            dataList: {
                page: 1,
                total_page: "",
                total_count: "",
                list: []
            }
        }, function() {
            a.toGetRankInteraction();
        })) : 3 == u && "toRank3" == e && (l = n, a.setData({
            rank4: l,
            dataList: {
                page: 1,
                total_page: "",
                total_count: "",
                list: []
            }
        }, function() {
            a.toGetRankRate();
        }));
    },
    init_echart: function(r, i) {
        var o = this;
        o.selectComponent("#mychart" + i).init(function(t, a, e) {
            var n = echarts.init(t, null, {
                width: a,
                height: e
            });
            return 1 == i ? n.setOption(o.getFunnelOption(r)) : 6 == i ? n.setOption(o.getPieOption(r, i)) : 8 == i ? n.setOption(o.getCategoryOption(r, i)) : 9 <= i ? n.setOption(o.getRadarOption(r, i)) : n.setOption(o.getLineOption(r, i)), 
            n;
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
        var a = [], e = [];
        for (var n in t) a.push(t[n].title), e.push(t[n].number);
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
                data: a,
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
                data: e
            } ]
        };
    },
    getRadarOption: function(t, a) {
        var e = [], n = [], r = this.data.aiList.max, i = 50;
        for (var o in 9 == a && (i = 80), 10 != a && 11 != a || (i = 65), t) 9 < a ? e.push({
            text: "",
            max: parseFloat(r[o])
        }) : e.push({
            text: t[o].titlle + t[o].value,
            max: parseFloat(r[o])
        }), n.push(parseFloat(t[o].value));
        return {
            legend: {
                x: "center",
                data: [ "" ]
            },
            radar: [ {
                indicator: e,
                center: [ "50%", "50%" ],
                radius: i
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
                    value: n
                } ]
            } ]
        };
    },
    getLineOption: function(t, a) {
        var e = [], n = [], r = [], i = [];
        for (var o in t) e.push(t[o].date), 2 == a ? (n.push(t[o].order_number), r.push(t[o].money_number)) : i.push(t[o].number);
        return 2 == a ? {
            legend: {
                data: [ "商城订单量", "交易金额" ]
            },
            color: [ "#1774dc", "#e93636" ],
            grid: {
                top: "40",
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
                name: "商城订单量",
                type: "line",
                stack: "",
                areaStyle: {},
                data: n
            }, {
                name: "交易金额",
                type: "line",
                stack: "",
                areaStyle: {},
                data: r
            } ]
        } : {
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
                data: i
            } ]
        };
    },
    toJump: function(t) {
        var a = this, e = _xx_util2.default.getData(t), n = e.status, r = e.index, i = e.type, o = e.avatar, s = a.data, l = s.orderMoney, u = s.newClient, d = s.askClient, c = s.markClient, p = [], f = void 0, g = a.data, _ = g.rank1, m = g.rank2, k = g.rank3, v = g.rank4, h = g.currentRank;
        if ("toChangeRank" == n) a.setData({
            refresh: !0,
            "dataList.page": 1
        }), 0 == h ? ("toRank1" == i && (_[0] = r), "toRank2" == i && (_[1] = r), a.setData({
            rank1: _
        }, function() {
            a.toGetRankClients();
        })) : 1 == h ? "toRank1" == i && (m = r, a.setData({
            rank2: m
        }, function() {
            a.toGetRankOrder();
        })) : 2 == h ? ("toRank1" == i && (k[0] = r), "toRank2" == i && (k[1] = r), a.setData({
            rank3: k
        }, function() {
            a.toGetRankInteraction();
        })) : 3 == h && "toRank1" == i && (v = r, a.setData({
            rank4: v
        }, function() {
            a.toGetRankRate();
        })); else if ("toCount1" == n || "toCount2" == n || "toCount3" == n || "toCount4" == n) {
            0 == r ? f = 23 : 1 == r ? f = 15 : 2 == r && (f = 0), "toCount1" == n && a.setData({
                count1: r
            }), "toCount2" == n && a.setData({
                count2: r
            }), "toCount3" == n && a.setData({
                count3: r
            }), "toCount4" == n && a.setData({
                count4: r
            });
            for (var x = f; x < 30; x++) 2 == i && p.push(l[x]), 3 == i && p.push(u[x]), 4 == i && p.push(d[x]), 
            5 == i && p.push(c[x]);
            a.init_echart(p, i);
        } else if ("toJumpUrl" == n) if ("currStaff" == i) {
            var y = a.data.aiList.list[r];
            y.rank = 1 * r + 1, a.setData({
                staff_ai_data: y
            }, function() {
                _xx_util2.default.goUrl(t);
            });
        } else "toAvatar" == i && wx.setStorageSync("toAvatar", o), _xx_util2.default.goUrl(t);
    },
    formSubmit: function(t) {
        var e = this, a = t.detail.formId, n = _xx_util2.default.getFormData(t), r = n.status, i = n.index, o = n.type, s = e.data.currentTabBar;
        if ("toSetTab" == r) {
            if ("toOverview" == s) e.setData({
                currentIndex: i,
                is_more: 0
            }, function() {
                e.toGetOverview();
            }); else if ("toRank" == s) {
                var l = e.data, u = l.setRank1, d = l.setRank2, c = l.tmp_rank1, p = l.tmp_rank2, f = l.tmp_rank3, g = l.tmp_rank4;
                0 == i ? u = [ c, f ] : 1 == i ? d = f : 2 == i ? u = [ p, f ] : 3 == i && (d = g), 
                e.setData({
                    currentRank: i,
                    setRank1: u,
                    setRank2: d,
                    refresh: !0,
                    "dataList.page": 1
                }, function() {
                    var t = e.data.currentRank;
                    0 == t && e.toGetRankClients(), 1 == t && e.toGetRankOrder(), 2 == t && e.toGetRankInteraction(), 
                    3 == t && e.toGetRankRate();
                });
            }
        } else if ("toTabBar" == r) {
            var _ = e.data, m = _.is_more, k = _.tmp_Index, v = _.tmp_Rank, h = _.tabList, x = _.currentTabBar, y = void 0;
            if (y = "Boss雷达", "toOverview" == (x = o) && (h = k, m = 0, e.setData({
                tabList: h,
                is_more: m,
                currentTabBar: x
            }, function() {
                if ("toOverview" == e.data.currentTabBar) {
                    var t = e.data.tmpCountData;
                    if (t) for (var a in t) e.init_echart(t[a].data, t[a].type); else e.setData({
                        is_more: 1
                    }, function() {
                        e.toGetOverview();
                    });
                }
            })), "toRank" == o) {
                y = "销售排行";
                var R = e.data, b = R.setRank1, A = R.setRank2, L = R.tmp_rank1, C = R.tmp_rank2, D = R.tmp_rank3, G = R.tmp_rank4, I = R.currentRank;
                0 == I ? b = [ L, D ] : 1 == I ? A = D : 2 == I ? b = [ C, D ] : 1 == I && (A = G), 
                h = v, e.setData({
                    currentTabBar: x,
                    tabList: h,
                    setRank1: b,
                    setRank2: A,
                    refresh: !0,
                    "dataList.page": 1
                }, function() {
                    0 == I ? e.toGetRankClients() : 1 == I ? e.toGetRankOrder() : 2 == I ? e.toGetRankInteraction() : 3 == I && e.toGetRankRate();
                });
            } else "toAnalysis" == x && (y = "AI分析", e.setData({
                currentTabBar: x,
                refreshAI: !0,
                "aiList.page": 1
            }, function() {
                e.toGetAI();
            }));
            wx.setNavigationBarTitle({
                title: y
            });
        } else "toJumpUrl" == r && _xx_util2.default.goUrl(t, !0);
        _index.bossModel.getFormId({
            formId: a
        });
    }
});