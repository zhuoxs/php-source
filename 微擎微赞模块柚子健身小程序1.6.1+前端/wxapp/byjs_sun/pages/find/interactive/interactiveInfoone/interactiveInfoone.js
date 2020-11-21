var app = getApp();

Page({
    data: {
        talent: {
            img: "http://img.zcool.cn/community/0142135541fe180000019ae9b8cf86.jpg@1280w_1l_2o_100sh.png",
            name: "卡若不弃",
            release_time: "12月10日",
            gender: 0,
            userId: "123",
            talentImg: [ "http://img.zcool.cn/community/0142135541fe180000019ae9b8cf86.jpg@1280w_1l_2o_100sh.png" ],
            talentText: "世纪东方看水电费上课的飞机上课的房间上课的房间开始的九分裤世纪东方开始的减肥上课京东方",
            talentLove: "12",
            talentComment: "1",
            iddata: 1
        },
        is_modal_Hidden: !0,
        isLogin: !0,
        lovestatus: 0,
        loveimgsrc1: "../../../../../byjs_sun/resource/images/find/icon-love.png",
        loveimgsrc2: "../../../../../byjs_sun/resource/images/find/icon-love-1.png",
        lovenum: 0,
        lovenumadd1: 1,
        releaseFocus: !1,
        fixbottomFocus: !0,
        expert_id: ""
    },
    onLoad: function(e) {
        var t = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var o = e.id;
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(e) {
                wx.setStorageSync("url", e.data), t.setData({
                    url: e.data
                });
            }
        }), t.wxauthSetting();
        var n = wx.getStorageSync("users").id;
        app.util.request({
            url: "entry/wxapp/GetExpertDetail",
            cachetime: "0",
            data: {
                expert_id: o,
                user_id: n
            },
            success: function(e) {
                console.log(e.data), t.setData({
                    talent: e.data,
                    expert_id: o
                });
            }
        });
    },
    lovefun: function(e) {
        var t = this, o = this.data.expert_id, n = wx.getStorageSync("users").id, a = t.data.talent;
        1 == a.is_love ? (a.is_love = 0, a.collect_num = parseInt(a.collect_num) - 1) : (a.is_love = 1, 
        a.collect_num = parseInt(a.collect_num) + 1), app.util.request({
            url: "entry/wxapp/lovefun",
            cachetime: "0",
            data: {
                tag: 0,
                id: o,
                user_id: n
            },
            success: function(e) {
                1 == e.data ? t.setData({
                    talent: a
                }) : wx.showToast({
                    title: "点赞失败，网络延迟！！！",
                    icon: "none"
                });
            },
            fail: function(e) {
                wx.showToast({
                    title: "点赞失败，网络延迟！！！",
                    icon: "none"
                });
            }
        });
    },
    previewImage: function(e) {
        for (var t = wx.getStorageSync("url"), o = e.currentTarget.dataset.img, n = this.data.talent.img, a = [], s = 0; s < n.length; s++) a[s] = t + n[s];
        wx.previewImage({
            current: o,
            urls: a
        });
    },
    bindReply: function(e) {
        console.log(e), console.log(this.data), this.setData({
            releaseFocus: !0
        });
    },
    displaycom: function(e) {
        this.setData({
            releaseFocus: !1,
            fixbottomFocus: !0
        });
    },
    addcom: function(e) {
        var t = this.data.talent;
        this.setData({
            releaseFocus: !0,
            fixbottomFocus: !1,
            releaseName: t.name
        });
    },
    tacomformSubmit: function(e) {
        var n = this, a = n.data.talent, t = wx.getStorageSync("users").id, o = n.data.expert_id, s = e.detail.value.commenttext;
        if (!s) return wx.showToast({
            title: "内容不能为空！！！",
            icon: "none"
        }), !1;
        app.util.request({
            url: "entry/wxapp/Addcomment",
            cachetime: "0",
            data: {
                expert_id: o,
                user_id: t,
                content: s
            },
            success: function(e) {
                var t = a.comment;
                console.log(t);
                var o = {
                    img: wx.getStorageSync("users").img,
                    gender: wx.getStorageSync("users").gender,
                    name: wx.getStorageSync("users").name,
                    content: s,
                    release_time: 0
                };
                0 < e.data.id && (o.release_time = e.data.data.release_time, t.unshift(o), a.comment = t, 
                n.setData({
                    releaseFocus: !1,
                    fixbottomFocus: !0,
                    talent: a
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
    onShareAppMessage: function(e) {
        var t = wx.getStorageSync("users").name;
        return "button" === e.from && console.log(e.target), {
            title: "用户 " + t + " 邀你来到最好的健身小程序",
            path: "/byjs_sun/pages/find/interactive/interactiveInfoone/interactiveInfoone?id=" + this.data.expert_id,
            success: function(e) {},
            fail: function(e) {}
        };
    },
    toIndex: function(e) {
        wx.redirectTo({
            url: "/byjs_sun/pages/product/index/index"
        });
    },
    wxauthSetting: function(e) {
        var s = this;
        wx.getStorageSync("openid") ? wx.getSetting({
            success: function(e) {
                console.log("进入wx.getSetting 1"), console.log(e), e.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权 1"), 
                wx.getUserInfo({
                    success: function(e) {
                        s.setData({
                            is_modal_Hidden: !0,
                            thumb: e.userInfo.avatarUrl,
                            nickname: e.userInfo.nickName
                        });
                    }
                })) : (console.log("scope.userInfo没有授权 1"), wx.showModal({
                    title: "获取信息失败",
                    content: "请允许授权以便为您提供给服务",
                    success: function(e) {
                        s.setData({
                            is_modal_Hidden: !1
                        });
                    }
                }));
            },
            fail: function(e) {
                console.log("获取权限失败 1"), s.setData({
                    is_modal_Hidden: !1
                });
            }
        }) : wx.login({
            success: function(e) {
                console.log("进入wx-login");
                var t = e.code;
                wx.setStorageSync("code", t), wx.getSetting({
                    success: function(e) {
                        console.log("进入wx.getSetting"), console.log(e), e.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权"), 
                        wx.getUserInfo({
                            success: function(e) {
                                s.setData({
                                    is_modal_Hidden: !0,
                                    thumb: e.userInfo.avatarUrl,
                                    nickname: e.userInfo.nickName
                                }), console.log("进入wx-getUserInfo"), console.log(e.userInfo), wx.setStorageSync("user_info", e.userInfo);
                                var o = e.userInfo.nickName, n = e.userInfo.avatarUrl, a = e.userInfo.gender;
                                app.util.request({
                                    url: "entry/wxapp/openid",
                                    cachetime: "0",
                                    data: {
                                        code: t
                                    },
                                    success: function(e) {
                                        console.log("进入获取openid"), console.log(e.data), wx.setStorageSync("key", e.data.session_key);
                                        var t = e.data.openid;
                                        wx.setStorageSync("userid", e.data.openid), wx.setStorage({
                                            key: "openid",
                                            data: t
                                        }), app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: t,
                                                img: n,
                                                name: o,
                                                gender: a
                                            },
                                            success: function(e) {
                                                console.log("进入地址login"), console.log(e.data), wx.setStorageSync("users", e.data), 
                                                wx.setStorageSync("uniacid", e.data.uniacid), s.setData({
                                                    usersinfo: e.data
                                                });
                                            }
                                        });
                                    }
                                });
                            },
                            fail: function(e) {
                                console.log("进入 wx-getUserInfo 失败"), wx.showModal({
                                    title: "获取信息失败",
                                    content: "请允许授权以便为您提供给服务!",
                                    success: function(e) {
                                        s.setData({
                                            is_modal_Hidden: !1
                                        });
                                    }
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
                    success: function(e) {
                        s.setData({
                            is_modal_Hidden: !1
                        });
                    }
                });
            }
        });
    },
    updateUserInfo: function(e) {
        console.log("授权操作更新");
        this.wxauthSetting();
    }
});