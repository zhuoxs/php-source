Object.defineProperty(exports, "__esModule", {
    value: !0
});

var _createClass = function() {
    function t(e, a) {
        for (var n = 0; n < a.length; n++) {
            var t = a[n];
            t.enumerable = t.enumerable || !1, t.configurable = !0, "value" in t && (t.writable = !0), 
            Object.defineProperty(e, t.key, t);
        }
    }
    return function(e, a, n) {
        return a && t(e.prototype, a), n && t(e, n), e;
    };
}();

function _classCallCheck(e, a) {
    if (!(e instanceof a)) throw new TypeError("Cannot call a class as a function");
}

var app = getApp(), manageShop = function() {
    function e() {
        _classCallCheck(this, e);
    }
    return _createClass(e, [ {
        key: "_uploadImg",
        value: function(e, a) {
            app.util.url("entry/wxapp/uploadImg");
            for (var n = 0; n < e.length; n++) wx.uploadFile({
                url: app.util.url("entry/wxapp/uploadImg", {
                    m: "sudu8_page_plugin_shop"
                }),
                filePath: e[n],
                name: "file",
                success: function(e) {
                    "function" == typeof a && a(e.data);
                },
                fail: function(e) {
                    wx.showModal({
                        title: "错误提示",
                        content: "上传图片失败",
                        showCancel: !1
                    });
                }
            });
        }
    } ]), e;
}();

exports.manageShop = manageShop;