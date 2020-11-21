var _Page;

function _defineProperty(e, t, a) {
    return t in e ? Object.defineProperty(e, t, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = a, e;
}

var imgArray1 = [], imgArray2 = [], app = getApp();

Page((_defineProperty(_Page = {
    data: {
        items: [ "是", "否" ],
        itemss: [ "是", "否" ],
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
    radioChange1: function(e) {
        console.log("radio发生change事件，携带value值为：", e.detail.value);
        if ("是" == e.detail.value) var t = 1; else t = 2;
        this.setData({
            lowdebuxing: t
        });
    }
}, "bindTimeChange", function(e) {
    console.log("picker发送选择改变，携带值为", e.detail.value), "start" == e.currentTarget.dataset.statu ? this.setData({
        stime: e.detail.value
    }) : this.setData({
        etime: e.detail.value
    });
}), _defineProperty(_Page, "submitForm", function(e) {
    var t = this;
    console.log(e);
    var a = wx.getStorageSync("auth_type"), i = e.detail.value.gname, o = e.detail.value.marketprice, n = e.detail.value.shopprice, s = e.detail.value.gnum, l = e.detail.value.share_title, c = e.detail.value.part_num, u = t.data.is_vip, p = t.data.lowdebuxing, r = e.detail.value.content, g = t.data.stime, d = t.data.etime, f = t.data.uppic;
    console.log(p);
    var h = t.data.uppics, m = t.data.upnew_pic, w = wx.getStorageSync("openid");
    i ? o ? n ? s ? l ? c ? u ? p ? r ? g && d ? 0 != f.length ? 0 != h.length ? 0 != m.length ? wx.showModal({
        title: "提示",
        content: "确认信息填写无误？",
        success: function(e) {
            e.confirm ? app.util.request({
                url: "entry/wxapp/ReleaseBargain",
                cacahetime: "5",
                data: {
                    gname: i,
                    marketprice: o,
                    shopprice: n,
                    gnum: s,
                    share_title: l,
                    part_num: c,
                    is_vip: u,
                    lowdebuxing: p,
                    content: r,
                    starttime: g,
                    endtime: d,
                    pic: f,
                    imgs: h,
                    details: m,
                    openid: w,
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
        title: "请选择是否最低价购买",
        icon: "none"
    }) : wx.showToast({
        title: "请选择是否会员商品",
        icon: "none"
    }) : wx.showToast({
        title: "请输入可参与人数",
        icon: "none"
    }) : wx.showToast({
        title: "请输入分享标题",
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
}), _defineProperty(_Page, "chooseImage", function() {
    var t = this, a = t.data.pics, i = app.util.url("entry/wxapp/Toupload") + "&m=chbl_sun";
    a.length < 1 ? wx.chooseImage({
        count: 1,
        sizeType: [ "original", "compressed" ],
        sourceType: [ "album", "camera" ],
        success: function(e) {
            a = e.tempFilePaths, console.log(a), 0 < a.length && t.uploadimg({
                url: i,
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
}), _defineProperty(_Page, "uploadimg", function(t, e) {
    var a = this, i = t.i ? t.i : 0, o = t.success ? t.success : 0, n = t.fail ? t.fail : 0;
    wx.uploadFile({
        url: t.url,
        filePath: t.path[i],
        name: "file",
        formData: e,
        success: function(e) {
            t.uppic = t.uppic.concat(e.data), console.log(t.uppic);
        },
        fail: function(e) {
            2 == e.data && n++, console.log("fail:" + i + "fail:" + n);
        },
        complete: function() {
            ++i == t.path.length ? (console.log("执行完毕"), a.setData({
                uppic: t.uppic
            })) : (t.i = i, t.success = o, t.fail = n, a.uploadimg(t, e));
        }
    });
}), _defineProperty(_Page, "chooseImage1", function() {
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
}), _defineProperty(_Page, "uploadimg1", function(t, e) {
    var a = this, i = t.i ? t.i : 0, o = t.success ? t.success : 0, n = t.fail ? t.fail : 0;
    wx.uploadFile({
        url: t.url,
        filePath: t.path[i],
        name: "file",
        formData: e,
        success: function(e) {
            console.log("这里是上传图片时一起上传的数据"), console.log(e), console.log(t.uppics), t.uppics = t.uppics.concat(e.data), 
            console.log(t.uppics);
        },
        fail: function(e) {
            2 == e.data && n++, console.log("fail:" + i + "fail:" + n);
        },
        complete: function() {
            ++i == t.path.length ? (console.log("执行完毕"), a.setData({
                uppics: t.uppics
            })) : (t.i = i, t.success = o, t.fail = n, a.uploadimg1(t, e));
        }
    });
}), _defineProperty(_Page, "chooseImage2", function() {
    var t = this, a = t.data.new_pic, i = app.util.url("entry/wxapp/Toupload") + "&m=chbl_sun";
    a.length < 9 ? wx.chooseImage({
        count: 9,
        sizeType: [ "original", "compressed" ],
        sourceType: [ "album", "camera" ],
        success: function(e) {
            a = e.tempFilePaths, console.log(a), 0 < a.length && (t.uploadimg2({
                url: i,
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
}), _defineProperty(_Page, "uploadimg2", function(t, e) {
    var a = this, i = t.i ? t.i : 0, o = t.success ? t.success : 0, n = t.fail ? t.fail : 0;
    wx.uploadFile({
        url: t.url,
        filePath: t.path[i],
        name: "file",
        formData: e,
        success: function(e) {
            console.log("这里是上传图片时一起上传的数据"), console.log(e), console.log(t.new_pic), t.new_pic = t.new_pic.concat(e.data), 
            console.log(t.new_pic);
        },
        fail: function(e) {
            2 == e.data && n++, console.log("fail:" + i + "fail:" + n);
        },
        complete: function() {
            ++i == t.path.length ? (console.log("执行完毕"), a.setData({
                upnew_pic: t.new_pic
            })) : (t.i = i, t.success = o, t.fail = n, a.uploadimg2(t, e));
        }
    });
}), _defineProperty(_Page, "deleteImage", function(e) {
    var t = this.data.pics, a = e.currentTarget.dataset.index;
    t.splice(a, 1), this.setData({
        pics: t
    });
}), _defineProperty(_Page, "deleteImage1", function(e) {
    var t = this.data.picss, a = e.currentTarget.dataset.index;
    t.splice(a, 1), this.setData({
        picss: t
    });
}), _defineProperty(_Page, "deleteImage2", function(e) {
    var t = this.data.new_pic, a = e.currentTarget.dataset.index;
    t.splice(a, 1), this.setData({
        new_pic: t
    });
}), _defineProperty(_Page, "previewImage", function(e) {
    console.log(e);
    var t = e.currentTarget.dataset.index, a = e.currentTarget.dataset.list;
    wx.previewImage({
        current: a[t],
        urls: a
    });
}), _defineProperty(_Page, "onReady", function() {}), _defineProperty(_Page, "onShow", function() {}), 
_defineProperty(_Page, "onHide", function() {}), _defineProperty(_Page, "onUnload", function() {}), 
_defineProperty(_Page, "onPullDownRefresh", function() {}), _defineProperty(_Page, "onReachBottom", function() {}), 
_Page));