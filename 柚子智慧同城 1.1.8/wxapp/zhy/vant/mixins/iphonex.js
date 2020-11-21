function e() {
    return new Promise(function(e, n) {
        null !== t ? e(t) : wx.getSystemInfo({
            success: function(n) {
                var o = n.model, i = n.screenHeight, s = /iphone x/i.test(o), r = /iPhone11/i.test(o) && 812 === i;
                e(t = s || r);
            },
            fail: n
        });
    });
}

Object.defineProperty(exports, "__esModule", {
    value: !0
});

var t = null;

exports.iphonex = Behavior({
    properties: {
        safeAreaInsetBottom: {
            type: Boolean,
            value: !0
        }
    },
    created: function() {
        var t = this;
        e().then(function(e) {
            t.set({
                isIPhoneX: e
            });
        });
    }
});