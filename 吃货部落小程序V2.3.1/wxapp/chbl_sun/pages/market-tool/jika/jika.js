var _Page;

function _defineProperty(e, t, a) {
    return t in e ? Object.defineProperty(e, t, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = a, e;
}

var app = getApp(), imgArray1 = [], imgArray2 = [];

Page((_defineProperty(_Page = {
    data: {
        items: [ "是", "否" ],
        pics: [],
        picss: [],
        uppic: [],
        uppics: []
    },
    onLoad: function(e) {},
    bindSave: function(e) {
        console.log(e);
        var t = wx.getStorageSync("auth_type"), a = this.data.uppic, i = this.data.uppics, n = e.detail.value.title, o = e.detail.value.subtitle, c = e.detail.value.content, s = e.detail.value.active_num, l = e.detail.value.antime, u = e.detail.value.astime, p = e.detail.value.num, r = e.detail.value.share_plus, d = e.detail.value.sharenum, g = wx.getStorageSync("openid");
        n && o && c && s && p && r && d && a && i && u && l ? l <= u ? wx.showToast({
            title: "开始时间不得大于结束时间",
            icon: "none"
        }) : wx.showModal({
            title: "提示",
            content: "信息已填写完整，是否进行下一步？(此操作不可退回)",
            confirmText: "下一步",
            cancelText: "再看看",
            success: function(e) {
                e.confirm ? app.util.request({
                    url: "entry/wxapp/ReleaseActive",
                    cachetime: "30",
                    data: {
                        openid: g,
                        title: n,
                        subtitle: o,
                        content: c,
                        active_num: s,
                        antime: l,
                        astime: u,
                        num: p,
                        share_plus: r,
                        sharenum: d,
                        uppic: a,
                        uppics: i,
                        auth_type: t
                    },
                    success: function(e) {
                        console.log(e), wx.setStorageSync("collecting_id", e.data.data), wx.redirectTo({
                            url: "../../add-activity/details"
                        });
                    }
                }) : e.cancel && console.log("用户点击取消");
            }
        }) : wx.showToast({
            title: "请填写完整信息！",
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
    uploadimg: function(t, e) {
        var a = this, i = t.i ? t.i : 0, n = t.success ? t.success : 0, o = t.fail ? t.fail : 0;
        wx.uploadFile({
            url: t.url,
            filePath: t.path[i],
            name: "file",
            formData: e,
            success: function(e) {
                t.uppic = t.uppic.concat(e.data);
            },
            fail: function(e) {
                2 == e.data && o++, console.log("fail:" + i + "fail:" + o);
            },
            complete: function() {
                ++i == t.path.length ? (console.log("执行完毕"), a.setData({
                    uppic: t.uppic
                })) : (t.i = i, t.success = n, t.fail = o, a.uploadimg(t, e));
            }
        });
    },
    chooseImage: function() {
        var t = this, a = t.data.pics, i = app.util.url("entry/wxapp/Toupload") + "&m=chbl_sun";
        a.length < 1 ? wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                0 < (a = e.tempFilePaths).length && t.uploadimg({
                    url: i,
                    path: a,
                    uppic: ""
                }, ""), console.log(a), t.setData({
                    pics: a
                });
            }
        }) : wx.showToast({
            title: "只允许上传1张图片！！！",
            icon: "none"
        });
    },
    uploadimg1: function(t, e) {
        console.log("-------------进入商家上传---------");
        var a = this, i = t.i ? t.i : 0, n = t.success ? t.success : 0, o = t.fail ? t.fail : 0;
        wx.uploadFile({
            url: t.url,
            filePath: t.path[i],
            name: "file",
            formData: e,
            success: function(e) {
                console.log("返回的图"), console.log(e.data), t.uppics = t.uppics.concat(e.data);
            },
            fail: function(e) {
                2 == e.data && o++, console.log("fail:" + i + "fail:" + o);
            },
            complete: function() {
                ++i == t.path.length ? (console.log("执行完毕"), console.log(t.uppics), a.setData({
                    uppics: t.uppics
                })) : (t.i = i, t.success = n, t.fail = o, a.uploadimg1(t, e));
            }
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
    previewImage: function(e) {
        console.log(e);
        var t = e.currentTarget.dataset.index, a = e.currentTarget.dataset.list;
        wx.previewImage({
            current: a[t],
            urls: a
        });
    }
}, "previewImage", function(e) {
    console.log(e);
    var t = e.currentTarget.dataset.index, a = e.currentTarget.dataset.list;
    wx.previewImage({
        current: a[t],
        urls: a
    });
}), _defineProperty(_Page, "onReady", function() {}), _defineProperty(_Page, "onShow", function() {}), 
_defineProperty(_Page, "onHide", function() {}), _defineProperty(_Page, "onUnload", function() {}), 
_defineProperty(_Page, "onPullDownRefresh", function() {}), _defineProperty(_Page, "onReachBottom", function() {}), 
_defineProperty(_Page, "onShareAppMessage", function() {}), _Page));