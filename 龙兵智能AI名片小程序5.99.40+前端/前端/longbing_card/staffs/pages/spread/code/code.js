var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js"), _xx_request = require("../../../../resource/js/xx_request.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    imagePath: "",
    data: {
        id: "",
        template: {},
        name: "",
        avatar: "",
        qrImg: ""
    },
    onLoad: function(e) {
        console.log("onLoad ==>", this);
        wx.hideShareMenu(), _xx_util2.default.showLoading({
            title: "海报生成中"
        });
        var t = e.id, a = _xx_util2.default.getPage(-1).data.cardIndexData.info, r = a.avatar_2, o = a.name;
        r = (0, _xx_request.formatImageUrl)(r);
        var i = app.globalData.isIphoneX;
        this.toGetQR(t, i, r, o);
    },
    toGetQR: function(e, o, i, n) {
        var l = this;
        _index.staffModel.getCodeQr({
            id: e
        }).then(function(e) {
            var t = e.data, a = "";
            88 < t.content.length && (a = "..."), t.content = t.content.slice(0, 88) + a;
            var r = {
                width: "670rpx",
                height: "840rpx",
                background: "#ffffff",
                borderRadius: "0rpx",
                views: [ {
                    type: "rect",
                    css: {
                        top: "0rpx",
                        left: "0rpx",
                        color: "#faf8f5",
                        borderRadius: 0,
                        borderWidth: 0,
                        width: "670rpx",
                        height: "293rpx"
                    }
                }, {
                    type: "image",
                    url: i,
                    css: {
                        top: "44rpx",
                        left: "22rpx",
                        width: "92rpx",
                        height: "92rpx",
                        mode: "scaleToFill",
                        rotate: 0,
                        borderRadius: "92rpx"
                    }
                }, {
                    type: "text",
                    text: n,
                    css: {
                        fontSize: "30rpx",
                        top: "65rpx",
                        left: "130rpx",
                        color: "#2b2b2b",
                        textDecoration: "none",
                        align: "left",
                        width: "540rpx"
                    }
                }, {
                    type: "text",
                    text: t.content,
                    css: {
                        fontSize: "28rpx",
                        top: "155rpx",
                        left: "26rpx",
                        color: "#333333",
                        textDecoration: "none",
                        align: "left",
                        width: "610rpx"
                    }
                }, {
                    type: "image",
                    url: t.path,
                    css: {
                        top: "363rpx",
                        left: "142rpx",
                        width: "396rpx",
                        height: "396rpx",
                        mode: "scaleToFill",
                        rotate: 0,
                        borderRadius: 0
                    }
                } ]
            };
            l.setData({
                template: r,
                isIphoneX: o
            });
        });
    },
    onImgOK: function(e) {
        this.setData({
            imagePath: e.detail.path
        }), wx.hideLoading(), console.log(e);
    },
    previewImage: function() {
        var e = this.data.imagePath, t = [];
        t.push(e), wx.previewImage({
            current: e,
            urls: t
        });
    },
    saveImage: function() {
        wx.saveImageToPhotosAlbum({
            filePath: this.data.imagePath,
            success: function(e) {
                console.log("保存自定义码成功 ==>", e), _xx_util2.default.showModal({
                    content: "自定义码保存成功，快去相册看看吧！"
                });
            },
            fail: function(e) {
                console.log("fail ==> ", e);
            }
        });
    }
});