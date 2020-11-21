var app = getApp();

Page({
    data: {
        navTile: "发布",
        uploadPic: [],
        choose_gid: 0,
        choose_gname: "商品名称",
        isIpx: app.globalData.isIpx
    },
    onLoad: function(o) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: this.data.navTile
        });
        var t = wx.getStorageSync("url");
        this.setData({
            url: t
        });
    },
    onReady: function() {},
    onShow: function() {
        var o = wx.getStorageSync("goodsChoose_gid"), t = wx.getStorageSync("goodsChoose_gname");
        0 < o && this.setData({
            choose_gid: o
        }), "" != t && this.setData({
            choose_gname: t
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    formSubmit: function(o) {
        var t = o.detail.value.content, a = this.data.uploadPic, e = this.data.choose_gid;
        console.log(a), "" == t ? wx.showToast({
            title: "请输入发布内容",
            icon: "none"
        }) : (console.log("开始提交表单"), a = a.toString(), app.util.request({
            url: "entry/wxapp/setDynamic",
            cachetime: "0",
            data: {
                content: t,
                imgs: a,
                gid: e
            },
            success: function(o) {
                wx.showToast({
                    title: "发布成功",
                    icon: "success",
                    duration: 2e3,
                    success: function() {},
                    complete: function() {
                        wx.navigateTo({
                            url: "../../active/active"
                        });
                    }
                });
            }
        }));
    },
    uploadPic: function(o) {
        var i = this, s = i.data.uploadPic;
        if (9 <= s.length) wx.showToast({
            title: "最多上传9张图片",
            icon: "loading",
            mask: !0,
            duration: 1e3
        }); else {
            var c = app.util.url() + "&c=entry&a=wxapp&do=upload1&&m=yzmdwsc_sun";
            console.log(c), wx.chooseImage({
                count: 9,
                sizeType: [ "original", "compressed" ],
                sourceType: [ "album", "camera" ],
                success: function(o) {
                    var a = o.tempFilePaths;
                    if (9 < s.length + a.length) wx.showToast({
                        title: "最多上传9张图片",
                        icon: "loading",
                        mask: !0,
                        duration: 1e3
                    }); else {
                        console.log("测试中"), console.log(a), wx.showToast({
                            title: "正在上传...",
                            icon: "loading",
                            mask: !0,
                            duration: 1e4
                        });
                        for (var e = 0, t = 0, n = a.length; t < n; t++) wx.uploadFile({
                            url: c,
                            filePath: a[t],
                            name: "upfile",
                            formData: {
                                upload: "upload"
                            },
                            header: {
                                "Content-Type": "multipart/form-data"
                            },
                            success: function(o) {
                                e++;
                                var t = o.data;
                                s.push(t), i.setData({
                                    uploadPic: s
                                }), e == a.length && wx.hideToast();
                            }
                        });
                    }
                }
            });
        }
    },
    toGoodslist: function(o) {
        wx.navigateTo({
            url: "../goodslist/goodslist"
        });
    },
    toIndex: function(o) {
        wx.redirectTo({
            url: "../index/index"
        });
    },
    toSet: function(o) {
        wx.redirectTo({
            url: "../set/set"
        });
    }
});