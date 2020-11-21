var app = getApp();

Page({
    data: {
        array: [],
        index: 0,
        albumSrc: []
    },
    onLoad: function(a) {},
    camera: function() {
        var t = this, e = t.data.albumSrc;
        wx.chooseImage({
            count: 9,
            sizeType: [ "compressed" ],
            sourceType: [ "camera" ],
            success: function(a) {
                a.tempFilePaths;
                e.length < 9 ? e = e.concat(a.tempFilePaths[0]) : wx.showToast({
                    title: "最多上传9张图片",
                    icon: "none",
                    duration: 2e3
                }), t.setData({
                    albumSrc: e
                });
            }
        });
    },
    picture: function() {
        var n = this, o = n.data.albumSrc;
        wx.chooseImage({
            count: 9,
            sizeType: [ "compressed" ],
            sourceType: [ "album" ],
            success: function(a) {
                var t = a.tempFilePaths;
                if (1 == t) o.length < 9 ? o = o.concat(a.tempFilePaths[0]) : wx.showToast({
                    title: "最多上传9张图片",
                    icon: "none",
                    duration: 2e3
                }); else for (var e = 0; e < t.length; e++) o.length < 9 ? o = o.concat(a.tempFilePaths[e]) : wx.showToast({
                    title: "最多上传9张图片",
                    icon: "none",
                    duration: 2e3
                });
                n.setData({
                    albumSrc: o
                }), console.log(o);
            }
        });
    },
    closeitem: function(a) {
        var t = this, e = a.currentTarget.dataset.index, n = t.data.albumSrc;
        wx.showModal({
            title: "提示",
            content: "确定删除吗？",
            success: function(a) {
                a.confirm && (n.splice(e, 1), t.setData({
                    albumSrc: n
                }));
            }
        });
    },
    previewImage: function(a) {
        var t = a.currentTarget.dataset.index, e = this.data.albumSrc;
        wx.previewImage({
            current: e[t],
            urls: e
        });
    },
    bindKeyInput: function(a) {
        this.setData({
            length: a.detail.value.length,
            value: a.detail.value
        });
    },
    bindKeyInput2: function(a) {
        this.setData({
            uname: a.detail.value
        });
    },
    bindKeyInput3: function(a) {
        this.setData({
            uphone: a.detail.value
        });
    },
    uploadimg: function(a, t) {
        var e = this, n = a.i ? a.i : 0, o = a.success ? a.success : 0, i = a.fail ? a.fail : 0;
        console.log(t), wx.uploadFile({
            url: a.url,
            filePath: a.path[n],
            name: "file",
            formData: t,
            success: function(a) {
                1 == a.data && o++, console.log(a), console.log(n);
            },
            fail: function(a) {
                2 == a.data && i++, console.log("fail:" + n + "fail:" + i);
            },
            complete: function() {
                ++n == a.path.length ? (console.log("执行完毕"), wx.hideLoading(), wx.showToast({
                    title: "发布成功！！！",
                    icon: "success",
                    success: function() {
                        e.setData({
                            pics: [],
                            content: "",
                            disabled: !1,
                            sendtitle: "发送"
                        }), app.globalData.aci = "", setTimeout(function() {
                            wx.navigateBack({
                                url: "../circleindex/circleindex"
                            });
                        }, 1500);
                    }
                })) : (a.i = n, a.success = o, a.fail = i, e.uploadimg(a, t));
            }
        });
    },
    send: function() {
        var n = this, t = wx.getStorageSync("users").openid, o = app.util.url("entry/wxapp/Toupload1") + "&m=yzcj_sun", i = n.data.albumSrc;
        null == n.data.value ? wx.showToast({
            title: "内容不得为空！",
            icon: "none",
            duration: 1e3,
            mask: !0
        }) : null == n.data.post_id ? wx.showToast({
            title: "选择帖子类别！",
            icon: "none",
            duration: 1e3,
            mask: !0
        }) : wx.showModal({
            title: "提示",
            content: "确定发送吗？",
            success: function(a) {
                a.confirm && (console.log(1111), wx.showLoading({
                    title: "内容发布中..."
                }), app.util.request({
                    url: "entry/wxapp/SendCircle",
                    data: {
                        openid: t,
                        content: n.data.value,
                        type: n.data.post_id,
                        uname: n.data.uname,
                        uphone: n.data.uphone,
                        addr: n.data.address,
                        latitude: n.data.latitude,
                        longitude: n.data.longitude
                    },
                    success: function(a) {
                        console.log(a.data);
                        var t = a.data;
                        if (0 < i.length) {
                            var e = {
                                id: t
                            };
                            console.log(e), n.uploadimg({
                                url: o,
                                path: i
                            }, e);
                        } else wx.hideLoading(), wx.showToast({
                            title: "发布成功！！！",
                            icon: "success",
                            success: function() {
                                setTimeout(function() {
                                    wx.navigateBack({
                                        url: "../circleindex/circleindex"
                                    });
                                }, 1500);
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
                }));
            }
        });
    },
    onShow: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/CircleType",
            data: {},
            success: function(a) {
                e.data.array = [];
                for (var t = 0; t < a.data.length; t++) e.data.array.push(a.data[t].tname);
                e.setData({
                    array: e.data.array,
                    noDealData_fl: a.data
                });
            }
        });
    },
    bindPickerChange: function(a) {
        console.log("picker发送选择改变，携带值为", a.detail.value);
        var t = this.data.noDealData_fl[a.detail.value].id;
        console.log(t), this.setData({
            post_id: t,
            index: a.detail.value
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    chooseLocation: function() {
        var t = this;
        wx.chooseLocation({
            type: "wgs84 ",
            success: function(a) {
                console.log("获取地址"), console.log(a.address), t.setData({
                    address: a.address,
                    longitude: a.longitude,
                    latitude: a.latitude
                });
            },
            fail: function() {
                console.log(2);
            }
        });
    }
});