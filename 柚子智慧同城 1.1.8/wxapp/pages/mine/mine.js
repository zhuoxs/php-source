function n(n, e) {
    e || (e = 0);
    var t = 1e3 * (n - 0) + 864e5 * (e - 0), i = new Date(t);
    return i.getFullYear() + "-" + (i.getMonth() + 1 > 9 ? i.getMonth() + 1 : "0" + (i.getMonth() + 1)) + "-" + (i.getDate() > 9 ? i.getDate() : "0" + i.getDate());
}

var e = require("../../zhy/component/comFooter/dealfoot.js"), t = getApp();

t.Base({
    data: {
        vipBtn: "查看",
        mineBg: "/zhy/resource/images/mine/mine.png"
    },
    onLoad: function(n) {
        this._getData();
    },
    onShow: function() {
        var n = this;
        this.checkLogin(function(e) {
            n.setData({
                user: e
            }), n.onLoadData(e);
        }, "/pages/mine/mine", !0);
    },
    onLoadData: function(e) {
        var i = this, a = new Date().getTime() / 1e3, o = null, r = null;
        e.vip_endtime && a <= e.vip_endtime ? (o = "有效期至：" + n(e.vip_endtime), r = "查看") : e.vip_endtime && a > e.vip_endtime ? (o = "已过期", 
        r = "去续费") : (o = "未开通", r = "去开通"), Promise.all([ t.api.apiStoreGetMyStore({
            user_id: e.id
        }), t.api.apiStoreCheckStoreUserPermission({
            user_id: e.id
        }), t.api.apiDistributionIsDistributionpromoter({
            user_id: e.id
        }), t.api.apiDistributionGetDistributionset(), t.api.apiUserMyInfo({
            user_id: e.id
        }) ]).then(function(n) {
            i.setData({
                vipStatus: o,
                vipBtn: r,
                shop: n[0].data,
                auth: n[1].data,
                distribution: n[2].data,
                mes: n[3].data,
                likenum: n[4].data,
                show: !0
            });
        }).catch(function(n) {
            t.tips(n.msg);
        });
    },
    toggleShare: function() {
        this.setData({
            share: !this.data.share
        });
    },
    onShareAppMessage: function(n) {
        return {
            title: "我的",
            path: "/pages/mine/mine"
        };
    },
    onMemberTap: function() {
        t.navTo("/pages/member/member");
    },
    onApplyTap: function() {
        t.navTo("/base/apply/apply");
    },
    onCollectTap: function() {
        t.navTo("/base/mycollect/mycollect");
    },
    onBindPhone: function() {
        t.navTo("/base/bindphone/bindphone");
    },
    onAdminTap: function() {
        t.navTo("/base/admin/admin");
    },
    onMyGoodsOrderTap: function() {
        t.navTo("/base/mygoodsorder/mygoodsorder");
    },
    onMyReserveOrderTap: function() {
        t.navTo("/base/myreserveorder/myreserveorder");
    },
    onMyreleaseTap: function() {
        t.navTo("/base/myrelease/myrelease");
    },
    onMycouponsTap: function() {
        t.navTo("/base/mycoupons/mycoupons");
    },
    onMyPanicOrderTap: function() {
        t.navTo("/plugin/panic/mypanicorder/mypanicorder");
    },
    onDistributionTap: function() {
        t.navTo("/plugin/distribution/distributioncenter/distributioncenter");
    },
    onIntegralshopTap: function() {
        t.navTo("/pages/integral/integral");
    },
    onIntegralorderTap: function() {
        t.navTo("/base/integralorder/integralorder");
    },
    onApplictionTap: function() {
        var n = this.data.mes;
        1 == n.distribution_condition || 2 == n.distribution_condition || 5 == n.distribution_condition ? t.navTo("/plugin/distribution/memberapplicationtxt/memberapplicationtxt") : t.tips("不符合申请条件！");
    },
    onSpellOrderTap: function() {
        t.navTo("/plugin/spell/myorder/myorder");
    },
    onFreeTap: function() {
        t.navTo("/plugin/free/myorder/myorder");
    },
    onBalanceTap: function() {
        t.navTo("/base/mybalance/mybalance");
    },
    onIntegralTap: function() {
        t.navTo("/base/myintegral/myintegral");
    },
    _getData: function() {
        var n = this;
        Promise.all([ t.api.apiIndexSystemSet(), t.api.apiIndexNavIcon() ]).then(function(t) {
            var i = e.dealFootNav(t[1].data, t[1].other.img_root), a = {
                config: t[0].data,
                nav: i
            };
            wx.setStorageSync("setting", a), n.setData({
                mineBg: t[0].data.mine_bg ? t[0].other.img_root + t[0].data.mine_bg : n.data.mineBg
            });
        }).catch(function(n) {
            console.log(n), t.tips(n.msg);
        });
    }
});