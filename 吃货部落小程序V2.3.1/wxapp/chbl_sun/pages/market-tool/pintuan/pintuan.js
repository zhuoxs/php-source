var app = getApp(), imgArray1 = [], imgArray2 = [];

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
    onLoad: function(e) {},
    bindTimeChange: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value), "start" == e.currentTarget.dataset.statu ? this.setData({
            stime: e.detail.value
        }) : this.setData({
            etime: e.detail.value
        });
    },
    radioChange: function(e) {
        console.log("radio发生change事件，携带value值为：", e.detail.value);
        if ("是" == e.detail.value) var t = 1; else t = 2;
        this.setData({
            is_vip: t
        });
    },
    submitForm: function(e) {
        var t = this, a = wx.getStorageInfoSync("auth_type");
        console.log(e);
        var o = e.detail.value.gname, i = e.detail.value.marketprice, n = e.detail.value.shopprice, s = e.detail.value.num, c = e.detail.value.groups_num, l = t.data.is_vip, u = e.detail.value.content, p = t.data.stime, r = t.data.etime, g = t.data.uppic, h = t.data.uppics, d = t.data.upnew_pic, m = wx.getStorageSync("openid");
        o ? i ? n ? s ? c ? l ? u ? p && r ? 0 != g.length ? 0 != h.length ? 0 != d.length ? wx.showModal({
            title: "提示",
            content: "确认信息填写无误？",
            success: function(e) {
                e.confirm ? app.util.request({
                    url: "entry/wxapp/ReleaseGroups",
                    cacahetime: "5",
                    data: {
                        gname: o,
                        marketprice: i,
                        shopprice: n,
                        num: s,
                        groups_num: c,
                        is_vip: l,
                        content: u,
                        starttime: p,
                        endtime: r,
                        pic: g,
                        imgs: h,
                        details: d,
                        openid: m,
                        auth_type: a
                    },
                    success: function(e) {
                        console.log(e), 1 == e.data ? (wx.showToast({
                            title: "发布成功"
                        }), setTimeout(function() {
                            console.log("返回上一个页面"), wx.navigateBack({});
                        }, 2e3)) : wx.showToast({
                            title: "发布失败"
                        });
                    }
                }) : e.cancel && console.log("用户点击取消");
            }
        }) : wx.showToast({
            title: "请输入商品详情图",
            icon: "none"
        }) : wx.showToast({
            title: "请选择商家轮播图",
            icon: "none"
        }) : wx.showToast({
            title: "请选择商品封面图",
            icon: "none"
        }) : wx.showToast({
            title: "请活动开始时间或结束时间",
            icon: "none"
        }) : wx.showToast({
            title: "请输入砍价说明",
            icon: "none"
        }) : wx.showToast({
            title: "请选择是否会员商品",
            icon: "none"
        }) : wx.showToast({
            title: "请输入拼团人数",
            icon: "none"
        }) : wx.showToast({
            title: "请输入商品数量",
            icon: "none"
        }) : wx.showToast({
            title: "请输入最低价格",
            icon: "none"
        }) : wx.showToast({
            title: "请输入商品原价",
            icon: "none"
        }) : wx.showToast({
            title: "请输入商品名称",
            icon: "none"
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