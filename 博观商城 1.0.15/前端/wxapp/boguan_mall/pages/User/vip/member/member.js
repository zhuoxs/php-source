var t = require("../../../../utils/base.js"), n = require("../../../../../api.js"), a = new t.Base();

Page({
    data: {},
    onLoad: function(t) {
        console.log(t), this.setData({
            vipIntegral: t.vipIntegral
        }), this.getVipInfo();
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    getVipInfo: function() {
        var t = this, i = [], e = {
            url: n.default.vip_info,
            method: "get"
        };
        a.getData(e, function(n) {
            if (1 == n.errorCode) for (var a = 0; a < n.data.length; a++) 1 == n.data[a].is_current && i.push(n.data[a]);
            t.setData({
                allinfo: n.data,
                vipInfo: i,
                discount: n.data[0].discount,
                level: n.data[0].name
            });
        });
    },
    vipSwiper: function(t) {
        this.setData({
            discount: this.data.vipInfo[t.detail.current].discount,
            level: this.data.vipInfo[t.detail.current].name
        });
    }
});