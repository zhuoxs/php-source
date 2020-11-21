function o(o) {
    return o && o.__esModule ? o : {
        default: o
    };
}

var e = o(require("../../util/we-cropper.js")), t = o(require("../../util/request.js")), n = require("../../util/image.js"), c = wx.getSystemInfoSync(), r = c.windowWidth, i = c.windowHeight - 50;

Page({
    data: {
        cropperOpt: {
            id: "cropper",
            width: r,
            height: i,
            scale: 2.5,
            zoom: 8,
            cut: {
                x: (r - 300) / 2,
                y: (i - 300) / 2,
                width: 300,
                height: 300
            }
        }
    },
    touchStart: function(o) {
        this.wecropper.touchStart(o);
    },
    touchMove: function(o) {
        this.wecropper.touchMove(o);
    },
    touchEnd: function(o) {
        this.wecropper.touchEnd(o);
    },
    getCropperImage: function() {
        var o = this;
        this.wecropper.getCropperImage(function(e) {
            e ? (console.log(e), (0, n.upload)(e).then(function(e) {
                console.log(e);
                var n = o.data.user.id, c = e.filename;
                t.default.post("myinfo", {
                    op: "postheadpic",
                    userid: n,
                    headpic: c
                }).then(function(o) {
                    wx.showModal({
                        title: "提示",
                        content: "修改成功！",
                        showCancel: !1,
                        success: function(o) {
                            o.confirm && wx.redirectTo({
                                url: "../my/myinfo"
                            });
                        }
                    });
                }, function(o) {
                    wx.showModal({
                        title: "提示",
                        content: o,
                        showCancel: !1,
                        success: function(o) {
                            o.confirm && wx.redirectTo({
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
        var o = this;
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                var t = e.tempFilePaths[0];
                o.wecropper.pushOrign(t);
            }
        });
    },
    onLoad: function(o) {
        var t = wx.getStorageSync("user") || null;
        this.setData({
            user: t
        }), null == t && wx.redirectTo({
            url: "../login/login"
        });
        var n = this.data.cropperOpt;
        o.src && (n.src = o.src, new e.default(n).on("ready", function(o) {
            console.log("wecropper is ready for work!");
        }).on("beforeImageLoad", function(o) {
            console.log("before picture loaded, i can do something"), console.log("current canvas context:", o), 
            wx.showToast({
                title: "上传中",
                icon: "loading",
                duration: 2e4
            });
        }).on("imageLoad", function(o) {
            console.log("picture loaded"), console.log("current canvas context:", o), wx.hideToast();
        }).on("beforeDraw", function(o, e) {
            console.log("before canvas draw,i can do something"), console.log("current canvas context:", o);
        }).updateCanvas());
    }
});