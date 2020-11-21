var e = require("../../../../utils/base.js"), t = require("../../../../../api.js"), a = new e.Base();

Page({
    data: {},
    onLoad: function(e) {
        this.getQrcode();
    },
    getQrcode: function() {
        var e = this;
        wx.showLoading({
            title: "正在生成二维码"
        });
        var r = {
            url: t.default.share_poster,
            method: "GET"
        };
        a.getData(r, function(t) {
            console.log("推广海报=>", t), 1 == t.errorCode && e.setData({
                shareImg: t.data
            }), setTimeout(function() {
                wx.hideLoading();
            }, 300);
        });
    },
    previewImage: function(e) {
        wx.previewImage({
            current: e.currentTarget.dataset.img,
            urls: [ e.currentTarget.dataset.img ]
        });
    }
});