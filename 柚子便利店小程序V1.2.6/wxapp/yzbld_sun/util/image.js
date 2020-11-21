Object.defineProperty(exports, "__esModule", {
    value: !0
}), exports.chooseImage = chooseImage, exports.upload = upload;

var app = getApp();

function chooseImage() {
    return new Promise(function(o, n) {
        wx.chooseImage({
            count: 1,
            success: function(e) {
                o(e.tempFilePaths[0]);
            },
            fail: function(e) {
                n(e);
            }
        });
    });
}

function upload(e) {
    var o = app.siteInfo.siteroot, t = (o = o.replace("app/index.php", "web/index.php")) + "?i=" + app.siteInfo.uniacid + "&c=utility&a=file&do=upload&thumb=0";
    return new Promise(function(o, n) {
        wx.uploadFile({
            url: t,
            filePath: e,
            name: "file",
            header: {},
            formData: {},
            success: function(e) {
                console.log("success"), console.log(e), o(JSON.parse(e.data));
            },
            fail: function(e) {
                console.log("errror"), console.log(e), n(e);
            },
            complete: function(e) {}
        });
    });
}