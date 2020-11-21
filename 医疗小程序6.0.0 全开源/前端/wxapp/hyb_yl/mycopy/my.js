var app = getApp();

Page({
    data: {
        zhiwuss: [],
        zhiwu: [],
        userInfo: {},
        qhtab: [ "个人", "专家" ],
        current: 0,
        touxiang: !0,
        touxiangurl: "",
        hide: !1,
        imgs: [],
        zhuce: 0,
        array1: [],
        indexx: null,
        array: [],
        yiyuan: [],
        zhuanjiaImg: "",
        radioIndex: 1,
        ids: [],
        index: null,
        zhiwuindex: null,
        upload_picture_list: [],
        date: "",
        uplogo: ""
    },
    zhiwu: function(a) {
        var t = a.detail.value, e = this.data.pid[t];
        this.setData({
            pid: e,
            zhiwuindex: a.detail.value
        });
    },
    tijianbaogao: function() {
        wx.showToast({
            title: "功能暂未开发"
        });
    },
    deletetouxiang: function() {
        this.setData({
            touxiang: !0,
            touxiangurl: ""
        });
    },
    touxiang: function() {
        var e = this, n = app.siteInfo.uniacid;
        e.data.imgs;
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                var t = a.tempFilePaths[0];
                wx.uploadFile({
                    url: e.data.url + "app/index.php?i=" + n + "&c=entry&a=wxapp&do=Uploadsarray&m=hyb_yl",
                    filePath: t,
                    name: "upfile",
                    formData: {},
                    success: function(a) {
                        e.setData({
                            uplogo: a.data,
                            touxiangurl: t,
                            touxiang: !1
                        });
                    },
                    fail: function(a) {
                        console.log(a);
                    }
                }), e.setData({
                    logo: t
                });
            }
        });
    },
    bindDateChange: function(a) {
        this.setData({
            date: a.detail.value
        });
    },
    deleteimg: function(a) {
        var t = a.currentTarget.dataset.index, e = this.data.upload_picture_list;
        e.splice(t, 1), this.setData({
            upload_picture_list: e,
            hide: !1
        });
    },
    qhtab: function(t) {
        var e = this;
        console.log(t);
        var a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Zhuanjsh",
            data: {
                openid: a
            },
            success: function(a) {
                if (!1 !== a.data.dat && e.setData({
                    zhuce: a.data.data.z_yy_sheng,
                    id: a.data.data
                }), 1 == t.currentTarget.dataset.index) {
                    if (0 == a.data.data.z_yy_sheng) return wx.showModal({
                        content: "您提交的资料还在审核当中"
                    }), !1;
                    e.setData({
                        current: t.currentTarget.dataset.index
                    });
                } else e.setData({
                    current: t.currentTarget.dataset.index
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    uploadImage: function() {
        var t = this, e = t.data.imgs;
        wx.chooseImage({
            count: 3,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                e.push(a.tempFilePaths), t.setData({
                    imgs: e
                }), 3 == e.length && t.setData({
                    hide: !0
                });
            }
        });
    },
    formsubmit: function(t) {
        var a = this, n = a.data.id, i = wx.getStorageSync("openid"), e = t.detail.value, o = e.z_name, s = e.z_sex, u = e.z_telephone, c = e.z_yiyuan, l = e.z_zhiwu, d = e.z_content, r = a.data.uplogo, p = a.data.pid;
        return console.log(), 0 == t.detail.value.z_name.length || 0 == t.detail.value.z_telephone.length ? (wx.showModal({
            content: "姓名和手机号不能为空"
        }), !1) : 0 == t.detail.value.z_yiyuan.length ? (wx.showModal({
            content: "请填写所在医院"
        }), !1) : 0 == t.detail.value.pid.length ? (wx.showModal({
            content: "请选择二级科室"
        }), !1) : void wx.showModal({
            title: "提示",
            content: " 确认提交么？ ",
            success: function(a) {
                if (a.confirm) {
                    console.log("用户点击确定");
                    t.detail.value;
                    app.util.request({
                        url: "entry/wxapp/zhuanjiash",
                        data: {
                            openid: i
                        },
                        header: {
                            "Content-Type": "application/json"
                        },
                        success: function(a) {
                            var t = a.data, e = t.substring(0, t.length - 1);
                            app.util.request({
                                url: "entry/wxapp/Zimages",
                                data: {
                                    id: n,
                                    z_name: o,
                                    z_sex: s,
                                    z_telephone: u,
                                    z_yiyuan: c,
                                    z_zhiwu: l,
                                    z_content: d,
                                    openid: i,
                                    dataimg: e,
                                    z_thumbs: r,
                                    pid: p
                                },
                                header: {
                                    "Content-Type": "application/json"
                                },
                                success: function(a) {
                                    console.log(a), wx.showLoading({
                                        title: "提交成功待审核"
                                    }), setTimeout(function() {
                                        wx.hideLoading(), wx.reLaunch({
                                            url: "../index/index"
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
    onLoad: function(a) {
        var t = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: t
        });
        var e = this;
        app.util.request({
            url: "entry/wxapp/Ifent",
            success: function(a) {
                e.setData({
                    kaiguan: a.data.data.kaiguan
                });
            },
            fail: function(a) {
                console.log(a);
            }
        }), wx.login({
            success: function(a) {
                wx.getUserInfo({
                    success: function(a) {
                        var t = a.userInfo;
                        e.setData({
                            userInfo: t
                        });
                    }
                });
            }
        });
        var n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Myphone",
            data: {
                openid: n
            },
            success: function(a) {
                e.setData({
                    myphone: a.data.data,
                    openid: n
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
        app.siteInfo.uniacid;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(a) {
                e.setData({
                    url: a.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Scurl",
            cachetime: "0",
            success: function(a) {
                e.setData({
                    scurl: a.data.data
                });
            }
        });
        n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Myzhuan",
            data: {
                openid: n
            },
            success: function(a) {
                e.setData({
                    myzhuan: a.data.data,
                    zhuanjiaImg: a.data.data.z_thumbs
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
        n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Doctormoney",
            data: {
                openid: n
            },
            success: function(a) {
                e.setData({
                    zhuanmoney: a.data.data.money
                });
            },
            fail: function(a) {
                console.log(a);
            }
        }), app.util.request({
            url: "entry/wxapp/Doctormoneytx",
            data: {
                openid: n
            },
            success: function(a) {
                e.setData({
                    zhuanmoneysy: a.data.data.money
                });
            },
            fail: function(a) {
                console.log(a);
            }
        }), app.util.request({
            url: "entry/wxapp/Myxiaofeisum",
            data: {
                openid: n
            },
            success: function(a) {
                e.setData({
                    myxiaofeisum: a.data.data
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    replace: function() {
        var e = this, n = app.siteInfo.uniacid, i = (e.data.zhuanjiaImg, wx.getStorageSync("openid"));
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                var t = a.tempFilePaths[0];
                wx.uploadFile({
                    url: e.data.url + "app/index.php?i=" + n + "&c=entry&a=wxapp&do=Uploadsarray&m=hyb_yl",
                    filePath: t,
                    name: "upfile",
                    formData: {
                        path: "wxchat"
                    },
                    success: function(a) {
                        e.setData({
                            uplogo: a.data,
                            zhuanjiaImg: t
                        }), app.util.request({
                            url: "entry/wxapp/Myzhuanjiaimg",
                            data: {
                                openid: i,
                                uplogo: a.data
                            },
                            success: function(a) {
                                console.log(a.data.data), e.setData({
                                    myxiaofeisum: a.data.data
                                });
                            },
                            fail: function(a) {
                                console.log(a);
                            }
                        });
                    },
                    fail: function(a) {
                        console.log(a);
                    }
                }), e.setData({
                    logo: t
                });
            }
        });
    },
    onReady: function() {
        this.getBase(), this.getMyvt(), this.getKeshi(), this.getMyxfjl();
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var a = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: a
        }), this.getBase(), this.getMyvt(), this.getKeshi(), this.getMyxfjl(), wx.showNavigationBarLoading(), 
        setTimeout(function() {
            wx.stopPullDownRefresh(), wx.hideNavigationBarLoading();
        }, 1e3);
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    getMyxfjl: function() {
        var t = this, a = wx.getStorageSync("openid"), e = app.siteInfo.uniacid;
        app.util.request({
            url: "entry/wxapp/Myxfjl",
            data: {
                openid: a,
                uniacid: e
            },
            success: function(a) {
                console.log(a), t.setData({
                    myxfjl: a.data.data
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    getMyvt: function() {
        var t = this, e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/myvt",
            data: {
                openid: e
            },
            success: function(a) {
                t.setData({
                    myvt: a.data.data,
                    openid: e
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    bindPickerChange1: function(a) {
        var t = this, e = a.detail.value, n = t.data.keshiid[e];
        console.log(n);
        var i = t.data.zhiwu[e];
        app.util.request({
            url: "entry/wxapp/Category2",
            data: {
                id: n
            },
            success: function(a) {
                console.log(a), t.setData({
                    zhiwuss: a.data.data.name,
                    pid: a.data.data.id
                });
            },
            fail: function(a) {
                console.log(a);
            }
        }), t.setData({
            index: a.detail.value,
            id: n,
            zhiwuss: i
        });
    },
    bindPickerChange2: function(a) {
        var t = a.detail.value, e = this.data.monery, n = this.data.pid[t];
        console.log(n), this.setData({
            indexx: t,
            monerynum: e[t],
            id: n
        });
    },
    bindPickerChange: function(a) {
        this.setData({
            index: a.detail.value
        });
    },
    switchChange: function(a) {
        console.log("switch1 发生 change 事件，携带值为", a.detail.value);
    },
    radio: function(a) {
        var t = a.detail.value;
        this.setData({
            radioIndex: a.detail.value,
            ky_sex: t
        });
    },
    getBase: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(a) {
                t.setData({
                    baseinfo: a.data.data,
                    bq_thumb: a.data.data.bq_thumb,
                    bq_name: a.data.data.bq_name
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    getKeshi: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Keshi",
            success: function(a) {
                t.setData({
                    keshi: a.data.data.name,
                    keshiid: a.data.data.id
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    uploadpic: function(a) {
        var i = this, o = i.data.upload_picture_list;
        function s(e, n, t) {
            var a = app.siteInfo.uniacid, i = wx.getStorageSync("openid");
            wx.uploadFile({
                url: e.data.url + "app/index.php?i=" + a + "&c=entry&a=wxapp&do=msg_send_imgs&m=hyb_yl",
                filePath: n[t].path,
                name: "file",
                formData: {
                    path: "wxchat",
                    openid: i,
                    uniacid: a,
                    i_type: 2
                },
                success: function(a) {
                    var t = a.data;
                    e.setData({
                        thumb: t,
                        upload_picture_list: n
                    });
                }
            }).onProgressUpdate(function(a) {
                n[t].upload_percent = a.progress, e.setData({
                    upload_picture_list: n
                });
            });
        }
        wx.chooseImage({
            count: 3,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                var t = a.tempFiles;
                for (var e in t) t[e].upload_percent = 0, t[e].path_server = "", o.push(t[e]);
                for (var n in i.setData({
                    upload_picture_list: o
                }), 3 == o.length && i.setData({
                    hide: !0
                }), o) 0 == o[n].upload_percent && s(i, o, n);
            }
        });
    },
    erClick: function() {
        wx.showActionSheet({
            itemList: [ "预约核销" ],
            success: function(a) {
                0 == a.tapIndex && wx.navigateTo({
                    url: "../hexiao/hexiao"
                });
            },
            fail: function(a) {
                console.log(a.errMsg);
            }
        });
    },
    chufang: function(a) {
        var t = a.currentTarget.dataset.id;
        wx.navigateTo({
            url: "/hyb_yl/my_prescription/my_prescription?id=" + t
        });
    }
});