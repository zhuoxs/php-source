/*www.lanrenzhijia.com   time:2019-06-01 22:11:54*/
var a = getApp();
a.Base({
    data: {},
    onLoad: function() {},
    onShow: function() {
        var a = this;
        this.checkLogin(function(n) {
            a.setData({
                user: n
            }), a.onLoadData(n)
        }, "/base/mybalance/mybalance")
    },
    onLoadData: function(n) {
        var t = this;
        a.api.ApiRechargeRecharge({
            user_id: n.id
        }).then(function(a) {
            t.setData({
                info: a.data,
                show: !0
            })
        }).
        catch (function(n) {
            a.tips(n.msg)
        })
    },
    onRechargeTap: function() {
        a.navTo("/base/recharge/recharge")
    },
    onBalancelistTap: function() {
        a.navTo("/base/balancelist/balancelist")
    }
});