var app = getApp();

Page({
    data: {
        imgSrc: "",
        array: [ "柚子KTV集美店", "柚子KTV北京店", "柚子KTV巴西店", "柚子KTV日本店" ],
        wineName: "",
        wineNum: "",
        mobile: "",
        userName: "",
        index: ""
    },
    onLoad: function(e) {
        var t = this, a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/buildData",
            cachetime: "0",
            data: {
                openid: a
            },
            success: function(e) {
                console.log(e.data), t.setData({
                    build: e.data.build,
                    num: e.data.wine_num
                });
            }
        });
    },
    imgAdd: function() {
        var a = this;
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                var t = e.tempFilePaths;
                a.uploadimg(t), a.setData({
                    imgSrc: e.tempFilePaths
                });
            }
        });
    },
    uploadimg: function(e) {
        var t = this, a = e, n = app.util.url("entry/wxapp/Toupload1") + "&m=ymktv_sun";
        wx.uploadFile({
            url: n,
            filePath: a[0],
            name: "file",
            success: function(e) {
                t.setData({
                    img: e.data
                });
            }
        });
    },
    bindPickerChange: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value);
        var t = this.data.build[e.detail.value].id;
        this.setData({
            id: t,
            index: e.detail.value
        });
    },
    wineNameInput: function(e) {
        this.setData({
            wineName: e.detail.value
        });
    },
    wineNumInput: function(e) {
        this.setData({
            wineNum: e.detail.value
        });
    },
    userNameInput: function(e) {
        this.setData({
            userName: e.detail.value
        });
    },
    mobileInput: function(e) {
        this.setData({
            mobile: e.detail.value
        });
    },
    submit: function() {
        var e = this, t = e.data.num, a = e.data.mobile, n = e.data.userName, i = e.data.wineName, o = e.data.wineNum, u = e.data.img, s = e.data.id, r = wx.getStorageSync("openid");
        if ("" == u) return wx.showToast({
            title: "图片不能为空",
            icon: "none"
        }), !1;
        if ("" == i) return wx.showToast({
            title: "酒名不能为空",
            icon: "none"
        }), !1;
        if ("" == o) return wx.showToast({
            title: "数量不能为空",
            icon: "none"
        }), !1;
        if ("" == n) return wx.showToast({
            title: "姓名不能为空",
            icon: "none"
        }), !1;
        if ("" == a) return wx.showToast({
            title: "手机号不能为空",
            icon: "none"
        }), !1;
        if (a.length < 11) return wx.showToast({
            title: "手机号长度有误！",
            icon: "none",
            duration: 1500
        }), !1;
        if (null == s) return wx.showToast({
            title: "请选择店名",
            icon: "none",
            duration: 1500
        }), !1;
        if (!/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1}))+\d{8})$/.test(a)) return wx.showToast({
            title: "手机号有误！",
            icon: "none",
            duration: 1500
        }), !1;
        0 <= parseInt(t) - parseInt(o) ? app.util.request({
            url: "entry/wxapp/Savekeepwine",
            cachetime: "0",
            data: {
                mobile: a,
                userName: n,
                wineName: i,
                wineNum: o,
                imgSrc: u,
                id: s,
                openid: r
            },
            success: function(e) {
                1 == e.data ? wx.redirectTo({
                    url: "../wineorder/wineorder"
                }) : wx.showToast({
                    title: "请检查重新提交！",
                    icon: "none",
                    duration: 2e3
                });
            }
        }) : wx.showToast({
            title: "您的存酒数量不够了，亲！",
            icon: "none",
            duration: 2e3
        });
    },
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});