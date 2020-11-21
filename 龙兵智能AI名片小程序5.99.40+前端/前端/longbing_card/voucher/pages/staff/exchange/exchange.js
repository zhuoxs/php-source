var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var app = getApp(), voucher = require("../../../../templates/voucher/voucher.js"), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        voucherStatus: {
            show: !0,
            status: 0
        },
        dataList: {},
        refresh: !1,
        loading: !0
    },
    onLoad: function(t) {
        var e = this;
        console.log(t, "options");
        var o = {
            coupon_id: t.id,
            type: t.type
        };
        getApp().getConfigInfo().then(function() {
            e.setData({
                globalData: app.globalData,
                paramObj: o
            }, function() {
                e.toGetCouponUserList();
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
                    refresh: !0
                }, function() {
                    wx.showNavigationBarLoading(), t.toGetCouponUserList();
                });
            });
        });
    },
    toGetCouponUserList: function() {
        var o = this, t = o.data, e = t.paramObj;
        t.refresh || _xx_util2.default.showLoading(), _index.staffModel.getCouponUserList(e).then(function(t) {
            _xx_util2.default.hideAll();
            var e = t.data;
            o.setData({
                dataList: e,
                refresh: !1
            });
        });
    },
    toCloseVoucher: function() {
        voucher.toCloseVoucher(this);
    },
    toJump: function(t) {
        var o = this, e = _xx_util2.default.getData(t).status;
        "toExchangeBtn" == e ? wx.scanCode({
            success: function(t) {
                var e = JSON.parse(t.result);
                console.log(t, e, "toExchangeBtn  wx.scanCode"), wx.showModal({
                    title: "",
                    content: "是否要核销此福包(满" + e.full + "元减" + e.reduce + "元)？",
                    success: function(t) {
                        t.confirm && _index.staffModel.getCouponClean(e).then(function(t) {
                            _xx_util2.default.hideAll();
                            var e = t.message;
                            wx.showModal({
                                title: "",
                                content: e,
                                showCancel: !1,
                                success: function(t) {
                                    t.confirm && o.setData({
                                        refresh: !0
                                    }, function() {
                                        o.toGetCouponUserList();
                                    });
                                }
                            });
                        });
                    }
                });
            }
        }) : "toUseVoucher" == e && o.setData({
            "useStatus.show": !0,
            "useStatus.status": "receive"
        });
    },
    formSubmit: function(t) {
        var e = t.detail.formId;
        _index.baseModel.getFormId({
            formId: e
        });
        var o = _xx_util2.default.getFormData(t), a = o.index;
        "toSetTab" == o.status && this.setData({
            currentIndex: a
        });
    }
});