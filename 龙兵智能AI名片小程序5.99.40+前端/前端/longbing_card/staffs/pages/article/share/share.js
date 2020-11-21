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
        template: {}
    },
    onLoad: function(e) {
        _xx_util2.default.showLoading({
            title: "海报生成中"
        }), wx.hideShareMenu();
        var t = _xx_util2.default.getPage(-1).data, r = t.optionsParam, i = (t.staffInfo, 
        t.article), o = t.qr, a = i.id, x = i.title, l = i.cover, p = wx.getStorageSync("user"), n = p.avatarUrl, s = p.nickName;
        l = (0, _xx_request.formatImageUrl)(l), n = (0, _xx_request.formatImageUrl)(n);
        var c = 31;
        10 < s.length && (s = s.slice(0, 10) + "...", c = 25), 27 < x.length && (x = x.slice(0, 27) + "...");
        var u = r.uid, d = getApp().globalData.isIphoneX, f = {
            width: "750rpx",
            height: "1080rpx",
            background: "#ffffff",
            views: [ {
                type: "image",
                url: l,
                css: {
                    width: "750rpx",
                    height: "420rpx",
                    top: "0rpx",
                    left: "0rpx"
                }
            }, {
                type: "image",
                url: n,
                css: {
                    top: "470rpx",
                    left: "70rpx",
                    width: "60rpx",
                    height: "60rpx",
                    mode: "scaleToFill",
                    rotate: 0,
                    borderRadius: "60rpx"
                }
            }, {
                type: "text",
                text: s,
                css: {
                    fontSize: "28rpx",
                    top: "480rpx",
                    left: "150rpx",
                    color: "#1b1b1b",
                    textDecoration: "none",
                    align: "left",
                    width: "480rpx"
                }
            }, {
                type: "text",
                text: "正在阅读这篇文章",
                css: {
                    fontSize: "28rpx",
                    top: "480rpx",
                    left: s.length * c + 150 + "rpx",
                    color: "#888888",
                    textDecoration: "none",
                    align: "left",
                    width: "480rpx"
                }
            }, {
                type: "text",
                text: x,
                css: {
                    fontSize: "40rpx",
                    top: "550rpx",
                    left: "70rpx",
                    color: "#333333",
                    textDecoration: "none",
                    lineHeight: "50rpx",
                    align: "left",
                    width: "610rpx"
                }
            }, {
                type: "rect",
                css: {
                    top: "690rpx",
                    left: "0rpx",
                    color: "#eeeeee",
                    borderRadius: "0rpx",
                    borderWidth: 0,
                    width: "750rpx",
                    height: "1rpx"
                }
            }, {
                type: "image",
                url: o,
                css: {
                    top: "780rpx",
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
                    top: "760rpx",
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
                    top: "950rpx",
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
                    top: "985rpx",
                    left: "400rpx",
                    color: "#969696",
                    textDecoration: "none",
                    align: "left",
                    width: "300rpx"
                }
            }, {
                type: "text",
                text: "文章详情",
                css: {
                    fontSize: "26rpx",
                    top: "985rpx",
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
                    top: "985rpx",
                    left: "577rpx",
                    color: "#969696",
                    textDecoration: "none",
                    align: "left",
                    width: "300rpx"
                }
            } ]
        };
        this.setData({
            template: f,
            id: a,
            to_uid: u,
            article: i,
            isIphoneX: d
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
        var p = this;
        wx.authorize({
            scope: "scope.writePhotosAlbum",
            success: function(e) {
                wx.saveImageToPhotosAlbum({
                    filePath: p.data.imagePath,
                    success: function(e) {
                        var t = p.data, r = t.id, i = t.to_uid, o = t.article, a = o.is_staff, x = o.need_confirm, l = o.my_article_id;
                        _index.pluginModel.toArticleShare({
                            id: r,
                            to_uid: i,
                            type: 2
                        }), 1 == a && 1 == x && _index.pluginModel.toConfirmSync({
                            article_id: l
                        }), _xx_util2.default.showModal({
                            content: "文章海报保存成功，快去相册看看吧！"
                        });
                    },
                    fail: function(e) {
                        console.log("fail ==> ", e);
                    }
                });
            },
            fail: function(e) {
                p.setData({
                    isSetting: !0
                });
            }
        });
    }
});