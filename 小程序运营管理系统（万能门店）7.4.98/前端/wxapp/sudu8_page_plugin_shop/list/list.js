var app = getApp();

function initSubMenuDisplay() {
    return [ "hidden", "hidden", "hidden", "hidden" ];
}

function menuCss() {
    return [ "ordinary", "ordinary", "ordinary", "ordinary" ];
}

function rotateRight() {
    return [ "", "", "", "", "" ];
}

var cover = "", initSubMenuHighLight = [ [ "", "", "", "", "" ], [ "", "", "", "", "" ], [ "", "", "", "", "" ], [ "", "", "", "", "" ], [ "", "", "", "", "" ] ], selectData = [ "附近", "不限", "不限", "不限" ];

Page({
    data: {
        page_sign: "shopsList",
        page: 1,
        morePro: !1,
        baseinfo: [],
        cid: 0,
        cate: [],
        footer: {
            i_tel: app.globalData.i_tel,
            i_add: app.globalData.i_add,
            i_time: app.globalData.i_time,
            i_view: app.globalData.i_view,
            close: app.globalData.close,
            v_ico: app.globalData.v_ico
        },
        showMenu: !1,
        subMenuDisplay: initSubMenuDisplay(),
        subMenuHighLight: initSubMenuHighLight,
        cover: cover,
        menuCss: menuCss(),
        rotateRight: rotateRight(),
        menuContent: [ {
            title: "全部分类",
            content: [ "全部分类" ]
        }, {
            title: "综合排序",
            content: [ "综合排序", "距离最近" ]
        }, {
            title: "所有商家",
            content: [ "所有商家", "优选商家" ]
        } ],
        content: [],
        indexListHouse: [],
        lastIndex: null,
        times: 1,
        longitude: "",
        latitude: ""
    },
    onPullDownRefresh: function() {
        var t = this;
        t.getBase(), t.getCate(t.data.cid), wx.stopPullDownRefresh();
    },
    onLoad: function(t) {
        var a = this;
        a.setData({
            isIphoneX: app.globalData.isIphoneX
        }), t.cid && a.setData({
            cid: t.cid
        });
        t.fxsid && (t.fxsid, a.setData({
            fxsid: t.fxsid
        })), a.getBase(), a.getCate(a.data.cid);
    },
    redirectto: function(t) {
        var a = t.currentTarget.dataset.link, e = t.currentTarget.dataset.linktype;
        app.util.redirectto(a, e);
    },
    onShow: function() {
        var a = this;
        a.data.page = 1, wx.getLocation({
            type: "wgs84",
            success: function(t) {
                a.data.latitude = t.latitude, a.data.longitude = t.longitude, app.util.getUserInfo(a.getinfos, a.data.fxsid);
            },
            fail: function(t) {
                wx.getSetting({
                    success: function(t) {
                        t.authSetting["scope.userLocation"] ? wx.showModal({
                            title: "提示",
                            content: "请检查手机位置信息/GPS是否有开启",
                            showCancel: !1,
                            success: function(t) {
                                wx.redirectTo({
                                    url: "/sudu8_page/index/index"
                                });
                            }
                        }) : wx.showModal({
                            title: "提示",
                            content: "请授权获取您的位置信息",
                            showCancel: !1,
                            success: function() {
                                wx.openSetting({
                                    success: function(t) {
                                        1 == t.authSetting["scope.userLocation"] && (wx.showToast({
                                            title: "授权成功！",
                                            icon: "success",
                                            duration: 1e3
                                        }), app.util.getUserInfo(a.getinfos, a.data.fxsid));
                                    }
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    onReachBottom: function() {
        var a = this;
        a.data.page++, app.util.request({
            url: "entry/wxapp/selectShopList",
            data: {
                option1: a.data.menuContent[0].title,
                option2: a.data.menuContent[1].title,
                option3: a.data.menuContent[2].title,
                longitude: a.data.longitude,
                latitude: a.data.latitude,
                page: a.data.page
            },
            cachetime: "30",
            success: function(t) {
                a.setData({
                    shopList: a.data.shopList.concat(t.data.data)
                });
            }
        });
    },
    getinfos: function() {
        var a = this, e = a.data.cid;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                a.setData({
                    openid: t.data
                }), a.getShopList(e);
            }
        });
    },
    getBase: function() {
        var a = this, t = app.util.url("entry/wxapp/Base", {
            m: "sudu8_page"
        });
        wx.request({
            url: t,
            data: {
                vs1: 1
            },
            success: function(t) {
                a.setData({
                    baseinfo: t.data.data
                }), wx.setNavigationBarColor({
                    frontColor: a.data.baseinfo.base_tcolor,
                    backgroundColor: a.data.baseinfo.base_color
                }), wx.setNavigationBarTitle({
                    title: "商户列表"
                });
            }
        });
    },
    tapMainMenu: function(t) {
        var a = this, e = t.currentTarget.dataset.index;
        a.data.lastIndex == e ? (a.data.times++, 2 == a.data.times ? a.setData({
            showMenu: !1
        }) : a.setData({
            showMenu: !0,
            content: a.data.menuContent[e].content,
            times: 1
        })) : a.setData({
            showMenu: !0,
            content: a.data.menuContent[e].content,
            times: 1
        }), a.data.lastIndex = e;
    },
    tapSubMenu: function(t) {
        var a = this, e = a.data.menuContent, n = t.currentTarget.dataset.index;
        e[a.data.lastIndex].title = a.data.content[n], a.setData({
            menuContent: e,
            showMenu: !1,
            times: 2,
            page: 1
        }), app.util.request({
            url: "entry/wxapp/selectShopList",
            data: {
                option1: a.data.menuContent[0].title,
                option2: a.data.menuContent[1].title,
                option3: a.data.menuContent[2].title,
                longitude: a.data.longitude,
                latitude: a.data.latitude,
                page: 1
            },
            cachetime: "30",
            success: function(t) {
                a.setData({
                    shopList: t.data.data
                });
            }
        });
    },
    switchCate: function(t) {
        var a = t.currentTarget.dataset.cid, e = t.currentTarget.dataset.name;
        this.getShopList(a), this.setData({
            nowCate: e,
            changeShow1: "hide",
            changeShow2: "hide",
            changeShow3: "show"
        });
    },
    getShopList: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/selectShopList",
            data: {
                cid: t,
                longitude: a.data.longitude,
                latitude: a.data.latitude
            },
            cachetime: "30",
            success: function(t) {
                a.setData({
                    shopList: t.data.data
                });
            }
        });
    },
    getCate: function(s) {
        var u = this;
        app.util.request({
            url: "entry/wxapp/getCate",
            success: function(t) {
                for (var a = u.data.menuContent, e = 0; e < t.data.data.length; e++) a[0].content.push(t.data.data[e].name);
                if (s) for (var n = u.data.menuContent, i = t.data.data, o = 0; o < i.length; o++) i[o].id == s && (n[0].title = i[o].name, 
                u.setData({
                    menuContent: n
                }));
                u.setData({
                    cate: t.data.data
                });
            }
        });
    },
    makePhoneCall: function(t) {
        var a = t.currentTarget.dataset.tel;
        wx.makePhoneCall({
            phoneNumber: a
        });
    },
    onShareAppMessage: function() {
        return {
            title: this.data.cateinfo.name + "-" + this.data.baseinfo.name
        };
    }
});