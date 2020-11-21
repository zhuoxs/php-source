var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        activeIndex: 100000101,
        showMoreStatus: 0,
        keyword: ""
    },
    onLoad: function(e) {
        this.setData({
            isIphoneX: getApp().globalData.isIphoneX
        });
    },
    onShow: function() {
        this.getShopSearchRecord(), wx.hideLoading();
    },
    onPullDownRefresh: function() {
        wx.showNavigationBarLoading(), this.getShopSearchRecord();
    },
    getShopSearchRecord: function() {
        var t = this;
        _index.userModel.getShopSearchRecord().then(function(e) {
            t.setData({
                Record: e.data
            });
        });
    },
    bindinput: function(e) {
        this.setData({
            keyword: e.detail.value
        });
    },
    toSearchBtn: function() {
        if (!this.data.keyword) return wx.showToast({
            icon: "none",
            title: "请输入关键词！",
            duration: 2e3
        }), !1;
        wx.navigateTo({
            url: "/longbing_card/users/pages/shop/list/list?keyword=" + this.data.keyword
        });
    },
    toJump: function(e) {
        var t = _xx_util2.default.getData(e).status;
        if ("toSearchKeyWord" == t) {
            if (!this.data.keyword) return wx.showToast({
                icon: "none",
                title: "请输入关键词！",
                duration: 2e3
            }), !1;
            _xx_util2.default.goUrl(e);
        } else "toSearch" == t && _xx_util2.default.goUrl(e);
    }
});