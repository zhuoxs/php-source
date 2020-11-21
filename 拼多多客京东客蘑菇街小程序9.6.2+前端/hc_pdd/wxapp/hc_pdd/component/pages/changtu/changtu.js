var app = getApp();

Page({
    data: {
        title: "tom",
        mob: 0,
        toView: "inToView3",
        lpav: !1,
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
        var i = app.globalData.userInfo;
        this.setData({
            userInfo: i
        });
    },
    dain: function(a) {
        var i = a.currentTarget.dataset.hb_id;
        console.log(i, "红包id"), this.setData({
            lpav: !this.data.lpav,
            hb_id: i
        });
    },
    award_gib: function() {
        this.setData({
            lpav: !this.data.lpav
        });
    },
    Headcolor: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Headcolor",
            method: "POST",
            success: function(a) {
                var i = a.data.data.config;
                e.setData({
                    config: i
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    fanhui: function() {
        console.log(111), wx, wx.navigateBack({
            delta: 1
        });
    },
    onShow: function() {
        this.Shenhelist(), this.Headcolor();
    },
    cash: function() {
        wx.navigateTo({
            url: "../cash/cash"
        });
    },
    pengyiud: function() {
        var i = this;
        wx.showLoading({
            title: "图片保存中"
        }), app.util.request({
            url: "entry/wxapp/Treeposter",
            method: "POST",
            data: {
                user_id: app.globalData.user_id,
                hb_id: i.data.hb_id
            },
            success: function(a) {
                i.bao();
            },
            fail: function(a) {
                i.bao();
            }
        });
    },
    bao: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Treeurl",
            method: "POST",
            success: function(a) {
                var i = a.data.data;
                e.setData({
                    imgcxs: i
                }), wx.downloadFile({
                    url: e.data.imgcxs,
                    success: function(a) {
                        console.log(a);
                        var i = a.tempFilePath;
                        wx.showToast({
                            title: "保存成功",
                            icon: "success",
                            duration: 2e3
                        }), wx.saveImageToPhotosAlbum({
                            filePath: i,
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
        var g = this;
        app.util.request({
            url: "entry/wxapp/Treelist",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(a) {
                for (var i = a.data.data.data, e = a.data.data.res, t = 0; t < i.length; t++) i[t] = i[t].reverse();
                g.setData({
                    liswet: i,
                    reua: e
                });
            }
        });
    },
    onShareAppMessage: function(a) {
        var i = this;
        app.globalData.userInfo;
        return "button" === a.from && console.log(a.target), {
            title: i.data.config.treesharetitle,
            imageUrl: i.data.config.treesharepic,
            path: "hc_pdd/component/pages/redbag/redbag?outuser_id=" + app.globalData.user_id + "&hb_id=" + i.data.hb_id
        };
    }
});