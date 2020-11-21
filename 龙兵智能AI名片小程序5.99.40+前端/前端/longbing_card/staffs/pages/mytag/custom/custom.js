var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(a) {
    return a && a.__esModule ? a : {
        default: a
    };
}

function _toConsumableArray(a) {
    if (Array.isArray(a)) {
        for (var t = 0, e = Array(a.length); t < a.length; t++) e[t] = a[t];
        return e;
    }
    return Array.from(a);
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        toSearchCard: !1,
        tagType: 0,
        dataList: {
            page: 1,
            total_page: "",
            list: [],
            refresh: !1,
            loading: !1
        }
    },
    onLoad: function(a) {
        var r = this;
        wx.hideShareMenu();
        var t = "标签客户", e = a.status, i = {
            status: e,
            label_id: a.label_id,
            label_name: a.label_name
        };
        "starmark" == e && (t = "星标客户"), wx.setNavigationBarTitle({
            title: t
        }), getApp().getConfigInfo(!0).then(function() {
            var a = getApp().globalData, t = a.isIphoneX, e = a.userDefault;
            a.configInfo;
            r.setData({
                paramObj: i,
                isIphoneX: t,
                userDefault: e
            }, function() {
                "starmark" == i.status ? r.toGetStarMarkList() : r.toGetLabelUserList();
            });
        });
    },
    onPullDownRefresh: function() {
        var a = this;
        app.globalData.configInfo = !1, getApp().getConfigInfo(!0).then(function() {
            a.setData({
                globalData: app.globalData
            }, function() {
                a.setData({
                    "dataList.refresh": !0,
                    "dataList.page": 1
                }, function() {
                    wx.showNavigationBarLoading(), "starmark" == a.data.paramObj.status ? a.toGetStarMarkList() : a.toGetLabelUserList();
                });
            });
        });
    },
    onReachBottom: function() {
        var a = this, t = a.data.dataList;
        t.page == t.total_page || t.loading || a.setData({
            "dataList.page": parseInt(t.page) + 1,
            "dataList.loading": !1
        }, function() {
            "starmark" == a.data.paramObj.status ? a.toGetStarMarkList() : a.toGetLabelUserList();
        });
    },
    toSearchCardBlur: function() {
        this.setData({
            toSearchCard: !1
        });
    },
    toSearchCard: function(a) {
        var t = a.detail.value;
        this.setData({
            cardSearchKey: t
        });
    },
    toSearchCardConfirm: function() {
        var a = this;
        console.log("toSearchCardConfirm", a.data.cardSearchKey), a.setData({
            "dataList.refresh": !0
        }, function() {
            "starmark" == a.data.paramObj.status ? a.toGetStarMarkList() : a.toGetLabelUserList();
        });
    },
    toGetStarMarkList: function() {
        var i = this, a = i.data, s = a.dataList, t = a.cardSearchKey, e = {
            page: s.page
        };
        t && (e.keyword = t), s.refresh || _xx_util2.default.showLoading(), _index.staffModel.getStarMarkList(e).then(function(a) {
            _xx_util2.default.hideAll(), console.log("getStarMarkList ==>", a.data);
            var t = s, e = a.data;
            for (var r in s.refresh || (e.list = [].concat(_toConsumableArray(t.list), _toConsumableArray(e.list))), 
            e.list) e.list[r].last_time2 = _xx_util2.default.ctDate(1 * e.list[r].user.last);
            i.setData({
                dataList: e,
                "dataList.page": s.page,
                "dataList.refresh": !1
            });
        });
    },
    toGetLabelUserList: function() {
        var i = this, a = i.data, s = a.dataList, t = a.cardSearchKey, e = {
            label_id: i.data.paramObj.label_id,
            page: s.page
        };
        t && (e.keyword = t), s.refresh || _xx_util2.default.showLoading(), _index.staffModel.getLabelUserList(e).then(function(a) {
            _xx_util2.default.hideAll(), console.log("getLabelUserList ==>", a.data);
            var t = s, e = a.data;
            for (var r in s.refresh || (e.list = [].concat(_toConsumableArray(t.list), _toConsumableArray(e.list))), 
            e.list) e.list[r].last_time2 = _xx_util2.default.ctDate(1 * e.list[r].user.last);
            i.setData({
                dataList: e,
                "dataList.page": s.page,
                "dataList.refresh": !1
            });
        });
    },
    toGetLabelEdit: function(t, e) {
        var r = this, a = {
            label_id: r.data.paramObj.label_id,
            name: t
        };
        2 == e && (a.delete = 1), _index.staffModel.getLabelEdit(a).then(function(a) {
            _xx_util2.default.hideAll(), 1 == e ? r.setData({
                "paramObj.label_id": a.data.lable_id,
                "paramObj.label_name": t
            }) : 2 == e && wx.navigateBack();
        });
    },
    toJump: function(a) {
        var e = this, t = _xx_util2.default.getData(a), r = t.status;
        t.type;
        "toJumpUrl" == r ? _xx_util2.default.goUrl(a) : "toSearchCardFocus" == r ? e.setData({
            toSearchCard: !0
        }) : "toDelete" == r && wx.showModal({
            title: "",
            content: "是否确认删除此标签？",
            success: function(a) {
                if (a.confirm) {
                    var t = e.data.paramObj.label_name;
                    e.toGetLabelEdit(t, 2);
                }
            }
        });
    },
    formSubmit: function(a) {
        var t = a.detail.formId;
        _index.baseModel.getFormId({
            formId: t
        });
        var e = _xx_util2.default.getFormData(a), r = e.status, i = e.type, s = a.detail.value.label_name;
        if ("toEditSave" == r) {
            var l = void 0;
            0 == i ? l = 1 : 1 == i && (l = 0, this.toGetLabelEdit(s, 1)), this.setData({
                tagType: l
            });
        }
    }
});