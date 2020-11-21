var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(a) {
    return typeof a;
} : function(a) {
    return a && "function" == typeof Symbol && a.constructor === Symbol && a !== Symbol.prototype ? "symbol" : typeof a;
}, app = getApp(), adds = {};

Page({
    data: {
        array: [ "男", "女" ],
        index: "",
        current: 0,
        date: "",
        date1: "",
        date2: "",
        relative: [ {
            names: "name_0",
            types: "types_0",
            phones: "phones_0"
        } ],
        array1: [],
        array2: [],
        index2: 0,
        index1: "",
        imgArr: [],
        imgArr1: [],
        img_arr: [],
        data_arr: [],
        lianxiren: []
    },
    onLoad: function(a) {
        var t = this, e = wx.getStorageSync("color"), i = app.siteInfo.uniacid, n = wx.getStorageSync("openid");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: e
        }), app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(a) {
                console.log(a), t.setData({
                    url: a.data
                });
            }
        }), t.setData({
            backgroundColor: e,
            uniacid: i,
            openid: n
        });
    },
    bindPickerChange: function(a) {
        console.log("picker发送选择改变，携带值为", a.detail.value), this.setData({
            index: a.detail.value
        });
    },
    bindPickerChange2: function(a) {
        console.log("picker发送选择改变，携带值为", a.detail.value);
        var t = this.data.array_fid;
        console.log(t);
        var e = t[a.detail.value].fid;
        console.log(e), this.setData({
            index1: a.detail.value,
            fid: e
        });
    },
    bindDateChange1: function(a) {
        console.log("picker发送选择改变，携带值为", a.detail.value), this.setData({
            date1: a.detail.value
        });
    },
    bindDateChange: function(a) {
        console.log("picker发送选择改变，携带值为", a.detail.value), this.setData({
            date: a.detail.value
        });
    },
    bindDateChange2: function(a) {
        console.log("picker发送选择改变，携带值为", a.detail.value), this.setData({
            date2: a.detail.value
        });
    },
    nextClick: function() {
        this.setData({
            current: 1
        });
    },
    nextClick2: function() {
        this.setData({
            current: 2
        });
    },
    nextClick3: function() {
        this.setData({
            current: 3
        });
    },
    lastClick: function() {
        this.setData({
            current: 0
        });
    },
    lastClick2: function() {
        this.setData({
            current: 0
        });
    },
    lastClick3: function() {
        this.setData({
            current: 1
        });
    },
    lastClick4: function() {
        this.setData({
            current: 2
        });
    },
    add: function(a) {
        var t = this.data.relative, e = t.length, i = {};
        i.names = "names_" + e, i.types = "types_" + e, i.phones = "phones_" + e, t.push(i), 
        this.setData({
            relative: t
        });
    },
    chooseImgArr: function() {
        var t = this;
        console.log(this.data.img_arr), this.data.img_arr.length < 4 ? wx.chooseImage({
            count: 4,
            sizeType: [ "original", "compressed" ],
            success: function(a) {
                console.log(a), 4 == a.tempFilePaths.length && t.setData({
                    hide: !0
                }), t.setData({
                    img_arr: t.data.img_arr.concat(a.tempFilePaths)
                });
            }
        }) : wx.showToast({
            title: "最多上传四张图片",
            icon: "loading",
            duration: 3e3
        });
    },
    del: function(a) {
        var t = a.currentTarget.dataset.index, e = this.data.img_arr;
        e.splice(t, 1), this.setData({
            imgArr: e
        });
    },
    onReady: function() {
        this.getFwleix();
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    inputClick10: function(a) {
        var t = this.data.lianxiren, e = a.currentTarget.dataset.index;
        if (console.log(_typeof(t[e])), "object" == _typeof(t[e])) t[e].names = a.detail.value; else {
            var i = {};
            i.names = a.detail.value, t[e] = i;
        }
        this.setData({
            lianxiren: t
        });
    },
    inputClick11: function(a) {
        var t = this.data.lianxiren, e = a.currentTarget.dataset.index;
        if ("object" == _typeof(t[e])) t[e].types = a.detail.value; else {
            var i = {};
            i.types = a.detail.value, t[e] = i;
        }
        this.setData({
            lianxiren: t
        });
    },
    inputClick12: function(a) {
        var t = this.data.lianxiren, e = a.currentTarget.dataset.index;
        if ("object" == _typeof(t[e])) t[e].phones = a.detail.value; else {
            var i = {};
            i.phones = a.detail.value, t[e] = i;
        }
        this.setData({
            lianxiren: t
        });
    },
    subClick: function(a) {
        console.log(a);
        var t = this.data.fid, e = a.detail.formId, i = wx.getStorageSync("openid"), n = a.detail.value;
        adds = a.detail.value;
        var o = a.detail.target.dataset.index, r = this.data.data_arr, s = this.data.lianxiren;
        [].push(s), n.lianxi = s, console.log(n), 1 == o && (console.log(r), this.upload(), 
        wx.showToast({
            title: "上传中，请稍后",
            icon: "loading"
        }), setTimeout(function() {
            app.util.request({
                url: "entry/wxapp/Inseruser",
                data: {
                    value: n,
                    data_arr: r,
                    fid: t
                },
                success: function(a) {
                    app.util.request({
                        url: "entry/wxapp/QQemail",
                        data: {
                            cyname: n.cyname,
                            phone: n.uerPhone
                        },
                        success: function(a) {
                            console.log(a);
                        }
                    });
                }
            });
        }, 3e3)), app.util.request({
            url: "entry/wxapp/UserFormId",
            data: {
                form_id: e,
                openid: i
            },
            success: function(a) {}
        });
    },
    upload: function() {
        for (var t = this, a = t.data.uniacid, e = t.data.data_arr, i = 0; i < this.data.img_arr.length; i++) wx.uploadFile({
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
    getFwleix: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Fwleix",
            success: function(a) {
                console.log(a.data.data), t.setData({
                    array1: a.data.data.fwname,
                    array_fid: a.data.data
                });
            }
        });
    }
});