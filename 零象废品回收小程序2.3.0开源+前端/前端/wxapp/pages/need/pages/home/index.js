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
        content: "",
        type_value: "",
        type_index: "",
        selectTime: "agc",
        color: [ "rgba(0,0,0,.3)", "#333" ],
        beginTime: [ 2018, 1, 1, 8, 0 ]
    }, e(t, "selectTime", []), e(t, "endTime", [ 2030, 1, 1, 2, 2 ]), e(t, "defSelectTime", [ 2019, 1, 1, 0, 0 ]), 
    e(t, "userblack", 0), e(t, "userblack_info", []), e(t, "TabCur", 0), e(t, "scrollLeft", 0), 
    t),
    onLoad: function(e) {
        var t = this;
        if (i.util.getUserInfo(function(e) {
            e.memberInfo ? (i.util.request({
                url: "entry/wxapp/Api",
                data: {
                    m: "ox_reclaim",
                    r: "need.type",
                    uid: e.memberInfo.uid
                },
                success: function(e) {
                    t.setData({
                        type: e.data.data.type,
                        address: e.data.data.address
                    });
                }
            }), wx.setStorageSync("uid", e.memberInfo.uid)) : t.hideDialog();
        }), e.id) {
            var d = "", n = [];
            this.setData({
                TabCur: e.id,
                type_value: e.type
            }), i.util.request({
                url: "entry/wxapp/Api",
                data: {
                    m: "ox_reclaim",
                    r: "need.typeDetail",
                    id: e.id
                },
                success: function(e) {
                    d = e.data.data.html, n = e.data.data.priceList, t.setData({
                        priceList: n
                    }), d && t.setData({
                        content: d.replace(/\<img/g, '<img style="width:100%;height:auto;disply:block"')
                    });
                }
            });
        }
        a = new s({
            key: "XC2BZ-OGTRJ-AEDFB-FMHHP-XMOEO-KWBAM"
        }), wx.getLocation({
            type: "wgs84",
            success: function(e) {
                t.setData({
                    latitude: e.latitude,
                    longitude: e.longitude
                }), t.getCity(e.latitude, e.longitude);
            }
        });
    },
    address: function() {
        wx.navigateTo({
            url: "/pages/me/address/index?id=1"
        });
    },
    onShow: function() {
        var e = new Date();
        this.setData({
            selectTime: [ e.getFullYear(), e.getMonth() + 1, e.getDate(), 8, 0 ]
        });
    },
    reclaim: function() {
        this.setData({
            priceList: []
        });
    },
    tabSelect: function(e) {
        var t = this, a = "", s = [];
        this.setData({
            TabCur: e.currentTarget.dataset.id,
            scrollLeft: 60 * (e.currentTarget.dataset.index - 1),
            type_value: e.currentTarget.dataset.type
        }), i.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "need.typeDetail",
                id: e.currentTarget.dataset.id
            },
            success: function(e) {
                a = e.data.data.html, s = e.data.data.priceList, t.setData({
                    priceList: s
                }), a ? t.setData({
                    content: a.replace(/\<img/g, '<img style="width:100%;height:auto;disply:block"')
                }) : t.setData({
                    content: ""
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
        if (t.setData({
            modalName: null
        }), "" != t.data.address && "undefined" != t.data.address) {
            "" != t.data.type_value && "undefined" != t.data.type_value || t.setData({
                type_value: ""
            });
            var s = {
                formid: e.detail.formId,
                type_name: t.data.type_value,
                address: t.data.address.address,
                address_detail: t.data.address.address_detail,
                longitude: t.data.address.longitude,
                latitude: t.data.address.latitude,
                province: t.data.address.province,
                city: t.data.address.city,
                district: t.data.address.district,
                phone: t.data.address.phone,
                name: t.data.address.name,
                remark: e.detail.value.remark,
                imgs: JSON.stringify(t.data.imgList),
                uid: wx.getStorageSync("uid"),
                time: a,
                cycle: e.detail.value.cycle,
                m: "ox_reclaim",
                r: "need.createOrder"
            };
            i.util.request({
                url: "entry/wxapp/Api",
                data: s,
                method: "POST",
                success: function(e) {
                    wx.showModal({
                        title: "预约成功",
                        content: "正在为您联系服务人员",
                        success: function(e) {
                            console.log(e), e.confirm && wx.switchTab({
                                url: "/pages/order/index"
                            });
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
            title: "请选择地址",
            type: "error"
        });
    },
    goBack: function() {
        wx.navigateBack({
            delta: 1
        });
    },
    getPhoneNumber: function(e) {
        var t = this;
        e.detail.iv && i.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "home.userphone",
                iv: e.detail.iv,
                encryptedData: e.detail.encryptedData
            },
            success: function(e) {
                t.setData({
                    phone: e.data.data
                });
            }
        });
    },
    getCity: function(e, t) {
        var s = this;
        a.reverseGeocoder({
            location: {
                latitude: e,
                longitude: t
            },
            success: function(e) {
                var e = e.result;
                i.util.request({
                    url: "entry/wxapp/Api",
                    data: {
                        m: "ox_reclaim",
                        r: "need.service",
                        city_name: e.address_component.city
                    },
                    success: function(e) {
                        e.data.data.status || s.setData({
                            modalName: "DialogModal2"
                        });
                    }
                }), s.setData({
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
    apply: function() {
        var e = this;
        i.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "need.addService",
                city_name: e.data.city,
                province: e.data.province
            },
            success: function(e) {
                wx.showToast({
                    title: "已提交申请",
                    icon: "success",
                    duration: 2e3,
                    complete: function() {
                        setTimeout(function() {
                            wx.navigateBack({
                                delta: 1
                            });
                        }, 2e3);
                    }
                });
            }
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
            count: 3,
            sizeType: [ "original", "compressed" ],
            success: function(t) {
                var a = t.tempFilePaths, s = t.tempFilePaths.length, d = 1;
                e.setData({
                    loading: !1
                });
                for (var n in a) wx.uploadFile({
                    url: i.util.url("entry/wxapp/Api", {
                        m: "ox_reclaim",
                        r: "upload.save"
                    }),
                    filePath: a[n],
                    name: "file",
                    success: function(t) {
                        var a = JSON.parse(t.data), i = e.data.imgList;
                        i.push(a.data), e.setData({
                            imgList: i
                        }), d == s && e.setData({
                            loading: !0
                        }), d += 1;
                    }
                });
            }
        });
    },
    showModal: function(e) {
        this.setData({
            modalName: e.currentTarget.dataset.target
        });
    },
    hideModal: function(e) {
        this.setData({
            modalName: null
        });
    },
    datechange: function(e) {
        this.setData({
            selectTime: e.detail
        });
    }
});