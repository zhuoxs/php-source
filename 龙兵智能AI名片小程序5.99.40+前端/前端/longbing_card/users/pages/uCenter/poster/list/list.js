var _xx_util = require("../../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

function _toConsumableArray(t) {
    if (Array.isArray(t)) {
        for (var e = 0, a = Array(t.length); e < t.length; e++) a[e] = t[e];
        return a;
    }
    return Array.from(t);
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        activeIndex: "100000101",
        refresh: !1,
        loading: !0,
        paramType: {
            to_uid: "",
            type: 0,
            user_info: 0
        },
        dataList: {
            page: 1,
            total_page: "",
            post_img: [],
            refresh: !1,
            loading: !0
        }
    },
    onLoad: function(t) {
        var e = this;
        getApp().getConfigInfo().then(function() {
            e.setData({
                "paramType.to_uid": wx.getStorageSync("userid"),
                "paramType.user_info": 1,
                globalData: app.globalData
            }, function() {
                e.getPosterType();
            });
        });
    },
    onShow: function() {
        this.onPullDownRefresh(), console.log("页面显示");
    },
    onPullDownRefresh: function() {
        var t = this, e = t.data.activeIndex;
        getApp().getConfigInfo(!0).then(function() {
            t.setData({
                globalData: app.globalData
            }, function() {
                t.setData({
                    "dataList.refresh": !0,
                    "dataList.page": 1
                }, function() {
                    wx.showNavigationBarLoading(), "100000102" == e ? t.toGetMyPoster() : t.getPosterType();
                });
            });
        });
    },
    onReachBottom: function() {
        var t = this, e = t.data, a = e.activeIndex, o = e.dataList;
        o.page == o.total_page || o.loading || t.setData({
            "dataList.page": parseInt(o.page) + 1,
            "dataList.loading": !0
        }, function() {
            "100000102" == a ? t.toGetMyPoster() : t.getPosterType();
        });
    },
    toDelPoster: function(t) {
        var a = this, e = _xx_util2.default.getData(t), o = e.id, i = e.name, r = e.index;
        wx.showModal({
            title: "删除海报",
            content: "请确认是否要删除此海报  " + i,
            success: function(t) {
                t.confirm && (_xx_util2.default.showLoading(), _index.staffModel.toDelPoster({
                    id: o
                }).then(function(t) {
                    if (_xx_util2.default.hideAll(), 0 == t.errno) {
                        _xx_util2.default.showSuccess("删除成功");
                        var e = a.data.dataList.post_img;
                        e.splice(r, 1), a.setData({
                            "dataList.post_img": e
                        });
                    } else _xx_util2.default.showToast("fail", "删除失败");
                }));
            }
        });
    },
    toGetMyPoster: function() {
        var o = this, t = o.data, e = t.paramType, i = t.dataList;
        e.page = i.page, i.refresh || _xx_util2.default.showLoading(), _index.userModel.getMyPoster(e).then(function(t) {
            _xx_util2.default.hideAll(), console.log("getMyPoster ==>", t.data);
            var e = i, a = t.data;
            i.refresh || (a.list = [].concat(_toConsumableArray(e.post_img), _toConsumableArray(a.list))), 
            a.page = i.page, a.post_img = a.list, a.refresh = !1, a.loading = !1, o.setData({
                dataList: a
            });
        });
    },
    getPosterType: function() {
        var n = this, t = n.data, e = t.paramType, l = t.dataList, u = n.data.paramType.user_info;
        e.page = l.page, l.refresh || _xx_util2.default.showLoading(), _index.userModel.getPosterType(e).then(function(t) {
            _xx_util2.default.hideAll(), console.log("getPosterType ==>", t.data);
            var e = l, a = t.data;
            l.refresh || (a.post_img = [].concat(_toConsumableArray(e.post_img), _toConsumableArray(a.post_img)));
            if (a.page = l.page, a.refresh = !1, a.loading = !1, 1 == u) {
                var o = t.data, i = o.post_type_list, r = o.post_user, s = o.post_company;
                n.setData({
                    post_type_list: i,
                    post_user: r,
                    post_company: s
                });
            }
            n.setData({
                dataList: a,
                userinfo: 0
            });
        });
    },
    toJump: function(t) {
        var e = this, a = t.currentTarget.dataset, o = a.status, i = a.index, r = a.categoryid;
        if ("toTabClickMore" == o || "toTabClick" == o || "toTabClickMine" == o) {
            var s = i, n = r;
            "toTabClickMore" == o && (s = "100000101", n = 0), "toTabClickMine" == o && (s = "100000102", 
            n = "Mine"), console.log(s, "tmpIndex   tmpIndextmpIndextmpIndex"), e.setData({
                activeIndex: s,
                categoryid: r,
                scrollNav: "scrollNav" + n,
                "dataList.page": 1,
                "dataList.post_img": [],
                "dataList.refresh": !1,
                "paramType.type": r,
                "paramType.user_info": 0
            }, function() {
                "toTabClickMine" == o ? e.toGetMyPoster() : e.getPosterType();
            });
        } else "toShare" == o ? e.setData({
            currentPoster: i
        }, function() {
            _xx_util2.default.goUrl(t);
        }) : "toJumpUrl" == o && _xx_util2.default.goUrl(t);
    },
    formSubmit: function(t) {
        var e = t.detail.formId, a = (t.detail.target.dataset.index, t.detail.target.dataset.status);
        _index.baseModel.getFormId({
            formId: e
        }), console.log("toJump ==> ", a), _xx_util2.default.goUrl(t, !0);
    }
});