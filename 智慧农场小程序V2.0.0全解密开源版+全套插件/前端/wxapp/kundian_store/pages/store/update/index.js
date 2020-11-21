var e = new getApp(), t = e.util.getNewUrl("entry/wxapp/store", "kundian_farm_plugin_store");

Page({
    data: {
        store: [],
        uType: "name",
        addressInfo: {},
        imgs: [],
        tmpPhoto: [],
        remark: [],
        storeRemark: [],
        inRemark: ""
    },
    onLoad: function(a) {
        var o = this, n = a.uType, s = a.phone, r = wx.getStorageSync("kundian_farm_setData");
        e.util.setNavColor(e.siteInfo.uniacid);
        var i = "商家信息";
        "name" == n && (i = "设置商家名称"), "phone" == n && (i = "设置电话"), "address" == n && (i = "设置地址"), 
        "imgs" == n && (i = "设置展示图片"), "remark" == n && (i = "设置标签"), wx.setNavigationBarTitle({
            title: i
        }), wx.request({
            url: t,
            data: {
                op: "storeLogin",
                control: "store",
                type: "nowLogin",
                phone: s,
                uType: n
            },
            success: function(e) {
                var t = e.data.store;
                o.setData({
                    store: t,
                    uType: n,
                    setData: r,
                    phone: t.phone,
                    tmpPhoto: t.imgs ? t.imgs : [],
                    remark: e.data.remark || [],
                    storeRemark: t.remark
                });
            }
        });
    },
    getPhoneNumber: function(e) {
        if ("getPhoneNumber:fail user deny" != e.detail.errMsg) {
            var a = this, o = wx.getStorageSync("kundian_farm_uid"), n = a.data, s = n.code;
            n.userInfo;
            s ? wx.request({
                url: t,
                data: {
                    encryptedData: e.detail.encryptedData,
                    iv: e.detail.iv,
                    code: s,
                    op: "getPhoneNum",
                    uid: o,
                    control: "store"
                },
                header: {
                    "content-type": "application/json"
                },
                success: function(e) {
                    var t = e.data, o = t.msg, n = t.phone;
                    wx.showToast({
                        title: o,
                        icon: "none"
                    }), a.setData({
                        phone: n
                    });
                },
                fail: function(e) {
                    console.log(e);
                }
            }) : wx.login({
                success: function(n) {
                    wx.login({
                        success: function(n) {
                            wx.request({
                                url: t,
                                data: {
                                    encryptedData: e.detail.encryptedData,
                                    iv: e.detail.iv,
                                    code: n.code,
                                    op: "getPhoneNum",
                                    uid: o,
                                    control: "store"
                                },
                                header: {
                                    "content-type": "application/json"
                                },
                                success: function(e) {
                                    var t = e.data, o = t.msg, n = t.phone;
                                    wx.showToast({
                                        title: o,
                                        icon: "none"
                                    }), a.setData({
                                        phone: n
                                    });
                                },
                                fail: function(e) {
                                    console.log(e);
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
    },
    chooseAddress: function(e) {
        var t = this;
        wx.chooseLocation({
            success: function(e) {
                t.setData({
                    addressInfo: e
                });
            }
        });
    },
    chooseImage: function(t) {
        var a = this, o = a.data.tmpPhoto;
        wx.chooseImage({
            success: function(t) {
                var n = e.siteInfo.siteroot.replace("app/index.php", "web/index.php") + "?i=" + e.siteInfo.uniacid + "&c=utility&a=file&do=upload&thumb=0", s = t.tempFilePaths, r = 0;
                wx.showToast({
                    title: "正在上传...",
                    icon: "loading",
                    mask: !0,
                    duration: 1e4
                });
                for (var i = 0; i < s.length; i++) wx.uploadFile({
                    url: n,
                    filePath: s[i],
                    name: "file",
                    formData: {
                        op: "upload_file"
                    },
                    success: function(e) {
                        r++;
                        var t = JSON.parse(e.data);
                        o.push(t.url), r == s.length && (wx.hideToast(), a.setData({
                            tmpPhoto: o
                        }));
                    }
                });
            }
        });
    },
    delImg: function(e) {
        this.data.tmpPhoto.splice(e.currentTarget.dataset.index, 1), this.setData({
            tmpPhoto: this.data.tmpPhoto
        });
    },
    viewImage: function(e) {
        wx.previewImage({
            urls: this.data.tmpPhoto,
            current: e.currentTarget.dataset.url
        });
    },
    checkRemark: function(e) {
        var t = e.currentTarget.dataset, a = t.type, o = t.index, n = this.data, s = n.remark, r = n.storeRemark;
        "cancel" == a ? (r.map(function(e, t) {
            e == s[o].name && r.splice(t, 1);
        }), s[o].select = !1) : (r.push(s[o].name), s[o].select = !0), this.setData({
            storeRemark: r,
            remark: s
        });
    },
    importRemark: function(e) {
        this.setData({
            inRemark: e.detail.value
        });
    },
    addRemark: function() {
        var e = this.data, t = e.storeRemark, a = e.inRemark;
        a.length > 5 ? wx.showToast({
            title: "标签字数不能超过五个字符",
            icon: "none"
        }) : (t.push(a), this.setData({
            storeRemark: t
        }));
    },
    remarkDek: function(e) {
        var t = e.currentTarget.dataset.index, a = this.data, o = a.remark, n = a.storeRemark;
        o.map(function(e, a) {
            e.name == n[t] && (o[a].select = !1);
        }), n.splice(t, 1), this.setData({
            storeRemark: n,
            remark: o
        });
    },
    saveData: function(e) {
        var a = this.data, o = a.uType, n = a.addressInfo, s = a.phone, r = a.store, i = a.tmpPhoto, c = a.storeRemark, u = e.detail.value, d = {
            op: "updateStore",
            control: "store",
            id: r.id,
            uType: o
        };
        "name" == o && (d.name = u.name), "phone" == o && (d.phone = s), "address" == o && (d.address = n.address, 
        d.longitude = n.longitude, d.latitude = n.latitude), "intro" == o && (d.intro = u.intro), 
        "remark" == o && (d.remark = c.join(",")), "imgs" == o && (d.src = i.join(",")), 
        wx.request({
            url: t,
            data: d,
            success: function(e) {
                wx.showToast({
                    title: e.data.msg,
                    icon: "none",
                    success: function() {
                        if (0 == e.data.code) var t = setTimeout(function() {
                            clearTimeout(t), wx.navigateBack({
                                delta: 1
                            });
                        }, 1500);
                    }
                });
            }
        });
    }
});