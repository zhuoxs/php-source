var _xx_util = require("../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

function _asyncToGenerator(t) {
    return function() {
        var o = t.apply(this, arguments);
        return new Promise(function(i, s) {
            return function e(t, a) {
                try {
                    var n = o[t](a), r = n.value;
                } catch (t) {
                    return void s(t);
                }
                if (!n.done) return Promise.resolve(r).then(function(t) {
                    e("next", t);
                }, function(t) {
                    e("throw", t);
                });
                i(r);
            }("next");
        });
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

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
        countList: {},
        globalData: {},
        staffInfo: {},
        staffCard: {},
        qrImg: ""
    },
    onLoad: function(t) {
        var n = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return _xx_util2.default.showLoading(), (e = n).getStaffInfo(), e.getCardIndexData(), 
                    t.next = 6, getApp().getConfigInfo(!0);

                  case 6:
                    _xx_util2.default.hideAll(), a = getApp().globalData.isIphoneX, e.setData({
                        isIphoneX: a
                    });

                  case 9:
                  case "end":
                    return t.stop();
                }
            }, t, n);
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
        this.subscribe(), this.toGetCount();
    },
    onPullDownRefresh: function() {
        var a = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    e = a, wx.showNavigationBarLoading(), e.getStaffInfo(), e.getCardIndexData();

                  case 4:
                  case "end":
                    return t.stop();
                }
            }, t, a);
        }))();
    },
    onShareAppMessage: function(t) {
        var e = this.data.cardIndexData;
        if ("button" === t.from) {
            var a = e.share_img;
            return a && "cardType1" != e.info.card_type && "cardType4" != e.info.card_type || (a = e.info.avatar_2), 
            {
                title: e.info.share_text,
                path: "/longbing_card/pages/index/index?to_uid=" + wx.getStorageSync("userid") + "&from_id=" + wx.getStorageSync("userid") + "&currentTabBar=toCard",
                imageUrl: a
            };
        }
    },
    pickerSelected: function(t) {
        "count" == t.currentTarget.dataset.status && (this.setData({
            count: t.detail.value
        }), this.setData({
            countList: {}
        }), this.toGetCount());
    },
    getStaffInfo: function() {
        var e = this;
        _index.staffModel.getStaffInfo().then(function(t) {
            _xx_util2.default.hideAll(), e.setData({
                staffInfo: t.data
            }, function() {
                e.getStaffCard();
            });
        });
    },
    getStaffCard: function() {
        var e = this;
        _index.staffModel.getStaffCardInfo().then(function(t) {
            _xx_util2.default.hideAll(), e.setData({
                StaffCard: t.data.count
            });
        });
    },
    getCardIndexData: function() {
        var a = this;
        _xx_util2.default.showLoading();
        var t = {
            to_uid: wx.getStorageSync("userid")
        };
        _index.userModel.getCardShow(t).then(function(t) {
            _xx_util2.default.hideAll();
            var e = t.data;
            a.setData({
                cardIndexData: e
            });
        });
    },
    toGetCount: function() {
        var c = this;
        _index.staffModel.getExtStatistics({
            type: 1 * c.data.count + 1
        }).then(function(t) {
            _xx_util2.default.hideAll();
            var e = t.data, a = (new Date().getTime() / 1e3).toFixed(0);
            if (e.extension.count || (e.extension.count = 0), e.timeline.count || (e.timeline.count = 0), 
            e.card.count || (e.card.count = 0), e.extension.last_time = parseInt(e.extension.last_time), 
            e.extension.last_time) {
                e.extension.last_time = a - e.extension.last_time;
                var n = parseInt(e.extension.last_time / 86400), r = parseInt(e.extension.last_time / 3600);
                e.extension.last_time = 0 < n ? n + "天前互动" : 0 < r ? r + "小时前互动" : "";
            } else e.extension.last_time = "";
            if (e.timeline.last_time = parseInt(e.timeline.last_time), e.timeline.last_time) {
                e.timeline.last_time = a - e.timeline.last_time;
                var i = parseInt(e.timeline.last_time / 86400), s = parseInt(e.timeline.last_time / 3600);
                e.timeline.last_time = 0 < i ? i + "天前互动" : 0 < s ? s + "小时前互动" : "";
            } else e.timeline.last_time = "";
            if (e.card.last_time = parseInt(e.card.last_time), e.card.last_time) {
                e.card.last_time = a - e.card.last_time;
                var o = parseInt(e.card.last_time / 86400), u = parseInt(e.card.last_time / 3600);
                e.card.last_time = 0 < o ? o + "天前互动" : 0 < u ? u + "小时前互动" : "";
            } else e.card.last_time = "";
            c.setData({
                countList: e
            });
        });
    },
    formSubmit: function(t) {
        var e = _xx_util2.default.getFormData(t), a = e.status, n = (e.index, e.type);
        "toSpread" == a ? "toProduct" == n ? wx.navigateTo({
            url: "/longbing_card/staffs/pages/spread/product/product"
        }) : "toNews" == n ? wx.navigateTo({
            url: "/longbing_card/staffs/pages/spread/news/news?status=news"
        }) : "toCard" == n || ("toEwm" == n ? wx.navigateTo({
            url: "/longbing_card/users/pages/card/share/share"
        }) : "toCode" == n && wx.navigateTo({
            url: "/longbing_card/staffs/pages/spread/news/news?status=code"
        })) : "toHome" == a && wx.reLaunch({
            url: "/longbing_card/pages/index/index?to_uid=" + wx.getStorageSync("userid") + "&from_id=" + wx.getStorageSync("userid") + "&currentTabBar=toCard"
        });
    },
    toJump: function(t) {
        var e = _xx_util2.default.getData(t), a = (e.status, e.type);
        "toSprdadDetail" && 3 != a && wx.navigateTo({
            url: "/longbing_card/staffs/pages/spread/spread/spread?type=" + a
        });
    }
});