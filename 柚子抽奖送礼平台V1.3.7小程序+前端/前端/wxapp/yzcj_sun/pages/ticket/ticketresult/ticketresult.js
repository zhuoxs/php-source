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
        showModalStatus: !1
    },
    onLoad: function(t) {
        var a = this, e = t.gid;
        a.setData({
            gid: e
        }), console.log(a.data.gid), wx.getUserInfo({
            success: function(t) {
                a.setData({
                    userInfo: t.userInfo
                });
            }
        });
    },
    onReady: function() {},
    shareCanvas: function() {
        var t = this, a = "yzcj_sun/pages/ticket/ticketmiandetail/ticketmiandetail?gid=" + t.data.gid, e = t.data.cjzt ? t.data.cjzt : "../addons/yzcj_sun/banner.jpg";
        console.log(a);
        var n = t.data.product, o = [];
        o.gid = n.gid, o.url = t.data.url, o.logo = n.pic ? n.pic : e, console.log(o), app.func.creatPoster(app, a, 430, o, 1, "shareImg");
    },
    onShareAppMessage: function(t) {
        var a = this, e = (wx.getStorageSync("users").openid, wx.getStorageSync("users").id), n = a.data.gid, o = a.data.product.onename, i = t.target.dataset.name, s = a.data.product.group - a.data.product.groupcount, c = a.data.product;
        if (console.log(e), "button" === t.from) {
            if (console.log(t.target), i) {
                if (console.log("3333333"), 2 == t.target.dataset.cid) r = "红包 " + a.data.product.gname + " 元"; else r = o || a.data.product.gname;
                return a.createGroup(), {
                    title: "仅剩" + s + "个名额马上参与[" + r + "]抽奖",
                    path: "/yzcj_sun/pages/ticket/ticketmiandetail/ticketmiandetail?gid=" + n + "&invuid=" + e,
                    success: function(t) {},
                    fail: function(t) {}
                };
            }
            if (2 == t.target.dataset.cid) var r = "红包 " + a.data.product.gname + " 元"; else var r = o || a.data.product.gname;
            return {
                title: a.data.userInfo.nickName + "邀你参与[" + r + "]抽奖",
                path: 0 != c.oid ? "/yzcj_sun/pages/ticket/ticketmiandetail/ticketmiandetail?gid=" + n + "&invuid=" + e : "/yzcj_sun/pages/ticket/ticketmiandetail/ticketmiandetail?gid=" + n,
                success: function(t) {},
                fail: function(t) {}
            };
        }
        return console.log(r), {
            title: a.data.userInfo.nickName + "邀你参与[" + r + "]抽奖",
            path: "/yzcj_sun/pages/ticket/ticketmiandetail/ticketmiandetail?gid=" + n + "&invuid=" + e,
            success: function(t) {},
            fail: function(t) {}
        };
    },
    hidden: function(t) {
        this.setData({
            hidden: !0
        });
    },
    save: function() {
        console.log("ssss");
        var a = this;
        wx.saveImageToPhotosAlbum({
            filePath: a.data.prurl,
            success: function(t) {
                console.log("成功"), wx.showModal({
                    content: "图片已保存到相册，赶紧晒一下吧~",
                    showCancel: !1,
                    confirmText: "好哒",
                    confirmColor: "#ef8200",
                    success: function(t) {
                        t.confirm && (console.log("用户点击确定"), a.setData({
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
        var i = this, a = wx.getStorageSync("users").openid, s = i.data.gid;
        app.util.request({
            url: "entry/wxapp/IniProDetail",
            data: {
                openid: a,
                gid: s
            },
            success: function(t) {
                if (console.log(t.data), 10001 == t.data.num) {
                    t.data.res;
                    var a = t.data.res.cjzt, e = parseInt(t.data.res.onenum) + parseInt(t.data.res.twonum) + parseInt(t.data.res.threenum), n = t.data.res.content;
                    n && WxParse.wxParse("content", "html", n, i, 15);
                    var o = t.data.res.lottery;
                    o && WxParse.wxParse("lottery", "html", o, i, 15), i.setData({
                        product: t.data.res,
                        ad: t.data.ad[0],
                        oid: t.data.res.oid,
                        cjzt: a,
                        dj: e
                    }), 0 == t.data.res.oid ? i.setData({
                        status: !0
                    }) : i.setData({
                        status: !1
                    }), i.getUrl();
                } else 10002 == t.data.num && app.util.request({
                    url: "entry/wxapp/AccessToken",
                    cachetime: "0",
                    success: function(t) {
                        var a = t.data.access_token;
                        app.util.request({
                            url: "entry/wxapp/ActiveMessage",
                            cachetime: "0",
                            data: {
                                gid: s,
                                page: "yzcj_sun/pages/ticket/ticketresults/ticketresults?gid=" + s,
                                access_token: a
                            },
                            success: function(t) {
                                console.log("模板消息发送"), wx.showToast({
                                    title: "已成功开奖！",
                                    icon: "",
                                    duration: 1e3,
                                    mask: !0
                                }), setTimeout(function(t) {
                                    wx.navigateBack({
                                        url: "../ticketlaunch/ticketlaunch"
                                    });
                                }, 1e3);
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
    rotateAndScale: function(t) {
        var a = this, e = wx.getStorageSync("users").openid, n = wx.getStorageSync("users").name, o = wx.getStorageSync("users").img, i = wx.getStorageInfoSync("users").id, s = a.data.gid, c = wx.getStorageSync("users").id, r = t.detail.formId, u = a.data.product.state;
        if ("" != e && "" != n && "" != o && "" != c && "" != s && null != e && null != n && null != o && null != c && null != s) if (this.animation.width("180rpx").height("180rpx").opacity(.3).step(), 
        this.setData({
            animationData: this.animation.export()
        }), console.log(11111111), 1 == u) {
            console.log(22222222);
            var d = a.data.product.paidprice;
            console.log(d), console.log(e), app.util.request({
                url: "entry/wxapp/Orderarr",
                data: {
                    openid: e,
                    price: d
                },
                success: function(t) {
                    console.log("aaaa"), wx.requestPayment({
                        timeStamp: t.data.timeStamp,
                        nonceStr: t.data.nonceStr,
                        package: t.data.package,
                        signType: "MD5",
                        paySign: t.data.paySign,
                        success: function(t) {
                            console.log("bbbbb"), app.util.request({
                                url: "entry/wxapp/TakePro",
                                data: {
                                    openid: e,
                                    gid: s,
                                    invuid: i,
                                    state: u
                                },
                                success: function(t) {
                                    10001 == t.data.num && wx.showToast({
                                        title: "队伍已满，请自行参与抽奖",
                                        icon: "none",
                                        duration: 2e3
                                    }), 10003 == t.data.num ? wx.showToast({
                                        title: "无法再获取抽奖码",
                                        icon: "none",
                                        duration: 2e3
                                    }) : (app.util.request({
                                        url: "entry/wxapp/SaveFormid",
                                        data: {
                                            openid: e,
                                            user_id: c,
                                            form_id: r,
                                            gid: s,
                                            state: 2
                                        },
                                        success: function(t) {
                                            a.setData({
                                                status: !1
                                            });
                                        }
                                    }), a.onShow());
                                }
                            });
                        },
                        fail: function() {
                            wx.showToast({
                                title: "支付失败",
                                icon: "none",
                                duration: 2e3
                            });
                        }
                    });
                }
            });
        } else {
            if (2 == u) return console.log(333333), a.setData({
                orderV: !0,
                showModalStatus: !0
            }), !1;
            console.log(44444444), app.util.request({
                url: "entry/wxapp/TakePro",
                data: {
                    openid: e,
                    gid: s,
                    invuid: i,
                    state: u
                },
                success: function(t) {
                    console.log(t), 10001 == t.data.num && wx.showToast({
                        title: "队伍已满，请自行参与抽奖",
                        icon: "none",
                        duration: 2e3
                    }), 10003 == t.data.num && wx.showToast({
                        title: "无法再获取抽奖码",
                        icon: "none",
                        duration: 2e3
                    }), 10002 == t.data.num && (app.util.request({
                        url: "entry/wxapp/SaveFormid",
                        data: {
                            openid: e,
                            user_id: c,
                            form_id: r,
                            gid: s,
                            state: 2
                        },
                        success: function(t) {
                            a.setData({
                                status: !1
                            });
                        }
                    }), a.onShow());
                }
            });
        } else wx.showModal({
            title: "提示",
            content: "用户授权有误，无法参与抽奖，请重新授权！如若授权失败，请联系客服！",
            success: function(t) {
                t.confirm ? a.setData({
                    isLogin: !0
                }) : t.cancel;
            }
        });
    },
    getUrl: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
    },
    goXcx: function(t) {
        var a = t.currentTarget.dataset.appid;
        wx.navigateToMiniProgram({
            appId: a,
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
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    goEditor: function() {
        wx.navigateTo({
            url: "../ticketeditor/ticketeditor"
        });
    },
    onDolottery: function(t) {
        var e = this.data.gid;
        t.detail.formId, wx.getStorageSync("users").openid, wx.getStorageSync("users").id;
        app.util.request({
            url: "entry/wxapp/DoLottery",
            data: {
                gid: e
            },
            success: function(t) {
                1 == t.data ? wx.showToast({
                    title: "参与用户为空！",
                    icon: "",
                    duration: 1e3,
                    mask: !0
                }) : app.util.request({
                    url: "entry/wxapp/AccessToken",
                    cachetime: "0",
                    success: function(t) {
                        var a = t.data.access_token;
                        app.util.request({
                            url: "entry/wxapp/ActiveMessage",
                            cachetime: "0",
                            data: {
                                gid: e,
                                page: "yzcj_sun/pages/ticket/ticketresults/ticketresults?gid=" + e,
                                access_token: a
                            },
                            success: function(t) {
                                console.log("模板消息发送"), wx.navigateBack({
                                    url: "../ticketlaunch/ticketlaunch"
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    goTicketadd: function(t) {
        wx.navigateTo({
            url: "../ticketadd/ticketadd"
        });
    },
    goSeeAddress: function(t) {
        var a = t.currentTarget.dataset.gid, e = t.currentTarget.dataset.oid;
        wx.setStorageSync("gid", a), wx.setStorageSync("oid", e), wx.navigateTo({
            url: "../seeaddress/seeaddress"
        });
    },
    goTicketnum: function(t) {
        var a = t.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "../ticketnum/ticketnum?gid=" + a
        });
    },
    touchstart: function(t) {
        this.setData({
            startPoint: [ t.touches[0].pageX, t.touches[0].pageY ]
        });
    },
    touchmove: function(t) {
        var a, e = [ t.touches[0].pageX, t.touches[0].pageY ], n = this.data.startPoint;
        20 < n[0] - e[0] && ((a = wx.createAnimation({
            duration: 1e3,
            timingFunction: "ease"
        })).translateX(-240, 0).step({
            duration: 1e3
        }), this.setData({
            animationSwing: a.export()
        }));
        20 < e[0] - n[0] && ((a = wx.createAnimation({
            duration: 1e3,
            timingFunction: "ease"
        })).translateX(0, 0).step({
            duration: 1e3
        }), this.setData({
            animationSwing: a.export()
        }));
    },
    createGroup: function() {
        var a = this, t = a.data.gid, e = wx.getStorageSync("users").id, n = a.data.oid;
        console.log(n), console.log(t), app.util.request({
            url: "entry/wxapp/GoGroup",
            data: {
                oid: n,
                uid: e,
                gid: t
            },
            success: function(t) {
                console.log(t), t && (console.log("组队成功"), a.onShow());
            }
        });
    },
    orderInput: function(t) {
        var a = t.detail.value;
        this.setData({
            uorder: a
        });
    },
    orderSubmit: function(t) {
        var a = this, e = a.data.uorder, n = a.data.product.password, o = wx.getStorageSync("users").openid, i = wx.getStorageInfoSync("users").id, s = a.data.gid, c = wx.getStorageSync("users").id, r = t.detail.formId, u = a.data.product.state;
        e == n ? (a.setData({
            orderV: !1,
            showModalStatus: !1
        }), wx.showToast({
            title: "口令正确",
            duration: 2e3
        }), app.util.request({
            url: "entry/wxapp/TakePro",
            data: {
                openid: o,
                gid: s,
                invuid: i,
                state: u
            },
            success: function(t) {
                10001 == t.data.num && wx.showToast({
                    title: "队伍已满，请自行参与抽奖",
                    icon: "none"
                }), 10003 == t.data.num && wx.showToast({
                    title: "无法再获取抽奖码",
                    icon: "none"
                }), 10002 == t.data.num && app.util.request({
                    url: "entry/wxapp/SaveFormid",
                    data: {
                        openid: o,
                        user_id: c,
                        form_id: r,
                        gid: s,
                        state: 2
                    },
                    success: function(t) {
                        a.setData({
                            oid: t.data.oid
                        });
                    }
                }), a.onShow();
            }
        })) : (a.setData({
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
    }
});