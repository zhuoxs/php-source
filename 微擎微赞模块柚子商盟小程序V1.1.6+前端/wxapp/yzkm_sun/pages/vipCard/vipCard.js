var app = getApp();

Page({
    data: {
        template_member: "",
        jh_num: "",
        hyk_id: "",
        hyk_price: "",
        hyk_day: ""
    },
    onLoad: function(e) {
        var t = this, a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Url",
            success: function(e) {
                console.log("页面加载请求"), console.log(e), wx.setStorageSync("url", e.data), t.setData({
                    url: e.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Card_class",
            data: {
                openid: a
            },
            success: function(e) {
                console.log("会员卡分类"), t.setData({
                    class_hyk: e.data.class,
                    imags: e.data.res.img,
                    text: e.data.res.desc,
                    endTime: "" == e.data.state ? "当前非会员状态" : e.data.state.dq_time
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Mob_message",
            success: function(e) {
                console.log("模板消息数据"), t.setData({
                    template_member: e.data.template_member
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Member_dqsj",
            data: {
                openid: a
            },
            success: function(e) {
                console.log("会员卡有效期");
            }
        }), t.diyWinColor();
    },
    buyCardType: function(e) {
        console.log(e);
        this.setData({
            currentIdx: e.currentTarget.dataset.index,
            hyk_id: e.currentTarget.dataset.id,
            hyk_price: e.currentTarget.dataset.price,
            hyk_day: e.currentTarget.dataset.day
        });
    },
    tobuy: function(a) {
        console.log(a);
        var o = this, n = wx.getStorageSync("openid");
        console.log(n), console.log(o.data.sta_hyk), app.util.request({
            url: "entry/wxapp/User_id",
            data: {
                openid: n
            },
            success: function(e) {
                console.log("查看用户id"), console.log(e), o.setData({
                    user_id: e.data.id
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Member_dqsj",
            data: {
                openid: n
            },
            success: function(e) {
                console.log("返回的用户会员卡状态"), "" != o.data.hyk_id ? setTimeout(function() {
                    var e = o.data.hyk_price, t = o.data.user_id;
                    app.util.request({
                        url: "entry/wxapp/Orderarr",
                        cachetime: "30",
                        data: {
                            openid: n,
                            price: e
                        },
                        success: function(e) {
                            console.log(e);
                            e.data.prepay_id;
                            wx.requestPayment({
                                timeStamp: e.data.timeStamp,
                                nonceStr: e.data.nonceStr,
                                package: e.data.package,
                                signType: "MD5",
                                paySign: e.data.paySign,
                                success: function(e) {
                                    console.log("支付数据"), console.log(e), wx.showToast({
                                        title: "支付成功",
                                        icon: "success",
                                        duration: 2e3
                                    }), app.util.request({
                                        url: "entry/wxapp/Member_card",
                                        data: {
                                            openid: n,
                                            user_id: t,
                                            hyk_id: o.data.hyk_id,
                                            hyk_price: o.data.hyk_price,
                                            hyk_day: o.data.hyk_day
                                        },
                                        success: function(e) {
                                            console.log("修改成功"), console.log(e), app.util.request({
                                                url: "entry/wxapp/AccessToken",
                                                cachetime: "0",
                                                success: function(e) {
                                                    console.log("模板消息的 formid 和 模板编号"), console.log(e.data), console.log(a.detail.formId), 
                                                    console.log(o.data.template_member), app.util.request({
                                                        url: "entry/wxapp/Send_hyk",
                                                        cachetime: "0",
                                                        data: {
                                                            access_token: e.data.access_token,
                                                            template_id: o.data.template_member,
                                                            page: "./index/index",
                                                            openid: n,
                                                            form_id: a.detail.formId,
                                                            money: o.data.hyk_price
                                                        },
                                                        success: function(e) {
                                                            console.log(e), wx.navigateTo({
                                                                url: "../vipCard/vipCard"
                                                            });
                                                        }
                                                    });
                                                }
                                            });
                                        }
                                    });
                                }
                            });
                        }
                    });
                }, 500) : wx.showToast({
                    title: "购买的会员天数不能为空",
                    icon: "none"
                });
            }
        });
    },
    inputActCode: function(e) {
        this.setData({
            jh_num: e.detail.value
        });
    },
    deterActTap: function(e) {
        var a = this;
        setTimeout(function() {
            var t = wx.getStorageSync("openid");
            console.log(t), app.util.request({
                url: "entry/wxapp/User_id",
                data: {
                    openid: t
                },
                success: function(e) {
                    console.log("查看用户id"), console.log(e), console.log(t), console.log(a.data.jh_num), 
                    app.util.request({
                        url: "entry/wxapp/Activation",
                        data: {
                            num_code: a.data.jh_num,
                            user_id: e.data.id,
                            openid: t
                        },
                        success: function(e) {
                            console.log("激活码判定");
                        }
                    });
                }
            });
        }, 1e3), setTimeout(function() {
            wx.navigateTo({
                url: "../vipCard/vipCard"
            });
        }, 3e3);
    },
    selVipType: function(e) {
        this.setData({
            currentIdx: e.currentTarget.dataset.index
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    diyWinColor: function(e) {
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: "#ffb62b"
        }), wx.setNavigationBarTitle({
            title: "会员卡"
        });
    }
});