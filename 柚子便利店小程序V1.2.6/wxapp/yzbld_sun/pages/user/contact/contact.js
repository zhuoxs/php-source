var _request = require("../../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

Page({
    data: {
        navTile: "联系客服",
        diaName: "客服"
    },
    onLoad: function(e) {
        var t = this;
        wx.setNavigationBarTitle({
            title: t.data.navTile
        }), _request2.default.get("getStoreDetail", {
            store_id: wx.getStorageSync("storeId")
        }).then(function(e) {
            console.log(e), t.setData({
                phone: e.phone
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
    dialog: function(e) {
        wx.makePhoneCall({
            phoneNumber: this.data.phone
        });
    }
});