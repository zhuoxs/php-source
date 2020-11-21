Page({
    data: {},
    onLoad: function(o) {
        var e = o.url;
        this.setData({
            path: e
        });
    },
    bindmessage: function(o) {
        console.log("回调"), console.log(o);
    },
    onShareAppMessage: function(o) {
        console.log("分享"), console.log(o.webViewUrl);
    },
    ceshi: function(o) {
        console.log("cesshji");
    }
});