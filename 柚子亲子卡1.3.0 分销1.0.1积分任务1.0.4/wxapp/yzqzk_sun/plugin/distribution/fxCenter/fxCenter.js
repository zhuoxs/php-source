var app = getApp();

Page({
    data: {
        hk_bgimg: "",
        hk_namecolor: "#f5ac32",
        user_info: [],
        d_info: [],
        hidden: !0
    },
    onLoad: function(t) {
        var e = this;
        wx.getStorageSync("System");
        app.util.request({
            url: "entry/wxapp/System",
            success: function(t) {
                wx.setStorageSync("System", t.data), e.setData({
                    hk_bgimg: t.data.hk_bgimg ? t.data.hk_bgimg : "",
                    hk_namecolor: t.data.hk_namecolor ? t.data.hk_namecolor : "#f5ac32"
                });
            }
        });
        var o = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/IsPromoter",
            data: {
                openid: o,
                m: app.globalData.Plugin_distribution
            },
            showLoading: !1,
            success: function(t) {
                if (t) if (9 != t.data) {
                    var o = t.data;
                    e.setData({
                        user_info: o
                    });
                } else wx.redirectTo({
                    url: "/yzqzk_sun/plugin/distribution/fxAddShare/fxAddShare"
                });
            }
        });
        var n = wx.getStorageSync("users");
        app.util.request({
            url: "entry/wxapp/GetDistribution",
            data: {
                uid: n.id,
                m: app.globalData.Plugin_distribution
            },
            showLoading: !1,
            success: function(t) {
                console.log("9696969696969696"), console.log(t.data), 2 != t.data && e.setData({
                    d_info: t.data
                });
            }
        });
    },
    toIndex: function(t) {
        wx.reLaunch({
            url: "/yzqzk_sun/pages/index/index"
        });
    },
    onReady: function() {},
    onShow: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    hidden: function(t) {
        this.setData({
            hidden: !0
        });
    },
    save: function() {
        var o = this;
        wx.saveImageToPhotosAlbum({
            filePath: o.data.prurl,
            success: function(t) {
                console.log("成功"), wx.showModal({
                    content: "图片已保存到相册，赶紧晒一下吧~",
                    showCancel: !1,
                    confirmText: "好哒",
                    confirmColor: "#ef8200",
                    success: function(t) {
                        t.confirm && (console.log("用户点击确定"), o.setData({
                            hidden: !0
                        }));
                    }
                });
            },
            fail: function(t) {
                console.log("失败"), wx.getSetting({
                    success: function(t) {
                        t.authSetting["scope.writePhotosAlbum"] || (console.log("进入信息授权开关页面"), wx.openSetting({
                            success: function(t) {
                                console.log("openSetting success", t.authSetting);
                            }
                        }));
                    }
                });
            }
        });
    },
    shareCanvas: function() {
        var t = wx.getStorageSync("users"), o = [];
        o.uid = t.id, o.title = "扫码赚钱", o.url = this.data.url, o.scene = "d_user_id=" + t.id, 
        this.creatPoster("yzqzk_sun/pages/index/index", 430, o, 8, "shareImg");
    },
    creatPoster: function(t, o, e, n, s) {
        var l = this, i = app.siteInfo.siteroot.split("/app/")[0] + "/attachment/", u = "", c = "", r = "", a = e.scene;
        wx.showLoading({
            title: "获取图片中..."
        });
        var d = e.uid ? e.uid : 0;
        app.util.request({
            url: "entry/wxapp/GetwxCode",
            data: {
                scene: a,
                page: t,
                width: o,
                uid: d,
                m: app.globalData.Plugin_distribution
            },
            success: function(a) {
                console.log("获取小程序二维码"), console.log(a), u = a.data.wxcode_pic, c = a.data.blogo, 
                r = a.data.postertoptitle ? a.data.postertoptitle : e.title;
                var t = new Promise(function(o, t) {
                    wx.getImageInfo({
                        src: c,
                        success: function(t) {
                            console.log("图片缓存1"), console.log(t), o(t.path);
                        },
                        fail: function(t) {
                            console.log("图片1保存失败"), o(c), console.log(t);
                        }
                    });
                }), o = new Promise(function(o, t) {
                    wx.getImageInfo({
                        src: i + u,
                        success: function(t) {
                            app.util.request({
                                url: "entry/wxapp/DelwxCode",
                                data: {
                                    imgurl: u,
                                    m: app.globalData.Plugin_distribution
                                },
                                success: function(t) {
                                    console.log(t.data);
                                }
                            }), console.log("图片缓存2"), console.log(t), o(t.path);
                        },
                        fail: function(t) {
                            console.log("图片2保存失败"), o(i + u), console.log(t);
                        }
                    });
                });
                Promise.all([ t, o ]).then(function(t) {
                    console.log(t), console.log("进入 promise"), console.log(a);
                    var o = wx.createCanvasContext(s), e = r, n = t[0], i = t[1];
                    o.rect(0, 0, 600, 770), o.setFillStyle("#fff"), o.fill(), o.drawImage(n, 0, 0, 600, 418), 
                    o.setFillStyle("#000"), o.setFontSize(34), l.drawText(e, 20, 414, 500, o), o.drawImage(i, 60, 550, 180, 180), 
                    o.drawImage("../../../../style/images/zhiwen.png", 380, 550, 130, 130), o.setFontSize(22), 
                    o.setFillStyle("#999"), o.fillText("长按识别二维码进入", 350, 710), o.stroke(), o.draw(), 
                    console.log("结束 promise"), wx.hideLoading(), wx.showLoading({
                        title: "开始生成海报..."
                    }), new Promise(function(t, o) {
                        setTimeout(function() {
                            t("second ok");
                        }, 500);
                    }).then(function(t) {
                        console.log(t), wx.canvasToTempFilePath({
                            x: 0,
                            y: 0,
                            width: 602,
                            height: 771,
                            destWidth: 602,
                            destHeight: 771,
                            canvasId: s,
                            success: function(t) {
                                console.log("进入 canvasToTempFilePath"), l.setData({
                                    prurl: t.tempFilePath,
                                    hidden: !1
                                }), wx.hideLoading();
                            },
                            fail: function(t) {
                                console.log(t);
                            }
                        });
                    });
                });
            }
        });
    },
    drawText: function(t, o, e, n, i) {
        var a = t.split(""), s = "", l = [];
        i.font = "30rpx Arial", i.fillStyle = "#222222", i.textBaseline = "middle";
        for (var u = 0; u < a.length; u++) i.measureText(s).width < n || (l.push(s), s = ""), 
        s += a[u];
        l.push(s);
        for (var c = 0; c < l.length; c++) i.fillText(l[c], o, e + 30 * (c + 1));
    },
    toFxCash: function(t) {
        wx.navigateTo({
            url: "/yzqzk_sun/plugin/distribution/fxCash/fxCash"
        });
    },
    toFxWd: function(t) {
        wx.navigateTo({
            url: "/yzqzk_sun/plugin/distribution/fxWithdraw/fxWithdraw"
        });
    },
    toFxOrder: function(t) {
        wx.navigateTo({
            url: "/yzqzk_sun/plugin/distribution/fxOrder/fxOrder"
        });
    },
    toFxDetail: function(t) {
        wx.navigateTo({
            url: "/yzqzk_sun/plugin/distribution/fxDetail/fxDetail"
        });
    },
    toFxTeam: function(t) {
        wx.navigateTo({
            url: "/yzqzk_sun/plugin/distribution/fxTeam/fxTeam"
        });
    },
    toFxGoods: function(t) {
        wx.navigateTo({
            url: "/yzqzk_sun/plugin/distribution/fxGoods/fxGoods"
        });
    }
});