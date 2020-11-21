Object.defineProperty(exports, "__esModule", {
    value: !0
}), exports.chooseImage = function() {
    return new Promise(function(e, o) {
        wx.chooseImage({
            count: 1,
            success: function(o) {
                e(o.tempFilePaths[0]);
            },
            fail: function(e) {
                o(e);
            }
        });
    });
}, exports.upload = function(o) {
    var t = e.siteInfo.siteroot + "?i=" + e.siteInfo.uniacid + "&c=utility&a=file&do=upload&thumb=0";
    return new Promise(function(e, n) {
        wx.uploadFile({
            url: t,
            filePath: o,
            name: "file",
            header: {},
            formData: {},
            success: function(o) {
                e(JSON.parse(o.data));
            },
            fail: function(e) {
                console.log("errror"), console.log(e), n(e);
            },
            complete: function(e) {}
        });
    });
};

var e = getApp();