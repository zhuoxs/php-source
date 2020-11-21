var util = require("util.js"), md5 = require("../we7/js/md5.js"), api = {
    promise_list: {},
    get_promise: function(t) {
        var e = 1 < arguments.length && void 0 !== arguments[1] && arguments[1], i = this, n = md5(t);
        if (!e && i.promise_list[n]) return i.promise_list[n];
        var r = new Promise(t);
        return i.promise_list[n] = r.then(function(t) {
            return delete i.promise_list[n], Promise.resolve(t);
        }).catch(function(t) {
            return delete i.promise_list[n], Promise.reject(t);
        }), i.promise_list[n];
    },
    get_imgroot: function() {
        !(0 < arguments.length && void 0 !== arguments[0]) || arguments[0];
        return this.get_promise(function(e, t) {
            util.request({
                url: "entry/wxapp/GetImgRoot",
                success: function(t) {
                    e(t.data);
                }
            });
        });
    },
    get_menus: function() {
        !(0 < arguments.length && void 0 !== arguments[0]) || arguments[0];
        var i = this;
        return new Promise(function(e, t) {
            i.get_imgroot().then(function(t) {
                util.request({
                    url: "entry/wxapp/GetAppMenus",
                    success: function(t) {
                        e(t.data);
                    }
                });
            });
        });
    },
    get_setting: function() {
        !(0 < arguments.length && void 0 !== arguments[0]) || arguments[0];
        return this.get_promise(function(e, t) {
            util.request({
                url: "entry/wxapp/GetPlatformInfo",
                success: function(t) {
                    e(t.data);
                }
            });
        });
    },
    get_store_info: function() {
        var n = !(0 < arguments.length && void 0 !== arguments[0]) || arguments[0], r = getApp();
        return this.get_promise(function(e, t) {
            var i = r.globalData.store_info;
            i && n ? e(i) : r.get_wxuser_location().then(function(t) {
                util.request({
                    url: "entry/wxapp/GetNearestStore",
                    data: {
                        latitude: t.latitude,
                        longitude: t.longitude
                    },
                    success: function(t) {
                        r.globalData.store_info = t.data, e(t.data);
                    }
                });
            });
        });
    },
    get_user_info: function() {
        var n = !(0 < arguments.length && void 0 !== arguments[0]) || arguments[0], r = getApp();
        return this.get_promise(function(e, t) {
            var i = r.globalData.user_info;
            i && n ? e(i) : r.get_openid().then(function(t) {
                util.request({
                    url: "entry/wxapp/Login",
                    data: {
                        openid: t
                    },
                    success: function(t) {
                        r.globalData.user_info = t.data, r.globalData.uniacid = t.data.uniacid, e(t.data);
                    }
                });
            });
        });
    }
};

module.exports = api;