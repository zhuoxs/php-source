var app = getApp();

Page({
    data: {
        flag2: 0,
        title: "tom",
        mob: 0,
        toView: "inToView3",
        lpav: !1,
        liu_id: "",
        yun: [ {
            imga: [ {
                img: "../../images/1_06.jpg"
            }, {
                img: "../../images/1_06.jpg"
            }, {
                img: "../../images/1_06.jpg"
            } ]
        }, {
            imga: [ {
                img: "../../images/1_06.jpg"
            }, {
                img: "../../images/1_06.jpg"
            }, {
                img: "../../images/1_06.jpg"
            } ]
        }, {
            imga: [ {
                img: "../../images/1_06.jpg"
            }, {
                img: "../../images/1_06.jpg"
            }, {
                img: "../../images/1_06.jpg"
            } ]
        } ],
        yuntw: [ {
            imga: [ {
                img: "../../images/1_06.jpg"
            }, {
                img: "../../images/1_06.jpg"
            }, {
                img: "../../images/1_06.jpg"
            } ]
        }, {
            imga: [ {
                img: "../../images/1_06.jpg"
            }, {
                img: "../../images/1_06.jpg"
            }, {
                img: "../../images/1_06.jpg"
            } ]
        }, {
            imga: [ {
                img: "../../images/1_06.jpg"
            }, {
                img: "../../images/1_06.jpg"
            }, {
                img: "../../images/1_06.jpg"
            } ]
        }, {
            imga: [ {
                img: "../../images/1_06.jpg"
            }, {
                img: "../../images/1_06.jpg"
            }, {
                img: "../../images/1_06.jpg"
            } ]
        }, {
            imga: [ {
                img: "../../images/1_06.jpg"
            }, {
                img: "../../images/1_06.jpg"
            }, {
                img: "../../images/1_06.jpg"
            } ]
        } ]
    },
    onLoad: function(a) {
        console.log(getCurrentPages()[0].route, "从哪里进的啊");
        var e = app.globalData.userInfo;
        this.setData({
            userInfo: e,
            Pagesli: getCurrentPages()[0].route
        });
    },
    dain: function(a) {
        var e = a.currentTarget.dataset.hb_id;
        console.log(e, "红包id"), this.setData({
            lpav: !this.data.lpav,
            hb_id: e,
            flag2: 1
        });
    },
    award_gib: function() {
        this.setData({
            lpav: !this.data.lpav,
            flag2: 0
        });
    },
    Headcolor: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Headcolor",
            method: "POST",
            success: function(a) {
                var e = a.data.data.config;
                t.setData({
                    config: e
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    fanhui: function() {
        console.log(111), "hc_pdd/component/pages/redbag/redbag" == this.data.Pagesli ? wx.reLaunch({
            url: "../../../pages/index/index"
        }) : wx.navigateBack({
            delta: 1
        });
    },
    onShow: function() {
        this.Shenhelist(), this.Headcolor();
    },
    cash: function() {
        app.util.request({
            url: "entry/wxapp/Treeway",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(a) {
                console.log(a.data.data);
                var e = a.data.data.totalmoney;
                console.log(e), console.log(a.data.data.user), a.data.data.tree_way ? (console.log("支付宝"), 
                wx.navigateTo({
                    url: "../../../pages/cash/cash?path=1&totalmoney=" + e
                })) : (console.log("微信"), wx.navigateTo({
                    url: "../cash/cash"
                }));
            }
        });
    },
    pengyiud: function() {
        var e = this;
        wx.showLoading({
            title: "图片保存中"
        }), app.util.request({
            url: "entry/wxapp/Treeposter",
            method: "POST",
            data: {
                user_id: app.globalData.user_id,
                hb_id: e.data.hb_id
            },
            success: function(a) {
                e.bao();
            },
            fail: function(a) {
                e.bao();
            }
        });
    },
    bao: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Treeurl",
            method: "POST",
            success: function(a) {
                var e = a.data.data;
                t.setData({
                    imgcxs: e
                }), wx.downloadFile({
                    url: t.data.imgcxs,
                    success: function(a) {
                        console.log(a);
                        var e = a.tempFilePath;
                        wx.showToast({
                            title: "保存成功",
                            icon: "success",
                            duration: 2e3
                        }), wx.saveImageToPhotosAlbum({
                            filePath: e,
                            success: function(a) {
                                console.log(a);
                            },
                            fail: function(a) {}
                        });
                    }
                });
            },
            fail: function(a) {
                console.log(a), console.log("失败" + a);
            }
        });
    },
    Shenhelist: function() {
        var s = this;
        app.util.request({
            url: "entry/wxapp/Treelist",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(a) {
                var e = a.data.data.data, t = a.data.data.res, i = a.data.data.res.treeadultid;
                console.log(a.data);
                for (var g = 0; g < e.length; g++) e[g] = e[g].reverse();
                s.setData({
                    liswet: e,
                    reua: t,
                    liu_id: i
                });
            }
        });
    },
    onShareAppMessage: function(a) {
        var e = this;
        app.globalData.userInfo;
        return "button" === a.from && console.log(a.target), {
            title: e.data.config.treesharetitle,
            imageUrl: e.data.config.treesharepic,
            path: "hc_pdd/component/pages/redbag/redbag?outuser_id=" + app.globalData.user_id + "&hb_id=" + e.data.hb_id
        };
    }
});