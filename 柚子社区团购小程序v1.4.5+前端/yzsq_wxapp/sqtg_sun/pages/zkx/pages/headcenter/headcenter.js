var app = getApp();

Page({
    data: {
        reload: !1,
        spell: !1
    },
    onLoad: function(e) {
        var a = this;
        1 == getCurrentPages().length && a.setData({
            showFoot: !0
        }), app.ajax({
            url: "Csystem|getSetting",
            success: function(e) {
                a.setData({
                    setting: e.data
                }), wx.setStorageSync("appConfig", e.data);
            }
        });
        var t = wx.getStorageSync("userInfo");
        t ? a.setData({
            user_id: t.id
        }) : wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(e) {
                if (e.confirm) {
                    var a = encodeURIComponent("/sqtg_sun/pages/zkx/pages/headcenter/headcenter");
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + a);
                } else e.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
        var s = wx.getStorageSync("linkaddress");
        s ? (a.setData({
            linkaddress: s
        }), a.getmyleader()) : app.navTo("/sqtg_sun/pages/zkx/pages/nearleaders/nearleaders");
    },
    onShow: function() {
        var e = wx.getStorageSync("spell");
        this.data.spell = e, this.setData({
            spell: e
        });
    },
    getmyleader: function() {
        var a = this, e = wx.getStorageSync("userInfo");
        app.ajax({
            url: "Cleader|getMyLeader",
            data: {
                user_id: e.id
            },
            success: function(e) {
                console.log(e), a.setData({
                    show: !0,
                    myleader: e.data,
                    is_leader: e.data && 2 == e.data.check_state,
                    apply_bgm: e.other.apply_bgm,
                    img_root: e.other.img_root
                }), console.log(a.data.myleader), a.data.is_leader ? wx.setStorageSync("myleader", a.data.myleader) : console.log(a.data), 
                wx.setNavigationBarTitle({
                    title: "团长后台"
                }), a.getConfirmUsers(e.data.id), a.getSendingUsers(e.data.id);
            }
        }), app.api.getCartCount({
            user_id: a.data.user_id,
            leader_id: a.data.linkaddress.id
        }).then(function(e) {
            a.setData({
                cartCount: e
            });
        });
    },
    getConfirmUsers: function(e) {
        var a = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "", t = this;
        app.ajax({
            url: "Cleader|getConfirmUsers",
            data: {
                leader_id: e,
                key: a
            },
            success: function(e) {
                t.setData({
                    users: e.data
                });
            }
        });
    },
    getConfirmSendingUsers: function(e) {
        var a = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "", t = this;
        app.ajax({
            url: "Cleader|getConfirmSendingUsers",
            data: {
                leader_id: e,
                key: a
            },
            success: function(e) {
                t.setData({
                    sending_users: e.data
                });
            }
        });
    },
    getSendingUsers: function(e) {
        var a = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "", t = this;
        app.ajax({
            url: "Cleader|getSendingUsers",
            data: {
                leader_id: e,
                key: a
            },
            success: function(e) {
                t.setData({
                    sending_users: e.data
                });
            }
        });
    },
    onLoadData: function() {
        var a = this, t = wx.getStorageSync("userInfo");
        t ? (app.ajax({
            url: "Index|getpluginkey",
            success: function(e) {
                a.setData({
                    control: e.data
                });
            }
        }), app.ajax({
            url: "Cuser|myInfo",
            data: {
                user_id: t.id
            },
            success: function(e) {
                a.setData({
                    info: e.data,
                    imgRoot: e.other.img_root,
                    show: !0,
                    user_id: t.id
                });
            }
        })) : wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(e) {
                if (e.confirm) {
                    var a = encodeURIComponent("/sqtg_sun/pages/home/my/my?id=123");
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + a);
                } else e.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
    },
    myScan: function() {
        var s = this;
        wx.scanCode({
            success: function(e) {
                var a = e.result;
                if (/code-/.test(a)) {
                    var t = a.replace("code-", "");
                    app.navTo("/sqtg_sun/pages/zkx/pages/verificationorder/verificationorder?id=" + t + "&leader_id=" + s.data.myleader.id);
                }
            }
        });
    },
    userKeyInput: function(e) {
        this.setData({
            userKey: e.detail.value
        });
    },
    userSearch: function(e) {
        var a = this.data.userKey || "", t = this.data.myleader.id;
        this.setData({
            usersearch: 1
        }), this.getConfirmUsers(t, a);
    },
    userSearchSending: function(e) {
        var a = this.data.userKey || "", t = this.data.myleader.id;
        this.setData({
            userSearchSending: 1
        }), this.getConfirmSendingUsers(t, a);
    },
    chooseUser: function(e) {
        var a = this.data.myleader.id, t = e.currentTarget.dataset.userid;
        app.navTo("/sqtg_sun/pages/zkx/pages/verificationorder/verificationorder?id=" + t + "&leader_id=" + a);
    },
    chooseSendingUser: function(e) {
        var a = this.data.myleader.id, t = e.currentTarget.dataset.userid;
        app.navTo("/sqtg_sun/pages/zkx/pages/verificationgoods/verificationgoods?id=" + t + "&leader_id=" + a);
    },
    toApply: function() {
        app.reTo("../headapplication/headapplication");
    },
    onPullDownRefresh: function() {
        this.getmyleader();
    }
});