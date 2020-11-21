function _defineProperty(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

var app = getApp(), goods = [], webim = require("../../../we7/resource/js/webim_wx.js"), webimhandler = require("../../../we7/resource/js/webim_handler.js");

global.webim = webim;

var Config = {
    sdkappid: null,
    accountType: null,
    accountMode: 0
}, ctx = null, factor = {
    speed: .0088,
    t: 0
}, timer = null, timer_Dialog = null, timer_onlineNum = null, startTime = null;

function loadDialog(n) {
    console.log(startTime), app.util.request({
        url: "entry/wxapp/live",
        method: "POST",
        showLoading: !1,
        data: {
            op: "loadDialog",
            time: startTime,
            live_id: n.data.list.id
        },
        success: function(t) {
            var e = t.data;
            if (e.data.list) {
                var s = n.data.msgs;
                console.log(s), e.data.list.forEach(function(t, e) {
                    var a;
                    if (2 == t.type) n.setData((_defineProperty(a = {}, "tip.name", t.fromAccountNick), 
                    _defineProperty(a, "tip.avatar", ""), _defineProperty(a, "tip.style", 2), _defineProperty(a, "tip.text", "进入了房间"), 
                    a)), n.showD(), startTime = t.createtime; else if (3 == t.type) {
                        var i;
                        n.setData((_defineProperty(i = {}, "tip.name", t.fromAccountNick), _defineProperty(i, "tip.avatar", t.avatarurl), 
                        _defineProperty(i, "tip.style", 2), _defineProperty(i, "tip.text", "给主播点了个赞"), i)), 
                        n.showD(), startTime = t.createtime;
                    } else if (4 == t.type) {
                        var o;
                        n.setData((_defineProperty(o = {}, "tip.name", t.fromAccountNick), _defineProperty(o, "tip.avatar", t.avatarurl), 
                        _defineProperty(o, "tip.style", 1), _defineProperty(o, "tip.text", "刚刚剁了手"), o)), 
                        n.showD(), startTime = t.createtime;
                    } else 1 == t.type && (startTime = t.createtime, s.push(t));
                }), n.setData(_defineProperty({
                    msgs: s
                }, "list.number", t.data.data.num)), n.dialogTobottom();
            }
        },
        fail: function(t) {
            t && t.data && t.data.data && t.data.data.num && n.setData(_defineProperty({}, "list.number", t.data.data.num));
        }
    }), timer_Dialog = setTimeout(function() {
        loadDialog(n);
    }, 1e3 * app.globalData.webset.live_dialog_time);
}

function sendMsgs(t, e, a, i) {
    app.util.request({
        url: "entry/wxapp/live",
        showLoading: !1,
        method: "POST",
        data: {
            op: "createDialog",
            live_id: t.data.list.id,
            type: e,
            text: a
        },
        success: function(t) {},
        fail: function(t) {
            2 == t.data.errno && app.look.no(t.data.message);
        }
    });
}

Page({
    data: {
        userinfo: {},
        msgs: [],
        Identifier: null,
        UserSig: null,
        msgContent: "",
        tip: [],
        value: "",
        keyboard: !1,
        agree: !1,
        model: !1,
        num: 1,
        style_img: "",
        scrollTop: 0,
        region: [ "请选择" ],
        myAddress: null
    },
    toLiveindex: function() {
        var t = 1 == this.data.options.style ? this.data.list.id : this.data.list.live_id;
        wx.redirectTo({
            url: "../liveIndex/liveIndex?id=" + t
        });
    },
    zhuyi: function() {
        wx.redirectTo({
            url: "/xc_xinguwu/pages/index/index"
        });
    },
    toAtten: function() {
        var t = 1 == this.data.options.style ? this.data.list.id : this.data.list.live_id, e = this;
        app.util.request({
            url: "entry/wxapp/live",
            method: "POST",
            showLoading: !1,
            data: {
                op: "live_focus_change",
                live_id: t,
                status: -e.data.list.focused
            },
            success: function(t) {
                e.setData(_defineProperty({}, "list.focused", -e.data.list.focused));
            }
        });
    },
    showInput: function() {
        this.setData({
            keyboard: !0
        });
    },
    hideinput: function(t) {
        this.setData({
            keyboard: !1
        });
    },
    inputvale: function(t) {
        this.setData({
            value: t.detail.value
        });
    },
    showList: function(t) {
        this.setData({
            showList: !0,
            model: !0
        });
    },
    closeList: function() {
        this.setData({
            showList: !1,
            model: !1
        });
    },
    closeSize: function() {
        this.setData({
            choSize: !1,
            showList: !0,
            model: !0
        });
    },
    selectedList: function(t) {
        var a = this, e = t.currentTarget.dataset.index, i = a.data.list.contents[e].id;
        this.setData({
            choSize: !0,
            showList: !0,
            model: !0
        }), goods.hasOwnProperty(i) ? a.setData({
            good: goods[i],
            good_img: goods[i].bimg,
            good_price: goods[i].prices,
            attred: "",
            num: 1
        }) : app.util.request({
            url: "entry/wxapp/live",
            method: "POST",
            showLoading: !1,
            data: {
                op: "get_good_info",
                id: i
            },
            success: function(t) {
                var e = t.data;
                e.data.list && (a.setData({
                    good: e.data.list,
                    good_img: e.data.list.bimg,
                    good_price: e.data.list.prices,
                    attred: "",
                    num: 1
                }), goods[i] = e.data.list);
            }
        });
    },
    chooseAttr: function(t) {
        var e = this, a = t.currentTarget.dataset.index;
        console.log(e.data.good), parseInt(e.data.good.attrs[a].stock) <= 0 ? app.look.alert("没有库存") : this.setData({
            attred: a,
            good_price: e.data.good.attrs[a].price,
            good_img: e.data.good.attrs[a].img,
            num: 1
        });
    },
    addCount: function(t) {
        var e = this, a = this.data.num;
        a += 1, parseInt(e.data.good.attrs[e.data.attred].stock) < a ? app.look.alert("库存不足") : this.setData({
            num: a,
            good_price: parseFloat(e.data.good.attrs[e.data.attred].price) * a
        });
    },
    minusCount: function(t) {
        var e = this.data.num;
        e <= 1 || (e -= 1, this.setData({
            num: e,
            good_price: parseFloat(this.data.good.attrs[this.data.attred].price) * e
        }));
    },
    toBuy: function(t) {
        var e = t.currentTarget.dataset.mode, a = this;
        if ("" != a.data.attred) {
            if (1 == e) {
                var i = wx.getStorageSync("cars") || [], o = !1;
                if (i && i.forEach(function(t, e) {
                    t.id == a.data.good.id && t.attr == a.data.attred && (o = !0, app.look.alert("该商品已在购物车中"));
                }), o) return;
                i.push({
                    id: a.data.good.id,
                    num: a.data.num,
                    price: a.data.good.attrs[a.data.attred].price,
                    cid: 1,
                    attr: a.data.attred
                }), wx.setStorage({
                    key: "cars",
                    data: i,
                    success: function() {
                        app.look.ok("已加入购物车");
                    }
                });
            }
            2 == e && (a.setData(_defineProperty({
                submit: !0,
                showList: !0
            }, "showList", !1)), this.countPrice());
        } else app.look.alert("请先选择属性");
    },
    countPrice: function() {
        var t = this.data.address;
        if (null == t) this.setData({
            pay_price: this.data.good_price
        }); else {
            var e = this, a = app.globalData.express, i = e.data.num, o = parseInt(i) * parseInt(e.data.good.weight), s = app.look.count_express(a, i, o, t.region), n = (parseFloat(e.data.good_price) + parseFloat(s)).toFixed(2);
            e.setData({
                pay_price: n,
                express_price: s
            });
        }
    },
    toPay: function() {
        if (null != this.data.address) {
            var a = this, t = [];
            t.push({
                id: a.data.good.id,
                img: a.data.good_img,
                name: a.data.good.name,
                price: a.data.good.attrs[a.data.attred].price,
                num: a.data.num,
                attr: a.data.attred,
                attr_name: a.data.good.attr_name
            }), app.util.request({
                url: "entry/wxapp/goods",
                showLoading: !0,
                data: {
                    op: "make_order",
                    paytype: 2,
                    order: t,
                    pay_price: a.data.pay_price,
                    address: a.data.address,
                    navIndex: 1
                },
                success: function(t) {
                    var e = t.data.data.tid;
                    wx.requestPayment({
                        timeStamp: t.data.data.timeStamp,
                        nonceStr: t.data.data.nonceStr,
                        package: t.data.data.package,
                        signType: "MD5",
                        paySign: t.data.data.paySign,
                        success: function(t) {
                            setTimeout(function() {
                                !function t(e) {
                                    app.util.request({
                                        url: "entry/wxapp/payquery",
                                        showLoading: !1,
                                        data: {
                                            tid: e
                                        },
                                        success: function(t) {
                                            app.globalData.userInfo = t.data.data, 2 == app.globalData.webset.live_dialog_type ? sendMsgs(a, 4, "") : webimhandler.onSendMsg("#18mod#" + app.globalData.userInfo.avatarurl), 
                                            app.look.ok("支付成功"), setTimeout(function() {
                                                a.setData({
                                                    submit: !1,
                                                    model: !1,
                                                    choSize: !1,
                                                    showList: !1
                                                });
                                            }, 1500);
                                        },
                                        fail: function() {
                                            setTimeout(function() {
                                                t(e);
                                            }, 1e3);
                                        }
                                    });
                                }(e);
                            }, 500);
                        },
                        fail: function(t) {
                            app.voucher = null, "requestPayment:fail cancel" === t.errMsg && app.util.message({
                                title: "你有订单未支付",
                                redirect: "redirect:../order/order?status=1"
                            });
                        }
                    });
                }
            });
        } else app.look.no("请选择地址");
    },
    toChoose: function() {
        this.setData({
            choose: !0,
            model: !0
        });
        var a = this;
        null == a.data.myAddress && app.util.request({
            url: "entry/wxapp/my",
            method: "POST",
            showLoading: !0,
            data: {
                op: "address"
            },
            success: function(t) {
                var e = t.data;
                e.data.list && a.setData({
                    myAddress: e.data.list
                });
            }
        });
    },
    selectAddress: function(t) {
        this.setData({
            address: this.data.myAddress[t.currentTarget.dataset.index],
            choose: !1
        }), this.countPrice();
    },
    useWechat: function() {
        var e = this;
        wx.chooseAddress({
            success: function(t) {
                e.setData({
                    address: {
                        id: -1,
                        name: t.userName,
                        phone: t.telNumber,
                        detail: t.detailInfo,
                        region: t.provinceName + " " + t.cityName + " " + t.countyName
                    },
                    choose: !1,
                    submit: !0
                }), e.countPrice();
            }
        });
    },
    toAdd: function() {
        this.setData({
            addAddress: !0,
            choose: !1
        });
    },
    sure_addADdress: function(t) {
        var e = this, a = t.detail.value;
        "" != a.name ? /^1\d{10}$/.test(a.phone) ? "" != a.detail ? a.region.length < 3 ? wx.showToast({
            title: "请填写所在地区",
            icon: "none"
        }) : app.util.request({
            url: "entry/wxapp/live",
            showLoading: !0,
            data: {
                op: "addAddress",
                name: a.name,
                phone: a.phone,
                region: a.region.join(" "),
                detail: a.detail
            },
            success: function(t) {
                wx.showToast({
                    title: "添加成功",
                    success: function() {
                        setTimeout(function() {
                            e.setData({
                                myAddress: t.data.data.concat(e.data.myAddress)
                            }), e.closetoAdd();
                        }, 1500);
                    }
                });
            },
            fail: function(t) {
                app.look.no(t.data.message);
            }
        }) : wx.showToast({
            title: "请填写详细地址信息",
            icon: "none"
        }) : wx.showToast({
            title: "请填写正确联系方式",
            icon: "none"
        }) : wx.showToast({
            title: "请填写收货人信息",
            icon: "none"
        });
    },
    closeSubmit: function() {
        this.setData({
            showList: !0,
            submit: !1
        });
    },
    closeadd: function() {
        this.setData({
            showList: !0,
            choose: !1
        });
    },
    closetoAdd: function() {
        this.setData({
            choose: !0,
            addAddress: !1
        });
    },
    showD: function(t) {
        var e = this, a = wx.createAnimation({
            duration: 400,
            timingFunction: "linear"
        });
        (e.animation = a).translateX(-100).step(), e.setData({
            animationData: a.export(),
            has: !0
        }), setTimeout(function() {
            a.translateX(0).step(), e.setData({
                animationData: a.export()
            });
        }, 200), setTimeout(function() {
            e.setData({
                has: !1
            });
        }, 3e3);
    },
    bindRegionChange: function(t) {
        this.setData({
            region: t.detail.value
        });
    },
    get_online: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/live",
            method: "POST",
            showLoading: !1,
            data: {
                op: "get_online",
                id: e.data.options.id
            },
            success: function(t) {
                e.setData(_defineProperty({}, "list.number", t.data.data)), timer_onlineNum = setTimeout(function() {
                    e.get_online();
                }, 7e4);
            }
        });
    },
    dialogTobottom: function() {
        var t = this.data.msgs.length;
        t <= 4 ? t = 0 : t -= 4, this.setData({
            scrollTop: 64 * t
        });
    },
    send_dialog: function(t) {
        var e = this;
        if (app.look.istrue(t.detail.value)) var a = t.detail.value; else a = e.data.value;
        a.replace(/^\s*|\s*$/g, "") && (2 == app.globalData.webset.live_dialog_type ? (sendMsgs(this, 1, a, function() {
            this.setData({
                value: "",
                keyboard: !1
            });
        }), this.setData({
            value: "",
            keyboard: !1
        })) : webimhandler.onSendMsg(a, function() {
            e.setData({
                value: "",
                keyboard: !1
            });
        }));
    },
    receiveMsgs: function(t) {
        var e, a, i = this.data.msgs || [];
        return "@TIM#SYSTEM" == t.fromAccountNick ? (this.setData((_defineProperty(e = {}, "tip.name", ""), 
        _defineProperty(e, "tip.avatar", ""), _defineProperty(e, "tip.style", 2), _defineProperty(e, "tip.text", t.content.substr(7, t.content.length) + "!!"), 
        e)), void this.showD()) : "#18mod#" == t.content.substring(0, 7) ? (this.setData((_defineProperty(a = {}, "tip.name", t.fromAccountNick), 
        _defineProperty(a, "tip.avatar", t.content.substring(7, t.content.length)), _defineProperty(a, "tip.style", 1), 
        _defineProperty(a, "tip.text", "刚刚剁了手"), a)), void this.showD()) : (i.push(t), this.setData({
            msgs: i
        }), void this.dialogTobottom());
    },
    initIM: function(t) {
        var e = this, a = e.data.list.groupid;
        webimhandler.init({
            accountMode: Config.accountMode,
            accountType: Config.accountType,
            sdkAppID: Config.sdkappid,
            avChatRoomId: a,
            selType: webim.SESSION_TYPE.GROUP,
            selToID: a,
            selSess: null
        });
        var i = {
            sdkAppID: Config.sdkappid,
            appIDAt3rd: Config.sdkappid,
            accountType: Config.accountType,
            identifier: e.data.Identifier,
            identifierNick: t.nickName,
            userSig: e.data.UserSig
        }, o = (webimhandler.onDestoryGroupNotify, webimhandler.onRevokeGroupNotify, webimhandler.onCustomGroupNotify, 
        {
            onConnNotify: webimhandler.onConnNotify,
            onBigGroupMsgNotify: function(t) {
                webimhandler.onBigGroupMsgNotify(t, function(t) {
                    e.receiveMsgs(t);
                });
            },
            onMsgNotify: webimhandler.onMsgNotify,
            onGroupSystemNotifys: webimhandler.onGroupSystemNotifys,
            onGroupInfoChangeNotify: webimhandler.onGroupInfoChangeNotify
        }), s = {
            isAccessFormalEnv: !0,
            isLogOn: !0
        };
        Config.accountMode, webimhandler.sdkLogin(i, o, s, a);
    },
    aa: function() {
        sendMsgs(this, 4, "");
    },
    onLoad: function(t) {
        ctx = wx.createCanvasContext("canvas_wi");
        var e = 10 * Math.random() + 50;
        this.setData({
            myx: e
        });
        var o = this;
        o.setData({
            options: t
        }), app.util.request({
            url: "entry/wxapp/live",
            method: "POST",
            showLoading: !1,
            data: {
                op: "get_live_detail",
                id: o.data.options.id,
                style: o.data.options.style
            },
            success: function(t) {
                var e = t.data;
                if (e.data.list && (console.log(e.data.list), o.setData({
                    list: e.data.list,
                    playurl: 1 == o.data.options.style ? e.data.list.player : e.data.list.video_url
                }), wx.setNavigationBarTitle({
                    title: e.data.list.title
                })), 1 == o.data.options.style) if (2 == app.globalData.webset.live_dialog_type) {
                    var a = new app.util.date();
                    startTime = a.dateToStr("yyyy-MM-dd HH:mm:ss"), sendMsgs(o, 2, ""), loadDialog(o);
                } else {
                    e.data.sdkappid && (Config.sdkappid = e.data.sdkappid), e.data.accounttype && (Config.accountType = e.data.accounttype), 
                    e.data.sig && o.setData({
                        Identifier: "user" + app.globalData.userInfo.id,
                        UserSig: e.data.sig
                    });
                    var i = [];
                    i.nickName = app.globalData.userInfo.nickname, o.initIM(i);
                }
            }
        });
    },
    onReady: function() {
        wx.setKeepScreenOn({
            keepScreenOn: !0
        });
        var t = this, e = {};
        e.live_tell = app.module_url + "resource/wxapp/live/live_tell.png", e.live_good = app.module_url + "resource/wxapp/live/live_good.png", 
        e.live_love = app.module_url + "resource/wxapp/live/live_love.png", e.live_close = app.module_url + "resource/wxapp/live/live-close.png", 
        t.setData({
            images: e,
            address: app.address
        }), 1 == t.data.options.style && setTimeout(function() {
            t.get_online();
        }, 5e3);
    },
    drawImage: function(t) {
        var e = this, a = this.data.myx, i = t[0][0], o = t[0][1], s = t[0][2], n = t[0][3], d = t[1][0], r = t[1][1], l = t[1][2], u = t[1][3], p = t[2][0], c = t[2][1], g = t[2][2], m = t[2][3], f = factor.t, h = 3 * (o.x - i.x), y = 3 * (s.x - o.x) - h, w = n.x - i.x - h - y, v = 3 * (o.y - i.y), x = 3 * (s.y - o.y) - v, _ = n.y - i.y - v - x, D = w * (f * f * f) + y * (f * f) + h * f + i.x, b = _ * (f * f * f) + x * (f * f) + v * f + i.y, T = 3 * (r.x - d.x), k = 3 * (l.x - r.x) - T, P = u.x - d.x - T - k, S = 3 * (r.y - d.y), I = 3 * (l.y - r.y) - S, N = u.y - d.y - S - I, M = P * (f * f * f) + k * (f * f) + T * f + d.x, A = N * (f * f * f) + I * (f * f) + S * f + d.y, L = 3 * (c.x - p.x), C = 3 * (g.x - c.x) - L, q = m.x - p.x - L - C, O = 3 * (c.y - p.y), G = 3 * (g.y - c.y) - O, R = m.y - p.y - O - G, F = q * (f * f * f) + C * (f * f) + L * f + p.x, U = R * (f * f * f) + G * (f * f) + O * f + p.y;
        factor.t += factor.speed, ctx.drawImage("../images/heart1.png", D, b, 30, 30), ctx.drawImage("../images/heart2.png", M, A, 30, 30), 
        ctx.drawImage("../images/heart3.png", F, U, 30, 30), ctx.draw(), 1 < factor.t ? (factor.t = 0, 
        clearTimeout(timer), e.startTimer()) : timer = setTimeout(function() {
            e.drawImage([ [ {
                x: 40,
                y: 400
            }, {
                x: 70,
                y: 300
            }, {
                x: -a,
                y: 150
            }, {
                x: 30,
                y: 0
            } ], [ {
                x: 55,
                y: 400
            }, {
                x: 30,
                y: 300
            }, {
                x: 80,
                y: 150
            }, {
                x: 30,
                y: 0
            } ], [ {
                x: 55,
                y: 400
            }, {
                x: 0,
                y: 90
            }, {
                x: 80,
                y: 100
            }, {
                x: 30,
                y: 0
            } ] ]);
        }, 12);
    },
    onClickImage: function(t) {
        2 == app.globalData.webset.live_dialog_type ? sendMsgs(this, 3, "") : webimhandler.sendGroupLoveMsg();
        this.setData({
            style_img: "transform:scale(1.1);",
            agree: !0
        });
    },
    startTimer: function() {
        var t = this;
        t.drawImage([ [ {
            x: 50,
            y: 400
        }, {
            x: 70,
            y: 300
        }, {
            x: -50,
            y: 150
        }, {
            x: 30,
            y: 0
        } ], [ {
            x: 30,
            y: 400
        }, {
            x: 30,
            y: 300
        }, {
            x: 80,
            y: 150
        }, {
            x: 30,
            y: 0
        } ], [ {
            x: 30,
            y: 400
        }, {
            x: 0,
            y: 90
        }, {
            x: 80,
            y: 100
        }, {
            x: 30,
            y: 0
        } ] ]), setTimeout(function() {
            1 == t.data.agree && t.setData({
                agress: !1
            });
        }, 6e4);
    },
    onShow: function() {},
    onHide: function() {
        console.log("onHide");
    },
    onUnload: function() {
        this.data.list.groupid && webimhandler.quitBigGroup(this.data.list.groupid), clearTimeout(timer_Dialog), 
        clearTimeout(timer), clearTimeout(timer_onlineNum);
    },
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(t) {
        wx.showShareMenu({
            withShareTicket: !0
        });
        var e = "", a = "";
        if (app.look.istrue(app.globalData.webset.webname) && (a = app.globalData.webset.webname), 
        "menu" == t.from) return e = "/" + this.route + "?id=" + this.options.id + "&style=" + this.options.style, 
        console.log(e), {
            title: a,
            path: "/xc_xinguwu/pages/base/base?share=" + (e = encodeURIComponent(e)) + "&userid=" + app.globalData.userInfo.id,
            imageUrl: "",
            success: function(t) {
                wx.showToast({
                    title: "转发成功"
                });
            },
            fail: function(t) {}
        };
    }
});