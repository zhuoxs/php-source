var e = require("../../../../utils/base.js"), s = require("../../../../../api.js"), a = new e.Base();

Page({
    data: {},
    onLoad: function(e) {
        console.log(e), this.setData({
            express: e.express,
            express_no: e.express_no,
            orderId: e.id,
            image: e.image
        }), "null" != e.express && "null" != e.express_no ? this.express(e) : console.log("运单空");
    },
    copy: function(e) {
        var s = e.target.dataset.orderon;
        wx.setClipboardData({
            data: s,
            success: function(e) {
                wx.showToast({
                    title: "复制成功"
                });
            }
        });
    },
    express: function(e) {
        var t = this, r = {
            url: s.default.express,
            data: {
                expressName: e.express,
                expressNumber: e.express_no
            }
        };
        a.getData(r, function(e) {
            t.setData({
                expressInfo: e.data
            });
        });
    }
});