var t, a = getApp(), e = require("../../../../utils/qqmap-wx-jssdk.min.js");

Page({
    data: {
        isShow: !1,
        loading: !0,
        imgList: [],
        type: [],
        address: "",
        mapy: "",
        mapx: "",
        phone: "",
        sexvalue: "",
        typeall: "",
        type_name: [],
        type_id: [],
        province: "",
        city: "",
        district: "",
        qq_map_key: ""
    },
    onLoad: function(t) {
        var e = this;
        a.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "master.type",
                uid: wx.getStorageSync("uid")
            },
            success: function(t) {
                console.log(t), e.setData({
                    typeall: t.data.data.typeall,
                    qq_map_key: t.data.data.qq_map_key,
                    type_num: t.data.data.type_num
                });
                for (var i = [], d = [], s = 0; s < t.data.data.typeall.length; s++) t.data.data.typeall[s].xuanzhong && (i.push(t.data.data.typeall[s].id), 
                d.push(t.data.data.typeall[s].name));
                e.setData({
                    type_name: d,
                    type_id: i
                }), t.data.data.detail.address && (e.setData({
                    detail: t.data.data.detail,
                    address: t.data.data.detail.address,
                    mapy: t.data.data.detail.mapy,
                    mapx: t.data.data.detail.mapx,
                    province: t.data.data.detail.province,
                    city: t.data.data.detail.city,
                    district: t.data.data.detail.district,
                    sexvlue: t.data.data.detail.sex
                }), t.data.data.detail.imgs.length > 0 && e.setData({
                    imgList: t.data.data.detail.imgs
                })), t.data.data.detail.address && 2 == e.data.detail.status && 0 == e.data.detail.black && a.util.message({
                    title: "驳回原因：" + e.data.detail.reject + "--请重新提交",
                    type: "error"
                });
            }
        });
    },
    formSubmit: function(t) {
        var e = this;
        if (e.data.type_id.length < 1) a.util.message({
            title: "请选择服务类型",
            type: "error"
        }); else if ("" != t.detail.value.name && "undefined" != t.detail.value.name) if ("" != t.detail.value.phone && "undefined" != t.detail.value.phone) if (/^1[34578]\d{9}$/.test(t.detail.value.phone)) if ("" != t.detail.value.address && "undefined" != t.detail.address) if ("" != e.data.mapx && "undefined" != e.data.mapx) if ("" != t.detail.value.address_detail && "undefined" != t.detail.address_detail) {
            var i = {
                formid: t.detail.formId,
                type_id: e.data.type_id,
                type_name: e.data.type_name,
                address: t.detail.value.address,
                name: t.detail.value.name,
                age: t.detail.value.age,
                detail: t.detail.value.detail,
                address_detail: t.detail.value.address_detail,
                mapy: e.data.mapy,
                mapx: e.data.mapx,
                sex: e.data.sexvlue,
                phone: t.detail.value.phone,
                imgs: JSON.stringify(e.data.imgList),
                uid: wx.getStorageSync("uid"),
                province: e.data.province,
                city: e.data.city,
                district: e.data.district,
                id: t.detail.value.id,
                m: "ox_master",
                r: "store.create"
            };
            a.util.request({
                url: "entry/wxapp/Api",
                data: i,
                method: "POST",
                success: function(t) {
                    wx.showModal({
                        title: "提交成功",
                        content: "",
                        success: function(t) {
                            t.confirm && wx.switchTab({
                                url: "/pages/me/index"
                            });
                        }
                    });
                }
            });
        } else a.util.message({
            title: "请填写店铺详细地址",
            type: "error"
        }); else a.util.message({
            title: "请点击获取地址",
            type: "error"
        }); else a.util.message({
            title: "请填写店铺地址",
            type: "error"
        }); else a.util.message({
            title: "请检查手机格式",
            type: "error"
        }); else a.util.message({
            title: "请填写服务电话",
            type: "error"
        }); else a.util.message({
            title: "请填写真实姓名",
            type: "error"
        });
    },
    getCity: function(a, e) {
        var i = this;
        t.reverseGeocoder({
            location: {
                latitude: a,
                longitude: e
            },
            success: function(t) {
                var t = t.result;
                i.setData({
                    province: t.address_component.province,
                    city: t.address_component.city,
                    district: t.address_component.district
                });
            },
            fail: function(t) {
                console.error(t);
            }
        });
    },
    sexChange: function(t) {
        this.setData({
            sexvlue: t.detail.value
        });
    },
    getPhoneNumber: function(t) {
        var e = this;
        t.detail.iv && a.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "home.userphone",
                iv: t.detail.iv,
                encryptedData: t.detail.encryptedData
            },
            success: function(t) {
                e.setData({
                    phone: t.data.data
                }), console.log(t);
            }
        });
    },
    tomap: function() {
        var a = this;
        wx.chooseLocation({
            success: function(i) {
                console.log(i), a.setData({
                    mapx: i.latitude,
                    mapy: i.longitude,
                    address: i.address
                }), t = new e({
                    key: a.data.qq_map_key
                });
                var d = i.latitude, s = i.longitude;
                a.getCity(d, s);
            },
            fail: function() {
                wx.getSetting({
                    success: function(t) {
                        t.authSetting["scope.userLocation"] || wx.showModal({
                            content: "请允许获取地理位置后再次尝试",
                            success: function(t) {
                                t.confirm ? wx.openSetting({
                                    success: function(t) {
                                        t.authSetting = {
                                            "scope.userInfo": !0,
                                            "scope.userLocation": !0
                                        };
                                    },
                                    fail: function(t) {
                                        console.log(t);
                                    }
                                }) : t.cancel && console.log("用户点击取消");
                            }
                        });
                    }
                });
            }
        });
    },
    bindChange: function(t) {
        this.setData({
            type_index: t.detail.value,
            type_value: this.data.type[t.detail.value]
        });
    },
    deleteImg: function(t) {
        var a = t.currentTarget.dataset.id, e = this.data.imgList;
        e.splice(a, 1), this.setData({
            imgList: e
        });
    },
    uplaod: function() {
        var t = this;
        wx.chooseImage({
            count: 6,
            sizeType: [ "original", "compressed" ],
            success: function(e) {
                var i = e.tempFilePaths, d = e.tempFilePaths.length, s = 1;
                t.setData({
                    loading: !1
                });
                for (var l in i) wx.uploadFile({
                    url: a.util.url("entry/wxapp/Api", {
                        m: "ox_master",
                        r: "upload.save"
                    }),
                    filePath: i[l],
                    name: "file",
                    success: function(a) {
                        var e = JSON.parse(a.data), i = t.data.imgList;
                        i.push(e.data), t.setData({
                            imgList: i
                        }), s == d && t.setData({
                            loading: !0
                        }), s += 1;
                    }
                });
            }
        });
    },
    typeselect: function(t) {
        var e = t.currentTarget.dataset.index, i = this.data.typeall;
        if (console.log(this.data.type_id.length), console.log(this.data.type_id), console.log(e), 
        this.data.type_id.length != this.data.type_num || i[e].xuanzhong) {
            i[e].xuanzhong = !i[e].xuanzhong;
            for (var d = [], s = [], l = 0; l < this.data.typeall.length; l++) this.data.typeall[l].xuanzhong && (d.push(this.data.typeall[l].id), 
            s.push(this.data.typeall[l].name));
            this.setData({
                typeall: i,
                type_name: s,
                type_id: d
            });
        } else a.util.message({
            title: "最多只能选" + this.data.type_num + "个",
            type: "error"
        });
    }
});