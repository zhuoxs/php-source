var app = getApp();

Page({
    data: {
        goods: {
            img: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png",
            title: "发财树绿萝栀子花海棠花卉盆栽",
            price: "2.50",
            oldprice: "3.00",
            num: "3",
            userNum: 5,
            status: 2,
            spec: [ {
                specName: "套餐类型",
                specValue: [ {
                    name: "套餐",
                    status: "0"
                }, {
                    name: "套餐",
                    status: "0"
                }, {
                    name: "套餐",
                    status: "0"
                }, {
                    name: "套餐",
                    status: "0"
                }, {
                    name: "套餐",
                    status: "0"
                }, {
                    name: "套餐",
                    status: "0"
                }, {
                    name: "套餐",
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
            } ]
        },
        showModalStatus: !1,
        specConn: "",
        num: 1,
        guarantee: [ "正品保障", "超时赔付", "7天无忧退货" ],
        user: [ "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg" ],
        isLogin: !1
    },
    onLoad: function(t) {
        var e = this;
        e.reload();
        var a = t.order_id, n = wx.getStorageSync("openid");
        e.setData({
            order_id: a
        }), console.log("获取拼单详情"), app.util.request({
            url: "entry/wxapp/getGroupsDetail",
            cachetime: "0",
            data: {
                order_id: a,
                openid: n
            },
            success: function(t) {
                console.log(t.data.data.goodsdetail), e.setData({
                    groupsdetail: t.data.data
                });
            }
        });
    },
    labelItemTap: function(t) {
        var e = this, a = t.currentTarget.dataset.propertychildindex;
        e.data.currentNamet || (e.data.currentNamet = "");
        var n = t.currentTarget.dataset.propertychildname + e.data.currentNamet;
        e.setData({
            currentIndex: a,
            currentName: t.currentTarget.dataset.propertychildname,
            specConn: n
        });
    },
    labelItemTaB: function(t) {
        var e = this, a = t.currentTarget.dataset.propertychildindex;
        e.data.currentName || (e.data.currentName = "");
        var n = e.data.currentName + " " + t.currentTarget.dataset.propertychildname;
        e.setData({
            currentSel: a,
            currentNamet: t.currentTarget.dataset.propertychildname,
            specConn: n
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this;
        wx.getStorageSync("is_login") || wx.getSetting({
            success: function(t) {
                t.authSetting["scope.userInfo"] ? (wx.setStorageSync("is_login", 1), e.setData({
                    isLogin: !1
                })) : e.setData({
                    isLogin: !0
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    toGrouppro: function(t) {
        wx.navigateTo({
            url: "../groupPro/groupPro"
        });
    },
    powerDrawer: function(t) {
        var e = t.currentTarget.dataset.statu;
        this.util(e);
    },
    util: function(t) {
        var e = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = e).opacity(0).height(0).step(), this.setData({
            animationData: e.export()
        }), setTimeout(function() {
            e.opacity(1).height("724rpx").step(), this.setData({
                animationData: e
            }), "close" == t && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == t && this.setData({
            showModalStatus: !0
        });
    },
    chooseSpec: function(t) {
        for (var e = this.data.goods, a = (e.spec, t.currentTarget.dataset.idx), n = t.currentTarget.dataset.index, o = "", s = 0; s < e.spec[a].specValue.length; s++) e.spec[a].isChoose = !0, 
        n == s ? e.spec[a].specValue[n].status = "1" : e.spec[a].specValue[s].status = "0";
        for (var r = 0; r < e.spec.length; r++) for (s = 0; s < e.spec[r].specValue.length; s++) "1" == e.spec[r].specValue[s].status && (o += e.spec[r].specValue[s].name + " ");
        this.setData({
            goods: e,
            specConn: o
        });
    },
    addNum: function(t) {
        var e = t.currentTarget.dataset.index, a = parseInt(e) + 1;
        100 < a && (a = 99), this.setData({
            num: a
        }), this.getTotalPrice();
    },
    reduceNum: function(t) {
        var e = t.currentTarget.dataset.index, a = parseInt(e) - 1;
        a < 1 && (a = 1), this.setData({
            num: a
        }), this.getTotalPrice();
    },
    getTotalPrice: function() {
        var t = parseFloat(this.data.num), e = this.data.goods.price * t;
        this.setData({
            totalprice: e
        });
    },
    formSubmit: function(t) {
        var s = this, r = t.currentTarget.dataset.gid;
        if ("" != s.data.groupsdetail.goodsdetail.spec_name && "" != s.data.groupsdetail.goodsdetail.spec_names) {
            if (!s.data.currentName || !s.data.currentNamet) return void wx.showModal({
                title: "提示",
                content: "请选择商品规格！",
                showCancel: !1
            });
        } else if ("" != s.data.groupsdetail.goodsdetail.spec_name) {
            if (!s.data.currentName) return void wx.showModal({
                title: "提示",
                content: "请选择商品规格！",
                showCancel: !1
            });
        } else if ("" != s.data.groupsdetail.goodsdetail.spec_names && !s.data.currentNamet) return void wx.showModal({
            title: "提示",
            content: "请选择商品规格！",
            showCancel: !1
        });
        app.util.request({
            url: "entry/wxapp/isGroups",
            cachetime: "0",
            data: {
                order_id: s.data.order_id
            },
            success: function(t) {
                var a = s.data.currentName, n = s.data.currentNamet, o = s.data.num;
                app.util.request({
                    url: "entry/wxapp/checkGoods",
                    cachetime: "0",
                    data: {
                        gid: r,
                        num: o
                    },
                    success: function(t) {
                        var e = wx.getStorageSync("openid");
                        app.util.request({
                            url: "entry/wxapp/isGroupsGou",
                            cachetime: "0",
                            data: {
                                gid: r,
                                openid: e,
                                num: o
                            },
                            success: function(t) {
                                wx.setStorage({
                                    key: "order-groupjoin",
                                    data: {
                                        spec: a,
                                        spect: n,
                                        num: o
                                    }
                                }), wx.navigateTo({
                                    url: "../cforder-groupjoin/cforder-groupjoin?order_id=" + s.data.order_id
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    bindGetUserInfo: function(t) {
        null == t.detail.userInfo ? console.log("没有授权") : (wx.setStorageSync("is_login", 1), 
        this.setData({
            isLogin: !1
        }), this.reload(), this.onLoad());
    },
    reload: function(t) {
        var e = this, a = wx.getStorageSync("url");
        "" == a ? app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        }) : e.setData({
            url: a
        });
        var n = wx.getStorageSync("settings");
        "" == n ? app.util.request({
            url: "entry/wxapp/Settings",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("settings", t.data), wx.setStorageSync("color", t.data.color), 
                wx.setStorageSync("fontcolor", t.data.fontcolor), wx.setNavigationBarColor({
                    frontColor: wx.getStorageSync("fontcolor"),
                    backgroundColor: wx.getStorageSync("color"),
                    animation: {
                        duration: 0,
                        timingFunc: "easeIn"
                    }
                }), e.setData({
                    settings: t.data
                });
            }
        }) : (e.setData({
            settings: n
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }));
        var o = wx.getStorageSync("openid");
        "" == o ? wx.login({
            success: function(t) {
                var e = t.code;
                app.util.request({
                    url: "entry/wxapp/openid",
                    cachetime: "0",
                    data: {
                        code: e
                    },
                    success: function(t) {
                        wx.setStorageSync("openid", t.data.openid);
                        var n = t.data.openid;
                        wx.getSetting({
                            success: function(t) {
                                t.authSetting["scope.userInfo"] && wx.getUserInfo({
                                    success: function(t) {
                                        wx.setStorageSync("user_info", t.userInfo);
                                        var e = t.userInfo.nickName, a = t.userInfo.avatarUrl;
                                        app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: n,
                                                img: a,
                                                name: e
                                            },
                                            success: function(t) {
                                                wx.setStorageSync("users", t.data), wx.setStorageSync("uniacid", t.data.uniacid);
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    }
                });
            }
        }) : wx.getSetting({
            success: function(t) {
                t.authSetting["scope.userInfo"] && wx.getUserInfo({
                    success: function(t) {
                        wx.setStorageSync("user_info", t.userInfo);
                        var e = t.userInfo.nickName, a = t.userInfo.avatarUrl;
                        app.util.request({
                            url: "entry/wxapp/Login",
                            cachetime: "0",
                            data: {
                                openid: o,
                                img: a,
                                name: e
                            },
                            success: function(t) {
                                wx.setStorageSync("users", t.data), wx.setStorageSync("uniacid", t.data.uniacid);
                            }
                        });
                    }
                });
            }
        });
    },
    toIndex: function(t) {
        wx.redirectTo({
            url: "/yzmdwsc_sun/pages/index/index"
        });
    }
});