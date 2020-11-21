!function(a) {
    a && a.__esModule;
}(require("../../utils/util.js"));

var a = getApp(), t = a.siteInfo.uniacid;

Page({
    data: {
        isIphoneX: a.globalData.isIphoneX,
        statusBarHeight: a.globalData.statusBarHeight,
        titleBarHeight: a.globalData.titleBarHeight,
        maxPasture: 10,
        isUpdate: !1,
        area: 10,
        sureUpdate: !1,
        showHome: !1,
        showIcon: !0,
        saleNum: "",
        saleMoney: 0,
        state: 0,
        screenHeight: 0,
        Proportion: 0,
        money: "10000.00",
        isFullScreen: !1,
        userAppid: 123456789,
        steal: !1,
        stealMoney: 0,
        friendList: [],
        showFriend: !1,
        animalList: [],
        depotList: [],
        clearTime: !1,
        currentInfo: {},
        noAnimal: !1,
        currentAnimal: {},
        selectNum: 1,
        showDepot: !1,
        showDetail: !1,
        pickeList: [],
        showShop: !1,
        total: 0,
        showFarm: !1,
        kundianPlaySet: [],
        userData: []
    },
    onLoad: function(e) {
        var n = wx.getStorageSync("kundianPlaySet");
        this.setData({
            screenHeight: a.globalData.screenHeight,
            isFullScreen: a.globalData.isFullScreen,
            Proportion: a.globalData.Proportion,
            kundianPlaySet: n
        }), this.getMyAnimal(), a.util.setNavColor(t);
    },
    getMyAnimal: function(e) {
        var n = this, i = !1, s = a.util.getNewUrl("entry/wxapp/game", "kundian_farm_plugin_play"), r = wx.getStorageSync("kundian_farm_uid");
        wx.request({
            url: s,
            data: {
                op: "getMyAnimal",
                action: "animal",
                uid: r,
                uniacid: t
            },
            success: function(a) {
                0 == a.data.animalList.length && (i = !0), n.setData({
                    animalList: a.data.animalList,
                    userData: a.data.userData,
                    noAnimal: i,
                    depotList: a.data.depotData,
                    isUpdate: a.data.is_upgrade,
                    maxPasture: a.data.userData.shed_area
                });
            }
        });
    },
    checkFriend: function() {
        var e = this.data.showFriend;
        this.setData({
            showFriend: !e
        });
        var n = this, i = wx.getStorageSync("kundian_farm_uid"), s = a.util.getNewUrl("entry/wxapp/game", "kundian_farm_plugin_play");
        wx.request({
            url: s,
            data: {
                op: "getFriendInfo",
                action: "friend",
                uniacid: t,
                uid: i
            },
            success: function(a) {
                n.setData({
                    friendList: a.data.friendList
                });
            }
        });
    },
    visited: function(a) {
        var t = this, e = a.currentTarget.dataset.frienduid;
        wx.redirectTo({
            url: "../pasture_fri/index?friend_uid=" + e,
            success: function(a) {
                t.setData({
                    showFriend: !1
                });
            }
        });
    },
    reflect: function() {
        wx.navigateTo({
            url: "/kundian_farm/pages/user/wallet/index"
        });
    },
    farm: function() {
        wx.reLaunch({
            url: "../farm/index"
        });
    },
    monitor: function() {
        wx.navigateTo({
            url: "/kundian_farm/pages/HomePage/live/index"
        });
    },
    adopt: function() {
        if (this.data.userData.shed_area <= 0) return wx.showModal({
            title: "提示",
            content: "您还没有租赁棚哦，请先升级棚面积！",
            showCancel: !1
        }), !1;
        wx.navigateTo({
            url: "/kundian_farm/pages/shop/Adopt/index"
        });
    },
    animalDetail: function(a) {
        var t = [ a.detail, this.data.animalList ], e = t[0], n = t[1].find(function(a) {
            return a.id === e;
        });
        this.setData({
            currentInfo: n
        });
    },
    closeDetail: function() {
        this.setData({
            currentInfo: {}
        });
    },
    close: function() {
        this.setData({
            noAnimal: !1
        });
    },
    joinBag: function() {
        var e = this, n = this.data, i = n.currentInfo, s = (n.animalList, n.depotList, 
        a.util.getNewUrl("entry/wxapp/game", "kundian_farm_plugin_play"));
        wx.request({
            url: s,
            data: {
                op: "joinBag",
                action: "animal",
                uniacid: t,
                adopt_id: i.id,
                uid: wx.getStorageSync("kundian_farm_uid")
            },
            success: function(a) {
                0 == a.data.code ? (wx.showModal({
                    title: "提示",
                    content: "认养已成功放入背包，请打开背包进行查看",
                    confirmText: "进入背包",
                    success: function(a) {
                        a.confirm ? e.setData({
                            showDepot: !0,
                            currentInfo: {}
                        }) : a.cancel && e.setData({
                            currentInfo: {}
                        });
                    }
                }), e.getAnimalBagData()) : wx.showModal({
                    title: "提示",
                    content: "认养放入背包失败，请稍后重试",
                    showCancelL: !1
                });
            }
        });
    },
    getAnimalBagData: function(e) {
        var n = this, i = wx.getStorageSync("kundian_farm_uid"), s = a.util.getNewUrl("entry/wxapp/game", "kundian_farm_plugin_play");
        wx.request({
            url: s,
            data: {
                op: "getAnimalBagData",
                action: "animal",
                uniacid: t,
                uid: i
            },
            success: function(a) {
                console.log(a), n.setData({
                    depotList: a.data.depotList
                });
            }
        });
    },
    checkDepot: function() {
        var a = this.data.showDepot;
        this.setData({
            showDepot: !a
        });
    },
    closrProDetail: function() {
        this.setData({
            state: 0,
            saleNum: ""
        });
    },
    sale: function(a) {
        var t = [ a.currentTarget.dataset.id, this.data.depotList ], e = t[0], n = t[1].find(function(a) {
            return a.id === e;
        });
        n.animation || this.setData({
            currentAnimal: n,
            state: 1
        });
    },
    post: function() {
        var a = this.data, t = (a.currentAnimal, a.depotList, this), e = this.data.currentAnimal.id;
        wx.navigateTo({
            url: "/kundian_farm/pages/user/confirmOrder/index?adopt_id=" + e,
            success: function() {
                t.setData({
                    state: 0
                });
            }
        });
    },
    saleItem: function() {
        var e = this, n = e.data.currentAnimal, i = wx.getStorageSync("kundian_farm_uid");
        if (n.weight <= 0 || n.sale_price <= 0) return wx.showModal({
            title: "提示",
            content: "当前认养的总产量为0，或者售出单价小于等于0，还不能卖出！",
            showCancel: !1
        }), !1;
        wx.showModal({
            title: "提示",
            content: "确认要卖出" + n.animal_name + "吗？",
            success: function(s) {
                if (s.confirm) {
                    var r = a.util.getNewUrl("entry/wxapp/game", "kundian_farm_plugin_play");
                    wx.request({
                        url: r,
                        data: {
                            op: "saleAdopt",
                            action: "animal",
                            uid: i,
                            adopt_id: n.id,
                            uniacid: t
                        },
                        success: function(a) {
                            console.log(a), 0 == a.data.code && (e.setData({
                                saleMoney: a.data.totalPrice,
                                state: 3
                            }), e.getAnimalBagData());
                        }
                    });
                }
            }
        });
    },
    inputWeight: function(a) {
        var t = a.detail.value;
        this.setData({
            saleNum: t
        });
    },
    saleAll: function() {
        var a = this.data.currentAnimal, t = (a.price * a.weight).toFixed(2);
        this.setData({
            state: 3,
            saleMoney: t
        });
    },
    salePart: function() {
        var a = this.data, t = a.saleNum, e = a.currentAnimal;
        if (t > e.num) wx.showToast({
            title: "售出数量超过总数量",
            icon: "none",
            duration: 2e3
        }); else if ("" != t) {
            var n = (t * e.price).toFixed(2);
            this.setData({
                state: 3,
                saleMoney: n
            });
        } else wx.showToast({
            title: "你还没输入售出的数量",
            icon: "none",
            duration: 2e3
        });
    },
    getIndex: function(a, t) {
        return a.findIndex(function(a) {
            return a.id == t.id;
        });
    },
    showFarm: function() {
        var a = this.data.showFarm;
        this.setData({
            showFarm: !a
        });
    },
    update: function() {
        var a = this.data.isUpdate;
        this.setData({
            isUpdate: !a
        });
    },
    sureUpdate: function() {
        var a = this.data.sureUpdate, t = wx.getStorageSync("kundianPlaySet"), e = this.data.maxPasture;
        this.setData({
            sureUpdate: !a,
            maxPasture: parseFloat(e) + parseFloat(t.once_upgrade_area)
        });
    },
    updates: function() {
        var e = this, n = wx.getStorageSync("kundian_farm_uid");
        if (!n) return wx.navigateTo({
            url: "/kundian_farm/pages/login/index"
        }), !1;
        var i = a.util.getNewUrl("entry/wxapp/game", "kundian_farm_plugin_play");
        wx.request({
            url: i,
            data: {
                op: "createUpgradeShedOrder",
                action: "animal",
                uniacid: t,
                uid: n
            },
            success: function(n) {
                if (console.log(n), -1 == n.data.code) return wx.showModal({
                    title: "提示",
                    content: n.data.msg,
                    showCancel: !1
                }), !1;
                var i = n.data.order_id;
                a.util.request({
                    url: "entry/wxapp/playUpgradePay",
                    data: {
                        order_id: i,
                        uniacid: t
                    },
                    cachetime: "0",
                    success: function(n) {
                        if (n.data && n.data.data && !n.data.errno) {
                            var s = n.data.data.package;
                            wx.requestPayment({
                                timeStamp: n.data.data.timeStamp,
                                nonceStr: n.data.data.nonceStr,
                                package: n.data.data.package,
                                signType: "MD5",
                                paySign: n.data.data.paySign,
                                success: function(n) {
                                    var r = a.util.getNewUrl("entry/wxapp/game", "kundian_farm_plugin_play");
                                    wx.request({
                                        url: r,
                                        data: {
                                            op: "UpgradeShedNotify",
                                            action: "animal",
                                            order_id: i,
                                            uniacid: t,
                                            prepay_id: s
                                        },
                                        success: function(a) {
                                            wx.showModal({
                                                title: "提示",
                                                content: "支付成功",
                                                showCancel: "false",
                                                success: function() {
                                                    e.setData({
                                                        sureUpdate: !1,
                                                        isUpdate: !1
                                                    }), e.getMyAnimal();
                                                }
                                            });
                                        }
                                    });
                                },
                                fail: function(a) {
                                    wx.showModal({
                                        title: "系统提示",
                                        content: "您取消了支付",
                                        showCancel: !1,
                                        success: function(a) {}
                                    });
                                }
                            });
                        }
                    },
                    fail: function(a) {
                        if ("JSAPI支付必须传openid" == a.data.message) return wx.navigateTo({
                            url: "/kundian_farm/pages/login/index"
                        }), !1;
                        wx.showModal({
                            title: "系统提示",
                            content: a.data.message ? a.data.message : "错误",
                            showCancel: !1,
                            success: function(a) {}
                        });
                    }
                });
            }
        });
    }
});