var _request = require("../../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

Page({
    data: {
        navTile: "订单详情",
        status: 1,
        all: [],
        info: {
            order_sn: "",
            remark: "",
            phone: "",
            userName: "",
            address: "",
            dis_amount: ""
        }
    },
    onLoad: function(e) {
        var t = this;
        wx.setNavigationBarTitle({
            title: t.data.navTile
        }), _request2.default.get("disOrderDetail", {
            dis_order_sn: e.sn
        }).then(function(e) {
            console.log(e), t.setData({
                all: e.goods,
                info: e.info,
                status: e.status
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
    toReceive: function(e) {
        _request2.default.post("receiveOrder", {
            dis_order_sn: this.data.info.order_sn
        }).then(function(e) {
            console.log(e), wx.navigateTo({
                url: "../dorder/dorder"
            });
        });
    },
    toSuccess: function(e) {
        this.setData({
            status: 3
        });
    },
    toDelete: function(e) {
        wx.showModal({
            title: "提示",
            content: "确定删除该订单吗？",
            success: function(e) {
                e.confirm;
            }
        });
    },
    toDialog: function(e) {
        wx.makePhoneCall({
            phoneNumber: this.data.info.phone
        });
    },
    toMap: function(e) {
        wx.openLocation({
            latitude: this.data.info.latitude,
            longitude: this.data.info.longitude,
            scale: 28
        });
    }
});