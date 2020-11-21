var app = getApp();

Page({
    data: {
        tximg: "",
        nnewm: "/sudu8_page/resource/img/u_food.png"
    },
    onPullDownRefresh: function() {
        this.getinfos(), wx.showLoading({
            title: "二维码生成中"
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
    redirectto: function(t) {
        var e = t.currentTarget.dataset.link, a = t.currentTarget.dataset.linktype;
        app.util.redirectto(e, a);
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
        var a = this, e = wx.getStorageSync("openid"), i = a.data.types;
        if ("PT" == i) {
            wx.showLoading({
                title: "二维码生成中"
            });
            var s = app.util.url("entry/wxapp/Ptproductinfo", {
                m: "sudu8_page_plugin_pt"
            });
            wx.request({
                url: s,
                data: {
                    id: t,
                    openid: e
                },
                success: function(t) {
                    wx.showLoading({
                        title: "二维码生成中"
                    });
                    var e = t.data.data.products;
                    a.setData({
                        pro: e
                    });
                }
            });
        } else if ("shops" == i) {
            wx.showLoading({
                title: "二维码生成中"
            });
            s = app.util.url("entry/wxapp/showPro", {
                m: "sudu8_page_plugin_shop"
            });
            wx.request({
                url: s,
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
        } else wx.showLoading({
            title: "二维码生成中"
        }), app.util.request({
            url: "entry/wxapp/ProductsDetail",
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
            url: "entry/wxapp/shareewm",
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
            var t = o.data.pro.thumbimg, n = 1;
            wx.getImageInfo({
                src: t,
                success: function(t) {
                    wx.showLoading({
                        title: "二维码生成中"
                    });
                    var e = t.path, a = t.width, i = t.height;
                    o.setData({
                        imgwidth: a,
                        imgheight: i
                    }), o.saveimg(e, s, n);
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
        var i = this, s = i.data.baseinfo.name, o = wx.createCanvasContext("myCanvas"), n = i.data.imgwidth, l = i.data.imgheight, d = i.data.pwidth, r = i.data.pheight, c = i.data.types;
        o.setFillStyle("#ffffff"), r < 600 ? o.fillRect(0, 0, d, d + 140) : o.fillRect(0, 0, d, d + 160);
        var w = d * l / n;
        if (i.setData({
            heigts: w + 180
        }), o.drawImage(t, 0, 0, d, w), 1 == a) {
            var u = i.data.pro, g = u.title, h = u.price;
            o.setFillStyle("#333333"), o.setFontSize(14), o.setTextAlign("left");
            var p = g;
            if (o.fillText(p, 10, w + 30), "showArt" == c || "showPic" == c) {
                var f = "";
                o.fillText(f, d - 10, w + 30);
            } else {
                o.setFillStyle("#E7142F"), o.setFontSize(14), o.setTextAlign("right");
                f = "¥" + h;
                o.fillText(f, d - 10, w + 30);
            }
        }
        2 == a && (o.setFillStyle("#333333"), o.setFontSize(14), o.setTextAlign("center"), 
        o.fillText("<更多内容小程序内查看>", d / 2, w + 30)), o.setStrokeStyle("#dedede"), o.moveTo(10, w + 45), 
        o.lineTo(d - 10, w + 45), o.stroke(), o.setFillStyle("#666666"), r < 600 ? o.setFontSize(16) : o.setFontSize(18), 
        o.setTextAlign("left"), o.fillText("长按识别小程序码访问", 10, w + 80), o.setFillStyle("#666666"), 
        o.setFontSize(14), o.setTextAlign("left"), o.fillText(s, 10, w + 110), o.setFillStyle("#000000"), 
        o.setFontSize(14), o.setTextAlign("left"), o.fillText("", 80, 495), r < 600 ? o.drawImage(e, d - 100, w + 60, 80, 80) : o.drawImage(e, d - 120, w + 60, 100, 100), 
        o.draw(), wx.hideLoading();
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
    }
});