var app = getApp();

Page({
    data: {
        secArr: [],
        imgarr: [],
        img_arr: [],
        xztimes: "请选择时间",
        data_arr: [],
        xm: !1
    },
    jcxm: function() {
        var a = this.data.erjid;
        wx.navigateTo({
            url: "../xuanzexiangmu/xuanzexiangmu?p_id=" + a
        });
    },
    shouzhenyiyuan: function() {
        wx.navigateTo({
            url: "../selhospital/selhospital"
        });
    },
    dingqiyisheng: function() {
        wx.navigateTo({
            url: "/hyb_yl/dyisheng/dyisheng"
        });
    },
    nextjiuzhen: function() {
        wx.navigateTo({
            url: "../nextjiuzhen/nextjiuzhen"
        });
    },
    xztimes: function(a) {
        this.setData({
            xztimes: a.detail.value
        });
    },
    delimgs: function(a) {
        var t = a.currentTarget.dataset.dex, e = this.data.imgarr;
        e.splice(t, 1), this.setData({
            imgarr: e
        });
    },
    onLoad: function(a) {
        var n = this, t = wx.getStorageSync("color");
        if (wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: t
        }), void 0 !== a.jd_id) {
            var e = a.jd_id;
            app.util.request({
                url: "entry/wxapp/Selectjdinfo",
                data: {
                    jd_id: e
                },
                success: function(a) {
                    console.log(a), n.setData({
                        detail: a.data.data,
                        secArr: a.data.data.info,
                        imgarr: a.data.data.org_pic,
                        jcx_id: a.data.data.jcx_id
                    });
                }
            }), n.setData({
                jd_id: e
            });
        }
        if ("undefined" !== a.ejdiv) n.setData({
            erjid: a.ejdiv
        }); else if (void 0 !== a.erjid) {
            var i = a.erjid;
            app.util.request({
                url: "entry/wxapp/Alldiy",
                data: {
                    id: i
                },
                success: function(a) {
                    console.log(a);
                    var t = a.data.data, e = {}, i = JSON.parse(JSON.stringify(a.data.data));
                    e.secArr1 = [];
                    n.data.tabArr;
                    for (var r = 0; r < t.length; r++) if (2 == i[r].displaytype) {
                        i[r].picker = {}, i[r].picker.items = [], i[r].picker.displayorder = "";
                        for (var s = 0, d = i[r].items.length; s < d; s++) console.log(1), i[r].picker.items[s] = i[r].items[s].title;
                    }
                    n.data.secArr.push(e), n.setData({
                        secArr: i,
                        data: a.data.data,
                        currentEr: 0
                    });
                }
            }), n.setData({
                erjid: i
            });
        }
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(a) {
                n.setData({
                    url: a.data
                });
            }
        });
    },
    lineClick: function(a) {
        console.log(a);
        var t = this.data.secArr;
        t[a.currentTarget.dataset.idx].description = a.detail.value, this.setData({
            secArr: t
        });
    },
    choosePhoto: function(a) {
        var t = this, e = t.data.secArr;
        console.log(e);
        a.currentTarget.dataset.index, a.currentTarget.dataset.indexs;
        var i = a.currentTarget.dataset.idx;
        wx.chooseImage({
            count: 9,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                e[i].items = e[i].items.concat(a.tempFilePaths), e[i].description = e[i].items, 
                9 <= e[i].items.length && (e[i].items.length = 9), console.log(e), t.setData({
                    secArr: e
                });
            }
        });
    },
    delClick: function(a) {
        var t = this.data.secArr, e = a.currentTarget.dataset.index;
        a.currentTarget.dataset.indexs;
        t[a.currentTarget.dataset.idx].items.splice(e, 1), this.setData({
            secArr: t
        });
    },
    duohangClick: function(a) {
        var t = this.data.secArr;
        a.currentTarget.dataset.indexs;
        t[a.currentTarget.dataset.idx].description = a.detail.value, this.setData({
            secArr: t
        });
    },
    onReady: function() {
        this.getAlljcxm();
    },
    chooseCheck: function(a) {
        var t = a.currentTarget.dataset.index, e = a.currentTarget.dataset.idx, i = this.data.secArr;
        i[e].items[t].checked ? (i[e].items[t].checked = !1, i[e].description += i[e].items[t].title + ";") : (i[e].items[t].checked = !0, 
        i[e].description = i[e].description.replace(i[e].items[t].title + ";", "")), this.setData({
            secArr: i
        });
    },
    radioChange: function(a) {
        console.log(a);
        var t = this.data.secArr;
        t[a.currentTarget.dataset.idx].description = a.detail.value, console.log(t), this.setData({
            secArr: t
        });
    },
    subClick: function(a) {
        var t = this, e = this.data.secArr, i = t.data.erjid, r = t.data.txt, s = t.data.multsel;
        if (t.data.jd_id) var d = t.data.jd_id;
        var n = t.data.data_arr;
        this.addimgload(), wx.showToast({
            title: "上传中，请稍后",
            icon: "loading"
        });
        t.data.doctitle;
        for (var o = 0; o < e.length; o++) delete e[o].uniacid, delete e[o].activityid, 
        delete e[o].content, delete e[o].fieldstype, 3 != e[o].displaytype && (delete e[o].highStandard, 
        delete e[o].lowStandard), 0 != e[o].displaytype && 2 != e[o].displaytype && 1 != e[o].displaytype && delete e[o].items;
        var c = !1;
        for (var o in e) {
            if ("1" == e[o].essential && "" == e[o].description) return wx.showToast({
                title: e[o].title + "不能为空",
                image: "../images/err.png"
            }), !1;
            c = !0;
        }
        if (c) {
            var l = JSON.stringify(e);
            console.log(e);
            var u = a.detail.value.hosp, g = a.detail.value.xctime, p = t.data.xztimes;
            if (t.data.jcx_id) var h = t.data.jcx_id;
            "" == a.detail.value.hosp ? wx.showToast({
                title: "请选择首诊医院",
                image: "../images/err.png"
            }) : "" == p ? wx.showToast({
                title: "请选择日期",
                image: "../images/err.png"
            }) : setTimeout(function() {
                app.util.request({
                    url: "entry/wxapp/Savedivjd",
                    data: {
                        values: l,
                        fuleiid: i,
                        jd_id: d,
                        openid: wx.getStorageSync("openid"),
                        org_pic: n,
                        timearr: p,
                        hosp: u,
                        xctime: g,
                        xmname: r,
                        jcx_id: h,
                        multsel: s
                    },
                    success: function(a) {
                        console.log(a), wx.showToast({
                            title: "保存成功",
                            icon: "success",
                            duration: 2e3,
                            success: function() {
                                setTimeout(function() {
                                    wx.navigateBack({
                                        delta: 1
                                    });
                                }, 2e3);
                            }
                        });
                    }
                });
            }, 3500);
        }
    },
    bloodClick: function(a) {
        console.log("picker发送选择改变，携带值为", a.detail.value);
        var t = this.data.secArr;
        t[a.currentTarget.dataset.idx].picker.displayorder = a.detail.value;
        for (var e = 0; e < t.length; e++) 2 == t[e].displaytype && (t[e].displayorder = t[e].items[a.detail.value].title);
        console.log(t), this.setData({
            secArr: t
        });
    },
    onShow: function() {
        var a = this, t = getCurrentPages(), e = t[t.length - 1];
        if (e.data.yiyuan && (a.setData({
            yiyuan: e.data.yiyuan
        }), e.data.xctime && e.data.xctime, e.data.z_name && e.data.z_name), e.data.z_name) {
            for (var i = a.data.secArr, r = 0; r < i.length; r++) 6 == i[r].displaytype && (i[r].displayorder = e.data.z_name);
            console.log(i), a.setData({
                secArr: i
            });
        }
        e.data.txt && a.setData({
            txt: e.data.txt
        }), e.data.xm_id && a.setData({
            xm_id: e.data.xm_id
        }), e.data.jc_jgtype && a.setData({
            multsel: e.data.jc_jgtype
        }), e.data.jcx_id && a.setData({
            jcx_id: e.data.jcx_id
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    addimgload: function() {
        for (var t = this, a = app.siteInfo.uniacid, e = t.data.data_arr, i = 0; i < this.data.imgarr.length; i++) wx.uploadFile({
            url: t.data.url + "app/index.php?i=" + a + "&c=entry&a=wxapp&do=Upload&m=hyb_yl",
            filePath: t.data.imgarr[i],
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
        console.log(this.data.imgarr), this.data.imgarr.length < 3 ? wx.chooseImage({
            count: 3,
            sizeType: [ "original", "compressed" ],
            success: function(a) {
                console.log(a), 3 == a.tempFilePaths.length && t.setData({
                    hide: !0
                }), t.setData({
                    imgarr: t.data.imgarr.concat(a.tempFilePaths)
                });
            }
        }) : wx.showToast({
            title: "最多上传三张图片",
            icon: "loading",
            duration: 3e3
        });
    },
    fanhui: function() {
        wx.navigateBack({
            delta: 1
        });
    },
    getAlljcxm: function() {
        var t = this, a = t.data.erjid;
        app.util.request({
            url: "entry/wxapp/Alljcxm",
            data: {
                p_id: a
            },
            success: function(a) {
                0 !== a.data ? t.setData({
                    jcxm: a.data.data,
                    xm: !0
                }) : (console.log("eee"), t.setData({
                    xm: !1
                }));
            }
        });
    },
    getJcjg: function(a) {
        var t = this, e = t.data.xm_id, i = t.data.multsel;
        if (void 0 !== t.data.multsel) i = t.data.multsel; else {
            i = a.currentTarget.dataset.multsel;
            var r = 1;
        }
        if (void 0 !== t.data.erjid) var s = t.data.erjid; else s = a.currentTarget.dataset.erjid;
        a.currentTarget.dataset.jcx_id;
        t.data.jcx_id ? wx.navigateTo({
            url: "/hyb_yl/jianchajieguo/jianchajieguo?xm_id=" + e + "&multsel=" + i + "&erjid=" + s + "&jcx_id=" + t.data.jcx_id + "&multtypes=" + r
        }) : wx.navigateTo({
            url: "/hyb_yl/jianchajieguo/jianchajieguo?xm_id=" + e + "&multsel=" + i + "&erjid=" + s
        });
    }
});