/*www.lanrenzhijia.com   time:2019-06-01 22:11:49*/
function a(a, t, e) {
    return t in a ? Object.defineProperty(a, t, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = e, a
}
var t = getApp();
t.Base({
    data: {
        nav: [{
            title: "全部",
            type: 0
        }, {
            title: "待支付",
            type: 1
        }, {
            title: "待使用/待发货",
            type: 2
        }, {
            title: "待收货",
            type: 6
        }, {
            title: "待评价",
            type: 3
        }, {
            title: "已完成",
            type: 4
        }, {
            title: "售后/退款",
            type: 5
        }],
        type: 0
    },
    onLoad: function(a) {
        this.data.reload = !0
    },
    onShow: function() {
        var a = this;
        this.data.reload && this.checkLogin(function(t) {
            a.setData({
                user: t
            }), a.onLoadData()
        }, "/plugin/panic/mypanicorder/mypanicorder")
    },
    onLoadData: function() {
        this.data.reload = !1, this.setData({
            list: {
                load: !1,
                over: !1,
                page: 1,
                length: 10,
                none: !1,
                data: []
            }
        }), this.loadListData()
    },
    loadListData: function() {
        var e = this;
        if (!this.data.list.over) {
            this.setData(a({}, "list.load", !0));
            var d = {
                user_id: this.data.user.id,
                page: this.data.list.page,
                length: this.data.list.length,
                type: this.data.type
            };
            t.api.apiPanicOrderList(d).then(function(a) {
                e.data.show || e.setData({
                    show: !0,
                    imgRoot: a.other.img_root
                });
                for (var t in a.data) switch (a.data[t].btnFlagA = 0, a.data[t].btnFlagNameA = "", a.data[t].btnFlagNameB = "查看详情", a.data[t].order_status - 0) {
                    case 5:
                        a.data[t].flag = 1, a.data[t].flagName = "订单已取消";
                        break;
                    case 10:
                        a.data[t].flag = 2, a.data[t].flagName = "待支付", a.data[t].btnFlagA = 1, a.data[t].btnFlagNameA = "取消订单", a.data[t].btnFlagNameB = "继续支付";
                        break;
                    case 20:
                        0 == a.data[t].after_sale ? (1 == a.data[t].panic.is_support_refund && (4 == a.data[t].refund_status ? (a.data[t].btnFlagA = 6, a.data[t].btnFlagNameA = "拒绝退款") : (a.data[t].btnFlagA = 2, a.data[t].btnFlagNameA = "申请退款")), 1 == a.data[t].sincetype ? (a.data[t].flag = 31, a.data[t].flagName = "待核销", a.data[t].btnFlagNameB = "去核销") : 2 == a.data[t].sincetype ? (a.data[t].flag = 32, a.data[t].flagName = "待发货") : 3 == a.data[t].sincetype && (a.data[t].flag = 33, a.data[t].flagName = "待送货")) : 1 == a.data[t].after_sale ? (a.data[t].btnFlagA = 3, a.data[t].btnFlagNameA = "等待退款处理", a.data[t].flag = 34, a.data[t].flagName = "申请退款中") : 2 == a.data[t].after_sale && (1 == a.data[t].refund_status ? (a.data[t].btnFlagA = 4, a.data[t].btnFlagNameA = "售后退款中", a.data[t].btnFlagNameB = "查看详情", a.data[t].flag = 35, a.data[t].flagName = "退款中") : 2 == a.data[t].refund_status ? (a.data[t].flag = 36, a.data[t].flagName = "退款成功") : 3 == a.data[t].refund_status ? (a.data[t].flag = 37, a.data[t].flagName = "退款失败", a.data[t].btnFlagA = 5, a.data[t].btnFlagNameA = "申请退款") : 4 == a.data[t].refund_status && (a.data[t].flag = 38, a.data[t].flagName = "退款失败", a.data[t].btnFlagA = 6, a.data[t].btnFlagNameA = "拒绝退款"));
                        break;
                    case 30:
                        0 == a.data[t].after_sale ? (a.data[t].flag = 32, a.data[t].flagName = "待收货", 1 == a.data[t].panic.is_support_refund && (4 == a.data[t].refund_status ? a.data[t].flagName = "待收货（已拒绝退款）" : a.data[t].btnFlagNameB = "确认收货"), a.data[t].btnFlagNameB = "确认收货") : 1 == a.data[t].after_sale ? (a.data[t].btnFlagA = 3, a.data[t].btnFlagNameA = "等待退款处理", a.data[t].flag = 34, a.data[t].flagName = "申请退款中") : 2 == a.data[t].after_sale && (1 == a.data[t].refund_status ? (a.data[t].btnFlagA = 4, a.data[t].btnFlagNameA = "售后退款中", a.data[t].btnFlagNameB = "查看详情", a.data[t].flag = 35, a.data[t].flagName = "退款中") : 2 == a.data[t].refund_status ? (a.data[t].flag = 36, a.data[t].flagName = "退款成功") : 3 == a.data[t].refund_status ? (a.data[t].flag = 37, a.data[t].flagName = "退款失败", a.data[t].btnFlagA = 5, a.data[t].btnFlagNameA = "申请退款") : 4 == a.data[t].refund_status && (a.data[t].flag = 38, a.data[t].flagName = "退款失败", a.data[t].btnFlagA = 6, a.data[t].btnFlagNameA = "拒绝退款"));
                        break;
                    case 40:
                        a.data[t].btnFlagA = 6, a.data[t].btnFlagNameA = "去评价", a.data[t].btnFlagNameB = "查看详情", a.data[t].flag = 4, a.data[t].flagName = "待评价";
                        break;
                    case 60:
                        a.data[t].btnFlagNameB = "查看详情", a.data[t].flag = 5, a.data[t].flagName = "已完成";
                        break;
                    default:
                        a.data[t].btnFlagNameB = "未知", a.data[t].flag = -1, a.data[t].flagName = "未知"
                }
                e.dealList(a.data, e.data.list.page)
            }).
            catch (function(a) {
                t.tips(a.msg)
            })
        }
    },
    onReachBottom: function() {
        this.loadListData()
    },
    onTypeTap: function(a) {
        var t = a.currentTarget.dataset.type;
        this.setData({
            type: t,
            list: {
                load: !1,
                over: !1,
                page: 1,
                length: 10,
                none: !1,
                data: []
            }
        }), this.loadListData()
    },
    onPanicOrderTap: function(a) {
        var e = a.currentTarget.dataset.idx,
            d = this.data.list.data[e].id;
        t.navTo("/plugin/panic/panicorderinfo/panicorderinfo?page=0&oid=" + d)
    },
    onBtnAtap: function(a) {
        var e = a.currentTarget.dataset.idx,
            d = this.data.list.data[e].id;
        40 == this.data.list.data[e].order_status ? t.navTo("/base/comment/comment?page=0&id=" + d) : t.navTo("/plugin/panic/panicorderinfo/panicorderinfo?page=0&oid=" + d)
    }
});