var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request), _cart = require("../../util/cart.js"), _cart2 = _interopRequireDefault(_cart);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var wxbarcode = require("../../../style/utils/index.js");

Page({
    data: {
        navTile: "我的",
        bguser: "../../../style/images/bguser.png",
        is_distribution: !1,
        is_admin: 0,
        showCode: !1,
        cartCount: _cart2.default.getAllNum()
    },
    onLoad: function(o) {
        var n = this;
        wx.setNavigationBarTitle({
            title: n.data.navTile
        }), wx.getUserInfo({
            success: function(e) {
                n.setData({
                    thumb: e.userInfo.avatarUrl,
                    nickname: e.userInfo.nickName
                });
            }
        }), _request2.default.get("getWe", {
            store_id: wx.getStorageSync("storeId")
        }).then(function(e) {
            n.setData({
                shopName: wx.getStorageSync("storeName"),
                umoney: e.umoney,
                couponCount: e.couponCount,
                is_distribution: e.is_distribution,
                is_admin: e.is_admin
            });
            var t = o.redirect || "";
            "order" != t ? "" == t || wx.navigateTo({
                url: "myorderdet/myorderdet?sn=" + t
            }) : wx.navigateTo({
                url: "myorder/myorder"
            });
        }), wxbarcode.qrcode("qrcode", "1111111111", 500, 500);
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    toOrder: function(e) {
        wx.navigateTo({
            url: "myorder/myorder"
        });
    },
    toOrderStatus10: function(e) {
        wx.navigateTo({
            url: "myorder/myorder?index=1"
        });
    },
    toOrderStatus20: function(e) {
        wx.navigateTo({
            url: "myorder/myorder?index=2"
        });
    },
    toOrderStatus40: function(e) {
        wx.navigateTo({
            url: "myorder/myorder?index=3"
        });
    },
    toAddress: function(e) {
        wx.chooseAddress ? wx.chooseAddress({
            success: function(e) {
                console.log(JSON.stringify(e));
            },
            fail: function(e) {
                console.log(JSON.stringify(e));
            }
        }) : console.log("当前微信版本不支持chooseAddress");
    },
    toCards: function(e) {
        wx.navigateTo({
            url: "cards/cards"
        });
    },
    toShop: function(e) {
        wx.navigateTo({
            url: "shop/shop"
        });
    },
    toContact: function(e) {
        wx.navigateTo({
            url: "contact/contact"
        });
    },
    toDistribute: function(e) {
        wx.navigateTo({
            url: "distribute/distribute"
        });
    },
    toRecharge: function(e) {
        wx.navigateTo({
            url: "recharge/recharge"
        });
    },
    toBackstage: function(e) {
        wx.navigateTo({
            url: "../backstage/index/index"
        });
    },
    showModel: function(e) {
        this.setData({
            showCode: !this.data.showCode
        });
    }
});