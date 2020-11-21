var _data;

function _defineProperty(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

var app = getApp();

Page({
    data: (_data = {
        guanzhu: !0,
        wordLength: 0,
        imgs: [],
        hide: !1,
        tishi: !0,
        toastHidden3: !0,
        toastHidden4: !1,
        textarea: "",
        tw_money: "",
        doctor_openid: "",
        tishiindex: 0,
        uniacid: 0,
        upload_picture_list: ""
    }, _defineProperty(_data, "imgs", []), _defineProperty(_data, "upload_picture_list", []), 
    _data),
    tishi: function() {
        var t = this.data.imgs;
        0 == this.data.tishi ? (t = null, this.setData({
            imgs: t,
            tishiindex: 0
        })) : this.setData({
            imgs: t,
            tishiindex: 1
        }), this.setData({
            tishi: !this.data.tishi
        }), console.log(this.data.tishiindex);
    },
    computing_word: function(t) {
        console.log(t.detail.value), this.setData({
            wordLength: t.detail.value.length,
            textarea: t.detail.value
        });
    },
    uploadImage: function() {
        var e = this, a = e.data.imgs;
        wx.chooseImage({
            count: 6,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(t) {
                a.push(t.tempFilePaths), e.setData({
                    imgs: a
                }), 3 == a.length && e.setData({
                    hide: !0
                });
            }
        });
    },
    formSubmit: function(e) {
        var t = this, o = this.data.tishiindex;
        console.log(o);
        var i = this.data.textarea, n = (this.data.imgs, this.data.tw_money), s = wx.getStorageSync("openid"), c = this.data.doctor_openid, d = e.detail.value.p_id, l = e.detail.value.q_dname, u = e.detail.value.q_zhiwei, p = e.detail.value.q_docthumb, r = t.data.userInfo.nickName, g = t.data.userInfo.avatarUrl, a = (e.detail.value, 
        t.data.zid);
        if (console.log(a), "" == e.detail.value.tiwen) wx.showModal({
            title: "",
            content: "请填写问题描述"
        }); else {
            e.detail.value;
            if (1 == this.data.tishi && this.data.imgs, n <= 0) console.log("免费"), wx.showModal({
                title: "提示",
                content: " 确认提交么？ ",
                success: function(t) {
                    if (t.confirm) {
                        console.log("用户点击确定");
                        e.detail.value;
                        app.util.request({
                            url: "entry/wxapp/Selcetwzximg",
                            data: {
                                us_openid: s,
                                i_doctor: a
                            },
                            header: {
                                "Content-Type": "application/json"
                            },
                            success: function(t) {
                                console.log(t);
                                var e = t.data, a = e.substring(0, e.length - 1);
                                console.log(a), app.util.request({
                                    url: "entry/wxapp/Doctorqs",
                                    data: {
                                        question: i,
                                        user_picture: a,
                                        user_payment: n,
                                        user_openid: s,
                                        savant_openid: c,
                                        sj_type: o,
                                        p_id: d,
                                        q_username: r,
                                        q_thumb: g,
                                        q_docthumb: p,
                                        q_zhiwei: u,
                                        q_dname: l,
                                        h_pic: 1
                                    },
                                    header: {
                                        "content-type": "application/json"
                                    },
                                    success: function(t) {
                                        wx.showLoading({
                                            title: "提问成功"
                                        }), setTimeout(function() {
                                            wx.hideLoading(), wx.redirectTo({
                                                url: "../wodetiwen/wodetiwen"
                                            });
                                        }, 800);
                                    },
                                    fail: function(t) {
                                        console.log(t);
                                    }
                                });
                            }
                        });
                    }
                }
            }); else {
                console.log("收费");
                var h = this.data.tw_money;
                s = wx.getStorageSync("openid");
                wx.showModal({
                    title: "提示",
                    content: " 确认提交么？ ",
                    success: function(t) {
                        if (t.confirm) {
                            console.log("用户点击确定");
                            e.detail.value;
                            app.util.request({
                                url: "entry/wxapp/Selcetwzximg",
                                data: {
                                    us_openid: s,
                                    i_doctor: a
                                },
                                header: {
                                    "Content-Type": "application/json"
                                },
                                success: function(t) {
                                    console.log(t);
                                    var e = t.data, a = e.substring(0, e.length - 1);
                                    console.log(a), app.util.request({
                                        url: "entry/wxapp/Pay",
                                        header: {
                                            "Content-Type": "application/xml"
                                        },
                                        method: "GET",
                                        data: {
                                            openid: s,
                                            z_tw_money: h
                                        },
                                        success: function(t) {
                                            console.log(t), wx.requestPayment({
                                                timeStamp: t.data.timeStamp,
                                                nonceStr: t.data.nonceStr,
                                                package: t.data.package,
                                                signType: t.data.signType,
                                                paySign: t.data.paySign,
                                                success: function(t) {
                                                    console.log(t), app.util.request({
                                                        url: "entry/wxapp/Doctorqs",
                                                        data: {
                                                            question: i,
                                                            user_picture: a,
                                                            user_payment: h,
                                                            user_openid: s,
                                                            savant_openid: c,
                                                            sj_type: o,
                                                            p_id: d,
                                                            q_username: r,
                                                            q_thumb: g,
                                                            q_docthumb: p,
                                                            q_zhiwei: u,
                                                            q_dname: l,
                                                            h_pic: 1
                                                        },
                                                        header: {
                                                            "content-type": "application/json"
                                                        },
                                                        success: function(t) {
                                                            wx.showLoading({
                                                                title: "提问成功"
                                                            }), setTimeout(function() {
                                                                wx.hideLoading(), wx.redirectTo({
                                                                    url: "../wodetiwen/wodetiwen"
                                                                });
                                                            }, 800);
                                                        },
                                                        fail: function(t) {
                                                            console.log(t);
                                                        }
                                                    });
                                                }
                                            });
                                        },
                                        fail: function(t) {
                                            console.log(t);
                                        }
                                    });
                                }
                            });
                        }
                    }
                });
            }
        }
    },
    onLoad: function(t) {
        var a = this, e = t.id, o = wx.getStorageSync("openid"), i = app.siteInfo.uniacid;
        console.log(i), app.util.request({
            url: "entry/wxapp/Zhuanjiaxiangqing",
            data: {
                id: e
            },
            success: function(t) {
                console.log(t.data.data), a.setData({
                    zid: e,
                    xiangqing: t.data.data,
                    tw_money: t.data.data.z_tw_money,
                    doctor_openid: t.data.data.openid
                });
            },
            fail: function(t) {
                console.log(t);
            }
        }), app.util.request({
            url: "entry/wxapp/CheckCollect",
            headers: {
                "Content-Type": "application/json"
            },
            cachetime: "0",
            data: {
                openid: o,
                goods_id: e
            },
            success: function(t) {
                2 == t.data ? (console.log("已经关注"), a.setData({
                    toastHidden3: !0,
                    toastHidden4: !1
                })) : 1 == t.data && (console.log("关注"), a.setData({
                    toastHidden3: !1,
                    toastHidden4: !0
                }));
            }
        }), app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(t) {
                a.setData({
                    url: t.data
                }), wx.setStorageSync("urls", t.data);
            }
        }), wx.login({
            success: function() {
                wx.getUserInfo({
                    success: function(t) {
                        var e = t.userInfo;
                        a.setData({
                            userInfo: e
                        });
                    }
                });
            }
        });
        i = app.siteInfo.uniacid;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(t) {
                a.setData({
                    url: t.data
                });
            }
        });
    },
    onReady: function() {
        wx.setNavigationBarTitle({
            title: "提问"
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    likeClick: function(t) {
        var e = this, a = t.currentTarget.dataset.id;
        console.log(t.currentTarget.dataset.id);
        var o = wx.getStorageSync("openid");
        console.log(o), app.util.request({
            url: "entry/wxapp/CheckCollect",
            headers: {
                "Content-Type": "application/json"
            },
            cachetime: "0",
            data: {
                openid: o,
                goods_id: a,
                cerated_type: 0
            },
            success: function(t) {
                2 == t.data ? (console.log("取消成功"), app.util.request({
                    url: "entry/wxapp/SaveCollect",
                    cachetime: "0",
                    data: {
                        openid: o,
                        goods_id: a,
                        cerated_type: 0
                    },
                    dataType: "json",
                    success: function(t) {
                        wx.showToast({
                            title: "取消成功",
                            icon: "success",
                            duration: 1500
                        }), e.setData({
                            toastHidden4: !0,
                            toastHidden3: !1
                        });
                    }
                })) : 1 == t.data && (console.log("关注成功"), app.util.request({
                    url: "entry/wxapp/SaveCollect",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    cachetime: "0",
                    data: {
                        openid: o,
                        goods_id: a,
                        cerated_type: 0
                    },
                    dataType: "json",
                    success: function(t) {
                        console.log(t), wx.showToast({
                            title: "关注成功",
                            icon: "success",
                            duration: 1500
                        }), e.setData({
                            collect_url: !e.data.collect_url,
                            c_text: !e.data.c_text,
                            toastHidden3: !0,
                            toastHidden4: !1
                        });
                    }
                }));
            }
        });
    },
    uploadpic: function(t) {
        var i = this, n = i.data.upload_picture_list, e = i.data.zid;
        function s(a, o, i) {
            var t = app.siteInfo.uniacid, e = a.data.zid;
            console.log(t);
            var n = wx.getStorageSync("openid");
            console.log("开始上传" + i + "图片到服务器："), console.log(o[i]), wx.uploadFile({
                url: a.data.url + "app/index.php?i=" + t + "&c=entry&a=wxapp&do=msg_send_imgs&m=hyb_yl",
                filePath: o[i].path,
                name: "file",
                formData: {
                    path: "wxchat",
                    openid: n,
                    uniacid: t,
                    i_type: 1,
                    zid: e
                },
                success: function(t) {
                    console.log(t);
                    var e = t.data;
                    a.setData({
                        thumb: e,
                        upload_picture_list: o
                    }), console.log("图片上传" + i + "到服务器完成：");
                }
            }).onProgressUpdate(function(t) {
                o[i].upload_percent = t.progress, console.log("第" + i + "个图片上传进度：" + o[i].upload_percent), 
                console.log(o), a.setData({
                    upload_picture_list: o
                });
            });
        }
        console.log(e), wx.chooseImage({
            count: 8,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(t) {
                var e = t.tempFiles;
                for (var a in e) e[a].upload_percent = 0, e[a].path_server = "", n.push(e[a]);
                for (var o in i.setData({
                    upload_picture_list: n
                }), 6 == n.length && i.setData({
                    hide: !0
                }), n) 0 == n[o].upload_percent && s(i, n, o);
            }
        });
    },
    deleteimg: function(t) {
        var e = t.currentTarget.dataset.index, a = this.data.upload_picture_list;
        a.splice(e, 1), this.setData({
            upload_picture_list: a
        });
    }
});