var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        globalData: {}
    },
    onLoad: function(t) {
        console.log(t, "options");
        var e = {
            detailID: t.id,
            to_uid: t.to_uid
        };
        wx.getStorageSync("moreCollageData") && (e.data = wx.getStorageSync("moreCollageData")), 
        this.setData({
            paramData: e,
            globalData: app.globalData
        }), this.getCollageList(), wx.hideLoading();
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        wx.showNavigationBarLoading(), this.getCollageList();
    },
    getCollageList: function() {
        var u = this, t = u.data.paramData.detailID;
        _index.userModel.getShopCollageList({
            goods_id: t
        }).then(function(t) {
            var e = t.data, a = [], o = [];
            for (var i in e) 0 < e[i].left_number && o.push(e[i]);
            for (var l in o) {
                var r = o[l].left_time, n = parseInt(r / 24 / 60 / 60);
                n = 0 < n ? n + "天 " : "", a[l] = n + _xx_util2.default.formatTime(1e3 * r, "h小时m分钟"), 
                0 == r && (o.splice(l, 1), a.splice(l, 1)), u.setData({
                    tmpTimes: a
                });
            }
            u.setData({
                collageList: o
            });
        });
    },
    toJump: function(t) {
        var e = _xx_util2.default.getData(t).status;
        "toCopyright" == e ? _xx_util2.default.goUrl(t) : "toReleaseCollage" == e && _xx_util2.default.goUrl(t);
    }
});