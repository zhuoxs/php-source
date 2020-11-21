var _data;

function _defineProperty(a, t, e) {
    return t in a ? Object.defineProperty(a, t, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = e, a;
}

var WxParse = require("../wxParse/wxParse.js"), app = getApp();

Page({
    data: (_data = {
        swiper: {
            indicatorDots: !1,
            autoplay: !0,
            circular: !0,
            interval: 3e3,
            duration: 500,
            color: "rgba(255,255,255,.3)",
            acolor: "#ff6500",
            imgUrls: [ {
                img: "../images/active_01.jpg",
                id: 0
            }, {
                img: "../images/active_01.jpg",
                id: 1
            } ],
            payMoney: 0
        },
        title: "上班族入职体检基本套餐",
        org: 1980,
        now: 1980,
        con: "fdsajfj是了附加赛可李老师附近的杀两件事的发了肯定接受啊",
        biaoqian: [ {
            img: "../images/tui.png",
            con: "随时退换"
        }, {
            img: "../images/you.png",
            con: "优质服务"
        }, {
            img: "../images/mian.png",
            con: "免费咨询"
        }, {
            img: "../images/tui.png",
            con: "随时退换"
        }, {
            img: "../images/you.png",
            con: "优质服务"
        }, {
            img: "../images/mian.png",
            con: "免费咨询"
        } ],
        positionArr: [ {
            title: "就开始劳动法流口水就啊弗兰克萨发",
            con: "发撒会计分录刷卡缴费来看撒娇的弗利萨弗兰克萨就了分散剂了",
            latitude: 37.76602,
            longitude: 112.5445
        } ],
        nav: {
            nav_list: [ "套餐详情" ],
            currentTab: 0
        },
        taocanArr: [ {
            con: "飞机撒咖啡就零售价法落实到离开弗兰克萨奥拉夫看撒娇理发卡算了"
        }, {
            img: "../images/active_01.jpg"
        }, {
            con: "放假啊发了深刻啊",
            img: "../images/active_02.jpg"
        }, {
            con: "放假啊发了深刻啊",
            img: "../images/active_02.jpg"
        }, {
            con: "放假啊发了深刻啊",
            img: "../images/active_02.jpg"
        } ],
        clientHeight: "",
        overflow: "",
        img: "../images/active_01.jpg"
    }, _defineProperty(_data, "title", "上班族支付体检基本套餐"), _defineProperty(_data, "names", "爱因斯坦"), 
    _defineProperty(_data, "pay", "￥1293"), _defineProperty(_data, "now_num", 1), _defineProperty(_data, "now_num1", 1), 
    _defineProperty(_data, "biaoqianArr", [ {
        biaoqian: "血常规",
        checked: !1
    }, {
        biaoqian: "血常规",
        checked: !1
    }, {
        biaoqian: "血常规",
        checked: !1
    }, {
        biaoqian: "血常规",
        checked: !1
    } ]), _defineProperty(_data, "pingArr", [ {
        fa: [ {
            id: 0,
            img: "../images/header_01.png",
            names: "匿名用户",
            con: "费劲的撒咖啡来上课了房间里三的解放路口三经理看积分为就放老司机李开复三等奖拉的撒吉林省的",
            time: "4小时前"
        } ],
        zan: [ {
            id: 2,
            names: "fsaf",
            con: "fs繁花似锦阿卡开始 =fhsakj 发神经k",
            time: "1小时前"
        }, {
            id: 3,
            names: "fsaf",
            con: "fs繁花似锦阿卡开始 =fhsakj 发神经k",
            time: "1小时前"
        } ]
    }, {
        fa: [ {
            id: 0,
            img: "../images/header_01.png",
            names: "匿名用户",
            con: "费劲的撒咖啡来上课了房间里三的解放路口三经理看积分为就放老司机李开复三等奖拉的撒吉林省的",
            time: "4小时前"
        } ],
        zan: [ {
            id: 2,
            names: "fsaf",
            con: "fs繁花似锦阿卡开始 =fhsakj 发神经k",
            time: "1小时前"
        }, {
            id: 3,
            names: "fsaf",
            con: "fs繁花似锦阿卡开始 =fhsakj 发神经k",
            time: "1小时前"
        }, {
            id: 2,
            names: "fsaf",
            con: "fs繁花似锦阿卡开始 =fhsakj 发神经k",
            time: "1小时前"
        }, {
            id: 3,
            names: "fsaf",
            con: "fs繁花似锦阿卡开始 =fhsakj 发神经k",
            time: "1小时前"
        } ]
    } ]), _defineProperty(_data, "id", 3), _defineProperty(_data, "adress", "点击选择配送地址"), 
    _data),
    swichNav: function(a) {
        console.log(a);
        var t = this.data.nav;
        t.currentTab = a.currentTarget.dataset.current, this.setData({
            nav: t
        });
    },
    onLoad: function(a) {
        var t = this, e = a.f_id, n = wx.getStorageSync("color");
        if (wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: n
        }), t.setData({
            f_id: e
        }), a.currentTab) {
            var i = t.data.nav;
            if (i.currentTab = a.currentTab, "true" == a.focus) {
                t.setData({
                    overFlow2: !0,
                    focus: !0
                });
            }
            t.setData({
                nav: i
            });
        }
        wx.getSystemInfo({
            success: function(a) {
                console.log(a.windowHeight), t.setData({
                    clientHeight: a.windowHeight
                });
            }
        });
    },
    mapClick: function(a) {
        var t = JSON.parse(this.data.latitude), e = JSON.parse(this.data.longitude), n = a.currentTarget.dataset.addname, i = a.currentTarget.dataset.yy_address;
        wx.openLocation({
            latitude: t,
            longitude: e,
            scale: 18,
            name: n,
            address: i
        });
    },
    yuClick: function() {
        this.setData({
            overflow: "hidden"
        });
    },
    choose: function(a) {
        console.log(a);
        var t = this, e = a.currentTarget.dataset.index, n = t.data.tcinfo;
        n.taocanm[e].checked = !n.taocanm[e].checked, n.zmoney = Number(n.zmoney);
        for (var i = 0, o = "", s = 0; s < n.taocanm.length; s++) n.taocanm[s].checked && (i += Number(n.taocanm[s].tcmoney), 
        o += n.taocanm[s].tcname + ";");
        t.noChoose(n.taocanm) || (i = n.zmoney), console.log(i, o), t.setData({
            tcinfo: n,
            payMoney: i,
            str: o
        });
    },
    noChoose: function(a) {
        for (var t = 0; t < a.length; t++) if (a[t].checked) return !0;
        return !1;
    },
    hideClick: function() {
        this.setData({
            overflow: "",
            overflow1: "",
            hidden: "",
            index: "",
            idx: "",
            overFlow2: ""
        });
    },
    addClick: function(a) {
        var t = this, e = (t.data.num, t.data.now_num);
        e++, t.setData({
            now_num: e
        });
    },
    subClick: function(a) {
        var t = this, e = (t.data.num, t.data.now_num);
        e <= 0 ? e = 0 : e--, t.setData({
            now_num: e
        });
    },
    add1Click: function(a) {
        this.data.num;
        var t = this.data.now_num1;
        t++, this.setData({
            now_num1: t
        });
    },
    sub1Click: function(a) {
        this.data.num;
        var t = this.data.now_num1;
        t <= 0 ? t = 0 : t--, this.setData({
            now_num1: t
        });
    },
    payClick: function(a) {
        var t = this.data.payMoney, e = this.data.str, n = this.data.adress, i = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Pay",
            header: {
                "Content-Type": "application/xml"
            },
            method: "GET",
            data: {
                openid: i,
                z_tw_money: t
            },
            success: function(a) {
                console.log(n), wx.requestPayment({
                    timeStamp: a.data.timeStamp,
                    nonceStr: a.data.nonceStr,
                    package: a.data.package,
                    signType: a.data.signType,
                    paySign: a.data.paySign,
                    success: function(a) {
                        app.util.request({
                            url: "entry/wxapp/Savegoods",
                            data: {
                                openid: wx.getStorageSync("openid"),
                                money: t,
                                goodsname: e,
                                types: 1,
                                address: n,
                                ifzhifu: 1
                            },
                            success: function(a) {
                                console.log(a), wx.showToast({
                                    title: "下单成功",
                                    icon: "success",
                                    duration: 2e3,
                                    success: function() {
                                        setTimeout(function() {
                                            wx.navigateBack({
                                                delta: 2
                                            });
                                        }, 2e3);
                                    }
                                });
                            }
                        });
                    },
                    fail: function() {
                        app.util.request({
                            url: "entry/wxapp/Savegoods",
                            data: {
                                openid: wx.getStorageSync("openid"),
                                money: t,
                                goodsname: e,
                                types: 1,
                                address: n,
                                ifzhifu: 0
                            },
                            success: function(a) {
                                console.log(a);
                            }
                        });
                    }
                });
            }
        });
    },
    inputClick: function(a) {
        var t = a.detail.value;
        this.setData({
            value: t
        });
    },
    pingClick: function(a) {
        var t = a.currentTarget.dataset.fa, e = a.currentTarget.dataset.idx, n = this.data.nav;
        n.currentTab = 1, console.log(e);
        this.setData({
            overFlow2: "true",
            fa: t,
            idx: e,
            nav: n,
            focus: !0
        });
    },
    showClick: function(a) {
        console.log(a);
        var t = a.currentTarget.dataset.idx, e = a.currentTarget.dataset.index;
        this.setData({
            overflow1: "true",
            hidden: "hidden",
            idx: t,
            index: e
        });
    },
    delClick: function(a) {
        var t = this.data.pingArr, e = this.data.idx, n = this.data.index;
        console.log(t[e].zan), t[e].zan.splice(n, 1), console.log(t[e].zan);
        n = "", e = "";
        this.setData({
            pingArr: t,
            overflow1: "",
            hidden: "",
            index: n,
            idx: n
        });
    },
    faClick: function() {
        var a = this, t = a.data.idx;
        if (console.log(t), "" != t) {
            var e = a.data.value, n = a.data.fa, i = "刚刚", o = a.data.id, s = a.data.names, c = a.data.img;
            (r = {}).id = o, r.names = s, r.img = c, r.time = i, r.con = e, (u = a.data.pingArr)[t].zan.unshift(r), 
            console.log(u);
        } else {
            e = a.data.value, i = "刚刚";
            var d = {};
            d[n = a.data.fa] = [];
            var r, u;
            o = a.data.id, s = a.data.names, c = a.data.img;
            (r = {}).id = o, r.names = s, r.img = c, r.time = i, r.con = e, d[n].push(r), d.zan = [], 
            (u = a.data.pingArr).push(d);
        }
        e = "";
        a.setData({
            pingArr: u,
            value: e,
            overFlow2: ""
        });
    },
    pingDetailClick: function() {
        wx.navigateTo({
            url: "/pages/ping_detail/ping_detail"
        });
    },
    chooseLocation: function() {
        var t = this;
        wx.chooseAddress({
            success: function(a) {
                console.log(a), t.setData({
                    adress: a.provinceName + a.cityName + a.countyName + a.detailInfo
                });
            },
            fail: function(a) {},
            complete: function(a) {}
        });
    },
    preventTouchMove: function(a) {},
    retrunTopClick: function(a) {
        console.log(a);
        if (600 <= a.target.offsetTop) var t = !0; else t = !1;
        this.setData({
            top: t
        });
    },
    returnTop: function() {
        wx.pageScrollTo({
            scrollTop: 0,
            duration: 300
        });
        this.setData({
            top: !1
        });
    },
    onReady: function() {
        this.getTaocaninfo(), this.getBase();
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    getTaocaninfo: function() {
        var t = this, a = t.data.f_id;
        app.util.request({
            url: "entry/wxapp/Taocaninfo",
            data: {
                f_id: a
            },
            success: function(a) {
                console.log(a), t.setData({
                    tcinfo: a.data.data,
                    payMoney: a.data.data.zmoney,
                    swiper: a.data.data.mor_thumb
                }), WxParse.wxParse("articles", "html", a.data.data.jieshao, t, 5);
            }
        });
    },
    getBase: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(a) {
                console.log(a), t.setData({
                    tell: a.data.data.yy_telphone,
                    yy_title: a.data.data.yy_title,
                    yy_address: a.data.data.yy_address,
                    latitude: a.data.data.latitude,
                    longitude: a.data.data.longitude,
                    baseinfo: a.data.data,
                    show_title: a.data.data.show_title,
                    bq_thumb: a.data.data.bq_thumb,
                    bq_name: a.data.data.bq_name
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    }
});