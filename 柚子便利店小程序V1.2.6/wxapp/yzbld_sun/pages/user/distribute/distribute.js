var _request = require("../../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

Page({
    data: {
        navTile: "社区配送员",
        tabBar: {
            color: "#9E9E9E",
            selectedColor: "#f00",
            backgroundColor: "#fff",
            borderStyle: "#ccc",
            list: [ {
                pagePath: "/yzbld_sun/pages/user/distribute/distribute",
                text: "配送",
                iconPath: "/style/images/ps1.png",
                selectedIconPath: "/style/images/ps2.png",
                selectedColor: "#ef8200",
                active: !0
            }, {
                pagePath: "/yzbld_sun/pages/user/dorder/dorder",
                text: "订单",
                iconPath: "/style/images/ps3.png",
                selectedIconPath: "/style/images/ps4.png",
                selectedColor: "#ef8200",
                active: !1
            } ],
            position: "bottom"
        },
        chooseItem: [ {
            types: "距离最近"
        }, {
            types: "最新发布"
        }, {
            types: "价格最高"
        } ],
        curIndex: 0,
        show: !1,
        list: []
    },
    onLoad: function(t) {
        var n = this;
        function s(t, e) {
            return t.distance > e.distance;
        }
        wx.setNavigationBarTitle({
            title: n.data.navTile
        }), _request2.default.get("getDisList").then(function(t) {
            console.log(t);
            var e = t.disList;
            e.sort(s), n.setData({
                banner: t.banner,
                list: e
            });
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    showChoose: function(t) {
        this.setData({
            show: !this.data.show
        });
    },
    choseType: function(t) {
        var e = t.currentTarget.dataset.index, n = this.data.list;
        0 == e ? n.sort(function(t, e) {
            return t.distance > e.distance;
        }) : 1 == e ? n.sort(function(t, e) {
            return t.time < e.time;
        }) : n.sort(function(t, e) {
            return t.price > e.price;
        }), this.setData({
            curIndex: e,
            show: !this.data.show,
            list: n
        });
    },
    toRedirect: function(t) {
        var e = t.currentTarget.dataset.action;
        -1 == e.indexOf("/") || wx.navigateTo({
            url: "/yzbld_sun/pages/" + e
        });
    },
    toDorderdet: function(t) {
        var e = t.currentTarget.dataset.sn;
        wx.navigateTo({
            url: "../dorderdet/dorderdet?sn=" + e
        });
    }
});