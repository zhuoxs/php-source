/*www.lanrenzhijia.com   time:2019-06-01 22:11:49*/
var i = getApp(),
    t = require("../../../zhy/template/wxParse/wxParse.js");
i.Base({
    data: {
        balance: 0
    },
    onLoad: function(i) {},
    onShow: function() {
        var i = this;
        this.checkLogin(function(t) {
            i.onLoadData(t), i.setData({
                user: t
            })
        }, "/plugin/distribution/commission/commission")
    },
    onLoadData: function(a) {
        var n = this,
            o = this.data.balance;
        Promise.all([i.api.apiDistributionGetDistributionpromoterDetail({
            user_id: a.id
        }), i.api.apiDistributionGetDistributionset({})]).then(function(i) {
            o = (i[0].data.canwithdraw - 0 - (i[0].data.freezemoney - 0)).toFixed(2);
            var a = i[1].data.user_notice;
            t.wxParse("detail", "html", a, n, 20), n.setData({
                show: !0,
                partner: i[0].data,
                distribution: i[1].data,
                balance: o
            })
        }).
        catch (function(t) {
            i.tips(t.msg)
        })
    },
    checkWarm: function() {
        this.setData({
            popWin: !0
        })
    },
    agree: function() {
        this.setData({
            popWin: !1
        })
    },
    onApplicationTap: function() {
        i.navTo("/plugin/distribution/withdrawal/withdrawal")
    },
    onCommissiondetailTap: function() {
        i.navTo("/plugin/distribution/commissiondetail/commissiondetail")
    }
});