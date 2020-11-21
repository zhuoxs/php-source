var _extends = Object.assign || function(t) {
    for (var e = 1; e < arguments.length; e++) {
        var a = arguments[e];
        for (var i in a) Object.prototype.hasOwnProperty.call(a, i) && (t[i] = a[i]);
    }
    return t;
}, _reload = require("../../common/js/reload.js"), _api = require("../../common/js/api.js"), app = getApp();

function timestampToTime(t) {
    var e = new Date(1e3 * t);
    return e.getFullYear() + "-" + ((e.getMonth() + 1 < 10 ? "0" + (e.getMonth() + 1) : e.getMonth() + 1) + "-") + e.getDate();
}

Page(_extends({}, _reload.reload, {
    data: {
        imgLink: wx.getStorageSync("url"),
        types: 1,
        currentStatus: 0,
        statusType: [ "待使用", "已过期" ],
        youhuiList: [ {
            num: 100,
            duration: "2018 - 3 - 10至2018-10 - 31",
            tiaojian: 500
        }, {
            num: 50,
            duration: "2018 - 3 - 10至2018-10 - 31",
            tiaojian: 500
        } ]
    },
    onLoad: function(t) {
        this.setData({
            ctype: t.ctype
        });
    },
    onloadData: function(t) {
        var e = this;
        t.detail.login && (this.setData({
            show: !0
        }), this.checkUrl().then(function(t) {
            1 == e.data.ctype ? wx.setNavigationBarTitle({
                title: "我的租车券"
            }) : wx.setNavigationBarTitle({
                title: "我的优惠券"
            }), e.getList();
        }).catch(function(t) {
            -1 === t.code ? e.tips(t.msg) : e.tips("false");
        }));
    },
    statusTap: function(t) {
        this.setData({
            currentStatus: t.currentTarget.dataset.index,
            types: t.currentTarget.dataset.index + 1
        }), this.getList();
    },
    getList: function() {
        var i = this, t = {
            uid: wx.getStorageSync("userInfo").wxInfo.id,
            type: this.data.types,
            ctype: this.data.ctype
        };
        (0, _api.MycouponData)(t).then(function(t) {
            var e = t;
            for (var a in e) e[a].createtime = timestampToTime(e[a].createtime), e[a].start_time = timestampToTime(e[a].start_time), 
            e[a].end_time = timestampToTime(e[a].end_time);
            i.setData({
                list: e
            });
        }, function(t) {
            console.log("err" + t);
        });
    }
}));