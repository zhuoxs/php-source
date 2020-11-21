var app = getApp();

Page({
    data: {
        tximg: "",
        nnewm: "/sudu8_page/resource/img/u_food.png",
        pro: ""
    },
    onPullDownRefresh: function() {
        this.getinfos(), wx.showLoading({
            title: "二维码生成中2222"
        }), wx.stopPullDownRefresh();
    },
    onLoad: function(t) {
        var e = this;
        wx.setNavigationBarTitle({
            title: "二维码生成"
        }), wx.showLoading({
            title: "二维码生成中"
        }), wx.getSystemInfo({
            success: function(t) {
                e.setData({
                    pwidth: t.screenWidth,
                    pheight: t.windowHeight,
                    wheight: t.windowHeight,
                    pixelRatio: t.pixelRatio
                });
            }
        }), app.util.request({
            url: "entry/wxapp/BaseMin",
            data: {
                vs1: 1
            },
            success: function(t) {
                wx.showLoading({
                    title: "二维码生成中"
                }), e.setData({
                    baseinfo: t.data.data
                }), wx.setNavigationBarColor({
                    frontColor: e.data.baseinfo.base_tcolor,
                    backgroundColor: e.data.baseinfo.base_color
                });
            }
        });
        var a = t.id, i = t.type;
        e.setData({
            id: a,
            types: i
        });
        var s = 0;
        t.fxsid && (s = t.fxsid, e.setData({
            fxsid: t.fxsid
        })), app.util.getUserInfo(e.getinfos, s);
    },
    getinfos: function() {
        var i = this;
        wx.showLoading({
            title: "二维码生成中"
        }), wx.getStorage({
            key: "openid",
            success: function(t) {
                var e = t.data;
                i.setData({
                    openid: e
                }), app.util.request({
                    url: "entry/wxapp/globaluserinfo",
                    data: {
                        openid: e
                    },
                    success: function(t) {
                        wx.showLoading({
                            title: "二维码生成中"
                        }), i.setData({
                            globaluser: t.data.data
                        });
                    }
                });
                var a = i.data.id;
                i.data.types;
                a ? (i.setData({
                    id: a
                }), i.getproinfo(a), i.ewm(a, 2)) : (i.ewm(0, 1), i.setData({
                    id: 0
                }));
            }
        });
    },
    getproinfo: function(t) {
        var a = this, e = wx.getStorageSync("openid");
        a.data.types;
        wx.showLoading({
            title: "二维码生成中"
        }), app.util.request({
            url: "entry/wxapp/staffDetail",
            data: {
                id: t,
                openid: e
            },
            success: function(t) {
                wx.showLoading({
                    title: "二维码生成中"
                });
                var e = t.data.data;
                a.setData({
                    pro: e
                });
            }
        });
    },
    ewm: function(t, e) {
        var a = this;
        wx.showLoading({
            title: "二维码生成中"
        });
        var i = wx.getStorageSync("openid"), s = a.data.types;
        app.util.request({
            url: "entry/wxapp/sharecard",
            data: {
                openid: i,
                id: t,
                types: e,
                frompage: s
            },
            success: function(t) {
                wx.showLoading({
                    title: "二维码生成中"
                });
                var e = t.data.data;
                wx.getImageInfo({
                    src: e,
                    success: function(t) {
                        var e = t.path;
                        a.jibxx(e);
                    },
                    fail: function() {
                        wx.hideLoading(), wx.showModal({
                            title: "提示",
                            showCancel: !1,
                            content: "二维码生成失败，请稍后再试",
                            success: function(t) {}
                        });
                    }
                });
            }
        });
    },
    jibxx: function(s) {
        var o = this;
        if (wx.showLoading({
            title: "二维码生成中"
        }), 0 != o.data.id) {
            var i = o.data.pro.pic, n = 1;
            wx.getImageInfo({
                src: "/sudu8_page/resource/img/callcardbg.png",
                success: function(t) {
                    wx.showLoading({
                        title: "二维码生成中"
                    });
                    t.path;
                    var e = t.width, a = t.height;
                    o.setData({
                        imgwidth: e,
                        imgheight: a
                    }), "" == i ? o.saveimg("/sudu8_page/resource/img/default_pic.png", s, n) : wx.getImageInfo({
                        src: i,
                        success: function(t) {
                            o.saveimg(t.path, s, n);
                        }
                    });
                },
                fail: function() {
                    wx.hideLoading(), wx.showModal({
                        title: "提示",
                        showCancel: !1,
                        content: "二维码生成失败1111111，请稍后再试",
                        success: function(t) {}
                    });
                }
            });
        } else {
            wx.showLoading({
                title: "二维码生成中"
            });
            n = 2;
            app.util.request({
                url: "entry/wxapp/shareguiz",
                success: function(t) {
                    wx.showLoading({
                        title: "二维码生成中"
                    });
                    var e = t.data.data;
                    o.setData({
                        thumbimg: e
                    }), wx.getImageInfo({
                        src: e,
                        success: function(t) {
                            wx.showLoading({
                                title: "二维码生成中"
                            });
                            var e = t.width, a = t.height;
                            o.setData({
                                imgwidth: e,
                                imgheight: a
                            });
                            var i = t.path;
                            o.saveimg(i, s, n);
                        },
                        fail: function() {
                            wx.hideLoading(), wx.showModal({
                                title: "提示",
                                showCancel: !1,
                                content: "二维码生成失败！如开启远程附件，需设置https，并添加域名至小程序服务器域名downloadfile内！",
                                success: function(t) {}
                            });
                        }
                    });
                }
            });
        }
    },
    saveimg: function(t, e, a) {
        wx.showLoading({
            title: "二维码生成中"
        });
        var i = this, s = (i.data.baseinfo, wx.createCanvasContext("myCanvas")), o = i.data.imgwidth, n = i.data.imgheight, l = "/sudu8_page/resource/img/company.png", d = i.data.pro, c = i.data.pwidth, g = (i.data.pheight, 
        i.data.types, c * n / o);
        s.setFillStyle("#ffffff"), s.fillRect(0, 0, c, c + 140), s.drawImage(t, 20, 20, .6 * c, .6 * g), 
        s.drawImage("/sudu8_page/resource/img/callcardbg.png", c - 20 - .6 * c, 20, .6 * c, .6 * g), 
        i.drawRoundRect(s, 20, 20, c - 40, .6 * g, 12), i.setData({
            heigts: g + 50
        }), s.setShadow(0, 0, 50, "#ffffff"), s.setFillStyle("#232323"), s.setFontSize(23), 
        s.setTextAlign("left"), s.fillText(d.realname, .6 * c, .25 * g), s.setFillStyle("#838383"), 
        s.setFontSize(13), s.setTextAlign("left"), s.fillText(d.title + "-" + d.job, .58 * c, .32 * g), 
        s.drawImage("/sudu8_page/resource/img/phone1.png", .89 * c, .41 * g, 15, 15), s.setFillStyle("#838383"), 
        s.setFontSize(12), s.setTextAlign("right"), s.fillText(d.mobile, .86 * c, .44 * g), 
        null != d.email && "" != d.email ? (s.drawImage("/sudu8_page/resource/img/email.png", .89 * c, .49 * g, 15, 12), 
        s.setFillStyle("#838383"), s.setFontSize(12), s.setTextAlign("right"), s.fillText(d.email, .86 * c, .51 * g), 
        null != d.company && "" != d.company && (s.drawImage(l, .89 * c, .56 * g, 15, 15), 
        s.setFillStyle("#838383"), s.setFontSize(12), s.setTextAlign("right"), s.fillText(d.company, .86 * c, .59 * g))) : null != d.company && "" != d.company && (s.drawImage(l, .89 * c, .49 * g, 15, 15), 
        s.setFillStyle("#838383"), s.setFontSize(12), s.setTextAlign("right"), s.fillText(d.company, .86 * c, .52 * g)), 
        s.setFillStyle("#232323"), s.setFontSize(18), s.setTextAlign("left"), s.fillText("扫一扫右边的小程序码", 25, .85 * g), 
        s.setFillStyle("#666666"), s.setFontSize(16), s.setTextAlign("left"), s.fillText("查看具体信息吧", 25, .93 * g), 
        s.drawImage(e, c - 120, .75 * g, 100, 100), s.draw(), wx.hideLoading();
    },
    saveimgdo: function() {
        var e = this;
        wx.getSetting({
            success: function(t) {
                t.authSetting["scope.writePhotosAlbum"] ? e.dosave() : wx.authorize({
                    scope: "scope.writePhotosAlbum",
                    success: function() {
                        e.dosave();
                    },
                    fail: function() {
                        wx.openSetting();
                    }
                });
            }
        });
    },
    dosave: function() {
        var t = this.data.pwidth, e = this.data.heigts, a = this.data.pixelRatio;
        wx.canvasToTempFilePath({
            x: 0,
            y: 0,
            width: t,
            height: e,
            destWidth: t * a,
            destHeight: e * a,
            canvasId: "myCanvas",
            success: function(t) {
                wx.saveImageToPhotosAlbum({
                    filePath: t.tempFilePath,
                    success: function(t) {
                        wx.showModal({
                            title: "提醒",
                            content: "请转发您专属的分享图至好友、群。好友点击后，您将获得积分！",
                            showCancel: !1,
                            success: function(t) {
                                wx.navigateBack({
                                    delta: 1
                                });
                            }
                        });
                    },
                    fail: function(t) {}
                });
            }
        });
    },
    drawRoundRect: function(t, e, a, i, s, o) {
        i < 2 * o && (o = i / 2), s < 2 * o && (o = s / 2), t.setFillStyle("rgba(238, 238, 238, 0)"), 
        t.setStrokeStyle("#f9f9f9"), t.setLineWidth(10), t.setShadow(10, 10, 60, "#e1e1e1"), 
        t.beginPath(), t.moveTo(e + o, a), t.arcTo(e + i, a, e + i, a + s, o), t.arcTo(e + i, a + s, e, a + s, o), 
        t.arcTo(e, a + s, e, a, o), t.arcTo(e, a, e + i, a, o), t.closePath(), t.fill(), 
        t.stroke();
    }
});