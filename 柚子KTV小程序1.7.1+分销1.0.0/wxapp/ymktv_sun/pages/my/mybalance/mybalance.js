var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        msg: "享受会员折扣、超市会员折扣、会员积分、会员生日礼遇；在厦门区以外的欢唱KTV可享受会员折扣；如有不明之处请致电4000 917 888进行咨询。",
        vip: !1
    },
    onLoad: function(a) {},
    onShow: function() {
        var e = this, a = wx.getStorageSync("openid"), n = wx.getStorageSync("userInfo");
        app.util.request({
            url: "entry/wxapp/inaryRecharge",
            cachetime: "0",
            data: {
                openid: a
            },
            success: function(a) {
                console.log(a.data), e.setData({
                    list: a.data.inary,
                    balance: a.data.balance,
                    userInfo: n,
                    isopen: a.data.isopen,
                    iscun: a.data.iscun
                });
            }
        });
    },
    gobalancedetail: function() {
        wx.navigateTo({
            url: "../balancedetail/balancedetail"
        });
    },
    goVipthree: function(a) {
        var e = this, n = e.data.userInfo;
        if (0 == e.data.iscun) var t = 0; else {
            var o = a.currentTarget.dataset.index;
            t = e.data.list[o].recharge;
        }
        1 == e.data.isopen ? wx.showModal({
            title: "提示",
            content: "您是会员，是否前往会员充值！",
            success: function(a) {
                a.confirm && wx.redirectTo({
                    url: "/ymktv_sun/pages/booking/vipsuper/vipsuper"
                });
            }
        }) : wx.navigateTo({
            url: "../../booking/vipthree/vipthree?total=" + t + "&name=" + n.nickName
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});