var _request = require("../../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

Page({
    data: {
        navTile: "订单",
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
                active: !1
            }, {
                pagePath: "/yzbld_sun/pages/user/dorder/dorder",
                text: "订单",
                iconPath: "/style/images/ps3.png",
                selectedIconPath: "/style/images/ps4.png",
                selectedColor: "#ef8200",
                active: !0
            } ],
            position: "bottom"
        },
        curIndex: 0,
        nav: [ "配送中", "已完成", "财务" ],
        billList: [ {
            ordernum: "12323432423",
            money: "-30",
            time: "2018-05-05"
        }, {
            ordernum: "12323432423",
            money: "-30",
            time: "2018-05-05",
            state: 0
        }, {
            ordernum: "123243243",
            money: "+30",
            time: "2018-05-05"
        } ],
        multiArray: [ [ "2018", "2019" ], [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12" ] ],
        multiIndex: [ 0, 0 ],
        oldMultiIndex: [],
        amount: 999,
        pageIndex: 1,
        money: "0.00",
        all: [],
        current: [],
        month: ""
    },
    onLoad: function(t) {
        var e = this;
        wx.setNavigationBarTitle({
            title: e.data.navTile
        });
        var a = new Date(), n = a.getFullYear(), r = a.getMonth(), o = e.data.multiArray, i = e.data.multiIndex;
        if (o[0][0] < n) {
            for (var s = n - o[0][0], u = 0; u < s; u++) o[0].push(parseInt(o[0][0]) + u + 1);
            i[0] = o.length;
        }
        i[1] = r, e.setData({
            multiArray: o,
            multiIndex: i,
            oldMultiIndex: i
        });
        var d = parseInt(t.index || 0);
        console.log("index:" + d), _request2.default.get("getDisOrderList").then(function(t) {
            console.log(t), e.setData({
                all: t.orderList,
                money: t.dis_amount,
                billList: t.amount_log,
                month: t.month,
                amount: t.month_amount
            }), 2 == d ? e.setData({
                curIndex: d
            }) : e.switchTab(d);
        });
    },
    switchTab: function(t) {
        for (var e = this.data.all, a = [ 20, 30 ][t], n = [], r = 0; r < e.length; ++r) e[r].status == a && n.push(e[r]);
        this.setData({
            current: n,
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
    toCash: function(t) {
        wx.navigateTo({
            url: "/yzbld_sun/pages/user/cash/cash"
        });
    },
    bindMultiPickerColumnChange: function(t) {
        var e = {
            multiArray: this.data.multiArray,
            multiIndex: this.data.multiIndex
        };
        e.multiIndex[t.detail.column] = t.detail.value, e.time = this.data.multiArray[0][this.data.multiIndex[0]] + " " + this.data.multiArray[1][this.data.multiIndex[1]], 
        this.setData(e);
    },
    dataChange: function(t) {
        var e = this.data.multiIndex, a = this;
        this.setData({
            oldMultiIndex: e
        });
        var n = this.data.multiArray[0][e[0]], r = this.data.multiArray[1][e[1]];
        _request2.default.get("getDisMonthSummary", {
            year: n,
            month: r
        }).then(function(t) {
            console.log(t), a.setData({
                amount: t.amount
            });
        });
    },
    dataCancel: function(t) {
        console.log("aaaaa" + this.data.oldMultiIndex), this.setData({
            multiIndex: this.data.oldMultiIndex
        });
    },
    bargainTap: function(t) {
        var e = parseInt(t.currentTarget.dataset.index);
        e != this.data.curIndex && this.switchTab(e);
    },
    toDorderdet: function(t) {
        var e = t.currentTarget.dataset.sn;
        wx.navigateTo({
            url: "../dorderdet/dorderdet?sn=" + e
        });
    },
    toDelete: function(t) {
        var e = t.currentTarget.dataset.sn;
        _request2.default.post("disOrderDelete", {
            dis_order_sn: e
        }).then(function(t) {
            console.log(t), wx.redirectTo({
                url: "../dorder/dorder?index=1"
            });
        });
    },
    toFinish: function(t) {
        t.currentTarget.dataset.sn;
        wx.scanCode({
            scanType: "barCode",
            success: function(t) {
                console.log(t);
                var e = t.result;
                _request2.default.get("getOrderSnFromVerifySn", {
                    verify_sn: e,
                    admin: 0
                }).then(function(t) {
                    console.log(t);
                    var e = t.order_sn;
                    wx.navigateTo({
                        url: "../../backstage/writeoff/writeoff?sn=" + e + "&dis=1"
                    });
                });
            }
        });
    }
});