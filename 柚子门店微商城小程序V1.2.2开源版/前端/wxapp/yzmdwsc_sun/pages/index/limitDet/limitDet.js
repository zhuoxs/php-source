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
        goods: [ {
            id: 41,
            imgUrls: [ "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152540565197.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152540565217.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152229433564.png" ],
            title: "发财树绿萝",
            price: "56.80",
            oldPrice: "90.00",
            litnum: "40",
            endtime: "1526483891000",
            clock: "",
            freight: "免运费",
            detail: [ "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264562.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264579.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/15254126459.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264601.png" ],
            goodsThumb: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295634.png",
            spec: [ {
                specName: "套餐类型",
                specValue: [ {
                    name: "套餐1",
                    status: "0"
                }, {
                    name: "套餐2",
                    status: "0"
                }, {
                    name: "套餐3",
                    status: "0"
                }, {
                    name: "套餐4",
                    status: "0"
                } ],
                isChoose: !1
            }, {
                specName: "尺寸",
                specValue: [ {
                    name: "S",
                    status: "0"
                }, {
                    name: "M",
                    status: "0"
                }, {
                    name: "L",
                    status: "0"
                } ],
                isChoose: !1
            } ],
            num: 1,
            specConn: "",
            limit: 3,
            selected: !1
        } ],
        curIndex: "0",
        specConn: "",
        comment: [ {
            uname: "上善诺水",
            uface: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152159562425.png",
            cont: "保洁阿姨服务认真，非常赞,保洁阿姨服务认真，非常赞,保洁阿姨服务认真，非常赞,保洁阿姨服务认真，非常赞,保洁阿姨服务认真，非常赞保洁阿姨服务认真，非常赞保洁阿姨服务认真，非常赞保洁阿姨服务认真",
            time: "2017-11-07 17:55"
        }, {
            uname: "上善诺水",
            uface: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152159562425.png",
            cont: "保洁阿姨服务认真，非常赞",
            time: "2017-11-07 17:55"
        } ],
        guarantee: [ "正品保障", "超时赔付", "7天无忧退货" ],
        num: 1,
        isIpx: app.globalData.isIpx
    },
    onLoad: function(t) {
        var e = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: e.data.navTile
        });
        var n, a = t.gid;
        e.setData({
            gid: a
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GoodsDetails",
            cachetime: "0",
            data: {
                id: a
            },
            success: function(a) {
                console.log(a), e.setData({
                    goodinfo: a.data.data
                });
                setInterval(function() {
                    var t = tool.countDown(e, a.data.data.endtime);
                    n = t ? t[2] + " : " + t[3] + " : " + t[4] : "00 : 00 : 00", e.setData({
                        clock: n
                    });
                }, 1e3);
            }
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
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(t) {
        var a = this.data.goodinfo.goods_name;
        return "button" === t.from && console.log(t.target), {
            title: a,
            path: "yzmdwsc_sun/pages/index/limitDet/limitDet?gid=" + this.data.gid,
            success: function(t) {},
            fail: function(t) {}
        };
    },
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
        for (var a = this.data.goods, e = (a[0].spec, t.currentTarget.dataset.idx), n = t.currentTarget.dataset.index, i = "", o = 0; o < a[0].spec[e].specValue.length; o++) a[0].spec[e].isChoose = !0, 
        n == o ? a[0].spec[e].specValue[n].status = "1" : a[0].spec[e].specValue[o].status = "0";
        for (var s = 0; s < a[0].spec.length; s++) for (o = 0; o < a[0].spec[s].specValue.length; o++) "1" == a[0].spec[s].specValue[o].status && (i += a[0].spec[s].specValue[o].name + " ");
        this.setData({
            goods: a,
            specConn: i
        });
    },
    addNum: function(t) {
        var a = t.currentTarget.dataset.index, e = (this.data.goods[0].limit, parseInt(a) + 1);
        100 < e && (e = 100), this.setData({
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
        var t = parseFloat(this.data.num), a = (this.data.goods[0].price * t).toFixed(2);
        this.setData({
            totalprice: a
        });
    },
    formSubmit: function(o) {
        var s = this, r = o.currentTarget.dataset.gid;
        if ("" != s.data.goodinfo.spec_name && "" != s.data.goodinfo.spec_names) {
            if (!s.data.currentName || !s.data.currentNamet) return void wx.showModal({
                title: "提示",
                content: "请选择商品规格！",
                showCancel: !1
            });
        } else if ("" != s.data.goodinfo.spec_name) {
            if (!s.data.currentName) return void wx.showModal({
                title: "提示",
                content: "请选择商品规格！",
                showCancel: !1
            });
        } else if ("" != s.data.goodinfo.spec_names && !s.data.currentNamet) return void wx.showModal({
            title: "提示",
            content: "请选择商品规格！",
            showCancel: !1
        });
        app.util.request({
            url: "entry/wxapp/checkGoods",
            cachetime: "0",
            data: {
                gid: r,
                num: s.data.num
            },
            success: function(t) {
                var a = s.data.style, e = s.data.currentName, n = s.data.currentNamet, i = s.data.num;
                wx.setStorage({
                    key: "order",
                    data: {
                        spec: e,
                        spect: n,
                        num: i
                    }
                }), 1 == a ? wx.getStorage({
                    key: "openid",
                    success: function(t) {
                        app.util.request({
                            url: "entry/wxapp/AddShopCart",
                            cachetime: "0",
                            data: {
                                uid: t.data,
                                gid: r,
                                num: i,
                                spec_value: e,
                                spec_value1: n,
                                gname: o.currentTarget.dataset.gname,
                                price: o.currentTarget.dataset.price,
                                pic: o.currentTarget.dataset.pic
                            },
                            success: function(t) {
                                0 == t.data.errno && wx.showToast({
                                    title: "加入购物车成功",
                                    icon: "success",
                                    duration: 2e3
                                });
                            }
                        });
                    }
                }) : 2 == a && wx.navigateTo({
                    url: "../cforder/cforder?gid=" + r
                });
            }
        });
    },
    toIndex: function(t) {
        wx.redirectTo({
            url: "../index"
        });
    }
});