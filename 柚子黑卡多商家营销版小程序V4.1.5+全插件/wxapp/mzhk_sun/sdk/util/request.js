Object.defineProperty(exports, "__esModule", {
    value: !0
});

var app = getApp();

function request(e, t, n) {
    n || (n = {}), n.m || (n.m = "mzhk_sun");
    var a = wx.getStorageSync("openid");
    return a && (n.openid = a), new Promise(function(t, a) {
        app.util.request({
            url: "entry/wxapp/" + e,
            data: n,
            success: function(e) {
                0 == e.data.errno && t(e.data.data), a(e.data.message);
            },
            fail: function(e) {
                var t = e.data && e.data.message ? e.data.message : e.errMsg;
                wx.showToast({
                    title: t,
                    icon: "none",
                    duration: 2e3
                });
            },
            complete: function() {}
        });
    });
}

function iget(e, t) {
    return request(e, "GET", t);
}

function ipost(e, t) {
    return request(e, "POST", t);
}

exports.default = {
    get: iget,
    post: ipost
};