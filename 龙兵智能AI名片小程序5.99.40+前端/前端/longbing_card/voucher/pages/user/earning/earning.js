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

var app = getApp(), voucher = require("../../../../templates/voucher/voucher.js"), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        tabList: [ {
            status: "toSetTab",
            name: "全部"
        }, {
            status: "toSetTab",
            name: "1级"
        }, {
            status: "toSetTab",
            name: "2级"
        } ],
        currentIndex: 0,
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
        a.setData({
            globalData: app.globalData
        }, function() {
            a.toGetEarning();
        });
    },
    onPullDownRefresh: function() {
        var t = this;
        t.setData({
            "dataList.refresh": !0,
            "dataList.page": 1
        }, function() {
            wx.showNavigationBarLoading(), t.toGetEarning();
        });
    },
    onReachBottom: function() {
        var t = this, a = t.data.dataList;
        a.page == a.total_page || a.loading || t.setData({
            "dataList.page": parseInt(a.page) + 1,
            "dataList.loading": !0
        }, function() {
            t.toGetEarning();
        });
    },
    toGetEarning: function() {
        var r = this, t = r.data, n = (t.currentIndex, t.dataList), a = {
            page: n.page
        };
        n.refresh || _xx_util2.default.showLoading(), _index.userModel.getEarning(a).then(function(t) {
            _xx_util2.default.hideAll();
            var a = n, e = t.data;
            n.refresh || (e.list = [].concat(_toConsumableArray(a.list), _toConsumableArray(e.list))), 
            e.page = e.page, e.refresh = !1, e.loading = !1, r.setData({
                dataList: e
            });
        });
    },
    formSubmit: function(t) {
        var a = this, e = t.detail.formId, r = _xx_util2.default.getFormData(t), n = r.index;
        "toSetTab" == r.status && a.setData({
            currentIndex: n,
            "dataList.page": 1,
            "dataList.refresh": !0
        }, function() {
            a.toGetEarning();
        }), _index.baseModel.getFormId({
            formId: e
        });
    }
});