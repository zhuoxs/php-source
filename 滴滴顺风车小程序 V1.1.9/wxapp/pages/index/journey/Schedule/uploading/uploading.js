var e = getApp();

Page({
    data: {
        tempFilePaths: "",
        tempFilePathst: "",
        ordernum: "",
        ntype: "",
        bindTextAreaBlur: "",
        PD: ""
    },
    onLoad: function(t) {
        var a = this;
        try {
            (o = wx.getStorageSync("imgid")) && (console.log("nid:", o), a.setData({
                nid: o
            }));
        } catch (e) {}
        try {
            (o = wx.getStorageSync("xntype")) && (console.log("xntype:", o), a.setData({
                ntype: o
            }));
        } catch (e) {}
        try {
            (o = wx.getStorageSync("PD")) && (console.log("PD:", o), a.setData({
                PD: o
            }));
        } catch (e) {}
        try {
            (o = wx.getStorageSync("session")) && (console.log("logintag:", o), a.setData({
                logintag: o
            }));
        } catch (e) {}
        try {
            var o = wx.getStorageSync("san");
            o && (console.log("san:", o), a.setData({
                san: o
            }));
        } catch (e) {}
        var n = a.data.logintag, i = (a.data.loginopen, a.data.nid), s = a.data.ntype;
        wx.request({
            url: e.data.url + "my_upimg_view",
            data: {
                logintag: n,
                nid: i,
                ntype: s
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(e) {
                if (console.log("上传图片界面展现接口"), console.log(e), "0000" == e.data.retCode) a.setData({
                    ordernum: e.data.ordernum
                }); else {
                    if (wx.showToast({
                        title: e.data.retDesc,
                        icon: "loading",
                        duration: 2e3
                    }), "账号已冻结" == e.data.retDesc) return void wx.navigateTo({
                        url: "/pages/index/index"
                    });
                    console.log("身份选择失败");
                }
            }
        });
    },
    chooseimage: function() {
        var e = this;
        wx.showActionSheet({
            itemList: [ "拍照", "从相册中选择" ],
            itemColor: "#000",
            success: function(t) {
                t.cancel || (1 == t.tapIndex ? e.chooseWxImage("album") : 0 == t.tapIndex && e.chooseWxImage("camera"));
            }
        });
    },
    chooseWxImage: function(e) {
        var t = this;
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ e ],
            success: function(e) {
                var a = e.tempFilePaths[0];
                console.log(a), t.setData({
                    tempFilePaths: a
                }), t.tempFilePaths(a);
            }
        });
    },
    chooseimagetow: function() {
        var e = this;
        wx.showActionSheet({
            itemList: [ "拍照", "从相册中选择" ],
            itemColor: "#000",
            success: function(t) {
                t.cancel || (1 == t.tapIndex ? e.chooseWxImaget("album") : 0 == t.tapIndex && e.chooseWxImaget("camera"));
            }
        });
    },
    chooseWxImaget: function(e) {
        var t = this;
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ e ],
            success: function(e) {
                var a = e.tempFilePaths[0];
                console.log(a), t.setData({
                    tempFilePathst: a
                }), t.tempFilePathst(a);
            }
        });
    },
    bindtap: function(e) {
        var t = this;
        2 == t.data.PD ? t.owner() : t.passenger();
    },
    passenger: function(t) {
        var a = this, o = a.data.img1, n = a.data.img2, i = a.data.PD;
        if (void 0 != o || void 0 != n) {
            var s = a.data.bindTextAreaBlur, c = a.data.logintag, l = a.data.loginopen, d = a.data.nid, r = a.data.ntype, g = o + "," + n;
            console.log("picpath:", g), console.log("ntype:", r), console.log("nid:", d), console.log("bindTextAreaBlur:", s), 
            wx.request({
                url: e.data.url + "passenger_click_complain_op",
                data: {
                    loginopen: l,
                    logintag: c,
                    nid: d,
                    ntype: r,
                    picpath: g,
                    note: s
                },
                header: {
                    "content-type": "application/x-www-form-urlencoded"
                },
                success: function(e) {
                    if (console.log("乘客投诉操作"), console.log(e), "0000" == e.data.retCode) wx.navigateBack({
                        delta: 2,
                        success: function(e) {
                            var t = getCurrentPages().pop();
                            void 0 != t && null != t && t.onLoad(i);
                        }
                    }), wx.showToast({
                        title: e.data.retDesc,
                        icon: "succes",
                        duration: 1e3,
                        mask: !0
                    }); else if (wx.showToast({
                        title: e.data.retDesc,
                        icon: "loading",
                        duration: 1e3
                    }), "账号已冻结" == e.data.retDesc) return void wx.navigateTo({
                        url: "/pages/index/index"
                    });
                }
            });
        } else wx.showToast({
            title: "至少上传一张图片",
            icon: "loading",
            duration: 1e3
        });
    },
    owner: function(t) {
        var a = this, o = a.data.img1, n = a.data.img2, i = a.data.PD, s = a.data.san, c = a.data.bindTextAreaBlur, l = a.data.logintag, d = a.data.loginopen, r = a.data.nid, g = a.data.ntype, u = o + "," + n;
        void 0 != o || void 0 != n ? (console.log("picpath:", u), console.log("ntype:", g), 
        console.log("nid:", r), console.log("bindTextAreaBlur:", c), wx.request({
            url: e.data.url + "car_owner_click_complain_op",
            data: {
                loginopen: d,
                logintag: l,
                nid: r,
                ntype: g,
                picpath: u,
                note: c
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(e) {
                if (console.log("车主投诉操作"), console.log(e), "0000" == e.data.retCode) s ? wx.navigateBack({
                    delta: 3,
                    success: function(e) {
                        var t = getCurrentPages().pop();
                        void 0 != t && null != t && t.onLoad(i);
                    }
                }) : wx.navigateBack({
                    delta: 2,
                    success: function(e) {
                        var t = getCurrentPages().pop();
                        void 0 != t && null != t && t.onLoad(i);
                    }
                }), wx.showToast({
                    title: e.data.retDesc,
                    icon: "succes",
                    duration: 1e3,
                    mask: !0
                }); else if (wx.showToast({
                    title: e.data.retDesc,
                    icon: "loading",
                    duration: 1e3
                }), "账号已冻结" == e.data.retDesc) return void wx.navigateTo({
                    url: "/pages/index/index"
                });
            }
        })) : wx.showToast({
            title: "至少上传一张图片",
            icon: "loading",
            duration: 1e3
        });
    },
    tempFilePaths: function(t) {
        var a = this, o = t, n = a.data.logintag, i = a.data.loginopen;
        wx.uploadFile({
            url: e.data.url + "my_upimg",
            filePath: o,
            name: "file",
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            formData: {
                logintag: n,
                loginopen: i
            },
            success: function(e) {
                console.log(e);
                var t = JSON.parse(e.data).pathfile;
                console.log("imgone:", t), a.setData({
                    img1: t
                });
            }
        });
    },
    tempFilePathst: function(t) {
        var a = this, o = t, n = a.data.logintag, i = a.data.loginopen;
        wx.uploadFile({
            url: e.data.url + "my_upimg",
            filePath: o,
            name: "file",
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            formData: {
                logintag: n,
                loginopen: i
            },
            success: function(e) {
                console.log(e);
                var t = JSON.parse(e.data).pathfile;
                console.log("imgone:", t), a.setData({
                    img2: t
                });
            }
        });
    },
    bindTextAreaBlur: function(e) {
        this.setData({
            bindTextAreaBlur: e.detail.value
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var e = this.data.id;
        return console.log("分享：", e), {
            title: "拼车",
            desc: "拼车!",
            path: "/pages/index/index?id=" + e
        };
    }
});