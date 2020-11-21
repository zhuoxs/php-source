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
        console.log(t, "options");
        var n = t.id, r = t.status;
        getApp().getConfigInfo().then(function() {
            var t = getApp().globalData, a = t.userDefault, e = t.isIphoneX;
            i.setData({
                id: n,
                avatarUrl: wx.getStorageSync("toAvatar"),
                status: r,
                userDefault: a,
                isIphoneX: e
            }, function() {
                i.toGetClientList();
            });
        });
    },
    onHide: function() {
        wx.setStorageSync("toAvatar", "");
    },
    onUnload: function() {
        wx.setStorageSync("toAvatar", "");
    },
    onPullDownRefresh: function() {
        var t = this;
        getApp().getConfigInfo(!0).then(function() {
            t.setData({
                "dataList.refresh": !0,
                "dataList.page": 1
            }, function() {
                wx.showNavigationBarLoading(), t.toGetClientList();
            });
        });
    },
    onReachBottom: function() {
        var t = this, a = t.data.dataList;
        a.page == a.total_page || a.loading || t.setData({
            "dataList.page": parseInt(a.page) + 1,
            "dataList.loading": !0
        }, function() {
            t.toGetClientList();
        });
    },
    toGetClientList: function() {
        var i = this, t = i.data, n = t.dataList, a = t.id, e = {
            page: n.page,
            staff_id: a
        };
        n.refresh || _xx_util2.default.showLoading(), _index.bossModel.getClientList(e).then(function(t) {
            _xx_util2.default.hideAll();
            var a = n, e = t.data;
            n.refresh || (e.list = [].concat(_toConsumableArray(a.list), _toConsumableArray(e.list))), 
            e.page = e.page, e.refresh = !1, e.loading = !1, i.setData({
                dataList: e
            });
        });
    },
    toCusDetail: function(t) {
        var a = this.data.avatarUrl;
        a = a || getApp().globalData.userDefault, getApp().globalData.avatarUrlStaff = a, 
        _xx_util2.default.goUrl(t);
    }
});