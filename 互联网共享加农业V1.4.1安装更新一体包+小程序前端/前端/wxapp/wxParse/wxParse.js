var _showdown = require("./showdown.js"), _showdown2 = _interopRequireDefault(_showdown), _html2json = require("./html2json.js"), _html2json2 = _interopRequireDefault(_html2json);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

function wxParse() {
    var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : "wxParseData", a = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "html", t = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : '<div class="color:red;">数据不能为空</div>', o = arguments[3], i = arguments[4], s = o, r = {};
    if ("html" == a) r = _html2json2.default.html2json(t, e), console.log(JSON.stringify(r, " ", " ")); else if ("md" == a || "markdown" == a) {
        var n = new _showdown2.default.Converter().makeHtml(t);
        r = _html2json2.default.html2json(n, e), console.log(JSON.stringify(r, " ", " "));
    }
    r.view = {}, void (r.view.imagePadding = 0) !== i && (r.view.imagePadding = i);
    var d = {};
    d[e] = r, s.setData(d), s.setData({
        canshow: s.data.canshow + 1
    }), console.log(s.data.canshow), s.wxParseImgLoad = wxParseImgLoad, s.wxParseImgTap = wxParseImgTap;
}

function wxParseImgTap(e) {
    var a = e.target.dataset.src, t = e.target.dataset.from;
    void 0 !== t && 0 < t.length && wx.previewImage({
        current: a,
        urls: this.data[t].imageUrls
    });
}

function wxParseImgLoad(e) {
    var a = e.target.dataset.from, t = e.target.dataset.idx;
    void 0 !== a && 0 < a.length && calMoreImageInfo(e, t, this, a);
}

function calMoreImageInfo(e, a, t, o) {
    var i = t.data[o];
    if (0 != i.images.length) {
        var s = i.images, r = wxAutoImageCal(e.detail.width, e.detail.height, t, o);
        s[a].width = r.imageWidth, s[a].height = r.imageheight, i.images = s;
        var n = {};
        n[o] = i, t.setData(n);
    }
}

function wxAutoImageCal(t, o, i, s) {
    var r = 0, n = 0, d = 0, g = {};
    return wx.getSystemInfo({
        success: function(e) {
            var a = i.data[s].view.imagePadding;
            r = e.windowWidth - 2 * a, e.windowHeight, console.log("windowWidth" + r), r < t ? (n = r, 
            console.log("autoWidth" + n), d = n * o / t, console.log("autoHeight" + d), g.imageWidth = n, 
            g.imageheight = d) : (g.imageWidth = t, g.imageheight = o);
        }
    }), g;
}

function wxParseTemArray(e, a, t, o) {
    for (var i = [], s = o.data, r = null, n = 0; n < t; n++) {
        var d = s[a + n].nodes;
        i.push(d);
    }
    e = e || "wxParseTemArray", (r = JSON.parse('{"' + e + '":""}'))[e] = i, o.setData(r);
}

function emojisInit() {
    var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : "", a = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "/wxParse/emojis/", t = arguments[2];
    _html2json2.default.emojisInit(e, a, t);
}

module.exports = {
    wxParse: wxParse,
    wxParseTemArray: wxParseTemArray,
    emojisInit: emojisInit
};