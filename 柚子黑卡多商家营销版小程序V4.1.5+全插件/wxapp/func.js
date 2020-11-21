function _defineProperty(e, t, n) {
    return t in e ? Object.defineProperty(e, t, {
        value: n,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = n, e;
}

var func = {};

function payresult(e, t, n) {
    var a = n.SendMessagePay, i = n.PayOrder, s = n.PayOrderurl, o = n.PayredirectTourl;
    e.util.request({
        url: "entry/wxapp/SendMessagePay",
        cachetime: "0",
        data: a,
        success: function(e) {
            console.log("发送成功"), console.log(e.data);
        }
    }), e.util.request({
        url: s,
        cachetime: "0",
        data: i,
        success: function(e) {
            console.log("跳转"), t.data.iscj - 0 == 1 && t.data.open_lottery ? wx.showModal({
                title: "提示",
                content: "购买成功,获得抽奖资格,是否参与抽奖",
                success: function(e) {
                    e.confirm ? wx.redirectTo({
                        url: "/mzhk_sun/plugin4/ticket/ticketmiandetail/ticketmiandetail?ggid=" + t.data.gid + "&gid=" + t.data.cjid
                    }) : e.cancel && wx.redirectTo({
                        url: o
                    });
                }
            }) : wx.redirectTo({
                url: o
            });
        }
    });
}

function paymemresult(e, n, t) {
    var a = t.PayOrder;
    e.util.request({
        url: "entry/wxapp/PayVIP",
        cachetime: "0",
        data: a,
        success: function(t) {
            n.setData({
                isclick: !1
            }), wx.showModal({
                content: "恭喜你，成为会员啦~",
                showCancel: !0,
                success: function(e) {
                    t.data.re ? wx.navigateTo({
                        url: "/mzhk_sun/pages/user/return/return"
                    }) : wx.navigateBack();
                }
            });
        },
        fail: function(e) {
            n.setData({
                isclick: !1
            });
        }
    });
}

function paycouponresult(e, t, n) {
    var a = n.PayredirectTourl;
    console.log(n), t.setData({
        receive: 1
    }), wx.showToast({
        title: "领取成功",
        icon: "success",
        duration: 1e3
    }), wx.redirectTo({
        url: a
    });
}

function payorderresult(e, n, t) {
    t.SendMessagePay;
    var a = t.PayOrder, i = t.PayOrderurl, s = t.PayredirectTourl, o = s.orderlist;
    e.util.request({
        url: i,
        cachetime: "0",
        data: a,
        success: function(e) {
            var t;
            (console.log(s.f_index), o[s.f_index].status = s.status, 1 == s.deliveryOrder) ? n.setData((_defineProperty(t = {}, "list.data", o), 
            _defineProperty(t, "isclick", !1), _defineProperty(t, "payStatus", 0), t)) : n.setData({
                orderlist: o,
                isclick: !1,
                payStatus: 0
            });
            n.data.iscj - 0 == 1 && wx.showModal({
                title: "提示",
                content: "购买成功,获得抽奖资格,是否参与抽奖",
                success: function(e) {
                    e.confirm ? wx.redirectTo({
                        url: "/mzhk_sun/plugin4/ticket/ticketmiandetail/ticketmiandetail?ggid=" + n.data.gid + "&gid=" + n.data.cjid
                    }) : e.cancel && wx.redirectTo({
                        url: s
                    });
                }
            });
        }
    });
}

func.gotourl = function(e, t, n) {
    var a = 3 < arguments.length && void 0 !== arguments[3] ? arguments[3] : "", i = t, s = "", o = !1;
    if (2 == i) s = "/mzhk_sun/pages/index/bargain/bargain"; else if (3 == i) s = "/mzhk_sun/pages/index/cards/cards"; else if (4 == i) s = "/mzhk_sun/pages/index/timebuy/timebuy"; else if (5 == i) s = "/mzhk_sun/pages/index/group/group"; else if (6 == i) s = "/mzhk_sun/pages/index/shop/shop?id=" + n; else if (7 == i) s = "/mzhk_sun/pages/index/bardet/bardet?id=" + n; else if (8 == i) s = "/mzhk_sun/pages/index/cardsdet/cardsdet?gid=" + n; else if (9 == i) s = "/mzhk_sun/pages/index/package/package?id=" + n; else if (10 == i) s = "/mzhk_sun/pages/index/groupdet/groupdet?id=" + n; else if (11 == i) s = "/mzhk_sun/pages/index/welfare/welfare?id=" + n; else if (13 == i) s = "/mzhk_sun/pages/index/freedet/freedet?id=" + n; else if (14 == i) s = "/mzhk_sun/pages/index/free/free"; else if (15 == i) s = "/mzhk_sun/pages/index/index", 
    o = !0; else if (16 == i) s = "/mzhk_sun/pages/active/active", o = !0; else if (17 == i) s = "/mzhk_sun/pages/goods/goods", 
    o = !0; else if (18 == i) s = "/mzhk_sun/pages/user/user", o = !0; else if (19 == i) s = "/mzhk_sun/pages/index/news/news"; else if (20 == i) s = "/mzhk_sun/pages/index/article/article?id=" + n; else if (21 == i) s = "/mzhk_sun/pages/dynamic/dynamic", 
    o = !0; else if (24 == i) s = "/mzhk_sun/pages/member/member"; else if (25 == i) s = "/mzhk_sun/pages/user/recharge/recharge"; else if (28 == i) s = "/mzhk_sun/plugin/eatvisit/life/life"; else if (29 == i) s = "/mzhk_sun/pages/index/coupon/coupon"; else if (44 == i) s = "/mzhk_sun/pages/productlist/productlist?id=" + n; else if (46 == i) s = "/mzhk_sun/pages/productlist/productlist"; else if (26 == i) {
        e.util.request({
            url: "entry/wxapp/User",
            cachetime: "0",
            showLoading: !1,
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {
                if (1 == e.data) return wx.showToast({
                    title: "禁止参与",
                    icon: "loading",
                    duration: 2e3
                }), s = "/mzhk_sun/pages/index/index", wx.redirectTo({
                    url: s
                }), !1;
            }
        });
        var r = wx.getStorageSync("openid");
        e.util.request({
            url: "entry/wxapp/IsPromoter",
            data: {
                openid: r,
                m: e.globalData.Plugin_distribution
            },
            showLoading: !1,
            success: function(e) {
                if (e) {
                    var t = e.data;
                    if (9 != t) s = 1 == t.status ? "/mzhk_sun/plugin/distribution/fxCenter/fxCenter" : "/mzhk_sun/plugin/distribution/fxAddShare/fxAddShare", 
                    wx.navigateTo({
                        url: s
                    }); else {
                        var n = wx.getStorageSync("users");
                        s = "/mzhk_sun/pages/user/user?d_user_id=" + n.id, wx.navigateTo({
                            url: s
                        });
                    }
                }
            }
        });
    } else if (30 == i) {
        e.util.request({
            url: "entry/wxapp/User",
            cachetime: "0",
            showLoading: !1,
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {
                if (1 == e.data) return wx.showToast({
                    title: "禁止参与",
                    icon: "loading",
                    duration: 2e3
                }), s = "/mzhk_sun/pages/index/index", wx.redirectTo({
                    url: s
                }), !1;
            }
        });
        r = wx.getStorageSync("openid");
        e.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 3
            },
            showLoading: !1,
            success: function(e) {
                var t = 2 != e.data && e.data;
                2 != t && t ? (s = "/mzhk_sun/plugin/shoppingMall/home/home", wx.navigateTo({
                    url: s
                })) : wx.showModal({
                    title: "提示信息",
                    content: "还未安装积分插件，请先购买安装",
                    showCancel: !1,
                    success: function(e) {
                        s = "/mzhk_sun/pages/index/index", wx.navigateTo({
                            url: s
                        });
                    }
                });
            }
        });
    } else if (31 == i) {
        e.util.request({
            url: "entry/wxapp/User",
            cachetime: "0",
            showLoading: !1,
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {
                if (1 == e.data) return wx.showToast({
                    title: "禁止参与",
                    icon: "loading",
                    duration: 2e3
                }), s = "/mzhk_sun/pages/index/index", wx.redirectTo({
                    url: s
                }), !1;
            }
        });
        r = wx.getStorageSync("openid");
        e.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 4
            },
            showLoading: !1,
            success: function(e) {
                2 != (2 != e.data && e.data) ? (s = "/mzhk_sun/plugin/fission/index/index", wx.navigateTo({
                    url: s
                })) : wx.showModal({
                    title: "提示信息",
                    content: "还未安装裂变券插件，请先购买安装",
                    showCancel: !1,
                    success: function(e) {
                        s = "/mzhk_sun/pages/index/index", wx.navigateTo({
                            url: s
                        });
                    }
                });
            }
        });
    } else if (32 == i) {
        e.util.request({
            url: "entry/wxapp/User",
            cachetime: "0",
            showLoading: !1,
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {
                if (1 == e.data) return wx.showToast({
                    title: "禁止参与",
                    icon: "loading",
                    duration: 2e3
                }), s = "/mzhk_sun/pages/index/index", wx.redirectTo({
                    url: s
                }), !1;
            }
        });
        r = wx.getStorageSync("openid");
        e.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 5
            },
            showLoading: !1,
            success: function(e) {
                var t = 2 != e.data && e.data;
                2 != t && t ? (s = "/mzhk_sun/plugin/redpacket/packageReceive/packageReceive", wx.navigateTo({
                    url: s
                })) : wx.showModal({
                    title: "提示信息",
                    content: "还未安装红包插件，请先购买安装",
                    showCancel: !1,
                    success: function(e) {
                        s = "/mzhk_sun/pages/index/index", wx.navigateTo({
                            url: s
                        });
                    }
                });
            }
        });
    } else if (33 == i) {
        e.util.request({
            url: "entry/wxapp/User",
            cachetime: "0",
            showLoading: !1,
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {
                if (1 == e.data) return wx.showToast({
                    title: "禁止参与",
                    icon: "loading",
                    duration: 2e3
                }), s = "/mzhk_sun/pages/index/index", wx.redirectTo({
                    url: s
                }), !1;
            }
        });
        r = wx.getStorageSync("openid");
        e.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 5
            },
            showLoading: !1,
            success: function(e) {
                var t = 2 != e.data && e.data;
                2 != t && t ? (s = "/mzhk_sun/plugin/redpacket/packageReceive2/packageReceive2", 
                wx.navigateTo({
                    url: s
                })) : wx.showModal({
                    title: "提示信息",
                    content: "还未安装红包插件，请先购买安装",
                    showCancel: !1,
                    success: function(e) {
                        s = "/mzhk_sun/pages/index/index", wx.navigateTo({
                            url: s
                        });
                    }
                });
            }
        });
    } else if (34 == i) {
        e.util.request({
            url: "entry/wxapp/User",
            cachetime: "0",
            showLoading: !1,
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {
                if (1 == e.data) return wx.showToast({
                    title: "禁止参与",
                    icon: "loading",
                    duration: 2e3
                }), s = "/mzhk_sun/pages/index/index", wx.redirectTo({
                    url: s
                }), !1;
            }
        });
        r = wx.getStorageSync("openid");
        e.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 7
            },
            showLoading: !1,
            success: function(e) {
                var t = 2 != e.data && e.data;
                2 != t && t ? (s = "/mzhk_sun/plugin2/secondary/list/list?tab=1", wx.reLaunch({
                    url: s
                })) : wx.showModal({
                    title: "提示信息",
                    content: "还未安装次卡插件，请先购买安装",
                    showCancel: !1,
                    success: function(e) {
                        s = "/mzhk_sun/pages/index/index", wx.navigateTo({
                            url: s
                        });
                    }
                });
            }
        });
    } else if (35 == i) {
        e.util.request({
            url: "entry/wxapp/User",
            cachetime: "0",
            showLoading: !1,
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {
                if (1 == e.data) return wx.showToast({
                    title: "禁止参与",
                    icon: "loading",
                    duration: 2e3
                }), s = "/mzhk_sun/pages/index/index", wx.redirectTo({
                    url: s
                }), !1;
            }
        });
        r = wx.getStorageSync("openid");
        e.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 8
            },
            showLoading: !1,
            success: function(e) {
                var t = e.data.isopen;
                2 != t && t ? (s = "/mzhk_sun/plugin3/package/packageIndex/packageIndex", wx.reLaunch({
                    url: s
                })) : wx.showModal({
                    title: "提示信息",
                    content: "还未安装套餐包插件，请先购买安装",
                    showCancel: !1,
                    success: function(e) {
                        s = "/mzhk_sun/pages/index/index", wx.navigateTo({
                            url: s
                        });
                    }
                });
            }
        });
    } else {
        if (27 == i) return a.setData({
            showPublic: 1
        }), !1;
        if (22 == i) return wx.scanCode({
            success: function(e) {
                console.log("扫描获取数据-成功"), console.log(e);
                var t = "/mzhk_sun/pages/user/pay/pay?bid=" + JSON.parse(e.result).bid;
                wx.navigateTo({
                    url: t
                });
            }
        }), !1;
        if (23 == i) return !1;
        if (36 == i) {
            e.util.request({
                url: "entry/wxapp/User",
                cachetime: "0",
                showLoading: !1,
                data: {
                    openid: wx.getStorageSync("openid")
                },
                success: function(e) {
                    if (1 == e.data) return wx.showToast({
                        title: "禁止参与",
                        icon: "loading",
                        duration: 2e3
                    }), s = "/mzhk_sun/pages/index/index", wx.redirectTo({
                        url: s
                    }), !1;
                }
            });
            r = wx.getStorageSync("openid");
            e.util.request({
                url: "entry/wxapp/Plugin",
                data: {
                    type: 3
                },
                showLoading: !1,
                success: function(e) {
                    var t = 2 != e.data && e.data;
                    2 != t && t ? (s = "/mzhk_sun/plugin/shoppingMall/integrationMall/integrationMall", 
                    wx.navigateTo({
                        url: s
                    })) : wx.showModal({
                        title: "提示信息",
                        content: "还未安装积分插件，请先购买安装",
                        showCancel: !1,
                        success: function(e) {
                            s = "/mzhk_sun/pages/index/index", wx.navigateTo({
                                url: s
                            });
                        }
                    });
                }
            });
        } else if (37 == i) {
            e.util.request({
                url: "entry/wxapp/User",
                cachetime: "0",
                showLoading: !1,
                data: {
                    openid: wx.getStorageSync("openid")
                },
                success: function(e) {
                    if (1 == e.data) return wx.showToast({
                        title: "禁止参与",
                        icon: "loading",
                        duration: 2e3
                    }), s = "/mzhk_sun/pages/index/index", wx.redirectTo({
                        url: s
                    }), !1;
                }
            });
            r = wx.getStorageSync("openid");
            e.util.request({
                url: "entry/wxapp/Plugin",
                data: {
                    type: 3
                },
                showLoading: !1,
                success: function(e) {
                    var t = 2 != e.data && e.data;
                    2 != t && t ? (s = "/mzhk_sun/plugin/shoppingMall/assignment/assignment", wx.navigateTo({
                        url: s
                    })) : wx.showModal({
                        title: "提示信息",
                        content: "还未安装积分插件，请先购买安装",
                        showCancel: !1,
                        success: function(e) {
                            s = "/mzhk_sun/pages/index/index", wx.navigateTo({
                                url: s
                            });
                        }
                    });
                }
            });
        } else if (38 == i) {
            e.util.request({
                url: "entry/wxapp/User",
                cachetime: "0",
                showLoading: !1,
                data: {
                    openid: wx.getStorageSync("openid")
                },
                success: function(e) {
                    if (1 == e.data) return wx.showToast({
                        title: "禁止参与",
                        icon: "loading",
                        duration: 2e3
                    }), s = "/mzhk_sun/pages/index/index", wx.redirectTo({
                        url: s
                    }), !1;
                }
            });
            r = wx.getStorageSync("openid");
            e.util.request({
                url: "entry/wxapp/Plugin",
                data: {
                    type: 3
                },
                showLoading: !1,
                success: function(e) {
                    var t = 2 != e.data && e.data;
                    2 != t && t ? (s = "/mzhk_sun/plugin/shoppingMall/me/me", wx.navigateTo({
                        url: s
                    })) : wx.showModal({
                        title: "提示信息",
                        content: "还未安装积分插件，请先购买安装",
                        showCancel: !1,
                        success: function(e) {
                            s = "/mzhk_sun/pages/index/index", wx.navigateTo({
                                url: s
                            });
                        }
                    });
                }
            });
        } else if (39 == i) {
            e.util.request({
                url: "entry/wxapp/User",
                cachetime: "0",
                showLoading: !1,
                data: {
                    openid: wx.getStorageSync("openid")
                },
                success: function(e) {
                    if (1 == e.data) return wx.showToast({
                        title: "禁止参与",
                        icon: "loading",
                        duration: 2e3
                    }), s = "/mzhk_sun/pages/index/index", wx.redirectTo({
                        url: s
                    }), !1;
                }
            });
            r = wx.getStorageSync("openid");
            e.util.request({
                url: "entry/wxapp/Plugin",
                data: {
                    type: 3
                },
                showLoading: !1,
                success: function(e) {
                    var t = 2 != e.data && e.data;
                    2 != t && t ? (s = "/mzhk_sun/plugin/shoppingMall/pointsDraw/pointsDraw", wx.navigateTo({
                        url: s
                    })) : wx.showModal({
                        title: "提示信息",
                        content: "还未安装积分插件，请先购买安装",
                        showCancel: !1,
                        success: function(e) {
                            s = "/mzhk_sun/pages/index/index", wx.navigateTo({
                                url: s
                            });
                        }
                    });
                }
            });
        } else if (40 == i) {
            e.util.request({
                url: "entry/wxapp/User",
                cachetime: "0",
                showLoading: !1,
                data: {
                    openid: wx.getStorageSync("openid")
                },
                success: function(e) {
                    if (1 == e.data) return wx.showToast({
                        title: "禁止参与",
                        icon: "loading",
                        duration: 2e3
                    }), s = "/mzhk_sun/pages/index/index", wx.redirectTo({
                        url: s
                    }), !1;
                }
            });
            r = wx.getStorageSync("openid");
            e.util.request({
                url: "entry/wxapp/Plugin",
                data: {
                    type: 9
                },
                showLoading: !1,
                success: function(e) {
                    console.log(e);
                    var t = 2 != e.data && e.data;
                    2 != t && t ? (s = "/mzhk_sun/plugin4/ticket/ticketmiannew/ticketmiannew", wx.navigateTo({
                        url: s
                    })) : wx.showModal({
                        title: "提示信息",
                        content: "还未安装抽奖插件，请先购买安装",
                        showCancel: !1,
                        success: function(e) {
                            s = "/mzhk_sun/pages/index/index", wx.navigateTo({
                                url: s
                            });
                        }
                    });
                }
            });
        } else if (41 == i) {
            e.util.request({
                url: "entry/wxapp/User",
                cachetime: "0",
                showLoading: !1,
                data: {
                    openid: wx.getStorageSync("openid")
                },
                success: function(e) {
                    if (1 == e.data) return wx.showToast({
                        title: "禁止参与",
                        icon: "loading",
                        duration: 2e3
                    }), s = "/mzhk_sun/pages/index/index", wx.redirectTo({
                        url: s
                    }), !1;
                }
            });
            r = wx.getStorageSync("openid");
            e.util.request({
                url: "entry/wxapp/Plugin",
                data: {
                    type: 6
                },
                showLoading: !1,
                success: function(e) {
                    console.log(e);
                    var t = 2 != e.data && e.data;
                    2 != t && t ? (console.log(t), s = "/mzhk_sun/pages/member/member?cur=2", wx.navigateTo({
                        url: s
                    })) : wx.showModal({
                        title: "提示信息",
                        content: "还未安装权益插件，请先购买安装",
                        showCancel: !1,
                        success: function(e) {
                            s = "/mzhk_sun/pages/index/index", wx.navigateTo({
                                url: s
                            });
                        }
                    });
                }
            });
        } else if (42 == i) {
            console.log(11111), e.util.request({
                url: "entry/wxapp/User",
                cachetime: "0",
                showLoading: !1,
                data: {
                    openid: wx.getStorageSync("openid")
                },
                success: function(e) {
                    if (console.log(e), 1 == e.data) return wx.showToast({
                        title: "禁止参与",
                        icon: "loading",
                        duration: 2e3
                    }), s = "/mzhk_sun/pages/index/index", wx.redirectTo({
                        url: s
                    }), !1;
                }
            });
            r = wx.getStorageSync("openid");
            e.util.request({
                url: "entry/wxapp/Plugin",
                data: {
                    type: 9
                },
                showLoading: !1,
                success: function(e) {
                    console.log(e);
                    var t = 2 != e.data && e.data;
                    2 != t && t ? (console.log(t), s = "/mzhk_sun/pages/gifts/gifts", wx.navigateTo({
                        url: s
                    })) : wx.showModal({
                        title: "提示信息",
                        content: "还未安装抽奖插件，请先购买安装",
                        showCancel: !1,
                        success: function(e) {
                            s = "/mzhk_sun/pages/index/index", wx.navigateTo({
                                url: s
                            });
                        }
                    });
                }
            });
        } else if (43 == i) {
            console.log(11111), e.util.request({
                url: "entry/wxapp/User",
                cachetime: "0",
                showLoading: !1,
                data: {
                    openid: wx.getStorageSync("openid")
                },
                success: function(e) {
                    if (console.log(e), 1 == e.data) return wx.showToast({
                        title: "禁止参与",
                        icon: "loading",
                        duration: 2e3
                    }), s = "/mzhk_sun/pages/index/index", wx.redirectTo({
                        url: s
                    }), !1;
                }
            });
            r = wx.getStorageSync("openid");
            e.util.request({
                url: "entry/wxapp/Plugin",
                data: {
                    type: 9
                },
                showLoading: !1,
                success: function(e) {
                    console.log(e);
                    var t = 2 != e.data && e.data;
                    2 != t && t ? (console.log(t), s = "/mzhk_sun/plugin4/gift/giftindex/giftindex", 
                    wx.navigateTo({
                        url: s
                    })) : wx.showModal({
                        title: "提示信息",
                        content: "还未安装抽奖插件，请先购买安装",
                        showCancel: !1,
                        success: function(e) {
                            s = "/mzhk_sun/pages/index/index", wx.navigateTo({
                                url: s
                            });
                        }
                    });
                }
            });
        } else if (45 == i) {
            console.log(11111);
            wx.navigateTo({
                url: "/mzhk_sun/plugin3/delivery/carList/carList"
            });
        } else 12 == i && e.util.request({
            url: "entry/wxapp/GetOtherApplets",
            data: {
                id: n
            },
            success: function(e) {
                wx.navigateToMiniProgram({
                    appId: e.data.wxappjump.appid,
                    path: e.data.wxappjump.path,
                    extarData: {
                        open: "auth"
                    },
                    envVersion: "develop",
                    success: function(e) {
                        console.log("跳转成功");
                    },
                    fail: function(e) {
                        console.log("跳转失败");
                    }
                });
            },
            fail: function(e) {
                console.log("获取其他小程序数据失败");
            }
        });
    }
    "" != s && (o ? wx.redirectTo({
        url: s
    }) : wx.navigateTo({
        url: s
    }));
}, func.islogin = function(t, n) {
    var e = wx.getStorageSync("have_wxauth"), a = wx.getStorageSync("openid"), i = wx.getStorageSync("users");
    e && a && i || wx.getSetting({
        success: function(e) {
            e.authSetting["scope.userInfo"] ? (t.wxauthSetting(), wx.setStorageSync("have_wxauth", 1), 
            n.setData({
                is_modal_Hidden: !0
            })) : n.setData({
                is_modal_Hidden: !1
            });
        },
        fail: function(e) {
            n.setData({
                is_modal_Hidden: !1
            });
        }
    });
}, func.orderarr = function(t, n, a) {
    var i = this, s = a.orderarr, e = a.payType, o = a.resulttype ? a.resulttype : 5;
    a.orderarr.m && a.orderarr.m, a.message, a.deliveryOrder;
    console.log(n.data.cjid), 1 == e ? t.util.request({
        url: "entry/wxapp/Orderarr",
        data: s,
        success: function(e) {
            console.log(e.data), wx.requestPayment({
                timeStamp: e.data.timeStamp,
                nonceStr: e.data.nonceStr,
                package: e.data.package,
                signType: e.data.signType,
                paySign: e.data.paySign,
                success: function(e) {
                    wx.showToast({
                        title: "支付成功",
                        icon: "success",
                        duration: 2e3
                    }), 1 == o ? i.payresultsms(t, n, a) : 2 == o ? paymemresult(t, n, a) : 3 == o ? payorderresult(t, n, a) : 4 == o ? paycouponresult(t, n, a) : payresult(t, n, a);
                },
                fail: function(e) {
                    wx.showToast({
                        title: "支付失败",
                        icon: "none",
                        duration: 2e3
                    }), console.log("失败00003"), n.setData({
                        continuesubmit: !0,
                        isclickpay: !1,
                        isclick: !1
                    });
                }
            });
        },
        fail: function(e) {
            console.log("失败00002"), n.setData({
                continuesubmit: !0,
                isclickpay: !1,
                isclick: !1
            }), wx.showModal({
                title: "提示信息",
                content: e.data.message,
                showCancel: !1
            });
        }
    }) : 2 == e && (console.log("余额"), console.log(s), t.util.request({
        url: "entry/wxapp/VIP",
        showLoading: !1,
        data: {
            openid: wx.getStorageSync("openid")
        },
        success: function(e) {
            console.log(e), console.log(parseFloat(e.data.money)), console.log(parseFloat(s.price)), 
            parseFloat(e.data.money) >= parseFloat(s.price) ? t.util.request({
                url: "entry/wxapp/OrderarrYue",
                data: s,
                success: function(e) {
                    wx.showToast({
                        title: "支付成功",
                        icon: "success",
                        duration: 2e3
                    }), 1 == o ? i.payresultsms(t, n, a) : 2 == o ? paymemresult(t, n, a) : 3 == o ? payorderresult(t, n, a) : 4 == o ? paycouponresult(t, n, a) : payresult(t, n, a);
                },
                fail: function(e) {
                    console.log("失败00004"), n.setData({
                        continuesubmit: !0,
                        isclickpay: !1,
                        isclick: !1
                    }), wx.showModal({
                        title: "提示信息",
                        content: e.data.message,
                        showCancel: !1
                    });
                }
            }) : wx.showModal({
                title: "提示信息",
                content: "余额不足",
                showCancel: !1
            });
        }
    }));
}, func.payresultsms = function(e, t, n) {
    var a = n.SendMessagePay, i = (n.PayOrder, n.PayOrderurl, n.PayredirectTourl, n.SendSms);
    e.util.request({
        url: "entry/wxapp/SendMessagePay",
        cachetime: "0",
        data: a,
        success: function(e) {
            console.log("发送成功"), console.log(e.data);
        }
    }), i ? e.util.request({
        url: "entry/wxapp/SendSms",
        cachetime: "0",
        data: i,
        success: function(e) {
            wx.showModal({
                title: "提示",
                content: "提交成功，将返回上一页",
                showCancel: !1,
                success: function(e) {
                    wx.navigateBack();
                }
            });
        }
    }) : wx.showModal({
        title: "提示",
        content: "提交成功，将返回上一页",
        showCancel: !1,
        success: function(e) {
            wx.navigateBack();
        }
    });
}, func.decodeScene = function(e) {
    if (e.scene) for (var t = e, n = decodeURIComponent(e.scene).split("&"), a = 0; a < n.length; a++) {
        var i = n[a].split("=");
        t[i[0]] = i[1];
    } else t = e;
    return t;
}, func.show = function(e, t, n, a) {
    var i = wx.createAnimation({
        duration: t,
        timingFunction: "ease"
    });
    i.opacity(a).step();
    var s = '{"' + n + '":""}';
    (s = JSON.parse(s))[n] = i.export(), e.setData(s);
}, func.slideupshow = function(e, t, n, a, i) {
    var s = wx.createAnimation({
        duration: t,
        timingFunction: "ease"
    });
    s.translateY(a).opacity(i).step();
    var o = '{"' + n + '":""}';
    (o = JSON.parse(o))[n] = s.export(), e.setData(o);
}, func.sliderightshow = function(e, t, n, a, i) {
    var s = wx.createAnimation({
        duration: t,
        timingFunction: "ease"
    });
    s.translateX(a).opacity(i).step();
    var o = '{"' + n + '":""}';
    (o = JSON.parse(o))[n] = s.export(), e.setData(o);
}, func.creatPoster = function(n, e, t, s, a, o) {
    var i = getCurrentPages(), r = i[i.length - 1], u = n.siteInfo.siteroot.split("/app/")[0] + "/attachment/", c = "";
    wx.showLoading({
        title: "获取图片中..."
    });
    var l = s.gid ? s.gid : 0;
    n.util.request({
        url: "entry/wxapp/GetwxCode",
        data: {
            page: e,
            width: t,
            gid: l,
            m: n.globalData.Plugin_lottery
        },
        success: function(i) {
            console.log("获取小程序二维码"), console.log(i.data), c = i.data;
            var e = new Promise(function(t, e) {
                wx.getImageInfo({
                    src: s.url + s.logo,
                    success: function(e) {
                        console.log("图片缓存1"), console.log(e), t(e.path);
                    },
                    fail: function(e) {
                        console.log("图片1缓存失败"), t(s.url + s.logo), console.log(e);
                    }
                });
            });
            console.log(u + c);
            var t = new Promise(function(t, e) {
                wx.getImageInfo({
                    src: u + c,
                    success: function(e) {
                        n.util.request({
                            url: "entry/wxapp/DelwxCode",
                            data: {
                                imgurl: c,
                                m: n.globalData.Plugin_lottery
                            },
                            success: function(e) {
                                console.log(e.data);
                            }
                        }), console.log("图片缓存2"), console.log(e), t(e.path);
                    },
                    fail: function(e) {
                        console.log("图片2保存失败"), t(u + c), console.log(e);
                    }
                });
            });
            Promise.all([ e, t ]).then(function(e) {
                console.log(e), console.log("进入 promise"), console.log(i);
                var t = wx.createCanvasContext(o), n = (s.bname, e[0]), a = e[1];
                t.rect(0, 0, 580, 680), t.setStrokeStyle("#ffffff"), t.setFillStyle("#ffffff"), 
                t.fill(), t.drawImage(n, 0, 0, 580, 350), t.setFontSize(36), t.setFillStyle("#fe5047"), 
                t.fillText("参与抽奖 有惊喜哦！", 126, 420, 340, 36), t.drawImage(a, 60, 460, 196, 196), 
                t.drawImage("../../resource/images/fingerprint.png", 368, 480, 120, 134), t.setFontSize(24), 
                t.setFillStyle("#999"), t.fillText("长按识别二维码进入", 316, 650, 340, 24), t.stroke(), 
                t.draw(), console.log("结束 promise"), wx.hideLoading(), wx.showLoading({
                    title: "开始生成海报..."
                }), new Promise(function(e, t) {
                    setTimeout(function() {
                        e("second ok");
                    }, 500);
                }).then(function(e) {
                    console.log(e), wx.canvasToTempFilePath({
                        x: 0,
                        y: 0,
                        width: 580,
                        height: 680,
                        destWidth: 580,
                        destHeight: 680,
                        canvasId: o,
                        success: function(e) {
                            console.log("进入 canvasToTempFilePath"), r.setData({
                                prurl: e.tempFilePath,
                                hidden: !1
                            }), wx.hideLoading();
                        },
                        fail: function(e) {
                            console.log(e);
                        }
                    });
                });
            });
        }
    });
}, module.exports = func;