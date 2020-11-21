var app = getApp(), WxParse = require("../../wxParse/wxParse.js"), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        hidden: !0,
        animationData: {},
        product: [],
        status: "",
        animationSwing: {},
        startPoint: [ 0, 0 ],
        orderC: !1,
        showModalStatus: !1,
        groupV: !1
    },
    onLoad: function(t) {
        var e = this;
        this.data.isLogin;
        wx.getStorageSync("openid") ? wx.getSetting({
            success: function(t) {
                t.authSetting["scope.userInfo"] && wx.getUserInfo({
                    success: function(t) {
                        e.setData({
                            isLogin: !1,
                            userInfo: t.userInfo
                        });
                    }
                });
            }
        }) : e.setData({
            isLogin: !0
        });
        e = this, wx.getStorageSync("users").openid;
        var a = t.gid, o = t.invuid;
        e.setData({
            gid: a,
            invuid: o
        });
    },
    shareCanvas: function() {
        var t = this, e = "/yzcj_sun/pages/ticket/ticketmiandetail/ticketmiandetail?gid=" + t.data.gid;
        console.log(e);
        var a = t.data.cjzt ? t.data.cjzt : "../addons/yzcj_sun/banner.jpg", o = t.data.product, n = [];
        n.gid = o.gid, n.url = t.data.url, n.logo = o.pic ? o.pic : a, console.log(n), app.func.creatPoster(app, e, 430, n, 1, "shareImg");
    },
    onShareAppMessage: function(t) {
        var e = this, a = (wx.getStorageSync("users").openid, wx.getStorageSync("users").id), o = e.data.gid, n = e.data.product.onename, i = t.target.dataset.name, s = e.data.product.group - e.data.product.groupcount, c = e.data.product;
        if (console.log("11111111111"), "button" === t.from) {
            if (console.log(t.target), i) {
                if (console.log("3333333"), 2 == t.target.dataset.cid) r = "红包 " + e.data.product.gname + " 元"; else r = n || e.data.product.gname;
                return {
                    title: "仅剩" + s + "个名额马上参与[" + r + "]抽奖",
                    path: "/yzcj_sun/pages/ticket/ticketmiandetail/ticketmiandetail?gid=" + o + "&invuid=" + a,
                    success: function(t) {},
                    fail: function(t) {}
                };
            }
            if (console.log("2222222222"), 2 == t.target.dataset.cid) {
                console.log(111);
                var r = "红包 " + e.data.product.gname + " 元";
            } else {
                console.log(222);
                var r = n || e.data.product.gname;
            }
            return {
                title: e.data.userInfo.nickName + "邀你参与[" + r + "]抽奖",
                path: 0 != c.oid ? "/yzcj_sun/pages/ticket/ticketmiandetail/ticketmiandetail?gid=" + o + "&invuid=" + a : "/yzcj_sun/pages/ticket/ticketmiandetail/ticketmiandetail?gid=" + o,
                success: function(t) {},
                fail: function(t) {}
            };
        }
        console.log(r);
    },
    hidden: function(t) {
        this.setData({
            hidden: !0
        });
    },
    save: function() {
        console.log("ssssss");
        var e = this;
        wx.saveImageToPhotosAlbum({
            filePath: e.data.prurl,
            success: function(t) {
                console.log("成功"), wx.showModal({
                    content: "图片已保存到相册，赶紧晒一下吧~",
                    showCancel: !1,
                    confirmText: "好哒",
                    confirmColor: "#ef8200",
                    success: function(t) {
                        t.confirm && (console.log("用户点击确定"), e.setData({
                            hidden: !0
                        }));
                    }
                });
            },
            fail: function(t) {
                console.log("失败"), wx.getSetting({
                    success: function(t) {
                        t.authSetting["scope.writePhotosAlbum"] || (console.log("进入信息授权开关页面"), wx.openSetting({
                            success: function(t) {
                                console.log("openSetting success", t.authSetting);
                            }
                        }));
                    }
                });
            }
        });
    },
    bindGetUserInfo: function(t) {
        var a = this;
        wx.setStorageSync("user_info", t.detail.userInfo);
        var o = t.detail.userInfo.nickName, n = t.detail.userInfo.avatarUrl;
        wx.login({
            success: function(t) {
                var e = t.code;
                app.util.request({
                    url: "entry/wxapp/openid",
                    cachetime: "0",
                    data: {
                        code: e
                    },
                    success: function(t) {
                        wx.setStorageSync("key", t.data.session_key), wx.setStorageSync("openid", t.data.openid);
                        var e = t.data.openid;
                        app.util.request({
                            url: "entry/wxapp/Login",
                            cachetime: "0",
                            data: {
                                openid: e,
                                img: n,
                                name: o
                            },
                            success: function(t) {
                                a.setData({
                                    isLogin: !1
                                }), wx.setStorageSync("users", t.data), wx.setStorageSync("uniacid", t.data.uniacid), 
                                a.onShow();
                            }
                        });
                    }
                });
            }
        });
    },
    gohome: function() {
        wx.reLaunch({
            url: "../ticketmiannew/ticketmiannew"
        });
    },
    onShow: function() {
        var t = wx.createAnimation({
            transformOrigin: "50% 50%",
            duration: 1e3,
            timingFunction: "ease-in-out",
            delay: 0
        });
        this.animation = t, this.setData({
            animationData: t.export()
        });
        var i = this, e = wx.getStorageSync("users").openid, s = i.data.gid, a = (wx.getStorageSync("users").id, 
        i.data.invuid);
        console.log(s), app.util.request({
            url: "entry/wxapp/ProDetail",
            data: {
                openid: e,
                gid: s,
                invuid: a
            },
            success: function(t) {
                if (console.log(t), 10001 == t.data.num) {
                    console.log(t.data.res);
                    var e = t.data.res, a = t.data.res.cjzt, o = t.data.res.content;
                    o && WxParse.wxParse("content", "html", o, i, 15);
                    var n = t.data.res.lottery;
                    n && WxParse.wxParse("lottery", "html", n, i, 15), i.setData({
                        product: e,
                        ad: t.data.ad[0],
                        cjzt: a,
                        oid: t.data.res.oid,
                        groupV: !!t.data.res.groupcount
                    }), 0 == t.data.res.oid ? i.setData({
                        status: !0
                    }) : i.setData({
                        status: !1
                    }), i.getUrl();
                } else 10002 == t.data.num ? app.util.request({
                    url: "entry/wxapp/AccessToken",
                    cachetime: "0",
                    success: function(t) {
                        var e = t.data.access_token;
                        app.util.request({
                            url: "entry/wxapp/ActiveMessage",
                            cachetime: "0",
                            data: {
                                gid: s,
                                page: "yzcj_sun/pages/ticket/ticketresults/ticketresults?gid=" + s,
                                access_token: e
                            },
                            success: function(t) {
                                console.log("模板消息发送"), wx.showToast({
                                    title: "已成功开奖！",
                                    icon: "",
                                    duration: 1e3,
                                    mask: !0
                                }), setTimeout(function(t) {
                                    wx.reLaunch({
                                        url: "../ticketmiannew/ticketmiannew"
                                    });
                                }, 1e3);
                            }
                        });
                    }
                }) : 10003 == t.data.num && wx.showModal({
                    title: "提示",
                    content: "抽奖正在审核中",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && wx.reLaunch({
                            url: "../ticketmiannew/ticketmiannew"
                        });
                    }
                });
            }
        });
    },
    rotateAndScale: function(t) {
        var e = this, a = wx.getStorageSync("users").openid, o = wx.getStorageSync("users").name, n = wx.getStorageSync("users").img, i = (wx.getStorageInfoSync("users").id, 
        e.data.invuid), s = e.data.gid, c = wx.getStorageSync("users").id, r = t.detail.formId, u = e.data.product.state;
        if ("" != a && "" != o && "" != n && "" != c && "" != s && null != a && null != o && null != n && null != c && null != s) if (this.animation.width("180rpx").height("180rpx").opacity(.3).step(), 
        this.setData({
            animationData: this.animation.export()
        }), console.log("111111111"), console.log(u), console.log(r), 1 == u) {
            var d = e.data.product.paidprice;
            app.util.request({
                url: "entry/wxapp/Orderarr",
                data: {
                    openid: a,
                    price: d
                },
                success: function(t) {
                    wx.requestPayment({
                        timeStamp: t.data.timeStamp,
                        nonceStr: t.data.nonceStr,
                        package: t.data.package,
                        signType: "MD5",
                        paySign: t.data.paySign,
                        success: function(t) {
                            console.log(t), app.util.request({
                                url: "entry/wxapp/TakePro",
                                data: {
                                    openid: a,
                                    gid: s,
                                    invuid: i,
                                    state: u
                                },
                                success: function(t) {
                                    console.log(333333), console.log(t), 10001 == t.data.num && wx.showToast({
                                        title: "队伍已满，请自行参与抽奖",
                                        icon: "none",
                                        duration: 2e3
                                    }), 10003 == t.data.num ? wx.showToast({
                                        title: "无法再获取抽奖码",
                                        icon: "none",
                                        duration: 2e3
                                    }) : (console.log(44444444), app.util.request({
                                        url: "entry/wxapp/SaveFormid",
                                        data: {
                                            openid: a,
                                            user_id: c,
                                            form_id: r,
                                            gid: s,
                                            state: 2
                                        },
                                        success: function(t) {
                                            console.log(t), e.setData({
                                                status: !1
                                            });
                                        }
                                    }), e.onShow());
                                }
                            });
                        },
                        fail: function() {
                            wx.showToast({
                                title: "支付失败",
                                icon: "none"
                            });
                        }
                    });
                }
            });
        } else {
            if (2 == u) return console.log("弹出口令输入"), e.setData({
                orderV: !0,
                showModalStatus: !0
            }), !1;
            console.log(22222222), app.util.request({
                url: "entry/wxapp/TakePro",
                data: {
                    openid: a,
                    gid: s,
                    invuid: i,
                    state: u
                },
                success: function(t) {
                    console.log(333333), console.log(t), 10001 == t.data.num && wx.showToast({
                        title: "队伍已满，请自行参与抽奖",
                        icon: "none",
                        duration: 2e3
                    }), 10003 == t.data.num && wx.showToast({
                        title: "无法再获取抽奖码",
                        icon: "none",
                        duration: 2e3
                    }), 10002 == t.data.num && (console.log(44444444), app.util.request({
                        url: "entry/wxapp/SaveFormid",
                        data: {
                            openid: a,
                            user_id: c,
                            form_id: r,
                            gid: s,
                            state: 2
                        },
                        success: function(t) {
                            console.log(t), e.setData({
                                status: !1
                            });
                        }
                    }), e.onShow());
                }
            });
        } else wx.showModal({
            title: "提示",
            content: "用户授权有误，无法参与抽奖，请重新授权！如若授权失败，请联系客服！",
            success: function(t) {
                t.confirm ? e.setData({
                    isLogin: !0
                }) : t.cancel && console.log("用户点击取消");
            }
        });
    },
    getUrl: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    goTicketadd: function(t) {
        wx.navigateTo({
            url: "../ticketadd/ticketadd"
        });
    },
    goTicketnum: function(t) {
        var e = t.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "../ticketnum/ticketnum?gid=" + e
        });
    },
    goXcx: function(t) {
        var e = t.currentTarget.dataset.appid;
        wx.navigateToMiniProgram({
            appId: e,
            path: "",
            extraData: {
                foo: "bar"
            },
            envVersion: "develop",
            success: function(t) {
                console.log(t);
            }
        });
    },
    touchstart: function(t) {
        this.setData({
            startPoint: [ t.touches[0].pageX, t.touches[0].pageY ]
        });
    },
    touchmove: function(t) {
        var e, a = [ t.touches[0].pageX, t.touches[0].pageY ], o = this.data.startPoint;
        20 < o[0] - a[0] && ((e = wx.createAnimation({
            duration: 1e3,
            timingFunction: "ease"
        })).translateX(-240, 0).step({
            duration: 1e3
        }), this.setData({
            animationSwing: e.export()
        }));
        20 < a[0] - o[0] && ((e = wx.createAnimation({
            duration: 1e3,
            timingFunction: "ease"
        })).translateX(0, 0).step({
            duration: 1e3
        }), this.setData({
            animationSwing: e.export()
        }));
    },
    createGroup: function(t) {
        var e = this, a = e.data.gid, o = wx.getStorageSync("users").id, n = e.data.oid;
        wx.showModal({
            title: "提示",
            content: "是否创建队伍",
            success: function(t) {
                t.confirm ? app.util.request({
                    url: "entry/wxapp/GoGroup",
                    data: {
                        oid: n,
                        uid: o,
                        gid: a
                    },
                    success: function(t) {
                        console.log(t), console.log("111111"), t && (e.setData({
                            groupV: !0
                        }), e.onShow());
                    }
                }) : t.cancel && console.log("用户点击取消");
            }
        });
    },
    orderInput: function(t) {
        var e = t.detail.value;
        this.setData({
            uorder: e
        });
    },
    orderSubmit: function(t) {
        var e = this, a = e.data.uorder, o = e.data.product.password, n = wx.getStorageSync("users").openid, i = wx.getStorageInfoSync("users").id, s = e.data.gid, c = wx.getStorageSync("users").id, r = t.detail.formId, u = e.data.product.state;
        console.log(a), console.log(o), a == o ? (console.log(11111), e.setData({
            orderV: !1,
            showModalStatus: !1
        }), wx.showToast({
            title: "口令正确",
            duration: 2e3
        }), app.util.request({
            url: "entry/wxapp/TakePro",
            data: {
                openid: n,
                gid: s,
                invuid: i,
                state: u
            },
            success: function(t) {
                10001 == t.data.num && (console.log(111111), wx.showToast({
                    title: "队伍已满，请自行参与抽奖",
                    icon: "none"
                })), 10003 == t.data.num && (console.log(2222), wx.showToast({
                    title: "无法再获取抽奖码",
                    icon: "none"
                })), 10002 == t.data.num && (console.log(23333), app.util.request({
                    url: "entry/wxapp/SaveFormid",
                    data: {
                        openid: n,
                        user_id: c,
                        form_id: r,
                        gid: s,
                        state: 2
                    },
                    success: function(t) {
                        console.log(t), e.setData({
                            oid: t.data.oid
                        });
                    }
                })), e.onShow();
            }
        })) : (e.setData({
            orderV: !1,
            showModalStatus: !1
        }), wx.showToast({
            title: "口令错误",
            icon: "none"
        }));
    },
    close: function() {
        this.setData({
            orderV: !1,
            showModalStatus: !1
        });
    },
    preview_img: function(t) {
        var e = this.data.url + t.currentTarget.dataset.path, a = [];
        a.push(e), wx.previewImage({
            current: e,
            urls: a
        });
    }
});