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
            name: "提现申请中"
        }, {
            status: "toSetTab",
            name: "提现已到账"
        } ],
        currentIndex: 0,
        scrollNav: "scrollNav0",
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
        console.log(t, "options");
        var e = {
            status: t.status
        };
        a.setData({
            paramObj: e,
            "globalData.isIphoneX": app.globalData.isIphoneX
        }, function() {
            a.toGetWithdrawList();
        });
    },
    onPullDownRefresh: function() {
        var t = this;
        t.setData({
            "dataList.refresh": !0,
            "dataList.page": 1
        }, function() {
            wx.showNavigationBarLoading(), t.toGetWithdrawList();
        });
    },
    onReachBottom: function() {
        var t = this, a = t.data.dataList;
        a.page == a.total_page || a.loading || t.setData({
            "dataList.page": parseInt(a.page) + 1,
            "dataList.loading": !0
        }, function() {
            t.toGetWithdrawList();
        });
    },
    toGetWithdrawList: function() {
        var r = this, t = r.data, a = t.currentIndex, i = t.dataList, e = {
            page: i.page,
            type: a
        };
        i.refresh || _xx_util2.default.showLoading(), _index.userModel.getWithdrawList(e).then(function(t) {
            _xx_util2.default.hideAll(), console.log("getWithdrawList ==>", t.data);
            var a = i, e = t.data;
            i.refresh || (e.list = [].concat(_toConsumableArray(a.list), _toConsumableArray(e.list))), 
            e.page = e.page, e.refresh = !1, e.loading = !1, r.setData({
                dataList: e
            });
        });
    },
    toJump: function(t) {
        "toJumpUrl" == _xx_util2.default.getData(t).status && _xx_util2.default.goUrl(t);
    },
    toTabClick: function(t) {
        var a = _xx_util2.default.getData(t).index;
        this.setData({
            currentIndex: a,
            scrollNav: "scrollNav" + a
        }), this.onPullDownRefresh();
    }
});