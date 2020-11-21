function e(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

function t(e) {
    var t = this, a = e.target.dataset.src, i = e.target.dataset.from;
    void 0 !== i && i.length > 0 && wx.previewImage({
        current: a,
        urls: t.data[i].imageUrls
    });
}

function a(e) {
    var t = this, a = e.target.dataset.from, o = e.target.dataset.idx;
    void 0 !== a && a.length > 0 && i(e, o, t, a);
}

function i(e, t, a, i) {
    var n = a.data[i];
    if (0 != n.images.length) {
        var s = n.images, r = o(e.detail.width, e.detail.height, a, i);
        s[t].width = r.imageWidth, s[t].height = r.imageheight, n.images = s;
        var d = {};
        d[i] = n, a.setData(d);
    }
}

function o(e, t, a, i) {
    var o = 0, n = 0, s = 0, r = 0, d = {};
    return wx.getSystemInfo({
        success: function(g) {
            var l = a.data[i].view.imagePadding;
            o = g.windowWidth - 2 * l, n = g.windowHeight, console.log("windowWidth" + o), e > o ? (s = o, 
            console.log("autoWidth" + s), r = s * t / e, console.log("autoHeight" + r), d.imageWidth = s, 
            d.imageheight = r) : (d.imageWidth = e, d.imageheight = t);
        }
    }), d;
}

var n = e(require("./showdown.js")), s = e(require("./html2json.js"));

module.exports = {
    wxParse: function() {
        var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "wxParseData", i = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : "html", o = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : '<div class="color:red;">数据不能为空</div>', r = arguments[3], d = arguments[4], g = r, l = {};
        if ("html" == i) l = s.default.html2json(o, e), console.log(JSON.stringify(l, " ", " ")); else if ("md" == i || "markdown" == i) {
            var h = new n.default.Converter().makeHtml(o);
            l = s.default.html2json(h, e), console.log(JSON.stringify(l, " ", " "));
        }
        l.view = {}, l.view.imagePadding = 0, void 0 !== d && (l.view.imagePadding = d);
        var m = {};
        m[e] = l, g.setData(m), g.setData({
            canshow: g.data.canshow + 1
        }), console.log(g.data.canshow), g.wxParseImgLoad = a, g.wxParseImgTap = t;
    },
    wxParseTemArray: function(e, t, a, i) {
        for (var o = [], n = i.data, s = null, r = 0; r < a; r++) {
            var d = n[t + r].nodes;
            o.push(d);
        }
        e = e || "wxParseTemArray", (s = JSON.parse('{"' + e + '":""}'))[e] = o, i.setData(s);
    },
    emojisInit: function() {
        var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "", t = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : "/wxParse/emojis/", a = arguments[2];
        s.default.emojisInit(e, t, a);
    }
};