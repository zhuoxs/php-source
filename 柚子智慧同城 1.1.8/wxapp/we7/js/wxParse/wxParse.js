function e(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

function t(e, t, a) {
    return t in e ? Object.defineProperty(e, t, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = a, e;
}

function a(e) {
    var t = this, a = e.target.dataset.src, i = e.target.dataset.from;
    void 0 !== i && i.length > 0 && wx.previewImage({
        current: a,
        urls: t.data[i].imageUrls
    });
}

function i(e) {
    var t = this, a = e.target.dataset.from, i = e.target.dataset.idx;
    void 0 !== a && a.length > 0 && r(e, i, t, a);
}

function r(e, a, i, r) {
    var o, d = i.data[r];
    if (d && 0 != d.images.length) {
        var s = d.images, l = n(e.detail.width, e.detail.height, i, r), g = s[a].index, h = "" + r, m = !0, u = !1, v = void 0;
        try {
            for (var f, w = g.split(".")[Symbol.iterator](); !(m = (f = w.next()).done); m = !0) h += ".nodes[" + f.value + "]";
        } catch (e) {
            u = !0, v = e;
        } finally {
            try {
                !m && w.return && w.return();
            } finally {
                if (u) throw v;
            }
        }
        var c = h + ".width", x = h + ".height";
        i.setData((o = {}, t(o, c, l.imageWidth), t(o, x, l.imageheight), o));
    }
}

function n(e, t, a, i) {
    var r = 0, n = 0, o = 0, d = {}, g = a.data[i].view.imagePadding;
    return r = s - 2 * g, l, e > r ? (o = (n = r) * t / e, d.imageWidth = n, d.imageheight = o) : (d.imageWidth = e, 
    d.imageheight = t), d;
}

var o = e(require("./showdown.js")), d = e(require("./html2json.js")), s = 0, l = 0;

wx.getSystemInfo({
    success: function(e) {
        s = e.windowWidth, l = e.windowHeight;
    }
}), module.exports = {
    wxParse: function() {
        var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "wxParseData", t = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : "html", r = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : '<div class="color:red;">数据不能为空</div>', n = arguments[3], s = arguments[4], l = n, g = {};
        if ("html" == t) g = d.default.html2json(r, e), console.log(JSON.stringify(g, " ", " ")); else if ("md" == t || "markdown" == t) {
            var h = new o.default.Converter().makeHtml(r);
            g = d.default.html2json(h, e), console.log(JSON.stringify(g, " ", " "));
        }
        g.view = {}, g.view.imagePadding = 0, void 0 !== s && (g.view.imagePadding = s);
        var m = {};
        m[e] = g, l.setData(m), l.wxParseImgLoad = i, l.wxParseImgTap = a;
    },
    wxParseTemArray: function(e, t, a, i) {
        for (var r = [], n = i.data, o = null, d = 0; d < a; d++) {
            var s = n[t + d].nodes;
            r.push(s);
        }
        e = e || "wxParseTemArray", (o = JSON.parse('{"' + e + '":""}'))[e] = r, i.setData(o);
    },
    emojisInit: function() {
        var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "", t = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : "/wxParse/emojis/", a = arguments[2];
        d.default.emojisInit(e, t, a);
    }
};