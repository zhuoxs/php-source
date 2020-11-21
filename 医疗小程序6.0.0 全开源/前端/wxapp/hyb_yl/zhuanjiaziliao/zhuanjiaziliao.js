var _data, _Page;

function _defineProperty(e, a, t) {
    return a in e ? Object.defineProperty(e, a, {
        value: t,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[a] = t, e;
}

var app = getApp();

Page((_defineProperty(_Page = {
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
    _defineProperty(_data, "ids", []), _defineProperty(_data, "index", null), _defineProperty(_data, "date", ""), 
    _defineProperty(_data, "zhiwuindex", null), _data),
    getKeshi: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Keshi",
            success: function(e) {
                a.setData({
                    keshi: e.data.data.name,
                    keshiid: e.data.data.id
                });
            },
            fail: function(e) {
                console.log(e);
            }
        });
    },
    formsubmit: function(a) {
        var e = this, t = e.data.id, i = wx.getStorageSync("openid"), n = a.detail.value, o = n.z_name, d = n.z_sex, u = n.z_telephone, r = n.z_yiyuan, s = n.z_zhiwu, l = n.z_content, p = e.data.uplogo, c = e.data.pid;
        return 0 == a.detail.value.z_name.length || 0 == a.detail.value.z_telephone.length ? (wx.showModal({
            content: "姓名和手机号不能为空"
        }), !1) : 0 == a.detail.value.z_yiyuan.length ? (wx.showModal({
            content: "请填写所在医院"
        }), !1) : 0 == a.detail.value.pid.length ? (wx.showModal({
            content: "请选择科室"
        }), !1) : 0 == a.detail.value.z_zhiwu.length ? (wx.showModal({
            content: "请填写真实职务"
        }), !1) : void wx.showModal({
            title: "提示",
            content: " 确认提交么？ ",
            success: function(e) {
                if (e.confirm) {
                    a.detail.value;
                    app.util.request({
                        url: "entry/wxapp/zhuanjiash",
                        data: {
                            openid: i
                        },
                        header: {
                            "Content-Type": "application/json"
                        },
                        success: function(e) {
                            e.data;
                            app.util.request({
                                url: "entry/wxapp/Zimagesnew",
                                data: {
                                    id: t,
                                    z_name: o,
                                    z_sex: d,
                                    z_telephone: u,
                                    z_yiyuan: r,
                                    z_zhiwu: s,
                                    z_content: l,
                                    openid: i,
                                    z_thumbs: p,
                                    z_room: c
                                },
                                header: {
                                    "Content-Type": "application/json"
                                },
                                success: function(e) {
                                    wx.showLoading({
                                        title: "修改成功"
                                    }), setTimeout(function() {
                                        wx.hideLoading(), wx.redirectTo({
                                            url: "../my/my"
                                        });
                                    }, 800);
                                },
                                fail: function(e) {
                                    console.log(e);
                                }
                            });
                        },
                        fail: function(e) {
                            console.log(e);
                        }
                    });
                } else e.cancel && console.log("用户点击取消");
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
        var t = this, i = app.siteInfo.uniacid;
        t.data.imgs;
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                var a = e.tempFilePaths[0];
                wx.uploadFile({
                    url: t.data.url + "app/index.php?i=" + i + "&c=entry&a=wxapp&do=Uploads&m=hyb_yl",
                    filePath: a,
                    name: "upfile",
                    formData: {
                        path: "wxchat"
                    },
                    success: function(e) {
                        console.log(e.data), t.setData({
                            uplogo: e.data,
                            touxiangurl: a,
                            touxiang: !1
                        });
                    },
                    fail: function(e) {
                        console.log(e);
                    }
                }), t.setData({
                    logo: a
                });
            }
        });
    },
    uploadpic: function(e) {
        var n = this, o = n.data.upload_picture_list;
        function d(t, i, n) {
            var e = app.siteInfo.uniacid, a = wx.getStorageSync("openid");
            wx.uploadFile({
                url: t.data.url + "app/index.php?i=" + e + "&c=entry&a=wxapp&do=msg_send_imgs&m=hyb_yl",
                filePath: i[n].path,
                name: "file",
                formData: {
                    path: "wxchat",
                    openid: a,
                    uniacid: e,
                    i_type: 2
                },
                success: function(e) {
                    console.log(e);
                    var a = e.data;
                    t.setData({
                        thumb: a,
                        upload_picture_list: i
                    }), console.log("图片上传" + n + "到服务器完成：");
                }
            }).onProgressUpdate(function(e) {
                i[n].upload_percent = e.progress, console.log("第" + n + "个图片上传进度：" + i[n].upload_percent), 
                console.log(i), t.setData({
                    upload_picture_list: i
                });
            });
        }
        wx.chooseImage({
            count: 8,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                var a = e.tempFiles;
                for (var t in a) a[t].upload_percent = 0, a[t].path_server = "", o.push(a[t]);
                for (var i in n.setData({
                    upload_picture_list: o
                }), 3 == o.length && n.setData({
                    hide: !0
                }), o) 0 == o[i].upload_percent && d(n, o, i);
            }
        });
    },
    deleteimg: function(e) {
        var a = e.currentTarget.dataset.index, t = this.data.imgs;
        t.splice(a, 1), this.setData({
            imgs: t,
            hide: !1
        });
    },
    radio: function(e) {
        this.setData({
            radioIndex: e.detail.value
        });
    }
}, "getKeshi", function() {
    var a = this;
    app.util.request({
        url: "entry/wxapp/Keshi",
        success: function(e) {
            a.setData({
                keshi: e.data.data.name,
                keshiid: e.data.data.id
            });
        },
        fail: function(e) {
            console.log(e);
        }
    });
}), _defineProperty(_Page, "onLoad", function(e) {
    var a = wx.getStorageSync("color");
    wx.setNavigationBarColor({
        frontColor: "#ffffff",
        backgroundColor: a
    });
    var i = this, t = e.id;
    app.siteInfo.uniacid, app.siteInfo.uniacid;
    app.util.request({
        url: "entry/wxapp/url",
        cachetime: "0",
        success: function(e) {
            i.setData({
                url: e.data
            });
        }
    }), app.util.request({
        url: "entry/wxapp/Zjinfo",
        data: {
            id: t
        },
        success: function(e) {
            console.log(e);
            var a = e.data.data.z_thumb.split(";");
            a.splice(a.length - 1, 1), a.length < 3 && i.setData({
                hide: !1
            });
            var t = e.data.data.z_room;
            app.util.request({
                url: "entry/wxapp/Parentid",
                data: {
                    id: t
                },
                success: function(e) {
                    i.setData({
                        name: e.data.data.name
                    });
                }
            }), i.setData({
                userinfo: e.data.data,
                touxiangurl: e.data.data.z_thumbs,
                upload_picture_list: a
            });
        },
        fail: function(e) {
            console.log(e);
        }
    }), app.util.request({
        url: "entry/wxapp/Scurl",
        cachetime: "0",
        success: function(e) {
            i.setData({
                scurl: e.data.data
            });
        }
    });
}), _defineProperty(_Page, "onReady", function() {
    this.getKeshi();
}), _defineProperty(_Page, "onShow", function() {}), _defineProperty(_Page, "onHide", function() {}), 
_defineProperty(_Page, "onUnload", function() {}), _defineProperty(_Page, "onPullDownRefresh", function() {}), 
_defineProperty(_Page, "onReachBottom", function() {}), _defineProperty(_Page, "onShareAppMessage", function() {}), 
_defineProperty(_Page, "zhiwu", function(e) {
    var a = e.detail.value, t = this.data.getpid[a];
    this.setData({
        pid: t,
        zhiwuindex: e.detail.value
    });
}), _defineProperty(_Page, "bindPickerChange1", function(e) {
    var a = this, t = e.detail.value, i = a.data.keshiid[t];
    a.data.zhiwu;
    app.util.request({
        url: "entry/wxapp/Category2",
        data: {
            id: i
        },
        success: function(e) {
            a.setData({
                zhiwuss: e.data.data.name,
                getpid: e.data.data.id,
                zhiwuindex: ""
            });
        },
        fail: function(e) {
            console.log(e);
        }
    }), a.setData({
        index: e.detail.value,
        id: i
    });
}), _defineProperty(_Page, "bindPickerChange2", function(e) {
    var a = e.detail.value, t = this.data.monery, i = this.data.pid[a];
    console.log(i), this.setData({
        indexx: a,
        monerynum: t[a],
        id: i
    });
}), _Page));