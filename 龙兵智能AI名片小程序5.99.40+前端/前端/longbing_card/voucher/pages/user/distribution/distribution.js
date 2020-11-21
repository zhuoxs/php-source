var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

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

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        type: 1,
        sort: 1,
        dataList: {
            page: 1,
            total_page: "",
            list: [],
            refresh: !1,
            loading: !0
        }
    },
    onLoad: function(t) {
        var a = this;
        wx.hideShareMenu(), getApp().getConfigInfo(!0).then(function() {
            a.setData({
                globalData: app.globalData,
                userid: wx.getStorageSync("userid")
            }, function() {
                a.toGetDistribution();
            });
        });
    },
    onPullDownRefresh: function() {
        var t = this;
        t.setData({
            "dataList.refresh": !0,
            "dataList.page": 1
        }, function() {
            wx.showNavigationBarLoading(), t.toGetDistribution();
        });
    },
    onReachBottom: function() {
        var t = this, a = t.data.dataList;
        a.page == a.total_page || a.loading || t.setData({
            "dataList.page": parseInt(a.page) + 1,
            "dataList.loading": !0
        }, function() {
            t.toGetDistribution();
        });
    },
    onShareAppMessage: function(t) {
        var a = this.data, e = a.dataList, i = a.globalData, r = t.target.dataset, o = r.index, s = r.id;
        if ("button" === t.from) {
            var n = "/longbing_card/pages/shop/detail/detail?id=" + s + "&to_uid=" + i.to_uid + "&from_id=" + wx.getStorageSync("userid");
            return console.log(n), {
                title: e.list[o].name,
                path: n,
                imageUrl: e.list[o].cover
            };
        }
    },
    toGetDistribution: function() {
        var r = this, t = r.data, o = t.dataList, a = t.type, e = t.sort, i = {
            page: o.page,
            type: a,
            desc: e
        };
        o.refresh || _xx_util2.default.showLoading(), _index.userModel.getDistribution(i).then(function(t) {
            _xx_util2.default.hideAll();
            var a = o, e = t.data;
            for (var i in o.refresh || (e.list = [].concat(_toConsumableArray(a.list), _toConsumableArray(e.list))), 
            e.list) e.list[i].shop_price = _xx_util2.default.getNormalPrice((e.list[i].price / 1e4).toFixed(4));
            e.page = e.page, e.refresh = !1, e.loading = !1, r.setData({
                dataList: e
            });
        });
    },
    toJump: function(t) {
        var a = this, e = _xx_util2.default.getData(t), i = e.status, r = e.index, o = e.type, s = e.sort;
        if ("toJumpUrl" == i) _xx_util2.default.goUrl(t); else if ("toShowShare" == i) a.setData({
            showShareStatus: 1,
            shareIndex: r
        }); else if ("toShareCard" == i) a.setData({
            showShareStatus: 0
        }); else if ("toRank" == i) {
            var n = 1;
            1 == s && (n = 2), a.setData({
                type: o,
                sort: n,
                "dataList.page": 1,
                "dataList.refresh": !0
            }, function() {
                a.toGetDistribution();
            });
        }
    }
});