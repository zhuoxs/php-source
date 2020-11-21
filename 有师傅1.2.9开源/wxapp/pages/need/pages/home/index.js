function e(e, t, a) {
    return t in e ? Object.defineProperty(e, t, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = a, e;
}

var t, a, i = getApp(), s = require("../../../../utils/qqmap-wx-jssdk.min.js");

Page({
    data: (t = {
        isShow: !1,
        loading: !0,
        imgList: [],
        type: [],
        address: "",
        mapy: "",
        mapx: "",
        phone: "",
        province: "",
        city: "",
        district: "",
        type_value: "",
        type_index: "",
        selectTime: "agc",
        color: [ "rgba(0,0,0,.3)", "#333" ],
        beginTime: [ 2018, 1, 1, 0, 0 ]
    }, e(t, "selectTime", []), e(t, "endTime", [ 2030, 1, 1, 2, 2 ]), e(t, "defSelectTime", [ 2019, 1, 1, 0, 0 ]), 
    e(t, "userblack", 0), e(t, "userblack_info", []), t),
    onLoad: function(e) {
        var t = this;
        i.util.getUserInfo(function(e) {
            e.memberInfo ? (wx.setStorageSync("uid", e.memberInfo.uid), t.black(e.memberInfo.uid)) : t.hideDialog();
        }), i.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "master.type"
            },
            success: function(e) {
                t.setData({
                    type: e.data.data.type,
                    price: e.data.data.price,
                    detail: e.data.data.detail,
                    tip: e.data.data.tip
                });
            }
        }), this.setData({
            type_value: e.type_value
        });
    },
    black: function(e) {
        var t = this;
        i.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "me.userblack",
                uid: e
            },
            success: function(e) {
                e.data.data.user && t.setData({
                    userblack: 1,
                    userblack_info: e.data.data.user
                });
            }
        });
    },
    hideDialog: function() {
        this.setData({
            isShow: !this.data.isShow
        });
    },
    updateUserInfo: function(e) {
        var t = this;
        t.hideDialog(), e.detail.userInfo && i.util.getUserInfo(function(e) {
            wx.setStorageSync("uid", e.memberInfo.uid), t.black(res.memberInfo.uid);
        }, e.detail);
    },
    formSubmit: function(e) {
        var t = this, a = t.data.selectTime[0] + "-" + t.data.selectTime[1] + "-" + t.data.selectTime[2] + " " + t.data.selectTime[3] + ":" + t.data.selectTime[4];
        if ("" != e.detail.value.phone && "undefined" != e.detail.value.phone) if ("" != e.detail.value.name && "undefined" != e.detail.value.name) if (/^1[34578]\d{9}$/.test(e.detail.value.phone)) if ("" != e.detail.value.address && "undefined" != e.detail.address) if ("" != e.detail.value.address_detail && "undefined" != e.detail.address_detail) if (t.data.imgList.length < 1) i.util.message({
            title: "请上传图片方便服务人员了解具体情况",
            type: "error"
        }); else {
            var s = {
                formid: e.detail.formId,
                type_name: t.data.type_value,
                address: e.detail.value.address,
                address_detail: e.detail.value.address_detail,
                mapy: t.data.mapy,
                mapx: t.data.mapx,
                province: t.data.province,
                city: t.data.city,
                district: t.data.district,
                phone: e.detail.value.phone,
                name: e.detail.value.name,
                remark: e.detail.value.remark,
                imgs: JSON.stringify(t.data.imgList),
                uid: wx.getStorageSync("uid"),
                time: a,
                m: "ox_master"
            };
            i.util.request({
                url: "entry/wxapp/PayRepair",
                data: s,
                method: "POST",
                success: function(e) {
                    e.data && "1" == e.data.message && wx.showModal({
                        title: "预约成功",
                        content: "正在为您联系服务人员",
                        success: function(e) {
                            console.log(e), e.confirm && wx.switchTab({
                                url: "/pages/order/index"
                            });
                        }
                    }), e.data && e.data.data && !e.data.errno && "1" != e.data.message && wx.requestPayment({
                        timeStamp: e.data.data.timeStamp,
                        nonceStr: e.data.data.nonceStr,
                        package: e.data.data.package,
                        signType: "MD5",
                        paySign: e.data.data.paySign,
                        success: function(e) {
                            wx.showModal({
                                title: "预约成功",
                                content: "正在为您联系服务人员",
                                success: function(e) {
                                    e.confirm && wx.switchTab({
                                        url: "/pages/order/index"
                                    });
                                }
                            });
                        },
                        fail: function(e) {
                            backApp();
                        }
                    });
                },
                fail: function(e) {
                    wx.showModal({
                        title: "系统提示",
                        content: e.data.message ? e.data.message : "错误",
                        showCancel: !1,
                        success: function(e) {
                            e.confirm && backApp();
                        }
                    });
                }
            });
        } else i.util.message({
            title: "请填写服务详细地址",
            type: "error"
        }); else i.util.message({
            title: "请填写服务地址",
            type: "error"
        }); else i.util.message({
            title: "请检查手机格式",
            type: "error"
        }); else i.util.message({
            title: "请填写联系人",
            type: "error"
        }); else i.util.message({
            title: "请填写联系方式",
            type: "error"
        });
    },
    getPhoneNumber: function(e) {
        var t = this;
        e.detail.iv && i.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "home.userphone",
                iv: e.detail.iv,
                encryptedData: e.detail.encryptedData
            },
            success: function(e) {
                t.setData({
                    phone: e.data.data
                }), console.log(e);
            }
        });
    },
    getCity: function(e, t) {
        var i = this;
        a.reverseGeocoder({
            location: {
                latitude: e,
                longitude: t
            },
            success: function(e) {
                var e = e.result;
                i.setData({
                    province: e.address_component.province,
                    city: e.address_component.city,
                    district: e.address_component.district
                });
            },
            fail: function(e) {
                console.error(e);
            }
        });
    },
    tomap: function() {
        var e = this;
        wx.authorize({
            scope: "scope.userLocation",
            success: function(t) {
                wx.chooseLocation({
                    success: function(t) {
                        e.setData({
                            mapx: t.latitude,
                            mapy: t.longitude,
                            address: t.address
                        }), a = new s({
                            key: e.data.detail.qq_map_key
                        });
                        var i = t.latitude, n = t.longitude;
                        e.getCity(i, n);
                    },
                    fail: function() {
                        wx.getSetting({
                            success: function(e) {
                                e.authSetting["scope.userLocation"] || wx.showModal({
                                    content: "请允许获取地理位置后再次尝试",
                                    success: function(e) {
                                        e.confirm ? wx.openSetting({
                                            success: function(e) {
                                                e.authSetting = {
                                                    "scope.userInfo": !0,
                                                    "scope.userLocation": !0
                                                };
                                            },
                                            fail: function(e) {
                                                console.log(e);
                                            }
                                        }) : e.cancel && console.log("用户点击取消");
                                    }
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    bindChange: function(e) {
        this.setData({
            type_index: e.detail.value,
            type_value: this.data.type[e.detail.value]
        });
    },
    deleteImg: function(e) {
        var t = e.currentTarget.dataset.id, a = this.data.imgList;
        a.splice(t, 1), this.setData({
            imgList: a
        });
    },
    uplaod: function() {
        var e = this;
        wx.chooseImage({
            count: 6,
            sizeType: [ "original", "compressed" ],
            success: function(t) {
                var a = t.tempFilePaths, s = t.tempFilePaths.length, n = 1;
                e.setData({
                    loading: !1
                });
                for (var d in a) wx.uploadFile({
                    url: i.util.url("entry/wxapp/Api", {
                        m: "ox_master",
                        r: "upload.save"
                    }),
                    filePath: a[d],
                    name: "file",
                    success: function(t) {
                        var a = JSON.parse(t.data), i = e.data.imgList;
                        i.push(a.data), e.setData({
                            imgList: i
                        }), n == s && e.setData({
                            loading: !0
                        }), n += 1;
                    }
                });
            }
        });
    },
    datechange: function(e) {
        this.setData({
            selectTime: e.detail
        });
    },
    onShow: function() {
        var e = new Date();
        this.setData({
            selectTime: [ e.getFullYear(), e.getMonth() + 1, e.getDate(), 0, 0 ]
        });
    }
});