/*   time:2019-08-09 13:18:39*/
var app = getApp();
Page({
    data: {
        platname: "平台名称"
    },
    onLoad: function(t) {
        var e = this,
            a = t.id;
        if (console.log("999"), console.log(a), a <= 0 || !a || "undefined" == a) return wx.showModal({
            title: "提示",
            content: "参数错误，获取不到商品，点击确认跳转到首页",
            showCancel: !1,
            success: function(t) {
                wx.redirectTo({
                    url: "/mzhk_sun/pages/index/index"
                })
            }
        }), !1;
        e.setData({
            id: a
        }), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "30",
            showLoading: !1,
            success: function(t) {
                e.setData({
                    pt_name: t.data.hk_tubiao ? t.data.hk_tubiao : ""
                }), wx.setNavigationBarColor({
                    frontColor: t.data.fontcolor ? t.data.fontcolor : "#000000",
                    backgroundColor: t.data.color ? t.data.color : "#ffffff",
                    animation: {
                        duration: 0,
                        timingFunc: "easeIn"
                    }
                })
            }
        })
    },
    onReady: function() {
        var o = this;
        app.util.request({
            url: "entry/wxapp/GetGoodsInfo",
            data: {
                id: o.data.id,
                m: app.globalData.Plugin_eatvisit
            },
            showLoading: !1,
            success: function(t) {
                if (2 != t.data) {
                    var e = t.data,
                        a = e.url + e.posterimg;
                    o.drawImage(a), o.setData({
                        goods: e
                    })
                } else o.setData({
                    goods: []
                })
            }
        })
    },
    drawImage: function(i) {
        var s = this,
            t = wx.getStorageSync("users");
        app.util.request({
            url: "entry/wxapp/GetwxCode",
            data: {
                scene: "id=" + s.data.id + "&d_user_id=" + t.id,
                page: "mzhk_sun/plugin/eatvisit/lifedet/lifedet",
                m: app.globalData.Plugin_eatvisit
            },
            success: function(t) {
                var a = t.data.wxcode_pic,
                    o = app.siteInfo.siteroot.split("/app/")[0] + "/attachment/",
                    e = new Promise(function(e, t) {
                        wx.getImageInfo({
                            src: i,
                            success: function(t) {
                                console.log("图片缓存1"), console.log(t), e(t.path)
                            },
                            fail: function(t) {
                                console.log("图片1保存失败"), e(i)
                            }
                        })
                    }),
                    n = new Promise(function(e, t) {
                        wx.getImageInfo({
                            src: o + a,
                            success: function(t) {
                                app.util.request({
                                    url: "entry/wxapp/DelwxCode",
                                    data: {
                                        imgurl: a,
                                        m: app.globalData.Plugin_eatvisit
                                    },
                                    success: function(t) {
                                        console.log(t.data)
                                    }
                                }), console.log("图片缓存2"), console.log(t), e(t.path)
                            },
                            fail: function(t) {
                                console.log("图片2保存失败"), e(o + a)
                            }
                        })
                    });
                Promise.all([e, n]).then(function(t) {
                    var e = t[0],
                        a = t[1],
                        o = wx.createCanvasContext("image");
                    o.beginPath(), o.setStrokeStyle("#ff9e40"), o.rect(0, 0, 710, 1e3), o.setFillStyle("#ff9e40"), o.fill(), o.stroke(), o.drawImage(e, 20, 20, 670, 960), o.drawImage(a, 25, 725, 250, 250), o.draw(), new Promise(function(t, e) {
                        setTimeout(function() {
                            t("second ok")
                        }, 500)
                    }).then(function(t) {
                        wx.canvasToTempFilePath({
                            x: 0,
                            y: 0,
                            width: 710,
                            height: 1e3,
                            destWidth: 710,
                            destHeight: 1e3,
                            canvasId: "image",
                            success: function(t) {
                                console.log(t.tempFilePath), s.setData({
                                    imgPath: t.tempFilePath
                                })
                            }
                        })
                    })
                })
            }
        })
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    getImage: function(t) {
        wx.previewImage({
            urls: [this.data.imgPath],
            current: ""
        })
    }
});