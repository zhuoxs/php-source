var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp();

Page({
    data: {},
    calling: function(e) {
        wx.makePhoneCall({
            phoneNumber: e.target.dataset.mobile,
            success: function() {
                console.log("拨打电话成功！");
            },
            fail: function() {
                console.log("拨打电话失败！");
            }
        });
    },
    maping: function(e) {
        var a = this;
        wx.openLocation({
            latitude: parseFloat(a.data.branch.lat),
            longitude: parseFloat(a.data.branch.lng),
            scale: 18,
            name: a.data.branch.name,
            address: a.data.branch.address
        });
    },
    onLoad: function(e) {
        var a = this, t = wx.getStorageSync("param") || null, n = wx.getStorageSync("user") || null;
        a.setData({
            param: t,
            user: n
        }), null == n && wx.redirectTo({
            url: "../login/login"
        });
        var o = e.id;
        _request2.default.get("mybranch", {
            id: o,
            op: "details"
        }).then(function(e) {
            a.setData({
                branch: e.branch
            });
        }, function(e) {
            wx.showModal({
                title: "提示信息",
                content: e,
                showCancel: !1,
                success: function(e) {
                    e.confirm && wx.redirectTo({
                        url: "../my/my"
                    });
                }
            }), console.log(e);
        });
    },
    onReady: function() {
        app.util.footer(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        return {
            title: this.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: this.data.param.wxappshareimageurl
        };
    }
});