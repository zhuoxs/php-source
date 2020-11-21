var app = getApp();

Page({
    data: {
        formId: "",
        template_withdrawal: "",
        rz_id: "",
        fl_id: "",
        storein: [],
        store_fenlei: [],
        latAndLong: "",
        stime: "00:00",
        etime: "23:59",
        items: [ {
            name: 0,
            value: "刷卡支付"
        }, {
            name: 1,
            value: "免费停车"
        }, {
            name: 2,
            value: "免费wifi"
        }, {
            name: 3,
            value: "禁止吸烟"
        }, {
            name: 4,
            value: "提供包间"
        }, {
            name: 5,
            value: "沙发休闲"
        } ],
        checkRadio: [],
        pics: [],
        pics2: [],
        pics3: []
    },
    onLoad: function(e) {
        var t = this, o = wx.getStorageSync("openid");
        t.diyWinColor(), app.util.request({
            url: "entry/wxapp/User_id",
            data: {
                openid: o
            },
            success: function(e) {
                console.log("查看用户id"), console.log(e), t.setData({
                    comment_xqy: e.data
                }), wx.setStorageSync("user_id", e.data.id);
            }
        }), app.util.request({
            url: "entry/wxapp/Class_sj",
            success: function(e) {
                console.log("商家分类数据"), console.log(e);
                for (var o = 0; o < e.data.length; o++) t.data.store_fenlei.push(e.data[o].tname), 
                console.log(t.data.store_fenlei);
                console.log(t.data.store_fenlei), t.setData({
                    store_fenlei: t.data.store_fenlei,
                    noDealData_fl: e.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Day_rz",
            success: function(e) {
                console.log("商家入驻期限数据"), console.log(e);
                for (var o = 0; o < e.data.length; o++) {
                    var a = e.data[o].duration + "天/￥" + e.data[o].money;
                    t.data.storein.push(a), console.log(t.data.storein);
                }
                console.log(t.data.storein), t.setData({
                    storein: t.data.storein,
                    noDealData: e.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Mob_message",
            success: function(e) {
                console.log("模板消息数据"), console.log(e), t.setData({
                    template_withdrawal: e.data.template_withdrawal
                });
            }
        }), t.diyWinColor();
    },
    bindPickerChange: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value);
        var o = this.data.noDealData[e.detail.value].id, a = this.data.noDealData[e.detail.value].money;
        console.log(o), this.setData({
            index_qx: e.detail.value,
            rz_id: o,
            rz_money: a
        });
    },
    bindPickerType: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value);
        var o = this.data.noDealData_fl[e.detail.value].tid;
        console.log(o), this.setData({
            index_sj: e.detail.value,
            fl_id: o
        });
    },
    checkboxChange: function(e) {
        var o = e.detail.value, a = "";
        if (0 < o.length) for (var t = 0; t < o.length; t++) a = a ? a + "," + o[t] : o[t];
        this.setData({
            checkRadio: a
        }), console.log(a);
    },
    bindTimeChange: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value), "start" == e.currentTarget.dataset.statu ? this.setData({
            stime: e.detail.value
        }) : this.setData({
            etime: e.detail.value
        });
    },
    publish: function(a) {
        console.log(a);
        var l = this.data.noDealData[this.data.index_qx].money;
        console.log(l);
        var e = wx.getStorageSync("user_id");
        console.log(e), console.log("表单数据"), console.log(a);
        var o = a.detail.value, n = this;
        n.setData({
            formId: a.detail.formId
        }), console.log(n.data.template_withdrawal);
        var s = app.util.url("entry/wxapp/Toupload_sjlb") + "&m=yzkm_sun", i = app.util.url("entry/wxapp/Toupload_sjlb2") + "&m=yzkm_sun", c = app.util.url("entry/wxapp/Toupload_sjlb3") + "&m=yzkm_sun", d = n.data.pics, u = n.data.pics2, r = n.data.pics3;
        if (console.log("表单上传的图片数据"), console.log(u), "" == a.detail.value.store_name) return wx.showToast({
            title: "商家名称不能为空",
            icon: "none"
        }), !1;
        if ("" == a.detail.value.phone) return wx.showToast({
            title: "商家联系方式不能为空",
            icon: "none"
        }), !1;
        if ("" == a.detail.value.address) return wx.showToast({
            title: "商家地址不能为空",
            icon: "none"
        }), !1;
        if ("" == a.detail.value.averagePrice) return wx.showToast({
            title: "人均消费不能为空",
            icon: "none"
        }), !1;
        if ("" == a.detail.value.start_time) return wx.showToast({
            title: "请选择营业开始时间",
            icon: "none"
        }), !1;
        if ("" == a.detail.value.over_time) return wx.showToast({
            title: "请选择营业结束时间",
            icon: "none"
        }), !1;
        if ("" == a.detail.value.details) return wx.showToast({
            title: "请填写商家介绍",
            icon: "none"
        }), !1;
        if ("" == a.detail.value.coordinate) return wx.showToast({
            title: "请选择地理坐标",
            icon: "none"
        }), !1;
        if (!o.push_text && d.length <= 0) return wx.showToast({
            title: "写点内容或者发张图片吧！！！",
            icon: "none"
        }), !1;
        if (!o.push_text && u.length <= 0) return wx.showToast({
            title: "写点内容或者发张图片吧！！！",
            icon: "none"
        }), !1;
        var g = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Orderarr",
            cachetime: "30",
            data: {
                openid: g,
                price: l
            },
            success: function(e) {
                console.log(e), wx.requestPayment({
                    timeStamp: e.data.timeStamp,
                    nonceStr: e.data.nonceStr,
                    package: e.data.package,
                    signType: "MD5",
                    paySign: e.data.paySign,
                    success: function(e) {
                        console.log("支付数据"), console.log(e), wx.showToast({
                            title: "支付成功",
                            icon: "success",
                            duration: 2e3
                        });
                        var t = wx.getStorageSync("user_id");
                        wx.showLoading({
                            title: "内容发布中，请稍后...",
                            mask: !0
                        });
                        var o = wx.getStorageSync("id");
                        console.log("5555555555555555555555555555555555"), n.setData({
                            disabled: !0,
                            sendtitle: "稍后"
                        });
                        t = wx.getStorageSync("user_id");
                        console.log(n.data.rz_id), console.log(n.data.fl_id), app.util.request({
                            url: "entry/wxapp/AddPhoto_sjrz",
                            cachetime: "0",
                            data: {
                                latitude: n.data.latitude,
                                longitude: n.data.longitude,
                                uimg: d,
                                uimg2: u,
                                name: a.detail.value.name,
                                tel: a.detail.value.tel,
                                content: a.detail.value.content,
                                id: o,
                                store_name: a.detail.value.store_name,
                                phone: a.detail.value.phone,
                                address: a.detail.value.address,
                                averagePrice: a.detail.value.averagePrice,
                                coordinate: n.data.latAndLong,
                                index_qx: n.data.rz_id,
                                index_sj: n.data.fl_id,
                                checkRadio: n.data.checkRadio,
                                over_time: a.detail.value.over_time,
                                start_time: a.detail.value.start_time,
                                details: a.detail.value.details,
                                user_id: t
                            },
                            success: function(e) {
                                console.log("发布数据请求"), console.log(e.data), wx.setStorageSync("tcid", e.data);
                                var o = e.data, a = {
                                    tcid: o
                                };
                                0 < d.length && (console.log("2222222222222222"), console.log(o), n.uploadimg({
                                    url: s,
                                    path: d
                                }, a)), 0 < u.length && (console.log("图片2******************"), console.log(o), n.uploadimg2({
                                    url: i,
                                    path: u
                                }, a)), 0 < r.length && (console.log("图片3******************"), console.log(o), n.uploadimg3({
                                    url: c,
                                    path: r
                                }, a)), app.util.request({
                                    url: "entry/wxapp/AccessToken",
                                    cachetime: "0",
                                    success: function(e) {
                                        console.log(n.data.template_withdrawal), console.log(g), console.log(n.data.formId), 
                                        console.log(l), console.log(t), app.util.request({
                                            url: "entry/wxapp/Send_rz",
                                            cachetime: "0",
                                            data: {
                                                access_token: e.data.access_token,
                                                template_id: n.data.template_withdrawal,
                                                page: "yzkm_sun/pages/index/index",
                                                openid: g,
                                                form_id: n.data.formId,
                                                money: l,
                                                user_id: t
                                            },
                                            success: function(e) {
                                                console.log(e.data);
                                            }
                                        });
                                    }
                                });
                            },
                            fail: function() {
                                n.setData({
                                    disabled: !1,
                                    sendtitle: "发送"
                                }), wx.showToast({
                                    title: "可能由于网络原因，发布失败，请重新发布！！！",
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
    },
    chooseImage: function() {
        var o = this, a = o.data.pics;
        a.length < 9 ? wx.chooseImage({
            count: 9,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                a = a.concat(e.tempFilePaths), console.log("1111111111111"), console.log(a), o.setData({
                    pics: a
                });
            }
        }) : wx.showToast({
            title: "只允许上传9张图片！！！",
            icon: "none"
        });
    },
    uploadimg: function(e, o) {
        var a = this, t = e.i ? e.i : 0, l = e.success ? e.success : 0, n = e.fail ? e.fail : 0;
        console.log("这里是上传图片时一起上传的数据"), console.log(o), wx.uploadFile({
            url: e.url,
            filePath: e.path[t],
            name: "file",
            formData: o,
            success: function(e) {
                console.log("上传图片时的数据"), console.log(e), 1 == e.data && (console.log(2.222222222222222e46), 
                l++), console.log("图片上传成功后"), console.log(e), console.log(t);
            },
            fail: function(e) {
                2 == e.data && (console.log(3.3333333333333334e50), n++), console.log("上传失败"), console.log("fail:" + t + "fail:" + n);
            },
            complete: function() {
                ++t == e.path.length ? (console.log("执行完毕"), wx.hideLoading(), wx.showToast({
                    title: "已发送入驻申请！！！",
                    icon: "success",
                    success: function() {
                        a.setData({
                            pics: [],
                            content: "",
                            disabled: !1,
                            sendtitle: "发送"
                        }), app.globalData.aci = "";
                    }
                })) : (e.i = t, e.success = l, e.fail = n, a.uploadimg(e, o));
            }
        });
    },
    deleteImage: function(e) {
        var o = this.data.pics, a = e.currentTarget.dataset.index;
        o.splice(a, 1), this.setData({
            pics: o
        });
    },
    chooseImage2: function() {
        var o = this, a = o.data.pics2;
        a.length < 9 ? wx.chooseImage({
            count: 9,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                a = a.concat(e.tempFilePaths), console.log("1111111111111222222222222222222"), console.log(a), 
                o.setData({
                    pics2: a
                });
            }
        }) : wx.showToast({
            title: "只允许上传9张图片！！！",
            icon: "none"
        });
    },
    uploadimg2: function(e, o) {
        var a = this, t = e.i ? e.i : 0, l = e.success ? e.success : 0, n = e.fail ? e.fail : 0;
        console.log("这里是上传图片时一起上传的数据2222222222222222"), console.log(o), wx.uploadFile({
            url: e.url,
            filePath: e.path[t],
            name: "file",
            formData: o,
            success: function(e) {
                console.log("上传图片时的数据22222222222222222"), console.log(e), 1 == e.data && (console.log(2.222222222222222e46), 
                l++), console.log("图片上传成功后22222222222222"), console.log(e), console.log(t);
            },
            fail: function(e) {
                2 == e.data && (console.log(3.3333333333333334e50), n++), console.log("上传失败2222222222222222"), 
                console.log("fail:" + t + "fail:" + n);
            },
            complete: function() {
                ++t == e.path.length ? (console.log("执行完毕222222222222222"), wx.hideLoading(), wx.showToast({
                    title: "已发送入驻申请！！！",
                    icon: "success",
                    success: function() {
                        a.setData({
                            pics2: [],
                            content: "",
                            disabled: !1,
                            sendtitle: "发送"
                        }), app.globalData.aci = "";
                    }
                })) : (e.i = t, e.success = l, e.fail = n, a.uploadimg2(e, o));
            }
        });
    },
    deleteImage2: function(e) {
        var o = this.data.pics, a = e.currentTarget.dataset.index;
        o.splice(a, 1), this.setData({
            pics2: o
        });
    },
    chooseLoca: function(e) {
        var a = this;
        wx.chooseLocation({
            success: function(e) {
                console.log(e);
                var o = e.longitude + "," + e.latitude;
                a.setData({
                    latAndLong: o
                });
            }
        });
    },
    chooselogoImage: function() {
        var o = this, a = o.data.pics3;
        a.length < 1 ? wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                a = a.concat(e.tempFilePaths), console.log("333333333333333333333333333333333333333333"), 
                console.log(a), o.setData({
                    pics3: a
                });
            }
        }) : wx.showToast({
            title: "只允许上传1张图片！！！",
            icon: "none"
        });
    },
    uploadimg3: function(e, o) {
        var a = this, t = e.i ? e.i : 0, l = e.success ? e.success : 0, n = e.fail ? e.fail : 0;
        console.log("这里是上传图片时一起上传的数据333333333333333"), console.log(o), wx.uploadFile({
            url: e.url,
            filePath: e.path[t],
            name: "file",
            formData: o,
            success: function(e) {
                console.log("上传图片时的数据33333333333333"), console.log(e), 1 == e.data && (console.log(3.3333333333333334e36), 
                l++), console.log("图片上传成功后333333333333333333333333333"), console.log(e), console.log(t);
            },
            fail: function(e) {
                2 == e.data && (console.log(3.3333333333333334e50), n++), console.log("上传失败3333333333333333333333333333333"), 
                console.log("fail:" + t + "fail:" + n);
            },
            complete: function() {
                ++t == e.path.length ? (console.log("执行完毕3333333333333333333333"), wx.hideLoading(), 
                wx.showToast({
                    title: "已发送入驻申请！！！",
                    icon: "success",
                    success: function() {
                        a.setData({
                            pics3: [],
                            content: "",
                            disabled: !1,
                            sendtitle: "发送"
                        });
                    }
                })) : (e.i = t, e.success = l, e.fail = n, a.uploadimg3(e, o));
            }
        });
    },
    deleteImage3: function(e) {
        var o = this.data.pics3, a = e.currentTarget.dataset.index;
        o.splice(a, 1), this.setData({
            pics3: o
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    diyWinColor: function(e) {
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: "#ffb62b"
        }), wx.setNavigationBarTitle({
            title: "商家入驻"
        });
    }
});