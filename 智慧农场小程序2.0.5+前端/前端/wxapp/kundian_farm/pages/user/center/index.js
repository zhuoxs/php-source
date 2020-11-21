var a = new getApp(), e = a.siteInfo.uniacid;

Page({
    data: {
        SystemInfo: a.globalData.sysData,
        isIphoneX: a.globalData.isIphoneX,
        nickName: "",
        avatarUrl: "../../../images/icon/moren.png",
        back_img: "",
        noPayCount: 0,
        peiCount: 0,
        getCount: 0,
        is_admin: 2,
        setData: [],
        is_distributor: 0,
        aboutData: [],
        tarbar: wx.getStorageSync("kundianFarmTarbar"),
        is_tarbar: !1,
        userInfo: [],
        styleType: 2,
        page: [],
        kefu: {
            cover: "",
            url: "/kundian_farm/pages/user/center/index?is_tarbar=true",
            title: ""
        }
    },
    onLoad: function(t) {
        var n = this, r = parseInt(new Date().valueOf()), i = wx.getStorageSync("farmCenterPage");
        !i || wx.getStorageSync("farmCenterPage" + e) < r ? n.getCenterPage() : this.setData({
            page: i,
            styleType: i.currentType
        });
        var o = wx.getStorageSync("kundian_farm_uid"), s = wx.getStorageSync("kundian_farm_setData"), u = !1;
        t.is_tarbar && (u = t.is_tarbar);
        var d = wx.getStorageSync("kundian_farm_setData"), g = this.data.kefu;
        if (d.kefu_card) {
            var c = d.kefu_card;
            g.title = c.title || "个人中心", g.cover = c.cover || this.data.avatarUrl;
        }
        n.setData({
            setData: s,
            tarbar: wx.getStorageSync("kundianFarmTarbar"),
            is_tarbar: u,
            kefu: g
        }), o || wx.navigateTo({
            url: "../../login/index"
        }), a.util.setNavColor(e);
    },
    getCenterPage: function(t) {
        var n = this;
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "getCenterPage",
                control: "index",
                uniacid: e
            },
            success: function(a) {
                var t = a.data.centerPage;
                n.setData({
                    page: t,
                    styleType: t.currentType
                });
                var r = parseInt(new Date().valueOf()) + 18e5;
                wx.setStorageSync("farmCenterPage", t), wx.setStorageSync("farmCenterPage" + e, r);
            }
        });
    },
    getUserData: function() {
        var t = this, n = wx.getStorageSync("kundian_farm_uid");
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "getUserInfo",
                control: "index",
                uid: n,
                uniacid: e
            },
            success: function(a) {
                var e = a.data, n = e.noPayCount, r = e.peiCount, i = e.getCount, o = e.is_admin, s = e.back_img, u = e.aboutData, d = a.data.userInfo || {};
                Object.keys(d).length > 0 ? a.data.userInfo.avatarurl && void 0 != a.data.userInfo.avatarurl && t.setData({
                    nickName: d.nickname,
                    avatarUrl: d.avatarurl,
                    is_distributor: d.is_distributor || 0,
                    noPayCount: n,
                    peiCount: r,
                    getCount: i,
                    is_admin: o,
                    userInfo: d,
                    aboutData: u,
                    back_img: s
                }) : t.setData({
                    noPayCount: n,
                    peiCount: r,
                    getCount: i,
                    is_admin: o,
                    userInfo: d,
                    aboutData: u,
                    back_img: s
                }), d || (wx.removeStorageSync("kundian_farm_wxInfo"), wx.removeStorageSync("userInfo"), 
                wx.navigateTo({
                    url: "../../login/index"
                }));
            }
        });
    },
    onShow: function(a) {
        var e = this, t = wx.getStorageSync("kundian_farm_wxInfo");
        t && e.setData({
            avatarUrl: t.avatarUrl,
            nickName: t.nickName
        }), this.getUserData(), e.setData({
            tarbar: wx.getStorageSync("kundianFarmTarbar")
        });
    },
    intoOrder: function(a) {
        var e = a.currentTarget.dataset.status;
        wx.navigateTo({
            url: "../../shop/orderList/index?status=" + e
        });
    },
    updateUserInfo: function(a) {
        var e = this, t = getApp(), n = t.siteInfo.uniacid;
        t.util.getUserInfo(function(a) {
            wx.setStorageSync("kundian_farm_uid", a.memberInfo.uid), wx.setStorageSync("kundian_farm_sessionid", a.sessionid), 
            wx.setStorageSync("kundian_farm_wxInfo", a.wxInfo), console.log(a.wxInfo);
            var r = a.memberInfo, i = a.wxInfo.avatarUrl, o = a.wxInfo.nickName, s = r.uid;
            if (e.setData({
                nickName: o,
                avatarUrl: i
            }), !s) return wx.showModal({
                title: "提示",
                content: "获取用户UID失败",
                showCancel: !1
            }), !1;
            t.util.request({
                url: "entry/wxapp/class",
                data: {
                    op: "login",
                    control: "index",
                    avatar: r.avatar,
                    nickname: r.nickname,
                    uid: s,
                    uniacid: n,
                    wxNickName: o,
                    wxAvatar: i
                },
                success: function(a) {
                    var e = wx.getStorageSync("farm_share_uid");
                    void 0 != e && 0 != e && t.loginBindParent(e, s), wx.showModal({
                        title: "提示",
                        content: a.data.msg,
                        showCancel: !1
                    });
                }
            });
        }, a.detail);
    },
    onPullDownRefresh: function(t) {
        var n = this, r = wx.getStorageSync("kundian_farm_wxInfo");
        r && n.setData({
            avatarUrl: r.avatarUrl,
            nickName: r.nickName
        }), n.getCenterPage(), n.getUserData(), a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "getCommonData",
                control: "index",
                uniacid: e
            },
            success: function(a) {
                var e = a.data, t = e.tarbar, r = e.farmSetData;
                n.setData({
                    tarbar: t,
                    farmSetData: r
                }), wx.setStorageSync("kundianFarmTarbar", t), wx.setStorageSync("kundian_farm_setData", r);
            }
        }), wx.stopPullDownRefresh();
    },
    intoAdmin: function(a) {
        wx.navigateTo({
            url: "/kundian_farm/pages/manage/center/index"
        });
    },
    callPhone: function(a) {
        var e = a.currentTarget.dataset.phone;
        wx.makePhoneCall({
            phoneNumber: e
        });
    },
    intoMenuDetail: function(a) {
        var e = this, t = a.currentTarget.dataset.menutype, n = a.currentTarget.dataset.url;
        if ("center_address" == t) wx.navigateTo({
            url: "/kundian_farm/pages/user/address/index"
        }); else if ("center_sale" == t) {
            var r = e.data.is_distributor;
            1 == r ? wx.navigateTo({
                url: "/kundian_farm/pages/distribution/index/index"
            }) : 2 == r ? wx.navigateTo({
                url: "/kundian_farm/pages/distribution/examine/index"
            }) : wx.navigateTo({
                url: "/kundian_farm/pages/distribution/addinfo/index"
            });
        } else "center_animal" == t ? wx.navigateTo({
            url: "/kundian_farm/pages/" + n + "?current=4"
        }) : "center_land" == t ? wx.navigateTo({
            url: "/kundian_farm/pages/land/personLand/index"
        }) : "center_set" == t ? wx.navigateTo({
            url: "/kundian_farm/pages/user/install/index"
        }) : "center_funding" == t ? wx.navigateTo({
            url: "/kundian_funding/pages/orderList/index"
        }) : "center_active" == t ? wx.navigateTo({
            url: "/kundian_active/pages/orderList/index"
        }) : "plugin_pt" == t ? wx.navigateTo({
            url: "/kundian_pt/pages/orderLists/index"
        }) : "center_store" == t ? wx.navigateTo({
            url: "/kundian_store/pages/store/login/index"
        }) : "center_store_apply" == t ? wx.navigateTo({
            url: "/kundian_store/pages/store/apply/index"
        }) : wx.navigateTo({
            url: "/kundian_farm/pages/" + n
        });
    },
    intoSetting: function(a) {
        wx.navigateTo({
            url: "/kundian_farm/pages/user/install/index"
        });
    },
    intoScoreRecord: function(a) {
        wx.navigateTo({
            url: "/kundian_farm/pages/shop/integral/record/index"
        });
    },
    intoMoney: function() {
        wx.navigateTo({
            url: "/kundian_farm/pages/user/wallet/index"
        });
    },
    intoSign: function() {
        wx.navigateTo({
            url: "/kundian_farm/pages/shop/integral/index/index"
        });
    },
    showSystemInfo: function(e) {
        var t = "domain=" + a.siteInfo.siteroot + ";uid=" + wx.getStorageSync("kundian_farm_uid") + ";uniacid=" + a.siteInfo.uniacid;
        wx.showModal({
            title: "提示",
            content: t,
            showCancel: !1
        });
    }
});