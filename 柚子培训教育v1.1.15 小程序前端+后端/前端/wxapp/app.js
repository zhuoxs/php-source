App({
    onLaunch: function(r) {},
    onShow: function(r) {
        wx.setStorageSync("isshare", !1);
        var t = !0, e = !1, a = void 0;
        try {
            for (var i, n = [ 1007, 1008, 1011, 1012, 1013, 1014, 1019, 1020, 1025, 1028, 1029, 1031, 1032, 1034, 1035, 1043, 1045, 1046, 1047, 1048, 1049, 1058, 1067, 1081, 1082, 1091, 1102 ][Symbol.iterator](); !(t = (i = n.next()).done); t = !0) {
                if (i.value == r.scene) return void wx.setStorageSync("isshare", !0);
            }
        } catch (r) {
            e = !0, a = r;
        } finally {
            try {
                !t && n.return && n.return();
            } finally {
                if (e) throw a;
            }
        }
    },
    siteInfo: require("siteinfo.js"),
    util: require("/we7/js/util.js"),
    globalData: {
        tab: !1,
        show: !1,
        showMaskFlag: !0,
        backUrl: ""
    }
});