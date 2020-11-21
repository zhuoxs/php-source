var _request = require("../../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

Page({
    data: {
        storeName: "",
        list: [ {
            title: "今日订单数",
            detail: "0"
        }, {
            title: "派送待接单",
            detail: "0"
        }, {
            title: "订单待配送",
            detail: "0"
        } ],
        finance: [ {
            title: "今日销售额",
            detail: "0"
        }, {
            title: "昨日销售额",
            detail: "0"
        }, {
            title: "总销售额",
            detail: "0"
        } ],
        tabBar: {
            list: [ {
                pagePath: "/yzbld_sun/pages/backstage/index/index",
                text: "工作台",
                iconPath: "../../../../style/images/tab4.png",
                selectedIconPath: "../../../../style/images/tab3.png",
                selectedColor: "#ef8200",
                active: !0
            }, {
                pagePath: "/yzbld_sun/pages/backstage/set/set",
                text: "订单",
                iconPath: "../../../../style/images/tab2.png",
                selectedIconPath: "../../../../style/images/ps4.png",
                selectedColor: "#ef8200",
                active: !1
            } ]
        }
    },
    onLoad: function(e) {
        var n = this, s = this;
        wx.getUserInfo({
            success: function(e) {
                s.setData({
                    thumb: e.userInfo.avatarUrl,
                    nickname: e.userInfo.nickName
                });
            }
        }), _request2.default.get("getStoreSummary").then(function(e) {
            console.log(e);
            var t = n.data.list;
            t[0].detail = e.summary.todayOrder, t[1].detail = e.summary.noDisOrder, t[2].detail = e.summary.DisOrder;
            var a = n.data.finance;
            a[0].detail = e.summary.todaySales, a[1].detail = e.summary.yesterdaySales, a[2].detail = e.summary.allSales, 
            s.setData({
                storeName: e.storeName,
                list: t,
                finance: a
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
    toMessage: function(e) {
        wx.redirectTo({
            url: "../message/message"
        });
    },
    toSet: function(e) {
        wx.redirectTo({
            url: "../set/set"
        });
    },
    scanCode: function(e) {
        wx.scanCode({
            success: function(e) {
                var t = e.result;
                _request2.default.get("getOrderSnFromVerifySn", {
                    verify_sn: t,
                    admin: 1
                }).then(function(e) {
                    console.log(e);
                    var t = e.order_sn;
                    wx.navigateTo({
                        url: "../writeoff/writeoff?sn=" + t
                    });
                });
            }
        });
    },
    toManager: function(e) {
        wx.navigateTo({
            url: "../manager/manager"
        });
    }
});