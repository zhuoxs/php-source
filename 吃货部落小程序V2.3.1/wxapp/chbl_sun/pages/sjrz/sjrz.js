var imgArray1 = [], imgArray2 = [], app = getApp();

Page({
    data: {
        pics: [],
        picss: [],
        uppic: [],
        uppics: []
    },
    onLoad: function(e) {
        this.setData({
            url: wx.getStorageSync("url2")
        });
    },
    bindTimeChange: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value), "start" == e.currentTarget.dataset.statu ? this.setData({
            stime: e.detail.value
        }) : this.setData({
            etime: e.detail.value
        });
    },
    bindSave: function(a) {
        var e = a.detail.value;
        console.log(e), console.log(a);
        var t = this;
        if (a.detail.target.dataset.price) {
            var i;
            i = a.detail.target.dataset.price.split("￥"), console.log(i[1]);
            var o = i[1];
        }
        var s = t.data.address;
        console.log(s);
        var n = t.data.latitude, c = t.data.longitude;
        if (e.store_name) if (e.tel) if (s) {
            app.util.url("entry/wxapp/Toupload");
            var l = t.data.storein[t.data.index];
            if (console.log(l), l) if (console.log(e.start_time + e.end_time), e.start_time && e.end_time) {
                var r = e.start_time;
                if ((d = e.end_time) <= r) wx.showToast({
                    title: "请选择正确的营业时间",
                    icon: "none"
                }); else {
                    var u = e.store_name, d = (s = e.address, e.end_time), p = (r = e.start_time, e.introduce), g = e.time_type, f = e.tel, m = (t.data.pics, 
                    t.data.picss, t.data.uppic), h = t.data.uppics;
                    if (m.length <= 0) return wx.showToast({
                        title: "请上传商家轮播图片！！！",
                        icon: "none"
                    }), !1;
                    wx.showLoading({
                        title: "内容提交中...",
                        mask: !0
                    }), console.log(app.siteInfo.uniacid);
                    var w = wx.getStorageSync("openid");
                    t.setData({
                        disabled: !0,
                        sendtitle: "稍后"
                    }), console.log("-----------fromID-----------" + a.detail.formId), app.util.request({
                        url: "entry/wxapp/SaveFormid",
                        cachetime: "0",
                        data: {
                            user_id: wx.getStorageSync("users").id,
                            form_id: a.detail.formId,
                            openid: wx.getStorageSync("openid")
                        },
                        success: function(e) {
                            app.util.request({
                                url: "entry/wxapp/orderarr",
                                cachetime: "30",
                                data: {
                                    openid: w,
                                    price: o
                                },
                                success: function(e) {
                                    wx.requestPayment({
                                        timeStamp: e.data.timeStamp,
                                        nonceStr: e.data.nonceStr,
                                        package: e.data.package,
                                        signType: "MD5",
                                        paySign: e.data.paySign,
                                        success: function(e) {
                                            wx.showToast({
                                                title: "支付成功",
                                                icon: "success",
                                                duration: 2e3
                                            }), console.log("支付成功"), app.util.request({
                                                url: "entry/wxapp/AddStoreInfo",
                                                cachetime: "0",
                                                data: {
                                                    user_id: w,
                                                    store_name: u,
                                                    address: s,
                                                    start_time: r,
                                                    end_time: d,
                                                    introduce: p,
                                                    time_type: g,
                                                    tel: f,
                                                    uimg: m,
                                                    uimgs: h,
                                                    latitude: n,
                                                    longitude: c
                                                },
                                                success: function(e) {
                                                    var t = e.data;
                                                    console.log(e), console.log("------------------表单ID-----------------"), console.log(a.detail.formId), 
                                                    console.log("模板消息发送++++++++++++++++++++++"), app.util.request({
                                                        url: "entry/wxapp/rzmessage",
                                                        cachetime: "0",
                                                        data: {
                                                            form_id: a.detail.formId,
                                                            openid: wx.getStorageSync("openid"),
                                                            store_id: t
                                                        },
                                                        success: function(e) {
                                                            console.log("模板消息发送"), console.log(e);
                                                        }
                                                    }), wx.hideLoading(), wx.showToast({
                                                        title: "申请成功！！！",
                                                        icon: "success",
                                                        success: function() {
                                                            wx.redirectTo({
                                                                url: "../mine/index"
                                                            });
                                                        }
                                                    });
                                                },
                                                fail: function() {
                                                    t.setData({
                                                        disabled: !1,
                                                        sendtitle: "发送"
                                                    }), wx.showToast({
                                                        title: "可能由于网络原因，申请失败，请重新申请！！！",
                                                        icon: "none",
                                                        success: function() {
                                                            wx.hideLoading();
                                                        }
                                                    });
                                                }
                                            });
                                        }
                                    });
                                }
                            });
                        }
                    });
                }
            } else wx.showToast({
                title: "请选择营业时间！",
                icon: "none"
            }); else wx.showToast({
                title: "请选择入驻时间！",
                icon: "none"
            });
        } else wx.showToast({
            title: "请填写联系地址！",
            icon: "none"
        }); else wx.showToast({
            title: "请填写联系电话！",
            icon: "none"
        }); else wx.showToast({
            title: "请填写商家名称！",
            icon: "none"
        });
    },
    uploadimg: function(t, e) {
        var a = this, i = t.i ? t.i : 0, o = t.success ? t.success : 0, s = t.fail ? t.fail : 0;
        wx.uploadFile({
            url: t.url,
            filePath: t.path[i],
            name: "file",
            formData: e,
            success: function(e) {
                t.uppic = t.uppic.concat(e.data);
            },
            fail: function(e) {
                2 == e.data && s++, console.log("fail:" + i + "fail:" + s);
            },
            complete: function() {
                ++i == t.path.length ? (console.log("执行完毕"), a.setData({
                    uppic: t.uppic
                })) : (t.i = i, t.success = o, t.fail = s, a.uploadimg(t, e));
            }
        });
    },
    uploadimg1: function(t, e) {
        console.log("-------------进入商家上传---------");
        var a = this, i = t.i ? t.i : 0, o = t.success ? t.success : 0, s = t.fail ? t.fail : 0;
        wx.uploadFile({
            url: t.url,
            filePath: t.path[i],
            name: "file",
            formData: e,
            success: function(e) {
                t.uppics = t.uppics.concat(e.data);
            },
            fail: function(e) {
                2 == e.data && s++, console.log("fail:" + i + "fail:" + s);
            },
            complete: function() {
                ++i == t.path.length ? (console.log("执行完毕"), console.log(t.uppics), a.setData({
                    uppics: t.uppics
                })) : (t.i = i, t.success = o, t.fail = s, a.uploadimg1(t, e));
            }
        });
    },
    chooseImage: function() {
        var t = this, a = t.data.pics, i = app.util.url("entry/wxapp/Toupload") + "&m=chbl_sun";
        a.length < 4 ? wx.chooseImage({
            count: 4,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                0 < (a = e.tempFilePaths).length && t.uploadimg({
                    url: i,
                    path: a,
                    uppic: ""
                }, ""), t.setData({
                    pics: a
                });
            }
        }) : wx.showToast({
            title: "只允许上传4张图片！！！",
            icon: "none"
        });
    },
    chooseImage1: function() {
        var t = this, a = t.data.picss, i = app.util.url("entry/wxapp/Toupload") + "&m=chbl_sun";
        a.length < 9 ? wx.chooseImage({
            count: 9,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                a = e.tempFilePaths, console.log(a), 0 < a.length && (t.uploadimg1({
                    url: i,
                    path: a,
                    uppics: ""
                }, ""), t.setData({
                    picss: a
                }));
            }
        }) : wx.showToast({
            title: "只允许上传9张图片！！！",
            icon: "none"
        });
    },
    deleteImage: function(e) {
        var t = this.data.pics, a = e.currentTarget.dataset.index;
        t.splice(a, 1), this.setData({
            pics: t
        });
    },
    deleteImage1: function(e) {
        var t = this.data.picss, a = e.currentTarget.dataset.index;
        t.splice(a, 1), this.setData({
            picss: t
        });
    },
    delete2: function(e) {
        console.log(e);
        Array.prototype.indexOf = function(e) {
            for (var t = 0; t < this.length; t++) if (this[t] == e) return t;
            return -1;
        }, Array.prototype.remove = function(e) {
            var t = this.indexOf(e);
            -1 < t && this.splice(t, 1);
        };
        var t = e.currentTarget.dataset.index;
        imgArray2.remove(imgArray2[t]), this.setData({
            imgArray2: imgArray2
        });
    },
    previewImage: function(e) {
        console.log(e);
        var t = e.currentTarget.dataset.index, a = e.currentTarget.dataset.list;
        wx.previewImage({
            current: a[t],
            urls: a
        });
    },
    chooseAddTap: function() {
        var t = this;
        wx.chooseLocation({
            success: function(e) {
                console.log(e), t.setData({
                    address: e.address,
                    latitude: e.latitude,
                    longitude: e.longitude
                });
            },
            fail: function(e) {
                wx.showModal({
                    title: "请授权获得地理信息",
                    content: '点击右上角...，进入关于页面，再点击右上角...，进入设置,开启"使用我的地理位置"'
                });
            }
        });
    },
    onReady: function() {},
    bindPickerChange: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value), this.setData({
            index: e.detail.value
        });
    },
    onShow: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/storeIn",
            cachetime: "30",
            success: function(e) {
                console.log(e.data.data), t.setData({
                    storein: e.data.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});