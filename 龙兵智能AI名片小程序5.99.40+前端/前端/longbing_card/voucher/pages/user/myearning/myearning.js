var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        dataList: {},
        refresh: !1,
        loading: !0
    },
    onLoad: function(t) {
        var e = this;
        e.setData({
            globalData: app.globalData
        }, function() {
            e.toGetMyEarning();
        });
    },
    onPullDownRefresh: function() {
        var t = this;
        t.setData({
            refresh: !0
        }, function() {
            wx.showNavigationBarLoading(), t.toGetMyEarning();
        });
    },
    toGetMyEarning: function() {
        var r = this;
        r.data.refresh || _xx_util2.default.showLoading(), _index.userModel.getMyEarning().then(function(t) {
            _xx_util2.default.hideAll();
            var e = t.data;
            for (var a in e.water) e.water[a].create_time1 = _xx_util2.default.formatTime(1e3 * e.water[a].create_time, "YY-M-D");
            r.setData({
                dataList: e,
                refresh: !1
            });
        });
    },
    toJump: function(t) {
        "toJumpUrl" == _xx_util2.default.getData(t).status && _xx_util2.default.goUrl(t);
    },
    formSubmit: function(t) {
        var e = t.detail.formId, a = _xx_util2.default.getFormData(t);
        a.index, a.status;
        _index.baseModel.getFormId({
            formId: e
        });
    }
});