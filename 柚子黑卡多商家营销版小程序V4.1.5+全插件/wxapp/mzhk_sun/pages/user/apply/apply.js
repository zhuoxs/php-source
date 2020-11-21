var app = getApp();

Page({
    data: {
        navTile: "申请入驻",
        region: [ "福建省", "厦门市", " " ],
        customItem: "全部",
        money: "0",
        priceArray: [],
        showModalStatus: !1,
        showStoreModalStatus: !1,
        storelimitname: "",
        coordinates: "",
        address: "",
        uploadPicOne: [],
        uploadPicTwo: [],
        uploadPicThree: [],
        PicOne: "",
        PicTwo: "",
        PicThree: "",
        spec: [],
        storeCate: [],
        store_id: ""
    },
    onLoad: function(t) {
        var e = this;
        wx.setNavigationBarTitle({
            title: e.data.navTile
        }), app.wxauthSetting(), app.util.request({
            url: "entry/wxapp/GetStoreLimit",
            cachetime: "30",
            success: function(t) {
                console.log("获取入驻期限数据"), console.log(t.data), e.setData({
                    priceArray: t.data.storelimit,
                    spec: t.data.storefacility
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this;
        app.func.islogin(app, e), app.util.request({
            url: "entry/wxapp/url",
            cachetime: "120",
            success: function(t) {
                e.setData({
                    url: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    bindRegionChange: function(t) {
        this.setData({
            region: t.detail.value
        });
    },
    formSubmit: function(t) {
        var e = "", a = !0, o = this, i = t.detail.formId, s = t.detail.value.shopname, n = t.detail.value.uname, l = t.detail.value.phone, c = o.data.starttime, u = o.data.endtime, r = o.data.address, d = o.data.coordinates, p = t.detail.value.type, h = t.detail.value.feature, m = t.detail.value.price, g = t.detail.value.deliveryfee, f = t.detail.value.deliverytime, y = t.detail.value.deliveryaway, w = t.detail.value.lt_id, v = t.detail.value.lt_day, T = t.detail.value.lt_money, x = o.data.PicOne, P = o.data.PicTwo, S = o.data.PicThree, D = wx.getStorageSync("openid"), _ = o.data.spec, b = "";
        if (_.length) for (var C = 0; C < _.length; C++) _[C].statu && (b = "" != b ? b + "," + _[C].id : _[C].id);
        var I = t.detail.value.store_name, k = t.detail.value.store_id;
        "" == k ? e = "请选择商家分类" : "" == s ? e = "请先填写商家名称" : "" == n ? e = "请填写联系人" : "" == r ? e = "请填写详细地址" : null == c && null == u ? e = "请选择营业时间" : null == o.data.priceindex ? e = "请选择入驻时间" : "" == w || "" == v || "" == T ? e = "请选择入驻时间" : "" == S ? e = "请上传一张商家主图" : "" == x ? e = "请至少上传一张商家轮播图" : "" == P ? e = "请至少上传一张商家详情图" : (a = "false", 
        console.log("开始入驻提交"), app.util.request({
            url: "entry/wxapp/Orderarr",
            data: {
                openid: D,
                price: T
            },
            success: function(t) {
                console.log("获取支付需要参数"), console.log(t.data), wx.requestPayment({
                    timeStamp: t.data.timeStamp,
                    nonceStr: t.data.nonceStr,
                    package: t.data.package,
                    signType: t.data.signType,
                    paySign: t.data.paySign,
                    success: function(t) {
                        app.util.request({
                            url: "entry/wxapp/SaveStoreInfo",
                            data: {
                                openid: D,
                                bname: s,
                                uname: n,
                                phone: l,
                                starttime: c,
                                endtime: u,
                                address: r,
                                coordinates: d,
                                storetype: p,
                                feature: h,
                                price: m,
                                deliveryfee: g,
                                deliverytime: f,
                                deliveryaway: y,
                                lt_id: w,
                                lt_day: v,
                                lt_money: T,
                                img: x,
                                PicTwo: P,
                                logo: S,
                                facility: b,
                                store_name: I,
                                store_id: k
                            },
                            success: function(t) {
                                console.log("数据保存成功"), console.log(t.data);
                                var e = t.data.bid, a = t.data.bpl_id;
                                app.util.request({
                                    url: "entry/wxapp/SendMessage",
                                    cachetime: "0",
                                    data: {
                                        bid: e,
                                        openid: D,
                                        form_id: i
                                    },
                                    success: function(t) {
                                        console.log("发送成功"), console.log(t.data);
                                    }
                                }), app.util.request({
                                    url: "entry/wxapp/PayStoreIn",
                                    cachetime: "0",
                                    data: {
                                        bid: e,
                                        bpl_id: a
                                    },
                                    success: function(t) {
                                        console.log("进入跳转"), console.log(t.data), wx.redirectTo({
                                            url: "/mzhk_sun/pages/user/user"
                                        });
                                    }
                                });
                            }
                        });
                    },
                    fail: function(t) {
                        wx.showToast({
                            title: "支付失败",
                            icon: "error",
                            duration: 2e3
                        });
                    }
                });
            }
        })), 1 == a && wx.showModal({
            title: "提示",
            content: e,
            showCancel: !1
        });
    },
    toUser: function(t) {
        wx.switchTab({
            url: "../user"
        });
    },
    bindTimeChange: function(t) {
        this.setData({
            starttime: t.detail.value
        });
    },
    bindEndTimeChange: function(t) {
        this.setData({
            endtime: t.detail.value
        });
    },
    powerDrawer: function(t) {
        var e = t.currentTarget.dataset.statu;
        this.util(e, 0);
    },
    storePowerDrawer: function(t) {
        var e = this, a = t.currentTarget.dataset.statu;
        app.util.request({
            url: "entry/wxapp/GetStoreCate",
            cachetime: "0",
            success: function(t) {
                e.setData({
                    storeCateArray: t.data
                });
            }
        }), this.util(a, 1);
    },
    util: function(t, e) {
        var a = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = a).opacity(0).height(0).step(), this.setData({
            animationData: a.export()
        }), setTimeout(function() {
            a.opacity(1).height("400rpx").step(), this.setData({
                animationData: a
            }), "close" == t && (1 == e ? this.setData({
                showStoreModalStatus: !1
            }) : this.setData({
                showModalStatus: !1
            }));
        }.bind(this), 200), "open" == t && (1 == e ? this.setData({
            showStoreModalStatus: !0
        }) : this.setData({
            showModalStatus: !0
        }));
    },
    clickPrice: function(t) {
        var e = t.currentTarget.dataset.index, a = this.data.priceArray, o = a[e].money, i = a[e].lt_name + "(" + a[e].lt_day + "天)";
        this.setData({
            priceindex: e,
            money: o,
            storelimitday: i
        }), this.util("close", 0);
    },
    clickStoreCate: function(t) {
        var e = t.currentTarget.dataset.index, a = this.data.storeCateArray, o = a[e].id, i = a[e].store_name;
        this.setData({
            storeCateindex: e,
            store_id: o,
            storecate: i
        }), this.util("close", 1);
    },
    uploadPicOne: function(t) {
        var e = this, a = app.util.url("entry/wxapp/Touploadtwo") + "&m=mzhk_sun";
        wx.chooseImage({
            count: 6,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(t) {
                e.setData({
                    uploadPicOne: t.tempFilePaths
                }), e.uploadimg({
                    url: a,
                    path: t.tempFilePaths
                }, {});
            }
        });
    },
    uploadPicTwo: function(t) {
        var e = this, a = app.util.url("entry/wxapp/Touploadtwo") + "&m=mzhk_sun";
        wx.chooseImage({
            count: 9,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(t) {
                e.setData({
                    uploadPicTwo: t.tempFilePaths
                }), e.uploadimg({
                    url: a,
                    path: t.tempFilePaths,
                    utype: 1
                }, {});
            }
        });
    },
    uploadPicThree: function(t) {
        var e = this, a = app.util.url("entry/wxapp/Touploadtwo") + "&m=mzhk_sun";
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(t) {
                e.setData({
                    uploadPicThree: t.tempFilePaths
                }), e.uploadimg({
                    url: a,
                    path: t.tempFilePaths,
                    utype: 2
                }, {});
            }
        });
    },
    uploadimg: function(t, e) {
        console.log(t), console.log("开始上传图片");
        var a = this, o = t.i ? t.i : 0, i = t.utype ? t.utype : 0, s = void 0;
        s = 0 == o ? "" : 1 == i ? a.data.PicTwo : 2 == i ? "" : a.data.PicOne, wx.uploadFile({
            url: t.url,
            filePath: t.path[o],
            name: "file",
            formData: e,
            success: function(t) {
                console.log("success:" + o), s = 0 < s.length ? s + "," + t.data : t.data, console.log(s), 
                1 == i ? a.setData({
                    PicTwo: s
                }) : 2 == i ? a.setData({
                    PicThree: s
                }) : a.setData({
                    PicOne: s
                });
            },
            fail: function(t) {
                console.log("fail:" + o);
            },
            complete: function() {
                ++o == t.path.length ? console.log("图片上传完毕") : (console.log("上传下一张"), t.i = o, a.uploadimg(t, e));
            }
        });
    },
    chooseaddress: function(t) {
        console.log("进入选择地址");
        var a = this;
        wx.chooseLocation({
            type: "wgs84",
            success: function(t) {
                console.log("成功"), console.log(t), t.latitude, t.longitude, t.speed, t.accuracy;
                var e = t.latitude + "," + t.longitude;
                a.setData({
                    address: t.address,
                    coordinates: e
                });
            },
            fail: function(t) {
                console.log("获取地址失败"), wx.getSetting({
                    success: function(t) {
                        t.authSetting["scope.userLocation"] || (console.log("进入信息授权开关页面"), wx.openSetting({
                            success: function(t) {
                                console.log("openSetting success", t.authSetting);
                            }
                        }));
                    }
                });
            }
        });
    },
    chooseIn: function(t) {
        var e = t.currentTarget.dataset.statu, a = t.currentTarget.dataset.index, o = this.data.spec;
        o[a].statu = !e, this.setData({
            spec: o
        });
    },
    updateUserInfo: function(t) {
        console.log("授权操作更新");
        app.wxauthSetting();
    }
});