var a = new getApp(), t = a.siteInfo.uniacid;

Page({
    data: {
        lid: "",
        mineLand: [],
        sendMine: [],
        landStatus: [],
        scrollLeft: 0,
        isShow: !1,
        farmSetData: [],
        isLoading: !1,
        countDownNum: 30,
        close_type: 0,
        icon: [],
        is_loading: !0,
        is_show_status: !1,
        is_show_gain_dialog: !1,
        gainSeed: [],
        open_land_pay: 1,
        is_open_webthing: 0,
        land_opreation_time: 30,
        src_xy: []
    },
    onLoad: function(e) {
        var n = this, i = e.lid, d = wx.getStorageSync("kundian_farm_uid"), o = wx.getStorageSync("kundian_farm_setData");
        wx.showLoading({
            title: "玩命加载中..."
        }), a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "getMineLandDetail",
                control: "land",
                uid: d,
                uniacid: t,
                lid: i
            },
            success: function(a) {
                var t = a.data, e = t.mineLand, d = t.landSeed, o = t.icon, s = t.open_land_pay, c = t.is_open_webthing, r = t.land_opreation_time, l = e.live_src, u = [];
                l && (u = l.split(":")), n.setData({
                    mineLand: e,
                    lid: i,
                    sendMine: d,
                    icon: o,
                    open_land_pay: s,
                    is_open_webthing: c,
                    land_opreation_time: r || 30,
                    src_xy: u
                }), wx.hideLoading();
            }
        }), this.videoContext = wx.createVideoContext("myVideo", this), a.util.setNavColor(t), 
        this.setData({
            farmSetData: o,
            lid: i
        });
    },
    getLandDetail: function(e) {
        var n = this, i = wx.getStorageSync("kundian_farm_uid");
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "getMineLandDetail",
                control: "land",
                uid: i,
                uniacid: t,
                lid: e
            },
            success: function(a) {
                n.setData({
                    mineLand: a.data.mineLand,
                    lid: e,
                    sendMine: a.data.landSeed,
                    icon: a.data.icon
                });
            }
        });
    },
    getSeed: function(a) {
        var t = a.currentTarget.dataset.seedid, e = this.data.mineLand.id;
        wx.navigateTo({
            url: "../confirm_order/index?seed_id=" + t + "&mine_land_id=" + e
        });
    },
    showVideo: function() {
        this.setData({
            isShow: !this.data.isShow
        }), this.data.isShow && this.videoContext.play();
    },
    LookImg: function(a) {
        for (var t = this.data.landStatus, e = a.currentTarget.dataset.id, n = (a.currentTarget.dataset.index, 
        new Array()), i = 0; i < t.length; i++) if (t[i].id == e) {
            n = t[i].src;
            break;
        }
        wx.previewImage({
            urls: n
        });
    },
    watering: function(e) {
        var n = this, i = n.data, d = i.mineLand, o = i.open_land_pay, s = wx.getStorageSync("kundian_farm_uid"), c = e.detail.formId;
        if (1 == o) return wx.showLoading({
            title: "加载中..."
        }), void a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "operationLand",
                control: "control",
                uniacid: t,
                uid: s,
                adopt_id: d.id,
                operatype: 4,
                land_name: d.land_name + d.land_num,
                did: d.deviceInfo.did
            },
            success: function(e) {
                if (-1 == e.data.code) return wx.showModal({
                    title: "提示",
                    content: e.data.msg,
                    showCancel: !1
                }), !1;
                var n = e.data.order_id;
                a.util.request({
                    url: "entry/wxapp/pay",
                    data: {
                        control: "control",
                        order_id: n,
                        uniacid: t,
                        op: "getOperationPayOrder"
                    },
                    cachetime: "0",
                    success: function(e) {
                        if (e.data && e.data.data && !e.data.errno) {
                            var i = e.data.data.package;
                            wx.requestPayment({
                                timeStamp: e.data.data.timeStamp,
                                nonceStr: e.data.data.nonceStr,
                                package: e.data.data.package,
                                signType: "MD5",
                                paySign: e.data.data.paySign,
                                success: function(e) {
                                    wx.hideLoading(), a.util.request({
                                        url: "entry/wxapp/class",
                                        data: {
                                            op: "operation_notify",
                                            control: "control",
                                            order_id: n,
                                            uniacid: t,
                                            prepay_id: i
                                        },
                                        success: function(a) {
                                            wx.showModal({
                                                title: "提示",
                                                content: "支付成功,请等待管理员进行相关操作",
                                                showCancel: "false"
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
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "watering",
                control: "control",
                uniacid: t,
                uid: s,
                lid: d.id,
                web_did: d.deviceInfo.did,
                formId: c,
                did: d.id,
                operatype: 4
            },
            success: function(a) {
                1 == a.data.code ? (n.setData({
                    close_type: 1
                }), n.countDown(d.deviceInfo.did, 1)) : wx.showModal({
                    title: "提示",
                    content: a.data.msg,
                    showCancel: !1
                });
            }
        });
    },
    fertilization: function(e) {
        var n = this, i = n.data, d = i.mineLand, o = i.open_land_pay, s = wx.getStorageSync("kundian_farm_uid"), c = e.detail.formId;
        if (1 == o) return wx.showLoading({
            title: "加载中..."
        }), void a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "operationLand",
                control: "control",
                uniacid: t,
                uid: s,
                adopt_id: d.id,
                operatype: 1,
                land_name: d.land_name + d.land_num,
                did: d.id
            },
            success: function(e) {
                if (-1 == e.data.code) return wx.showModal({
                    title: "提示",
                    content: e.data.msg,
                    showCancel: !1
                }), !1;
                var n = e.data.order_id;
                a.util.request({
                    url: "entry/wxapp/pay",
                    data: {
                        control: "control",
                        order_id: n,
                        uniacid: t,
                        op: "getOperationPayOrder"
                    },
                    cachetime: "0",
                    success: function(e) {
                        if (e.data && e.data.data && !e.data.errno) {
                            var i = e.data.data.package;
                            wx.requestPayment({
                                timeStamp: e.data.data.timeStamp,
                                nonceStr: e.data.data.nonceStr,
                                package: e.data.data.package,
                                signType: "MD5",
                                paySign: e.data.data.paySign,
                                success: function(e) {
                                    wx.hideLoading(), a.util.request({
                                        url: "entry/wxapp/class",
                                        data: {
                                            op: "operation_notify",
                                            control: "control",
                                            order_id: n,
                                            uniacid: t,
                                            prepay_id: i
                                        },
                                        success: function(a) {
                                            wx.showModal({
                                                title: "提示",
                                                content: "支付成功,请等待管理员进行相关操作",
                                                showCancel: "false"
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
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "watering",
                control: "control",
                uniacid: t,
                uid: s,
                lid: d.id,
                web_did: d.deviceInfo.did,
                formId: c,
                operatype: 1
            },
            success: function(a) {
                1 == a.data.code ? (n.setData({
                    close_type: 2
                }), n.countDown(d.deviceInfo.did, 2)) : wx.showModal({
                    title: "提示",
                    content: a.data.msg,
                    showCancel: !1
                });
            }
        });
    },
    killVer: function(e) {
        var n = this, i = n.data, d = i.mineLand, o = i.open_land_pay, s = wx.getStorageSync("kundian_farm_uid"), c = e.detail.formId;
        if (1 == o) return wx.showLoading({
            title: "加载中..."
        }), void a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "operationLand",
                control: "control",
                uniacid: t,
                uid: s,
                adopt_id: d.id,
                operatype: 3,
                land_name: d.land_name + d.land_num,
                did: d.id
            },
            success: function(e) {
                if (-1 == e.data.code) return wx.showModal({
                    title: "提示",
                    content: e.data.msg,
                    showCancel: !1
                }), !1;
                var n = e.data.order_id;
                a.util.request({
                    url: "entry/wxapp/pay",
                    data: {
                        control: "control",
                        order_id: n,
                        uniacid: t,
                        op: "getOperationPayOrder"
                    },
                    cachetime: "0",
                    success: function(e) {
                        if (e.data && e.data.data && !e.data.errno) {
                            var i = e.data.data.package;
                            wx.requestPayment({
                                timeStamp: e.data.data.timeStamp,
                                nonceStr: e.data.data.nonceStr,
                                package: e.data.data.package,
                                signType: "MD5",
                                paySign: e.data.data.paySign,
                                success: function(e) {
                                    wx.hideLoading(), a.util.request({
                                        url: "entry/wxapp/class",
                                        data: {
                                            op: "operation_notify",
                                            control: "control",
                                            order_id: n,
                                            uniacid: t,
                                            prepay_id: i
                                        },
                                        success: function(a) {
                                            wx.showModal({
                                                title: "提示",
                                                content: "支付成功,请等待管理员进行相关操作",
                                                showCancel: "false"
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
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "watering",
                control: "control",
                uniacid: t,
                uid: s,
                lid: d.id,
                web_did: d.deviceInfo.did,
                formId: c,
                operatype: 3
            },
            success: function(a) {
                1 == a.data.code ? (n.setData({
                    close_type: 3
                }), n.countDown(d.deviceInfo.did, 3)) : wx.showModal({
                    title: "提示",
                    content: a.data.msg,
                    showCancel: !1
                });
            }
        });
    },
    weeding: function(e) {
        var n = this.data, i = n.mineLand, d = n.open_land_pay, o = wx.getStorageSync("kundian_farm_uid"), s = e.detail.formId;
        if (1 == d) return wx.showLoading({
            title: "加载中..."
        }), void a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "operationLand",
                control: "control",
                uniacid: t,
                uid: o,
                adopt_id: i.id,
                operatype: 2,
                land_name: i.land_name + i.land_num,
                did: i.id
            },
            success: function(e) {
                if (-1 == e.data.code) return wx.showModal({
                    title: "提示",
                    content: e.data.msg,
                    showCancel: !1
                }), !1;
                var n = e.data.order_id;
                a.util.request({
                    url: "entry/wxapp/pay",
                    data: {
                        control: "control",
                        order_id: n,
                        uniacid: t,
                        op: "getOperationPayOrder"
                    },
                    cachetime: "0",
                    success: function(e) {
                        if (e.data && e.data.data && !e.data.errno) {
                            var i = e.data.data.package;
                            wx.requestPayment({
                                timeStamp: e.data.data.timeStamp,
                                nonceStr: e.data.data.nonceStr,
                                package: e.data.data.package,
                                signType: "MD5",
                                paySign: e.data.data.paySign,
                                success: function(e) {
                                    wx.hideLoading(), a.util.request({
                                        url: "entry/wxapp/class",
                                        data: {
                                            op: "operation_notify",
                                            control: "control",
                                            order_id: n,
                                            uniacid: t,
                                            prepay_id: i
                                        },
                                        success: function(a) {
                                            wx.showModal({
                                                title: "提示",
                                                content: "支付成功,请等待管理员进行相关操作",
                                                showCancel: "false"
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
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "weeding",
                control: "control",
                uniacid: t,
                uid: o,
                lid: i.id,
                formId: s,
                operatype: 2
            },
            success: function(a) {
                wx.showModal({
                    title: "提示",
                    content: a.data.msg,
                    showCancel: !1
                });
            }
        });
    },
    countDown: function(a, t) {
        var e = this, n = e.data.land_opreation_time;
        e.setData({
            isLoading: !0,
            countDownNum: e.data.land_opreation_time
        }), e.setData({
            timer: setInterval(function() {
                n--, e.setData({
                    countDownNum: n
                }), 0 == n && (clearInterval(e.data.timer), e.setData({
                    isLoading: !1,
                    countDownNum: e.data.land_opreation_time
                }), e.closeDevice(a, t));
            }, 1e3)
        });
    },
    closeDevice: function(e, n) {
        var i = this, d = wx.getStorageSync("kundian_farm_uid");
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "closeDevice",
                control: "control",
                web_did: e,
                close_type: n,
                uniacid: t,
                uid: d
            },
            success: function(a) {
                console.log(a), wx.showModal({
                    title: "提示",
                    content: a.data.msg,
                    showCancel: !1
                }), i.setData({
                    close_type: 0
                });
            }
        });
    },
    submitData: function(a) {
        console.log(a);
    },
    onUnload: function(a) {
        var t = this, e = this.data.close_type;
        if (1 == e || 2 == e || 3 == e || 4 == e) {
            var n = t.data.mineLand.deviceInfo.did;
            t.closeDevice(n, e), clearInterval(t.data.timer);
        }
    },
    play: function(a) {
        this.setData({
            is_loading: !1
        });
    },
    lookStatusInfo: function(e) {
        if (this.setData({
            is_show_status: !this.data.is_show_status
        }), this.data.is_show_status) {
            var n = this, i = e.currentTarget.dataset.seedid, d = e.currentTarget.dataset.lid, o = e.detail.formId, s = wx.getStorageSync("kundian_farm_uid");
            wx.showLoading({
                title: "玩命加载中..."
            }), a.util.request({
                url: "entry/wxapp/class",
                data: {
                    op: "getSeedStatusList",
                    control: "land",
                    uniacid: t,
                    seed_id: i,
                    lid: d,
                    formid: o,
                    uid: s
                },
                success: function(a) {
                    n.setData({
                        landStatus: a.data.landStatus
                    }), wx.hideLoading();
                }
            });
        }
    },
    toSeed: function(a) {
        var t = this.data.lid, e = this.data.mineLand;
        if (e.residue_area <= 0) return wx.showModal({
            title: "提示",
            content: "当前地块面积不足~",
            showCancel: !1
        }), !1;
        wx.navigateTo({
            url: "/kundian_farm/pages/land/seedList/index?lid=" + t + "&can_count=" + e.residue_area
        });
    },
    pickSeed: function(a) {
        var t = this;
        if (this.setData({
            is_show_gain_dialog: !this.data.is_show_gain_dialog
        }), this.data.is_show_gain_dialog) {
            var e = a.currentTarget.dataset.seedid;
            this.data.sendMine.map(function(a) {
                e == a.id && t.setData({
                    gainSeed: a
                });
            });
        }
    },
    gainSeed: function(e) {
        var n = this, i = wx.getStorageSync("uid"), d = e.currentTarget.dataset.seedid, o = e.detail.formId;
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "gainSeed",
                control: "land",
                uniacid: t,
                seed_id: d,
                uid: i,
                formid: o
            },
            success: function(a) {
                wx.showModal({
                    title: "提示",
                    content: a.data.msg,
                    showCancel: !1,
                    success: function(a) {
                        var t = n.data.lid;
                        n.getLandDetail(t), n.setData({
                            is_show_gain_dialog: !n.data.is_show_gain_dialog
                        });
                    }
                });
            }
        });
    },
    intoBag: function(a) {
        var t = a.detail.formId;
        wx.navigateTo({
            url: "../seedBag/index?formid=" + t
        });
    },
    previewImg: function(a) {
        var t = a.currentTarget.dataset, e = t.id, n = t.current, i = [];
        this.data.landStatus.map(function(a) {
            a.id == e && (i = a.src);
        }), wx.previewImage({
            urls: i,
            current: i[n]
        });
    }
});