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
        var t = this;
        wx.hideShareMenu(), setTimeout(function() {
            _xx_util2.default.showLoading({
                title: "海报生成中"
            });
        }, 300);
        var r = _xx_util2.default.getPage(-1).data;
        console.log("prevPage", r);
        var o = r.detailData.staff_company_info.name;
        20 < o.length && (o = o.slice(0, 20) + "...");
        var i = r.shareParamObj;
        18 < i.name.length && (i.name = i.name.slice(0, 18) + "...");
        var a = r.shareParamObj2;
        a.price = (1 * a.price).toFixed(2);
        var p, n = a.price;
        if (1e4 < n && 1e4 != n) {
            var l = _xx_util2.default.getNormalPrice(parseInt(n / 1e4).toFixed(4));
            a.price = l.toString() + "万", p = 22 * parseInt(a.price.length) + 20;
        } else p = 22 * parseInt(a.price.toString().length), 0 == n && (a.price = getApp().globalData.configInfo.config.btn_talk || "面议", 
        p = 22 * parseInt(a.price.toString().length) + 50);
        var x = 22 * parseInt(a.people.length), s = parseInt(p).toString() + "rpx", c = parseInt(p + 45).toString() + "rpx", f = parseInt(x + 70).toString() + "rpx", u = getApp().globalData.isIphoneX;
        i.cover_true = (0, _xx_request.formatImageUrl)(i.cover_true), wx.hideShareMenu(), 
        setTimeout(function() {
            var e = {
                width: "612rpx",
                height: "987rpx",
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
                    text: o,
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
                        height: "97rpx"
                    }
                }, {
                    type: "text",
                    text: i.name,
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
                    text: "￥",
                    css: {
                        fontSize: "24rpx",
                        top: "130rpx",
                        left: "20rpx",
                        color: "#e93636",
                        bold: "bold",
                        textDecoration: "none",
                        align: "left",
                        width: "20rpx"
                    }
                }, {
                    type: "text",
                    text: a.price,
                    css: {
                        fontSize: "36rpx",
                        top: "120rpx",
                        left: "48rpx",
                        color: "#e93636",
                        bold: "bold",
                        textDecoration: "none",
                        align: "left",
                        width: s
                    }
                }, {
                    type: "text",
                    text: a.people + "人拼团",
                    css: {
                        fontSize: "24rpx",
                        top: "130rpx",
                        left: c,
                        color: "#e93636",
                        bold: "bold",
                        textDecoration: "none",
                        align: "left",
                        width: f
                    }
                }, {
                    type: "text",
                    text: "已拼" + i.collage_count,
                    css: {
                        fontSize: "24rpx",
                        top: "130rpx",
                        right: "20rpx",
                        color: "#313131",
                        bold: "bold",
                        textDecoration: "none",
                        align: "right",
                        width: "680rpx"
                    }
                }, {
                    type: "image",
                    url: i.cover_true,
                    css: {
                        top: "178rpx",
                        left: "0rpx",
                        width: "612rpx",
                        height: "612rpx",
                        mode: "scaleToFill",
                        rotate: 0,
                        borderRadius: 0
                    }
                }, {
                    type: "rect",
                    css: {
                        top: "786rpx",
                        left: "2rpx",
                        color: "#ffffff",
                        borderRadius: "5rpx",
                        width: "612rpx",
                        height: "200rpx"
                    }
                }, {
                    type: "image",
                    url: i.qr,
                    css: {
                        top: "808rpx",
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
                        top: "850rpx",
                        left: "300rpx",
                        color: "#313131",
                        bold: "bold",
                        textDecoration: "none",
                        align: "left",
                        width: "300rpx"
                    }
                }, {
                    type: "text",
                    text: "超值好货一起拼",
                    css: {
                        fontSize: "24rpx",
                        top: "900rpx",
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
                isIphoneX: u
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