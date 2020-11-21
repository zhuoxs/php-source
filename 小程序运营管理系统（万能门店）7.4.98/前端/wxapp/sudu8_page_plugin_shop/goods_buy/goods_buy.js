var _Page;

function _defineProperty(a, t, e) {
    return t in a ? Object.defineProperty(a, t, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = e, a;
}

var app = getApp();

Page((_defineProperty(_Page = {
    data: {
        id: "",
        bg: "",
        couponlist: [],
        picList: [],
        datas: "",
        autoplay: !1,
        comment: "",
        jhsl: 1,
        dprice: "",
        yhje: 0,
        hjjg: "",
        sfje: "",
        order: "",
        my_num: "",
        xg_num: "",
        shengyu: "",
        userInfo: "",
        chuydate: "",
        chuytime: "",
        couponprice: 0,
        jqdjg: "请选择",
        yhqid: "0",
        kuaidi: 0,
        nav: 0,
        globaluser: "",
        textarea: 1,
        again: 0,
        mraddress: "",
        sid: 0,
        gmnum: 0,
        v: 1,
        free_package: 2,
        full_free: 0,
        addressid: !1,
        orderid: !1,
        pagedata: "",
        formdescs: "",
        newSessionKey: "",
        formImgs: [],
        formSetId: ""
    },
    onPullDownRefresh: function() {
        this.getinfos(), wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var t = this;
        t.refreshSessionkey();
        var e = a.id;
        t.setData({
            id: e
        });
        var i = 0;
        a.fxsid && (i = a.fxsid, t.setData({
            fxsid: a.fxsid
        })), a.again && t.setData({
            again: 1
        }), t.data.addressid = a.addressid, t.data.orderid = a.orderid;
        var s = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: s,
            data: {
                vs1: 1
            },
            cachetime: "30",
            success: function(a) {
                a.data.data;
                t.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: t.data.baseinfo.base_tcolor,
                    backgroundColor: t.data.baseinfo.base_color
                });
            }
        }), app.util.getUserInfo(t.getinfos, i);
    },
    onShow: function() {
        var a = this;
        a.data.addressid ? a.getmraddresszd(a.data.addressid) : a.getmraddress();
    },
    redirectto: function(a) {
        var t = a.currentTarget.dataset.link, e = a.currentTarget.dataset.linktype;
        app.util.redirectto(t, e);
    },
    getinfos: function() {
        var i = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                i.setData({
                    openid: a.data
                });
                var t = i.data.id;
                i.getShowPic(t);
                var e = app.util.url("entry/wxapp/globaluserinfo", {
                    m: "sudu8_page"
                });
                wx.request({
                    url: e,
                    data: {
                        uniacid: i.data.uniacid,
                        openid: a.data
                    },
                    success: function(a) {
                        var t = a.data.data;
                        t.nickname && t.avatar || i.setData({
                            isview: 1
                        }), i.setData({
                            globaluser: a.data.data
                        });
                    }
                });
            }
        });
    },
    getShowPic: function(a) {
        var e = this, t = wx.getStorageSync("openid"), i = app.util.url("entry/wxapp/mycoupon", {
            m: "sudu8_page"
        });
        wx.request({
            url: i,
            data: {
                openid: t,
                flag: 0
            },
            success: function(a) {
                e.setData({
                    couponlist: a.data.data
                });
            },
            fail: function(a) {}
        }), app.util.request({
            url: "entry/wxapp/showPro",
            data: {
                id: a,
                openid: t
            },
            cachetime: "30",
            success: function(a) {
                var t = e.data.yhje;
                0 == a.data.data.kuaidi ? e.setData({
                    nav: 1
                }) : e.setData({
                    nav: 2
                }), e.setData({
                    picList: a.data.data.images,
                    title: a.data.data.title,
                    datas: a.data.data,
                    hjjg: a.data.data.sellprice,
                    dprice: a.data.data.sellprice,
                    kuaidi: a.data.data.kuaidi,
                    sfje: a.data.data.sellprice - t,
                    shengyu: a.data.data.storage,
                    pagedata: a.data.data.forms,
                    formdescs: a.data.data.formdescs,
                    shopinfo: a.data.data.shopinfo
                }), wx.setNavigationBarTitle({
                    title: e.data.title
                }), wx.setStorageSync("isShowLoading", !1), wx.hideNavigationBarLoading(), wx.stopPullDownRefresh();
            }
        });
    },
    jian: function() {
        var a = this, t = a.data.jhsl, e = a.data.dprice, i = a.data.yhje;
        --t <= 0 && (t = 1);
        var s = 100 * e * t / 100, d = (s = s.toFixed(2)) - i;
        a.setData({
            jhsl: t,
            hjjg: s,
            sfje: d,
            jqdjg: "请选择",
            yhqid: 0
        });
    },
    makePhoneCallC: function(a) {
        var t = a.currentTarget.dataset.tel;
        wx.makePhoneCall({
            phoneNumber: t
        });
    },
    kuaidi: function(a) {
        var t = this, e = t.data.id;
        app.util.request({
            url: "entry/wxapp/getkuaidi",
            data: {
                id: e
            },
            success: function(a) {
                0 == a.data.data ? t.setdata({
                    kuaidi: 0
                }) : t.setdata({
                    kuaidi: 1
                });
            }
        });
    },
    jia: function() {
        var a = this, t = a.data.jhsl, e = a.data.my_num, i = a.data.xg_num, s = a.data.shengyu, d = a.data.dprice, n = a.data.yhje;
        s < ++t && -1 != s && (t--, wx.showModal({
            title: "提醒",
            content: "库存量不足！",
            showCancel: !1
        })), i < t + e && 0 != i && (1 == t ? t = 1 : t -= 1, wx.showModal({
            title: "提醒",
            content: "该商品为限购产品，您总购买数已超过限额！",
            showCancel: !1
        }));
        var o = 100 * d * t / 100, r = (o = o.toFixed(2)) - n;
        a.setData({
            jhsl: t,
            hjjg: o,
            sfje: r,
            jqdjg: "请选择",
            yhqid: 0
        });
    },
    save: function(a) {
        var i = this, t = i.data.jhsl, e = i.data.shengyu;
        if (e < t && -1 != e) return t--, wx.showModal({
            title: "提醒",
            content: "库存量不足！",
            showCancel: !1
        }), !1;
        var s = i.data.sfje, d = wx.getStorageSync("openid"), n = i.data.jhsl, o = i.data.dprice, r = i.data.yhje, u = i.data.id, c = i.data.order, l = (i.data.id, 
        i.data.yhqid), p = (i.data.datas.formset, i.data.kuaidi, !0);
        if (!i.data.mraddress) return p = !1, wx.showModal({
            title: "提醒",
            content: "请选择地址！",
            showCancel: !1
        }), !1;
        p && app.util.request({
            url: "entry/wxapp/Dingd",
            data: {
                openid: d,
                id: u,
                price: o,
                count: n,
                youhui: r,
                zhifu: s,
                order: c,
                address: i.data.mraddress.id,
                yhqid: l,
                nav: i.data.nav,
                formid: i.data.formSetId
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                var t = a.data.data.order_id;
                if (0 == a.data.data.success && 0 == a.data.data.syl) return wx.showModal({
                    title: "提醒",
                    content: "很遗憾！商品售完了！",
                    showCancel: !1,
                    success: function() {
                        wx.reLaunch({
                            url: "../goods_detail/goods_detail?id=" + u
                        });
                    }
                }), !1;
                if (0 == a.data.data.success && 0 < a.data.data.syl) return wx.showModal({
                    title: "提醒",
                    content: "很遗憾！商品只剩下" + a.data.data.syl + "个",
                    showCancel: !1,
                    success: function() {
                        wx.reLaunch({
                            url: "../goods_detail/goods_detail?id=" + u
                        });
                    }
                }), !1;
                if (1 == a.data.data.success) if (i.setData({
                    order: a.data.data
                }), s <= i.data.globaluser.money) wx.showModal({
                    title: "提醒",
                    content: "您将使用余额支付" + s + "元",
                    success: function(a) {
                        a.confirm && app.util.request({
                            url: "entry/wxapp/yuzhifu",
                            data: {
                                uniacid: i.data.uniacid,
                                openid: d,
                                money: s,
                                order_id: t
                            },
                            success: function(a) {
                                1 == a.data.data && wx.showToast({
                                    icon: "success",
                                    title: "支付成功！",
                                    duration: 3e3,
                                    success: function(a) {
                                        wx.redirectTo({
                                            url: "/sudu8_page/order_more_list/order_more_list"
                                        });
                                    }
                                });
                            }
                        });
                    }
                }); else {
                    var e = "";
                    e = 0 < i.data.globaluser.money ? (100 * s - 100 * i.data.globaluser.money) / 100 : s, 
                    wx.showModal({
                        title: "提醒",
                        content: "您将微信支付" + e + "元",
                        success: function(a) {
                            a.confirm && app.util.request({
                                url: "entry/wxapp/zhifu",
                                data: {
                                    openid: d,
                                    money: e,
                                    types: 1,
                                    order_id: t
                                },
                                header: {
                                    "content-type": "application/json"
                                },
                                success: function(a) {
                                    a.data.data.order_id && wx.requestPayment({
                                        timeStamp: a.data.data.timeStamp,
                                        nonceStr: a.data.data.nonceStr,
                                        package: a.data.data.package,
                                        signType: "MD5",
                                        paySign: a.data.data.paySign,
                                        success: function(a) {
                                            wx.showToast({
                                                title: "支付成功",
                                                icon: "success",
                                                duration: 3e3,
                                                success: function(a) {
                                                    app.util.request({
                                                        url: "entry/wxapp/zhifuSuccess",
                                                        data: {
                                                            order_id: t
                                                        },
                                                        success: function(a) {}
                                                    }), wx.redirectTo({
                                                        url: "/sudu8_page/order_more_list/order_more_list"
                                                    });
                                                },
                                                fail: function(a) {
                                                    wx.showToast({
                                                        icon: "loading",
                                                        title: "支付失败！",
                                                        duration: 2e3
                                                    });
                                                },
                                                complete: function(a) {
                                                    wx.navigateBack({
                                                        delta: 9
                                                    }), wx.navigateTo({
                                                        url: "/sudu8_page/order_more_list/order_more_list"
                                                    });
                                                }
                                            });
                                        }
                                    });
                                }
                            });
                        }
                    });
                }
            }
        });
    },
    bindDateChange: function(a) {
        this.setData({
            chuydate: a.detail.value
        });
    },
    bindTimeChange: function(a) {
        this.setData({
            chuytime: a.detail.value
        });
    },
    add_address: function() {
        0 == this.data.again && wx.navigateTo({
            url: "/sudu8_page/address/address?shareid=" + this.data.shareid + "&pid=" + this.data.id + "&orderid=" + this.data.orderid
        });
    },
    getmoney: function(a) {
        var t = a.currentTarget.id, e = a.currentTarget.dataset.index, i = e.coupon.pay_money, s = this.data.hjjg;
        if (1 * s < 1 * i) wx.showModal({
            title: "提示",
            content: "价格未满" + i + "元，不可使用该优惠券！",
            showCancel: !1
        }); else {
            var d = parseFloat(((100 * s - 100 * t) / 100).toPrecision(12));
            d < 0 && (d = 0), this.setData({
                jqdjg: t,
                yhqid: e.id,
                sfje: d
            }), this.hideModal();
        }
    },
    qxyh: function() {
        var a = this.data.jqdjg;
        "请选择" == a && (a = 0);
        var t = (100 * this.data.sfje + 100 * a) / 100;
        this.hideModal(), this.setData(_defineProperty({
            jqdjg: 0,
            yhqid: 0,
            sfje: t
        }, "jqdjg", "请选择"));
    },
    showModal: function() {
        var a = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = a).translateY(300).step(), this.setData({
            animationData: a.export(),
            showModalStatus: !0
        }), setTimeout(function() {
            a.translateY(0).step(), this.setData({
                animationData: a.export(),
                textarea: 0
            });
        }.bind(this), 200);
    },
    hideModal: function() {
        var a = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = a).translateY(300).step(), this.setData({
            animationData: a.export()
        }), setTimeout(function() {
            a.translateY(0).step(), this.setData({
                animationData: a.export(),
                showModalStatus: !1,
                textarea: 1
            });
        }.bind(this), 200);
    },
    nav: function(a) {
        var t = parseInt(a.detail.value);
        this.setData({
            nav: t
        });
    },
    huoqusq: function() {
        var u = this, c = wx.getStorageSync("openid");
        wx.getUserInfo({
            success: function(a) {
                var t = a.userInfo, e = t.nickName, i = t.avatarUrl, s = t.gender, d = t.province, n = t.city, o = t.country, r = app.util.url("entry/wxapp/Useupdate", {
                    m: "sudu8_page"
                });
                wx.request({
                    url: r,
                    data: {
                        openid: c,
                        nickname: e,
                        avatarUrl: i,
                        gender: s,
                        province: d,
                        city: n,
                        country: o
                    },
                    header: {
                        "content-type": "application/json"
                    },
                    success: function(a) {
                        wx.setStorageSync("golobeuid", a.data.data.id), wx.setStorageSync("golobeuser", a.data.data), 
                        u.setData({
                            isview: 0,
                            globaluser: a.data.data
                        }), u.getinfos();
                    }
                });
            },
            fail: function() {
                app.util.selfinfoget(u.chenggfh);
            }
        });
    },
    getmraddresszd: function(a) {
        var i = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/getmraddresszd",
            data: {
                openid: t,
                id: a
            },
            success: function(a) {
                var t = a.data.data;
                if ("" != t) i.setData({
                    mraddress: t
                }); else {
                    var e = i.data.again;
                    0 == e ? i.setData({
                        mraddress: ""
                    }) : 1 == e && 0 == i.data.m_address_l ? i.setData({
                        mraddress: ""
                    }) : 1 == e && wx.showModal({
                        title: "提示",
                        content: "该订单数据错误，请重新下单",
                        showCancel: !1,
                        success: function() {
                            wx.redirectTo({
                                url: "/sudu8_page/index/index"
                            });
                        }
                    });
                }
                i.getinfos();
            }
        });
    },
    getmraddress: function() {
        var i = this, a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/getmraddress",
            data: {
                openid: a
            },
            success: function(a) {
                var t = a.data.data;
                if ("" != t) i.setData({
                    mraddress: t
                }); else {
                    var e = i.data.again;
                    0 == e ? i.setData({
                        mraddress: ""
                    }) : 1 == e && wx.showModal({
                        title: "提示",
                        content: "该订单数据错误，请重新下单",
                        showCancel: !1,
                        success: function() {
                            wx.redirectTo({
                                url: "/sudu8_page/index/index"
                            });
                        }
                    });
                }
                i.getinfos();
            }
        });
    },
    getPhoneNumber1: function(a) {
        var t = this, e = a.detail.iv, i = a.detail.encryptedData;
        if ("getPhoneNumber:ok" == a.detail.errMsg) {
            var s = app.util.url("entry/wxapp/jiemiNew", {
                m: "sudu8_page"
            });
            wx.checkSession({
                success: function() {
                    wx.request({
                        url: s,
                        data: {
                            newSessionKey: t.data.newSessionKey,
                            iv: e,
                            encryptedData: i
                        },
                        success: function(a) {
                            a.data.data ? t.setData({
                                wxmobile: a.data.data
                            }) : wx.showModal({
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
            });
        } else wx.showModal({
            title: "提示",
            content: "请先授权获取您的手机号！",
            showCancel: !1
        });
    },
    weixinadd: function() {
        var s = this;
        wx.chooseAddress({
            success: function(a) {
                var t = a.provinceName + " " + a.cityName + " " + a.countyName + " " + a.detailInfo, e = a.userName, i = a.telNumber;
                s.setData({
                    myname: e,
                    mymobile: i,
                    myaddress: t
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
    formSubmit: function(a) {
        var t = this;
        if ("0" == t.data.datas.formset) t.save(); else {
            for (var e = t.data.pagedata, i = a.detail.value, s = 0; s < e.length; s++) "5" == e[s].type && (i[s] = t.data.formImgs);
            for (s = 0; s < e.length; s++) {
                if ("1" == e[s].ismust && !i[s]) return wx.showModal({
                    title: "提醒",
                    content: e[s].name + "为必填项！",
                    showCancel: !1
                }), !1;
                if ("2" == e[s].type || "4" == e[s].type) {
                    var d = i[s];
                    e[s].val = e[s].tp_text[d];
                } else "3" == e[s].type ? (e[s].val = [], e[s].val = i[s]) : "5" == e[s].type ? e[s].z_val = t.data.formImgs : e[s].val = i[s];
            }
            var n = app.util.url("entry/wxapp/Formval", {
                m: "sudu8_page"
            });
            wx.request({
                url: n,
                data: {
                    id: t.data.id,
                    pagedata: JSON.stringify(e),
                    types: "showProDan",
                    fid: t.data.datas.formset,
                    openid: wx.getStorageSync("openid")
                },
                cachetime: "30",
                success: function(a) {
                    t.data.formSetId = a.data.data.id, t.save();
                }
            });
        }
    },
    choiceimg1111: function(a) {
        var d = this, n = d.data.zhixin, t = a.currentTarget.dataset.index, e = d.data.pagedata[t].tp_text[0], o = d.data.formImgs, i = e - o.length;
        if (i < 1) return wx.showToast({
            title: "只能上传" + e + "张图片",
            icon: "none"
        }), !1;
        var r = app.util.url("entry/wxapp/wxupimg", {
            m: "sudu8_page"
        });
        wx.chooseImage({
            count: i,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                n = !0, d.setData({
                    zhixin: n
                }), wx.showLoading({
                    title: "图片上传中"
                });
                var t = a.tempFilePaths, i = 0, s = t.length;
                !function e() {
                    wx.uploadFile({
                        url: r,
                        filePath: t[i],
                        name: "file",
                        success: function(a) {
                            var t = JSON.parse(a.data);
                            o.push(t), d.setData({
                                formImgs: o
                            }), d.data.formImgs = o, ++i < s ? e() : (n = !1, d.setData({
                                zhixin: n
                            }), wx.hideLoading());
                        }
                    });
                }();
            }
        });
    },
    delimg: function(a) {
        a.currentTarget.dataset.index;
        var t = a.currentTarget.dataset.id;
        this.data.formImgs;
        this.data.formImgs.splice(t, 1), this.setData({
            formImgs: this.data.formImgs
        });
    },
    onPreviewImage: function(a) {
        app.util.showImage(a);
    },
    bindPickerChange: function(a) {
        var t = a.detail.value, e = a.currentTarget.dataset.index, i = this.data.pagedata, s = i[e].tp_text[t];
        i[e].val = s, this.setData({
            pagedata: i
        });
    }
}, "bindDateChange", function(a) {
    var t = a.detail.value, e = a.currentTarget.dataset.index, i = this.data.pagedata;
    i[e].val = t, this.setData({
        pagedata: i
    });
}), _defineProperty(_Page, "bindTimeChange", function(a) {
    var t = a.detail.value, e = a.currentTarget.dataset.index, i = this.data.pagedata;
    i[e].val = t, this.setData({
        pagedata: i
    });
}), _defineProperty(_Page, "refreshSessionkey", function() {
    var t = this, e = app.util.url("entry/wxapp/getNewSessionkey", {
        m: "sudu8_page"
    });
    wx.login({
        success: function(a) {
            wx.request({
                url: e,
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
}), _Page));