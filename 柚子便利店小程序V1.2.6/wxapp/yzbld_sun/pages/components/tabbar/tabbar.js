var _request = require("../../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp();

Component({
    properties: {
        cartCount: {
            type: Number,
            value: 0,
            observer: function(e, t) {}
        }
    },
    data: {
        isIpx: app.globalData.isIpx,
        chooseNav: 0,
        isCart: ""
    },
    attached: function() {
        var e = wx.getStorageSync("bottom_tab") || null;
        if (null == e) this.getBottomTab(!0); else {
            this.setBottomTab(e.data);
            var t = parseInt(Date.parse(new Date()) / 1e3);
            parseInt(e.expried) < t && this.getBottomTab(!1);
        }
    },
    methods: {
        getCurrentPageUrl: function() {
            var e = getCurrentPages();
            return e[e.length - 1].route;
        },
        getTab: function() {
            this.updateData([ {
                pagePath: "/yzbld_sun/pages/index/index",
                text: "首页",
                iconPath: "/style/images/index.png",
                selectedIconPath: "/style/images/indexSelect.png",
                selectedColor: "#f5ac32",
                active: !0
            }, {
                pagePath: "/yzbld_sun/pages/classify/classify",
                text: "分类",
                iconPath: "/style/images/cata.png",
                selectedIconPath: "/style/images/cataSelect.png",
                selectedColor: "#f5ac32",
                active: !1
            }, {
                pagePath: "/yzbld_sun/pages/carts/carts",
                text: "购物车",
                iconPath: "/style/images/carts.png",
                selectedIconPath: "/style/images/cartsSelect.png",
                selectedColor: "#f5ac32",
                active: !1
            }, {
                pagePath: "/yzbld_sun/pages/user/user",
                text: "我的",
                iconPath: "/style/images/user.png",
                selectedIconPath: "/style/images/userSelect.png",
                selectedColor: "#f5ac32",
                active: !1
            } ]);
        },
        updateData: function(e) {
            for (var t = 0, a = "/" + this.getCurrentPageUrl(), s = 0; s < e.length; ++s) if (a == e[s].pagePath) {
                t = s;
                break;
            }
            this.setData({
                tabBar: e,
                chooseNav: t,
                isCart: "/yzbld_sun/pages/carts/carts" == a
            });
        },
        getBottomTab: function(n) {
            var r = this;
            _request2.default.get("getBottomTab").then(function(e) {
                if (console.log("getBottomTab"), console.log(e), 0 < e.length) for (var t = 0; t < e.length; ++t) e[t].pagePath = "/yzbld_sun/pages/" + e[t].pagePath;
                n && r.setBottomTab(e);
                var a = parseInt(Date.parse(new Date()) / 1e3), s = {};
                s.data = e, s.expried = a + 60, wx.setStorage({
                    key: "bottom_tab",
                    data: s
                });
            });
        },
        setBottomTab: function(e) {
            0 < e.length ? this.updateData(e) : this.getTab();
        },
        tabChange: function(e) {
            var t = e.currentTarget.dataset.index;
            wx.reLaunch({
                url: this.data.tabBar[t].pagePath
            });
        }
    }
});