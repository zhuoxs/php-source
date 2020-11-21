var app = getApp();

Page({
    data: {
        a: "1",
        phoneNumber: "",
        date: null,
        region: null,
        addressDetail: "",
        name: null,
        page_signs: "/sudu8_page/register/register",
        formset: 0,
        pagedata: [],
        beizhu: "",
        pagetype: "",
        formdescs: "",
        form_status: 0
    },
    onLoad: function(a) {
        var t = this;
        t.refreshSessionkey(), wx.setNavigationBarTitle({
            title: "开通"
        }), t.getBase(), t.checkApply(), t.getUserinfo(), t.registerForm();
    },
    checkApply: function() {
        app.util.request({
            url: "entry/wxapp/checkApply",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                3 == a.data.data.flag ? wx.showModal({
                    title: "提示",
                    content: "已有申请记录，请等待审核！",
                    showCancel: !1,
                    success: function() {
                        wx.redirectTo({
                            url: "/sudu8_page/index/index"
                        });
                    }
                }) : 1 != a.data.data.flag && 4 != a.data.data.flag || wx.showModal({
                    title: "提示",
                    content: "您已经是会员！",
                    showCancel: !1,
                    success: function() {
                        wx.navigateBack({
                            delta: 1
                        });
                    }
                });
            },
            fail: function(a) {}
        });
    },
    registerForm: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/RegisterFrom",
            data: {
                openid: wx.getStorageSync("openid")
            },
            cachetime: "30",
            success: function(a) {
                1 == a.data.data.flag ? t.setData({
                    formset: 1,
                    form_status: a.data.data.form_status,
                    pagedata: a.data.data.form,
                    beizhu: a.data.data.beizhu,
                    formdescs: a.data.data.formdescs
                }) : t.setData({
                    formset: 0,
                    form_status: a.data.data.form_status,
                    beizhu: a.data.data.beizhu
                });
            },
            fail: function(a) {}
        });
    },
    refreshSessionkey: function() {
        var t = this;
        wx.login({
            success: function(a) {
                app.util.request({
                    url: "entry/wxapp/getNewSessionkey",
                    data: {
                        code: a.code
                    },
                    success: function(a) {
                        t.setData({
                            newSessionKey: a.data.data
                        });
                    }
                });
            }
        });
    },
    redirectto: function(a) {
        var t = a.currentTarget.dataset.link, e = a.currentTarget.dataset.linktype;
        app.util.redirectto(t, e);
    },
    getBase: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/BaseMin",
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(a) {
                t.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: t.data.baseinfo.base_tcolor,
                    backgroundColor: t.data.baseinfo.base_color
                });
            },
            fail: function(a) {}
        });
    },
    getUserinfo: function() {
        var t = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                app.util.request({
                    url: "entry/wxapp/mymoney",
                    data: {
                        openid: a.data
                    },
                    success: function(a) {
                        t.setData({
                            cardname: a.data.data.cardname
                        });
                    }
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        this.refreshSessionkey(), wx.stopPullDownRefresh();
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    wxdz1: function() {
        var t = this;
        t.setData({
            a: "2"
        }), wx.chooseAddress({
            success: function(a) {
                t.setData({
                    name: a.userName,
                    region: a.provinceName + "-" + a.countyName + "-" + a.cityName,
                    addressDetail: a.detailInfo
                });
            },
            fail: function() {
                wx.showModal({
                    title: "授权失败",
                    content: "请重新授权",
                    success: function(a) {
                        a.confirm && wx.openSetting({
                            success: function() {
                                wx.getSetting({
                                    success: function(a) {
                                        a.authSetting["scope.address"] ? wx.chooseAddress({
                                            success: function(a) {
                                                t.setData({
                                                    name: a.userName,
                                                    region: a.provinceName + "-" + a.countyName + "-" + a.cityName,
                                                    addressDetail: a.detailInfo
                                                });
                                            }
                                        }) : t.wxdz2();
                                    }
                                });
                            }
                        }), a.cancel && t.wxdz2();
                    }
                });
            }
        });
    },
    wxdz2: function() {
        this.setData({
            a: "1"
        });
    },
    getPhoneNumber: function(a) {
        var n = this, t = a.detail.iv, e = a.detail.encryptedData;
        "getPhoneNumber:ok" == a.detail.errMsg ? wx.checkSession({
            success: function() {
                app.util.request({
                    url: "entry/wxapp/jiemiNew",
                    data: {
                        newSessionKey: n.data.newSessionKey,
                        iv: t,
                        encryptedData: e
                    },
                    success: function(a) {
                        if (a.data.data) {
                            for (var t = n.data.pagedata, e = 0; e < t.length; e++) 0 == t[e].type && 5 == t[e].tp_text[0].yval && (t[e].val = a.data.data);
                            n.setData({
                                phoneNumber: a.data.data,
                                wxmobile: a.data.data,
                                pagedata: t
                            });
                        } else wx.showModal({
                            title: "提示",
                            content: "sessionKey已过期，请下拉刷新！"
                        });
                    },
                    fail: function(a) {}
                });
            },
            fail: function() {
                wx.showModal({
                    title: "提示",
                    content: "sessionKey已过期，请下拉刷新！"
                });
            }
        }) : wx.showModal({
            title: "提示",
            content: "请先授权获取您的手机号！",
            showCancel: !1
        });
    },
    bindInputChange: function(a) {
        var t = a.detail.value, e = a.currentTarget.dataset.index, n = this.data.pagedata;
        n[e].val = t, this.setData({
            pagedata: n
        });
    },
    bindPickerChange: function(a) {
        var t = a.detail.value, e = a.currentTarget.dataset.index, n = this.data.pagedata, s = n[e].tp_text[t];
        n[e].val = s, this.setData({
            pagedata: n
        });
    },
    bindDateChange: function(a) {
        var t = a.detail.value, e = a.currentTarget.dataset.index, n = this.data.pagedata;
        n[e].val = t, this.setData({
            pagedata: n
        });
    },
    bindTimeChange: function(a) {
        var t = a.detail.value, e = a.currentTarget.dataset.index, n = this.data.pagedata;
        n[e].val = t, this.setData({
            pagedata: n
        });
    },
    checkboxChange: function(a) {
        var t = a.detail.value, e = a.currentTarget.dataset.index, n = this.data.pagedata;
        n[e].val = t, this.setData({
            pagedata: n
        });
    },
    radioChange: function(a) {
        var t = a.detail.value, e = a.currentTarget.dataset.index, n = this.data.pagedata;
        n[e].val = t, this.setData({
            pagedata: n
        });
    },
    choiceimg1111: function(a) {
        var i = this, t = 0, o = i.data.zhixin, d = a.currentTarget.dataset.index, r = i.data.pagedata, e = r[d].val, n = r[d].tp_text[0];
        e ? t = e.length : (t = 0, e = []);
        var s = n - t, c = app.util.url("entry/wxapp/wxupimg", {
            m: "sudu8_page"
        }), u = r[d].z_val ? r[d].z_val : [];
        wx.chooseImage({
            count: s,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                o = !0, i.setData({
                    zhixin: o
                }), wx.showLoading({
                    title: "图片上传中"
                });
                var t = a.tempFilePaths, n = 0, s = t.length;
                !function e() {
                    wx.uploadFile({
                        url: c,
                        filePath: t[n],
                        name: "file",
                        success: function(a) {
                            var t = JSON.parse(a.data);
                            u.push(t), r[d].z_val = u, i.setData({
                                pagedata: r
                            }), ++n < s ? e() : (o = !1, i.setData({
                                zhixin: o
                            }), wx.hideLoading());
                        }
                    });
                }();
            }
        });
    },
    delimg: function(a) {
        var t = a.currentTarget.dataset.index, e = a.currentTarget.dataset.id, n = this.data.pagedata, s = n[t].z_val;
        s.splice(e, 1), 0 == s.length && (s = ""), n[t].z_val = s, this.setData({
            pagedata: n
        });
    },
    namexz: function(a) {
        for (var t = a.currentTarget.dataset.index, e = this.data.pagedata[t], n = [], s = 0; s < e.tp_text.length; s++) {
            var i = {};
            i.keys = e.tp_text[s], i.val = 1, n.push(i);
        }
        this.setData({
            ttcxs: 1,
            formindex: t,
            xx: n,
            xuanz: 0,
            lixuanz: -1
        }), this.riqi();
    },
    riqi: function() {
        for (var a = new Date(), t = new Date(a.getTime()), e = t.getFullYear() + "-" + (t.getMonth() + 1) + "-" + t.getDate(), n = this.data.xx, s = 0; s < n.length; s++) n[s].val = 1;
        this.setData({
            xx: n
        }), this.gettoday(e);
        var i = [], o = [], d = new Date();
        for (s = 0; s < 5; s++) {
            var r = new Date(d.getTime() + 24 * s * 3600 * 1e3), c = r.getFullYear(), u = r.getMonth() + 1, l = r.getDate(), f = u + "月" + l + "日", h = c + "-" + u + "-" + l;
            i.push(f), o.push(h);
        }
        this.setData({
            arrs: i,
            fallarrs: o,
            today: e
        });
    },
    xuanzd: function(a) {
        for (var t = a.currentTarget.dataset.index, e = this.data.fallarrs[t], n = this.data.xx, s = 0; s < n.length; s++) n[s].val = 1;
        this.setData({
            xuanz: t,
            today: e,
            lixuanz: -1,
            xx: n
        }), this.gettoday(e);
    },
    goux: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData({
            lixuanz: t
        });
    },
    gettoday: function(a) {
        var s = this, t = s.data.id, e = s.data.formindex, i = s.data.xx;
        app.util.request({
            url: "entry/wxapp/Duzhan",
            data: {
                id: t,
                types: "showPro_lv_buy",
                days: a,
                pagedatekey: e
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                for (var t = a.data.data, e = 0; e < t.length; e++) i[t[e]].val = 2;
                var n = 0;
                t.length == i.length && (n = 1), s.setData({
                    xx: i,
                    isover: n
                });
            }
        });
    },
    getPhoneNumber1: function(a) {
        var n = this, t = a.detail.iv, e = a.detail.encryptedData;
        "getPhoneNumber:ok" == a.detail.errMsg ? wx.checkSession({
            success: function() {
                app.util.request({
                    url: "entry/wxapp/jiemiNew",
                    data: {
                        newSessionKey: n.data.newSessionKey,
                        iv: t,
                        encryptedData: e
                    },
                    success: function(a) {
                        if (a.data.data) {
                            for (var t = n.data.pagedata, e = 0; e < t.length; e++) 0 == t[e].type && 5 == t[e].tp_text[0].yval && (t[e].val = a.data.data);
                            n.setData({
                                wxmobile: a.data.data,
                                pagedata: t
                            });
                        } else wx.showModal({
                            title: "提示",
                            content: "sessionKey已过期，请下拉刷新！"
                        });
                    },
                    fail: function(a) {}
                });
            },
            fail: function() {
                wx.showModal({
                    title: "提示",
                    content: "sessionKey已过期，请下拉刷新！"
                });
            }
        }) : wx.showModal({
            title: "提示",
            content: "请先授权获取您的手机号！",
            showCancel: !1
        });
    },
    weixinadd: function() {
        var o = this;
        wx.chooseAddress({
            success: function(a) {
                for (var t = a.provinceName + " " + a.cityName + " " + a.countyName + " " + a.detailInfo, e = a.userName, n = a.telNumber, s = o.data.pagedata, i = 0; i < s.length; i++) 0 == s[i].type && 2 == s[i].tp_text[0].yval && (s[i].val = e), 
                0 == s[i].type && 3 == s[i].tp_text[0].yval && (s[i].val = n), 0 == s[i].type && 4 == s[i].tp_text[0].yval && (s[i].val = t);
                o.setData({
                    myname: e,
                    mymobile: n,
                    myaddress: t,
                    pagedata: s
                });
            },
            fail: function(a) {
                wx.getSetting({
                    success: function(a) {
                        a.authSetting["scope.address"] || wx.openSetting({
                            success: function(a) {}
                        });
                    }
                });
            }
        });
    },
    save_nb: function() {
        var a = this, t = a.data.today, e = a.data.xx, n = a.data.lixuanz;
        if (-1 == n) return wx.showModal({
            title: "提现",
            content: "请选择预约的选项",
            showCancel: !1
        }), !1;
        var s = "已选择" + t + "，" + e[n].keys.yval, i = a.data.pagedata, o = a.data.formindex;
        i[o].val = s, i[o].days = t, i[o].indexkey = o, i[o].xuanx = n, a.setData({
            ttcxs: 0,
            pagedata: i
        });
    },
    quxiao: function() {
        this.setData({
            ttcxs: 0
        });
    },
    changeName: function(a) {
        this.setData({
            name: a.detail.value
        });
    },
    changeDate: function(a) {
        this.setData({
            date: a.detail.value
        });
    },
    changeRegion: function(a) {
        this.setData({
            region: a.detail.value.join("-")
        });
    },
    changeDetail: function(a) {
        this.setData({
            addressDetail: a.detail.value
        });
    },
    confirmRegister: function(a) {
        var t = this, e = a.detail.formId, n = t.data.form_status;
        if (1 == n) {
            if (!t.data.name) return wx.showModal({
                title: "姓名不可为空！",
                content: "请重新输入",
                showCancel: !1
            }), !1;
            if (!t.data.phoneNumber) return wx.showModal({
                title: "手机号不可为空！",
                content: "请重新输入",
                showCancel: !1
            }), !1;
            if (!t.data.date) return wx.showModal({
                title: "生日不可为空！",
                content: "请重新输入",
                showCancel: !1
            }), !1;
            if (!t.data.region) return wx.showModal({
                title: "地区不可为空！",
                content: "请重新输入",
                showCancel: !1
            }), !1;
            if (!t.data.addressDetail) return wx.showModal({
                title: "详细地址不可为空！",
                content: "请重新输入",
                showCancel: !1
            }), !1;
        }
        for (var s = t.data.pagedata, i = 0; i < s.length; i++) if (1 == s[i].ismust) if (5 == s[i].type) {
            if ("" == s[i].z_val) return wx.showModal({
                title: "提醒",
                content: s[i].name + "为必填项！",
                showCancel: !1
            }), !1;
        } else if ("" == s[i].val) return wx.showModal({
            title: "提醒",
            content: s[i].name + "为必填项！",
            showCancel: !1
        }), !1;
        0 < s.length && t.formSubmits(), wx.getStorage({
            key: "openid",
            success: function(a) {
                app.util.request({
                    url: "entry/wxapp/registerVIP",
                    data: {
                        openid: a.data,
                        name: t.data.name,
                        phoneNumber: t.data.phoneNumber,
                        date: t.data.date,
                        region: t.data.region,
                        addressDetail: t.data.addressDetail,
                        formId: e,
                        cardname: t.data.cardname,
                        pagedata: JSON.stringify(s),
                        form_status: n
                    },
                    cachetime: "30",
                    success: function(a) {
                        1 == a.data.data ? wx.showModal({
                            title: "提示",
                            content: "申请成功，请等待审核！",
                            showCancel: !1,
                            success: function(a) {
                                wx.redirectTo({
                                    url: "/sudu8_page/usercenter/usercenter"
                                });
                            }
                        }) : 3 == a.data.data ? wx.showToast({
                            title: "开通成功！",
                            icon: "success",
                            success: function() {
                                setTimeout(function() {
                                    wx.redirectTo({
                                        url: "/sudu8_page/usercenter/usercenter"
                                    });
                                }, 1500);
                            }
                        }) : wx.showModal({
                            title: "提示",
                            content: "申请失败",
                            showCancel: !1
                        });
                    },
                    fail: function(a) {}
                });
            }
        });
    },
    formSubmits: function(a) {
        for (var t = this.data.pagedata, e = 0; e < t.length; e++) if (1 == t[e].ismust) if (5 == t[e].type) {
            if ("" == t[e].z_val) return wx.showModal({
                title: "提醒",
                content: t[e].name + "为必填项！",
                showCancel: !1
            }), !1;
        } else if ("" == t[e].val) return wx.showModal({
            title: "提醒",
            content: t[e].name + "为必填项！",
            showCancel: !1
        }), !1;
        app.util.request({
            url: "entry/wxapp/Formval",
            data: {
                id: 0,
                pagedata: JSON.stringify(t),
                types: "showPro_lv_buy",
                fid: this.data.baseinfo.fid,
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {}
        });
    }
});