var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _xx_request = require("../../../../resource/js/xx_request.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    imagePath: "",
    data: {
        template: {},
        shareData: {},
        qrImg: ""
    },
    onLoad: function(t) {
        var r = this;
        setTimeout(function() {
            _xx_util2.default.showLoading({
                title: "海报生成中"
            });
        }, 300);
        var e = _xx_util2.default.getPage(-1).data;
        console.log("prevPage", e);
        var o = e.shareParamObj, i = e.price_switch, p = e.detailData.staff_company_info.name;
        20 < p.length && (p = p.substr(0, 20) + "..."), o.s_title = e.detailData.s_title, 
        18 < o.name.length && (o.name = o.name.substr(0, 18) + "..."), 23 < o.s_title.length && (o.s_title = o.s_title.substr(0, 23) + "...");
        var a = _xx_util2.default.getNormalPrice((o.price / 1e4).toFixed(4)), l = void 0, x = !1;
        1 == i ? 1 < a || 1 == a ? (o.price = a + "万", l = 22 * parseInt(o.price.length) + 60 + "rpx") : (l = 22 * parseInt(o.price.length) + 40 + "rpx", 
        0 == o.price && (o.price = getApp().globalData.configInfo.config.btn_talk || "面议", 
        l = 40 * parseInt(o.price.length) + 20 + "rpx", x = !0)) : o.price = getApp().globalData.configInfo.config.btn_talk || "面议";
        var n = getApp().globalData.isIphoneX;
        o.cover_true = (0, _xx_request.formatImageUrl)(o.cover_true);
        var s = void 0, c = void 0, f = void 0, d = void 0, u = void 0, g = void 0, h = void 0, _ = void 0, b = void 0, m = void 0;
        o.s_title ? (s = "137rpx", c = "219rpx", f = "831rpx", d = "285rpx", u = "853rpx", 
        g = "895rpx", h = "945rpx", _ = "175rpx", b = "165rpx", m = "1032rpx") : (s = "97rpx", 
        c = "179rpx", f = "791rpx", d = "245rpx", u = "813rpx", g = "855rpx", h = "905rpx", 
        _ = "135rpx", b = "125rpx", m = "992rpx"), setTimeout(function() {
            var t = [ {
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
                text: p,
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
                    height: s
                }
            }, {
                type: "text",
                text: o.name,
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
                type: "image",
                url: o.cover_true,
                css: {
                    top: c,
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
                    top: f,
                    left: "0rpx",
                    color: "#ffffff",
                    borderRadius: "0rpx",
                    width: "612rpx",
                    height: d
                }
            }, {
                type: "image",
                url: o.qr,
                css: {
                    top: u,
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
                    top: g,
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
                    top: h,
                    left: "300rpx",
                    color: "#313131",
                    bold: "bold",
                    textDecoration: "none",
                    align: "left",
                    width: "300rpx"
                }
            } ];
            o.s_title && t.push({
                type: "text",
                text: o.s_title,
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
            }), 1 == i && 0 == x ? t.push({
                type: "text",
                text: "￥",
                css: {
                    fontSize: "24rpx",
                    top: _,
                    left: "20rpx",
                    color: "#e93636",
                    bold: "bold",
                    textDecoration: "none",
                    align: "left",
                    width: "20rpx"
                }
            }, {
                type: "text",
                text: o.price,
                css: {
                    fontSize: "36rpx",
                    top: b,
                    left: "50rpx",
                    color: "#e93636",
                    bold: "bold",
                    textDecoration: "none",
                    align: "left",
                    width: "266rpx"
                }
            }, {
                type: "text",
                text: "/" + o.unit,
                css: {
                    fontSize: "24rpx",
                    top: _,
                    left: l,
                    color: "#e93636",
                    bold: "bold",
                    textDecoration: "none",
                    align: "left",
                    width: "200rpx"
                }
            }) : t.push({
                type: "text",
                text: o.price,
                css: {
                    fontSize: "24rpx",
                    top: b,
                    left: "20rpx",
                    color: "#e93636",
                    bold: "bold",
                    textDecoration: "none",
                    align: "left",
                    width: "266rpx"
                }
            });
            var e = {
                width: "612rpx",
                height: m,
                background: "#e1e1e1",
                views: t
            };
            r.setData({
                template: e,
                isIphoneX: n
            });
        }, 3e3);
    },
    onImgOK: function(t) {
        this.setData({
            imagePath: t.detail.path
        }), wx.hideLoading(), console.log(t);
    },
    previewImage: function() {
        var t = this.data.imagePath, e = [];
        e.push(t), wx.previewImage({
            current: t,
            urls: e
        });
    },
    saveImage: function() {
        var e = this;
        console.log("点击保存海报"), wx.authorize({
            scope: "scope.writePhotosAlbum",
            success: function(t) {
                wx.saveImageToPhotosAlbum({
                    filePath: e.data.imagePath,
                    success: function(t) {
                        console.log("保存商品海报成功 ==>", t), _xx_util2.default.showModal({
                            content: "海报保存成功，快去相册看看吧！"
                        });
                    },
                    fail: function(t) {
                        console.log("fail ==> ", t);
                    }
                });
            },
            fail: function(t) {
                e.setData({
                    isSetting: !0
                });
            }
        });
    }
});