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
        zhuce: 1,
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
        uplogo: "",
        ge: 0,
        nav: {
            nav_list: [ {
                img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/yuyue.png",
                con: "我的预约",
                btn: "yuyueClick"
            }, {
                img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/dingdan.png",
                con: "我的课程",
                btn: "dingdanClick"
            }, {
                img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/tiwen.png",
                con: "我的提问",
                btn: "tiwenClick"
            }, {
                img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/xiaofei.png",
                con: "我的消费",
                btn: "xiaofeiClick"
            } ],
            currentTab: 0
        },
        nav1: {
            nav_list: [ {
                img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/yuyue.png",
                con: "患者预约",
                btn: "huanClick"
            }, {
                img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/dingdan.png",
                con: "我的处方",
                btn: "chufang"
            }, {
                img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/tiwen.png",
                con: "我的回答",
                btn: "daClick"
            } ],
            currentTab: 0
        },
        danganArr: [ 123 ],
        gongjuArr: [ {
            img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/2.2.png",
            con: "会话中心",
            btn: "dingdan1Click"
        }, {
            img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/2.5.png",
            con: "病例库",
            btn: "yutiClick"
        }, {
            img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/2.6.png",
            con: "平台报告",
            btn: "tiyuClick"
        }, {
            img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/cf.png",
            con: "我的处方",
            btn: "Mykchufang"
        }, {
            img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/2.8.png",
            con: "绑定手机",
            btn: "phoneClick"
        }, {
            img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/2.11.png",
            con: "编辑资料",
            btn: "dataClick"
        }, {
            img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/2.9.png",
            con: "我的关注",
            btn: "guanClick"
        }, {
            img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/tcdd.png",
            con: "服务订单",
            btn: "fuwuorder"
        }, {
            img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/微信图片_20180806101701.png",
            con: "我的理赔",
            btn: "lipeiClick"
        }, {
            img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/2.9.png",
            con: "健康档案",
            btn: "huanListClick"
        }, {
            img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/2.6.png",
            con: "体检报告",
            btn: "tijiabnbaogao"
        } ],
        gongjuArr1: [ {
            img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/2.11.png",
            con: "编辑资料",
            btn: "zhuanDataClick"
        }, {
            img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/1.5.png",
            con: "问题金额设置",
            btn: "zhuanWenClick"
        }, {
            img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/2.9.png",
            con: "扫码核销",
            btn: "erClick"
        }, {
            img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/2.2.png",
            con: "我的聊天",
            btn: "liaoClick"
        }, {
            img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/2.9.png",
            con: "我的患者",
            btn: "huanDetailClick"
        } ]
    },
    fuwuorder: function(a) {
        wx.navigateTo({
            url: "/hyb_yl/my_dingdan1/my_dingdan1"
        });
    },
    jiankangdangan: function(a) {
        var t = this.data.openid;
        wx.navigateTo({
            url: "/hyb_yl/mingxi/mingxi?openid=" + t
        });
    },
    tijiabnbaogao: function() {
        var a = this.data.openid;
        wx.navigateTo({
            url: "/hyb_yl/report/report?openid=" + a
        });
    },
    xiaofeiClick: function() {
        var a = this.data.openid;
        wx.navigateTo({
            url: "/hyb_yl/mingxi/mingxi?openid=" + a
        });
    },
    tiwenClick: function() {
        var a = this.data.openid;
        wx.navigateTo({
            url: "/hyb_yl/wodetiwen/wodetiwen?openid=" + a
        });
    },
    dingdanClick: function() {
        wx.navigateTo({
            url: "/hyb_yl/wodedingdan/wodedingdan"
        });
    },
    yuyueClick: function() {
        wx.navigateTo({
            url: "/hyb_yl/wodeyuyue/wodeyuyue"
        });
    },
    dingdan1Click: function() {
        var a = this.data.zid;
        wx.navigateTo({
            url: "/hyb_yl/guanzhuwode/guanzhuwode?id=" + a
        });
    },
    yutiClick: function() {
        this.data.zid;
        wx.navigateTo({
            url: "/hyb_yl/binglikulist/binglikulist"
        });
    },
    tiyuClick: function() {
        wx.navigateTo({
            url: "/hyb_yl/tijianbaogao/tijianbaogao"
        });
    },
    tibaoClick: function() {
        wx.navigateTo({
            url: "/hyb_yl/jianybaogao/jianybaogao"
        });
    },
    phoneClick: function() {
        wx.navigateTo({
            url: "/hyb_yl/tel/tel"
        });
    },
    dataClick: function() {
        wx.navigateTo({
            url: "/hyb_yl/gerenxinxi/gerenxinxi"
        });
    },
    guanClick: function() {
        wx.navigateTo({
            url: "/hyb_yl/wodeguanzhu/wodeguanzhu"
        });
    },
    huanListClick: function() {
        wx.navigateTo({
            url: "/hyb_yl/xinzengyiliao/xinzengyiliao?fuwu_name=健康档案"
        });
    },
    tiClick: function(a) {
        var t = a.currentTarget.dataset.docmoney;
        wx.navigateTo({
            url: "/hyb_yl/my_ti/my_ti?docmoney=" + t
        });
    },
    zongClick: function(a) {
        var t = a.currentTarget.dataset.docmoney;
        wx.navigateTo({
            url: "/hyb_yl/my_zong/my_zong?docmoney=" + t
        });
    },
    zhiwu: function(a) {
        var t = a.detail.value, n = this.data.pid[t];
        this.setData({
            pid: n,
            zhiwuindex: a.detail.value
        });
    },
    huanDetailClick: function() {
        var a = this.data.myzhuan;
        wx.navigateTo({
            url: "/hyb_yl/huan_detail/huan_detail?id=" + a.zid
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
        var n = this, i = app.siteInfo.uniacid;
        n.data.imgs;
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                var t = a.tempFilePaths[0];
                wx.uploadFile({
                    url: n.data.url + "app/index.php?i=" + i + "&c=entry&a=wxapp&do=Uploadsarray&m=hyb_yl",
                    filePath: t,
                    name: "upfile",
                    formData: {},
                    success: function(a) {
                        console.log(a.data), n.setData({
                            uplogo: a.data,
                            touxiangurl: t,
                            touxiang: !1
                        });
                    },
                    fail: function(a) {
                        console.log(a);
                    }
                }), n.setData({
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
        var t = a.currentTarget.dataset.index, n = this.data.upload_picture_list;
        n.splice(t, 1), this.setData({
            upload_picture_list: n,
            hide: !1
        });
    },
    qhtab: function(n) {
        var i = this, a = wx.getStorageSync("openid"), o = i.data.zj;
        app.util.request({
            url: "entry/wxapp/Zhuanjsh",
            data: {
                openid: a
            },
            success: function(a) {
                var t = a.data.data.z_yy_sheng;
                if (0 == t) return i.setData({
                    ge: 0,
                    types: t,
                    zj: o
                }), wx.showToast({
                    title: "资料审核中"
                }), !1;
                i.setData({
                    ge: n.target.dataset.ge,
                    types: t,
                    zj: o
                });
            }
        });
    },
    uploadImage: function() {
        var t = this, n = t.data.imgs;
        wx.chooseImage({
            count: 3,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                n.push(a.tempFilePaths), t.setData({
                    imgs: n
                }), 3 == n.length && t.setData({
                    hide: !0
                });
            }
        });
    },
    formsubmit: function(t) {
        var i = this.data.id, o = wx.getStorageSync("openid"), a = t.detail.value, e = a.z_name, u = a.z_sex, c = a.z_telephone, l = a.z_yiyuan, s = a.z_zhiwu, d = a.z_content, g = this.data.uplogo, p = this.data.pid;
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
                            openid: o
                        },
                        header: {
                            "Content-Type": "application/json"
                        },
                        success: function(a) {
                            var t = a.data, n = t.substring(0, t.length - 1);
                            app.util.request({
                                url: "entry/wxapp/Zimages",
                                data: {
                                    id: i,
                                    z_name: e,
                                    z_sex: u,
                                    z_telephone: c,
                                    z_yiyuan: l,
                                    z_zhiwu: s,
                                    z_content: d,
                                    openid: o,
                                    dataimg: n,
                                    z_thumbs: g,
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
    huanClick: function() {
        var a = this.data.myzhuan;
        wx.navigateTo({
            url: "/hyb_yl/huanzheyuyue/huanzheyuyue?id=" + a.zid
        });
    },
    onLoad: function(a) {
        var t = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: t
        });
        var o = this;
        o.setData({
            backgroundColor: t,
            myphone: app.globalData.myphone
        }), app.util.request({
            url: "entry/wxapp/Ifent",
            success: function(a) {
                o.setData({
                    kaiguan: a.data.data.kaiguan
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
                o.setData({
                    url: a.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Scurl",
            cachetime: "0",
            success: function(a) {
                o.setData({
                    scurl: a.data.data
                });
            }
        });
        var n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Myzhuan",
            data: {
                openid: n
            },
            success: function(a) {
                o.setData({
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
                for (var t = 0, n = 0, i = a.data.data.d_txmoney.length; n < i; n++) t += a.data.data.d_txmoney[n].d_txmoney;
                o.setData({
                    zhuanmoney: a.data.data.overmoney,
                    num: t.toFixed(2)
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
                o.setData({
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
                o.setData({
                    myxiaofeisum: a.data.data
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    replace: function() {
        var n = this, i = app.siteInfo.uniacid, o = (n.data.zhuanjiaImg, wx.getStorageSync("openid"));
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                var t = a.tempFilePaths[0];
                wx.uploadFile({
                    url: n.data.url + "app/index.php?i=" + i + "&c=entry&a=wxapp&do=Uploadsarray&m=hyb_yl",
                    filePath: t,
                    name: "upfile",
                    formData: {
                        path: "wxchat"
                    },
                    success: function(a) {
                        n.setData({
                            uplogo: a.data,
                            zhuanjiaImg: t
                        }), app.util.request({
                            url: "entry/wxapp/Myzhuanjiaimg",
                            data: {
                                openid: o,
                                uplogo: a.data
                            },
                            success: function(a) {
                                console.log(a.data.data), n.setData({
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
                }), n.setData({
                    logo: t
                });
            }
        });
    },
    onReady: function() {
        this.getIfdoc(), this.getBase(), this.getMyvt(), this.getKeshi(), this.getMyxfjl();
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
    getMyxfjl: function() {
        var t = this, a = wx.getStorageSync("openid"), n = app.siteInfo.uniacid;
        app.util.request({
            url: "entry/wxapp/Myxfjl",
            data: {
                openid: a,
                uniacid: n
            },
            success: function(a) {
                t.setData({
                    myxfjl: a.data.data
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    getMyvt: function() {
        var t = this, n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/myvt",
            data: {
                openid: n
            },
            success: function(a) {
                t.setData({
                    myvt: a.data.data,
                    openid: n
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    bindPickerChange1: function(a) {
        var t = this, n = a.detail.value, i = t.data.keshiid[n];
        console.log(i);
        var o = t.data.zhiwu[n];
        app.util.request({
            url: "entry/wxapp/Category2",
            data: {
                id: i
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
            id: i,
            zhiwuss: o
        });
    },
    bindPickerChange2: function(a) {
        var t = a.detail.value, n = this.data.monery, i = this.data.pid[t];
        console.log(i), this.setData({
            indexx: t,
            monerynum: n[t],
            id: i
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
        var o = this, e = o.data.upload_picture_list;
        function u(n, i, t) {
            var a = app.siteInfo.uniacid, o = wx.getStorageSync("openid");
            wx.uploadFile({
                url: n.data.url + "app/index.php?i=" + a + "&c=entry&a=wxapp&do=msg_send_imgs&m=hyb_yl",
                filePath: i[t].path,
                name: "file",
                formData: {
                    path: "wxchat",
                    openid: o,
                    uniacid: a,
                    i_type: 2
                },
                success: function(a) {
                    var t = a.data;
                    n.setData({
                        thumb: t,
                        upload_picture_list: i
                    });
                }
            }).onProgressUpdate(function(a) {
                i[t].upload_percent = a.progress, n.setData({
                    upload_picture_list: i
                });
            });
        }
        wx.chooseImage({
            count: 3,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                var t = a.tempFiles;
                for (var n in t) t[n].upload_percent = 0, t[n].path_server = "", e.push(t[n]);
                for (var i in o.setData({
                    upload_picture_list: e
                }), 3 == e.length && o.setData({
                    hide: !0
                }), e) 0 == e[i].upload_percent && u(o, e, i);
            }
        });
    },
    erClick: function() {
        0 == this.data.myxfjl.u_type ? wx.showToast({
            title: "暂无核销权限"
        }) : wx.showActionSheet({
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
        var t = this.data.myzhuan;
        wx.navigateTo({
            url: "/hyb_yl/my_prescription/my_prescription?id=" + t.zid
        });
    },
    daClick: function(a) {
        var t = this.data.myzhuan;
        console.log(t), wx.navigateTo({
            url: "/hyb_yl/wodehuida/wodehuida?zid=" + t.zid
        });
    },
    zhuanDataClick: function() {
        var a = this.data.myzhuan;
        wx.navigateTo({
            url: "/hyb_yl/zhuanjiaziliao/zhuanjiaziliao?id=" + a.zid
        });
    },
    zhuanWenClick: function() {
        var a = this.data.myzhuan;
        wx.navigateTo({
            url: "/hyb_yl/wentijine/wentijine?zid=" + a.zid
        });
    },
    liaoClick: function() {
        var a = this.data.myzhuan;
        wx.navigateTo({
            url: "/hyb_yl/guanzhuwode/guanzhuwode?zid=" + a.zid
        });
    },
    lipeiClick: function() {
        wx.navigateTo({
            url: "/hyb_yl/zhuan_huan/zhuan_huan"
        });
    },
    getIfdoc: function() {
        var t = this, a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Zhuanjsh",
            data: {
                openid: a
            },
            success: function(a) {
                t.setData({
                    zhuce: a.data.data.z_yy_sheng,
                    id: a.data.data,
                    zj: a.data.data
                });
            }
        });
    },
    Mykchufang: function() {
        var a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Myinfouid",
            data: {
                openid: a
            },
            success: function(a) {
                var t = a.data.data.my_id;
                wx.navigateTo({
                    url: "/hyb_yl/my_hzprescription/my_hzprescription?userid=" + t
                });
            }
        });
    }
});