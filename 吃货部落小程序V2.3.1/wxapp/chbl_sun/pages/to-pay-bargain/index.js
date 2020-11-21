var app = getApp();

Page({
    data: {
        postData: [ "快递", "到店取货" ],
        addressData: [],
        addNew: [],
        cid: "",
        payData: ""
    },
    onLoad: function(t) {
        var a = this;
        a.urls(), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), console.log(t);
        var e = t.id, o = wx.getStorageSync("openid");
        if (t.userid) var n = t.userid; else n = o;
        wx.setStorageSync("userid", n), console.log(n), a.setData({
            userid: n
        }), t.pid ? app.util.request({
            url: "entry/wxapp/GroupsDetails",
            cachetime: "30",
            data: {
                id: e
            },
            success: function(e) {
                console.log(e), a.setData({
                    info: e.data.data,
                    pid: t.pid
                });
            }
        }) : app.util.request({
            url: "entry/wxapp/BuyGoodsInfo",
            cachetime: "30",
            data: {
                id: e,
                openid: o
            },
            success: function(e) {
                console.log(e), a.setData({
                    info: e.data.data
                });
            }
        });
    },
    urls: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(e) {
                wx.setStorageSync("url", e.data), t.setData({
                    url: e.data
                });
            }
        });
    },
    selectPost: function(e) {
        var d = this;
        if (console.log(e), d.setData({
            currentSelect: e.currentTarget.dataset.index
        }), 0 == e.currentTarget.dataset.index) wx.chooseAddress({
            success: function(e) {
                var t = e.userName, a = e.postalCode, o = e.cityName, n = e.provinceName, s = e.countyName, c = e.detailInfo, r = e.nationalCode, i = e.telNumber;
                d.setData({
                    userName: t,
                    postalCode: a,
                    provinceName: n,
                    cityName: o,
                    countyName: s,
                    detailInfo: c,
                    nationalCode: r,
                    telNumber: i,
                    showBox: "",
                    nickName: "",
                    mobile: ""
                });
            }
        }); else if (1 == e.currentTarget.dataset.index) {
            d.setData({
                showBox: 1,
                userName: ""
            });
        }
    },
    myName: function(e) {
        var t = e.detail.value;
        this.setData({
            nickName: t
        });
    },
    mobile: function(e) {
        console.log(e);
        var t = e.detail.value;
        this.setData({
            mobile: t
        });
    },
    message: function(e) {
        var t = e.detail;
        this.setData({
            msg: t
        });
    },
    onReady: function() {},
    toPayGroups: function(e) {
        console.log(e);
        var o = this, n = e.currentTarget.dataset.price, t = e.currentTarget.dataset.address, s = e.currentTarget.dataset.consignee, c = e.currentTarget.dataset.gid, r = e.currentTarget.dataset.phone, i = wx.getStorageSync("userid"), d = e.currentTarget.dataset.nickname, u = e.currentTarget.dataset.mobile, l = e.currentTarget.dataset.store_id;
        if (console.log(t), o.data.msg) p = o.data.msg.value; else var p = "";
        var g = wx.getStorageSync("openid");
        return s || d ? r || u ? void (1 != o.data.currentSelect || u ? app.util.request({
            url: "entry/wxapp/OrderPass",
            cachetime: "0",
            data: {
                gid: c,
                openid: g
            },
            success: function(e) {
                console.log(e.data), "1" != e.data && 1 != e.data ? app.util.request({
                    url: "entry/wxapp/Orderarr",
                    cachetime: "30",
                    data: {
                        price: n,
                        openid: g
                    },
                    success: function(e) {
                        console.log(e);
                        var a = e.data.package;
                        wx.requestPayment({
                            timeStamp: e.data.timeStamp,
                            nonceStr: e.data.nonceStr,
                            package: e.data.package,
                            signType: "MD5",
                            paySign: e.data.paySign,
                            success: function(e) {
                                console.log(e), wx.showToast({
                                    title: "支付成功",
                                    icon: "success",
                                    duration: 2e3
                                }), app.util.request({
                                    url: "entry/wxapp/groupsorder",
                                    cachetime: "30",
                                    data: {
                                        price: n,
                                        address: t,
                                        consignee: s,
                                        gid: c,
                                        phone: r,
                                        note: p,
                                        openid: g,
                                        mobile: u,
                                        nickName: d,
                                        store_id: l
                                    },
                                    success: function(e) {
                                        console.log(e);
                                        var t = e.data.data.id;
                                        app.util.request({
                                            url: "entry/wxapp/BuyMessage",
                                            cachetime: "0",
                                            data: {
                                                order_id: t,
                                                new_package: a,
                                                openid: g
                                            },
                                            success: function(e) {
                                                console.log("-------------模板消息发送----------------"), console.log(e);
                                            }
                                        }), app.util.request({
                                            url: "entry/wxapp/UpdateGroupsOrder",
                                            cachetime: "0",
                                            data: {
                                                order_id: t
                                            },
                                            success: function(e) {
                                                console.log(e), console.log(o.data.pid), 1 == o.data.pid && app.util.request({
                                                    url: "entry/wxapp/userGroups",
                                                    cachetime: "0",
                                                    data: {
                                                        openid: g,
                                                        gid: c,
                                                        order_id: t,
                                                        price: n,
                                                        userid: i
                                                    },
                                                    success: function(e) {
                                                        console.log(e), app.util.request({
                                                            url: "entry/wxapp/overGroups",
                                                            cachetime: "0",
                                                            data: {
                                                                gid: c,
                                                                userid: i
                                                            },
                                                            success: function(e) {
                                                                console.log(e), 1 == e.data || "1" == e.data ? wx.switchTab({
                                                                    url: "../first/index"
                                                                }) : (console.log("进入拼单——————————————————————————————————"), console.log(i), wx.reLaunch({
                                                                    url: "../pintuan-list/goCantuan?id=" + c + "&openid=" + i
                                                                }));
                                                            }
                                                        });
                                                    }
                                                });
                                            }
                                        });
                                    }
                                });
                            },
                            fail: function(e) {}
                        });
                    }
                }) : wx.showToast({
                    title: "该商品已经在订单列表中了！",
                    icon: "none"
                });
            }
        }) : wx.showToast({
            title: "请输入手机号码或联系人",
            icon: "none"
        })) : (wx.showToast({
            title: "请填写联系方式",
            icon: "none"
        }), !1) : (wx.showToast({
            title: "请填写收货人",
            icon: "none"
        }), !1);
    },
    toPay: function(e) {
        console.log(this.data), console.log(e);
        var t = e.currentTarget.dataset.price, a = e.currentTarget.dataset.address, n = e.currentTarget.dataset.consignee, s = e.currentTarget.dataset.gid, c = e.currentTarget.dataset.phone, r = e.currentTarget.dataset.nickname, i = e.currentTarget.dataset.mobile, d = e.currentTarget.dataset.store_id;
        if (console.log(d), this.data.msg) u = this.data.msg.value; else var u = "";
        if (0 == this.data.currentSelect) if (n) {
            var l = wx.getStorageSync("openid");
            app.util.request({
                url: "entry/wxapp/buyed",
                cachetime: "30",
                data: {
                    id: s,
                    openid: l
                },
                success: function(e) {
                    console.log(e), 1 == e.data ? wx.showToast({
                        title: "该商品已经在您的订单列表了，快去付款吧",
                        icon: "none"
                    }) : app.util.request({
                        url: "entry/wxapp/Orderarr",
                        cachetime: "30",
                        data: {
                            price: t,
                            openid: l
                        },
                        success: function(o) {
                            console.log(o), wx.requestPayment({
                                timeStamp: o.data.timeStamp,
                                nonceStr: o.data.nonceStr,
                                package: o.data.package,
                                signType: "MD5",
                                paySign: o.data.paySign,
                                success: function(e) {
                                    wx.showToast({
                                        title: "支付成功",
                                        icon: "success",
                                        duration: 2e3
                                    }), app.util.request({
                                        url: "entry/wxapp/bargainorder",
                                        cachetime: "10",
                                        data: {
                                            address: a,
                                            consignee: n,
                                            gid: s,
                                            phone: c,
                                            openid: l,
                                            price: t,
                                            note: u,
                                            mobile: i,
                                            nickName: r,
                                            store_id: d
                                        },
                                        success: function(e) {
                                            console.log(e);
                                            var t = e.data, a = o.data.package;
                                            app.util.request({
                                                url: "entry/wxapp/BuyMessage",
                                                cachetime: "0",
                                                data: {
                                                    order_id: t,
                                                    new_package: a,
                                                    openid: l
                                                },
                                                success: function(e) {
                                                    console.log("-------------模板消息发送----------------"), console.log(e);
                                                }
                                            }), app.util.request({
                                                url: "entry/wxapp/UpdateOrder",
                                                cachetime: "0",
                                                data: {
                                                    order_id: t
                                                },
                                                success: function(e) {
                                                    console.log(e);
                                                }
                                            }), wx.navigateTo({
                                                url: "../myOrder-list/index?type=1"
                                            });
                                        },
                                        fail: function(e) {}
                                    });
                                }
                            });
                        }
                    });
                }
            });
        } else wx.showToast({
            title: "请选择收货人或收货地址！",
            icon: "none"
        }); else if (1 == this.data.currentSelect) if (i) {
            l = wx.getStorageSync("openid");
            app.util.request({
                url: "entry/wxapp/buyed",
                cachetime: "30",
                data: {
                    id: s,
                    openid: l
                },
                success: function(e) {
                    console.log(e), 1 == e.data ? wx.showToast({
                        title: "该商品已经在您的订单列表了，快去付款吧",
                        icon: "none"
                    }) : app.util.request({
                        url: "entry/wxapp/Orderarr",
                        cachetime: "30",
                        data: {
                            price: t,
                            openid: l
                        },
                        success: function(o) {
                            console.log(o), app.util.request({
                                url: "entry/wxapp/bargainorder",
                                cachetime: "30",
                                data: {
                                    address: a,
                                    consignee: n,
                                    gid: s,
                                    phone: c,
                                    openid: l,
                                    price: t,
                                    note: u,
                                    mobile: i,
                                    nickName: r,
                                    store_id: d
                                },
                                success: function(e) {
                                    console.log(e);
                                    var t = e.data, a = o.data.package;
                                    wx.requestPayment({
                                        timeStamp: o.data.timeStamp,
                                        nonceStr: o.data.nonceStr,
                                        package: o.data.package,
                                        signType: "MD5",
                                        paySign: o.data.paySign,
                                        success: function(e) {
                                            wx.showToast({
                                                title: "支付成功",
                                                icon: "success",
                                                duration: 2e3
                                            }), app.util.request({
                                                url: "entry/wxapp/BuyMessage",
                                                cachetime: "0",
                                                data: {
                                                    order_id: t,
                                                    new_package: a,
                                                    openid: l
                                                },
                                                success: function(e) {
                                                    console.log("-------------模板消息发送----------------"), console.log(e);
                                                }
                                            }), app.util.request({
                                                url: "entry/wxapp/UpdateOrder",
                                                cachetime: "0",
                                                data: {
                                                    order_id: t
                                                },
                                                success: function(e) {
                                                    console.log(e);
                                                }
                                            }), wx.navigateTo({
                                                url: "../myOrder-list/index"
                                            });
                                        },
                                        fail: function(e) {}
                                    });
                                }
                            });
                        }
                    });
                }
            });
        } else wx.showToast({
            title: "请输入手机号码或联系人",
            icon: "none"
        }); else wx.showToast({
            title: "请选择收货方式！",
            icon: "none"
        });
    },
    goToAddress: function() {
        wx.chooseAddress({
            success: function(e) {
                console.log(e.userName), console.log(e.postalCode), console.log(e.provinceName), 
                console.log(e.cityName), console.log(e.countyName), console.log(e.detailInfo), console.log(e.nationalCode), 
                console.log(e.telNumber);
            }
        });
    },
    onShow: function() {
        var t = this;
        wx.getStorage({
            key: "openid",
            success: function(e) {
                app.util.request({
                    url: "entry/wxapp/DefaultAddress",
                    cachetime: "0",
                    data: {
                        uid: e.data
                    },
                    success: function(e) {
                        console.log(e), t.setData({
                            addressData: e.data.data
                        });
                    }
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});