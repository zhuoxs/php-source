Object.defineProperty(exports, "__esModule", {
    value: !0
});

var app = getApp();

function request(e, t, n) {
    n || (n = {}), n.m || (n.m = "yzbld_sun");
    var o = wx.getStorageSync("openid");
    return o && (n.openid = o), new Promise(function(t, o) {
        app.util.request({
            url: "entry/wxapp/" + e,
            data: n,
            success: function(e) {
                0 == e.data.errno && t(e.data.data), o(e.data.message);
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
    return console.log(e), console.log(t), request(e, "GET", t);
}

function ipost(e, t) {
    return console.log(e), console.log(t), request(e, "POST", t);
}

exports.default = {
    get: iget,
    post: ipost
};