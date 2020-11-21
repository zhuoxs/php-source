function e(e) {
    for (var t = {}, r = e.split(","), a = 0; a < r.length; a++) t[r[a]] = !0;
    return t;
}

function t(e) {
    return '"' + e + '"';
}

function r(e) {
    return e.replace(/<\?xml.*\?>\n/, "").replace(/<!doctype.*\>\n/, "").replace(/<!DOCTYPE.*\>\n/, "");
}

var a = /^<([-A-Za-z0-9_]+)((?:\s+[a-zA-Z_:][-a-zA-Z0-9_:.]*(?:\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|[^>\s]+))?)*)\s*(\/?)>/, n = /^<\/([-A-Za-z0-9_]+)[^>]*>/, i = /([a-zA-Z_:][-a-zA-Z0-9_:.]*)(?:\s*=\s*(?:(?:"((?:\\.|[^"])*)")|(?:'((?:\\.|[^'])*)')|([^>\s]+)))?/g, s = e("area,base,basefont,br,col,frame,hr,img,input,link,meta,param,embed,command,keygen,source,track,wbr"), o = e("a,address,article,applet,aside,audio,blockquote,button,canvas,center,dd,del,dir,div,dl,dt,fieldset,figcaption,figure,footer,form,frameset,h1,h2,h3,h4,h5,h6,header,hgroup,hr,iframe,ins,isindex,li,map,menu,noframes,noscript,object,ol,output,p,pre,section,script,table,tbody,td,tfoot,th,thead,tr,ul,video"), c = e("abbr,acronym,applet,b,basefont,bdo,big,br,button,cite,code,del,dfn,em,font,i,iframe,img,input,ins,kbd,label,map,object,q,s,samp,script,select,small,span,strike,strong,sub,sup,textarea,tt,u,var"), l = e("colgroup,dd,dt,li,options,p,td,tfoot,th,thead,tr"), d = e("checked,compact,declare,defer,disabled,ismap,multiple,nohref,noresize,noshade,nowrap,readonly,selected"), h = e("script,style"), u = function(e, t) {
    function r(e, r) {
        if (r) for (a = m.length - 1; a >= 0 && m[a] != r; a--) ; else var a = 0;
        if (a >= 0) {
            for (var n = m.length - 1; n >= a; n--) t.end && t.end(m[n]);
            m.length = a;
        }
    }
    var u, f, p, m = [], v = e;
    for (m.last = function() {
        return this[this.length - 1];
    }; e; ) {
        if (f = !0, m.last() && h[m.last()]) e = e.replace(new RegExp("([\\s\\S]*?)</" + m.last() + "[^>]*>"), function(e, r) {
            return r = r.replace(/<!--([\s\S]*?)-->|<!\[CDATA\[([\s\S]*?)]]>/g, "$1$2"), t.chars && t.chars(r), 
            "";
        }), r(0, m.last()); else if (0 == e.indexOf("\x3c!--") ? (u = e.indexOf("--\x3e")) >= 0 && (t.comment && t.comment(e.substring(4, u)), 
        e = e.substring(u + 3), f = !1) : 0 == e.indexOf("</") ? (p = e.match(n)) && (e = e.substring(p[0].length), 
        p[0].replace(n, r), f = !1) : 0 == e.indexOf("<") && (p = e.match(a)) && (e = e.substring(p[0].length), 
        p[0].replace(a, function(e, a, n, h) {
            if (a = a.toLowerCase(), o[a]) for (;m.last() && c[m.last()]; ) r(0, m.last());
            if (l[a] && m.last() == a && r(0, a), (h = s[a] || !!h) || m.push(a), t.start) {
                var u = [];
                n.replace(i, function(e, t) {
                    var r = arguments[2] ? arguments[2] : arguments[3] ? arguments[3] : arguments[4] ? arguments[4] : d[t] ? t : "";
                    u.push({
                        name: t,
                        value: r,
                        escaped: r.replace(/(^|[^\\])"/g, '$1\\"')
                    });
                }), t.start && t.start(a, u, h);
            }
        }), f = !1), f) {
            var g = (u = e.indexOf("<")) < 0 ? e : e.substring(0, u);
            e = u < 0 ? "" : e.substring(u), t.chars && t.chars(g);
        }
        if (e == v) throw "Parse Error: " + e;
        v = e;
    }
    r();
}, f = {}, p = function() {};

f.html2json = function(e) {
    e = r(e);
    var t = [], a = {
        node: "root",
        child: []
    };
    return u(e, {
        start: function(e, r, n) {
            p();
            var i = {
                node: "element",
                tag: e
            };
            if (0 !== r.length && (i.attr = r.reduce(function(e, t) {
                var r = t.name, a = t.value;
                return a.match(/ /) && (a = a.split(" ")), e[r] ? Array.isArray(e[r]) ? e[r].push(a) : e[r] = [ e[r], a ] : e[r] = a, 
                e;
            }, {})), n) {
                var s = t[0] || a;
                void 0 === s.child && (s.child = []), s.child.push(i);
            } else t.unshift(i);
        },
        end: function(e) {
            p();
            var r = t.shift();
            if (r.tag !== e && console.error("invalid state: mismatch end tag"), 0 === t.length) a.child.push(r); else {
                var n = t[0];
                void 0 === n.child && (n.child = []), n.child.push(r);
            }
        },
        chars: function(e) {
            p();
            var r = {
                node: "text",
                text: e
            };
            if (0 === t.length) a.child.push(r); else {
                var n = t[0];
                void 0 === n.child && (n.child = []), n.child.push(r);
            }
        },
        comment: function(e) {
            p();
            var r = {
                node: "comment",
                text: e
            }, a = t[0];
            void 0 === a.child && (a.child = []), a.child.push(r);
        }
    }), a;
}, f.json2html = function e(r) {
    var a = [ "area", "base", "basefont", "br", "col", "frame", "hr", "img", "input", "isindex", "link", "meta", "param", "embed" ], n = "";
    r.child && (n = r.child.map(function(t) {
        return e(t);
    }).join(""));
    var i = "";
    if (r.attr && "" !== (i = Object.keys(r.attr).map(function(e) {
        var a = r.attr[e];
        return Array.isArray(a) && (a = a.join(" ")), e + "=" + t(a);
    }).join(" ")) && (i = " " + i), "element" === r.node) {
        var s = r.tag;
        return a.indexOf(s) > -1 ? "<" + r.tag + i + "/>" : "<" + r.tag + i + ">" + n + ("</" + r.tag + ">");
    }
    return "text" === r.node ? r.text : "comment" === r.node ? "\x3c!--" + r.text + "--\x3e" : "root" === r.node ? n : void 0;
};

var m = function(e) {
    for (var t = [], r = [], a = 0, n = e.length; a < n; a++) if (0 == a) {
        if ("view" == e[a].type) continue;
        t.push(e[a]);
    } else if ("view" == e[a].type) {
        if (t.length > 0) {
            i = {
                type: "view",
                child: t
            };
            r.push(i);
        }
        t = [];
    } else if ("img" == e[a].type) {
        if (t.length > 0) {
            i = {
                type: "view",
                child: t
            };
            r.push(i);
        }
        i = {
            type: "img",
            attr: e[a].attr
        };
        r.push(i), t = [];
    } else if (t.push(e[a]), a == n - 1) {
        var i = {
            type: "view",
            child: t
        };
        r.push(i);
    }
    return r;
}, v = function(e) {
    var t = [];
    return function e(r) {
        var a = {};
        if ("root" == r.node) ; else if ("element" == r.node) switch (r.tag) {
          case "a":
            a = {
                type: "a",
                text: r.child[0].text
            };
            break;

          case "img":
            a = {
                type: "img",
                text: r.text
            };
            break;

          case "p":
          case "div":
            a = {
                type: "view",
                text: r.text
            };
        } else "text" == r.node && (a = {
            type: "text",
            text: r.text
        });
        if (r.attr && (a.attr = r.attr), 0 != Object.keys(a).length && t.push(a), "a" != r.tag) {
            var n = r.child;
            if (n) for (var i in n) e(n[i]);
        }
    }(e), t;
};

module.exports = {
    html2json: function(e) {
        var t = f.html2json(e);
        return t = v(t), t = m(t);
    }
};