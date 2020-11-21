var _data;

function _defineProperty(a, e, t) {
    return e in a ? Object.defineProperty(a, e, {
        value: t,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[e] = t, a;
}

var app = getApp();

Page({
    data: (_data = {
        imgs: [],
        radioIndex: 1,
        hide: !0,
        touxiang: !0,
        touxiangurl: "",
        upload_picture_list: [],
        uplogo: ""
    }, _defineProperty(_data, "imgs", []), _defineProperty(_data, "zhuce", 0), _defineProperty(_data, "array1", []), 
    _defineProperty(_data, "indexx", null), _defineProperty(_data, "array", []), _defineProperty(_data, "yiyuan", []), 
    _defineProperty(_data, "radioIndex", 1), _defineProperty(_data, "ids", []), _defineProperty(_data, "index", null), 
    _defineProperty(_data, "date", ""), _data),
    bindPickerChange1: function(a) {
        var e = this, t = a.detail.value, n = e.data.ids[t];
        e.setData({
            id: n
        }), e.setData({
            index: a.detail.value
        });
    },
    formsubmit: function(e) {
        var t = this.data.id, n = wx.getStorageSync("openid"), a = e.detail.value, i = a.z_name, o = a.z_sex, u = a.z_telephone, l = a.z_yiyuan, s = a.z_zhiwu, d = a.z_content, r = this.data.uplogo;
        return 0 == e.detail.value.z_name.length || 0 == e.detail.value.z_telephone.length ? (wx.showModal({
            content: "姓名和手机号不能为空"
        }), !1) : 0 == e.detail.value.z_yiyuan.length ? (wx.showModal({
            content: "请填写所在医院"
        }), !1) : 0 == e.detail.value.z_room.length ? (wx.showModal({
            content: "请选择就诊科室"
        }), !1) : 0 == e.detail.value.z_zhiwu.length ? (wx.showModal({
            content: "请填写真实职务"
        }), !1) : void wx.showModal({
            title: "提示",
            content: " 确认提交么？ ",
            success: function(a) {
                if (a.confirm) {
                    console.log("用户点击确定");
                    e.detail.value;
                    app.util.request({
                        url: "entry/wxapp/zhuanjiash",
                        data: {
                            openid: n
                        },
                        header: {
                            "Content-Type": "application/json"
                        },
                        success: function(a) {
                            var e = a.data;
                            console.log(e), app.util.request({
                                url: "entry/wxapp/Zimagesnew",
                                data: {
                                    id: t,
                                    z_name: i,
                                    z_sex: o,
                                    z_telephone: u,
                                    z_yiyuan: l,
                                    z_zhiwu: s,
                                    z_content: d,
                                    openid: n,
                                    z_thumbs: r
                                },
                                header: {
                                    "Content-Type": "application/json"
                                },
                                success: function(a) {
                                    console.log(a), wx.showLoading({
                                        title: "修改成功"
                                    }), setTimeout(function() {
                                        wx.hideLoading(), wx.redirectTo({
                                            url: "../my/my"
                                        });
                                    }, 800);
                                },
                                fail: function(a) {
                                    console.log(a);
                                }
                            });
                        },
                        fail: function(a) {
                            console.log(a);
                        }
                    });
                } else a.cancel && console.log("用户点击取消");
            }
        });
    },
    deletetouxiang: function() {
        this.setData({
            touxiang: !0,
            touxiangurl: ""
        });
    },
    touxiang: function() {
        var t = this, n = app.siteInfo.uniacid;
        t.data.imgs;
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                var e = a.tempFilePaths[0];
                wx.uploadFile({
                    url: t.data.url + "app/index.php?i=" + n + "&c=entry&a=wxapp&do=Uploads&m=hyb_yl",
                    filePath: e,
                    name: "upfile",
                    formData: {
                        path: "wxchat"
                    },
                    success: function(a) {
                        console.log(a.data), t.setData({
                            uplogo: a.data,
                            touxiangurl: e,
                            touxiang: !1
                        });
                    },
                    fail: function(a) {
                        console.log(a);
                    }
                }), t.setData({
                    logo: e
                });
            }
        });
    },
    uploadpic: function(a) {
        var i = this, o = i.data.upload_picture_list;
        function u(t, n, i) {
            var a = app.siteInfo.uniacid, e = wx.getStorageSync("openid");
            wx.uploadFile({
                url: t.data.url + "app/index.php?i=" + a + "&c=entry&a=wxapp&do=msg_send_imgs&m=hyb_yl",
                filePath: n[i].path,
                name: "file",
                formData: {
                    path: "wxchat",
                    openid: e,
                    uniacid: a,
                    i_type: 2
                },
                success: function(a) {
                    console.log(a);
                    var e = a.data;
                    t.setData({
                        thumb: e,
                        upload_picture_list: n
                    }), console.log("图片上传" + i + "到服务器完成：");
                }
            }).onProgressUpdate(function(a) {
                n[i].upload_percent = a.progress, console.log("第" + i + "个图片上传进度：" + n[i].upload_percent), 
                console.log(n), t.setData({
                    upload_picture_list: n
                });
            });
        }
        wx.chooseImage({
            count: 8,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                var e = a.tempFiles;
                for (var t in e) e[t].upload_percent = 0, e[t].path_server = "", o.push(e[t]);
                for (var n in i.setData({
                    upload_picture_list: o
                }), 3 == o.length && i.setData({
                    hide: !0
                }), o) 0 == o[n].upload_percent && u(i, o, n);
            }
        });
    },
    deleteimg: function(a) {
        var e = a.currentTarget.dataset.index, t = this.data.imgs;
        t.splice(e, 1), this.setData({
            imgs: t,
            hide: !1
        });
    },
    radio: function(a) {
        this.setData({
            radioIndex: a.detail.value
        });
    },
    getKeshi: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Keshi",
            cachetime: "30",
            success: function(a) {
                e.setData({
                    array1: a.data.data.k_name,
                    ids: a.data.data.k_id
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    onLoad: function(a) {
        var t = this, e = a.id, n = app.siteInfo.uniacid;
        n = app.siteInfo.uniacid;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(a) {
                t.setData({
                    url: a.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Zjinfo",
            data: {
                id: e,
                uniacid: n
            },
            success: function(a) {
                var e = a.data.data.z_thumb.split(";");
                e.splice(e.length - 1, 1), e.length < 3 && t.setData({
                    hide: !1
                }), t.setData({
                    userinfo: a.data.data,
                    touxiangurl: a.data.data.z_thumbs,
                    upload_picture_list: e
                });
            },
            fail: function(a) {
                console.log(a);
            }
        }), app.util.request({
            url: "entry/wxapp/Scurl",
            cachetime: "0",
            success: function(a) {
                t.setData({
                    scurl: a.data.data
                });
            }
        });
    },
    onReady: function() {
        this.getKeshi();
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});