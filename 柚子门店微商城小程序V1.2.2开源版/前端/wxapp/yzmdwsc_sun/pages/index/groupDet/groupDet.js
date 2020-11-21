var app = getApp(), tool = require("../../../../style/utils/countDown.js");

Page({
    data: {
        navTile: "商品详情",
        indicatorDots: !1,
        autoplay: !1,
        interval: 3e3,
        duration: 800,
        showModalStatus: !1,
        totalprice: 48.8,
        show: !1,
        goods: [],
        curIndex: "0",
        specConn: "",
        comment: [],
        guarantee: [ "正品保障", "超时赔付", "7天无忧退货" ],
        curGroup: [],
        num: 1,
        joinOn: "0",
        swiperIndex: 1,
        isIpx: app.globalData.isIpx
    },
    onLoad: function(t) {
        var n = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: n.data.navTile
        }), wx.startPullDownRefresh(), wx.stopPullDownRefresh();
        var e = t.gid;
        n.setData({
            gid: e
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), n.setData({
                    url: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GoodsDetails",
            cachetime: "0",
            data: {
                id: e
            },
            success: function(t) {
                n.setData({
                    goodinfo: t.data.data
                });
            }
        }), wx.getStorage({
            key: "openid",
            success: function(t) {
                var a = t.data;
                app.util.request({
                    url: "entry/wxapp/getOtherGroups",
                    cachetime: "0",
                    data: {
                        gid: e,
                        openid: a,
                        limit: 2
                    },
                    success: function(t) {
                        var e = t.data;
                        setInterval(function() {
                            for (var t = 0; t < e.length; t++) {
                                var a = tool.countDown(n, e[t].endtime);
                                e[t].clock = a ? a[2] + " : " + a[3] + " : " + a[4] : "00 : 00 : 00";
                            }
                            n.setData({
                                Groups: e
                            });
                        }, 1e3);
                    }
                });
            }
        });
    },
    showGroup1: function(t) {
        this.setData({
            show: !this.data.show
        });
    },
    showGroup: function(t) {
        var n = this, e = n.data.gid;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                var a = t.data;
                app.util.request({
                    url: "entry/wxapp/getOtherGroups",
                    cachetime: "0",
                    data: {
                        gid: e,
                        openid: a,
                        limit: 10
                    },
                    success: function(t) {
                        var e = t.data;
                        cdInterval1 = setInterval(function() {
                            for (var t = 0; t < e.length; t++) {
                                var a = tool.countDown(n, e[t].endtime);
                                e[t].clock = a ? a[2] + " : " + a[3] + " : " + a[4] : "00 : 00 : 00";
                            }
                            n.setData({
                                curGroup: e
                            });
                        }, 1e3);
                    }
                });
            }
        }), this.setData({
            show: !this.data.show
        });
    },
    togroup: function(t) {
        var a = t.currentTarget.dataset.order_id;
        wx.navigateTo({
            url: "../groupjoin/groupjoin?order_id=" + a
        });
    },
    labelItemTap: function(t) {
        var a = this, e = t.currentTarget.dataset.propertychildindex;
        a.data.currentNamet || (a.data.currentNamet = "");
        var n = t.currentTarget.dataset.propertychildname + a.data.currentNamet;
        a.setData({
            currentIndex: e,
            currentName: t.currentTarget.dataset.propertychildname,
            specConn: n
        });
    },
    labelItemTaB: function(t) {
        var a = this, e = t.currentTarget.dataset.propertychildindex;
        a.data.currentName || (a.data.currentName = "");
        var n = a.data.currentName + " " + t.currentTarget.dataset.propertychildname;
        a.setData({
            currentSel: e,
            currentNamet: t.currentTarget.dataset.propertychildname,
            specConn: n
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/getPingjia",
            cachetime: "0",
            data: {
                gid: a.data.gid
            },
            success: function(t) {
                a.setData({
                    pingjia: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        console.log(123456);
    },
    onReachBottom: function() {},
    onShareAppMessage: function(t) {},
    navTab: function(t) {
        var a = t.currentTarget.dataset.index;
        this.setData({
            curIndex: a
        });
    },
    powerDrawer: function(t) {
        var a = t.currentTarget.dataset.statu, e = t.currentTarget.dataset.style;
        e && (console.log(e), this.setData({
            style: e
        })), this.util(a);
    },
    util: function(t) {
        var a = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = a).opacity(0).height(0).step(), this.setData({
            animationData: a.export()
        }), setTimeout(function() {
            a.opacity(1).height("724rpx").step(), this.setData({
                animationData: a
            }), "close" == t && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == t && this.setData({
            showModalStatus: !0
        });
    },
    chooseSpec: function(t) {
        for (var a = this.data.goods, e = (a[0].spec, t.currentTarget.dataset.idx), n = t.currentTarget.dataset.index, r = "", o = 0; o < a[0].spec[e].specValue.length; o++) a[0].spec[e].isChoose = !0, 
        n == o ? a[0].spec[e].specValue[n].status = "1" : a[0].spec[e].specValue[o].status = "0";
        for (var i = 0; i < a[0].spec.length; i++) for (o = 0; o < a[0].spec[i].specValue.length; o++) "1" == a[0].spec[i].specValue[o].status && (r += a[0].spec[i].specValue[o].name + " ");
        this.setData({
            goods: a,
            specConn: r
        });
    },
    addNum: function(t) {
        var a = t.currentTarget.dataset.index, e = parseInt(a) + 1;
        100 < e && (e = 99), this.setData({
            num: e
        }), this.getTotalPrice();
    },
    reduceNum: function(t) {
        var a = t.currentTarget.dataset.index, e = parseInt(a) - 1;
        e < 1 && (e = 1), this.setData({
            num: e
        }), this.getTotalPrice();
    },
    getTotalPrice: function() {
        var t = parseFloat(this.data.num), a = this.data.goods[0].price * t;
        this.setData({
            totalprice: a
        });
    },
    formSubmit: function(t) {
        var o = this, i = t.currentTarget.dataset.gid, s = wx.getStorageSync("openid");
        if ("" != o.data.goodinfo.spec_name && "" != o.data.goodinfo.spec_names) {
            if (!o.data.currentName || !o.data.currentNamet) return void wx.showModal({
                title: "提示",
                content: "请选择商品规格！",
                showCancel: !1
            });
        } else if ("" != o.data.goodinfo.spec_name) {
            if (!o.data.currentName) return void wx.showModal({
                title: "提示",
                content: "请选择商品规格！",
                showCancel: !1
            });
        } else if ("" != o.data.goodinfo.spec_names && !o.data.currentNamet) return void wx.showModal({
            title: "提示",
            content: "请选择商品规格！",
            showCancel: !1
        });
        app.util.request({
            url: "entry/wxapp/checkGoods",
            cachetime: "0",
            data: {
                gid: i,
                num: o.data.num
            },
            success: function(t) {
                var a = o.data.style, e = o.data.currentName, n = o.data.currentNamet, r = o.data.num;
                wx.setStorage({
                    key: "order",
                    data: {
                        spec: e,
                        spect: n,
                        num: r
                    }
                }), 1 == a ? wx.navigateTo({
                    url: "../cforder/cforder?gid=" + i
                }) : 2 == a && app.util.request({
                    url: "entry/wxapp/isGroupsGou",
                    cachetime: "0",
                    data: {
                        gid: i,
                        openid: s,
                        num: o.data.num
                    },
                    success: function(t) {
                        wx.navigateTo({
                            url: "../cforder-group/cforder-group?gid=" + i
                        });
                    }
                });
            }
        });
    },
    toIndex: function(t) {
        wx.redirectTo({
            url: "../index"
        });
    },
    toGrouppro: function(t) {
        wx.navigateTo({
            url: "../groupPro/groupPro"
        });
    },
    swiperChange: function(t) {
        this.setData({
            swiperIndex: t.detail.current + 1
        });
    }
});