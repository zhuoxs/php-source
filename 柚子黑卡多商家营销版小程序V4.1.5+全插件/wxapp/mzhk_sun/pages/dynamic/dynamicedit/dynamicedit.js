var app = getApp();

Page({
    data: {
        navTile: "商品评价",
        uploadPic: [],
        Pic: "",
        disabled: !1,
        placeHolder: "输入内容...",
        isuploadsuccess: !0,
        isclick: !1,
        content: "",
        form_id: "",
        is_modal_Hidden: !0,
        oid: 0,
        gid: 0,
        star: 0
    },
    onLoad: function(t) {
        var a = this;
        if (t) {
            var o = t.oid, e = t.gid;
            a.setData({
                oid: o,
                gid: e
            });
        }
        wx.setNavigationBarTitle({
            title: a.data.navTile
        });
        var i = app.getSiteUrl();
        i ? (a.setData({
            url: i
        }), app.editTabBar(i)) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), i = t.data, app.editTabBar(i), a.setData({
                    url: i
                });
            }
        }), app.wxauthSetting(), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor ? wx.getStorageSync("System").fontcolor : "",
            backgroundColor: wx.getStorageSync("System").color ? wx.getStorageSync("System").color : "",
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        app.func.islogin(app, this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    uploadPic: function(t) {
        var a = this, o = app.util.url("entry/wxapp/Touploadtwo") + "&m=mzhk_sun";
        wx.chooseImage({
            count: 9,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(t) {
                a.setData({
                    uploadPic: t.tempFilePaths,
                    isuploadsuccess: !1
                }), a.uploadimg({
                    url: o,
                    path: t.tempFilePaths
                }, {});
            }
        });
    },
    uploadimg: function(e, i) {
        console.log(e), console.log("开始上传图片");
        var n = this, s = e.i ? e.i : 0, a = (e.utype && e.utype, void 0);
        a = 0 == s ? "" : n.data.Pic, wx.uploadFile({
            url: e.url,
            filePath: e.path[s],
            name: "file",
            formData: i,
            success: function(t) {
                console.log("success:" + s), a = 0 < a.length ? a + "," + t.data : t.data, console.log(a), 
                n.data.isclick && wx.showToast({
                    icon: "none",
                    title: "提交中，请稍后...",
                    duration: 2e4
                }), n.setData({
                    Pic: a
                });
            },
            fail: function(t) {
                console.log("fail:" + s);
            },
            complete: function() {
                if (++s == e.path.length) {
                    console.log("图片上传完毕");
                    var t = n.data.isclick;
                    if (n.setData({
                        isuploadsuccess: !0
                    }), t) {
                        var a = n.data.content, o = n.data.form_id;
                        n.autoformSubmit(a, o);
                    }
                } else {
                    console.log("上传下一张"), (t = n.data.isclick) && wx.showToast({
                        icon: "none",
                        title: "提交中，请稍后...",
                        duration: 2e4
                    }), e.i = s, n.uploadimg(e, i);
                }
            }
        });
    },
    cominput: function(t) {
        var a = t.detail.value, o = /[^\u0020-\u007E\u00A0-\u00BE\u2E80-\uA4CF\uF900-\uFAFF\uFE30-\uFE4F\uFF00-\uFFEF\u0080-\u009F\u2000-\u201f\u2026\u2022\u20ac\r\n]/g;
        a.match(o) && (a = a.replace(o, "")), this.setData({
            content: a
        });
    },
    formSubmit: function(t) {
        var a = this, o = t.detail.value.content, e = wx.getStorageSync("openid"), i = a.data.Pic, n = a.data.isuploadsuccess, s = a.data.oid, c = a.data.gid, u = a.data.star;
        return n ? (console.log(i), "" == o && "" == i ? (wx.showToast({
            icon: "none",
            title: "请发张照片或者写些东西吧！"
        }), !1) : (wx.showLoading({
            title: "提交中，请稍后..."
        }), a.setData({
            disabled: !0
        }), void app.util.request({
            url: "entry/wxapp/SaveCircle",
            cachetime: "0",
            data: {
                user_id: wx.getStorageSync("users").id,
                content: o,
                pic: i,
                openid: e,
                form_id: t.detail.formId,
                oid: s,
                gid: c,
                star: u
            },
            success: function(t) {
                wx.showToast({
                    icon: "none",
                    title: "提交成功！",
                    duration: 1e3
                }), wx.hideLoading(), wx.redirectTo({
                    url: "/mzhk_sun/pages/dynamic/dynamic"
                });
            },
            fail: function(t) {
                wx.showModal({
                    title: "提示信息",
                    content: t.data.message,
                    showCancel: !1
                }), a.setData({
                    disabled: !1,
                    isclick: !1
                });
            }
        }))) : (wx.showToast({
            icon: "none",
            title: "提交中，请稍后...",
            duration: 2e4
        }), a.setData({
            isclick: !0,
            content: o,
            form_id: t.detail.formId
        }), !1);
    },
    autoformSubmit: function(t, a) {
        var o = this, e = wx.getStorageSync("openid"), i = o.data.Pic, n = (o.data.isuploadsuccess, 
        o.data.oid), s = o.data.gid, c = o.data.star;
        if ("" == t && "" == i) return wx.showToast({
            icon: "none",
            title: "请发张照片或者写些东西吧！"
        }), !1;
        o.setData({
            disabled: !0
        }), app.util.request({
            url: "entry/wxapp/SaveCircle",
            cachetime: "0",
            data: {
                user_id: wx.getStorageSync("users").id,
                content: t,
                pic: i,
                openid: e,
                form_id: a,
                oid: n,
                gid: s,
                star: c
            },
            success: function(t) {
                wx.showToast({
                    icon: "none",
                    title: "提交成功！",
                    duration: 1e3
                }), wx.hideLoading(), wx.redirectTo({
                    url: "/mzhk_sun/pages/dynamic/dynamic"
                });
            },
            fail: function(t) {
                wx.showModal({
                    title: "提示信息",
                    content: t.data.message,
                    showCancel: !1
                }), o.setData({
                    disabled: !1
                });
            }
        });
    },
    updateUserInfo: function(t) {
        console.log("授权操作更新");
        app.wxauthSetting();
    },
    myChooseStar: function(t) {
        console.log(t);
        var a = parseInt(t.target.dataset.star) || 0;
        this.setData({
            star: a
        });
    }
});