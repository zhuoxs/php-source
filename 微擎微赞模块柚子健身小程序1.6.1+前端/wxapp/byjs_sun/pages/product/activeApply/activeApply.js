var app = getApp();

Page({
    data: {
        isLimit: !1,
        activeType: [ "类别1", "类别2" ],
        activeTime: [ "10:00-12:00", "13:00-15:00" ],
        activeAddr: [ "地点1", "地点2" ],
        sex: [ "男", "女" ],
        sexIndex: 0,
        uploadImg: [],
        date: "",
        startTime: "",
        endTime: "",
        date2: "",
        imgSrc: ""
    },
    onLoad: function(t) {
        var e = this, a = new Date(), i = a.getFullYear() + "-" + e.filertNum(a.getMonth() + 1) + "-" + e.filertNum(a.getDate()), n = a.getFullYear() + 3 + "-" + e.filertNum(a.getMonth() + 1) + "-" + e.filertNum(a.getDate());
        e.setData({
            startTime: i,
            endTime: n
        });
        var s = t.avatar;
        if (s) {
            var u = app.util.url("entry/wxapp/Toupload123") + "&m=byjs_sun";
            wx.uploadFile({
                url: u,
                filePath: s,
                name: "file",
                success: function(t) {
                    console.log(t), e.setData({
                        pic: t.data
                    });
                }
            }), this.setData({
                imgSrc: s
            });
        }
    },
    filertNum: function(t) {
        return t < 10 ? "0" + t : t;
    },
    onReady: function() {},
    onShow: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/getActivify",
            cachetime: "0",
            success: function(t) {
                e.setData({
                    activeType: t.data.type,
                    status: t.data.status
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    bindPickerChange: function(t) {
        this.setData({
            typeIndex: t.detail.value
        });
    },
    bindDateChange: function(t) {
        this.setData({
            date: t.detail.value
        });
    },
    bindDateChange2: function(t) {
        this.setData({
            date2: t.detail.value
        });
    },
    bindPickerChangeAddr: function(t) {
        this.setData({
            addrIndex: t.detail.value
        });
    },
    bindPickerChangeSex: function(t) {
        this.setData({
            sexIndex: t.detail.value
        });
    },
    bindPickerTime: function(t) {
        this.setData({
            timeIndex: t.detail.value
        });
    },
    bindTimeChange: function(t) {
        this.setData({
            time: t.detail.value
        });
    },
    switchChange: function(t) {
        this.setData({
            isLimit: t.detail.value
        });
    },
    toMap: function(t) {
        var e = this;
        wx.chooseLocation({
            type: "wgs84 ",
            success: function(t) {
                console.log("获取地址"), console.log(t.address), e.setData({
                    address: t.address,
                    longitude: t.longitude,
                    latitude: t.latitude
                });
            },
            fail: function() {
                console.log(2);
            }
        });
    },
    upload: function() {
        var i = this, n = app.util.url("entry/wxapp/Toupload") + "&m=yzcj_sun";
        wx.chooseImage({
            count: 1,
            sizeType: [ "compressed" ],
            sourceType: [ "album" ],
            success: function(t) {
                var e = t.tempFilePaths, a = i.data.imgSrc;
                a = e, console.log(a), i.setData({
                    imgSrc: a
                }), wx.uploadFile({
                    url: n,
                    filePath: i.data.imgSrc[0],
                    name: "file",
                    formData: {},
                    success: function(t) {
                        console.log(t), i.setData({
                            pic: t.data
                        });
                    }
                });
            }
        });
    },
    formSubmit: function(t) {
        var e = this, a = wx.getStorageSync("users").id, i = !0, n = "", s = t.detail.value.activename, u = t.detail.value.activetype, l = t.detail.value.time, o = t.detail.value.starttime, d = t.detail.value.endtime, c = t.detail.value.addr, r = (e.data.isLimit, 
        t.detail.value.usernum), m = t.detail.value.money, p = t.detail.value.content, f = t.detail.value.uname, g = t.detail.value.tel;
        e.data.sex[e.data.sexIndex];
        "" == s ? n = "请输入活动名称" : "" == u ? n = "请选择活动类别" : "" == l ? n = "请选择活动日期" : "" == o ? n = "请选择活动开始时间" : "" == d ? n = "请选择截止日期" : "" == c ? n = "请选择活动地点" : "" == r ? n = "请输入人数限制" : "" == m ? n = "请输入报名费" : "" == p ? n = "请输入活动内容" : "" == f ? n = "请输入姓名" : /^1(3|4|5|7|8|9)\d{9}$/.test(g) ? "" == e.data.pic ? n = "请上传活动图片" : i = !1 : n = "请输入联系方式", 
        i ? wx.showToast({
            title: n,
            icon: "none"
        }) : app.util.request({
            url: "entry/wxapp/addActivify",
            cachetime: "0",
            data: {
                name: s,
                type: u,
                starttime: l + " " + o,
                endtime: d,
                address: c,
                lng: e.data.longitude,
                lat: e.data.latitude,
                content: p,
                top: r,
                application: m,
                ininame: f,
                iniphone: g,
                inigender: e.data.sexIndex,
                imgs: e.data.pic,
                uid: a,
                status: e.data.status
            },
            success: function(t) {
                console.log(t), 1 == t.data && (wx.showToast({
                    title: "发布成功！！",
                    icon: "success",
                    duration: 2e3
                }), setTimeout(function() {
                    wx.reLaunch({
                        url: "/byjs_sun/pages/mineAct/mineAct?currIdx=2"
                    });
                }, 1e3));
            }
        });
    }
});