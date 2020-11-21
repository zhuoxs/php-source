var app = getApp(), adds = {};

Page({
    data: {
        date: "",
        array: [ "骨科", "耳鼻喉科", "脑外科", "神经科", "妇科", "皮肤科" ],
        index: null,
        hide: !1,
        img_arr: [],
        formdata: "",
        data_arr: [],
        radioIndex: "男"
    },
    radio: function(a) {
        this.setData({
            radioIndex: a.detail.value
        });
    },
    bindDateChange: function(a) {
        this.setData({
            date: a.detail.value
        });
    },
    bindPickerChange: function(a) {
        this.setData({
            index: a.detail.value
        });
    },
    switchChange: function(a) {
        console.log("switch1 发生 change 事件，携带值为", a.detail.value);
    },
    deleteimg: function(a) {
        var t = a.currentTarget.dataset.index, e = this.data.img_arr;
        console.log(e), e.splice(t, 1), this.setData({
            img_arr: e,
            hide: !1
        });
    },
    formSubmit: function(g) {
        if (0 == /13[0123456789]{1}\d{8}|15[0123456789]\d{8}|17[0123456789]\d{8}|18[0123456789]\d{8}/.test(g.detail.value.phone)) wx.showToast({
            title: "手机号码不对",
            image: "/hyb_yl/images/err.png"
        }); else {
            adds = g.detail.value;
            var p = this.data.data_arr;
            console.log(p), this.upload(), wx.showToast({
                title: "上传中，请稍后",
                icon: "loading"
            }), setTimeout(function() {
                var a = g.detail.value, t = wx.getStorageSync("openid"), e = a.keshi, i = a.title_content, o = a.us_jhospital, n = a.us_name, s = a.us_xhospital, l = a.phone, r = a.gender, d = a.age, u = a.time, c = a.us_yibao, h = a.doctorn;
                app.util.request({
                    url: "entry/wxapp/Bingliku",
                    data: {
                        time: u,
                        us_openid: t,
                        keshi: e,
                        title_content: i,
                        us_jhospital: o,
                        us_name: n,
                        us_xhospital: s,
                        us_yibao: c,
                        thumb: p,
                        phone: l,
                        sex: r,
                        age: d,
                        doctorn: h
                    },
                    header: {
                        "Content-Type": "application/json"
                    },
                    success: function(a) {
                        wx.showModal({
                            title: "提交成功",
                            content: "",
                            showCancel: !1,
                            success: function(a) {
                                wx.reLaunch({
                                    url: "/hyb_yl/index/index"
                                });
                            }
                        });
                    },
                    fail: function(a) {
                        console.log(a);
                    }
                });
            }, 3e3);
        }
    },
    onLoad: function() {
        var a = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: a
        }), this.getBase();
        var t = this, e = app.siteInfo.uniacid;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(a) {
                console.log(a), t.setData({
                    url: a.data
                });
            }
        }), t.setData({
            uniacid: e
        });
    },
    getBase: function() {
        var t = this;
        console.log(app), app.util.request({
            url: "entry/wxapp/Base",
            success: function(a) {
                console.log(a), t.setData({
                    show_title: a.data.data.show_title
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    upload: function() {
        var t = this, a = t.data.uniacid, e = t.data.data_arr;
        if (0 == /13[0123456789]{1}\d{8}|15[0123456789]\d{8}|17[0123456789]\d{8}|18[0123456789]\d{8}/.test(adds.phone)) wx.showToast({
            title: "手机号码不对",
            image: "/hyb_yl/images/err.png"
        }); else for (var i = 0; i < this.data.img_arr.length; i++) wx.uploadFile({
            url: t.data.url + "app/index.php?i=" + a + "&c=entry&a=wxapp&do=Upload&m=hyb_yl",
            filePath: t.data.img_arr[i],
            name: "upfile",
            formData: adds,
            success: function(a) {
                console.log(a), e.push(a.data), t.setData({
                    data_arr: e
                });
            }
        });
        this.setData({
            formdata: ""
        });
    },
    upimg: function() {
        var t = this;
        console.log(this.data.img_arr), this.data.img_arr.length < 3 ? wx.chooseImage({
            count: 3,
            sizeType: [ "original", "compressed" ],
            success: function(a) {
                console.log(a), 3 == a.tempFilePaths.length && t.setData({
                    hide: !0
                }), t.setData({
                    img_arr: t.data.img_arr.concat(a.tempFilePaths)
                });
            }
        }) : wx.showToast({
            title: "最多上传三张图片",
            icon: "loading",
            duration: 3e3
        });
    }
});