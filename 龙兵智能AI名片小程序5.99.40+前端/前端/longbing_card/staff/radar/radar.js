var _slicedToArray = function(e, t) {
    if (Array.isArray(e)) return e;
    if (Symbol.iterator in Object(e)) return function(e, t) {
        var r = [], a = !0, n = !1, o = void 0;
        try {
            for (var i, u = e[Symbol.iterator](); !(a = (i = u.next()).done) && (r.push(i.value), 
            !t || r.length !== t); a = !0) ;
        } catch (e) {
            n = !0, o = e;
        } finally {
            try {
                !a && u.return && u.return();
            } finally {
                if (n) throw o;
            }
        }
        return r;
    }(e, t);
    throw new TypeError("Invalid attempt to destructure non-iterable instance");
}, _xx_util = require("../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../resource/apis/index.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

function _toConsumableArray(e) {
    if (Array.isArray(e)) {
        for (var t = 0, r = Array(e.length); t < e.length; t++) r[t] = e[t];
        return r;
    }
    return Array.from(e);
}

function _asyncToGenerator(e) {
    return function() {
        var u = e.apply(this, arguments);
        return new Promise(function(o, i) {
            return function t(e, r) {
                try {
                    var a = u[e](r), n = a.value;
                } catch (e) {
                    return void i(e);
                }
                if (!a.done) return Promise.resolve(n).then(function(e) {
                    t("next", e);
                }, function(e) {
                    t("throw", e);
                });
                o(n);
            }("next");
        });
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        tabList: [ {
            status: "time",
            name: "时间"
        }, {
            status: "behavior",
            name: "行为"
        } ],
        currentIndex: 0,
        scrollNav: "scrollNav0",
        setCount: [ {
            name: "近7天"
        }, {
            name: "近30天"
        } ],
        count: 0,
        dataList: {
            list: [],
            page: 0,
            total_page: 0
        },
        param: {
            page: 1
        },
        refresh: !1,
        loading: !0,
        windowHeight: "",
        show: !1,
        authStatus: !0,
        radarTime: "",
        tmpDDDDDDataLength: 0,
        behaviorInfo: [],
        behaviorList: [],
        globalData: {},
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
    onLoad: function(e) {
        var u = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, o, i;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return t = u, e.next = 3, getApp().getConfigInfo(!0);

                  case 3:
                    r = getApp().globalData, a = r.isIphoneX, n = r.userDefault, o = r.chatImg, i = (i = r.avatarUrl) || wx.getStorageSync("user").avatarUrl, 
                    t.setData({
                        windowHeight: wx.getSystemInfoSync().windowHeight,
                        isIphoneX: a,
                        userDefault: n,
                        chatImg: o,
                        avatarUrl: i,
                        curr_user_id: wx.getStorageSync("userid")
                    }), t.toGetStaffView(), _xx_util2.default.hideAll();

                  case 8:
                  case "end":
                    return e.stop();
                }
            }, e, u);
        }))();
    },
    subscribe: function() {
        var r = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    t = wx.getStorageSync("userid"), getApp().websocket.sendMessage({
                        unread: !0,
                        user_id: t,
                        to_uid: t
                    }), getApp().websocket.subscribe("unread", r.getUserUnreadNum), getApp().websocket.subscribe("getMsg", r.getMsgUnreadNum);

                  case 4:
                  case "end":
                    return e.stop();
                }
            }, e, r);
        }))();
    },
    getUserUnreadNum: function(e) {
        var t = e.data, r = {
            user_count: t.user_count,
            staff_count: t.staff_count
        };
        getApp().getUnReadNum(r);
    },
    getMsgUnreadNum: function(e) {
        var t = {
            user_count: e.user_count,
            staff_count: e.staff_count
        };
        getApp().getUnReadNum(t);
    },
    onShow: function() {
        this.subscribe();
    },
    onHide: function() {
        getApp().websocket.unSubscribe("unread"), getApp().websocket.unSubscribe("getMsg");
    },
    onUnload: function() {
        getApp().websocket.unSubscribe("unread"), getApp().websocket.unSubscribe("getMsg");
    },
    onPullDownRefresh: function() {
        var e = this, t = e.data.currentIndex;
        e.setData({
            refresh: !0,
            "param.page": 1
        }, function() {
            0 == t ? e.toGetStaffView() : e.getRadarByBehavior(), wx.showNavigationBarLoading(), 
            wx.stopPullDownRefresh(), _xx_util2.default.hideAll();
        });
    },
    onReachBottom: function() {
        var e = this.data, t = e.loading, r = e.dataList, a = e.currentIndex, n = r.page, o = r.total_page;
        if (n *= 1, 0 == a) {
            if (n == o || t) return;
            this.setData({
                "param.page": n + 1,
                loading: !0
            }), this.toGetStaffView();
        }
    },
    pickerSelected: function(e) {
        var t = this;
        "count" == e.currentTarget.dataset.status && t.setData({
            count: e.detail.value
        }, function() {
            t.getRadarByBehavior();
        });
    },
    toGetStaffView: function() {
        var h = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, o, i, u, s, c, l, f, d, g, p;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return r = (t = h).data, a = r.refresh, n = r.param, o = r.dataList, e.next = 4, 
                    _index.bossModel.getStaffView(n);

                  case 4:
                    for (l in i = e.sent, u = i.data, _xx_util2.default.hideAll(), s = o, a || (u.list = [].concat(_toConsumableArray(s.list), _toConsumableArray(u.list))), 
                    c = u.list) c[l].create_time && (c[l].create_time1 = _xx_util2.default.formatTime(1e3 * c[l].create_time, "YY/M/D"), 
                    c[l].create_time2 = _xx_util2.default.formatTime(1e3 * c[l].create_time, "h:m")), 
                    f = c[l], d = f.sign, g = f.type, p = f.count, c[l].countText = "", "copy" == d && (c[l].countText = g < 4 || 11 == g ? "，请随时保持电话畅通" : 4 == g ? "，请随时查看微信通讯录" : 5 == g ? "，可能随时邮寄文件给你，请注意查收" : 10 == g ? "，请及时留意雷达动态" : ""), 
                    "order" == d && (c[l].countText = 1 == g || 2 == g ? "，详情请查看订单中心并发货" : ""), "praise" == d && (2 == g && (c[l].countText = p < 2 ? "，TA正在了解你" : 2 <= p && p < 5 ? "，你成功的吸引了TA" : "，高意向客户立刻主动沟通"), 
                    4 == g && (c[l].countText = "，请及时留意雷达动态")), "view" == d && (c[l].countText = 1 == g || 15 == g ? 1 == p ? "，请尽快把握商机" : 2 == p ? 1 == g ? "，潜在购买客户" : "，潜在预约客户" : 3 == p ? "，高意向客户立刻主动沟通" : 1 == g ? "，购买欲望强烈" : "，预约欲望强烈" : 3 == g || 6 == g ? 1 == p ? 3 == g ? "，看来TA对公司动态感兴趣" : "，看来TA对公司官网感兴趣" : 2 == p ? "，赶快主动沟通" : "，高意向客户成交在望" : 2 == g || 17 == g ? "，尽快把握商机" : 18 == g ? "，请尽快处理" : "");
                    t.setData({
                        dataList: u,
                        loading: !1,
                        refresh: !1
                    });

                  case 12:
                  case "end":
                    return e.stop();
                }
            }, e, h);
        }))();
    },
    getRadarByBehavior: function() {
        var c = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, r, a, n, o, i, u, s;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    return r = (t = c).data.count, a = 1 * r + 1, n = getApp().siteInfo.uniacid, e.next = 6, 
                    Promise.all([ _index.staffModel.getAiHeader({
                        uniacid: n,
                        type: a
                    }), _index.staffModel.getAiOther({
                        type: a
                    }) ]);

                  case 6:
                    o = e.sent, i = _slicedToArray(o, 2), u = i[0], s = i[1], t.setData({
                        behaviorInfo: u.data,
                        behaviorList: s.data
                    });

                  case 11:
                  case "end":
                    return e.stop();
                }
            }, e, c);
        }))();
    },
    toChat: function(e) {
        var t = _xx_util2.default.getData(e).index, r = this.data, a = r.avatarUrl, n = r.dataList.list, o = n[t].user_id, i = n[t].user.nickName || "新客户", u = n[t].user.avatarUrl || userDefault, s = n[t].phone;
        wx.navigateTo({
            url: "/longbing_card/chat/staffChat/staffChat?chat_to_uid=" + o + "&contactUserName=" + i + "&chatAvatarUrl=" + a + "&toChatAvatarUrl=" + u + "&clientPhone=" + s
        });
    },
    toTabClick: function(e) {
        var t = _xx_util2.default.getData(e).index;
        wx.pageScrollTo({
            duration: 0,
            scrollTop: 0
        }), this.setData({
            currentIndex: t,
            scrollNav: "scrollNav" + t
        }), this.onPullDownRefresh();
    }
});