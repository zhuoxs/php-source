var app = getApp();

Page({
    data: {
        tab: [ "详情", "目录", "评价" ],
        current: 0,
        pinglun: [],
        guanzhu: !0,
        qupinglun: !0,
        plindex: !1,
        userInfo: {},
        labelIndex: null,
        kc_id: "",
        goumai: !1,
        vurl: "",
        toastHidden3: !0,
        toastHidden4: !1
    },
    tab: function(t) {
        var i = this;
        console.log(t);
        var e = t.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/Videoxianglist",
            data: {
                id: e
            },
            success: function(t) {
                console.log(t);
                for (var e = t.data.data, a = 0; a < e.length; a++) {
                    var o = e[a].demo, n = parseInt(o / 60), s = parseInt(o % 60);
                    e[a].demo = n + "分" + s + "秒";
                }
                i.setData({
                    muvd: e
                });
            },
            fail: function(t) {
                console.log(t);
            }
        }), i.setData({
            current: t.currentTarget.dataset.index
        });
    },
    likeClick: function(t) {
        var e = this, a = t.currentTarget.dataset.id;
        console.log(t.currentTarget.dataset.id);
        var o = wx.getStorageSync("openid");
        console.log(o), app.util.request({
            url: "entry/wxapp/CheckCollect",
            headers: {
                "Content-Type": "application/json"
            },
            cachetime: "0",
            data: {
                openid: o,
                goods_id: a
            },
            success: function(t) {
                2 == t.data ? (console.log("已取消"), app.util.request({
                    url: "entry/wxapp/SaveCollect",
                    cachetime: "0",
                    data: {
                        openid: o,
                        goods_id: a,
                        cerated_type: 1
                    },
                    dataType: "json",
                    success: function(t) {
                        wx.showToast({
                            title: "取消成功",
                            icon: "success",
                            duration: 1500
                        }), e.setData({
                            toastHidden4: !0,
                            toastHidden3: !1
                        });
                    }
                })) : 1 == t.data && (console.log("关注成功"), app.util.request({
                    url: "entry/wxapp/SaveCollect",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    cachetime: "0",
                    data: {
                        openid: o,
                        goods_id: a,
                        cerated_type: 1
                    },
                    dataType: "json",
                    success: function(t) {
                        console.log(t), wx.showToast({
                            title: "关注成功",
                            icon: "success",
                            duration: 1500
                        }), e.setData({
                            collect_url: !e.data.collect_url,
                            c_text: !e.data.c_text,
                            toastHidden3: !0,
                            toastHidden4: !1
                        });
                    }
                }));
            }
        });
    },
    muurl: function(t) {
        var e = t.currentTarget.dataset.url;
        console.log(e), this.setData({
            vurl: e
        });
    },
    xuexi: function() {
        this.setData({
            current: 1
        });
    },
    qupinglun: function(t) {
        console.log(t);
        var s = this, e = t.currentTarget.dataset.id, a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Pingl",
            data: {
                id: e,
                openid: a
            },
            success: function(t) {
                console.log(t);
                var e = wx.getStorageSync("openid"), a = t.data.data.m_openid, o = t.data.data.s_openid, n = t.data.data.m_comment;
                if (console.log(a), null == a) return wx.showToast({
                    title: "您还未购买",
                    icon: "success",
                    duration: 800
                }), !1;
                o == e && "" !== n ? wx.showToast({
                    title: "您已发表过评论",
                    icon: "success",
                    duration: 1500
                }) : s.setData({
                    qupinglun: !1,
                    plindex: !0
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    mqupinglun: function(t) {
        console.log(t);
        var o = this, e = t.currentTarget.dataset.id;
        console.log(e);
        var n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Pingl",
            data: {
                id: e,
                openid: n
            },
            success: function(t) {
                console.log(t);
                var e = t.data.data.m_openid, a = (t.data.data.s_openid, t.data.data.m_comment);
                if (console.log(e, a), null == e) return wx.showToast({
                    title: "您未学习该课程",
                    icon: "success",
                    duration: 800
                }), !1;
                e == n && "" !== a ? wx.showToast({
                    title: "您已发表过评论",
                    icon: "success",
                    duration: 1500
                }) : o.setData({
                    qupinglun: !1,
                    plindex: !0
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    close: function() {
        this.setData({
            plindex: !1
        });
    },
    formSubmit: function(s) {
        console.log(s);
        var i = this, t = s.detail.value, c = i.data.labelIndex, l = t.kc_id, u = t.m_comment, d = t.room_money, r = wx.getStorageSync("openid");
        console.log(d, u, l, c), null == c ? wx.showToast({
            title: "请您评个花花吧^^",
            icon: "success",
            duration: 1500
        }) : wx.showModal({
            title: "提示",
            content: " 确认提交么？ ",
            success: function(t) {
                if (t.confirm) {
                    var e = i.data.pinglun, a = new Date(), o = a.getUTCFullYear() + "-" + (a.getMonth() + 1 < 10 ? "0" + (a.getMonth() + 1) : a.getMonth() + 1) + "-" + (a.getDate() < 10 ? "0" + a.getDate() : a.getDate()) + " ", n = {};
                    n.m_img = i.data.userInfo.avatarUrl, n.name = i.data.userInfo.nickName, n.m_fenshu = s.detail.value.m_fenshu, 
                    n.m_comment = s.detail.value.m_comment, n.m_time = o, e.unshift(n), console.log(n.m_img, n.name), 
                    i.setData({
                        pinglun: e,
                        plindex: !1
                    }), app.util.request({
                        url: "entry/wxapp/Roomcoment",
                        data: {
                            name: i.data.userInfo.nickName,
                            m_img: i.data.userInfo.avatarUrl,
                            m_money: d,
                            m_comment: u,
                            kc_id: l,
                            m_fenshu: c,
                            m_openid: r,
                            m_type: 1
                        },
                        success: function(t) {
                            console.log(t);
                        },
                        fail: function(t) {
                            console.log(t);
                        }
                    });
                }
            }
        });
    },
    radioChange: function(t) {
        console.log(t.detail.value), this.setData({
            labelIndex: t.detail.value
        });
    },
    onLoad: function(t) {
        console.log(t);
        var e = wx.getStorageSync("openid");
        this.getBase();
        var a = this;
        wx.login({
            success: function() {
                wx.getUserInfo({
                    success: function(t) {
                        var e = t.userInfo;
                        a.setData({
                            userInfo: e
                        });
                    }
                });
            }
        });
        var o = t.id;
        app.util.request({
            url: "entry/wxapp/Videoxiang",
            data: {
                id: o,
                openid: e
            },
            cachetime: "0",
            success: function(t) {
                console.log(t), a.setData({
                    videoxiang: t.data.data,
                    room_money: t.data.data.room_money,
                    vurl: t.data.data.room_video
                });
            },
            fail: function(t) {
                console.log(t);
            }
        }), app.util.request({
            url: "entry/wxapp/Mianfei",
            data: {
                id: o,
                openid: e
            },
            success: function(t) {
                console.log(t), a.setData({
                    baoming: t.data.data,
                    openid: e
                });
            },
            fail: function(t) {
                console.log(t);
            }
        }), app.util.request({
            url: "entry/wxapp/Allcoment",
            data: {
                id: o
            },
            cachetime: "0",
            success: function(t) {
                console.log(t), a.setData({
                    pinglun: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
        e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Kcselect",
            data: {
                s_pid: o,
                s_openid: e
            },
            cachetime: "0",
            success: function(t) {
                console.log(t), a.setData({
                    kcselect: t.data.data
                }), console.log(wx.getStorageSync("openid"));
                var e = wx.getStorageSync("openid");
                t.data.data.s_openid == e && a.setData({
                    goumai: !0
                });
            },
            fail: function(t) {
                console.log(t);
            }
        }), app.util.request({
            url: "entry/wxapp/CheckCollect",
            headers: {
                "Content-Type": "application/json"
            },
            cachetime: "0",
            data: {
                openid: e,
                goods_id: o
            },
            success: function(t) {
                2 == t.data ? (console.log("已经关注"), a.setData({
                    toastHidden3: !0,
                    toastHidden4: !1,
                    toastHidden31: !0,
                    toastHidden41: !1
                })) : 1 == t.data && (console.log("关注"), a.setData({
                    toastHidden3: !1,
                    toastHidden4: !0,
                    toastHidden31: !1,
                    toastHidden41: !0
                }));
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    zhifu: function(a) {
        var o = this, n = o.data.room_money, t = a.currentTarget.dataset.id, s = wx.getStorageSync("openid");
        n <= 0 ? (console.log("免费"), app.util.request({
            url: "entry/wxapp/Kcinsert",
            data: {
                s_ormoney: n,
                s_pid: t,
                s_openid: s,
                m_type: 1,
                s_type: 0,
                m_tj: 0
            },
            success: function(t) {
                console.log(t), o.setData({
                    openid: s
                });
            }
        }), o.setData({
            current: 1
        })) : (console.log("付费"), wx.showModal({
            title: "是否支付",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/Orderpay",
                    method: "GET",
                    data: {
                        s_openid: s,
                        s_ormoney: n
                    },
                    success: function(t) {
                        wx.requestPayment({
                            timeStamp: t.data.timeStamp,
                            nonceStr: t.data.nonceStr,
                            package: t.data.package,
                            signType: t.data.signType,
                            paySign: t.data.paySign,
                            success: function(t) {
                                var e = a.currentTarget.dataset.id;
                                app.util.request({
                                    url: "entry/wxapp/Kcinsert",
                                    data: {
                                        s_ormoney: n,
                                        s_pid: e,
                                        s_openid: s,
                                        m_type: 1,
                                        s_type: 1,
                                        m_tj: 0
                                    },
                                    success: function(t) {
                                        o.setData({
                                            goumai: !0
                                        });
                                    }
                                });
                            },
                            fail: function(t) {
                                console.log(t);
                            }
                        });
                    }
                });
            },
            fail: function(t) {
                o.setData({
                    goumai: !1
                });
            }
        }));
    },
    getBase: function() {
        var e = this;
        console.log(app), app.util.request({
            url: "entry/wxapp/Base",
            cachetime: "30",
            success: function(t) {
                console.log(t), e.setData({
                    bq_thumb: t.data.data.bq_thumb,
                    bq_name: t.data.data.bq_name
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    }
});