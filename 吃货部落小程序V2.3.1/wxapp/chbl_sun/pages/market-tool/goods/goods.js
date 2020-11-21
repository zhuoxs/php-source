function _defineProperty(e, t, a) {
    return t in e ? Object.defineProperty(e, t, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = a, e;
}

var imgArray1 = [], imgArray2 = [], app = getApp();

Page({
    data: {
        items: [ "是", "否" ],
        pics: [],
        picss: [],
        uppic: [],
        uppics: [],
        new_pic: [],
        upnew_pic: []
    },
    onLoad: function(e) {
        var t = this;
        app.util.request({
            url: "entry/wxapp/GetGoodsCate",
            cachetime: "0",
            success: function(e) {
                console.log(e), t.setData({
                    cate: e.data.data
                });
            }
        });
    },
    bindPickerChange: function(e) {
        console.log(e), this.setData({
            index: e.detail.value
        });
    },
    radioChange: function(e) {
        console.log("radio发生change事件，携带value值为：", e.detail.value);
        if ("是" == e.detail.value) var t = 1; else t = 2;
        this.setData({
            is_vip: t
        });
    },
    formTap: function(e) {
        console.log(e);
        var t = this, a = wx.getStorageSync("auth_type"), o = wx.getStorageSync("openid"), i = e.detail.value.gname, n = e.detail.value.shopprice, s = e.detail.value.marketprice, c = e.detail.value.goods_num, l = e.detail.value.goods_volume, p = t.data.is_vip, u = e.detail.value.spec_name, r = e.detail.value.spec_value, d = e.detail.value.spec_names, f = e.detail.value.spec_values, g = t.data.uppic, h = t.data.uppics, m = t.data.upnew_pic;
        if (i) if (n) if (s) if (c) if (l) if (t.data.index) {
            var w = t.data.cate[t.data.index].id;
            w ? g ? h ? m ? wx.showModal({
                title: "提示",
                content: "确认所有信息无误",
                success: function(e) {
                    var t;
                    e.confirm ? (console.log("用户点击确定"), app.util.request({
                        url: "entry/wxapp/ReleaseGoods",
                        cachetime: "0",
                        data: (t = {
                            goods_name: i,
                            goods_price: n,
                            goods_cost: s,
                            goods_num: c
                        }, _defineProperty(t, "goods_cost", s), _defineProperty(t, "goods_volume", l), _defineProperty(t, "is_vip", p), 
                        _defineProperty(t, "cate_id", w), _defineProperty(t, "spec_name", u), _defineProperty(t, "spec_names", d), 
                        _defineProperty(t, "spec_value", r), _defineProperty(t, "spec_values", f), _defineProperty(t, "logo", g), 
                        _defineProperty(t, "banner", h), _defineProperty(t, "goods_details", m), _defineProperty(t, "openid", o), 
                        _defineProperty(t, "auth_type", a), t),
                        success: function(e) {
                            console.log(e), 1 == e.data.data ? (wx.showToast({
                                title: "发布成功！"
                            }), setTimeout(function() {
                                wx.navigateBack({});
                            }, 1500)) : wx.showToast({
                                title: "由于网络原因，发布失败，请重新发布！",
                                icon: "none"
                            });
                        }
                    })) : e.cancel && console.log("用户点击取消");
                }
            }) : wx.showToast({
                title: "请选择商品详情图！",
                icon: "none"
            }) : wx.showToast({
                title: "请选择商品轮播图！",
                icon: "none"
            }) : wx.showToast({
                title: "请选择商品封面图！",
                icon: "none"
            }) : wx.showToast({
                title: "请选择商品分类！",
                icon: "none"
            });
        } else wx.showToast({
            title: "请选择商品分类！",
            icon: "none"
        }); else wx.showToast({
            title: "请输入商品销量！",
            icon: "none"
        }); else wx.showToast({
            title: "请输入商品数量！",
            icon: "none"
        }); else wx.showToast({
            title: "请输入商品售价！",
            icon: "none"
        }); else wx.showToast({
            title: "请输入商品原价！",
            icon: "none"
        }); else wx.showToast({
            title: "请输入商品名称！",
            icon: "none"
        });
    },
    bindTimeChange: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value), "start" == e.currentTarget.dataset.statu ? this.setData({
            stime: e.detail.value
        }) : this.setData({
            etime: e.detail.value
        });
    },
    chooseImage: function() {
        var t = this, a = t.data.pics, o = app.util.url("entry/wxapp/Toupload") + "&m=chbl_sun";
        a.length < 1 ? wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                a = e.tempFilePaths, console.log(a), 0 < a.length && t.uploadimg({
                    url: o,
                    path: a,
                    uppic: ""
                }, ""), t.setData({
                    pics: a
                });
            }
        }) : wx.showToast({
            title: "只允许上传1张图片！！！",
            icon: "none"
        });
    },
    uploadimg: function(t, e) {
        var a = this, o = t.i ? t.i : 0, i = t.success ? t.success : 0, n = t.fail ? t.fail : 0;
        wx.uploadFile({
            url: t.url,
            filePath: t.path[o],
            name: "file",
            formData: e,
            success: function(e) {
                t.uppic = t.uppic.concat(e.data), console.log(t.uppic);
            },
            fail: function(e) {
                2 == e.data && n++, console.log("fail:" + o + "fail:" + n);
            },
            complete: function() {
                ++o == t.path.length ? (console.log("执行完毕"), a.setData({
                    uppic: t.uppic
                })) : (t.i = o, t.success = i, t.fail = n, a.uploadimg(t, e));
            }
        });
    },
    chooseImage1: function() {
        var t = this, a = t.data.picss, o = app.util.url("entry/wxapp/Toupload") + "&m=chbl_sun";
        a.length < 9 ? wx.chooseImage({
            count: 9,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                a = e.tempFilePaths, console.log(a), 0 < a.length && (t.uploadimg1({
                    url: o,
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
    uploadimg1: function(t, e) {
        var a = this, o = t.i ? t.i : 0, i = t.success ? t.success : 0, n = t.fail ? t.fail : 0;
        wx.uploadFile({
            url: t.url,
            filePath: t.path[o],
            name: "file",
            formData: e,
            success: function(e) {
                console.log("这里是上传图片时一起上传的数据"), console.log(e), console.log(t.uppics), t.uppics = t.uppics.concat(e.data), 
                console.log(t.uppics);
            },
            fail: function(e) {
                2 == e.data && n++, console.log("fail:" + o + "fail:" + n);
            },
            complete: function() {
                ++o == t.path.length ? (console.log("执行完毕"), a.setData({
                    uppics: t.uppics
                })) : (t.i = o, t.success = i, t.fail = n, a.uploadimg1(t, e));
            }
        });
    },
    chooseImage2: function() {
        var t = this, a = t.data.new_pic, o = app.util.url("entry/wxapp/Toupload") + "&m=chbl_sun";
        a.length < 9 ? wx.chooseImage({
            count: 9,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                a = e.tempFilePaths, console.log(a), 0 < a.length && (t.uploadimg2({
                    url: o,
                    path: a,
                    new_pic: ""
                }, ""), t.setData({
                    new_pic: a
                }));
            }
        }) : wx.showToast({
            title: "只允许上传9张图片！！！",
            icon: "none"
        });
    },
    uploadimg2: function(t, e) {
        var a = this, o = t.i ? t.i : 0, i = t.success ? t.success : 0, n = t.fail ? t.fail : 0;
        wx.uploadFile({
            url: t.url,
            filePath: t.path[o],
            name: "file",
            formData: e,
            success: function(e) {
                console.log("这里是上传图片时一起上传的数据"), console.log(e), console.log(t.new_pic), t.new_pic = t.new_pic.concat(e.data), 
                console.log(t.new_pic);
            },
            fail: function(e) {
                2 == e.data && n++, console.log("fail:" + o + "fail:" + n);
            },
            complete: function() {
                ++o == t.path.length ? (console.log("执行完毕"), a.setData({
                    upnew_pic: t.new_pic
                })) : (t.i = o, t.success = i, t.fail = n, a.uploadimg2(t, e));
            }
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
    deleteImage2: function(e) {
        var t = this.data.new_pic, a = e.currentTarget.dataset.index;
        t.splice(a, 1), this.setData({
            new_pic: t
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
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});