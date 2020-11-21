getApp().requirejs("core");

module.exports.number = function(t, e) {
    var o = e.currentTarget.dataset, a = o.value, s = o.hasOwnProperty("min") ? parseInt(o.min) : 1, n = o.hasOwnProperty("max") ? parseInt(o.max) : 999;
    return "minus" === e.target.dataset.action ? a > 1 && (a > s || 0 == s) ? a-- : (0 == s && (s = 1), 
    this.toast(t, "最少购买" + s + "件")) : "plus" === e.target.dataset.action && (a < n || 0 == n ? a++ : this.toast(t, "最多购买" + n + "件")), 
    a;
}, module.exports.toast = function(t, e, o) {
    o || (o = 1500), t.setData({
        FoxUIToast: {
            show: !0,
            text: e
        }
    });
    setTimeout(function() {
        t.setData({
            FoxUIToast: {
                show: !1
            }
        });
    }, o);
}, module.exports.notify = function(t, e, o, a) {
    a || (a = 1500), o || (o = "default"), t.setData({
        FoxUINotify: {
            show: !0,
            text: e,
            style: o
        }
    });
    setTimeout(function() {
        t.setData({
            FoxUINotify: {
                show: !1
            }
        });
    }, a);
};