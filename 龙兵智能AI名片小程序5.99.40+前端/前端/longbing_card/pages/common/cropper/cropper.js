var _weCropper = require("../../../templates/we-cropper/we-cropper.js"), _weCropper2 = _interopRequireDefault(_weCropper), _xx_util = require("../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../resource/apis/index.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        cropperOpt: {
            id: "cropper",
            scale: 2.5,
            zoom: 8,
            cut: ""
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
        var o = this.data.key;
        this.wecropper.getCropperImage(function(e) {
            _xx_util2.default.showLoading({
                title: "图片上传中"
            }), _index.baseModel.toUpload({
                filePath: e
            }).then(function(e) {
                _xx_util2.default.hideAll();
                var t = e, r = getCurrentPages();
                r[r.length - 2].handerImageChange(o, t), wx.navigateBack({
                    delta: 1
                });
            });
        });
    },
    uploadTap: function() {
        var r = this;
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                var t = e.tempFilePaths[0];
                console.log(e), r.wecropper.pushOrign(t);
            }
        });
    },
    initData: function() {},
    onLoad: function(e) {
        var t = e.ratio, r = e.src, o = e.key;
        e.c;
        this.setData({
            key: o || ""
        });
        var i = wx.getSystemInfoSync(), a = i.windowWidth, n = i.windowHeight - 50, u = {
            x: .1 * a,
            y: (n - .8 * a * (t = t || 4 / 3)) / 2,
            width: .8 * a,
            height: .8 * a * t
        };
        this.setData({
            "cropperOpt.width": a,
            "cropperOpt.height": n,
            "cropperOpt.cut": u
        });
        var p = this.data.cropperOpt;
        new _weCropper2.default(p).on("ready", function(e) {}).on("beforeImageLoad", function(e) {
            wx.showToast({
                title: "上传中",
                icon: "loading",
                duration: 2e4
            });
        }).on("imageLoad", function(e) {
            wx.hideToast();
        }).on("beforeDraw", function(e, t) {}).updateCanvas(), r && this.wecropper.pushOrign(r);
    }
});