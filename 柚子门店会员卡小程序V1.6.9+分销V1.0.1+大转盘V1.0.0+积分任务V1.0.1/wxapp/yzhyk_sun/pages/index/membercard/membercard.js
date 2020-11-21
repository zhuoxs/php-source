var wxbarcode = require("../../../../style/utils/index.js"), app = getApp();

Page({
    data: {
        navTile: "柚子会员卡",
        cardNum: "13000000000",
        bgLogo: "../../../../style/images/icon6.png",
        bgCards: "../../../../style/images/bgCards.png",
        integral: 0,
        remark: "所有门店,一卡通用！更多福利，敬请期待..."
    },
    onLoad: function(n) {
        var e = this;
        wx.setNavigationBarTitle({
            title: e.data.navTile
        }), app.get_user_info().then(function(n) {
            e.setData({
                cardNum: n.tel,
                integral: n.integral ? n.integral : 0
            }), wxbarcode.qrcode("qrcode", n.tel, 420, 420);
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    toIntegral: function(n) {
        wx.navigateTo({
            url: "../../user/integral/integral"
        });
    }
});