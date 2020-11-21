function e(e) {
    for (var t = {}, r = e.split(","), a = 0; a < r.length; a++) t[r[a]] = !0;
    return t;
}

function t(e) {
    return e.replace(/<\?xml.*\?>\n/, "").replace(/<.*!doctype.*\>\n/, "").replace(/<.*!DOCTYPE.*\>\n/, "");
}

function r(e) {
    return e.replace(/\r?\n+/g, "").replace(/<!--.*?-->/gi, "").replace(/\/\*.*?\*\//gi, "").replace(/[ ]+</gi, "<");
}

function a(e) {
    var t = [];
    if (0 == n.length || !i) return (d = {}).node = "text", d.text = e, a = [ d ];
    e = e.replace(/\[([^\[\]]+)\]/g, ":$1:");
    for (var r = new RegExp("[:]"), a = e.split(r), s = 0; s < a.length; s++) {
        var l = a[s], d = {};
        i[l] ? (d.node = "element", d.tag = "emoji", d.text = i[l], d.baseSrc = o) : (d.node = "text", 
        d.text = l), t.push(d);
    }
    return t;
}

var s = "https", n = "", o = "", i = {}, l = require("./wxDiscode.js"), d = require("./htmlparser.js"), c = (e("area,base,basefont,br,col,frame,hr,img,input,link,meta,param,embed,command,keygen,source,track,wbr"), 
e("br,a,code,address,article,applet,aside,audio,blockquote,button,canvas,center,dd,del,dir,div,dl,dt,fieldset,figcaption,figure,footer,form,frameset,h1,h2,h3,h4,h5,h6,header,hgroup,hr,iframe,ins,isindex,li,map,menu,noframes,noscript,object,ol,output,p,pre,section,script,table,tbody,td,tfoot,th,thead,tr,ul,video")), u = e("abbr,acronym,applet,b,basefont,bdo,big,button,cite,del,dfn,em,font,i,iframe,img,input,ins,kbd,label,map,object,q,s,samp,script,select,small,span,strike,strong,sub,sup,textarea,tt,u,var"), p = e("colgroup,dd,dt,li,options,p,td,tfoot,th,thead,tr");

e("checked,compact,declare,defer,disabled,ismap,multiple,nohref,noresize,noshade,nowrap,readonly,selected"), 
e("wxxxcode-style,script,style,view,scroll-view,block");

module.exports = {
    html2json: function(e, n) {
        e = r(e = t(e)), e = l.strDiscode(e);
        var o = [], i = {
            node: n,
            nodes: [],
            images: [],
            imageUrls: []
        }, g = 0;
        return d(e, {
            start: function(e, t, r) {
                var a = {
                    node: "element",
                    tag: e
                };
                if (0 === o.length ? (a.index = g.toString(), g += 1) : (void 0 === (x = o[0]).nodes && (x.nodes = []), 
                a.index = x.index + "." + x.nodes.length), c[e] ? a.tagType = "block" : u[e] ? a.tagType = "inline" : p[e] && (a.tagType = "closeSelf"), 
                0 !== t.length && (a.attr = t.reduce(function(e, t) {
                    var r = t.name, s = t.value;
                    return "class" == r && (a.classStr = s), "style" == r && (a.styleStr = s), s.match(/ /) && (s = s.split(" ")), 
                    e[r] ? Array.isArray(e[r]) ? e[r].push(s) : e[r] = [ e[r], s ] : e[r] = s, e;
                }, {})), "img" === a.tag) {
                    a.imgIndex = i.images.length, a.attr = a.attr || {};
                    var d = a.attr.src || [];
                    "" == d[0] && d.splice(0, 1), d = l.urlToHttpUrl(d, s), a.attr.src = d, a.from = n, 
                    i.images.push(a), i.imageUrls.push(d);
                }
                if ("font" === a.tag) {
                    var m = [ "x-small", "small", "medium", "large", "x-large", "xx-large", "-webkit-xxx-large" ], f = {
                        color: "color",
                        face: "font-family",
                        size: "font-size"
                    };
                    a.attr.style || (a.attr.style = []), a.styleStr || (a.styleStr = "");
                    for (var h in f) if (a.attr[h]) {
                        var v = "size" === h ? m[a.attr[h] - 1] : a.attr[h];
                        a.attr.style.push(f[h]), a.attr.style.push(v), a.styleStr += f[h] + ": " + v + ";";
                    }
                }
                if ("source" === a.tag && (i.source = a.attr.src), r) {
                    var x = o[0] || i;
                    void 0 === x.nodes && (x.nodes = []), x.nodes.push(a);
                } else o.unshift(a);
            },
            end: function(e) {
                var t = o.shift();
                if (t.tag !== e && console.error("invalid state: mismatch end tag"), "video" === t.tag && i.source && (t.attr.src = i.source, 
                delete i.source), 0 === o.length) i.nodes.push(t); else {
                    var r = o[0];
                    void 0 === r.nodes && (r.nodes = []), r.nodes.push(t);
                }
            },
            chars: function(e) {
                var t = {
                    node: "text",
                    text: e,
                    textArray: a(e)
                };
                if (0 === o.length) t.index = g.toString(), g += 1, i.nodes.push(t); else {
                    var r = o[0];
                    void 0 === r.nodes && (r.nodes = []), t.index = r.index + "." + r.nodes.length, 
                    r.nodes.push(t);
                }
            },
            comment: function(e) {}
        }), i;
    },
    emojisInit: function() {
        var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "", t = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : "/wxParse/emojis/", r = arguments[2];
        n = e, o = t, i = r;
    }
};