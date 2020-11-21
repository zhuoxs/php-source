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
        getApp().getConfigInfo().then(function() {
            a.setData({
                globalData: app.globalData
            }, function() {
                a.toGetStaffCouponList();
            });
        });
    },
    onPullDownRefresh: function() {
        var t = this;
        getApp().getConfigInfo(!0).then(function() {
            t.setData({
                globalData: app.globalData
            }, function() {
                t.setData({
                    "dataList.page": 1,
                    "dataList.refresh": !0
                }, function() {
                    wx.showNavigationBarLoading(), t.toGetStaffCouponList();
                });
            });
        });
    },
    onReachBottom: function() {
        var t = this, a = t.data.dataList;
        a.page == a.total_page || a.loading || t.setData({
            "dataList.page": parseInt(a.page) + 1,
            "dataList.loading": !1
        }, function() {
            t.toGetStaffCouponList();
        });
    },
    toGetStaffCouponList: function() {
        var o = this, i = o.data.dataList, t = {
            page: parseInt(i.page)
        };
        i.refresh || _xx_util2.default.showLoading(), _index.staffModel.getStaffCouponList(t).then(function(t) {
            _xx_util2.default.hideAll(), console.log("getStaffCouponList ==>", t.data);
            var a = i, e = t.data;
            i.refresh || (e.list = [].concat(_toConsumableArray(a.list), _toConsumableArray(e.list))), 
            e.refresh = !1, e.loading = !1, o.setData({
                dataList: e
            });
        });
    },
    toJump: function(t) {
        "toJumpUrl" == _xx_util2.default.getData(t).status && _xx_util2.default.goUrl(t);
    },
    formSubmit: function(t) {
        var a = t.detail.formId, e = _xx_util2.default.getFormData(t), o = e.index;
        "toSetTab" == e.status && this.setData({
            currentIndex: o
        }), _index.baseModel.getFormId({
            formId: a
        });
    }
});