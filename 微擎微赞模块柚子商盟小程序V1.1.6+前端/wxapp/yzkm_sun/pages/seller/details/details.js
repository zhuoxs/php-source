var app = getApp();

Page({
    data: {
        currentIndex: 0,
        showModalStatus: !1,
        statusType: [ "商家详情", "用户评论" ],
        num: 5,
        light: "",
        kong: "",
        starMap: [ "非常差", "差", "一般", "好", "非常好" ],
        star: 0,
        noS: "",
        is_modal_Hidden: !0,
        banners: [ "http://oydmq0ond.bkt.clouddn.com/shangpinxiangqing.png" ],
        serverList: [ "刷卡支付", "免费WIFI", "免费停车", "禁止吸烟", "提供包间" ],
        nodes: [ {
            name: "p",
            attrs: {
                style: "color:#666;font-size:30rpx;"
            }
        }, {
            name: "img",
            src: "http://oydnzfrbv.bkt.clouddn.com/shangjiaxiangqing.png",
            attrs: {
                style: "width:100%;"
            }
        } ],
        detailsList: [ {
            text: "这里是商家测试文字可删这里是商家测试文字可删这里是商家测试文字可删",
            pic: "http://oydnzfrbv.bkt.clouddn.com/shangjiaxiangqing.png"
        }, {
            text: "这里是商家测试文字可删这里是商家测试文字可删这里是商家测试文字可删",
            pic: "http://oydnzfrbv.bkt.clouddn.com/shangjiaxiangqing.png"
        }, {
            text: "这里是商家测试文字可删这里是商家测试文字可删这里是商家测试文字可删",
            pic: "http://oydnzfrbv.bkt.clouddn.com/shangjiaxiangqing.png"
        } ],
        comments: [ {
            headerImg: "http://oydnzfrbv.bkt.clouddn.com/header.png",
            nick: "XXX",
            dateTime: "2018-01-23 14:00",
            contents: "这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧"
        }, {
            headerImg: "http://oydnzfrbv.bkt.clouddn.com/header.png",
            nick: "Up",
            dateTime: "2020-08-23 09:00",
            contents: "这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧"
        }, {
            headerImg: "http://oydnzfrbv.bkt.clouddn.com/header.png",
            nick: "David",
            dateTime: "2016-02-23 23:00",
            contents: "这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧这里是文字测试内容可以是图片也可以是文字吧"
        } ]
    },
    onLoad: function(n) {
        var a = this;
        a.wxauthSetting(), wx.setStorageSync("iid", n.id), a.diyWinColor(), console.log("获取当前商家Id"), 
        console.log(n.id), app.util.request({
            url: "entry/wxapp/Url",
            success: function(t) {
                console.log("页面加载请求"), console.log(t), wx.getStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        }), wx.getLocation({
            type: "gcj02",
            success: function(t) {
                var o = t.latitude, e = t.longitude;
                app.util.request({
                    url: "entry/wxapp/Store_xqy",
                    data: {
                        latitude: o,
                        longitude: e,
                        currentIndex: 0,
                        sj_id: n.id
                    },
                    success: function(t) {
                        console.log("商家详情页数据请求"), console.log(t), a.setData({
                            list_xqy: t.data[0]
                        });
                    }
                });
            }
        }), wx.setNavigationBarTitle({
            title: n.store_name
        }), a.setData({
            store_name: n.store_name,
            store_id: n.id
        }), app.util.request({
            url: "entry/wxapp/Store_xqyGoods",
            data: {
                sj_id: n.id
            },
            success: function(t) {
                console.log("商家详情页商品数据请求"), console.log(t), a.setData({
                    list_xqyGoods: t.data
                });
            }
        });
        var t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/User_id",
            data: {
                openid: t
            },
            success: function(t) {
                console.log("查看用户id"), console.log(t), a.setData({
                    comment_xqy: t.data
                }), wx.setStorageSync("user_id", t.data.id);
            }
        }), setTimeout(function() {
            var t = wx.getStorageSync("user_id");
            console.log(t), app.util.request({
                url: "entry/wxapp/Status_sc",
                data: {
                    user_id: t,
                    store_id: n.id
                },
                success: function(t) {
                    console.log("判断初始收藏状态"), console.log(t), 0 == t.data.state ? a.setData({
                        noS: 0
                    }) : a.setData({
                        noS: 1
                    });
                }
            });
        }, 500);
    },
    toZhu: function(t) {
        wx.navigateTo({
            url: "../../sjrz-Page/sjrz-Page"
        });
    },
    statusTap: function(t) {
        t.currentTarget.dataset.index;
        this.setData({
            currentIndex: t.currentTarget.dataset.index
        }), this.onShow();
    },
    toComments: function(t) {
        var o = t.currentTarget.dataset.statu;
        this.util(o);
    },
    myChooseStar: function(t) {
        console.log("用户评价星级"), console.log(t);
        var o = parseInt(t.target.dataset.star) || 0;
        this.setData({
            star: o
        });
    },
    in_content: function(t) {
        console.log("评论内容"), console.log(t);
        var o = t.detail.value;
        this.setData({
            vals: o
        });
    },
    cancleBtn: function(t) {
        var o = t.currentTarget.dataset.statu;
        t.target.dataset.star;
        this.util(o);
    },
    close: function(t) {
        var o = t.currentTarget.dataset.statu, e = t.target.dataset.star;
        this.util(o), this.deterTap(e);
    },
    util: function(t) {
        "open" == t && this.setData({
            showModalStatus: !0
        });
        var o = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = o).opacity(0).height(0).step(), this.setData({
            animationData: o.export()
        }), setTimeout(function() {
            o.opacity(1).height("630rpx").step(), this.setData({
                animationData: o
            }), "close" == t && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200);
    },
    deterTap: function(t) {
        console.log(t);
        var o = this;
        if (console.log(o.data.star), 0 < o.data.star) {
            wx.showToast({
                title: "评价成功",
                icon: "success",
                duration: 2e3
            }), o.setData({
                hideStarBox: !0
            });
            var e = t.currentTarget.dataset.statu, n = o.data.vals, a = o.data.star, s = wx.getStorageSync("user_id");
            console.log("sadfsadsaddasdsadsadasdas"), console.log(s), console.log(a), console.log(n);
            var i = wx.getStorageSync("iid"), c = wx.getStorageSync("user_id");
            app.util.request({
                url: "entry/wxapp/Comment_AddSjpl",
                data: {
                    vals: n,
                    star: a,
                    user_id: c,
                    sj_id: i
                },
                success: function(t) {
                    console.log("查看是否评论成功"), console.log(t), o.setData({
                        comment_xqy: t.data
                    });
                }
            }), this.util(e);
        } else wx.showToast({
            title: "请评价星级",
            icon: "none",
            duration: 3e3
        });
    },
    makePhone: function(t) {
        console.log("电话的参数"), console.log(t);
        var o = t.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/Store_tel",
            data: {
                sj_id: o
            },
            success: function(t) {
                console.log("商电话请求"), console.log(t), wx.makePhoneCall({
                    phoneNumber: t.data[0].phone,
                    success: function(t) {
                        console.log("-----拨打电话成功-----");
                    },
                    fail: function(t) {
                        console.log("-----拨打电话失败-----");
                    }
                });
            }
        });
    },
    goGoodsDetails: function(t) {
        console.log("点击商品跳转商品详情页面"), console.log(t), wx.redirectTo({
            url: "../../goodsDetails/goodsDetails?id=" + t.currentTarget.dataset.id
        });
    },
    gohome: function() {
        wx.reLaunch({
            url: "../../index/index"
        });
    },
    collectTap: function(t) {
        var o = this, e = wx.getStorageSync("iid"), n = wx.getStorageSync("user_id");
        console.log(e), console.log(n), 1 == o.data.noS ? app.util.request({
            url: "entry/wxapp/Collect_sj",
            data: {
                noS: "0",
                id: n,
                iid: e
            },
            success: function(t) {
                console.log("收藏数据"), console.log(t), o.setData({
                    comment_xqy: t.data,
                    noS: 0
                });
            }
        }) : app.util.request({
            url: "entry/wxapp/Collect_sj",
            data: {
                noS: "1",
                id: n,
                iid: e
            },
            success: function(t) {
                console.log("收藏数据"), console.log(t), o.setData({
                    comment_xqy: t.data,
                    noS: "1"
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var o = this, t = wx.getStorageSync("iid");
        console.log("商家ID"), console.log(t), app.util.request({
            url: "entry/wxapp/Url",
            success: function(t) {
                wx.getStorageSync("url", t.data), o.setData({
                    url: t.data
                });
            }
        });
        var e = o.data.currentIndex;
        console.log("详情页选项卡下标获取"), console.log(e), 0 == e ? app.util.request({
            url: "entry/wxapp/Store_sjxqsj",
            data: {
                currentIndex: e,
                sj_id: t
            },
            success: function(t) {
                console.log("商家详情数据"), console.log(t), o.setData({
                    list_xqsj: t.data
                });
            }
        }) : 1 == e && app.util.request({
            url: "entry/wxapp/Store_xqy_comment",
            data: {
                currentIndex: e,
                sj_id: t
            },
            success: function(t) {
                console.log("商家评论数据"), console.log(t), o.setData({
                    list_comment: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(t) {
        return console.log(t), "button" === t.from && console.log(t.target), {
            title: this.data.comment_xqy.name + "邀你来到[" + this.data.store_name + "]",
            path: "/yzkm_sun/pages/seller/details/details?id=" + this.data.store_id + "&&store_name=" + this.data.store_name,
            success: function(t) {},
            fail: function(t) {}
        };
    },
    diyWinColor: function(t) {
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: "#ffb62b"
        });
    },
    wxauthSetting: function(t) {
        var s = this;
        console.log(111), wx.getStorageSync("openid") ? wx.getSetting({
            success: function(t) {
                console.log("进入wx.getSetting 1"), console.log(t), t.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权 1"), 
                wx.getUserInfo({
                    success: function(t) {
                        s.setData({
                            is_modal_Hidden: !0,
                            thumb: t.userInfo.avatarUrl,
                            nickname: t.userInfo.nickName
                        });
                    }
                })) : (console.log("scope.userInfo没有授权 1"), s.setData({
                    is_modal_Hidden: !1
                }));
            },
            fail: function(t) {
                console.log("获取权限失败 1"), s.setData({
                    is_modal_Hidden: !1
                });
            }
        }) : wx.login({
            success: function(t) {
                console.log("进入wx-login");
                var o = t.code;
                wx.setStorageSync("code", o), wx.getSetting({
                    success: function(t) {
                        console.log("进入wx.getSetting"), console.log(t), t.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权"), 
                        wx.getUserInfo({
                            success: function(t) {
                                console.log(t), s.setData({
                                    is_modal_Hidden: !0,
                                    thumb: t.userInfo.avatarUrl,
                                    nickname: t.userInfo.nickName
                                }), console.log("进入wx-getUserInfo"), console.log(t.userInfo), wx.setStorageSync("user_info", t.userInfo);
                                var e = t.userInfo.nickName, n = t.userInfo.avatarUrl, a = t.userInfo.gender;
                                app.util.request({
                                    url: "entry/wxapp/openid",
                                    cachetime: "0",
                                    data: {
                                        code: o
                                    },
                                    success: function(t) {
                                        console.log("进入获取openid"), console.log(t.data), wx.setStorageSync("key", t.data.session_key), 
                                        wx.setStorageSync("openid", t.data.openid);
                                        var o = t.data.openid;
                                        app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: o,
                                                img: n,
                                                name: e,
                                                gender: a
                                            },
                                            success: function(t) {
                                                console.log("进入地址login"), console.log(t.data), wx.setStorageSync("users", t.data), 
                                                wx.setStorageSync("uniacid", t.data.uniacid), s.setData({
                                                    usersinfo: t.data
                                                });
                                            }
                                        });
                                    }
                                });
                            },
                            fail: function(t) {
                                console.log("进入 wx-getUserInfo 失败"), s.setData({
                                    is_modal_Hidden: !1
                                });
                            }
                        })) : (console.log("scope.userInfo没有授权"), s.setData({
                            is_modal_Hidden: !1
                        }));
                    }
                });
            },
            fail: function() {
                wx.showModal({
                    title: "获取信息失败",
                    content: "请允许授权以便为您提供给服务!!!",
                    success: function(t) {
                        s.setData({
                            is_modal_Hidden: !1
                        });
                    }
                });
            }
        });
    },
    updateUserInfo: function(t) {
        console.log("授权操作更新");
        this.wxauthSetting();
    }
});