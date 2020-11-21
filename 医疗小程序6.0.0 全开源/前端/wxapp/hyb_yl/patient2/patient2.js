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
        relative: [],
        array1: [],
        array2: [ "" ],
        index2: "",
        index1: "",
        imgArr: [],
        imgArr1: [],
        img_arr: [],
        data_arr: [],
        lianxiren: []
    },
    onLoad: function(a) {
        var t = this, e = wx.getStorageSync("color"), i = a.lpid, n = app.siteInfo.uniacid, o = wx.getStorageSync("openid");
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
            uniacid: n,
            openid: o,
            lpid: i
        });
    },
    bindPickerChange: function(a) {
        console.log("picker发送选择改变，携带值为", a.detail.value), this.setData({
            index: a.detail.value
        });
    },
    bindPickerChange1: function(a) {
        console.log("picker发送选择改变，携带值为", a.detail.value), this.setData({
            index1: a.detail.value
        });
    },
    bindPickerChange2: function(a) {
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
        i.names1 = "names_" + e, i.types1 = "types_" + e, i.phones1 = "phones_" + e, t.push(i), 
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
        this.getFwleix(), this.getOne();
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
        var t = a.detail.formId, e = wx.getStorageSync("openid"), i = a.detail.value;
        adds = a.detail.value;
        var n = a.detail.target.dataset.index, o = this.data.data_arr, r = this.data.lianxiren;
        [].push(r), i.lianxi = r, console.log(i), 1 == n && (console.log(o), this.upload(), 
        wx.showToast({
            title: "上传中，请稍后",
            icon: "loading"
        }), setTimeout(function() {
            app.util.request({
                url: "entry/wxapp/Inseruser",
                data: {
                    value: i,
                    data_arr: o
                },
                success: function(a) {
                    app.util.request({
                        url: "entry/wxapp/QQemail",
                        data: {
                            cyname: i.cyname,
                            phone: i.uerPhone
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
                form_id: t,
                openid: e
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
    getOne: function() {
        var n = this, a = n.data.lpid;
        app.util.request({
            url: "entry/wxapp/Alonelip",
            data: {
                lpid: a
            },
            success: function(a) {
                console.log(a);
                var t = n.data.array1;
                console.log(t);
                for (var e = 0; e < t.length; e++) if (t[e] == a.data.data.fwname) var i = e;
                n.setData({
                    alone: a.data.data,
                    relative: a.data.data.name_0,
                    lianxiren: a.data.data.name_0,
                    img_arr: a.data.data.userpic,
                    index: a.data.data.sex,
                    date1: a.data.data.date1,
                    date2: a.data.data.date2,
                    date: a.data.data.date,
                    index1: i
                });
            }
        });
    },
    getFwleix: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Fwleix",
            success: function(a) {
                console.log(a.data.data.fwname), t.setData({
                    array1: a.data.data.fwname,
                    array_fid: a.data.data
                });
            }
        });
    }
});