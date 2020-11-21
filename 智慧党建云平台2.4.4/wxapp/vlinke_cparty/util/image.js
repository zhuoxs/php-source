Object.defineProperty(exports, "__esModule", {
    value: !0
}), exports.chooseImage = chooseImage, exports.upload = upload;

var app = getApp();

function chooseImage() {
    return new Promise(function(o, t) {
        wx.chooseImage({
            count: 1,
            success: function(e) {
                o(e.tempFilePaths[0]);
            },
            fail: function(e) {
                t(e);
            }
        });
    });
}

function upload(e) {
    var n = app.siteInfo.siteroot + "?i=" + app.siteInfo.uniacid + "&c=utility&a=file&do=upload&thumb=0";
    return new Promise(function(o, t) {
        wx.uploadFile({
            url: n,
            filePath: e,
            name: "file",
            header: {},
            formData: {},
            success: function(e) {
                o(JSON.parse(e.data));
            },
            fail: function(e) {
                console.log("errror"), console.log(e), t(e);
            },
            complete: function(e) {}
        });
    });
}