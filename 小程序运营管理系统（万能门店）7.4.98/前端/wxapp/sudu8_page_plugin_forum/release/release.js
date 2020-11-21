var app = getApp();

Page({
    data: {
        release_money: 0,
        stick_money: 0,
        stick_days: 7,
        release_img: [],
        cons: "",
        fid: 0,
        rid: 0,
        funcAll: [],
        funcTitleArr: [],
        index: 0,
        userMoney: 0,
        success_rid: 0,
        address: "",
        tel: "",
        stick: 2,
        update: 0,
        cons_len: 0,
        settop: 1,
        release_audit: 0
    },
    onPullDownRefresh: function() {
        this.huoqusq(), this.getReleaseInfo(), wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var t = this;
        wx.setNavigationBarTitle({
            title: "发布信息"
        });
        var e = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: e,
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(a) {
                t.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: t.data.baseinfo.base_tcolor,
                    backgroundColor: t.data.baseinfo.base_color
                });
            },
            fail: function(a) {}
        }), t.huoqusq();
        var s = a.fid;
        0 < s && t.setData({
            fid: s
        });
        var n = a.rid;
        0 < n && (t.setData({
            rid: n
        }), t.getReleaseInfo());
    },
    getInputTel: function(a) {
        var t = a.detail.value;
        this.setData({
            telphone: t
        });
    },
    getReleaseInfo: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/GetForumCon",
            data: {
                rid: t.data.rid,
                types: 1
            },
            success: function(a) {
                t.setData({
                    cons: a.data.data.content,
                    release_img: a.data.data.img,
                    release_money: 0,
                    fid: a.data.data.fid,
                    telphone: a.data.data.telphone,
                    address: a.data.data.address,
                    stick: a.data.data.stick,
                    update: 1
                });
            }
        });
    },
    getlocation: function() {
        var t = this;
        wx.chooseLocation({
            success: function(a) {
                t.setData({
                    address: a.name
                });
            },
            fail: function() {
                wx.getSetting({
                    success: function(a) {
                        a.authSetting["scope.userLocation"] || wx.showModal({
                            title: "请授权获取当前位置",
                            content: "获取位置需要授权此功能",
                            showCancel: !1,
                            success: function(a) {
                                a.confirm && wx.openSetting({
                                    success: function(a) {
                                        !0 === a.authSetting["scope.userLocation"] ? wx.showToast({
                                            title: "授权成功",
                                            icon: "success",
                                            duration: 1e3
                                        }) : wx.showToast({
                                            title: "授权失败",
                                            icon: "success",
                                            duration: 1e3,
                                            success: function() {
                                                t.getlocation();
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    },
                    fail: function(a) {
                        wx.showToast({
                            title: "调用授权窗口失败",
                            icon: "success",
                            duration: 1e3
                        });
                    }
                });
            }
        });
    },
    huoqusq: function() {
        var u = this, r = wx.getStorageSync("openid");
        u.setData({
            openid: r
        }), wx.getUserInfo({
            success: function(a) {
                var t = a.userInfo, e = t.nickName, s = t.avatarUrl, n = t.gender, i = t.province, o = t.city, c = t.country, d = app.util.url("entry/wxapp/Useupdate", {
                    m: "sudu8_page"
                });
                wx.request({
                    url: d,
                    data: {
                        openid: r,
                        nickname: e,
                        avatarUrl: s,
                        gender: n,
                        province: i,
                        city: o,
                        country: c
                    },
                    header: {
                        "content-type": "application/json"
                    },
                    success: function(a) {
                        wx.setStorageSync("golobeuid", a.data.data.id), wx.setStorageSync("golobeuser", a.data.data), 
                        u.setData({
                            isview: 0,
                            userMoney: a.data.data.money
                        });
                    }
                }), u.getforumset(), u.getfuncall();
            },
            fail: function() {
                u.setData({
                    isview: 1
                });
            }
        });
    },
    getfuncall: function() {
        var n = this;
        app.util.request({
            url: "entry/wxapp/GetFuncAll",
            success: function(a) {
                if (0 < a.data.data.funcAll.length) {
                    var t = a.data.data.funcAll;
                    n.setData({
                        funcAll: a.data.data.funcAll,
                        funcTitleArr: a.data.data.funcTitleArr
                    });
                    var e = n.data.fid;
                    if (0 < e) {
                        for (var s = 0; s < t.length; s++) e == t[s].id && n.setData({
                            index: s
                        });
                        n.setData({
                            fid: e
                        });
                    } else n.setData({
                        fid: a.data.data.funcAll[0].id
                    });
                }
            },
            fail: function(a) {}
        });
    },
    bindPickerChange: function(a) {
        var t = a.detail.value, e = this.data.funcAll[t].id;
        this.setData({
            fid: e,
            index: t
        });
    },
    releasePay: function(a) {
        var t = this;
        if ("" == t.data.cons) return wx.showModal({
            title: "提示",
            showCancel: !1,
            content: "发布信息不能为空"
        }), !1;
        var e = a.detail.formId, s = t.data.release_money, n = t.data.update;
        0 < s && 0 == n ? app.util.request({
            url: "entry/wxapp/ForumOrder",
            data: {
                release_money: s,
                openid: t.data.openid,
                formId: e
            },
            success: function(a) {
                if (1 == a.data.data.type) wx.showModal({
                    title: "请注意",
                    content: "您将使用余额支付" + s + "元",
                    success: function(a) {
                        a.confirm && t.releaseSub();
                    }
                }); else {
                    if ("success" == a.data.data.message) {
                        a.data.data.order_id;
                        t.setData({
                            prepay_id: a.data.data.package
                        }), wx.requestPayment({
                            timeStamp: a.data.data.timeStamp,
                            nonceStr: a.data.data.nonceStr,
                            package: a.data.data.package,
                            signType: "MD5",
                            paySign: a.data.data.paySign,
                            success: function(a) {
                                0 < t.data.userMoney ? app.util.request({
                                    url: "entry/wxapp/UpdateUserMoney",
                                    data: {
                                        openid: t.data.openid
                                    },
                                    success: function(a) {
                                        1 == a.data.data && wx.showToast({
                                            title: "支付成功",
                                            icon: "success",
                                            duration: 3e3,
                                            success: function(a) {
                                                t.releaseSub();
                                            }
                                        });
                                    }
                                }) : wx.showToast({
                                    title: "支付成功",
                                    icon: "success",
                                    duration: 3e3,
                                    success: function(a) {
                                        t.releaseSub();
                                    }
                                });
                            },
                            fail: function(a) {},
                            complete: function(a) {}
                        });
                    }
                    "error" == a.data.data.message && wx.showModal({
                        title: "提醒",
                        content: a.data.data.message,
                        showCancel: !1
                    });
                }
            },
            fail: function(a) {}
        }) : t.releaseSub();
    },
    releaseSub: function() {
        var e = this, a = e.data.cons, t = e.data.release_money, s = e.data.release_img;
        0 == s.length && (s = "");
        var n = e.data.release_audit, i = e.data.settop;
        app.util.request({
            url: "entry/wxapp/ReleaseSub",
            data: {
                openid: e.data.openid,
                fid: e.data.fid,
                rid: e.data.rid,
                cons: a,
                release_money: t,
                release_img: JSON.stringify(s),
                address: e.data.address,
                telphone: e.data.telphone,
                release_audit: n
            },
            success: function(a) {
                var t = a.data.data;
                0 < t ? 0 == n ? wx.showModal({
                    title: "提示",
                    showCancel: !1,
                    content: "发布成功",
                    success: function() {
                        if (1 == e.data.stick) {
                            e.data.fid;
                            wx.navigateBack({
                                delta: 1
                            });
                        } else e.setData({
                            success_rid: t
                        });
                        0 == i && e.goReleaseLists();
                    }
                }) : wx.showModal({
                    title: "提示",
                    showCancel: !1,
                    content: "发布成功，请等待审核！",
                    success: function(a) {
                        if (1 == e.data.stick) {
                            e.data.fid;
                            wx.navigateBack({
                                delta: 1
                            });
                        } else e.setData({
                            success_rid: t
                        });
                        0 == i && e.goReleaseLists();
                    }
                }) : wx.showToast({
                    title: "发布失败"
                });
            },
            fail: function(a) {}
        });
    },
    goReleaseLists: function() {
        this.data.fid;
        wx.navigateBack({
            delta: 1
        });
    },
    go_set_top: function() {
        var a = this.data.fid, t = this.data.success_rid;
        wx.redirectTo({
            url: "/sudu8_page_plugin_forum/set_top/set_top?fid=" + a + "&rid=" + t + "&returnpage=2"
        });
    },
    delimg: function(a) {
        var t = a.currentTarget.dataset.index, e = this.data.release_img;
        e.splice(t, 1), this.setData({
            release_img: e
        });
    },
    getforumset: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/ForumSet",
            success: function(a) {
                t.setData({
                    release_money: a.data.data.release_money,
                    stick_money: a.data.data.stick_money,
                    settop: a.data.data.settop,
                    release_audit: a.data.data.release_audit
                });
            },
            fail: function(a) {}
        });
    },
    getcons: function(a) {
        var t = a.detail.value, e = t.length;
        this.setData({
            cons: t,
            cons_len: e
        });
    },
    chooseImg: function() {
        var i = this, o = i.data.zhixin, c = i.data.release_img;
        c || (c = []);
        var d = app.util.url("entry/wxapp/wxupimg", {
            m: "sudu8_page"
        });
        wx.chooseImage({
            count: 9,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                o = !0, i.setData({
                    zhixin: o
                }), wx.showLoading({
                    title: "图片上传中"
                });
                var t = a.tempFilePaths, s = 0, n = t.length;
                !function e() {
                    wx.uploadFile({
                        url: d,
                        filePath: t[s],
                        name: "file",
                        success: function(a) {
                            var t = a.data.replace(/\\/g, "").replace(/\"/g, "");
                            c.push(t), i.setData({
                                release_img: c
                            }), ++s < n ? e() : (o = !1, i.setData({
                                zhixin: o
                            }), wx.hideLoading());
                        }
                    });
                }();
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    select: function() {
        var a = this.data.select;
        a = 2 == a ? 1 : 2, this.setData({
            select: a
        });
    },
    bindManual: function(a) {
        var t = a.detail.value;
        this.setData({
            stick_days: t
        });
    }
});