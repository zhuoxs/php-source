var _xx_util = require("../../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../../resource/apis/index.js"), _xx_request = require("../../../../../resource/js/xx_request.js");

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
        });
        var t = _xx_util2.default.getPage(-1).data;
        console.log("prevPage", t);
        var r = app.globalData.isIphoneX, o = 30 * parseInt(t.post_user.name.length + 2), a = 20 * parseInt(t.post_user.job_name.length + 2) + "rpx";
        t.currentPoster = (0, _xx_request.formatImageUrl)(t.currentPoster), t.post_user.avatar = (0, 
        _xx_request.formatImageUrl)(t.post_user.avatar);
        var i = {
            width: "641rpx",
            height: "1066rpx",
            background: "#ffffff",
            views: [ {
                type: "image",
                url: t.currentPoster,
                css: {
                    top: "0rpx",
                    left: "0rpx",
                    width: "641rpx",
                    height: "855rpx",
                    rotate: 0,
                    borderRadius: 0
                }
            }, {
                type: "rect",
                css: {
                    top: "855rpx",
                    left: "0rpx",
                    color: "#ffffff",
                    borderRadius: 0,
                    borderWidth: 0,
                    width: "641rpx",
                    height: "214rpx"
                }
            }, {
                type: "image",
                url: t.post_user.avatar,
                css: {
                    top: "905rpx",
                    left: "45rpx",
                    width: "85rpx",
                    height: "85rpx",
                    mode: "scaleToFill",
                    rotate: 0,
                    borderRadius: "5rpx"
                }
            }, {
                type: "text",
                text: t.post_user.name,
                css: {
                    fontSize: "29rpx",
                    top: "915rpx",
                    left: "150rpx",
                    color: "#222222",
                    textDecoration: "none",
                    align: "left",
                    width: o + "rpx"
                }
            }, {
                type: "text",
                text: t.post_user.job_name,
                css: {
                    fontSize: "20rpx",
                    top: "925rpx",
                    left: o + 100 + "rpx",
                    color: "#676767",
                    textDecoration: "none",
                    align: "left",
                    width: a
                }
            }, {
                type: "text",
                text: "Tel " + t.post_user.phone,
                css: {
                    fontSize: "20rpx",
                    top: "957rpx",
                    left: "150rpx",
                    color: "#676767",
                    textDecoration: "none",
                    align: "left",
                    width: "300rpx"
                }
            }, {
                type: "text",
                text: t.post_company.name,
                css: {
                    fontSize: "20rpx",
                    top: "1011rpx",
                    left: "45rpx",
                    color: "#676767",
                    textDecoration: "none",
                    align: "left",
                    width: "330rpx"
                }
            }, {
                type: "image",
                url: t.post_user.qr_path,
                css: {
                    top: "891rpx",
                    left: "470rpx",
                    width: "112rpx",
                    height: "112rpx",
                    mode: "scaleToFill",
                    rotate: 0,
                    borderRadius: "0rpx"
                }
            }, {
                type: "text",
                text: "长按识别 访问名片",
                css: {
                    fontSize: "20rpx",
                    top: "1016rpx",
                    left: "441rpx",
                    color: "#323232",
                    textDecoration: "none",
                    align: "left",
                    width: "200rpx"
                }
            } ]
        };
        this.setData({
            template: i,
            isIphoneX: r
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
    changeImage: function() {
        wx.navigateBack();
    },
    saveImage: function() {
        var t = this;
        wx.authorize({
            scope: "scope.writePhotosAlbum",
            success: function(e) {
                wx.saveImageToPhotosAlbum({
                    filePath: t.data.imagePath,
                    success: function(e) {
                        console.log("保存名片成功 ==>", e), _xx_util2.default.showModal({
                            content: "励志海报保存成功，快去相册看看吧！"
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