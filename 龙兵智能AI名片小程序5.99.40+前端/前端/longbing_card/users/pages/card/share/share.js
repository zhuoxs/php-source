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
        });
        var t = _xx_util2.default.getPage(-1).data;
        console.log("prevPage", t);
        var r = getApp().globalData, o = r.to_uid, a = r.isIphoneX, i = r.configInfo, n = t.cardIndexData.info, p = n.job_name, l = n.myCompany.name;
        17 < p.length && (p = p.slice(0, 17) + "..."), 35 < l.length && (l = l.slice(0, 35) + "..."), 
        t.cardIndexData.info.avatar_2 = (0, _xx_request.formatImageUrl)(t.cardIndexData.info.avatar_2);
        var x = {
            width: "750rpx",
            height: "800rpx",
            background: "#ffffff",
            views: [ {
                type: "image",
                url: "/longbing_card/resource/images/icon-shareimg.png",
                css: {
                    top: "20rpx",
                    left: "8rpx",
                    width: "734rpx",
                    height: "460rpx",
                    rotate: 0,
                    borderRadius: 0
                }
            }, {
                type: "rect",
                css: {
                    top: "100rpx",
                    left: "80rpx",
                    color: "#e0e0e1",
                    borderRadius: "96rpx",
                    borderWidth: 0,
                    width: "96rpx",
                    height: "96rpx"
                }
            }, {
                type: "image",
                url: t.cardIndexData.info.avatar_2,
                css: {
                    top: "96rpx",
                    left: "80rpx",
                    width: "96rpx",
                    height: "96rpx",
                    mode: "scaleToFill",
                    rotate: 0,
                    borderRadius: "96rpx"
                }
            }, {
                type: "text",
                text: t.cardIndexData.info.name,
                css: {
                    fontSize: "30rpx",
                    top: "100rpx",
                    left: "206rpx",
                    color: "#000000",
                    textDecoration: "none",
                    align: "left",
                    width: "480rpx"
                }
            }, {
                type: "text",
                text: p,
                css: {
                    fontSize: "26rpx",
                    top: "140rpx",
                    left: "206rpx",
                    color: "#969696",
                    textDecoration: "none",
                    align: "left",
                    width: "480rpx"
                }
            }, {
                type: "text",
                text: l,
                css: {
                    fontSize: "26rpx",
                    top: "175rpx",
                    left: "206rpx",
                    color: "#969696",
                    textDecoration: "none",
                    align: "left",
                    width: "480rpx"
                }
            }, {
                type: "image",
                url: "/longbing_card/resource/images/tel.png",
                css: {
                    top: "265rpx",
                    left: "80rpx",
                    width: "30rpx",
                    height: "30rpx",
                    mode: "scaleToFill",
                    rotate: 0,
                    borderRadius: 0
                }
            }, {
                type: "text",
                text: t.cardIndexData.info.phone,
                css: {
                    fontSize: "26rpx",
                    top: "260rpx",
                    left: "130rpx",
                    color: "#969696",
                    textDecoration: "none",
                    align: "left",
                    width: "600rpx"
                }
            }, {
                type: "image",
                url: "/longbing_card/resource/images/wechat.png",
                css: {
                    top: "303rpx",
                    left: "80rpx",
                    width: "30rpx",
                    height: "30rpx",
                    mode: "scaleToFill",
                    rotate: 0,
                    borderRadius: 0
                }
            }, {
                type: "text",
                text: t.cardIndexData.info.wechat,
                css: {
                    fontSize: "26rpx",
                    top: "300rpx",
                    left: "130rpx",
                    color: "#969696",
                    textDecoration: "none",
                    align: "left",
                    width: "600rpx"
                }
            }, {
                type: "image",
                url: "/longbing_card/resource/images/map.png",
                css: {
                    top: "343rpx",
                    left: "80rpx",
                    width: "30rpx",
                    height: "30rpx",
                    mode: "scaleToFill",
                    rotate: 0,
                    borderRadius: 0
                }
            }, {
                type: "text",
                text: t.cardIndexData.info.myCompany.addrMore,
                css: {
                    fontSize: "26rpx",
                    top: "340rpx",
                    left: "130rpx",
                    color: "#969696",
                    textDecoration: "none",
                    align: "left",
                    width: "550rpx"
                }
            }, {
                type: "image",
                url: t.cardIndexData.avatar_qr,
                css: {
                    top: "520rpx",
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
                    top: "520rpx",
                    left: "460rpx",
                    width: "160rpx",
                    height: "160rpx",
                    mode: "scaleToFill",
                    rotate: 0,
                    borderRadius: 0
                }
            }, {
                type: "text",
                text: "扫描或长按识别 收下名片",
                css: {
                    fontSize: "26rpx",
                    top: "710rpx",
                    left: "395rpx",
                    color: "#969696",
                    textDecoration: "none",
                    align: "left",
                    width: "300rpx"
                }
            } ]
        };
        this.setData({
            template: x,
            to_uid: o,
            isIphoneX: a,
            copyright: i.config
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
    getForwardRecord: function(e, t) {
        var r = {
            type: e,
            to_uid: app.globalData.to_uid
        };
        2 != e && 3 != e || (r.target_id = t), _index.userModel.getForwardRecord(r).then(function(e) {
            _xx_util2.default.hideAll();
        });
    },
    getShareRecord: function() {
        var e = {
            to_uid: app.globalData.to_uid
        };
        _index.userModel.getShareRecord(e).then(function(e) {
            _xx_util2.default.hideAll();
        });
    },
    getCopyRecord: function(e) {
        var t = {
            type: 10,
            to_uid: app.globalData.to_uid
        };
        _index.userModel.getCopyRecord(t).then(function(e) {
            _xx_util2.default.hideAll();
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
                        app.globalData.to_uid != wx.getStorageSync("userid") && t.getCopyRecord(), console.log("保存名片成功 ==>", e), 
                        _xx_util2.default.showModal({
                            content: "名片海报保存成功，快去相册看看吧！"
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