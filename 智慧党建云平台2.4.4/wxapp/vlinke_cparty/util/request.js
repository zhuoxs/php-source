Object.defineProperty(exports, "__esModule", {
    value: !0
});

var app = getApp();

function request(e, t, r) {
    return r || (r = {}), r.m || (r.m = "vlinke_cparty"), new Promise(function(t, a) {
        app.util.request({
            url: "entry/wxapp/" + e,
            data: r,
            success: function(e) {
                0 == e.data.errno && t(e.data.data), a(e.data.message);
            },
            fail: function(e) {
                a(e.data && e.data.message ? e.data.message : e.errMsg);
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