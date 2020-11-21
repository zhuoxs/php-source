var _xx_util = require("../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../resource/apis/index.js"), _xx_request = require("../../../resource/js/xx_request.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    imagePath: "",
    data: {
        template: {}
    },
    onLoad: function(e) {
        _xx_util2.default.showLoading({
            title: "海报生成中"
        }), wx.hideShareMenu();
        var t = _xx_util2.default.getPage(-1).data.data, r = t.id, i = t.title, o = t.cover, a = t.qr;
        o = (0, _xx_request.formatImageUrl)(o), a = (0, _xx_request.formatImageUrl)(a), 
        37 < i.length && (i = i.slice(0, 37) + "...");
        var x = getApp().globalData.isIphoneX, l = {
            width: "750rpx",
            height: "980rpx",
            background: "#ffffff",
            views: [ {
                type: "image",
                url: o,
                css: {
                    width: "750rpx",
                    height: "420rpx",
                    top: "0rpx",
                    left: "0rpx"
                }
            }, {
                type: "text",
                text: i,
                css: {
                    fontSize: "34rpx",
                    top: "450rpx",
                    left: "40rpx",
                    color: "#333333",
                    textDecoration: "none",
                    lineHeight: "40rpx",
                    align: "left",
                    width: "650rpx"
                }
            }, {
                type: "rect",
                css: {
                    top: "560rpx",
                    left: "0rpx",
                    color: "#eeeeee",
                    borderRadius: "0rpx",
                    borderWidth: 0,
                    width: "750rpx",
                    height: "1rpx"
                }
            }, {
                type: "image",
                url: a,
                css: {
                    top: "670rpx",
                    left: "80rpx",
                    width: "220rpx",
                    height: "220rpx",
                    mode: "scaleToFill",
                    rotate: 0,
                    borderRadius: 0
                }
            }, {
                type: "image",
                url: "/longbing_card/resource/images/icon-fingerprint.png",
                css: {
                    top: "650rpx",
                    left: "460rpx",
                    width: "160rpx",
                    height: "160rpx",
                    mode: "scaleToFill",
                    rotate: 0,
                    borderRadius: 0
                }
            }, {
                type: "text",
                text: "扫描或长按识别",
                css: {
                    fontSize: "26rpx",
                    top: "840rpx",
                    left: "450rpx",
                    color: "#969696",
                    textDecoration: "none",
                    align: "text",
                    width: "300rpx"
                }
            }, {
                type: "text",
                text: "进入",
                css: {
                    fontSize: "26rpx",
                    top: "875rpx",
                    left: "400rpx",
                    color: "#969696",
                    textDecoration: "none",
                    align: "left",
                    width: "300rpx"
                }
            }, {
                type: "text",
                text: "活动详情",
                css: {
                    fontSize: "26rpx",
                    top: "875rpx",
                    left: "462rpx",
                    color: "#ee234e",
                    textDecoration: "none",
                    align: "left",
                    width: "300rpx"
                }
            }, {
                type: "text",
                text: "阅读全文",
                css: {
                    fontSize: "26rpx",
                    top: "875rpx",
                    left: "577rpx",
                    color: "#969696",
                    textDecoration: "none",
                    align: "left",
                    width: "300rpx"
                }
            } ]
        };
        this.setData({
            template: l,
            id: r,
            enroll: t,
            isIphoneX: x
        });
    },
    onImgOK: function(e) {
        this.setData({
            imagePath: e.detail.path
        }), _xx_util2.default.hideAll(), console.log(e);
    },
    previewImage: function() {
        var e = this.data.imagePath, t = [];
        t.push(e), wx.previewImage({
            current: e,
            urls: t
        });
    },
    saveImage: function() {
        var t = this;
        wx.authorize({
            scope: "scope.writePhotosAlbum",
            success: function(e) {
                wx.saveImageToPhotosAlbum({
                    filePath: t.data.imagePath,
                    success: function(e) {
                        _xx_util2.default.showModal({
                            content: "海报保存成功，快去相册看看吧！"
                        });
                    },
                    fail: function(e) {
                        console.log("fail ==> ", e);
                    }
                });
            },
            fail: function(e) {
                t.setData({
                    isSetting: !0
                });
            }
        });
    }
});