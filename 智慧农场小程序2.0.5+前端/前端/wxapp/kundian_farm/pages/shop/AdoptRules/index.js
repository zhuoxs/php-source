var a = require("../../../../wxParse/wxParse.js"), t = new getApp(), i = t.siteInfo.uniacid;

Page({
    data: {
        state: !1,
        count: 1,
        animalData: [],
        aid: "",
        sku_name: "",
        aboutData: [],
        farmSetData: [],
        isShow: !1,
        is_loading: !0,
        kefu: {
            cover: "",
            url: "/kundian_farm/pages/shop/AdoptRules/index",
            title: ""
        },
        src_xy: []
    },
    preventTouchMove: function() {},
    onLoad: function(n) {
        var e = this, o = n.aid, s = 0;
        t.globalData.sysData.model.indexOf("iPhone X") > -1 && (s = 68);
        var u = wx.getStorageSync("kundian_farm_setData"), r = this.data.kefu;
        if (u.kefu_card) {
            var d = u.kefu_card;
            r.title = d.title || "认养详情", r.cover = d.cover || this.data.avatarUrl;
        }
        r.url = "/kundian_farm/pages/shop/AdoptRules/index?aid=" + o, e.setData({
            farmSetData: u,
            kefu: r
        }), t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "animal",
                op: "animalDetail",
                aid: o,
                uniacid: i
            },
            success: function(t) {
                var i = t.data, n = i.animalData, s = i.aboutData, u = n.src, r = [];
                r && (r = u.split(":")), e.setData({
                    animalData: n,
                    aid: o,
                    aboutData: s,
                    src_xy: r
                }), "" != n.detail_desc && a.wxParse("article", "html", n.detail_desc, e, 5);
            }
        });
        var c = n.user_uid, l = wx.getStorageSync("kundian_farm_uid");
        t.loginBindParent(c, l), void 0 != c && 0 != c && e.setData({
            user_uid: c
        }), e.setData({
            bottom: s
        }), t.util.setNavColor(i);
    },
    onShow: function(a) {
        var i = this, n = this.data.user_uid, e = wx.getStorageSync("kundian_farm_uid");
        t.loginBindParent(n, e), void 0 != n && 0 != n && i.setData({
            user_uid: n
        });
    },
    showMode: function() {
        var a = wx.getStorageSync("kundian_farm_uid");
        void 0 == a || 0 == a ? wx.navigateTo({
            url: "../../login/index"
        }) : this.setData({
            state: !0
        });
    },
    hideModal: function() {
        this.setData({
            state: !1
        });
    },
    reduceNum: function() {
        1 != this.data.count && this.setData({
            count: this.data.count - 1
        });
    },
    addNum: function() {
        var a = this, t = this.data, i = t.count, n = t.animalData;
        parseInt(i) + 1 > n.count ? wx.showToast({
            title: "库存不足",
            icon: "none"
        }) : a.setData({
            count: parseInt(i) + 1
        });
    },
    chooseNum: function(a) {
        var t = this.data, i = (t.count, t.animalData);
        a.detail.value > i.count ? wx.showToast({
            title: "库存不足",
            icon: "none"
        }) : this.setData({
            count: a.detail.value
        });
    },
    goHome: function(a) {
        wx.reLaunch({
            url: "/kundian_farm/pages/HomePage/index/index?is_tarbar=true"
        });
    },
    doCall: function(a) {
        var t = a.currentTarget.dataset.phone;
        wx.makePhoneCall({
            phoneNumber: t
        });
    },
    sureAnimal: function(a) {
        var t = this.data, i = t.aid, n = t.animalData, e = t.count;
        wx.getStorageSync("kundian_farm_uid");
        parseInt(e) + 1 > n.count ? wx.showToast({
            title: "库存不足",
            icon: "none"
        }) : (wx.setStorageSync("kundian_farm_buy_animal", n), wx.navigateTo({
            url: "../confirmAdopt/index?count=" + e + "&aid=" + i
        }));
    },
    onShareAppMessage: function() {
        var a = this.data.animalData, t = wx.getStorageSync("kundian_farm_uid");
        return {
            path: "/kundian_farm/pages/shop/AdoptRules/index?aid=" + a.id + "&user_uid=" + t,
            success: function(a) {},
            title: a.animal_name,
            imageUrl: a.animal_src
        };
    },
    showVideo: function() {
        this.setData({
            isShow: !this.data.isShow
        });
    },
    hideVideo: function() {
        this.setData({
            isShow: !1
        });
    },
    play: function(a) {
        this.setData({
            is_loading: !1
        });
    }
});