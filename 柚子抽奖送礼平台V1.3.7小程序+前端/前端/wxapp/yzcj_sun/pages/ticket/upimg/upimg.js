var _weCropper = require("../we-cropper/we-cropper.js"), _weCropper2 = _interopRequireDefault(_weCropper);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var device = wx.getSystemInfoSync(), width = device.windowWidth, height = device.windowHeight - 50, app = getApp();

Page({
    data: {
        cropperOpt: {
            id: "cropper",
            width: width,
            height: height,
            scale: 2.5,
            zoom: 8,
            cut: {
                x: (width - 320) / 2,
                y: height - 320,
                width: 320,
                height: 177.92
            }
        }
    },
    touchStart: function(e) {
        this.wecropper.touchStart(e);
    },
    touchMove: function(e) {
        this.wecropper.touchMove(e);
    },
    touchEnd: function(e) {
        this.wecropper.touchEnd(e);
    },
    getCropperImage: function() {
        this.data.rad, this.data.rad2;
        this.wecropper.getCropperImage(function(o) {
            if (o) {
                var e = getCurrentPages(), t = e[e.length - 2], r = app.util.url("entry/wxapp/Toupload") + "&m=yzcj_sun";
                wx.uploadFile({
                    url: r,
                    filePath: o,
                    name: "file",
                    success: function(e) {
                        console.log("1111111" + e), console.log(e), t.setData({
                            imgSrc: o,
                            pic: e.data
                        });
                    }
                }), console.log(o + "avatar"), wx.navigateBack({
                    delta: 1
                });
            } else console.log("获取图片失败，请稍后重试");
        });
    },
    uploadTap: function() {
        var t = this;
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                var o = e.tempFilePaths[0];
                t.wecropper.pushOrign(o);
            }
        });
    },
    onLoad: function(e) {
        this.setData({
            rad: e.rad,
            rad2: e.rad2
        });
        var o = this.data.cropperOpt;
        e.src && (o.src = e.src, new _weCropper2.default(o).on("ready", function(e) {
            console.log("wecropper is ready for work!");
        }).on("beforeImageLoad", function(e) {
            console.log("before picture loaded, i can do something"), console.log("current canvas context:", e), 
            wx.showToast({
                title: "上传中",
                icon: "loading",
                duration: 2e4
            });
        }).on("imageLoad", function(e) {
            console.log("picture loaded"), console.log("current canvas context:", e), wx.hideToast();
        }).on("beforeDraw", function(e, o) {
            console.log("before canvas draw,i can do something"), console.log("current canvas context:", e);
        }).updateCanvas());
    }
});