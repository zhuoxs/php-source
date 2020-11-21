var _extends = Object.assign || function(t) {
    for (var e = 1; e < arguments.length; e++) {
        var a = arguments[e];
        for (var i in a) Object.prototype.hasOwnProperty.call(a, i) && (t[i] = a[i]);
    }
    return t;
}, _reload = require("../../../common/js/reload.js"), _api = require("../../../common/js/api.js"), app = getApp();

Page(_extends({}, _reload.reload, {
    data: {
        toView: "",
        city: [],
        _city: ""
    },
    onLoad: function(t) {
        var a = this;
        wx.getSystemInfo({
            success: function(t) {
                var e = t.windowHeight * (750 / t.windowWidth);
                e = (e - 1040) / 2, a.setData({
                    height: e
                });
            }
        });
    },
    onShow: function() {
        this.onloadData();
    },
    onloadData: function(t) {
        var e = this;
        this.getUrl().then(function(t) {
            var e = {
                uid: wx.getStorageSync("userInfo").wxInfo.id,
                city_id: 0
            };
            return (0, _api.Getcity)(e);
        }).then(function(t) {
            console.log(t), e.setData({
                city: t.city,
                reccity: t.reccity,
                usercity: t.usercity
            });
        });
    },
    selectCity: function(t) {
        var e = getCurrentPages();
        e[e.length - 2].setData({
            _city: t.currentTarget.dataset.name,
            city_id: t.currentTarget.dataset.id
        });
        var a = {
            city_id: t.currentTarget.dataset.id,
            uid: wx.getStorageSync("userInfo").wxInfo.id
        };
        (0, _api.Choosecity)(a).then(function(t) {
            console.log(t);
        }), wx.navigateBack({
            delta: 1
        });
    },
    jump: function(t) {
        var e = t.currentTarget.dataset.src;
        this.setData({
            toView: e
        }), this.tips(e);
    }
}));