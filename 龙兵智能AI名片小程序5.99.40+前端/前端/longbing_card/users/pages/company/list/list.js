var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

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

function _asyncToGenerator(t) {
    return function() {
        var u = t.apply(this, arguments);
        return new Promise(function(r, o) {
            return function e(t, a) {
                try {
                    var i = u[t](a), n = i.value;
                } catch (t) {
                    return void o(t);
                }
                if (!i.done) return Promise.resolve(n).then(function(t) {
                    e("next", t);
                }, function(t) {
                    e("throw", t);
                });
                r(n);
            }("next");
        });
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        dataList: {
            page: 1,
            total_page: "",
            list: []
        }
    },
    onLoad: function(_) {
        var m = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var e, a, i, n, r, o, u, s, l, d, g, f, p, c;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    return console.log(_, "options"), e = m, a = _.type, i = _.name, n = _.table_name, 
                    r = _.identification, o = _.to_uid, u = _.from_id, s = {
                        type: a,
                        name: i,
                        table_name: n,
                        identification: r,
                        to_uid: o,
                        from_id: u
                    }, i && wx.setNavigationBarTitle({
                        title: i
                    }), o && (getApp().globalData.to_uid = o), t.next = 8, getApp().getConfigInfo(!0);

                  case 8:
                    l = getApp().globalData, d = l.isIphoneX, g = l.bannerDefault, f = l.playVideoImg, 
                    p = l.companyVideoImg, c = l.configInfo, e.setData({
                        paramData: s,
                        isIphoneX: d,
                        bannerDefault: g,
                        playVideoImg: f,
                        companyVideoImg: p,
                        copyright: c.config
                    }), e.getListData();

                  case 11:
                  case "end":
                    return t.stop();
                }
            }, t, m);
        }))();
    },
    onPullDownRefresh: function() {
        var t = this;
        t.setData({
            "dataList.refresh": !0,
            "dataList.page": 1
        }, function() {
            wx.showNavigationBarLoading(), t.getListData();
        });
    },
    onReachBottom: function() {
        var t = this, e = t.data.dataList;
        e.page == e.total_page || e.loading || t.setData({
            "dataList.page": parseInt(e.page) + 1,
            "dataList.loading": !1
        }, function() {
            t.getListData();
        });
    },
    getListData: function() {
        var r = this, t = r.data, e = t.paramData, o = t.dataList, a = {
            page: o.page,
            identification: e.identification
        };
        o.refresh || _xx_util2.default.showLoading(), _index.userModel.getModularList(a).then(function(t) {
            _xx_util2.default.hideAll(), console.log("getModularList ==>", t.data);
            var e = o, a = t.data;
            o.refresh || (a.list = [].concat(_toConsumableArray(e.list), _toConsumableArray(a.list)));
            var i = a.list;
            for (var n in i) i[n].create_time && (i[n].create_time2 = _xx_util2.default.formatTime(1e3 * i[n].create_time, "YY-M-D"));
            r.setData({
                dataList: a,
                "viewList.page": o.page,
                "viewList.refresh": !1
            });
        });
    },
    toJump: function(t) {
        var e = _xx_util2.default.getData(t), a = e.id, i = e.status, n = e.content, r = e.shareimg, o = this.data.paramData, u = o.type, s = o.table_name, l = o.name, d = o.to_uid;
        if (d || (d = getApp().globalData.to_uid), "toCopyright" == i && _xx_util2.default.goUrl(t), 
        5 == u) return !1;
        7 == u ? (n = n + "&shareimg=" + encodeURIComponent(r) + "&to_uid=" + d, wx.navigateTo({
            url: n
        })) : wx.navigateTo({
            url: "/longbing_card/users/pages/company/detail/detail?id=" + a + "&table_name=" + s + "&name=" + l + "&type=" + u + "&to_uid=" + d
        });
    }
});