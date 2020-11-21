var e = require("../../../../utils/base.js"), t = require("../../../../../wxParse/wxParse.js"), a = require("../../../../../api.js"), r = new e.Base();

Page({
    data: {},
    onLoad: function(e) {
        console.log(e), this.setData({
            dataType: e.type
        }), "notice" == e.type ? (this.getShareData(), wx.setNavigationBarTitle({
            title: "用户须知"
        })) : (this.getAgree(), wx.setNavigationBarTitle({
            title: "推广代理协议"
        }));
    },
    getShareData: function() {
        var e = this, i = {
            url: a.default.share_data,
            method: "GET"
        };
        r.getData(i, function(a) {
            if (console.log(a), 1 == a.errorCode) {
                var r = a.data.notice;
                e.setData({
                    shareData: r
                }), r && t.wxParse("notice", "html", r, e);
            }
        });
    },
    getAgree: function(e) {
        var a = wx.getStorageSync("userData").user_info.agree;
        a && t.wxParse("agree", "html", a, this);
    }
});