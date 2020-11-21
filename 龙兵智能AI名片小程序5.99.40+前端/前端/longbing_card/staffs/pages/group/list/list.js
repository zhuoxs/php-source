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
        status: 0,
        tagType: 0,
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
        var e = this;
        getApp().getConfigInfo().then(function() {
            var t = getApp().globalData, a = t.isIphoneX;
            t.configInfo;
            e.setData({
                isIphoneX: a
            }, function() {
                e.setData({
                    "dataList.refresh": !0
                }, function() {
                    e.toGetGroupRecord();
                });
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
                    wx.showNavigationBarLoading(), t.toGetGroupRecord();
                });
            });
        });
    },
    onReachBottom: function() {
        var t = this, a = t.data.dataList;
        a.page == a.total_page || a.loading || t.setData({
            "dataList.page": parseInt(a.page) + 1,
            "dataList.loading": !0
        }, function() {
            t.toGetGroupRecord();
        });
    },
    toGetGroupRecord: function() {
        var i = this, r = i.data.dataList;
        r.refresh || _xx_util2.default.showLoading();
        var t = {
            page: r.page
        };
        _index.staffModel.getGroupRecord(t).then(function(t) {
            _xx_util2.default.hideAll(), console.log("getGroupRecord ==>", t.data);
            var a = r, e = t.data;
            for (var o in r.refresh || (e.list = [].concat(_toConsumableArray(a.list), _toConsumableArray(e.list))), 
            e.list) e.list[o].show_more = 0, e.list[o].show_type = 0, 10 < e.list[o].label_count && (e.list[o].show_more = 1);
            e.page = e.page, e.refresh = !1, e.loading = !1, i.setData({
                dataList: e,
                status: 1
            });
        });
    },
    toJump: function(t) {
        var a = this, e = _xx_util2.default.getData(t), o = e.status, i = e.type, r = e.index;
        if ("toJumpUrl" == o) _xx_util2.default.goUrl(t); else if ("toShowTag" == o) {
            var n = a.data.dataList.list;
            (n[r].show_type = 1) == i && (n[r].show_type = 0), a.setData({
                "dataList.list": n
            });
        } else if ("toSendAgain" == o) {
            var s = a.data.dataList.list;
            a.setData({
                check_lable_count: s[r].label_count,
                check_lable_id: s[r].remark,
                check_lable_name: s[r].labels_name
            }), _xx_util2.default.goUrl(t);
        }
    },
    formSubmit: function(t) {
        "toJumpUrl" == _xx_util2.default.getFormData(t).status && _xx_util2.default.goUrl(t, !0);
    }
});