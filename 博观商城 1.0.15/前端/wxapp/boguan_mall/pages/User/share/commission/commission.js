var a = require("../../../../utils/base.js"), e = require("../../../../../api.js"), t = new a.Base();

Page({
    data: {},
    onLoad: function(a) {
        this.getShareData();
    },
    getShareData: function() {
        var a = this, r = {
            url: e.default.share_data,
            method: "GET"
        };
        t.getData(r, function(e) {
            console.log("推广佣金页信息=》", e), 1 == e.errorCode && a.setData({
                shareData: e.data
            });
        });
    }
});