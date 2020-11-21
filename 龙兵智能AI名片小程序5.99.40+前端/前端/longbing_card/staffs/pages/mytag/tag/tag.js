var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        dataList: {
            page: 1,
            total_page: 1,
            list: [],
            refresh: !1,
            loading: !0
        }
    },
    onLoad: function(t) {
        wx.hideShareMenu();
    },
    onShow: function() {
        var t = this;
        getApp().getConfigInfo().then(function() {
            t.setData({
                globalData: app.globalData,
                "dataList.refresh": !0
            }, function() {
                t.toGetLabelList();
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
                    wx.showNavigationBarLoading(), t.toGetLabelList();
                });
            });
        });
    },
    toSearchCardBlur: function() {
        this.setData({
            toSearchCard: !1
        });
    },
    toSearchCard: function(t) {
        var a = t.detail.value;
        this.setData({
            cardSearchKey: a
        });
    },
    toSearchCardConfirm: function() {
        var t = this;
        console.log("toSearchCardConfirm", t.data.cardSearchKey), t.setData({
            refreshCardList: !0
        }, function() {
            t.toGetLabelList();
        });
    },
    toGetLabelList: function() {
        var a = this, t = a.data, e = t.cardSearchKey, i = t.dataList, o = {};
        e && (o.keyword = e), i.refresh || _xx_util2.default.showLoading(), _index.staffModel.getLabelList(o).then(function(t) {
            _xx_util2.default.hideAll(), console.log("getLabelList ==>", t.data), i.list = t.data, 
            i.refresh = !1, i.loading = !1, i.page = 1, i.total_page = 1, a.setData({
                dataList: i
            });
        });
    },
    toJump: function(t) {
        var a = _xx_util2.default.getData(t), e = a.status;
        a.type;
        "toSearchCardFocus" == e ? this.setData({
            toSearchCard: !0
        }) : "toJumpUrl" == e && _xx_util2.default.goUrl(t);
    }
});