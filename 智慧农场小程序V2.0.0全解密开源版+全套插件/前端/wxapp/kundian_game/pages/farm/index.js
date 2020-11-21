var t = function(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}(require("../../utils/util.js")), a = getApp(), e = void 0, n = a.siteInfo.uniacid, i = a.util.getNewUrl("entry/wxapp/game", "kundian_farm_plugin_play");

Page({
    data: {
        isIphoneX: a.globalData.isIphoneX,
        statusBarHeight: a.globalData.statusBarHeight,
        titleBarHeight: a.globalData.titleBarHeight,
        saleWeight: "",
        saleMoney: 0,
        state: 0,
        screenHeight: 0,
        Proportion: 0,
        isFullScreen: !1,
        money: 0,
        area: 0,
        lands: [ {
            is_land_buy: 0,
            steal: !1,
            stealist: [],
            crops: []
        }, {
            is_land_buy: 0,
            steal: !1,
            stealist: [],
            crops: []
        }, {
            is_land_buy: 0,
            steal: !1,
            stealist: [],
            crops: []
        }, {
            is_land_buy: 0,
            steal: !1,
            stealist: [],
            crops: []
        }, {
            is_land_buy: 0,
            steal: !1,
            stealist: [],
            crops: []
        }, {
            is_land_buy: 0,
            steal: !1,
            stealist: [],
            crops: []
        }, {
            is_land_buy: 0,
            steal: !1,
            stealist: [],
            crops: []
        }, {
            is_land_buy: 0,
            steal: !1,
            stealist: [],
            crops: []
        }, {
            is_land_buy: 0,
            steal: !1,
            stealist: [],
            crops: []
        } ],
        friendList: [],
        seedsList: [],
        extensionIndex: 0,
        showFriend: !1,
        currentLand: {},
        showLandDetail: !1,
        currentShow: 1,
        isPlay: !1,
        isSelect: !1,
        showSeedList: !1,
        seedLandId: "",
        totalNum: 0,
        totalPrice: 0,
        showSelectSeeds: !1,
        alert: !1,
        isrun: !0,
        isNotice: !1,
        close: !1,
        depotList: [],
        currentAnimal: {},
        selectNum: 1,
        showDepot: !1,
        showDetail: !1,
        showAlert: !1,
        postList: [],
        showShop: !1,
        showFarm: !1,
        total: 0,
        userData: [],
        kundianPlaySet: [],
        share_uid: "",
        is_auth: !0,
        showOperation: !1,
        operatype: 1,
        close_type: 0,
        isLoading: !1,
        countDownNum: 30,
        showHome: !0,
        showIcon: !1,
        currentDid: ""
    },
    onLoad: function(t) {
        var e = this, i = wx.getStorageSync("kundian_farm_uid");
        if (i && 0 != i && "" != i || this.setData({
            is_auth: !1
        }), t.share_uid) {
            var s = t.share_uid;
            e.becomeFriend(i, s), e.setData({
                share_uid: s
            });
        }
        var o = a.globalData, r = o.screenHeight, d = o.isFullScreen, u = o.Proportion;
        this.setData({
            screenHeight: r,
            isFullScreen: d,
            Proportion: u
        }), this.videoContext = wx.createVideoContext("myVideo"), this.getHomeData(i), a.util.setNavColor(n), 
        wx.getStorageSync("enter_is_play") && wx.removeStorageSync("enter_is_play");
    },
    becomeFriend: function(t, a) {
        t != a && wx.request({
            url: i,
            data: {
                op: "becomeFriend",
                action: "friend",
                uid: t,
                share_uid: a,
                uniacid: n
            },
            success: function(t) {}
        });
    },
    onShow: function() {
        var t = wx.getStorageSync("kundian_farm_uid"), a = this.data.share_uid;
        a && this.becomeFriend(t, a), t ? this.getHomeData(t) : this.setData({
            is_auth: !1
        }), this.run(), wx.getStorageSync("entry_is_play") && wx.removeStorageSync("entry_is_play");
    },
    getHomeData: function(t) {
        var e = this;
        if (!t || 0 == t) return !1;
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "index",
                op: "getPluginLogin",
                uniacid: n
            },
            success: function(a) {
                wx.request({
                    url: i,
                    data: {
                        op: "getHomeData",
                        action: "land",
                        uniacid: n,
                        uid: t,
                        depot_type: 1
                    },
                    success: function(a) {
                        if (41009 == a.data.errno) return e.setData({
                            is_auth: !1
                        }), !1;
                        var n = a.data, i = n.playSet, s = n.none_land, o = n.depotData, r = n.allLand, d = n.userData;
                        wx.setStorageSync("kundianPlaySet", i);
                        var u = !1;
                        t && 0 == d.first_send_money && i.first_time_gold_count > 0 && (u = !0), e.setData({
                            lands: r,
                            userData: d,
                            close: u,
                            kundianPlaySet: i,
                            alert: s,
                            depotList: o
                        }), e.getStatusIndex();
                    }
                });
            }
        });
    },
    onHide: function() {
        clearTimeout(e);
    },
    run: function() {
        var t = this, a = !1;
        e = setTimeout(function() {
            a = !t.data.isrun, t.setData({
                isrun: a
            }), t.run();
        }, 700);
    },
    WillClose: function() {
        var t = this, a = wx.getStorageSync("kundian_farm_uid"), e = wx.getStorageSync("kundianPlaySet"), s = t.data.userData;
        wx.request({
            url: i,
            data: {
                op: "getCoin",
                action: "land",
                uniacid: n,
                uid: a,
                first_time_gold_count: e.first_time_gold_count
            },
            success: function(a) {
                s.money = parseFloat(s.money) + parseFloat(e.first_time_gold_count), t.coinMusic(e.first_time_gold_count), 
                t.setData({
                    close: !1,
                    userData: s
                }), 0 == a.data.code && wx.showToast({
                    title: "首次进入获得" + e.first_time_gold_count + "元",
                    icon: "none"
                });
            }
        });
    },
    coinMusic: function(t) {
        var a = wx.createInnerAudioContext();
        a.autoplay = !0, a.src = this.data.tempFilePath ? this.data.tempFilePath : this.data.kundianPlaySet.jinbiMusic, 
        this.setNumbeer(t);
    },
    setNumbeer: function(a) {
        var e = this, n = new t.default.NumberAnimate({
            from: a,
            speed: 1500,
            refreshTime: 200,
            decimals: 0,
            onUpdate: function() {
                e.setData({
                    money: n.tempValue
                });
            }
        });
    },
    getStatusIndex: function() {
        var t = [];
        this.data.lands.map(function(a) {
            1 == a.is_land_buy && t.push(a);
        }), this.setData({
            extensionIndex: t.length
        });
    },
    checkFriend: function() {
        var t = this.data.showFriend;
        if (this.setData({
            showFriend: !t
        }), !t) {
            var a = this, e = wx.getStorageSync("kundian_farm_uid");
            wx.request({
                url: i,
                data: {
                    op: "getFriendInfo",
                    action: "friend",
                    uniacid: n,
                    uid: e
                },
                success: function(t) {
                    a.setData({
                        friendList: t.data.friendList
                    });
                }
            });
        }
    },
    checkLand: function(t) {
        var a = t.currentTarget.dataset.id, e = this.data.lands.find(function(t) {
            return t.id == a;
        });
        1 == e.status && (this.setData({
            currentLand: e,
            showLandDetail: !0,
            currentShow: 1
        }), this.videoContext.pause());
    },
    closeVideo: function() {
        this.setData({
            showLandDetail: !1
        }), this.videoContext.pause();
    },
    changeType: function(t) {
        var a = t.currentTarget.dataset.index;
        this.setData({
            currentShow: a
        }), 1 == a ? this.videoContext.pause() : this.videoContext.play();
    },
    changeVideoState: function() {
        var t = this.data.isPlay;
        t ? this.videoContext.pause() : this.videoContext.play(), this.setData({
            isPlay: !t
        });
    },
    playVideo: function() {
        var t = this.data.isPlay;
        this.setData({
            isPlay: !t
        });
    },
    selectLand: function(t) {
        var a = this.data.isSelect;
        this.setData({
            isSelect: !a
        });
    },
    showSeedList: function(t) {
        var a = this.data.showSeedList;
        if (this.setData({
            showSeedList: !a,
            totalNum: 0,
            totalPrice: 0
        }), !a) {
            var e = this, s = t.currentTarget.dataset.landid, o = t.currentTarget.dataset.mindlandid, r = e.data.lands.find(function(t) {
                return t.id == o;
            });
            wx.request({
                url: i,
                data: {
                    op: "getLandSeed",
                    action: "land",
                    uniacid: n,
                    land_id: s
                },
                success: function(t) {
                    e.setData({
                        seedsList: t.data.seedsList,
                        seedLandId: o,
                        currentLand: r
                    });
                }
            });
        }
    },
    select: function(t) {
        var a = this, e = t.currentTarget.dataset.id, n = this.data.seedsList, i = this.data, s = i.totalNum, o = (i.area, 
        i.currentLand), r = n.findIndex(function(t) {
            return t.id == e;
        });
        if (parseInt(s) >= parseInt(o.residue_area)) this.setData({
            isNotice: !0
        }), setTimeout(function() {
            a.know();
        }, 2e3); else {
            if (n[r].low_count > 1) if (n[r].num > 0) n[r].num++; else {
                if (s + parseInt(n[r].low_count) > parseInt(o.residue_area)) return this.setData({
                    isNotice: !0
                }), void setTimeout(function() {
                    a.know();
                }, 2e3);
                n[r].num = parseInt(n[r].low_count);
            } else n[r].num++;
            this.setData({
                seedsList: n
            }), this.sumSelectNum(n);
        }
    },
    know: function() {
        this.setData({
            isNotice: !1
        });
    },
    reduceSeed: function(t) {
        var a = t.currentTarget.dataset.id, e = this.data.seedsList, n = e.findIndex(function(t) {
            return t.id == a;
        });
        e[n].low_count == e[n].num ? e[n].num = 0 : e[n].num--, this.setData({
            seedsList: e
        }), this.sumSelectNum(e);
    },
    sumSelectNum: function(t) {
        var a = t.reduce(function(t, a) {
            return a.num + t;
        }, 0), e = t.reduce(function(t, a) {
            return a.num * a.price + t;
        }, 0);
        this.setData({
            totalNum: a,
            totalPrice: e.toFixed(2)
        });
    },
    mature: function(t) {
        var a = t.currentTarget.dataset.id, e = this.data.lands, s = e.findIndex(function(t) {
            return t.id == a;
        }), o = this, r = t.currentTarget.dataset.minelandid, d = wx.getStorageSync("kundian_farm_uid");
        wx.request({
            url: i,
            data: {
                op: "pickSeed",
                action: "land",
                uid: d,
                uniacid: n,
                mine_land_id: r
            },
            success: function(t) {
                0 == t.data.code ? (e[s].animation = !0, e[s].steal = !0, e[s].crops.map(function(t, a) {
                    2 == t.status && e[s].crops.splice(a, 1);
                }), e[s].crops.length > 0 ? e[s].process = 3 : e[s].process = 0, o.setData({
                    lands: e
                }), wx.showModal({
                    title: "提示",
                    content: "正在收获中,收获成功后将放入背包,请耐心等待",
                    confirmText: "进入背包",
                    success: function(t) {
                        o.getSeedBagData(), t.confirm && o.setData({
                            showDepot: !0
                        });
                    }
                })) : wx.showToast({
                    title: t.data.smg,
                    icon: "none"
                });
            }
        });
    },
    showSelectSeeds: function() {
        var t = this.data.showSelectSeeds;
        this.setData({
            showSelectSeeds: !t
        });
    },
    visited: function(t) {
        var a = this, e = t.currentTarget.dataset.frienduid, n = t.detail.formId;
        wx.navigateTo({
            url: "../friend/index?friend_uid=" + e + "&form_id=" + n,
            success: function(t) {
                a.setData({
                    showFriend: !1
                });
            }
        });
    },
    reflect: function() {
        this.data.userData;
        wx.navigateTo({
            url: "/kundian_farm/pages/user/wallet/index"
        });
    },
    payfor: function(t) {
        var e = this, i = e.data.totalPrice, s = t.currentTarget.dataset.landid, o = wx.getStorageSync("kundian_farm_uid"), r = this.data.seedsList.filter(function(t) {
            return t.num > 0;
        });
        if (r.length <= 0) return wx.showToast({
            title: "请选择种子~",
            icon: "none"
        }), !1;
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "addSeedOrder",
                control: "land",
                uniacid: n,
                uid: o,
                total_price: i,
                seedList: JSON.stringify(r),
                lid: s
            },
            success: function(t) {
                var i = t.data.order_id;
                e.setData({
                    order_id: i
                }), a.util.request({
                    url: "entry/wxapp/pay",
                    data: {
                        op: "getSeedPayOrder",
                        control: "land",
                        orderid: i,
                        uniacid: n
                    },
                    cachetime: "0",
                    success: function(t) {
                        if (t.data && t.data.data && !t.data.errno) {
                            var r = t.data.data.package;
                            wx.requestPayment({
                                timeStamp: t.data.data.timeStamp,
                                nonceStr: t.data.data.nonceStr,
                                package: t.data.data.package,
                                signType: "MD5",
                                paySign: t.data.data.paySign,
                                success: function(t) {
                                    a.util.request({
                                        url: "entry/wxapp/class",
                                        data: {
                                            op: "notifySeed",
                                            control: "land",
                                            order_id: i,
                                            uniacid: n,
                                            prepay_id: r,
                                            lid: s
                                        },
                                        success: function(t) {
                                            wx.showModal({
                                                title: "提示",
                                                content: "种子已购买成功,请等待种植~",
                                                showCancel: !1,
                                                success: function() {
                                                    e.setData({
                                                        showSelectSeeds: !1,
                                                        selectSeedList: [],
                                                        showSeedList: !1,
                                                        totalNum: 0
                                                    }), e.getHomeData(o);
                                                }
                                            });
                                        }
                                    });
                                },
                                fail: function(t) {
                                    wx.showModal({
                                        title: "系统提示",
                                        content: "您取消了支付",
                                        showCancel: !1,
                                        success: function(t) {}
                                    });
                                }
                            });
                        }
                    },
                    fail: function(t) {
                        wx.showModal({
                            title: "系统提示",
                            content: t.data.message ? t.data.message : "错误",
                            showCancel: !1,
                            success: function(t) {}
                        });
                    }
                });
            }
        });
    },
    pasture: function() {
        wx.navigateTo({
            url: "../pasture/index"
        });
    },
    checkDepot: function() {
        var t = this.data.showDepot;
        this.setData({
            showDepot: !t
        });
    },
    sale: function(t) {
        var a = [ t.currentTarget.dataset.id, this.data.depotList ], e = a[0], n = a[1].find(function(t) {
            return t.id === e;
        });
        n.animation || this.setData({
            currentAnimal: n,
            state: 1
        });
    },
    closrProDetail: function() {
        this.setData({
            state: 0,
            saleWeight: ""
        });
    },
    post: function() {
        var t = this.data.currentAnimal;
        wx.navigateTo({
            url: "/kundian_farm/pages/land/pay_freight/index?types=1&selectBag=" + JSON.stringify(t)
        });
    },
    saleItem: function() {
        this.setData({
            state: 2
        });
    },
    inputWeight: function(t) {
        var a = t.detail.value;
        this.setData({
            saleWeight: a
        });
    },
    saleAll: function(t) {
        var a = this, e = t.detail.formId, s = this.data.currentAnimal, o = (s.sale_price * s.weight).toFixed(2);
        wx.showModal({
            title: "提示",
            content: "确认售出全部的商品吗？",
            success: function(t) {
                t.confirm && wx.request({
                    url: i,
                    data: {
                        op: "saleAll",
                        action: "land",
                        saleData: JSON.stringify(s),
                        uniacid: n,
                        form_id: e
                    },
                    success: function(t) {
                        wx.showModal({
                            title: "提示",
                            content: t.data.msg,
                            showCancel: !1,
                            success: function() {
                                a.setData({
                                    state: 3,
                                    saleMoney: o
                                }), a.getSeedBagData();
                            }
                        });
                    }
                });
            }
        });
    },
    salePart: function(t) {
        var a = this, e = t.detail.formId, s = this.data, o = s.saleWeight, r = s.currentAnimal;
        if (parseFloat(o) > parseFloat(r.weight)) wx.showToast({
            title: "售出重量超过总重量",
            icon: "none",
            duration: 2e3
        }); else if ("" != o) {
            var d = (o * r.sale_price).toFixed(2);
            wx.showModal({
                title: "提示",
                content: "确认售出部分商品吗？",
                success: function(t) {
                    t.confirm && wx.request({
                        url: i,
                        data: {
                            op: "salePart",
                            action: "land",
                            saleData: JSON.stringify(r),
                            weight: o,
                            uniacid: n,
                            form_id: e
                        },
                        success: function(t) {
                            wx.showModal({
                                title: "提示",
                                content: t.data.msg,
                                showCancel: !1,
                                success: function() {
                                    a.setData({
                                        state: 3,
                                        saleMoney: d
                                    }), a.getSeedBagData();
                                }
                            });
                        }
                    });
                }
            });
        } else wx.showToast({
            title: "你还没输入售出的重量",
            icon: "none",
            duration: 2e3
        });
    },
    getIndex: function(t, a) {
        return t.findIndex(function(t) {
            return t.id == a.id;
        });
    },
    showFarm: function() {
        var t = this.data.showFarm;
        this.setData({
            showFarm: !t
        });
    },
    onShareAppMessage: function(t) {
        t.from;
        var a = wx.getStorageSync("kundian_farm_uid");
        return {
            title: this.data.kundianPlaySet.farm_share_title,
            path: "kundian_game/pages/farm/index?share_uid=" + a
        };
    },
    goToBuyLand: function(t) {
        wx.navigateTo({
            url: "/kundian_farm/pages/land/landList/index?is_play=1"
        });
    },
    intoLandDetail: function(t) {
        var a = t.currentTarget.dataset.minelandid;
        wx.navigateTo({
            url: "/kundian_farm/pages/land/mineLandDetail/index?lid=" + a
        });
    },
    intoLive: function(t) {
        wx.navigateTo({
            url: "/kundian_farm/pages/HomePage/live/index"
        });
    },
    denyAuth: function(t) {
        this.setData({
            is_auth: !0
        }), wx.showModal({
            title: "提示",
            content: "您拒绝了授权，将获取不到您的用户信息，可能会影响您的体验哦",
            showCancel: !1
        });
    },
    updateUserInfo: function(t) {
        var a = this, e = getApp(), n = e.siteInfo.uniacid;
        e.util.getUserInfo(function(t) {
            wx.setStorageSync("kundian_farm_uid", t.memberInfo.uid), wx.setStorageSync("kundian_farm_userInfo", t.memberInfo), 
            wx.setStorageSync("kundian_farm_sessionid", t.sessionid);
            var i = t.memberInfo, s = t.wxInfo.avatarUrl, o = t.wxInfo.nickName, r = i.uid;
            if (a.setData({
                nickName: o,
                avatarUrl: s
            }), !r) return wx.showModal({
                title: "提示",
                content: "获取用户UID失败",
                showCancel: !1
            }), !1;
            var d = e.util.getNewUrl("entry/wxapp/class", "kundian_farm");
            wx.request({
                url: d,
                data: {
                    op: "login",
                    action: "index",
                    control: "home",
                    avatar: s,
                    nickname: o,
                    uid: r,
                    uniacid: n
                },
                success: function(t) {
                    0 == t.data.code && wx.showToast({
                        title: "授权成功~",
                        icon: "none",
                        success: function() {
                            a.setData({
                                is_auth: !0
                            }), console.log(a.data.is_auth), a.getHomeData(r);
                        }
                    });
                }
            });
        }, t.detail);
    },
    showOperation: function(t) {
        var a = 1;
        this.data.showOperation || (a = t.currentTarget.dataset.operatype), this.setData({
            showOperation: !this.data.showOperation,
            operatype: a
        });
    },
    operationLand: function(t) {
        var e = this, i = t.currentTarget.dataset, s = i.adoptid, o = i.operatype, r = i.landname, d = i.did, u = wx.getStorageSync("kundian_farm_uid");
        if (1 == this.data.kundianPlaySet.open_land_pay) return wx.showLoading({
            title: "加载中..."
        }), void a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "operationLand",
                control: "control",
                uniacid: n,
                uid: u,
                adopt_id: s,
                operatype: o,
                land_name: r,
                did: d
            },
            success: function(t) {
                if (-1 == t.data.code) return wx.showModal({
                    title: "提示",
                    content: t.data.msg,
                    showCancel: !1
                }), !1;
                var e = t.data.order_id;
                a.util.request({
                    url: "entry/wxapp/pay",
                    data: {
                        control: "control",
                        order_id: e,
                        uniacid: n,
                        op: "getOperationPayOrder"
                    },
                    cachetime: "0",
                    success: function(t) {
                        if (t.data && t.data.data && !t.data.errno) {
                            var i = t.data.data.package;
                            wx.requestPayment({
                                timeStamp: t.data.data.timeStamp,
                                nonceStr: t.data.data.nonceStr,
                                package: t.data.data.package,
                                signType: "MD5",
                                paySign: t.data.data.paySign,
                                success: function(t) {
                                    wx.hideLoading(), a.util.request({
                                        url: "entry/wxapp/class",
                                        data: {
                                            op: "operation_notify",
                                            control: "control",
                                            order_id: e,
                                            uniacid: n,
                                            prepay_id: i
                                        },
                                        success: function(t) {
                                            wx.showModal({
                                                title: "提示",
                                                content: "支付成功,请等待管理员进行相关操作",
                                                showCancel: "false"
                                            });
                                        }
                                    });
                                },
                                fail: function(t) {
                                    wx.showModal({
                                        title: "系统提示",
                                        content: "您取消了支付",
                                        showCancel: !1,
                                        success: function(t) {}
                                    });
                                }
                            });
                        }
                    },
                    fail: function(t) {
                        if ("JSAPI支付必须传openid" == t.data.message) return wx.navigateTo({
                            url: "/kundian_farm/pages/login/index"
                        }), !1;
                        wx.showModal({
                            title: "系统提示",
                            content: t.data.message ? t.data.message : "错误",
                            showCancel: !1,
                            success: function(t) {}
                        });
                    }
                });
            }
        });
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "watering",
                control: "control",
                uniacid: n,
                uid: u,
                lid: s,
                web_did: d,
                operatype: o
            },
            success: function(t) {
                var a = 1;
                3 == o && (a = 3), 4 == o && (a = 1), 1 == o && (a = 2), 1 == t.data.code ? (e.setData({
                    close_type: a,
                    currentDid: d
                }), e.countDown(d, a)) : wx.showModal({
                    title: "提示",
                    content: t.data.msg,
                    showCancel: !1
                });
            }
        });
    },
    countDown: function(t, a) {
        var e = this, n = e.data.kundianPlaySet.land_opreation_time;
        e.setData({
            isLoading: !0,
            countDownNum: e.data.kundianPlaySet.land_opreation_time
        }), e.setData({
            timer: setInterval(function() {
                n--, e.setData({
                    countDownNum: n
                }), 0 == n && (clearInterval(e.data.timer), e.setData({
                    isLoading: !1
                }), e.closeDevice(t, a));
            }, 1e3)
        });
    },
    closeDevice: function(t, e) {
        var i = this, s = wx.getStorageSync("kundian_farm_uid");
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "closeDevice",
                control: "control",
                web_did: t,
                close_type: e,
                uniacid: n,
                uid: s
            },
            success: function(t) {
                console.log(t), wx.showModal({
                    title: "提示",
                    content: t.data.msg,
                    showCancel: !1
                }), i.setData({
                    close_type: 0
                });
            }
        });
    },
    onUnload: function(t) {
        var a = this, e = this.data, n = e.close_type, i = e.currentDid;
        1 != n && 2 != n && 3 != n && 4 != n || (a.closeDevice(i, n), clearInterval(a.data.timer));
    },
    intoMenuPro: function(t) {
        wx.reLaunch({
            url: "/kundian_farm/pages/HomePage/index/index"
        });
    },
    intoMoneyBag: function(t) {
        wx.navigateTo({
            url: "/kundian_farm/pages/user/wallet/index"
        });
    },
    getSeedBagData: function(t) {
        var e = this, i = wx.getStorageSync("kundian_farm_uid"), s = a.util.getNewUrl("entry/wxapp/game", "kundian_farm_plugin_play");
        wx.request({
            url: s,
            data: {
                op: "getSeedBagData",
                action: "land",
                uniacid: n,
                uid: i
            },
            success: function(t) {
                e.setData({
                    depotList: t.data.depotData
                });
            }
        });
    }
});