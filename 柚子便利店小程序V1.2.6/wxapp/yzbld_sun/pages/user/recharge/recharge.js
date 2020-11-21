var _request = require("../../../util/request.js"), _request2 = _interopRequireDefault(_request), _pay = require("../../../util/pay"), _pay2 = _interopRequireDefault(_pay);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

Page({
    data: {
        notice: "充值后，账户余额仅支持平台消费，不予以退还"
    },
    onLoad: function(e) {
        var t = this;
        wx.setNavigationBarTitle({
            title: "充值"
        }), wx.getUserInfo({
            success: function(e) {
                t.setData({
                    nickname: e.userInfo.nickName
                });
            }
        }), _request2.default.get("getRecharge").then(function(e) {
            console.log(e), t.setData({
                youhui: e
            });
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    money: function(e) {
        var t = e.detail.value;
        this.setData({
            money: t
        });
    },
    toRechargePay: function(e) {
        var t = e.currentTarget.dataset.id;
        console.log("id:" + t), _request2.default.post("postRecharge", {
            recharge_id: t
        }).then(function(e) {
            console.log(e), _pay2.default.pay(e.sn).then(function(e) {
                console.log("pay success!"), wx.redirectTo({
                    url: "../user"
                });
            }, function(e) {
                console.log("pay fail!");
            });
        });
    },
    submit: function(e) {
        var t = e.currentTarget.dataset.money;
        null == t || 0 == t ? wx.showModal({
            title: "提示",
            content: "充值金额必须大于0元",
            showCancel: !1,
            success: function(e) {}
        }) : _request2.default.post("postRecharge", {
            money: t
        }).then(function(e) {
            console.log(e), _pay2.default.pay(e.sn).then(function(e) {
                console.log("pay success!"), wx.redirectTo({
                    url: "../user"
                });
            }, function(e) {
                console.log("pay fail!");
            });
        });
    }
});