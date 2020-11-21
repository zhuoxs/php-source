var app = getApp();

Page({
    data: {
        sweepBox: !0,
        sweepBoxs: !0,
        array: [ {
            dura: "1周",
            mon: "0.1"
        }, {
            dura: "2周",
            mon: "0.2"
        }, {
            dura: "3周",
            mon: "0.3"
        } ]
    },
    onLoad: function(a) {
        console.log(a);
        var t = this, e = wx.getStorageSync("url");
        console.log(e), t.setData({
            url: e
        });
        var o = wx.getStorageSync("system");
        t.setData({
            mineBj: o.personal_img,
            auth: a.auth
        }), console.log(t.data.array.length);
        for (var n = [], r = 0; r < t.data.array.length; r++) {
            var s = t.data.array[r].dura + "/" + t.data.array[r].mon;
            n.push(s);
        }
        app.util.request({
            url: "entry/wxapp/BranchMessage",
            cachetime: "0",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                console.log(a), t.setData({
                    branch_info: a.data.data
                });
            }
        }), t.setData({
            dealData: n
        }), t.diyWinColor();
    },
    bindPickerChange: function(a) {
        console.log("picker发送选择改变，携带值为", a.detail.value), this.setData({
            index: a.detail.value
        });
    },
    reserveManas: function(a) {
        console.log(a), wx.navigateTo({
            url: "../reverseMana/reverseMana"
        });
    },
    deterBtn: function(a) {
        var e = this;
        wx.scanCode({
            onlyFromCamera: !0,
            scanType: "qrCode",
            success: function(a) {
                console.log(a);
                var t = a.result;
                console.log(t), app.util.request({
                    url: "entry/wxapp/WriteOffOrder",
                    cachetime: "0",
                    data: {
                        code: t,
                        openid: wx.getStorageSync("openid")
                    },
                    success: function(a) {
                        console.log(a), 0 == a.data.message && e.setData({
                            sweepBox: !1,
                            orderinfo: a.data.data,
                            ordertype: a.data.message
                        }), 1 == a.data.message && e.setData({
                            sweepBoxs: !1,
                            stampinfo: a.data.data,
                            ordertype: a.data.message
                        });
                    }
                });
            }
        });
    },
    WriteOff: function(a) {
        console.log(a);
        var t = this, e = a.currentTarget.dataset.order_id, o = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/WriteOffSure",
            cachetime: "0",
            data: {
                order_id: e,
                openid: o,
                code_type: t.data.ordertype
            },
            success: function(a) {
                console.log(a), wx.showToast({
                    title: "核销成功！"
                }), setTimeout(function(a) {
                    t.onShow();
                }, 2e3);
            }
        }), t.setData({
            sweepBox: !0,
            sweepBoxs: !0
        });
    },
    withDrawalTap: function(a) {
        var t = wx.getStorageSync("system");
        1 == t.tx_open && (1 == this.data.auth ? wx.navigateTo({
            url: "../withDrawal/withDrawal"
        }) : wx.showModal({
            title: "提示",
            content: "您无权提现",
            showCancel: !1
        })), 2 == t.tx_open && wx.showToast({
            title: "暂不支持提现",
            icon: "none",
            duration: 2e3
        });
    },
    addMemberTap: function(a) {
        1 == this.data.auth ? wx.navigateTo({
            url: "../addVerMember/addVerMember"
        }) : wx.showModal({
            title: "提示",
            content: "您不是总管理员，无权添加",
            showCancel: !1
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = this, a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/PutForward",
            cachetime: "0",
            data: {
                openid: a
            },
            success: function(a) {
                console.log(a), t.setData({
                    canPutMoney: a.data.data
                });
            }
        }), t.getUserInfo();
    },
    getUserInfo: function() {
        var t = this;
        wx.login({
            success: function() {
                wx.getUserInfo({
                    success: function(a) {
                        console.log(a), t.setData({
                            userInfo: a.userInfo
                        });
                    }
                });
            }
        });
    },
    reserveMana: function(a) {
        wx.navigateTo({
            url: "../reverseMana/reverseMana"
        });
    },
    orderMana: function(a) {
        wx.navigateTo({
            url: "../orderMana/orderMana"
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    diyWinColor: function(a) {
        var t = wx.getStorageSync("system");
        wx.setNavigationBarColor({
            frontColor: t.color,
            backgroundColor: t.fontcolor,
            animation: {
                duration: 400,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: "管理后台"
        });
    },
    bindRzTap: function(a) {
        var t = a.currentTarget.dataset.statu;
        this.util(t), console.log(a);
    },
    close: function(a) {
        var t = a.currentTarget.dataset.statu;
        this.util(t);
    },
    util: function(a) {
        var t = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = t).opacity(0).height(0).step(), this.setData({
            animationData: t.export()
        }), setTimeout(function() {
            t.opacity(1).height("300rpx").step(), this.setData({
                animationData: t
            }), "close" == a && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == a && this.setData({
            showModalStatus: !0
        });
    }
});