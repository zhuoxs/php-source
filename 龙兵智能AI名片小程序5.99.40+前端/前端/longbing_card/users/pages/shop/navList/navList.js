var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        globalData: {},
        activeIndex: 0,
        showMoreStatus: 0,
        shopTypes: {}
    },
    onLoad: function(t) {
        var e = this;
        console.log(t, "options"), e.setData({
            to_uid: t.to_uid,
            globalData: app.globalData
        }, function() {
            e.getShopTypes();
        });
        var a = _xx_util2.default.getTabTextInd(getApp().globalData.tabBar, "toShop")[0];
        a || (a = "商城"), wx.setNavigationBarTitle({
            title: a
        });
    },
    onPullDownRefresh: function() {
        wx.showNavigationBarLoading(), this.getShopTypes();
    },
    getShopTypes: function() {
        var a = this;
        _xx_util2.default.showLoading();
        var t = a.data, e = t.currentIndex, o = t.to_uid;
        _index.userModel.getShopTypes({
            type: e,
            to_uid: o
        }).then(function(t) {
            _xx_util2.default.hideAll(), console.log("getShopTypes ==>", t.data);
            var e = t.data.shop_type;
            a.setData({
                shop_type: e
            });
        });
    },
    scroll: function(t) {
        this.setData({
            toRightView: "scrollRight1"
        });
    },
    toTabClickJump: function(t) {
        this.setData({
            toRightView: "scrollRight" + t
        });
    },
    toJump: function(t) {
        var e = this, a = _xx_util2.default.getData(t), o = a.status, i = a.type, u = (a.id, 
        a.index), l = a.categoryid, r = e.data.shop_type;
        if ("toCopyright" == o && _xx_util2.default.goUrl(t), "toShowMore" == o) {
            var s = e.data.showMoreStatus;
            0 == i ? s = 1 : 1 == i && (s = 0), e.setData({
                showMoreStatus: s
            });
        } else if ("toSearch" == o || "toMore" == o || "toNavProduct" == o) {
            if ("toMore" == o || "toNavProduct" == o) {
                var n = r[u];
                wx.setStorageSync("navTypes", n);
            }
            _xx_util2.default.goUrl(t);
        } else "toTabClick" == o && (e.setData({
            activeIndex: u,
            toLeftView: "scrollLeft" + l
        }), e.toTabClickJump(l));
    }
});