var app = getApp(), template = require("../template/template.js"), imgArray1 = [], image = "";

Page({
    data: {
        showNotes: !1,
        currentTab: 0,
        pics: [],
        class_tz: [],
        state: !0,
        post_id: ""
    },
    address: "",
    latitude: "",
    longitude: "",
    onLoad: function(t) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Url",
            success: function(t) {
                console.log("页面加载请求"), console.log(t), wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/system",
            success: function(t) {
                console.log("****************************"), console.log(t), wx.setStorageSync("system", t.data), 
                e.setData({
                    is_zx: t.data.is_zx
                }), wx.setNavigationBarColor({
                    frontColor: t.data.color,
                    backgroundColor: t.data.fontcolor,
                    animation: {
                        timingFunc: "easeIn"
                    }
                });
            }
        });
        var a = wx.getStorageSync("openid");
        e.diyWinColor(), app.util.request({
            url: "entry/wxapp/User_id",
            data: {
                openid: a
            },
            success: function(t) {
                console.log("查看用户id"), console.log(t), e.setData({
                    comment_xqy: t.data
                }), wx.setStorageSync("id", t.data.id);
            }
        }), app.util.request({
            url: "entry/wxapp/Custom_photo",
            success: function(t) {
                console.log("自定义数据显示"), console.log(t.data);
                var a = wx.getStorageSync("url");
                template.tabbar("tabBar", 2, e, t, a);
            }
        }), app.util.request({
            url: "entry/wxapp/Post_tz",
            success: function(t) {
                console.log("帖子分类数据"), console.log(t);
                for (var a = 0; a < t.data.length; a++) e.data.class_tz.push(t.data[a].post_name), 
                console.log(e.data.class_tz);
                console.log(e.data.class_tz), e.setData({
                    class_tz: e.data.class_tz,
                    noDealData_fl: t.data
                });
            }
        });
    },
    bindPickerChange: function(t) {
        console.log("picker发送选择改变，携带值为", t.detail.value), console.log(t);
        var a = this.data.noDealData_fl[t.detail.value].id;
        console.log(a), this.setData({
            index_qx: t.detail.value,
            post_id: a,
            classIndex: t.detail.value
        });
    },
    chooseImage: function() {
        var a = this, e = a.data.pics;
        e.length < 9 ? wx.chooseImage({
            count: 9 - e.length,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(t) {
                e = e.concat(t.tempFilePaths), console.log("1111111111111"), console.log(e), a.setData({
                    pics: e
                });
            }
        }) : wx.showToast({
            title: "只允许上传9张图片！！！",
            icon: "none"
        });
    },
    uploadimg: function(t, a) {
        var e = this, o = t.i ? t.i : 0, s = t.success ? t.success : 0, n = t.fail ? t.fail : 0;
        console.log(a), wx.uploadFile({
            url: t.url,
            filePath: t.path[o],
            name: "file",
            formData: a,
            success: function(t) {
                1 == t.data && s++, console.log(t), console.log(o);
            },
            fail: function(t) {
                2 == t.data && n++, console.log("fail:" + o + "fail:" + n);
            },
            complete: function() {
                ++o == t.path.length ? (console.log("执行完毕"), wx.hideLoading(), wx.showToast({
                    title: "发布成功！！！",
                    icon: "success",
                    success: function() {
                        e.setData({
                            pics: [],
                            content: "",
                            disabled: !1,
                            sendtitle: "发送"
                        }), app.globalData.aci = "", setTimeout(function() {
                            wx.reLaunch({
                                url: "../circle/circle"
                            });
                        }, 2e3);
                    }
                })) : (t.i = o, t.success = s, t.fail = n, e.uploadimg(t, a));
            }
        });
    },
    publish: function(t) {
        console.log("表单数据"), console.log(t);
        t.detail.value;
        var o = this;
        o.setData({
            state: !1
        });
        var s = app.util.url("entry/wxapp/Toupload") + "&m=yzkm_sun", n = o.data.pics;
        console.log("表单上传的图片数据"), console.log(n), wx.showLoading({
            title: "内容发布中，请稍后...",
            mask: !0
        });
        var a = wx.getStorageSync("id");
        return o.setData({
            disabled: !0,
            sendtitle: "稍后"
        }), "" == t.detail.value.content ? (wx.showToast({
            title: "发布内容不能为空",
            icon: "none"
        }), !1) : "" == t.detail.value.post_tzfl ? (wx.showToast({
            title: "帖子类别不能为空",
            icon: "none"
        }), !1) : void app.util.request({
            url: "entry/wxapp/Addtalentcircle",
            cachetime: "0",
            data: {
                latitude: o.data.latitude,
                longitude: o.data.longitude,
                post_id: o.data.post_id,
                uimg: n,
                name: t.detail.value.name,
                tel: t.detail.value.tel,
                id: a,
                content: t.detail.value.content,
                address: t.detail.value.address,
                state: o.data.is_zx
            },
            success: function(t) {
                console.log("发布数据请求"), console.log(t.data);
                var a = t.data;
                if (0 < n.length) {
                    var e = {
                        tcid: a
                    };
                    console.log("2222222222222222"), console.log(a), o.uploadimg({
                        url: s,
                        path: n
                    }, e);
                } else wx.hideLoading(), wx.showToast({
                    title: "发布成功！！！",
                    icon: "success",
                    success: function() {
                        wx.reLaunch({
                            url: "../circle/circle"
                        });
                    }
                });
            },
            fail: function() {
                o.setData({
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
    },
    deleteImage: function(t) {
        var a = this.data.pics, e = t.currentTarget.dataset.index;
        a.splice(e, 1), this.setData({
            pics: a
        });
    },
    add: function() {
        var a = this;
        wx.chooseLocation({
            type: "wgs84 ",
            success: function(t) {
                console.log("获取地址"), console.log(t), a.setData({
                    address: t.address,
                    longitude: t.longitude,
                    latitude: t.latitude
                });
            }
        });
    },
    previewImage: function(t) {
        console.log(t);
        var a = t.currentTarget.dataset.index, e = t.currentTarget.dataset.list;
        wx.previewImage({
            current: e[a],
            urls: e
        });
    },
    diyWinColor: function(t) {
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: "#ffb62b"
        }), wx.setNavigationBarTitle({
            title: "发布"
        });
    },
    bindChange: function(t) {
        this.setData({
            currentTab: t.detail.current
        });
    },
    swichNav: function(t) {
        if (this.data.currentTab === t.target.dataset.current) return !1;
        this.setData({
            currentTab: t.target.dataset.current
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    bindNotesTap: function(t) {
        var a = this, e = t.currentTarget.dataset.statu;
        app.util.request({
            url: "entry/wxapp/Fabu_xz",
            success: function(t) {
                console.log("查看发布需知"), console.log(t), a.setData({
                    fabu_xz: t.data.releaseneeds
                });
            }
        }), a.util(e), console.log(t);
    },
    close: function(t) {
        var a = t.currentTarget.dataset.statu;
        this.util(a);
    },
    util: function(t) {
        var a = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = a).opacity(0).height(0).step(), this.setData({
            animationData: a.export()
        }), setTimeout(function() {
            a.opacity(1).height("630rpx").step(), this.setData({
                animationData: a
            }), "close" == t && this.setData({
                showNotes: !1
            });
        }.bind(this), 200), "open" == t && this.setData({
            showNotes: !0
        });
    }
});