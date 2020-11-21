var app = getApp();

Page({
    data: {
        date: "",
        array: [ "骨科", "耳鼻喉科", "脑外科", "神经科", "妇科", "皮肤科" ],
        index: null,
        hide: !1,
        imgs: [],
        upload_picture_list: []
    },
    bindDateChange: function(e) {
        this.setData({
            date: e.detail.value
        });
    },
    bindPickerChange: function(e) {
        this.setData({
            index: e.detail.value
        });
    },
    switchChange: function(e) {
        console.log("switch1 发生 change 事件，携带值为", e.detail.value);
    },
    uploadImage: function() {
        var t = this, a = t.data.imgs;
        wx.chooseImage({
            count: 6,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                a.push(e.tempFilePaths), t.setData({
                    imgs: a
                }), 3 == a.length && t.setData({
                    hide: !0
                });
            }
        });
    },
    deleteimg: function(e) {
        var t = e.currentTarget.dataset.index, a = this.data.upload_picture_list;
        a.splice(t, 1), this.setData({
            upload_picture_list: a,
            hide: !1
        });
    },
    formSubmit: function(t) {
        var e = t.detail.value, o = wx.getStorageSync("openid"), i = (e.fujian0, e.fujian1, 
        e.fujian2, e.keshi), s = e.title_content, n = e.us_jhospital, l = e.us_name, c = e.us_xhospital, u = e.us_yibao, p = e.time;
        wx.showModal({
            title: "提示",
            content: " 确认提交么？ ",
            success: function(e) {
                if (e.confirm) {
                    console.log("用户点击确定");
                    t.detail.value;
                    app.util.request({
                        url: "entry/wxapp/Selcetmbingimg",
                        data: {
                            us_openid: o
                        },
                        header: {
                            "Content-Type": "application/json"
                        },
                        success: function(e) {
                            console.log(e);
                            var t = e.data, a = t.substring(0, t.length - 1);
                            console.log(a), app.util.request({
                                url: "entry/wxapp/Bingliku",
                                data: {
                                    time: p,
                                    us_openid: o,
                                    keshi: i,
                                    title_content: s,
                                    us_jhospital: n,
                                    us_name: l,
                                    us_xhospital: c,
                                    us_yibao: u,
                                    thumb: a
                                },
                                header: {
                                    "Content-Type": "application/json"
                                },
                                success: function(e) {
                                    console.log(e.data), 1 == e.data.code ? wx.showToast({
                                        title: "提交失败"
                                    }) : wx.showModal({
                                        title: "提交成功",
                                        content: "",
                                        success: function(e) {
                                            wx.redirectTo({
                                                url: "../index/index"
                                            });
                                        }
                                    });
                                },
                                fail: function(e) {
                                    console.log(e);
                                }
                            });
                        }
                    });
                } else e.cancel && console.log("用户点击取消");
            }
        });
    },
    onLoad: function() {
        this.getBase();
        var t = this;
        app.siteInfo.uniacid;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(e) {
                console.log(e), t.setData({
                    url: e.data
                });
            }
        });
    },
    getBase: function() {
        var t = this;
        console.log(app), app.util.request({
            url: "entry/wxapp/Base",
            success: function(e) {
                console.log(e), t.setData({
                    show_title: e.data.data.show_title
                });
            },
            fail: function(e) {
                console.log(e);
            }
        });
    },
    uploadpic: function(e) {
        var i = this, s = i.data.upload_picture_list;
        function n(a, o, i) {
            var e = app.siteInfo.uniacid;
            console.log(e);
            var t = wx.getStorageSync("openid");
            console.log("开始上传" + i + "图片到服务器："), console.log(o[i]), wx.uploadFile({
                url: a.data.url + "app/index.php?i=" + e + "&c=entry&a=wxapp&do=msg_send_imgs&m=hyb_yl",
                filePath: o[i].path,
                name: "file",
                formData: {
                    path: "wxchat",
                    openid: t,
                    uniacid: e,
                    i_type: 0
                },
                success: function(e) {
                    console.log(e);
                    var t = e.data;
                    a.setData({
                        thumb: t,
                        upload_picture_list: o
                    }), console.log("图片上传" + i + "到服务器完成：");
                }
            }).onProgressUpdate(function(e) {
                o[i].upload_percent = e.progress, console.log("第" + i + "个图片上传进度：" + o[i].upload_percent), 
                console.log(o), a.setData({
                    upload_picture_list: o
                });
            });
        }
        wx.chooseImage({
            count: 8,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                var t = e.tempFiles;
                for (var a in t) t[a].upload_percent = 0, t[a].path_server = "", s.push(t[a]);
                for (var o in i.setData({
                    upload_picture_list: s
                }), 3 == s.length && i.setData({
                    hide: !0
                }), s) 0 == s[o].upload_percent && n(i, s, o);
            }
        });
    }
});