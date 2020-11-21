var t = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(t) {
    return typeof t;
} : function(t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t;
}, e = new getApp(), o = e.util.getNewUrl("entry/wxapp/store", "kundian_farm_plugin_store");

Page({
    data: {
        logo: "",
        tmpPhoto: [],
        addressInfo: [],
        setData: [],
        code: "",
        phone: "",
        isApply: 2,
        store: [],
        name: "",
        intro: ""
    },
    onLoad: function(t) {
        var o = wx.getStorageSync("kundian_farm_setData");
        this.setData({
            setData: o
        }), this.checkApply();
        var a = this;
        wx.login({
            success: function(t) {
                a.setData({
                    code: t.code
                });
            }
        }), e.util.setNavColor(e.siteInfo.uniacid);
    },
    getName: function(t) {
        this.setData({
            name: t.detail.value
        });
    },
    getIntro: function(t) {
        this.setData({
            intro: t.detail.value
        });
    },
    checkApply: function(t) {
        var e = this, a = wx.getStorageSync("kundian_farm_uid");
        "" != a && void 0 != a ? wx.request({
            url: o,
            data: {
                op: "checkApply",
                control: "store",
                uid: a
            },
            success: function(t) {
                if (t.data.store) {
                    var o = t.data.store, a = {
                        address: o.address,
                        longitude: o.longitude,
                        latitude: o.latitude
                    };
                    e.setData({
                        addressInfo: a,
                        phone: o.phone,
                        logo: o.logo,
                        tmpPhoto: o.imgs,
                        name: o.name,
                        intro: o.intro
                    });
                }
                e.setData({
                    isApply: t.data.code,
                    store: t.data.store || []
                }), 1 == t.data.code && wx.showModal({
                    title: "提示",
                    content: "您已入驻了，请直接登录",
                    showCancel: !1,
                    success: function() {
                        wx.redirectTo({
                            url: "../login/index"
                        });
                    }
                });
            }
        }) : wx.navigateTo({
            url: "/kundian_farm/pages/login/index"
        });
    },
    onShow: function() {
        this.checkApply();
    },
    chooseImage: function(t) {
        var o = this, a = t.currentTarget.dataset.type;
        if (1 != a) {
            if (2 == a) {
                var n = e.siteInfo.siteroot.replace("app/index.php", "web/index.php") + "?i=" + e.siteInfo.uniacid + "&c=utility&a=file&do=upload&thumb=0";
                wx.chooseImage({
                    success: function(t) {
                        var e = t.tempFilePaths, a = [];
                        if (e.length > 0) {
                            wx.showToast({
                                title: "正在上传...",
                                icon: "loading",
                                mask: !0,
                                duration: 1e4
                            });
                            for (var i = 0, s = 0; s < e.length; s++) wx.uploadFile({
                                url: n,
                                filePath: e[s],
                                name: "file",
                                formData: {
                                    op: "upload_file"
                                },
                                success: function(t) {
                                    i++;
                                    var n = JSON.parse(t.data);
                                    a.push(n.url), i == e.length && (wx.hideToast(), o.setData({
                                        tmpPhoto: a
                                    }));
                                }
                            });
                        }
                    }
                });
            }
        } else wx.chooseImage({
            count: 1,
            success: function(t) {
                var a = e.siteInfo.siteroot.replace("app/index.php", "web/index.php") + "?i=" + e.siteInfo.uniacid + "&c=utility&a=file&do=upload&thumb=0";
                wx.uploadFile({
                    url: a,
                    filePath: t.tempFilePaths[0],
                    name: "file",
                    formData: {
                        op: "upload_file"
                    },
                    success: function(t) {
                        var e = JSON.parse(t.data);
                        o.setData({
                            logo: e.url
                        });
                    }
                });
            }
        });
    },
    chooseAddress: function(t) {
        var e = this;
        wx.chooseLocation({
            success: function(t) {
                e.setData({
                    addressInfo: t
                });
            },
            fail: function(t) {
                console.log(t), wx.showModal({
                    title: "提示",
                    content: "无法打开地址",
                    showCancel: !1
                });
            }
        });
    },
    delImg: function(t) {
        this.data.tmpPhoto.splice(t.currentTarget.dataset.index, 1), this.setData({
            tmpPhoto: this.data.tmpPhoto
        });
    },
    viewImage: function(t) {
        wx.previewImage({
            urls: this.data.tmpPhoto,
            current: t.currentTarget.dataset.url
        });
    },
    submitData: function(e) {
        var a = this, n = e.detail.value, i = n.name, s = n.phone, l = n.intro, c = e.detail.formId, d = a.data, r = d.tmpPhoto, u = d.addressInfo, p = d.logo, f = d.store;
        if ("" != p && void 0 != p) if ("" != i && void 0 != i) if ("" != s && void 0 != s) if ("" != u && void 0 != (void 0 === u ? "undefined" : t(u))) if ("" != l && void 0 != l) {
            var h = wx.getStorageSync("kundian_farm_uid"), g = "";
            r.length > 0 && (g = r.join(",")), wx.request({
                url: o,
                data: {
                    op: "storeApply",
                    control: "store",
                    name: i,
                    phone: s,
                    intro: l,
                    src: g,
                    logo: p,
                    formId: c,
                    uid: h,
                    id: f.id,
                    address: u.address,
                    longitude: u.longitude,
                    latitude: u.latitude
                },
                success: function(t) {
                    wx.showToast({
                        title: t.data.msg,
                        icon: "none"
                    }), 0 == t.data.code && a.setData({
                        isApply: 0
                    });
                }
            });
        } else wx.showToast({
            title: "请填写商户简介",
            icon: "none"
        }); else wx.showToast({
            title: "请选择商户地址",
            icon: "none"
        }); else wx.showToast({
            title: "请授权手机号码",
            icon: "none"
        }); else wx.showToast({
            title: "请填写商户名称",
            icon: "none"
        }); else wx.showToast({
            title: "请先上传logo",
            icon: "none"
        });
    },
    getPhoneNumber: function(t) {
        if ("getPhoneNumber:fail user deny" != t.detail.errMsg) {
            var e = this, a = wx.getStorageSync("kundian_farm_uid"), n = e.data, i = n.code;
            n.userInfo;
            i ? wx.request({
                url: o,
                data: {
                    encryptedData: t.detail.encryptedData,
                    iv: t.detail.iv,
                    code: i,
                    op: "getPhoneNum",
                    uid: a,
                    control: "store"
                },
                header: {
                    "content-type": "application/json"
                },
                success: function(t) {
                    var o = t.data, a = o.msg, n = o.phone;
                    wx.showToast({
                        title: a,
                        icon: "none"
                    }), e.setData({
                        phone: n
                    });
                },
                fail: function(t) {
                    console.log(t);
                }
            }) : wx.login({
                success: function(n) {
                    wx.login({
                        success: function(n) {
                            wx.request({
                                url: o,
                                data: {
                                    encryptedData: t.detail.encryptedData,
                                    iv: t.detail.iv,
                                    code: n.code,
                                    op: "getPhoneNum",
                                    uid: a,
                                    control: "store"
                                },
                                header: {
                                    "content-type": "application/json"
                                },
                                success: function(t) {
                                    var o = t.data, a = o.msg, n = o.phone;
                                    wx.showToast({
                                        title: a,
                                        icon: "none"
                                    }), e.setData({
                                        phone: n
                                    });
                                },
                                fail: function(t) {
                                    console.log(t);
                                }
                            });
                        }
                    });
                }
            });
        } else wx.showModal({
            title: "提示",
            content: "您拒绝了授权！",
            showCancel: !1
        });
    }
});