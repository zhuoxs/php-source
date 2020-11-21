var _request = require("../../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var WxParse = require("../../wxParse/wxParse.js");

Page({
    data: {
        navTile: "关于我们"
    },
    onLoad: function(e) {
        var n = this;
        wx.setNavigationBarTitle({
            title: n.data.navTile
        }), _request2.default.get("getStoreDetail", {
            store_id: wx.getStorageSync("storeId")
        }).then(function(e) {
            console.log(e), n.setData({
                aboutsrc: e.main_image,
                desc: e.content,
                phoneNum: e.phone,
                email: e.email,
                addr: e.address
            });
            var t = n.data.desc;
            WxParse.wxParse("desc", "html", t, n, 0);
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    toDialog: function(e) {
        wx.makePhoneCall({
            phoneNumber: this.data.phoneNum
        });
    }
});