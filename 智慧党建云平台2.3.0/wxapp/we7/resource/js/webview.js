function e(e, t) {
    e = e.replace(/(#\/)(.*)/, "");
    var n = new RegExp("(^|&)" + t + "=([^&]*)(&|$)", "i"), r = e.match(n);
    return null !== r ? unescape(r[2]) : null;
}

var t = getApp();

module.exports = {
    backApp: function(e) {
        if (e) try {
            wx.setStorageSync("we7_webview", e);
        } catch (e) {
            console.log(e);
        }
        var t = getCurrentPages();
        if (t.length > 1) for (var n in t) "wn_storex/pages/view/index" === t[n].__route__ && wx.navigateBack({
            data: t.length - n + 1
        });
    },
    urlAddCode: function(n) {
        var r = wx.getStorageSync("userInfo"), a = function(t) {
            var r = e(n, "state");
            n.indexOf("http") || r || (n = n.replace(/index.php\?/, "index.php?from=wxapp&state=we7sid-" + t.sessionid + "&"));
            var a = getCurrentPages();
            a && (a = a[getCurrentPages().length - 1]), a.setData({
                url: n
            });
        };
        r.sessionid ? a(r) : t.util.getUserInfo(a);
    }
};