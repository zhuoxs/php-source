var _request = require("../../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

Page({
    data: {
        navTile: "更多分店",
        key: ""
    },
    onLoad: function(e) {
        var n = this;
        wx.setNavigationBarTitle({
            title: n.data.navTile
        }), _request2.default.get("getStoreList").then(function(e) {
            console.log(e);
            var t = wx.getStorageSync("storeId");
            n.setData({
                branch: e,
                currstore: t
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
    chooseNav: function(e) {
        var t = e.currentTarget.dataset.index;
        this.setData({
            curInde: t
        }), wx.setStorageSync("storeId", this.data.branch[t].id), wx.setStorageSync("storeName", this.data.branch[t].name), 
        wx.reLaunch({
            url: "../index"
        });
    },
    dialog: function(e) {
        var t = e.currentTarget.dataset.phone;
        wx.makePhoneCall({
            phoneNumber: t
        });
    },
    search: function(e) {
        var t = this;
        console.log({
            key: e.detail.value
        }), _request2.default.post("getStoreList", {
            key: e.detail.value.trim()
        }).then(function(e) {
            console.log(e), t.setData({
                branch: e
            });
        });
    }
});