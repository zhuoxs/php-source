var app = getApp();

Page({
    data: {
        disabled: !1,
        img_arr: [],
        data_arr: []
    },
    chakanimg: function(a) {
        wx.previewImage({
            current: a.currentTarget.dataset.src,
            urls: this.data.info.pic
        });
    },
    upload: function() {
        for (var t = this, a = t.data.uniacid, e = t.data.data_arr, n = 0; n < this.data.img_arr.length; n++) wx.uploadFile({
            url: t.data.url + "app/index.php?i=" + a + "&c=entry&a=wxapp&do=Upload&m=hyb_yl",
            filePath: t.data.img_arr[n],
            name: "upfile",
            formData: [],
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
    },
    formSubmit: function(a) {
        var t = a.detail.value, e = t.dmoney, n = t.rg, o = t.hzid, i = t.zid, r = t.username, s = t.dorder, d = t.docname, c = this.data.data_arr, u = this.data.useropenid;
        this.upload(), wx.showToast({
            title: "上传中，请稍后",
            icon: "loading"
        }), setTimeout(function() {
            "" == a.detail.value.rg ? wx.showToast({
                title: "请填写处方",
                image: "/hyb_yl/images/err.png"
            }) : app.util.request({
                url: "entry/wxapp/Saverecipe",
                data: {
                    userid: o,
                    content: n,
                    docid: i,
                    orderarr: s,
                    username: t.username,
                    pic: c,
                    useropenid: u,
                    docname: d
                },
                success: function(a) {
                    app.util.request({
                        url: "entry/wxapp/Dyjj",
                        data: {
                            username: r,
                            content: n,
                            dmoney: e,
                            docname: d,
                            ky_yibao: s
                        },
                        success: function(a) {}
                    }), wx.showToast({
                        title: "提交成功",
                        icon: "success",
                        duration: 2e3,
                        success: function() {
                            wx.navigateBack({
                                delta: 1
                            });
                        }
                    });
                },
                fail: function(a) {
                    console.log(a);
                }
            });
        }, 3e3);
    },
    onLoad: function(a) {
        var t = this, e = a.username, n = a.ksname, o = a.money, i = a.phone, r = a.tjtime, s = a.yytime, d = a.dorder, c = a.sex, u = a.age, l = a.zjid, p = a.hzid, m = wx.getStorageSync("color"), f = a.cid, g = a.useropenid, h = app.siteInfo.uniacid, y = a.xq;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(a) {
                console.log(a), t.setData({
                    url: a.data
                });
            }
        }), "undefined" !== a.utype && t.setData({
            utype: a.utype
        }), f && app.util.request({
            url: "entry/wxapp/Selcetcfinfo",
            data: {
                cid: f
            },
            success: function(a) {
                console.log(a), t.setData({
                    dorder: a.data.data.orderarr,
                    username: a.data.data.username,
                    sex: a.data.data.mysex,
                    age: a.data.data.myage,
                    phone: a.data.data.myphone,
                    dmoney: a.data.data.dmoney,
                    money: a.data.data.money,
                    content: a.data.data.content,
                    info: a.data.data
                });
            }
        });
        var w = a.z_name;
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: m
        });
        t = this, a.id, a.ky_yibao;
        t.setData({
            username: e,
            ksname: n,
            money: o,
            phone: i,
            tjtime: r,
            yytime: s,
            dorder: d,
            sex: c,
            age: u,
            zjid: l,
            hzid: p,
            z_name: w,
            uniacid: h,
            useropenid: g,
            xq: y
        });
    },
    onReady: function() {
        this.getDocinfo();
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    getDocinfo: function() {
        var t = this, a = t.data.zjid;
        app.util.request({
            url: "entry/wxapp/Docinfo",
            data: {
                zid: a
            },
            success: function(a) {
                console.log(a), t.setData({
                    z_name: a.data.data.z_name
                });
            }
        });
    }
});