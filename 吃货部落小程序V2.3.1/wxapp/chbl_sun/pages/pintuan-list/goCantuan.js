var app = getApp();

Page({
    data: {
        hideShopPopup: !0,
        oldH: [ "http://oydnzfrbv.bkt.clouddn.com/tx.png", "http://oydnzfrbv.bkt.clouddn.com/tx.png" ],
        newH: "",
        details: "",
        is_modal_Hidden: !0,
        showModalStatus: !1
    },
    onLoad: function(e) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.getSetting({
            success: function(t) {
                console.log(t.authSetting["scope.userInfo"]), t.authSetting["scope.userInfo"] ? wx.getUserInfo({
                    success: function(t) {
                        console.log(t.userInfo);
                    }
                }) : d.setData({
                    isLogin: !0
                });
            }
        }), console.log(e);
        var d = this;
        d.setData({
            jiren: e.jiren
        });
        var t = wx.getStorageSync("openid"), a = e.openid;
        console.log(a), a == t ? d.setData({
            tuanzhang: "1"
        }) : d.setData({
            tuanzhang: "0"
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), d.setData({
                    url: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GroupsDetails",
            cachetime: "0",
            data: {
                id: e.id
            },
            success: function(c) {
                console.log("----------------gfdsdsg------------------------------"), console.log(c);
                var t = wx.getStorageSync("partnum"), l = [ {
                    thumb: c.data.data.pic,
                    title: c.data.data.gname,
                    active_num: c.data.data.num,
                    part_num: t,
                    id: c.data.data.id
                } ];
                wx.setStorageSync("groups_num", c.data.data.groups_num), console.log(wx.getStorageSync("groups_num")), 
                console.log(e.id), console.log(a), app.util.request({
                    url: "entry/wxapp/friendsGroups",
                    data: {
                        gid: e.id,
                        userid: a
                    },
                    success: function(t) {
                        console.log("拼团列表---------------------"), console.log(t);
                        var e = t.data.data, a = c.data.data.groups_num, o = c.data.data.groups_num - 1 - e.length;
                        if (5 < o) var n = 5; else n = o;
                        for (var s = [], i = 0; i < n; i++) s.push(1);
                        var u = s;
                        console.log(u);
                        var r = a - (e.length + 1);
                        console.log(r), d.setData({
                            newH: u,
                            surplus_num: r,
                            details: c.data.data,
                            friendsgroups: e,
                            active: l[0]
                        });
                    }
                });
            }
        }), app.util.request({
            url: "entry/wxapp/tuanzhang",
            cachetime: "0",
            data: {
                id: e.id,
                userid: a
            },
            success: function(t) {
                console.log(t), d.setData({
                    tuanz: t.data.data
                });
            }
        }), console.log(e.id), console.log(a);
    },
    moreGroups: function(t) {
        wx.navigateTo({
            url: "../allGroups/allGroups"
        });
    },
    wxauthSetting: function(t) {
        var s = this;
        wx.getStorageSync("openid") ? wx.getSetting({
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
                var e = t.code;
                wx.setStorageSync("code", e), wx.getSetting({
                    success: function(t) {
                        console.log("进入wx.getSetting"), console.log(t), t.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权"), 
                        wx.getUserInfo({
                            success: function(t) {
                                s.setData({
                                    is_modal_Hidden: !0,
                                    thumb: t.userInfo.avatarUrl,
                                    nickname: t.userInfo.nickName
                                }), console.log("进入wx-getUserInfo"), console.log(t.userInfo), wx.setStorageSync("user_info", t.userInfo);
                                var a = t.userInfo.nickName, o = t.userInfo.avatarUrl, n = t.userInfo.gender;
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
                                        app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: e,
                                                img: o,
                                                name: a,
                                                gender: n
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
    },
    nowPindan: function(e) {
        console.log(e);
        var t = wx.getStorageSync("openid"), a = this.data.tuanz.openid;
        app.util.request({
            url: "entry/wxapp/isBuyGroups",
            cachetime: "0",
            data: {
                tuanz: a,
                id: e.currentTarget.dataset.id,
                openid: t
            },
            success: function(t) {
                console.log(t), 1 != t.data ? wx.navigateTo({
                    url: "../to-pay-bargain/index?id=" + e.currentTarget.dataset.id + "&pid=" + e.currentTarget.dataset.pid + "&userid=" + e.currentTarget.dataset.userid
                }) : wx.showToast({
                    title: "您的商品正在拼团中...",
                    icon: "none"
                });
            }
        });
    },
    closePopupTap: function(t) {
        this.setData({
            hideShopPopup: !0
        });
    },
    bindGuiGeTap: function() {
        this.setData({
            hideShopPopup: !1
        });
    },
    labelItemTap: function(t) {
        console.log(t);
        var e = t.currentTarget.dataset.propertychildindex;
        this.setData({
            currentIndex: e,
            currentName: t.currentTarget.dataset.propertychildname
        });
    },
    labelItemTaB: function(t) {
        console.log(t);
        var e = t.currentTarget.dataset.propertychildindex;
        this.setData({
            currentSel: e,
            currentNamet: t.currentTarget.dataset.propertychildname
        });
    },
    numJianTap: function() {
        if (this.data.buyNumber > this.data.buyNumMin) {
            var t = this.data.buyNumber;
            t--, this.setData({
                buyNumber: t
            });
        }
    },
    numJiaTap: function() {
        if (this.data.buyNumber < this.data.buyNumMax) {
            var t = this.data.buyNumber;
            t++, this.setData({
                buyNumber: t
            });
        }
    },
    buyNow: function(t) {
        console.log(t), this.data.oldH.push(t.detail.userInfo.avatarUrl);
        var e = this.data.oldH;
        this.setData({
            oldH: e,
            newPintuanPeople: 1,
            newHeader: t.detail.userInfo,
            hideShopPopup: !0
        }), this.setData({
            old: this.data.num + 1,
            newH: 5 - this.data.num - 1
        }), console.log(this.data.oldH), console.log(this.data.newHeader.avatarUrl);
    },
    onReady: function() {},
    onShow: function() {
        this.wxauthSetting();
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    goBackHome: function(t) {
        wx.redirectTo({
            url: "../first/index"
        });
    },
    onShareAppMessage: function(t) {
        app.util.request({
            url: "entry/wxapp/system",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("system", t.data);
            }
        });
        var e = wx.getStorageSync("system"), a = t.target.dataset.id, o = t.target.dataset.userid, n = t.target.dataset.pid;
        return console.log(e), console.log(a), console.log(o), console.log(n), "button" === t.from && console.log(t.target), 
        {
            title: e.groups_title,
            path: "chbl_sun/pages/pintuan-list/goCantuan?id=" + a + "&openid=" + o + "&pid=" + n,
            success: function(t) {},
            fail: function(t) {}
        };
    },
    createPoster: function(t) {
        console.log(t);
        var e = this.data.active, a = t.currentTarget.dataset.userid;
        wx.setStorageSync("active", e), console.log(e);
        var o = "chbl_sun/pages/pintuan-list/goCantuan?id=" + e.id + "&openid=" + a + "&pid=1";
        wx.setStorageSync("page", o), wx.navigateTo({
            url: "../poster/poster"
        });
    },
    bindShareTap: function(t) {
        var e = t.currentTarget.dataset.statu;
        this.util(e), console.log(t);
    },
    close: function(t) {
        var e = t.currentTarget.dataset.statu;
        this.util(e);
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
            e.opacity(1).height("250rpx").step(), this.setData({
                animationData: e
            }), "close" == t && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == t && this.setData({
            showModalStatus: !0
        });
    }
});