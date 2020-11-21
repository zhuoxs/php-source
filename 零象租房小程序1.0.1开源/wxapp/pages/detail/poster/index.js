var a = getApp();

Page({
    data: {
        cvtype: !1,
        headimg: "",
        headtemp: "",
        carsimg: "",
        carstemp: "",
        qrcodeimg: "",
        qrcodetemp: "",
        nickname: "",
        propaganda1: "",
        propaganda11: "房源信息",
        propaganda2: "",
        qrstr: "识别上方二维码，进入小程序查看房源详情",
        makeinnum: 1,
        enddelimg: [],
        loaddata: "",
        isShow: !1,
        id: "",
        tupianjiazai: 0
    },
    hideDialog: function() {
        this.setData({
            isShow: !this.data.isShow
        });
    },
    updateUserInfo: function(a) {
        var t = this;
        t.hideDialog(), t.reload();
    },
    onLoad: function(a) {
        var t = this;
        t.setData({
            id: a.id
        }), t.reload();
    },
    onShow: function() {},
    reload: function() {
        var t = this, e = t.data.id;
        a.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reathouse",
                id: e,
                r: "detail.getshareimg"
            },
            cachetime: "0",
            success: function(a) {
                "" != a.data.data.carimg ? wx.downloadFile({
                    url: t.backimg(a.data.data.carimg),
                    success: function(a) {
                        console.log(a), t.data.carstemp = a.tempFilePath, t.setData({
                            tupianjiazai: t.data.tupianjiazai + 1
                        }), console.log(t.data.tupianjiazai);
                    },
                    fail: function() {
                        t.data.carstemp = "/pages/images/store_bg.png", t.setData({
                            tupianjiazai: t.data.tupianjiazai + 1
                        }), console.log(t.data.tupianjiazai);
                    }
                }) : t.data.carstemp = "/pages/images/store_bg.png", wx.downloadFile({
                    url: t.backimg(a.data.data.qrcode),
                    success: function(a) {
                        console.log(a), t.setData({
                            tupianjiazai: t.data.tupianjiazai + 1
                        }), console.log(t.data.tupianjiazai), t.setData({
                            qrcodetemp: a.tempFilePath
                        });
                    },
                    fail: function() {
                        t.setData({
                            tupianjiazai: t.data.tupianjiazai + 1
                        }), console.log(t.data.tupianjiazai), t.setData({
                            qrcodetemp: a.data.data.qrcode
                        });
                    }
                }), console.log(a.data.data.info), t.setData({
                    propaganda1: a.data.data.info.one,
                    propaganda2: a.data.data.info.two,
                    headimg: a.data.data.headimg,
                    carsimg: a.data.data.carimg ? a.data.data.carimg : "/pages/image/store_bg.png",
                    qrcodeimg: a.data.data.qrcode
                });
            },
            fail: function(a) {
                wx.showModal({
                    content: a.data.message,
                    success: function() {
                        5e3 == a.data.error && t.setData({
                            isShow: !0
                        }), wx.navigateBack({});
                    }
                });
            }
        });
    },
    backimg: function(t) {
        return a.util.url("entry/wxapp/Api", {
            m: "monai_market",
            img: t,
            r: "sale.index.getthecarimg"
        });
    },
    shareimage: function(a) {
        var t = this;
        wx.showLoading({
            title: "稍等，马上好",
            mask: !0
        });
        var e = wx.createCanvasContext("show", this);
        e.drawImage("/pages/images/share_tpl2.png", 0, 0, 414, 736), new Promise(function(a) {
            wx.getImageInfo({
                src: "https://monai-vr-test.oss-cn-shenzhen.aliyuncs.com/images/46/2018/08/XL0WldwzHWQH6WAQLWDLq6L70m0fAz.png",
                success: function(t) {
                    e.drawImage(t.path, 0, 0, 414, 276), e.drawImage("/pages/image/box.png", 0, 174, 414, 562), 
                    a();
                }
            });
        }).then(function() {
            return new Promise(function(a) {
                wx.getImageInfo({
                    src: "https://wechat.monainet.com/tqr.jpg",
                    success: function(t) {
                        console.log(t), e.drawImage(t.path, 167, 618, 80, 80), e.save(), e.beginPath(), 
                        e.arc(207, 658, 18, 0, 2 * Math.PI, !1), e.setStrokeStyle("white"), e.stroke(), 
                        e.clip(), e.drawImage("/pages/image/zjgl_btn.png", 187, 638, 40, 40), e.restore(), 
                        a();
                    }
                });
            });
        }).then(function() {
            return new Promise(function(a) {
                e.setFontSize(16), e.setTextAlign("center"), e.setFillStyle("#888888"), e.fillText("莫奈网络", 207, 260), 
                e.setFontSize(16), e.setTextAlign("left"), e.setFillStyle("#888888"), e.fillText("营业时间：8：00 - 22：00", 60, 320), 
                e.setFontSize(16), e.setTextAlign("left"), e.setFillStyle("#888888"), e.fillText("服务电话：13864984442", 60, 360), 
                e.setFontSize(16), e.setTextAlign("left"), e.setFillStyle("#888888"), e.fillText("店铺地址：兰山区鲁商中心（广州路北）", 60, 400), 
                e.setFontSize(12), e.setTextAlign("center"), e.setFillStyle("#999999"), e.fillText("长按识别小程序码", 207, 590), 
                e.draw(), setTimeout(function() {
                    return a();
                }, 1e3);
            });
        }).then(function() {
            wx.hideLoading(), wx.canvasToTempFilePath({
                canvasId: "shareCanvas",
                x: 0,
                y: 0,
                width: 414,
                height: 736,
                success: function(a) {
                    var t = [ a.tempFilePath ];
                    wx.previewImage({
                        urls: t
                    });
                }
            }, t);
        });
    },
    makeinimg: function() {
        wx.showLoading({
            title: "正在保存图片..."
        });
        var a = this;
        a.data.makeinnum > 1 || (a.data.makeinnum = 2, wx.canvasToTempFilePath({
            canvasId: "show",
            success: function(t) {
                wx.saveImageToPhotosAlbum({
                    filePath: t.tempFilePath,
                    success: function() {
                        a.data.makeinnum = 1, console.log("成功");
                    },
                    fail: function() {
                        a.data.makeinnum = 1, console.log("shibai ");
                    }
                });
            }
        }), setTimeout(function() {
            wx.hideLoading();
        }, 1e3));
    },
    makeimg: function(a) {
        var t = this, e = wx.createCanvasContext("show", t);
        wx.canvasPutImageData({
            canvasId: "show",
            x: 0,
            y: 0,
            width: 375,
            height: 560,
            success: function(a) {}
        }), e.setFillStyle("#DDDDDD"), e.fillRect(0, 0, 375, 560), e.rect(15, 15, 340, 530), 
        e.setFillStyle("#FFFFFF"), e.fill();
        var i = t.data.carstemp;
        e.drawImage(i, 15, 15, 340, 240);
        var n = t.data.qrcodetemp;
        e.drawImage(n, 110, 310, 150, 150), e.font = "normal bold 14px Microsoft YaHei", 
        e.setFillStyle("#000000"), e.setTextAlign("center"), e.fillText(t.data.propaganda1, 185, 280), 
        e.font = "normal normal 14px Microsoft YaHei", e.fillText(t.data.propaganda2, 185, 310), 
        e.font = "normal normal 13px Microsoft YaHei", e.setFillStyle("#666666"), e.fillText(t.data.qrstr, 185, 510), 
        e.save(), e.beginPath(), e.arc(15, 254, 12, 0, 2 * Math.PI), e.setFillStyle("#DDDDDD"), 
        e.fill(), e.clip(), e.restore(), e.save(), e.beginPath(), e.arc(355, 254, 12, 0, 2 * Math.PI), 
        e.setFillStyle("#DDDDDD"), e.fill(), e.clip(), e.restore(), t.setData({
            cvtype: !0
        }), wx.drawCanvas({
            canvasId: "show",
            actions: e.getActions()
        });
    },
    onReady: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});