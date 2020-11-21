var Page = require("../../../sdk/qitui/oddpush.js").oddPush(Page).Page, app = getApp(), tool = require("../../../../style/utils/countDown.js"), WxParse = require("../../wxParse/wxParse.js");

Page({
    data: {
        hideShopPopup: !0,
        num: 3,
        oldH: [ "http://oydnzfrbv.bkt.clouddn.com/tx.png", "http://oydnzfrbv.bkt.clouddn.com/tx.png" ],
        lavepeople: [],
        lavenum: 0,
        details: "",
        orderinfo: "",
        grouplist: "",
        ishas: !1,
        is_modal_Hidden: !0,
        lavenumhave: 0,
        nav: [ "商品详情", "" ]
    },
    onLoad: function(t) {
        var e = this, a = t.gid, o = t.id;
        e.setData({
            gid: a,
            id: o
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor,
            backgroundColor: wx.getStorageSync("System").color,
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), e.setData({
            isshare: t.isshare ? t.isshare : 0
        });
        var n = app.getSiteUrl();
        n ? e.setData({
            url: n
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), n = t.data, e.setData({
                    url: n
                });
            }
        }), app.wxauthSetting(), app.util.request({
            url: "entry/wxapp/CheckGroup",
            success: function(t) {
                console.log("成功"), console.log(t.data);
            }
        });
    },
    login: function() {
        app.wxauthSetting();
    },
    nowPindan: function(n) {
        app.util.request({
            url: "entry/wxapp/User",
            cachetime: "0",
            showLoading: !1,
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                if (1 == t.data) return wx.showToast({
                    title: "禁止参与",
                    icon: "loading",
                    duration: 2e3
                }), !1;
                var e = wx.getStorageSync("openid"), a = n.currentTarget.dataset.id, o = n.currentTarget.dataset.gid;
                app.util.request({
                    url: "entry/wxapp/CheckGroupOrder",
                    cachetime: "10",
                    data: {
                        order_id: a
                    },
                    success: function(t) {
                        console.log(t.data), app.util.request({
                            url: "entry/wxapp/CheckGoodsStatus",
                            cachetime: "0",
                            data: {
                                gid: o,
                                openid: e,
                                ltype: 1
                            },
                            success: function(t) {
                                console.log(t.data), wx.navigateTo({
                                    url: "../../member/ptorder/ptorder?id=" + o + "&order_id=" + a
                                });
                            },
                            fail: function(t) {
                                return wx.showModal({
                                    title: "提示信息",
                                    content: t.data.message,
                                    showCancel: !1
                                }), !1;
                            }
                        });
                    },
                    fail: function(t) {
                        return wx.showModal({
                            title: "提示信息",
                            content: t.data.message,
                            showCancel: !1
                        }), wx.navigateTo({
                            url: "/mzhk_sun/pages/index/group/group"
                        }), !1;
                    }
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
        var n, i, r = this, s = [], u = !1;
        app.func.islogin(app, r);
        var d = wx.getStorageSync("openid"), l = r.data.id, c = r.data.gid;
        app.util.request({
            url: "entry/wxapp/GroupsDetails",
            cachetime: "0",
            data: {
                id: l,
                gid: c
            },
            success: function(t) {
                console.log(111111111111), console.log(t.data), console.log(222222222222), n = Number(t.data.orderinfo.neednum) - Number(t.data.orderinfo.peoplenum);
                for (var e = Number(t.data.orderinfo.peoplenum) - Number(t.data.orderinfo.buynum), a = 0; a < n; a++) s[a] = "/resource/images/pintuan/mytx.png";
                if (i = t.data.grouplist, t.data.orderinfo.openid == d) u = !0; else for (a = 0; a < i.length; a++) i[a].openid == d && (u = !0);
                r.setData({
                    details: t.data.goodsinfo,
                    orderinfo: t.data.orderinfo,
                    grouplist: t.data.grouplist,
                    lavepeople: s,
                    lavenum: n,
                    lavenumhave: e,
                    ishas: u,
                    id: l,
                    gid: c
                });
                var o = t.data.goodsinfo.content;
                WxParse.wxParse("content", "html", o, r, 10);
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    toIndex: function(t) {
        wx.redirectTo({
            url: "/mzhk_sun/pages/index/index"
        });
    },
    otherGoods: function(t) {
        wx.redirectTo({
            url: "/mzhk_sun/pages/index/group/group"
        });
    },
    onShareAppMessage: function(t) {
        var n = this;
        app.util.request({
            url: "entry/wxapp/User",
            cachetime: "0",
            showLoading: !1,
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                if (1 == t.data) return wx.showToast({
                    title: "禁止参与",
                    icon: "loading",
                    duration: 2e3
                }), !1;
                app.util.request({
                    url: "entry/wxapp/UpdateGoods",
                    data: {
                        id: t.target.dataset.gid,
                        typeid: 2
                    },
                    success: function(t) {
                        console.log("更新数据"), console.log(t.data);
                    }
                });
                var e = t.target.dataset.id, a = t.target.dataset.gid, o = wx.getStorageSync("openid");
                return "button" === t.from && console.log(t.target), {
                    title: (n.data.details.biaoti ? n.data.details.biaoti + "：" : "") + n.data.details.gname,
                    path: "/mzhk_sun/pages/index/goCantuan/goCantuan?id=" + e + "&userid=" + o + "&gid=" + a + "&isshare=1",
                    success: function(t) {},
                    fail: function(t) {}
                };
            }
        });
    },
    updateUserInfo: function(t) {
        console.log("授权操作更新");
        app.wxauthSetting();
    }
});