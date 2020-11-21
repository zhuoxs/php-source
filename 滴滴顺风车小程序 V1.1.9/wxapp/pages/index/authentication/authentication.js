var e = getApp();

Page({
    data: {
        logintag: "",
        img_one: "",
        img_tow: "",
        driving_license: "",
        vehicle_license: "",
        radio: "",
        info: ""
    },
    onLoad: function(e) {
        var o = this;
        try {
            var n = wx.getStorageSync("session");
            n && (console.log("logintag:", n), o.setData({
                logintag: n
            }));
        } catch (e) {}
        o.member_isexist_mobile(), o.carowner_audit_show();
    },
    member_isexist_mobile: function() {
        var o = this.data.logintag;
        wx.request({
            url: e.data.url + "member_isexist_mobile",
            data: {
                logintag: o
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(e) {
                console.log("member_isexist_mobile => 判断有无手机号码"), console.log(e), "0000" == e.data.retCode || "不存在" == e.data.retDesc && wx.showModal({
                    title: "提示",
                    content: "没有手机码号,请添加手机号码。",
                    success: function(e) {
                        e.confirm ? wx.navigateTo({
                            url: "/pages/index/phone/phone"
                        }) : wx.navigateBack({
                            delta: 1
                        });
                    }
                });
            }
        });
    },
    carowner_audit_show: function(o) {
        var n = this, a = n.data.logintag;
        wx.request({
            url: e.data.url + "carowner_audit_show",
            data: {
                logintag: a
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(e) {
                if (console.log("carowner_audit_show => 显示获取车主认证的信息数据"), console.log(e), "0000" == e.data.retCode) {
                    var o = e.data.info;
                    n.setData({
                        info: o
                    });
                }
            }
        });
    },
    driving_img: function(e) {
        console.log(e);
        var o = this;
        wx.showActionSheet({
            itemList: [ "拍照", "从相册中选择" ],
            itemColor: "#000",
            success: function(e) {
                e.cancel || (1 == e.tapIndex ? o.chooseWxImage("album") : 0 == e.tapIndex && o.chooseWxImage("camera"));
            }
        });
    },
    chooseWxImage: function(e) {
        var o = this;
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ e ],
            success: function(e) {
                var n = e.tempFilePaths[0];
                o.setData({
                    img_one: n
                }), o.SC_driving_img(n);
            }
        });
    },
    SC_driving_img: function(o) {
        var n = this, a = o, t = n.data.logintag;
        wx.uploadFile({
            url: e.data.url + "my_license_upimg",
            filePath: a,
            name: "file",
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            formData: {
                logintag: t
            },
            success: function(e) {
                console.log(e);
                var o = JSON.parse(e.data);
                if ("0000" == o.retCode) {
                    var a = o.pathfile;
                    console.log("imgone:", a), n.setData({
                        driving_license: a
                    });
                } else wx.showToast({
                    title: o.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        });
    },
    license_img: function(e) {
        console.log(e);
        var o = this;
        wx.showActionSheet({
            itemList: [ "拍照", "从相册中选择" ],
            itemColor: "#000",
            success: function(e) {
                e.cancel || (1 == e.tapIndex ? o.license_WxImage("album") : 0 == e.tapIndex && o.license_WxImage("camera"));
            }
        });
    },
    license_WxImage: function(e) {
        var o = this;
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ e ],
            success: function(e) {
                var n = e.tempFilePaths[0];
                o.setData({
                    img_tow: n
                }), o.SC_license_img(n);
            }
        });
    },
    SC_license_img: function(o) {
        var n = this, a = o, t = n.data.logintag;
        wx.uploadFile({
            url: e.data.url + "my_license_upimg",
            filePath: a,
            name: "file",
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            formData: {
                logintag: t
            },
            success: function(e) {
                console.log(e);
                var o = JSON.parse(e.data);
                if ("0000" == o.retCode) {
                    var a = o.pathfile;
                    console.log("imgtow:", a), n.setData({
                        vehicle_license: a
                    });
                } else wx.showToast({
                    title: o.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        });
    },
    radio: function(e) {
        this.setData({
            radio: "radio"
        });
    },
    tiaozhaun: function(e) {
        wx.redirectTo({
            url: "tiaozhaun/tiaozhaun"
        });
    },
    information: function(o) {
        console.log(o);
        var n = this, a = n.data.logintag;
        if ("" == (t = n.data.driving_license) && (i = n.data.info.driving_license)) {
            c = i.split("/")[6];
            console.log(c);
            var t = c;
        }
        if ("" == (s = n.data.vehicle_license)) {
            var i = n.data.info.vehicle_license;
            if (i) {
                var c = i.split("/")[6];
                console.log(c);
                var s = c;
            }
        }
        var l = n.data.radio, r = o.detail.value.car_number, d = o.detail.value.car_model, u = o.detail.value.car_color;
        console.log("radio:", l), console.log("car_number:", r), console.log("car_model:", d), 
        console.log("car_color:", u), console.log("driving_license:", t), console.log("vehicle_license:", s), 
        "" != r ? "" != d ? "" != u ? "" != t ? "" != s ? "" != l ? wx.request({
            url: e.data.url + "carowner_audit_handle",
            data: {
                logintag: a,
                car_number: r,
                car_model: d,
                car_color: u,
                driving_license: t,
                vehicle_license: s
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(e) {
                console.log("carowner_audit_handle => 提交车主认证信息"), console.log(e), "0000" == e.data.retCode ? (wx.showToast({
                    title: e.data.retDesc,
                    icon: "none",
                    duration: 1e3
                }), setTimeout(function() {
                    console.log("延迟调用 => home"), wx.navigateTo({
                        url: "/pages/index/index"
                    });
                }, 1e3)) : wx.showToast({
                    title: e.data.retDesc,
                    icon: "none",
                    duration: 800
                });
            }
        }) : wx.showToast({
            title: "请勾选负责声明",
            icon: "none",
            duration: 1e3
        }) : wx.showToast({
            title: "车辆行驶证未上传",
            icon: "none",
            duration: 1e3
        }) : wx.showToast({
            title: "驾驶证图片未上传",
            icon: "none",
            duration: 1e3
        }) : wx.showToast({
            title: "汽车车辆颜色未填写",
            icon: "none",
            duration: 1e3
        }) : wx.showToast({
            title: "品牌型号未填写",
            icon: "none",
            duration: 1e3
        }) : wx.showToast({
            title: "车牌号码未填写",
            icon: "none",
            duration: 1e3
        });
    },
    onReady: function() {},
    onShow: function() {
        this.member_isexist_mobile();
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});