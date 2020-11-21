var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        index: 0,
        is_modal_Hidden: !0
    },
    onLoad: function(a) {
        var c = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var e = [ {
            name: "微信支付",
            value: "微信支付",
            checked: "true"
        }, {
            name: "余额支付",
            value: "余额支付"
        } ];
        app.util.request({
            url: "entry/wxapp/drinkbalance",
            cachetime: "0",
            success: function(a) {
                1 != a.data && e.splice(1, 1), c.setData({
                    items: e
                });
            }
        }), c.url();
        var s = a.ids, r = a.id, t = a.num, n = wx.getStorageSync("openid");
        wx.setStorageSync("bid", a.bid), app.util.request({
            url: "entry/wxapp/CartPayData",
            cachetime: "0",
            data: {
                ids: s,
                id: r,
                num: t,
                openid: n
            },
            success: function(a) {
                console.log(a.data);
                for (var e = 0, t = 0, n = 0, o = "", i = 0; i < a.data.length; i++) e += a.data[i].drink_price * a.data[i].num, 
                t += parseInt(a.data[i].num), n += a.data[i].integral, o += a.data[i].drink_name + ",";
                0 < o.length && (o = o.substr(0, o.length - 1)), n = n.toFixed(2), e = e.toFixed(2), 
                console.log(e), c.setData({
                    payData: a.data,
                    allprice: e,
                    allnum: t,
                    ids: s,
                    id: r,
                    integral: n,
                    radios: "微信支付",
                    drink_name: o
                });
            }
        });
    },
    radioChange: function(a) {
        console.log("radio发生change事件，携带value值为：", a.detail.value), this.setData({
            radios: a.detail.value
        });
    },
    bindPickerChange: function(a) {
        console.log("picker发送选择改变，携带值为", a.detail.value);
        var e = a.detail.value;
        this.setData({
            index: a.detail.value,
            roomnum: this.data.array[e].room_num
        });
    },
    url: function(a) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Url2",
            cachetime: "0",
            success: function(a) {
                wx.setStorageSync("url2", a.data);
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(a) {
                wx.setStorageSync("url", a.data), e.setData({
                    url: a.data
                });
            }
        });
    },
    bindSave: function(a) {
        var e = this;
        console.log(a);
        var n = a.detail.formId, t = e.data.radios, o = a.detail.value.roomnum, i = a.detail.value.mobile, c = wx.getStorageSync("openid"), s = wx.getStorageSync("bid");
        if (c) if ("" != o) if ("" != i) {
            var r = e.data.integral;
            e.data.ids ? "微信支付" == t ? wx.getStorage({
                key: "openid",
                success: function(a) {
                    var n = a.data;
                    app.util.request({
                        url: "entry/wxapp/Orderarr",
                        cachetime: "30",
                        data: {
                            openid: n,
                            price: e.data.allprice
                        },
                        success: function(a) {
                            var t = a.data.package;
                            wx.requestPayment({
                                timeStamp: a.data.timeStamp,
                                nonceStr: a.data.nonceStr,
                                package: a.data.package,
                                signType: "MD5",
                                paySign: a.data.paySign,
                                success: function(a) {
                                    wx.getStorage({
                                        key: "openid",
                                        success: function(a) {
                                            app.util.request({
                                                url: "entry/wxapp/PayCart",
                                                cachetime: "0",
                                                data: {
                                                    crid: e.data.ids,
                                                    openid: n,
                                                    allprice: e.data.allprice,
                                                    allnum: e.data.allnum,
                                                    roomnum: o,
                                                    mobile: i,
                                                    integral: r,
                                                    bid: s
                                                },
                                                success: function(a) {
                                                    console.log(a.data);
                                                    var e = a.data.id;
                                                    console.log(e), app.util.request({
                                                        url: "entry/wxapp/Paysuccess",
                                                        cachetime: "0",
                                                        data: {
                                                            prepay_id: t,
                                                            oid: e,
                                                            openid: n,
                                                            local: 2,
                                                            cate: 1
                                                        },
                                                        success: function(a) {
                                                            console.log(a.data), wx.redirectTo({
                                                                url: "../../my/myorder/myorder"
                                                            });
                                                        }
                                                    });
                                                }
                                            });
                                        }
                                    });
                                },
                                fail: function(a) {}
                            });
                        }
                    });
                }
            }) : wx.getStorage({
                key: "openid",
                success: function(a) {
                    var t = a.data;
                    app.util.request({
                        url: "entry/wxapp/BalancePay",
                        cachetime: "0",
                        data: {
                            openid: t,
                            total: e.data.allprice,
                            name: e.data.drink_name
                        },
                        success: function(a) {
                            1 == a.data ? app.util.request({
                                url: "entry/wxapp/PayCart",
                                cachetime: "0",
                                data: {
                                    crid: e.data.ids,
                                    openid: t,
                                    allprice: e.data.allprice,
                                    allnum: e.data.allnum,
                                    roomnum: o,
                                    mobile: i,
                                    integral: r,
                                    bid: s
                                },
                                success: function(a) {
                                    var e = a.data.id;
                                    console.log(e), app.util.request({
                                        url: "entry/wxapp/Paysuccess",
                                        cachetime: "0",
                                        data: {
                                            formId: n,
                                            oid: e,
                                            openid: t,
                                            local: 2,
                                            cate: 2
                                        },
                                        success: function(a) {}
                                    }), wx.redirectTo({
                                        url: "../../my/myorder/myorder"
                                    });
                                }
                            }) : wx.showToast({
                                title: "余额不足",
                                icon: "none",
                                duration: 2e3
                            });
                        }
                    });
                }
            }) : "微信支付" == t ? wx.getStorage({
                key: "openid",
                success: function(a) {
                    var n = a.data;
                    app.util.request({
                        url: "entry/wxapp/Orderarr",
                        cachetime: "30",
                        data: {
                            openid: n,
                            price: e.data.allprice
                        },
                        success: function(a) {
                            var t = a.data.package;
                            wx.requestPayment({
                                timeStamp: a.data.timeStamp,
                                nonceStr: a.data.nonceStr,
                                package: a.data.package,
                                signType: "MD5",
                                paySign: a.data.paySign,
                                success: function(a) {
                                    wx.getStorage({
                                        key: "openid",
                                        success: function(a) {
                                            app.util.request({
                                                url: "entry/wxapp/PayBuy",
                                                cachetime: "0",
                                                data: {
                                                    id: e.data.id,
                                                    openid: n,
                                                    allprice: e.data.allprice,
                                                    allnum: e.data.allnum,
                                                    roomnum: o,
                                                    mobile: i,
                                                    integral: r,
                                                    bid: s
                                                },
                                                success: function(a) {
                                                    var e = a.data.id;
                                                    app.util.request({
                                                        url: "entry/wxapp/Paysuccess",
                                                        cachetime: "0",
                                                        data: {
                                                            prepay_id: t,
                                                            oid: e,
                                                            openid: n,
                                                            local: 2,
                                                            cate: 1
                                                        },
                                                        success: function(a) {
                                                            console.log(a.data), wx.redirectTo({
                                                                url: "../../my/myorder/myorder"
                                                            });
                                                        }
                                                    });
                                                }
                                            });
                                        }
                                    });
                                },
                                fail: function(a) {}
                            });
                        }
                    });
                }
            }) : wx.getStorage({
                key: "openid",
                success: function(a) {
                    var t = a.data;
                    app.util.request({
                        url: "entry/wxapp/BalancePay",
                        cachetime: "0",
                        data: {
                            openid: t,
                            total: e.data.allprice,
                            name: e.data.drink_name
                        },
                        success: function(a) {
                            1 == a.data ? app.util.request({
                                url: "entry/wxapp/PayBuy",
                                cachetime: "0",
                                data: {
                                    id: e.data.id,
                                    openid: t,
                                    allprice: e.data.allprice,
                                    allnum: e.data.allnum,
                                    roomnum: o,
                                    mobile: i,
                                    integral: r,
                                    bid: s
                                },
                                success: function(a) {
                                    console.log(a.data);
                                    var e = a.data.id;
                                    app.util.request({
                                        url: "entry/wxapp/Paysuccess",
                                        cachetime: "0",
                                        data: {
                                            formId: n,
                                            oid: e,
                                            openid: t,
                                            local: 2,
                                            cate: 2
                                        },
                                        success: function(a) {}
                                    }), wx.redirectTo({
                                        url: "../../my/myorder/myorder"
                                    });
                                }
                            }) : wx.showToast({
                                title: "余额不足",
                                icon: "none",
                                duration: 2e3
                            });
                        }
                    });
                }
            });
        } else wx.showModal({
            title: "提示",
            content: "未填写手机号",
            showCancel: !1
        }); else wx.showModal({
            title: "提示",
            content: "输入包间号",
            showCancel: !1
        }); else e.wxauthSetting();
    },
    wxauthSetting: function(a) {
        var i = this;
        wx.getStorageSync("openid") ? wx.getSetting({
            success: function(a) {
                console.log("进入wx.getSetting 1"), console.log(a), a.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权 1"), 
                wx.getUserInfo({
                    success: function(a) {
                        i.setData({
                            is_modal_Hidden: !0,
                            thumb: a.userInfo.avatarUrl,
                            nickname: a.userInfo.nickName
                        });
                    }
                })) : (console.log("scope.userInfo没有授权 1"), wx.showModal({
                    title: "获取信息失败",
                    content: "请允许授权以便为您提供给服务",
                    success: function(a) {
                        i.setData({
                            is_modal_Hidden: !1
                        });
                    }
                }));
            },
            fail: function(a) {
                console.log("获取权限失败 1"), i.setData({
                    is_modal_Hidden: !1
                });
            }
        }) : wx.login({
            success: function(a) {
                console.log("进入wx-login");
                var e = a.code;
                wx.setStorageSync("code", e), wx.getSetting({
                    success: function(a) {
                        console.log("进入wx.getSetting"), console.log(a), a.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权"), 
                        wx.getUserInfo({
                            success: function(a) {
                                i.setData({
                                    is_modal_Hidden: !0,
                                    thumb: a.userInfo.avatarUrl,
                                    nickname: a.userInfo.nickName
                                }), console.log("进入wx-getUserInfo"), console.log(a.userInfo), wx.setStorageSync("user_info", a.userInfo), 
                                wx.setStorageSync("userInfo", a.userInfo);
                                var t = a.userInfo.nickName, n = a.userInfo.avatarUrl, o = a.userInfo.gender;
                                app.util.request({
                                    url: "entry/wxapp/openid",
                                    cachetime: "0",
                                    data: {
                                        code: e
                                    },
                                    success: function(a) {
                                        console.log("进入获取openid"), console.log(a.data), wx.setStorageSync("key", a.data.session_key), 
                                        wx.setStorageSync("openid", a.data.openid);
                                        var e = a.data.openid;
                                        console.log(e), wx.setStorageSync("userid", a.data.openid), wx.setStorage({
                                            key: "openid",
                                            data: e
                                        }), console.log(t), app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: e,
                                                img: n,
                                                name: t,
                                                gender: o
                                            },
                                            success: function(a) {
                                                console.log("进入地址login"), console.log(a.data), wx.setStorageSync("users", a.data), 
                                                wx.setStorageSync("uniacid", a.data.uniacid), i.setData({
                                                    usersinfo: a.data
                                                });
                                            }
                                        });
                                    }
                                }), i.onShow();
                            },
                            fail: function(a) {
                                console.log("进入 wx-getUserInfo 失败"), wx.showModal({
                                    title: "获取信息失败",
                                    content: "请允许授权以便为您提供给服务!",
                                    success: function(a) {
                                        i.setData({
                                            is_modal_Hidden: !1
                                        });
                                    }
                                });
                            }
                        })) : (console.log("scope.userInfo没有授权"), i.setData({
                            is_modal_Hidden: !1
                        }));
                    }
                });
            },
            fail: function() {
                wx.showModal({
                    title: "获取信息失败",
                    content: "请允许授权以便为您提供给服务!!!",
                    success: function(a) {
                        i.setData({
                            is_modal_Hidden: !1
                        });
                    }
                });
            }
        });
    },
    updateUserInfo: function(a) {
        console.log("授权操作更新");
        this.wxauthSetting();
    },
    onReady: function() {},
    onShow: function() {
        var e = this, a = wx.getStorageSync("bid");
        app.util.request({
            url: "entry/wxapp/roomDatas",
            cachetime: "0",
            data: {
                bid: a
            },
            success: function(a) {
                console.log(a.data), e.setData({
                    array: a.data,
                    roomnum: a.data[0].room_num
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    addnum: function(a) {
        var e = this.data.numvalue + 1;
        this.setData({
            numvalue: e
        });
    },
    subbnum: function(a) {
        var e = this.data.numvalue;
        1 < this.data.numvalue && (e = this.data.numvalue - 1), this.setData({
            numvalue: e
        });
    }
});