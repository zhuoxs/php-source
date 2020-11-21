var app = getApp();

Page({
    data: {
        navTile: "打卡日记",
        uploadPic: [],
        form_id: "",
        isRequest: 0,
        isIpx: app.globalData.isIpx
    },
    onLoad: function(t) {
        var o = this;
        wx.setNavigationBarTitle({
            title: o.data.navTile
        });
        var a = wx.getStorageSync("setting");
        a ? wx.setNavigationBarColor({
            frontColor: a.fontcolor,
            backgroundColor: a.color
        }) : app.get_setting(!0).then(function(t) {
            wx.setNavigationBarColor({
                frontColor: t.fontcolor,
                backgroundColor: t.color
            });
        }), app.get_imgroot().then(function(t) {
            o.setData({
                imgroot: t
            });
        }), o.setData({
            task_id: t.id
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    toDelete: function(t) {
        var o = this.data.uploadPic, a = t.currentTarget.dataset.index;
        o.splice(a, 1), this.setData({
            uploadPic: o
        });
    },
    formSubmit: function(t) {
        var a = this, e = t.detail.value.content;
        "" == e ? wx.showToast({
            title: "请输入打卡日记",
            icon: "none"
        }) : app.get_openid().then(function(t) {
            if (a.setData({
                isRequest: ++a.data.isRequest
            }), 1 == a.data.isRequest) {
                var o = a.data.uploadPic;
                o = o.toString(), app.util.request({
                    url: "entry/wxapp/setPunchRecord",
                    cachetime: "0",
                    data: {
                        openid: t,
                        task_id: a.data.task_id,
                        punch_diary: e,
                        punch_pic: o
                    },
                    success: function(t) {
                        wx.showToast({
                            title: "打卡成功",
                            duration: 2e3,
                            success: function(t) {
                                wx.navigateBack({});
                            }
                        });
                    },
                    fail: function(t) {
                        wx.showToast({
                            title: t.data.message,
                            icon: "none",
                            duration: 2e3
                        });
                    }
                });
            } else wx.showToast({
                title: "正在请求中...",
                icon: "none"
            });
        });
    },
    uploadPic: function(t) {
        var i = this, s = i.data.uploadPic;
        if (9 <= s.length) wx.showToast({
            title: "最多上传9张图片",
            icon: "loading",
            mask: !0,
            duration: 1e3
        }); else {
            var l = app.util.url() + "&c=entry&a=wxapp&do=upload1&&m=yzqzk_sun";
            console.log(l), wx.chooseImage({
                count: 9,
                sizeType: [ "original", "compressed" ],
                sourceType: [ "album", "camera" ],
                success: function(t) {
                    var a = t.tempFilePaths;
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
                        for (var e = 0, o = 0, n = a.length; o < n; o++) wx.uploadFile({
                            url: l,
                            filePath: a[o],
                            name: "upfile",
                            formData: {
                                upload: "upload"
                            },
                            header: {
                                "Content-Type": "multipart/form-data"
                            },
                            success: function(t) {
                                e++;
                                var o = t.data;
                                s.push(o), i.setData({
                                    uploadPic: s
                                }), e == a.length && wx.hideToast();
                            }
                        });
                    }
                }
            });
        }
    }
});