/*   time:2019-08-09 13:18:47*/
function _defineProperty(e, t, a) {
    return t in e ? Object.defineProperty(e, t, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = a, e
}
var app = getApp(),
    WxParse = require("../../../pages/wxParse/wxParse.js");
Page({
    data: {
        list: {
            load: !1,
            over: !1,
            page: 1,
            length: 10,
            none: !1,
            data: []
        },
        page1: 1,
        good_height: "auto",
        shop_height: "auto",
        is_modal_Hidden: !0,
        showgw: 0,
        hidden: !0
    },
    onLoad: function(e) {
        e = app.func.decodeScene(e), this.setData({
            pid: e.pid
        })
    },
    onReady: function() {},
    onShow: function() {
        var g = this;
        g.islogin(), wx.getLocation({
            type: "wgs84",
            success: function(e) {
                var t = e.latitude,
                    a = e.longitude;
                app.util.request({
                    url: "entry/wxapp/packagedetail",
                    data: {
                        m: app.globalData.Plugin_package,
                        pid: g.data.pid,
                        page: g.data.list.page,
                        page1: g.data.page1,
                        lat: t,
                        lng: a
                    },
                    success: function(e) {
                        if (console.log(e), 2 == e.data) wx.showModal({
                            title: "提示",
                            content: "套餐包已失效",
                            showCancel: !1,
                            success: function(e) {
                                wx.redirectTo({
                                    url: "../packageIndex/packageIndex"
                                })
                            }
                        });
                        else {
                            var t, a = e.data.package.content,
                                o = e.data.package.detail;
                            WxParse.wxParse("content", "html", a, g, 10), WxParse.wxParse("content2", "html", o, g, 10);
                            var n = [];
                            for (var i in e.data.imgs) n[i] = e.data.imgs[i].img;
                            var s = {
                                buynum: e.data.buynum.count,
                                imgs: n
                            };
                            g.setData((_defineProperty(t = {}, "list.data", e.data.goods), _defineProperty(t, "infos", e.data.package), _defineProperty(t, "activeList", s), _defineProperty(t, "imgLink", wx.getStorageSync("url")), _defineProperty(t, "url", wx.getStorageSync("url")), _defineProperty(t, "brand", e.data.brand), _defineProperty(t, "show_good", 4 < e.data.goods.length), _defineProperty(t, "show_shop", 2 < e.data.brand.length), _defineProperty(t, "good_height", 4 < e.data.goods.length ? 540 : "auto"), _defineProperty(t, "shop_height", 4 < e.data.goods.length ? 300 : "auto"), _defineProperty(t, "shows", 3 < e.data.goods.length), _defineProperty(t, "shows2", 2 < e.data.brand.length), t))
                        }
                    }
                })
            }
        });
        var e = wx.getStorageSync("System");
        console.log(e.showgw);
        var t = e.showgw;
        if (1 == t) {
            var a = {
                wg_title: e.wg_title,
                wg_directions: e.wg_directions,
                wg_img: e.wg_img,
                wg_keyword: e.wg_keyword,
                wg_addicon: e.wg_addicon
            };
            g.setData({
                showgw: t,
                wglist: a
            })
        }
        var o = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/ISVIP",
            cachetime: "0",
            data: {
                openid: o
            },
            header: {
                "content-type": "application/json"
            },
            success: function(e) {
                console.log("vip"), console.log(e.data), wx.setStorageSync("viptype", e.data.viptype), g.setData({
                    viptype: e.data.viptype
                })
            }
        })
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        console.log("分享");
        var e = this,
            t = e.data.infos.name,
            a = wx.getStorageSync("url"),
            o = e.data.infos.img,
            n = wx.getStorageSync("users");
        return {
            title: t,
            path: "/mzhk_sun/plugin3/package/packageDetail/packageDetail?pid=" + e.data.pid + "&is_share=1&d_user_id=" + n.id,
            imageUrl: a + o
        }
    },
    islogin: function() {
        var t = this;
        wx.getStorageSync("have_wxauth") || wx.getSetting({
            success: function(e) {
                e.authSetting["scope.userInfo"] ? (wx.setStorageSync("have_wxauth", 1), wx.getUserInfo({
                    success: function(e) {
                        t.setData({
                            is_modal_Hidden: !0
                        })
                    }
                })) : t.setData({
                    is_modal_Hidden: !1
                })
            }
        })
    },
    buyOrSpec: function() {
        wx.navigateTo({
            url: "../packagePay/packagePay?id=" + this.data.infos.id
        })
    },
    toCforder: function(e) {
        var t = this;
        if (console.log(e), 2 == t.data.infos.state) {
            app.util.request({
                url: "entry/wxapp/User",
                cachetime: "0",
                showLoading: !1,
                data: {
                    openid: wx.getStorageSync("openid")
                },
                success: function(e) {
                    if (1 == e.data) return wx.showToast({
                        title: "禁止购买",
                        icon: "loading",
                        duration: 2e3
                    }), tourl = "/mzhk_sun/pages/index/index", wx.redirectTo({
                        url: tourl
                    }), !1
                }
            });
            e.currentTarget.dataset.id;
            var a = e.currentTarget.dataset.price,
                o = (wx.getStorageSync("openid"), t.data.infos),
                n = t.data.viptype;
            console.log(a), 1 != o.is_vip && 0 < n && (a = 0 < o.vipprice ? o.vipprice : a), 0 == n && 1 == t.data.infos.is_vip ? wx.showToast({
                title: "该商品为会员专属",
                icon: "none",
                duration: 2e3
            }) : wx.navigateTo({
                url: "../packagePay/packagePay?id=" + this.data.infos.id + "&price=" + a
            })
        } else 1 == t.data.infos.state ? wx.showToast({
            title: "活动尚未开始"
        }) : wx.showToast({
            title: "活动已过期"
        })
    },
    gomember: function(e) {
        wx.navigateTo({
            url: "/mzhk_sun/pages/member/member"
        })
    },
    tels: function(e) {
        var t = e.currentTarget.dataset.tel;
        wx.makePhoneCall({
            phoneNumber: t
        })
    },
    address: function(e) {
        wx.openLocation({
            latitude: parseFloat(e.currentTarget.dataset.lat),
            longitude: parseFloat(e.currentTarget.dataset.lng)
        })
    },
    index: function(e) {
        wx.reLaunch({
            url: "../../../pages/index/index"
        })
    },
    change_good: function() {
        var e = this.data.show_good;
        e && this.setData({
            show_good: !1,
            good_height: "auto"
        }), e || this.setData({
            show_good: !0,
            good_height: 540
        })
    },
    change_shop: function() {
        var e = this.data.show_shop;
        e && this.setData({
            show_shop: !1,
            shop_height: "auto"
        }), e || this.setData({
            show_shop: !0,
            shop_height: 300
        })
    },
    goShopss: function(e) {
        var t = e.currentTarget.dataset.lid,
            a = e.currentTarget.dataset.id;
        console.log(t), console.log(a), 1 == t && (console.log(1111), wx.navigateTo({
            url: "/mzhk_sun/pages/index/goods/goods?gid=" + a
        })), 2 == t && (console.log(2222), wx.navigateTo({
            url: "/mzhk_sun/pages/index/bardet/bardet?id=" + a
        })), 3 == t && (console.log(333), wx.navigateTo({
            url: "/mzhk_sun/pages/index/groupdet/groupdet?id=" + a
        })), 5 == t && (console.log(555), wx.navigateTo({
            url: "/mzhk_sun/pages/index/package/package?id=" + a
        }))
    },
    shareCanvas: function() {
        var e = "mzhk_sun/plugin3/package/packageDetail/packageDetail",
            t = this.data.infos,
            a = [];
        a.codetype = wx.getStorageSync("System").ispnumber, a.gid = t.id, a.goodspicbg = wx.getStorageSync("System").goodspicbg, a.bname = t.name, a.url = this.data.imgLink, a.logo = t.img, a.shopprice = t.price, a.vipprice = t.vipprice;
        var o = wx.getStorageSync("users");
        a.scene = "d_user_id=" + o.id + "&pid=" + this.data.pid, console.log(e), console.log(a), a.tabletype = 4, app.creatPoster(e, 430, a, 9, "shareImg")
    },
    showwgtable: function(e) {
        var t = e.currentTarget.dataset.flag;
        this.setData({
            wg_flag: t
        })
    },
    updateUserInfo: function(e) {
        app.wxauthSetting()
    },
    save: function() {
        var t = this;
        wx.saveImageToPhotosAlbum({
            filePath: t.data.prurl,
            success: function(e) {
                wx.showModal({
                    content: "图片已保存到相册，赶紧晒一下吧~",
                    showCancel: !1,
                    confirmText: "好哒",
                    confirmColor: "#ef8200",
                    success: function(e) {
                        e.confirm && (console.log("用户点击确定"), t.setData({
                            hidden: !0
                        }))
                    }
                })
            },
            fail: function(e) {
                console.log("失败"), wx.getSetting({
                    success: function(e) {
                        e.authSetting["scope.writePhotosAlbum"] || (console.log("进入信息授权开关页面"), wx.openSetting({
                            success: function(e) {
                                console.log("openSetting success", e.authSetting)
                            }
                        }))
                    }
                })
            }
        })
    },
    hidden: function(e) {
        this.setData({
            hidden: !0
        })
    }
});