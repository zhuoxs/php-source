var app = getApp(), number = null, weight = null, totalPrice = 0, express_price_1 = 0, express_price_2 = 0, v_privce = 0;

Page({
    data: {
        staus: 1,
        money: 0,
        express_price: 0,
        pay_price: 0,
        isexpress: !0,
        address: null,
        order: null,
        cardnum: null,
        selected_card: null,
        formid: [],
        navIndex: 1,
        clubList: null,
        page: 1,
        pagesize: 20,
        loadend: !1,
        showClubList: !1,
        club: null,
        isaddr: !1,
        Clubloading: !1
    },
    navIndex: function(a) {
        var e = this, t = a.currentTarget.dataset.index;
        this.setData({
            navIndex: a.currentTarget.dataset.index
        }), 2 == t ? null == this.data.club ? wx.getLocation({
            success: function(a) {
                console.log(a), e.setData({
                    longitude: a.longitude,
                    latitude: a.latitude
                }), app.util.request({
                    url: "entry/wxapp/community",
                    showLoading: !0,
                    data: {
                        op: "clubList",
                        longitude: a.longitude,
                        latitude: a.latitude,
                        page: e.data.page,
                        pagesize: e.data.pagesize
                    },
                    success: function(a) {
                        for (var t = 0; t < a.data.data.clubList.length; t++) 1e3 < a.data.data.clubList[t].juli ? a.data.data.clubList[t].julishow = (a.data.data.clubList[t].juli / 1e3).toFixed(1) + "km" : a.data.data.clubList[t].julishow = a.data.data.clubList[t].juli + "m";
                        e.setData({
                            clubList: a.data.data.clubList,
                            club: a.data.data.clubList[0],
                            club_id: 0
                        }), 1 == app.globalData.webset.community_free || (express_price_2 = app.look.count_express("", number, weight, e.data.club.region)), 
                        e.countPrice();
                    },
                    fail: function() {
                        e.setData({
                            loadend: !0
                        });
                    }
                });
            }
        }) : (1 != app.globalData.webset.community_free && (express_price_2 = app.look.count_express("", number, weight, e.data.club.region)), 
        e.countPrice()) : e.countPrice();
    },
    showClubList: function() {
        if (this.setData({
            showClubList: !0
        }), null == this.data.clubList) {
            var e = this;
            wx.getLocation({
                success: function(a) {
                    e.setData({
                        longitude: a.longitude,
                        latitude: a.latitude
                    }), app.util.request({
                        url: "entry/wxapp/community",
                        showLoading: !0,
                        data: {
                            op: "clubList",
                            longitude: a.longitude,
                            latitude: a.latitude,
                            page: e.data.page,
                            pagesize: e.data.pagesize
                        },
                        success: function(a) {
                            for (var t = 0; t < a.data.data.clubList.length; t++) 1e3 < a.data.data.clubList[t].juli ? a.data.data.clubList[t].julishow = (a.data.data.clubList[t].juli / 1e3).toFixed(1) + "km" : -1 == a.data.data.clubList[t].juli ? a.data.data.clubList[t].julishow = "未知" : a.data.data.clubList[t].julishow = a.data.data.clubList[t].juli + "m";
                            e.setData({
                                clubList: a.data.data.clubList
                            });
                        },
                        fail: function() {
                            e.setData({
                                loadend: !0
                            });
                        }
                    });
                },
                fail: function(a) {
                    wx.showModal({
                        title: "需要授权使用地理位置",
                        content: "需要授权使用地理位置",
                        success: function(a) {
                            a.confirm ? (e.data.isaddr = !0, wx.openSetting()) : a.cancel && (e.data.longitude = -1, 
                            e.data.latitude = -1, e.data.page = 0, e.loadClubList());
                        }
                    });
                }
            });
        }
    },
    loadClubList: function() {
        if (!this.data.loadend && !this.data.Clubloading) {
            var e = this;
            this.data.Clubloading = !0, e.data.page = e.data.page + 1, app.util.request({
                url: "entry/wxapp/community",
                showLoading: !0,
                data: {
                    op: "clubList",
                    longitude: e.data.longitude,
                    latitude: e.data.latitude,
                    page: e.data.page,
                    pagesize: e.data.pagesize
                },
                success: function(a) {
                    for (var t = 0; t < a.data.data.clubList.length; t++) 1e3 < a.data.data.clubList[t].juli ? a.data.data.clubList[t].julishow = (a.data.data.clubList[t].juli / 1e3).toFixed(1) + "km" : -1 == a.data.data.clubList[t].juli ? a.data.data.clubList[t].julishow = "未知" : a.data.data.clubList[t].julishow = a.data.data.clubList[t].juli + "m";
                    e.data.clubList ? e.setData({
                        clubList: e.data.clubList.concat(a.data.data.clubList)
                    }) : e.setData({
                        clubList: a.data.data.clubList
                    });
                },
                complete: function(a) {
                    e.data.Clubloading = !1;
                },
                fail: function(a) {
                    app.look.alert(a.data.message), e.setData({
                        loadend: !0
                    });
                }
            });
        }
    },
    hideClubList: function() {
        this.setData({
            showClubList: !1
        });
    },
    tapClubList: function(a) {
        this.setData({
            club_id: a.currentTarget.dataset.index
        });
    },
    selectClub: function() {
        var a = this;
        this.data.club && this.data.club.region == this.data.clubList[this.data.club_id] || (1 != app.globalData.webset.community_free && (express_price_2 = app.look.count_express("", number, weight, this.data.clubList[this.data.club_id].region)), 
        a.countPrice()), this.setData({
            club: a.data.clubList[a.data.club_id],
            showClubList: !1
        });
    },
    onLoad: function(a) {
        var e = this;
        a.order = decodeURIComponent(a.order), a.order = JSON.parse(a.order), a.order.v_privce || (a.order.v_privce = 0), 
        e.setData({
            money: app.globalData.userInfo.amount,
            order: a.order,
            webset: app.globalData.webset,
            club: app.club,
            navIndex: 1 == app.globalData.webset.community ? 2 : 1
        });
        var t = a.order;
        weight = number = 0, t.content.forEach(function(a, t) {
            number += parseInt(a.num), weight += parseInt(a.weight) * parseInt(a.num);
        }), totalPrice = parseFloat(t.totalPrice), 1 == t.cid && app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !1,
            data: {
                op: "getusercard",
                price: t.totalPrice
            },
            success: function(a) {
                a.data.data.cardnum && e.setData({
                    cardnum: a.data.data.cardnum
                });
            }
        }), 2 == e.data.navIndex && (null == this.data.club ? wx.getLocation({
            success: function(a) {
                console.log(a), e.setData({
                    longitude: a.longitude,
                    latitude: a.latitude
                }), app.util.request({
                    url: "entry/wxapp/community",
                    showLoading: !0,
                    data: {
                        op: "clubList",
                        longitude: a.longitude,
                        latitude: a.latitude,
                        page: e.data.page,
                        pagesize: e.data.pagesize
                    },
                    success: function(a) {
                        for (var t = 0; t < a.data.data.clubList.length; t++) 1e3 < a.data.data.clubList[t].juli ? a.data.data.clubList[t].julishow = (a.data.data.clubList[t].juli / 1e3).toFixed(1) + "km" : a.data.data.clubList[t].julishow = a.data.data.clubList[t].juli + "m";
                        e.setData({
                            clubList: a.data.data.clubList,
                            club: a.data.data.clubList[0],
                            club_id: 0
                        }), 1 != app.globalData.webset.community_free && (express_price_2 = app.look.count_express("", number, weight, e.data.club.region)), 
                        e.countPrice();
                    },
                    fail: function() {
                        e.setData({
                            loadend: !0
                        });
                    }
                });
            }
        }) : (1 != app.globalData.webset.community_free && (express_price_2 = app.look.count_express("", number, weight, e.data.club.region)), 
        e.countPrice()));
    },
    myform: function(a) {
        var e = this.data.formid;
        if (1 != a.detail.target.dataset.sumit) return e.push(a.detail.formId), void this.setData({
            formid: e
        });
        e.push(a.detail.formId);
        var i = a.detail.value.remark, s = a.detail.value.paytype, o = this.data.address, t = this.data.money, d = this.data.order, l = this.data.pay_price, r = this.data.voucher, n = d.content;
        if (1 == d.cid) {
            var u = wx.getStorageSync("cars") || [];
            n.forEach(function(e, a) {
                u.forEach(function(a, t) {
                    e.id != a.id || u.splice(t, 1);
                });
            });
        }
        var c = this;
        if ("" != o && null != o || 2 == this.data.navIndex && "-1" == app.globalData.webset.community_personal_addr) if ("" != s) if (this.data.isexpress || 2 == c.data.navIndex) {
            if (2 == this.data.navIndex && null == this.data.club) return this.showClubList(), 
            void app.look.alert("当前没有社区团点,请选择团点其他模式");
            var p = function() {
                var a = {}, t = c.data.club;
                null != t && (delete t.avatar, delete t.avatarurl, t = JSON.stringify(t)), 1 == d.cid && (a = {
                    op: "make_order",
                    paytype: s,
                    order: JSON.stringify(d.content),
                    pay_price: l,
                    address: JSON.stringify(o),
                    remark: i,
                    formid: e,
                    voucherid: JSON.stringify(r),
                    navIndex: c.data.navIndex,
                    club: t
                }), 6 == d.cid && (a = {
                    op: "make_limit_order",
                    paytype: s,
                    pay_price: l,
                    address: JSON.stringify(o),
                    remarks: i,
                    formid: e,
                    goodid: d.content[0].id,
                    flashid: d.flashid,
                    num: d.totalNum,
                    attr: d.content[0].attr,
                    navIndex: c.data.navIndex,
                    club: t
                }), 4 == d.cid && (a = {
                    op: "make_bargain_order",
                    paytype: s,
                    pay_price: l,
                    address: JSON.stringify(o),
                    remarks: i,
                    formid: e,
                    id: d.bargain_self_id,
                    navIndex: c.data.navIndex,
                    club: t
                }), 5 == d.cid && (a = {
                    op: "make_group",
                    paytype: s,
                    pay_price: l,
                    address: JSON.stringify(o),
                    remarks: i,
                    formid: e,
                    id: d.group_id,
                    attr: d.content[0].attr,
                    num: d.totalNum,
                    cid: d.cid_type,
                    size: d.size,
                    style: d.style,
                    sponsor_id: d.sponsor_id,
                    navIndex: c.data.navIndex,
                    club: t
                }), console.log(a), app.util.request({
                    url: "entry/wxapp/goods",
                    showLoading: !0,
                    method: "POST",
                    data: a,
                    success: function(a) {
                        var t = a.data;
                        if (0 == t.errno) {
                            if (0 == parseFloat(l) && (s = 1), 3 == s ? "支付成功" == a.data.message && (s = 1) : 1 == s && "微信支付" == a.data.message && (s = 3), 
                            2 == s || 3 == s) {
                                var e = t.data.tid;
                                console.log(e), t && t.data && !a.data.errno && wx.requestPayment({
                                    timeStamp: a.data.data.timeStamp,
                                    nonceStr: a.data.data.nonceStr,
                                    package: a.data.data.package,
                                    signType: "MD5",
                                    paySign: a.data.data.paySign,
                                    success: function(a) {
                                        app.voucher = null;
                                        setTimeout(function() {
                                            !function a(t) {
                                                app.util.request({
                                                    url: "entry/wxapp/payquery",
                                                    showLoading: !0,
                                                    data: {
                                                        tid: t
                                                    },
                                                    success: function(a) {
                                                        1 == d.cid && wx.setStorage({
                                                            key: "cars",
                                                            data: u
                                                        }), console.log("AAAAAAAAAAAAA"), console.log(a), app.globalData.userInfo = a.data.data, 
                                                        5 == d.cid ? app.util.message({
                                                            title: "支付成功",
                                                            redirect: "redirect:../mygroup/mygroup"
                                                        }) : app.util.message({
                                                            title: "支付成功",
                                                            redirect: "reLaunch:../order/order?status=2"
                                                        });
                                                    },
                                                    fail: function() {
                                                        setTimeout(function() {
                                                            a(t);
                                                        }, 1e3);
                                                    }
                                                });
                                            }(e);
                                        }, 500);
                                    },
                                    fail: function(a) {
                                        console.log(a), app.voucher = null, "requestPayment:fail cancel" === a.errMsg && (1 == d.cid && wx.setStorage({
                                            key: "cars",
                                            data: u
                                        }), app.util.message({
                                            title: "你有订单未支付",
                                            redirect: "reLaunch:../order/order?status=1"
                                        }));
                                    }
                                });
                            }
                            1 != s && 4 != s || (app.voucher = null, wx.setStorage({
                                key: "cars",
                                data: u
                            }), app.globalData.userInfo = a.data.data, 5 == d.cid ? app.util.message({
                                title: "支付成功",
                                redirect: "redirect:../mygroup/mygroup"
                            }) : app.util.message({
                                title: a.data.message,
                                redirect: "reLaunch:../order/order?status=2"
                            }));
                        } else console.log("xxxxxxxxxxx"), wx.showModal({
                            title: "错误",
                            showCancel: !1,
                            content: a.message,
                            success: function(a) {
                                a.confirm || a.cancel;
                            }
                        });
                    },
                    fail: function(a) {
                        console.log("xxxxxxxxxxfffilal"), console.log(a.data), wx.showModal({
                            title: "错误",
                            showCancel: !1,
                            content: a.data.message,
                            success: function(a) {
                                a.confirm || a.cancel;
                            }
                        });
                    }
                });
            };
            if (1 == s) if (parseFloat(t) < parseFloat(l)) if (1 == app.globalData.webset.balance_wechat) {
                var g = (l - parseFloat(t) + .01).toFixed(2);
                s = 3, wx.showModal({
                    title: "确认支付?",
                    content: "确认通过余额支付" + t + "元,其余将通过微信支付" + g + "元,共" + l + "元",
                    success: function(a) {
                        a.confirm && p();
                    }
                });
            } else app.look.error("当前余额不足"); else wx.showModal({
                title: "确认支付?",
                content: "确认通过余额支付" + l + "元",
                success: function(a) {
                    a.confirm && p();
                }
            });
            2 != s && 4 != s || p();
        } else wx.showToast({
            title: "该地址不配送",
            icon: "none"
        }); else wx.showToast({
            title: "请选择支付方式",
            icon: "none"
        }); else wx.showToast({
            title: "请选择您的地址信息",
            icon: "none"
        });
    },
    tomyvoucher: function() {
        if (0 != this.data.cardnum) {
            var a = this.data.order.totalPrice, t = -1;
            null != app.voucher && (t = app.voucher.id), wx.navigateTo({
                url: "../myvoucher/myvoucher?stausid=2&price=" + a + "&mycard_id=" + t
            });
        }
    },
    onReady: function() {
        app.look.navbar(this), 6 == this.data.order.cid && wx.setNavigationBarTitle({
            title: "抢购订单结算"
        }), 5 == this.data.order.cid && wx.setNavigationBarTitle({
            title: "团购订单结算"
        }), 4 == this.data.order.cid && wx.setNavigationBarTitle({
            title: "砍价订单结算"
        });
    },
    countPrice: function() {
        if (console.log("countPrice"), 1 == this.data.navIndex) {
            var a = (parseFloat(totalPrice) + parseFloat(express_price_1) + .001 - this.data.order.v_privce).toFixed(2);
            console.log(a), parseFloat(a) > parseFloat(this.data.money) && this.setData({
                staus: 2
            }), this.setData({
                express_price: express_price_1,
                pay_price: a
            });
        } else {
            var t = (totalPrice * parseInt(100 - app.globalData.webset.community_discount) / 100 + .001).toFixed(2);
            console.log(t);
            a = (parseFloat(totalPrice) + parseFloat(express_price_2) - parseFloat(t) + .001).toFixed(2);
            parseFloat(a) > parseFloat(this.data.money) && this.setData({
                staus: 2
            }), this.setData({
                express_price: express_price_2,
                pay_price: a,
                community_price: t
            });
        }
    },
    onShow: function() {
        var a = this, t = app.address;
        if (totalPrice = this.data.order.totalPrice, 1 == this.data.order.cid) {
            var e = app.voucher;
            null != e ? ("1" == e.cid && (totalPrice = this.data.order.totalPrice - parseFloat(e.num)), 
            "2" == e.cid && (totalPrice = this.data.order.totalPrice - parseFloat(e.num)), "3" == e.cid && (totalPrice = (this.data.order.totalPrice * parseFloat(e.num) / 10 + .001).toFixed(2)), 
            a.setData({
                voucher: e
            })) : a.setData({
                voucher: null
            });
        }
        console.log(t), null != t && (a.setData({
            address: t
        }), express_price_1 = app.look.count_express("", number, weight, t.region)), this.countPrice(), 
        a.data.isaddr && 1 == a.data.page && (a.data.longitude = -1, a.data.latitude = -1, 
        a.data.page = 0, a.loadClubList());
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});