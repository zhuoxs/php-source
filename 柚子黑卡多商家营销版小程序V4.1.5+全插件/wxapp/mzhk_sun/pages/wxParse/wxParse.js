var _showdown = require("./showdown.js"), _showdown2 = _interopRequireDefault(_showdown), _html2json = require("./html2json.js"), _html2json2 = _interopRequireDefault(_html2json);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

function _defineProperty(e, t, a) {
    return t in e ? Object.defineProperty(e, t, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = a, e;
}

var realWindowWidth = 0, realWindowHeight = 0;

function wxParse() {
    var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : "wxParseData", t = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "html", a = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : '<div class="color:red;">数据不能为空</div>', i = arguments[3], r = arguments[4], n = i, o = {};
    if ("html" == t) o = _html2json2.default.html2json(a, e); else if ("md" == t || "markdown" == t) {
        var d = new _showdown2.default.Converter().makeHtml(a);
        o = _html2json2.default.html2json(d, e);
    }
    o.view = {}, void (o.view.imagePadding = 0) !== r && (o.view.imagePadding = r);
    var s = {};
    s[e] = o, n.setData(s), n.wxParseImgLoad = wxParseImgLoad, n.wxParseImgTap = wxParseImgTap;
}

function wxParseImgTap(e) {
    var t = e.target.dataset.src, a = e.target.dataset.from;
    void 0 !== a && 0 < a.length && wx.previewImage({
        current: t,
        urls: this.data[a].imageUrls
    });
}

function wxParseImgLoad(e) {
    var t = e.target.dataset.from, a = e.target.dataset.idx;
    void 0 !== t && 0 < t.length && calMoreImageInfo(e, a, this, t);
}

function calMoreImageInfo(e, t, a, i) {
    var r, n = a.data[i];
    if (n && 0 != n.images.length) {
        var o = n.images, d = wxAutoImageCal(e.detail.width, e.detail.height, a, i), s = o[t].index, l = "" + i, m = !0, h = !1, w = void 0;
        try {
            for (var g, u = s.split(".")[Symbol.iterator](); !(m = (g = u.next()).done); m = !0) {
                l += ".nodes[" + g.value + "]";
            }
        } catch (e) {
            h = !0, w = e;
        } finally {
            try {
                !m && u.return && u.return();
            } finally {
                if (h) throw w;
            }
        }
        var f = l + ".width", v = l + ".height";
        a.setData((_defineProperty(r = {}, f, d.imageWidth), _defineProperty(r, v, d.imageheight), 
        r));
    }
}

function wxAutoImageCal(e, t, a, i) {
    var r, n = 0, o = 0, d = {}, s = a.data[i].view.imagePadding;
    return realWindowHeight, (r = realWindowWidth - 2 * s) < e ? (o = (n = r) * t / e, 
    d.imageWidth = n, d.imageheight = o) : (d.imageWidth = e, d.imageheight = t), d;
}

function wxParseTemArray(e, t, a, i) {
    for (var r = [], n = i.data, o = null, d = 0; d < a; d++) {
        var s = n[t + d].nodes;
        r.push(s);
    }
    e = e || "wxParseTemArray", (o = JSON.parse('{"' + e + '":""}'))[e] = r, i.setData(o);
}

function emojisInit() {
    var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : "", t = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "/wxParse/emojis/", a = arguments[2];
    _html2json2.default.emojisInit(e, t, a);
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