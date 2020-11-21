var app = getApp();

Page({
    data: {
        navTile: "会员充值",
        recharge: [ {
            money: "100",
            give_money: "5",
            status: "1"
        }, {
            money: "200",
            give_money: "10",
            status: "0"
        }, {
            money: "500",
            give_money: "20",
            status: "0"
        }, {
            money: "1000",
            coupon: "50",
            status: "0"
        } ],
        curIndex: "0"
    },
    onLoad: function(e) {
        var t = this;
        wx.setNavigationBarTitle({
            title: t.data.navTile
        }), app.util.request({
            url: "entry/wxapp/GetRecharges",
            cachetime: "0",
            success: function(e) {
                t.setData({
                    recharge: e.data
                });
            }
        }), app.full_setting();
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    choose: function(e) {
        for (var t = e.currentTarget.dataset.index, n = this.data.recharge, a = 0; a < n.length; a++) n[a].status = 0;
        n[t].status = 1, this.setData({
            curIndex: t,
            recharge: n
        });
    },
    formSubmit: function(e) {
        var t = this.data.curIndex, n = this.data.recharge[t], a = e.detail.formId;
        app.wx_pay(n.money).then(function() {
            app.get_user_info().then(function(e) {
                app.util.request({
                    url: "entry/wxapp/Recharge",
                    cachetime: "0",
                    data: {
                        user_id: e.id,
                        money: n.money,
                        give_money: n.give_money
                    },
                    success: function(e) {
                        "the formId is a mock one" != a && app.getFormid(a), app.get_user_info(!1), app.get_user_coupons(!1), 
                        wx.redirectTo({
                            url: "../../index/paysuc/paysuc"
                        });
                    }
                });
            });
        });
    }
});