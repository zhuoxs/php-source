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
        var t = this;
        wx.hideShareMenu(), setTimeout(function() {
            _xx_util2.default.showLoading({
                title: "海报生成中"
            });
        }, 300);
        var r = _xx_util2.default.getPage(-1).data;
        console.log("prevPage", r);
        var o = r.data, i = o.title, a = o.desc, p = o.cover, x = o.appoint_price, l = o.qr, n = o.staff_company_info.name;
        20 < n.length && (n = n.substr(0, 20) + "..."), 18 < i.length && (i = i.substr(0, 18) + "..."), 
        22 < a.length && (a = a.substr(0, 22) + "...");
        var s = getApp().globalData.isIphoneX;
        p = (0, _xx_request.formatImageUrl)(p), wx.hideShareMenu(), setTimeout(function() {
            var e = {
                width: "612rpx",
                height: "1027rpx",
                background: "#e1e1e1",
                views: [ {
                    type: "image",
                    url: "/longbing_card/resource/images/icon-productBg.jpg",
                    css: {
                        top: "0rpx",
                        left: "0rpx",
                        width: "612rpx",
                        height: "82rpx",
                        rotate: 0,
                        borderRadius: 0
                    }
                }, {
                    type: "text",
                    text: n,
                    css: {
                        fontSize: "28rpx",
                        top: "10rpx",
                        left: "306rpx",
                        color: "#ffffff",
                        bold: "bold",
                        textDecoration: "none",
                        align: "center",
                        width: "572rpx"
                    }
                }, {
                    type: "rect",
                    css: {
                        top: "82rpx",
                        left: "0rpx",
                        color: "#ffffff",
                        borderRadius: "0rpx",
                        width: "612rpx",
                        height: "137rpx"
                    }
                }, {
                    type: "text",
                    text: i,
                    css: {
                        fontSize: "30rpx",
                        top: "78rpx",
                        left: "20rpx",
                        color: "#313131",
                        bold: "bold",
                        textDecoration: "none",
                        align: "left",
                        width: "572rpx"
                    }
                }, {
                    type: "text",
                    text: a,
                    css: {
                        fontSize: "24rpx",
                        top: "118rpx",
                        left: "20rpx",
                        color: "#969696",
                        bold: "bold",
                        textDecoration: "none",
                        align: "left",
                        width: "572rpx"
                    }
                }, {
                    type: "text",
                    text: x,
                    css: {
                        fontSize: "36rpx",
                        top: "160rpx",
                        left: "20rpx",
                        color: "#e93636",
                        bold: "bold",
                        textDecoration: "none",
                        align: "left",
                        width: "200rpx"
                    }
                }, {
                    type: "image",
                    url: p,
                    css: {
                        top: "227rpx",
                        left: "9rpx",
                        width: "594rpx",
                        height: "594rpx",
                        mode: "scaleToFill",
                        rotate: 0,
                        borderRadius: 0
                    }
                }, {
                    type: "rect",
                    css: {
                        top: "826rpx",
                        left: "2rpx",
                        color: "#ffffff",
                        borderRadius: "5rpx",
                        width: "612rpx",
                        height: "240rpx"
                    }
                }, {
                    type: "image",
                    url: l,
                    css: {
                        top: "848rpx",
                        left: "78rpx",
                        width: "158rpx",
                        height: "158rpx",
                        mode: "scaleToFill",
                        rotate: 0,
                        borderRadius: 0
                    }
                }, {
                    type: "text",
                    text: "长按识别小程序码",
                    css: {
                        fontSize: "30rpx",
                        top: "890rpx",
                        left: "300rpx",
                        color: "#313131",
                        bold: "bold",
                        textDecoration: "none",
                        align: "left",
                        width: "300rpx"
                    }
                }, {
                    type: "text",
                    text: "了解详情",
                    css: {
                        fontSize: "24rpx",
                        top: "940rpx",
                        left: "300rpx",
                        color: "#313131",
                        bold: "bold",
                        textDecoration: "none",
                        align: "left",
                        width: "300rpx"
                    }
                } ]
            };
            t.setData({
                template: e,
                isIphoneX: s
            });
        }, 3e3);
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
        var t = this;
        wx.authorize({
            scope: "scope.writePhotosAlbum",
            success: function(e) {
                wx.saveImageToPhotosAlbum({
                    filePath: t.data.imagePath,
                    success: function(e) {
                        console.log("保存海报成功 ==>", e), _xx_util2.default.showModal({
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