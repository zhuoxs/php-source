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
    onLoad: function(e) {
        var t = this, n = wx.getStorageSync("param") || null, a = wx.getStorageSync("user") || null;
        t.setData({
            param: n,
            user: a
        }), null == a && wx.redirectTo({
            url: "../login/login"
        });
        var o = e.id;
        _request2.default.get("mybranch", {
            op: "buser",
            id: o
        }).then(function(e) {
            t.setData({
                buser: e.buser,
                branch: e.branch,
                leader: e.leader
            });
        }, function(e) {
            wx.showModal({
                title: "提示信息",
                content: e,
                showCancel: !1,
                success: function(e) {
                    e.confirm && wx.redirectTo({
                        url: "../login/login"
                    });
                }
            });
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