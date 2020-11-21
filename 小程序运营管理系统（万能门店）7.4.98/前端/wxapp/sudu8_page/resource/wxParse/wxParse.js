var _html2json = require("./html2json.js"), _html2json2 = _interopRequireDefault(_html2json);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var realWindowWidth = 0, realWindowHeight = 0;

function wxParse() {
    var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : "wxParseData", a = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "html", r = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : '<div class="color:red;">暂无内容</div>', t = arguments[3], i = arguments[4], s = t, n = {};
    "html" == a && (n = _html2json2.default.html2json(r, e)), n.view = {}, void (n.view.imagePadding = 0) !== i && (n.view.imagePadding = i);
    var o = {};
    o[e] = n, s.setData(o), s.wxParseImgTap = wxParseImgTap, s.wxParseTagATap = wxParseTagATap;
}

function wxParseTagATap(e) {
    var a = e.currentTarget.dataset.src;
    "" != a && wx.navigateTo({
        url: a
    });
}

function wxParseImgTap(e) {
    var a = e.target.dataset.src;
    wx.previewImage({
        current: a,
        urls: [ a ]
    });
}

function wxParseTemArray(e, a, r, t) {
    for (var i = [], s = t.data, n = null, o = 0; o < r; o++) {
        var d = s[a + o].nodes;
        i.push(d);
    }
    e = e || "wxParseTemArray", (n = JSON.parse('{"' + e + '":""}'))[e] = i, t.setData(n);
}

function emojisInit() {
    var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : "", a = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "/wxParse/emojis/", r = arguments[2];
    _html2json2.default.emojisInit(e, a, r);
}

wx.getSystemInfo({
    success: function(e) {
        realWindowWidth = e.windowWidth, realWindowHeight = e.windowHeight;
    }
}), module.exports = {
    wxParse: wxParse,
    wxParseTemArray: wxParseTemArray,
    emojisInit: emojisInit
};