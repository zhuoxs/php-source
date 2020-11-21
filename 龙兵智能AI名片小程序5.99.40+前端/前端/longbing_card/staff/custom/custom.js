var _echarts = require("../../templates/ec-canvas/echarts"), echarts = _interopRequireWildcard(_echarts), _xx_util = require("../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../resource/apis/index.js");

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

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        Unchanged: [],
        avatarUrl: "",
        old: [],
        ec: {
            lazyLoad: !0
        },
        tabList: [ {
            status: "toSetTab",
            type: "customer",
            name: "新增客户"
        }, {
            status: "toSetTab",
            type: "follow",
            name: "跟进中"
        }, {
            status: "toSetTab",
            type: "deal",
            name: "已成交"
        } ],
        currentIndex: 0,
        currentTabBar: "customer",
        lists: [],
        pages: 1,
        total_page: "",
        typeindex: 1,
        echartslist: [],
        echartsdata: [ {
            value: "6",
            name: ""
        }, {
            value: "4",
            name: ""
        }, {
            value: "2",
            name: ""
        } ],
        Record: !1,
        Record_label: "0",
        Record_blur: "0",
        Record_input_value: "",
        Record_list: [],
        more: !0,
        loading: !1,
        show: !1,
        dataList: {
            page: 1,
            total_page: "",
            list: [],
            refresh: !1,
            loading: !0
        }
    },
    onLoad: function(t) {
        var i = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var a, e, r, n;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return a = i, _xx_util2.default.showLoading(), t.next = 4, getApp().getConfigInfo();

                  case 4:
                    e = getApp().globalData, r = e.isIphoneX, n = e.userDefault, a.setData({
                        isIphoneX: r,
                        userDefault: n,
                        curr_user_id: wx.getStorageSync("userid")
                    }), _index.staffModel.getStaffInfo().then(function(t) {
                        _xx_util2.default.hideAll();
                        var e = t.data.info.job_id;
                        a.setData({
                            job_id: e
                        });
                    }), a.getTurnoverRateTotal(), _xx_util2.default.hideAll();

                  case 9:
                  case "end":
                    return t.stop();
                }
            }, t, i);
        }))();
    },
    subscribe: function() {
        var a = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    e = wx.getStorageSync("userid"), getApp().websocket.sendMessage({
                        unread: !0,
                        user_id: e,
                        to_uid: e
                    }), getApp().websocket.subscribe("unread", a.getUserUnreadNum), getApp().websocket.subscribe("getMsg", a.getMsgUnreadNum);

                  case 4:
                  case "end":
                    return t.stop();
                }
            }, t, a);
        }))();
    },
    getUserUnreadNum: function(t) {
        var e = t.data, a = {
            user_count: e.user_count,
            staff_count: e.staff_count
        };
        getApp().getUnReadNum(a);
    },
    getMsgUnreadNum: function(t) {
        var e = {
            user_count: t.user_count,
            staff_count: t.staff_count
        };
        getApp().getUnReadNum(e);
    },
    onHide: function() {
        getApp().websocket.unSubscribe("unread"), getApp().websocket.unSubscribe("getMsg");
    },
    onUnload: function() {
        getApp().websocket.unSubscribe("unread"), getApp().websocket.unSubscribe("getMsg");
    },
    onShow: function() {
        var t = this;
        t.subscribe(), t.setData({
            "dataList.page": 1,
            "dataList.refresh": !0
        }), t.toGetClientList();
        var e = t.data.longType;
        if (e) {
            for (var a in e) e[a] = 0;
            t.setData({
                longType: e,
                touch_time: ""
            });
        }
    },
    onPullDownRefresh: function() {
        var t = this;
        t.setData({
            onPullDownRefresh: !0,
            "dataList.refresh": !0,
            "dataList.page": 1
        }, function() {
            t.toGetClientList(), t.getTurnoverRateTotal(), wx.showNavigationBarLoading();
        });
    },
    onReachBottom: function() {
        var t = this, e = t.data.dataList;
        e.page == e.total_page || e.loading || t.setData({
            "dataList.page": parseInt(e.page) + 1,
            "dataList.loading": !0
        }, function() {
            t.toGetClientList();
        });
    },
    onPageScroll: function(t) {
        var e = this.data.longType;
        for (var a in e) e[a] = 0;
        this.setData({
            longType: e
        });
    },
    getTurnoverRateTotal: function() {
        var s = this;
        _index.staffModel.getRateTotal().then(function(t) {
            if (_xx_util2.default.hideAll(), 0 == t.errno) {
                var e = t.data;
                1 == s.data.onPullDownRefresh && s.setData({
                    echartslist: [],
                    echartsdata: []
                });
                var a = s.data.echartslist, r = [];
                r.push(e.deals), r.push(e.follows), r.push(e.users);
                var n = [];
                n.push(60), n.push(80), n.push(100);
                var i = [ "成交数量:", "跟进数量:", "总用户数:" ];
                for (var o in i) a.push({
                    name: i[o] + r[o],
                    value: n[o]
                });
                s.setData({
                    echartsdata: a,
                    turnoverRateTotal: e
                }), s.barComponent = s.selectComponent("#mychart"), s.init_bar();
            }
        });
    },
    searchclick: function(t) {
        var e = wx.getStorageSync(this.data.job_id);
        e && this.setData({
            old: e
        }), this.setData({
            Record: !0
        });
        var a = this;
        _index.staffModel.getOftenLabel().then(function(t) {
            _xx_util2.default.hideAll(), a.setData({
                Unchanged: t.data
            });
        });
    },
    searchover: function(t) {
        this.setData({
            Record: !1,
            Record_label: "0",
            Record_blur: "0",
            Record_input_value: "",
            moreSearch: !0,
            isEmptySearch: !1,
            showSearch: !1
        });
    },
    Record_focuse: function(t) {
        this.setData({
            Record_label: "1",
            Record_list: []
        });
    },
    Record_blur: function(e) {
        if (e.detail.value) {
            var t = this.data.old;
            if (t[0]) {
                var a = !1;
                t.forEach(function(t) {
                    t == e.detail.value && (a = !0);
                }), a || (t.length < 3 ? t.push(e.detail.value) : (t.push(e.detail.value), t = t.slice(-3)));
            } else t.push(e.detail.value);
            wx.setStorageSync(this.data.job_id, t), this.setData({
                Record_input_value: e.detail.value,
                Record_blur: "1",
                Record_label: "1",
                old: t
            });
            var r = e.detail.value;
            this.toGetSearchList(r);
        } else this.setData({
            Record_label: "0",
            Record_list: []
        });
    },
    clickUnchanged: function(t) {
        this.setData({
            Record_input_value: t.currentTarget.dataset.name,
            Record_blur: "1",
            Record_label: "1"
        });
        var e = t.currentTarget.dataset.name;
        this.toGetSearchList(e);
    },
    toGetSearchList: function(t) {
        var r = this, e = {
            type: "1",
            keyword: t
        };
        _index.staffModel.getSearchList(e).then(function(t) {
            if (_xx_util2.default.hideAll(), 0 == t.errno) {
                var e = t.data;
                if (0 == e.length) return r.setData({
                    moreSearch: !1,
                    isEmptySearch: !0,
                    showSearch: !0
                }), !1;
                var a = r.data.Record_list;
                a = e.data, r.setData({
                    Record_list: a
                });
            }
        });
    },
    init_bar: function() {
        var n = this;
        this.barComponent.init(function(t, e, a) {
            var r = echarts.init(t, null, {
                width: e,
                height: a
            });
            return r.setOption(n.getBarOption()), r;
        });
    },
    getBarOption: function() {
        return {
            legend: {
                data: this.data.echartslist,
                top: "10"
            },
            color: [ "#91c7ae", "#d48265", "#c23531" ],
            calculable: !0,
            funnelAlign: "left",
            series: [ {
                name: "漏斗图",
                type: "funnel",
                top: "50",
                bottom: "20",
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
                            fontSize: 20
                        }
                    }
                },
                data: this.data.echartsdata.reverse()
            } ]
        };
    },
    toGetClientList: function() {
        var i = this, t = i.data, o = t.dataList, e = t.currentIndex, a = {
            page: o.page,
            type: 1 * e + 1
        };
        o.refresh || _xx_util2.default.showLoading(), _index.bossModel.getClientList(a).then(function(t) {
            _xx_util2.default.hideAll();
            var e = o, a = t.data;
            o.refresh || (a.list = [].concat(_toConsumableArray(e.list), _toConsumableArray(a.list)));
            var r = [];
            for (var n in a.list) r.push(0), a.list[n].last_time2 = _xx_util2.default.ctDate(1 * a.list[n].last_time), 
            -1 < a.list[n].share_str.indexOf("//XL:") && (a.list[n].clientSourceStr = a.list[n].share_str.split("//XL:"), 
            a.list[n].clientSourceType = "group");
            a.page = 1 * a.page, a.refresh = !1, a.loading = !1, i.setData({
                dataList: a,
                longType: r
            });
        });
    },
    mytouchstart: function(t) {
        var e = this, a = _xx_util2.default.getData(t), r = a.index, n = a.type, i = e.data.longType, o = void 0;
        for (var s in i) i[s] = 0;
        0 == n && (i[r] = 1, o = !0), setTimeout(function() {
            e.setData({
                longType: i,
                touch_type_time: o
            });
        }, 400), e.setData({
            touch_start: t.timeStamp
        });
    },
    mytouchend: function(t) {
        this.setData({
            touch_end: t.timeStamp
        });
    },
    longTap: function(t) {
        var e = _xx_util2.default.getData(t), a = e.index, r = e.type, n = this.data, i = n.touch_start, o = n.touch_end, s = n.longType, u = o - i, l = void 0;
        for (var c in s) s[c] = 0;
        500 < u ? this.setData({
            longTypeInd: a
        }) : (this.setData({
            longTypeInd: !1
        }), 1 == r ? (s[a] = 0, l = !1, this.setData({
            longType: s,
            touch_type_time: l
        })) : _xx_util2.default.goUrl(t));
    },
    catchAddMark: function(t) {
        _xx_util2.default.goUrl(t);
    },
    catchAddStar: function() {
        var a = this, t = a.data, r = t.longTypeInd, n = t.longType, i = t.dataList, e = {
            client_id: i.list[r].id
        };
        _index.staffModel.getStarMark(e).then(function(t) {
            for (var e in _xx_util2.default.hideAll(), n) n[e] = 0;
            1 == i.list[r].start ? i.list[r].start = 0 : i.list[r].start = 1, a.setData({
                dataList: i,
                longType: n,
                touch_time: !1,
                longTypeInd: !1
            });
        });
    },
    formSubmit: function(t) {
        var e = this, a = _xx_util2.default.getFormData(t), r = a.status, n = a.type, i = a.index;
        "toSetTab" == r && e.setData({
            currentIndex: i,
            currentTabBar: n,
            "dataList.page": 1,
            "dataList.refresh": !0,
            "dataList.loading": !0
        }, function() {
            e.toGetClientList();
        });
    }
});