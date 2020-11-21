var _weCropper = require("../../util/we-cropper.js"), _weCropper2 = _interopRequireDefault(_weCropper), _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request), _image = require("../../util/image.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var device = wx.getSystemInfoSync(), width = device.windowWidth, height = device.windowHeight - 50;

Page({
    data: {
        cropperOpt: {
            id: "cropper",
            width: width,
            height: height,
            scale: 2.5,
            zoom: 8,
            cut: {
                x: (width - 300) / 2,
                y: (height - 300) / 2,
                width: 300,
                height: 300
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
        var r = this;
        this.wecropper.getCropperImage(function(e) {
            e ? (console.log(e), (0, _image.upload)(e).then(function(e) {
                console.log(e);
                var o = r.data.user.id, t = e.filename;
                _request2.default.post("myinfo", {
                    op: "postheadpic",
                    userid: o,
                    headpic: t
                }).then(function(e) {
                    wx.showModal({
                        title: "提示",
                        content: "修改成功！",
                        showCancel: !1,
                        success: function(e) {
                            e.confirm && wx.redirectTo({
                                url: "../my/myinfo"
                            });
                        }
                    });
                }, function(e) {
                    wx.showModal({
                        title: "提示",
                        content: e,
                        showCancel: !1,
                        success: function(e) {
                            e.confirm && wx.redirectTo({
                                url: "../my/myinfo"
                            });
                        }
                    });
                });
            })) : wx.showToast({
                title: "获取图片失败，请稍后重试"
            });
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
        var o = wx.getStorageSync("user") || null;
        this.setData({
            user: o
        }), null == o && wx.redirectTo({
            url: "../login/login"
        });
        var t = this.data.cropperOpt;
        e.src && (t.src = e.src, new _weCropper2.default(t).on("ready", function(e) {
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