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
    if (0 == s.length || !o) return (d = {}).node = "text", d.text = e, a = [ d ];
    e = e.replace(/\[([^\[\]]+)\]/g, ":$1:");
    for (var r = new RegExp("[:]"), a = e.split(r), i = 0; i < a.length; i++) {
        var l = a[i], d = {};
        o[l] ? (d.node = "element", d.tag = "emoji", d.text = o[l], d.baseSrc = n) : (d.node = "text", 
        d.text = l), t.push(d);
    }
    return t;
}

var s = "", n = "", o = {}, i = require("./wxDiscode.js"), l = require("./htmlparser.js"), d = (e("area,base,basefont,br,col,frame,hr,img,input,link,meta,param,embed,command,keygen,source,track,wbr"), 
e("br,a,code,address,article,applet,aside,audio,blockquote,button,canvas,center,dd,del,dir,div,dl,dt,fieldset,figcaption,figure,footer,form,frameset,h1,h2,h3,h4,h5,h6,header,hgroup,hr,iframe,ins,isindex,li,map,menu,noframes,noscript,object,ol,output,p,pre,section,script,table,tbody,td,tfoot,th,thead,tr,ul,video")), c = e("abbr,acronym,applet,b,basefont,bdo,big,button,cite,del,dfn,em,font,i,iframe,img,input,ins,kbd,label,map,object,q,s,samp,script,select,small,span,strike,strong,sub,sup,textarea,tt,u,var"), u = e("colgroup,dd,dt,li,options,p,td,tfoot,th,thead,tr");

e("checked,compact,declare,defer,disabled,ismap,multiple,nohref,noresize,noshade,nowrap,readonly,selected"), 
e("wxxxcode-style,script,style,view,scroll-view,block"), module.exports = {
    html2json: function(e, s) {
        e = r(e = t(e)), e = i.strDiscode(e);
        var n = [], o = {
            node: s,
            nodes: [],
            images: [],
            imageUrls: []
        }, p = 0;
        return l(e, {
            start: function(e, t, r) {
                var a = {
                    node: "element",
                    tag: e
                };
                if (0 === n.length ? (a.index = p.toString(), p += 1) : (void 0 === (v = n[0]).nodes && (v.nodes = []), 
                a.index = v.index + "." + v.nodes.length), d[e] ? a.tagType = "block" : c[e] ? a.tagType = "inline" : u[e] && (a.tagType = "closeSelf"), 
                0 !== t.length && (a.attr = t.reduce(function(e, t) {
                    var r = t.name, s = t.value;
                    return "class" == r && (a.classStr = s), "style" == r && (a.styleStr = s), s.match(/ /) && (s = s.split(" ")), 
                    e[r] ? Array.isArray(e[r]) ? e[r].push(s) : e[r] = [ e[r], s ] : e[r] = s, e;
                }, {})), "img" === a.tag) {
                    a.imgIndex = o.images.length, a.attr = a.attr || {};
                    var l = a.attr.src || [];
                    "" == l[0] && l.splice(0, 1), l = i.urlToHttpUrl(l, "https"), a.attr.src = l, a.from = s, 
                    o.images.push(a), o.imageUrls.push(l);
                }
                if ("font" === a.tag) {
                    var g = [ "x-small", "small", "medium", "large", "x-large", "xx-large", "-webkit-xxx-large" ], m = {
                        color: "color",
                        face: "font-family",
                        size: "font-size"
                    };
                    a.attr.style || (a.attr.style = []), a.styleStr || (a.styleStr = "");
                    for (var f in m) if (a.attr[f]) {
                        var h = "size" === f ? g[a.attr[f] - 1] : a.attr[f];
                        a.attr.style.push(m[f]), a.attr.style.push(h), a.styleStr += m[f] + ": " + h + ";";
                    }
                }
                if ("source" === a.tag && (o.source = a.attr.src), r) {
                    var v = n[0] || o;
                    void 0 === v.nodes && (v.nodes = []), v.nodes.push(a);
                } else n.unshift(a);
            },
            end: function(e) {
                var t = n.shift();
                if (t.tag !== e && console.error("invalid state: mismatch end tag"), "video" === t.tag && o.source && (t.attr.src = o.source, 
                delete o.source), 0 === n.length) o.nodes.push(t); else {
                    var r = n[0];
                    void 0 === r.nodes && (r.nodes = []), r.nodes.push(t);
                }
            },
            chars: function(e) {
                var t = {
                    node: "text",
                    text: e,
                    textArray: a(e)
                };
                if (0 === n.length) t.index = p.toString(), p += 1, o.nodes.push(t); else {
                    var r = n[0];
                    void 0 === r.nodes && (r.nodes = []), t.index = r.index + "." + r.nodes.length, 
                    r.nodes.push(t);
                }
            },
            comment: function(e) {}
        }), o;
    },
    emojisInit: function() {
        var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "", t = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : "/wxParse/emojis/", r = arguments[2];
        s = e, n = t, o = r;
    }
};