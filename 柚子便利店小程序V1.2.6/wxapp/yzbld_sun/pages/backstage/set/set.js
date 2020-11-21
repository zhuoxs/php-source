var _request = require("../../../util/request"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

Page({
    data: {
        sets: [ {
            sets: "shop",
            status: !0
        }, {
            sets: "order",
            status: !0
        } ],
        showCode: !1,
        tabBar: {
            list: [ {
                pagePath: "/yzbld_sun/pages/backstage/index/index",
                text: "工作台",
                iconPath: "../../../../style/images/tab4.png",
                selectedIconPath: "../../../../style/images/tab3.png",
                selectedColor: "#ef8200",
                active: !1
            }, {
                pagePath: "/yzbld_sun/pages/backstage/set/set",
                text: "订单",
                iconPath: "../../../../style/images/tab2.png",
                selectedIconPath: "../../../../style/images/ps4.png",
                selectedColor: "#ef8200",
                active: !0
            } ]
        },
        curIndex: 0,
        nav: [ {
            name: "待配送",
            state: 10
        }, {
            name: "已完成",
            state: 40
        } ],
        all: [ {
            id: "12",
            store_id: "2",
            sn: "20020181012180559",
            status: "20",
            pay_amount: "13.00",
            created_at: "10-12 18:05",
            goods: [ {
                goods_name: "恒大矿泉水",
                goods_price: "1.00",
                buy_type: "0",
                num: "3",
                goods_img: "http://placeimg.com/800/800/any/5345235"
            } ],
            distribution_amount: 5,
            distance: 5.23,
            address: "地址",
            nums: 1
        } ],
        current: [],
        selectIndex: 0,
        distribution_amount: 0
    },
    onLoad: function(t) {
        var e = this, a = parseInt(t.index || 0);
        _request2.default.get("getStoreOrderList").then(function(t) {
            console.log(t), e.setData({
                all: t
            }), 2 == a ? e.setData({
                curIndex: a
            }) : e.switchTab(a);
        });
    },
    switchTab: function(t) {
        for (var e = this.data.all, a = [], s = 0; s < e.length; ++s) 0 == t ? 20 != e[s].status && 60 != e[s].status || a.push(e[s]) : 40 == e[s].status && a.push(e[s]);
        this.setData({
            current: a,
            curIndex: t
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    toIndex: function(t) {
        wx.redirectTo({
            url: "../index/index"
        });
    },
    toMessage: function(t) {
        wx.redirectTo({
            url: "../message/message"
        });
    },
    toDelete: function(t) {},
    bargainTap: function(t) {
        var e = parseInt(t.currentTarget.dataset.index);
        e != this.data.curIndex && this.switchTab(e);
    },
    showModel: function(t) {
        if (this.data.showCode) this.setData({
            showCode: !this.data.showCode
        }); else {
            var e = parseInt(t.currentTarget.dataset.index), a = this.data.current[e].distribution_amount;
            this.setData({
                selectIndex: e,
                distribution_amount: a,
                showCode: !this.data.showCode
            });
        }
    },
    reduceAmount: function(t) {
        var e = this.data.distribution_amount;
        e <= 1 || this.setData({
            distribution_amount: --e
        });
    },
    addAmount: function(t) {
        var e = this.data.distribution_amount;
        this.setData({
            distribution_amount: ++e
        });
    },
    formSubmit: function(t) {
        var s = this, n = this.data.current, i = n[this.data.selectIndex].sn;
        n[this.data.selectIndex].distribution_amount = this.data.distribution_amount, n[this.data.selectIndex].status = 60;
        var e = {};
        e.sn = i, e.dis_amount = this.data.distribution_amount, _request2.default.post("postDisOrder", e).then(function(t) {
            console.log(t);
            for (var e = s.data.all, a = 0; a < e.length; ++a) if (e[a].sn == i) {
                e[a].distribution_amount = s.data.distribution_amount, e[a].status = 60;
                break;
            }
            s.setData({
                showCode: !1,
                current: n,
                all: e
            });
        });
    }
});