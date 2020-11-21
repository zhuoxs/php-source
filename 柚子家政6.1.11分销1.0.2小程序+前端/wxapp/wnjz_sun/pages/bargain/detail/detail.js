var app = getApp(), WxParse = require("../../../../we7/js/wxParse/wxParse.js");

function count_down(t, e, a) {
    parseInt(a);
    var n = t.data.bargainList, o = e - Date.parse(new Date());
    if (n[a].clock = date_format(o), o <= 0) return n[a].clock = "已经截止", void t.setData({
        bargainList: n
    });
    setTimeout(function() {
        o -= 100, count_down(t, t.data.bargainList[a].endTime, a);
    }, 100), t.setData({
        bargainList: n
    });
}

function date_format(t) {
    var e = Math.floor(t / 1e3), a = Math.floor(e / 3600 / 24), n = Math.floor((e - 60 * a * 60 * 24) / 3600), o = Math.floor(e / 3600), i = fill_zero_prefix(Math.floor((e - 3600 * o) / 60));
    return "距离结束还剩：" + a + "天" + n + "时" + i + "分" + fill_zero_prefix(e - 3600 * o - 60 * i) + "秒";
}

function fill_zero_prefix(t) {
    return t < 10 ? "0" + t : t;
}

Page({
    data: {
        active: "",
        order: [],
        kanjia: [],
        is_modal_Hidden: !0,
        hidden: !0,
        url: [],
        showModalStatus: !1,
        imgsrc: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152178548159.png",
        title: "日式精细擦窗",
        price: "100",
        minPrice: "68",
        surplus: "100",
        startTime: "2017-12-12 00:00:00",
        endTime: "2018-01-12 00:00:00",
        imgArr: [ "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152084048151.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152084048161.png" ],
        bargainList: [ {
            endTime: "1523519898765",
            clock: ""
        } ],
        isIpx: app.globalData.isIpx
    },
    onLoad: function(t) {
        (o = this).wxauthSetting();
        var e = o.data.bargainList;
        wx.setStorageSync("kanjiaid", t.id), wx.getUserInfo({
            success: function(t) {
                o.setData({
                    thumb: t.userInfo.avatarUrl,
                    nickname: t.userInfo.nickName
                });
            }
        }), e.endTime = [ {
            antime: "1521863868099",
            astime: "2018-03-23 00:00:00",
            content: "321",
            createtime: "1521790326",
            hits: "0",
            id: "45",
            num: "2",
            sort: "3",
            status: "1",
            titl: "时间"
        } ].antime, o.setData({
            bargainList: e,
            id: t.id
        });
        var a = t.id, n = t.build_id;
        n && a && app.util.request({
            url: "entry/wxapp/KjActiveing",
            cachetime: "0",
            data: {
                id: a,
                build_id: n
            },
            success: function(t) {
                console.log(t.data), 1 == t.data ? o.setData({
                    active: !0
                }) : 2 == t.data ? wx.showModal({
                    title: "提示",
                    content: "活动未开始",
                    showCancel: !1
                }) : wx.setStorageSync("build_id", n);
            }
        }), count_down(this, this.data.bargainList[0].endTime, 0);
        var o = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        a = o.data.id, wx.getStorageSync("openid");
    },
    onReady: function() {},
    onShow: function() {
        var a = this, t = a.data.id, e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/kanzhu",
            data: {
                id: t,
                openid: e
            },
            success: function(t) {
                console.log(t), a.setData({
                    kanzhu: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/kanjiade",
            method: "GET",
            data: {
                id: a.data.id
            },
            success: function(t) {
                console.log(t), a.setData({
                    order: t.data
                }), a.getUrl(), WxParse.wxParse("article", "html", t.data.content, a, 5);
            }
        }), console.log(a.data.id);
        e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/iskanjia",
            data: {
                id: a.data.id,
                openid: e
            },
            success: function(t) {
                console.log(t);
                var e = t.data.status;
                a.setData({
                    join: e
                });
            }
        }), app.util.request({
            url: "entry/wxapp/HelpFriends",
            data: {
                id: a.data.id,
                openid: e
            },
            success: function(t) {
                console.log(t.data), a.setData({
                    friend: t.data
                });
            }
        });
    },
    getUrl: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    order: function(t) {
        console.log(t);
        var e = t.target.dataset.id, a = t.target.dataset.price, n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/isBuyKjgoods",
            cachetime: "0",
            data: {
                id: e,
                openid: n
            },
            success: function(t) {
                1 == t.data ? wx.showToast({
                    title: "您已购买过该商品！",
                    icon: "none",
                    duration: 2e3
                }) : 3 == t.data ? wx.showToast({
                    title: "活动已截止！",
                    icon: "none",
                    duration: 2e3
                }) : wx.navigateTo({
                    url: "../cforder/cforder?id=" + e + "&price=" + a
                });
            }
        });
    },
    bargain: function(t) {},
    gokanjiadetails: function(t) {
        var e = wx.getStorageSync("openid"), a = wx.getStorageSync("kanjiaid");
        wx.navigateTo({
            url: "/wnjz_sun/pages/bargain/help/help?id=" + a + "&openid=" + e
        });
    },
    onShareAppMessage: function(t) {
        var e = wx.getStorageSync("openid"), a = wx.getStorageSync("kanjiaid"), n = wx.getStorageSync("system");
        return console.log(n), "button" === t.from && console.log(t.target), {
            title: n.share_title,
            path: "wnjz_sun/pages/bargain/help/help?id=" + a + "&openid=" + e,
            success: function(t) {
                console.log("转发成功");
            },
            fail: function(t) {
                console.log("转发失败");
            }
        };
    },
    powerDrawer: function(t) {
        var e = this, a = t.currentTarget.dataset.statu;
        e.util(a);
        var n = t.currentTarget.dataset.join;
        if (e.setData({
            join: n
        }), "open" == a) {
            var o = t.currentTarget.dataset.id, i = wx.getStorageSync("openid");
            console.log(i), console.log(i), app.util.request({
                url: "entry/wxapp/Kanjiaorder",
                data: {
                    id: o,
                    openid: i
                },
                success: function(t) {
                    console.log(t), e.setData({
                        kanjia: t.data
                    }), e.onShow();
                }
            });
        }
    },
    util: function(t) {
        var e = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = e).opacity(0).height(0).step(), this.setData({
            animationData: e.export()
        }), setTimeout(function() {
            e.opacity(1).height("488rpx").step(), this.setData({
                animationData: e
            }), "close" == t && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == t && this.setData({
            showModalStatus: !0
        });
    },
    help: function(t) {
        wx.updateShareMenu({
            withShareTicket: !0,
            success: function() {}
        });
    },
    toIndex: function(t) {
        wx.reLaunch({
            url: "../../index/index"
        });
    },
    onPosterTab: function() {
        var t = wx.getStorageSync("users"), e = wx.getStorageSync("build_id"), a = wx.getStorageSync("system"), n = this.data.order, o = [];
        o.goodspicbg = a.poster_img, o.bname = n.gname, o.url = this.data.url, o.logo = n.pic, 
        o.kjprice = n.shopprice, console.log(o), o.scene = "d_user_id=" + t.id + "&id=" + n.id + "&build_id=" + e, 
        app.creatPoster("wnjz_sun/pages/bargain/detail/detail", 430, o, 2, "shareImg");
    },
    hidden: function(t) {
        this.setData({
            hidden: !0
        });
    },
    save: function() {
        var e = this;
        wx.saveImageToPhotosAlbum({
            filePath: e.data.prurl,
            success: function(t) {
                wx.showModal({
                    content: "图片已保存到相册，赶紧晒一下吧~",
                    showCancel: !1,
                    confirmText: "好哒",
                    confirmColor: "#ef8200",
                    success: function(t) {
                        t.confirm && (console.log("用户点击确定"), e.setData({
                            hidden: !0
                        }));
                    }
                });
            },
            fail: function(t) {
                console.log("失败"), wx.getSetting({
                    success: function(t) {
                        t.authSetting["scope.writePhotosAlbum"] || (console.log("进入信息授权开关页面"), wx.openSetting({
                            success: function(t) {
                                console.log("openSetting success", t.authSetting);
                            }
                        }));
                    }
                });
            }
        });
    },
    wxauthSetting: function(t) {
        var i = this;
        wx.getStorageSync("openid") ? wx.getSetting({
            success: function(t) {
                console.log("进入wx.getSetting 1"), console.log(t), t.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权 1"), 
                wx.getUserInfo({
                    success: function(t) {
                        i.setData({
                            is_modal_Hidden: !0,
                            thumb: t.userInfo.avatarUrl,
                            nickname: t.userInfo.nickName
                        });
                    }
                })) : (console.log("scope.userInfo没有授权 1"), wx.showModal({
                    title: "获取信息失败",
                    content: "请允许授权以便为您提供给服务",
                    success: function(t) {
                        i.setData({
                            is_modal_Hidden: !1
                        });
                    }
                }));
            },
            fail: function(t) {
                console.log("获取权限失败 1"), i.setData({
                    is_modal_Hidden: !1
                });
            }
        }) : wx.login({
            success: function(t) {
                console.log("进入wx-login");
                var e = t.code;
                wx.setStorageSync("code", e), wx.getSetting({
                    success: function(t) {
                        console.log("进入wx.getSetting"), console.log(t), t.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权"), 
                        wx.getUserInfo({
                            success: function(t) {
                                i.setData({
                                    is_modal_Hidden: !0,
                                    thumb: t.userInfo.avatarUrl,
                                    nickname: t.userInfo.nickName
                                }), console.log("进入wx-getUserInfo"), console.log(t.userInfo), wx.setStorageSync("user_info", t.userInfo);
                                var a = t.userInfo.nickName, n = t.userInfo.avatarUrl, o = t.userInfo.gender;
                                app.util.request({
                                    url: "entry/wxapp/openid",
                                    cachetime: "0",
                                    data: {
                                        code: e
                                    },
                                    success: function(t) {
                                        console.log("进入获取openid"), console.log(t.data), wx.setStorageSync("key", t.data.session_key), 
                                        wx.setStorageSync("openid", t.data.openid);
                                        var e = t.data.openid;
                                        wx.setStorage({
                                            key: "openid",
                                            data: e
                                        }), app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: e,
                                                img: n,
                                                name: a,
                                                gender: o
                                            },
                                            success: function(t) {
                                                console.log("进入地址login"), console.log(t.data), wx.setStorageSync("users", t.data), 
                                                wx.setStorageSync("uniacid", t.data.uniacid), i.setData({
                                                    usersinfo: t.data
                                                });
                                            }
                                        });
                                    }
                                });
                            },
                            fail: function(t) {
                                console.log("进入 wx-getUserInfo 失败"), wx.showModal({
                                    title: "获取信息失败",
                                    content: "请允许授权以便为您提供给服务!",
                                    success: function(t) {
                                        i.setData({
                                            is_modal_Hidden: !1
                                        });
                                    }
                                });
                            }
                        })) : (console.log("scope.userInfo没有授权"), i.setData({
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
                        i.setData({
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
    },
    goHome: function() {
        wx.reLaunch({
            url: "/wnjz_sun/pages/index/index"
        });
    }
});