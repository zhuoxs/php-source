var app = getApp();

Page({
    data: {
        imgUrls: [ "../../resource/images/0324133759.png", "../../resource/images/0324134938.png", "../../resource/images/180324134942.png" ],
        indicatorDots: !1,
        autoplay: !0,
        interval: 5e3,
        duration: 1e3,
        previousmargin: "137rpx",
        nextmargin: "137rpx",
        circular: !0,
        tuhight: 0
    },
    onLoad: function(a) {
        var t = this;
        t.daili(), t.Headcolor(), t.Diyname();
        var o = app.globalData.user_id, i = app.globalData.Headcolor;
        t.setData({
            user_id: o,
            backgroundColor: i
        });
    },
    yaoqing: function() {
        var a = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = a).translateY(this.data.animationShowHeight).step(), this.setData({
            animationData: a.export(),
            showModalStatus: !0
        }), setTimeout(function() {
            a.translateY(0).step(), this.setData({
                animationData: a.export()
            });
        }.bind(this), 200);
    },
    quxiaocd: function() {
        var a = wx.createAnimation({
            duration: 1e3,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = a).translateY(this.data.animationShowHeight).step(), this.setData({
            animationData: a.export()
        }), setTimeout(function() {
            a.translateY(0).step(), this.setData({
                animationData: a.export(),
                showModalStatus: !1
            });
        }.bind(this), 200);
    },
    onReady: function() {},
    daili: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Invite",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(a) {
                var t = a.data.data.info.invite_agreement, o = a.data.data.img;
                e.setData({
                    invite_agreement: t,
                    imgUrls: o
                });
                for (var i = 0; i < o.length; i++) {
                    var n = o[1].pic;
                    e.setData({
                        imgcxs: n
                    });
                }
            }
        });
    },
    Diyname: function() {
        var i = this;
        app.util.request({
            url: "entry/wxapp/Diyname",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(a) {
                var t = a.data.data.config, o = a.data.data.role;
                i.setData({
                    nufiome: t,
                    role: o
                });
            }
        });
    },
    bindchange: function(a) {
        for (var t = this, o = a.detail.current, i = t.data.imgUrls, n = 0; n < i.length; n++) {
            var e = i[o].pic;
            t.setData({
                imgcxs: e
            });
        }
        t.setData({
            tuhight: o
        });
    },
    Headcolor: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Headcolor",
            method: "POST",
            success: function(a) {
                var t = a.data.data.config.search_color, o = a.data.data.config.share_icon;
                a.data.data.config.head_color;
                app.globalData.Headcolor = a.data.data.config.head_color;
                a.data.data.config.title;
                var i = a.data.data.yesno, n = a.data.data.config.loginbg;
                e.setData({
                    search_color: t,
                    share_icon: o,
                    yesno: i,
                    loginbg: n
                });
            },
            fail: function(a) {
                console.log("失败" + a), console.log(a);
            }
        });
    },
    bao: function() {
        var t = this;
        wx.showToast({
            title: "生成中",
            icon: "loading"
        }), app.util.request({
            url: "entry/wxapp/Shareposter",
            method: "POST",
            data: {
                user_id: app.globalData.user_id,
                imgid: t.data.tuhight
            },
            success: function(a) {
                console.log("接口成功"), console.log(a), app.util.request({
                    url: "entry/wxapp/CreateShareposter",
                    method: "POST",
                    data: {
                        imgid: t.data.tuhight
                    },
                    success: function(a) {
                        console.log("接口成功"), console.log(a);
                        var t = a.data.data;
                        wx.downloadFile({
                            url: t,
                            success: function(a) {
                                console.log(a);
                                var t = a.tempFilePath;
                                wx.showToast({
                                    title: "保存成功",
                                    icon: "success",
                                    duration: 2e3
                                }), wx.saveImageToPhotosAlbum({
                                    filePath: t,
                                    success: function(a) {
                                        console.log(a);
                                    },
                                    fail: function(a) {}
                                });
                            },
                            fail: function() {
                                console.log(a);
                            }
                        });
                    },
                    fail: function(a) {
                        console.log("接口失败"), console.log(a);
                    }
                });
            },
            fail: function(a) {
                console.log("接口失败"), console.log(a);
            }
        });
    },
    onShow: function() {
        this.daili();
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(a) {
        return a.from, {
            title: this.data.nufiome.invite_title,
            path: "/hc_pdd/pages/yaoqing/yaoqing?user_id=" + app.globalData.user_id,
            imageUrl: this.data.nufiome.invite_pic,
            success: function(a) {},
            fail: function(a) {}
        };
    }
});