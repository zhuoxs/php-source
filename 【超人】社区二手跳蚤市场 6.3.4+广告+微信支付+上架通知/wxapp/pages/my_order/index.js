var app = getApp(), Toptips = require("../../libs/zanui/toptips/index");

Page({
    data: {
        confirmBar: !1,
        pages: 1,
        hide: !0,
        more: !0,
        refresh: !0,
        expressList: [ {
            name: "顺丰速运",
            code: "SF"
        }, {
            name: "百世快递",
            code: "HTKY"
        }, {
            name: "中通快递",
            code: "ZTO"
        }, {
            name: "申通快递",
            code: "STO"
        }, {
            name: "圆通速递",
            code: "YTO"
        }, {
            name: "韵达速递",
            code: "YD"
        }, {
            name: "邮政快递",
            code: "YZPY"
        }, {
            name: "EMS",
            code: "EMS"
        }, {
            name: "天天快递",
            code: "HHTT"
        }, {
            name: "京东快递",
            code: "JD"
        }, {
            name: "优速快递",
            code: "UC"
        }, {
            name: "德邦快递",
            code: "DBL"
        }, {
            name: "宅急送",
            code: "ZJS"
        }, {
            name: "TNT快递",
            code: "TNT"
        }, {
            name: "UPS",
            code: "UPS"
        }, {
            name: "DHL",
            code: "DHL"
        } ]
    },
    onLoad: function(t) {
        var e = this, a = wx.getStorageSync("loading_img");
        a ? e.setData({
            loadingImg: a
        }) : e.setData({
            loadingImg: "../../libs/images/loading.gif"
        }), app.viewCount();
        var o = wx.getStorageSync("userInfo");
        e.setData({
            uid: o.memberInfo.uid,
            type: t.type
        }), e.getOrderList(t.type);
    },
    getOrderList: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/order",
            cachetime: "0",
            data: {
                type: t,
                m: "superman_hand2"
            },
            success: function(t) {
                var e = "";
                "sell" == a.data.type ? e = "卖出" : "buy" == a.data.type && (e = "买到"), wx.setNavigationBarTitle({
                    title: "我" + e + "的"
                }), t.data.errno ? wx.showModal({
                    title: "系统提示",
                    content: t.data.errmsg
                }) : a.setData({
                    list: t.data.data.list,
                    total: t.data.data.list ? t.data.data.list.length : 0,
                    showExpress: 1 == t.data.data.show_express,
                    credit_title: app.globalData.credit_title,
                    completed: !0
                });
            },
            fail: function(t) {
                a.setData({
                    completed: !0
                }), wx.showModal({
                    title: "系统提示",
                    content: t.data.errmsg
                });
            }
        });
    },
    showBottomModal: function(t) {
        this.setData({
            showBottomModal: !0,
            order_id: t.currentTarget.dataset.id
        });
    },
    PickerChange: function(t) {
        this.setData({
            epIndex: t.detail.value
        });
    },
    showAddress: function(t) {
        wx.showModal({
            title: "自提地址",
            content: t.currentTarget.dataset.address,
            showCancel: !1
        });
    },
    checkExpress: function(t) {
        wx.navigateTo({
            url: "../express_info/index?orderid=" + t.currentTarget.dataset.id
        });
    },
    sendOrder: function(t) {
        var e = this, a = t.detail.formId, o = t.detail.value;
        null != e.data.epIndex ? "" != o.express_no ? (app.util.request({
            url: "entry/wxapp/notice",
            cachetime: "0",
            data: {
                act: "formid",
                formid: a,
                m: "superman_hand2"
            },
            success: function(t) {
                0 == t.data.errno ? console.log("formid已添加") : console.log(t.data.errmsg);
            },
            fail: function(t) {
                console.log(t.data.errmsg);
            }
        }), app.util.request({
            url: "entry/wxapp/order",
            cachetime: "0",
            data: {
                act: "post",
                orderid: e.data.order_id,
                status: 2,
                formId: a,
                express_company: e.data.expressList[e.data.epIndex].code,
                express_no: o.express_no,
                m: "superman_hand2"
            },
            success: function(t) {
                e.setData({
                    showBottomModal: !1
                }), t.data.errno ? wx.showModal({
                    title: "系统提示",
                    content: t.data.errmsg
                }) : (wx.showToast({
                    title: "发货成功",
                    icon: "success"
                }), setTimeout(function() {
                    e.getOrderList(e.data.type);
                }, 1500));
            },
            fail: function(t) {
                e.setData({
                    showBottomModal: !1
                }), wx.showModal({
                    title: "系统提示",
                    content: t.data.errmsg
                });
            }
        })) : wx.showToast({
            title: "请填写快递单号",
            icon: "none"
        }) : wx.showToast({
            title: "请选择快递公司",
            icon: "none"
        });
    },
    cacelOrder: function(t) {
        var e = t.currentTarget.dataset.id, a = t.detail.formId;
        app.util.request({
            url: "entry/wxapp/notice",
            cachetime: "0",
            data: {
                act: "formid",
                formid: a,
                m: "superman_hand2"
            },
            success: function(t) {
                0 == t.data.errno ? console.log("formid已添加") : console.log(t.data.errmsg);
            },
            fail: function(t) {
                console.log(t.data.errmsg);
            }
        }), this.setData({
            orderId: e,
            showModal: !0
        });
    },
    refund: function(t) {
        var e = this, a = t.currentTarget.dataset.id, o = t.detail.formId;
        app.util.request({
            url: "entry/wxapp/notice",
            cachetime: "0",
            data: {
                act: "formid",
                formid: o,
                m: "superman_hand2"
            },
            success: function(t) {
                0 == t.data.errno ? console.log("formid已添加") : console.log(t.data.errmsg);
            },
            fail: function(t) {
                console.log(t.data.errmsg);
            }
        }), app.util.request({
            url: "entry/wxapp/order",
            cachetime: "0",
            data: {
                act: "refund",
                orderid: a,
                m: "superman_hand2"
            },
            success: function(t) {
                0 == t.data.errno ? (wx.showToast({
                    title: "退款成功"
                }), setTimeout(function() {
                    e.getOrderList(e.data.type);
                }, 1500)) : wx.showModal({
                    title: "系统提示",
                    content: t.data.errmsg
                });
            },
            fail: function(t) {
                wx.showModal({
                    title: "系统提示",
                    content: t.data.errmsg
                });
            }
        });
    },
    deleteOrder: function(t) {
        var e = this, a = t.currentTarget.dataset.id, o = t.detail.formId, r = wx.getStorageSync("userInfo").memberInfo.uid;
        app.util.request({
            url: "entry/wxapp/notice",
            cachetime: "0",
            data: {
                act: "formid",
                formid: o,
                m: "superman_hand2"
            },
            success: function(t) {
                0 == t.data.errno ? console.log("formid已添加") : console.log(t.data.errmsg);
            },
            fail: function(t) {
                console.log(t.data.errmsg);
            }
        }), wx.showModal({
            title: "系统提示",
            content: "确认要删除该订单？",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/order",
                    cachetime: "0",
                    data: {
                        act: "delete",
                        orderid: a,
                        uid: r,
                        m: "superman_hand2"
                    },
                    success: function(t) {
                        t.data.errno ? wx.showModal({
                            title: "系统提示",
                            content: t.data.errmsg
                        }) : (wx.showToast({
                            title: "删除成功"
                        }), setTimeout(function() {
                            e.getOrderList(e.data.type);
                        }, 1500));
                    },
                    fail: function(t) {
                        wx.showModal({
                            title: "系统提示",
                            content: t.data.errmsg
                        });
                    }
                });
            }
        });
    },
    goComment: function(t) {
        var e = t.currentTarget.dataset.id, a = t.detail.formId;
        app.util.request({
            url: "entry/wxapp/notice",
            cachetime: "0",
            data: {
                act: "formid",
                formid: a,
                m: "superman_hand2"
            },
            success: function(t) {
                0 == t.data.errno ? console.log("formid已添加") : console.log(t.data.errmsg);
            },
            fail: function(t) {
                console.log(t.data.errmsg);
            }
        }), wx.navigateTo({
            url: "../comment/index?orderid=" + e
        });
    },
    closeModal: function() {
        this.setData({
            showModal: !1
        });
    },
    closeBottomModal: function() {
        this.setData({
            showBottomModal: !1
        });
    },
    onPullDownRefresh: function() {
        this.getOrderList(this.data.type), wx.stopPullDownRefresh();
    },
    formSubmit: function(t) {
        var e = this, a = t.detail.value.content, o = e.data.orderId;
        if ("" != a) {
            var r = t.detail.formId;
            app.util.request({
                url: "entry/wxapp/notice",
                cachetime: "0",
                data: {
                    act: "formid",
                    formid: r,
                    m: "superman_hand2"
                },
                success: function(t) {
                    0 == t.data.errno ? console.log("formid已添加") : console.log(t.data.errmsg);
                },
                fail: function(t) {
                    console.log(t.data.errmsg);
                }
            }), app.util.request({
                url: "entry/wxapp/order",
                cachetime: "0",
                data: {
                    act: "post",
                    orderid: o,
                    status: -1,
                    reason: a,
                    m: "superman_hand2"
                },
                success: function(t) {
                    e.setData({
                        showModal: !1
                    }), t.data.errno ? wx.showModal({
                        title: "系统提示",
                        content: t.data.errmsg + "(" + t.data.errno + ")"
                    }) : (wx.showToast({
                        title: "提交成功",
                        icon: "success"
                    }), e.getOrderList(e.data.type));
                },
                fail: function(t) {
                    wx.showModal({
                        title: "系统提示",
                        content: t.data.errmsg + "(" + t.data.errno + ")"
                    });
                }
            });
        } else Toptips("内容不能为空");
    },
    confirmReceive: function(t) {
        var e = this, a = t.currentTarget.dataset.id, o = t.detail.formId;
        app.util.request({
            url: "entry/wxapp/notice",
            cachetime: "0",
            data: {
                act: "formid",
                formid: o,
                m: "superman_hand2"
            },
            success: function(t) {
                0 == t.data.errno ? console.log("formid已添加") : console.log(t.data.errmsg);
            },
            fail: function(t) {
                console.log(t.data.errmsg);
            }
        }), wx.showModal({
            title: "系统提示",
            content: "请确认物品已收到",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/order",
                    cachetime: "0",
                    data: {
                        act: "post",
                        orderid: a,
                        status: 3,
                        m: "superman_hand2"
                    },
                    success: function(t) {
                        t.data.errno ? wx.showModal({
                            title: "系统提示",
                            content: t.data.errmsg + "(" + t.data.errno + ")"
                        }) : wx.showToast({
                            title: "状态已修改",
                            icon: "success",
                            success: function() {
                                e.getOrderList(e.data.type);
                            }
                        });
                    },
                    fail: function(t) {
                        wx.showModal({
                            title: "系统提示",
                            content: t.data.errmsg + "(" + t.data.errno + ")"
                        });
                    }
                });
            }
        });
    },
    onReachBottom: function() {
        var o = this;
        if (o.data.refresh) if (o.data.total < 20) o.setData({
            more: !1
        }); else {
            o.setData({
                hide: !1
            });
            var r = o.data.pages + 1;
            app.util.request({
                url: "entry/wxapp/order",
                cachetime: "0",
                data: {
                    type: o.data.type,
                    page: r,
                    m: "superman_hand2"
                },
                success: function(t) {
                    if (o.setData({
                        hide: !0
                    }), 0 == t.data.errno) {
                        var e = t.data.data.list;
                        if (0 < e.length) {
                            var a = o.data.list.concat(e);
                            o.setData({
                                total: e.length,
                                list: a,
                                pages: r
                            });
                        } else o.setData({
                            more: !1,
                            refresh: !1
                        });
                    } else o.showIconToast(t.errmsg);
                }
            });
        }
    }
});