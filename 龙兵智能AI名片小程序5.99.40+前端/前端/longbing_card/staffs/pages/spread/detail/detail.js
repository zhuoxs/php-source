var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

function _asyncToGenerator(e) {
    return function() {
        var u = e.apply(this, arguments);
        return new Promise(function(o, r) {
            return function t(e, a) {
                try {
                    var n = u[e](a), i = n.value;
                } catch (e) {
                    return void r(e);
                }
                if (!n.done) return Promise.resolve(i).then(function(e) {
                    t("next", e);
                }, function(e) {
                    t("throw", e);
                });
                o(i);
            }("next");
        });
    };
}

var app = getApp(), echarts = require("../../../../templates/ec-canvas/echarts"), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        setCount: [ {
            name: "今日"
        }, {
            name: "近7天"
        }, {
            name: "近30天"
        }, {
            name: "本月"
        } ],
        count: 2,
        classify: 2,
        interaction: 2,
        opengid: "",
        orderType: "time",
        showAddUseSec: !1,
        groupPeople: {},
        groupRandData: [],
        setFunnelOption: {
            legend: [],
            data: []
        },
        setPieOption: {
            legend: [],
            data: []
        }
    },
    onLoad: function(o) {
        var r = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, a, n, i;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return _xx_util2.default.showLoading(), t = r, wx.hideShareMenu(), o.opengid && t.setData({
                        opengid: o.opengid
                    }), e.next = 6, getApp().getConfigInfo(!0);

                  case 6:
                    a = getApp().globalData, n = a.isIphoneX, i = a.userDefault, a.configInfo, t.setData({
                        isIphoneX: n,
                        userDefault: i
                    }), wx.hideShareMenu(), t.getGroupPeople(), t.getTurnoverRate(), t.getInteraction(), 
                    t.getGroupRank(), t.barComponent = t.selectComponent("#mychart"), t.barComponent2 = t.selectComponent("#mychart2"), 
                    _xx_util2.default.hideAll();

                  case 16:
                  case "end":
                    return e.stop();
                }
            }, e, r);
        }))();
    },
    onPullDownRefresh: function() {
        var e = this;
        wx.showNavigationBarLoading(), wx.showNavigationBarLoading(), e.getGroupPeople(), 
        e.getTurnoverRate(), e.getInteraction(), e.getGroupRank();
    },
    pickerSelected: function(e) {
        var t = this, a = e.currentTarget.dataset.status;
        "count" == a ? (t.setData({
            count: e.detail.value
        }), t.getTurnoverRate()) : "classify" == a ? (t.setData({
            classify: e.detail.value
        }), t.getInteraction()) : "interaction" == a && (t.setData({
            interaction: e.detail.value
        }), t.getGroupRank());
    },
    toJump: function(e) {
        var t = _xx_util2.default.getData(e).status;
        "toCopyright" != t && "toEditNum" != t || _xx_util2.default.goUrl(e);
    },
    checkOrderType: function(e) {
        var t = e.currentTarget.dataset.status;
        this.setData({
            orderType: t
        }), this.getGroupRank();
    },
    getGroupPeople: function() {
        var o = this;
        _index.staffModel.getGroupPeople({
            openGId: o.data.opengid
        }).then(function(e) {
            _xx_util2.default.hideAll();
            var t = e.data, a = (new Date().getTime() / 1e3).toFixed(0);
            if (t.last_time = parseInt(t.last_time), t.last_time) {
                t.last_time = a - t.last_time;
                var n = parseInt(t.last_time / 86400), i = parseInt(t.last_time / 3600);
                0 < n ? (t.last_time = n, t.last_time_text = "天前互动") : 0 < i ? (t.last_time = i, 
                t.last_time_text = "小时前互动") : (t.last_time = "", t.last_time_text = "暂无互动");
            } else t.last_time = "", t.last_time_text = "暂无互动";
            o.setData({
                groupPeople: t
            });
        });
    },
    getTurnoverRate: function() {
        var a = this, e = {
            openGId: a.data.opengid,
            type: 1 * a.data.count + 1
        };
        _index.staffModel.getTurnoverRate(e).then(function(e) {
            _xx_util2.default.hideAll();
            var t = e.data;
            a.setData({
                setFunnelOption: t
            }), a.init_funnel();
        });
    },
    getInteraction: function() {
        var n = this, e = {
            openGId: n.data.opengid,
            type: 1 * n.data.classify + 1
        };
        _index.staffModel.getInteraction(e).then(function(e) {
            _xx_util2.default.hideAll();
            var t = e.data, a = {
                legend: [],
                data: []
            };
            0 != t.goods.count && (a.legend.push("产品" + t.goods.count + "(" + t.goods.rate + "%)"), 
            a.data.push({
                value: t.goods.rate,
                name: "产品" + t.goods.count + "(" + t.goods.rate + "%)"
            })), 0 != t.timeline.count && (a.legend.push("动态" + t.timeline.count + "(" + t.timeline.rate + "%)"), 
            a.data.push({
                value: t.timeline.rate,
                name: "动态" + t.timeline.count + "(" + t.timeline.rate + "%)"
            })), 0 != t.card.count && (a.legend.push("名片" + t.card.count + "(" + t.card.rate + "%)"), 
            a.data.push({
                value: t.card.rate,
                name: "名片" + t.card.count + "(" + t.card.rate + "%)"
            })), 0 != t.qr.count && (a.legend.push("名片码" + t.qr.count + "(" + t.qr.rate + "%)"), 
            a.data.push({
                value: t.qr.rate,
                name: "名片码" + t.qr.count + "(" + t.qr.rate + "%)"
            })), 0 != t.custom_qr.count && (a.legend.push("自定义码" + t.custom_qr.count + "(" + t.custom_qr.rate + "%)"), 
            a.data.push({
                value: t.custom_qr.rate,
                name: "自定义码" + t.goods.count + "(" + t.custom_qr.rate + "%)"
            })), 0 == a.legend.length && (a.legend.push("暂无互动数据"), a.data.push({
                value: 100,
                name: "暂无互动数据"
            })), n.setData({
                setPieOption: a
            }), n.init_pie();
        });
    },
    getGroupRank: function() {
        var r = this, e = {
            type: 1 * r.data.interaction + 1,
            order: r.data.orderType,
            openGId: r.data.opengid
        };
        _index.staffModel.getGroupRank(e).then(function(e) {
            _xx_util2.default.hideAll();
            var t = e.data, a = (new Date().getTime() / 1e3).toFixed(0);
            for (var n in t) if (t[n].update_time) {
                t[n].update_time = a - t[n].update_time;
                var i = parseInt(t[n].update_time / 86400), o = parseInt(t[n].update_time / 3600);
                t[n].update_time = 0 < i ? i + "天前互动" : 0 < o ? o + "小时前互动" : "";
            } else t[n].update_time = "";
            r.setData({
                groupRandData: t
            }), r.init_funnel();
        });
    },
    init_funnel: function() {
        var i = this;
        i.barComponent.init(function(e, t, a) {
            var n = echarts.init(e, null, {
                width: t,
                height: a
            });
            return n.setOption(i.getFunnelOption()), n;
        });
    },
    init_pie: function() {
        var i = this;
        i.barComponent2.init(function(e, t, a) {
            var n = echarts.init(e, null, {
                width: t,
                height: a
            });
            return n.setOption(i.getPieOption()), n;
        });
    },
    getFunnelOption: function() {
        var e = this;
        return {
            backgroundColor: "#ffffff",
            color: [ "#37a2da", "#32c4e9", "#66e0e3", "#91f2de", "#fedb5b" ],
            calculable: !0,
            series: [ {
                name: "推广统计",
                type: "funnel",
                left: "10%",
                top: 20,
                bottom: 40,
                width: "60%",
                height: "80%",
                min: 20,
                max: 100,
                minSize: "20%",
                maxSize: "100%",
                sort: "descending",
                gap: 2,
                data: [ {
                    value: 100,
                    name: "群成员数" + e.data.setFunnelOption.number
                }, {
                    value: 80,
                    name: "引流人数" + e.data.setFunnelOption.users
                }, {
                    value: 60,
                    name: "咨询人数" + e.data.setFunnelOption.chats
                }, {
                    value: 40,
                    name: "跟进人数" + e.data.setFunnelOption.follows
                }, {
                    value: 20,
                    name: "成交人数" + e.data.setFunnelOption.deals
                } ]
            } ]
        };
    },
    getPieOption: function() {
        return {
            legend: {
                orient: "vertical",
                top: "10%",
                right: "10%",
                data: this.data.setPieOption.legend
            },
            series: [ {
                name: "互动分类",
                type: "pie",
                center: [ "30%", "47%" ],
                radius: [ "55%", "75%" ],
                avoidLabelOverlap: !1,
                label: {
                    normal: {
                        show: !1,
                        position: "center"
                    }
                },
                data: this.data.setPieOption.data
            } ]
        };
    }
});