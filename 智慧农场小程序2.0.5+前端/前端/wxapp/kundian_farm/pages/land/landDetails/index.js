var a = require("../../../../wxParse/wxParse.js"), t = new getApp(), e = t.siteInfo.uniacid;

Page({
    data: {
        selectLandSpec: [],
        isReturn: !1,
        isShow: !0,
        seedData: [],
        landSpec: [],
        landLimit: [],
        total_price: 0,
        farmSetData: wx.getStorageSync("kundian_farm_setData"),
        icon: [],
        is_loading: !0,
        uid: "",
        scrollShow: !1,
        src_xy: [],
        land_num: ""
    },
    onLoad: function(i) {
        var n = this, s = i.lid, l = wx.getStorageSync("kundian_farm_uid");
        wx.showLoading({
            title: "玩命加载中..."
        });
        var d = i.user_uid;
        t.loginBindParent(d, l), t.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "getLandDetail",
                uniacid: e,
                lid: s,
                control: "land"
            },
            success: function(e) {
                var i = 0;
                t.globalData.sysData.model.indexOf("iPhone X") > -1 && (i = 68);
                var s = e.data, d = s.landDetail, o = s.seedData, c = s.landSpec, r = s.landLimit, u = s.icon, h = d.live_src, p = [];
                h && (p = h.split(":")), n.setData({
                    landDetail: d,
                    seedData: o,
                    landSpec: c,
                    landLimit: r,
                    bottom: i,
                    icon: u,
                    uid: l,
                    src_xy: p
                }), e.data.landDetail.land_desc && a.wxParse("article", "html", e.data.landDetail.land_desc, n, 5), 
                wx.hideLoading();
            }
        }), t.util.setNavColor(e);
    },
    selectArea: function(a) {
        var t = this, e = a.currentTarget.dataset.areaid;
        this.data.landSpec.map(function(a) {
            e == a.id && t.setData({
                selectLandSpec: a
            });
        });
    },
    onPageScroll: function(a) {
        var t = !1;
        a.scrollTop > 200 && (t = !0), this.setData({
            isReturn: t
        });
        a.scrollTop >= 350 ? this.data.scrollShow || this.setData({
            scrollShow: !0
        }) : this.data.scrollShow && this.setData({
            scrollShow: !1
        });
    },
    returnTop: function() {
        wx.pageScrollTo({
            scrollTop: 0,
            duration: 300
        });
    },
    showVideo: function() {
        this.setData({
            isShow: !0
        });
    },
    hideVideo: function() {
        this.setData({
            isShow: !this.data.isShow
        });
    },
    select: function(a) {
        var t = a.currentTarget.dataset.id, e = this.data, i = e.landSpec, n = e.land_num;
        i.map(function(a) {
            if (a.id === t) {
                var e = a.select;
                a.select = !e, n = a.land_num;
            } else a.select = !1;
        }), this.setData({
            landSpec: i,
            land_num: n
        }), this.getTotalPrice();
    },
    getTotalPrice: function(a) {
        var t = this.data, e = t.landSpec, i = t.landLimit, n = 0;
        e.map(function(a) {
            a.select && (n = parseFloat(n) + a.price * i.day);
        }), this.setData({
            total_price: n.toFixed(2)
        });
    },
    toPay: function(a) {
        var t = this.data, e = t.landDetail, i = t.landSpec, n = [];
        if (wx.getStorageSync("kundian_farm_uid")) {
            if (i.map(function(a) {
                a.select && n.push(a);
            }), !(n.length > 0)) return wx.showModal({
                title: "提示",
                content: "请选择土地面积",
                showCancel: !1
            }), !1;
            wx.setStorageSync("selectSpec", n), wx.navigateTo({
                url: "../payFor/index?land_id=" + e.id + "&land_method=2"
            });
        } else wx.navigateTo({
            url: "../../login/index"
        });
    },
    intoSeedDetail: function(a) {
        var t = a.currentTarget.dataset.sid;
        wx.navigateTo({
            url: "../seedDetails/index?sid=" + t
        });
    },
    waiting: function(a) {},
    play: function(a) {
        this.setData({
            is_loading: !1
        });
    },
    onShow: function(a) {
        this.setData({
            is_loading: !0
        });
    },
    getAuthUserInfo: function(a) {
        var e = this;
        t.getAuthUserInfo(a).then(function(a) {
            e.setData({
                uid: a
            }), e.toPay();
        }).then(function() {});
    },
    onShareAppMessage: function(a) {
        var t = this.data.landDetail, e = wx.getStorageSync("kundian_farm_uid"), i = "/kundian_farm/pages/land/landDetails/index?lid=" + t.id;
        return e && (i = "/kundian_farm/pages/land/landDetails/index?user_uid=" + e + "&lid=" + t.id), 
        {
            path: i,
            success: function(a) {},
            title: "实时监控"
        };
    }
});