var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
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
        currentIndex: 0
    },
    onLoad: function(t) {
        console.log(t, "options");
        this.setData({
            globalData: app.globalData,
            paramObj: {}
        });
    },
    onShow: function() {
        this.toGetMyEarning();
    },
    onPullDownRefresh: function() {
        this.setData({
            refresh: !0
        }, function() {
            wx.showNavigationBarLoading();
        });
    },
    toGetMyEarning: function() {
        var a = this;
        _index.userModel.getMyEarning().then(function(t) {
            _xx_util2.default.hideAll();
            var e = t.data;
            a.setData({
                dataList: e
            });
        });
    },
    toGetWithdraw: function(t) {
        _index.userModel.getWithdraw(t).then(function(t) {
            0 == t.errno && wx.showToast({
                icon: "success",
                title: "已申请提现",
                duration: 2e3,
                success: function() {
                    setTimeout(function() {
                        wx.redirectTo({
                            url: "/longbing_card/voucher/pages/user/withlist/withlist"
                        });
                    }, 2e3);
                }
            });
        });
    },
    toJump: function(t) {
        var e = _xx_util2.default.getData(t).status, a = this.data.dataList, i = a.cash_mini, n = a.profit;
        "toWithdrawAll" == e && (1 * i <= 1 * n ? this.setData({
            inputMoney: n
        }) : _xx_util2.default.showModal({
            content: "钱包余额小于最低提现标准！"
        }));
    },
    formSubmit: function(t) {
        var e = this, a = t.detail.formId, i = _xx_util2.default.getFormData(t), n = (i.index, 
        i.status), o = t.detail.value, u = e.data.dataList, r = u.cash_mini, s = u.profit, l = e.data.globalData.configInfo.config.admin_account;
        if ("toWithDrawBtn" == n) {
            if (!o.account) return _xx_util2.default.showModal({
                content: "请输入微信账号！"
            }), !1;
            if (1 * s < 1 * r) return _xx_util2.default.showModal({
                content: "钱包余额小于最低提现标准！"
            }), !1;
            if (1 * o.money < 1 * r) return _xx_util2.default.showModal({
                content: "提现金额未达到最低提现标准！"
            }), !1;
            wx.showModal({
                title: "",
                content: "需要添加管理员微信好友后才可提现\r\n管理员微信号：" + l,
                confirmText: "复制微信",
                cancelText: "关闭",
                success: function(t) {
                    t.confirm ? (wx.setClipboardData({
                        data: l,
                        success: function(t) {
                            wx.getClipboardData({
                                success: function(t) {
                                    console.log("复制微信号 ==>>", t.data);
                                }
                            });
                        }
                    }), e.toGetWithdraw(o)) : t.cancel && e.toGetWithdraw(o);
                }
            });
        }
        _index.baseModel.getFormId({
            formId: a
        });
    }
});